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

    $idCategoria =  $body['idCategoria'];
    $nombre = $body['nombre'];
    $descripcion = $body['descripcion'];

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_Category(:instruccion, null, :idCategoria, null, :nombre, :descripcion)';
            $insert = $db->query($query, [
                'instruccion' => 'UPDATE',
                'idCategoria' => $idCategoria,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
            ]);
    
        unset($idCategoria);
        unset($nombre);
        unset($descripcion);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Categoría actualizada correctamente!';

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