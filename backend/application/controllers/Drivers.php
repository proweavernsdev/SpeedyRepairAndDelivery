<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Accept: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, PWAUTH");

require_once APPPATH . '/libraries/rest/Rest.php';

class Drivers extends Rest
{
    private $mw;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DeliveryDriversModel');
        $this->load->library('plugins/filehelper');
        // Shorten Libraries and Models
        $this->mw = $this->middleware;
    }

    protected function _get(){
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();

            // Check if the user has Admin level access
            if ($params->AccessLevel == 'Admin') {
                // Retrieve all driver data
                $res = $this->DeliveryDriversModel->all();
                // Respond with a success message and the retrieved data
                $this->responseOutput('Data Retrieved', $res, 200, true, true);
            
            // Check if the user has Driver level access
            } elseif ($params->AccessLevel == 'Driver') {
                // Retrieve data specific to the driver associated with the user ID
                $res = $this->DeliveryDriversModel->retrieveData($data->UserID);
                // Respond with a success message and the retrieved data
                $this->responseOutput('Data Retrieved', $res, 200, true, true);
            
            // If access level is neither Admin nor Driver, throw an exception
            } else {
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    protected function docs_get(){
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();
    
            // Check if the user has Admin level access
            if ($params->AccessLevel == 'Admin') {
                // Get data from HTTP headers
                $data = $_SERVER['HTTP_DATA'];
                // View files for the driver using the data from HTTP headers
                $res = $this->filehelper->viewfiles("Users/Driver/{$data}");
                
                // If file retrieval fails, throw an exception
                if (!$res) throw new Exception('Internal Server Error');
                // Respond with the retrieved files
                $this->response($res, 200);
                
            // Check if the user has Driver level access
            } elseif ($params->AccessLevel == 'Driver') {
                // View files for the driver using the user ID
                $res = $this->filehelper->viewfiles("Users/Driver/{$data->UserID}");
                // Respond with a success message and the retrieved files
                $this->responseOutput('Files retrieved', $res, 200, true, true);
            
            // If access level is neither Admin nor Driver, throw an exception
            } else {
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    protected function _post(){
        // Retrieve post data from the request
        $postData = $this->post();
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();

            // Ensure the account does not already have a role assigned
            if ($params->AccessLevel !== 'null') throw new Exception('Account already has a role');

            // Ensure none of the required input fields are empty
            if (empty($postData['FirstName']) && empty($postData['LastName']) && empty($postData['Address']) && empty($postData['TownCity']) && empty($postData['State']) && empty($postData['Zip']) && empty($postData['LicenseNumber']))
                throw new Exception('Input Fields must not be empty');

            // Register the driver with the provided data
            $res = $this->DeliveryDriversModel->DeliveryDriverRegister(
                $data->UserID, 
                $postData);

            // Attempt to upload multiple files to the designated directory
            $upld = $this->filehelper->uploadMultiple("Users/Driver/{$data->UserID}/docs", 'files', true);

            // Check if driver registration or file upload failed
            if (!$res || !$upld) throw new Exception('Something went wrong, Unable to create driver account');

            // Respond with a success message
            $this->responseOutput('Driver has been created', [], 200, true);
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    protected function upload_post(){
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();

            // Check if the user has Driver level access
            if($params == 'Driver'){
                // Get the current timestamp for the file path
                $currentTimestamp = time();
                // Attempt to upload the profile picture file
                $upload = $this->filehelper->upload("Users/Driver/{$data->UserID}/pfp/{$currentTimestamp}", 'file', true);

                // Check if the upload was unsuccessful
                if (!isset($upload['result'])) {
                    // Respond with an error message
                    $this->response([
                        'success' => false,
                        'Error' => 'Internal Server Error',
                        'message' => 'Upload has failed',
                        'results' => $upload
                    ], 500);
                }

                // Convert the upload result to an object
                $uploadObject = (object) $upload;
                // Get the path of the uploaded file
                $path = $uploadObject->result['path'];
                // Update the profile picture path in the database
                $res = $this->DeliveryDriversModel->setPfp($data->UserID, $path, 'comp_userOwner', 'srdr_company', 'comp_businessPhoto');
    
                // If the database update fails, throw an exception
                if (!$res) throw new Exception('Internal Server Error');

                // Respond with a success message
                $this->responseOutput('Profile picture has been updated');
                
            }else throw new Exception('Unauthorized Access');
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    protected function _put(){
        // Get JSON data from request
        $jsonData = $this->json();
        try {
            // Validate the token and extract data and parameters
            $token = $this->mw->checkToken();
            $data = $token->getData();
            $params = $token->getParams();

            // Check if user has Admin level access
            if($params->AccessLevel == 'Admin'){
                $res = $this->DeliveryDriversModel->setStatus($jsonData['DriverID'], $jsonData['Status']);
                if(!$res) throw new Exception('Error updating status');
                $this->responseOutput('Status has been updated');
            }elseif($params->AccessLevel == 'Driver'){
                $toArray = [];
                $parameter = ['driverUserOwner'=>$data->UserID];
                foreach ($jsonData as $key => $value) {
                    // check if key is not empty
                    if (!empty($value) && $value != null) {
                        // append data to variable $parameter
                        switch ($key) {
                            case 'FirstName':
                                $toArray['driver_firstName'] = $value;
                                break;
                            case 'LastName':
                                $toArray['driver_lastName'] = $value;
                                break;
                            case 'Address':
                                $toArray['driver_address'] = $value;
                                break;
                            case 'Towity':
                                $toArray['driver_towity'] = $value;
                                break;
                            case 'State':
                                $toArray['driver_state'] = $value;
                                break;
                            case 'Zip':
                                $toArray['driver_zip'] = $value;
                                break;
                        }
                    }
                }
                $update = $this->qb->update('deliveryDriver', $toArray, true, $parameter);
                if(!$update)throw new Exception('Error updating database');
                $this->responseOutput('Database update successful', [], 200, true);
            }else throw new Exception('Unauthorized Access');
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

}