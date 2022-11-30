<?php
include('../conexion/conexion.php');
$data=array();
 global $con;
 $fecha_inicio=$_GET["fecha_inicio"];
 $fecha_fin=$_GET["fecha_fin"];
 $tipo_caso=$_GET["tipo_caso"];
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  g.codigo_dane AS ciudad_conocido,
  DATE_FORMAT(b.fecha_ingreso, '%Y-%m-%d') AS fecha_visita,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,
  o.descripcion AS tipo_vehiculo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  DATE_FORMAT(m.inicio_vigencia, '%Y-%m-%d') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%Y-%m-%d') AS fin_vigencia,
  n.placa,
  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%Y-%m-%d') AS fecha_ingreso,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.edad AS edad_lesionado,
  CASE 
  WHEN b.seguridad_social='1' THEN 'S'
  WHEN b.seguridad_social='2' THEN 'N' else 'N' END AS seguridad_social_lesionado,
  'N' as ingreso_fosyga,
  'N' AS otros_diagnosticos,
  '0' AS costo,
  'S' AS visita_sitio,
  i.lugar_accidente,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
   'N' AS caracteristicas_siniestro,
  b.condicion AS condicion_lesionado,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude, 
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%Y-%m-%d')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  r.codigo_dane AS ciudad_residencia
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN definicion_tipos e ON e.id=c.sexo
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN ciudades g ON g.id=f.ciudad 
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN tipo_vehiculos o ON o.id=n.tipo_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude
  LEFT JOIN ciudades r ON r.id=c.ciudad_residencia
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=2  AND p.id_aseguradora=2  AND u.id_tipo=31 AND u.descripcion=".$tipo_caso." AND e.id_tipo=3 and d.id_tipo=5 AND b.tipo_persona in (1,2) AND mi.id_multimedia = 9 AND a.fecha_cargue BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'";
   $filePath = 'book.xml';
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
   $dom     = new DOMDocument('1.0', 'utf-8'); 
   $root      = $dom->createElement('Investigaciones'); 
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC))
  {
    $investigacion = $dom->createElement('ResultadoInvestigacion');
    $IdCaso     = $dom->createElement('IdCaso', $resArchivoPlanoCensos["consecutivo"]);     
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdCaso->appendChild($domAttribute);
    $investigacion->appendChild($IdCaso); 


    $IdCiudad     = $dom->createElement('IdCiudad', $resArchivoPlanoCensos["ciudad_conocido"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdCiudad->appendChild($domAttribute);
    $investigacion->appendChild($IdCiudad); 


    $FechaConocimiento     = $dom->createElement('FechaConocimiento', $resArchivoPlanoCensos["fecha_ingreso"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'DateTime';
$FechaConocimiento->appendChild($domAttribute);
    $investigacion->appendChild($FechaConocimiento); 
    

    $HoraConocimiento     = $dom->createElement('HoraConocimiento', $resArchivoPlanoCensos["hora_ingreso"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$HoraConocimiento->appendChild($domAttribute);
    $investigacion->appendChild($HoraConocimiento); 


    $TipoVehiculo     = $dom->createElement('TipoVehiculo', $resArchivoPlanoCensos["tipo_vehiculo"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$TipoVehiculo->appendChild($domAttribute);
    $investigacion->appendChild($TipoVehiculo); 


    $PolizaPrefijo     = $dom->createElement('PolizaPrefijo', $resArchivoPlanoCensos["aseguradora"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$PolizaPrefijo->appendChild($domAttribute);
    $investigacion->appendChild($PolizaPrefijo); 
    

    $PolizaNumero     = $dom->createElement('PolizaNumero', $resArchivoPlanoCensos["poliza"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$PolizaNumero->appendChild($domAttribute);
    $investigacion->appendChild($PolizaNumero); 


    $PolizaDv     = $dom->createElement('PolizaDv', $resArchivoPlanoCensos["dig_ver_poliza"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$PolizaDv->appendChild($domAttribute);
    $investigacion->appendChild($PolizaDv); 


    $InicioVigencia     = $dom->createElement('InicioVigencia', $resArchivoPlanoCensos["inicio_vigencia"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'DateTime';
$InicioVigencia->appendChild($domAttribute);
    $investigacion->appendChild($InicioVigencia); 
    

    $FinVigencia     = $dom->createElement('FinVigencia', $resArchivoPlanoCensos["fin_vigencia"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'DateTime';
$FinVigencia->appendChild($domAttribute);
    $investigacion->appendChild($FinVigencia); 


    $Placa     = $dom->createElement('Placa', $resArchivoPlanoCensos["placa"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$Placa->appendChild($domAttribute);
    $investigacion->appendChild($Placa); 
    

    $IdIps     = $dom->createElement('IdIps', $resArchivoPlanoCensos["nit_ips"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdIps->appendChild($domAttribute);
    $investigacion->appendChild($IdIps); 
    

    $FechaIngreso     = $dom->createElement('FechaIngreso', $resArchivoPlanoCensos["fecha_ingreso"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'DateTime';
$FechaIngreso->appendChild($domAttribute);
    $investigacion->appendChild($FechaIngreso); 
    

    $HoraIngreso     = $dom->createElement('HoraIngreso', $resArchivoPlanoCensos["hora_ingreso"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$HoraIngreso->appendChild($domAttribute);
    $investigacion->appendChild($HoraIngreso); 
    

    $NombreLesionado     = $dom->createElement('NombreLesionado', $resArchivoPlanoCensos["nombres_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$NombreLesionado->appendChild($domAttribute);
    $investigacion->appendChild($NombreLesionado); 
    

    $ApellidoLesionado     = $dom->createElement('ApellidoLesionado', $resArchivoPlanoCensos["apellidos_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$ApellidoLesionado->appendChild($domAttribute);
    $investigacion->appendChild($ApellidoLesionado); 


    $IdLesionadoTipo     = $dom->createElement('IdLesionadoTipo', $resArchivoPlanoCensos["tipo_identificacion_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdLesionadoTipo->appendChild($domAttribute);
    $investigacion->appendChild($IdLesionadoTipo); 
    

    $IdLesionadoNumero     = $dom->createElement('IdLesionadoNumero', $resArchivoPlanoCensos["identificacion_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdLesionadoNumero->appendChild($domAttribute);
    $investigacion->appendChild($IdLesionadoNumero); 
    

    $EdadLesionado     = $dom->createElement('EdadLesionado', $resArchivoPlanoCensos["edad_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$EdadLesionado->appendChild($domAttribute);
    $investigacion->appendChild($EdadLesionado); 
    

    $SeguridadSocial     = $dom->createElement('SeguridadSocial', $resArchivoPlanoCensos["seguridad_social_lesionado"]); 
$domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$SeguridadSocial->appendChild($domAttribute);
    $investigacion->appendChild($SeguridadSocial); 
    

    $IdAseguradora     = $dom->createElement('IdAseguradora', $resArchivoPlanoCensos["aseguradora"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdAseguradora->appendChild($domAttribute);
    $investigacion->appendChild($IdAseguradora); 
    

    $IngresoFisalud     = $dom->createElement('IngresoFisalud', $resArchivoPlanoCensos["ingreso_fosyga"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IngresoFisalud->appendChild($domAttribute);
    $investigacion->appendChild($IngresoFisalud); 
    

    $LugarAccidente     = $dom->createElement('LugarAccidente', $resArchivoPlanoCensos["lugar_accidente"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$LugarAccidente->appendChild($domAttribute);
    $investigacion->appendChild($LugarAccidente); 
    

    $FechaAccidente     = $dom->createElement('FechaAccidente', $resArchivoPlanoCensos["fecha_accidente"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'DateTime';
$FechaAccidente->appendChild($domAttribute);
    $investigacion->appendChild($FechaAccidente); 
    

    $HoraAccidente     = $dom->createElement('HoraAccidente', $resArchivoPlanoCensos["hora_accidente"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$HoraAccidente->appendChild($domAttribute);
    $investigacion->appendChild($HoraAccidente); 
    

    $CaracteristicasSiniestro     = $dom->createElement('CaracteristicasSiniestro', $resArchivoPlanoCensos["caracteristicas_siniestro"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$CaracteristicasSiniestro->appendChild($domAttribute);
    $investigacion->appendChild($CaracteristicasSiniestro); 
    

    $CondicionVictima     = $dom->createElement('CondicionVictima', $resArchivoPlanoCensos["condicion_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$CondicionVictima->appendChild($domAttribute);
    $investigacion->appendChild($CondicionVictima); 
    

    $OtrosDiagnosticos     = $dom->createElement('OtrosDiagnosticos', $resArchivoPlanoCensos["otros_diagnosticos"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$OtrosDiagnosticos->appendChild($domAttribute);
    $investigacion->appendChild($OtrosDiagnosticos); 


    $CostoAtencion     = $dom->createElement('CostoAtencion', $resArchivoPlanoCensos["costo"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$CostoAtencion->appendChild($domAttribute);
    $investigacion->appendChild($CostoAtencion); 
    

    $VisitaSitio     = $dom->createElement('VisitaSitio', $resArchivoPlanoCensos["visita_sitio"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$VisitaSitio->appendChild($domAttribute);
    $investigacion->appendChild($VisitaSitio); 
    

    $Pruebas     = $dom->createElement('Pruebas', $resArchivoPlanoCensos["caracteristicas_siniestro"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$Pruebas->appendChild($domAttribute);
    $investigacion->appendChild($Pruebas); 
    

    $CubiertoAseguradora     = $dom->createElement('CubiertoAseguradora', $resArchivoPlanoCensos["resultado_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$CubiertoAseguradora->appendChild($domAttribute);
    $investigacion->appendChild($CubiertoAseguradora); 
    

    $IdMotivoObjecion     = $dom->createElement('IdMotivoObjecion', $resArchivoPlanoCensos["indicador_fraude"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdMotivoObjecion->appendChild($domAttribute);
    $investigacion->appendChild($IdMotivoObjecion); 
    

    $ValorFraude     = $dom->createElement('ValorFraude', $resArchivoPlanoCensos["costo"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$ValorFraude->appendChild($domAttribute);
    $investigacion->appendChild($ValorFraude); 
    

    $IdUsuario     = $dom->createElement('IdUsuario', $resArchivoPlanoCensos["nombre_investigador"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$IdUsuario->appendChild($domAttribute);
    $investigacion->appendChild($IdUsuario); 
    

    $Observaciones     = $dom->createElement('Observaciones', $resArchivoPlanoCensos["observaciones"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$Observaciones->appendChild($domAttribute);
    $investigacion->appendChild($Observaciones); 
    

    $Eps     = $dom->createElement('Eps', $resArchivoPlanoCensos["eps"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$Eps->appendChild($domAttribute);
    $investigacion->appendChild($Eps); 


    $FechaRegistro     = $dom->createElement('FechaRegistro', $resArchivoPlanoCensos["fecha_plano"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'DateTime';
$FechaRegistro->appendChild($domAttribute);
    $investigacion->appendChild($FechaRegistro); 
    

    $Genero     = $dom->createElement('Genero', $resArchivoPlanoCensos["sexo"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$Genero->appendChild($domAttribute);
    $investigacion->appendChild($Genero); 
    

    $Ciudad1     = $dom->createElement('Ciudad1', $resArchivoPlanoCensos["codigo_ciudad_ocurrencia"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$Ciudad1->appendChild($domAttribute);
    $investigacion->appendChild($Ciudad1);


    $TelefonoAfectado     = $dom->createElement('TelefonoAfectado', $resArchivoPlanoCensos["telefono_lesionado"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$TelefonoAfectado->appendChild($domAttribute);
    $investigacion->appendChild($TelefonoAfectado); 
    

    $NombreIPS     = $dom->createElement('NombreIPS', $resArchivoPlanoCensos["nombre_ips"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$NombreIPS->appendChild($domAttribute);
    $investigacion->appendChild($NombreIPS); 
    

    $CiudadIPS     = $dom->createElement('CiudadIPS', $resArchivoPlanoCensos["ciudad_ips"]); 
    $domAttribute = $dom->createAttribute('Type');
$domAttribute->value = 'VarChar';
$CiudadIPS->appendChild($domAttribute);
    $investigacion->appendChild($CiudadIPS); 
    
    $root->appendChild($investigacion);

  }
   $dom->appendChild($root); 

$name="arcXML ".$fecha_inicio." A ".$fecha_fin.".xml";
   header('Content-Disposition: attachment;filename=' . $name);
    header('Content-Type: text/xml');

    echo $dom->saveXML();


?>