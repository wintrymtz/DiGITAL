<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$email = $body['email'];

$errors = array();
try{
    if(empty($errors)){

        $query = 'CALL sp_getPersonalInfo(:email)';
        $user = $db->query($query, [
            'email' => $email,
        ])->find();

        unset($email);

        //Guardar datos y mandarlos de vuelta en la respuesta

        if($user){
            $response = [];
            $response["success"] = true;
            $response["errors"] = [];
            $response['data'] = $user;
            $response["msg"] = 'Sesion iniciada correctamente';
            echo json_encode($response);
            return;
        } else{
            header('HTTP/1.1 404');
            
            $response = [];
            $response["success"] = false;
            $response["errors"] = [];
            $response["msg"] = 'Usuario no encontrado, error de sesión';
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