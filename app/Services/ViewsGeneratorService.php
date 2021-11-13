<?php
namespace App\Services;

//session_start();


use eftec\bladeone\BladeOne;


class ViewsGeneratorService {

    private $blade;

    public const VIEWS = __DIR__ . '/../../views';
    public const CACHE = __DIR__ . '/../../cache';

    public function __construct(){

        $this->blade = new BladeOne(self::VIEWS,self::CACHE, BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.


    }
    
    public function loginView(){
        $csrfToken = $this->createCSRFToken();

        echo $this->blade->run("login",array("csrf"=> $csrfToken)); 
    }

    public function addBookView(array $authors){
        $csrfToken = $this->createCSRFToken();

        echo $this->blade->run("books-add",["csrf"=> $csrfToken, 'authors' => $authors]); 
    }

    public function authorsView(array $response){
        echo $this->blade->run("authors-list", ['authors' => $response] ); 
    }

    public function singleAuthorView(array $response){
        echo $this->blade->run("authors-single", ['author' => $response] ); 
    }

    public function homeView(){
        echo $this->blade->run("home"); 
    }
      
    private function createCSRFToken(){

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