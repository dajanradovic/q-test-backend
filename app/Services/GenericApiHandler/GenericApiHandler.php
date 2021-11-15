<?php

namespace App\Services\GenericApiHandler;
//session_start();

use Exception;
use GuzzleHttp\Client;
use App\Services\AuthenticationService;
use App\Services\ViewsGeneratorService;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

abstract class GenericApiHandler {

    public const ERROR_CODE_401 = 401;
    public const ERROR_CODE_403 = 403;
    public const ERROR_CODE_404 = 404;
    protected $client;
    private $token;
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const PUT_METHOD = 'PUT';
    public const PATCH_METHOD = 'PATCH';
    public const DELETE_METHOD = 'DELETE';
    

    public function __construct(string $baseUri, array $headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json'])
    {
        $this->client = new Client(['base_uri' => $baseUri, 'headers' => $headers, 'http_errors' => true]);
        $this->token = $_ENV['TEST_MODE'] == '1' ? $_ENV['TEST_TOKEN'] : ($_SESSION['user']['api_token'] ?? null);
    }

    public function handleRoutes(string $method, string $uri, array $body = null)
    {
        try {
            switch ($method) {

                case self::GET_METHOD:
                   return $this->get($uri);
                   
                   break;
            
                case self::POST_METHOD:
                   return  $this->post($uri, $body);
                   
                   break;
                case self::DELETE_METHOD:
                   return $this->delete($uri);
                   
                   break;
                }
             } catch (ClientException $e) {
                $response = $e->getResponse();
                
                if ($response->getStatusCode() == SELF::ERROR_CODE_401) {
                    
                        $authenticationService = new AuthenticationService();
                        $authenticationService->removeUserFromSessionAndInvalidateCookie();
                        $viewer = new ViewsGeneratorService();
                        $viewer->unauthorizedView();

                }
                if ($response->getStatusCode() == SELF::ERROR_CODE_403) {
                    
                        return ['errors' => true];
                }

                if ($response->getStatusCode() == SELF::ERROR_CODE_404) {
                    
                    return ['errors' => true];
            }
            } catch (Exception $e) {
                        
                        return ['errors' => true];

            }
    }

    private function get(string $uri)
    {
        $res = $this->client->request('GET', $uri, ['headers' => ['Authorization' => 'Bearer ' . $this->token]]);
        return ['errors' => false, 'data' => json_decode($res->getBody(), true)];
      
    }

    private function delete(string $uri)
    {
       $this->client->delete($uri, ['headers' => ['Authorization' => 'Bearer ' . $this->token]]);
       return ['errors' => false, 'data' => []];

    }

    private function post(string $uri, array $body = null)
    {        
        $res =  $this->client->post($uri, ['json' => $body, 'headers' => ['Authorization' => 'Bearer ' . $this->token]]);
        return ['errors' => false, 'data' => json_decode($res->getBody(), true)];
    }
    
}
