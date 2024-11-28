<?php

// return [
//    '/' => 'controllers/index.php',
//     '/iniciarSesion' => 'controllers/registration/iniciarSesion.php',

//     '/registrarse' => 'controllers/registration/registrarse.php',
//     '/registrarse/store' => 'controllers/registration/store.php',
//     '/registrarse/login' => 'controllers/registration/login.php',
//     '/registrarse/show' => 'controllers/registration/show.php',
//     '/registrarse/update-info' => 'controllers/registration/update.php',
//     '/registrarse/update-password' => 'controllers/registration/updatePassword.php',

//     '/user/update-photo' => 'controllers/registration/updateImage.php',
//     '/user/change-status' => 'controllers/registration/changeStatus.php',

//     '/manejarPerfil' => 'controllers/manejarPerfil.php',
//     '/session/getSession' => 'controllers/session/getSession.php',

    
//     '/subirCurso' => 'controllers/subirCurso.php',
//     '/subirCurso/create' => 'controllers/courses/create.php',
//     '/editarCurso' => 'controllers/editarCurso.php',

//     '/courses/show' => 'controllers/courses/show.php',
//     '/courses/show-specials' => 'controllers/courses/getSpecials.php',
//     '/courses/update' => 'controllers/courses/update.php',

//     '/courses/get' => 'controllers/courses/getCourse.php',
//     '/courses/getBought' => 'controllers/courses/getBoughtCourse.php',
//     '/courses/buyCourse' => 'controllers/courses/buyCourse.php',
//     '/courses/kardex' => 'controllers/courses/showMine.php',
//     '/courses/disable' => 'controllers/courses/disable.php',

//     '/courses/show-created' => 'controllers/courses/showCreated.php',
//     '/courses/show-one-created' => 'controllers/courses/showOneCreated.php',
    
//     '/levels/get' => 'controllers/levels/show.php',
//     '/levels/completeLevel' => 'controllers/levels/complete.php',

//     '/kardex' => 'controllers/kardex.php',
//     '/ventasGeneral' => 'controllers/ventasGeneral.php',
//     '/ventasCurso' => 'controllers/ventasCurso.php',
//     '/verCurso' => 'controllers/verCurso.php',
//     '/calificarCurso' => 'controllers/calificarCurso.php',

//     '/administrador' => 'controllers/administrador.php',
//     '/admin/category/store' => 'controllers/categories/store.php',
//     '/admin/category/getAll' => 'controllers/categories/show.php',
//     '/admin/category/update' => 'controllers/categories/update.php',
//     '/admin/category/delete' => 'controllers/categories/delete.php',

//     '/admin/user/getUsers' => 'controllers/registration/report.php',

//     '/buscar' => 'controllers/buscar.php',
//     '/comprarCurso' => 'controllers/comprarCurso.php',
//     '/confirmarCompra' => 'controllers/confirmarCompra.php',
    
//     '/chat' => 'controllers/chat.php',
//     '/message/send' => 'controllers/chats/store.php',
//     '/message/get' => 'controllers/chats/show.php',

//     '/comments/create' => 'controllers/comments/create.php',
//     '/comments/getAll' => 'controllers/comments/show.php',
//     '/comments/delete' => 'controllers/comments/delete.php',

//     '/courses-certificate' => 'controllers/courses/certificate.php',


// ];


$router->add('/', 'controllers/index.php');
$router->add('/iniciarSesion','controllers/registration/iniciarSesion.php');

$router->add('/registrarse' , 'controllers/registration/registrarse.php');//vista
$router->add('/registrarse/store' , 'controllers/registration/store.php');
$router->add('/registrarse/login' , 'controllers/registration/login.php');
$router->add('/registrarse/show' , 'controllers/registration/show.php');
$router->add('/registrarse/update-info' , 'controllers/registration/update.php');
$router->add('/registrarse/update-password' , 'controllers/registration/updatePassword.php');

$router->add('/user/update-photo' , 'controllers/registration/updateImage.php');
$router->add('/user/change-status' , 'controllers/registration/changeStatus.php');

$router->add('/manejarPerfil' , 'controllers/manejarPerfil.php');
$router->add('/session/getSession' , 'controllers/session/getSession.php');

$router->add('/subirCurso' , 'controllers/subirCurso.php')->only('instructor');
$router->add('/subirCurso/create' , 'controllers/courses/create.php');
$router->add('/editarCurso', 'controllers/editarCurso.php')->only('instructor');

$router->add('/courses/show' , 'controllers/courses/show.php');
$router->add('/courses/show-specials' ,'controllers/courses/getSpecials.php');
$router->add('/courses/update' , 'controllers/courses/update.php');

$router->add('/courses/get' , 'controllers/courses/getCourse.php');
$router->add('/courses/getBought' , 'controllers/courses/getBoughtCourse.php');
$router->add('/courses/buyCourse' , 'controllers/courses/buyCourse.php');
$router->add('/courses/kardex' , 'controllers/courses/showMine.php');
$router->add('/courses/disable' , 'controllers/courses/disable.php');

$router->add('/courses/show-created' , 'controllers/courses/showCreated.php');
$router->add('/courses/show-one-created' , 'controllers/courses/showOneCreated.php');

$router->add('/levels/get' , 'controllers/levels/show.php');
$router->add('/levels/completeLevel' , 'controllers/levels/complete.php');

$router->add('/kardex' , 'controllers/kardex.php')->only('student'); //vista
$router->add('/ventasGeneral' , 'controllers/ventasGeneral.php')->only('instructor');
$router->add('/ventasCurso', 'controllers/ventasCurso.php')->only('instructor');
$router->add('/verCurso' , 'controllers/verCurso.php')->only('student');
$router->add('/calificarCurso' , 'controllers/calificarCurso.php')->only('student');

$router->add('/administrador' , 'controllers/administrador.php')->only('admin'); //vista
$router->add('/admin/category/store' , 'controllers/categories/store.php');
$router->add('/admin/category/getAll' , 'controllers/categories/show.php');
$router->add('/admin/category/update', 'controllers/categories/update.php');
$router->add('/admin/category/delete' , 'controllers/categories/delete.php');

$router->add('/admin/user/getUsers', 'controllers/registration/report.php');

$router->add('/buscar', 'controllers/buscar.php');
$router->add('/comprarCurso', 'controllers/comprarCurso.php');
$router->add('/confirmarCompra', 'controllers/confirmarCompra.php')->only('student');

$router->add('/chat', 'controllers/chat.php');
$router->add('/message/send', 'controllers/chats/store.php');
$router->add('/message/get', 'controllers/chats/show.php');

$router->add('/comments/create', 'controllers/comments/create.php');
$router->add('/comments/getAll', 'controllers/comments/show.php');
$router->add('/comments/delete', 'controllers/comments/delete.php');

$router->add('/courses-certificate', 'controllers/courses/certificate.php')->only('student');




// $router->get( '/',  'controllers/index.php');

// $router->get('/iniciarSesion', 'controllers/iniciarSesion.php');
// $router->get('/registrarse', 'controllers/registration/registrarse.php');

// $router->get('/kardex', 'controllers/kardex.php');
// $router->get('/manejarPerfil', 'controllers/manejarPerfil.php');

// $router->get('/subirCurso', 'controllers/subirCurso.php');
// $router->get('/ventasGeneral', 'controllers/ventasGeneral.php');
// $router->get('/ventasCurso', 'controllers/ventasCurso.php');

// $router->get('/buscar', 'controllers/buscar.php');
// $router->get('/verCurso', 'controllers/verCurso.php');

// $router->get('/comprarCurso', 'controllers/comprarCurso.php');
// $router->get('/confirmarCompra', 'controllers/confirmarCompra.php');

// $router->get('/chat', 'controllers/chat.php');

// $router->get('/administrador', 'controllers/administrador.php');