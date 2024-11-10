<?php

$heading = 'Buscar';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

// echo $_GET['query'];

require 'views/buscar.view.php';