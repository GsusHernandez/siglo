<?php
include('../conexion/conexion.php');

function consultarInvestigadoresPeriodos($idPeriodo){
  global $con;
  $data=array();

  $consultaInvestigadoresPeriodos="(SELECT a.*
  FROM 
  (SELECT a.id AS id_investigador,CONCAT(a.nombres,' ',a.apellidos) AS nombre_investigador,CONCAT(b.descripcion,' ',a.identificacion) AS identificacion_investigador
  FROM investigadores a 
  LEFT JOIN definicion_tipos b ON a.tipo_identificacion=b.id 
  WHERE b.id_tipo=5 AND a.vigente='s') a
  LEFT OUTER JOIN (SELECT id_investigador FROM cuenta_cobro_investigadores WHERE id_periodo='".$idPeriodo."') b ON a.id_investigador=b.id_investigador 
  WHERE  b.id_investigador IS NULL)
  UNION
  (SELECT a.id_investigador,CONCAT(b.nombres,' ',b.apellidos) AS nombre_investigador,CONCAT(c.descripcion,' ',b.identificacion) AS identificacion_investigador 
  FROM 
  cuenta_cobro_investigadores a 
  LEFT JOIN investigadores b ON a.id_investigador=b.id 
  LEFT JOIN definicion_tipos c ON c.id=b.tipo_identificacion
  WHERE c.id_tipo=5 AND a.id_periodo='".$idPeriodo."' AND a.vigente='s')";

  $queryInvestigadoresPeriodos=mysqli_query($con,$consultaInvestigadoresPeriodos);
  while ($resInvestigadoresPeriodos=mysqli_fetch_array($queryInvestigadoresPeriodos,MYSQLI_ASSOC)){
    $data[]=array("valor"=>$resInvestigadoresPeriodos["id_investigador"],
      "descripcion"=>$resInvestigadoresPeriodos["nombre_investigador"]." - ".$resInvestigadoresPeriodos["identificacion_investigador"]); 
  }

  return json_encode($data);
}

function consultarPeriodosCuentasInv($idPeriodo){

  global $con;
  $data=array();
  $consultaPeriodosCuentaInv="SELECT a.id, YEAR(a.periodo) AS anio, a.periodo, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM cuenta_cobro_investigador a GROUP BY a.periodo, a.numero ORDER BY a.periodo DESC, a.numero DESC;";

  $queryInvestigadoresPeriodos=mysqli_query($con,$consultaPeriodosCuentaInv);
  while ($resp=mysqli_fetch_array($queryInvestigadoresPeriodos,MYSQLI_ASSOC)){
    $data[]=array("anio"=>$resp["anio"],
      "periodo"=>$resp["periodo"],
      "numero"=>$resp["numero"],
      "nomMes"=>$resp["nomMes"]);
  }

  return json_encode($data);
}

function consultarLesionadosInvestigacion($idInvestigacion){
  global $con;
  $data=array();
  $consultarLesionados="SELECT CONCAT(a.nombres,' ',a.apellidos,' - ',b.descripcion,' ',a.identificacion) as descripcion,a.id FROM personas_investigaciones_soat a LEFT JOIN personas b ON a.id_persona=b.id LEFT JOIN definicion_tipos c ON b.tipo_identificacion=c.id WHERE c.id_tipo=5 AND a.id_investigacion='".$idInvestigacion."'";

  $data[]=array("valor"=>0,
    "descripcion"=>"SELECCIONE UN VALOR");
  $queryLesionadosInvestigacion=mysqli_query($con,$consultarLesionados);
  while ($resLesionadosInvestigacion=mysqli_fetch_array($queryLesionadosInvestigacion,MYSQLI_ASSOC))
  {

    $data[]=array("valor"=>$resLesionadosInvestigacion["id"],
      "descripcion"=>$resLesionadosInvestigacion["descripcion"]); 
  }

  return json_encode($data);
}


function consultarFotografiasSalud($idInvestigacion)
{
  global $con;
  $data=array();
  $consultarFotos="SELECT id,id as descripcion FROM multimedia_investigacion WHERE id_investigacion='".$idInvestigacion."' and id_multimedia=5";

  $data[]=array("valor"=>0,
    "descripcion"=>"SELECCIONE UN VALOR");
  $queryFotos=mysqli_query($con,$consultarFotos);
  while ($resFotos=mysqli_fetch_array($queryFotos,MYSQLI_ASSOC))
  {

    $data[]=array("valor"=>$resFotos["id"],
      "descripcion"=>$resFotos["descripcion"]); 
  }
  return json_encode($data);
}


function verificarDescargaInforme($idInvestigacion, $conResultado, $aseguradora)
{
  global $con;
  $data=array();
  $consultaValidarPolizaVehiculoInformeDiligencia="SELECT 
  CASE 
  WHEN conclusiones IS NULL THEN 'N'
  WHEN conclusiones='' THEN 'N'
  ELSE  's' END AS conclusiones,
  CASE 
  WHEN punto_referencia IS NULL THEN IF(visita_lugar_hechos='N', 's','N')
  WHEN punto_referencia='' THEN IF(visita_lugar_hechos='N', 's','N')
  ELSE 's' END AS punto_referencia,
  CASE 
  WHEN furips IS NULL THEN 'N'
  WHEN furips='' THEN 'N'
  ELSE  's' END AS furips,
  CASE 
  WHEN visita_lugar_hechos IS NULL THEN 'N'
  WHEN visita_lugar_hechos='' THEN 'N'
  ELSE  's' END AS visita_lugar_hechos,
  CASE 
  WHEN registro_autoridades IS NULL THEN 'N'
  WHEN registro_autoridades='' THEN 'N'
  ELSE  's' END AS registro_autoridades,
  CASE 
  WHEN inspeccion_tecnica IS NULL THEN 'N'
  WHEN inspeccion_tecnica='' THEN 'N'
  ELSE  's' END AS inspeccion_tecnica,
  CASE 
  WHEN consulta_runt IS NULL THEN 'N'
  WHEN consulta_runt='' THEN 'N'
  ELSE  's' END AS consulta_runt,
  CASE 
  WHEN diligencia_formato_declaracion IS NULL THEN 'N'
  WHEN diligencia_formato_declaracion='' THEN 'N'
  WHEN diligencia_formato_declaracion='0' THEN 'N'
  ELSE  's' END AS diligencia_formato_declaracion,
  CASE 
  WHEN resultado_diligencia_tomador IS NULL THEN 'N'
  WHEN resultado_diligencia_tomador='' THEN 'N'
  WHEN resultado_diligencia_tomador='0' THEN 'N'
  ELSE  's' END AS resultado_diligencia_tomador,
  CASE 
  WHEN id_poliza IS NULL THEN 'N'
  WHEN id_poliza='' THEN 'N'
  WHEN id_poliza='0' THEN 'N'
  ELSE  's' END AS id_poliza
  FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."'";
  $queryValidarPolizaVehiculoInformeDiligencia=mysqli_query($con,$consultaValidarPolizaVehiculoInformeDiligencia);
  $resValidarPolizaVehiculoInformeDiligencia=mysqli_fetch_assoc($queryValidarPolizaVehiculoInformeDiligencia);
  $data["validadorPoliza"]=$resValidarPolizaVehiculoInformeDiligencia["id_poliza"];
  $data["validadorDiligenciaTomador"]=$resValidarPolizaVehiculoInformeDiligencia["resultado_diligencia_tomador"];
  $data["validadorConsultaRunt"]=$resValidarPolizaVehiculoInformeDiligencia["consulta_runt"];
  $data["validadorInspeccion"]=$resValidarPolizaVehiculoInformeDiligencia["inspeccion_tecnica"];
  $data["validadorRegistroAutoridades"]=$resValidarPolizaVehiculoInformeDiligencia["registro_autoridades"];
  $data["validadorVisitaLugarHechos"]=$resValidarPolizaVehiculoInformeDiligencia["visita_lugar_hechos"];
  $data["validadorFurips"]=$resValidarPolizaVehiculoInformeDiligencia["furips"];
  $data["validadorPuntoReferencia"]=$resValidarPolizaVehiculoInformeDiligencia["punto_referencia"];
  $data["validadorConclusiones"]=$resValidarPolizaVehiculoInformeDiligencia["conclusiones"];


  $consultaValidarLesionados="SELECT * FROM personas_investigaciones_soat WHERE tipo_persona=1 and id_investigacion='".$idInvestigacion."'";
  mysqli_next_result($con);
  $queryValidadorLesionados=mysqli_query($con,$consultaValidarLesionados);
  if (mysqli_num_rows($queryValidadorLesionados)>0){
    $data["validadorLesionados"]='S';

  }else{
    $data["validadorLesionados"]='N';
  }

  $resValidadorLesionados=mysqli_fetch_assoc($queryValidadorLesionados);

  if ($idInvestigacion > '96220') {
    $version = 1;
  }else{
    $version = 0;
  }

  $consultarTipoInforme="SELECT c.*
  FROM investigaciones a
  LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
  LEFT JOIN informe_resultado_aseguradora c ON c.id_aseguradora=a.id_aseguradora AND c.id_amparo=a.tipo_caso AND c.resultado=b.resultado
  WHERE b.tipo_persona=1 AND a.id='".$idInvestigacion."' AND version_informe = '".$version."'";
  mysqli_next_result($con);
  $queryTipoInforme=mysqli_query($con,$consultarTipoInforme);
  $resTipoInforme=mysqli_fetch_assoc($queryTipoInforme);
  $data["ruta_informe"]=$resTipoInforme["informe"]."?idInv=".$idInvestigacion."&result=".$conResultado;  

  return ($data);
}

function descargarInformesMasivo($idAseguradora,$fechaInicioDescargaInformes,$fechaFinDescargaInformes,$tipoCasoDescargaInformes,$opcionesDescargaInformes){
  global $con;
  $informe="";

  $consultarTipoCaso=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=32 and id='1'");
  $resTipoCaso=mysqli_fetch_assoc($consultarTipoCaso);
  $nombreComprimido="INFORMES ".$resTipoCaso["descripcion"]." DE ".$fechaInicioDescargaInformes." A ".$fechaFinDescargaInformes."-".rand().".zip";

  if ($tipoCasoDescargaInformes==5)
  {
    mysqli_next_result($con);
    $consultarInformes="SELECT c.ruta,a.codigo,b.nombre_entidad, CONCAT(NIT,' ',b.identificacion_entidad) as identificacion_entidad
    FROM investigaciones a
    LEFT JOIN detalle_investigaciones_validaciones b ON a.id=b.id_investigacion
    LEFT JOIN multimedia_investigacion c ON c.id_investigacion=a.id
    LEFT JOIN definicion_tipos d ON d.descripcion2=a.tipo_caso
    LEFT JOIN definicion_tipos e ON e.id=e.descripcion
    WHERE c.id_multimedia=9 and c.vigente='s' d.id_tipo=31 AND d.descripcion='".$tipoCasoDescargaInformes."' AND e.id_tipo=32 and a.id_aseguradora='".$idAseguradora."' and DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioDescargaInformes."' and '".$fechaFinDescargaInformes."' AND a.estado=1";
    $queryConsultarInformes=mysqli_query($con,$consultarInformes);
    $cont=mysqli_num_rows($queryConsultarInformes);
    if ($cont>0)
    {
      $zip = new ZipArchive();
      $zip->open("comprimidos/".$nombreComprimido,ZipArchive::CREATE);
      while ($respConsultarInformes=mysqli_fetch_assoc($queryConsultarInformes))
      {
        $nombreArchivo=$respConsultarInformes["codigo"]." ".$respConsultarInformes["nombre_entidad"]." ".$respConsultarInformes["identificacion_entidad"].".pdf";
        $zip->addFile($respConsultarInformes["ruta"],$nombreArchivo);

      }
      $zip->close();
    }
  }
  else
  {
    mysqli_next_result($con);
    $consultarInformes="SELECT a.id as idCaso,a.codigo,b.resultado,g.ruta,CONCAT(c.nombres,' ',c.apellidos) as nombre_lesionado, CONCAT(d.descripcion,' ',c.identificacion) as identificacion_lesionado
    FROM investigaciones a
    LEFT JOIN personas_investigaciones_soat b ON a.id=b.id_investigacion
    LEFT JOIN personas c ON c.id=b.id_persona
    LEFT JOIN definicion_tipos d ON d.id=c.tipo_identificacion
    LEFT JOIN definicion_tipos e ON e.descripcion2=a.tipo_caso
    LEFT JOIN definicion_tipos f ON f.id=e.descripcion
    LEFT JOIN multimedia_investigacion g ON g.id_investigacion=a.id
    WHERE b.tipo_persona=1 and g.id_multimedia=9 and g.vigente='s' and d.id_tipo=5 AND e.id_tipo=31 AND e.descripcion='".$tipoCasoDescargaInformes."' AND f.id_tipo=32 and a.id_aseguradora='".$idAseguradora."' and DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioDescargaInformes."' and '".$fechaFinDescargaInformes."' AND a.estado=1";
    if ($opcionesDescargaInformes==1 || $opcionesDescargaInformes==2)
    {
      $consultarInformes.=" AND b.resultado='".$opcionesDescargaInformes."'";     
    }

    $queryConsultarInformes=mysqli_query($con,$consultarInformes);
    $cont=mysqli_num_rows($queryConsultarInformes);
    if ($cont>0)
    {

      $zip = new ZipArchive();
      $zip->open("comprimidos/".$nombreComprimido,ZipArchive::CREATE);
      while ($respConsultarInformes=mysqli_fetch_assoc($queryConsultarInformes))
      {

        if ($respConsultarInformes["resultado"]==1)
        {
          $consultarResultado="SELECT c.descripcion2 as resultado
          FROM 
          investigaciones a
          LEFT JOIN aseguradoras b ON b.id=a.id_aseguradora
          LEFT JOIN definicion_tipos c ON b.resultado_atender=c.id
          WHERE a.id=".$respConsultarInformes["idCaso"]." AND c.id_tipo=10 AND a.estado=1";
        }
        else
        {
          $consultarResultado="SELECT c.descripcion2 as resultado
          FROM 
          investigaciones a
          LEFT JOIN aseguradoras b ON b.id=a.id_aseguradora
          LEFT JOIN definicion_tipos c ON b.resultado_no_atender=c.id
          WHERE a.id=".$respConsultarInformes["idCaso"]." AND c.id_tipo=10 AND a.estado=1";
        }
        mysqli_next_result($con);
        $queryConsultarResultado=mysqli_query($con,$consultarResultado);
        $resConsultarResultado=mysqli_fetch_assoc($queryConsultarResultado);
        $explode=explode("globalredltda.co/siglo/portal", $respConsultarInformes["ruta"]);
        $nombreArchivo=$respConsultarInformes["codigo"]." ".$respConsultarInformes["nombre_lesionado"]." ".$respConsultarInformes["identificacion_lesionado"]." ".$resConsultarResultado["resultado"].".pdf";
        $informe.=$nombreArchivo;
        $zip->addFile("..".$explode[1],$nombreArchivo);

      }
      $zip->close();
    }
  }

  $variable="";

  if ($cont>0)   {
    $variable="class/comprimidos/".$nombreComprimido;
  }else{
    $variable="NR";
  } 

  return($variable);
}

function consultarFuncionReporte($idRegistro){
  global $con;
  $data=array();
  $consultaFuncionReporte="CALL manejoAseguradoraAmparoTarifas (19,'','','','','','','','','','','".$idRegistro."','',@resp)"; 
  $queryFuncionReporte=mysqli_query($con,$consultaFuncionReporte);
  $resFuncionReporte=mysqli_fetch_array($queryFuncionReporte);
  $data["nombre_funcion"]=$resFuncionReporte["funcion_ejecutar"];
  $data["id"]=$resFuncionReporte["id"];
  return $data;
}

function consultarAutorizacion($idInvestigacion)
{
  global $con;
  $data=array();

  $consultaAutorizacion="SELECT id, CASE
  WHEN autorizacion is null then 'NR'
  ELSE autorizacion end as autorizacion,id,usuario_permiso,fecha_permiso FROM autorizacion_investigacion where id_investigacion='".$idInvestigacion."'";
  $queryAutorizacion=mysqli_query($con,$consultaAutorizacion);
  $cantidadAutorizacion=mysqli_num_rows($queryAutorizacion);
  $data["cantidad_autorizacion"]=$cantidadAutorizacion;
  if ($cantidadAutorizacion>0)
  {
    $resAutorizacion=mysqli_fetch_array($queryAutorizacion);
    $data["autorizacion"]=$resAutorizacion["autorizacion"];
  } 
  return $data;
}

function consultarParametroAmparo($idAmparo){
  global $con;
  $data=array();
  $consultaParametroAmparo="SELECT b.descripcion2 as rutaModal,a.id_aseguradora FROM aseguradora_amparo a LEFT JOIN definicion_tipos b ON a.id_tipo_facturacion=b.id WHERE b.id_tipo=9 AND a.id='".$idAmparo."'";
  $queryParametroAmparo=mysqli_query($con,$consultaParametroAmparo);
  $resParamatroAmparo=mysqli_fetch_array($queryParametroAmparo);
  $data["rutaModal"]=$resParamatroAmparo["rutaModal"];
  $data["id_aseguradora"]=$resParamatroAmparo["id_aseguradora"];
  return $data;
}

function consultarOpcion($idOpcion)
{
  global $con;
  $data=array();

  $consultaOpciones=mysqli_query($con,"SELECT * FROM opciones WHERE codigo='".$idOpcion."'");
  $resOpciones=mysqli_fetch_array($consultaOpciones);
  $data["ruta"]=$resOpciones["ruta"];
  $data["nombre"]=$resOpciones["descripcion"];
  return ($data);
}

function getRealIP(){
  $ipaddress = '';

  if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
  else
    $ipaddress = 'UNKNOWN';

  return $ipaddress;
}

function guardarLogSesion($usuario,$error){
  global $con;

  if (getRealIP()=="181.129.155.147" || getRealIP()=="190.145.174.134" || getRealIP()=="::1"){
    $server="RED LOCAL GLOBAL RED LTDA";
  }else{
    $server=getRealIP();
  }

  $ingresarLogConsulta="INSERT INTO log_sesion (fecha,id_usuario,direccion_acceso,descripcion) VALUES (CURRENT_TIMESTAMP,'".$usuario."','".$server."','".$error."')";
  if (mysqli_query($con,$ingresarLogConsulta)){
    $resultadoLogConsulta=1;
  }else{
    $resultadoLogConsulta=2;
  }

  return $resultadoLogConsulta;
}

function guardarLogErrores($usuario,$descripcion){
  global $con;

  if ($_SERVER['REMOTE_ADDR']=="::1"){
    $server="RED LOCAL GLOBAL RED LTDA";
  }else{
    $server=$_SERVER['REMOTE_ADDR'];
  }

  $ingresarLogEventosConsulta="INSERT INTO log_eventos (fecha,usuario,direccion_acceso,descripcion) VALUES (CURRENT_TIMESTAMP,'".$usuario."','".$server."','".$descripcion."')";

  if (mysqli_query($con,$ingresarLogEventosConsulta)){
    $resultadoLogEventosConsulta=1;
  }else{
    $resultadoLogEventosConsulta=2;
  }

  return $resultadoLogEventosConsulta;
}

function consultarAmparosAseguradora($idAseguradora,$tipoCasos){
  $data=array(); $data2=array(); 
  global $con;
  if ($tipoCasos=="Global"){
    $consultarAmparoAseguradora="CALL manejoAseguradoraAmparoTarifas (13,'".$idAseguradora."','','','','','','','','','','','',@resp)";
  }else if ($tipoCasos=="Asignado"){
    $consultarAmparoAseguradora="CALL manejoAseguradoraAmparoTarifas (15,'".$idAseguradora."','','','','','','','','','','','',@resp)"; 
  }else if ($tipoCasos=="Reportes"){
    $consultarAmparoAseguradora="CALL manejoAseguradoraAmparoTarifas (17,'".$idAseguradora."','','','','','','','','','','','',@resp)"; 
  }else if ($tipoCasos=="Plano"){
    $consultarAmparoAseguradora="CALL manejoAseguradoraAmparoTarifas (18,'".$idAseguradora."','','','','','','','','','','','',@resp)"; 
  }

  $data[]=array("valor"=>0,
    "descripcion"=>"SELECCIONE UN VALOR");

  if ($tipoCasos=="Reportes"){
    $data[]=array("valor"=>"t",
    "descripcion"=>"TODOS");
  }

  $queryAmparoAseguradora=mysqli_query($con,$consultarAmparoAseguradora);
  while ($resAmparoAseguradora=mysqli_fetch_array($queryAmparoAseguradora,MYSQLI_ASSOC)){
    $data[]=array("valor"=>$resAmparoAseguradora["id"],
      "descripcion"=>$resAmparoAseguradora["descripcion"]); 
  }
  $results = array(
    $data
  );
  return ($data);
}


function consultarResultadosAseguradora($idCaso){

  $data=array(); $data2=array(); 
  global $con;
  $consultarResultadoAseguradora="CALL manejoIndicadorAseguradora (6,'".$idCaso."','','','','',@resp)";

  $data[]=array("valor"=>0,
    "descripcion"=>"SELECCIONE UN VALOR");
  $queryResultadoAseguradora=mysqli_query($con,$consultarResultadoAseguradora);
  while ($resResultadoAseguradora=mysqli_fetch_array($queryResultadoAseguradora,MYSQLI_ASSOC)){


    $data[]=array("valor"=>$resResultadoAseguradora["descripcion"],
      "descripcion"=>$resResultadoAseguradora["descripcion2"]); 

  }

  $results = array(
    $data
  );
  return ($data);
}

function consultarIndicadorFraude($idCaso,$idResultado){
  $data=array(); $data2=array(); 
  global $con;
  $consultarIndicadorFraude= "CALL manejoIndicadorAseguradora (5,'".$idCaso."','','','".$idResultado."','',@resp)";

  $data[]=array(
    "valor"=>0,
    "descripcion"=>"SELECCIONE UN VALOR"
  );

  $queryIndicadorFraude=mysqli_query($con,$consultarIndicadorFraude);
  while ($resIndicadorFraude=mysqli_fetch_array($queryIndicadorFraude,MYSQLI_ASSOC)){
    $data[]=array(
      "valor"=>$resIndicadorFraude["id"],
      "descripcion"=>$resIndicadorFraude["descripcion"]
    );
  }

  $results = array(
    $data
  );
  return ($data);
}

function consultarErroresEps(){

  $fecha_inicio = $_POST["fecha_inicio"];
  $fecha_fin = $_POST["fecha_fin"];

  global $con;
  $datos =array();

  $query = "CALL consultaSQL(1,'".$fecha_inicio."','".$fecha_fin."','','','')";

  $query = mysqli_query($con,$query);
  while ($res=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $datos[]=array(
      "id"=>$res["id"],
      "id_persona"=>$res["id_persona"],
      "codigo"=>$res["codigo"],
      "eps"=>$res["eps"]
    ); 
  }
  return $datos;
}

function ActualizarEps(){

  $arrayDatos = json_decode($_POST['datos']);
  $query = "";
  global $con;

  foreach($arrayDatos as $datoPersona) {
    $query .= "UPDATE personas_investigaciones_soat p SET p.eps = '".strtoupper($datoPersona[1])."' WHERE p.id = ".$datoPersona[2]."; ";
  }

  $resultUpdate = mysqli_multi_query($con, $query);

  if($resultUpdate){
    return true;
  }else{
    return false;
  }
}

function ReportarCargueAchivoPlano(){
  global $con;
  session_start();
  $codigos = json_decode($_POST['datos']);
  $id_anterior = 0;
  $contarCargue = 0;
  $existencia = 0;
  $cargadosHoy = 0;

  foreach ($codigos as $codigo) {

    $id_investigacion = intval(preg_replace('/[^0-9]+/', '', $codigo), 10);

    if($id_investigacion != $id_anterior){
      $id_anterior = $id_investigacion;

      $validarCargue = mysqli_query($con, "SELECT * FROM control_cargue c WHERE c.id_investigacion = $id_investigacion AND DATE_FORMAT(c.fecha, '%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y-%m-%d')");

      if(mysqli_num_rows($validarCargue) == 0){

        $sql = "SELECT * FROM investigaciones i WHERE i.id =".$id_investigacion;

        $sql = mysqli_query($con, $sql);

        if(mysqli_num_rows($sql) > 0){
          $query = "INSERT INTO control_cargue (id_investigacion, fecha, id_usuario) VALUES($id_investigacion, CURRENT_TIMESTAMP(), ".$_SESSION['id'].")";

          if(mysqli_query($con, $query)){

            $query1 = "UPDATE investigaciones SET conteo_cargue = conteo_cargue + 1 WHERE id = $id_investigacion";
            if(mysqli_query($con, $query1)){
              $contarCargue++;  
            }
          }
        }else{
          $existencia++;
        }
      }else{
        $cargadosHoy++;
      }
    }
  }

  if($contarCargue > 0){
    $respuesta = array(
      "reportados" => $contarCargue,
      "existencia" => $existencia,
      "cargadosHoy" => $cargadosHoy,
      "res" => true
    );
    return $respuesta;
  }else{
    $respuesta = array(
      "reportados" => $contarCargue,
      "existencia" => $existencia,
      "cargadosHoy" => $cargadosHoy,
      "res" => false
    );
    return $respuesta;
  }
  return false;
}

function consultarReportesInvesticaciones(){
  global $con;
  session_start();
  $id_usuario = $_SESSION["id"];
  $datos =array();

  $query = "CALL consultaSQL(2,'".$id_usuario."','','','','')";

  $query = mysqli_query($con,$query);
  while ($res=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $datos[]=array(
      "codigo"=>$res["codigo"],
      "conteo_cargue"=>$res["conteo_cargue"],
      "hora"=>$res["hora"]
    );
  }
  return $datos;
}

function ConsultarOcurrenciasInicio($id_usuario, $tipo_usuario){
  global $con;
  $datos =array();
  
  if($tipo_usuario == 1){
    $respuesta = mysqli_query($con, "SELECT count(a.id) AS cantidad
      FROM investigaciones a
      WHERE a.id_usuario=".$id_usuario);

    $res=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);

    $respuesta2 = mysqli_query($con, "SELECT count(a.id) AS cantidad
    FROM investigaciones a
    LEFT JOIN multimedia_investigacion b ON a.id=b.id_investigacion
    WHERE b.id_multimedia=9 AND b.vigente='c' and a.id_usuario =".$id_usuario);

    $res2=mysqli_fetch_array($respuesta2,MYSQLI_ASSOC);

    $datos[]=array("misCasos"=>$res["cantidad"], "misCasosSinPDF"=>$res2["cantidad"]);

    return $datos;
  }else{
    return false;
  }
}

function consultarMisCasosSinPDF($id_usuario){
  global $con;
  $respuesta = mysqli_query($con, "SELECT a.id, a.tipo_caso, a.codigo, if(i.identificador IS NULL, '',i.identificador) AS identificador, if(h.placa IS NULL,'',h.placa) AS placa , if(CONCAT(f.nombres, ' ',f.apellidos) IS NULL, '', CONCAT(f.nombres, ' ',f.apellidos)) AS lesionado, b.nombre_corto as nombre_aseguradora, c.fecha_accidente, TIMESTAMPDIFF(day, DATE_FORMAT(c.fecha_accidente, '%Y-%m-%d'), DATE_FORMAT(NOW(), '%Y-%m-%d')) AS diff_accidente
    FROM investigaciones a
    left join detalle_investigaciones_soat c on a.id = c.id_investigacion
    LEFT JOIN aseguradoras b ON a.id_aseguradora = b.id
    LEFT JOIN multimedia_investigacion d ON a.id=d.id_investigacion
    left join personas_investigaciones_soat e on a.id = e.id_investigacion
    LEFT JOIN personas f ON f.id = e.id_persona
    LEFT JOIN polizas g ON g.id = c.id_poliza
    LEFT JOIN vehiculos h ON h.id = g.id_vehiculo
    LEFT JOIN id_casos_aseguradora i ON i.id_investigacion = a.id
    WHERE d.id_multimedia=9 AND d.vigente='c' AND a.id_usuario=".$id_usuario." ORDER BY a.id ASC");

  while ($res=mysqli_fetch_array($respuesta,MYSQLI_ASSOC)){
    $datos[]=array(
      "id"=>$res["id"],
      "codigo"=>$res["codigo"],
      "lesionado"=>$res["lesionado"],
      "fecha_accidente"=>$res["fecha_accidente"],
      "placa"=>$res["placa"],
      "identificador"=>$res["identificador"],
      "diff_accidente"=>$res["diff_accidente"],
      "tipo_caso"=>$res["tipo_caso"]
    );
  }
  return $datos;
}

function consultarMisCasosPendientes($id_usuario){
  global $con;
  $respuesta = mysqli_query($con, "SELECT a.id, a.tipo_caso, a.codigo, b.nombre_aseguradora, c.fecha_accidente, a.fecha_inicio, a.fecha_entrega, a.fecha_cargue, TIMESTAMPDIFF(day, DATE_FORMAT(c.fecha_accidente, '%Y-%m-%d'), DATE_FORMAT(NOW(), '%Y-%m-%d')) AS diff_accidente , TIMESTAMPDIFF(day, DATE_FORMAT(NOW(), '%Y-%m-%d'), a.fecha_entrega) AS diff_entrega, TIMESTAMPDIFF(day, DATE_FORMAT(NOW(), '%Y-%m-%d'), a.fecha_cargue) AS diff_cargue FROM investigaciones a
    left join detalle_investigaciones_soat c on a.id = c.id_investigacion
    LEFT JOIN aseguradoras b ON a.id_aseguradora = b.id
    WHERE a.id_usuario=".$id_usuario." ORDER BY fecha_cargue, fecha_entrega DESC");

  while ($res=mysqli_fetch_array($respuesta,MYSQLI_ASSOC)){
    $datos[]=array(
      "id"=>$res["id"],
      "codigo"=>$res["codigo"],
      "aseguradora"=>$res["nombre_aseguradora"],
      "fecha_accidente"=>$res["fecha_accidente"],
      "fecha_inicio"=>$res["fecha_inicio"],
      "fecha_entrega"=>$res["fecha_entrega"],
      "fecha_cargue"=>$res["fecha_cargue"],
      "diff_accidente"=>$res["diff_accidente"],
      "diff_entrega"=>$res["diff_entrega"],
      "diff_cargue"=>$res["diff_cargue"],
      "tipo_caso"=>$res["tipo_caso"]
    );
  }
  return $datos;
}

function consultarTopMayoresIncidencias($tipo_usuario){
  global $con;
  session_start();
  $ano = date("Y");
  if ($tipo_usuario == 4) {
    $where = " AND p.id_aseguradora = ".$_SESSION['id_aseguradora'];  
  }else{
    $where = " ";
  }

  $sqlPlaca = "SELECT v.placa, COUNT(v.id) AS cantidad
  FROM detalle_investigaciones_soat di
  LEFT JOIN investigaciones i ON i.id = di.id_investigacion
  LEFT JOIN polizas p ON p.id = di.id_poliza
  LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
  WHERE DATE_FORMAT(i.fecha, '%Y') = '$ano' $where
  GROUP BY v.id
  ORDER BY COUNT(v.id) DESC 
  LIMIT 10";

  $respuestaPlaca = mysqli_query($con, $sqlPlaca);

  while ($resPlaca=mysqli_fetch_array($respuestaPlaca,MYSQLI_ASSOC)){
    $placas[]=array(
      "placa"=>$resPlaca["placa"],
      "casos"=>$resPlaca["cantidad"]
    );
  }

  $sqlMarca = "SELECT tv.descripcion AS tipo_vehiculo,v.marca, v.modelo, COUNT(v.id) AS cantidad
  FROM detalle_investigaciones_soat di
  LEFT JOIN investigaciones i ON i.id = di.id_investigacion
  LEFT JOIN polizas p ON p.id = di.id_poliza
  LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
  LEFT JOIN tipo_vehiculos tv ON tv.id = v.tipo_vehiculo
  WHERE DATE_FORMAT(i.fecha, '%Y') = '$ano' AND v.marca <> '0' $where
  GROUP BY v.tipo_vehiculo, v.marca, v.modelo
  ORDER BY COUNT(v.id) DESC 
  LIMIT 10";

  $respuestaMarcas = mysqli_query($con, $sqlMarca);

  while ($resMarca=mysqli_fetch_array($respuestaMarcas,MYSQLI_ASSOC)){
    $marcas[]=array(
      "tipo_vehiculo"=>$resMarca["tipo_vehiculo"],
      "marca"=>$resMarca["marca"],
      "modelo"=>$resMarca["modelo"],
      "casos"=>$resMarca["cantidad"]
    );
  }

  $sqlPersona = "SELECT CONCAT(p.nombres,' ',p.apellidos) AS nombre, COUNT(p.id) AS cantidad
  FROM personas_investigaciones_soat ps";

  $sqlPersona .= " LEFT JOIN investigaciones i on i.id = ps.id_investigacion
  LEFT JOIN personas p ON p.id = ps.id_persona
  WHERE ps.tipo_persona = 1 AND p.tipo_identificacion IS NOT NULL AND DATE_FORMAT(i.fecha, '%Y') = '$ano'";

  if ($tipo_usuario == 4) {
    $sqlPersona .= " AND i.id_aseguradora = ".$_SESSION['id_aseguradora']; 
  }

  $sqlPersona .= " GROUP BY p.id
  ORDER BY COUNT(p.id) DESC
  LIMIT 10";

  $respuestaPersonas = mysqli_query($con, $sqlPersona);

  while ($resPersona=mysqli_fetch_array($respuestaPersonas,MYSQLI_ASSOC)){
    $personas[]=array(
      "persona"=>$resPersona["nombre"],
      "casos"=>$resPersona["cantidad"]
    );
  }

  $datos[]=array(
    "placas"=>$placas,
    "marcas"=>$marcas,
    "personas"=>$personas
  );

  return $datos;
}

function ConsultarTipoCasoProcesoJuridico ($aseguradora) {

    global $con;

    $consultarTipoCaso = "SELECT t.id, t.descripcion FROM aseguradora_amparo a LEFT JOIN tipo_caso t ON t.id = a.id_amparo WHERE a.id_aseguradora = ".$aseguradora;

    $consultarTipoCaso = mysqli_query($con,$consultarTipoCaso);

    while ($res = mysqli_fetch_array($consultarTipoCaso,MYSQLI_ASSOC)){

      $data[]=array(
        "id"=>$res["id"],
        "descripcion"=>$res["descripcion"]
      ); 
    }

    return $data;
  }

  function consultarPersonaPJ ($identificacion, $selectpjTipoId) {

    global $con;
    $data =array();
    $consultarPersona = "SELECT * FROM personas p WHERE p.identificacion = '$identificacion' AND p.tipo_identificacion = ".$selectpjTipoId;

    $consultarPersona = mysqli_query($con,$consultarPersona);

    while ($res = mysqli_fetch_array($consultarPersona,MYSQLI_ASSOC)){
      $data[]=array(
        "id"=>$res["id"],
        "nombres"=>$res["nombres"],
        "apellidos"=>$res["apellidos"]
      );
    }

    return $data;
  }

  

function consultarPeriodosCuentasAna($id_usuario){

  global $con;
  $data=array();
  $consultaPeriodosCuentaInv="SELECT a.id, YEAR(a.periodo) AS anio, a.periodo, a.numero, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM cuenta_cobro_analista a WHERE a.id_analista = $id_usuario GROUP BY a.periodo, a.numero ORDER BY a.periodo DESC, a.numero DESC";

  $queryInvestigadoresPeriodos=mysqli_query($con,$consultaPeriodosCuentaInv);
  while ($resp=mysqli_fetch_array($queryInvestigadoresPeriodos,MYSQLI_ASSOC)){
    $data[]=array("anio"=>$resp["anio"],
      "periodo"=>$resp["periodo"],
      "numero"=>$resp["numero"],
      "nomMes"=>$resp["nomMes"]);
  }

  return json_encode($data);
}

function ConsultarDatosMensuales(){

  global $con;
  $data=array();
  $mes = date("Y-m");
  $consultaOcurrenciasNoConfirmadas = "WITH cte AS (
    SELECT i.id_aseguradora,a.nombre_corto,  COUNT(i.id) AS casos, sum(if(pis.indicador_fraude = 13, 1,0)) AS ocurrencias
    FROM investigaciones i
    LEFT JOIN personas_investigaciones_soat pis ON pis.id_investigacion = i.id
    LEFT JOIN aseguradoras a ON a.id = i.id_aseguradora
    WHERE pis.tipo_persona = 1 AND DATE_FORMAT(i.fecha_entrega, '%Y-%m') = '$mes' AND i.tipo_caso NOT IN (1)
    GROUP BY i.id_aseguradora
    UNION 
    SELECT i.id_aseguradora,a.nombre_corto, COUNT(i.id) AS casos, sum(if(pis.indicador_fraude = 13, 1,0)) AS ocurrencias
    FROM investigaciones i
    LEFT JOIN personas_investigaciones_soat pis ON pis.id_investigacion = i.id
    LEFT JOIN aseguradoras a ON a.id = i.id_aseguradora
    WHERE pis.tipo_persona = 1 AND DATE_FORMAT(i.fecha, '%Y-%m') = '$mes' AND i.tipo_caso IN (1)
    GROUP BY i.id_aseguradora)
    SELECT id_aseguradora, nombre_corto, SUM(casos) AS casos, SUM(ocurrencias) AS ocurrencias
    FROM cte
    GROUP BY id_aseguradora
    ORDER BY SUM(casos) DESC";

  $queryOcurrenciasNoConfirmadas=mysqli_query($con,$consultaOcurrenciasNoConfirmadas);
  while ($resp=mysqli_fetch_array($queryOcurrenciasNoConfirmadas,MYSQLI_ASSOC)){
    $data[]=array(
      "id_aseguradora"=>$resp["id_aseguradora"],
      "aseguradora"=>$resp["nombre_corto"],
      "cantCasos"=>$resp["casos"],
      "cantOcurrencias"=>$resp["ocurrencias"]
    );
  }
  return json_encode($data);
}

function consultarOcurrenciasAseguradoras($id_aseguradora){
  global $con;
  $data=array();
  $mes=date("Y-m");
  $consultaOcurrenciasAseguradoras = "WITH cte AS (
    SELECT a.nombre_corto AS aseguradora,d.nombre AS departamento, COUNT(i.id) AS total, SUM(if(pis.indicador_fraude = 13, 1,0)) AS ocurrencias
    FROM investigaciones i
    left JOIN personas_investigaciones_soat pis ON pis.id_investigacion = i.id
    LEFT JOIN ips ON ips.id = pis.ips
    LEFT JOIN ciudades c ON c.id = ips.ciudad
    LEFT JOIN departamentos d ON d.id = c.id_departamento
    LEFT JOIN aseguradoras a ON a.id = i.id_aseguradora
    WHERE DATE_FORMAT(i.fecha_entrega, '%Y-%m') = '$mes' AND tipo_persona = 1 AND i.id_aseguradora = $id_aseguradora AND i.tipo_caso NOT IN (1)
    GROUP BY d.id
    UNION 
    SELECT a.nombre_corto AS aseguradora,d.nombre AS departamento, COUNT(i.id) AS total, SUM(if(pis.indicador_fraude = 13, 1,0)) AS ocurrencias
    FROM investigaciones i
    left JOIN personas_investigaciones_soat pis ON pis.id_investigacion = i.id
    LEFT JOIN ips ON ips.id = pis.ips
    LEFT JOIN ciudades c ON c.id = ips.ciudad
    LEFT JOIN departamentos d ON d.id = c.id_departamento
    LEFT JOIN aseguradoras a ON a.id = i.id_aseguradora
    WHERE DATE_FORMAT(i.fecha, '%Y-%m') = '$mes' AND tipo_persona = 1 AND i.id_aseguradora = $id_aseguradora AND i.tipo_caso = 1
    GROUP BY d.id)
    SELECT aseguradora, departamento, SUM(total) AS total, SUM(ocurrencias) AS ocurrencias
    FROM cte
    GROUP BY departamento
    ORDER BY SUM(ocurrencias) DESC";

  $queryOcurrenciasAseguradora = mysqli_query($con,$consultaOcurrenciasAseguradoras);
  while ($resp=mysqli_fetch_array($queryOcurrenciasAseguradora,MYSQLI_ASSOC)){
    $data[]=array(
      "aseguradora"=>$resp["aseguradora"],
      "departamento"=>$resp["departamento"],
      "total"=>$resp["total"],
      "ocurrencias"=>$resp["ocurrencias"]
    );
  }
  return json_encode($data);
}

function consultarPeriodosFacturas($id_aseguradora){

  global $con;
  $data=array();
  $consultaPeriodosCuentaInv="SELECT a.id, YEAR(a.periodo) AS anio, a.periodo, CASE WHEN MONTH(a.periodo) = 1 THEN 'ENERO' WHEN MONTH(a.periodo) = 2 THEN 'FEBRERO' WHEN MONTH(a.periodo) = 3 THEN 'MARZO' WHEN MONTH(a.periodo) = 4 THEN 'ABRIL' WHEN MONTH(a.periodo) = 5 THEN 'MAYO' WHEN MONTH(a.periodo) = 6 THEN 'JUNIO' WHEN MONTH(a.periodo) = 7 THEN 'JULIO' WHEN MONTH(a.periodo) = 8 THEN 'AGOSTO' WHEN MONTH(a.periodo) = 9 THEN 'SEPTIEMBRE' WHEN MONTH(a.periodo) = 10 THEN 'OCTUBRE' WHEN MONTH(a.periodo) = 11 THEN 'NOVIEMBRE' WHEN MONTH(a.periodo) = 12 THEN 'DICIEMBRE' END AS nomMes, a.periodo FROM facturas a WHERE a.id_aseguradora = $id_aseguradora  AND YEAR(a.periodo) > '2021' GROUP BY a.periodo ORDER BY a.id DESC;";

  $queryInvestigadoresPeriodos=mysqli_query($con,$consultaPeriodosCuentaInv);
  while ($resp=mysqli_fetch_array($queryInvestigadoresPeriodos,MYSQLI_ASSOC)){
    $data[]=array("periodo"=>$resp["periodo"], "nomMes"=>$resp["nomMes"]." ".$resp["anio"]);
  }

  return json_encode($data);
}

function consultarNombreFacturas($periodo, $id_aseguradora){

  global $con;
  $data=array();
  $consultaObsFacturas="SELECT a.id, if(a.id_tipo_caso = 0, a.observacion, b.descripcion) AS observacion FROM facturas a LEFT JOIN definicion_tipos b ON b.id = a.id_tipo_caso AND b.id_tipo = 32 WHERE a.periodo = '$periodo' AND a.id_aseguradora = $id_aseguradora ORDER BY a.id DESC;";

  $queryFacObs=mysqli_query($con,$consultaObsFacturas);
  while ($resp=mysqli_fetch_array($queryFacObs,MYSQLI_ASSOC)){
    $data[]=array("id"=>$resp["id"], "observacion" => $resp["observacion"]);
  }

  return json_encode($data);
}
