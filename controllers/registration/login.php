<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$email = $body['email'];
$password = $body['password'];

$errors = array();
try{
    if(empty($errors)){

        $query = 'CALL sp_ValidateUser(:email, :password)';
        $user = $db->query($query, [
            'email' => $email,
            'password' => $password,
        ])->find();

        //almacenamos sesion
        if($user){
            $_SESSION['id'] = $user['idUsuario'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['foto'] = base64_encode($user['foto']);
            $_SESSION['mimeType'] = $user['mimeType'];
            $_SESSION['rol'] = $user['rol'];
        }

        unset($email);
        unset($password);

        //Guardar datos y mandarlos de vuelta en la respuesta

        if($user){
            $response = [];
            $response["success"] = true;
            $response["errors"] = [];
            $response["msg"] = 'Sesion iniciada correctamente';
            echo json_encode($response);
            return;
        } else{
            header('HTTP/1.1 404');
            
            $response = [];
            $response["success"] = false;
            $response["errors"] = [];
            $response["msg"] = 'Usuario no encontrado';
            echo json_encode($response);
            return;
        }
        return;
    } else {
        header('HTTP/1.1 400');

        $response["success"] = false;
        $response["errors"] = $errors;
        $response["msg"] = 'Some errors occured!';
        echo json_encode($response);
        return;
    }
} catch (PDOException $error) {
    header('HTTP/1.1 400');

    $response["success"] = false;
    $response["msg"] = 'DataBase error!';
    $response["errorCode"] = $error->getCode();
    $response["errorDetails"] = $error->getMessage();
    echo json_encode($response);
}