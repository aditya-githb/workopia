<?php

// return [
//     '/' => 'controllers/home.php',
//     '/listings' => 'controllers/listings/index.php',
//     '/listings/create' => 'controllers/listings/create.php',
//     '404' => 'controllers/error/404.php'
// ];

use App\controllers\ListingController;

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create',['auth']);
$router->get('/listings/edit/{id}', 'ListingController@edit',['auth']);
$router->get("/listings/search",'ListingController@search');
$router->get('/listings/{id}', 'ListingController@show');


$router->post('/listings', 'ListingController@store',['auth']);
$router->put('/listings/{id}', 'ListingController@update',['auth']);
$router->delete('/listings/{id}', 'ListingController@destroy',['auth']);


$router->get('/auth/register', 'UserController@register',['guest']);
$router->get('/auth/login', 'UserController@login',['guest']);
$router->post('/auth/register', 'UserController@store',['guest']);
$router->post('/auth/logout', 'UserController@logout',['auth']);
$router->post('/auth/login', 'UserController@authenticate',['guest']);



// $router->get("/","controllers/home.php");
// $router->get("/listings","controllers/listings/index.php");
// $router->get("/listings/create","controllers/listings/create.php");
// $router->get("/listing","controllers/listings/show.php");
