-- Consulta por número de licencia: obtener, con un número de licencia específico,
-- información sobre los accidentes en los que ha participado el conductor propietario de
-- la misma, con detalles de fecha, lugar, tipo de accidente, participación y modalidad.

//
CREATE PROCEDURE `Info_nro_licencia` (IN licencia INT(11))
BEGIN
	SELECT DISTINCT
	    s.id AS 'SINIESTRO ID',
	    CASE
	        WHEN va.dni = p.dni OR vrio.dni = p.dni THEN i.vehiculo_matricula
	        ELSE NULL
	    END AS 'Matricula del vehiculo',
	    s.descripcion AS 'Descripcion del siniestro',
	    s.fecha_hora AS 'Fecha del siniestro',
	    tfh.nombre AS 'Tipo de falla',
	    tfh.descripcion AS 'Descripcion de la falla',
	    ta.nombre AS 'Tipo accidente',
	    ta.descripcion AS 'Descripcion del tipo de accidente',
	    co.descripcion AS 'Colision',
	    CONCAT(c.nombre,
	            d.altura,
	            ', ',
	            l.nombre,
	            ', ',
	            prov.nombre) AS 'Direccion',
	    CASE
	        WHEN va.dni = p.dni THEN 'Victima'
	        ELSE CASE
	            WHEN vrio.dni = p.dni THEN 'Victimario'
	            ELSE CASE
	                WHEN t.dni = p.dni THEN 'Testigo'
	                ELSE 'Nada'
	            END
	        END
	    END AS 'Participacion',
	    cantidadV.count AS 'Vehiculos habilitados'
	FROM
	    Persona AS p
	        INNER JOIN
	    testigos AS t ON t.dni = p.dni
	        INNER JOIN
	    involucrados AS i ON i.persona_dni = p.dni
	        INNER JOIN
	    siniestro AS s ON s.id = i.siniestro_id
	        OR s.id = t.siniestro_id
	        INNER JOIN
	    tipo_falla_humana AS tfh ON tfh.id = s.tipo_falla_id
	        INNER JOIN
	    tipo_accidente AS ta ON ta.id = s.tipo_accidente_id
	        INNER JOIN
	    colision AS co ON co.id = s.colision_id
	        INNER JOIN
	    Direccion AS d ON d.altura = s.direccion_altura
	        AND d.camino_id = s.direccion_camino_id
	        INNER JOIN
	    Camino AS c ON c.id = d.camino_id
	        INNER JOIN
	    localidad AS l
	        INNER JOIN
	    registro_calles AS rc ON l.id = rc.camino_id
	        AND rc.localidad_id = l.id
	        INNER JOIN
	    provincia AS prov ON prov.id = l.provincia_id
	        INNER JOIN
	    conclusion AS con ON con.siniestro_id = s.id
	        INNER JOIN
	    victima AS va ON va.conclusion_id = con.id
	        INNER JOIN
	    victimario AS vrio ON vrio.conclusion_id = con.id
	        INNER JOIN
	    (SELECT 
	        COUNT(*) AS 'count'
	    FROM
	        registro_automotor
	    WHERE
	        dni = licencia) AS cantidadV
	WHERE
	    p.dni = licencia
	ORDER BY s.id;
END //


//
CREATE PROCEDURE `incurrencia_tipo_accidente` (IN tipo varchar(255))
BEGIN
	SELECT 
	    p.dni, COUNT(DISTINCT s.id)
	FROM
	    persona p
	        INNER JOIN
	    testigos AS t ON t.dni = p.dni
	        INNER JOIN
	    involucrados AS i ON i.persona_dni = p.dni
	        INNER JOIN
	    siniestro AS s ON s.id = i.siniestro_id
	        OR s.id = t.siniestro_id
	        INNER JOIN
	    tipo_accidente AS ta ON ta.id = s.tipo_accidente_id
	WHERE
	    ta.nombre = tipo
	GROUP BY p.dni
	ORDER BY COUNT(DISTINCT s.id) DESC
END //
