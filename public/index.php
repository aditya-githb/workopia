<?php ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;
use Framework\Session;

Session::start();

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
