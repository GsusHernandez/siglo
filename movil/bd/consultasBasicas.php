<?php
include('../conexion/conexion.php');



function descargarInformesMasivo($idAseguradora,$fechaInicioDescargaInformes,$fechaFinDescargaInformes,$tipoCasoDescargaInformes,$opcionesDescargaInformes)
{
   global $con;
   $zip = new ZipArchive();
   $consultarTipoCaso=mysqli_query($con,"SELECT * FROM definicion_tipos WHERE id_tipo=32 and id='".$tipoCasoDescargaInformes."'");
   $resTipoCaso=mysqli_fetch_assoc($consultarTipoCaso);
   $nombreComprimido="INFORMES ".$resTipoCaso["descripcion"]."DE ".$fechaInicioDescargaInformes." A ".$fechaFinDescargaInformes.".zip";
   $zip->open($nombreComprimido,ZipArchive::CREATE);

   if ($tipoCasoDescargaInformes==5)
   {
    mysqli_next_result($con);
      $consultarInformes="SELECT c.ruta,a.codigo,b.nombre_entidad, CONCAT(NIT,' ',b.identificacion_entidad) as identificacion_entidad
      FROM investigaciones a
      LEFT JOIN detalle_investigaciones_validaciones b ON a.id=b.id_investigacion
      LEFT JOIN multimedia_investigacion c ON c.id_investigacion=a.id
      LEFT JOIN definicion_tipos d ON d.descripcion2=a.tipo_caso
      LEFT JOIN definicion_tipos e ON e.id=e.descripcion
      WHERE c.id_multimedia=9 and c.vigente='s' d.id_tipo=31 AND d.descripcion='".$tipoCasoDescargaInformes."' AND e.id_tipo=32 and a.id_aseguradora='".$idAseguradora."' and DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioDescargaInformes."' and '".$fechaFinDescargaInformes."'";
      $queryConsultarInformes=mysqli_query($con,$consultarInformes);
      while ($respConsultarInformes=mysqli_fetch_assoc($queryConsultarInformes))
      {
        $nombreArchivo=$respConsultarInformes["codigo"]." ".$respConsultarInformes["nombre_entidad"]." ".$respConsultarInformes["identificacion_entidad"].".pdf";
        $zip->addFile($respConsultarInformes["ruta"],$nombreArchivo);

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
      WHERE b.tipo_persona=1 and g.id_multimedia=9 and g.vigente='s' and d.id_tipo=5 AND e.id_tipo=31 AND e.descripcion='".$tipoCasoDescargaInformes."' AND f.id_tipo=32 and a.id_aseguradora='".$idAseguradora."' and DATE_FORMAT(a.fecha, '%Y-%m-%d') BETWEEN '".$fechaInicioDescargaInformes."' and '".$fechaFinDescargaInformes."'";
      if ($opcionesDescargaInformes==1 || $opcionesDescargaInformes==2)
      {
        $consultarInformes.=" AND b.resultado='".$opcionesDescargaInformes."'";     
      }
      $queryConsultarInformes=mysqli_query($con,$consultarInformes);
      while ($respConsultarInformes=mysqli_fetch_assoc($queryConsultarInformes))
      {
        if ($respConsultarInformes["resultado"]==1)
        {
          $consultarResultado="SELECT c.descripcion2 as resultado
          FROM 
          investigaciones a
          LEFT JOIN aseguradoras b ON b.id=a.id_aseguradora
          LEFT JOIN definicion_tipos c ON b.resultado_atender=c.id
          WHERE a.id=".$respConsultarInformes["idCaso"]." AND c.id_tipo=10";
        }
        else
        {
          $consultarResultado="SELECT c.descripcion2 as resultado
          FROM 
          investigaciones a
          LEFT JOIN aseguradoras b ON b.id=a.id_aseguradora
          LEFT JOIN definicion_tipos c ON b.resultado_no_atender=c.id
          WHERE a.id=".$respConsultarInformes["idCaso"]." AND c.id_tipo=10";
        }
        mysqli_next_result($con);
        $queryConsultarResultado=mysqli_query($con,$consultarResultado);
        $resConsultarResultado=mysqli_fetch_assoc($queryConsultarResultado);

        $nombreArchivo=$respConsultarInformes["codigo"]." ".$respConsultarInformes["nombre_lesionado"]." ".$respConsultarInformes["identificacion_lesionado"]." ".$resConsultarResultado["resultado"].".pdf";
        $zip->addFile($respConsultarInformes["ruta"],$nombreArchivo);

      }
   }
   $zip->close();
   header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=".$nombreComprimido);
  readfile("'".$nombreComprimido."'");
  unlink("'".$nombreComprimido."'");
    
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


function guardarLogSesion($usuario,$error){
     global $con;
if ($_SERVER['REMOTE_ADDR']=="::1"){
    $server="RED LOCAL GLOBAL RED LTDA";
  }else{
    $server=$_SERVER['REMOTE_ADDR'];
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
    $queryAmparoAseguradora=mysqli_query($con,$consultarAmparoAseguradora);
     while ($resAmparoAseguradora=mysqli_fetch_array($queryAmparoAseguradora,MYSQLI_ASSOC))
     {

       $data[]=array("valor"=>$resAmparoAseguradora["id"],
                  "descripcion"=>$resAmparoAseguradora["descripcion"]); 
      }

     
      
   $results = array(
        $data
        );
        return ($data);
        
    
    
  
  }


  function consultarResultadosAseguradora($idCaso)
  {
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

   
    $data[]=array("valor"=>0,
                  "descripcion"=>"SELECCIONE UN VALOR");
  $queryIndicadorFraude=mysqli_query($con,$consultarIndicadorFraude);
      while ($resIndicadorFraude=mysqli_fetch_array($queryIndicadorFraude,MYSQLI_ASSOC)){

     
       $data[]=array("valor"=>$resIndicadorFraude["id"],
                  "descripcion"=>$resIndicadorFraude["descripcion"]); 

      }

    
  
      
      
      
 $results = array(
      $data
      );
      return ($data);
      
    
  }

?>