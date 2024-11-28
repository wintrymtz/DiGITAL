<?php

$heading = 'Confirmar Comprar';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

if($rol == 'instructor'){
    dd('Credenciales no validas');
}

require 'views/confirmarCompra.view.php';