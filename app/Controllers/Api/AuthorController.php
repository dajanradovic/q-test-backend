<?php

namespace App\Controllers\Api;

use App\Services\QBackendService;


class AuthorController{
        
       public static function checkIfAuthorHasBooks(){
          $data = json_decode(file_get_contents('php://input'), true);
          $qBackendService = new QBackendService();
          $author = $qBackendService->singleAuthor($data['author_id']);
          header("Content-Type: application/json");
          echo (json_encode(['message' => count($author['books']) > 0]));
    
       }


}