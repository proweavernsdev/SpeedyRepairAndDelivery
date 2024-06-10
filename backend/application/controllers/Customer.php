<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Accept: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, PWAUTH");

require_once APPPATH . '/libraries/rest/Rest.php';

class Customer extends Rest {
    private $cm;
    private $mw;
    private $cp;
    private $fh;
    public function __construct(){
        parent::__construct();
        $this->load->model('CustomerModel');
        $this->load->library('middleware');
        $this->load->library('plugins/crypto');
        $this->load->library('plugins/filehelper');
        // shorten libraries and models
        $this->cm = $this->CustomerModel;
        $this->mw = $this->middleware;
        $this->fh = $this->filehelper;
        $this->cp = $this->crypto;
    }

    protected function _get(){
        if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $decrypted = $this->cp->decrypt($token);
            if(!$decrypted){
                $this->response([
                    'success' => false,
                    'message' => 'Unauthorize access'
                ],401);
            }else{
                if(!array_key_exists('expires_at', $decrypted)){
                    $this->response([
                        'success' => false,
                        'message' => 'Unauthorized access'
                    ],401);
                }else{
                    if(time() >= $decrypted['expires_at']){
                        $this->response([
                            'success' => false,
                            'message' => 'Token is expired'
                        ],401);
                    }else{
                        $this->responseOutput('All data', $this->cm->all() , 200, true, true);
                    }
                }
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Unauthorized access'
            ],401);
        }
    }

    protected function user_get(){
        if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $decrypted = $this->cp->decrypt($token);
            if(!$decrypted){
                $this->response([
                    'success' => false,
                    'message' => 'Invalid Token'
                ],401);
            }else{
                $this->responseOutput('Customer Data', $this->cm->retrieveData($decrypted['UserID']) , 200, true, true);
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Unauthorized access'
            ],401);
        }
    }

    protected function _post(){
        $postData = $this->json();

        if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $decrypted = $this->cp->decrypt($token);

            if(!isset($decrypted)) throw new Exception("Token is Invalid"); 
            else if($decrypted['UserID'] == null || empty($decrypted['UserID'])) throw new Exception("Token is empty");
            if(!empty($postData['FirstName']) && !empty($postData['LastName']) && !empty($postData['Address']) && !empty($postData['TownCity']) && !empty($postData['State']) && !empty($postData['Zip'])){
                    $res = $this->cm->customerRegister($postData, $decrypted['UserID']);
                    if($res){
                        $this->response([
                            'success' => true,
                            'message' => 'Customer has been created'
                        ], 200);
                    }else{
                        $this->response([
                            'success' => false,
                            'message' => 'Internal Server Error'
                        ], 500);
                    }
            }else{
                $this->response([
                    'success' => false,
                    'message' => 'Input fields must not be empty',
                    'dataReceived' => $postData
                ],401);
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Unauthorize access'
            ],401);
        }
    }

    protected function _put(){
        $data = $this->json();
        if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $decrypted = $this->cp->decrypt($token);
            if(!$decrypted){
                $this->response([
                    'success' => false,
                    'message' => 'Invalid Token'
                ],401);
            }else{
                if(isset($decrypted['UserID']) && !empty($decrypted['UserID'])){
                    $query = $this->cm->retrieveData($decrypted['UserID']);

                    if(!$query) $this->responseOutput('Something went wrong retrieving data');

                    $res = $this->cm->updateDetails($query->customerID, $data);
                    if($res){
                        $this->responseOutput('Data successfuly updated',[],200,true);
                    }else{
                        $this->responseOutput('Internal Server Error');
                    }
                }else{
                    $this->responseOutput('Token is empty');
                }
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Unauthorized access'
            ],401);
        }
    }

    protected function upload_put(){
        if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $decrypted = $this->crypto->decrypt($token);
            if(!$decrypted){
                $this->response([
                    'success' => false,
                    'message' => 'Invalid Token'
                ],401);
            }else{
                // place code here
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Unauthorized access'
            ],401);
        }
    }
}