<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Accept: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, PWAUTH");

require_once APPPATH . '/libraries/rest/Rest.php';
require_once APPPATH . '/libraries/middlewares/firebase-php/Firebase_lib.php';

class Company extends Rest {
    private $sm;
    private $mw;
    public function __construct(){
        parent::__construct();
        $this->load->model('CompanyModel');
        $this->load->library('middleware');
        $this->load->library('plugins/crypto');
        $this->load->library('plugins/filehelper');
        $this->load->library('middlewares/firebase-php/Firebase_lib');
        // Shorten Libraries and Models
        $this->fb = $this->firebase_lib;
        $this->mw = $this->middleware;
    }
    
    protected function _get(){
        try{
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();
            if($params->AccessLevel == 'Admin'){
                $res = $this->CompanyModel->all();
                $this->responseOutput('Data Retrieved', $res, 200, true, true) ;
            }elseif($params->AccessLevel == 'Company'){
                $res = $this->CompanyModel->retrieveData($data->UserID);
                $this->responseOutput('Data Retrieved', $res, 200, true, true) ;
            }else throw new Exception('Unauthorized access');
        } catch (Exception $e) {
            $this->responseOutput($e->getMessage());
        }
    }

    protected function docs_get(){
        try{
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();
            if($params->AccessLevel == 'Admin'){
                $jsonData = $this->json();
                $res = $this->filehelper->viewfiles("Users/Company/{$jsonData['UserID']}");
                if(!$res){
                    $this->response([
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ],401);
                }else{
                    $this->response($res,200);
                }
            }elseif($params->AccessLevel == 'Company'){
                $res = $this->filehelper->viewfiles("Users/Company/{$data->UserID}");
                $this->responseOutput('Files retrieved', $res, 200, true, true);
            }else throw new Exception('Unauthorized access');
        } catch (Exception $e) {    
            $this->responseOutput($e->getMessage());
        }
    }

    protected function employee_get(){
        try{
            $token = $this->mw->checkToken();
            $params = $token->getParams();
            $data = $token->getData();
            if($params->AccessLevel == 'Admin'){
                $jsonData = $this->json();
                $query = $this->CompanyModel->select('comp_userOwner', $jsonData['CompanyID'], 'srdr_company')->row();
                if($query){
                    $res = $this->CompanyModel->employeeRetrieve($query->companyID);
                    if(!isset($res['success'])){
                        $this->response([
                            'success' => true,
                            'results' => $res
                        ],200);
                    }else{
                        $this->response([
                            'success' => false,
                            'message' => 'Internal Server Error',
                            'result' => $res
                        ],500);
                    }
                }else{
                    $this->response([
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ],500);
                }
            }elseif($params->AccessLevel == 'Company'){
                $query = $this->CompanyModel->select('comp_userOwner', $data->UserID, 'srdr_company')->row();
                if($query){
                    $res = $this->CompanyModel->employeeRetrieve($query->companyID);
                    if(!isset($res['success'])){
                        $this->response([
                            'success' => true,
                            'results' => $res
                        ],200);
                    }else{
                        $this->response([
                            'success' => false,
                            'message' => 'Internal Server Error',
                            'result' => $res
                        ],500);
                    }
                }else{
                    $this->response([
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ],500);
                }

            }else throw new Exception('Unauthorized access');
        } catch (Exception $e) {    
            $this->responseOutput($e->getMessage());
        }
    }
}