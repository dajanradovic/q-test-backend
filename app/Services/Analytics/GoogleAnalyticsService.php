<?php

namespace App\Services\Analytics;

use App\Services\Interfaces\AnalyticsServiceInterface;
use Exception;

class GoogleAnalyticsService implements AnalyticsServiceInterface{

    public const LABEL = 'google';
    private $secretKey;
    private $baseUrl;

    public function __construct(){

        //initialize data to connect to external service, these data could come from .env file, some config file, or maybe from database

        $this->secretKey = $_ENV['GOOGLE_ANALYTICS_SECRET_KEY'];
        $this->baseUrl = $_ENV['GOOGLE_ANALYTICS_BASE_URL'];

    }

    public static function getLabel(): string{

        return self::LABEL;
    }


    public function getMonthlyReportData(): array{

        $data = [];
        
        try{
              //api call to external service
                
              //in the end we return result, a number which represent vistors in the last month according to google analytics 
        }catch(Exception $e){
                        
        }

        //dummy data
        $data = [self::LABEL => 2000];

        return $data; 
      
    }

}