<?php

namespace Tests\Unit;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

use GuzzleHttp\Client;
use App\Router\MainRouter;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Services\QBackendService;
use App\Services\ViewsGeneratorService;
use App\Services\Analytics\SegmentsService;
use App\Services\Analytics\GoogleAnalyticsService;

class MainRouterTest extends TestCase{
  
    private $http;
    private $email;
    private $password;
    private $qBackendService;
    
    protected function setUp() : void {
       
        $this->http = new Client(['base_uri' => $_ENV['BASE_URL'], ['http_errors' => false]]);
        $this->email = $_ENV['TEST_EMAIL'];
        $this->password = $_ENV['TEST_PASSWORD'];
        $this->qBackendService = new QBackendService();

    }
   
    public function testLoginSuccess()
    { 
        $response = $this->http->request('POST', '/login', ['form_params' => [
            'email' => $this->email, 
            'password' => $this->password,
        ], 'http_errors' => false]);

       $this->assertEquals(200, $response->getStatusCode());
        
    }

   public function testLoginFailedValidation()
    { 
        $response = $this->http->request('POST', '/login', ['form_params' => [
            'email' => $this->email, 
            'password' => '',
        ], 'http_errors' => false]);

       $this->assertEquals(422, $response->getStatusCode());
        
    }

    public function testLoginFailedAuthentication()
    { 
        $response = $this->http->request('POST', '/login', ['form_params' => [
            'email' => $this->email, 
            'password' => 'sasddsa',
        ], 'http_errors' => false]);
       $this->assertEquals(403, $response->getStatusCode());
        
    }

    public function testGetLoginPage()
    {
        $response = $this->http->request('GET', '/login');

        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testHomePage()
    {
        $response = $this->http->request('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testAuthorsPage()
    {   
        $response = $this->http->request('GET', '/authors');
        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testSingleAuthorAndAuthorDeletePage()
    {   
        $authors = $this->qBackendService->authors();
        $response = $this->http->request('GET', '/authors/' . $authors['items'][0]['id']);
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->request('POST', '/authors/' . 1, ['form_params' => [
           'method' => 'DELETE'
        ], 'http_errors' => false]);

       $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testCreateBookSuccessAndValidationError()
    { 
        $authors = $this->qBackendService->authors();

        $response = $this->http->request('POST', '/books', ['form_params' => [
            'title' => 'test', 
            'description' => 'description',
            'isbn' => 'isbn',
            'format' => '',
            'release_date' => '12/12/2021',
            'number_of_pages' => 123,
            'author' => [
                'id' =>  $authors['items'][0]['id']
            ]

        ], 'http_errors' => false]);

       $this->assertEquals(422, $response->getStatusCode());

       $response = $this->http->request('POST', '/books', ['form_params' => [
        'title' => 'test', 
        'description' => 'description',
        'isbn' => 'isbn',
        'format' => 'xyccx',
        'release_date' => "2021-11-20",
        'number_of_pages' => 123,
        'author' => [
            'id' =>  $authors['items'][0]['id']
        ]

    ], 'http_errors' => false]);

       $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testDoesAuthorHaveBooks()
    { 
        $authors = $this->qBackendService->authors();

        $response = $this->http->request('POST', '/api/author/books', ['json' => [
            'author_id' => $authors['items'][0]['id'], 
        ], 'http_errors' => false]);

        $this->assertArrayHasKey('message', json_decode($response->getBody()->getContents(), true));
        
    }

   

}