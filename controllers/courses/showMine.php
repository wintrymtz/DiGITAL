<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$errors = array();
$idUsuario = $_SESSION['id'];

try{
    if(empty($errors)){

        //Busqueda de curso
        $query = 'CALL sp_Course(:instruccion, :idUsuario, null, null, null, null, null, null, null, null, null, null, null)';
        $courses = $db->query($query, [
             'instruccion' => 'KARDEX',
             'idUsuario' => $idUsuario,
            ])->get();


        unset($idUsuario);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Cursos cagados correctamente';
        $response['data'] = $courses;

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