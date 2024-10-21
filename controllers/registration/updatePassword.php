<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$email = $body['email'];
$oldPassword = $body['oldPassword'];
$newPassword = $body['newPassword'];

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_UpdateUserPassword(:oldPassword, :newPassword, :email)';
            $insert = $db->query($query, [
                'newPassword' => $newPassword,
                'oldPassword' => $oldPassword,
                'email' => $email,
            ])->find();
    
        unset($oldPassword);
        unset($newPassword);
        unset($email);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = $insert;

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