<?php

namespace Tests\Unit;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Services\Analytics\SegmentsService;
use App\Services\Analytics\GoogleAnalyticsService;

class MainRouterTest extends TestCase{
  
    private $http;
    
    protected function setUp() : void {
       
        $this->http = new Client(['base_uri' => $_ENV['BASE_URL']]);

    }
   
    public function testWebAnalyticsRouteSuccess()
    {
        $response = $this->http->request('GET', '/web-analytics');

        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testWebAnalyticsRouteFail()
    {
        $response = $this->http->request('GET', '/web-anaslytics', ['http_errors' => false]);

        $this->assertEquals(404, $response->getStatusCode());
        
    }

    public function testWebAnalyticsSingleRouteSuccess()
    {
        $response = $this->http->request('GET', '/web-analytics/' . GoogleAnalyticsService::getLabel());

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->request('GET', '/web-analytics/' . SegmentsService::getLabel());

        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function testWebAnalyticsSingleRouteFail()
    {
        $response = $this->http->request('GET', '/web-anaalytics/dfs', ['http_errors' => false]);

        $this->assertEquals(404, $response->getStatusCode());
        
    }





}