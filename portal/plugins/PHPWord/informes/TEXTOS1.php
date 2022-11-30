SELECT a.codigo,a.id as id_caso,CONCAT(d.nombres,' ',d.apellidos) as nombre_lesionado,CONCAT(e.descripcion,' ',d.identificacion) as identificacion_lesionado,f.nombre_ips,k.placa,k.marca,k.modelo,k.linea,k.color,k.numero_vin,k.numero_serie,k.numero_motor,k.numero_chasis,l.descripcion as tipo_servicio,c.resultado,
CONCAT(UPPER(LEFT(h.nombre, 1)), LOWER(SUBSTRING(h.nombre, 2))) as departamento_ips,
CONCAT(UPPER(LEFT(g.nombre, 1)), LOWER(SUBSTRING(g.nombre, 2))) as ciudad_ips,m.responsable,j.numero as numero_poliza,j.inicio_vigencia,j.fin_vigencia,l.descripcion as tipo_vehiculo,b.fecha_accidente,c.fecha_ingreso,c.fecha_egreso,q.descripcion as indicador_fraude,m.id as id_aseguradora,c.indicador_fraude as id_indicador_fraude,
case 
m.cargo is null then 'N' else m.cargo end as cargo,d.ocupacion,d.edad,d.direccion_residencia,
CONCAT(CONCAT(UPPER(LEFT(n.nombre, 1)), LOWER(SUBSTRING(h.nombre, 2))),' - ',
CONCAT(UPPER(LEFT(o.nombre, 1)), LOWER(SUBSTRING(g.nombre, 2)))) AS ciudad_residencia,d.barrio,d.telefono,c.condicion,c.servicio_ambulancia,c.tipo_traslado_ambulancia,c.lugar_traslado,c.tipo_vehiculo_traslado,c.lesiones,c.tratamiento,c.relato,r.descripcion2 as seguridad_social,c.seguridad_social as id_seguridad_social,c.eps,c.regimen,c.estado as estado_eps,c.causal_consulta,b.lugar_accidente,b.visita_lugar_hechos,b.punto_referencia,b.registro_autoridades,b.diligencia_formato_declaracion,b.id_diligencia_formato,b.furips,
j.nombre_tomador,concat(s.descripcion,' ',j.identificacion_tomador) as identificacion_tomador,j.telefono_tomador,j.direccion_tomador,concat(u.nombre,' - ',t.nombre) as ciudad_tomador,concat(v.nombre,' - ',w.nombre) as ciudad_expedicion_poliza,b.resultado_diligencia_tomador,b.observaciones_diligencia_tomador,y.descripcion2 as descripcion_diligencia_tomador
FROM investigaciones a
LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
LEFT JOIN personas d ON d.id=c.id_persona
LEFT JOIN definicion_tipos e ON e.id=d.tipo_identificacion
LEFT JOIN ips f ON f.id=c.ips
LEFT JOIN ciudades g ON g.id=f.ciudad
LEFT JOIN departamentos h ON h.id=g.id_departamento
LEFT JOIN poliza_vehiculo i ON i.id_poliza=b.id_poliza
LEFT JOIN polizas j ON j.id=i.id_poliza
LEFT JOIN vehiculos k ON k.id=i.id_vehiculo
LEFT JOIN tipo_vehiculos l ON l.id=k.tipo_vehiculo
LEFT JOIN aseguradoras m ON m.id=a.id_aseguradora
LEFT JOIN ciudades n ON n.id=d.ciudad_residencia
LEFT JOIN departamentos o ON o.id=n.id_departamento
LEFT JOIN definicion_tipos p ON p.id=k.tipo_servicio
LEFT JOIN definicion_tipos q ON q.id=c.indicador_fraude
LEFT JOIN definicion_tipos r ON r.id=c.seguridad_social
LEFT JOIN definicion_tipos s ON s.id=j.tipo_identificacion_tomador
LEFT JOIN ciudades t ON r.id=j.ciudad_tomador
LEFT JOIN departamentos u ON u.id=t.id_departamento
LEFT JOIN ciudades v ON v.id=j.ciudad_expedicion
LEFT JOIN departamentos w ON w.id=v.id_departamento
LEFT JOIN definicion_tipos y ON y.id=b.resultado_diligencia_tomador
WHERE e.id_tipo=5 and c.tipo_persona=1 and p.id_tipo=21 and a.id=1 and q.id_tipo=12 and r.id_tipo=17 and y.id_tipo=38




SELECT CONCAT(d.nombres,' ',d.apellidos) as nombre_lesionado,concat(e.descripcion,' ',d.identificacion) as identificacion_lesionado,f.nombre_ips,d.ocupacion,d.edad,d.direccion_residencia,concat(g.nombre,' - ',h.nombre) as ciudad,d.telefono,c.condicion,c.lesiones,c.tratamiento,f.nombre_ips                                           
		FROM 
		investigaciones a
		LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
		LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
		LEFT JOIN personas d ON d.id=c.id_persona
		LEFT JOIN definicion_tipos e ON e.id=d.tipo_identificacion
		LEFT JOIN ips f ON f.id=c.ips
		LEFT JOIN ciudades g ON g.id=d.ciudad_residencia
		LEFT JOIN departamentos h ON h.id=g.id_departamento
		WHERE e.id_tipo=5