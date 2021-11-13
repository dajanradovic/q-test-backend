<?php

namespace App\Services\GenericApiHandler;
//session_start();

use GuzzleHttp\Client;


abstract class GenericApiHandler {

    protected $client;

    public function __construct(string $baseUri, array $headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json']) {

        $this->client = new Client(['base_uri' => $baseUri, 'headers' => $headers, 'http_errors' => true]);
    }

    protected function get(string $uri){

        $res = $this->client->request('GET', $uri, ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['user']['api_token']]]);

        return json_decode($res->getBody(), true);

    }

    protected function delete(string $uri){

        $res =  $this->client->delete($uri, ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['user']['api_token']]]);

    }

    protected function post(string $uri, array $body = null){
     
       try{
       $res =  $this->client->post($uri, ['json' => $body, 'headers' => ['Authorization' => 'Bearer ' . $_SESSION['user']['api_token']]]);
       
       return json_decode($res->getBody(), true);
       }
       catch(\GuzzleHttp\Exception\RequestException $e){
        $response = $e->getResponse();
        var_dump($response->getStatusCode()); // HTTP status code;
        var_dump($response->getReasonPhrase()); // Response message;
        var_dump(json_decode($response->getBody(), true)['errors'][0]); // Body, normally it is JSON;
        /*var_dump(json_decode((string) $response->getBody())); // Body as the decoded JSON;
        var_dump($response->getHeaders()); // Headers array;
        var_dump($response->hasHeader('Content-Type')); // Is the header presented?
        var_dump($response->getHeader('Content-Type')[0]); // Concr*/
       }
    }

    function dd($variable){
        echo '<pre>';
        die(var_dump($variable));
        echo '</pre>';
    }

}