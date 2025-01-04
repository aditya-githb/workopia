<?php

session_start();

use Framework\Router;

require __DIR__ . '/../vendor/autoload.php';
require "../helpers.php";

// spl_autoload_register(function ($class){
//     $path = basePath('Framework/' . $class . '.php');
//     if (file_exists($path)) {
//         require $path;
//     }
//     else echo "file does not exist";
// });

$router = new Router();
require basePath("routes.php");
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$router->route($uri);
