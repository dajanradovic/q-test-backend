<?php

namespace App\Controllers;

use App\Services\ViewsGeneratorService;



class HomeController{

        public static function index(){
            $viewer = new ViewsGeneratorService();
            $viewer->homeView();
       }

}