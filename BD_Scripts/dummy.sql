 
 CALL sp_RegisterUser('admin@gmail.com', 'nombre del administrador', 'apellido del administrador', '123', '1');
CALL sp_RegisterUser('estudiante@gmail.com', 'nombre del estudiante', 'apellido del estudiante', '123', '2');
CALL sp_RegisterUser('estudiante2@gmail.com', 'nombre2', 'apellido2', '123', '2');
 CALL sp_RegisterUser('instructor@gmail.com', 'nombre del instructor', 'apellido del instructor', '123', '3');

 CALL sp_Level('BOUGHT_LEVELS', null, 76, null, null, null, null, null, null, 3, null);
CALL sp_Category('SELECT_FROM_COURSE', 1, null, null, null, null);
