<?php

namespace App\Services;

use App\Services\GenericApiHandler\GenericApiHandler;

class QBackendService extends GenericApiHandler{

    public function __construct() {

        parent::__construct($_ENV['Q_BACKEND_SERVICE_BASE_URL']);
    }

    public function login(string $email, string $password){
        
        $body = ['email' => $email, 'password' => $password];
       
        $response = $this->handleRoutes(self::POST_METHOD, '/api/v2/token', $body);
        
        if(!$response['errors']){
            return $response['data'];
        }

        return $response;
    }

    public function deleteBook(string $id){
               
       $response = $this->handleRoutes(self::DELETE_METHOD, '/api/v2/books/' . $id);
                
    }

    public function deleteAuthor(string $id){
               
       $this->handleRoutes(self::DELETE_METHOD,'/api/v2/authors/' . $id);
        
    }

    public function storeBook(string $title, string $description, string $format, string $isbn, string $releaseDate, string $numberOfPages, string $author){
        
        $body = ['title' => $title, 
                'description' => $description,
                'format' => $format,
                'isbn' => $isbn,
                'release_date' => $releaseDate,
                'number_of_pages' => intval($numberOfPages),
                'author' => ['id' => $author]];
       
        $response = $this->handleRoutes(self::POST_METHOD, '/api/v2/books', $body);

        if(!$response['errors']){
            return $response['data'];
        }
    }

    public function authors(?string $queryString = null){
        
        $query = $queryString ? '?' . $queryString : null;
        $response = $this->handleRoutes(self::GET_METHOD, '/api/v2/authors' . $query);
       
        if(!$response['errors']){
            return $response['data'];
        }
    }

    public function singleAuthor(?string $id){

        $response = $this->handleRoutes(self::GET_METHOD, '/api/v2/authors/' . $id);
        
        if(!$response['errors']){
            return $response['data'];
        }

        return $response;
       
    }

    public function booksByAuthor(?string $id){
       
        $response = $this->handleRoutes(self::GET_METHOD, '/api/v2/books');
        
        if(!$response['errors']){
            return $response['data'];
        }
        
    }
 
}