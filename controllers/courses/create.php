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
$descripcion = $_POST['descripcion'];
$categorias = $_POST['categorias'];

if($_POST['PorNivel'] === 'true'){
    $PorNivel = 1;
    $costoNiveles = $_POST['precioNiveles'];
    $costo = 0;
} else{
    $PorNivel = 0;
    $costoNiveles = null;
    $costo = $_POST['costo'];
}

//imagen del curso
$data = file_get_contents($_FILES['image']['tmp_name']);
$mimeType = $_FILES['image']['type'];

//NIVELES
$nombreNiveles = $_POST['nombreNiveles'];

$archivosNiveles = $_FILES['archivosNiveles'];

$Instruccion = 'INSERT';
$errors = array();

try{
    if(empty($errors)){
        
        //Creamos el curso en su respectiva tabla
            $query = 'CALL sp_Course(:instruccion, :idInstructor, null, :nombre, :cantidadNiveles, :costo, :descripcion, :foto, :mimetype, :PorNivel, null, null, null)';
            $insert = $db->query($query, [
                'instruccion' => $Instruccion,
                'idInstructor' => $idInstructor,
                'nombre' => $nombre,
                'cantidadNiveles' => $cantNiveles,
                'costo' => $costo,
                'descripcion' => $descripcion,
                'foto' => $data,
                'mimetype' => $mimeType,
                'PorNivel' => $PorNivel,
            ])->find(); //obtiene el id del curso creado

            //Referenciamos las categorías seleccionadas con el curso creado
            foreach($categorias as $categoria){
                $query2 = 'CALL sp_Category(:instruccion, :idCurso, :idCategoria, null, null, null)';
                $level = $db->query($query2, [
                    'instruccion' => 'ADD',
                    'idCategoria' => $categoria,
                    'idCurso' => $insert['idCurso'],
                ]);
            }
            
            $i = 0;
             //Referenciamos los niveles creados con el curso creado
             foreach($nombreNiveles as $nombreNivel){
                if($PorNivel===1){
                    $costoIndividual = $costoNiveles[$i];
                } else{
                    $costoIndividual = null;
                }

                $i = $i + 1;
                $query3 = 'CALL sp_Level(:instruccion, null, :idCurso, :nombre, :numero, :costo, null, null, null, null, null)';
                $insert3 = $db->query($query3, [
                    'instruccion' => 'INSERT',
                    'idCurso' => $insert['idCurso'],
                    'nombre' => $nombreNivel,
                    'numero' => $i,
                    'costo' => $costoIndividual,
                ])->find(); //obtiene el id del nivel creador

                $files = $archivosNiveles['tmp_name'][$i - 1];

                $j = 0;
                foreach($files as $file){

                    $data = file_get_contents($file);
                    $mimeType = $archivosNiveles['type'][$i-1][$j];
                    $name = $archivosNiveles['name'][$i-1][$j];

                    $videoPath = null;

                    $query4 = 'CALL sp_Level(:instruccion, :idNivel, null, :nombreArchivo, null, null, :archivo, :mimeType, :videoPath, null, null)';
                    $insert4 = $db->query($query4, [
                        'instruccion' => 'ADD_FILE',
                        'idNivel' => $insert3['idNivel'],
                        'archivo' => $data,
                        'mimeType' => $mimeType,
                        'videoPath' => $videoPath,
                        'nombreArchivo' => $name,
                    ]);

                    $j = $j + 1;
                }
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
        $response['data'] = 0;
        // $response['data'] = $archivosNiveles['tmp_name'][1][0];
        //                                     //propiedad [nivelIndex] [archivo index]

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