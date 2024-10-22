<?php

$heading = 'Kardex';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/kardex.view.php';