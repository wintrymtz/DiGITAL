<?php

namespace Core\Middleware;

class Middleware
{
    public const MAP = [
        'admin' => Admin::class,
        'student' => Student::class,
        'instructor' => Instructor::class,
        // 'auth' => Authenticated::class
    ];

    public static function resolve($key)
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}
