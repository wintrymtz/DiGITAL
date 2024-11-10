<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');



// if(!isset($_SESSION['id'])){
//     $response["msg"] = 'Sesion no iniciada';
//     echo json_encode($response);
// return;
// }

$body = json_decode($json, true);

if(!isset($body['idCurso'])){
    $response["msg"] = 'Informacion vacía';
    echo json_encode($response);
    return;
}


$idUsuario = $_SESSION['id'];

$idCurso = $body['idCurso'];


$pago = $body['pago'];

$metodoPago = $body['metodoPago'];

$nivelesId = $body['nivelesId'];


$nivelesPago = $body['nivelesCostos'];

$errors = array();

try{
    if(empty($errors)){

        //Creamos el curso en su respectiva tabla
        $query = 'CALL sp_Course(:instruccion, :idUsuario, :idCurso, null, null, :pago, null, null, null, null, null, null, :metodoPago)';
        $buyCourse = $db->query($query, [
            'instruccion' => 'BUY_COURSE',
            'idUsuario' => $idUsuario,
            'idCurso' => $idCurso,
            'pago' => $pago,
            'metodoPago' => $metodoPago,
        ])->find();

        $levelsMsg =[];
        $j =0;
        foreach($nivelesId as $nivelId){

                $pago = null;
                if(!empty($nivelesPago)){
                    $pago = $nivelesPago[$j];
                }


                $query = 'CALL sp_Level(:instruccion, :idNivel, null, null, null, :pago, null, null, null, :idUsuario, :metodoPago)';
                $buyLevels = $db->query($query, [
                'instruccion' => 'BUY_LEVEL',
                'idUsuario' => $idUsuario,
                'idNivel' => $nivelId,
                'pago' => $pago,
                'metodoPago' => $metodoPago,
            ])->find();
    
                $levelsMsg[] = $buyLevels;
                $j = $j +1;
        }

       

        // if($nivelesId = $_POST['nivelesId'])

        // foreach($nivelesId as )
        
        unset($idUsuario);
        unset($idCurso);
        unset($pago);
        unset($metodoPago);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Curso comprado correctamente!';
        $response["bd_msg_curso"] = $buyCourse;
        $response["bd_msg_niveles"] = $levelsMsg;
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