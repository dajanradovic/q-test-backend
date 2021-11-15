<?php
namespace App\Services;

use eftec\bladeone\BladeOne;

class ViewsGeneratorService {

    private $blade;

    public const VIEWS = __DIR__ . '/../../views';
    public const CACHE = __DIR__ . '/../../cache';

    public function __construct(){

        $this->blade = new BladeOne(self::VIEWS,self::CACHE, BladeOne::MODE_DEBUG);
    }
    
    public function loginView(array $oldData = null, callable $setHeader = null){
       
        $csrfToken = $this->createCSRFToken();
        
        if(is_callable($setHeader)){
            call_user_func($setHeader);
        }
        echo $this->blade->run("login", ["csrf"=> $csrfToken, 'oldData' => $oldData]); 
        exit();
    }

    public function addBookView(array $authors, array $oldData = null, callable $setHeader = null){
        
        $csrfToken = $this->createCSRFToken();

        if(is_callable($setHeader)){
            call_user_func($setHeader);
        }
        echo $this->blade->run("books-add", ["csrf"=> $csrfToken, 'authors' => $authors, 'oldData' => $oldData]); 
        exit();
    }

    public function authorsView(array $response){
        
        echo $this->blade->run("authors-list", ['authors' => $response] ); 
        exit();
    }

    public function singleAuthorView(array $response){
       
        echo $this->blade->run("authors-single", ['author' => $response] ); 
        exit();
    }

    public function homeView(){
       
        echo $this->blade->run("home"); 
        exit();
    }

    public function unauthorizedView(){
        
        http_response_code(403);
        echo $this->blade->run("unauthorized403"); 
        exit();
    }

    public function injectErrors($errorArray){

        $errorCallback = function($key = null) use ($errorArray) {
            if (array_key_exists($key, $errorArray)) {
                return $errorArray[$key];
            }
        
            return false;
        };
        echo $this->blade->setErrorFunction($errorCallback); 
    }
      
    public function createCSRFToken(){

       $csrfToken = md5(uniqid(mt_rand(), true));
       $_SESSION['csrf_token'] = $csrfToken;

       return $csrfToken;

    }

    public function validateCSRFToken(string $token){
        if (!$token || $token !== $_SESSION['csrf_token']) {
            return false;
        } 
       
        unset($_SESSION['csrf_token']);
        return true;
    }

}