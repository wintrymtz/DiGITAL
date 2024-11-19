<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');

if(!isset($_SESSION['id'])){
    $response["msg"] = 'Sesion no iniciada';
    echo json_encode($response);
return;
}

$body = json_decode($json, true);

 $idCategoria =  $_GET['id'];


$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_Category(:instruccion, null, :idCategoria, null, null, null)';
            $insert = $db->query($query, [
                'instruccion' => 'DELETE',
                'idCategoria' => $idCategoria,
            ]);
    
        unset($idCategoria);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Categoría eliminada correctamente!';

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