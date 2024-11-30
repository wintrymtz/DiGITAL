
-- Storage Procedures

DELIMITER //
CREATE PROCEDURE sp_ValidateUser(
in _email varchar(200),
in _pass varchar(50))
BEGIN

DECLARE existeUsuario int;
DECLARE validacion int;
DECLARE _intentos int;
SET existeUsuario = 0;
SET validacion = 0;
SET _intentos = 0;

SELECT COUNT(idUsuario) INTO existeUsuario FROM Usuario
						WHERE _email = Usuario.email AND
                        Usuario.estado = true;

IF existeUsuario = 1 THEN
		SELECT COUNT(idUsuario) INTO validacion FROM Usuario
						WHERE _email = Usuario.email AND 
						BINARY  Usuario.pass =  _pass AND
						Usuario.estado = true;
		IF validacion = 1 THEN
			UPDATE Usuario SET intentos = 0 WHERE  _email = Usuario.email;
            SELECT idUsuario, rol, foto, mimeType, nombre, apellido, email FROM Usuario
							WHERE _email = Usuario.email AND 
							BINARY  Usuario.pass =  _pass AND
							Usuario.estado = true;
        ELSE
			UPDATE Usuario SET intentos = intentos +1 WHERE  _email = Usuario.email;
			SELECT intentos INTO _intentos FROM Usuario WHERE  _email = Usuario.email;
            IF _intentos = 3 THEN
			UPDATE Usuario SET intentos = 0, estado = false WHERE  _email = Usuario.email;
			END IF;
        END IF;
END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_getPersonalInfo(
in _email varchar(200)
)
BEGIN
SELECT nombre, email, apellido, genero, fechaNacimiento, foto, rol FROM vista_personalInfo WHERE _email = email;
END//
DELIMITER ;

 DELIMITER //
 CREATE PROCEDURE sp_RegisterUser(
 in _email varchar(200),
 in _nombre varchar(50),
 in _apellido varchar(50),
 in _pass varchar(50),
 in _rol enum('administrador',
 'estudiante', 'instructor'))
 BEGIN
 INSERT INTO Usuario(email, nombre, apellido, pass, rol) 
 VALUES (_email, _nombre, _apellido, _pass, _rol);
 END//
 DELIMITER ;

 DELIMITER //
CREATE PROCEDURE sp_UpdateUserInfo(
in _newEmail varchar(200),
in _oldEmail varchar(200),
in _nombre varchar(50),
in _apellido varchar(50),
in _fechaNacimiento date,
in _genero enum('hombre', 'mujer', 'otro')
)
BEGIN
UPDATE Usuario U
SET 
U.email = _newEmail,
U.nombre = _nombre,
U.apellido = _apellido,
U.fechaNacimiento = _fechaNacimiento,
U.genero = _genero
WHERE U.email = _oldEmail;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_UpdateUserPassword(
_oldPassword varchar(50),
_newPassword varchar(50),
_email varchar(200)
)
BEGIN
DECLARE result int;
DECLARE response varchar(100);

-- Verifica que exista el usuario
SELECT count(*) INTO result FROM Usuario U WHERE U.email = _email;
	IF result < 1 THEN SET response = 'Usuario no encontrado';
	ELSE
-- En caso de que si exista
	UPDATE Usuario U
	SET U.pass = _newPassword
	WHERE BINARY U.pass = _oldPassword AND U.email = _email;

-- Verificar que hubo alguna actualizacion
		IF ROW_COUNT() > 0 THEN
				SET response = 'Contraseña actualizada correctamente';
			ELSE
				SET response = 'Contraseña antigua incorrecta';
		END IF;
	END IF;
    SELECT response;
END//
DELIMITER ;

-- TABLA CURSOS (CREAR, BUSCAR)
DELIMITER //
CREATE PROCEDURE sp_Course(
IN _instruccion 			VARCHAR(20),
IN _idUsuario				INT UNSIGNED, -- instructor quien crea / estudiante que compra
IN _idCurso					INT UNSIGNED,
IN _nombre 					VARCHAR(80),
IN _cantidadNiveles			INT,		-- cantidad de niveles / calificacion	
IN _costo					DECIMAL(9, 2),	-- Cuanto cuesta / cuanto se pagó por él
IN _descripcion				VARCHAR(200),
IN _foto					mediumblob,
IN _mimetype				varchar(20),					
IN _PorNivel 				BOOL,				
IN _estado					BOOL,
IN _busqueda				VARCHAR(100), -- busqueda
IN _metodoPago				enum('paypal', 'creditCard', 'variado'),
IN _comentario				text,
IN _idUsuario2				INT UNSIGNED
)
BEGIN
    DECLARE v_idCurso INT UNSIGNED;
    DECLARE v_count INT;

	IF _instruccion = 'INSERT' THEN
    INSERT INTO Curso(idInstructor, nombre, cantidadNiveles, costo, descripcion, PorNivel, foto)
    VALUES (_idUsuario, _nombre, _cantidadNiveles, _costo, _descripcion, _PorNivel, _foto);
    SET v_idCurso = LAST_INSERT_ID();
    SELECT v_idCurso as idCurso;
    END IF;
    
     IF _instruccion = 'UPDATE' THEN
		UPDATE Curso 
        SET 
        nombre = _nombre,
        descripcion = _descripcion
        WHERE idCurso = _idCurso;
    END IF;
    
    IF _instruccion = 'SELECT' THEN
    SELECT c.idInstructor, CONCAT(u.nombre, ' ', u.apellido) as nombreInstructor,
			c.nombre, c.cantidadNiveles, c.costo, c.descripcion, c.PorNivel, c.estado,
            c.foto, c.calificacion, c.mimeType
			FROM Curso c
            INNER JOIN Usuario u ON u.idUsuario = c.idInstructor
            WHERE c.idCurso = _idCursO;
	END IF;    
    
    IF _instruccion = 'DISABLE' THEN
    UPDATE Curso SET estado = false WHERE idCurso = _idCurso;
    END IF;
    
    IF _instruccion = 'BOUGHT_COURSE' THEN
    SELECT cc.calificacion, cc.idUsuario, cc.progreso, c.idInstructor, CONCAT(u.nombre, ' ', u.apellido) as nombreInstructor, c.nombre, c.cantidadNiveles, c.costo, c.descripcion, c.PorNivel, c.estado, c.foto
			FROM Curso c
            INNER JOIN Usuario u ON u.idUsuario = c.idInstructor
			INNER JOIN CursoComprado cc ON c.idCurso = cc.idCurso
            WHERE c.idCurso = _idCurso AND cc.idUsuario = _idUsuario;
	UPDATE CursoComprado SET fechaUltimoIngreso = current_timestamp() WHERE idUsuario = _idUsuario AND idCurso = _idCurso;
    END IF;
    
    IF _instruccion = 'SEARCH' THEN
    SELECT c.idInstructor,
    u.nombre as nombreUsuario,
	c.idCurso,
    c.fechaCreacion,
    c.nombre as nombreCurso,
    c.costo,
    c.descripcion,
    c.foto,
    c.mimetype
			FROM Curso c 
            INNER JOIN Usuario u ON c.idInstructor = u.idUsuario
            WHERE c.nombre LIKE CONCAT('%',_busqueda, '%') AND c.estado = true;
    END IF;
    
	IF _instruccion = 'BUY_COURSE' THEN
    SELECT count(*) INTO v_count FROM cursoComprado cc WHERE cc.idUsuario = _idUsuario AND cc.idCurso = _idCurso;
    
    IF v_count > 0 THEN
		 SELECT 'Este curso ya había sido comprado' as respuesta;
		ELSE
			INSERT INTO  cursocomprado(idCurso, idUsuario, metodoPago, pago)
			VALUES (_idCurso, _idUsuario, _metodoPago, _costo);
		SELECT 'Compra exitosa' as respuesta;
        END IF;
    END IF;
    
    IF _instruccion='KARDEX' THEN
      SELECT
        Curso,
		idUsuario,
		idCurso,
		progreso,
		fechaUltimoIngreso,
		fechaInicio,
		fechaTerminado,
        nombreInstructor
		FROM vista_Kardex
        WHERE idUsuario = _idUsuario
        ORDER BY cc.fechaUltimoIngreso;
    END IF;
    
    IF _instruccion = 'I_ALL_C' THEN
    SELECT idCurso, fechaCreacion, Curso, AlumnosInscritos, promedio, ingresosPayPal, ingresosCreditCard, ingresosTotales, estado FROM vista_IngresosPorCurso
																								WHERE _idUsuario = idInstructor
                                                                                                GROUP BY 1;
    END IF;
    
	IF _instruccion = 'I_ONE_C' THEN
        SELECT idCurso, Alumno, idUsuario, FechaInscripcion, progreso,NivelAvance, PrecioPagado, metodoPago, ingresosTotales FROM vista_DetalleAlumnosPorCurso
				WHERE idCurso = _idCurso;
    END IF;
    
    IF _instruccion = 'COMMENT' THEN
		UPDATE cursoComprado SET
		comentario = _comentario,
        fechaComentario = current_timestamp,
        estadoComentario = true
        WHERE idUsuario = _idUsuario AND idCurso = _idCurso;
	END IF;
    
	IF _instruccion = 'GET_COMMENTS' THEN
			SELECT idUsuario, nombre, comentario, fechaComentario, estadoComentario, causaEliminacion FROM vista_comentarios
            WHERE idCurso = _idCurso AND comentario is not null;
    END IF;
    
    IF _instruccion = 'DELETE_COMMENT' THEN
		UPDATE CursoComprado SET
        estadoComentario = false,
        fechaComentarioEliminado = current_timestamp(),
        causaEliminacion = _busqueda,
        idAdmin = _idUsuario2
        WHERE idUsuario = _idUsuario AND idCurso = _idCurso;
    END IF;
    
    IF _instruccion = 'RATE' THEN
		UPDATE CursoComprado SET
        calificacion = _cantidadNiveles
        WHERE idUsuario = _idUsuario AND idCurso = _idCurso;
    END IF;
 
	IF _instruccion = 'S_RATED' THEN
      SELECT c.idInstructor,
		u.nombre as nombreUsuario,
		c.idCurso,
		c.fechaCreacion,
		c.nombre as nombreCurso,
		c.costo,
		c.descripcion,
		c.foto,
		c.mimetype,
        c.calificacion
			FROM Curso c 
            INNER JOIN Usuario u ON c.idInstructor = u.idUsuario
            WHERE c.estado = true
            ORDER BY c.calificacion DESC;
    END IF;

	IF _instruccion = 'S_RECENT' THEN
      SELECT c.idInstructor,
		u.nombre as nombreUsuario,
		c.idCurso,
		c.fechaCreacion,
		c.nombre as nombreCurso,
		c.costo,
		c.descripcion,
		c.foto,
		c.mimetype,
        c.calificacion
			FROM Curso c 
            INNER JOIN Usuario u ON c.idInstructor = u.idUsuario
            WHERE c.estado = true
            ORDER BY c.fechaCreacion DESC;
    END IF;
    
	IF _instruccion = 'S_SELL' THEN
      SELECT c.idInstructor,
		u.nombre as nombreUsuario,
		c.idCurso,
		c.fechaCreacion,
		c.nombre as nombreCurso,
		c.costo,
		c.descripcion,
		c.foto,
		c.mimetype,
        c.calificacion,
        f_comprasPorCurso(c.idCurso) as compras
			FROM Curso c 
            INNER JOIN Usuario u ON c.idInstructor = u.idUsuario
            WHERE c.estado = true
            ORDER BY compras DESC;
    END IF;


END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_Category(
IN _instruccion VARCHAR(100),
IN _idCurso		INT UNSIGNED,
IN _idCategoria INT UNSIGNED,
IN _idCreador INT UNSIGNED,
IN _nombre VARCHAR(30),
IN _descripcion VARCHAR(200)
)
BEGIN
	IF _instruccion = 'INSERT' THEN
		INSERT INTO categoria(idCreador, nombre, descripcion)
		VALUES (_idCreador, _nombre, _descripcion);
    END IF;
	IF _instruccion = 'ADD' THEN
		INSERT INTO cursocategoria(idCurso, idCategoria) VALUES(_idCurso, _idCategoria);
    END IF;
    IF _instruccion = 'UPDATE' THEN
		UPDATE Categoria c SET c.nombre = _nombre, c.descripcion = _descripcion, c.fechaActualizacion = current_timestamp()
							WHERE c.idCategoria = _idCategoria;
	END IF;
    IF _instruccion = 'SELECT' THEN
		SELECT idCategoria, nombre, descripcion FROM vista_obtenerCategorias WHERE estado = true;
    END IF;
    
    IF _instruccion = 'DELETE' THEN
		UPDATE Categoria SET estado = false WHERE idCategoria = _idCategoria;
    END IF;
    
    IF _instruccion = 'SELECT_FROM_COURSE' THEN
    		SELECT c.idCategoria, c.nombre, c.descripcion FROM Categoria c
				INNER JOIN cursocategoria cc ON cc.idCategoria = c.idCategoria
                WHERE cc.idCurso = _idCurso;
    END IF;

END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_Level(
IN _instruccion varchar(100),
IN _idNivel int unsigned,
IN _idCurso int unsigned,
IN _nombre varchar(80),
IN _numero int,
IN _costo decimal(9,2),
IN _archivo LONGBLOB,
IN _mimeType VARCHAR(20),
IN _videoPath VARCHAR(200),
IN _idUsuario int unsigned,
IN _metodoPago enum('paypal', 'creditCard')
)
BEGIN
	DECLARE v_idNivel INT UNSIGNED;
    DECLARE v_count INT;
    DECLARE v_prevCost DECIMAL(9,2);
    DECLARE v_PorNivel BOOL;

	IF _instruccion = 'INSERT' THEN
    INSERT INTO Nivel(idCurso, nombre, numero, costo) VALUES( _idCurso, _nombre, _numero, _costo);
	SET v_idNivel = LAST_INSERT_ID();
    SELECT v_idNivel as idNivel;
    END IF;
    
    IF _instruccion = 'SELECT' THEN
    SELECT idNivel, idCurso, nombre, numero, costo FROM Nivel WHERE Nivel.idCurso = _idCurso;
    END IF;
    
    IF _instruccion = 'ADD_FILE' THEN
    INSERT INTO Archivos(idNivel, archivo, mimeType, videoPath, nombreArchivo) VALUES(_idNivel, _archivo, _mimeType, _videoPath, _nombre);
    END IF;
    
    IF _instruccion = 'BUY_LEVEL' THEN
    SELECT count(*) INTO v_count FROM NivelComprado nc WHERE nc.idUsuario = _idUsuario AND nc.idNivel = _idNivel;
		IF v_count > 0 THEN
		 SELECT 'Este nivel ya había sido comprado' as respuesta;
		ELSE
			INSERT INTO NivelComprado(idNivel, idUsuario, metodoPago, pago) 
			VALUES(_idNivel, _idUsuario, _metodoPago, _costo); -- MATCH
            
            SELECT PorNivel INTO v_PorNivel FROM Curso WHERE idCurso = _idCurso;
            IF v_PorNivel = true THEN
				 SELECT SUM(pago) INTO v_prevCost FROM NivelComprado nc
											INNER JOIN Nivel n ON n.idNivel = nc.idNivel
											WHERE _idCurso = n.idCurso AND _idUsuario = nc.idUsuario;
				UPDATE CursoComprado SET pago = v_prevCost WHERE idCurso = _idCurso AND _idUsuario = idUsuario;
            END IF;
           
            
		SELECT 'Compra exitosa' as respuesta;
        END IF;
    END IF;
    
	IF _instruccion = 'BOUGHT_LEVELS' THEN
    SELECT 
    n.idNivel,
    n.nombre,
    n.numero,
    n.costo,
    a.idArchivo,
    a.archivo,
    a.mimeType,
    a.nombreArchivo,
    a.videoPath
    FROM Nivel n
    INNER JOIN nivelcomprado nc ON nc.idNivel = n.idNivel
	INNER JOIN archivos a ON a.idNivel = nc.idNivel
    WHERE n.idCurso = _idCurso AND nc.idUsuario = _idUsuario;
    END IF;

	IF _instruccion = 'COMPLETE' THEN
		UPDATE nivelcomprado SET completado = true WHERE idNivel = _idNivel AND idUsuario = _idUsuario;
    END IF;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_User(
IN _instruccion VARCHAR(100),
IN _idUsuario INT UNSIGNED,
IN _foto MEDIUMBLOB,
IN _mimeType VARCHAR(20))
BEGIN
	IF _instruccion = 'UPDATE_IMAGE' THEN
		UPDATE Usuario u SET u.foto = _foto,
						 u.mimeType = _mimeType
        WHERE u.idUsuario = _idUsuario;
        SELECT 'se actualizó correctamente' as response;
    END IF;
    
    IF _instruccion = 'GET_CHAT' THEN
	SELECT  u.foto, u.mimeType, CONCAT(u.nombre, ' ',u.apellido) AS nombre FROM Usuario u where u.idUsuario = _idUsuario;
    END IF;
    
       IF _instruccion = 'GET_STUDENTS' THEN
       SELECT 
       idUsuario,
       email,
       nombre,
       fechaCreacion,
       Inscritos,
       Terminados,
       estado
       FROM vista_reporteEstudiante;
    END IF;
    
     IF _instruccion = 'GET_INSTRUCTORS' THEN
     SELECT 
     idUsuario,
     email,
	 nombre,
     fechaCreacion,
     cursosCreados,
     ingresosTotales,
     estado
     FROM vista_reporteInstructor;
    END IF;

	IF _instruccion = 'DELETE' THEN
		UPDATE Usuario SET estado = false 
        WHERE idUsuario = _idUsuario;
    END IF;
    
    IF _instruccion = 'ENABLE' THEN
		UPDATE Usuario SET estado = true
        WHERE idUsuario = _idUsuario;
    END IF;

END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_Message(
IN _instruccion VARCHAR(100),
IN _idUsuario1 INT UNSIGNED, -- quien manda el mensaje
IN _idUsuario2 INT UNSIGNED, -- quien lo recibe
IN _mensaje	   TEXT
)
BEGIN
	IF _instruccion = 'SEND' THEN
		INSERT INTO Mensaje(idUsuario1, idUsuario2, mensaje) VALUES (_idUsuario1, _idUsuario2, _mensaje);
    END IF;
    
    IF _instruccion = 'GET' THEN
		SELECT m.idUsuario1, m.idUsuario2, m.Mensaje, m.fechaMensaje FROM Mensaje m
				WHERE (idUsuario1 = _idUsuario1 AND idUsuario2 = _idUsuario2)
			    OR (idUsuario1 = _idUsuario2 AND idUsuario2 = _idUsuario1)
				ORDER BY fechaMensaje;  
    END IF;
END //
DELIMITER ;

-- FUNCIONES----------------------------------------------------------------------------------------------------------

DELIMITER //
CREATE FUNCTION f_ingresosPorCurso (_idCurso INT UNSIGNED, _metodoPago enum('paypal', 'creditCard', 'variado'))
RETURNS DECIMAL(9, 2)
DETERMINISTIC
BEGIN
	DECLARE v_ingresos DECIMAL(9, 2);
    IF _metodoPago = 3 THEN
		   SELECT SUM(c.pago) INTO v_ingresos FROM cursoComprado c WHERE c.idCurso =  _idCurso;
    ELSE
		SELECT SUM(c.pago) INTO v_ingresos FROM cursoComprado c WHERE c.idCurso =  _idCurso AND _metodoPago = c.metodoPago;
    END IF;
    
    IF v_ingresos is null THEN
		SET v_ingresos = 0;
	END IF;
    RETURN v_ingresos;
END//
DELIMITER ;


DELIMITER //
CREATE FUNCTION f_alumnosPorCurso (_idCurso INT UNSIGNED)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE v_count INT;
    SELECT count(cc.idUsuario) INTO v_count FROM cursoComprado cc WHERE cc.idCurso = _idCurso;
    RETURN v_count;
END//
DELIMITER ;

DELIMITER //
CREATE FUNCTION f_obtenerProgreso(_idUsuario INT UNSIGNED, _idCurso INT UNSIGNED)
RETURNS DECIMAL (5,2)
DETERMINISTIC
BEGIN
	DECLARE v_totalProgreso DECIMAL (5,2);
    DECLARE v_totalNiveles INT;
    DECLARE v_totalNivelesCompletados INT;
    
    SELECT count(*) INTO v_totalNiveles FROM Nivel WHERE Nivel.idCurso = _idCurso;
    SELECT count(*) INTO v_totalNivelesCompletados FROM NivelComprado nc
													INNER JOIN Nivel n ON n.idNivel = nc.idNivel
													WHERE n.idCurso = _idCurso AND nc.idUsuario = _idUsuario AND completado = true;
                                                    
	IF v_totalNiveles = 0 OR v_totalNivelesCompletados = 0 THEN
    SET v_totalProgreso = 0;
    ELSE
    SET v_totalProgreso = v_totalNivelesCompletados * 100 / v_totalNiveles;
    END IF;
    
    RETURN v_totalProgreso;
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION f_CursosInscritos(_idUsuario INT UNSIGNED)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE v_cantidad INT;
    SELECT count(*) INTO v_cantidad FROM cursoComprado WHERE idUsuario = _idUsuario;
    RETURN v_cantidad;
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION f_CursosTerminados(_idUsuario INT UNSIGNED)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE v_cantidad INT;
    DECLARE v_total INT;
	SELECT count(*) INTO v_total FROM cursoComprado WHERE idUsuario = _idUsuario;
    SELECT count(*) INTO v_cantidad FROM cursoComprado WHERE idUsuario = _idUsuario AND progreso = 100;
    IF v_total <> 0 THEN
    SET v_total = (v_cantidad *100) / v_total;
    END IF;
    RETURN v_total;
END //
DELIMITER ;

DELIMITER //
CREATE FUNCTION f_CursosCreados(_idUsuario INT UNSIGNED)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE v_cantidad INT;
    SELECT count(*) INTO v_cantidad FROM Curso WHERE idInstructor = _idUsuario;
    RETURN v_cantidad;
END //
DELIMITER ;


DELIMITER //
CREATE FUNCTION f_ingresosTotales (_idUsuario INT UNSIGNED)
RETURNS DECIMAL(9, 2)
DETERMINISTIC
BEGIN
	DECLARE v_ingresos DECIMAL(9, 2);
    
	SELECT SUM(cc.pago) INTO v_ingresos FROM cursoComprado cc
										INNER JOIN Curso c ON c.idCurso = cc.idCurso
                                        WHERE c.idInstructor =  _idUsuario;

    IF v_ingresos is null THEN
		SET v_ingresos = 0;
	END IF;
    RETURN v_ingresos;
END//
DELIMITER ;

DELIMITER //
CREATE FUNCTION f_comprasPorCurso (_idCurso INT UNSIGNED)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE total INT;
    SET total = 0;
    
	SELECT COUNT(cc.idCurso) INTO total FROM cursoComprado cc
                                        WHERE cc.idCurso =  _idCurso;
    RETURN total;
END//
DELIMITER ;


DELIMITER //
CREATE FUNCTION f_nivelPromedio (_idCurso INT UNSIGNED)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE total INT;
    DECLARE suma DECIMAL(5,2);
    DECLARE promedio DECIMAL(5,2);
    
    SET suma = 0;
    SELECT SUM(progreso) INTO suma FROM cursoComprado WHERE idCurso = _idCurso;
    
	SELECT COUNT(idUsuario) INTO total FROM CursoComprado
                                        WHERE idCurso =  _idCurso;
	SET promedio = suma / total;
    RETURN promedio;
END//
DELIMITER ;
-- VISTAS ------------------------------------------------------------------------------------------------------
CREATE VIEW vista_IngresosPorCurso AS
	SELECT
	c.idInstructor,
	c.idCurso,
    c.fechaCreacion,
	c.nombre as Curso,
	f_alumnosPorCurso(c.idCurso) as AlumnosInscritos,
	f_ingresosPorCurso(c.idCurso, 1) as ingresosPayPal,
	f_ingresosPorCurso(c.idCurso, 2) as ingresosCreditCard,
	f_ingresosPorCurso(c.idCurso, 3) as ingresosTotales,
    f_nivelPromedio(c.idCurso) as Promedio,
    c.estado
	FROM Curso c 
	LEFT JOIN cursoComprado cc ON c.idCurso = cc.idCurso;
    
CREATE VIEW vista_DetalleAlumnosPorCurso AS
SELECT
cc.idCurso as idCurso,
cc.idUsuario ,
CONCAT(u.nombre," ", u.apellido) as Alumno,
cc.fechaInicio as FechaInscripcion,
0 as NivelAvance,
cc.pago as PrecioPagado,
cc.metodoPago,
cc.progreso,
f_ingresosPorCurso(c.idCurso, 3) as ingresosTotales
FROM Usuario u
	INNER JOIN CursoComprado cc ON cc.idUsuario = u.idUsuario
    INNER JOIN Curso c ON c.idCurso = cc.idCurso;

CREATE VIEW vista_Kardex AS
 SELECT 
    c.nombre as Curso,
    cc.idUsuario,
    c.idCurso,
    cc.progreso,
    cc.fechaUltimoIngreso,
    cc.fechaInicio,
    cc.fechaTerminado,
    CONCAT(u.nombre, " ", u.apellido) as nombreInstructor
    FROM Curso c
		INNER JOIN cursoComprado cc ON c.idCurso = cc.idCurso
        INNER JOIN Usuario u ON u.idUsuario = c.idInstructor;
        
CREATE VIEW vista_reporteEstudiante AS
SELECT idUsuario,
 email,
 CONCAT(nombre, ' ',apellido) as nombre,
 fechaCreacion,
 f_CursosInscritos(idUsuario) as Inscritos,
 f_CursosTerminados(idUsuario) as Terminados,
 estado
 FROM Usuario WHERE rol = 2;
 
 CREATE VIEW vista_reporteInstructor AS
 SELECT idUsuario,
 email,
 CONCAT(nombre, ' ',apellido) as nombre,
 fechaCreacion,
 f_CursosCreados(idUsuario) as cursosCreados,
 f_ingresosTotales(idUsuario) as ingresosTotales,
 estado
 FROM Usuario WHERE rol = 3;
 
 CREATE VIEW vista_comentarios AS
 SELECT cc.idCurso, cc.idUsuario, u.nombre, cc.comentario, cc.fechaComentario, cc.estadoComentario, cc.causaEliminacion FROM CursoComprado cc
            INNER JOIN Usuario u ON cc.idUsuario = u.idUsuario;
 
 CREATE VIEW vista_obtenerCategorias AS
 		SELECT c.idCategoria, c.nombre, c.descripcion, c.estado FROM Categoria c;

CREATE VIEW vista_personalInfo AS
SELECT nombre, email, apellido, genero, fechaNacimiento, foto, rol FROM Usuario;
 -- ------------------------------------------------------------------------------------------------------------------------------------

SELECT * FROM usuario ;
SELECT*FROM curso;
SELECT * FROM cursoCategoria;
SELECT * FROM categoria;
SELECT*FROM Nivel;
SELECT*FROM cursocomprado;
SELECT*FROM nivelComprado;
select *from archivos;
select*from mensaje;
UPDATE CURSO SET estado = true WHERE idCurso = 1;

CALL sp_User('DELETE', 2, null, null);


TRUNCATE cursoComprado;
TRUNCATE nivelComprado;


SELECT * FROM vista_IngresosPorCurso;
SELECT * FROM vista_DetalleAlumnosPorCurso;
SELECT * FROM vista_kardex;
select * from vista_reporteEstudiante;



select f_alumnosPorCurso(2);
select f_ingresosPorCurso(1, 1);
select f_obtenerProgreso(2, 2);
select f_nivelPromedio(1);

 SELECT 
    n.idNivel,
    n.nombre,
    n.numero,
    n.costo,
    a.idArchivo,
    a.archivo,
    a.mimeType,
    a.nombreArchivo
    FROM Nivel n
    INNER JOIN nivelcomprado nc ON nc.idNivel = n.idNivel
	INNER JOIN archivos a ON a.idNivel = nc.idNivel
    WHERE n.idCurso = 73 AND nc.idUsuario = 3;




-- ------------------------------------------------TRIGGERS----------------------------------------------------------------
DELIMITER //
CREATE TRIGGER levelCompleted
AFTER UPDATE
ON nivelComprado
FOR EACH ROW
BEGIN
	DECLARE v_idCurso int unsigned;
    DECLARE v_progreso decimal (5,2);
    
	SELECT idCurso INTO v_idCurso FROM Nivel WHERE idNivel = NEW.idNivel;
    SET v_progreso = f_obtenerProgreso(NEW.idUsuario, v_idCurso);
	UPDATE cursoComprado SET 
    progreso = v_progreso
        WHERE idCurso = v_idCurso AND idUsuario = NEW.idUsuario;
        
	IF v_progreso = 100 THEN
    UPDATE cursoComprado SET 
    fechaTerminado = current_timestamp()
        WHERE idCurso = v_idCurso AND idUsuario = NEW.idUsuario;
    END IF;
END //
DELIMITER ;

DROP TRIGGER cursoCalificado;
DELIMITER //
CREATE TRIGGER cursoCalificado
AFTER UPDATE
ON cursoComprado
FOR EACH ROW
BEGIN
	DECLARE v_sumaCalif decimal(9,2);
	DECLARE v_cantidadCalif int;
    DECLARE v_final decimal(9,2);

    
	IF OLD.calificacion is null THEN
    
    SELECT sum(calificacion) INTO v_sumaCalif FROM CursoComprado WHERE idCurso = NEW.idCurso;
	SELECT count(calificacion) INTO v_cantidadCalif FROM CursoComprado WHERE idCurso = NEW.idCurso AND calificacion is not null;
    
	SET v_final = v_sumaCalif / v_cantidadCalif;
    
    UPDATE Curso
    SET calificacion = v_final
    WHERE idCurso = NEW.idCurso;
    END IF;

END //
DELIMITER ;






