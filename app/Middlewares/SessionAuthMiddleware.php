<?php

namespace App\Middlewares;

use DateTime;

class SessionAuthMiddleware{

    private bool $user;
    private bool  $tokenValid;

    public function __construct(){

        $this->user = isset($_SESSION['user']);
        
        $this->tokenValid = $this->user && date($_SESSION['user']['api_token_expiry']) > date('Y/m/d H:i:s'); 
    }

    public function isAuthenticated() : bool{
      
        return $this->user && $this->tokenValid;
    }

    public function redirectToLogin(string $intendedUrl = null) : void{
        $intendedUrl = $intendedUrl ? '?intended=' . $intendedUrl : null;
        header('Location: ' . $_ENV['BASE_URL'] . '/login' . $intendedUrl);
        exit();
    }

    public function redirect(string $route) : void {

        header('Location: ' . $_ENV['BASE_URL'] . $route);
        exit();
    }


}