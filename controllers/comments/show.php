<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');


$json = file_get_contents('php://input');

$body = json_decode($json, true);

$idCurso = $_GET['id'];

$errors = array();


try{
    if(empty($errors)){
        
            $query = 'CALL sp_Course(:instruccion, null, :idCurso, null, null, null, null, null, null, null, null, null, null, null, null)';
            $insert = $db->query($query, [
                'instruccion' => 'GET_COMMENTS',
                'idCurso' => $idCurso,
            ])->get();



        unset($idCurso);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["data"] = $insert;
        $response["msg"] = 'Se cargaron los comentarios correctamente!';

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