<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');
$json = file_get_contents("php://input");

if(!isset($_FILES['image'])){
    $response = [];
    $response["success"] = false;
    $response["msg"] = 'ERROR DE ARCHIVO';
    echo json_encode($response);
    return;
}

// @list(, , $imtype, ) = getimagesize($_FILES['']['tmp_name']);

// $errors = array();

// if ($imtype == 3) // cheking image type
// $ext="png";   // to use it later in HTTP headers
// elseif ($imtype == 2)
// $ext="jpeg";
// elseif ($imtype == 1)
// $ext="gif";
// elseif ($imtype == 6)
// $ext="bmp";
// else
// $msg = 'Error: unknown file format';

//     if (!isset($msg)) // If there was no error
//       {
          
//       }

// echo json_encode($_FILES['image']);
// return;



try{
    if(empty($errors)){

        $data = file_get_contents($_FILES['image']['tmp_name']);
        $mimeType = $_FILES['image']['type'];
        
            $query = 'CALL sp_User(:instruccion, :idUsuario, :foto, :mimeType)';
            $insert = $db->query($query, [
                'instruccion' => 'UPDATE_IMAGE',
                'idUsuario' => 1,
                'foto' => $data,
                'mimeType' => $mimeType
            ]);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response['img'] = base64_encode($data);
        $response["msg"] = 'Se actualizó correctamente la imagen';

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