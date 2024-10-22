<?php

$heading = 'Subir Curso';

$rol = 'none';
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}

require 'views/subirCurso.view.php';