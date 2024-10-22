<?php

$heading = 'Buscar';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/buscar.view.php';