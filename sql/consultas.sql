-- Consulta por número de licencia: obtener, con un número de licencia específico,
-- información sobre los accidentes en los que ha participado el conductor propietario de
-- la misma, con detalles de fecha, lugar, tipo de accidente, participación y modalidad.

//
CREATE PROCEDURE `Info_nro_licencia` (IN licencia INT(11))
BEGIN
	Select 	DISTINCT s.id as 'SINIESTRO ID',
			CASE WHEN va.dni = p.dni or vrio.dni = p.dni THEN 
				i.vehiculo_matricula 
			ELSE 
				NULL 
			END as 'Matricula del vehiculo',
			s.descripcion as 'Descripcion del siniestro',
			s.fecha_hora as 'Fecha del siniestro',
			tfh.nombre as 'Tipo de falla',
			tfh.descripcion as 'Descripcion de la falla',
			ta.nombre as 'Tipo accidente',
			ta.descripcion as 'Descripcion del tipo de accidente',
			co.descripcion as 'Colision',
			concat(c.nombre,d.altura,', ',l.nombre,', ',prov.nombre) as 'Direccion',
			CASE WHEN va.dni = p.dni THEN 'Victima' ELSE 
				CASE WHEN vrio.dni = p.dni THEN 'Victimario' ELSE 
					CASE WHEN t.dni = p.dni THEN 'Testigo' ELSE
					'Nada'
					END
				END 
			END as 'Participacion',
			cantidadV.count as 'Vehiculos habilitados'
	from Persona as p
		inner join testigos as t on 
			t.dni = p.dni
		inner join involucrados as i on 
			i.persona_dni = p.dni
		inner join siniestro as s on 
			s.id = i.siniestro_id or s.id = t.siniestro_id
		inner join tipo_falla_humana as tfh on 
			tfh.id = s.tipo_falla_id
		inner join tipo_accidente as ta on
			ta.id = s.tipo_accidente_id
		inner join colision as co on
			co.id = s.colision_id
		inner join Direccion as d on 
			d.altura = s.direccion_altura and 
			d.camino_id = s.direccion_camino_id
		inner join Camino as c on 
			c.id = d.camino_id
		inner join localidad as l
		inner join registro_calles as rc on l.id = rc.camino_id and rc.localidad_id = l.id
		inner join provincia as prov on prov.id = l.provincia_id
		inner join conclusion as con on con.siniestro_id = s.id
		inner join victima as va on va.conclusion_id = con.id
		inner join victimario as vrio on vrio.conclusion_id = con.id
		inner join (Select COUNT(*) as 'count' from registro_automotor where dni = licencia) as cantidadV

	where p.dni = licencia 
	order by s.id;
END //


//
CREATE PROCEDURE `incurrencia_tipo_accidente` (IN tipo varchar(255))
BEGIN
	SELECT
		p.dni,
		count(p.dni)
	FROM
		persona p
			INNER JOIN
		testigos AS t ON t.dni = p.dni
			INNER JOIN
		involucrados AS i ON i.persona_dni = p.dni
			INNER JOIN
		siniestro as s on s.id = i.siniestro_id
			OR s.id = t.siniestro_id
			INNER JOIN
		tipo_accidente AS ta ON ta.id = s.tipo_accidente_id

	where
		ta.nombre = tipo
	group by p.dni, s.id
	order by count(p.dni) DESC;
END //
