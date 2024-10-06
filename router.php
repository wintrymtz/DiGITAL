<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = require "routes.php";

function toController($uri,$routes){
    if(array_key_exists($uri, $routes)) {
        require $routes[$uri];
    }else{
        dd($uri);
        abort();
    }
}

function abort($code = 404)
{
    http_response_code($code);
    require "views/$code.php";
    die();
}


toController($uri,$routes);