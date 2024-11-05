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

// if(!isset($_SESSION['id'])){
//     $response["msg"] = 'Sesion no iniciada';
//     echo json_encode($response);
// return;
// }

$body = json_decode($json, true);

    $idInstructor = $_SESSION['id'];
    $nombre = $_POST['nombre'];
    $cantNiveles = $_POST['cantNiveles'];
    $costo = $_POST['costo'];
    $descripcion = $_POST['descripcion'];
    $categorias = $_POST['categorias'];

    if($_POST['PorNivel'] === 'true'){
        $PorNivel = 1;
        $costoNivel = $_POST['costoNivel'];
    } else{
        $PorNivel =0;
        $costoNivel = null;
    }
    $foto = null;

    //NIVELES
    $nombreNiveles = $_POST['nombreNiveles'];

$Instruccion = 'INSERT';

$errors = array();

try{
    if(empty($errors)){
        
        //Creamos el curso en su respectiva tabla
            $query = 'CALL sp_Course(:instruccion, :idInstructor, null, :nombre, :cantidadNiveles, :costo, :descripcion, :foto, :PorNivel, null, null)';
            $insert = $db->query($query, [
                'instruccion' => $Instruccion,
                'idInstructor' => $idInstructor,
                'nombre' => $nombre,
                'cantidadNiveles' => $cantNiveles,
                'costo' => $costo,
                'descripcion' => $descripcion,
                'foto' => $foto,
                'PorNivel' => $PorNivel,
            ])->find(); //obtiene el id del curso creado

            //Referenciamos las categorías seleccionadas con el curso creado
            foreach($categorias as $categoria){
                $query2 = 'CALL sp_Category(:instruccion, :idCurso, :idCategoria, null, null, null)';
                $insert2 = $db->query($query2, [
                    'instruccion' => 'ADD',
                    'idCategoria' => $categoria,
                    'idCurso' => $insert['idCurso'],
                ]);
            }

            $i = 0;
             //Referenciamos los niveles creados con el curso creado
             foreach($nombreNiveles as $nombreNivel){
                $i = $i + 1;
                $query3 = 'CALL sp_Level(:instruccion, null, :idCurso, :nombre, :numero, :costo)';
                $insert3 = $db->query($query3, [
                    'instruccion' => 'INSERT',
                    'idCurso' => $insert['idCurso'],
                    'nombre' => $nombreNivel,
                    'numero' => $i,
                    'costo' => $costoNivel,
                ]);
            }


        unset($Instruccion);
        unset($idInstructor);
        unset($nombre);
        unset($cantNiveles);
        unset($costo);
        unset($descripcion);
        unset($PorNivel);
        unset($categorias);

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Curso creado correctamente!';
        $response['data'] = $insert2;

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