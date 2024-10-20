<?php

$Project = '/DiGITAL';
$url = $Project;

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

function getFile($new, $type){
    global $url;

    switch ($type) {
    case 'css':
        return 'views/css'.$new.'.css';
        break;
    case 'js':
        return 'views/js'.$new.'.js';
        break;
    case 'img':
        return 'views/img'.$new;
        break;
    }

}

function base_path($path): string
{
return BASE_PATH . $path;
}