<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');


$json = file_get_contents('php://input');
$body = json_decode($json, true);

if(!isset($_SESSION['id'])){
    $response["msg"] = 'Sesion no iniciada';
    echo json_encode($response);
return;
}


$idUsuario = $body['idUsuario'];
$newStatus = $body['status'];

$errors = array();



try{
    if(empty($errors)){

        $instruccion = "";
        if($newStatus == false){
            $instruccion = "DELETE";
        } else{
            $instruccion = "ENABLE";
        }
        


        //Modificamos status
            $query = 'CALL sp_User(:instruccion, :idUsuario, null, null)';
            $insert = $db->query($query, [
                'instruccion' => $instruccion,
                'idUsuario' => $idUsuario,
            ]);

            $response["msg"] = $body;
            echo json_encode($response);
            return;

        unset($instruccion);
        unset($idUsuario);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Se cambió el estatus del usuario correctamente!';

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