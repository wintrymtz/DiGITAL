<?php

$heading = 'Calificar Curso';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/calificarCurso.view.php';