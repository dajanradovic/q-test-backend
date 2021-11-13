<?php

namespace App\Controllers;

use App\Services\QBackendService;
use App\Services\ViewsGeneratorService;



class AuthenticationController{

        public static function login(){
           $viewer = new ViewsGeneratorService();
     
                $token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);
                if($viewer->validateCSRFToken($token)){
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $qBackendService = new QBackendService();
                        $response = $qBackendService->login($email, $password);
                        storeUserInSession($response);
                        $redirection = isset($_POST['intended']) ? $_POST['intended'] : '/authors';
                        header('Location: ' . $_ENV['BASE_URL'] . $redirection);
                        exit();
                }

                header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                exit;
        
        }

        public static function logout(){
                removeUserFromSession();
                header('Location: ' . $_ENV['BASE_URL'] . '/');
                exit();

        }

}