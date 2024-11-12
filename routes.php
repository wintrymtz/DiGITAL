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

    '/manejarPerfil' => 'controllers/manejarPerfil.php',
    '/session/getSession' => 'controllers/session/getSession.php',

    
    '/subirCurso' => 'controllers/subirCurso.php',
    '/subirCurso/create' => 'controllers/courses/create.php',
    '/courses/show' => 'controllers/courses/show.php',
    '/courses/get' => 'controllers/courses/getCourse.php',
    '/courses/buyCourse' => 'controllers/courses/buyCourse.php',
    '/courses/kardex' => 'controllers/courses/showMine.php',
    
    '/levels/get' => 'controllers/levels/show.php',

    '/kardex' => 'controllers/kardex.php',
    '/ventasGeneral' => 'controllers/ventasGeneral.php',
    '/ventasCurso' => 'controllers/ventasCurso.php',
    '/verCurso' => 'controllers/verCurso.php',

    '/administrador' => 'controllers/administrador.php',
    '/admin/category/store' => 'controllers/categories/store.php',
    '/admin/category/getAll' => 'controllers/categories/show.php',
    '/admin/category/update' => 'controllers/categories/update.php',

    '/buscar' => 'controllers/buscar.php',
    '/comprarCurso' => 'controllers/comprarCurso.php',
    '/confirmarCompra' => 'controllers/confirmarCompra.php',
    
    '/chat' => 'controllers/chat.php',
    '/message/send' => 'controllers/chats/store.php',
    '/message/get' => 'controllers/chats/show.php',
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