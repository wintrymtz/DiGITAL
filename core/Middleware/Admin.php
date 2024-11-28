<?php

namespace Core\Middleware;

class Admin
{
    public function handle()
    {
        if ($_SESSION['rol'] !== 'administrador') {
            header('location: /DiGITAL/');
            exit();
        }
    }
}