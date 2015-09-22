-- Consulta por número de licencia: obtener, con un número de licencia específico,
-- información sobre los accidentes en los que ha participado el conductor propietario de
-- la misma, con detalles de fecha, lugar, tipo de accidente, participación y modalidad.

SELECT pl.dni AS "Licencia", s.fecha_hora "Fecha y Hora del accidente", direccion_camino_id AS "Calle/Camino", direccion_altura AS "Altura",s.tipo_accidente_id AS "Tipo de accidente",(pl.dni = v.dni) AS "Es victima",(pl.dni = vm.dni) AS "Es victimario" FROM persona_con_licencia pl LEFT JOIN victima v ON pl.dni = v.dni LEFT JOIN victimario vm ON pl.dni = vm.dni INNER JOIN conclusion c ON c.id = v.conclusion_id or c.id = vm.conclusion_id INNER JOIN siniestro s ON c.siniestro_id = s.id WHERE v.dni != vm.dni != NULL AND pl.dni = 1;

-- También se deberá indicar la cantidad de automóviles que está habilitado a conducir.
SELECT dni, COUNT(matricula) FROM registro_automotor WHERE dni=1

