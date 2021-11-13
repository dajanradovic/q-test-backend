<?php

namespace App\Controllers;

use App\Router\MainRouter;
use App\Models\WebAnalytics;
use eftec\bladeone\BladeOne;
use App\Services\QBackendService;
use App\Resources\WebAnalyticsResource;
use App\Services\ViewsGeneratorService;

class WebAnalyticsController{

        public static function getAllAnalytics() : void {

            $webAnalytics = new WebAnalytics();
            $output = $webAnalytics->collectAnalyticsFromAllAnalyticsServices();
            MainRouter::successOutput(WebAnalyticsResource::resourceTemplate($output));

        }
  
        public static function login(){

            $viewer = new ViewsGeneratorService();
            /*$views = __DIR__ . '/../../templates/layouts';
            $cache = __DIR__ . '/../../cache';
            $blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.
            echo $blade->run("login",array("variable1"=>"value1")); 
           /* $service = new QBackendService();
            $service->login();*/
            $viewer->loginView();
        }


}