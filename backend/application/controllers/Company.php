<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Accept: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, PWAUTH, DATA");

require_once APPPATH . '/libraries/rest/Rest.php';
require_once APPPATH . '/libraries/middlewares/firebase-php/Firebase_lib.php';

class Company extends Rest {
    private $mw;
    public function __construct(){
        parent::__construct();
        $this->load->model('CompanyModel');
        $this->load->library('plugins/filehelper');
        $this->load->library('middlewares/firebase-php/Firebase_lib');
        // Shorten Libraries and Models
        $this->fb = $this->firebase_lib;
        $this->mw = $this->middleware;
    }
    
    /**
     *  Admin: Retrieves all company accounts and their details
     *  Company: Retrieves their own account details
     */
    protected function _get(){
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();
    
            // Check if the user has Admin level access
            if ($params->AccessLevel == 'Admin') {
                // Retrieve all company data
                $res = $this->CompanyModel->all();
                // Respond with a success message and the retrieved data
                $this->responseOutput('Data Retrieved', $res, 200, true, true);
            
            // Check if the user has Company level access
            } elseif ($params->AccessLevel == 'Company') {
                // Retrieve data specific to the company associated with the user ID
                $res = $this->CompanyModel->retrieveData($data->UserID);
                // Respond with a success message and the retrieved data
                $this->responseOutput('Data Retrieved', $res, 200, true, true);
            
            // If access level is neither Admin nor Company, throw an exception
            } else {
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }
    

    /**
     *  Admin: Retrieves documents from the submitted files from the creation of Company Accounts specified by the Company IDs 
     *  Company: Retrieves document from the submitted files from the creation of Company Accounts
     */
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
                // View files for the company using the data from HTTP headers
                $res = $this->filehelper->viewfiles("Users/Company/{$data}");
                
                // If file retrieval fails, throw an exception
                if (!$res) throw new Exception('Internal Server Error');
                // Respond with the retrieved files
                $this->response($res, 200);
                
            // Check if the user has Company level access
            } elseif ($params->AccessLevel == 'Company') {
                // View files for the company using the user ID
                $res = $this->filehelper->viewfiles("Users/Company/{$data->UserID}");
                // Respond with a success message and the retrieved files
                $this->responseOutput('Files retrieved', $res, 200, true, true);
            
            // If access level is neither Admin nor Company, throw an exception
            } else {
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    /**
     *  Retrieve sub-accounts/employee data
     */
    protected function employee_get(){
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();
    
            // Check if the user has Admin level access
            if ($params->AccessLevel == 'Admin') {
                // Get data from HTTP headers
                $dataParams = $_SERVER['HTTP_DATA'];
                // Fetch the company information based on the data
                $query = $this->CompanyModel->select('comp_userOwner', $dataParams, 'srdr_company')->row();
                
                // If the company is found, retrieve employee data
                if ($query) {
                    $res = $this->CompanyModel->employeeRetrieve($query->companyID);
                    
                    // Check if the retrieval was successful
                    if (!isset($res['success'])) {
                        // Respond with the retrieved data
                        $this->response([
                            'success' => true,
                            'results' => $res
                        ], 200);
                    } else {
                        // Respond with an error message if retrieval failed
                        $this->response([
                            'success' => false,
                            'message' => 'Internal Server Error',
                            'result' => $res
                        ], 500);
                    }
                } else {
                    // Respond with an error message if the company is not found
                    $this->response([
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ], 500);
                }
            
            // Check if the user has Company level access
            } elseif ($params->AccessLevel == 'Company') {
                // Fetch the company information based on the user ID
                $query = $this->CompanyModel->select('comp_userOwner', $data->UserID, 'srdr_company')->row();
                
                // If the query fails, throw an exception
                if (!$query) throw new Exception('Internal Server Error');
                
                // Retrieve employee data for the company
                $res = $this->CompanyModel->employeeRetrieve($query->companyID);
                
                // Check if the retrieval was successful
                if (!isset($res['success'])) {
                    // Respond with the retrieved data
                    $this->response([
                        'success' => true,
                        'results' => $res
                    ], 200);
                } else {
                    // Respond with an error message if retrieval failed
                    $this->response([
                        'success' => false,
                        'message' => 'Internal Server Error',
                        'result' => $res
                    ], 500);
                }
            
            // If access level is neither Admin nor Company, throw an exception
            } else {
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }
    

// =============== POST =============== // // =============== POST =============== // // =============== POST =============== //
// =============== POST =============== // // =============== POST =============== // // =============== POST =============== //
// =============== POST =============== // // =============== POST =============== // // =============== POST =============== //

    // Create Company type account, User: any user with null Usser Access
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
            if (empty($postData['CompName']) && empty($postData['CompAddr']) && empty($postData['TownCity']) && empty($postData['CompState']) && empty($postData['CompZip']))
                throw new Exception('Input Fields must not be empty');

            // Register the company with the provided data
            $res = $this->CompanyModel->companyRegister(
                $postData['CompName'], 
                $data->UserID, 
                $postData['CompAddr'],
                $postData['TownCity'],
                $postData['CompState'],
                $postData['CompZip']
            );

            // Attempt to upload multiple files to the designated directory
            $upld = $this->filehelper->uploadMultiple("Users/Company/{$data->UserID}/docs", 'files', true);

            // Check if company registration or file upload failed
            if (!$res || !$upld) throw new Exception('Something went wrong, Unable to create company account');

            // Respond with a success message
            $this->responseOutput('Company has been created', [], 200, true);
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    // Create employee/sub-user accounts for company type accounts, Users: Company
    protected function employee_post(){
        // Get JSON data from the request
        $jsonData = $this->json();
        try {
            // Validate the token and extract data and parameters
            $token = $this->mw->checkToken();
            $data = $token->getData();
            $params = $token->getParams();
    
            // Check if the user has Company level access
            if ($params->AccessLevel == 'Company') {
                // Ensure none of the input fields are empty
                if (empty($jsonData['email']) && empty($jsonData['password']) && empty($jsonData['FirstName']) && empty($jsonData['LastName'])) 
                    throw new Exception('Input fields must not be empty');
    
                // Fetch the company information based on the user ID
                $query = $this->CompanyModel->select('comp_userOwner', $data->UserID, 'srdr_company')->row();
                if (!$query) throw new Exception('Internal Server Error');
    
                // Register the new employee with the provided data
                $reg = $this->fb->registerVerified($jsonData);
                if (!$reg) throw new Exception('Internal Server Error');
    
                // Retrieve the Firebase account details using the provided email
                $fbAcc = $this->fb->userRecordsbyEmail($jsonData['email']);
                $newData = [
                    'uid' => $fbAcc->uid,
                    'email' => $fbAcc->email,
                    'password' => $jsonData['password'],
                    'FirstName' => $jsonData['FirstName'],
                    'LastName' => $jsonData['LastName']
                ];
    
                // Register the employee in the company database
                $res = $this->CompanyModel->registerEmloyee($query->companyID, $newData);
                if (!$res) throw new Exception('Internal Server Error');
    
                // Respond with a success message
                $this->responseOutput('Account has been added', [], 200, true);
            
            // Check if the user has Employee level access
            } elseif ($params->AccessLevel == 'Employee') {
                // Validate the URI contains 'pfp' for profile picture update
                $uri_segments = $this->uri->segments;
                if (in_array('pfp', $uri_segments)) {
                    // If the URI contains '/pfp', call the pfp_post() method
                    $this->pfp_post();
                    return; // Exit to prevent further execution
                }else throw new Exception('Unauthorized Access');
            } else {
                // If access level is neither Company nor Employee, throw an exception
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }

    // Add profile picture, Users: Company, Employees
    protected function pfp_post(){
        try {
            // Validate the token and extract data and parameters
            $token = $this->mw->checkToken();
            $data = $token->getData();
            $params = $token->getParams();
    
            // Check if the user has Company level access
            if ($params->AccessLevel == 'Company') {
                // Get the current timestamp for the file path
                $currentTimestamp = time();
                // Attempt to upload the profile picture file
                $upload = $this->filehelper->upload("Users/Company/{$data->UserID}/pfp/{$currentTimestamp}", 'file', true);
    
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
                $res = $this->CompanyModel->setPfp($data->UserID, $path, 'comp_userOwner', 'srdr_company', 'comp_businessPhoto');
    
                // If the database update fails, throw an exception
                if (!$res) throw new Exception('Internal Server Error');
    
                // Respond with a success message
                $this->responseOutput('Profile picture has been updated');
    
            } elseif ($params->AccessLevel == 'Employee') {
                // Ensure the URI contains 'employee' to validate access
                $uri_segments = $this->uri->segments;
                if (!in_array('employee', $uri_segments)) throw new Exception('Unauthorized access');
    
                // Fetch the employee's company association
                $query = $this->CompanyModel->select('subs_userOwner', $data->UserID, 'srdr_subUsers')->row();
                if (!$query) throw new Exception('Internal Server Error');
    
                // Fetch the company information
                $compQuery = $this->CompanyModel->select('companyID', $query->subs_underCompany, 'srdr_company')->row();
                if (!$compQuery) throw new Exception('Internal Server Error');
    
                // Get the current timestamp for the file path
                $timeStamp = time();
                // Attempt to upload the profile picture file
                $upld = $this->filehelper->upload("Users/Company/{$compQuery->comp_userOwner}/employee/{$data->UserID}/pfp/{$timeStamp}", 'file', true);
    
                // If the upload was unsuccessful, throw an exception
                if (!$upld) throw new Exception('Internal Server Error');
    
                // Convert the upload result to an object
                $uploadObject = (object) $upld;
                // Get the path of the uploaded file
                $path = $uploadObject->result['path'];
                // Update the profile picture path in the database
                $res = $this->CompanyModel->setPfp($data->UserID, $path, 'subs_userOwner', 'srdr_subUsers', 'subs_userPhoto');
    
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

// =============== PUT =============== // // =============== PUT =============== // // =============== PUT =============== //
// =============== PUT =============== // // =============== PUT =============== // // =============== PUT =============== //
// =============== PUT =============== // // =============== PUT =============== // // =============== PUT =============== //

    // Change Company status, Users: Admin
    // Upate Company details, Users: Company
    protected function _put(){
        // Get JSON data from the request
        $jsonData = $this->json();
        try {
            // Validate the token and extract data and parameters
            $token = $this->mw->checkToken();
            $data = $token->getData();
            $params = $token->getParams();

            // Check if the user has Admin level access
            if ($params->AccessLevel == 'Admin') {
                // Update the company's status in the database
                $res = $this->CompanyModel->setStatus($jsonData['CompanyID'], $jsonData['Status']);

                // If the update fails, throw an exception
                if (!$res) throw new Exception('Status has failed to update');

                // Respond with a success message
                $this->responseOutput('Status has been updated', [], 200, true);

            // Check if the user has Company level access
            } elseif ($params->AccessLevel == 'Company') {
                // Fetch the company information based on the user ID
                $query = $this->CompanyModel->select('comp_userOwner', $data->UserID, 'srdr_company')->row();

                // If the query fails, throw an exception
                if (!$query) throw new Exception('Internal Server Error');

                // Update the company details in the database
                $res = $this->CompanyModel->updateCompDetails($query->companyID, $data);

                // If the update fails, throw an exception
                if (!$res) throw new Exception('Internal Server Error, Failed to update');

                // Respond with a success message
                $this->responseOutput('Update successful', [], 200, true);
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }


    // Update employee's status, Users: Company, Admin
    protected function employee_put(){
        // Get JSON data from the request
        $jsonData = $this->json();
        try {
            // Validate the token and extract data and parameters
            $token = $this->mw->checkToken();
            $data = $token->getData();
            $params = $token->getParams();
    
            // Check if the user has Admin or Company level access
            if ($params->AccessLevel == 'Admin' || $params->AccessLevel == 'Company') {
                // Update the employee's status in the database
                $res = $this->CompanyModel->setEmployeeStatus($jsonData['sub_userID'], $jsonData['Status']);
                // If the update fails, throw an exception
                if (!$res) throw new Exception('Status has failed to update');
                // Respond with a success message
                $this->responseOutput('Status has been updated', [], 200, true);
            } else {
                // If access level is neither Admin nor Company, throw an exception
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }
    
}