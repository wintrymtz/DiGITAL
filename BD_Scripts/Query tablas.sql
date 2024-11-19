DROP DATABASE BDM_CURSOS;
CREATE DATABASE BDM_CURSOS;
USE BDM_CURSOS;

CREATE TABLE Usuario(
idUsuario 				int 			unsigned primary key auto_increment						COMMENT 'Identificador del usuario',
email 					varchar(200) 	unique not null											COMMENT 'Correo del usuario',
pass					varchar(50)		not null												COMMENT 'Contraseña del usuario',
nombre					varchar(50)		not null												COMMENT 'Nombre del usuario',
apellido				varchar(50)		not null												COMMENT 'Apellido del usuario',
genero 					enum('hombre', 'mujer', 'otro')	null									COMMENT 'Género del usuario',
fechaNacimiento 		date																	COMMENT 'Fecha de nacimiento del usuario',
foto 					mediumblob																COMMENT 'Imagen de perfil del usuario',
mimeType				varchar(20)		 default(null)											COMMENT 'Tipo de imagen (.jpg, .png, etc)',
rol						enum('administrador', 'estudiante', 'instructor')	not null			COMMENT 'Rol del usuario',
estado					bool 			default(true)											COMMENT 'True si está activo y false si no',
intentos				int				default 0												COMMENT 'Intentos al iniciar sesion, con 3 se desactiva el usuario',
fechaCreacion 			timestamp 		default current_timestamp								COMMENT 'Fecha de creación del usuario',
fechaActualizacion 		timestamp 		default current_timestamp								COMMENT 'Fecha de actualizacion del usuario'
);

CREATE TABLE Curso(
idCurso					int				unsigned primary key auto_increment						COMMENT 'Identificador del Curso',
idInstructor			int				unsigned not null										COMMENT 'Identificador del Instructor que creó el curso',
nombre					varchar(80)		not null												COMMENT 'Nombre del curso',
cantidadNiveles			int				not null												COMMENT 'Cantidad de niveles que tiene el curso',
costo					decimal(9, 2)	default(0)												COMMENT 'Costo del curso',
descripcion				varchar(200)															COMMENT 'Descripción general del contenido del curso',
foto					mediumblob																COMMENT 'Imagen de portada del curso',
mimeType				varchar(20)		 default(null)											COMMENT 'Tipo de imagen (.jpg, .png, etc)',
PorNivel 				bool default false														COMMENT 'True si se puede comprar cada nivel por separado',					
estado					bool			default(true) not null									COMMENT 'True si está activo y false si no',
fechaCreacion			timestamp 		default current_timestamp								COMMENT 'Fecha de creación del curso',
calificacion 			DECIMAL (9,2) 															COMMENT 'Calificacion general del curso',
foreign key(idInstructor) references Usuario(idUsuario)
);

CREATE TABLE Nivel(
idNivel 		int 					unsigned primary key auto_increment						COMMENT 'Identificador del nivel',
idCurso 		int 					unsigned												COMMENT 'Identificador del curso al que pertenecen',
nombre			varchar(80)																		COMMENT 'Nombre del nivel',
numero			int						not null												COMMENT 'Numero del nivel dentro del curso',
costo			decimal(9, 2) 			default(0)												COMMENT 'Costo del nivel',
fechaCreacion	timestamp 				default current_timestamp								COMMENT 'Fecha de creación del nivel',

foreign key(idCurso) references Curso(idCurso)
);

CREATE TABLE Categoria(
idCategoria			int					unsigned primary key auto_increment						COMMENT 'Identificador de la categoría',
idCreador			int					unsigned												COMMENT 'Identificador del usuario que la creó',
nombre				varchar(30) 		not null												COMMENT 'Nombre de la categoría',
descripcion			varchar(200)																COMMENT 'Descripcion de la categoría',
fechaCreacion		timestamp 			default current_timestamp								COMMENT 'Fecha de creación de la categoría',
fechaActualizacion 	timestamp			default current_timestamp								COMMENT 'Fecha de actualizacion de la categoría',
estado				bool				default true											COMMENT 'True si existe, false si se desahabilitó',

foreign key(idCreador) references Usuario(idUsuario)
);

CREATE TABLE Archivos(
idArchivo		int				unsigned primary key auto_increment								COMMENT 'Identificador del archivo',
idNivel			int				unsigned														COMMENT 'Identificador del nivel al que pertenece el archivo',
archivo			longblob																		COMMENT 'Archivo almacenado',
mimeType		varchar(20)		default(null)													COMMENT 'Tipo de imagen (.jpg, .png, etc)',
videoPath		varchar(200)    default(null)													COMMENT 'Path del video en el servidor',
fechaCreacion 	timestamp 		default current_timestamp										COMMENT 'Fecha de subida del archivo',
nombreArchivo 	varchar(200) 	default('archivo') 												COMMENT 'Nombre del archivo que se mostrará',

foreign key(idNivel) references Nivel(idNivel)
);

CREATE TABLE CursoComprado(
idCurso 					int 					unsigned 									COMMENT 'Identificador del curso que se compró',
idUsuario 					int 					unsigned									COMMENT 'Identificador del usuario que compró el curso',
progreso					decimal(5, 2)			default(0)									COMMENT 'Progreso del curso de acuerdo a niveles completados',
metodoPago 					enum('paypal', 'creditCard', 'variado') not null					COMMENT 'Método de pago utilizado para comprar el curso',
pago						decimal(9, 2) 			default(null)								COMMENT 'Cuánto pagó el usuario por el curso',
calificacion 				int																	COMMENT 'Calificacion que el usuario le da al curso',
-- datos del comentario unico
comentario					text																COMMENT 'Comentario del estudiante al terminar el curso',
fechaComentario				timestamp															COMMENT 'Fecha de creacion del comentario',
estadoComentario			bool																COMMENT 'Si está activo o inactivo',
causaEliminacion			varchar(100)														COMMENT 'En caso de eliminacion del comentario, la razón',
fechaComentarioEliminado	timestamp															COMMENT 'Fecha en la que se desactivó el comentario',
idAdmin						int unsigned														COMMENT 'Identificador del usuario administrador que eliminó el comentario',

fechaUltimoIngreso			timestamp															COMMENT 'Fecha del ultmo ingreso del estudiante',
fechaInicio					timestamp				default current_timestamp					COMMENT 'Fecha en la que inició el curso',
fechaTerminado 				timestamp															COMMENT 'Fecha en la que tereminó el curso',

primary key(idUsuario, idCurso),
foreign key(idCurso) references Curso(idCurso),
foreign key(idUsuario) references Usuario(idUsuario),
foreign key(idAdmin) references Usuario(idUsuario)
);

CREATE TABLE Mensaje(
idMensaje			int 		unsigned primary key auto_increment								COMMENT 'Identificador del mensaje',
idUsuario1			int 		unsigned														COMMENT 'Identificador del usuario que manda el mensaje',
idUsuario2			int 		unsigned														COMMENT 'Identificador del usuario que recibe el mensaje',
Mensaje				text 		not null														COMMENT 'Mensaje que se está almacenando',
fechaMensaje		timestamp	default current_timestamp										COMMENT	'Fecha del envío del mensaje',	

foreign key (idUsuario1) references Usuario(idUsuario),
foreign key (idUsuario2) references Usuario(idUsuario)
);

-- tabla de estudiante nivel
CREATE TABLE NivelComprado(
idNivel				int 							unsigned									COMMENT 'Identificador del nivel comprado',
idUsuario			int 							unsigned									COMMENT 'Identificador del usuario que compró el nivel',
metodoPago			enum('paypal', 'creditCard') 	not null									COMMENT  'Método de pago utilizado',
pago				decimal(9, 2) 					default(null)								COMMENT 'Cuánto pagó el usuario por el nivel',
completado			bool							default(false)								COMMENT 'Si el usuario ya vio los videos del curso',
fechaCompra			timestamp						default current_timestamp					COMMENT 'Fecha de compra',

primary key(idUsuario, idNivel),
foreign key (idUsuario) references Usuario(idUsuario),
foreign key (idNivel) references Nivel(idNivel)
);

CREATE TABLE CursoCategoria(
idCurso					int			 	unsigned												COMMENT 'Identificador del curso',
idCategoria				int 			unsigned												COMMENT 'Identificador de la categoría',
fechaCreacion			timestamp       default current_timestamp								COMMENT 'Fecha de creación del registro',

primary key(idCurso, idCategoria),
foreign key (idCurso) references Curso(idCurso),
foreign key (idCategoria) references Categoria(idCategoria)
);

-- Consulta para los comentarios
SELECT  
	c.table_name,
    c.column_name,
    c.column_type,
    c.column_default,
    c.column_key,
    c.is_nullable,
   /* t.table_name, */
    c.column_comment
    FROM information_schema.tables AS t
    INNER JOIN information_schema.columns AS c
		ON t.table_name = c.table_name
        AND t.table_schema = c.table_schema
	WHERE t.table_type IN ('BASE TABLE')
    AND t.table_schema = 'bdm_cursos'
	ORDER BY
			1,
			--c.column_name,
            c.ordinal_position;
