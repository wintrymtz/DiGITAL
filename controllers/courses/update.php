<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');


$json = file_get_contents('php://input');


if(!isset($_POST['nombre'])){
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

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$idCurso = $_POST['idCurso'];

$Instruccion = 'UPDATE';
$errors = array();


try{
    if(empty($errors)){
        
        //Creamos el curso en su respectiva tabla                                       
            $query = 'CALL sp_Course(:instruccion, null, :idCurso, :nombre, null, null, :descripcion, null, null, null, null, null, null, null, null)';
            $insert = $db->query($query, [
                'instruccion' => $Instruccion,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'idCurso' => $idCurso
            ]); 


        unset($Instruccion);
        unset($idInstructor);
        unset($nombre);
        unset($descripcion);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Curso actualizado correctamente!';

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