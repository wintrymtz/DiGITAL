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

    $idCreador = $_SESSION['id'];
    $nombre = $body['nombre'];
    $descripcion = $body['descripcion'];

$Instruccion = 'INSERT';

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_Category(:instruccion, null, null, :idCreador, :nombre, :descripcion)';
            $insert = $db->query($query, [
                'instruccion' => $Instruccion,
                'idCreador' => $idCreador,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
            ]);
    

        unset($Instruccion);
        unset($idCreador);
        unset($nombre);
        unset($descripcion);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Categoría creada correctamente!';

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