<?php

$heading = 'Iniciar Sesión';

// $config = require 'config.php';

// $db = new Database($config['database']);
// $notes = $db->query('SELECT * FROM usuario where idUsuario = 1')
//     ->fetchAll(PDO::FETCH_ASSOC);

// dd($notes);

if(isset($_SESSION['email'])){
    session_destroy();
}


require 'views/iniciarSesion.view.php';