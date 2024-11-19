<?php

$heading = 'Certificado';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

$nombreUsuario = $_SESSION['nombre'];
$apeliidoUsuario = $_SESSION['apellido'];
$nombreCurso = $_GET['nombreCurso'];
$fechaTerminado = $_GET['fechaTerminado'];
$nombreInstructor = $_GET['nombreInstructor'];

require 'views/Diploma.view.php';