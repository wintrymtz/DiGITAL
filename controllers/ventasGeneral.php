<?php

$heading = 'Ventas General';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/ventasGeneral.view.php';