<?php

$config = require './config.php';
$db = new Database($config['database']);

header('Content-type: application/json');

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$errors = array();

try{
    if(empty($errors)){
       
        
        //Busqueda de cursos mas vistos
        $query = 'CALL sp_Course(:instruccion, null, null, null, null, null, null, null, null, null, null, null, null, null, null)';
        $courses1 = $db->query($query, [
                 'instruccion' => 'S_SELL'
        ])->get();

        $query = 'CALL sp_Course(:instruccion, null, null, null, null, null, null, null, null, null, null, null, null, null, null)';
        $courses2 = $db->query($query, [
                 'instruccion' => 'S_RATED'
        ])->get();

        $query = 'CALL sp_Course(:instruccion, null, null, null, null, null, null, null, null, null, null, null, null, null, null)';
        $courses3 = $db->query($query, [
                 'instruccion' => 'S_RECENT'
        ])->get();

    

        foreach($courses1 as &$course){
        //     $categorias=[];
        //     $query2 ='CALL sp_Category(:instruccion, :idCurso, null, null, null, null)';
        //     $categories = $db->query($query2, [
        //         'instruccion' => 'SELECT_FROM_COURSE',
        //         'idCurso' => $course['idCurso']
        //    ])->get();

        //    foreach($categories as $category){
        //     $categorias[] = $category;
        //    }

        //    $course['categorias'] = $categorias;
           $course['foto'] = base64_encode($course['foto']);
        }

        foreach($courses2 as &$course){
               $course['foto'] = base64_encode($course['foto']);
        }
        foreach($courses3 as &$course){
            $course['foto'] = base64_encode($course['foto']);
     }

        $response = [];
        $response["success"] = true;
        $response["errors"] = [];
        $response["msg"] = 'Cursos cargados correctamente!';
        $response['vendidos'] = $courses1;
        $response['calificacion'] = $courses2;
        $response['recientes'] = $courses3;

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