<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$errors = array();
$idCurso = $_GET['id'];

try{
    if(empty($errors)){

        //Busqueda de curso
        $query = 'CALL sp_Course(:instruccion, :idUsuario, :idCurso, null, null, null, null, null, null, null, null, null, null, null, null)';
        $course = $db->query($query, [
             'instruccion' => 'BOUGHT_COURSE',
             'idCurso' => $idCurso,
             'idUsuario' => $_SESSION['id'],
            ])->find();

      
        $query = 'CALL sp_Level(:instruccion, null, :idCurso, null, null, null, null, null, null, null, null)';
        $levels = $db->query($query, [
            'instruccion' => 'SELECT',
            'idCurso' => $idCurso,
        ])->get();

            
        $course['foto'] = base64_encode($course['foto']);

        unset($idCurso);
        $data['curso'] = $course;
        $data['niveles'] = $levels;

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'hola!';
        $response['data'] = $data;

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