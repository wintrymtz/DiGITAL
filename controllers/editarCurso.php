<?php

$heading = 'Editar Curso';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/editarCurso.view.php';