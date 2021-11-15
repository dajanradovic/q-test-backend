<?php

namespace App\Router;

use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\AuthorController;
use App\Controllers\Api\AuthorController as AuthorApiController;
use App\Services\ViewsGeneratorService;
use App\Controllers\AuthenticationController;
use App\Middlewares\AuthenticationMiddleware;
use App\Middlewares\SessionAuthMiddleware;

class MainRouter{

    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const DELETE_METHOD = 'DELETE';

    public const AUTHOR_PATTERN = 'authors';
    public const AUTHOR_ID_PATTERN = '/authors/';
    public const BOOK_PATTERN = 'books';
    public const BOOK_ID_PATTERN = '/books/';


    public function determineRoute(string $uri): void {

        $authenticationMiddleware = new AuthenticationMiddleware();
        $authenticationMiddleware->checkForCookie();

        $method = $_SERVER['REQUEST_METHOD'];
        $queryString = $_SERVER['QUERY_STRING'] ?? null;
        [$mainUrl, $lastParameter] = $this->prepareUrlData($uri);
        $authenticator = new SessionAuthMiddleware();

        switch ($mainUrl){

            case '/':
                if($method == self::GET_METHOD){
                    HomeController::index();
                }

                self::error404(); 
                           
                break;

            case '/login':
              
                if($method == self::GET_METHOD){
                    if($authenticator->isAuthenticated()){
                        $authenticator->redirect('/authors');
                    }

                    $viewer = new ViewsGeneratorService();
                    $viewer->loginView();
                }
               
                else if ($method == self::POST_METHOD){
                    AuthenticationController::login();
                }

                self::error404(); 
                
                break;

            case '/logout':

                if($method == self::POST_METHOD){
                    if(!$authenticator->isAuthenticated()){
                      self::error401();
                    }

                     AuthenticationController::logout();
                }

                self::error404(); 
               
                break;

            case '/authors':

                if($method == self::GET_METHOD){
                    if(!$authenticator->isAuthenticated()){
                        $authenticator->redirectToLogin($mainUrl);
                    }
                   
                    AuthorController::authors($queryString);
                }
        
                self::error404(); 

                break;

                //authors/{id}
            case '/authors/' :

                if($method == self::GET_METHOD){
                    if(!$authenticator->isAuthenticated()){
                        $authenticator->redirectToLogin($mainUrl . $lastParameter);
                    }

                    AuthorController::singleAuthor($lastParameter);
                }
                else if($method == self::POST_METHOD && $_POST['method'] == self::DELETE_METHOD){
                   
                    if(!$authenticator->isAuthenticated()){
                        self::error401();
                      }

                    AuthorController::deleteAuthor($lastParameter);
                }

                self::error404(); 

                break;

            case '/books':
                BookController::books($method, $mainUrl);
        
                break;

                // books/{id}
            case '/books/' :
                if($method == self::POST_METHOD && $_POST['method'] == self::DELETE_METHOD){
                    if(!$authenticator->isAuthenticated()){
                        self::error401();
                      }

                    BookController::deleteBook($lastParameter);
                }

                self::error404(); 
            
                break;

            case '/api/author/books' :

                if($method == self::POST_METHOD){
                    if(!$authenticator->isAuthenticated()){
                        self::error401();
                      }

                    AuthorApiController::checkIfAuthorHasBooks();
                }

                self::error404(); 
                
                break;
                      
            default:
                self::error404(); 
        }
    }

    public static function error404(): void {
        
        header("HTTP/1.0 404 Not Found");
        echo 'This page was not found';
        exit();
    }

    public static function error401(): void {
        
        header("HTTP/1.1 401 Unauthorized");
        echo 'Unauthorized';
        exit();
    }

    private function prepareUrlData(string $uri): array {
        
        $additionalParameters = explode('/', $uri);

        if(count($additionalParameters) > 2 
                && $additionalParameters[count($additionalParameters) - 2] == self::AUTHOR_PATTERN
                && preg_match('/^[0-9]/', $additionalParameters[count($additionalParameters) - 1])) {
         
                    $lastParameter = $additionalParameters[count($additionalParameters) - 1];
                    $uri = self::AUTHOR_ID_PATTERN;         
        }
        else if(count($additionalParameters) > 2 
                && $additionalParameters[count($additionalParameters) - 2] == self::BOOK_PATTERN
                && preg_match('/^[0-9]/', $additionalParameters[count($additionalParameters) - 1])) {
            
                    $lastParameter = $additionalParameters[count($additionalParameters) - 1];
                    $uri = self::BOOK_ID_PATTERN;         
          }
            
        else{
            $lastParameter = null;
        }

        return [$uri, $lastParameter];
    }

   }