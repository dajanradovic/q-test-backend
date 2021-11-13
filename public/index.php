<?php
session_start();

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Router\MainRouter;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new MainRouter();
$router->determineRoute($uri);