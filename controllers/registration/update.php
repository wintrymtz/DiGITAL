<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$nombre = $body['name'];
$apellido = $body['lastName'];
$oldEmail = $body['oldEmail'];
$newEmail = $body['newEmail'];
$fechaNacimiento = $body['date'];
$gender = $body['gender'];

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_UpdateUserInfo(:newEmail, :oldEmail, :nombre, :apellido, :fechaNacimiento, :gender)';
            $insert = $db->query($query, [
                'nombre' =>$nombre,
                'newEmail' => $newEmail,
                'oldEmail' => $oldEmail,
                'apellido' => $apellido,
                'fechaNacimiento' => $fechaNacimiento,
                'gender' => $gender,
            ]);
    
        $_SESSION['email'] = $newEmail;

        unset($nombre);
        unset($apellido);
        unset($oldEmail);
        unset($newEmail);
        unset($fechaNacimiento);
        unset($gender);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Usuario Actualizado';

        echo json_encode($response);
        return;
    } else {
        header('HTTP/1.1 400');

        $response["success"] = false;
        $response["errors"] = $errors;
        $response["msg"] = 'Error al actualizar!';
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