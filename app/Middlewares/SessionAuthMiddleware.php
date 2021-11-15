<?php

namespace App\Middlewares;

class SessionAuthMiddleware{

    private bool $user;

    public function __construct(){

        $this->user = isset($_SESSION['user']);
        
    }

    public function isAuthenticated() : bool{
      
        return $_ENV['TEST_MODE'] == '1' || $this->user;
    }

    public function redirectToLogin(string $intendedUrl = null) : void {
        
        $intendedUrl = $intendedUrl ? '?intended=' . $intendedUrl : null;
        header('Location: ' . $_ENV['BASE_URL'] . '/login' . $intendedUrl);
        exit();
    }

    public function redirect(string $route) : void {

        header('Location: ' . $_ENV['BASE_URL'] . $route);
        exit();
    }


}