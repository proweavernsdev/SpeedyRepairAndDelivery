<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Accept: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: LOGINAUTH, Content-Type, PWAUTH");

require_once APPPATH . '/libraries/rest/Rest.php';
//Test Comment to test CI/CD on backend

class Users extends Rest {
    public function __construct(){
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->library('plugins/crypto');
    }

    protected function test_get(){
        $this->response([
            'success' => true,
            'message' => $this->UsersModel->test()
        ],200);
    }

    protected function _get(){
        if (isset($_SERVER['HTTP_LOGINAUTH'])) {
            $authorizationHeader = $_SERVER['HTTP_LOGINAUTH'];
                if(strpos($authorizationHeader, 'Basic') === 0){
                    $base64Credentials = substr($authorizationHeader, 5);
                    $credentials = base64_decode($base64Credentials);
                    $credentialsArray = explode(':', $credentials);
                    $email = ['email' => $credentialsArray[0]];
                    $password = ['password' => $credentialsArray[0]];
                    list($email, $password) = $credentialsArray;
                    if (!empty($email && $password)){
                        if(strpos($email, ' ') !== false || strpos($password, ' ') !== false){
                            $this->response([
                                'success' => false,
                                'msg' => 'input field must not contain whitespaces',
                            ],402);
                        }else{
                            $res = $this->UsersModel->login($email, $password);
                            if($res){
                                if($res->users_access_level_id == 0 && $res->users_access_level_id != null || $res->users_access_level_id == 1 && $res->users_access_level_id != null){
                                    $this->response([
                                        'success' => true,
                                        'result' => $this->middleware->tokenize([
                                            'UserID' => $res->userID,
                                            'Email' => $res->users_email,
                                            'UserAccess' => $res->users_access_level_id])
                                    ],200);
                                }else{
                                    $this->response([
                                        'success' => true,
                                        'result' => $this->crypto->encrypt([
                                            'UserID' => $res->userID,
                                            'Email' => $res->users_email,
                                            'UserAccess' => $res->users_access_level_id])
                                        ],200);
                                    }
                            }else{
                                $this->response([
                                    'success' => false,
                                    'msg' => 'Wrong credentials'
                                ],401);
                            }
                        }
                    }else{
                        $this->response([
                            'success' => false,
                            'message' => 'Fields must not be empty 1'
                        ],400);
                    }
                }else{
                    $this->response([
                        'success' => false,
                        'msg' => 'Unsupported authentaction scheme',
                    ],403);
                }
        }

        else if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $decrypted = $this->crypto->decrypt($token);
            if(!$decrypted){
                $this->response([
                    'success' => false,
                    'message' => 'Unauthorize access'
                ],401);
            }else{
                if(!array_key_exists('expires_at', $decrypted)){
                    $this->response([
                        'success' => true,
                        'source' => 'crypto',
                        'result' => $decrypted
                    ],200);
                }else{
                    if(time() >= $decrypted['expires_at']){
                        $this->response([
                            'success' => false,
                            'message' => 'Token is expired'
                        ],401);
                    }else{
                        $this->response([
                            'success' => true,
                            'source' => 'middleware',
                            'result' => $decrypted
                        ],200);
                    }
                }
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Unauthorize access'
            ],401);
        }
    }

    protected function _post(){
        $this->validator->validate('UsersModel', $this->json(), ['userID', 'users_access_level_id']);

        $data = $this->validator->sanitize( $this->json() );
        $email = $data['email'];
        $password = $data['password'];
        if (!empty($email && $password)){
            if(strpos($email, ' ') !== false || strpos($password, ' ') !== false){
                $this->response([
                    'success' => false,
                    'message' => 'Input field must not contain white spaces'
                ],422);
            }else{
                $acc = $this->UsersModel->select($uEmail='users_email', $email);
                if($acc->num_rows() == 0){
                    if(empty($data['otp'])){
                        $otp = $this->UsersModel->createAndSaveOTP();
                        $to_email = $email;
                        $subject = "Subject: Your Registration OTP (Expires in 5 Minutes)";
                        $body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                                 <p>You have initiated the registration process for your account. To complete this process, please use the following One-Time Password (OTP):</p>
                                 <p>OTP: <span style='font-weight: bold;'>" . $otp . "</span></p>
                                 <p>This OTP is valid for 5 minutes only and is essential for completing your registration securely. It helps us confirm your identity and maintain the security of your account.</p>
                                 <p>Please use the OTP promptly to ensure a successful registration. Remember, it will expire in 5 minutes.</p>
                                 <p>Keep your OTP confidential and avoid sharing it with anyone.</p>
                                 <p>If you didn't initiate this registration, please ignore this email.</p>
                                 </div>";

                        $this->sendemail->sendEmail($to_email, $subject, $body);
                    }else{
                        $verify = $this->UsersModel->verifyOTP($data['otp']);
                        
                        if ($verify === true){
                            $res = $this->UsersModel->register($data);
                            if($res){
                                // get last row and insert to history
                                $this->response([
                                    'success' => true,
                                    'msg' => 'User Added'
                                ],201);
                            }else{
                                $this->response([
                                    'success' => false,
                                    'message' => 'Internal server error'
                                ],500);
                            }
                        }else{
                                $this->response([
                                    'success' => false,
                                    'message' => 'OTP does not match'
                                ],402);
                        }
                    }
                }else{
                    $this->response([
                        'success' => false,
                        'message' => 'Email is already taken'
                    ],402);
                }
            }
        }else{
            $this->response([
                'success' => false,
                'message' => 'Fields must not be empty 2'
            ],422);
        }
    }

    protected function _put(){
        $this->validator->validate('UsersModel', $this->json(), [], true);

        $data = $this->validator->sanitize( $this->json(), ['update_access', 'update_username', 'forgot_password', 'forget_password_token', 'update_passwordAccMgt'] );
        $update_access = $data['update_access'];
        $update_passwordAccMgt = $data['update_passwordAccMgt'];
        $forgot_password = $data['forgot_password'];
        if(isset($_SERVER['HTTP_PWAUTH'])){
            $token = $_SERVER['HTTP_PWAUTH'];
            $validated = $this->crypto->decrypt($token);
            
            if(!$validated) throw new Exception('The provided token is invalid');
            if ($update_access === true){
                if(!empty($data['accessID'])){
                    if(strpos($data['accessID'], ' ') !== false && strpos($validated['UserID'], ' ') !== false){
                        $this->response([
                            'success' => false,
                            'msg' => 'input field must not contain whitespaces',
                        ],402);
                    }else{
                        $res = $this->UsersModel->userRoleUpdate($data['accessID'], $validated['UserID']);
                        if($res){
                            $query = $this->UsersModel->select($usersID = 'userID',$validated['UserID']);
                            if ($query){
                                $row = $query->row();
                                $this->response([
                                    'success' => true,
                                    'result' => [
                                        'UserID' => $row->userID,
                                        'UserAccess' => $row->users_access_level_id]
                                ],200);
                            }else{
                                $this->response([
                                    'success' => false,
                                    'msg' => 'Internal Server Error'
                                ],500);
                            }
                        }else{
                            $this->response([
                                'success' => false,
                                'msg' => 'Wrong credentials'
                            ],402);
                        }
                    }
                }else{
                    $this->response([
                        'success' => false,
                        'message' => 'Fields must not be empty 3'
                    ],400);
                }
            }

            if ($update_passwordAccMgt == true){
                $this->load->library('sendemail');
                if(!empty($data['oldPassword']) && !empty($data['newPassword']) && !empty($data['confPassword'])){
                    $acc = $this->UsersModel->select($usersID = 'userID', $validated['UserID'])->row();

                    if(empty($data['otp'])){
                        $otp = $this->UsersModel->createAndSaveOTP();
                        $to_email = $acc->users_email;
                        $subject = "Subject: Your Password Change OTP (Expires in 5 Minutes)";
                        $body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                        <p>You have initiated change password for your account. To complete this process, please use the following One-Time Password (OTP).</p>
                        <p>OTP: <span style='font-weight: bold;'>" . $otp . "</span></p>
                        <p>This OTP is valid for 5 minutes only and is essential for resetting your password securely. It helps us confirm your identity and maintain the security of your account.</p>
                        <p>Please use the OTP promptly to ensure a successful password reset. Remember, it will expire in 5 minutes.</p>
                        <p>Keep your OTP confidential and avoid sharing it with anyone.</p>
                        <p>If you didn't request this password reset, please ignore this email.</p>
                        </div>";
    
                        $this->sendemail->sendEmail($to_email, $subject, $body);
                    }else{
                        $verify = $this->UsersModel->verifyOTP($data['otp']);
                        
                        if ($verify === true){
                            if(password_verify($data['oldPassword'], $acc->users_password)){
                                if($data['newPassword'] == $data['confPassword']){
                                    $pass = $this->UsersModel->changePassword($validated['UserID'], $data['newPassword']);
                                    if($pass){
                                        $this->UsersModel->deleteOTP($data['otp']);
                                        $this->response([
                                            'success' => true,
                                            'message' => 'Password has been changed'
                                        ],200);
                                    }else{
                                        $this->response([
                                            'success' => false,
                                            'message' => 'Internal Server Error'
                                        ],500);
                                    }
                                }else{
                                    $this->response([
                                        'success' => false,
                                        'message' => 'New password does not match'
                                    ],402);
                                }
                            }else{
                                $this->response([
                                    'success' => false,
                                    'message' => 'Password does not match'
                                ],402);
                            }
                        }else{
                            $this->response([
                                'success' => false,
                                'message' => 'OTP does not match'
                            ],402);
                        }
                    }
                }else{
                    $this->response([
                        'success' => false,
                        'message' => 'Fields must not be empty 4'
                    ],400);
                }
            }
        }

            if($forgot_password == true){
                if(!empty($data['forget_password_token'])){
                    $token = $data['forget_password_token'];
                    $validate = $this->middleware->validateToken($token);
                    if($validate != false){
                        if($data['newPassword'] == $data['confPassword']){
                            $query = $this->UsersModel->changePassword($validate->data['userID'], $data['newPassword']);
                            if($query){
                                $this->response([
                                    'success' => true,
                                    'message' => 'Password has been changed'
                                ],200);
                            }else{
                                $this->response([
                                    'success' => false,
                                    'message' => 'Internal Server Error'
                                ],500);
                            }
                        }else{
                            $this->response([
                                'success' => false,
                                'message' => 'Password does not match'
                            ],400);
                        }
                    }else{
                        $this->response([
                            'success' => false,
                            'message' => 'Unauthorize access 2'
                        ],401);
                    }
                }else{
                    if(!empty($data['email'])){
                        if(strpos($data['email'], ' ')){
                            $this->response([
                                'success' => false,
                                'message' => 'Fields must not include whitespace'
                            ],400);
                        }else{
                            $queryData = $this->UsersModel->select('users_email', $data['email']);
                            if($queryData->num_rows() > 0){
                                $row = $queryData->row();
                                $token = $this->middleware->tokenize([
                                    'userID' => $row->userID,
                                    'Email' => $row->users_email
                                ]);
                                $parsedToken = stripslashes($token);
                                $trimmedToken = trim($parsedToken, "\"");
                                $tokenURL = urlencode($trimmedToken);
                                $dummyLink = 'https://speedyrepairanddelivery.com/admin-delivery/change-password?marker='.$tokenURL;
                                $to_email = $row->users_email;
                                $subject = "Subject: Your Password Reset Link (Expires in 10 Minutes)";
                                $body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                                <p>You have initiated password reset for your account. To complete this process, please use the following link.</p>
                                <p><a href=".$dummyLink." style='font-weight: bold;'> Click Me </a></p>
                                <p>This link is valid for 10 minutes only and is essential for resetting your password securely. It helps us confirm your identity and maintain the security of your account.</p>
                                <p>Please use the link promptly to ensure a successful password reset. Remember, it will expire in 10 minutes.</p>
                                <p>Keep your link confidential and avoid sharing it with anyone.</p>
                                <p>If you didn't request this password reset, please ignore this email.</p>
                                </div>";
        
                                $this->sendemail->sendEmail($to_email, $subject, $body);
                            }else{
                                $this->response([
                                    'success' => false,
                                    'message' => 'Account does not exist'
                                ],404);
                            }
                        }
                    }else{
                        $this->response([
                            'success' => false,
                            'message' => 'Input fields must not be empty 5'
                        ],401);
                    }
                }
            }
            
        
    }

    }
