<?php

namespace App\Controllers;

use App\Router\MainRouter;
use App\Validators\SaveBook;
use App\Services\QBackendService;
use App\Services\ViewsGeneratorService;
use App\Middlewares\SessionAuthMiddleware;

class BookController{

        public static function books(string $method, $mainUrl){

           $viewer = new ViewsGeneratorService();
           $authenticator = new SessionAuthMiddleware();
          
           if ($method == 'POST'){
                   if(!$authenticator->isAuthenticated()){
                        MainRouter::error401();
                      }
           
             $validator = new SaveBook($_POST);
             $validationResult = $validator->validate(); 

             if (count($validationResult) > 0){

                $qBackendService = new QBackendService();
                $authors = $qBackendService->authors('limit=1000&page=1'); // ovo je hack da se dobiju svi autori za dropdown picker jer je resurs paginiran
               
                $viewer->injectErrors($validationResult);
                $setHeader = function(){
                        header("HTTP/1.1 422 Unprocessable entity");
                     };      

                $viewer->addBookView($authors, $_POST, $setHeader);

             }   
            
            $token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);
           
            if ($_ENV['TEST_MODE'] == '1' ? true : $viewer->validateCSRFToken($token)){

                    $qBackendService = new QBackendService();
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $format = $_POST['format'];
                    $isbn = $_POST['isbn'];
                    $releaseDate = $_POST['release_date'];
                    $numberOfPages = $_POST['number_of_pages'];
                    $author = $_POST['author'];

                    $qBackendService->storeBook($title, $description, $format, $isbn, $releaseDate, $numberOfPages, $author);

                    showFlashMessage();
                    header('Location: ' . $_ENV['BASE_URL'] . '/authors');
                    exit();
            }

            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
           
            }
          
            else if($method == 'GET'){
                
                if(!$authenticator->isAuthenticated()){
                        $authenticator->redirectToLogin($mainUrl);
                    }
                              
                $qBackendService = new QBackendService();
                $authors = $qBackendService->authors('limit=1000&page=1'); // ovo je hack da se dobiju svi autori za dropdown picker jer je resurs paginiran
                $viewer->addBookView($authors);

            }
            
            MainRouter::error404();
        }


        public static function deleteBook(?string $id){

            $qBackendService = new QBackendService();
            $qBackendService->deleteBook($id);
            $author = $qBackendService->singleAuthor($_POST['author_id']);
            header('Location: ' . $_ENV['BASE_URL'] . '/authors/' . $author['id']);
            exit();
        }
       

}