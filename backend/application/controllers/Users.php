<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Accept: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: LOGINAUTH, Content-Type, PWAUTH');

require_once APPPATH . '/libraries/rest/Rest.php';

class Users extends Rest {
    private $fb;
    private $sm;
    private $cp;
    private $md;
    private $mw;
    private $br;
    public function __construct(){
        // Inherit parent's construct
        parent::__construct();
        // load Model
        $this->load->model('UsersModel_v2');
        $this->load->model('CustomerModel');
        // load libraries
        $this->load->library('sendemail');
        $this->load->library('middleware');
        $this->load->library('plugins/crypto');
        $this->load->library('middlewares/BridgeAPI');
        $this->load->library('middlewares/firebase-php/Firebase_lib');
        // Shorten Libraries and Models
        $this->cp = $this->crypto;
        $this->sm = $this->sendemail;
        $this->br = $this->bridgeapi;
        $this->mw = $this->middleware;
        $this->fb = $this->firebase_lib;
        $this->md = $this->UsersModel_v2;

    }
    protected function _get(){
        try{
            /**
             *  Check if the credentials are present
             */
            if(!isset($_SERVER['HTTP_LOGINAUTH']))throw new Exception('No credentials detected');
            $authorizationHeader = $_SERVER['HTTP_LOGINAUTH'];

            if(strpos($authorizationHeader, 'Basic') !== 0)throw new Exception('Unsupported authentication scheme');
            
            $base64Credentials = substr($authorizationHeader, 5);
            $credentials = base64_decode($base64Credentials);
            $credentialsArray = explode(':', $credentials);
            $email = $credentialsArray[0];
            $password = $credentialsArray[1];

            if(empty($email) && empty($password))throw new Exception('Fields must not be empty');
            if(strpos($email, ' ') !== false || strpos($password, ' ') !== false)throw new Exception('input field must not contain whitespaces');

            $login = $this->fb->login($email, $password);

            $userRecord = $this->fb->userRecords($login['localId']);
            
            if($userRecord->emailVerified == true){
                // once verified, check database
                    $toArray = ['uid'=>$login['localId'], 'email'=>$email];
                    // check if data in database is present
                    $check = $this->md->checkDB($toArray);
                    if($check){
                        $data = [
                            'UserID'=>$check->userID,
                            'Email'=>$check->users_email,
                            'UserAccess'=>$check->users_access_level_id
                        ];
                        $params = [
                            'accessLevel'=> true,
                            'levelParams'=> 'AccessLevelData',
                            'basedOn'=> $data['UserAccess'],
                        ];
                        $this->responseOutput('Login success',json_decode($this->mw->createToken($data, $params)),200,true, true);
                    }else{
                    // If Speedy Delivery database query is false
                        // Create HTTP Request to the Speedy Repair API to check for possible accounts
                        $body = json_encode(['keypass'=>'laNzFSqL3D','email'=>$email,'uid'=>$login['localId']]);
                        $header = ['Content-Type'=>'application/json'];
                        // Submit HTTP Request to the Speedy Repair API 
                        $bridge = $this->br->bridgePost('verify',$body,$header);
                        // Check if the role is Customer
                        if($bridge->user_role !== 'Customer')throw new Exception('User not a Customer type');
                        // first, create account to db
                        $loginArray = [
                            'uid'=>$login['localId'],
                            'email'=>$bridge->user_email,
                            'accessID'=>3
                        ];
                        $this->md->registerDB($loginArray);
                        $toArray =[
                            'FirstName'=>$bridge->user_firstname,
                            'LastName'=>$bridge->user_lastname,
                            'Address'=>$bridge->user_address,
                            'TownCity'=>$bridge->user_city,
                            'State'=>$bridge->user_state,
                            'ZIP'=>$bridge->user_zip
                        ];
                        $query = $this->CustomerModel->customerRegister($toArray, $login['localId']);
                        if($query){
                            $this->responseOutput('Account succesfully migrated', [], 200, true);
                        }else throw new Exception('Query error');
                    }
                }else{
                    if(isset($userRecord->email)){
                        $verifyLink = $this->fb->getVerification($userRecord->email);
                        $to_email = $userRecord->email;
                        $subject = "Subject: Your Email Verification Link (Expires in 5 Minutes)";
                        $body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                                <p>You have initiated the registration process for your account. To complete this process, please use the following verification link:</p>
                                <p>Link: <span style='font-weight: bold;'> <a href= '" . $verifyLink . "'>link</a> </span></p>
                                <p>This Link is valid for 5 minutes only and is essential for completing your registration securely. It helps us confirm your identity and maintain the security of your account.</p>
                                <p>Please use the Link promptly to ensure a successful registration. Remember, it will expire in 5 minutes.</p>
                                <p>Keep your Link confidential and avoid sharing it with anyone.</p>
                                <p>If you didn't initiate this registration, please ignore this email.</p>
                                </div>";
                        $mail = $this->sm->sendEmail($to_email, $subject, $body);
                        if($mail){
                            $this->responseOutput('Email is not verified, verification link sent to email', ['email'=>$userRecord->email], 200,  true, true);
                        }else{
                            $this->responseOutput('Internal Server Error', ['email'=>$mail], 500, false, true);
                        }
                    }else{
                        $this->responseOutput('Internal Server Error');
                    }
                }
        } catch (Exception $e){
            $this->responseOutput($e->getMessage());
        }
    }
    
    protected function info_get(){
        try{
            $data = $this->mw->checkToken()->getData();
            $this->responseOutput('Proccess Successful', $data, 200,true,true);
        } catch (Exception $e){
            $this->responseOutput($e->getMessage());
        }
    }
    
    protected function _put(){
        try{
            $checker = $this->mw->checkToken();
            $data = $checker->getData();
            
            if(empty($data->Email))throw new Exception('Email is empty');
            if(!filter_var($data->Email, FILTER_VALIDATE_EMAIL))throw new Exception('Invalid email format');

            $verifyLink = $this->fb->getPassResetLink($data->Email);
            $to_email = $data->Email;
            $subject = "Subject: Your Password Reset Link (Expires in 5 Minutes)";
            $body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                    <p>You have initiated the password reset process for your account. To complete this process, please use the following verification link:</p>
                    <p>Link: <span style='font-weight: bold;'> <a href= '" . $verifyLink . "'>link</a> </span></p>
                    <p>This Link is valid for 5 minutes only and is essential for completing your password reset securely. It helps us confirm your identity and maintain the security of your account.</p>
                    <p>Please use the Link promptly to ensure a successful password reset. Remember, it will expire in 5 minutes.</p>
                    <p>Keep your Link confidential and avoid sharing it with anyone.</p>
                    <p>If you didn't initiate this password reset, please ignore this email.</p>
                    </div>";
            $mail = $this->sm->sendEmail($to_email, $subject, $body);
            if(!$mail)throw new Exception('An error has occured, Email not sent');
            $this->responseOutput('Password reset link has been sent',[],200,true);
        } catch (Exception $e) {
            $this->responseOutput($e->getMessage());
        }
    }
}