<?php
session_start();

const BASE_PATH = __DIR__.'/./';

require BASE_PATH.'core/functions.php';
require 'Database.php';


spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require base_path("{$class}.php");
});

// require 'router.php';

$router = new \Core\Router();
$routes = require base_path('routes.php');


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$method = null;
$router->route($uri, $method);

//--- NO IMPLEMENTADO

// <?php

// const BASE_PATH = __DIR__.'/./';
// require BASE_PATH.'core/functions.php';

// // require 'core/Router.php';
// // require 'Database.php';
// // require 'router.php';

// spl_autoload_register(function ($class) {
//     $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

//     require base_path("{$class}.php");
// });

// $router = new \Core\Router();
// $routes = require base_path('routes.php');

// $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

// $router->route($uri, $method);
