<?php

namespace App\Controllers;

use App\Services\QBackendService;
use App\Services\ViewsGeneratorService;

class AuthorController{

        public static function authors(?string $queryString){

           $viewer = new ViewsGeneratorService();
           $qBackendService = new QBackendService();
           $response = $qBackendService->authors($queryString);
           $viewer->authorsView($response);

        }

        public static function singleAuthor(?string $id){

            $viewer = new ViewsGeneratorService();
            $qBackendService = new QBackendService();
            $author = $qBackendService->singleAuthor($id);
            $viewer->singleAuthorView($author);

       }

      public static function deleteAuthor(string $id){

            $qBackendService = new QBackendService();
            $qBackendService->deleteAuthor($id);
            header('Location: ' . $_ENV['BASE_URL'] . '/authors');
            exit();
       }

}