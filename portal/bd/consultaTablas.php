<?php
include('../conexion/conexion.php');
$hoy = date("Y-m-d");
session_start();

function consultarTipoCasosAseguradoraCuentaCobro($idCuentaCobro){
  global $con;
  $consultaTipoCasoAseguradoraCuentaCobro="(SELECT CONCAT(b.nombre_aseguradora,'-',d.descripcion,'-',g.descripcion) AS aseguradora_tipo_caso,COUNT(a.id) AS cantidad_investigaciones,CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,e.tipo_caso,e.id_aseguradora,e.tipo_perimetro,e.tipo_auditoria,e.resultado
  FROM 
  investigaciones a 
  LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id 
  LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso 
  LEFT JOIN definicion_tipos d ON d.id=c.descripcion
  LEFT JOIN detalle_cuenta_cobro_investigadores e ON e.id_investigacion=a.id
  LEFT JOIN cuenta_cobro_investigadores f ON f.id=e.id_cuenta_cobro
  LEFT JOIN definicion_tipos g ON g.id=e.resultado
  WHERE g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado=3
  GROUP BY b.id,d.id,g.id)
  
  UNION
  
  (SELECT CONCAT(b.nombre_aseguradora,'-',d.descripcion,'-',g.descripcion,'-',h.descripcion,'-',i.descripcion) AS aseguradora_tipo_caso,COUNT(a.id) AS cantidad_investigaciones,CASE WHEN e.valor_investigacion IS NULL THEN '0' ELSE e.valor_investigacion END AS valor_investigacion,e.tipo_caso,e.id_aseguradora,e.tipo_perimetro,e.tipo_auditoria,e.resultado
  FROM 
  investigaciones a 
  LEFT JOIN aseguradoras b ON a.id_aseguradora=b.id 
  LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso 
  LEFT JOIN definicion_tipos d ON d.id=c.descripcion
  LEFT JOIN detalle_cuenta_cobro_investigadores e ON e.id_investigacion=a.id
  LEFT JOIN cuenta_cobro_investigadores f ON f.id=e.id_cuenta_cobro
  LEFT JOIN definicion_tipos g ON g.id=e.resultado
  LEFT JOIN definicion_tipos h ON h.id=e.tipo_auditoria
  LEFT JOIN definicion_tipos i ON i.id=e.tipo_perimetro
  WHERE i.id_tipo=46 AND h.id_tipo=45 AND g.id_tipo=44 AND c.id_tipo=43 AND d.id_tipo=42 AND f.id='".$idCuentaCobro."' AND e.resultado<>3
  GROUP BY b.id,d.id,g.id,h.id,i.id)";

    $queryTipoCasoAseguradoraCuentaCobro=mysqli_query($con,$consultaTipoCasoAseguradoraCuentaCobro);
    $data=array();

    while ($resTipoCasoAseguradoraCuentaCobro=mysqli_fetch_array($queryTipoCasoAseguradoraCuentaCobro,MYSQLI_ASSOC))   {
      $data[]=array("aseguradora_tipo_caso"=>$resTipoCasoAseguradoraCuentaCobro["aseguradora_tipo_caso"],
        "cantidad_investigaciones"=>"<input disabled class='CamNum input-sm form-control-sm form-control'  type='text' id='cantidadInvestigacionesAseguradoraCuentaCobro' value='".$resTipoCasoAseguradoraCuentaCobro["cantidad_investigaciones"]."' name='".$resTipoCasoAseguradoraCuentaCobro["tipo_caso"]."'>",
        "valor_caso"=>"<input class='CamNum input-sm form-control-sm form-control'  type='text' id='valorCasoInvestigacionesAseguradoraCuentaCobro' value='".$resTipoCasoAseguradoraCuentaCobro["valor_investigacion"]."' name='".$resTipoCasoAseguradoraCuentaCobro["tipo_caso"]."'>",
        "valor_total"=>"<input class='CamNum input-sm form-control-sm form-control' type='text' id='valorTotalInvestigacionesAseguradoraCuentaCobro' value='".($resTipoCasoAseguradoraCuentaCobro["cantidad_investigaciones"]*$resTipoCasoAseguradoraCuentaCobro["valor_investigacion"])."' name='".$resTipoCasoAseguradoraCuentaCobro["tipo_caso"]."'>",
        "id_aseguradora"=>$resTipoCasoAseguradoraCuentaCobro["id_aseguradora"],
        "id_tipo_caso"=>$resTipoCasoAseguradoraCuentaCobro["tipo_caso"],
        "id_resultado"=>$resTipoCasoAseguradoraCuentaCobro["resultado"],
        "id_tipo_zona"=>$resTipoCasoAseguradoraCuentaCobro["tipo_perimetro"],
        "id_tipo_auditoria"=>$resTipoCasoAseguradoraCuentaCobro["tipo_auditoria"]
      );
    }
    
    $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
    );

    echo json_encode($results); 
}

function consultarCuentaCobroInvestigadores($idPeriodo){
  global $con;
  $consultaCCInvestigadores="SELECT a.valor_investigaciones,a.valor_biaticos,a.valor_adicionales,a.valor_total,CONCAT(b.nombres,' ',b.apellidos) as nombre_investigador,CONCAT(c.descripcion,' ',b.identificacion) as identificacion_investigador,a.id as id_cuenta_cobro,b.id as id_investigador,a.vigente as vigente_Cuenta_cobro FROM cuenta_cobro_investigadores a LEFT JOIN investigadores b on a.id_investigador=b.id LEFT JOIN definicion_tipos c on c.id=b.tipo_identificacion where c.id_tipo=5 and a.id_periodo='".$idPeriodo."'";
  $queryCCInvestigadores=mysqli_query($con,$consultaCCInvestigadores);
  $data=array();
  
  while ($resCCInvestigadores=mysqli_fetch_array($queryCCInvestigadores,MYSQLI_ASSOC)){
    $cantidadInvestigacionesCuentaCobro="SELECT COUNT(id) as cantidad_investigaciones_cuenta_cobro FROM detalle_cuenta_cobro_investigadores where id_cuenta_cobro='".$resCCInvestigadores["id_cuenta_cobro"]."'";
    mysqli_next_result($con);
    $queryInvestigacionesCuentaCobro=mysqli_query($con,$cantidadInvestigacionesCuentaCobro);
    $resInvestigacionesCuentaCobro=mysqli_fetch_assoc($queryInvestigacionesCuentaCobro);
    $opciones="<div class='btn-group'>";

    if ($resCCInvestigadores["vigente_Cuenta_cobro"]=="s"){
      $opciones.="<button type='button' class='btn btn-success' name='".$resCCInvestigadores["id_cuenta_cobro"]."' id='btnAccionesGestionUsuario'>OPCIONES</button><button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPeriodosCCInvestigadores["id_cuenta_cobro"]."' id='btnAccionesGestionUsuario2'>";
    }else if ($resCCInvestigadores["vigente_Cuenta_cobro"]=="n"){
      $opciones.="<button type='button' class='btn btn-danger' name='".$resCCInvestigadores["id_cuenta_cobro"]."' id='btnAccionesGestionUsuario'>OPCIONES</button><button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPeriodosCCInvestigadores["id_cuenta_cobro"]."' id='btnAccionesGestionUsuario2'>";
    }
  
    $opciones.="<span class='caret'></span>
      <span class='sr-only'>Toggle Dropdown</span>
      </button>
      <ul class='dropdown-menu' role='menu'>
      <li><a name='".$resCCInvestigadores["id_cuenta_cobro"]."' id='btnIngresarValoresCuentaCobroInvestigadores'>Ingresar Valores</a></li>
      <li><a name='".$resCCInvestigadores["id_cuenta_cobro"]."' id='btnCerrarCuentaCobroInvestigadores'>Habilitar/Deshabilitar Cuenta</a></li>
      <li><a name='".$resCCInvestigadores["id_cuenta_cobro"]."' id='btnVerCuentaCobroInvestigadores'>Ver Cuenta</a></li>
    </ul></div>";

    $data[]=array("nombre_investigador"=>$resCCInvestigadores["nombre_investigador"],
      "identificacion_investigador"=>$resCCInvestigadores["identificacion_investigador"],
      "cantidad_investigaciones"=>$resInvestigacionesCuentaCobro["cantidad_investigaciones_cuenta_cobro"],
      "valor_investigaciones"=>$resCCInvestigadores["valor_investigaciones"],
      "valor_biaticos"=>$resCCInvestigadores["valor_biaticos"],
      "valor_adicionales"=>$resCCInvestigadores["valor_adicionales"],
      "valor_total"=>$resCCInvestigadores["valor_total"],
      "opciones"=>$opciones    
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  
  echo json_encode($results); 
}

function consultarPeriodosCuentaCobroInvestigadores(){
  global $con;
  $consultaPeriodosCCInvestigadores="SELECT * FROM periodos_cuenta_cobro_investigadores";
  $queryPeriodosCCInvestigadores=mysqli_query($con,$consultaPeriodosCCInvestigadores);
    $data=array();
  
  while ($resPeriodosCCInvestigadores=mysqli_fetch_array($queryPeriodosCCInvestigadores,MYSQLI_ASSOC)){
    $opciones="<div class='btn-group'>";
    if ($resPeriodosCCInvestigadores["vigente"]=="s"){
        $opciones.="<button type='button' class='btn btn-success' name='".$resPeriodosCCInvestigadores["id"]."' id='btnAccionesGestionUsuario'>OPCIONES</button><button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPeriodosCCInvestigadores["id"]."' id='btnAccionesGestionUsuario2'>";
    }else{
        $opciones.="<button type='button' class='btn btn-danger' name='".$resPeriodosCCInvestigadores["id"]."' id='btnAccionesGestionUsuario'>OPCIONES</button><button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPeriodosCCInvestigadores["id"]."' id='btnAccionesGestionUsuario2'>";
    }
  
    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resPeriodosCCInvestigadores["id"]."' id='btnRevisarCCInvestigadoress'>Revisar Cuenta Cobros</a></li>
    <li><a name='".$resPeriodosCCInvestigadores["id"]."' id='btnModificarPeriodosCCInvestigadoress'>Modificar</a></li>
    <li><a name='".$resPeriodosCCInvestigadores["id"]."' id='btnVigenciaPeriodosCCInvestigadoress'>Habilitar/Deshabilitar</a></li>
    <li><a name='".$resPeriodosCCInvestigadores["id"]."' id='btnEliminarPeriodosCCInvestigadoress'>Eliminar</a></li>
  </ul></div>";

  $data[]=array("descripcion"=>$resPeriodosCCInvestigadores["descripcion"],
    "opciones"=>$opciones
    );
  }

  $results = array(
  "sEcho" => 1,
  "iTotalRecords" => count($data),
  "iTotalDisplayRecords" => count($data),
  "aaData" => $data
  );
  echo json_encode($results); 
}

function archivoPlanoIncapacidadesSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="SELECT  
  f.nombre_ips AS nombre_ips,
  f.identificacion AS nit_ips,
  c.nombres AS nombres_lesionado,  
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,
  n.placa,
  b.condicion AS condicion_lesionado,
  m.numero AS poliza,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  IF(mi.ruta IS NULL, CONCAT(i.hechos,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',i.hechos,'. ',i.conclusiones)) AS observaciones,
  CASE   WHEN b.resultado='1' THEN 'CUBIERTO'  WHEN b.resultado='2' THEN 'NO CUBIERTO' END AS resultado_lesionado,
  a.codigo AS consecutivo
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND u.id_tipo=31 AND u.descripcion=4 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
     $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
                   "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
                   "placa"=>$resArchivoPlanoCensos["placa"],
                   "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
                   "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
                   "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
                   "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
                   "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
                   "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
                   "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
                   "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
                   "observaciones"=>$resArchivoPlanoCensos["observaciones"],
                   "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
                   "numero_factura"=>""
                    );
  }
   $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
        );
  return json_encode($results); 
}

function archivoPlanoMuerteSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  
  $consultaArchivoPlanoCensos="SELECT  
  f.nombre_ips AS nombre_ips,
  f.identificacion AS nit_ips,
  c.nombres AS nombres_lesionado,  
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,
  n.placa,
  b.condicion AS condicion_lesionado,
  m.numero AS poliza,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  IF(mi.ruta IS NULL, CONCAT(i.hechos,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',i.hechos,'. ',i.conclusiones)) AS observaciones,
  CASE   WHEN b.resultado='1' THEN 'CUBIERTO'  WHEN b.resultado='2' THEN 'NO CUBIERTO' END AS resultado_lesionado,
  a.codigo AS consecutivo
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND u.id_tipo=31 AND u.descripcion=3 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "observaciones"=>$resArchivoPlanoCensos["observaciones"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "numero_factura"=>""
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function archivoPlanoGastosMedicosSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
    $data=array();
  $consultaArchivoPlanoCensos="SELECT  
  f.nombre_ips AS nombre_ips,
  f.identificacion AS nit_ips,
  c.nombres AS nombres_lesionado,  
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,
  n.placa,
  b.condicion AS condicion_lesionado,
  m.numero AS poliza,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  CASE   WHEN b.resultado='1' THEN 'CUBIERTO'  WHEN b.resultado='2' THEN 'NO CUBIERTO' END AS resultado_lesionado,
  a.codigo AS consecutivo
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND u.id_tipo=31 AND u.descripcion=2 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "observaciones"=>$resArchivoPlanoCensos["observaciones"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "numero_factura"=>""
    );
  }
  
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function archivoPlanoSIRASEstado($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
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
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  '0' AS valor_fraude,
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
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=2  AND p.id_aseguradora=2  AND u.id_tipo=31 AND u.descripcion=17 AND e.id_tipo=3 and d.id_tipo=5 AND b.tipo_persona in (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
     $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
                   "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
                   "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
                   "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
                   "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
                   "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
                   "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
                   "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
                   "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
                   "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
                   "placa"=>$resArchivoPlanoCensos["placa"],
                   "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
                   "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
                   "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
                   "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
                   "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
                   "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
                   "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
                   "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
                   "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
                   "aseguradora2"=>$resArchivoPlanoCensos["aseguradora"],
                   "ingreso_fosyga"=>$resArchivoPlanoCensos["ingreso_fosyga"],
                   "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
                   "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
                   "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
                   "pruebas"=>$resArchivoPlanoCensos["pruebas"],
                   "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
                   "otros_diagnosticos"=>$resArchivoPlanoCensos["otros_diagnosticos"],
                   "costo"=>$resArchivoPlanoCensos["costo"],
                   "visita_sitio"=>$resArchivoPlanoCensos["visita_sitio"],
                   "pruebas2"=>$resArchivoPlanoCensos["pruebas"],
                   "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
                   "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
                   "valor_fraude"=>$resArchivoPlanoCensos["valor_fraude"],
                   "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
                   "observaciones"=>$resArchivoPlanoCensos["observaciones"],
                   "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
                   "nombre_eps"=>$resArchivoPlanoCensos["eps"],
                   
                   "sexo"=>$resArchivoPlanoCensos["sexo"],
                   "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
                   "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
                   "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
                   "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"],
                   "ciudad_residencia_lesionado"=>$resArchivoPlanoCensos["ciudad_residencia"]
                    );
  }
   $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
        );
  return json_encode($results); 
}

function archivoPlanoCensosAsignadoSolidaria2($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
    $data=array();
  $consultaArchivoPlanoCensos="SELECT  
  f.nombre_ips AS nombre_ips,
  f.identificacion AS nit_ips,
  c.nombres AS nombres_lesionado,  
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,
  n.placa,
  b.condicion AS condicion_lesionado,
  m.numero AS poliza,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  CASE   WHEN b.resultado='1' THEN 'CUBIERTO'  WHEN b.resultado='2' THEN 'NO CUBIERTO' END AS resultado_lesionado,
  a.codigo AS consecutivo
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND u.id_tipo=31 AND u.descripcion=10 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
     $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
                   "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
                   "placa"=>$resArchivoPlanoCensos["placa"],
                   "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
                   "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
                   "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
                   "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
                   "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
                   "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
                   "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
                   "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
                   "observaciones"=>$resArchivoPlanoCensos["observaciones"],
                   "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
                   "numero_factura"=>""
                    );
  }
   $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
        );
  return json_encode($results); 
}

function archivoPlanoCensosSolidaria2($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
    $data=array();
  $consultaArchivoPlanoCensos="SELECT  
  f.nombre_ips AS nombre_ips,
  f.identificacion AS nit_ips,
  c.nombres AS nombres_lesionado,  
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,
  n.placa,
  b.condicion AS condicion_lesionado,
  m.numero AS poliza,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  CASE   WHEN b.resultado='1' THEN 'CUBIERTO'  WHEN b.resultado='2' THEN 'NO CUBIERTO' END AS resultado_lesionado,
  a.codigo AS consecutivo
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND u.id_tipo=31 AND u.descripcion=9 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  if ($tipoGenerarArchivoPlano=="rangoFecha")
  {
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso")
  {
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC))
  {
     $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
                   "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
                   "placa"=>$resArchivoPlanoCensos["placa"],
                   "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
                   "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
                   "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
                   "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
                   "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
                   "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
                   "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
                   "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
                   "observaciones"=>$resArchivoPlanoCensos["observaciones"],
                   "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
                   "numero_factura"=>""
                    );
  }
   $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
        );
  return json_encode($results); 
}

function consultarCasosSOATHistorico($codigoFrmBuscarSOAT,$nombresFrmBuscarSOAT,$apellidosFrmBuscarSOAT,$identificacionFrmBuscarSOAT,$placaFrmBuscarSOAT,$polizaFrmBuscarSOAT,$identificadorFrmBuscarSOAT,$tipoConsultaBuscar,$usuario){
  $con2= mysqli_connect("localhost","grbd","Global.2021","ltdaglob_u7365390");

  mysqli_set_charset($con2, "utf8");
  if (!$con2) {
    die("Connection failed: " . mysqli_connect_error());
  }

  global $con;

  $consultarTipoUsuario=mysqli_query($con,"SELECT * FROM usuarios WHERE id='".$usuario."'");
  $resTipoUsuario=mysqli_fetch_array($consultarTipoUsuario,MYSQLI_ASSOC);

  mysqli_next_result($con);
  $regs="";
  $data=array();

  if ($tipoConsultaBuscar=="buscarCasosFiltrosHistorico"){

    $consultarFiltrosSOAT="SELECT e.descripcion AS caso,h.nombre as nombre_aseguradora,a.tipo_solicitud,a.codigo as consecutivo,a.tipo_solicitud as tipo_solicitud2,
    c.nombre as ips, a.fecha_accidente,
    a.id,a.poliza,a.placa,a.concepto,concat(b.nombres,' ',b.apellidos) as nombre_completo,
    concat(d.descripcion2,' ',b.identificacion) as identificacion,f.descripcion as tipo_solicitud,case when g.url_informe is null then 'N' else g.url_informe end as informe
    from informe a 
    left join otros_lesionados b on a.id=b.id_informe 
    left join clinica c on b.ips_atencion=c.id 
    left join definicion_tipos d on d.id=b.tipo_identificacion 
    left join definicion_tipos e on e.id=a.asignado
    left join definicion_tipos f on f.id=a.tipo_solicitud
    LEFT JOIN up_pdf g ON g.id_informe=a.id
    LEFT JOIN aseguradora h ON a.id_aseguradora=h.id
    where f.id_tipo=2 and e.id_tipo=3 and d.id_tipo=1 and a.asignado in (4,1,2,5,3,6,9,10,19,20,21,14) and b.les_prin=1";

    $cont=0;
    $id_aseguradora_usuario = $resTipoUsuario["id_aseguradora"];

    switch ($id_aseguradora_usuario) {
      case 2:
        //ESTADO
        $id_aseguradora_usuario = 3;
        break;

      case 5:
        //EQUIDAD
        $id_aseguradora_usuario = 4;
        break;

      case 4:
        //Allianz
        $id_aseguradora_usuario = 5;
        break;

      case 8:
        //LIBERTY
        $id_aseguradora_usuario = 6;
        break;

      case 3:
        //QBE
        $id_aseguradora_usuario = 8;
        break;

      case 7:
        //SOLIDARIA
        $id_aseguradora_usuario = 9;
        break;

      case 6:
        //AXA
        $id_aseguradora_usuario = 10;
        break;
    }

    if ($resTipoUsuario["tipo_usuario"]==4){
      $consultarFiltrosSOAT.=" AND ";

      $consultarFiltrosSOAT.=" a.id_aseguradora='".$id_aseguradora_usuario."'";
      $cont++;
    }


    if ($codigoFrmBuscarSOAT!=""){
      $consultarFiltrosSOAT.=" AND ";

      $consultarFiltrosSOAT.=" a.codigo='".$codigoFrmBuscarSOAT."'";
      $cont++;
    }
    else{

      if ($nombresFrmBuscarSOAT!=""){
        $consultarFiltrosSOAT.=" AND ";
        $consultarFiltrosSOAT.=" b.nombres like '%".$nombresFrmBuscarSOAT."%'";
        $cont++;
      }else if ($apellidosFrmBuscarSOAT!=""){
        $consultarFiltrosSOAT.=" AND ";
        $consultarFiltrosSOAT.=" b.apellidos LIKE '%".$apellidosFrmBuscarSOAT."%'";
        $cont++;
      }else if ($identificacionFrmBuscarSOAT!=""){
        $consultarFiltrosSOAT.=" AND ";
        $consultarFiltrosSOAT.=" b.identificacion LIKE '%".$identificacionFrmBuscarSOAT."%'";
        $cont++;
      }else if ($placaFrmBuscarSOAT!=""){
        $consultarFiltrosSOAT.=" AND ";
        $consultarFiltrosSOAT.=" a.placa LIKE '%".$placaFrmBuscarSOAT."%'";            
        $cont++;
      }else if ($polizaFrmBuscarSOAT!=""){
        $consultarFiltrosSOAT.=" AND ";
        $consultarFiltrosSOAT.=" a.poliza like '%".$polizaFrmBuscarSOAT."%'";            
        $cont++;
      }else if ($identificadorFrmBuscarSOAT!=""){
        $consultarFiltrosSOAT.=" AND ";
        $consultarFiltrosSOAT.=" a.radicado='".$identificadorFrmBuscarSOAT."'";            
        $cont++;
      }
    }

    $queryConsultaHistorico=mysqli_query($con2,$consultarFiltrosSOAT);

    while ($resConsultaHistocio=mysqli_fetch_assoc($queryConsultaHistorico)){

      $informacionGeneral="";
      $opciones="";
      $opciones.="<div class='btn-group'>";

      $opciones.="<button type='button' class='btn btn-success' name='".$resConsultaHistocio["id"]."'>";

      if ($resConsultaHistocio["informe"]!="N"){
        $opciones.="<span class='fa fa-file-pdf-o'></span>";
      }

      $opciones.=$resConsultaHistocio["consecutivo"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resConsultaHistocio["id"]."'>";

      $opciones.="<span class='caret'></span>
      <span class='sr-only'>Toggle Dropdown</span>
      </button>
      <ul class='dropdown-menu' role='menu'>";

      if ($resConsultaHistocio["informe"]!="N"){
        $opciones.="<li><a target='_blank' href='".$resConsultaHistocio["informe"].'?'.time()."'>Ver Informe</a></li>";  
      }

      $opciones.="</ul></div>";

      $informacionGeneral.="<b>Aseguradora: </b>".$resConsultaHistocio["nombre_aseguradora"]."<br><b>Tipo de Caso: </b>".$resConsultaHistocio["caso"]."<br><b>Tipo de Solicitud: </b>".$resConsultaHistocio["tipo_solicitud"]; 

      $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
        "VictimaCasosSoat"=>"<b>Nombre: </b>".$resConsultaHistocio["nombre_completo"]."<br><b>Identificacion: </b>".$resConsultaHistocio["identificacion"]."<br><b>Reclamante: </b>".$resConsultaHistocio["ips"],
        "SiniestroCasosSoat"=>"<b>Fecha de Accidente: </b>".$resConsultaHistocio["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resConsultaHistocio["placa"]."<br>"."<b>Poliza: </b>".$resConsultaHistocio["poliza"]."<br>"."<b>Resultado: </b>".$resConsultaHistocio["concepto"],
        "opciones"=>$opciones); 
    }
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);

  mysql_close($con2);
}

function replacePipe($texto){
  if($texto != '' && $texto != NULL){
    $texto = str_replace("|", "/", $texto);
  }
  return $texto;
}

function reportCasosDiariosAnalista($fechaInicioCasosDiarioAnalista,$fechaFinCasosDiarioAnalista,$idAnalistaCasosDiarioAnalista){

  global $con;
  $data=array();

  $consultarCasosDiariosAnalistas="SELECT 'PLANILLADO' AS origen,i.codigo,i.id, CONCAT(u.nombres, ' ', u.apellidos) AS analista, ei.fecha
  FROM investigaciones i
  LEFT JOIN estado_investigaciones ei ON ei.id_investigacion = i.id AND ei.estado = 19
  LEFT JOIN usuarios u ON u.id = ei.usuario
  WHERE DATE_FORMAT(ei.fecha, '%Y-%m-%d') BETWEEN '$fechaInicioCasosDiarioAnalista' AND '$fechaFinCasosDiarioAnalista' AND ei.inicial = 's' AND i.id NOT IN (
  SELECT ei1.id_investigacion
  FROM estado_investigaciones ei1
  WHERE DATE_FORMAT(ei1.fecha, '%Y-%m-%d') BETWEEN '$fechaInicioCasosDiarioAnalista' AND '$fechaFinCasosDiarioAnalista' AND ei1.estado = 11";

  if ($idAnalistaCasosDiarioAnalista<>0){
    $consultarCasosDiariosAnalistas.=" AND ei1.usuario='$idAnalistaCasosDiarioAnalista'";
  }

  $consultarCasosDiariosAnalistas.=")";
  if ($idAnalistaCasosDiarioAnalista<>0){
    $consultarCasosDiariosAnalistas.=" AND ei.usuario='$idAnalistaCasosDiarioAnalista'";
  }

  $consultarCasosDiariosAnalistas.=" UNION ";
  $consultarCasosDiariosAnalistas.="SELECT 'INFORME' AS origen,i.codigo,i.id, CONCAT(u.nombres, ' ', u.apellidos) AS analista,mi.fecha AS fecha
  FROM investigaciones i
  LEFT JOIN estado_investigaciones ei ON i.id=ei.id_investigacion
  LEFT JOIN multimedia_investigacion mi ON mi.id_multimedia = 9 AND mi.id_investigacion = i.id
  LEFT JOIN usuarios u ON u.id = mi.usuario
  WHERE DATE_FORMAT(mi.fecha, '%Y-%m-%d') BETWEEN '$fechaInicioCasosDiarioAnalista' AND '$fechaFinCasosDiarioAnalista'";

  if ($idAnalistaCasosDiarioAnalista<>0){
    $consultarCasosDiariosAnalistas.=" AND mi.usuario='".$idAnalistaCasosDiarioAnalista."'";
  }

  mysqli_next_result($con);
  $queryCasosDiariosAnalistas=mysqli_query($con,$consultarCasosDiariosAnalistas);
  while (@$resCasosDiariosAnalistas=mysqli_fetch_array($queryCasosDiariosAnalistas,MYSQLI_ASSOC)){

    $data[]=array("origen"=>$resCasosDiariosAnalistas["origen"],
      "codigo"=>$resCasosDiariosAnalistas["codigo"],
      "analista"=>$resCasosDiariosAnalistas["analista"],
      "fecha"=>$resCasosDiariosAnalistas["fecha"]
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results);
}

function consultarEstadosInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultaEstadosInvs="SELECT a.estado, if(a.estado = 20, CONCAT (b.descripcion, ' DEL ', (SELECT IF(i2.codigo IS NULL, 'CASO', i2.codigo) FROM investigaciones i LEFT JOIN investigaciones i2 ON i2.id = i.id_caso_ampliado WHERE i.id = a.id_investigacion)) , b.descripcion) as evento, CONCAT(c.nombres,' ',c.apellidos) AS nombre_usuario, a.fecha
  FROM estado_investigaciones a
  LEFT JOIN definicion_tipos b ON a.estado=b.id
  LEFT JOIN usuarios c ON c.id=a.usuario
  WHERE b.id_tipo=30 AND a.id_investigacion=$idInvestigacion ORDER BY a.fecha DESC";
  $queryEstadosInvs=mysqli_query($con,$consultaEstadosInvs);

  while ($resEstadosInvs=mysqli_fetch_array($queryEstadosInvs,MYSQLI_ASSOC)){
    $data[]=array("descripcionEvento"=>$resEstadosInvs["evento"],
      "usuarioInvestigacionEvento"=>$resEstadosInvs["nombre_usuario"],
      "fechaEvento"=>$resEstadosInvs["fecha"]);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function consultarLesionadosDiligenciaInformeInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultaLesionadosDiligenciaInformeInvestigacion="SELECT b.id, CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion,' ',b.identificacion) as identificacion_lesionado
  FROM personas_investigaciones_soat a
  LEFT JOIN personas b ON a.id_persona=b.id
  LEFT JOIN definicion_tipos c ON b.tipo_identificacion=c.id AND c.id_tipo=5 
  WHERE a.id_investigacion='".$idInvestigacion."'";
  $queryLesionados=mysqli_query($con,$consultaLesionadosDiligenciaInformeInvestigacion);
  $opciones="";
  while ($resLesionadosDiligenciaInformeInvestigacion=mysqli_fetch_array($queryLesionados,MYSQLI_ASSOC)){

    $opciones="";
    mysqli_next_result($con);
    $consultarDiligenciaInforme=mysqli_query($con,"SELECT * FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."'");
    $resDiligenciaInforme=mysqli_fetch_array($consultarDiligenciaInforme,MYSQLI_ASSOC);

    if ($resDiligenciaInforme["id_diligencia_formato_declaracion"]!=$resLesionadosDiligenciaInformeInvestigacion["id"])      {
      $opciones="<a class='btn btn-success' name='".$resLesionadosDiligenciaInformeInvestigacion["id"]."' id='btnSeleecionarLesionadoDiligencia'>Seleccionar</a>";  
    }

    $data[]=array("nombreLesionadoDiligencia"=>$resLesionadosDiligenciaInformeInvestigacion["nombre_lesionado"],
      "identificacionLesionadoDiligencia"=>$resLesionadosDiligenciaInformeInvestigacion["identificacion_lesionado"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  
  return json_encode($results);
}

function consultarTestigosInformeInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultaTestigosInformeInvestigacion="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_testigo,concat(c.descripcion,' ',b.identificacion) as identificacion_testigo,a.id
  FROM testigos a
  LEFT JOIN personas b ON a.id_persona=b.id
  LEFT JOIN definicion_tipos c ON b.tipo_identificacion=c.id
  WHERE c.id_tipo=5 AND a.id_investigacion='".$idInvestigacion."'";
  $queryTestigos=mysqli_query($con,$consultaTestigosInformeInvestigacion);
  $opciones="";
  
  while ($resTestigosInformeInvestigacion=mysqli_fetch_array($queryTestigos,MYSQLI_ASSOC)){
    $opciones="<div class='btn-group'><button type='button' class='btn btn-success' name='".$resTestigosInformeInvestigacion["id"]."' id=''>".$resTestigosInformeInvestigacion["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resTestigosInformeInvestigacion["id"]."'><span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resTestigosInformeInvestigacion["id"]."' id='btnEliminarTestigoInformeInvestigacion'>Eliminar</a></li>
    </ul></div>";

    $data[]=array("nombreTestigo"=>$resTestigosInformeInvestigacion["nombre_testigo"],
      "identificacionTestigo"=>$resTestigosInformeInvestigacion["identificacion_testigo"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function consultarObservacionesInformeInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultaObservacionesInformeInvestigacion="SELECT b.descripcion as seccion_informe,a.observacion,a.id
  FROM observaciones_secciones_informe a
  LEFT JOIN definicion_tipos b ON a.id_seccion=b.id
  WHERE b.id_tipo=23 AND a.id_investigacion='".$idInvestigacion."'";
  $queryObservaciones=mysqli_query($con,$consultaObservacionesInformeInvestigacion);
  $opciones="";
  while ($resObservacionesInformeInvestigacion=mysqli_fetch_array($queryObservaciones,MYSQLI_ASSOC)){
    $opciones="<div class='btn-group'><button type='button' class='btn btn-success' name='".$resObservacionesInformeInvestigacion["id"]."' id=''>".$resObservacionesInformeInvestigacion["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resObservacionesInformeInvestigacion["id"]."'><span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resObservacionesInformeInvestigacion["id"]."' id='btnEditarObservacionInformeInvestigacion'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resObservacionesInformeInvestigacion["id"]."' id='btnEliminarObservacionInformeInvestigacion'>Eliminar</a></li>
    </ul></div>";

    $data[]=array("tipoSeccionObservaciones"=>$resObservacionesInformeInvestigacion["seccion_informe"],
      "descripcionObservacion"=>$resObservacionesInformeInvestigacion["observacion"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results);
}

function archivoPlanoIncapacidadPermanenteMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  v.descripcion AS tipo_caso,
  DATE_FORMAT(a.fecha_inicio, '%d-%m-%Y') AS fecha_asignacion, 
  'NO REGISTRA' AS siniestro,
  DATE_FORMAT(a.fecha_entrega, '%d-%m-%Y') AS fecha_entrega, 
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  i.lugar_accidente,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  r.codigo_dane AS departamento_residencia,
  q.codigo_dane AS ciudad_residencia,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  z.descripcion AS tipo_identificacion_reclamante,
  y.identificacion AS identificacion_reclamante,
  y.nombres AS nombre_reclamante,
  y.apellidos AS apellido_reclamante,
  y.direccion_residencia AS direccion_reclamante,
  ab.codigo_dane AS departamento_reclamante,
  aa.codigo_dane AS ciudad_reclamante,
  'SOAT' AS ramo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  n.placa,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  '' AS fiscalia_lleva_caso,
  '' AS informe_accidente,
  '' AS no_proceso,
  i.hechos AS hechos,
  d.descripcion AS tipo_identificacion_beneficiario,
  c.identificacion AS identificacion_beneficiario,
  c.nombres AS nombres_beneficiario,
  c.apellidos AS apellidos_beneficiario,
  '' AS parentesco_beneficiario,
  c.telefono AS telefono_beneficiario,
  IF(mi.ruta IS NULL, i.conclusiones, CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',i.conclusiones)) AS conclusiones,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  'JOSE QUIJANO' AS nombre_investigador,
  p.codigo_aseguradora AS indicador_fraude,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude
  LEFT JOIN ciudades q ON q.id=c.ciudad_residencia
  LEFT JOIN departamentos r ON r.id=q.id_departamento 
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN definicion_tipos v ON v.id=u.descripcion
  LEFT JOIN personas_investigaciones_soat w ON a.id=w.id_investigacion
  LEFT JOIN personas y ON y.id=w.id_persona
  LEFT JOIN definicion_tipos z ON z.id=y.tipo_identificacion
  LEFT JOIN ciudades aa ON aa.id=y.ciudad_residencia
  LEFT JOIN departamentos ab ON ab.id=aa.id_departamento
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.asignacion_especial is null and a.tipo_solicitud=1 AND p.id_aseguradora=1 AND w.tipo_persona in (3) AND z.id_tipo=5 AND a.id_aseguradora=1 AND v.id_tipo=32 AND u.id_tipo=31 AND u.descripcion=4 and d.id_tipo=5 AND b.tipo_persona in (1) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha")  {
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  } else if ($tipoGenerarArchivoPlano=="codigoCaso")  {
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }

  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos.=" AND a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }

  $consultaArchivoPlanoCensos.=" AND a.estado=1 AND mi.id_multimedia = 9";

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);

  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC))  {

    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "tipo_caso"=>$resArchivoPlanoCensos["tipo_caso"],
      "fecha_asignacion"=>$resArchivoPlanoCensos["fecha_asignacion"],
      "siniestro"=>$resArchivoPlanoCensos["siniestro"],
      "fecha_entrega"=>$resArchivoPlanoCensos["fecha_entrega"],
      "codigo_ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "departamento_residencia"=>$resArchivoPlanoCensos["departamento_residencia"],
      "ciudad_residencia"=>$resArchivoPlanoCensos["ciudad_residencia"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "tipo_identificacion_reclamante"=>$resArchivoPlanoCensos["tipo_identificacion_reclamante"],
      "identificacion_reclamante"=>$resArchivoPlanoCensos["identificacion_reclamante"],
      "nombre_reclamante"=>$resArchivoPlanoCensos["nombre_reclamante"],
      "apellido_reclamante"=>$resArchivoPlanoCensos["apellido_reclamante"],
      "direccion_reclamante"=>$resArchivoPlanoCensos["direccion_reclamante"],
      "departamento_reclamante"=>$resArchivoPlanoCensos["departamento_reclamante"],
      "ciudad_reclamante"=>$resArchivoPlanoCensos["ciudad_reclamante"],
      "ramo"=>$resArchivoPlanoCensos["ramo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "poliza"=>$resArchivoPlanoCensos["poliza"],
      "dig_ver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "inicio_vigencia"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "fin_vigencia"=>$resArchivoPlanoCensos["fin_vigencia"],
      "fiscalia_lleva_caso"=>$resArchivoPlanoCensos["fiscalia_lleva_caso"],
      "informe_accidente"=>$resArchivoPlanoCensos["informe_accidente"],
      "no_proceso"=>$resArchivoPlanoCensos["no_proceso"],
      "hechos"=>$resArchivoPlanoCensos["hechos"],
      "tipo_identificacion_beneficiario"=>$resArchivoPlanoCensos["tipo_identificacion_beneficiario"],
      "identificacion_beneficiario"=>$resArchivoPlanoCensos["identificacion_beneficiario"],
      "nombres_beneficiario"=>$resArchivoPlanoCensos["nombres_beneficiario"],
      "apellidos_beneficiario"=>$resArchivoPlanoCensos["apellidos_beneficiario"],
      "parentesco_beneficiario"=>$resArchivoPlanoCensos["parentesco_beneficiario"],
      "telefono_beneficiario"=>$resArchivoPlanoCensos["telefono_beneficiario"],
      "conclusiones"=>$resArchivoPlanoCensos["conclusiones"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoMuerteMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  v.descripcion AS tipo_caso,
  DATE_FORMAT(a.fecha_inicio, '%d-%m-%Y') AS fecha_asignacion, 
  'NO REGISTRA' AS siniestro,
  DATE_FORMAT(a.fecha_entrega, '%d-%m-%Y') AS fecha_entrega, 
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  i.lugar_accidente,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  r.codigo_dane AS departamento_residencia,
  q.codigo_dane AS ciudad_residencia,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  z.descripcion AS tipo_identificacion_reclamante,
  y.identificacion AS identificacion_reclamante,
  y.nombres AS nombre_reclamante,
  y.apellidos AS apellido_reclamante,
  y.direccion_residencia AS direccion_reclamante,
  ab.codigo_dane AS departamento_reclamante,
  aa.codigo_dane AS ciudad_reclamante,
  'SOAT' AS ramo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  n.placa,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  i.fiscalia_lleva_caso AS fiscalia_lleva_caso,
  i.croquis AS informe_accidente,
  i.proceso_fiscalia AS no_proceso,
  i.hechos AS hechos,
  ae.descripcion AS tipo_identificacion_beneficiario,
  ad.identificacion AS identificacion_beneficiario,
  ad.nombres AS nombres_beneficiario,
  ad.apellidos AS apellidos_beneficiario,
  ac.parentesco AS parentesco_beneficiario,
  ad.telefono AS telefono_beneficiario,
  IF(mi.ruta IS NULL, i.conclusiones, CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',i.conclusiones)) AS conclusiones,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  'JOSE QUIJANO' AS nombre_investigador,
  p.codigo_aseguradora AS indicador_fraude,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude
  LEFT JOIN ciudades q ON q.id=c.ciudad_residencia
  LEFT JOIN departamentos r ON r.id=q.id_departamento 
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN definicion_tipos v ON v.id=u.descripcion
  LEFT JOIN personas_investigaciones_soat w ON a.id=w.id_investigacion
  LEFT JOIN personas y ON y.id=w.id_persona
  LEFT JOIN definicion_tipos z ON z.id=y.tipo_identificacion
  LEFT JOIN ciudades aa ON aa.id=y.ciudad_residencia
  LEFT JOIN departamentos ab ON ab.id=aa.id_departamento 
  LEFT JOIN personas_investigaciones_soat ac ON a.id=ac.id_investigacion
  LEFT JOIN personas ad ON ad.id=ac.id_persona
  LEFT JOIN definicion_tipos ae ON ae.id=ad.tipo_identificacion
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.asignacion_especial is null and a.tipo_solicitud=1 and p.id_aseguradora=1 AND ac.tipo_persona in (4) AND w.tipo_persona in (3) AND z.id_tipo=5 AND ae.id_tipo=5 AND a.id_aseguradora=1 AND v.id_tipo=32 AND u.id_tipo=31 AND u.descripcion=3 and d.id_tipo=5 AND b.tipo_persona in (1) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  } else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }

  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos.=" AND a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }
  $consultaArchivoPlanoCensos.=" AND a.estado=1 AND mi.id_multimedia = 9 ";

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC))  {
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "tipo_caso"=>$resArchivoPlanoCensos["tipo_caso"],
      "fecha_asignacion"=>$resArchivoPlanoCensos["fecha_asignacion"],
      "siniestro"=>$resArchivoPlanoCensos["siniestro"],
      "fecha_entrega"=>$resArchivoPlanoCensos["fecha_entrega"],
      "codigo_ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "departamento_residencia"=>$resArchivoPlanoCensos["departamento_residencia"],
      "ciudad_residencia"=>$resArchivoPlanoCensos["ciudad_residencia"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "tipo_identificacion_reclamante"=>$resArchivoPlanoCensos["tipo_identificacion_reclamante"],
      "identificacion_reclamante"=>$resArchivoPlanoCensos["identificacion_reclamante"],
      "nombre_reclamante"=>$resArchivoPlanoCensos["nombre_reclamante"],
      "apellido_reclamante"=>$resArchivoPlanoCensos["apellido_reclamante"],
      "direccion_reclamante"=>$resArchivoPlanoCensos["direccion_reclamante"],
      "departamento_reclamante"=>$resArchivoPlanoCensos["departamento_reclamante"],
      "ciudad_reclamante"=>$resArchivoPlanoCensos["ciudad_reclamante"],
      "ramo"=>$resArchivoPlanoCensos["ramo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "poliza"=>$resArchivoPlanoCensos["poliza"],
      "dig_ver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "inicio_vigencia"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "fin_vigencia"=>$resArchivoPlanoCensos["fin_vigencia"],
      "fiscalia_lleva_caso"=>$resArchivoPlanoCensos["fiscalia_lleva_caso"],
      "informe_accidente"=>$resArchivoPlanoCensos["informe_accidente"],
      "no_proceso"=>$resArchivoPlanoCensos["no_proceso"],
      "hechos"=>$resArchivoPlanoCensos["hechos"],
      "tipo_identificacion_beneficiario"=>$resArchivoPlanoCensos["tipo_identificacion_beneficiario"],
      "identificacion_beneficiario"=>$resArchivoPlanoCensos["identificacion_beneficiario"],
      "nombres_beneficiario"=>$resArchivoPlanoCensos["nombres_beneficiario"],
      "apellidos_beneficiario"=>$resArchivoPlanoCensos["apellidos_beneficiario"],
      "parentesco_beneficiario"=>$resArchivoPlanoCensos["parentesco_beneficiario"],
      "telefono_beneficiario"=>$resArchivoPlanoCensos["telefono_beneficiario"],
      "conclusiones"=>$resArchivoPlanoCensos["conclusiones"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoGastosMedicosMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){

  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  v.descripcion AS tipo_caso,
  DATE_FORMAT(a.fecha_inicio, '%d-%m-%Y') AS fecha_asignacion, 
  'NO REGISTRA' AS siniestro,
  DATE_FORMAT(a.fecha_entrega, '%d-%m-%Y') AS fecha_entrega, 
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  i.lugar_accidente,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  r.codigo_dane AS departamento_residencia,
  q.codigo_dane AS ciudad_residencia,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  'NIT' AS tipo_identificacion_reclamante,
  f.identificacion AS identificacion_reclamante,
  f.nombre_ips AS nombre_reclamante,
  '' AS apellido_reclamante,
  f.direccion AS direccion_reclamante,
  s.codigo_dane AS departamento_reclamante,
  g.codigo_dane AS ciudad_reclamante,
  'SOAT' AS ramo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  n.placa,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  '' AS fiscalia_lleva_caso,
  '' AS informe_accidente,
  '' AS no_proceso,
  b.observaciones AS hechos,
  '' AS tipo_identificacion_beneficiario,
  '' AS identificacion_beneficiario,
  '' AS nombres_beneficiario,
  '' AS apellidos_beneficiario,
  '' AS parentesco_beneficiario,
  '' AS telefono_beneficiario,
  IF(mi.ruta IS NULL, i.conclusiones, CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',i.conclusiones) ) AS conclusiones,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  'JOSE QUIJANO' AS nombre_investigador,
  p.codigo_aseguradora AS indicador_fraude,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN ciudades g ON g.id=f.ciudad 
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude
  LEFT JOIN ciudades q ON q.id=c.ciudad_residencia
  LEFT JOIN departamentos r ON r.id=q.id_departamento 
  LEFT JOIN departamentos s ON s.id=g.id_departamento 
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN definicion_tipos v ON v.id=u.descripcion
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.asignacion_especial is null and a.tipo_solicitud=1 and p.id_aseguradora=1 AND a.id_aseguradora=1 AND v.id_tipo=32 AND u.id_tipo=31 AND u.descripcion=2 and d.id_tipo=5 AND b.tipo_persona in (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "tipo_caso"=>$resArchivoPlanoCensos["tipo_caso"],
      "fecha_asignacion"=>$resArchivoPlanoCensos["fecha_asignacion"],
      "siniestro"=>$resArchivoPlanoCensos["siniestro"],
      "fecha_entrega"=>$resArchivoPlanoCensos["fecha_entrega"],
      "codigo_ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "departamento_residencia"=>$resArchivoPlanoCensos["departamento_residencia"],
      "ciudad_residencia"=>$resArchivoPlanoCensos["ciudad_residencia"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "tipo_identificacion_reclamante"=>$resArchivoPlanoCensos["tipo_identificacion_reclamante"],
      "identificacion_reclamante"=>$resArchivoPlanoCensos["identificacion_reclamante"],
      "nombre_reclamante"=>$resArchivoPlanoCensos["nombre_reclamante"],
      "apellido_reclamante"=>$resArchivoPlanoCensos["apellido_reclamante"],
      "direccion_reclamante"=>$resArchivoPlanoCensos["direccion_reclamante"],
      "departamento_reclamante"=>$resArchivoPlanoCensos["departamento_reclamante"],
      "ciudad_reclamante"=>$resArchivoPlanoCensos["ciudad_reclamante"],
      "ramo"=>$resArchivoPlanoCensos["ramo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "poliza"=>$resArchivoPlanoCensos["poliza"],
      "dig_ver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "inicio_vigencia"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "fin_vigencia"=>$resArchivoPlanoCensos["fin_vigencia"],
      "fiscalia_lleva_caso"=>$resArchivoPlanoCensos["fiscalia_lleva_caso"],
      "informe_accidente"=>$resArchivoPlanoCensos["informe_accidente"],
      "no_proceso"=>$resArchivoPlanoCensos["no_proceso"],
      "hechos"=>$resArchivoPlanoCensos["hechos"],
      "tipo_identificacion_beneficiario"=>$resArchivoPlanoCensos["tipo_identificacion_beneficiario"],
      "identificacion_beneficiario"=>$resArchivoPlanoCensos["identificacion_beneficiario"],
      "nombres_beneficiario"=>$resArchivoPlanoCensos["nombres_beneficiario"],
      "apellidos_beneficiario"=>$resArchivoPlanoCensos["apellidos_beneficiario"],
      "parentesco_beneficiario"=>$resArchivoPlanoCensos["parentesco_beneficiario"],
      "telefono_beneficiario"=>$resArchivoPlanoCensos["telefono_beneficiario"],
      "conclusiones"=>$resArchivoPlanoCensos["conclusiones"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function archivoPlanoCensosAsignadoSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){

  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT   a.codigo AS consecutivo,  g.codigo_dane AS ciudad_conocido,  DATE_FORMAT(b.fecha_ingreso, '%Y-%m-%d') AS fecha_visita,  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,  o.descripcion AS tipo_vehiculo,   k.indicativo AS aseguradora,  m.numero AS poliza,  m.digito_verificacion AS dig_ver_poliza,  DATE_FORMAT(m.inicio_vigencia, '%Y-%m-%d') AS inicio_vigencia,  DATE_FORMAT(m.fin_vigencia, '%Y-%m-%d') AS fin_vigencia,  n.placa,  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%Y-%m-%d') AS fecha_ingreso,  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,  c.apellidos AS apellidos_lesionado,  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,  c.edad AS edad_lesionado,  CASE   WHEN b.seguridad_social='1' THEN 'S'  WHEN b.seguridad_social='2' THEN 'N' END AS seguridad_social_lesionado,  'N' AS ingreso_fosyga,  'N' AS otros_diagnosticos,  '0' AS costo,  'S' AS visita_sitio,  i.lugar_accidente,  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,  b.condicion AS condicion_lesionado,  'N' AS pruebas,  CASE   WHEN b.resultado='1' THEN 'S'  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,  p.codigo_aseguradora AS indicador_fraude,  '0' AS valor_fraude,  'JOSE QUIJANO' AS nombre_investigador,  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,  DATE_FORMAT(CURDATE(),'%Y-%m-%d')AS fecha_plano,  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,  e.descripcion2 AS sexo,  j.codigo_dane AS codigo_ciudad_ocurrencia,  c.telefono AS telefono_lesionado,  f.nombre_ips AS nombre_ips,  g.codigo_dane AS ciudad_ips  FROM investigaciones a
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
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND p.id_aseguradora=7  AND u.id_tipo=31 AND u.descripcion=6 AND e.id_tipo=3 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "aseguradora2"=>$resArchivoPlanoCensos["aseguradora"],
      "ingreso_fosyga"=>$resArchivoPlanoCensos["ingreso_fosyga"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "otros_diagnosticos"=>$resArchivoPlanoCensos["otros_diagnosticos"],
      "costo"=>$resArchivoPlanoCensos["costo"],
      "visita_sitio"=>$resArchivoPlanoCensos["visita_sitio"],
      "pruebas2"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "valor_fraude"=>$resArchivoPlanoCensos["valor_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$resArchivoPlanoCensos["observaciones"],
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function archivoPlanoCensosSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT   a.codigo AS consecutivo,  g.codigo_dane AS ciudad_conocido,  DATE_FORMAT(b.fecha_ingreso, '%Y-%m-%d') AS fecha_visita,  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,  o.descripcion AS tipo_vehiculo,   k.indicativo AS aseguradora,  m.numero AS poliza,  m.digito_verificacion AS dig_ver_poliza,  DATE_FORMAT(m.inicio_vigencia, '%Y-%m-%d') AS inicio_vigencia,  DATE_FORMAT(m.fin_vigencia, '%Y-%m-%d') AS fin_vigencia,  n.placa,  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%Y-%m-%d') AS fecha_ingreso,  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,  c.apellidos AS apellidos_lesionado,  d.descripcion AS tipo_identificacion_lesionado,  
  c.identificacion AS identificacion_lesionado,  c.edad AS edad_lesionado,  CASE   WHEN b.seguridad_social='1' THEN 'S'  WHEN b.seguridad_social='2' THEN 'N' END AS seguridad_social_lesionado,  'N' AS ingreso_fosyga,  'N' AS otros_diagnosticos,  '0' AS costo,  'S' AS visita_sitio,  i.lugar_accidente,  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,  b.condicion AS condicion_lesionado,  'N' AS pruebas,  CASE   WHEN b.resultado='1' THEN 'S'  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,  p.codigo_aseguradora AS indicador_fraude,  '0' AS valor_fraude,  'JOSE QUIJANO' AS nombre_investigador,  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,  DATE_FORMAT(CURDATE(),'%Y-%m-%d')AS fecha_plano,  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,  e.descripcion2 AS sexo,  j.codigo_dane AS codigo_ciudad_ocurrencia,  c.telefono AS telefono_lesionado,  f.nombre_ips AS nombre_ips,  g.codigo_dane AS ciudad_ips, if(b.resultado =1 AND b.indicador_fraude = 13, 's', 'n') AS aconsideracion, a.id 
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
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=7 AND p.id_aseguradora=7  AND u.id_tipo=31 AND u.descripcion=1 AND e.id_tipo=3 AND d.id_tipo=5 AND b.tipo_persona IN (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){

    if ($resArchivoPlanoCensos["aconsideracion"] == 's') {
      $query = "SELECT b.descripcion
      FROM conclusiones_inconsistencias_investigaciones a
      LEFT JOIN conclusiones_inconsistencias b ON b.id = a.id_conclusion
      WHERE a.id_investigacion = ".$resArchivoPlanoCensos["id"]." AND a.activo = 's'";
      mysqli_next_result($con);
      $query = mysqli_query($con,$query);
      $texto = " Se deja a consideración de la compañía el resultado final de la investigación, debido a inconsistencias que se evidencian en el proceso, las cuales se describen a continuación: ";

      $i = 1;
      while ($resQueryConsideracion=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $texto .= $i++."- ".$resQueryConsideracion['descripcion']." ";
      }
      $observaciones = $resArchivoPlanoCensos["observaciones"].$texto;
    }else{
      $observaciones = $resArchivoPlanoCensos["observaciones"];
    }

    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "aseguradora2"=>$resArchivoPlanoCensos["aseguradora"],
      "ingreso_fosyga"=>$resArchivoPlanoCensos["ingreso_fosyga"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "otros_diagnosticos"=>$resArchivoPlanoCensos["otros_diagnosticos"],
      "costo"=>$resArchivoPlanoCensos["costo"],
      "visita_sitio"=>$resArchivoPlanoCensos["visita_sitio"],
      "pruebas2"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "valor_fraude"=>$resArchivoPlanoCensos["valor_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$observaciones,
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoCensosEquidad($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
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
  WHEN b.seguridad_social='2' THEN 'N' END AS seguridad_social_lesionado,
  'N' as ingreso_fosyga,
  'N' AS otros_diagnosticos,
  '0' AS costo,
  'S' AS visita_sitio,
  i.lugar_accidente,
  DATE_FORMAT(i.fecha_accidente, '%Y-%m-%d') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  '0' AS valor_fraude,
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%Y-%m-%d')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  IF(b.resultado = 1 AND b.indicador_fraude = 13, 's', 'n') AS aconsideracion, 
  a.id
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion AND d.id_tipo=8
  LEFT JOIN definicion_tipos e ON e.id=c.sexo AND e.id_tipo=3
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN ciudades g ON g.id=f.ciudad 
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN tipo_vehiculos o ON o.id=n.tipo_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude AND p.id_aseguradora=5
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso AND u.id_tipo=31
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 AND a.id_aseguradora=5  AND u.descripcion IN(1,6,2) AND mi.id_multimedia = 9 AND b.tipo_persona in (1,2) ";
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    if ($resArchivoPlanoCensos["aconsideracion"] == 's') {
      $query = "SELECT b.descripcion
      FROM conclusiones_inconsistencias_investigaciones a
      LEFT JOIN conclusiones_inconsistencias b ON b.id = a.id_conclusion
      WHERE a.id_investigacion = ".$resArchivoPlanoCensos["id"]." AND a.activo = 's'";
      mysqli_next_result($con);
      $query = mysqli_query($con,$query);
      $texto = " Se deja a consideración de la compañía el resultado final de la investigación, debido a inconsistencias que se evidencian en el proceso, las cuales se describen a continuación: ";

      $i = 1;
      while ($resQueryConsideracion=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $texto .= $i++."- ".$resQueryConsideracion['descripcion']." ";
      }

      $observaciones = $resArchivoPlanoCensos["observaciones"].$texto;
    }else{
      $observaciones = $resArchivoPlanoCensos["observaciones"];
    }

    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "aseguradora2"=>$resArchivoPlanoCensos["aseguradora"],
      "ingreso_fosyga"=>$resArchivoPlanoCensos["ingreso_fosyga"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "otros_diagnosticos"=>$resArchivoPlanoCensos["otros_diagnosticos"],
      "costo"=>$resArchivoPlanoCensos["costo"],
      "visita_sitio"=>$resArchivoPlanoCensos["visita_sitio"],
      "pruebas2"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "valor_fraude"=>$resArchivoPlanoCensos["valor_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$observaciones,
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoCensosEstado($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
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
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  '0' AS valor_fraude,
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%Y-%m-%d')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  r.codigo_dane AS ciudad_residencia, 
  IF(b.resultado =1 AND b.indicador_fraude = 13, 's', 'n') AS aconsideracion, a.id 
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
  WHERE a.tipo_solicitud=1 and a.id_aseguradora=2  AND p.id_aseguradora=2  AND u.id_tipo=31 AND u.descripcion=1 AND e.id_tipo=3 and d.id_tipo=5 AND b.tipo_persona in (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    if ($resArchivoPlanoCensos["aconsideracion"] == 's') {
      $query = "SELECT b.descripcion
      FROM conclusiones_inconsistencias_investigaciones a
      LEFT JOIN conclusiones_inconsistencias b ON b.id = a.id_conclusion
      WHERE a.id_investigacion = ".$resArchivoPlanoCensos["id"]." AND a.activo = 's'";
      mysqli_next_result($con);
      $query = mysqli_query($con,$query);
      $texto = " Se deja a consideración de la compañía el resultado final de la investigación, debido a inconsistencias que se evidencian en el proceso, las cuales se describen a continuación: ";

      $i = 1;
      while ($resQueryConsideracion=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $texto .= $i++."- ".$resQueryConsideracion['descripcion']." ";
      }

      $observaciones = $resArchivoPlanoCensos["observaciones"].$texto;
    }else{
      $observaciones = $resArchivoPlanoCensos["observaciones"];
    }

    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "aseguradora2"=>$resArchivoPlanoCensos["aseguradora"],
      "ingreso_fosyga"=>$resArchivoPlanoCensos["ingreso_fosyga"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "otros_diagnosticos"=>$resArchivoPlanoCensos["otros_diagnosticos"],
      "costo"=>$resArchivoPlanoCensos["costo"],
      "visita_sitio"=>$resArchivoPlanoCensos["visita_sitio"],
      "pruebas2"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "valor_fraude"=>$resArchivoPlanoCensos["valor_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$observaciones,
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],

      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"],
      "ciudad_residencia_lesionado"=>$resArchivoPlanoCensos["ciudad_residencia"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoCensosAsignadosMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  g.codigo_dane AS ciudad_conocido,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_visita,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,
  o.descripcion AS tipo_vehiculo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  n.placa,
  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.edad AS edad_lesionado,
  CASE 
  WHEN b.seguridad_social='1' THEN 's'
  else 'n' END AS seguridad_social_lesionado,
  i.lugar_accidente,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 's'
  WHEN b.resultado='2' THEN 'n' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace. ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  CASE WHEN b.remitido=2 THEN 'SI' ELSE 'NO' END AS remitido,
  CASE WHEN b.remitido=2 THEN  s.nombre_ips ELSE '' END AS ips_remitido,
  CASE WHEN b.remitido=2 THEN  t.codigo_dane ELSE '' END AS ciudad_remitido,
  CASE WHEN b.servicio_ambulancia='s' THEN  'AMBULANCIA' ELSE 'PROPIOS MEDIOS' END AS transporte,
  r.codigo_dane AS ciudad_residencia
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion AND d.id_tipo=5
  LEFT JOIN definicion_tipos e ON e.id=c.sexo AND e.id_tipo=3
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
  LEFT JOIN ips s ON s.id=b.ips_remitido
  LEFT JOIN ciudades t ON t.id=s.ciudad
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and p.id_aseguradora=1 AND a.id_aseguradora=1  AND p.id_aseguradora=1  AND u.id_tipo=31 AND u.descripcion=6 AND b.tipo_persona in (1,2) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha") {
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }else if ($tipoGenerarArchivoPlano=="codigoCaso") {
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos.=" AND a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }
  $consultaArchivoPlanoCensos.=" AND a.estado=1 AND mi.id_multimedia = 9";

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);

  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$resArchivoPlanoCensos["observaciones"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],
      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"],
      "remitido"=>$resArchivoPlanoCensos["remitido"],
      "ips_remitido"=>$resArchivoPlanoCensos["ips_remitido"],
      "ciudad_remitido"=>$resArchivoPlanoCensos["ciudad_remitido"],
      "servicio_ambulancia"=>$resArchivoPlanoCensos["transporte"],
      "ciudad_residencia_lesionado"=>$resArchivoPlanoCensos["ciudad_residencia"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoCensosMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.asignacion_especial,a.codigo AS consecutivo,
  g.codigo_dane AS ciudad_conocido,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_visita,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,
  o.descripcion AS tipo_vehiculo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  n.placa,
  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.edad AS edad_lesionado,
  CASE 
  WHEN b.seguridad_social='1' THEN 's'
  else 'n' END AS seguridad_social_lesionado,
  i.lugar_accidente,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 's'
  WHEN b.resultado='2' THEN 'n' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  CASE WHEN b.remitido=2 THEN 'SI' ELSE 'NO' END AS remitido,
  CASE WHEN b.remitido=2 THEN  s.nombre_ips ELSE '' END AS ips_remitido,
  CASE WHEN b.remitido=2 THEN  t.codigo_dane ELSE '' END AS ciudad_remitido,
  CASE WHEN b.servicio_ambulancia='s' THEN  'AMBULANCIA' ELSE 'PROPIOS MEDIOS' END AS transporte,
  r.codigo_dane AS ciudad_residencia,
  IF(b.resultado = 1 AND b.indicador_fraude = 13, 's', 'n') AS aconsideracion,
  a.id
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
  LEFT JOIN ips s ON s.id=b.ips_remitido
  LEFT JOIN ciudades t ON t.id=s.ciudad
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and p.id_aseguradora=1 AND a.id_aseguradora=1  AND p.id_aseguradora=1  AND u.id_tipo=31 AND (u.descripcion=1 and a.asignacion_especial is null) AND e.id_tipo=3 and d.id_tipo=5 AND b.tipo_persona in (1,2) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha") {
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }

  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos .= " and a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }

  $consultaArchivoPlanoCensos .= " AND a.estado = 1 AND mi.id_multimedia = 9 ";

  $consultaArchivoPlanoCensos.=" UNION SELECT
  a.asignacion_especial,a.codigo AS consecutivo,
  g.codigo_dane AS ciudad_conocido,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_visita,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,
  o.descripcion AS tipo_vehiculo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  n.placa,
  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.edad AS edad_lesionado,
  CASE 
  WHEN b.seguridad_social='1' THEN 's'
  else 'n' END AS seguridad_social_lesionado,
  i.lugar_accidente,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 's'
  WHEN b.resultado='2' THEN 'n' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  CASE WHEN b.remitido=2 THEN 'SI' ELSE 'NO' END AS remitido,
  CASE WHEN b.remitido=2 THEN  s.nombre_ips ELSE '' END AS ips_remitido,
  CASE WHEN b.remitido=2 THEN  t.codigo_dane ELSE '' END AS ciudad_remitido,
  CASE WHEN b.servicio_ambulancia='s' THEN  'AMBULANCIA' ELSE 'PROPIOS MEDIOS' END AS transporte,
  r.codigo_dane AS ciudad_residencia,
  IF(b.resultado = 1 AND b.indicador_fraude = 13, 's', 'n') AS aconsideracion,
  a.id
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
  LEFT JOIN ips s ON s.id=b.ips_remitido
  LEFT JOIN ciudades t ON t.id=s.ciudad
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=1 and p.id_aseguradora=1 AND a.id_aseguradora=1  AND p.id_aseguradora=1  AND u.id_tipo=31 AND (u.descripcion in (2) and a.asignacion_especial IS NOT null)  AND e.id_tipo=3 and d.id_tipo=5 AND b.tipo_persona in (1,2) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha") {
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos .= " and a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }

  $consultaArchivoPlanoCensos .= " AND a.estado = 1 AND mi.id_multimedia = 9";

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)) {

    if ($resArchivoPlanoCensos["aconsideracion"] == 's') {
      $query = "SELECT b.descripcion
      FROM conclusiones_inconsistencias_investigaciones a
      LEFT JOIN conclusiones_inconsistencias b ON b.id = a.id_conclusion
      WHERE a.id_investigacion = ".$resArchivoPlanoCensos["id"]." AND a.activo = 's'";
      mysqli_next_result($con);
      $query = mysqli_query($con,$query);
      $texto = " Se deja a consideración de la compañía el resultado final de la investigación, debido a inconsistencias que se evidencian en el proceso, las cuales se describen a continuación: ";

      $i = 1;
      while ($resQueryConsideracion=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $texto .= $i++."- ".$resQueryConsideracion['descripcion']." ";
      }

      $observaciones = $resArchivoPlanoCensos["observaciones"].$texto;
    }else{
      $observaciones = $resArchivoPlanoCensos["observaciones"];
    }

    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$observaciones,
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],
      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"],
      "remitido"=>$resArchivoPlanoCensos["remitido"],
      "ips_remitido"=>$resArchivoPlanoCensos["ips_remitido"],
      "ciudad_remitido"=>$resArchivoPlanoCensos["ciudad_remitido"],
      "servicio_ambulancia"=>$resArchivoPlanoCensos["transporte"],
      "ciudad_residencia_lesionado"=>$resArchivoPlanoCensos["ciudad_residencia"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function reportRegistroDiarioValidacionesIPS($fechaInicioReporteBasico,$fechaFinReporteBasico,$aseguradoraReporteBasico,$tipoCasoReporteBasico){

  global $con;
  $data=array();
  $consultarRegistroValidacionesIPS="SELECT a.tipo_caso,c.descripcion as descripcion_tipo_caso,a.codigo,a.id
  FROM investigaciones a
  LEFT JOIN definicion_tipos b ON b.descripcion2=a.tipo_caso
  LEFT JOIN definicion_tipos c ON c.id=a.tipo_caso
  WHERE c.id_tipo=8 and a.tipo_solicitud=1 AND b.id_tipo=31 AND DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."' AND a.id_aseguradora='".$aseguradoraReporteBasico."' 
  AND b.descripcion='".$tipoCasoReporteBasico."'"; 
  $queryRegistroDiario=mysqli_query($con,$consultarRegistroValidacionesIPS);
  while ($resRegistroDiario=mysqli_fetch_array($queryRegistroDiario,MYSQLI_ASSOC)){

    $nombreEntidad="";$departamentoEntidad="";$identificacionEntidad="";
    mysqli_next_result($con);
    $consultarDetalleCaso="SELECT 
    CASE
    WHEN identificacion_entidad is null then 'NR'
    ELSE identificacion_entidad end as identificacion_entidad,
    CASE
    WHEN nombre_entidad is null then 'NR'
    ELSE nombre_entidad end as nombre_entidad,
    CASE
    WHEN ciudad_entidad is null then 'NR'
    ELSE ciudad_entidad end as ciudad_entidad
    FROM detalle_investigaciones_validaciones WHERE id_investigacion='".$resRegistroDiario["id"]."'";
    $queryDetalleCaso=mysqli_query($con,$consultarDetalleCaso);
    $resDetalleCaso=mysqli_fetch_array($queryDetalleCaso);

    if ($resDetalleCaso["identificacion_entidad"]=="NR"){
      $identificacionEntidad="NO REGISTRA";
    }
    else{
      $identificacionEntidad=$resDetalleCaso["identificacion_entidad"];
    }

    if ($resDetalleCaso["nombre_entidad"]=="NR"){
      $nombreEntidad="NO REGISTRA";
    }
    else {
      $nombreEntidad=$resDetalleCaso["nombre_entidad"];
    }

    if ($resDetalleCaso["ciudad_entidad"]=="NR") {
      $departamentoEntidad="NO REGISTRA";
    }
    else {
      mysqli_next_result($con);
      $consultarCiudadDptoEntidad="SELECT a.nombre as ciudad,b.nombre as departamento
      FROM ciudades a
      LEFT JOIN departamentos b ON a.id_departamento=b.id
      WHERE a.id='".$resDetalleCaso["ciudad_entidad"]."'";
      $queryCiudadDptoEntidad=mysqli_query($con,$consultarCiudadDptoEntidad);
      $resCiudadDptoEntidad=mysqli_fetch_array($queryCiudadDptoEntidad,MYSQLI_ASSOC);


      $departamentoEntidad=$resCiudadDptoEntidad["departamento"]; 
    }

    $data[]=array("codigo"=>$resRegistroDiario["codigo"],
      "tipo_caso"=>$resRegistroDiario["descripcion_tipo_caso"],
      "departamento_entidad"=>$departamentoEntidad,
      "nombre_entidad"=>$nombreEntidad,
      "identificacion_entidad"=>$identificacionEntidad);
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function reporteRegistroDiarioSOAT($fechaInicioReporteBasico,$fechaFinReporteBasico,$aseguradoraReporteBasico,$tipoCasoReporteBasico,$usuarioReporteBasico){

  global $con;
  $data=array();

  $consultarRegistroDiario = array();
  $consultarRegistroDiario[1]="SELECT case when o.tipo_persona = 1 then 'PRINCIPAL' ELSE 'SEGUNDO LES' END tipo_persona, o.condicion,  CASE WHEN (o.servicio_ambulancia = 's') AND ( o.tipo_traslado_ambulancia = 2) THEN 'AMBULANCIA - OTRO SITIO' 
    WHEN o.servicio_ambulancia = 's' THEN 'AMBULANCIA' WHEN o.servicio_ambulancia = 'n' THEN 'PROPIOS MEDIOS' ELSE '' END servicio, 
    CASE WHEN o.tipo_traslado_ambulancia = 1 THEN 'PRIMARIO' WHEN o.tipo_traslado_ambulancia = 2 THEN 'SECUNDARIO' ELSE 'PROPIOS MEDIOS' END tipo_traslado,a.codigo,a.tipo_caso,d.descripcion as descripcion_tipo_caso,
    CASE WHEN b.fecha_accidente IS NULL THEN 'NO REGISTRA' ELSE b.fecha_accidente END AS fecha_accidente,
    CASE WHEN a.fecha_conocimiento IS NULL THEN 'NO REGISTRA' ELSE a.fecha_conocimiento END AS fecha_conocimiento,
    a.fecha_cargue AS fecha_entrega,
    CASE WHEN i.placa IS NULL THEN 'NO REGISTRA' ELSE i.placa END AS placa, 
    CASE WHEN h.numero IS NULL THEN 'NO REGISTRA' ELSE h.numero END AS numero_poliza, 
    CASE WHEN h.ciudad_expedicion IS NULL THEN 'NO REGISTRA' ELSE CONCAT(k.nombre,' - ',j.nombre) END AS lugar_expedicion_poliza,
    CASE WHEN l.id IS NULL THEN 'NO REGISTRA' ELSE l.nombre END AS ciudad_ocurrencia, 
    CASE WHEN m.id IS NULL THEN 'NO REGISTRA' ELSE m.nombre END AS departamento_ocurrencia,
    s.descripcion AS indicador_fraude,
    o.resultado AS id_resultado, CASE WHEN o.resultado = 1 THEN (SELECT a1.descripcion2 FROM definicion_tipos a1 LEFT JOIN aseguradoras b1 ON b1.resultado_atender=a1.id AND a1.id_tipo=10 WHERE b1.id = a.id_aseguradora) ELSE (SELECT a1.descripcion2 FROM definicion_tipos a1 LEFT JOIN aseguradoras b1 ON b1.resultado_no_atender=a1.id AND a1.id_tipo=10 WHERE b1.id = a.id_aseguradora) END AS resultado,
    CONCAT(p.nombres,' ',CASE WHEN p.apellidos IS NULL THEN '' ELSE p.apellidos END) AS nombre_lesionado,
    q.descripcion AS tipo_identificacion_lesionado,p.identificacion AS identificacion_lesionado,
    'NIT' AS tipo_identificacion_reclamante, r.identificacion AS identificacion_reclamante,
    r.nombre_ips AS nombre_reclamante,
    CASE WHEN o.observaciones IS NULL then 'NO REGISTRA' ELSE o.observaciones END AS observaciones,
    CASE WHEN n.id IS NULL THEN 'NO REGISTRA' ELSE n.descripcion END AS tipo_zona,
    CONCAT(CASE WHEN e.nombres IS NULL THEN '' ELSE e.nombres END,' ',CASE WHEN e.apellidos IS NULL THEN '' ELSE e.apellidos END) AS nombre_usuario_actual,CONCAT(f.nombres,' ',f.apellidos) as nombre_usuario_crear,
    CASE WHEN b.fecha_diligencia_formato_declaracion = '0000-00-00' THEN 'NO REGISTRA'
    WHEN b.fecha_diligencia_formato_declaracion IS NULL THEN 'NO REGISTRA'
    ELSE b.fecha_diligencia_formato_declaracion END AS fecha_diligencia_formato_declaracion
    , CASE WHEN a.id_tipo_auditoria = 1 THEN 'DECLARACIÓN' WHEN a.id_tipo_auditoria = 2 THEN 'AUDITORÍA TELÉFONICA' ELSE 'NO REGISTRA' END AS tipo_auditoria, CONCAT(iv.nombres, ' ', iv.apellidos) AS investigador
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_soat b ON b.id_investigacion = a.id 
    LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso AND c.id_tipo=31
    LEFT JOIN definicion_tipos d ON d.id=a.tipo_caso AND d.id_tipo=8
    LEFT JOIN usuarios e ON e.id=a.id_usuario
    LEFT JOIN usuarios f ON f.id=a.usuario
    LEFT JOIN polizas h ON h.id=b.id_poliza
    LEFT JOIN vehiculos i ON i.id=h.id_vehiculo
    LEFT JOIN ciudades j ON j.id=h.ciudad_expedicion
    LEFT JOIN departamentos k ON k.id=j.id_departamento
    LEFT JOIN ciudades l ON l.id=b.ciudad_ocurrencia
    LEFT JOIN departamentos m ON m.id=l.id_departamento
    LEFT JOIN definicion_tipos n ON n.id_tipo=11 AND n.id=b.tipo_zona
    LEFT JOIN personas_investigaciones_soat o ON o.id_investigacion=a.id AND o.tipo_persona=1
    LEFT JOIN personas p ON p.id=o.id_persona
    LEFT JOIN definicion_tipos q ON q.id=p.tipo_identificacion AND q.id_tipo=5
    LEFT JOIN ips r ON o.ips=r.id
    LEFT JOIN definicion_tipos s ON s.id=o.indicador_fraude AND s.id_tipo=12
    LEFT JOIN investigadores iv ON iv.id = a.id_investigador
    WHERE DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."' AND a.id_aseguradora='".$aseguradoraReporteBasico."'";

  if($tipoCasoReporteBasico==7 || $tipoCasoReporteBasico==8){
    $consultarRegistroDiario[1].=" and a.tipo_solicitud=2";
  }else{
    $consultarRegistroDiario[1].=" and a.tipo_solicitud=1";
  }

  if ($tipoCasoReporteBasico=="t")
  {
    $consultarRegistroDiario[1].=" AND c.descripcion<>5";
  }else{
    $consultarRegistroDiario[1].=" AND c.descripcion='".$tipoCasoReporteBasico."'";
  }
  

  if($_SESSION['tipo_usuario'] == 4){
    $consultarRegistroDiario[1].=" and a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }
  $consultarRegistroDiario[1].=" AND a.estado=1 GROUP BY a.id";

  $consultarRegistroDiario[2]="SELECT case when o.tipo_persona = 1 then 'PRINCIPAL' ELSE 'SEGUNDO LES' END tipo_persona, o.condicion,  CASE WHEN (o.servicio_ambulancia = 's') AND ( o.tipo_traslado_ambulancia = 2) THEN 'AMBULANCIA - OTRO SITIO' 
    WHEN o.servicio_ambulancia = 's' THEN 'AMBULANCIA' WHEN o.servicio_ambulancia = 'n' THEN 'PROPIOS MEDIOS' ELSE '' END servicio, 
    CASE WHEN o.tipo_traslado_ambulancia = 1 THEN 'PRIMARIO' WHEN o.tipo_traslado_ambulancia = 2 THEN 'SECUNDARIO' ELSE 'PROPIOS MEDIOS' END tipo_traslado,a.codigo,a.tipo_caso,d.descripcion as descripcion_tipo_caso,
    CASE WHEN b.fecha_accidente IS NULL THEN 'NO REGISTRA' ELSE b.fecha_accidente END AS fecha_accidente,
    CASE WHEN a.fecha_conocimiento IS NULL THEN 'NO REGISTRA' ELSE a.fecha_conocimiento END AS fecha_conocimiento,
    a.fecha_cargue AS fecha_entrega,
    CASE WHEN i.placa IS NULL THEN 'NO REGISTRA' ELSE i.placa END AS placa, 
    CASE WHEN h.numero IS NULL THEN 'NO REGISTRA' ELSE h.numero END AS numero_poliza, 
    CASE WHEN h.ciudad_expedicion IS NULL THEN 'NO REGISTRA' ELSE CONCAT(k.nombre,' - ',j.nombre) END AS lugar_expedicion_poliza,
    CASE WHEN l.id IS NULL THEN 'NO REGISTRA' ELSE l.nombre END AS ciudad_ocurrencia, 
    CASE WHEN m.id IS NULL THEN 'NO REGISTRA' ELSE m.nombre END AS departamento_ocurrencia,
    s.descripcion AS indicador_fraude,
    o.resultado AS id_resultado, CASE WHEN o.resultado = 1 THEN (SELECT a1.descripcion2 FROM definicion_tipos a1 LEFT JOIN aseguradoras b1 ON b1.resultado_atender=a1.id AND a1.id_tipo=10 WHERE b1.id = a.id_aseguradora) ELSE (SELECT a1.descripcion2 FROM definicion_tipos a1 LEFT JOIN aseguradoras b1 ON b1.resultado_no_atender=a1.id AND a1.id_tipo=10 WHERE b1.id = a.id_aseguradora) END AS resultado,
    CONCAT(p.nombres,' ',CASE WHEN p.apellidos IS NULL THEN '' ELSE p.apellidos END) AS nombre_lesionado,
    q.descripcion AS tipo_identificacion_lesionado,p.identificacion AS identificacion_lesionado,
    q1.descripcion AS tipo_identificacion_reclamante, p1.identificacion AS identificacion_reclamante,
    CONCAT(p1.nombres,' ',p1.apellidos) AS nombre_reclamante,o.observaciones AS observaciones,
    CASE WHEN n.id IS NULL THEN 'NO REGISTRA' ELSE n.descripcion END AS tipo_zona,
    CONCAT(e.nombres,' ',e.apellidos) as nombre_usuario_actual,CONCAT(f.nombres,' ',f.apellidos) as nombre_usuario_crear,
    CASE WHEN b.fecha_diligencia_formato_declaracion = '0000-00-00' 
    THEN 'NO REGISTRA' 
    WHEN b.fecha_diligencia_formato_declaracion IS NULL THEN 'NO REGISTRA'
    ELSE b.fecha_diligencia_formato_declaracion END AS fecha_diligencia_formato_declaracion
    , CASE WHEN a.id_tipo_auditoria = 1 THEN 'DECLARACIÓN' WHEN a.id_tipo_auditoria = 2 THEN 'AUDITORÍA TELÉFONICA' ELSE 'NO REGISTRA' END AS tipo_auditoria, CONCAT(iv.nombres, ' ', iv.apellidos) AS investigador
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_soat b ON b.id_investigacion = a.id 
    LEFT JOIN definicion_tipos c ON c.descripcion2=a.tipo_caso AND c.id_tipo=31
    LEFT JOIN definicion_tipos d ON d.id=a.tipo_caso AND d.id_tipo=8
    LEFT JOIN usuarios e ON e.id=a.id_usuario
    LEFT JOIN usuarios f ON f.id=a.usuario
    LEFT JOIN polizas h ON h.id=b.id_poliza
    LEFT JOIN vehiculos i ON i.id=h.id_vehiculo
    LEFT JOIN ciudades j ON j.id=h.ciudad_expedicion
    LEFT JOIN departamentos k ON k.id=j.id_departamento
    LEFT JOIN ciudades l ON l.id=b.ciudad_ocurrencia
    LEFT JOIN departamentos m ON m.id=l.id_departamento
    LEFT JOIN definicion_tipos n ON n.id_tipo=11 AND n.id=b.tipo_zona
    LEFT JOIN personas_investigaciones_soat o ON o.id_investigacion=a.id AND o.tipo_persona=1
    LEFT JOIN personas_investigaciones_soat o1 ON o1.id_investigacion = o.id_investigacion AND o1.tipo_persona=3 
    LEFT JOIN personas p ON p.id=o.id_persona
    LEFT JOIN personas p1 ON p1.id=o1.id_persona
    LEFT JOIN definicion_tipos q ON q.id=p.tipo_identificacion AND q.id_tipo=5
    LEFT JOIN definicion_tipos q1 ON q1.id=p1.tipo_identificacion AND q1.id_tipo=5
    LEFT JOIN definicion_tipos s ON s.id=o.indicador_fraude AND s.id_tipo=12
    LEFT JOIN investigadores iv ON iv.id = a.id_investigador
    WHERE DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."' AND a.id_aseguradora='".$aseguradoraReporteBasico."'";

  if($tipoCasoReporteBasico==7 || $tipoCasoReporteBasico==8){
    $consultarRegistroDiario[2].=" and a.tipo_solicitud=2";
  }else{
    $consultarRegistroDiario[2].=" and a.tipo_solicitud=1";
  }
  

  if ($tipoCasoReporteBasico=="t")
  {
    $consultarRegistroDiario[2].=" AND c.descripcion<>5 ";
  }else{
    $consultarRegistroDiario[2].=" AND c.descripcion='".$tipoCasoReporteBasico."' ";
  }


  if($_SESSION['tipo_usuario'] == 4){
    $consultarRegistroDiario[2].=" and a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }

  $consultarRegistroDiario[2].=" AND a.estado=1 GROUP BY a.id";

  //$GMTrans = array("1","2","3","4","5","6","13","14");
  //$MuerteIncapacidad = array("7","8","9","10");
  //CONSULTA PARA TIPO CASOS POR TIPO DE REPORTE
  $consultaOpcion = 'SELECT a.descripcion, 1 AS consulta FROM definicion_tipos a 
  WHERE a.id_tipo = 31 AND a.descripcion2 IN("1","2","3","4","5","6","13","14") GROUP BY a.descripcion
  UNION ALL
  SELECT b.descripcion, 2 AS consulta FROM definicion_tipos b 
  WHERE b.id_tipo = 31 AND b.descripcion2 IN("7","8","9","10") GROUP BY b.descripcion';

  $queryOpcion=mysqli_query($con,$consultaOpcion);
  $opQuery = 1;
  while ($resOpcion=mysqli_fetch_array($queryOpcion,MYSQLI_ASSOC)){
    if($tipoCasoReporteBasico == $resOpcion["descripcion"]){
      $opQuery = $resOpcion["consulta"];
    }
  }


  mysqli_next_result($con);

  $queryRegistroDiario=mysqli_query($con,$consultarRegistroDiario[$opQuery]);

  while ($resRegistroDiario=mysqli_fetch_array($queryRegistroDiario,MYSQLI_ASSOC)){

    $fechaAccidente=$resRegistroDiario["fecha_accidente"];
    $fechaConocimiento=$resRegistroDiario["fecha_conocimiento"];
    $fechaEntrega=$resRegistroDiario["fecha_entrega"];
    $ciudadOcurrencia=$resRegistroDiario["ciudad_ocurrencia"];
    $departamentoOcurrencia=$resRegistroDiario["departamento_ocurrencia"];
    $tipoZona=$resRegistroDiario["tipo_zona"];
    $tipo_auditoria=$resRegistroDiario["tipo_auditoria"];
    $poliza=$resRegistroDiario["numero_poliza"];
    $lugar_expedicion_poliza=$resRegistroDiario["lugar_expedicion_poliza"];
    $placa=$resRegistroDiario["placa"];
    $fecha_diligencia=$resRegistroDiario["fecha_diligencia_formato_declaracion"];
    $analistaActual=$resRegistroDiario["nombre_usuario_actual"];
    $analistaCrear=$resRegistroDiario["nombre_usuario_crear"];
    $nombreVictima=$resRegistroDiario["nombre_lesionado"];
    $identificacionVictima=$resRegistroDiario["identificacion_lesionado"];
    $tipoIdentificacionVictima=$resRegistroDiario["tipo_identificacion_lesionado"];

    //VALIDACION PARA ESTADO 
    /*if($aseguradoraReporteBasico == 2){

      $usuEstadoPermitidos = array('1','4','8','9','15','16','17','18','36','59','77','501');

      if(in_array($usuarioReporteBasico, $usuEstadoPermitidos)){
        $resultadoVictima=$resRegistroDiario["resultado"];
      } else{
        $resultadoVictima="NO APLICA";
      }
    } else{*/
      $resultadoVictima=$resRegistroDiario["resultado"];
    //}

    $tipologiaVictima=$resRegistroDiario["indicador_fraude"];
    $nombreReclamante=$resRegistroDiario["nombre_reclamante"];
    $tipoIdentificacionReclamante=$resRegistroDiario["tipo_identificacion_reclamante"];
    $identificacionReclamante=$resRegistroDiario["identificacion_reclamante"];
    $observaciones=$resRegistroDiario["observaciones"];
    $investigador=$resRegistroDiario["investigador"];

    $data[]=array("codigo"=>$resRegistroDiario["codigo"],
      "tipo_caso"=>$resRegistroDiario["descripcion_tipo_caso"],
      "fecha_accidente"=>$fechaAccidente,
      "fecha_conocimiento"=>$fechaConocimiento,
      "fecha_entrega"=>$fechaEntrega,
      "placa"=>$placa,
      "poliza"=>$poliza,
      "lugar_expedicion_poliza"=>$lugar_expedicion_poliza,
      "ciudad_ocurrencia"=>$ciudadOcurrencia,
      "departamento_ocurrencia"=>$departamentoOcurrencia,
      "tipo_identificacion_reclamante"=>$tipoIdentificacionReclamante,
      "identifidad_reclamante"=>$identificacionReclamante,
      "nombre_reclamante"=>$nombreReclamante,
      "tipo_identificacion_victima"=>$tipoIdentificacionVictima,
      "identificacion_victima"=>$identificacionVictima,
      "nombre_victima"=>$nombreVictima,
      "resultado_investigacion"=>$resultadoVictima,
      "tipologia_hallazgo"=>$tipologiaVictima,
      "perimetro"=>$tipoZona,
      "observaciones"=>$observaciones,
      "usuarioActual"=>$analistaActual,
      "usuarioCrear"=>$analistaCrear,
      "tipo_auditoria"=>$tipo_auditoria,
      "servicio"=>$resRegistroDiario["servicio"],
      "tipo_traslado"=>$resRegistroDiario["tipo_traslado"],
      "tipo_persona"=>$resRegistroDiario["tipo_persona"],
      "investigador"=>$investigador
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function reporteCargueInformes($fechaInicioReporteBasico,$fechaFinReporteBasico,$aseguradoraReporteBasico){
  global $con;
  $data=array();
  $consultarInformes="SELECT f.nombre_aseguradora,a.codigo,e.descripcion as tipo_caso,a.fecha_inicio,a.fecha_entrega,concat(c.nombres,' ',c.apellidos) as nombre_analista, CASE 
  WHEN b.vigente='c' THEN 'NO REGISTRA'
  ELSE 'SI' END AS informe
  FROM investigaciones a
  LEFT JOIN multimedia_investigacion b on a.id=b.id_investigacion
  LEFT JOIN usuarios c on c.id=a.id_usuario

  LEFT JOIN definicion_tipos e on e.id=a.tipo_caso
  LEFT JOIN aseguradoras f ON f.id=a.id_aseguradora
  WHERE e.id_tipo=8 and a.tipo_solicitud=1 and b.id_multimedia=9 AND DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";

  if ($aseguradoraReporteBasico<>0){
    $consultarInformes.=" AND a.id_aseguradora='".$aseguradoraReporteBasico."'";
  }

  $queryInformes=mysqli_query($con,$consultarInformes);

  while ($resInformes=mysqli_fetch_array($queryInformes,MYSQLI_ASSOC))    {
    $data[]=array("codigo"=>$resInformes["codigo"],
      "aseguradora"=>$resInformes["nombre_aseguradora"],
      "tipo_caso"=>$resInformes["tipo_caso"],
      "nombre_analista"=>$resInformes["nombre_analista"],
      "fecha_inicio"=>$resInformes["fecha_inicio"],
      "fecha_entrega"=>$resInformes["fecha_entrega"],
      "informe"=>$resInformes["informe"]);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultarCasosValidacionesHistorico($codigoFrmBuscarValIPS,$identificacionFrmBuscarValIPS,$razonSocialFrmBuscarValIPS,$identificadorFrmBuscarValIPS,$tipoConsultaBuscar,$usuario){
  $con2= mysqli_connect("localhost","grbd","Global.2021","ltdaglob_u7365390");

  mysqli_set_charset($con2, "utf8");
  if (!$con2) {
    die("Connection failed: " . mysqli_connect_error());
  }

  global $con;

  $consultarTipoUsuario=mysqli_query($con,"SELECT * FROM usuarios WHERE id='".$usuario."'");
  $resTipoUsuario=mysqli_fetch_array($consultarTipoUsuario,MYSQLI_ASSOC);

  mysqli_next_result($con);
  $regs="";
  $data=array();

  if ($tipoConsultaBuscar=="buscarCasosFiltrosHistorico"){
    $consultarFiltrosValidaciones="SELECT case when g.url_informe is null then 'N' else g.url_informe end as informe,a.fecha_matricula,a.fecha_asignacion,concat(f.descripcion2,a.id) AS consecutivo,e.descripcion as tipo_solicitud,f.descripcion AS tipo_investigacion,a.id,a.nombre_ips, a.identificacion AS identificacion_ips,CASE WHEN a.tipo_identificacion_representante='' THEN  '0' WHEN a.tipo_identificacion_representante is null THEN  '0' ELSE a.tipo_identificacion_representante END AS tipo_identificacion_representante,a.identificacion_representante,a.dig_ver AS digito_verificacion, a.direccion,a.telefono,CONCAT(c.nombres,' ',c.apellidos) AS analista,d.nombre AS aseguradora,CONCAT(CONCAT_WS('','',a.nombres_representante),' ',CONCAT_WS('','',a.apellidos_representante)) AS nombre_representante FROM validacion_ips a LEFT JOIN aseguradora d ON a.id_aseguradora=d.id LEFT JOIN usuarios_siglo c ON a.id_analista=c.id LEFT JOIN definicion_tipos e ON e.id=a.tipo_solicitud LEFT JOIN definicion_tipos f ON f.id=a.asignado LEFT JOIN up_pdf g ON g.id_informe=a.id LEFT JOIN aseguradora h ON a.id_aseguradora=h.id WHERE e.id_tipo=2 and f.id_tipo=3";

    $cont=0;
    $id_aseguradora_usuario = $resTipoUsuario["id_aseguradora"];

    switch ($id_aseguradora_usuario) {
      case 2:
      //ESTADO
      $id_aseguradora_usuario = 3;
      break;

      case 5:
      //EQUIDAD
      $id_aseguradora_usuario = 4;
      break;

      case 4:
      //Allianz
      $id_aseguradora_usuario = 5;
      break;

      case 8:
      //LIBERTY
      $id_aseguradora_usuario = 6;
      break;

      case 3:
      //QBE
      $id_aseguradora_usuario = 8;
      break;

      case 7:
      //SOLIDARIA
      $id_aseguradora_usuario = 9;
      break;

      case 6:
      //AXA
      $id_aseguradora_usuario = 10;
      break;
    }

    if ($resTipoUsuario["tipo_usuario"]==4){
      $consultarFiltrosValidaciones.=" AND ";

      $consultarFiltrosValidaciones.=" a.id_aseguradora='".$id_aseguradora_usuario."'";
      $cont++;
    }

    if ($codigoFrmBuscarValIPS!=""){
      $codigo = substr($codigoFrmBuscarValIPS, 3);
      $consultarFiltrosValidaciones.=" AND ";

      $consultarFiltrosValidaciones.=" a.id='".$codigo."'";
      $cont++;
    }
    else{
      if ($identificacionFrmBuscarValIPS!=""){
        $consultarFiltrosValidaciones.=" AND REPLACE(a.identificacion,'.','')='".$identificacionFrmBuscarValIPS."'";
        $cont++;
      }else if ($razonSocialFrmBuscarValIPS!=""){

        $consultarFiltrosValidaciones.=" AND a.nombre_ips LIKE '".$razonSocialFrmBuscarValIPS."'";
        $cont++;
      }else if ($identificadorFrmBuscarValIPS!=""){

        $consultarFiltrosValidaciones.=" AND c.identificador='".$identificadorFrmBuscarValIPS."'";            
        $cont++;
      }
    }
    $queryCasosFiltrosValidaciones=mysqli_query($con2,$consultarFiltrosValidaciones);

    while ($resInformacionValidaciones=mysqli_fetch_array($queryCasosFiltrosValidaciones,MYSQLI_ASSOC)){
      $opciones="";
      $opciones.="<div class='btn-group'>";

      $opciones.="<button type='button' class='btn btn-success' name='".$resInformacionValidaciones["id"]."'>";
      
      if ($resInformacionValidaciones["informe"]<>'N'){
        $opciones.="<span class='fa fa-file-pdf-o'></span>";
      }

      $opciones.=$resInformacionValidaciones["consecutivo"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInformacionValidaciones["id"]."'>";
      $opciones.="<span class='caret'></span>
      <span class='sr-only'>Toggle Dropdown</span>
      </button>
      <ul class='dropdown-menu' role='menu'>";
      
      if ($resInformacionValidaciones["informe"]<>'N'){
        global $rutaArchivos;
        $opciones.="<li><a target='_blank' href='".$rutaArchivos."informes/".$resInformacionValidaciones["informe"].'?'.time()."'>Ver Informe</a></li></ul></div>";  
      }

      $informacionGeneral="";
      if ($resTipoUsuario["tipo_usuario"]<>4){
        $informacionGeneral.="<b>Usuario: </b>".$resInformacionValidaciones["analista"]."<br>";
      } 

      $informacionGeneral.="<b>Aseguradora: </b>".$resInformacionValidaciones["aseguradora"]."<br><b>Tipo de Caso: </b>".$resInformacionValidaciones["tipo_investigacion"]."<br><b>Tipo de Solicitud: </b>".$resInformacionValidaciones["tipo_solicitud"];  

      $data[]=array("GeneralCasosValidaciones"=>$informacionGeneral,
        "IPSCasoValidaciones"=>"<b>Nombre: </b>".$resInformacionValidaciones["nombre_ips"]."<br>"."<b>Identificacion: </b>".$resInformacionValidaciones["identificacion_ips"],
        "RepLegalValidaciones"=>"<b>Nombre: </b>".$resInformacionValidaciones["nombre_representante"]."<br>"."<b>Identificacion: </b>".$resInformacionValidaciones["identificacion_representante"],
        "opciones"=>$opciones); 
    }
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
  mysql_close($con2);
}

function consultarCasosValidaciones($codigoFrmBuscarValIPS,$identificacionFrmBuscarValIPS,$razonSocialFrmBuscarValIPS,$identificadorFrmBuscarValIPS,$tipoConsultaBuscar,$usuario){
  global $con;
  $data=array();

  $consultarTipoUsuario=mysqli_query($con,"SELECT * FROM usuarios WHERE id='".$usuario."'");
  $resTipoUsuario=mysqli_fetch_array($consultarTipoUsuario,MYSQLI_ASSOC);
  mysqli_next_result($con);
  
  if ($tipoConsultaBuscar=="buscarCasosFiltros"){
    $consultarFiltrosValidaciones="SELECT a.id_usuario,h.descripcion AS desc_tipo_caso,
    g.nombre_aseguradora,
    a.id as id_investigacion,
    a.tipo_caso,
    a.codigo,
    CASE 
    WHEN b.identificacion_entidad IS NULL THEN 'NO REGISTRA'
    ELSE CONCAT(b.identificacion_entidad,'-',b.digver_entidad) END AS identificacion_entidad,
    CASE 
    WHEN b.nombre_representante IS NULL THEN 'NO REGISTRA'
    ELSE  CONCAT(b.nombre_representante,' ',b.apellidos_representante) END AS nombre_representante,
    CASE 
    WHEN b.nombre_entidad IS NULL THEN 'NO REGISTRA'
    ELSE  b.nombre_entidad END AS nombre_entidad, 
    CASE 
    WHEN b.identificacion_representante IS NULL THEN 'NO REGISTRA'
    ELSE  b.identificacion_representante END AS identificacion_representante, 
    CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,
    f.descripcion AS tipo_solicitud
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_validaciones b ON a.id=b.id_investigacion
    LEFT JOIN id_casos_aseguradora c ON c.id_investigacion=a.id 
    LEFT JOIN usuarios e ON e.id=a.id_usuario
    LEFT JOIN definicion_tipos f ON f.id=a.tipo_solicitud
    LEFT JOIN aseguradoras g ON g.id=a.id_aseguradora
    LEFT JOIN definicion_tipos h ON h.id=a.tipo_caso
    WHERE h.id_tipo=8 and f.id_tipo=14 ";
    $cont=0;

    if ($resTipoUsuario["tipo_usuario"]==4){
      $consultarFiltrosValidaciones.=" AND a.id_aseguradora='".$resTipoUsuario["id_aseguradora"]."' AND a.estado = 1";
      $cont++;
    }

    if ($codigoFrmBuscarValIPS!=""){
      $consultarFiltrosValidaciones.=" AND a.codigo='".$codigoFrmBuscarValIPS."'";
      $cont++;
    }
    else{
      if ($identificacionFrmBuscarValIPS!=""){
        $consultarFiltrosValidaciones.=" AND b.identificacion_entidad='".$identificacionFrmBuscarValIPS."'";
        $cont++;
      }else if ($razonSocialFrmBuscarValIPS!=""){

        $consultarFiltrosValidaciones.=" AND b.nombre_entidad='".$razonSocialFrmBuscarValIPS."'";
        $cont++;
      }else if ($identificadorFrmBuscarValIPS!=""){

        $consultarFiltrosValidaciones.=" AND c.identificador='".$identificadorFrmBuscarValIPS."'";            
        $cont++;

      }
    }
  }
  else if ($tipoConsultaBuscar=="buscarCasoSinInformeValidaciones"){
    $consultarFiltrosValidaciones="SELECT a.id_usuario,h.descripcion AS desc_tipo_caso,
    g.nombre_aseguradora,
    a.id as id_investigacion,
    a.tipo_caso,
    a.codigo,
    CASE 
    WHEN b.identificacion_entidad IS NULL THEN 'NO REGISTRA'
    ELSE CONCAT(b.identificacion_entidad,'-',b.digver_entidad) END AS identificacion_entidad,
    CASE 
    WHEN b.nombre_representante IS NULL THEN 'NO REGISTRA'
    ELSE  CONCAT(b.nombre_representante,' ',b.apellidos_representante) END AS nombre_representante,
    CASE 
    WHEN b.nombre_entidad IS NULL THEN 'NO REGISTRA'
    ELSE  b.nombre_entidad END AS nombre_entidad, 
    CASE 
    WHEN b.identificacion_representante IS NULL THEN 'NO REGISTRA'
    ELSE  b.identificacion_representante END AS identificacion_representante, 
    CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,
    f.descripcion AS tipo_solicitud
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_validaciones b ON a.id=b.id_investigacion
    LEFT JOIN id_casos_aseguradora c ON c.id_investigacion=a.id 
    LEFT JOIN usuarios e ON e.id=a.id_usuario
    LEFT JOIN definicion_tipos f ON f.id=a.tipo_solicitud
    LEFT JOIN aseguradoras g ON g.id=a.id_aseguradora
    LEFT JOIN definicion_tipos h ON h.id=a.tipo_caso
    LEFT JOIN multimedia_investigacion i ON a.id=i.id_investigacion
    WHERE h.id_tipo=8 and f.id_tipo=14 and i.id_multimedia=9 AND i.vigente='c' and a.id_usuario='".$usuario."'";
  }
  else if ($tipoConsultaBuscar=="buscarCasoAsignadosValidaciones"){
    $consultarFiltrosValidaciones="SELECT a.id_usuario,h.descripcion AS desc_tipo_caso,
    g.nombre_aseguradora,
    a.id as id_investigacion,
    a.tipo_caso,
    a.codigo,
    CASE 
    WHEN b.identificacion_entidad IS NULL THEN 'NO REGISTRA'
    ELSE CONCAT(b.identificacion_entidad,'-',b.digver_entidad) END AS identificacion_entidad,
    CASE 
    WHEN b.nombre_representante IS NULL THEN 'NO REGISTRA'
    ELSE  CONCAT(b.nombre_representante,' ',b.apellidos_representante) END AS nombre_representante,
    CASE 
    WHEN b.nombre_entidad IS NULL THEN 'NO REGISTRA'
    ELSE  b.nombre_entidad END AS nombre_entidad, 
    CASE 
    WHEN b.identificacion_representante IS NULL THEN 'NO REGISTRA'
    ELSE  b.identificacion_representante END AS identificacion_representante, 
    CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,
    f.descripcion AS tipo_solicitud
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_validaciones b ON a.id=b.id_investigacion
    LEFT JOIN id_casos_aseguradora c ON c.id_investigacion=a.id 
    LEFT JOIN usuarios e ON e.id=a.id_usuario
    LEFT JOIN definicion_tipos f ON f.id=a.tipo_solicitud
    LEFT JOIN aseguradoras g ON g.id=a.id_aseguradora
    LEFT JOIN definicion_tipos h ON h.id=a.tipo_caso
    LEFT JOIN estado_investigaciones i ON a.id=i.id_investigacion
    WHERE h.id_tipo=8 and f.id_tipo=14 and i.estado=18 AND i.vigente='s' and a.id_usuario='".$usuario."'";
  }
  else if ($tipoConsultaBuscar=="buscarCasoAsignadosAseguradoraValidaciones"){
    $consultarFiltrosValidaciones="SELECT a.id_usuario,h.descripcion AS desc_tipo_caso,
    g.nombre_aseguradora,
    a.id as id_investigacion,
    a.tipo_caso,
    a.codigo,
    CASE 
    WHEN b.identificacion_entidad IS NULL THEN 'NO REGISTRA'
    ELSE CONCAT(b.identificacion_entidad,'-',b.digver_entidad) END AS identificacion_entidad,
    CASE 
    WHEN b.nombre_representante IS NULL THEN 'NO REGISTRA'
    ELSE  CONCAT(b.nombre_representante,' ',b.apellidos_representante) END AS nombre_representante,
    CASE 
    WHEN b.nombre_entidad IS NULL THEN 'NO REGISTRA'
    ELSE  b.nombre_entidad END AS nombre_entidad, 
    CASE 
    WHEN b.identificacion_representante IS NULL THEN 'NO REGISTRA'
    ELSE  b.identificacion_representante END AS identificacion_representante, 
    CONCAT(e.nombres,' ',e.apellidos) AS nombre_usuario,
    f.descripcion AS tipo_solicitud
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_validaciones b ON a.id=b.id_investigacion
    LEFT JOIN id_casos_aseguradora c ON c.id_investigacion=a.id 
    LEFT JOIN usuarios e ON e.id=a.id_usuario
    LEFT JOIN definicion_tipos f ON f.id=a.tipo_solicitud
    LEFT JOIN aseguradoras g ON g.id=a.id_aseguradora
    LEFT JOIN definicion_tipos h ON h.id=a.tipo_caso
    LEFT JOIN estado_investigaciones i ON a.id=i.id_investigacion
    WHERE h.id_tipo=8 and f.id_tipo=14 and i.estado in (1,12,13) AND i.vigente='s'";
  }

  $queryCasosFiltrosValidaciones=mysqli_query($con,$consultarFiltrosValidaciones);

  while ($resInformacionValidaciones=mysqli_fetch_array($queryCasosFiltrosValidaciones,MYSQLI_ASSOC)){
    mysqli_next_result($con);
    $consultarInforme=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$resInformacionValidaciones["id_investigacion"]."' and id_multimedia=9 and vigente<>'c'");
    $cantidadInformes=mysqli_num_rows($consultarInforme);
    $resInforme=mysqli_fetch_array($consultarInforme,MYSQLI_ASSOC);

    mysqli_next_result($con);
    $consultarAudio=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$resInformacionValidaciones["id_investigacion"]."' and id_multimedia=15");
    $resAudio=mysqli_fetch_array($consultarAudio,MYSQLI_ASSOC);
    $cantidadAudio=mysqli_num_rows($consultarAudio);

    mysqli_next_result($con);
    $consultarTipoCaso=mysqli_query($con,"SELECT descripcion as tipo_caso FROM definicion_tipos WHERE descripcion2='".$resInformacionValidaciones["tipo_caso"]."' and id_tipo=13");
    $resTipoCaso=mysqli_fetch_array($consultarTipoCaso,MYSQLI_ASSOC);

    $opciones="";
    $opciones.="<div class='btn-group'>";

    $opciones.="<button type='button' class='btn btn-success' name='".$resInformacionValidaciones["id_investigacion"]."'>";
    
    if ($cantidadInformes>0){
      $opciones.="<span class='fa fa-file-pdf-o'></span>";
    }

    $opciones.=$resInformacionValidaciones["codigo"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInformacionValidaciones["id_investigacion"]."'>";
    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>";
    
    if ($cantidadInformes>0){
      global $rutaArchivos;
      $opciones.="<li><a target='_blank' href='".$rutaArchivos."informes/".$resInforme["ruta"].'?'.time()."'>Ver Informe</a></li><li class='divider'></li>";
    }
    if ($cantidadAudio>0){
      $opciones.="<li><a id='btnDescargarAudioCasoSoat' href='bd/forzarDescargaArchivos.php?id_caso=".$resInformacionValidaciones["id_investigacion"]."'>Descargar Audio</a></li><li class='divider'></li>";  
    }

    if ($resTipoUsuario["tipo_usuario"]==4 && $resInformacionValidaciones["id_usuario"]==$usuario && $resTipoCaso["tipo_caso"]=="2"){
      $opciones.="<li><a name='".$resInformacionValidaciones["id_investigacion"]."' id='btnEditarAsignacionCasoValidacion'>Editar</a></li>";
    }
    else if (($resInformacionValidaciones["id_usuario"]==$usuario || $resTipoUsuario["tipo_usuario"]==2 || $resTipoUsuario["tipo_usuario"]==3) && $resTipoUsuario["tipo_usuario"]<>4){
      
      $opciones.="
      <li><a name='".$resInformacionValidaciones["id_investigacion"]."' id='btnEditarCasoValidacion'>Editar</a></li>
      <li class='divider'></li>
      <li><a name='".$resInformacionValidaciones["id_investigacion"]."' id='btnGestionarCasoValidacion'>Gestionar</a></li>
      <li class='divider'></li>
      <li><a name='".$resInformacionValidaciones["id_investigacion"]."' id='btnAsignarAnalistaCasoValidacion'>Asignar Analista</a></li>
      <li class='divider'></li>
      <li><a name='".$resInformacionValidaciones["id_investigacion"]."' id='btnEliminarCasoValidacion'>Eliminar</a></li></ul></div>";
    }

    $informacionGeneral="";
    if ($resTipoUsuario["tipo_usuario"]<>4){
      $informacionGeneral.="<b>Usuario: </b>".$resInformacionValidaciones["nombre_usuario"]."<br>";
    }  
    $informacionGeneral.="<b>Aseguradora: </b>".$resInformacionValidaciones["nombre_aseguradora"]."<br><b>Tipo de Caso: </b>".$resInformacionValidaciones["desc_tipo_caso"]."<br><b>Tipo de Solicitud: </b>".$resInformacionValidaciones["tipo_solicitud"];

    if ($resTipoUsuario["tipo_usuario"]==4){
      mysqli_next_result($con);
      $consultarCasoAsignado=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=13 and descripcion=2 and descripcion2='".$resInformacionValidaciones["tipo_caso"]."'");

      if ($cantidadInformes>0 || mysqli_num_rows($consultarCasoAsignado)>0){
        $data[]=array("GeneralCasosValidaciones"=>$informacionGeneral,
          "IPSCasoValidaciones"=>"<b>Nombre: </b>".$resInformacionValidaciones["nombre_entidad"]."<br>"."<b>Identificacion: </b>".$resInformacionValidaciones["identificacion_entidad"],
          "RepLegalValidaciones"=>"<b>Nombre: </b>".$resInformacionValidaciones["nombre_representante"]."<br>"."<b>Identificacion: </b>".$resInformacionValidaciones["identificacion_representante"],
          "opciones"=>$opciones,
          "idInvestigacion"=>$resInformacionValidaciones["id_investigacion"]); 
      }
    }else{
      $data[]=array("GeneralCasosValidaciones"=>$informacionGeneral,
        "IPSCasoValidaciones"=>"<b>Nombre: </b>".$resInformacionValidaciones["nombre_entidad"]."<br>"."<b>Identificacion: </b>".$resInformacionValidaciones["identificacion_entidad"],
        "RepLegalValidaciones"=>"<b>Nombre: </b>".$resInformacionValidaciones["nombre_representante"]."<br>"."<b>Identificacion: </b>".$resInformacionValidaciones["identificacion_representante"],
        "opciones"=>$opciones,
        "idInvestigacion"=>$resInformacionValidaciones["id_investigacion"]); 
    }
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultarBeneficiariosInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultarBeneficiariosCasoSOAT="SELECT a.parentesco,a.tipo_persona,CONCAT(b.nombres,' ',b.apellidos) as nombre_beneficiario,CONCAT(c.descripcion,' ',b.identificacion) as identificacion_beneficiario,a.id 
  FROM personas_investigaciones_soat a
  LEFT JOIN personas b ON a.id_persona=b.id
  LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
  WHERE a.tipo_persona=4 and  a.id_investigacion='".$idInvestigacion."' and c.id_tipo=5";
  $queryBeneficiariosCasoSOAT=mysqli_query($con,$consultarBeneficiariosCasoSOAT);
  $opciones="";
  
  while ($resBeneficiariosCasoSOAT=mysqli_fetch_array($queryBeneficiariosCasoSOAT,MYSQLI_ASSOC)){
    $opciones="";
    $opciones="<div class='btn-group'><button type='button' class='btn btn-success' name='".$resBeneficiariosCasoSOAT["id"]."' id=''>".$resBeneficiariosCasoSOAT["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resBeneficiariosCasoSOAT["id"]."'><span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resBeneficiariosCasoSOAT["id"]."' id='btnEditarBeneficiarioSOAT'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resBeneficiariosCasoSOAT["id"]."' id='btnEliminarBeneficiarioSOAT'>Eliminar</a></li>
    </ul></div>";

    $data[]=array("nombreBeneficiario"=>$resBeneficiariosCasoSOAT["nombre_beneficiario"],
      "identificacionBeneficiario"=>$resBeneficiariosCasoSOAT["identificacion_beneficiario"],
      "parentescoBeneficiario"=>$resBeneficiariosCasoSOAT["parentesco"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultarMultimediaInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultarMultimedia="SELECT b.descripcion as seccion,a.*
  FROM multimedia_investigacion a
  LEFT JOIN definicion_tipos b ON a.id_multimedia=b.id
  WHERE b.id_tipo=23 and a.id_investigacion='".$idInvestigacion."' and a.id_multimedia in (1,2,3,4,5,6,7,8,12,13,15)";
  $queryMultimedia=mysqli_query($con,$consultarMultimedia);

  while ($resMultimedia=mysqli_fetch_array($queryMultimedia,MYSQLI_ASSOC)){
    $data[]=array("codigoMultimedia"=>$resMultimedia["id"],
      "SeccionMultimedia"=>$resMultimedia["seccion"],
      "verMultimedia"=>"<a href=".'data/multimedia/'.$resMultimedia["ruta"].'?'.time()." data-lightbox=".$resMultimedia["seccion"]." data-title=".$resMultimedia["seccion"]." class='btn btn-success' name='".$resMultimedia["id"]."' id='btnVerMultimedia'>Ver Imagen</a>",
      "eliminarMultimedia"=>"<a class='btn btn-danger' name='".$resMultimedia["id"]."' id='btnEliminarMultimedia'>Eliminar</a>");
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultarVehiculos($placaVehiculo){
  global $con;
  $data=array();
  $consultarVehiculos="SELECT a.id,a.placa, b.descripcion as tipo_vehiculo
  FROM vehiculos a
  LEFT JOIN tipo_vehiculos b ON a.tipo_vehiculo=b.id
  WHERE a.placa like '%".$placaVehiculo."%'";
  $queryVehiculos=mysqli_query($con,$consultarVehiculos);

  while ($resVehiculos=mysqli_fetch_array($queryVehiculos,MYSQLI_ASSOC)){
    $data[]=array("placaVehiculo"=>$resVehiculos["placa"],
      "tipoVehiculo"=>$resVehiculos["tipo_vehiculo"],
      "opcionesVehiculo"=>"<a class='btn btn-success' name='".$resVehiculos["id"]."' id='btnSeleccionarVehiculo'>SELECCIONAR</a>");
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  
  return json_encode($results); 
}

function consultarPolizasVehiculos($idVehiculo,$idInvestigacion){
  global $con;
  $data=array();
  $consultarPolizas="SELECT CONCAT(b.numero,' ',b.digito_verificacion) as numero_poliza, c.nombre_aseguradora as aseguradora,b.id as id_poliza
  from polizas b
  LEFT JOIN aseguradoras c ON b.id_aseguradora=c.id
  WHERE b.id_vehiculo='".$idVehiculo."'";
  $queryPolizas=mysqli_query($con,$consultarPolizas);
  $opciones="";
  while ($resPolizas=mysqli_fetch_array($queryPolizas,MYSQLI_ASSOC)){

    mysqli_next_result($con);

    $consultarPolizaInvestigacion=mysqli_query($con,"SELECT * FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."' and id_poliza='".$resPolizas["id_poliza"]."'");

    $opciones="<div class='btn-group'>";

    if (mysqli_num_rows($consultarPolizaInvestigacion)>0){

      $opciones .= "<button type='button' class='btn btn-primary' name='".$resPolizas["id_poliza"]."' id=''>".$resPolizas["id_poliza"]."</button><button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPolizas["id_poliza"]."'>";
    }else{

      $opciones .= "<button type='button' class='btn btn-success' name='".$resPolizas["id_poliza"]."' id=''>".$resPolizas["id_poliza"]."</button><button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resPolizas["id_poliza"]."'>" ;
    }

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resPolizas["id_poliza"]."' id='btnEditarPolizaSOAT'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resPolizas["id_poliza"]."' id='btnEliminarPolizaSOAT'>Eliminar</a></li>
    <li class='divider'></li>";

    if (mysqli_num_rows($consultarPolizaInvestigacion)==0){
      $opciones.="<li><a name='".$resPolizas["id_poliza"]."' id='btnSeleccionarPolizaSOAT'>Seleccionar Poliza</a></li>";
    }

    $opciones.="</ul></div>";

    $data[]=array(
      "noPolizaSOAT"=>$resPolizas["numero_poliza"],
      "companiaPolizaSOAT"=>$resPolizas["aseguradora"],
      "opcionesPolizaSOAT"=>$opciones
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultarPersonas($identificacionPersona){
  global $con;
  $data=array();
  $consultarPersonas="SELECT a.id,CONCAT(a.nombres,' ',a.apellidos) as nombre_persona,concat(b.descripcion,' ',a.identificacion) as identificacion_persona FROM personas a LEFT JOIN definicion_tipos b on a.tipo_identificacion=b.id where b.id_tipo=5 and a.identificacion like '%".$identificacionPersona."%'";
  $queryPersonas=mysqli_query($con,$consultarPersonas);

  while ($resPersonas=mysqli_fetch_array($queryPersonas,MYSQLI_ASSOC)){

    $opciones="<div class='btn-group'><button type='button' class='btn btn-success' name='".$resLesionadosCasoSOAT["id"]."' id=''>".$resLesionadosCasoSOAT["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resLesionadosCasoSOAT["id"]."'><span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resLesionadosCasoSOAT["id"]."' id='btnEditarLesionadoSOAT'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resLesionadosCasoSOAT["id"]."' id='btnEliminarLesionadoSOAT'>Eliminar</a></li>
    <li class='divider'></li>";

    if ($resLesionadosCasoSOAT["tipo_persona"]=="2"){
      $opciones.="<li><a name='".$resLesionadosCasoSOAT["id"]."' id='btnCambiarTPersonaLesionadoSoat'>Primer Lesionado</a></li>";
    }

    $opciones.="</ul></div>";


    $data[]=array("nombrePersona"=>$resPersonas["nombre_persona"],
      "identificacionPersona"=>$resPersonas["identificacion_persona"],
      "opcionesPersona"=>"<a class='btn btn-success' name='".$resPersonas["id"]."' id='btnSeleccionarPersona'>SELECCIONAR</a>");
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultarLesionadosCasoSOAT($idCaso){
  global $con;
  $data=array();
  $consultarLesionadosCasoSOAT="SELECT a.tipo_persona,CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,CONCAT(d.descripcion,' ',b.identificacion) as identificacion_lesionado,c.nombre_ips,a.id,a.resultado,e.descripcion as indicador
  FROM personas_investigaciones_soat a
  LEFT JOIN personas b ON a.id_persona=b.id
  LEFT JOIN ips c ON c.id=a.ips
  LEFT JOIN definicion_tipos d ON d.id=b.tipo_identificacion
  LEFT JOIN definicion_tipos e ON e.id=a.indicador_fraude
  WHERE d.id_tipo=5 AND a.id_investigacion='".$idCaso."' and e.id_tipo=12";
  $queryLesionadosCasoSOAT=mysqli_query($con,$consultarLesionadosCasoSOAT);
  $opciones="";
  
  while ($resLesionadosCasoSOAT=mysqli_fetch_array($queryLesionadosCasoSOAT,MYSQLI_ASSOC)){
    
    $opciones="";    
    if ($resLesionadosCasoSOAT["resultado"]==1){
      $consultarResultado="SELECT c.descripcion2 as resultado
      FROM 
      investigaciones a
      LEFT JOIN aseguradoras b ON b.id=a.id_aseguradora
      LEFT JOIN definicion_tipos c ON b.resultado_atender=c.id
      WHERE a.id=".$idCaso." AND c.id_tipo=10";
    }
    else{
      $consultarResultado="SELECT c.descripcion2 as resultado
      FROM 
      investigaciones a
      LEFT JOIN aseguradoras b ON b.id=a.id_aseguradora
      LEFT JOIN definicion_tipos c ON b.resultado_no_atender=c.id
      WHERE a.id=".$idCaso." AND c.id_tipo=10";
    }

    mysqli_next_result($con);
    $queryResultado=mysqli_query($con,$consultarResultado);
    $resResultado=mysqli_fetch_array($queryResultado,MYSQLI_ASSOC);
    $opciones="<div class='btn-group'><button type='button' class='btn btn-success' name='".$resLesionadosCasoSOAT["id"]."' id=''>".$resLesionadosCasoSOAT["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resLesionadosCasoSOAT["id"]."'><span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resLesionadosCasoSOAT["id"]."' id='btnEditarLesionadoSOAT'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resLesionadosCasoSOAT["id"]."' id='btnEliminarLesionadoSOAT'>Eliminar</a></li>
    <li class='divider'></li>";
    
    if ($resLesionadosCasoSOAT["tipo_persona"]=="2") {
      $opciones.="<li><a name='".$resLesionadosCasoSOAT["id"]."' id='btnCambiarTPersonaLesionadoSoat'>Primer Lesionado</a></li>";
    }

    $opciones.="</ul></div>";
    $data[]=array("nombreLesionadoCasoSOAT"=>$resLesionadosCasoSOAT["nombre_lesionado"],
      "ipsLesionadoCasoSOAT"=>"<b>Identificacion: </b>".$resLesionadosCasoSOAT["identificacion_lesionado"]."<br><b>IPS: </b>".$resLesionadosCasoSOAT["nombre_ips"],
      "informacionLesionadoCasoSOAT"=>"<b>Resultado: </b>".$resResultado["resultado"]."<br>"."<b>Indicador: </b>".$resLesionadosCasoSOAT["indicador"],
      "opcionesLesionadoCasoSOAT"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  
  return json_encode($results); 
}

function consultarAsignacionInvestigadoresClinicas($idClinica){
  global $con;
  $consultarInvestigadoresIPS="SELECT a.id,CONCAT(b.nombres,' ',b.apellidos) as nombre_investigador,b.telefono,concat(c.descripcion,' ',b.identificacion) as identificacion_investigador FROM ips_investigador a LEFT JOIN investigadores b ON a.id_investigador=b.id LEFT JOIN definicion_tipos c on c.id=b.tipo_identificacion WHERE c.id_tipo=5 and a.id_ips='".$idClinica."'";
  $queryInvestigadorIps=mysqli_query($con,$consultarInvestigadoresIPS);
  $data=array();

  while ($resInvestigadorIps=mysqli_fetch_array($queryInvestigadorIps,MYSQLI_ASSOC)){
    $data[]=array("nombreInvestigadorIPS"=>$resInvestigadorIps["nombre_investigador"],
      "identificacionInvestigadorIPS"=>$resInvestigadorIps["identificacion_investigador"],
      "telefonoInvestigadorIPS"=>$resInvestigadorIps["telefono"],
      "opciones"=>"<a class='btn btn-success' name='".$resInvestigadorIps["id"]."' id='btnEliminarInvestigadorIPS'>REMOVER</a>");
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultarInvestigadores($nombreInvestigadorBuscar,$identificacionInvestigadorBuscar){
  global $con;
  $consultaInvestigador="SELECT CONCAT(a.nombres,' ',a.apellidos) as nombre_investigador,a.id,a.vigente,concat(b.descripcion,' ',a.identificacion) as identificacion_investigador,a.correo FROM investigadores a LEFT JOIN definicion_tipos b on a.tipo_identificacion=b.id where b.id_tipo=5";
  $cont = 0;

  if ($nombreInvestigadorBuscar!=""){


    $consultaInvestigador.=" AND a.nombres LIKE '%".$nombreInvestigadorBuscar."%' OR  a.apellidos LIKE '%".$nombreInvestigadorBuscar."%'";
  }

  if ($identificacionInvestigadorBuscar!=""){


    $cont++;
    $consultaInvestigador.=" AND a.identificacion = '".$identificacionInvestigadorBuscar."'" ;

  }


  $queryInvestigador=mysqli_query($con,$consultaInvestigador);
  $regs="";
  $data=array();

  while ($resInvestigador=mysqli_fetch_array($queryInvestigador,MYSQLI_ASSOC)){
    $opciones="<div class='btn-group'>";
    if ($resInvestigador["vigente"]=="s"){
      $opciones.="<button type='button' class='btn btn-success' name='".$resInvestigador["id"]."' id=''>".$resInvestigador["id"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInvestigador["id"]."'>";
    }else if ($resInvestigador["vigente"]=="n"){
      $opciones.="<button type='button' class='btn btn-danger' name='".$resInvestigador["id"]."' id='btnAccionesGestionUsuario'>".$resInvestigador["id"]."</button>
      <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInvestigador["id"]."'>";
    }

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resInvestigador["id"]."' id='btnEditarInvestigador'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resInvestigador["id"]."' id='btnEliminarRegistroInvestigador'>Eliminar</a></li>
    <li class='divider'></li>";
    if ($resInvestigador["vigente"]=="s"){
      $opciones.="<li><a name='".$resInvestigador["id"]."' id='btnPermitirInvestigador'>Deshabilitar</a></li>";
    }else if ($resInvestigador["vigente"]=="n"){
      $opciones.="<li><a name='".$resInvestigador["id"]."' id='btnPermitirInvestigador'>Habilitar</a></li>";
    }

    $opciones.="</ul></div>";

    $data[]=array("nombreInvestigador"=>$resInvestigador["nombre_investigador"],
      "identificacionInvestigador"=>$resInvestigador["identificacion_investigador"],
      "correoInvestigador"=>$resInvestigador["correo"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultaTablaUsuarios($userUsuarioBuscar,$nombreUsuarioBuscar){
  global $con;
  $consultaUsuario="SELECT CONCAT(nombres,' ',apellidos) as nombre_usuario,usuario,id,vigente FROM usuarios";
  $cont = 0;

  if ($nombreUsuarioBuscar!=""){
    if ($cont == 0) {
      $consultaUsuario.=" WHERE ";
    }
    else{
      $consultaUsuario.=" AND ";
    }
    $cont++;
    $consultaUsuario.=" nombres LIKE '%".$nombreUsuarioBuscar."%' OR  apellidos LIKE '%".$nombreUsuarioBuscar."%'";
  }

  if ($userUsuarioBuscar!=""){
    if ($cont == 0) {
      $consultaUsuario.=" WHERE ";
    }
    else{
      $consultaUsuario.=" AND ";
    }
    $cont++;
    $consultaUsuario.="usuario = '".$userUsuarioBuscar."'" ;
  }

  $queryUsuario=mysqli_query($con,$consultaUsuario);
  $regs="";
  $data=array();

  while ($resUsuario=mysqli_fetch_array($queryUsuario,MYSQLI_ASSOC)) {
    $opciones="<div class='btn-group'>";
    if ($resUsuario["vigente"]=="s"){
      $opciones.="<button type='button' class='btn btn-success' name='".$resUsuario["id"]."' id=''>".$resUsuario["id"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resUsuario["id"]."'>";
    }else if ($resUsuario["vigente"]=="n"){
      $opciones.="<button type='button' class='btn btn-danger' name='".$resUsuario["id"]."' id='btnAccionesGestionUsuario'>".$resUsuario["id"]."</button>
      <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resUsuario["id"]."'>";
    }

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resUsuario["id"]."' id='btnEditarUsuario'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resUsuario["id"]."' id='btnOpcionesUsuario'>Asignar Opciones</a></li>
    <li class='divider'></li>
    <li><a name='".$resUsuario["id"]."' id='btnEliminarRegistroUsuario'>Eliminar</a></li>
    <li class='divider'></li>";
    if ($resUsuario["vigente"]=="s"){
      $opciones.="<li><a name='".$resUsuario["id"]."' id='btnPermitirUsuario'>Deshabilitar</a></li>";
    }else if ($resUsuario["vigente"]=="n"){
      $opciones.="<li><a name='".$resUsuario["id"]."' id='btnPermitirUsuario'>Habilitar</a></li>";
    }

    $opciones.="</ul></div>";

    $data[]=array("userUsuarios"=>$resUsuario["usuario"],
      "nombreUsuarios"=>$resUsuario["nombre_usuario"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultaTablaAseguradora($nombreBuscarAseguradora,$identificacionBuscarAseguradora){
  global $con;
  $consultaAseguradora="SELECT * FROM aseguradoras";
  $cont = 0;

  if ($nombreBuscarAseguradora!=""){


    if ($cont == 0) {
      $consultaAseguradora.=" WHERE ";
    }
    else{
      $consultaAseguradora.=" AND ";

    }
    $cont++;
    $consultaAseguradora.=" nombre_aseguradora LIKE '%".$nombreBuscarAseguradora."%'";
  }

  if ($identificacionBuscarAseguradora!=""){

    if ($cont == 0) {
      $consultaAseguradora.=" WHERE ";
    }
    else{
      $consultaAseguradora.=" AND ";
    }
    $cont++;
    $consultaAseguradora.="identificacion = '".$identificacionBuscarAseguradora."'" ;
  }

  $queryAseguradora=mysqli_query($con,$consultaAseguradora);
  $regs="";
  $data=array();

  while ($resAseguradora=mysqli_fetch_array($queryAseguradora,MYSQLI_ASSOC)){
    $opciones="<div class='btn-group'>";
    if ($resAseguradora["vigente"]=="s"){
      $opciones.="<button type='button' class='btn btn-success' name='".$resAseguradora["id"]."' id=''>".$resAseguradora["id"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resAseguradora["id"]."'>";
    }else if ($resAseguradora["vigente"]=="n"){
      $opciones.="<button type='button' class='btn btn-danger' name='".$resAseguradora["id"]."' id='btnAccionesGestionUsuario'>".$resAseguradora["id"]."</button>
      <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resAseguradora["id"]."'>";
    }

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resAseguradora["id"]."' id='btnEditarAseguradora'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resAseguradora["id"]."' id='btnEliminarRegistroAseguradora'>Eliminar</a></li>
    <li class='divider'></li>";
    if ($resAseguradora["vigente"]=="s"){
      $opciones.="<li><a name='".$resAseguradora["id"]."' id='btnPermitirAseguradora'>Deshabilitar</a></li>";
    }else if ($resAseguradora["vigente"]=="n"){
      $opciones.="<li><a name='".$resAseguradora["id"]."' id='btnPermitirAseguradora'>Habilitar</a></li>";
    }
    $opciones.="<li class='divider'></li>
    <li><a name='".$resAseguradora["id"]."' id='btnParametrosAseguradora'>Parámetros</a></li>";

    $opciones.="</ul></div>";

    $data[]=array("nombreAseguradora"=>$resAseguradora["nombre_aseguradora"],
      "identificacionAseguradora"=>$resAseguradora["identificacion"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultarEventosUsuario($idUsuario){

  global $con;
  $consultarLogEventos="SELECT  a.fecha,a.direccion_acceso,b.descripcion FROM log_sesion a LEFT JOIN definicion_tipos b ON a.descripcion=b.id WHERE b.id_tipo=29 and a.id_usuario='".$idUsuario."' ORDER BY fecha DESC LIMIT 100";  
  $queryLogEventos=mysqli_query($con,$consultarLogEventos);
  $data=array();

  while ($resLogEvento=mysqli_fetch_array($queryLogEventos)){                                

    $data[]=array("HoraFechaEvento"=>$resLogEvento["fecha"],
      "DescripcionEvento"=>$resLogEvento["descripcion"],
      "DireccionAccesoEvento"=>$resLogEvento["direccion_acceso"]
    );  
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultaTablaClinica($nombreBuscarClinica,$identificacionClinica){
  global $con;
  $consultaClinica="SELECT a.id,a.vigente,a.nombre_ips,CONCAT(a.identificacion,'-',a.dig_ver) AS identificacion,CONCAT(b.nombre,'-',c.nombre) AS ciudad FROM ips a LEFT JOIN ciudades b ON a.ciudad=b.id LEFT JOIN departamentos c ON c.id=b.id_departamento";
  $cont = 0;

  if ($nombreBuscarClinica!=""){
    if ($cont == 0) {
      $consultaClinica.=" WHERE ";
    }
    else{
      $consultaClinica.=" AND ";

    }
    $cont++;
    $consultaClinica.=" a.nombre_ips LIKE '%".$nombreBuscarClinica."%'";
  }

  if ($identificacionClinica!=""){
    if ($cont == 0) {
      $consultaClinica.=" WHERE ";
    }
    else{
      $consultaClinica.=" AND ";
    }
    $cont++;
    $consultaClinica.="a.identificacion = '".$identificacionClinica."'" ;
  }

  $queryClinica=mysqli_query($con,$consultaClinica);
  $regs="";
  $data=array();

  while ($resClinica=mysqli_fetch_array($queryClinica,MYSQLI_ASSOC)){
    $opciones="<div class='btn-group'>";
    if ($resClinica["vigente"]=="s"){
      $opciones.="<button type='button' class='btn btn-success' name='".$resClinica["id"]."' id=''>".$resClinica["id"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resClinica["id"]."'>";
    }else if ($resClinica["vigente"]=="n"){
      $opciones.="<button type='button' class='btn btn-danger' name='".$resClinica["id"]."' id='btnAccionesGestionUsuario'>".$resClinica["id"]."</button>
      <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resClinica["id"]."'>";
    }

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>

    <li><a name='".$resClinica["id"]."' id='btnAsignarInvestigadoresClinica'>Asignar Investigadores</a></li>
    <li class='divider'></li>
    <li><a name='".$resClinica["id"]."' id='btnEditarClinica'>Editar</a></li>
    <li class='divider'></li>
    <li><a name='".$resClinica["id"]."' id='btnEliminarRegistroClinica'>Eliminar</a></li>
    <li class='divider'></li>";
    if ($resClinica["vigente"]=="s"){
      $opciones.="<li><a name='".$resClinica["id"]."' id='btnPermitirClinica'>Deshabilitar</a></li>";
    }else if ($resClinica["vigente"]=="n"){
      $opciones.="<li><a name='".$resClinica["id"]."' id='btnPermitirClinica'>Habilitar</a></li>";
    }

    $opciones.="</ul></div>";

    $data[]=array("nombreClinica"=>$resClinica["nombre_ips"],
      "identificacionClinica"=>$resClinica["identificacion"],
      "ciudadClinica"=>$resClinica["ciudad"],
      "opciones"=>$opciones);
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultarOpcionesUsuarios($userOpcionesUsuarios) {
  global $con;
  $regs="";
  $data=array();
  $consultaOpcionesModalesPadresUsuarios="SELECT * FROM opciones WHERE vigente='s' and tipo_opcion in (1,3,5) order by tipo_opcion,opcion_padre desc";
  $queryOpcionesModalesPadresUsuarios=mysqli_query($con,$consultaOpcionesModalesPadresUsuarios);

  while ($resOpcionesModalesPadresUsuarios=mysqli_fetch_array($queryOpcionesModalesPadresUsuarios,MYSQLI_ASSOC)){
    if ($resOpcionesModalesPadresUsuarios["tipo_opcion"]==3){
      $consultarOpcionAsignadaPadre="SELECT * FROM opciones_usuarios WHERE opcion='".$resOpcionesModalesPadresUsuarios["id"]."' and usuario='".$userOpcionesUsuarios."'";
      mysqli_next_result($con);
      $queryOpcionAsignadaPadre=mysqli_query($con,$consultarOpcionAsignadaPadre);

      if (mysqli_num_rows($queryOpcionAsignadaPadre)>0)
      {
        $selectedOpcion="<input type='checkbox' checked='true' name='checkSelectOpcion' value='".$resOpcionesModalesPadresUsuarios["id"]."'>";

      }else{
        $selectedOpcion="<input type='checkbox'  name='checkSelectOpcion' value='".$resOpcionesModalesPadresUsuarios["id"]."'>";
      }

      $data[]=array("seleccOpcion"=>$selectedOpcion,
        "codOpcion"=>$resOpcionesModalesPadresUsuarios["codigo"],
        "descOpcion"=>$resOpcionesModalesPadresUsuarios["descripcion"]); 
    }
    else if ($resOpcionesModalesPadresUsuarios["tipo_opcion"]==1){
      $consultaOpcionesHijosUsuarios="SELECT * FROM opciones WHERE vigente='s' and opcion_padre='".$resOpcionesModalesPadresUsuarios["codigo"]."' and tipo_opcion in (2,4) order by tipo_opcion desc";
      mysqli_next_result($con);
      $queryOpcionesHijosUsuarios=mysqli_query($con,$consultaOpcionesHijosUsuarios);

      if (mysqli_num_rows($queryOpcionesHijosUsuarios)>0){
        $consultarOpcionAsignadaPadre="SELECT * FROM opciones_usuarios WHERE opcion='".$resOpcionesModalesPadresUsuarios["id"]."' and usuario='".$userOpcionesUsuarios."'";
        mysqli_next_result($con);
        $queryOpcionAsignadaPadre=mysqli_query($con,$consultarOpcionAsignadaPadre);

        if (mysqli_num_rows($queryOpcionAsignadaPadre)>0){
          $selectedOpcion="<input type='checkbox' checked='true' name='checkSelectOpcion' value='".$resOpcionesModalesPadresUsuarios["id"]."'>";
        }else{
          $selectedOpcion="<input type='checkbox' name='checkSelectOpcion' value='".$resOpcionesModalesPadresUsuarios["id"]."'>";
        }

        $data[]=array("seleccOpcion"=>$selectedOpcion,
          "codOpcion"=>"-".$resOpcionesModalesPadresUsuarios["codigo"],
          "descOpcion"=>"-".$resOpcionesModalesPadresUsuarios["descripcion"]); 

        while ($resOpcionesHijosUsuarios=mysqli_fetch_array($queryOpcionesHijosUsuarios,MYSQLI_ASSOC)){ 
          $consultarOpcionAsignadaPadre="SELECT * FROM opciones_usuarios WHERE opcion='".$resOpcionesHijosUsuarios["id"]."' and usuario='".$userOpcionesUsuarios."'";
          mysqli_next_result($con);
          $queryOpcionAsignadaPadre=mysqli_query($con,$consultarOpcionAsignadaPadre);

          if (mysqli_num_rows($queryOpcionAsignadaPadre)>0)
          {
            $selectedOpcion="<input type='checkbox' checked='true' name='checkSelectOpcion' value='".$resOpcionesHijosUsuarios["id"]."'>";

          }else{
            $selectedOpcion="<input type='checkbox'  name='checkSelectOpcion' value='".$resOpcionesHijosUsuarios["id"]."'>";
          }

          $data[]=array("seleccOpcion"=>$selectedOpcion,
            "codOpcion"=>"---".$resOpcionesHijosUsuarios["codigo"],
            "descOpcion"=>"---".$resOpcionesHijosUsuarios["descripcion"]); 
        }
      }
    }else if ($resOpcionesModalesPadresUsuarios["tipo_opcion"]==5) {

      $consultarOpcionAsignadaPadre="SELECT * FROM opciones_usuarios WHERE opcion='".$resOpcionesModalesPadresUsuarios["id"]."' and usuario='".$userOpcionesUsuarios."'";
      mysqli_next_result($con);
      $queryOpcionAsignadaPadre=mysqli_query($con,$consultarOpcionAsignadaPadre);
      if (mysqli_num_rows($queryOpcionAsignadaPadre)>0)
      {
        $selectedOpcion="<input type='checkbox' checked='true' name='checkSelectOpcion' value='".$resOpcionesModalesPadresUsuarios["id"]."'>";

      }else{
        $selectedOpcion="<input type='checkbox'  name='checkSelectOpcion' value='".$resOpcionesModalesPadresUsuarios["id"]."'>";
      }

      $data[]=array("seleccOpcion"=>$selectedOpcion,
        "codOpcion"=>"----".$resOpcionesModalesPadresUsuarios["codigo"],
        "descOpcion"=>"----".$resOpcionesModalesPadresUsuarios["descripcion"]); 
    }
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultarClinicasAseguradoras($idAsignacionAseguradora){
  global $con;
  $regs="";
  $data=array();

  $consultarClinicas = "SELECT a.id,a.vigente,a.nombre_ips,CONCAT(a.identificacion,'-',a.dig_ver) AS identificacion,CONCAT(b.nombre,'-',c.nombre) AS ciudad FROM ips a LEFT JOIN ciudades b ON a.ciudad=b.id LEFT JOIN departamentos c ON c.id=b.id_departamento";
  $queryConsultarClinicas=mysqli_query($con,$consultarClinicas);

  while ($resConsultarClinicas=mysqli_fetch_array($queryConsultarClinicas,MYSQLI_ASSOC)){
    $consultarAseguradoraClinica = "SELECT * FROM aseguradora_ips WHERE id_aseguradora = '".$idAsignacionAseguradora."' and id_ips = '".$resConsultarClinicas["id"]."'";
    mysqli_next_result($con);
    $queryAseguradoraClinica=mysqli_query($con,$consultarAseguradoraClinica);

    if (mysqli_num_rows($queryAseguradoraClinica)>0)
    {
      $selectedOpcion="<input type='checkbox' checked='true' name='checkSelectOpcion' value='".$resConsultarClinicas["id"]."'>";

    }else{
      $selectedOpcion="<input type='checkbox'  name='checkSelectOpcion' value='".$resConsultarClinicas["id"]."'>";
    }

    $data[]=array("seleccClinica"=>$selectedOpcion,
      "nomClinica"=>$resConsultarClinicas["nombre_ips"],
      "nitClinica"=>$resConsultarClinicas["identificacion"],
      "ciudadClinica"=>$resConsultarClinicas["ciudad"]); 
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function consultarRangoValorTarifaAmparo($idAsegAmparo,$idCiudad){
  global $con;
  $regs="";
  $data=array();

  $consultaRangoValorTarifaAmparo = "SELECT * FROM tarifa_amparo_aseguradora WHERE id_aseg_amparo='".$idAsegAmparo."' AND id_aseg_clinica_ciudad='".$idCiudad."'";
  $queryRangoValorTarifaAmparo=mysqli_query($con,$consultaRangoValorTarifaAmparo);

  while ($resRangoValorTarifaAmparo=mysqli_fetch_array($queryRangoValorTarifaAmparo,MYSQLI_ASSOC)){

    $data[]=array("rangoDesdeValorTarifa"=>$resRangoValorTarifaAmparo["rango_desde"],
      "rangoHastaValorTarifa"=>$resRangoValorTarifaAmparo["rango_hasta"],
      "costoValorTarifa"=>'$'.number_format($resRangoValorTarifaAmparo["valor_caso"],2),
      "opciones"=>"<a class='btn btn-success' name='".$resRangoValorTarifaAmparo["id"]."' id='btnEliminarRangoValorTarifaAmparo'>REMOVER</a>"); 
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function consultarClinicaCiudadesAseguradoras($idRegistroAseguradoraClinicaCiudad){
  global $con;
  $regs="";
  $data=array();

  $consultaClinicaCiudadesAseguradoras = "SELECT d.nombre_ips,CONCAT(c.nombre,'-',e.nombre) as nombre_ciudad,b.id,b.id_ciudad FROM aseguradora_amparo a RIGHT JOIN aseguradora_clinica_ciudad b ON a.id=b.id_aseg_amparo LEFT JOIN ciudades c on c.id=b.id_ciudad LEFT JOIN ips d on d.id=b.id_clinica LEFT JOIN departamentos e on e.id=c.id_departamento WHERE a.id='".$idRegistroAseguradoraClinicaCiudad."'";
  $queryClinicaCiudadesAseguradoras=mysqli_query($con,$consultaClinicaCiudadesAseguradoras);

  while ($resClinicaCiudadesAseguradoras=mysqli_fetch_array($queryClinicaCiudadesAseguradoras,MYSQLI_ASSOC)){

    $opciones="<div class='btn-group'>";

    $opciones.="<button type='button' class='btn btn-success' name='".$resClinicaCiudadesAseguradoras["id"]."'>".$resClinicaCiudadesAseguradoras["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resClinicaCiudadesAseguradoras["id"]."'>";

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resClinicaCiudadesAseguradoras["id_ciudad"]."' id='btnAsignarTarifasClinicaCiudadesTarAmp'>Asignar Rango - Valores</a></li>

    <li class='divider'></li>
    <li><a name='".$resClinicaCiudadesAseguradoras["id"]."' id='btnEliminarClinicaCiudadesTarAmp'>Eliminar</a></li></ul></div>";

    $data[]=array("nomCiudad"=>$resClinicaCiudadesAseguradoras["nombre_ciudad"],
      "nomClinica"=>$resClinicaCiudadesAseguradoras["nombre_ips"],
      "opciones"=>$opciones); 
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function consultarAmparosAseguradoras($idAsignacionAmparo){
  global $con;
  $regs="";
  $data=array();

  $consultarAmparosAseguradora = "SELECT b.id as tipo_facturacion_id,c.descripcion as amparo,b.descripcion as tipo_facturacion,a.id FROM aseguradora_amparo a LEFT JOIN definicion_tipos b ON a.id_tipo_facturacion=b.id LEFT JOIN definicion_tipos c ON c.id=a.id_amparo WHERE a.id_aseguradora='".$idAsignacionAmparo."' AND b.id_tipo=9 and c.id_tipo=8";
  $queryAmparosAseguradora=mysqli_query($con,$consultarAmparosAseguradora);

  while ($resAmparosAseguradora=mysqli_fetch_array($queryAmparosAseguradora,MYSQLI_ASSOC)){

    $opciones="<div class='btn-group'>";
    $opciones.="<button type='button' class='btn btn-success' name='".$resAmparosAseguradora["id"]."'>".$resAmparosAseguradora["id"]."</button>
    <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resAmparosAseguradora["id"]."'>";

    $opciones.="<span class='caret'></span>
    <span class='sr-only'>Toggle Dropdown</span>
    </button>
    <ul class='dropdown-menu' role='menu'>
    <li><a name='".$resAmparosAseguradora["id"]."' id='btnAsignarTarifasAmparo'>Asignar Tarifas</a></li>

    <li class='divider'></li>
    <li><a name='".$resAmparosAseguradora["id"]."' id='btnEliminarAmparoAseguradora'>Eliminar</a></li></ul></div>";          

    $data[]=array("amparoAseguradora"=>$resAmparosAseguradora["amparo"],
      "metodFacturacion"=>$resAmparosAseguradora["tipo_facturacion"],
      "opcionesAmparo"=>$opciones); 
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results);
}

function consultarIndicadorAseguradoras($idAsignacionIndicador){
  global $con;
  $regs="";
  $data=array();

  $consultarIndicadorAseguradora = "SELECT  a.id,a.codigo_aseguradora,b.descripcion AS indicador,a.id_resultado AS resultado
  FROM indicador_aseguradora a 
  LEFT JOIN definicion_tipos b ON a.id_indicador=b.id 
  LEFT JOIN aseguradoras c ON a.id_aseguradora=c.id 
  WHERE  b.id_tipo=12 AND c.id='".$idAsignacionIndicador."'";
  $queryIndicadorAseguradora=mysqli_query($con,$consultarIndicadorAseguradora);

  while ($resIndicadorAseguradora=mysqli_fetch_array($queryIndicadorAseguradora,MYSQLI_ASSOC)){
    if ($resIndicadorAseguradora["resultado"]==1){
      $consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_atender=b.id where b.id_tipo=10 and a.id='".$idAsignacionIndicador."'";
    }
    else if ($resIndicadorAseguradora["resultado"]==2){
      $consultarResultado="SELECT b.descripcion2 as resultado from aseguradoras a left join definicion_tipos b on a.resultado_no_atender=b.id where b.id_tipo=10 and a.id='".$idAsignacionIndicador."'";
    }

    mysqli_next_result($con);
    $queryResultado=mysqli_query($con,$consultarResultado);
    $resResultado=mysqli_fetch_assoc($queryResultado);

    $data[]=array("resultadoAseguradora"=>$resResultado["resultado"],
      "descripcionIndicador"=>$resIndicadorAseguradora["indicador"],
      "codigoIndicador"=>$resIndicadorAseguradora["codigo_aseguradora"],
      "opcionesIndicador"=>"<a class='btn btn-success' name='".$resIndicadorAseguradora["id"]."' id='btnEliminarIndicador'>REMOVER</a>"); 
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results);
}

function consultarIndicativoCasosSOAT($idCaso){
  global $con;
  $consultarIndicativosCasosSOAT="SELECT * FROM id_casos_aseguradora WHERE id_investigacion='".$idCaso."'";
  $data=array();
  $queryIndicativosCasosSOAT=mysqli_query($con,$consultarIndicativosCasosSOAT);
  while ($resIndicativosCasosSOAT=mysqli_fetch_array($queryIndicativosCasosSOAT,MYSQLI_ASSOC)){
    $data[]=array("indicativoCasosSOAT"=>$resIndicativosCasosSOAT["identificador"],
      "fechaInicioCasosSOAT"=>$resIndicativosCasosSOAT["fecha_inicio"],
      "fechaEntregaCasosSOAT"=>$resIndicativosCasosSOAT["fecha_entrega"],
      "opcionesIndicativoCasosSOAT"=>"<a class='btn btn-success' name='".$resIndicativosCasosSOAT["id"]."' id='btnEliminarIndicador'>REMOVER</a>"); 
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function consultarCasosSOAT($codigoFrmBuscarSOAT,$nombresFrmBuscarSOAT,$apellidosFrmBuscarSOAT,$identificacionFrmBuscarSOAT,$placaFrmBuscarSOAT,$polizaFrmBuscarSOAT,$identificadorFrmBuscarSOAT,$tipoConsultaBuscar,$fechaAccidenteFrmBuscarSOAT,$fechaDigitacionFrmBuscarSOAT,$aseguradoraFrmBuscarSOAT,$usuario){

  global $con;
  $consultarTipoUsuario=mysqli_query($con,"SELECT * FROM usuarios WHERE id='".$usuario."'");
  $resTipoUsuario=mysqli_fetch_array($consultarTipoUsuario,MYSQLI_ASSOC);
  mysqli_next_result($con);
  $regs="";
  $data=array();

  if ($tipoConsultaBuscar=="buscarCasosFiltros"){
    $consultarFiltrosSOAT="SELECT distinct a.id,a.tipo_caso,a.id_usuario
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
    LEFT JOIN personas_investigaciones_soat c ON c.id_investigacion=a.id
    LEFT JOIN personas d ON d.id=c.id_persona
    LEFT JOIN polizas g ON g.id=b.id_poliza
    LEFT JOIN vehiculos f ON f.id=g.id_vehiculo
    LEFT JOIN id_casos_aseguradora h ON h.id_investigacion=a.id ";
    $cont=0;

    if ($resTipoUsuario["tipo_usuario"]==4){
      if ($cont==0){
        $consultarFiltrosSOAT.=" WHERE ";
      }else{
        $consultarFiltrosSOAT.=" AND ";
      }
      $consultarFiltrosSOAT.=" a.id_aseguradora='".$resTipoUsuario["id_aseguradora"]."' AND a.estado = 1";
      $cont++;
    }

    if ($codigoFrmBuscarSOAT!=""){
      if ($cont==0){
        $consultarFiltrosSOAT.=" WHERE ";
      }else{
        $consultarFiltrosSOAT.=" AND ";
      }
      $consultarFiltrosSOAT.=" a.codigo='".$codigoFrmBuscarSOAT."'";
      $cont++;
    }
    else {
      if ($fechaAccidenteFrmBuscarSOAT!=""){

        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" DATE_FORMAT(b.fecha_accidente, '%Y-%m-%d')='".$fechaAccidenteFrmBuscarSOAT."'";
        $cont++;
      }
      else  if ($fechaDigitacionFrmBuscarSOAT!=""){

        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" DATE_FORMAT(a.fecha, '%Y-%m-%d')='".$fechaDigitacionFrmBuscarSOAT."'";
        $cont++;
      }
      else if ($nombresFrmBuscarSOAT!=""){

        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" d.nombres like '%".$nombresFrmBuscarSOAT."%'";
        $cont++;
      }else if ($apellidosFrmBuscarSOAT!=""){
        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" d.apellidos LIKE '%".$apellidosFrmBuscarSOAT."%'";
        $cont++;
      }else if ($identificacionFrmBuscarSOAT!=""){
        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" d.identificacion LIKE '%".$identificacionFrmBuscarSOAT."%'";
        $cont++;
      }else if ($placaFrmBuscarSOAT!=""){
        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" f.placa LIKE '%".$placaFrmBuscarSOAT."%'";            
        $cont++;
      }else if ($polizaFrmBuscarSOAT!=""){
        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" g.numero like '%".$polizaFrmBuscarSOAT."%'";            
        $cont++;
      }else if ($identificadorFrmBuscarSOAT!=""){
        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" h.identificador='".$identificadorFrmBuscarSOAT."'";            
        $cont++;
      }else if ($aseguradoraFrmBuscarSOAT!=""){
        if ($cont==0){
          $consultarFiltrosSOAT.=" WHERE ";
        }else{
          $consultarFiltrosSOAT.=" AND ";
        }
        $consultarFiltrosSOAT.=" a.id_aseguradora='".$aseguradoraFrmBuscarSOAT."'";            
        $cont++;
      }

    }
  }
  else if ($tipoConsultaBuscar=="buscarCasoSinInformeSOAT"){
    $consultarFiltrosSOAT="SELECT a.id,a.tipo_caso,b.ruta,b.id_multimedia
    FROM investigaciones a
    LEFT JOIN multimedia_investigacion b ON a.id=b.id_investigacion
    WHERE b.id_multimedia=9 AND b.vigente='c' and a.id_usuario='".$usuario."'";
  }
  else if ($tipoConsultaBuscar=="buscarCasoAsignadosSOAT"){
    $consultarFiltrosSOAT="SELECT a.id,a.tipo_caso
    FROM investigaciones a
    LEFT JOIN estado_investigaciones b ON a.id=b.id_investigacion
    WHERE b.estado=18 AND b.vigente='s' and a.id_usuario='".$usuario."'";
  }
  else if ($tipoConsultaBuscar=="buscarCasoAsignadosAseguradoraSOAT"){
    $consultarFiltrosSOAT="SELECT a.id,a.tipo_caso
    FROM investigaciones a
    LEFT JOIN estado_investigaciones b ON a.id=b.id_investigacion
    WHERE b.estado in (1,12) AND b.vigente='s'";
  }
  mysqli_next_result($con);

  $queryCasosFiltrosSOAT=mysqli_query($con,$consultarFiltrosSOAT);
  $GMTrans = array("1","2","3","4","5","6","13","14","15","16","17");
  $MuerteIncapacidad = array("7","8","9","10");

  while ($resCasosFiltrosSOAT=mysqli_fetch_array($queryCasosFiltrosSOAT,MYSQLI_ASSOC)) {
    $consultarInformacionBasica="SELECT a.tipo_caso as id_tipo_caso,e.descripcion as tipo_caso,g.nombre_aseguradora as aseguradora,a.codigo,a.id,
    CASE 
    WHEN i.placa IS NULL THEN 'NO REGISTRA'
    ELSE i.placa END AS placa_vehiculo,
    CASE 
    WHEN CONCAT(f.nombres,' ',f.apellidos) IS NULL THEN 'NO REGISTRA'
    ELSE CONCAT(f.nombres,' ',f.apellidos) END AS nombre_investigador,
    CASE 
    WHEN j.numero IS NULL THEN 'NO REGISTRA'
    ELSE j.numero END AS poliza,
    CONCAT(d.nombres,' ',d.apellidos) as nombre_usuario,
    CASE 
    WHEN  b.fecha_accidente IS NULL THEN 'NO REGISTRA'
    ELSE  b.fecha_accidente END AS fecha_accidente
    ,c.descripcion AS tipo_solicitud,c.id AS id_tipo_solicitud,a.id_usuario,
    l.id AS id_cuenta_cobro,
    CONCAT(
     CASE 
      WHEN MONTH(l.periodo) = 1 THEN 'ENERO' 
       WHEN MONTH(l.periodo) = 2 THEN 'FEBRERO' 
       WHEN MONTH(l.periodo) = 3 THEN 'MARZO' 
       WHEN MONTH(l.periodo) = 4 THEN 'ABRIL' 
       WHEN MONTH(l.periodo) = 5 THEN 'MAYO' 
       WHEN MONTH(l.periodo) = 6 THEN 'JUNIO' 
       WHEN MONTH(l.periodo) = 7 THEN 'JULIO' 
       WHEN MONTH(l.periodo) = 8 THEN 'AGOSTO' 
       WHEN MONTH(l.periodo) = 9 THEN 'SEPTIEMBRE' 
       WHEN MONTH(l.periodo) = 10 THEN 'OCTUBRE'
       WHEN MONTH(l.periodo) = 11 THEN 'NOVIEMBRE' 
       WHEN MONTH(l.periodo) = 12 THEN 'DICIEMBRE' 
    END,' ',l.numero,' DE ',YEAR(l.periodo)) AS periodo
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_soat b ON a.id=b.id_investigacion
    LEFT JOIN definicion_tipos c ON c.id=a.tipo_solicitud
    LEFT JOIN usuarios d ON d.id=a.id_usuario
    LEFT JOIN definicion_tipos e ON e.id=a.tipo_caso
    LEFT JOIN investigadores f ON f.id=a.id_investigador
    LEFT JOIN aseguradoras g ON g.id=a.id_aseguradora
    LEFT JOIN polizas j ON j.id=b.id_poliza
    LEFT JOIN vehiculos i ON i.id=j.id_vehiculo
    LEFT JOIN investigaciones_cuenta_investigador k ON k.id_investigacion = i.id
    LEFT JOIN cuenta_cobro_investigador l ON l.id = k.id_cuenta_cobro
    where c.id_tipo=14 and e.id_tipo=8 and a.id='".$resCasosFiltrosSOAT["id"]."'";
    mysqli_next_result($con);
    $queryInformacionBasica=mysqli_query($con,$consultarInformacionBasica);
    $resInformacionBasica=mysqli_fetch_array($queryInformacionBasica,MYSQLI_ASSOC);
    mysqli_next_result($con);

    if ($tipoConsultaBuscar!="buscarCasoSinInformeSOAT"){
      $consultarInforme=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$resInformacionBasica["id"]."' and id_multimedia=9 and vigente<>'c'");
      $resInforme=mysqli_fetch_array($consultarInforme,MYSQLI_ASSOC);
      $cantidadInformes=mysqli_num_rows($consultarInforme);
      mysqli_next_result($con);

      $consultarAudio=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$resInformacionBasica["id"]."' and id_multimedia=15");
      $resAudio=mysqli_fetch_array($consultarAudio,MYSQLI_ASSOC);
      $cantidadAudio=mysqli_num_rows($consultarAudio);
      mysqli_next_result($con);
    }else{
      $cantidadInformes = 0;
      $cantidadAudio = 0;
    }

    $consultarTipoCaso=mysqli_query($con,"SELECT descripcion as tipo_caso FROM definicion_tipos WHERE descripcion2='".$resInformacionBasica["id_tipo_caso"]."' and id_tipo=13");
    $resTipoCaso=mysqli_fetch_array($consultarTipoCaso,MYSQLI_ASSOC);

    if (in_array($resCasosFiltrosSOAT["tipo_caso"], $GMTrans)){

      $consultarInformacionPersonas="SELECT a.id_investigacion,CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion,' ',b.identificacion) as identificacion_lesionado,d.nombre_ips AS nombre_reclamante, CASE a.resultado WHEN 1 THEN 'ATENDER' WHEN 2 THEN 'NO ATENDER' ELSE 'NO APLICA' END resultado 
      FROM personas_investigaciones_soat a
      LEFT JOIN personas b ON b.id=a.id_persona
      LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
      LEFT JOIN ips d ON d.id=a.ips
      WHERE c.id_tipo=5 AND a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";
      mysqli_next_result($con);
      $queryInformacionPersonas=mysqli_query($con,$consultarInformacionPersonas);
      $informacionGeneral="";
      $opciones="";
      $opciones.="<div class='btn-group'>";
      $opciones.="<button type='button' class='btn btn-success' name='".$resInformacionBasica["id"]."'>";

      if ($cantidadInformes>0){
        $opciones.="<span class='fa fa-file-pdf-o'></span>";
      }

      $opciones.=$resInformacionBasica["codigo"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInformacionBasica["id"]."'>";
      $opciones.="<span class='caret'></span>
      <span class='sr-only'>Toggle Dropdown</span>
      </button>
      <ul class='dropdown-menu' role='menu'>";

      if ($cantidadInformes>0){
        global $rutaArchivos;
        $opciones.="<li><a target='_blank' href='".$rutaArchivos."informes/".$resInforme["ruta"].'?'.time()."'>Ver Informe</a></li><li class='divider'></li>";  
      }

      if ($cantidadAudio>0){
        $opciones.="<li><a id='btnDescargarAudioCasoSoat'  href='bd/forzarDescargaArchivos.php?id_caso=".$resInformacionBasica["id"]."'>Descargar Audio</a></li><li class='divider'></li>";  
      }


      if ($resTipoUsuario["tipo_usuario"]==1){

        if ($resInformacionBasica["id_usuario"]==$usuario){
          $opciones.="
          <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
          <li class='divider'></li>
          <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
          <li class='divider'></li>
          <li><a name='".$resInformacionBasica["id"]."' id='btnCrearAmpliacionCasoSoat'>Crear Ampliacion</a></li>";
        }
      }
      else  if ($resTipoUsuario["tipo_usuario"]==2){
        mysqli_next_result($con);
        $consultarAutorizacion=mysqli_query($con,"SELECT id, CASE
          WHEN autorizacion is null then 'NR'
          ELSE autorizacion end as autorizacion,id,usuario_permiso,fecha_permiso FROM autorizacion_investigacion where id_investigacion='".$resInformacionBasica["id"]."'");
        $resAutorizacion=mysqli_fetch_array($consultarAutorizacion);

        if (mysqli_num_rows($consultarAutorizacion)>0 && $resAutorizacion["autorizacion"]=="NR"){
          $opciones.="<li><a name='".$resInformacionBasica["id"]."' id='btnAutorizarInvestigacionSOAT'>Autorizar Investigacion</a></li>
          <li class='divider'></li>";
        }
        $opciones.="
        <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnCrearAmpliacionCasoSoat'>Crear Ampliacion</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnCambiarEstado'>Cambio de Estado</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnActualizarCargueCasoSoat'>Actualizar Cargue</a></li>";
      }else if ($resTipoUsuario["tipo_usuario"]==3){

        mysqli_next_result($con);
        $consultarAutorizacion=mysqli_query($con,"SELECT id, CASE
          WHEN autorizacion is null then 'NR'
          ELSE autorizacion end as autorizacion,id,usuario_permiso,fecha_permiso FROM autorizacion_investigacion where id_investigacion='".$resInformacionBasica["id"]."'");
        $resAutorizacion=mysqli_fetch_array($consultarAutorizacion);

        if (mysqli_num_rows($consultarAutorizacion)>0 && $resAutorizacion["autorizacion"]=="NR"){
          $opciones.="<li><a name='".$resInformacionBasica["id"]."' id='btnAutorizarInvestigacionSOAT'>Autorizar Investigacion</a></li>
          <li class='divider'></li>";
        }
        $opciones.="
        <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnCrearAmpliacionCasoSoat'>Crear Ampliacion</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnCambiarEstado'>Cambio de Estado</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnActualizarCargueCasoSoat'>Actualizar Cargue</a></li>";
      }
      else if ($resTipoUsuario["tipo_usuario"]==4){

        if ($resInformacionBasica["id_usuario"]==$usuario && $resTipoCaso["tipo_caso"]=="2"){
          $opciones.="<li class='divider'></li>
          <li><a name='".$resInformacionBasica["id"]."' id='btnEditarAsignacionCasoSOAT'>Editar</a></li>";
        }
      }

      if($usuario==15 || $usuario==77 || $usuario==530){
        $opciones.="<li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnEliminarCasoSoat'>Eliminar</a></li></ul></div>";
      }

      $opciones.="</ul></div>";

      if ($resTipoUsuario["tipo_usuario"]<>4){
        $informacionGeneral.="<b>Usuario: </b>".$resInformacionBasica["nombre_usuario"]."<br>";
      }

      $informacionGeneral.="<b>Aseguradora: </b>".$resInformacionBasica["aseguradora"]."<br><b>Tipo de Caso: </b>".$resInformacionBasica["tipo_caso"];

      if ($_SESSION["id"] != 13){
        if ($resInformacionBasica["id_tipo_solicitud"] == 2){
          $informacionGeneral.="<br><p style='color: #e07100;'><b>Tipo de Solicitud: </b>".$resInformacionBasica["tipo_solicitud"]."</p>";
        }else{
          $informacionGeneral.="<br><b>Tipo de Solicitud: </b>".$resInformacionBasica["tipo_solicitud"];
        }

      }else{
        $conInvCuentas = mysqli_query($con, "SELECT id_cuenta_cobro from investigaciones_cuenta_investigador where id_investigacion =".$resInformacionBasica["id"]);
        if(mysqli_num_rows($conInvCuentas)>0){
          $resInfoCuentas=mysqli_fetch_array($conInvCuentas,MYSQLI_ASSOC);
          $informacionGeneral .= "<br><b>Cuentas: Inv: </b>".$resInfoCuentas["id_cuenta_cobro"];
        }
      }

      if ($resTipoUsuario["tipo_usuario"]==4){
        mysqli_next_result($con);
        $consultarCasoAsignado=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=13 and descripcion=2 and descripcion2='".$resCasosFiltrosSOAT["tipo_caso"]."'");

        if ($cantidadInformes>0 || mysqli_num_rows($consultarCasoAsignado)>0){

          if (mysqli_num_rows($queryInformacionPersonas)==0){

            $textoSegundoTD = "<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA";

            if($resTipoUsuario["tipo_usuario"] == 2){
              $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
            }

            $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

            if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
              $textoTerceroTD .= "<br><b>Resultado: </b>NO APLICA";
            }

            $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
              "VictimaCasosSoat"=>$textoSegundoTD,
              "SiniestroCasosSoat"=>$textoTerceroTD,
              "opciones"=>$opciones,
              "idInvestigacion"=>$resInformacionBasica["id"]
            ); 
          }
          else{

            while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC)){

              $textoSegundoTD = "<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$resInformacionPersona["nombre_reclamante"];

              if($resTipoUsuario["tipo_usuario"] == 2){
                $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
              }

              $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

              if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
                $textoTerceroTD .= "<br><b>Resultado: </b>".$resInformacionPersona["resultado"];
              }

              $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                "VictimaCasosSoat"=>$textoSegundoTD,
                "SiniestroCasosSoat"=>$textoTerceroTD,
                "opciones"=>$opciones,
                "idInvestigacion"=>$resInformacionBasica["id"]); 
            }
          }
        }
      }
      else{

        if (mysqli_num_rows($queryInformacionPersonas)==0){

          $textoSegundoTD = "<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA";

          if($resTipoUsuario["tipo_usuario"] == 2){
            $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
          }

          $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

          if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
            $textoTerceroTD .= "<br><b>Resultado: </b>NO APLICA";
          }

          $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
            "VictimaCasosSoat"=> $textoSegundoTD,
            "SiniestroCasosSoat"=>$textoTerceroTD,
            "opciones"=>$opciones,
            "idInvestigacion"=>$resInformacionBasica["id"]); 
        }
        else{
          while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC)){

            $textoSegundoTD = "<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$resInformacionPersona["nombre_reclamante"];

            if($resTipoUsuario["tipo_usuario"] == 2 || $_SESSION["id"] == 13){
              $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
            }

            if($_SESSION['id'] == 13){
              $textoSegundoTD .= "<br><b title='".$resInformacionBasica['periodo']."'>Cuenta: ".$resInformacionBasica["id_cuenta_cobro"]."</b>";
            }

            $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

            if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
              $textoTerceroTD .= "<br><b>Resultado: </b>".$resInformacionPersona["resultado"];
            }

            $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
              "VictimaCasosSoat"=>$textoSegundoTD,
              "SiniestroCasosSoat"=>$textoTerceroTD,
              "opciones"=>$opciones,
              "idInvestigacion"=>$resInformacionBasica["id"]); 
          }
        }
      } 
    }
    else if (in_array($resCasosFiltrosSOAT["tipo_caso"], $MuerteIncapacidad)){

      $consultarInformacionPersonas="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion,' ',b.identificacion) as identificacion_lesionado, CASE a.resultado WHEN 1 THEN 'ATENDER' WHEN 2 THEN 'NO ATENDER' ELSE 'NO APLICA' END resultado 
      FROM personas_investigaciones_soat a
      left join personas b on b.id=a.id_persona
      left join definicion_tipos c on c.id=b.tipo_identificacion
      where a.tipo_persona=1 and c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";

      mysqli_next_result($con);
      $queryInformacionPersonas=mysqli_query($con,$consultarInformacionPersonas);
      $informacionGeneral="";
      $opciones="";
      $opciones.="<div class='btn-group'>";
      $opciones.="<button type='button' class='btn btn-success' name='".$resInformacionBasica["id"]."'>";
      if ($cantidadInformes>0){
        $opciones.="<span class='fa fa-file-pdf-o'></span>";
      }

      $opciones.=$resInformacionBasica["codigo"]."</button>
      <button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='true' name='".$resInformacionBasica["id"]."'>";

      $opciones.="<span class='caret'></span>
      <span class='sr-only'>Toggle Dropdown</span>
      </button>
      <ul class='dropdown-menu' role='menu'>";

      if ($cantidadInformes>0){
        global $rutaArchivos;
        $opciones.="<li><a target='_blank' href='".$rutaArchivos."informes/".$resInforme["ruta"].'?'.time()."'>Ver Informe</a></li><li class='divider'></li>";
      }
      if ($resTipoUsuario["tipo_usuario"]==1){

        if ($resInformacionBasica["id_usuario"]==$usuario){
          $opciones.="
          <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
          <li class='divider'></li>
          <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
          <li class='divider'></li>
          ";
        }
      }
      else  if ($resTipoUsuario["tipo_usuario"]==2){
        $opciones.="
        <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnCambiarEstado'>Cambio de Estado</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnActualizarCargueCasoSoat'>Actualizar Cargue</a></li>
        ";
      }
      else  if ($resTipoUsuario["tipo_usuario"]==3){       
        $opciones.="
        <li><a name='".$resInformacionBasica["id"]."' id='btnEditarCasoSoat'>Editar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnGestionarCasoSoat'>Gestionar</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnCambiarEstado'>Cambio de Estado</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnActualizarCargueCasoSoat'>Actualizar Cargue</a></li>
        <li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnAsignarAnalistaCasoSoat'>Asignar Analista</a></li>";
      }
      else  if ($resTipoUsuario["tipo_usuario"]==4){

        if ($resInformacionBasica["id_usuario"]==$usuario && $resTipoCaso["tipo_caso"]=="2"){
          $opciones.="<li class='divider'></li>
          <li><a name='".$resInformacionBasica["id"]."' id='btnEditarAsignacionCasoSOAT'>Editar</a></li>";
        } 
      }

      if($usuario==15 || $usuario==77 || $usuario==530){
        $opciones.="<li class='divider'></li>
        <li><a name='".$resInformacionBasica["id"]."' id='btnEliminarCasoSoat'>Eliminar</a></li></ul></div>";
      }

      $opciones .= "</ul></div>";

      if ($resTipoUsuario["tipo_usuario"]<>4){
        $informacionGeneral.="<b>Usuario: </b>".$resInformacionBasica["nombre_usuario"]."<br>";
      }  

      $informacionGeneral.="<b>Aseguradora: </b>".$resInformacionBasica["aseguradora"]."<br><b>Tipo de Caso: </b>".$resInformacionBasica["tipo_caso"]."<br><b>Tipo de Solicitud: </b>".$resInformacionBasica["tipo_solicitud"];  

      if ($resTipoUsuario["tipo_usuario"]==4){
        mysqli_next_result($con);
        $consultarCasoAsignado=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=13 and descripcion=2 and descripcion2='".$resCasosFiltrosSOAT["tipo_caso"]."'");

        if ($cantidadInformes>0 || mysqli_num_rows($consultarCasoAsignado)>0){

          if (mysqli_num_rows($queryInformacionPersonas)==0){

            $textoSegundoTD = "<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA";

            if($resTipoUsuario["tipo_usuario"] == 2){
              $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
            }

            $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

            if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
              $textoTerceroTD .= "<br><b>Resultado: </b>NO APLICA";
            }

            $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
              "VictimaCasosSoat"=> $textoSegundoTD,
              "SiniestroCasosSoat"=>$textoTerceroTD,
              "opciones"=>$opciones,
              "idInvestigacion"=>$resInformacionBasica["id"]); 
          }
          else{
            $consultarReclamante="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion2,' ',b.identificacion) as identificacion_lesionado
            FROM personas_investigaciones_soat a
            left join personas b on b.id=a.id_persona
            left join definicion_tipos c on c.id=b.tipo_identificacion
            where a.tipo_persona=3 and c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";

            mysqli_next_result($con);
            $queryReclamante=mysqli_query($con,$consultarReclamante);
            if (mysqli_num_rows($queryReclamante)==0){
              $nombreReclamante="NO REGISTRA";
            }else{
              $resReclamante=mysqli_fetch_array($queryReclamante,MYSQLI_ASSOC);  
              $nombreReclamante=$resReclamante["nombre_lesionado"];
            }

            while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC)){

              $textoSegundoTD = "<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$nombreReclamante;

              if($resTipoUsuario["tipo_usuario"] == 2){
                $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
              }

              $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

              if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
                $textoTerceroTD .= "<br><b>Resultado: </b>".$resInformacionPersona["resultado"];
              }

              $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
                "VictimaCasosSoat"=>$textoSegundoTD,
                "SiniestroCasosSoat"=>$textoTerceroTD,
                "opciones"=>$opciones,
                "idInvestigacion"=>$resInformacionBasica["id"]); 
            }
          }
        }
      }
      else{

        if (mysqli_num_rows($queryInformacionPersonas)==0){

          $textoSegundoTD = "<b>Nombre: </b>NO REGISTRA<br>"."<b>Identificacion: </b>NO REGISTRA<br><b>Reclamante: </b>NO REGISTRA";

          if($resTipoUsuario["tipo_usuario"] == 2){
            $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
          }

          $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

          if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
            $textoTerceroTD .= "<br><b>Resultado: </b>NO APLICA";
          }

          $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
            "VictimaCasosSoat"=>$textoSegundoTD,
            "SiniestroCasosSoat"=>$textoTerceroTD,
            "opciones"=>$opciones,
            "idInvestigacion"=>$resInformacionBasica["id"]); 
        }
        else{

          $consultarReclamante="SELECT CONCAT(b.nombres,' ',b.apellidos) as nombre_lesionado,concat(c.descripcion2,' ',b.identificacion) as identificacion_lesionado
          FROM personas_investigaciones_soat a
          left join personas b on b.id=a.id_persona
          left join definicion_tipos c on c.id=b.tipo_identificacion
          where a.tipo_persona=3 and c.id_tipo=5 and a.id_investigacion='".$resCasosFiltrosSOAT["id"]."'";

          mysqli_next_result($con);
          $queryReclamante=mysqli_query($con,$consultarReclamante);
          if (mysqli_num_rows($queryReclamante)==0){
            $nombreReclamante="NO REGISTRA";

          }else{
            $resReclamante=mysqli_fetch_array($queryReclamante,MYSQLI_ASSOC);  
            $nombreReclamante=$resReclamante["nombre_lesionado"];
          }

          while ($resInformacionPersona=mysqli_fetch_array($queryInformacionPersonas,MYSQLI_ASSOC)) {

            $textoSegundoTD = "<b>Nombre: </b>".$resInformacionPersona["nombre_lesionado"]."<br>"."<b>Identificacion: </b>".$resInformacionPersona["identificacion_lesionado"]."<br><b>Reclamante: </b>".$nombreReclamante;

            if($resTipoUsuario["tipo_usuario"] == 2){
              $textoSegundoTD .= "<br><b>Investigador: </b>".strtoupper($resInformacionBasica["nombre_investigador"]);
            }

            $textoTerceroTD = "<b>Fecha de Accidente: </b>".$resInformacionBasica["fecha_accidente"]."<br>"."<b>Placa Vehiculo: </b>".$resInformacionBasica["placa_vehiculo"]."<br>"."<b>Poliza: </b>".$resInformacionBasica["poliza"];

            if($resTipoUsuario["tipo_usuario"] || $resTipoUsuario["tipo_usuario"] == 3){
              $textoTerceroTD .= "<br><b>Resultado: </b>".$resInformacionPersona["resultado"];
            }

            $data[]=array("GeneralCasosSoat"=>$informacionGeneral,
              "VictimaCasosSoat"=>$textoSegundoTD,
              "SiniestroCasosSoat"=>$textoTerceroTD,
              "opciones"=>$opciones,
              "idInvestigacion"=>$resInformacionBasica["id"]); 
          }
        }
      }
    }
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
}

function archivoPlanoCensosMundialAmpliacion($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  g.codigo_dane AS ciudad_conocido,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_visita,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_visita,
  o.descripcion AS tipo_vehiculo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  n.placa,
  f.identificacion AS nit_ips,
  DATE_FORMAT(b.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
  DATE_FORMAT(b.fecha_ingreso, '%l:%i') AS hora_ingreso,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.edad AS edad_lesionado,
  CASE 
  WHEN b.seguridad_social='1' THEN 's'
  else 'n' END AS seguridad_social_lesionado,
  i.lugar_accidente,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  b.condicion AS condicion_lesionado,
  'N' AS pruebas,
  CASE 
  WHEN b.resultado='1' THEN 's'
  WHEN b.resultado='2' THEN 'n' END AS resultado_lesionado,
  p.codigo_aseguradora AS indicador_fraude,
  'JOSE QUIJANO' AS nombre_investigador,
  IF(mi.ruta IS NULL, CONCAT(b.observaciones,'. ',i.conclusiones), CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',b.observaciones,'. ',i.conclusiones)) AS observaciones,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano,
  CASE WHEN b.eps='' THEN 'NO APLICA' WHEN b.eps IS NULL THEN 'NO APLICA' ELSE b.eps END AS eps,
  e.descripcion2 AS sexo,
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  c.telefono AS telefono_lesionado,
  f.nombre_ips AS nombre_ips,
  g.codigo_dane AS ciudad_ips,
  CASE WHEN b.remitido=2 THEN 'SI' ELSE 'NO' END AS remitido,
  CASE WHEN b.remitido=2 THEN  s.nombre_ips ELSE '' END AS ips_remitido,
  CASE WHEN b.remitido=2 THEN  t.codigo_dane ELSE '' END AS ciudad_remitido,
  CASE WHEN b.servicio_ambulancia='s' THEN  'AMBULANCIA' ELSE 'PROPIOS MEDIOS' END AS transporte,
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
  LEFT JOIN ips s ON s.id=b.ips_remitido
  LEFT JOIN ciudades t ON t.id=s.ciudad
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=2 and p.id_aseguradora=1 AND a.id_aseguradora=1  AND p.id_aseguradora=1  AND u.id_tipo=31 AND u.descripcion=7 AND e.id_tipo=3 and d.id_tipo=5 AND b.tipo_persona in (1,2) AND mi.id_multimedia = 9 ";
  
  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  
  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "ciudad_conocido"=>$resArchivoPlanoCensos["ciudad_conocido"],
      "fecha_visita"=>$resArchivoPlanoCensos["fecha_visita"],
      "hora_visita"=>$resArchivoPlanoCensos["hora_visita"],
      "tipo_vehiculo"=>$resArchivoPlanoCensos["tipo_vehiculo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "numero_poliza"=>$resArchivoPlanoCensos["poliza"],
      "digver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "vigencia_desde"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "vigencia_hasta"=>$resArchivoPlanoCensos["fin_vigencia"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "nit_ips"=>$resArchivoPlanoCensos["nit_ips"],
      "fecha_ingreso_ips"=>$resArchivoPlanoCensos["fecha_ingreso"],
      "hora_ingreso_ips"=>$resArchivoPlanoCensos["hora_ingreso"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "edad_lesionado"=>$resArchivoPlanoCensos["edad_lesionado"],
      "seguridad_social_lesionado"=>$resArchivoPlanoCensos["seguridad_social_lesionado"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "condicion_lesionado"=>$resArchivoPlanoCensos["condicion_lesionado"],
      "pruebas"=>$resArchivoPlanoCensos["pruebas"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "observaciones"=>$resArchivoPlanoCensos["observaciones"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"],
      "nombre_eps"=>$resArchivoPlanoCensos["eps"],
      "sexo"=>$resArchivoPlanoCensos["sexo"],
      "ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "telefono"=>$resArchivoPlanoCensos["telefono_lesionado"],
      "nombre_ips"=>$resArchivoPlanoCensos["nombre_ips"],
      "ciudad_ips"=>$resArchivoPlanoCensos["ciudad_ips"],
      "remitido"=>$resArchivoPlanoCensos["remitido"],
      "ips_remitido"=>$resArchivoPlanoCensos["ips_remitido"],
      "ciudad_remitido"=>$resArchivoPlanoCensos["ciudad_remitido"],
      "servicio_ambulancia"=>$resArchivoPlanoCensos["transporte"],
      "ciudad_residencia_lesionado"=>$resArchivoPlanoCensos["ciudad_residencia"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoGastosMedicosMundialAmpliacion($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){
  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  v.descripcion AS tipo_caso,
  DATE_FORMAT(a.fecha_inicio, '%d-%m-%Y') AS fecha_asignacion, 
  'NO REGISTRA' AS siniestro,
  DATE_FORMAT(a.fecha_entrega, '%d-%m-%Y') AS fecha_entrega, 
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  i.lugar_accidente,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  r.codigo_dane AS departamento_residencia,
  q.codigo_dane AS ciudad_residencia,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  'NIT' AS tipo_identificacion_reclamante,
  f.identificacion AS identificacion_reclamante,
  f.nombre_ips AS nombre_reclamante,
  '' AS apellido_reclamante,
  f.direccion AS direccion_reclamante,
  s.codigo_dane AS departamento_reclamante,
  g.codigo_dane AS ciudad_reclamante,
  'SOAT' AS ramo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  n.placa,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  '' AS fiscalia_lleva_caso,
  '' AS informe_accidente,
  '' AS no_proceso,
  b.observaciones AS hechos,
  '' AS tipo_identificacion_beneficiario,
  '' AS identificacion_beneficiario,
  '' AS nombres_beneficiario,
  '' AS apellidos_beneficiario,
  '' AS parentesco_beneficiario,
  '' AS telefono_beneficiario,
  IF(mi.ruta IS NULL, i.conclusiones, CONCAT('Para mas informacion consulte este enlace ',mi.ruta,'. ',i.conclusiones)) AS conclusiones,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  'JOSE QUIJANO' AS nombre_investigador,
  p.codigo_aseguradora AS indicador_fraude,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN ips f ON f.id=b.ips
  LEFT JOIN ciudades g ON g.id=f.ciudad 
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude
  LEFT JOIN ciudades q ON q.id=c.ciudad_residencia
  LEFT JOIN departamentos r ON r.id=q.id_departamento 
  LEFT JOIN departamentos s ON s.id=g.id_departamento 
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN definicion_tipos v ON v.id=u.descripcion
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  WHERE a.tipo_solicitud=2 and p.id_aseguradora=1 AND a.id_aseguradora=1 AND v.id_tipo=32 AND u.id_tipo=31 AND u.descripcion=2 and d.id_tipo=5 AND b.tipo_persona in (1,2) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }
  else if ($tipoGenerarArchivoPlano=="codigoCaso"){
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }
  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos.=" AND a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }
  $consultaArchivoPlanoCensos.=" AND a.estado=1 AND mi.id_multimedia = 9 ";

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "tipo_caso"=>$resArchivoPlanoCensos["tipo_caso"],
      "fecha_asignacion"=>$resArchivoPlanoCensos["fecha_asignacion"],
      "siniestro"=>$resArchivoPlanoCensos["siniestro"],
      "fecha_entrega"=>$resArchivoPlanoCensos["fecha_entrega"],
      "codigo_ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "departamento_residencia"=>$resArchivoPlanoCensos["departamento_residencia"],
      "ciudad_residencia"=>$resArchivoPlanoCensos["ciudad_residencia"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "tipo_identificacion_reclamante"=>$resArchivoPlanoCensos["tipo_identificacion_reclamante"],
      "identificacion_reclamante"=>$resArchivoPlanoCensos["identificacion_reclamante"],
      "nombre_reclamante"=>$resArchivoPlanoCensos["nombre_reclamante"],
      "apellido_reclamante"=>$resArchivoPlanoCensos["apellido_reclamante"],
      "direccion_reclamante"=>$resArchivoPlanoCensos["direccion_reclamante"],
      "departamento_reclamante"=>$resArchivoPlanoCensos["departamento_reclamante"],
      "ciudad_reclamante"=>$resArchivoPlanoCensos["ciudad_reclamante"],
      "ramo"=>$resArchivoPlanoCensos["ramo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "poliza"=>$resArchivoPlanoCensos["poliza"],
      "dig_ver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "inicio_vigencia"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "fin_vigencia"=>$resArchivoPlanoCensos["fin_vigencia"],
      "fiscalia_lleva_caso"=>$resArchivoPlanoCensos["fiscalia_lleva_caso"],
      "informe_accidente"=>$resArchivoPlanoCensos["informe_accidente"],
      "no_proceso"=>$resArchivoPlanoCensos["no_proceso"],
      "hechos"=>$resArchivoPlanoCensos["hechos"],
      "tipo_identificacion_beneficiario"=>$resArchivoPlanoCensos["tipo_identificacion_beneficiario"],
      "identificacion_beneficiario"=>$resArchivoPlanoCensos["identificacion_beneficiario"],
      "nombres_beneficiario"=>$resArchivoPlanoCensos["nombres_beneficiario"],
      "apellidos_beneficiario"=>$resArchivoPlanoCensos["apellidos_beneficiario"],
      "parentesco_beneficiario"=>$resArchivoPlanoCensos["parentesco_beneficiario"],
      "telefono_beneficiario"=>$resArchivoPlanoCensos["telefono_beneficiario"],
      "conclusiones"=>$resArchivoPlanoCensos["conclusiones"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function archivoPlanoMuerteMundialAmpliacion($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico){

  global $con;
  $data=array();
  $consultaArchivoPlanoCensos="
  SELECT
  a.codigo AS consecutivo,
  v.descripcion AS tipo_caso,
  DATE_FORMAT(a.fecha_inicio, '%d-%m-%Y') AS fecha_asignacion, 
  'NO REGISTRA' AS siniestro,
  DATE_FORMAT(a.fecha_entrega, '%d-%m-%Y') AS fecha_entrega, 
  j.codigo_dane AS codigo_ciudad_ocurrencia,
  i.lugar_accidente,
  d.descripcion AS tipo_identificacion_lesionado,
  c.identificacion AS identificacion_lesionado,
  c.nombres AS nombres_lesionado,
  c.apellidos AS apellidos_lesionado,
  r.codigo_dane AS departamento_residencia,
  q.codigo_dane AS ciudad_residencia,
  DATE_FORMAT(i.fecha_accidente, '%d-%m-%Y') AS fecha_accidente,
  DATE_FORMAT(i.fecha_accidente, '%l:%i') AS hora_accidente,
  z.descripcion AS tipo_identificacion_reclamante,
  y.identificacion AS identificacion_reclamante,
  y.nombres AS nombre_reclamante,
  y.apellidos AS apellido_reclamante,
  y.direccion_residencia AS direccion_reclamante,
  ab.codigo_dane AS departamento_reclamante,
  aa.codigo_dane AS ciudad_reclamante,
  'SOAT' AS ramo,
  k.indicativo AS aseguradora,
  m.numero AS poliza,
  m.digito_verificacion AS dig_ver_poliza,
  n.placa,
  DATE_FORMAT(m.inicio_vigencia, '%d-%m-%Y') AS inicio_vigencia,
  DATE_FORMAT(m.fin_vigencia, '%d-%m-%Y') AS fin_vigencia,
  i.fiscalia_lleva_caso AS fiscalia_lleva_caso,
  i.croquis AS informe_accidente,
  i.proceso_fiscalia AS no_proceso,
  i.hechos AS hechos,
  ae.descripcion AS tipo_identificacion_beneficiario,
  ad.identificacion AS identificacion_beneficiario,
  ad.nombres AS nombres_beneficiario,
  ad.apellidos AS apellidos_beneficiario,
  ac.parentesco AS parentesco_beneficiario,
  ad.telefono AS telefono_beneficiario,
  i.conclusiones AS conclusiones,
  CASE 
  WHEN b.resultado='1' THEN 'S'
  WHEN b.resultado='2' THEN 'N' END AS resultado_lesionado,
  'JOSE QUIJANO' AS nombre_investigador,
  p.codigo_aseguradora AS indicador_fraude,
  DATE_FORMAT(CURDATE(),'%d-%m-%Y')AS fecha_plano
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN personas c ON c.id=b.id_persona
  LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
  LEFT JOIN detalle_investigaciones_soat i ON i.id_investigacion=a.id
  LEFT JOIN ciudades j ON j.id=i.ciudad_ocurrencia 
  LEFT JOIN aseguradoras k ON k.id=a.id_aseguradora
  LEFT JOIN polizas m ON m.id=i.id_poliza
  LEFT JOIN vehiculos n ON n.id=m.id_vehiculo
  LEFT JOIN indicador_aseguradora p ON p.id_indicador=b.indicador_fraude
  LEFT JOIN ciudades q ON q.id=c.ciudad_residencia
  LEFT JOIN departamentos r ON r.id=q.id_departamento 
  LEFT JOIN definicion_tipos u ON u.descripcion2=a.tipo_caso
  LEFT JOIN definicion_tipos v ON v.id=u.descripcion
  LEFT JOIN personas_investigaciones_soat w ON a.id=w.id_investigacion
  LEFT JOIN personas y ON y.id=w.id_persona
  LEFT JOIN definicion_tipos z ON z.id=y.tipo_identificacion
  LEFT JOIN ciudades aa ON aa.id=y.ciudad_residencia
  LEFT JOIN departamentos ab ON ab.id=aa.id_departamento 
  LEFT JOIN personas_investigaciones_soat ac ON a.id=ac.id_investigacion
  LEFT JOIN personas ad ON ad.id=ac.id_persona
  LEFT JOIN definicion_tipos ae ON ae.id=ad.tipo_identificacion
  WHERE a.tipo_solicitud=2 and p.id_aseguradora=1 AND ac.tipo_persona in (4) AND w.tipo_persona in (3) AND z.id_tipo=5 AND ae.id_tipo=5 AND a.id_aseguradora=1 AND v.id_tipo=32 AND u.id_tipo=31 AND u.descripcion=3 and d.id_tipo=5 AND b.tipo_persona in (1) ";

  if ($tipoGenerarArchivoPlano=="rangoFecha"){
    $consultaArchivoPlanoCensos.="AND a.fecha_cargue BETWEEN '".$fechaInicioReporteBasico."' AND '".$fechaFinReporteBasico."'";
  }  else if ($tipoGenerarArchivoPlano=="codigoCaso")  {
    $consultaArchivoPlanoCensos.="AND a.id='".$fechaInicioReporteBasico."'";
  }

  if($_SESSION['tipo_usuario'] == 4){
    $consultaArchivoPlanoCensos.=" AND a.id_aseguradora='".$_SESSION['id_aseguradora']."'";
  }
  $consultaArchivoPlanoCensos.=" AND a.estado=1";

  $queryArchivoPlanoCensos=mysqli_query($con,$consultaArchivoPlanoCensos);
  while ($resArchivoPlanoCensos=mysqli_fetch_array($queryArchivoPlanoCensos,MYSQLI_ASSOC)){
    $data[]=array("codigo"=>$resArchivoPlanoCensos["consecutivo"],
      "tipo_caso"=>$resArchivoPlanoCensos["tipo_caso"],
      "fecha_asignacion"=>$resArchivoPlanoCensos["fecha_asignacion"],
      "siniestro"=>$resArchivoPlanoCensos["siniestro"],
      "fecha_entrega"=>$resArchivoPlanoCensos["fecha_entrega"],
      "codigo_ciudad_ocurrencia"=>$resArchivoPlanoCensos["codigo_ciudad_ocurrencia"],
      "lugar_accidente"=>$resArchivoPlanoCensos["lugar_accidente"],
      "tipo_identificacion_lesionado"=>$resArchivoPlanoCensos["tipo_identificacion_lesionado"],
      "identificacion_lesionado"=>$resArchivoPlanoCensos["identificacion_lesionado"],
      "nombres_lesionado"=>$resArchivoPlanoCensos["nombres_lesionado"],
      "apellidos_lesionado"=>$resArchivoPlanoCensos["apellidos_lesionado"],
      "departamento_residencia"=>$resArchivoPlanoCensos["departamento_residencia"],
      "ciudad_residencia"=>$resArchivoPlanoCensos["ciudad_residencia"],
      "fecha_accidente"=>$resArchivoPlanoCensos["fecha_accidente"],
      "hora_accidente"=>$resArchivoPlanoCensos["hora_accidente"],
      "tipo_identificacion_reclamante"=>$resArchivoPlanoCensos["tipo_identificacion_reclamante"],
      "identificacion_reclamante"=>$resArchivoPlanoCensos["identificacion_reclamante"],
      "nombre_reclamante"=>$resArchivoPlanoCensos["nombre_reclamante"],
      "apellido_reclamante"=>$resArchivoPlanoCensos["apellido_reclamante"],
      "direccion_reclamante"=>$resArchivoPlanoCensos["direccion_reclamante"],
      "departamento_reclamante"=>$resArchivoPlanoCensos["departamento_reclamante"],
      "ciudad_reclamante"=>$resArchivoPlanoCensos["ciudad_reclamante"],
      "ramo"=>$resArchivoPlanoCensos["ramo"],
      "aseguradora"=>$resArchivoPlanoCensos["aseguradora"],
      "poliza"=>$resArchivoPlanoCensos["poliza"],
      "dig_ver_poliza"=>$resArchivoPlanoCensos["dig_ver_poliza"],
      "placa"=>$resArchivoPlanoCensos["placa"],
      "inicio_vigencia"=>$resArchivoPlanoCensos["inicio_vigencia"],
      "fin_vigencia"=>$resArchivoPlanoCensos["fin_vigencia"],
      "fiscalia_lleva_caso"=>$resArchivoPlanoCensos["fiscalia_lleva_caso"],
      "informe_accidente"=>$resArchivoPlanoCensos["informe_accidente"],
      "no_proceso"=>$resArchivoPlanoCensos["no_proceso"],
      "hechos"=>$resArchivoPlanoCensos["hechos"],
      "tipo_identificacion_beneficiario"=>$resArchivoPlanoCensos["tipo_identificacion_beneficiario"],
      "identificacion_beneficiario"=>$resArchivoPlanoCensos["identificacion_beneficiario"],
      "nombres_beneficiario"=>$resArchivoPlanoCensos["nombres_beneficiario"],
      "apellidos_beneficiario"=>$resArchivoPlanoCensos["apellidos_beneficiario"],
      "parentesco_beneficiario"=>$resArchivoPlanoCensos["parentesco_beneficiario"],
      "telefono_beneficiario"=>$resArchivoPlanoCensos["telefono_beneficiario"],
      "conclusiones"=>$resArchivoPlanoCensos["conclusiones"],
      "resultado_lesionado"=>$resArchivoPlanoCensos["resultado_lesionado"],
      "nombre_investigador"=>$resArchivoPlanoCensos["nombre_investigador"],
      "indicador_fraude"=>$resArchivoPlanoCensos["indicador_fraude"],
      "fecha_plano"=>$resArchivoPlanoCensos["fecha_plano"]
    );
  }
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results); 
}

function consultaReportePendienteAnalistas($idAseguradora, $tipoCaso, $idAnalista, $fechaCargue){

  global $con;
  $data=array();

  $ConsultaPendAnalista = "SELECT a.id_usuario, a.id, a.codigo, d.placa, e.fecha_accidente, CONCAT(c.nombres, ' ', c.apellidos) AS analista, b.nombre_aseguradora AS aseguradora, a.fecha_inicio, a.fecha_entrega, a.fecha_cargue
  FROM investigaciones a
  LEFT JOIN aseguradoras b ON a.id_aseguradora = b.id
  LEFT JOIN detalle_investigaciones_soat e ON e.id_investigacion = a.id
  LEFT JOIN asignar_censo_analista_temp d ON d.id_investigacion = a.id
  LEFT JOIN usuarios c ON c.id = a.id_usuario
  WHERE a.id_usuario != 56 ";

  if($idAseguradora != '' && $idAseguradora != '0'){ $ConsultaPendAnalista .= " AND a.id_aseguradora = ".$idAseguradora;}
  if($tipoCaso != '' && $tipoCaso != '0'){ $ConsultaPendAnalista .= " AND a.tipo_caso = ".$tipoCaso;}
  if($idAnalista != '' && $idAnalista != '0' && $idAnalista != 56){ $ConsultaPendAnalista .= " AND a.id_usuario = ".$idAnalista;}
  if($fechaCargue != ''){ $ConsultaPendAnalista .= " AND fecha_cargue = '".$fechaCargue."'";}

  $queryConsultaPendAnalista=mysqli_query($con,$ConsultaPendAnalista);

  while ($resPendAnalista=mysqli_fetch_array($queryConsultaPendAnalista,MYSQLI_ASSOC)){
    $data[]=array("id_usuario"=>$resPendAnalista["id_usuario"],
      "codigo"=>$resPendAnalista["codigo"],
      "placa"=>$resPendAnalista["placa"],
      "fecha_accidente"=>$resPendAnalista["fecha_accidente"],
      "analista"=>$resPendAnalista["analista"],
      "aseguradora"=>$resPendAnalista["aseguradora"],
      "fecha_inicio"=>$resPendAnalista["fecha_inicio"],
      "fecha_entrega"=>$resPendAnalista["fecha_entrega"],
      "fecha_cargue"=>$resPendAnalista["fecha_cargue"]
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultaCasosCuentaCobroInv($idInvestigador, $idAseguradora, $tipoCaso, $fechaLimite){

  global $con;
  $data=array();

  $consultaCasosInv = "SELECT a.id, a.codigo, a.id_aseguradora, j.nombre_corto AS aseguradora, a.tipo_caso, l.descripcion2 AS tipoCaso, a.fecha_inicio, a.fecha_entrega, a.fecha, f.fecha_accidente, CONCAT(k.nombres, ' ', k.apellidos) AS investigador
  , c.tipo_identificacion, i.descripcion AS tipo_docu, c.identificacion, CONCAT(c.nombres, ' ', c.apellidos) AS lesionado, 
  c.ciudad_residencia, CONCAT(e.nombre, ' - ', d.nombre) AS ciudad, d.tipo_zona, b.resultado as id_resultado, b.indicador_fraude, g.numero as poliza, h.placa, mi.ruta
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON b.id_investigacion = a.id
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  LEFT JOIN aseguradoras j ON j.id = a.id_aseguradora
  LEFT JOIN detalle_investigaciones_soat f ON f.id_investigacion = a.id
  LEFT JOIN investigadores k ON a.id_investigador = k.id
  LEFT JOIN personas c ON b.id_persona = c.id
  LEFT JOIN ciudades d ON d.id = c.ciudad_residencia
  LEFT JOIN departamentos e ON e.id = d.id_departamento
  LEFT JOIN polizas g ON g.id = f.id_poliza
  LEFT JOIN vehiculos h ON h.id = g.id_vehiculo
  LEFT JOIN definicion_tipos i ON i.id_tipo = 5 AND i.id = c.tipo_identificacion
  LEFT JOIN definicion_tipos l ON l.id_tipo = 8 AND l.id = a.tipo_caso
  WHERE mi.id_multimedia = 9 AND NOT EXISTS (
  SELECT NULL
  FROM investigaciones_cuenta_investigador aa
  WHERE a.id = aa.id_investigacion) 
  AND b.tipo_persona = 1 AND a.tipo_solicitud = 1 AND a.id > 50000";

  if($idAseguradora != '' && $idAseguradora != '0'){ $consultaCasosInv .= " AND a.id_aseguradora = ".$idAseguradora;}
  if($tipoCaso != '' && $tipoCaso != '0'){ $consultaCasosInv .= " AND a.tipo_caso = ".$tipoCaso;}
  if($idInvestigador != '' && $idInvestigador != '0' && $idInvestigador != 30){ 
    $consultaCasosInv .= " AND a.id_investigador = ".$idInvestigador;
  }
  if($fechaLimite != ''){ $consultaCasosInv .= " AND date_format(a.fecha, '%Y-%m-%d') <= '".$fechaLimite."'";}

  $consultaCasosInv .= " ORDER BY a.tipo_caso, a.id;";

  $queryConsultaPendAnalista=mysqli_query($con,$consultaCasosInv);

  while ($repCasosInv=mysqli_fetch_array($queryConsultaPendAnalista,MYSQLI_ASSOC)){

    $botonInforme = '<a type="button" class="btn btn-block btn-default btn-sm" title="No Tiene Informe"><span class="fa fa-file-pdf-o"></span></a>';

    if ($repCasosInv["ruta"]!= ""){
      global $rutaArchivos;
      $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$repCasosInv["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#304f6f;"><span class="fa fa-file-pdf-o"></span></a>';
    }

    if ($repCasosInv["indicador_fraude"] == 13 || $repCasosInv["id_resultado"] == 3){
      $repCasosInv["id_resultado"] = 3;
      $repCasosInv["resultado"] = 'OCURRENCIA';
    }else{
      if($repCasosInv["id_resultado"] == 2){
        $repCasosInv["resultado"] = 'NO ATENDER';
      }else{
        $repCasosInv["resultado"] = 'ATENDER';
      }
    }

    $data[]=array("id"=>$repCasosInv["id"],
      "opciones"=>'
      <button onclick="agregarFila(this, '.$repCasosInv["id"].')" type="button" class="btn btn-danger btn-block btn-sm" style="background-color:#9e174f;" ><span class="fa fa-upload"></span></button>'.$botonInforme,
      "marcar"=>'<input value="'.$repCasosInv["id"].'" class="checkCasos" id="check'.$repCasosInv["id"].'" type="checkbox"/>',
      "codigo"=>$repCasosInv["codigo"],
      "id_aseguradora"=>$repCasosInv["id_aseguradora"],
      "aseguradora"=>$repCasosInv["aseguradora"],
      "tipo_caso"=>$repCasosInv["tipo_caso"],
      "tipoCaso"=>$repCasosInv["tipoCaso"],
      "fecha_inicio"=>$repCasosInv["fecha_inicio"],
      "investigador"=>$repCasosInv["investigador"],
      "fecha_entrega"=>$repCasosInv["fecha_entrega"],
      "fecha"=>$repCasosInv["fecha"],
      "tipo_identificacion"=>$repCasosInv["tipo_identificacion"],
      "tipo_docu"=>$repCasosInv["tipo_docu"],
      "fecha_accidente"=>$repCasosInv["fecha_accidente"],
      "identificacion"=>$repCasosInv["identificacion"],
      "lesionado"=>$repCasosInv["lesionado"],
      "ciudad_residencia"=>$repCasosInv["ciudad_residencia"],
      "ciudad"=>$repCasosInv["ciudad"],
      "tipo_zona"=>$repCasosInv["tipo_zona"],
      "id_resultado"=>$repCasosInv["id_resultado"],
      "resultado"=>$repCasosInv["resultado"],
      "poliza"=>$repCasosInv["poliza"],
      "placa"=>$repCasosInv["placa"]
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function verCasosCuentaCobroInv($idInvestigador, $periodo, $numero, $id){

  global $con;
  $data=array();

  $sqlCabecera="SELECT a.id, DATE_FORMAT(a.periodo,'%Y-%m') as periodo, a.numero, CONCAT(m.nombres, ' ', m.apellidos) AS investigador , a.estado, a.cantidad_investigaciones, a.valor_viaticos, a.valor_adicional, a.valor_total, a.fecha, a.fecha_cerrada, a.observacion FROM cuenta_cobro_investigador a 
  LEFT JOIN investigadores m ON m.id = a.id_investigador ";

  if($id != ""){
     $sqlCabecera.="WHERE a.id = $id";
  }else{
     $sqlCabecera.="WHERE a.periodo = '$periodo' AND a.numero = $numero AND a.id_investigador = $idInvestigador";
  }
  
  $investigador = "";
  $estado = 1;
  $cuenta = 0;
  $totalCasos = 0;
  $valorAdicional = 0;
  $valorViaticos = 0;
  $fecha = "";
  $fechaCerrada = "";
  $observacion = "";

  $queryCabecera=mysqli_query($con,$sqlCabecera);
  if(mysqli_num_rows($queryCabecera) > 0){
    $respCabecera = mysqli_fetch_array($queryCabecera,MYSQLI_ASSOC);
    $cuenta = $respCabecera["id"];
    $investigador = $respCabecera["investigador"];    
    $periodo = $respCabecera["periodo"];
    $numero = $respCabecera["numero"];
    $estado = $respCabecera["estado"];
    $totalCasos = $respCabecera["valor_total"];
    $valorAdicional = $respCabecera["valor_adicional"];
    $valorViaticos = $respCabecera["valor_viaticos"];
    $fecha = $respCabecera["fecha"];
    $fechaCerrada = $respCabecera["fecha_cerrada"];
    $observacion = $respCabecera["observacion"];
  }

  $consultaCasosInv = "SELECT d.id_cuenta_cobro, a.id, a.codigo, a.id_aseguradora, j.nombre_corto AS aseguradora, a.tipo_caso, l.descripcion2 AS tipoCasoCorto, l.descripcion3 AS tipoCasoTarifa,  l.descripcion AS tipoCaso, f.fecha_accidente, CONCAT(c.nombres, ' ', c.apellidos) AS lesionado, c.ciudad_residencia, f1.id_departamento, f1.tipo_zona AS capital, f1.tipo_zona, b.resultado as id_resultado, b.indicador_fraude, g.numero as poliza, h.placa, d.valor_pagado, d.id_tarifa, mi.ruta
  FROM investigaciones_cuenta_investigador d
  LEFT JOIN investigaciones a ON a.id = d.id_investigacion
  LEFT JOIN personas_investigaciones_soat b ON b.id_investigacion = d.id_investigacion
  LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
  LEFT JOIN aseguradoras j ON j.id = a.id_aseguradora
  LEFT JOIN detalle_investigaciones_soat f ON f.id_investigacion = b.id_investigacion
  LEFT JOIN personas c ON b.id_persona = c.id
  LEFT JOIN ciudades f1 ON f1.id = c.ciudad_residencia
  LEFT JOIN polizas g ON g.id = f.id_poliza
  LEFT JOIN vehiculos h ON h.id = g.id_vehiculo
  LEFT JOIN definicion_tipos l ON l.id_tipo = 8 AND l.id = a.tipo_caso
  WHERE mi.id_multimedia = 9 AND b.tipo_persona = 1 AND d.id_cuenta_cobro = $cuenta ORDER BY a.tipo_caso, a.id;";

  $queryVerCasosCuentaInv=mysqli_query($con,$consultaCasosInv);

  $cantPositivos=0; $cantAtender=0;

  while ($repCasosInv=mysqli_fetch_array($queryVerCasosCuentaInv,MYSQLI_ASSOC)){

    if ($repCasosInv["indicador_fraude"] == 13 || $repCasosInv["id_resultado"] == 3){
      $repCasosInv["id_resultado"] = 3;
      $repCasosInv["resultado"] = 'OCURRENCIA';
      $cantAtender++;
    }else{
      if($repCasosInv["id_resultado"] == 2){
        $repCasosInv["resultado"] = 'NO ATENDER';
        $cantPositivos++; 
      }else{
        $repCasosInv["resultado"] = 'ATENDER';
        $cantAtender++;
      }
    }

    if($fechaCerrada == ''){

      $sqlValorv="SELECT id, valor, descripcion FROM (
      SELECT 1 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 1 AND id_clase = 1 AND id_resultado = ".$repCasosInv['id_resultado']." AND id_aseguradora = ".$repCasosInv["id_aseguradora"]." AND id_tipo_caso = ".$repCasosInv["tipoCasoTarifa"]." AND id_departamento = ".$repCasosInv["id_departamento"]." AND id_tipo_zona = ".$repCasosInv["capital"]." UNION
      SELECT 2 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 1 AND id_clase = 1 AND id_resultado = ".$repCasosInv['id_resultado']." AND id_aseguradora = ".$repCasosInv["id_aseguradora"]." AND id_tipo_caso = 0 AND id_departamento = ".$repCasosInv["id_departamento"]." AND id_tipo_zona = ".$repCasosInv["capital"]." UNION
      SELECT 3 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 1 AND id_clase = 1 AND id_resultado = ".$repCasosInv['id_resultado']." AND id_aseguradora = ".$repCasosInv["id_aseguradora"]." AND id_tipo_caso = 0 AND id_departamento = ".$repCasosInv["id_departamento"]." AND id_tipo_zona = 0 UNION
      SELECT 4 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 1 AND id_clase = 1 AND id_resultado = ".$repCasosInv['id_resultado']." AND id_aseguradora = ".$repCasosInv["id_aseguradora"]." AND id_tipo_caso = ".$repCasosInv["tipoCasoTarifa"]." AND id_departamento = 0 AND id_tipo_zona = 0 UNION
      SELECT 5 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 1 AND id_clase = 1 AND id_resultado = ".$repCasosInv['id_resultado']." AND id_aseguradora = ".$repCasosInv["id_aseguradora"]." AND id_tipo_caso = 0 AND id_departamento = 0 AND id_tipo_zona = 0) cte ORDER BY prioridad DESC LIMIT 1";
      $queryValor=mysqli_query($con,$sqlValorv);

      $id_tarifa = 0;   $valorCaso = 0;

      if(mysqli_num_rows($queryValor) > 0){
        $respValor = mysqli_fetch_array($queryValor,MYSQLI_ASSOC);
        $valorCaso = $respValor["valor"];
        $id_tarifa = $respValor["id"];
      }

      $totalCasos=$totalCasos+$valorCaso;
    }else{
      $valorCaso = $repCasosInv["valor_pagado"];
      $id_tarifa = $repCasosInv["id_tarifa"];
    }

    $classBtnEliminar = 'btn-warning';
    $disabled = '';

    if($estado == 2){
      $classBtnEliminar = 'btn-default';
      $disabled = 'disabled="disabled"';
    }

    $botonInforme = '<a type="button" class="btn btn-block btn-default btn-sm" title="No Tiene Informe"><span class="fa fa-file-pdf-o"></span></a>';

    if ($repCasosInv["ruta"]!= ""){
      global $rutaArchivos;
      $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$repCasosInv["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#762929;"><span class="fa fa-file-pdf-o"></span></a>';
    }

    $data[]=array("id"=>$repCasosInv["id"],
      "opciones"=>'
      <button '.$disabled.' onclick="eliminarFilaCuentaInv(this, '.$repCasosInv["id"].', '.$repCasosInv["id_cuenta_cobro"].')" type="button" class="btn btn-block btn-sm btns-eliminar '.$classBtnEliminar.'"><span class="fa fa-trash"></span></button>'.$botonInforme,
      "codigo"=>$repCasosInv["codigo"],
      "id_aseguradora"=>$repCasosInv["id_aseguradora"],
      "aseguradora"=>$repCasosInv["aseguradora"],
      "tipo_caso"=>$repCasosInv["tipo_caso"],
      "tipoCasoCorto"=>$repCasosInv["tipoCasoCorto"],
      "tipoCasoTarifa"=>$repCasosInv["tipoCasoTarifa"],
      "fecha_accidente"=>$repCasosInv["fecha_accidente"],
      "lesionado"=>$repCasosInv["lesionado"],
      "tipo_zona"=>$repCasosInv["tipo_zona"],
      "resultado"=>$repCasosInv["resultado"],
      "id_resultado"=>$repCasosInv["id_resultado"],
      "poliza"=>$repCasosInv["poliza"],
      "placa"=>$repCasosInv["placa"],
      "valor"=>'<input '.$disabled.' value="'.$valorCaso.'" onblur="calcularTotalesVerCuentaInv();" class="valorCasos" name="valorCasos[]" id="'.$repCasosInv["id"].'" type="number"> <input class="tarifaCasos" name="tarifaCasos[]" value="'.$id_tarifa.'" type="hidden"> <input class="idCasos" name="idCasos[]" value="'.$repCasosInv["id"].'" type="hidden">',
      "valor1"=>'$'.number_format($valorCaso)
    );
  }

  $totales = array(
    "totalCasos" => intval($totalCasos),
    "cantAtender" => intval($cantAtender),
    "cantPositivos" => intval($cantPositivos),
    "valorViaticos" => intval($valorViaticos),
    "valorAdicional" => intval($valorAdicional)
  );

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "cuenta" => intval($cuenta),
    "investigador" => $investigador,
    "periodo" => $periodo,
    "numero" => $numero,
    "estado" => intval($estado),
    "fechaCreacion" => $fecha,
    "fechaCerrada" => $fechaCerrada,
    "observacion" => $observacion,
    "aaData" => $data,
    "totales" => $totales
  );

  return json_encode($results); 
}

function consultaCasosAFacturar($codigo, $idAseguradora, $tipoCaso, $fechaLimite){

  global $con;
  $data=array();

  $consultaCasosFac = "SELECT a.id,
  tp.descripcion2 AS caso, a.codigo, a.id_aseguradora, date_format(a.fecha, '%d-%m-%Y') AS fecha,
  CASE WHEN po.numero IS NULL THEN 'NO REGISTRA' ELSE po.numero END AS poliza, 
  CASE WHEN v.placa IS NULL THEN 'NO REGISTRA' ELSE v.placa END AS placa,
  CASE WHEN ica.identificador IS NULL THEN 'NO REGISTRA' ELSE ica.identificador END AS radicado,
  CASE WHEN c.id IS NULL THEN 'NO REGISTRA' ELSE c.nombre END AS ciudad_ips, 
  CASE WHEN d.id IS NULL THEN 'NO REGISTRA' ELSE d.nombre END AS departamento_ips,
  CASE WHEN ip.identificacion IS NULL THEN 'NO REGISTRA' ELSE ip.identificacion END AS id_ips, 
  CASE WHEN ip.nombre_ips IS NULL THEN 'NO REGISTRA' ELSE ip.nombre_ips END AS nombre_ips, 
  CASE WHEN p.tipo_identificacion IS NULL THEN 'NA'
  WHEN p.tipo_identificacion = 1 THEN 'CC'
  WHEN p.tipo_identificacion = 2 THEN 'TI'
  WHEN p.tipo_identificacion = 3 THEN 'NIT'
  WHEN p.tipo_identificacion = 4 THEN 'RC'
  WHEN p.tipo_identificacion = 5 THEN 'CE'
  WHEN p.tipo_identificacion = 6 THEN 'MSI'
  WHEN p.tipo_identificacion = 7 THEN 'ASI'
  WHEN p.tipo_identificacion = 8 THEN 'PAS'
  ELSE 'NA' END AS tipo_id, 
  CASE WHEN p.identificacion IS NULL THEN 'NO REGISTRA' ELSE p.identificacion END AS id_lesionado, 
  CASE WHEN CONCAT(p.nombres,' ',p.apellidos) IS NULL THEN 'NO REGISTRA' ELSE CONCAT(p.nombres,' ',p.apellidos) END AS nombre_lesionado, 
  date_format(dis.fecha_accidente, '%d-%m-%Y') AS fecha_accidente, if(dis.tipo_zona > 0, 'SI', 'NO') AS zona, 
  if(p.sexo > 0, 'SI', 'NO') AS sexo, 
  CASE WHEN pis.resultado IS NULL THEN 'NO REGISTRA' ELSE pis.resultado END AS id_resultado,
  CASE WHEN pis.resultado IS NULL THEN 'NO REGISTRA' WHEN pis.resultado = 1 THEN 'ATENDER' ELSE 'NO ATENDER' END AS resultado,
  CASE WHEN pis.indicador_fraude IS NULL THEN 'NO REGISTRA' ELSE pis.indicador_fraude END AS indicador_fraude,
  CASE WHEN inf.descripcion IS NULL THEN 'NO REGISTRA' ELSE inf.descripcion END AS causal,
  IF(a.conteo_cargue > 0, 'SI', 'NO') AS cargado, a.fecha_cargue, if(a.id_tipo_auditoria = 1, 'Declaración', 'Teléfono') AS auditoria
  FROM investigaciones a
  LEFT JOIN tipo_caso tp ON tp.id = a.tipo_caso
  LEFT JOIN detalle_investigaciones_soat dis ON dis.id_investigacion = a.id
  LEFT JOIN polizas po ON po.id = dis.id_poliza
  LEFT JOIN vehiculos v ON v.id = po.id_vehiculo
  LEFT JOIN personas_investigaciones_soat pis ON pis.id_investigacion = a.id
  LEFT JOIN ips ip ON ip.id=pis.`ips`
  LEFT JOIN ciudades c ON c.id=ip.`ciudad`
  LEFT JOIN departamentos d ON d.id=c.`id_departamento`
  LEFT JOIN id_casos_aseguradora ica ON ica.id_investigacion = a.id
  LEFT JOIN personas p ON p.id = pis.id_persona AND pis.tipo_persona = 1
  LEFT JOIN definicion_tipos inf ON inf.id=pis.indicador_fraude AND inf.id_tipo=12
  WHERE NOT EXISTS (
    SELECT NULL
    FROM investigaciones_facturas b
    WHERE a.id = b.id_investigacion) 
  AND a.tipo_solicitud = 1 AND a.id > 30000 ";

  if($codigo != '' && $codigo != '0'){ 
    $consultaCasosFac .= " AND a.codigo = '".$codigo."'";
  }elseif($codigo == ''){
    if($idAseguradora != '' && $idAseguradora != '0'){ $consultaCasosFac .= " AND a.id_aseguradora = ".$idAseguradora;}
    if($tipoCaso != '' && $tipoCaso != '0'){ $consultaCasosFac .= " AND a.tipo_caso = ".$tipoCaso;}

    if($fechaLimite != ''){ $consultaCasosFac .= " AND date_format(a.fecha, '%Y-%m-%d') <= '".$fechaLimite."'";}  
    if($fechaLimite != ''){ $consultaCasosFac .= " AND date_format(a.fecha_entrega, '%Y-%m-%d') <= '".$fechaLimite."'";}
  }

  $consultaCasosFac .= " GROUP BY a.id ORDER BY a.tipo_caso, a.id;";

  $queryConsultaPendAnalista=mysqli_query($con,$consultaCasosFac);

  while ($repCasosInv=mysqli_fetch_array($queryConsultaPendAnalista,MYSQLI_ASSOC)){

    if ($repCasosInv["indicador_fraude"] == 13 || $repCasosInv["id_resultado"] == 3){
      $repCasosInv["id_resultado"] = 3;
      $repCasosInv["resultado"] = 'OCURRENCIA';
    }else{
      if($repCasosInv["id_resultado"] == 2){
        $repCasosInv["resultado"] = 'NO ATENDER';
      }else{
        $repCasosInv["resultado"] = 'ATENDER';
      }
    }

    $data[]=array("id"=>$repCasosInv["id"],
      "opciones"=>'
      <button onclick="agregarFila(this, '.$repCasosInv["id"].')" type="button" class="btn btn-danger btn-block btn-sm" style="background-color:#9e174f;" ><span class="fa fa-upload"></span></button>',
      "marcar"=>'<input value="'.$repCasosInv["id"].'" class="checkCasos" id="check'.$repCasosInv["id"].'" type="checkbox"/>',
      "codigo"=>$repCasosInv["codigo"],
      "caso"=>$repCasosInv["caso"],
      "id_aseguradora"=>$repCasosInv["id_aseguradora"],
      "poliza"=>$repCasosInv["poliza"],
      "placa"=>$repCasosInv["placa"],
      "radicado"=>$repCasosInv["radicado"],
      "ciudad_ips"=>$repCasosInv["ciudad_ips"],
      "departamento_ips"=>$repCasosInv["departamento_ips"],
      "id_ips"=>$repCasosInv["id_ips"],
      "nombre_ips"=>$repCasosInv["nombre_ips"],
      "tipo_id"=>$repCasosInv["tipo_id"],
      "id_lesionado"=>$repCasosInv["id_lesionado"],
      "nombre_lesionado"=>$repCasosInv["nombre_lesionado"],
      "fecha_accidente"=>$repCasosInv["fecha_accidente"],
      "zona"=>$repCasosInv["zona"],
      "sexo"=>$repCasosInv["sexo"],
      "id_resultado"=>$repCasosInv["id_resultado"],
      "resultado"=>$repCasosInv["resultado"],
      "causal"=>$repCasosInv["causal"],
      "cargado"=>$repCasosInv["cargado"],
      "fecha_cargue"=>$repCasosInv["fecha_cargue"],
      "auditoria"=>$repCasosInv["auditoria"],
      "fecha"=>$repCasosInv["fecha"],
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultaCasosCuentaCobroAnalista($idAnalista, $idAseguradora, $tipoCaso, $codigo, $fechaLimite){

  global $con;
  $data=array();
  $whereJoinInv = '';

  if($codigo != ''){
    $wherePlanillado = "WHERE i.codigo = '$codigo' AND ei.inicial = 's' AND i.id NOT IN (SELECT ei1.id_investigacion FROM estado_investigaciones ei1 WHERE ei1.estado = 11 AND ei1.usuario=77) AND NOT EXISTS (SELECT NULL FROM investigaciones_cuenta_analista aa WHERE i.id = aa.id_investigacion)";
    $whereInforme = "WHERE NOT EXISTS (SELECT NULL FROM investigaciones_cuenta_analista aa WHERE ei.id_investigacion = aa.id_investigacion AND aa.origen != 1) AND ei.id_investigacion > 50000 AND i.codigo = '$codigo' AND ei.estado = 11";
  }else{
    
    $whereInforme = "WHERE NOT EXISTS (SELECT NULL FROM investigaciones_cuenta_analista aa WHERE ei.id_investigacion = aa.id_investigacion AND aa.origen != 1) AND ei.id_investigacion > 70000 AND ei.usuario=$idAnalista AND ei.estado = 11";

    if($fechaLimite != ''){ 
      $wherePlanillado = "WHERE ei.usuario = 77 AND ei.inicial = 's' AND i.id NOT IN (SELECT ei1.id_investigacion FROM estado_investigaciones ei1 WHERE date_format(i.fecha, '%Y-%m-%d') <= '".$fechaLimite."' AND  ei1.estado = 11 AND ei1.usuario=77) AND NOT EXISTS (SELECT NULL FROM investigaciones_cuenta_analista aa WHERE i.id = aa.id_investigacion)";
      $whereInforme .= " AND date_format(ei.fecha, '%Y-%m-%d') BETWEEN '2021-11-30' AND '".$fechaLimite."'";
    }else{
      $wherePlanillado = "WHERE ei.usuario = 77 AND ei.inicial = 's' AND i.id NOT IN (SELECT ei1.id_investigacion FROM estado_investigaciones ei1 WHERE ei1.estado = 11 AND ei1.usuario=77) AND NOT EXISTS (SELECT NULL FROM investigaciones_cuenta_analista aa WHERE i.id = aa.id_investigacion)";
      $whereInforme .= " AND date_format(ei.fecha, '%Y-%m-%d') >= '2021-12-01'";
    }

    if($idAseguradora != '' && $idAseguradora != '0'){ 
      $wherePlanillado .= " AND i.id_aseguradora = ".$idAseguradora;
      $whereJoinInv = "i.id_aseguradora = ".$idAseguradora;
    }

    if($tipoCaso != '' && $tipoCaso != '0'){ 
      $wherePlanillado .= " AND i.tipo_caso = ".$tipoCaso;
      if($whereJoinInv != ''){
        $whereJoinInv .= " AND i.tipo_caso = ".$tipoCaso;
      }else{
        $whereJoinInv = "i.tipo_caso = ".$tipoCaso;
      }
    }
  }

  $consultaCasosInv = "SELECT 'INFORME' AS origen, i.id, i.codigo, i.id_aseguradora, j.nombre_corto AS aseguradora, i.tipo_caso, l.descripcion2 AS tipoCaso, CONCAT(c.nombres, ' ', c.apellidos) AS lesionado, b.resultado as id_resultado, b.indicador_fraude, mi.ruta, ei.fecha
  FROM estado_investigaciones ei
  JOIN investigaciones i ON i.id = ei.id_investigacion $whereJoinInv
  JOIN multimedia_investigacion mi ON mi.id_investigacion = ei.id_investigacion AND mi.id_multimedia = 9 AND mi.ruta != '' 
  LEFT JOIN personas_investigaciones_soat b ON b.tipo_persona = 1 AND b.id_investigacion = ei.id_investigacion
  LEFT JOIN personas c ON c.id = b.id_persona
  LEFT JOIN aseguradoras j ON j.id = i.id_aseguradora
  LEFT JOIN definicion_tipos l ON l.id = i.tipo_caso AND l.id_tipo = 8
  $whereInforme";

  $queryConsultaPendAnalista=mysqli_query($con,$consultaCasosInv);
  while ($repCasosInv=mysqli_fetch_array($queryConsultaPendAnalista,MYSQLI_ASSOC)){

    $botonInforme = '<a type="button" class="btn btn-block btn-default btn-sm" title="No Tiene Informe"><span class="fa fa-file-pdf-o"></span></a>';

    if ($repCasosInv["ruta"]!= ""){
      global $rutaArchivos;
      $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$repCasosInv["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#304f6f;"><span class="fa fa-file-pdf-o"></span></a>';
    }

    if ($repCasosInv["indicador_fraude"] == 13 || $repCasosInv["id_resultado"] == 3){
      $repCasosInv["id_resultado"] = 3;
      $repCasosInv["resultado"] = 'OCURRENCIA';
      $cantAtender++;
    }else{
      if($repCasosInv["id_resultado"] == 2){
        $repCasosInv["resultado"] = 'NO ATENDER';
        $cantPositivos++; 
      }else{
        $repCasosInv["resultado"] = 'ATENDER';
        $cantAtender++;
      }
    }

    $data[]=array("id"=>$repCasosInv["id"],
      "opciones"=>'
      <button onclick="agregarFila(this, '.$repCasosInv["id"].')" type="button" class="btn btn-danger btn-block btn-sm" style="background-color:#9e174f;" ><span class="fa fa-upload"></span></button>'.$botonInforme,
      "marcar"=>'<input value="'.$repCasosInv["id"].'" class="checkCasos chequeos" id="check'.$repCasosInv["id"].'" type="checkbox"/><label for="check'.$repCasosInv["id"].'"></label>',
      "codigo"=>$repCasosInv["codigo"],
      "origen"=>$repCasosInv["origen"],
      "id_aseguradora"=>$repCasosInv["id_aseguradora"],
      "aseguradora"=>$repCasosInv["aseguradora"],
      "tipo_caso"=>$repCasosInv["tipo_caso"],
      "tipoCaso"=>$repCasosInv["tipoCaso"],
      "fecha"=>$repCasosInv["fecha"],
      "lesionado"=>$repCasosInv["lesionado"],
      "id_resultado"=>$repCasosInv["id_resultado"],
      "resultado"=>$repCasosInv["resultado"]
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function verCasosCuentaCobroAna($idAnalista, $periodo, $numero){

  global $con;
  $data=array();
  $sqlCabecera="SELECT a.id, DATE_FORMAT(a.periodo,'%Y-%m') as periodo, a.numero, CONCAT(m.nombres, ' ', m.apellidos) AS analista , a.estado, a.cantidad_investigaciones, a.valor_descuento, a.valor_adicional, a.valor_total, a.fecha, a.fecha_cerrada, a.observacion FROM cuenta_cobro_analista a 
  LEFT JOIN usuarios m ON m.id = a.id_analista WHERE a.periodo = '$periodo' AND a.numero = $numero AND a.id_analista = $idAnalista";

  $analista = "";
  $estado = 0;
  $cuenta = 0;
  $totalCasos = 0;
  $valorAdicional = 0;
  $valorGuardado = 0;
  $valorDescuento = 0;
  $fecha = "";
  $fechaCerrada = "";
  $observacion = "";

  $queryCabecera=mysqli_query($con,$sqlCabecera);
  if(mysqli_num_rows($queryCabecera) > 0){
    $respCabecera = mysqli_fetch_array($queryCabecera,MYSQLI_ASSOC);
    $cuenta = $respCabecera["id"];
    $analista = $respCabecera["analista"];
    $estado = $respCabecera["estado"];
    $valorDescuento = $respCabecera["valor_descuento"];
    $valorAdicional = $respCabecera["valor_adicional"];
    $valorGuardado = $respCabecera["valor_total"];
    $fecha = $respCabecera["fecha"];
    $fechaCerrada = $respCabecera["fecha_cerrada"];
    $observacion = $respCabecera["observacion"];
  }

  $consultaCasosAna = "SELECT d.id_cuenta_cobro, a.id, a.codigo, a.id_aseguradora, j.nombre_corto AS aseguradora, a.tipo_caso, l.descripcion2 AS tipoCasoCorto, l.descripcion3 AS tipoCasoTarifa,  l.descripcion AS tipoCaso, f.fecha_accidente, CONCAT(c.nombres, ' ', c.apellidos) AS lesionado, if(l.descripcion3 IN(11,12), 0, b.resultado) as id_resultado, b.indicador_fraude, d.valor_pagado, d.id_tarifa, mi.ruta, d.origen, IF(d.origen = 0, 'INFORME', 'PLANILLADO') AS origen_lt
    FROM investigaciones_cuenta_analista d
    LEFT JOIN investigaciones a ON a.id = d.id_investigacion
    LEFT JOIN personas_investigaciones_soat b ON b.id_investigacion = d.id_investigacion AND b.tipo_persona = 1
    LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
    LEFT JOIN aseguradoras j ON j.id = a.id_aseguradora
    LEFT JOIN detalle_investigaciones_soat f ON f.id_investigacion = b.id_investigacion
    LEFT JOIN personas c ON b.id_persona = c.id
    LEFT JOIN definicion_tipos l ON l.id_tipo = 8 AND l.id = a.tipo_caso
    WHERE mi.id_multimedia = 9 AND d.id_cuenta_cobro = $cuenta ORDER BY a.tipo_caso, a.id;";

  $queryVerCasosCuentaInv=mysqli_query($con,$consultaCasosAna);

  $cantPositivos=0; $cantAtender=0;

  while ($repCasosAna=mysqli_fetch_array($queryVerCasosCuentaInv,MYSQLI_ASSOC)){

    if ($repCasosAna["indicador_fraude"] == 13 || $repCasosAna["id_resultado"] == 3){
      $repCasosAna["id_resultado"] = 3;
      $repCasosAna["resultado"] = 'OCURRENCIA';
      $cantAtender++;
    }else{
      if($repCasosAna["id_resultado"] == 2){
        $repCasosAna["resultado"] = 'NO ATENDER';
        $cantPositivos++; 
      }else{
        $repCasosAna["resultado"] = 'ATENDER';
        $cantAtender++;
      }
    }

    $disabled = '';
    if($estado < 2 && $repCasosAna["valor_pagado"] < 1500){

      if ($repCasosAna["ruta"] != ""){
        $sqlValorv="SELECT id, valor, descripcion FROM (
        SELECT 1 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = ".$repCasosAna['id_resultado']." AND id_aseguradora = ".$repCasosAna["id_aseguradora"]." AND id_tipo_caso = ".$repCasosAna["tipoCasoTarifa"]." UNION
        SELECT 2 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = 0 AND id_aseguradora = ".$repCasosAna["id_aseguradora"]." AND id_tipo_caso = ".$repCasosAna["tipoCasoTarifa"]." UNION
        SELECT 3 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = ".$repCasosAna['id_resultado']." AND id_aseguradora = ".$repCasosAna["id_aseguradora"]." AND id_tipo_caso = 0 UNION
        SELECT 4 AS prioridad, id, descripcion, id_aseguradora, id_tipo_caso, id_departamento, id_tipo_zona, id_resultado, valor FROM tarifas WHERE id_tipo = 2 AND id_clase = 2 AND id_resultado = 0 AND id_aseguradora = ".$repCasosAna["id_aseguradora"]." AND id_tipo_caso = 0) cte ORDER BY prioridad ASC LIMIT 1";
        $queryValor=mysqli_query($con,$sqlValorv);

        $id_tarifa = 0;   $valorCaso = 0;

        if(mysqli_num_rows($queryValor) > 0){
          $respValor = mysqli_fetch_array($queryValor,MYSQLI_ASSOC);

          if($repCasosAna["id_aseguradora"] == 1){
            $sqlSiPlanillado="SELECT id_investigacion FROM investigaciones_cuenta_analista WHERE origen = 1 AND id_investigacion = ".$repCasosAna["id"];
            $querySiPlanillado=mysqli_query($con,$sqlSiPlanillado);
            
            if(mysqli_num_rows($querySiPlanillado) > 0){
              $disabled = 'disabled="disabled" title="Se cobró como Planillado"';
              if($repCasosAna["id_resultado"] == 2){
                $valorCaso = 6000;
              }else{
                $valorCaso = 5000;
              }
              $repCasosAna["origen_lt"] = 'PLN-INF';
              $id_tarifa = $respValor["id"];
            }else{
              $valorCaso = $respValor["valor"];
              $id_tarifa = $respValor["id"];
            }
          }else{
            $valorCaso = $respValor["valor"];
            $id_tarifa = $respValor["id"];
          }
        }else{
          $valorCaso = 2000;
          $id_tarifa = 319;
        }

        $totalCasos=$totalCasos+$valorCaso;
      }else{
        $valorCaso = 2000;
        $id_tarifa = 319;
        $totalCasos=$totalCasos+$valorCaso;
      }
                        
    }else{
      $valorCaso = $repCasosAna["valor_pagado"];
      $totalCasos=$totalCasos+$valorCaso;
      $id_tarifa = $repCasosAna["id_tarifa"];
    }

    $classBtnEliminar = 'btn-warning';

    if($estado == 2){
      $classBtnEliminar = 'btn-default';
      $disabled = 'disabled="disabled"';
    }

    $botonInforme = '<a type="button" class="btn btn-block btn-default btn-sm" title="No Tiene Informe"><span class="fa fa-file-pdf-o"></span></a>';

    if ($repCasosAna["ruta"]!= ""){
      global $rutaArchivos;
      $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$repCasosAna["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#762929;"><span class="fa fa-file-pdf-o"></span></a>';
    }

    $data[]=array("id"=>$repCasosAna["id"],
      "opciones"=>'
      <button '.$disabled.' onclick="eliminarFilaCuentaAna(this, '.$repCasosAna["id"].', '.$repCasosAna["id_cuenta_cobro"].', '.$repCasosAna["origen"].')" type="button" class="btn btn-block btn-sm btns-eliminar '.$classBtnEliminar.'"><span class="fa fa-trash"></span></button>'.$botonInforme,
      "codigo"=>$repCasosAna["codigo"],
      "id_aseguradora"=>$repCasosAna["id_aseguradora"],
      "aseguradora"=>$repCasosAna["aseguradora"],
      "tipo_caso"=>$repCasosAna["tipo_caso"],
      "tipoCasoCorto"=>$repCasosAna["tipoCasoCorto"],
      "tipoCasoTarifa"=>$repCasosAna["tipoCasoTarifa"],
      "fecha_accidente"=>$repCasosAna["fecha_accidente"],
      "lesionado"=>$repCasosAna["lesionado"],
      "resultado"=>$repCasosAna["resultado"],
      "id_resultado"=>$repCasosAna["id_resultado"],
      "origen_lt"=>$repCasosAna["origen_lt"],
      "valor"=>'<input '.$disabled.' value="'.$valorCaso.'" onblur="calcularTotalesVerCuentaAna();" class="valorCasos" name="valorCasos[]" id="'.$repCasosAna["id"].'" type="number"> <input class="tarifaCasos" name="tarifaCasos[]" value="'.$id_tarifa.'" type="hidden"> <input class="idCasos" name="idCasos[]" value="'.$repCasosAna["id"].'" type="hidden"> <input class="origenCasos" name="origenCasos[]" value="'.$repCasosAna["origen"].'" type="hidden">'
    );
  }

  $totales = array(
    "totalCasos" => intval($totalCasos),
    "cantAtender" => intval($cantAtender),
    "cantPositivos" => intval($cantPositivos),
    "valorDescuento" => intval($valorDescuento),
    "valorGuardado" => intval($valorGuardado),
    "valorAdicional" => intval($valorAdicional)
  );

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "cuenta" => intval($cuenta),
    "analista" => $analista,
    "periodo" => $periodo,
    "numero" => $numero,
    "estado" => intval($estado),
    "fechaCreacion" => $fecha,
    "fechaCerrada" => $fechaCerrada,
    "observacion" => $observacion,
    "aaData" => $data,
    "totales" => $totales
  );

  return json_encode($results); 
}

function verGrupoCuentaCobroAnalista($periodoCuentaAna, $numPerCuentaAna, $analistaCuentaAna, $estadoCuentaAna, $numeroCuentaAna){

  global $con;
  $data=array();

  $where = "";
  if($periodoCuentaAna != ''){
    $where = "WHERE a.periodo = '$periodoCuentaAna' AND a.numero = '$numPerCuentaAna'";
  }
  if($analistaCuentaAna != ''){
    if($where != ""){
      $where .= " AND a.id_analista = $analistaCuentaAna";
    }else{
      $where = "WHERE a.id_analista = $analistaCuentaAna";
    }
  }
  if($estadoCuentaAna != ''){
    if($where != ""){
      $where .= " AND a.estado = $estadoCuentaAna";
    }else{
      $where = "WHERE a.estado = $estadoCuentaAna";
    }
  }
  if($numeroCuentaAna != ''){
    if($where != ""){
      $where .= " AND a.id = $numeroCuentaAna";
    }else{
      $where = "WHERE a.id = $numeroCuentaAna";
    }
  }

  $consultaCuentas="SELECT a.id, YEAR(a.periodo) AS anio, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENE' WHEN MONTH(a.periodo) = 2 THEN 'FEB' WHEN MONTH(a.periodo) = 3 THEN 'MAR' WHEN MONTH(a.periodo) = 4 THEN 'ABR' WHEN MONTH(a.periodo) = 5 THEN 'MAY' WHEN MONTH(a.periodo) = 6 THEN 'JUN' WHEN MONTH(a.periodo) = 7 THEN 'JUL' WHEN MONTH(a.periodo) = 8 THEN 'AGO' WHEN MONTH(a.periodo) = 9 THEN 'SEP' WHEN MONTH(a.periodo) = 10 THEN 'OCT' WHEN MONTH(a.periodo) = 11 THEN 'NOV' WHEN MONTH(a.periodo) = 12 THEN 'DIC' END AS nomMes, CONCAT(m.nombres, ' ', m.apellidos) AS analista, a.estado, a.cantidad_investigaciones, a.valor_investigaciones, a.valor_descuento, a.valor_adicional, a.valor_total, a.fecha, a.fecha_cerrada, a.observacion
      FROM cuenta_cobro_analista a
      LEFT JOIN usuarios m ON m.id = a.id_analista
      $where";

  $analista = "";
  $estado = 0;
  $cuenta = 0;
  $totalCasos = 0;
  $valorAdicional = 0;
  $valorDescuento = 0;
  $fecha = "";
  $fechaCerrada = "";
  $observacion = "";

  $queryVerGrupoCuentaAna=mysqli_query($con,$consultaCuentas);
  while ($repCuentasAna=mysqli_fetch_array($queryVerGrupoCuentaAna,MYSQLI_ASSOC)){
    if($repCuentasAna["estado"] == 1){
      $estado = '<span class="label label-primary">ENVIADA</span>';
    }else if($repCuentasAna["estado"] == 2){
      $estado = '<span class="label label-danger">CERRADA</span>';
    }else{      
      $estado = '<span class="label label-success">ABIERTA</span>';
    }

    $data[]=array("id"=>$repCuentasAna["id"],
      "marcar"=>'<input value="'.$repCuentasAna["id"].'" class="checkCasos chequeos" id="check'.$repCuentasAna["id"].'" type="checkbox"/><label for="check'.$repCuentasAna["id"].'"></label>',
      "periodo"=>$repCuentasAna["numero"]."-".$repCuentasAna["nomMes"]."-".$repCuentasAna["anio"],
      "analista"=>$repCuentasAna["analista"],
      "estado"=>$estado,
      "total_inv"=>$repCuentasAna["cantidad_investigaciones"],
      "subtotal"=>$repCuentasAna["valor_investigaciones"],
      "adicional"=>$repCuentasAna["valor_adicional"],
      "descuento"=>$repCuentasAna["valor_descuento"],
      "total_cuenta"=>$repCuentasAna["valor_total"]
    );
  }

  $totales = array(
    "totalCuentas" => intval($totalCasos)
  );

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data,
    "totales" => $totales
  );

  return json_encode($results); 
}

function buscarDenuncias($idAseguradora, $tipoCaso, $fechaLimite){

  global $con;
  $data=array(); 
  
  $whereDen_1 = "";
  $whereDen_2 = "";
  $whereDen_3 = "";

  if($tipoCaso != '' && $tipoCaso != '0'){ 
    $whereDen_1 .= " AND i.tipo_caso = ".$tipoCaso;
    $whereDen_2 .= " AND i.tipo_caso = ".$tipoCaso;
  }
  if($fechaLimite != ''){
    $whereDen_1 .= " AND i.fecha_entrega <= '".$fechaLimite."'";
    $whereDen_2 .= " AND DATE_FORMAT(i.fecha, '%Y-%m-%d') <= '".$fechaLimite."'";
  }

  if($tipoCaso != '2'){
    $whereDen_3 = " AND i.tipo_caso IN (3,4,5,6,9,10,13,14)";
  }
  
  $ConsultaDenuncias = "";
  $ConsultaDenuncias .= "SELECT i.id, tc.descripcion AS tipo_caso, i.codigo, DATE_FORMAT(dis.fecha_accidente, '%Y-%m-%d') AS fecha_accidente, v.placa, p.numero AS poliza, d.nombre AS departamento_ips, ips.nombre_ips, ips.identificacion AS nit_ips, tid.descripcion AS tipo_identificacion, pr.identificacion, CONCAT(pr.nombres,' ',pr.apellidos) AS lesionado, tid1.descripcion AS tipo_identificacion1, p.identificacion_tomador, p.nombre_tomador, p.direccion_tomador, c1.nombre AS ciudad_tomador, p.telefono_tomador, ind.descripcion AS indicador_fraude, mi.ruta
    FROM investigaciones i
    LEFT JOIN definicion_tipos tc ON tc.id = i.tipo_caso
    LEFT JOIN detalle_investigaciones_soat dis ON dis.id_investigacion = i.id
    LEFT JOIN polizas p ON p.id = dis.id_poliza
    LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
    LEFT JOIN personas_investigaciones_soat pis ON pis.id_investigacion = i.id
    LEFT JOIN ips ON ips.id = pis.ips
    LEFT JOIN ciudades c ON c.id = ips.ciudad
    LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = i.id AND mi.id_multimedia = 9
    LEFT JOIN departamentos d ON d.id = c.id_departamento
    LEFT JOIN personas pr ON pr.id = pis.id_persona
    LEFT JOIN definicion_tipos tid ON tid.id = pr.tipo_identificacion
    LEFT JOIN definicion_tipos tid1 ON tid1.id = p.tipo_identificacion_tomador
    LEFT JOIN ciudades c1 ON c1.id = p.ciudad_tomador
    LEFT JOIN definicion_tipos ind ON ind.id = pis.indicador_fraude
    WHERE i.id > 77000 AND i.tipo_solicitud = 1
    AND pis.tipo_persona = 1 AND tc.id_tipo = 8 AND tid.id_tipo = 5 AND tid1.id_tipo = 5 AND ind.id_tipo = 12
    AND pis.resultado = 2 AND pis.indicador_fraude IN (3,23)    
    AND i.id_aseguradora = $idAseguradora
    $whereDen_3
    AND i.denuncia = 0
    $whereDen_1 ";

    if($tipoCaso == '1'){
      $ConsultaDenuncias .= " UNION 

      SELECT i.id, tc.descripcion AS tipo_caso, i.codigo, DATE_FORMAT(dis.fecha_accidente, '%Y-%m-%d') AS fecha_accidente, v.placa, p.numero AS poliza, d.nombre AS departamento_ips, ips.nombre_ips, ips.identificacion AS nit_ips, tid.descripcion AS tipo_identificacion, pr.identificacion, CONCAT(pr.nombres,' ',pr.apellidos) AS lesionado, tid1.descripcion AS tipo_identificacion1, p.identificacion_tomador, p.nombre_tomador, p.direccion_tomador, c1.nombre AS ciudad_tomador, p.telefono_tomador, ind.descripcion AS indicador_fraude, mi.ruta
      FROM investigaciones i
      LEFT JOIN definicion_tipos tc ON tc.id = i.tipo_caso
      LEFT JOIN detalle_investigaciones_soat dis ON dis.id_investigacion = i.id
      LEFT JOIN polizas p ON p.id = dis.id_poliza
      LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
      LEFT JOIN personas_investigaciones_soat pis ON pis.id_investigacion = i.id
      LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = i.id AND mi.id_multimedia = 9
      LEFT JOIN ips ON ips.id = pis.ips
      LEFT JOIN ciudades c ON c.id = ips.ciudad
      LEFT JOIN departamentos d ON d.id = c.id_departamento
      LEFT JOIN personas pr ON pr.id = pis.id_persona
      LEFT JOIN definicion_tipos tid ON tid.id = pr.tipo_identificacion
      LEFT JOIN definicion_tipos tid1 ON tid1.id = p.tipo_identificacion_tomador
      LEFT JOIN ciudades c1 ON c1.id = p.ciudad_tomador
      LEFT JOIN definicion_tipos ind ON ind.id = pis.indicador_fraude
      WHERE i.id > 77000 AND i.tipo_solicitud = 1
      AND pis.tipo_persona = 1 AND tc.id_tipo = 8 AND tid.id_tipo = 5 AND tid1.id_tipo = 5 AND ind.id_tipo = 12 AND i.tipo_caso NOT IN (7,8)
      AND pis.resultado = 2 AND pis.indicador_fraude IN (3,23)
      AND i.id_aseguradora = $idAseguradora 
      AND i.tipo_caso = 1
      AND i.denuncia = 0
      $whereDen_2 ";
    }


    /*$ConsultaDenuncias .= ")SELECT * FROM denuncias GROUP BY id ORDER BY tipo_caso, id;";*/

  $queryConsultaDenuncias=mysqli_query($con,$ConsultaDenuncias);

  while ($resDenuncias=mysqli_fetch_array($queryConsultaDenuncias,MYSQLI_ASSOC)){
    
    $botonInforme = '<a type="button" class="btn btn-block btn-default btn-sm" title="No Tiene Informe"><span class="fa fa-file-pdf-o"></span></a>';

    if ($resDenuncias["ruta"]!= ""){
      global $rutaArchivos;
      $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$resDenuncias["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#762929;"><span class="fa fa-file-pdf-o"></span></a>';
    }
  
    $data[]=array(
      "opciones"=>$botonInforme.'<button onclick="denunciarInvest(this, '.$resDenuncias["id"].')" type="button" class="btn btn-block btn-primary"><span class="fa fa-gavel"></span></button> 
                                  <button onclick="noDenunciarInvest(this, '.$resDenuncias["id"].')" type="button" class="btn btn-block btn-warning"><span class="fa fa-close"></span></button>',
      "tipo_caso"=>$resDenuncias["tipo_caso"],
      "codigo"=>$resDenuncias["codigo"],
      "fecha_accidente"=>$resDenuncias["fecha_accidente"],
      "placa"=>$resDenuncias["placa"],
      "poliza"=>$resDenuncias["poliza"],
      "departamento_ips"=>$resDenuncias["departamento_ips"],
      "nombre_ips"=>$resDenuncias["nombre_ips"],
      "nit_ips"=>$resDenuncias["nit_ips"],
      "tipo_id_lesionado"=>$resDenuncias["tipo_identificacion"],
      "identificacion"=>$resDenuncias["identificacion"],
      "lesionado"=>$resDenuncias["lesionado"],
      "tipo_id_tomador"=>$resDenuncias["tipo_identificacion1"],
      "identificacion_tomador"=>$resDenuncias["identificacion_tomador"],
      "nombre_tomador"=>$resDenuncias["nombre_tomador"],
      "direccion_tomador"=>$resDenuncias["direccion_tomador"],
      "ciudad_tomador"=>$resDenuncias["ciudad_tomador"],
      "telefono_tomador"=>$resDenuncias["telefono_tomador"],
      "indicador_fraude"=>$resDenuncias["indicador_fraude"]
    );
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function consultaDenuncias($idAseguradora, $dpto, $ips, $indicador, $fechaInicio, $fechaFin, $agrupar){

  global $con;
  $data=array(); 

  if($agrupar == 1){
    $ConsultaDenuncias = "SELECT i.id, tc.descripcion AS tipo_caso, i.codigo, DATE_FORMAT(dis.fecha_accidente, '%Y-%m-%d') AS fecha_accidente, v.placa, p.numero AS poliza, d.nombre AS departamento_ips, ips.nombre_ips, ips.identificacion AS nit_ips, tid.descripcion AS tipo_identificacion, pr.identificacion, CONCAT(pr.nombres,' ',pr.apellidos) AS lesionado, tid1.descripcion AS tipo_identificacion1, p.identificacion_tomador, p.nombre_tomador, p.direccion_tomador, c1.nombre AS ciudad_tomador, p.telefono_tomador, ind.descripcion AS indicador_fraude, mi.ruta
      FROM denuncias de
      JOIN investigaciones i ON i.id = de.id_investigacion
      LEFT JOIN definicion_tipos tc ON tc.id = i.tipo_caso AND tc.id_tipo = 8
      JOIN detalle_investigaciones_soat dis ON dis.id_investigacion = de.id_investigacion
      LEFT JOIN polizas p ON p.id = dis.id_poliza
      LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
      JOIN personas_investigaciones_soat pis ON pis.id_investigacion = de.id_investigacion
      LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = de.id_investigacion AND mi.id_multimedia = 9
      LEFT JOIN ips ON ips.id = pis.ips
      LEFT JOIN ciudades c ON c.id = ips.ciudad
      LEFT JOIN departamentos d ON d.id = c.id_departamento
      LEFT JOIN personas pr ON pr.id = pis.id_persona
      LEFT JOIN definicion_tipos tid ON tid.id = pr.tipo_identificacion AND tid.id_tipo = 5
      LEFT JOIN definicion_tipos tid1 ON tid1.id = p.tipo_identificacion_tomador AND tid1.id_tipo = 5
      LEFT JOIN ciudades c1 ON c1.id = p.ciudad_tomador
      JOIN definicion_tipos ind ON ind.id_tipo = 12 and ind.id = pis.indicador_fraude
      WHERE pis.tipo_persona = 1 AND i.id_aseguradora = $idAseguradora AND de.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

    if($dpto != ''){ $ConsultaDenuncias .= " AND c.id_departamento = $dpto"; }
    if($ips != ''){ $ConsultaDenuncias .= " AND pis.ips = $ips"; }
    if($indicador != ''){ $ConsultaDenuncias .= " AND pis.indicador_fraude = $indicador"; }
  
  }else if($agrupar == 2){

    $ConsultaDenuncias = "SELECT ind.descripcion AS indicador_fraude, count(i.id) AS cant
      FROM denuncias de
      JOIN investigaciones i ON i.id = de.id_investigacion
      LEFT JOIN definicion_tipos tc ON tc.id = i.tipo_caso AND tc.id_tipo = 8
      JOIN personas_investigaciones_soat pis ON pis.id_investigacion = de.id_investigacion
      LEFT JOIN definicion_tipos ind ON ind.id_tipo = 12 AND ind.id = pis.indicador_fraude
      WHERE pis.tipo_persona = 1 AND i.id_aseguradora = $idAseguradora AND de.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
      GROUP BY pis.indicador_fraude";

  }else if($agrupar == 3){

    $ConsultaDenuncias = "SELECT COUNT(i.id) AS cant, d.nombre AS departamento_ips, ips.nombre_ips, ips.identificacion AS nit_ips, ind.descripcion AS indicador_fraude
      FROM denuncias de
      JOIN investigaciones i ON i.id = de.id_investigacion
      JOIN personas_investigaciones_soat pis ON pis.id_investigacion = de.id_investigacion
      LEFT JOIN ips ON ips.id = pis.ips
      LEFT JOIN ciudades c ON c.id = ips.ciudad
      LEFT JOIN departamentos d ON d.id = c.id_departamento
      LEFT JOIN definicion_tipos ind ON ind.id_tipo = 12 AND ind.id = pis.indicador_fraude
      WHERE pis.tipo_persona = 1 AND i.id_aseguradora = $idAseguradora AND de.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
      GROUP BY pis.ips, pis.indicador_fraude
      ORDER BY ips.nombre_ips, COUNT(i.id) DESC;";

  }else if($agrupar == 4){

    $ConsultaDenuncias = "SELECT COUNT(i.id) AS cant, d.nombre AS departamento_ips, ind.descripcion AS indicador_fraude
      FROM denuncias de
      JOIN investigaciones i ON i.id = de.id_investigacion
      JOIN personas_investigaciones_soat pis ON pis.id_investigacion = de.id_investigacion
      LEFT JOIN ips ON ips.id = pis.ips
      LEFT JOIN ciudades c ON c.id = ips.ciudad
      LEFT JOIN departamentos d ON d.id = c.id_departamento
      LEFT JOIN definicion_tipos ind ON ind.id_tipo = 12 AND ind.id = pis.indicador_fraude
      WHERE pis.tipo_persona = 1 AND i.id_aseguradora = $idAseguradora AND de.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
      GROUP BY c.id_departamento, pis.indicador_fraude
      ORDER BY d.nombre, COUNT(i.id) DESC;";
  }

  $queryConsultaDenuncias=mysqli_query($con, $ConsultaDenuncias);
  while ($resDenuncias=mysqli_fetch_array($queryConsultaDenuncias,MYSQLI_ASSOC)){

    if($agrupar == 1){

      $botonInforme = '<a type="button" class="btn btn-block btn-default btn-sm" title="No Tiene Informe"><span class="fa fa-file-pdf-o"></span></a>';

      if ($resDenuncias["ruta"]!= ""){
        global $rutaArchivos;
        $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$resDenuncias["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#762929;"><span class="fa fa-file-pdf-o"></span></a>';
      }

      $data[]=array(
        "opciones"=>$botonInforme,
        "tipo_caso"=>$resDenuncias["tipo_caso"],
        "codigo"=>$resDenuncias["codigo"],
        "fecha_accidente"=>$resDenuncias["fecha_accidente"],
        "placa"=>$resDenuncias["placa"],
        "poliza"=>$resDenuncias["poliza"],
        "departamento_ips"=>$resDenuncias["departamento_ips"],
        "nombre_ips"=>$resDenuncias["nombre_ips"],
        "nit_ips"=>$resDenuncias["nit_ips"],
        "tipo_id_lesionado"=>$resDenuncias["tipo_identificacion"],
        "identificacion"=>$resDenuncias["identificacion"],
        "lesionado"=>$resDenuncias["lesionado"],
        "tipo_id_tomador"=>$resDenuncias["tipo_identificacion1"],
        "identificacion_tomador"=>$resDenuncias["identificacion_tomador"],
        "nombre_tomador"=>$resDenuncias["nombre_tomador"],
        "direccion_tomador"=>$resDenuncias["direccion_tomador"],
        "ciudad_tomador"=>$resDenuncias["ciudad_tomador"],
        "telefono_tomador"=>$resDenuncias["telefono_tomador"],
        "indicador_fraude"=>$resDenuncias["indicador_fraude"]
      );
    }else if($agrupar == 2){

      $data[]=array(
        "indicador_fraude"=>$resDenuncias["indicador_fraude"],
        "cant"=>$resDenuncias["cant"]
      );
    }else if($agrupar == 3){

      $data[]=array(
        "departamento_ips"=>$resDenuncias["departamento_ips"],
        "nombre_ips"=>$resDenuncias["nombre_ips"],
        "nit_ips"=>$resDenuncias["nit_ips"],
        "indicador_fraude"=>$resDenuncias["indicador_fraude"],
        "cant"=>$resDenuncias["cant"]
      );
    }else if($agrupar == 4){

      $data[]=array(
        "departamento_ips"=>$resDenuncias["departamento_ips"],
        "indicador_fraude"=>$resDenuncias["indicador_fraude"],
        "cant"=>$resDenuncias["cant"]
      );
    }
  }

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );

  return json_encode($results); 
}

function verFactura($factura){

  global $con;
  $data=array();

  $sqlCabecera="SELECT a.id, a.periodo, a.id_tipo_caso, a.id_aseguradora, m.nombre_corto, a.fecha, a.observacion
    FROM facturas a
    LEFT JOIN aseguradoras m ON m.id = a.id_aseguradora ";


  if($factura != ""){
     $sqlCabecera.="WHERE a.id = $factura";
  }else{
     $sqlCabecera.="WHERE a.periodo = '$periodo' AND a.id_aseguradora = $id_aseguradora";
  }

  $analista = "";
  $estado = 0;
  $totalCasos = 0;
  $valorAdicional = 0;
  $valorDescuento = 0;
  $id_tipo_caso = 0;
  $fecha = "";
  $periodo = "";
  $observacion = "";

  $queryCabecera=mysqli_query($con,$sqlCabecera);
  if(mysqli_num_rows($queryCabecera) > 0){
    $respCabecera = mysqli_fetch_array($queryCabecera,MYSQLI_ASSOC);
    $factura = $respCabecera["id"];
    $analista = $respCabecera["nombre_corto"];
    $estado = 1;
    $valorDescuento = 0;
    $id_tipo_caso = $respCabecera["id_tipo_caso"];
    $valorAdicional = 0;
    $fecha = $respCabecera["fecha"];
    $periodo = $respCabecera["periodo"];
    $observacion = $respCabecera["observacion"];
  }

  /*$consultaCasosFac = "SELECT a.id, a.codigo, a.tipo_caso, l.descripcion2 AS tipoCasoCorto,  f.fecha_accidente, b.resultado as id_resultado, b.indicador_fraude, e.descripcion AS tipologia,  d.facturado, if(d.motivo_rechazo IS NULL, '', d.motivo_rechazo) AS motivo_rechazo, mi.ruta, '' AS placa
    FROM investigaciones_facturas d
    LEFT JOIN investigaciones a ON a.id = d.id_investigacion
    LEFT JOIN personas_investigaciones_soat b ON b.id_investigacion = d.id_investigacion AND b.tipo_persona = 1
    LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
    LEFT JOIN aseguradoras j ON j.id = a.id_aseguradora
    LEFT JOIN detalle_investigaciones_soat f ON f.id_investigacion = b.id_investigacion
    LEFT JOIN definicion_tipos e ON b.indicador_fraude = e.id AND e.id_tipo = 12
    LEFT JOIN definicion_tipos l ON l.id_tipo = 8 AND l.id = a.tipo_caso
    WHERE mi.id_multimedia = 9 AND d.id_factura = $factura ORDER BY a.tipo_caso, a.id;";*/

  $consultaCasosFac = "";

  if($id_tipo_caso == 3 || $id_tipo_caso == 4){//muerte e incapacidad 
    $consultaCasosFac = "SELECT i.id, i.codigo, DATE_FORMAT(di.`fecha_accidente`,'%Y-%m-%d') AS fecha_accidente, v.`placa`, p.`numero` AS poliza,ia.identificador, d.`nombre` AS departamento, tid.`descripcion` AS tipo_identificacion,pr.`identificacion`,CONCAT(pr.`nombres`,' ',pr.`apellidos`) AS nombre_lesionado,CASE WHEN pinv.`resultado`=1 THEN 'CUBIERTO' ELSE 'NO CUBIERTO' END AS resultado,ind.`descripcion` AS indicador_fraude,
        tz.`descripcion` AS perimetro,i.`fecha_inicio`,i.fecha_cargue,
        CASE WHEN di.`fecha_cambio_estado` IS NULL THEN 'NO' ELSE 'SI' END AS cambio_estado,
        CASE WHEN di.`fecha_cambio_estado` IS NULL THEN 'NO APLICA' ELSE di.fecha_cambio_estado END AS fecha_cambio_estado,  ifa.facturado, if(ifa.motivo_rechazo IS NULL, '', ifa.motivo_rechazo) AS motivo_rechazo, mi.ruta, pinv.resultado AS id_resultado
        FROM investigaciones i
        LEFT JOIN detalle_investigaciones_soat di ON i.id=di.`id_investigacion`
        LEFT JOIN polizas p ON p.id=di.`id_poliza`
        LEFT JOIN vehiculos v ON v.id=p.`id_vehiculo`
        LEFT JOIN personas_investigaciones_soat pinv ON pinv.`id_investigacion`=i.id
        LEFT JOIN personas pr ON pr.id=pinv.`id_persona`
        LEFT JOIN definicion_tipos tid ON tid.id=pr.`tipo_identificacion`
        LEFT JOIN definicion_tipos ind ON ind.id=pinv.indicador_fraude
        LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = i.id
        LEFT JOIN ips ip ON ip.id=pinv.`ips`
        LEFT JOIN investigaciones_facturas ifa ON ifa.`id_investigacion`=i.id
        LEFT JOIN ciudades c ON c.id=di.`ciudad_ocurrencia`
        LEFT JOIN departamentos d ON d.id=c.`id_departamento`
        LEFT JOIN id_casos_aseguradora ia ON ia.`id_investigacion`=i.id
        LEFT JOIN definicion_tipos tz ON tz.id=di.`tipo_zona`
        WHERE pinv.`tipo_persona`=1 AND tid.id_tipo=5 AND ind.id_tipo=12 AND ifa.`id_factura`=$factura AND tz.`id_tipo`=11
        GROUP BY ifa.id_investigacion
        ORDER BY i.tipo_caso, ifa.id_investigacion;";
  }else if($id_tipo_caso == 5){ //Validaciones
    $consultaCasosFac = "SELECT i.codigo, d.nombre AS departamento, di.nombre_entidad, di.identificacion_entidad, i.fecha_inicio, i.fecha_cargue, mi.ruta, ifa.facturado, if(ifa.motivo_rechazo IS NULL, '', ifa.motivo_rechazo) AS motivo_rechazo
      FROM investigaciones i
      LEFT JOIN detalle_investigaciones_validaciones di ON i.id=di.`id_investigacion`
      LEFT JOIN investigaciones_facturas ifa ON ifa.`id_investigacion`=i.id
      LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = i.id
      LEFT JOIN ciudades c ON c.id=di.ciudad_entidad
      LEFT JOIN departamentos d ON d.id=c.`id_departamento`
      WHERE ifa.`id_factura`=$factura
      GROUP BY ifa.id_investigacion
      ORDER BY i.tipo_caso, ifa.id_investigacion;";
  }else{ //Censos gastos medicos y demas
    $consultaCasosFac = "SELECT IF(a.id_tipo_auditoria = 1, 'DECLARACIÓN', 'AUD TELEFONICA') AS tipoa, l.descripcion2 AS tipoCasoCorto, l.descripcion AS tipoCasoLargo, a.tipo_caso, a.id, a.codigo, date_format(f.fecha_accidente, '%Y-%m-%d') AS fecha_accidente, v.placa, p.numero AS poliza, dep.nombre AS departamento_ips, ips.nombre_ips, ips.identificacion AS nit_ips, ia.identificador, ti.descripcion AS tipo_identificacion, pe.identificacion, CONCAT(pe.nombres, ' ', pe.apellidos) AS nombre_lesionado, IF(b.resultado = 1, 'CUBIERTO', 'NO CUBIERTO') AS resultado, e.descripcion AS tipologia, tz.descripcion AS perimetro, a.fecha_inicio, a.fecha_entrega,
      CASE WHEN (SELECT MIN(date_format(cc.fecha, '%Y-%m-%d')) FROM control_cargue cc WHERE cc.id_investigacion = a.id ) IS NULL then  a.fecha_cargue ELSE (SELECT MIN(date_format(cc.fecha, '%Y-%m-%d')) FROM control_cargue cc WHERE cc.id_investigacion = a.id ) END fecha_cargue,
      CASE WHEN f.fecha_cambio_estado IS NULL THEN 'NO' ELSE 'SI' END AS cambio_estado, CASE WHEN f.fecha_cambio_estado IS NULL THEN 'NO APLICA' ELSE f.fecha_cambio_estado END AS fecha_cambio_estado, b.resultado AS id_resultado, b.indicador_fraude,  d.facturado, if(d.motivo_rechazo IS NULL, '', d.motivo_rechazo) AS motivo_rechazo, mi.ruta
      FROM investigaciones_facturas d
      LEFT JOIN investigaciones a ON a.id = d.id_investigacion
      LEFT JOIN personas_investigaciones_soat b ON b.id_investigacion = d.id_investigacion AND b.tipo_persona = 1
      LEFT JOIN multimedia_investigacion mi ON mi.id_investigacion = a.id
      LEFT JOIN aseguradoras j ON j.id = a.id_aseguradora
      LEFT JOIN detalle_investigaciones_soat f ON f.id_investigacion = b.id_investigacion
      LEFT JOIN definicion_tipos e ON b.indicador_fraude = e.id AND e.id_tipo = 12
      LEFT JOIN definicion_tipos l ON l.id_tipo = 8 AND l.id = a.tipo_caso
      LEFT JOIN polizas p ON p.id = f.id_poliza
      LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
      LEFT JOIN ips ON ips.id = b.ips
      LEFT JOIN ciudades c ON c.id = ips.ciudad
      LEFT JOIN departamentos dep ON dep.id = c.id_departamento
      LEFT JOIN id_casos_aseguradora ia ON ia.id_investigacion = a.id
      LEFT JOIN personas pe ON pe.id = b.id_persona
      LEFT JOIN definicion_tipos ti ON ti.id_tipo = 5 AND ti.id = pe.tipo_identificacion
      LEFT JOIN definicion_tipos tz ON tz.id = f.tipo_zona AND tz.id_tipo = 11
      WHERE mi.id_multimedia = 9 AND d.id_factura = $factura
      ORDER BY a.tipo_caso, a.id;";
  }

  $queryVerCasosfacturaInv=mysqli_query($con, $consultaCasosFac);

  $cantPositivos=0; $cantAtender=0;

  while ($repCasosFac=mysqli_fetch_array($queryVerCasosfacturaInv,MYSQLI_ASSOC)){

    if($id_tipo_caso != 5){

      if ($repCasosFac["indicador_fraude"] == 13 || $repCasosFac["id_resultado"] == 3){
        $repCasosFac["id_resultado"] = 3;
        $repCasosFac["resultado"] = 'OCURRENCIA';
        $cantAtender++;
      }else{
        if($repCasosFac["id_resultado"] == 2){
          $repCasosFac["resultado"] = 'NO ATENDER';
          $cantPositivos++; 
        }else{
          $repCasosFac["resultado"] = 'ATENDER';
          $cantAtender++;
        }
      }
    }

    $disabled = '';

    $classBtnEliminar = 'btn-warning';

    if($estado == 2){
      $classBtnEliminar = 'btn-default';
      $disabled = 'disabled="disabled"';
    }

    $botonInforme = '<span title="No Tiene Informe">Sin PDF</span>';

    if ($repCasosFac["ruta"]!= ""){
      global $rutaArchivos;
      $botonInforme = '<a target="_blank" href="'.$rutaArchivos."informes/".$repCasosFac["ruta"].'?'.time().'" type="button" class="btn btn-block btn-primary btn-sm" title="Ver Informe" style="background-color:#762929;"><span class="fa fa-file-pdf-o"></span></a>';
    }

    if($repCasosFac["facturado"] == 's'){
      $repCasosFac["facturado"] = 'SI';
    }else{
      $repCasosFac["facturado"] = 'NO';
    }

    if($id_tipo_caso == 3 || $id_tipo_caso == 4){//muerte e incapacidad 

      $data[]=array(
        "id"=>$repCasosFac["id"],
        "codigo"=>$repCasosFac["codigo"],
        "fecha_accidente"=>$repCasosFac["fecha_accidente"],
        "placa"=>$repCasosFac["placa"],
        "poliza"=>$repCasosFac["poliza"],
        "departamento_ips"=>$repCasosFac["departamento"],
        "identificador"=>$repCasosFac["identificador"],
        "tipo_identificacion"=>$repCasosFac["tipo_identificacion"],
        "identificacion"=>$repCasosFac["identificacion"],
        "nombre_lesionado"=>$repCasosFac["nombre_lesionado"],
        "resultado"=>$repCasosFac["resultado"],
        "tipologia"=>$repCasosFac["indicador_fraude"],
        "perimetro"=>$repCasosFac["perimetro"],
        "fecha_inicio"=>$repCasosFac["fecha_inicio"],
        "fecha_cargue"=>$repCasosFac["fecha_cargue"],
        "cambio_estado"=>$repCasosFac["cambio_estado"],
        "fecha_cambio_estado"=>$repCasosFac["fecha_cambio_estado"],
        "facturado"=>$repCasosFac["facturado"],
        "motivo_rechazo"=>$repCasosFac["motivo_rechazo"],
        "id_resultado"=>$repCasosFac["id_resultado"],
        "informe"=>$botonInforme
      );

    }else if($id_tipo_caso == 5){//Validaciones

      $data[]=array(
        "id"=>$repCasosFac["id"],
        "codigo"=>$repCasosFac["codigo"],
        "departamento_ips"=>$repCasosFac["departamento"],
        "nombre_ips"=>$repCasosFac["nombre_entidad"],
        "nit_ips"=>$repCasosFac["identificacion_entidad"],
        "fecha_inicio"=>$repCasosFac["fecha_inicio"],
        "fecha_cargue"=>$repCasosFac["fecha_cargue"],
        "facturado"=>$repCasosFac["facturado"],
        "motivo_rechazo"=>$repCasosFac["motivo_rechazo"],
        "informe"=>$botonInforme
      );
    }else{

      $data[]=array(
        "tipoa"=>$repCasosFac["tipoa"],
        "tipoCasoCorto"=>$repCasosFac["tipoCasoCorto"],
        "tipoCasoLargo"=>$repCasosFac["tipoCasoLargo"],
        "tipo_caso"=>$repCasosFac["tipo_caso"],
        "id"=>$repCasosFac["id"],
        "codigo"=>$repCasosFac["codigo"],
        "fecha_accidente"=>$repCasosFac["fecha_accidente"],
        "placa"=>$repCasosFac["placa"],
        "poliza"=>$repCasosFac["poliza"],
        "departamento_ips"=>$repCasosFac["departamento_ips"],
        "nombre_ips"=>$repCasosFac["nombre_ips"],
        "nit_ips"=>$repCasosFac["nit_ips"],
        "identificador"=>$repCasosFac["identificador"],
        "tipo_identificacion"=>$repCasosFac["tipo_identificacion"],
        "identificacion"=>$repCasosFac["identificacion"],
        "nombre_lesionado"=>$repCasosFac["nombre_lesionado"],
        "resultado"=>$repCasosFac["resultado"],
        "tipologia"=>$repCasosFac["tipologia"],
        "perimetro"=>$repCasosFac["perimetro"],
        "fecha_inicio"=>$repCasosFac["fecha_inicio"],
        "fecha_entrega"=>$repCasosFac["fecha_entrega"],
        "fecha_cargue"=>$repCasosFac["fecha_cargue"],
        "cambio_estado"=>$repCasosFac["cambio_estado"],
        "fecha_cambio_estado"=>$repCasosFac["fecha_cambio_estado"],
        "facturado"=>$repCasosFac["facturado"],
        "motivo_rechazo"=>$repCasosFac["motivo_rechazo"],
        "resultado"=>$repCasosFac["resultado"],
        "id_resultado"=>$repCasosFac["id_resultado"],
        "informe"=>$botonInforme
      );
    }
  }

  $totales = array(
    "totalCasos" => intval($totalCasos),
    "cantAtender" => intval($cantAtender),
    "cantPositivos" => intval($cantPositivos),
    "valorDescuento" => intval($valorDescuento),
    "valorAdicional" => intval($valorAdicional)
  );

  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "factura" => intval($factura),
    "id_tipo_caso" => $id_tipo_caso,
    "analista" => $analista,
    "periodo" => $periodo,
    "estado" => intval($estado),
    "fechaCreacion" => $fecha,
    "periodo" => $periodo,
    "observacion" => $observacion,
    "aaData" => $data,
    "totales" => $totales
  );

  return json_encode($results);
}
?>