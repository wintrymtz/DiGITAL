<?php

$heading = 'Configuracion';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/manejarPerfil.view.php';