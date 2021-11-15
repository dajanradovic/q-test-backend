<?php

namespace App\Controllers;

use App\Services\AuthenticationService;
use App\Validators\Login;
use App\Services\QBackendService;
use App\Services\ViewsGeneratorService;

class AuthenticationController{

        public static function login(){
                
                $viewer = new ViewsGeneratorService();
                
                $token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);

                $validator = new Login($_POST);
                $validationResult = $validator->validate(); 

                if (count($validationResult) > 0) {
                        
                        $viewer->injectErrors($validationResult);

                        $setHeader = function(){
                                header("HTTP/1.1 422 Unprocessable entity");
                           };

                        $viewer->loginView($_POST, $setHeader); 
                 }
                
                if ($_ENV['TEST_MODE'] == '1' ? true : $viewer->validateCSRFToken($token)) {
                        
                        $email = $_POST['email'];
                        $password = $_POST['password'];

                        $qBackendService = new QBackendService();
                        $response = $qBackendService->login($email, $password);

                        if(isset($response['errors'])){

                                $viewer->injectErrors(['errors' => 'wrong credentials']);

                                $setHeader = function(){
                                        header("HTTP/1.1 403 Unauthorized");
                                    };
                                
                                $viewer->loginView($_POST, $setHeader);  
                        }

                        $authenticationService = new AuthenticationService();
                        $authenticationService->saveToken($response);
                        $authenticationService->storeUserDataInSession($response);

                        $redirection = isset($_POST['intended']) ? $_POST['intended'] : '/authors';
                        header('Location: ' . $_ENV['BASE_URL'] . $redirection);
                        exit();
                }

                header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                exit;
        }


        public static function logout(){
               
                $authenticationService = new AuthenticationService();
                $authenticationService->removeUserFromSessionAndInvalidateCookie();

                header('Location: ' . $_ENV['BASE_URL'] . '/');
                exit();

        }
}