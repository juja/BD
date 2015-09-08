DROP SCHEMA IF EXISTS public CASCADE;
CREATE SCHEMA IF NOT EXISTS public;

CREATE TABLE tipo_accidente(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE tipo_lugar(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE tipo_infraccion(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE cobertura(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE tipo_vehiculo(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE categoria_vehiculo(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE compania_seguros(
	id SERIAL PRIMARY KEY,
	nombre VARCHAR(255)
);

CREATE TYPE tipo_cedula AS ENUM ('Verde', 'azul');
CREATE TABLE cedula(
	id SERIAL PRIMARY KEY,
	tipo tipo_cedula
);

CREATE TABLE antecedente_penal(
	id SERIAL PRIMARY KEY,
	descripcion TEXT
);

CREATE TABLE persona(
	dni integer PRIMARY KEY,
	nombre VARCHAR(255),
	antecedente_id integer,
	FOREIGN KEY (antecedente_id) REFERENCES antecedente_penal(id)
);

CREATE TABLE victima(
	dni integer PRIMARY KEY,
	FOREIGN KEY(dni) REFERENCES persona(dni)
);

CREATE TABLE testigo(
	dni integer PRIMARY KEY,	
	FOREIGN KEY(dni) REFERENCES persona(dni)
);

CREATE TABLE conductor(
	dni integer PRIMARY KEY,
	lic_conducir VARCHAR(255),	
	FOREIGN KEY(dni) REFERENCES persona(dni)
);

CREATE TABLE lugar(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255),
	tipo_id INTEGER,
	FOREIGN KEY(tipo_id) REFERENCES tipo_lugar(id)
);

CREATE TABLE autopista(
	id INTEGER PRIMARY KEY,
	kilometros integer,
	FOREIGN KEY(id) REFERENCES tipo_lugar(id)
);

CREATE TABLE infraccion(
	id SERIAL PRIMARY KEY,
	fecha_hora TIMESTAMP WITHOUT TIME ZONE,
	conductor_dni INTEGER NOT NULL,
	tipo_infraccion_id INTEGER,
	FOREIGN KEY(conductor_dni) REFERENCES conductor(dni),
	FOREIGN KEY(tipo_infraccion_id) REFERENCES tipo_infraccion(id)
);

CREATE TABLE vehiculo(
	id SERIAL PRIMARY KEY,
	dominio CHAR(6) UNIQUE,
	modelo SMALLINT,
	tipo_id integer,
	categoria_id integer,	
	FOREIGN KEY(tipo_id) REFERENCES tipo_vehiculo(id),
	FOREIGN KEY(categoria_id) REFERENCES categoria_vehiculo(id)
);


CREATE TABLE siniestro(
	id SERIAL PRIMARY KEY,
	fecha_hora TIMESTAMP WITHOUT TIME ZONE,
	lugar_id INTEGER,
	tipo_accidente_id INTEGER,
	FOREIGN KEY(lugar_id) REFERENCES lugar(id),
	FOREIGN KEY(tipo_accidente_id) REFERENCES tipo_accidente(id)
);

CREATE TABLE victima_siniestro(
	victima_dni INTEGER,
	siniestro_id INTEGER,	
	usa_cinturon BOOLEAN,
	PRIMARY KEY(victima_dni,siniestro_id),
	FOREIGN KEY(victima_dni) REFERENCES victima(dni),
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id)
);

CREATE TABLE testigo_siniestro(
	testigo_dni INTEGER,
	siniestro_id INTEGER,
	PRIMARY KEY(testigo_dni,siniestro_id),
	FOREIGN KEY(testigo_dni) REFERENCES testigo(dni),
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id)
);

CREATE TABLE conductor_vehiculo_siniestro(
	siniestro_id INTEGER,
	conductor_dni INTEGER,
	vehiculo_id INTEGER,
	PRIMARY KEY(conductor_dni,siniestro_id),
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id),
	FOREIGN KEY(conductor_dni) REFERENCES conductor(dni),
	FOREIGN KEY(vehiculo_id) REFERENCES vehiculo(id)
);

CREATE TABLE persona_antecedente_penal(
	dni INTEGER,
	antecedente_penal_id INTEGER,
	PRIMARY KEY(dni,antecedente_penal_id),
	FOREIGN KEY(dni) REFERENCES persona(dni),
	FOREIGN KEY(antecedente_penal_id) REFERENCES antecedente_penal(id)
);

CREATE TABLE vehiculo_compania_cobertura(
	vehiculo_id INTEGER,
	compania_seguros_id INTEGER,
	cobertura_id INTEGER,
	PRIMARY KEY(vehiculo_id,cobertura_id),
	FOREIGN KEY(vehiculo_id) REFERENCES vehiculo(id),
	FOREIGN KEY(compania_seguros_id) REFERENCES compania_seguros(id),
	FOREIGN KEY(cobertura_id) REFERENCES cobertura(id)
);

CREATE TABLE tipo_colision(
	id SERIAL PRIMARY KEY,
	descripcion VARCHAR(255)
);

CREATE TABLE siniestro_tipo_colision(
	siniestro_id INTEGER,
	tipo_colision_id INTEGER,
	PRIMARY KEY(siniestro_id,tipo_colision_id),
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id),
	FOREIGN KEY(tipo_colision_id) REFERENCES tipo_colision(id)
);


CREATE TABLE informe(
	id SERIAL PRIMARY KEY,
	causa_presunta TEXT,
	iluminacion VARCHAR(255),
	condicion_via VARCHAR(255),
	condicion_climatica VARCHAR(255),
	tipo_pavimento varchar(50),
	siniestro_id INTEGER NOT NULL,
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id)
);

CREATE TABLE denuncia_policial(
	id SERIAL PRIMARY KEY,
	descripcion TEXT,
	siniestro_id INTEGER,
	FOREIGN KEY(siniestro_id) REFERENCES siniestro(id)
);

