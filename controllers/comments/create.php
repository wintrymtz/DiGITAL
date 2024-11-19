<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');


$json = file_get_contents('php://input');
$body = json_decode($json, true);


if(!isset($body['comentario'])){
    $response["msg"] = 'Informacion vacía';
    echo json_encode($response);
    return;
}

if(!isset($_SESSION['id'])){
    $response["msg"] = 'Sesion no iniciada';
    echo json_encode($response);
return;
}


$idUsuario = $_SESSION['id'];
$comentario = $body['comentario'];
$idCurso = $body['idCurso'];
$calif = $body['calificacion'];

$errors = array();


try{
    if(empty($errors)){
        
        //Almacenamos el comentario
            $query = 'CALL sp_Course(:instruccion, :idUsuario, :idCurso, null, null, null, null, null, null, null, null, null, null, :comentario, null)';
            $insert = $db->query($query, [
                'instruccion' => 'COMMENT',
                'idUsuario' => $idUsuario,
                'comentario' => $comentario,
                'idCurso' => $idCurso,
            ]);

        //Almacenamos calificacion
        $query = 'CALL sp_Course(:instruccion, :idUsuario, :idCurso, null, :calif, null, null, null, null, null, null, null, null, null, null)';
        $insert = $db->query($query, [
            'instruccion' => 'RATE',
            'idUsuario' => $idUsuario,
            'calif' => $calif,
            'idCurso' => $idCurso,
        ]);


        unset($idUsuario);
        unset($comentario);
        unset($idCurso);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Se publicó el comentario correctamente!';

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