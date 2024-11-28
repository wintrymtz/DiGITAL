<?php

namespace Core\Middleware;

class Instructor
{
    public function handle()
    {
        if ($_SESSION['rol'] !== 'instructor') {
            header('location: /DiGITAL/');
            exit();
        }
    }
}