<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Accept: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, PWAUTH");

require_once APPPATH . '/libraries/rest/Rest.php';

class App extends Rest {
    private $mw;
    public function __construct(){
        parent::__construct();
        $this->load->model('AppModel');

        $this->mw = $this->middleware;
    }

    protected function _get(){
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();

            // Check if user has any level access, throw Exception if null or empty
            if($params->AccessLevel == null || empty($params->AccessLevel)) throw new Exception('Access Level is null or empty');

            // Retrieve data from the database
            $res = $this->AppModel->get_all();

            // Check if query did not fail
            if(!$res) throw new Exception('Data retrieval from database failed');

            // If successful, return data
            $this->responseOutput('Data retrieval successful', $res, 200, true, true);
            
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }
    
    protected function _put(){
        // Get JSON from request
        $jsonData = $this->json();
        try {
            // Validate the token and extract parameters and data
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();

            // Check if user has Admin access level
            if($params->AccessLevel = 'Admin'){
                // Check if jsonData is empty
                if(empty($jsonData['AppFee']) && empty($jsonData['VAT'])) throw new Exception('Fields must not be empty');
                // Update database data
                $res = $this->AppModel->updateFees($jsonData, $data->UserID);
                // Check if retrieval is successful, otherwis throw an Exception
                if(!$res) throw new Exception('Data update to Database failed');
                // If all is successful, return true
                $this->responseOutput('Successfully updated', [], 200, true);
            }else throw new Exception('Unauthorized access');
        } catch (Exception $e) {
            // Catch any exceptions and respond with the error message
            $this->responseOutput($e->getMessage());
        }
    }
    
}