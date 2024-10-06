<?php

$Project = '/PROYECTO%20CURSOS';
$Project2 = '/PaginaWeb';
$url = $Project.$Project2;

function dd($var)
{
    header("HTTP/1.0 500");
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function isUri($route)
{
    return $_SERVER['REQUEST_URI'] === $route ? 'bg-gray-900 text-white ' : 'text-gray-300 hover:bg-gray-700 hover:text-white ';
}

function getProjectRoot($new){
    global $url;
    return $url.$new;
}