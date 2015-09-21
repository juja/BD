DROP SCHEMA IF EXISTS TP;
CREATE SCHEMA IF NOT EXISTS TP;
USE TP;

CREATE TABLE persona(
	dni INTEGER PRIMARY KEY,
	nacionalidad VARCHAR(255) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	apellido VARCHAR(255) NOT NULL
);
	
CREATE TABLE tipo_delito(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255) NOT NULL,
	descripcion VARCHAR(1024)
);

CREATE TABLE antecedente(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	descripcion VARCHAR(1024),
	fecha DATETIME NOT NULL,
	tipo_delito_id INTEGER NOT NULL,
	dni INTEGER NOT NULL,
	FOREIGN KEY(tipo_delito_id) REFERENCES tipo_delito(id),
	FOREIGN KEY(dni) REFERENCES persona(dni)
);

CREATE TABLE persona_con_licencia(
	dni INTEGER PRIMARY KEY,		
	fecha_vencimiento DATETIME
);

CREATE TABLE cedula_vehicular(
	codigo INTEGER PRIMARY KEY,
	tipo_cedula ENUM('Verde','Azul')
);

CREATE TABLE tipo_vehiculo(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255)
);

CREATE TABLE categoria_vehiculo(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255)
);

CREATE TABLE vehiculo(
	matricula CHAR(6) PRIMARY KEY,
	modelo SMALLINT,
	detalle VARCHAR(1024),	
	tipo_id INTEGER,
	categoria_id INTEGER,
	dni INTEGER NOT NULL,
	FOREIGN KEY(dni) REFERENCES persona(dni),
	FOREIGN KEY(tipo_id) REFERENCES tipo_vehiculo(id),
	FOREIGN KEY(categoria_id) REFERENCES categoria_vehiculo(id)	
);

CREATE TABLE registro_automotor(
	dni INTEGER NOT NULL,
	matricula CHAR(6) NOT NULL,
	cedula_codigo INTEGER NOT NULL,
	PRIMARY KEY(dni,cedula_codigo),
	FOREIGN KEY(dni) REFERENCES persona(dni),
	FOREIGN KEY(matricula) REFERENCES vehiculo(matricula),
	FOREIGN KEY(cedula_codigo) REFERENCES cedula_vehicular(codigo)
);

CREATE TABLE tipo_cobertura(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255),
	descripcion VARCHAR(1024)
);

CREATE TABLE compania_seguro(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255),
	descripcion VARCHAR(1024)
);

CREATE TABLE cobertura(
	vehiculo_matricula CHAR(6) NOT NULL,
	tipo_id INTEGER NOT NULL,
	compania_id INTEGER NOT NULL,
	PRIMARY KEY (vehiculo_matricula,tipo_id,compania_id),
	
	FOREIGN KEY(tipo_id) REFERENCES tipo_cobertura(id),
	FOREIGN KEY(compania_id) REFERENCES compania_seguro(id)
);
CREATE TABLE camino(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255),
	longitud INTEGER
);

CREATE TABLE direccion(	
	altura INTEGER NOT NULL,
	camino_id INTEGER NOT NULL,
	PRIMARY KEY(altura,camino_id),
	FOREIGN KEY(camino_id) REFERENCES camino(id)
);

CREATE TABLE infraccion(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	descripcion VARCHAR(1024),
	fecha DATE NOT NULL,
	vehiculo_matricula CHAR(6) NOT NULL,
	dni INTEGER NOT NULL,	
	direccion_altura INTEGER NOT NULL,
	direccion_camino_id INTEGER NOT NULL,
	FOREIGN KEY(dni) REFERENCES persona(dni),
	FOREIGN KEY(direccion_altura,direccion_camino_id) REFERENCES direccion(altura,camino_id),
	FOREIGN KEY(vehiculo_matricula) REFERENCES vehiculo(matricula)
);

CREATE TABLE tipo_infraccion(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255),
	descripcion VARCHAR(1024)
);

CREATE TABLE tipo_accidente(
	id INTEGER AUTO_INCREMENT PRIMARY KEY, 
	nombre VARCHAR(255), 
	descripcion VARCHAR(1024)
);

CREATE TABLE tipo_falla_humana (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255), 
	descripcion VARCHAR(1024)
);

CREATE TABLE comisaria(
	numero INTEGER PRIMARY KEY,
	direccion_altura INTEGER,
	direccion_camino_id INTEGER,
	FOREIGN KEY(direccion_altura,direccion_camino_id) REFERENCES direccion(altura,camino_id)
);


CREATE TABLE denuncia(
	id INTEGER PRIMARY KEY,
	fecha DATETIME,
	comisaria_nro INTEGER NOT NULL,
	FOREIGN KEY(comisaria_nro) REFERENCES comisaria(numero)
); 

CREATE TABLE colision(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	descripcion VARCHAR(1024)
);

CREATE TABLE tipo_peritaje(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255),
	descripcion VARCHAR(1024)
);


CREATE TABLE peritaje(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	fecha DATE,
	descripcion TEXT,
	conclusion TEXT,
	tipo_peritaje_id INTEGER NOT NULL,
	FOREIGN KEY(tipo_peritaje_id) REFERENCES tipo_peritaje(id)
);

CREATE TABLE siniestro(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	descripcion TEXT,
	fecha_hora DATETIME,	
	tipo_falla_id INTEGER NOT NULL,
	tipo_accidente_id INTEGER NOT NULL, 
	denuncia_id INTEGER NOT NULL,
	colision_id INTEGER NOT NULL,
	direccion_altura INTEGER NOT NULL,
	direccion_camino_id INTEGER NOT NULL,
	FOREIGN KEY(tipo_accidente_id) REFERENCES tipo_accidente(id),
	FOREIGN KEY(tipo_falla_id) REFERENCES tipo_falla_humana(id),
	FOREIGN KEY(denuncia_id) REFERENCES denuncia(id),
	FOREIGN KEY(colision_id) REFERENCES colision(id),
	FOREIGN KEY(direccion_altura,direccion_camino_id) REFERENCES direccion(altura,camino_id)
);

CREATE TABLE conclusion(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	conclusion_final TEXT,
	siniestro_id INTEGER NOT NULL,
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id)
);

CREATE TABLE victima(
	conclusion_id INTEGER NOT NULL,
	dni INTEGER NOT NULL,
	PRIMARY KEY(conclusion_id,dni),
	FOREIGN KEY(conclusion_id) REFERENCES conclusion(id),
	FOREIGN KEY(dni) REFERENCES persona(dni)
);

CREATE TABLE victimario(
	conclusion_id INTEGER NOT NULL,
	dni INTEGER NOT NULL,
	PRIMARY KEY(conclusion_id,dni),
	FOREIGN KEY(conclusion_id) REFERENCES conclusion(id),
	FOREIGN KEY(dni) REFERENCES persona(dni)
);

CREATE TABLE testigos(
	siniestro_id INTEGER NOT NULL,
	dni INTEGER NOT NULL,
	FOREIGN KEY(dni) REFERENCES persona(dni),
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id)
);

CREATE TABLE provincia(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255)
);

CREATE TABLE localidad(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255),
	provincia_id INTEGER NOT NULL,
	FOREIGN KEY(provincia_id) REFERENCES provincia(id)
);

CREATE TABLE registro_calles(
	camino_id INTEGER NOT NULL,
	localidad_id INTEGER NOT NULL,
	altura_desde INTEGER NOT NULL,
	altura_hasta INTEGER NOT NULL,
	PRIMARY KEY(camino_id,localidad_id),
	FOREIGN KEY(camino_id) REFERENCES camino(id),
	FOREIGN KEY(localidad_id) REFERENCES localidad(id)
);

CREATE TABLE tipo_camino(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255)
);

CREATE TABLE clasificacion_camino(
	camino_id INTEGER NOT NULL,
	tipo_id INTEGER NOT NULL,
	altura_hasta INTEGER NOT NULL,
	altura_desde INTEGER NOT NULL,
	longitud INTEGER NOT NULL,
	PRIMARY KEY(camino_id,tipo_id,altura_desde,altura_hasta),
	FOREIGN KEY(camino_id) REFERENCES camino(id),
	FOREIGN KEY(tipo_id) REFERENCES tipo_camino(id)
);


