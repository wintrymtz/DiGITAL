<?php

$heading = 'Administrador';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/administrador.view.php';