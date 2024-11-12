<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');

if(!$json){
    $response["msg"] = 'Informacion vacía';
    echo json_encode($response);
    return;
}

if(!isset($_SESSION['id'])){
    $response["msg"] = 'Sesion no iniciada';
    echo json_encode($response);
return;
}

$body = json_decode($json, true);

    $idUsuario1 = $_SESSION['id'];
    $idUsuario2 = $body['idUsuario2'];
    $mensaje = $body['mensaje'];

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_Message(:instruccion, :idUsuario1, :idUsuario2, :mensaje)';
            $insert = $db->query($query, [
                'instruccion' => 'SEND',
                'idUsuario1' => $idUsuario1,
                'idUsuario2' => $idUsuario2,
                'mensaje' => $mensaje,
            ]);

        unset($idUsuario1);
        unset($idUsuario2);
        unset($mensaje);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Mensaje creado correctamente';

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