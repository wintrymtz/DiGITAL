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

$idAdmin = $_SESSION['id'];
$idComentario = $body['idComentario'];
$idCurso = $body['idCurso'];
$causa = $body['causa'];

$errors = array();

try{
    if(empty($errors)){
        
            $query = 'CALL sp_Course(:instruccion, :idComentario, :idCurso, null, null, null, null, null, null, null, null, :causa, null, null, :idAdmin)';
            $insert = $db->query($query, [
                'instruccion' => 'DELETE_COMMENT',
                'idAdmin' => $idAdmin,
                'idComentario' => $idComentario,
                'idCurso' => $idCurso,
                'causa' => $causa,
            ]);

        unset($idAdmin);
        unset($idComentario);
        unset($idCurso);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Se dió de baja el comentario correctamente!';

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