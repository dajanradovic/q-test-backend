<?php

namespace App\Middlewares;

use App\Services\AuthenticationService;

class AuthenticationMiddleware{

    private AuthenticationService $authenticationService;

    public function __construct(){

        $this->authenticationService = new AuthenticationService();

    }

    public function checkForCookie(){
        if (isset($_SESSION['user'])) {

            return true;
        }
        
        return  $this->authenticationService->getToken();
    }

}