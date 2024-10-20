<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$nombre = $body['name'];
$apellido = $body['lastName'];
$email = $body['email'];
$password = $body['password'];
$rol = $body['role'];

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_RegisterUser(:email, :nombre, :apellido, :password, :rol)';
            $insert = $db->query($query, [
                'email' => $email,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'password' => $password,
                'rol' => $rol,
            ]);
    

        unset($nombre);
        unset($apellido);
        unset($email);
        unset($password);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Usuario creado correctamente!';

        echo json_encode($response);
        return;
    } else {
        header('HTTP/1.1 400');

        $response["success"] = false;
        $response["errors"] = $errors;
        $response["msg"] = 'Some errors occured!';
        echo json_encode($response);
        return;
    }
} catch (PDOException $error){
    header('HTTP/1.1 400');

        $response["success"] = false;
        $response["msg"] = 'DataBase error!';
        $response["errorCode"] = $error->getCode();
        $response["errorDetails"] = $error->getMessage();
        echo json_encode($response);
}