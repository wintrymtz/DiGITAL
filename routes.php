<?php

return [
   '/' => 'controllers/index.php',
    '/iniciarSesion' => 'controllers/registration/iniciarSesion.php',

    '/registrarse' => 'controllers/registration/registrarse.php',
    '/registrarse/store' => 'controllers/registration/store.php',
    '/registrarse/login' => 'controllers/registration/login.php',
    '/registrarse/show' => 'controllers/registration/show.php',
    '/registrarse/update-info' => 'controllers/registration/update.php',
    '/registrarse/update-password' => 'controllers/registration/updatePassword.php',

    '/user/update-photo' => 'controllers/registration/updateImage.php',
    '/user/change-status' => 'controllers/registration/changeStatus.php',

    '/manejarPerfil' => 'controllers/manejarPerfil.php',
    '/session/getSession' => 'controllers/session/getSession.php',

    
    '/subirCurso' => 'controllers/subirCurso.php',
    '/subirCurso/create' => 'controllers/courses/create.php',
    '/editarCurso' => 'controllers/editarCurso.php',

    '/courses/show' => 'controllers/courses/show.php',
    '/courses/show-specials' => 'controllers/courses/getSpecials.php',
    '/courses/update' => 'controllers/courses/update.php',

    '/courses/get' => 'controllers/courses/getCourse.php',
    '/courses/getBought' => 'controllers/courses/getBoughtCourse.php',
    '/courses/buyCourse' => 'controllers/courses/buyCourse.php',
    '/courses/kardex' => 'controllers/courses/showMine.php',
    '/courses/disable' => 'controllers/courses/disable.php',

    '/courses/show-created' => 'controllers/courses/showCreated.php',
    '/courses/show-one-created' => 'controllers/courses/showOneCreated.php',
    
    '/levels/get' => 'controllers/levels/show.php',
    '/levels/completeLevel' => 'controllers/levels/complete.php',

    '/kardex' => 'controllers/kardex.php',
    '/ventasGeneral' => 'controllers/ventasGeneral.php',
    '/ventasCurso' => 'controllers/ventasCurso.php',
    '/verCurso' => 'controllers/verCurso.php',
    '/calificarCurso' => 'controllers/calificarCurso.php',

    '/administrador' => 'controllers/administrador.php',
    '/admin/category/store' => 'controllers/categories/store.php',
    '/admin/category/getAll' => 'controllers/categories/show.php',
    '/admin/category/update' => 'controllers/categories/update.php',
    '/admin/category/delete' => 'controllers/categories/delete.php',

    '/admin/user/getUsers' => 'controllers/registration/report.php',

    '/buscar' => 'controllers/buscar.php',
    '/comprarCurso' => 'controllers/comprarCurso.php',
    '/confirmarCompra' => 'controllers/confirmarCompra.php',
    
    '/chat' => 'controllers/chat.php',
    '/message/send' => 'controllers/chats/store.php',
    '/message/get' => 'controllers/chats/show.php',

    '/comments/create' => 'controllers/comments/create.php',
    '/comments/getAll' => 'controllers/comments/show.php',
    '/comments/delete' => 'controllers/comments/delete.php',

    '/courses-certificate' => 'controllers/courses/certificate.php',


];

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