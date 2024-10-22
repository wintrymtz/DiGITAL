<?php

$heading = 'Comprar Curso';


$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/comprarCurso.view.php';