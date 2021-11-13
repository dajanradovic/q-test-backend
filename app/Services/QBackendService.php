<?php

namespace App\Services;

use App\Services\GenericApiHandler\GenericApiHandler;

class QBackendService extends GenericApiHandler{

    public function __construct() {

        parent::__construct($_ENV['Q_BACKEND_SERVICE_BASE_URL']);
    }

    public function login(string $email, string $password){
        
        $body = ['email' => $email, 'password' => $password];
       
        return $response = $this->post('/api/v2/token', $body);
    }

    public function deleteBook(string $id){
               
        return $response = $this->delete('/api/v2/books/' . $id);
    }

    public function deleteAuthor(string $id){
               
        return $response = $this->delete('/api/v2/authors/' . $id);
    }

    public function storeBook(string $title, string $description, string $format, string $isbn, string $releaseDate, string $numberOfPages, string $author){
        
        $body = ['title' => $title, 
                'description' => $description,
                'format' => $format,
                'isbn' => $isbn,
                'release_date' => $releaseDate,
                'number_of_pages' => intval($numberOfPages),
                'author' => ['id' => $author]];
       
        return $response = $this->post('/api/v2/books', $body);
    }

    public function authors(?string $queryString = null){
        $query = $queryString ? '?' . $queryString : null;
        return $response = $this->get('/api/v2/authors' . $query);
    }

    public function singleAuthor(?string $id){

        return $response = $this->get('/api/v2/authors/' . $id);
        
    }

    public function booksByAuthor(?string $id){
       
      return  $response = $this->get('/api/v2/books');
        
    }
 
}