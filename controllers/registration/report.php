<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');
$json = file_get_contents("php://input");


$rol = $_GET['rol'];

try{
    if(empty($errors)){

        $data = null;

        if($rol == 0){
            $query = 'CALL sp_User(:instruccion, null, null, null)';
            $respuesta = $db->query($query, [
                'instruccion' => 'GET_STUDENTS',
            ])->get();

            $data = $respuesta;

        } else if ($rol == 1){
            $query = 'CALL sp_User(:instruccion, null, null, null)';
            $respuesta = $db->query($query, [
                'instruccion' => 'GET_INSTRUCTORS',
            ])->get();     

            $data = $respuesta;       
        }
           
        $response["data"] = $data;
        $response["msg"] = 'Se cargó correctamente la informacion';

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