<?php

$heading = 'Confirmar Comprar';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/confirmarCompra.view.php';