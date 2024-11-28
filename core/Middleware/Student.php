<?php

namespace Core\Middleware;

class Student
{
    public function handle()
    {
        if ($_SESSION['rol'] !== 'estudiante') {
            header('location: /DiGITAL/');
            exit();
        }
    }
}