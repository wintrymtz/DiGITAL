<?php

$heading = 'Ventas Curso';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/ventasCurso.view.php';