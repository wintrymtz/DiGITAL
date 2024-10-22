<?php

$heading = 'Ver Curso';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/verCurso.view.php';