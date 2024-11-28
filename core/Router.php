<?php
namespace Core;


use Core\Middleware\Admin;
use Core\Middleware\Student;
use Core\Middleware\Instructor;
use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function add($uri, $controller){
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            // 'method' => $method,
            'middleware' => null
        ];
        return $this;
    }

    // public function get($uri, $controller)
    // {
    //     return $this->add('GET', $uri, $controller);
    // }

    // public function post($uri, $controller)
    // {
    //     return $this->add('POST', $uri, $controller);
    // }


    
    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    public function route($uri, $method)
    {
        //debido que durante el proyecto ya se manejaba una url, se modifica para que las rutas conicidan
        //No se manejan metodos por la ruta
        $modifiedUrl = str_replace('/DiGITAL/', '/', $uri);

        foreach ($this->routes as $route) {
            // if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                if ($route['uri'] === $modifiedUrl){
                Middleware::resolve($route['middleware']);
                return require base_path($route['controller']);
            }
        }
        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}