<?php 

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include('../conexion/conexion.php');
include ('../plugins/mailer/send.php');
include '../plugins/ExcelReader/Classes/PHPExcel/IOFactory.php'; //Agregamos la librería 

ini_set('max_execution_time', 0);
set_time_limit(0);


function subirConsolidadoAsignarInvestigadoresMundialMok($arcConsolidadoMultimedia,$idUsuario,$fechaEntrega){
  global $con;
  $data=array();
  $rutaSup="/var/www/html/siglo/portal/";
  //$rutaSup="c:/wamp64/www/siglo/portal/";
  $ruta="plugins/ExcelReader/".$arcConsolidadoMultimedia['name'];
  $ejemplo="";

  if(is_dir("../data")){
    if (move_uploaded_file($arcConsolidadoMultimedia['tmp_name'], "../".$ruta)) {
    
    $inputFileType = PHPExcel_IOFactory::identify($rutaSup.$ruta);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($rutaSup.$ruta);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();
    $cont=1;$cont2=0;
    for ($row = 2; $row <= $highestRow; $row++)
    { 
       $fecha_entrega = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("AE".$row)->getValue())) ) );


      $fecha_asignacion = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("AB".$row)->getValue())) ) );
      
      $fecha_accidente = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("AC".$row)->getValue())) ) );

      $asignado="2";
      //if (($sheet->getCell("Z".$row)->getValue()=="Gastos de transporte y movilización")){
      //  $asignado="4";
      //}
      //else if (($sheet->getCell("Z".$row)->getValue()=="Gastos médicos")){
      //  $asignado="4";
      //}
      

      //if($sheet->getCell("V".$row)->getValue() != ""){
        //$cadenaMotivo = str_replace(";",",",$sheet->getCell("V".$row)->getValue()); 
      //}else{
       // $cadenaMotivo = '';
      //}


      $nombresLesionado=$sheet->getCell("J".$row)->getValue();
      $tipoIdentificacion=$sheet->getCell("L".$row)->getValue();
      $identificacion=$sheet->getCell("K".$row)->getValue();
      $radicado=$sheet->getCell("A".$row)->getValue();
      $placa=$sheet->getCell("Y".$row)->getValue();
      $poliza=$sheet->getCell("V".$row)->getValue();
      $investigador=$sheet->getCell("AD".$row)->getValue();
      //$no_caso=$sheet->getCell("A".$row)->getValue();

      $insertarCasoSOATAsignacion = "CALL manejoInvestigacionesSOAT (12,'".$asignado."','1', '".$fecha_accidente."', '2', '', '','".$investigador."','','".$radicado."','".$fecha_asignacion."','".$fecha_entrega."','".$idUsuario."','','','','','','','','','',@resp,@resp2,@resp3)";
      $ejemplo.=$insertarCasoSOATAsignacion;
      mysqli_next_result($con);
      if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {

        $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
        $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

        $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
        $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
        $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  

        if ($respuesta["respuesta"]==1)
        {
          $rutaFinal="data/soportes_asignacion_analistas/".$radicado.".pdf";

          mysqli_next_result($con);
          $consultaSubirSoporte="CALL manejoMultimediaInvestigaciones (11,'https://globalredltda.co/siglo".$rutaFinal."','".$respuesta["caso"]."','','','".$idUsuario."',@resp)";
          mysqli_query($con,$consultaSubirSoporte);
          $consultaRespuestaSubirSoporte=mysqli_query($con,"SELECT @resp as resp");
          $respSubirSoporte=mysqli_fetch_assoc($consultaRespuestaSubirSoporte);

          mysqli_next_result($con);
          $insertarPersonas = "CALL manejoPersonas (5,'".$nombresLesionado."', '".$tipoIdentificacion."', '', '', '', '', '','','','','".$identificacion."','','".$idUsuario."',@resp)";
          mysqli_query($con,$insertarPersonas);
          $consultaRespuestaInsertarPersonas=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarPersonas=mysqli_fetch_assoc($consultaRespuestaInsertarPersonas);

          mysqli_next_result($con);
          $consultaInsertarLesionadoPrincipal="CALL manejoLesionadosSOAT(15,'".$respInsertarPersonas["resp"]."', '', '', '', '', '', '','','','','','','','','','','','','". $respuesta["caso"]."','','','','','','".$idUsuario."',@resp)";
          mysqli_query($con,$consultaInsertarLesionadoPrincipal);
          $consultaRespuestaInsertarLesionado=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarLesionados=mysqli_fetch_assoc($consultaRespuestaInsertarLesionado);

          mysqli_next_result($con);
          $insertarVehiculo = "CALL manejoVehiculo (6,'', '".$placa."', '', '', '', '', '', '','','','','','".$idUsuario."',@resp,@resp2)";
          mysqli_query($con,$insertarVehiculo);
          $consultaRespuestaInsertarVehiculo=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
          $respInsertarVehiculo=mysqli_fetch_assoc($consultaRespuestaInsertarVehiculo);

          mysqli_next_result($con);
          $insertarPoliza = "CALL manejoPolizas (6,'".$poliza."', '', '', '', '', '', '', '','','','','','','".$respInsertarVehiculo["resp2"]."','".$respuesta["caso"]."','','".$idUsuario."',@resp)";
          mysqli_query($con,$insertarPoliza);
          $consultaRespuestaInsertarPoliza=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarPoliza=mysqli_fetch_assoc($consultaRespuestaInsertarPoliza);


          mysqli_next_result($con);
          $consultaInformacionInvestigador="CALL manejoInvestigadores(5,'','','','','','','','".$investigador."','','','','','',@resp)"; 
          $queryInvestigador=mysqli_query($con,$consultaInformacionInvestigador);
          $respInvestigador=mysqli_fetch_assoc($queryInvestigador);

          if (enviarEmail($respuesta["caso"],"3")==1){
            $respuestaEnviarEmail="CORREO ENVIADO";  
          }else{
            $respuestaEnviarEmail="ERROR AL ENVIAR CORREO";
          }

          $data[]=array("codigo"=>$respuesta["codigo"],
            "radicado"=>$radicado,
            "investigador"=>$respInvestigador["nombres"]." ".$respInvestigador["apellidos"],
            "respuesta_email"=>$respuestaEnviarEmail);
        }else if ($respuesta["respuesta"]==2){
          $data[]=array("codigo"=>"NO REGISTRA",
            "radicado"=>$radicado,
            "investigador"=>"NO REGISTRA",
            "respuesta_email"=>"CASO NO CREADO POR ERROR EN TIPO DE CASO");
        }else if ($respuesta["respuesta"]==3){
          $data[]=array("codigo"=>"NO REGISTRA",
            "radicado"=>$radicado,
            "investigador"=>"NO REGISTRA",
            "respuesta_email"=>"CASO YA EXISTE");
        }

      }
      else
      {
        $respuesta["respuesta"]=2;
      }
    }
    }
  }
  unlink($rutaSup.$ruta);
  
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($data);
}





function asignarInvestigadorCuentaCobro($idInvestigador,$periodoAsignar,$tipoAuditoriaAsignar,$resultadoAsignar,$tipoZonaAsignar,$tipoCasoAsignar,$idCaso,$idUsuario)

{
  global $con;
  $consultaAsignarInvestigadorCuentaCobro="CALL manejoCuentasCobroInvestigadores(6,'".$resultadoAsignar."','".$idInvestigador."','".$periodoAsignar."','".$tipoAuditoriaAsignar."','".$tipoCasoAsignar."','".$tipoZonaAsignar."','".$idCaso."','".$idUsuario."',@resp)";
  if (mysqli_query($con,$consultaAsignarInvestigadorCuentaCobro))
  {
    $variable=1;
  }else{
    $variable=2;
  }

  return ($variable);

}

function consultarInformacionAsignarInvestigadorCuentaCobro($idCaso)
{
   global $con;
  $data1=array();
  $data=array();


  $consultarInformacionInvestigacion="SELECT f.id AS tipo_caso,f.descripcion,CASE WHEN c.indicador_fraude=13 then 3 when c.indicador_fraude<>13 and c.resultado=1 then 1 when c.indicador_fraude<>13 and c.resultado=2 then 2 end as resultado,a.id_tipo_auditoria,d.tipo_zona  FROM investigaciones a LEFT JOIN detalle_investigaciones_soat b on a.id=b.id_investigacion LEFT JOIN personas_investigaciones_soat c on c.id_investigacion=a.id LEFT JOIN ciudades d on d.id=b.ciudad_ocurrencia  LEFT JOIN definicion_tipos e ON a.tipo_caso=e.descripcion2 LEFT JOIN definicion_tipos f ON f.id=e.descripcion where f.id_tipo=42 and e.id_tipo=43 and c.tipo_persona=1 and a.id='".$idCaso."'";

  $queryInformacionInvestigacion=mysqli_query($con,$consultarInformacionInvestigacion);
  if (mysqli_num_rows($queryInformacionInvestigacion)>0)
  {
    $resInformacionInvestigacion=mysqli_fetch_assoc($queryInformacionInvestigacion);
    $data["info"]=1;
    $data["id_resultado"]=$resInformacionInvestigacion["resultado"];
    $data["id_tipo_auditoria"]=$resInformacionInvestigacion["id_tipo_auditoria"];
    $data["tipo_zona"]=$resInformacionInvestigacion["tipo_zona"];
    $data["tipo_caso"]=$resInformacionInvestigacion["tipo_caso"];
  }else{
    $data["info"]=2;
    $data["id_resultado"]=0;
    $data["id_tipo_auditoria"]=0;
    $data["tipo_zona"]=0;
    $data["tipo_caso"]=0;
  }

  mysqli_next_result($con);
  $consultarAsignacionInvetigacionCuentaCobro="SELECT d.id as id_periodo,b.id_investigador as id_investigador,b.vigente,d.descripcion AS periodo,CONCAT(c.nombres,' ',c.apellidos) AS investigador,concat(e.descripcion,' ',c.identificacion) as identificacion_investigador 
FROM detalle_cuenta_cobro_investigadores a
LEFT JOIN cuenta_cobro_investigadores b ON a.id_cuenta_cobro=b.id
LEFT JOIN investigadores c ON b.id_investigador=c.id 
LEFT JOIN periodos_cuenta_cobro_investigadores d ON d.id=b.id_periodo 
LEFT JOIN definicion_tipos e ON e.id=c.tipo_identificacion
WHERE e.id_tipo=5 and a.id_investigacion='".$idCaso."'";
  $queryAsignacionInvetigacionCuentaCobro=mysqli_query($con,$consultarAsignacionInvetigacionCuentaCobro);
  $resultado="";
  if (mysqli_num_rows($queryAsignacionInvetigacionCuentaCobro)>0){
    $resAsignacionInvetigacionCuentaCobro=mysqli_fetch_assoc($queryAsignacionInvetigacionCuentaCobro);
    
    $resultado="<b>Periodo: </b>".$resAsignacionInvetigacionCuentaCobro["periodo"]."<br>"."<b>Investigador: </b>".$resAsignacionInvetigacionCuentaCobro["investigador"]." - ".$resAsignacionInvetigacionCuentaCobro["identificacion_investigador"]."<br>";
    $data["id_investigador"]=$resAsignacionInvetigacionCuentaCobro["id_investigador"];
    $data["id_periodo"]=$resAsignacionInvetigacionCuentaCobro["id_periodo"];
    if ($resAsignacionInvetigacionCuentaCobro["vigente"]=="s")
    {
      $data["resultado"]=1;
      $resultado.="<b>Estado: </b>ABIERTO";
    }else{
      $data["resultado"]=2;
      $resultado.="<b>Estado: </b>CERRADO";
    }
    $data["descripcion_resultado"]=$resultado;
    $data["resultado"]=1;

  }else{
    $data["resultado"]=1;
    $data["id_investigador"]=0;
    $data["id_periodo"]=0;
    $resultado="<b>Periodo: </b>NO ASIGNADO<br>"."<b>Investigador: </b>NO ASIGNADO";
    $data["descripcion_resultado"]=$resultado;
  }
  return json_encode($data);
}

function autorizarFacturacionMultipleInvestigaciones($idInvestigaciones,$idUsuario){
  global $con;
  $data1=array();
  $data=array();
  $decodIdInvestigaciones=json_decode($idInvestigaciones);
  $cont=0;$cont1=0;
  foreach($decodIdInvestigaciones as $passIdInvestigaciones)
  {

       $consultaInformacionBasicaCaso="CALL manejoInvestigacionesSOAT (29,'','','','','','','','','','','','".$idUsuario."','".$passIdInvestigaciones->idInvestigacion."','','','','','','','','',@resp,@resp2,@resp3)";

       mysqli_next_result($con);

       $queryInformacionBasicaCaso=mysqli_query($con,$consultaInformacionBasicaCaso);
       if (mysqli_num_rows($queryInformacionBasicaCaso)==0)
       {
          $consultaAutorizarFacturcionCaso="CALL manejoInvestigacionesSOAT (28,'','','','','','','','','','','','".$idUsuario."','".$passIdInvestigaciones->idInvestigacion."','','','','','','','','',@resp,@resp2,@resp3)";

          mysqli_next_result($con);
          $consultarInformacionBasicaCaso="SELECT a.id,c.numero as poliza,a.codigo,concat(e.nombres,' ',e.apellidos) as nombre_lesionado FROM investigaciones a LEFT JOIN detalle_investigaciones_soat b on a.id=b.id_investigacion LEFT JOIN polizas c on c.id=b.id_poliza LEFT JOIN personas_investigaciones_soat d on d.id_investigacion=a.id LEFT JOIN personas e on e.id=d.id_persona where d.tipo_persona=1 and a.id='".$passIdInvestigaciones->idInvestigacion."'";
        mysqli_next_result($con);
        $queryInformacionBasicaCaso=mysqli_query($con,$consultarInformacionBasicaCaso);
        $resInformacionBasicaCaso=mysqli_fetch_assoc($queryInformacionBasicaCaso);



        mysqli_next_result($con);
         if (mysqli_query($con,$consultaAutorizarFacturcionCaso))
        {
          mysqli_next_result($con);

          $consultaRespuestaAutorizarFacturacionCaso=mysqli_query($con,"SELECT @resp as resp");
          $respAutorizarFacturacionCaso=mysqli_fetch_assoc($consultaRespuestaAutorizarFacturacionCaso); 
          $variable=$respAutorizarFacturacionCaso["resp"];

           $data[]=array(
              "codigoCasoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["codigo"],
              "polizaCasoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["poliza"],
              "nombreLesionadoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["nombre_lesionado"],
              "estadoDuplicadoAutorizacionFacturacion"=>"AUTORIZADO",
              "opciones"=>""
           );

        
        }
        else
        {
          $variable=2;
           $data[]=array(
              "codigoCasoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["codigo"],
              "polizaCasoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["poliza"],
              "nombreLesionadoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["nombre_lesionado"],
              "estadoDuplicadoAutorizacionFacturacion"=>"ERROR NO AUTORIZADO",
              "opciones"=>"<a class='btn btn-success' name='".$resInformacionBasicaCaso["id"]."' id='btnAutorizarCasoDuplicadoFacturacion'>Autorizar</a>"
           );
        } 
        $cont++;

     }else{
      $cont1++;
      $consultarInformacionBasicaCaso="SELECT a.id,c.numero as poliza,a.codigo,concat(e.nombres,' ',e.apellidos) as nombre_lesionado FROM investigaciones a LEFT JOIN detalle_investigaciones_soat b on a.id=b.id_investigacion LEFT JOIN polizas c on c.id=b.id_poliza LEFT JOIN personas_investigaciones_soat d on d.id_investigacion=a.id LEFT JOIN personas e on e.id=d.id_persona where d.tipo_persona=1 and a.id='".$passIdInvestigaciones->idInvestigacion."'";
        mysqli_next_result($con);
        $queryInformacionBasicaCaso=mysqli_query($con,$consultarInformacionBasicaCaso);
        $resInformacionBasicaCaso=mysqli_fetch_assoc($queryInformacionBasicaCaso);



        $data[]=array(
        "codigoCasoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["codigo"],
        "polizaCasoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["poliza"],
        "nombreLesionadoDuplicadoAutorizacionFacturacion"=>$resInformacionBasicaCaso["nombre_lesionado"],
        "estadoDuplicadoAutorizacionFacturacion"=>"NO AUTORIZADO",
        "opciones"=>"<a class='btn btn-success' name='".$resInformacionBasicaCaso["id"]."' id='btnAutorizarCasoDuplicadoFacturacion'>Autorizar</a>"
     );

     }

          
              
  }  
    
       $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData" => $data
      );
   
    return json_encode($data);
}





function autorizarFacturacionInvestigacion($idRegistro,$idUsuario)
{
  global $con;

  $consultaAutorizarFacturcionCaso="CALL manejoInvestigacionesSOAT (28,'','','','','','','','','','','','".$idUsuario."','".$idRegistro."','','','','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultaAutorizarFacturcionCaso))
    {

      $consultaRespuestaAutorizarFacturacionCaso=mysqli_query($con,"SELECT @resp as resp");
      $respAutorizarFacturacionCaso=mysqli_fetch_assoc($consultaRespuestaAutorizarFacturacionCaso);
      $variable=$respAutorizarFacturacionCaso["resp"];

      
    }
    else
    {
      $variable=2;
    }
    return ($variable);
}




function subirConsolidadoSIRASEstado($arcConsolidadoMultimedia,$idUsuario,$fechaEntrega){
  global $con;
  $data=array();
  $rutaSup="/var/www/html/siglo/portal/";
  $ruta="plugins/ExcelReader/".$arcConsolidadoMultimedia['name'];
  $ejemplo="";

  if("../data"){}
  if (move_uploaded_file($arcConsolidadoMultimedia['tmp_name'], "../".$ruta)) {
    $inputFileType = PHPExcel_IOFactory::identify($rutaSup.$ruta);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($rutaSup.$ruta);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();
    $cont=1;$cont2=0;
    for ($row = 2; $row <= $highestRow; $row++)
    { 
      $fecha_excel = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("Z".$row)->getValue())) ) );


      $fecha_asignacion = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("A".$row)->getValue())) ) );

     $fecha_accidente = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("AE".$row)->getValue())) ) );


      $fecha_vigencia_desde = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("I".$row)->getValue())) ) );


      $fecha_vigencia_hasta = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("J".$row)->getValue())) ) );

      
      
      $asignado="17";
      $cadenaMotivo = "ASIGNACION CENSOS SIRAS"; 
      

      $nombresLesionado=$sheet->getCell("Q".$row)->getValue()." ".$sheet->getCell("R".$row)->getValue();
      $apellidosLesionado=$sheet->getCell("O".$row)->getValue()." ".$sheet->getCell("P".$row)->getValue();
      $tipoIdentificacion=$sheet->getCell("M".$row)->getValue();
      $identificacion=$sheet->getCell("N".$row)->getValue();
      $radicado=$sheet->getCell("D".$row)->getValue();
      $placa=$sheet->getCell("AC".$row)->getValue();
      $poliza=$sheet->getCell("H".$row)->getValue();
      $idCruce=$sheet->getCell("B".$row)->getValue();
      $lugar_accidente=$sheet->getCell("AF".$row)->getValue();

      $insertarCasoSOATAsignacion = "CALL manejoInvestigacionesSOAT (12,'".$asignado."','2', '".$fecha_accidente."', '', '', '','".$investigador."','','".$radicado."','".$fecha_asignacion."','".$fecha_excel."','".$idUsuario."','','','','','','','','".$cadenaMotivo."','',@resp,@resp2,@resp3)";
      mysqli_next_result($con);
      if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {

        $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
        $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

        $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
        $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
        $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  

        if ($respuesta["respuesta"]==1)
        {

          mysqli_next_result($con);
          $insertarPersonas = "CALL manejoPersonas (5,'".$nombresLesionado." ".$apellidosLesionado."', '".$tipoIdentificacion."', '', '', '', '', '','','','','".$identificacion."','','".$idUsuario."',@resp)";
          mysqli_query($con,$insertarPersonas);
          $consultaRespuestaInsertarPersonas=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarPersonas=mysqli_fetch_assoc($consultaRespuestaInsertarPersonas);

          mysqli_next_result($con);
          $consultaInsertarLesionadoPrincipal="CALL manejoLesionadosSOAT(15,'".$respInsertarPersonas["resp"]."', '', '', '', '', '', '','','','','','','','','','','','','". $respuesta["caso"]."','','','','','','".$idUsuario."',@resp)";
          mysqli_query($con,$consultaInsertarLesionadoPrincipal);
          $consultaRespuestaInsertarLesionado=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarLesionados=mysqli_fetch_assoc($consultaRespuestaInsertarLesionado);

          mysqli_next_result($con);
          $insertarVehiculo = "CALL manejoVehiculo (6,'', '".$placa."', '', '', '', '', '', '','','','','','".$idUsuario."',@resp,@resp2)";
          mysqli_query($con,$insertarVehiculo);
          $consultaRespuestaInsertarVehiculo=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
          $respInsertarVehiculo=mysqli_fetch_assoc($consultaRespuestaInsertarVehiculo);


          mysqli_next_result($con);
          $insertarPoliza = "CALL manejoPolizas (6,'".$poliza."', '', '".$fecha_vigencia_desde."', '', '', '', '', '','','','','','','".$respInsertarVehiculo["resp2"]."','".$respuesta["caso"]."','','".$idUsuario."',@resp)";
          mysqli_query($con,$insertarPoliza);
          $consultaRespuestaInsertarPoliza=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarPoliza=mysqli_fetch_assoc($consultaRespuestaInsertarPoliza);


          mysqli_next_result($con);
          $consultaInformacionInvestigador="CALL manejoInvestigadores(5,'','','','','','','','".$investigador."','','','','','',@resp)"; 
          $queryInvestigador=mysqli_query($con,$consultaInformacionInvestigador);
          $respInvestigador=mysqli_fetch_assoc($queryInvestigador);

     

          $data[]=array("codigo"=>$respuesta["codigo"],
            "radicado"=>$radicado,
            "investigador"=>"NO PARAMETRIZADO ASIGNACION INVESTIGADOR",
            "respuesta_email"=>"NO PARAMETRIZADO ENVIO DE CORREOS");
        }else if ($respuesta["respuesta"]==2){
          $data[]=array("codigo"=>"NO REGISTRA",
            "radicado"=>$radicado,
            "investigador"=>"NO REGISTRA",
            "respuesta_email"=>"CASO NO CREADO POR ERROR EN TIPO DE CASO");
        }else if ($respuesta["respuesta"]==3){
          $data[]=array("codigo"=>"NO REGISTRA",
            "radicado"=>$radicado,
            "investigador"=>"NO REGISTRA",
            "respuesta_email"=>"CASO YA EXISTE");
        }

      }
      else
      {
        $respuesta["respuesta"]=2;
      }

    }
  }
  unlink($rutaSup.$ruta);
  
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($data);
}


function eliminarIndicadorCaso($idIndicador){
  global $con;
  
  $consultarEliminarMultimedia="DELETE FROM id_casos_aseguradora WHERE id = $idIndicador";
  mysqli_next_result($con);

  if (mysqli_query($con,$consultarEliminarMultimedia)){
    $variable=1; 
  }else{
    $variable=2;
  }

  return ($variable);
}


function subirArchivoInformeFinal2($informeFinal2,$idInvestigacion,$idUsuario){
   global $con;
    $data=array();
    
    $permitidos = array("application/pdf");
    if (!empty($informeFinal2))
    {
      if (in_array($informeFinal2['type'], $permitidos))
        {


          $extension=explode("/",$informeFinal2['type']);
            $archivo=base64_encode($idInvestigacion.rand()).".".$extension[1];
            $data["ruta"]="data/informes2/".$archivo;

            $consultarInformeFinal=consultarInformeFinalInvestigacion($idInvestigacion);
        


           if ( move_uploaded_file($informeFinal2['tmp_name'], "../data/informes2/".$archivo)) 
           {
                $consultaSubirInformeFinal="CALL manejoMultimediaInvestigaciones (14,'".$archivo."','".$idInvestigacion."','','','".$idUsuario."',@resp)";
                 mysqli_next_result($con);
                if (mysqli_query($con,$consultaSubirInformeFinal))
                {
                    $consultaRespuestaSubirInformeFinal=mysqli_query($con,"SELECT @resp as resp");
                    $respSubirInformeFinal=mysqli_fetch_assoc($consultaRespuestaSubirInformeFinal);
                    $variable=$respSubirInformeFinal["resp"];
                }
                else
                {
                    $variable=2;
                }
                                                          

           }
           else
           {
              $variable=3;
           }
        }
        else
        {
          $variable=4;     
        }
    }
    else
    {
      $variable=5;
    }
    $consultarTipoGeneralCaso=consultarCasoSOAT($idInvestigacion);          
    if ($variable==1){

      if ($consultarTipoGeneralCaso["tipo_general_caso"]==2){ 
        if (enviarEmail($idInvestigacion,2)==2){
          $variable=6;       
        }
      }      
    }
    return $variable;
}


function crearAmpliacionInvestigacionSOAT($investigadorFrmAmpliarInvestigacion,$identificadorFrmAmpliarInvestigacion,$fechaInicioFrmAmpliarInvestigacion,$fechaEntregaFrmAmpliarInvestigacion,$motivoInvestigacionFrmAmpliarInvestigacion,$idCasoFrmAmpliarInvestigacion,$idUsuario){

  global $con;

  $consultarIngresarInvestigacionAmpliacion="INSERT INTO investigaciones (id_investigador,tipo_caso,id_aseguradora,tipo_solicitud,fecha_inicio,fecha_entrega,id_usuario,fecha_cargue,fecha,usuario, id_caso_ampliado) SELECT '".$investigadorFrmAmpliarInvestigacion."' as investigador,tipo_caso,id_aseguradora,'2' as tipo_solicitud,'".$fechaInicioFrmAmpliarInvestigacion."' as fecha_inicio,'".$fechaEntregaFrmAmpliarInvestigacion."' as fecha_entrega,'".$idUsuario."' as id_usuario,'".$fechaEntregaFrmAmpliarInvestigacion."' as fecha_cargue,CURRENT_TIMESTAMP() as fecha_cargue,'".$idUsuario."' as usuario, ".$idCasoFrmAmpliarInvestigacion." as id_caso_ampliado FROM investigaciones where id='".$idCasoFrmAmpliarInvestigacion."'";
  mysqli_next_result($con);
  $queryIngresarInvestigacionAmpliacion=mysqli_query($con,$consultarIngresarInvestigacionAmpliacion);
  $idAmpliacionInvestigacion=mysqli_insert_id($con);

  $consultarTipoCaso="SELECT CONCAT(b.descripcion2,a.id) as tipo_caso from investigaciones a LEFT JOIN definicion_tipos b on b.id=a.tipo_caso where b.id_tipo=8 and a.id='".$idAmpliacionInvestigacion."'";
  mysqli_next_result($con);
  $queryTipoCaso=mysqli_query($con,$consultarTipoCaso);
  $resTipoCaso=mysqli_fetch_assoc($queryTipoCaso);

  $actualizarTipoCaso="UPDATE investigaciones SET codigo='".$resTipoCaso["tipo_caso"]."' WHERE id='".$idAmpliacionInvestigacion."'";

  mysqli_next_result($con);
  $queryActualizarTipoCaso=mysqli_query($con,$actualizarTipoCaso);

  $consultaIngresarDetalleInvestigacionAmpliacion="INSERT INTO detalle_investigaciones_soat (id_investigacion,motivo_investigacion,usuario,fecha,fecha_accidente,lugar_accidente,ciudad_ocurrencia,tipo_zona,conclusiones,furips,punto_referencia,circunstancias,visita_lugar_hechos,registro_autoridades,inspeccion_tecnica,consulta_runt,id_poliza,hechos,fiscalia_lleva_caso,proceso_fiscalia,no_siniestro,croquis,motivo_no_anexo,diligencia_formato_declaracion,id_diligencia_formato_declaracion,observacion_diligencia_formato_declaracion,resultado_diligencia_tomador,observaciones_diligencia_tomador,fecha_diligencia_formato_declaracion,fecha_cambio_estado,usuario_cambio_estado,observacion_cambio_estado) SELECT '".$idAmpliacionInvestigacion."' as id,'".$motivoInvestigacionFrmAmpliarInvestigacion."','".$idUsuario."' as usuario,CURRENT_TIMESTAMP() as fecha,fecha_accidente,lugar_accidente,ciudad_ocurrencia,tipo_zona,conclusiones,furips,punto_referencia,circunstancias,visita_lugar_hechos,registro_autoridades,inspeccion_tecnica,consulta_runt,id_poliza,hechos,fiscalia_lleva_caso,proceso_fiscalia,no_siniestro,croquis,motivo_no_anexo,diligencia_formato_declaracion,id_diligencia_formato_declaracion,observacion_diligencia_formato_declaracion,resultado_diligencia_tomador,observaciones_diligencia_tomador,fecha_diligencia_formato_declaracion,fecha_cambio_estado,usuario_cambio_estado,observacion_cambio_estado FROM detalle_investigaciones_soat where id_investigacion='".$idCasoFrmAmpliarInvestigacion."'";

  mysqli_next_result($con);
  $queryInsertarDetalleInvestigacionSOAT=mysqli_query($con,$consultaIngresarDetalleInvestigacionAmpliacion);

  $consultaInsertarMultimediaAmpliacionSOAT2="INSERT INTO multimedia_investigacion (id_investigacion,id_multimedia,ruta,vigente,fecha,usuario) VALUES ('".$idAmpliacionInvestigacion."',10,'".$identificadorFrmAmpliarInvestigacion.".pdf','s',CURRENT_TIMESTAMP(),'".$idUsuario."')";
  mysqli_next_result($con);
  $queryInsertarMultimediaAmpliacionSOAT2=mysqli_query($con,$consultaInsertarMultimediaAmpliacionSOAT2);

  $consultaInsertarPersonaAmpliacionSOAT="INSERT INTO personas_investigaciones_soat (id_investigacion,fecha,usuario,id_persona,ips,fecha_ingreso,fecha_egreso,condicion,seguridad_social,eps,causal_consulta,regimen,estado,lesiones,tratamiento,relato,observaciones,traslado,servicio_ambulancia,tipo_traslado_ambulancia,tipo_vehiculo_traslado,lugar_traslado,resultado,indicador_fraude,tipo_persona,parentesco,remitido,ips_remitido) SELECT '".$idAmpliacionInvestigacion."' as id,CURRENT_TIMESTAMP,'".$idUsuario."' as id_usuario,id_persona,ips,fecha_ingreso,fecha_egreso,condicion,seguridad_social,eps,causal_consulta,regimen,estado,lesiones,tratamiento,relato,observaciones,traslado,servicio_ambulancia,tipo_traslado_ambulancia,tipo_vehiculo_traslado,lugar_traslado,resultado,indicador_fraude,tipo_persona,parentesco,remitido,ips_remitido FROM personas_investigaciones_soat where id_investigacion='".$idCasoFrmAmpliarInvestigacion."'";
  mysqli_next_result($con);
  $queryInsertarPersonaAmpliacionSOAT=mysqli_query($con,$consultaInsertarPersonaAmpliacionSOAT);

  $consultaInsertarIdentificadores="INSERT INTO id_casos_aseguradora (id_investigacion,identificador,fecha_inicio,fecha_entrega,usuario)  SELECT '".$idAmpliacionInvestigacion."' ,identificador,fecha_inicio,fecha_entrega,usuario FROM id_casos_aseguradora WHERE id_investigacion='".$idCasoFrmAmpliarInvestigacion."'";

  mysqli_next_result($con);
  $queryInsertarIdentificadores=mysqli_query($con,$consultaInsertarIdentificadores);

  $consultaInsertarIdentificadorNuevo="INSERT INTO id_casos_aseguradora (id_investigacion,identificador,fecha_inicio,fecha_entrega,usuario) VALUES ('".$idAmpliacionInvestigacion."','".$identificadorFrmAmpliarInvestigacion."','".$fechaInicioFrmAmpliarInvestigacion."','".$fechaEntregaFrmAmpliarInvestigacion."','".$idUsuario."')";

  mysqli_next_result($con);
  $queryInsertarIdentificadoresNuevo=mysqli_query($con,$consultaInsertarIdentificadorNuevo);

  $consultaInsertarEstadoNuevo="INSERT INTO estado_investigaciones (id_investigacion,vigente,estado,usuario,fecha) VALUES ('".$idAmpliacionInvestigacion."','s','20','".$idUsuario."',CURRENT_TIMESTAMP)";

  mysqli_next_result($con);
  $queryInsertarEstadoNuevo=mysqli_query($con,$consultaInsertarEstadoNuevo);

  if (enviarEmail($idAmpliacionInvestigacion,"4")==1){
    $variable="1";  
  }else{
    $variable="2";
  }

  return $variable;
}

function actualizarCargueInvestigacionSOAT($idInvestigacion,$idUsuario)
{
 global $con;
    $consultaActualizarCargue="CALL manejoInvestigacionesSOAT (27,'','','','','','','','','','','','".$idUsuario."','".$idInvestigacion."','','','','','','','','',@resp,@resp2,@resp3)";
     $queryActualizarCargue=mysqli_query($con,$consultaActualizarCargue);
  
   mysqli_next_result($con);
     $consultaRespuestaActualizarCargue=mysqli_query($con,"SELECT @resp as resp, @resp2 as resp2, @resp3 as resp3");
      $respActualizarCargue=mysqli_fetch_assoc($consultaRespuestaActualizarCargue);
      return $respActualizarCargue["resp"];
}


function terminarPlanillarCaso($usuario,$idCaso)
{
   global $con;
    $guardarPlanilladoTerminado="CALL manejoInvestigacionesSOAT (26,'','','','','','','','','','','','".$usuario."','".$idCaso."','','','','','','','','',@resp,@resp2,@resp3)";
     $queryPlanilladoTerminado=mysqli_query($con,$guardarPlanilladoTerminado);
  
   mysqli_next_result($con);
     $consultaRespuestaPlanilladoTerminado=mysqli_query($con,"SELECT @resp as resp, @resp2 as resp2, @resp3 as resp3");
      $respPlanilladoTerminado=mysqli_fetch_assoc($consultaRespuestaPlanilladoTerminado);
      return $respPlanilladoTerminado["resp"];
}

function guardarCambioEstado($idInvestigacion,$observacionesCambioEstado,$idUsuario){
  global $con;
  $data=array();
  $guardarCambioEstado="CALL manejoInvestigacionesSOAT (25,'','','','','','','','','','','','".$idUsuario."','".$idInvestigacion."','".$observacionesCambioEstado."','','','','','','','',@resp,@resp2,@resp3)";

  $queryCambioEstado=mysqli_query($con,$guardarCambioEstado);

  mysqli_next_result($con);
  $consultaRespuestaCambioEstado=mysqli_query($con,"SELECT @resp as resp, @resp2 as resp2, @resp3 as resp3");
  $respCambioEstado=mysqli_fetch_assoc($consultaRespuestaCambioEstado);
  $data["resultado"]=$respCambioEstado["resp"];

  if ($respCambioEstado["resp"]==1){
    mysqli_next_result($con);
    $consultarPlanoCaso="CALL manejoAseguradoraAmparoTarifas (20,'','','','','','','','','','','".$idInvestigacion."','',@resp)"; 
    $queryPlanoCaso=mysqli_query($con,$consultarPlanoCaso);
    $resPlanoCaso=mysqli_fetch_assoc($queryPlanoCaso);
    $data["id"]=$resPlanoCaso["id"];
    $data["tipo_caso"]=$resPlanoCaso["tipo_caso"];
    $data["id_aseguradora"]=$resPlanoCaso["id_aseguradora"];
    $data["nombre_funcion"]=$resPlanoCaso["funcion_ejecutar"];    
  }
  else{
    $data["resultado"]=2;
  }

  return json_encode($data);
}


function autorizarCasoSOAT($idRegistro,$idUsuario){
  global $con;

  $consultarEliminarCaso="CALL manejoInvestigacionesSOAT (14,'','','','','','','','','','','','".$idUsuario."','".$idRegistro."','','','','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarEliminarCaso)){

      $consultaRespuestaEliminarCaso=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarCaso=mysqli_fetch_assoc($consultaRespuestaEliminarCaso);
      $variable=$respEliminarCaso["resp"];
    }
    else{
      $variable=2;
    }
    return ($variable);
}

function subirAsignarCensosAnalistas($idAseguradora, $fechaEntrega, $excelCensoAnalista, $idUsuario){
  global $con;
  $data=array();

  $rutaSup="/var/www/html/siglo/portal/";
  $ruta="plugins/ExcelReader/".$excelCensoAnalista['name'];
  $ejemplo="";

  date_default_timezone_set('America/Bogota');

  if (move_uploaded_file($excelCensoAnalista['tmp_name'], "../".$ruta)) {

    $inputFileType = PHPExcel_IOFactory::identify($rutaSup.$ruta);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($rutaSup.$ruta);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    $data=array();
    
    $cont1=0; $cont2=0;
    $contError1=0; $contError2=0; $contError3=0; $contError4=0;

    $idsInserts = array();    

    for ($row = 2; $row <= $highestRow; $row++){ 
      $cont1++;
      $rowPlaca=$sheet->getCell("A".$row)->getValue();
      //$rowFecAc=date($format = "Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("B".$row)->getValue())); 
      $rowFecAc = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("B".$row)->getValue())) ) );
      $rowAnali=$sheet->getCell("C".$row)->getValue();
      $rowInves=$sheet->getCell("D".$row)->getValue();
      $rowTpCas=$sheet->getCell("E".$row)->getValue();

      $codigo = "cg";

      $sqlInsertCaso = "INSERT INTO investigaciones (tipo_solicitud, tipo_caso, fecha_inicio, fecha_entrega, id_aseguradora, id_investigador, id_usuario, fecha_cargue, id_tipo_auditoria, fecha, usuario, estado) VALUES (1, $rowTpCas, CURRENT_DATE(), '$fechaEntrega', $idAseguradora, $rowInves, $rowAnali, '$fechaEntrega', 1, CURRENT_TIMESTAMP(), $idUsuario, 1);";
      
      mysqli_next_result($con);
      if (mysqli_query($con,$sqlInsertCaso)){

        $idsInserts[] = $id_caso = mysqli_insert_id($con);
        $cont2++;

        mysqli_next_result($con);
        $dataTc = mysqli_query($con, "SELECT descripcion2 FROM definicion_tipos WHERE id_tipo = 8 AND id = ".$rowTpCas);
        $infoTpCaso=mysqli_fetch_array($dataTc,MYSQLI_ASSOC);
        $codigo=$infoTpCaso["descripcion2"].$id_caso;

        mysqli_next_result($con);
        $sqlUpdateCodigo = "UPDATE investigaciones SET codigo = '$codigo' WHERE id = $id_caso;";
        if (!mysqli_query($con,$sqlUpdateCodigo)){
          $contError2++;
        }

        mysqli_next_result($con);
        $sqlInsertAsigTemp = "INSERT INTO asignar_censo_analista_temp (id_investigacion, placa) VALUES ($id_caso, '$rowPlaca');";
        if (!mysqli_query($con,$sqlInsertAsigTemp)){
          $contError3++;
        }

        mysqli_next_result($con);
        $sqlInsertDetalle = "INSERT INTO detalle_investigaciones_soat (id_investigacion, fecha_accidente, usuario, fecha) VALUES ($id_caso, '$rowFecAc', $idUsuario, CURRENT_TIMESTAMP());";
        if (!mysqli_query($con,$sqlInsertDetalle)){
          $contError4++;
        }

        mysqli_next_result($con);
        $sqlInsertEstado = "INSERT INTO estado_investigaciones (id_investigacion,estado,vigente,usuario,fecha) VALUES ($id_caso, 18, 's', $idUsuario, CURRENT_TIMESTAMP());";
        mysqli_query($con,$sqlInsertEstado);

        mysqli_next_result($con);
        $sqlInsertMult = "INSERT INTO multimedia_investigacion (vigente,id_investigacion,id_multimedia) VALUES ('c',$id_caso,'9');";
        mysqli_query($con,$sqlInsertMult);

        mysqli_next_result($con);
        $sqlInsertMult = "INSERT INTO multimedia_investigacion (vigente,id_investigacion,id_multimedia) VALUES ('c',$id_caso,'14');";
        mysqli_query($con,$sqlInsertMult);

        mysqli_next_result($con);
        $sqlInsertAutorizar = "INSERT INTO autorizacion_facturacion_investigacion (id_investigacion,autorizar_facturacion,id_usuario,fecha) VALUES ($id_caso,'n',$idUsuario,CURRENT_TIMESTAMP());";
        mysqli_query($con,$sqlInsertAutorizar);

        mysqli_next_result($con);
        $resultInfoCaso = mysqli_query($con,"SELECT a.codigo, CONCAT(b.nombres, ' ', b.apellidos) AS analista, c.nombre_aseguradora AS aseguradora
          FROM investigaciones a
          LEFT JOIN usuarios b ON b.id = a.id_usuario
          LEFT JOIN aseguradoras c ON a.id_aseguradora = c.id
          WHERE a.id = $id_caso;");

        $infoCaso=mysqli_fetch_array($resultInfoCaso,MYSQLI_ASSOC);
    
        $data[]=array("Codigo"=>$codigo,
        "Placa"=>$rowPlaca,
        "FechaAccidente"=>$rowFecAc,
        "Analista"=>$infoCaso["analista"],
        "Aseguradora"=>$infoCaso["aseguradora"]);
      }
      else{
        $contError1++;
      }
    }
  }

  unlink($rutaSup.$ruta);

  $respuesta = 1;
  if($contError1 == 0 && $contError2 == 0 && $contError3 == 0 && $contError4 == 0){
    $respuesta = 1;
  }else{
    $respuesta = 2;
  }

  $results = array(
    "sEcho" => $respuesta,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($results);
} 

function subirConsolidadoAsignarAnalistasMundial($arcConsolidadoMultimedia,$idUsuario){
  global $con;
  $data=array();
  
  $rutaSup="/var/www/html/siglo/portal/";
  $ruta="plugins/ExcelReader/".$arcConsolidadoMultimedia['name'];
  $ejemplo="";

    if (move_uploaded_file($arcConsolidadoMultimedia['tmp_name'], "../".$ruta)) 
    {
      $inputFileType = PHPExcel_IOFactory::identify($rutaSup.$ruta);
      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($rutaSup.$ruta);
      $sheet = $objPHPExcel->getSheet(0); 
      $highestRow = $sheet->getHighestRow(); 
      $highestColumn = $sheet->getHighestColumn();
      $cont=1;$cont2=0;
      for ($row = 2; $row <= $highestRow; $row++)
      { 
        $analista=$sheet->getCell("AB".$row)->getValue();
        $radicado=$sheet->getCell("B".$row)->getValue();

        $consultarAsignarAnalistaCaso="CALL manejoInvestigacionesSOAT (13,'','','','','','','','".$analista."','".$radicado."','','','".$idUsuario."','','','','','','','','','',@resp,@resp2,@resp3)";


        mysqli_next_result($con);
        if (mysqli_query($con,$consultarAsignarAnalistaCaso))
        {

          $consultaRespuestaAsignarAnalista=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respAsignarAnalista=mysqli_fetch_assoc($consultaRespuestaAsignarAnalista);

          $respuesta["codigo"]=$respAsignarAnalista["resp3"];
          $respuesta["caso"]=$respAsignarAnalista["resp2"];
          $respuesta["respuesta"]=$respAsignarAnalista["resp"];  

          mysqli_next_result($con);
          $consultaInformacionUsuario="CALL manejoUsuarios(6,'','','','','','".$analista."','','','',@resp)"; 
          $consultarInformacionUsuario=mysqli_query($con,$consultaInformacionUsuario);
          $resInformacionUsuario=mysqli_fetch_array($consultarInformacionUsuario,MYSQLI_ASSOC);
    
          $data[]=array("codigo"=>$respuesta["codigo"],
                        "radicado"=>$radicado,
                        "analista"=>($resInformacionUsuario["nombres"]." ".$resInformacionUsuario["apellidos"]));
       
        }
        else
        {
          $respuesta["respuesta"]=2;
        }
         
      }
    }
    unlink($rutaSup.$ruta);
    
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
        );
  return json_encode($data);
}    

function subirConsolidadoAsignarInvestigadoresMundial($arcConsolidadoMultimedia,$idUsuario,$fechaEntrega){
  global $con;
  $data=array();
  $rutaSup="/var/www/html/siglo/portal/";
  $ruta="plugins/ExcelReader/".$arcConsolidadoMultimedia['name'];
  $ejemplo="";

  if (move_uploaded_file($arcConsolidadoMultimedia['tmp_name'], "../".$ruta)) {
    $inputFileType = PHPExcel_IOFactory::identify($rutaSup.$ruta);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($rutaSup.$ruta);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();
    $cont=1;$cont2=0;
    for ($row = 2; $row <= $highestRow; $row++)
    { 
       $fecha_entrega = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("Z".$row)->getValue())) ) );


      $fecha_asignacion = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("J".$row)->getValue())) ) );
      
      $fecha_accidente = gmdate ( 'Y-m-d H:i:s' ,  strtotime ( date("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("L".$row)->getValue())) ) );

      $asignado="0";
      if (($sheet->getCell("H".$row)->getValue()=="Investigacion") && ($sheet->getCell("I".$row)->getValue()=="GASTOS MEDICOS, QUIRURGICOS, FARMACEUTICOS Y HOSPITALARIOS")){
        $asignado="4";
      }
      else if (($sheet->getCell("H".$row)->getValue()=="Investigación") && ($sheet->getCell("I".$row)->getValue()=="GASTOS MEDICOS, QUIRURGICOS, FARMACEUTICOS Y HOSPITALARIOS")){
        $asignado="4";
      }
      else if (($sheet->getCell("H".$row)->getValue()=="Censo") && ($sheet->getCell("I".$row)->getValue()=="GASTOS MEDICOS, QUIRURGICOS, FARMACEUTICOS Y HOSPITALARIOS"))
      {
        $asignado="2";

      }
      else  if (($sheet->getCell("H".$row)->getValue()=="Investigacion") && ($sheet->getCell("I".$row)->getValue()=="GASTOS DE TRANSPORTE Y MOVILIZACION DE VICTIMAS"))
      {
        $asignado="6";

      }
      else  if (($sheet->getCell("H".$row)->getValue()=="Investigación") && ($sheet->getCell("I".$row)->getValue()=="GASTOS DE TRANSPORTE Y MOVILIZACION DE VICTIMAS"))
      {
        $asignado="6";

      }
      else if (($sheet->getCell("H".$row)->getValue()=="Censo") && ($sheet->getCell("I".$row)->getValue()=="GASTOS DE TRANSPORTE Y MOVILIZACION DE VICTIMAS"))
      {
        $asignado="2";


      }
      else if (($sheet->getCell("H".$row)->getValue()=="Ampliacion Censo") && ($sheet->getCell("I".$row)->getValue()=="GASTOS MEDICOS, QUIRURGICOS, FARMACEUTICOS Y HOSPITALARIOS" || $sheet->getCell("I".$row)->getValue()=="GASTOS DE TRANSPORTE Y MOVILIZACION DE VICTIMAS"))
      {
        $asignado="2";

      }
      else if ($sheet->getCell("H".$row)->getValue()=="Investigacion" && $sheet->getCell("I".$row)->getValue()=="MUERTE Y GASTOS FUNERARIOS"){
        $asignado="8";          
      }
      else if ($sheet->getCell("H".$row)->getValue()=="Investigación" && $sheet->getCell("I".$row)->getValue()=="MUERTE Y GASTOS FUNERARIOS"){
        $asignado="8";          
      }

      if($sheet->getCell("V".$row)->getValue() != ""){
        $cadenaMotivo = str_replace(";",",",$sheet->getCell("V".$row)->getValue()); 
      }else{
        $cadenaMotivo = '';
      }


      $nombresLesionado=$sheet->getCell("S".$row)->getValue();
      $tipoIdentificacion=$sheet->getCell("Q".$row)->getValue();
      $identificacion=$sheet->getCell("R".$row)->getValue();
      $radicado=$sheet->getCell("B".$row)->getValue();
      $placa=$sheet->getCell("G".$row)->getValue();
      $poliza=$sheet->getCell("F".$row)->getValue();
      $investigador=$sheet->getCell("AA".$row)->getValue();
      $no_caso=$sheet->getCell("A".$row)->getValue();

      $insertarCasoSOATAsignacion = "CALL manejoInvestigacionesSOAT (12,'".$asignado."','1', '".$fecha_accidente."', '1', '', '','".$investigador."','','".$radicado."','".$fecha_asignacion."','".$fecha_entrega."','".$idUsuario."','','','','','','','','".$cadenaMotivo."','',@resp,@resp2,@resp3)";
      mysqli_next_result($con);
      if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {

        $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
        $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

        $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
        $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
        $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  

        if ($respuesta["respuesta"]==1)
        {
          $rutaFinal="data/soportes_asignacion_analistas/".$radicado.".pdf";

          mysqli_next_result($con);
          $consultaSubirSoporte="CALL manejoMultimediaInvestigaciones (11,'https://globalredltda.co/siglo/portal/".$rutaFinal."','".$respuesta["caso"]."','','','".$idUsuario."',@resp)";
          mysqli_query($con,$consultaSubirSoporte);
          $consultaRespuestaSubirSoporte=mysqli_query($con,"SELECT @resp as resp");
          $respSubirSoporte=mysqli_fetch_assoc($consultaRespuestaSubirSoporte);

          mysqli_next_result($con);
          $insertarPersonas = "CALL manejoPersonas (5,'".$nombresLesionado."', '".$tipoIdentificacion."', '', '', '', '', '','','','','".$identificacion."','','".$idUsuario."',@resp)";
          mysqli_query($con,$insertarPersonas);
          $consultaRespuestaInsertarPersonas=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarPersonas=mysqli_fetch_assoc($consultaRespuestaInsertarPersonas);

          mysqli_next_result($con);
          $consultaInsertarLesionadoPrincipal="CALL manejoLesionadosSOAT(15,'".$respInsertarPersonas["resp"]."', '', '', '', '', '', '','','','','','','','','','','','','". $respuesta["caso"]."','','','','','','".$idUsuario."',@resp)";
          mysqli_query($con,$consultaInsertarLesionadoPrincipal);
          $consultaRespuestaInsertarLesionado=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarLesionados=mysqli_fetch_assoc($consultaRespuestaInsertarLesionado);

          mysqli_next_result($con);
          $insertarVehiculo = "CALL manejoVehiculo (6,'', '".$placa."', '', '', '', '', '', '','','','','','".$idUsuario."',@resp,@resp2)";
          mysqli_query($con,$insertarVehiculo);
          $consultaRespuestaInsertarVehiculo=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
          $respInsertarVehiculo=mysqli_fetch_assoc($consultaRespuestaInsertarVehiculo);

          mysqli_next_result($con);
          $insertarPoliza = "CALL manejoPolizas (6,'".$poliza."', '', '', '', '', '', '', '','','','','','','".$respInsertarVehiculo["resp2"]."','".$respuesta["caso"]."','','".$idUsuario."',@resp)";
          mysqli_query($con,$insertarPoliza);
          $consultaRespuestaInsertarPoliza=mysqli_query($con,"SELECT @resp as resp");
          $respInsertarPoliza=mysqli_fetch_assoc($consultaRespuestaInsertarPoliza);


          mysqli_next_result($con);
          $consultaInformacionInvestigador="CALL manejoInvestigadores(5,'','','','','','','','".$investigador."','','','','','',@resp)"; 
          $queryInvestigador=mysqli_query($con,$consultaInformacionInvestigador);
          $respInvestigador=mysqli_fetch_assoc($queryInvestigador);

          if (enviarEmail($respuesta["caso"],"3")==1){
            $respuestaEnviarEmail="CORREO ENVIADO";  
          }else{
            $respuestaEnviarEmail="ERROR AL ENVIAR CORREO";
          }

          $data[]=array("codigo"=>$respuesta["codigo"],
            "radicado"=>$radicado,
            "investigador"=>$respInvestigador["nombres"]." ".$respInvestigador["apellidos"],
            "respuesta_email"=>$respuestaEnviarEmail);
        }else if ($respuesta["respuesta"]==2){
          $data[]=array("codigo"=>"NO REGISTRA",
            "radicado"=>$radicado,
            "investigador"=>"NO REGISTRA",
            "respuesta_email"=>"CASO NO CREADO POR ERROR EN TIPO DE CASO");
        }else if ($respuesta["respuesta"]==3){
          $data[]=array("codigo"=>"NO REGISTRA",
            "radicado"=>$radicado,
            "investigador"=>"NO REGISTRA",
            "respuesta_email"=>"CASO YA EXISTE");
        }

      }
      else
      {
        $respuesta["respuesta"]=2;
      }

    }
  }
  unlink($rutaSup.$ruta);
  
  $results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
  );
  return json_encode($data);
}



function modificarAsignacionInvestigacion($fechaEntregaFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$idInvestigacion,$idUsuario)
{
  global $con;
    $data=array();
    $respuesta=array();

$insertarCasoSOATAsignacion = "CALL manejoInvestigacionesSOAT (23,'','', '".$fechaEntregaFrmAsignarInvestigacion."', '', '', '','','','','','','".$idInvestigacion."','','','','','','','','".$motivoInvestigacionFrmAsignarInvestigacion."','',@resp,@resp2,@resp3)";

if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {

          $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

     

        

          $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
          $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
          $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      

        if ($respInsertarCasoSOAT["resp"]==1)
        {


            if (!empty($soporteFile))
            {
                 mysqli_next_result($con);
                $consultarSoporte=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$idInvestigacion."' and id_multimedia='10'");
                if (mysqli_num_rows($consultarSoporte)>0)
                {
                  $resSoporte=mysqli_fetch_assoc($consultarSoporte);
                  
                    unlink("../data/soporte_asignacion_investigacion/".$resSoporte["ruta"]);
                    mysqli_next_result($con);
                  $eliminarSoporte=mysqli_query($con,"CALL manejoMultimediaInvestigaciones (12,'','','','".$resSoporte["id"]."','',@resp)");
                }

                $extension=explode("/",$soporteFile['type']);
                $archivo=base64_encode("s-".$idInvestigacion.rand()).".".$extension[1];
                  
  
                      if ( move_uploaded_file($soporteFile['tmp_name'], "../data/soporte_asignacion_investigacion/".$archivo))
                      {
                          
                           $consultaSubirSoporte="CALL manejoMultimediaInvestigaciones (7,'".$archivo."','".$idInvestigacion."','','','".$idUsuario."',@resp)";


                              if (mysqli_query($con,$consultaSubirSoporte))
                              {

                                $consultaRespuestaSubirSoporte=mysqli_query($con,"SELECT @resp as resp");
                                $respSubirSoporte=mysqli_fetch_assoc($consultaRespuestaSubirSoporte);
                                $respuesta["respuesta_cargar_soporte"]=$respSubirSoporte["resp"];

                                
                              }else{
                                $respuesta["respuesta_cargar_soporte"]=2;
                              }
                                                          

                        }
                        else
                        {
                         $respuesta["respuesta_cargar_soporte"]=3;
                        } 

                       
              }else{
                $respuesta["respuesta_cargar_soporte"]=5;
              }



         
        }

        

      return json_encode($respuesta);
}




function registrarAsignacionInvestigacion($idAseguradoraFrmAsignarInvestigacion,$fechaEntregaFrmAsignarInvestigacion,$tipoCasoFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$idUsuario)
{
  global $con;
    $data=array();
    $respuesta=array();

$insertarCasoSOATAsignacion = "CALL manejoInvestigacionesSOAT (11,'".$tipoCasoFrmAsignarInvestigacion."','".$idAseguradoraFrmAsignarInvestigacion."', '".$fechaEntregaFrmAsignarInvestigacion."', '', '', '','','".$usuario."','','','','".$idUsuario."','','','','','','','','".$motivoInvestigacionFrmAsignarInvestigacion."','',@resp,@resp2,@resp3)";

if (mysqli_query($con,$insertarCasoSOATAsignacion))
      {

          $consultaRespuestaInsertarCasoSOATAsignacion=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOATAsignacion);

     

        

          $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
          $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
          $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      

        if ($respInsertarCasoSOAT["resp"]==1)
        {


            if (!empty($soporteFile))
            {
              

                $extension=explode("/",$soporteFile['type']);
                $archivo=base64_encode("s-".$respuesta["caso"].rand()).".".$extension[1];
                  
  
                      if ( move_uploaded_file($soporteFile['tmp_name'], "../data/soporte_asignacion_investigacion/".$archivo)) 
                      {
                          
                           $consultaSubirSoporte="CALL manejoMultimediaInvestigaciones (7,'".$archivo."','".$respuesta["caso"]."','','','".$idUsuario."',@resp)";


                              if (mysqli_query($con,$consultaSubirSoporte))
                              {

                                $consultaRespuestaSubirSoporte=mysqli_query($con,"SELECT @resp as resp");
                                $respSubirSoporte=mysqli_fetch_assoc($consultaRespuestaSubirSoporte);
                                $respuesta["respuesta_cargar_soporte"]=$respSubirSoporte["resp"];

                                
                              }else{
                                $respuesta["respuesta_cargar_soporte"]=2;
                              }
                                                          

                        }
                        else
                        {
                         $respuesta["respuesta_cargar_soporte"]=3;
                        } 

                       
              }else{
                $respuesta["respuesta_cargar_soporte"]=5;
              }



         
        }

        if ($respuesta["respuesta"]==1)
        {
          $respuesta["respuesta_envio_correo"]=enviarEmail($respuesta["caso"],"1");
          
        }

      return json_encode($respuesta);
}


function modificarDetalleInvestigacionMuerte($idInvestigacionFrmInformeMuerte,$fiscaliaCasoInformeMuerteFrm,$procesoFiscaliaInformeMuerteFrm,$noCroquisInformeMuerteFrm,$siniestroInformeMuerteFrm,$hechosInformeMuerteFrm,$conclusionesInformeMuerteFrm,$conclusionesInformeMuerteFrm2,$idUsuario)
{
    global $con;

     $respuesta=array();
    $modificarDetalleCasoSOAT = "CALL manejoInvestigacionesSOAT (10,'','','','','','','','','','','','".$idUsuario."','".$idInvestigacionFrmInformeMuerte."','".$conclusionesInformeMuerteFrm."','".$hechosInformeMuerteFrm."','".$fiscaliaCasoInformeMuerteFrm."','".$procesoFiscaliaInformeMuerteFrm."','".$siniestroInformeMuerteFrm."','".$noCroquisInformeMuerteFrm."','','',@resp,@resp2,@resp3)";

        if (mysqli_query($con,$modificarDetalleCasoSOAT))
        {

          $consultaRespuestaModificarDetalleCasoSOAT=mysqli_query($con,"SELECT @resp as resp");
          $respModificarDetalleCasoSOAT=mysqli_fetch_assoc($consultaRespuestaModificarDetalleCasoSOAT);
          $variable=$respModificarDetalleCasoSOAT["resp"];

          
        }else{
          $variable=2;
        }


     
      
     return ($variable);
}

function deshabilitarInformeFinal($idInvestigacion,$idUsuario)
{
  global $con;
  $consultaDeshabilitarInformeFinal="CALL manejoMultimediaInvestigaciones (5,'','".$idInvestigacion."','','','".$idUsuario."',@resp)";

   if (mysqli_query($con,$consultaDeshabilitarInformeFinal))
    {
      $consultaDeshabilitarInformeFinal=mysqli_query($con,"SELECT @resp as resp");
      $respDeshabilitarInformeFinal=mysqli_fetch_assoc($consultaDeshabilitarInformeFinal);
      $variable=$respDeshabilitarInformeFinal["resp"];
    }
    else
    {
      $variable=2;
    }
 return ($variable);
}


function subirArchivoInformeFinal($informeFinal,$idInvestigacion,$idUsuario){
  
  global $con;
  $data=array();
  $permitidos = array("application/pdf","");
  
  if (!empty($informeFinal)){

    //var_dump($informeFinal);

    if (in_array($informeFinal['type'], $permitidos)){

      $extension=explode("/",$informeFinal['type']);
      $archivo=base64_encode($idInvestigacion.rand()).".".$extension[1];
      $data["ruta"]="data/informes/".$archivo;
      $consultarInformeFinal=consultarInformeFinalInvestigacion($idInvestigacion);
        if(is_dir("../data")){
      if ( move_uploaded_file($informeFinal['tmp_name'], "../data/informes/".$archivo)) {
        $consultaSubirInformeFinal="CALL manejoMultimediaInvestigaciones (6,'".$archivo."','".$idInvestigacion."','','','".$idUsuario."',@resp)";
        mysqli_next_result($con);

        if (mysqli_query($con,$consultaSubirInformeFinal)){
          $consultaRespuestaSubirInformeFinal=mysqli_query($con,"SELECT @resp as resp");
          $respSubirInformeFinal=mysqli_fetch_assoc($consultaRespuestaSubirInformeFinal);
          $variable=$respSubirInformeFinal["resp"];
        }
        else{
          $variable=2;
        }
      }
      else{
        $variable=3;
      }
    }
    else{
      $variable=4;     
    }
  }
  else
  {
    $variable=5;
  }
  $consultarTipoGeneralCaso=consultarCasoSOAT($idInvestigacion);     
  if ($variable==1)
  {

    if ($consultarTipoGeneralCaso["tipo_general_caso"]==2)
    { 
      if (enviarEmail($idInvestigacion,2)==2)
      {
        $variable=6;       
      }
    }

  }
  }
  return $variable;
}


function consultarInformeFinalInvestigacion($idInvestigacion)
{
  global $con;

     $data=array();

      $consultaInformeFinal2Investigacion="CALL manejoMultimediaInvestigaciones (13,'','".$idInvestigacion."','','','',@resp)";

      $queryInformeFinal2Investigacion=mysqli_query($con,$consultaInformeFinal2Investigacion);
      
      $data["cantidad_informe2"]=@mysqli_num_rows($queryInformeFinal2Investigacion);
      

      if (@mysqli_num_rows($queryInformeFinal2Investigacion)>0)
      {
        $resInformeFinal2Investigacion=mysqli_fetch_array($queryInformeFinal2Investigacion,MYSQLI_ASSOC);
        $data["vigente_informe2"]=$resInformeFinal2Investigacion["vigente"];
        $data["ruta_informe2"]=$resInformeFinal2Investigacion["ruta"];
        $data["ruta2_informe2"]=$resInformeFinal2Investigacion["ruta"].'?'.time();
        
        $data["id_registro_informe2"]=$resInformeFinal2Investigacion["id"];
      }

      mysqli_next_result($con);


     $consultaInformeFinalInvestigacion="CALL manejoMultimediaInvestigaciones (4,'','".$idInvestigacion."','','','',@resp)";

      $queryInformeFinalInvestigacion=mysqli_query($con,$consultaInformeFinalInvestigacion);
      
      $data["cantidad_informe"]=@mysqli_num_rows($queryInformeFinalInvestigacion);
      

      if (@mysqli_num_rows($queryInformeFinalInvestigacion)>0)
      {
        $resInformeFinalInvestigacion=mysqli_fetch_array($queryInformeFinalInvestigacion,MYSQLI_ASSOC);
        $data["vigente"]=$resInformeFinalInvestigacion["vigente"];
        $data["ruta"]=$resInformeFinalInvestigacion["ruta"];
        $data["ruta2"]=$resInformeFinalInvestigacion["ruta"].'?'.time();
        
        $data["id_registro"]=$resInformeFinalInvestigacion["id"];
      }

      mysqli_next_result($con);

      $consultaSoporteInvestigacion="CALL manejoMultimediaInvestigaciones (9,'','".$idInvestigacion."','','','',@resp)";

      $querySoporteInvestigacion=mysqli_query($con,$consultaSoporteInvestigacion);
      
      $data["cantidad_soporte"]=@mysqli_num_rows($querySoporteInvestigacion);
      

      if (@mysqli_num_rows($querySoporteInvestigacion)>0)
      {
        $resSoporteInvestigacion=mysqli_fetch_array($querySoporteInvestigacion,MYSQLI_ASSOC);
        
        $data["ruta_soporte"]=$resSoporteInvestigacion["ruta"];
        $data["ruta2_soporte"]=$resSoporteInvestigacion["ruta"].'?'.time();
        
        $data["id_registro"]=$resSoporteInvestigacion["id"];
      }


       mysqli_next_result($con);

      $consultaCartaPresentacionInvestigacion="CALL manejoMultimediaInvestigaciones (10,'','".$idInvestigacion."','','','',@resp)";

      $queryCartaPresentacionInvestigacion=mysqli_query($con,$consultaCartaPresentacionInvestigacion);
      
      $data["cantidad_carta_presentacion"]=@mysqli_num_rows($queryCartaPresentacionInvestigacion);
      

      if (@mysqli_num_rows(@$queryCartaPresentacionInvestigacion)>0)
      {
        $resCartaPresentacionInvestigacion=mysqli_fetch_array($queryCartaPresentacionInvestigacion,MYSQLI_ASSOC);
        
        $data["ruta_carta_presentacion"]=$resCartaPresentacionInvestigacion["ruta"];
        $data["ruta2_carta_presentacion"]=$resCartaPresentacionInvestigacion["ruta"].'?'.time();
        
        $data["id_registro"]=$resCartaPresentacionInvestigacion["id"];
      }
      return $data;

}



function modificarDetalleInvestigacion($contactoTomadorInformeFrm,$observacionContactoTomadorInformeFrm,$visitaLugarHechosInformeFrm,$registroAutoridadesTecnicaInformeFrm,$inspeccionTecnicaInformeFrm,$ConsultaRUNTInformeFrm,$causalNoConsultaRUNTInformeFrm,$puntoReferenciaInformeFrm,$furipsInformeFrm,$conclusionesInformeFrm,$idInvestigacionFrmInforme,$idUsuario,$aConsideracion,$versionesHechosDiferenteInformeFrm,$cantidadOcupantesInformeFrm,$cantidadPersonasTrasladoInformeFrm,$motivoOcurrencia)
{
     global $con;

     $respuesta=array();
    $modificarDetalleCasoSOAT = "CALL manejoInvestigacionesSOAT (9,'".$contactoTomadorInformeFrm."','".$observacionContactoTomadorInformeFrm."','".$versionesHechosDiferenteInformeFrm."','".$cantidadOcupantesInformeFrm."','".$cantidadPersonasTrasladoInformeFrm."','".$motivoOcurrencia."','','','','','','".$idUsuario."','".$idInvestigacionFrmInforme."','".$conclusionesInformeFrm."','".$furipsInformeFrm."','".$puntoReferenciaInformeFrm."','".$visitaLugarHechosInformeFrm."','".$registroAutoridadesTecnicaInformeFrm."','".$inspeccionTecnicaInformeFrm."','".$ConsultaRUNTInformeFrm."','".$causalNoConsultaRUNTInformeFrm."',@resp,@resp2,@resp3)";

        if (mysqli_query($con,$modificarDetalleCasoSOAT))
        {

          $consultaRespuestaModificarDetalleCasoSOAT=mysqli_query($con,"SELECT @resp as resp");
          $respModificarDetalleCasoSOAT=mysqli_fetch_assoc($consultaRespuestaModificarDetalleCasoSOAT);
          $variable=$respModificarDetalleCasoSOAT["resp"];

          if ($variable == 1) {
            $query = "UPDATE conclusiones_inconsistencias_investigaciones SET activo='n' WHERE id_investigacion=".$idInvestigacionFrmInforme;
            if(mysqli_query($con, $query)){
              if($aConsideracion <> 0){
                //echo "Cantidad ".$aConsideracion;
                $sql = "";
                $aConsideracion = explode(",", $aConsideracion);
                for($i = 0; $i < count($aConsideracion); $i++) {
                  $sql .= "INSERT INTO conclusiones_inconsistencias_investigaciones (id_investigacion, id_conclusion, fecha) VALUES ('".$idInvestigacionFrmInforme."', '".$aConsideracion[$i]."', CURRENT_TIMESTAMP()); ";
                }

                if($resultInsert = mysqli_multi_query($con, $sql)){
                  $variable=1;
                }else{
                  $variable=2;        
                }
              }
            }
          }
        }else{
          $variable=2;
        }
        
     return ($variable);
}


function consultarDetalleCasoSOAT($idCaso)
{
     global $con;

     $respuesta=array();
    $consultarDetalleCasoSOAT = "CALL manejoInvestigacionesSOAT (8,'','','','','','','','','','','','','".$idCaso."','','','','','','','','',@resp,@resp2,@resp3)";

      $queryDetalleCasoSOAT=mysqli_query($con,$consultarDetalleCasoSOAT);
      $respDetalleCasoSOAT=mysqli_fetch_assoc($queryDetalleCasoSOAT);

      $respuesta["id_investigacion"]=$respDetalleCasoSOAT["id_investigacion"];
      $respuesta["conclusiones"]=$respDetalleCasoSOAT["conclusiones"];  
      $respuesta["furips"]=$respDetalleCasoSOAT["furips"];  
      $respuesta["punto_referencia"]=$respDetalleCasoSOAT["punto_referencia"];  
      $respuesta["visita_lugar_hechos"]=$respDetalleCasoSOAT["visita_lugar_hechos"];  
      $respuesta["registro_autoridades"]=$respDetalleCasoSOAT["registro_autoridades"];  
      $respuesta["inspeccion_tecnica"]=$respDetalleCasoSOAT["inspeccion_tecnica"];  
      $respuesta["consulta_runt"]=$respDetalleCasoSOAT["consulta_runt"];  
      $respuesta["causal_runt"]=$respDetalleCasoSOAT["causal_runt"];  

      $respuesta["hechos"]=$respDetalleCasoSOAT["hechos"]; 
      $respuesta["proceso_fiscalia"]=$respDetalleCasoSOAT["proceso_fiscalia"]; 
      $respuesta["fiscalia_lleva_caso"]=$respDetalleCasoSOAT["fiscalia_lleva_caso"]; 
 
      $respuesta["no_siniestro"]=$respDetalleCasoSOAT["no_siniestro"]; 
      $respuesta["croquis"]=$respDetalleCasoSOAT["croquis"]; 
      $respuesta["resultado_diligencia_tomador"]=$respDetalleCasoSOAT["resultado_diligencia_tomador"]; 
      $respuesta["observaciones_diligencia_tomador"]=$respDetalleCasoSOAT["observaciones_diligencia_tomador"];
      
      
      $respuesta["numero_ocupantes_vehiculo"]=$respDetalleCasoSOAT["numero_ocupantes_vehiculo"]; 
      $respuesta["cantidad_personas_traslado"]=$respDetalleCasoSOAT["cantidad_personas_traslado"]; 
      $respuesta["versiones_diferentes"]=$respDetalleCasoSOAT["versiones_diferentes"];
      $respuesta["motivo_ocurrencia"] = $respDetalleCasoSOAT["id_motivo_ocurrencia"];

    //consultar resultado del caso si es atender
    $query = "SELECT ps.resultado, ps.indicador_fraude
      FROM personas_investigaciones_soat ps
      WHERE ps.tipo_persona = 1 AND ps.resultado = 1 AND ps.indicador_fraude = 13 AND ps.id_investigacion = $idCaso";
    mysqli_next_result($con);
    $resConclusiones=mysqli_query($con,$query);
    if(!empty($resConclusiones) AND mysqli_num_rows($resConclusiones) > 0){
      $respuesta['a_consideracion'] = true;

      $queryTraerSeleccion = "SELECT ps.resultado, ps.indicador_fraude, ci.id_conclusion
        FROM personas_investigaciones_soat ps
        left JOIN conclusiones_inconsistencias_investigaciones ci ON ci.id_investigacion = ps.id_investigacion
        WHERE ps.tipo_persona = 1 AND ps.resultado = 1 AND ps.indicador_fraude = 13 AND ps.id_investigacion = $idCaso AND ci.activo = 's'";
      mysqli_next_result($con);
      $resQuerySeleccion = mysqli_query($con, $queryTraerSeleccion);

      if(!empty($resQuerySeleccion) AND mysqli_num_rows($resQuerySeleccion) > 0){
        while ($res=mysqli_fetch_array($resQuerySeleccion,MYSQLI_ASSOC)){
          $datos[] = array(
            $res['id_conclusion']
          );
        }
        $respuesta['resAconsideracion'] = $datos;
      }else{
        $respuesta['resAconsideracion'] = false;
      }
    }else{
      $respuesta['a_consideracion'] = false;
    }

    //Observaciones

    $querySMS = "SELECT * 
        FROM investigaciones i
        LEFT JOIN personas_investigaciones_soat pis ON i.id = pis.id_investigacion
        WHERE pis.tipo_persona = 1 AND i.tipo_caso = 35 AND i.id = $idCaso";
      mysqli_next_result($con);

      $consultarSMS = mysqli_query($con, $querySMS);

      if(mysqli_num_rows($consultarSMS) > 0){
        $respuesta['ObsSMS'] = true;
      }else{
        $respuesta['ObsSMS'] = false;
      }
  
    return json_encode($respuesta);
}


function eliminarMultimediaInvestigacion($idRegistro,$idUsuario){
global $con;
  $consultarInfoMultimedia="CALL manejoMultimediaInvestigaciones (3,'','','','".$idRegistro."','',@resp)";
  $queryInfoMultimedia=mysqli_query($con,$consultarInfoMultimedia);
  $resInfoMultimedia=mysqli_fetch_assoc($queryInfoMultimedia);
  $consultarEliminarMultimedia="CALL manejoMultimediaInvestigaciones (2,'','".$resInfoMultimedia["id_investigacion"]."','','".$idRegistro."','".$idUsuario."',@resp)";
  mysqli_next_result($con);

  if (mysqli_query($con,$consultarEliminarMultimedia)){
    unlink("../data/multimedia/".$resInfoMultimedia["ruta"]);
    $consultaRespuestaEliminarMultimedia=mysqli_query($con,"SELECT @resp as resp");
    $respEliminarMultimedia=mysqli_fetch_assoc($consultaRespuestaEliminarMultimedia);
    $variable=$respEliminarMultimedia["resp"]; 
  }else{
    $variable=2;
  }
  return ($variable);
}

function eliminarCasoSOAT($idRegistro,$idUsuario){
  
  global $con;

  /*$consultarEliminarCaso="CALL manejoInvestigacionesSOAT (7,'','','','','','','','','','','','".$idUsuario."','".$idRegistro."','','','','','','','','',@resp,@resp2,@resp3)";

  if (mysqli_query($con,$consultarEliminarCaso)){
    $consultaRespuestaEliminarCaso=mysqli_query($con,"SELECT @resp as resp");
    $respEliminarCaso=mysqli_fetch_assoc($consultaRespuestaEliminarCaso);
    $variable=$respEliminarCaso["resp"];
  }else{
    $variable=2;
  }*/
   $sqlInsertTrash[1] = "INSERT INTO siglo_trash.detalle_investigaciones_soat SELECT * FROM siglo.detalle_investigaciones_soat WHERE siglo.detalle_investigaciones_soat.id_investigacion = $idRegistro;";  
  $sqlInsertTrash[2] = "INSERT INTO siglo_trash.personas_investigaciones_soat SELECT * FROM siglo.personas_investigaciones_soat WHERE siglo.personas_investigaciones_soat.id_investigacion = $idRegistro;";
  $sqlInsertTrash[3] = "INSERT INTO siglo_trash.investigaciones SELECT * FROM siglo.investigaciones WHERE siglo.investigaciones.id = $idRegistro;";
  $sqlInsertTrash[4] = "INSERT INTO siglo_trash.autorizacion_investigacion SELECT * FROM siglo.autorizacion_investigacion WHERE siglo.autorizacion_investigacion.id_investigacion = $idRegistro;";
  $sqlInsertTrash[5] = "INSERT INTO siglo_trash.id_casos_aseguradora SELECT * FROM siglo.id_casos_aseguradora WHERE siglo.id_casos_aseguradora.id_investigacion = $idRegistro;";
  $sqlInsertTrash[6] = "INSERT INTO siglo_trash.control_cargue SELECT * FROM siglo.control_cargue WHERE siglo.control_cargue.id_investigacion = $idRegistro;";
  $sqlInsertTrash[7] = "INSERT INTO siglo_trash.control_cargues SELECT * FROM siglo.control_cargues WHERE siglo.control_cargues.id_investigacion = $idRegistro;";
  $sqlInsertTrash[8] = "INSERT INTO siglo_trash.observaciones_secciones_informe SELECT * FROM siglo.observaciones_secciones_informe WHERE siglo.observaciones_secciones_informe.id_investigacion = $idRegistro;";
  $sqlInsertTrash[9] = "INSERT INTO siglo_trash.estado_investigaciones SELECT * FROM siglo.estado_investigaciones WHERE siglo.estado_investigaciones.id_investigacion = $idRegistro;";
  $sqlInsertTrash[10] = "INSERT INTO siglo_trash.multimedia_investigacion SELECT * FROM siglo.multimedia_investigacion WHERE siglo.multimedia_investigacion.id_investigacion = $idRegistro;";
  //$sqlInsertTrash[11] = "INSERT INTO siglo_trash.personas_diligencia_formato_declaracion SELECT * FROM siglo.personas_diligencia_formato_declaracion WHERE siglo.personas_diligencia_formato_declaracion.id_investigacion = $idRegistro;";
  //$sqlInsertTrash[12] = "INSERT INTO siglo_trash.censo_investigador SELECT * FROM siglo.censo_investigador WHERE siglo.censo_investigador.id_investigacion = $idRegistro;";

  $sqlEliminarCaso[1] = "DELETE FROM detalle_investigaciones_soat WHERE id_investigacion = $idRegistro;";  
  $sqlEliminarCaso[2] = "DELETE FROM personas_investigaciones_soat WHERE id_investigacion = $idRegistro;";
  $sqlEliminarCaso[3] = "DELETE FROM investigaciones WHERE id = $idRegistro;";
  $sqlEliminarCaso[4] = "DELETE FROM autorizacion_investigacion WHERE id_investigacion = $idRegistro;";
  $sqlEliminarCaso[5] = "DELETE FROM id_casos_aseguradora WHERE id_investigacion = $idRegistro;";
  $sqlEliminarCaso[6] = "DELETE FROM control_cargue WHERE id_investigacion = $idRegistro;";
  $sqlEliminarCaso[7] = "DELETE FROM control_cargues WHERE id_investigacion = $idRegistro;";
  $sqlEliminarCaso[8] = "DELETE FROM observaciones_secciones_informe WHERE id_investigacion = $idRegistro;";
  $sqlEliminarCaso[9] = "DELETE FROM estado_investigaciones WHERE id_investigacion = $idRegistro;"; 
  $sqlEliminarCaso[10] = "DELETE FROM multimedia_investigacion WHERE id_investigacion = $idRegistro;";
  //$sqlEliminarCaso[11] = "DELETE FROM personas_diligencia_formato_declaracion WHERE id_investigacion = $idRegistro;";
  //$sqlEliminarCaso[12] = "DELETE FROM censo_investigador WHERE id_investigacion = $idRegistro;";

  $errorText="";
  $errores = 0;

  mysqli_query($con,"INSERT INTO estado_investigaciones (id_investigacion, estado, vigente, inicial, usuario, fecha) VALUES ($idRegistro, 14, 'n', 'n', $idUsuario, CURRENT_TIMESTAMP());");

  for ($i=1; $i <= count($sqlInsertTrash); $i++) { 
    if(mysqli_query($con,$sqlInsertTrash[$i])){

      if($i == 10){

        $consultaMultimedia = mysqli_query($con,"SELECT ruta FROM multimedia_investigacion WHERE id_investigacion = $idRegistro;");
        
        while ($rowRuta=mysqli_fetch_array($consultaMultimedia,MYSQLI_ASSOC)){
          
          if(file_exists ($rowRuta["ruta"])){
            $rutaTemp = explode("https://globalredltda.co/siglo/portal/data/", $rowRuta["ruta"]);
            $rutaTrash = "";
            if(isset($rutaTemp[1])){
              $rutaTrash = "https://globalredltda.co/siglo/portal/trash/".$rutaTemp[1];
            }

            if(copy($rowRuta["ruta"],$rutaTrash)){
              unlink($rowRuta["ruta"]);
            }
          }
        }
      }

      if(!mysqli_query($con,$sqlEliminarCaso[$i])){
        $errorText.="R:".$i."=Error2__";
        $errores++;
      } 
    }else{
      $errorText.="R:".$i."=Error1__";
      $errores++;
    }  
  }

  if ($errores==0){
    $variable=1;
  }else{
    $variable=$errorText;
  }

  return ($variable);
}


function modificarCasoSOAT($fecha_conocimiento,$barrio_accidente,$aseguradoraFrmCasosGM,$tipoCasoFrmCasosGM,$fechaAccidenteFrmCasosGM,$lugarAccidenteFrmCasosGM,$ciudadFrmCasosGM,$tipoZonaFrmCasosGM,$investigadorFrmCasosGM,$idCasoFrmCasosGM,$usuario,$identificadoresCaso,$idCaso,$tipoAuditoriaFrmCasosGM,$diasDeInvestigadorFrmCasosGM){
     
     global $con;
     $modificarCasoSOAT = "CALL manejoInvestigacionesSOAT (5,'".$tipoCasoFrmCasosGM."','".$aseguradoraFrmCasosGM."', '".$fechaAccidenteFrmCasosGM."', '".$lugarAccidenteFrmCasosGM."', '".$ciudadFrmCasosGM."', '".$tipoZonaFrmCasosGM."','".$investigadorFrmCasosGM."','','','".$barrio_accidente."','".$fecha_conocimiento."','".$usuario."','".$idCaso."','','','','','','','','',@resp,@resp2,@resp3)";

     if (mysqli_query($con,$modificarCasoSOAT))
      {

          $consultaRespuestaModificarCasoSOAT=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
          $respModificarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaModificarCasoSOAT);

          $eliminarIdenticadoresCasoSOAT="CALL manejoInvestigacionesSOAT (2,'','','','','','','','','','','','".$usuario."','".$idCaso."','','','','','','','','',@resp,@resp2,@resp3)";
          mysqli_query($con,$eliminarIdenticadoresCasoSOAT);

           $identificadoresCasosConvertidos=json_decode($identificadoresCaso);
              foreach($identificadoresCasosConvertidos as $passIdentificadoresCasosConvertidos)
              {
                  $insertarIdenticadoresCasoSOAT="CALL manejoInvestigacionesSOAT (3,'','','','','','','','','".$passIdentificadoresCasosConvertidos->identificador."','".$passIdentificadoresCasosConvertidos->fecha_asignacion."','".$passIdentificadoresCasosConvertidos->fecha_entrega."','".$usuario."','".$idCaso."','','','','','','','','',@resp,@resp2,@resp3)";
                  mysqli_query($con,$insertarIdenticadoresCasoSOAT);
                                  
              }

          mysqli_query($con,"UPDATE investigaciones SET dias_investigador = '$diasDeInvestigadorFrmCasosGM', id_tipo_auditoria = '$tipoAuditoriaFrmCasosGM' WHERE id = ".$idCaso);

          $respuesta["codigo"]=$respModificarCasoSOAT["resp3"];
          $respuesta["caso"]=$respModificarCasoSOAT["resp2"];
          $respuesta["respuesta"]=$respModificarCasoSOAT["resp"];  
      }
      else
      {
         $respuesta["respuesta"]=2;
      }
      
     return json_encode($respuesta);
}

function registrarCasoSOAT($fecha_conocimiento,$barrio_accidente,$aseguradoraFrmCasosGM,$tipoCasoFrmCasosGM,$fechaAccidenteFrmCasosGM,$lugarAccidenteFrmCasosGM,$ciudadFrmCasosGM,$tipoZonaFrmCasosGM,$investigadorFrmCasosGM,$idCasoFrmCasosGM,$usuario,$identificadoresCaso, $tipoAuditoriaFrmCasosGM, $diasDeInvestigadorFrmCasosGM){
  
  global $con;

  $respuesta=array();
  //Barrio y fecha de conocimiento se reciben en los parametros
  //del procedimiento en fecha de inicio y fecha de entrega
  $insertarCasoSOAT = "CALL manejoInvestigacionesSOAT (1,'".$tipoCasoFrmCasosGM."','".$aseguradoraFrmCasosGM."', '".$fechaAccidenteFrmCasosGM."', '".$lugarAccidenteFrmCasosGM."', '".$ciudadFrmCasosGM."', '".$tipoZonaFrmCasosGM."','".$investigadorFrmCasosGM."','".$usuario."','','".$barrio_accidente."','".$fecha_conocimiento."','".$usuario."','','','','','','','','','',@resp,@resp2,@resp3)";

  if (mysqli_query($con,$insertarCasoSOAT)){

    $consultaRespuestaInsertarCasoSOAT=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2, @resp3 as resp3");
    $respInsertarCasoSOAT=mysqli_fetch_assoc($consultaRespuestaInsertarCasoSOAT);

    $eliminarIdenticadoresCasoSOAT="CALL manejoInvestigacionesSOAT (2,'','','','','','','','','','','','".$usuario."','".$respInsertarCasoSOAT["resp2"]."','','','','','','','','',@resp,@resp2,@resp3)";
    mysqli_query($con,$eliminarIdenticadoresCasoSOAT);
    $identificadoresCasosConvertidos=json_decode($identificadoresCaso);

    foreach($identificadoresCasosConvertidos as $passIdentificadoresCasosConvertidos){
      $insertarIdenticadoresCasoSOAT="CALL manejoInvestigacionesSOAT (3,'','','','','','','','','".$passIdentificadoresCasosConvertidos->identificador."','".$passIdentificadoresCasosConvertidos->fecha_asignacion."','".$passIdentificadoresCasosConvertidos->fecha_entrega."','".$usuario."','".$respInsertarCasoSOAT["resp2"]."','','','','','','','','',@resp,@resp2,@resp3)";
      mysqli_query($con,$insertarIdenticadoresCasoSOAT);
    }

    mysqli_query($con,"UPDATE investigaciones SET dias_investigador = '$diasDeInvestigadorFrmCasosGM', id_tipo_auditoria = '$tipoAuditoriaFrmCasosGM' WHERE id = ".$respInsertarCasoSOAT["resp2"]);

    $respuesta["codigo"]=$respInsertarCasoSOAT["resp3"];
    $respuesta["caso"]=$respInsertarCasoSOAT["resp2"];
    $respuesta["respuesta"]=$respInsertarCasoSOAT["resp"];  
  }
  else{
    $respuesta["respuesta"]=2;
  }

  return json_encode($respuesta);
}

function consultarCasoSOAT($idCaso){
     
      global $con;

      $respuesta=array();
      $consultarCasoSOAT = "CALL manejoInvestigacionesSOAT (4,'','','','','','','','','','','','','".$idCaso."','','','','','','','','',@resp,@resp2,@resp3)";

      $queryCasoSOAT=mysqli_query($con,$consultarCasoSOAT);
      @$respCasoSOAT=mysqli_fetch_assoc($queryCasoSOAT);
      
      $respuesta["id"]=$respCasoSOAT["id"];
      $respuesta["tipo_caso"]=$respCasoSOAT["tipo_caso"];  
      $respuesta["id_aseguradora"]=$respCasoSOAT["id_aseguradora"];  
      $respuesta["id_investigador"]=$respCasoSOAT["id_investigador"];  
      $respuesta["fecha_accidente"]=$respCasoSOAT["fecha_accidente"];  
      $respuesta["lugar_accidente"]=$respCasoSOAT["lugar_accidente"];  
      $respuesta["ciudad_ocurrencia"]=$respCasoSOAT["ciudad_ocurrencia"];  
      $respuesta["id_usuario"]=$respCasoSOAT["id_usuario"];  
      $respuesta["tipo_zona"]=$respCasoSOAT["tipo_zona"];  
      $respuesta["tipo_general_caso"]=$respCasoSOAT["tipo_general_caso"];  
      $respuesta["tipo_caso_informe"]=$respCasoSOAT["tipo_caso_informe"];  
      $respuesta["id_tipo_auditoria"]=$respCasoSOAT["id_tipo_auditoria"];
      $respuesta["dias_investigador"]=$respCasoSOAT["dias_investigador"];
      $respuesta["placa_temp"]=$respCasoSOAT["placa_temp"];
      $respuesta["barrio_accidente"]=$respCasoSOAT["barrio_accidente"];
      $respuesta["fecha_conocimiento"]=$respCasoSOAT["fecha_conocimiento"];
      
     return ($respuesta);

}


function asignarAnalistaCaso($idAnalista,$idCasoSoat,$idUsuario)
{
    global $con;

      $consultarAsignarAnalistaCaso="CALL manejoInvestigacionesSOAT (6,'','','','','','','','".$idAnalista."','','','','".$idUsuario."','".$idCasoSoat."','','','','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarAsignarAnalistaCaso))
    {
      mysqli_next_result($con);
      $consultaRespuestaAsignarAnalistaCaso=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarCaso=mysqli_fetch_assoc($consultaRespuestaAsignarAnalistaCaso);
      $variable=$respEliminarCaso["resp"];

      
    }else{
      $variable=2;
    }
          return ($variable);
}






function subirArchivoMultimediaInvestigacion($archivoMultimedia1,$archivoMultimedia2,$idInvestigacion,$seccionMultimediaFrmMultimedia,$idUsuario)
{
  global $con;
  $data=array();
  $var1=0;
  $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
  $permitidos2 = array("audio/mp3", "audio/wma","application/octet-stream","audio/m4a","audio/x-m4a");

  if ($seccionMultimediaFrmMultimedia==12 || $seccionMultimediaFrmMultimedia==13 || $seccionMultimediaFrmMultimedia==15)
  {
    mysqli_next_result($con);
    $consultaCantidadMultimedia=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$idInvestigacion."' and id_multimedia='".$seccionMultimediaFrmMultimedia."'");
    if (mysqli_num_rows($consultaCantidadMultimedia)>2)
    {
      $var1=2;
      $data["resultado1"]=6;
    }
    else
    {
      $var1=1;
    }
  }

  else
  {
    $var1=1;
  }
  if ($var1==1 && $seccionMultimediaFrmMultimedia<>15)
  {
    if (!empty($archivoMultimedia1))
    {
      if (in_array($archivoMultimedia1['type'], $permitidos))
      {

        $extension=explode("/",$archivoMultimedia1['type']);
        $archivo=base64_encode($seccionMultimediaFrmMultimedia."-".$idInvestigacion.rand()).".".$extension[1];
        $data["ruta"]='data/multimedia/'.$archivo;

        if ( move_uploaded_file($archivoMultimedia1['tmp_name'], "../data/multimedia/".$archivo)) 
        {

          $consultaSubirMultimedia="CALL manejoMultimediaInvestigaciones (1,'".$archivo."','".$idInvestigacion."','".$seccionMultimediaFrmMultimedia."','','".$idUsuario."',@resp)";


          if (mysqli_query($con,$consultaSubirMultimedia))
          {

            $consultaRespuestaSubirMultimedia=mysqli_query($con,"SELECT @resp as resp");
            $respSubirMultimedia=mysqli_fetch_assoc($consultaRespuestaSubirMultimedia);
            $variable=$respSubirMultimedia["resp"];


          }else{
            $variable=2;
          }


        }
        else
        {
          $variable=31;
        } 

      }
      else
      {
        $variable=4;
      }
    }else{
      $variable=5;
    }



    if (!empty($archivoMultimedia2))
    {
      if (in_array($archivoMultimedia2['type'], $permitidos))
      {
        $extension2=explode("/",$archivoMultimedia2['type']);
        $archivo=base64_encode($seccionMultimediaFrmMultimedia."-".$idInvestigacion.rand()).".".$extension2[1];
        $data["ruta2"]='data/multimedia/'.$archivo;

        if ( move_uploaded_file($archivoMultimedia2['tmp_name'], "../data/multimedia/".$archivo)) 
        {

          $consultaSubirMultimedia2="CALL manejoMultimediaInvestigaciones (1,'".$archivo."','".$idInvestigacion."','".$seccionMultimediaFrmMultimedia."','','".$idUsuario."',@resp)";


          if (mysqli_query($con,$consultaSubirMultimedia2))
          {

            $consultaRespuestaSubirMultimedia2=mysqli_query($con,"SELECT @resp as resp");
            $respSubirMultimedia2=mysqli_fetch_assoc($consultaRespuestaSubirMultimedia2);
            $variable1=$respSubirMultimedia2["resp"];


          }else{
            $variable1=2;
          }


        }else{
          $variable1=32;
        } 

      }else{
        $variable1=4;
      }
    }else{
      $variable1=5;
    }
    $data["resultado1"]=$variable;
    $data["resultado2"]=$variable1;
  }
  else  if ($var1==1 && $seccionMultimediaFrmMultimedia==15)
  {
    if (!empty($archivoMultimedia1))
    {

      $extension=explode("/",$archivoMultimedia1['type']);
      $archivo=$archivoMultimedia1['name'];
      $ext = pathinfo($archivo);
      $archivo=base64_encode($seccionMultimediaFrmMultimedia."-".$idInvestigacion.rand()).".".$ext["extension"];
      $data["ruta"]='data/audios/'.$archivo;

      if ( move_uploaded_file($archivoMultimedia1['tmp_name'], "../data/audios/".$archivo)) 
      {

        $consultaSubirMultimedia="CALL manejoMultimediaInvestigaciones (1,'".$archivo."','".$idInvestigacion."','".$seccionMultimediaFrmMultimedia."','','".$idUsuario."',@resp)";


        if (mysqli_query($con,$consultaSubirMultimedia))
        {

          $consultaRespuestaSubirMultimedia=mysqli_query($con,"SELECT @resp as resp");
          $respSubirMultimedia=mysqli_fetch_assoc($consultaRespuestaSubirMultimedia);
          if ($respSubirMultimedia["resp"]==1)
          {
            $variable=7;
          }else{
            $variable=8;
          }



        }else{
          $variable=2;
        }


      }
      else
      {
        $variable=33;
      } 


    }else{
      $variable=5;
    }



    mysqli_next_result($con);
    if (!empty($archivoMultimedia2))
    {

      $extension2=explode("/",$archivoMultimedia2['type']);
      $archivo=$archivoMultimedia2['name'];
      $ext2 = pathinfo($archivo);
      $archivo2=base64_encode($seccionMultimediaFrmMultimedia."-".$idInvestigacion.rand()).".".$ext2["extension"];
      $data["ruta"]='data/audios/'.$archivo2;

      if ( move_uploaded_file($archivoMultimedia2['tmp_name'], "../data/audios/".$archivo2)) 
      {

        $consultaSubirMultimedia2="CALL manejoMultimediaInvestigaciones (1,'".$archivo2."','".$idInvestigacion."','".$seccionMultimediaFrmMultimedia."','','".$idUsuario."',@resp)";


        if (mysqli_query($con,$consultaSubirMultimedia2))
        {

          $consultaRespuestaSubirMultimedia2=mysqli_query($con,"SELECT @resp as resp");
          $respSubirMultimedia2=mysqli_fetch_assoc($consultaRespuestaSubirMultimedia2);
          if ($respSubirMultimedia2["resp"]==1)
          {
            $variable1=7;
          }else{
            $variable1=8;
          }
        }else{
          $variable1=2;
        }


      }
      else
      {
        $variable1=34;
      } 


    }else{
      $variable1=5;
    }
    $data["resultado1"]=$variable;
    $data["resultado2"]=$variable1;
    $data["resultado3"]=$archivoMultimedia1['type'];
  }




  return ($data);
}

function consultarObservacionesInformeInvestigaciones($idObservaciones)
{
  global $con;

    $respuesta=array();
    $consultarObservacionesInforme = "CALL manejoInvestigacionesSOAT (15,'','','','','','','','','','','','','".$idObservaciones."','','','','','','','','',@resp,@resp2,@resp3)";

      $queryObservacionesInforme=mysqli_query($con,$consultarObservacionesInforme);
      $respObservacionesInforme=mysqli_fetch_assoc($queryObservacionesInforme);


          $respuesta["id_observacion"]=$respObservacionesInforme["id"];
          $respuesta["id_investigacion"]=$respObservacionesInforme["id_investigacion"];  
          $respuesta["observacion"]=$respObservacionesInforme["observacion"];  
          $respuesta["id_seccion"]=$respObservacionesInforme["id_seccion"];  
   
     return ($respuesta);
}


function registrarObservacionesInformeInvestigaciones($idInvestigacion,$idSeccionInforme,$descripcionObservacion,$idUsuario)
{
    global $con;

      $consultarRegistrarObservacionesInforme="CALL manejoInvestigacionesSOAT (16,'','','','','','','','','','','','".$idUsuario."','','".$idSeccionInforme."','".$idInvestigacion."','".$descripcionObservacion."','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarRegistrarObservacionesInforme))
    {
      mysqli_next_result($con);
      $consultaRespuestaRegistrarObservacionesInforme=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarObservacionesInforme=mysqli_fetch_assoc($consultaRespuestaRegistrarObservacionesInforme);
      $variable=$respRegistrarObservacionesInforme["resp"];

      
    }else{
      $variable=2;
    }
          return ($variable);
}

function modificarObservacionesInformeInvestigaciones($idObservaciones,$idInvestigacion,$idSeccionInforme,$descripcionObservacion)
{
   global $con;

      $consultarModificarObservacionesInforme="CALL manejoInvestigacionesSOAT (17,'','','','','','','','','','','','','".$idObservaciones."','".$idSeccionInforme."','".$idInvestigacion."','".$descripcionObservacion."','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarModificarObservacionesInforme))
    {
      mysqli_next_result($con);
      $consultaRespuestaModificarObservacionesInforme=mysqli_query($con,"SELECT @resp as resp");
      $respModificarObservacionesInforme=mysqli_fetch_assoc($consultaRespuestaModificarObservacionesInforme);
      $variable=$respModificarObservacionesInforme["resp"];

      
    }else{
      $variable=2;
    }
          return ($variable);
}


function eliminarObservacionInformeInvestigacion($idObservaciones)
{
      global $con;

      $consultarEliminarObservacionesInforme="CALL manejoInvestigacionesSOAT (18,'','','','','','','','','','','','','".$idObservaciones."','','','','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarEliminarObservacionesInforme))
    {
      mysqli_next_result($con);
      $consultaRespuestaEliminarObservacionesInforme=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarObservacionesInforme=mysqli_fetch_assoc($consultaRespuestaEliminarObservacionesInforme);
      $variable=$respEliminarObservacionesInforme["resp"];

      
    }else{
      $variable=2;
    }
          return ($variable);
}


function registrarTestigoInforme($idInvestigacionTestigos,$idPersona,$usuario)
{
     global $con;

      $consultarRegistrarTestigoInforme="CALL manejoInvestigacionesSOAT (19,'','','','','','','','','','','','".$usuario."','','".$idPersona."','".$idInvestigacionTestigos."','','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarRegistrarTestigoInforme))
    {
      mysqli_next_result($con);
      $consultaRespuestaRegistrarTestigoInforme=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarTestigoInforme=mysqli_fetch_assoc($consultaRespuestaRegistrarTestigoInforme);
      $variable=$respRegistrarTestigoInforme["resp"];

      
    }else{
      $variable=2;
    }
          return ($variable);
}


function eliminarTestigoInformeInvestigacion($idTestigo)
{
      global $con;

      $consultarEliminarTestigoInforme="CALL manejoInvestigacionesSOAT (20,'','','','','','','','','','','','','".$idTestigo."','','','','','','','','',@resp,@resp2,@resp3)";

    if (mysqli_query($con,$consultarEliminarTestigoInforme))
    {
      mysqli_next_result($con);
      $consultaRespuestaEliminarTestigoInforme=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarTestigoInforme=mysqli_fetch_assoc($consultaRespuestaEliminarTestigoInforme);
      $variable=$respEliminarTestigoInforme["resp"];

      
    }else{
      $variable=2;
    }
          return ($variable);
}



function seleccionarLesionadoDiligenciaFormato($idLesionado,$idInvestigacion,$fechaDiligenciaFormatoFrm){
  global $con;
  $consultaSeleccionarLesionadoDiligencia="CALL manejoInvestigacionesSOAT (21,'','','','',0,0,0,0,'','','".$fechaDiligenciaFormatoFrm."','','".$idInvestigacion."','1','".$idLesionado."','','','','','','',@resp,@resp2,@resp3)";

  if (mysqli_query($con,$consultaSeleccionarLesionadoDiligencia)){
    mysqli_next_result($con);
    $consultaRespuestaSeleccionarLesionadoDiligencia=mysqli_query($con,"SELECT @resp as resp");
    $respSeleccionarLesionadoDiligencia=mysqli_fetch_assoc($consultaRespuestaSeleccionarLesionadoDiligencia);
    $variable=$respSeleccionarLesionadoDiligencia["resp"];
  }else{
    $variable=2;
  }
  return ($variable);
}

function guardarPersonaDiligenciaFormato($nombreAcompanante,$tipoIdentificacionAcompanante,$identificacionAcompanante,$telefonoAcompanante,$direccionAcompanante,$relacionAcompanante,$idUsuario,$idInvestigacion,$opcionDiligenciaFormato,$fechaDiligenciaFormatoFrm){
  global $con;
  $consultaGuardarPersonaDiligencia="CALL manejoInvestigacionesSOAT (21,'','','','','','','','','','','".$fechaDiligenciaFormatoFrm."','".$idUsuario."','".$idInvestigacion."','".$opcionDiligenciaFormato."','".$nombreAcompanante."','".$relacionAcompanante."','".$telefonoAcompanante."','".$direccionAcompanante."','".$tipoIdentificacionAcompanante."','".$identificacionAcompanante."','',@resp,@resp2,@resp3)";
  if (mysqli_query($con,$consultaGuardarPersonaDiligencia))
    {
      mysqli_next_result($con);
      $consultaRespuestaGuardarPersonaDiligencia=mysqli_query($con,"SELECT @resp as resp");
      $respGuardarPersonaDiligencia=mysqli_fetch_assoc($consultaRespuestaGuardarPersonaDiligencia);
      $variable=$respGuardarPersonaDiligencia["resp"];

      
    }else{
      $variable=2;
    }

    return ($variable);
}


function seleccionarInvestigadorDiligenciaFormato($idInvestigacion,$opcionDiligenciaFormato,$fechaDiligenciaFormatoFrm)
{
  global $con;
  $consultaSeleccionarInvestigadorDiligenciaFormato="CALL manejoInvestigacionesSOAT (21,'','','','','','','','','','','".$fechaDiligenciaFormatoFrm."','','".$idInvestigacion."','".$opcionDiligenciaFormato."','','','','','','','',@resp,@resp2,@resp3)";
  if (mysqli_query($con,$consultaSeleccionarInvestigadorDiligenciaFormato))
    {
      mysqli_next_result($con);
      $consultaSeleccionarInvestigadorDiligenciaFormato=mysqli_query($con,"SELECT @resp as resp");
      $respSeleccionarInvestigadorDiligenciaFormato=mysqli_fetch_assoc($consultaSeleccionarInvestigadorDiligenciaFormato);
      $variable=$respSeleccionarInvestigadorDiligenciaFormato["resp"];

      
    }else{
      $variable=2;
    }

    return ($variable);
}

function guardarObservacionesDiligenciaFormato($idInvestigacion,$opcionDiligenciaFormato,$observacionDiligenciaFormato,$fechaDiligenciaFormatoFrm)
{
  global $con;
  $consultaGuardarObservacionesDiligenciaFormato="CALL manejoInvestigacionesSOAT (21,'','','','','','','','','','','".$fechaDiligenciaFormatoFrm."','','".$idInvestigacion."','".$opcionDiligenciaFormato."','".$observacionDiligenciaFormato."','','','','','','',@resp,@resp2,@resp3)";
  if (mysqli_query($con,$consultaGuardarObservacionesDiligenciaFormato))
    {
      mysqli_next_result($con);
      $consultaGuardarObservacionesDiligenciaFormato=mysqli_query($con,"SELECT @resp as resp");
      $respGuardarObservacionesDiligenciaFormato=mysqli_fetch_assoc($consultaGuardarObservacionesDiligenciaFormato);
      $variable=$respGuardarObservacionesDiligenciaFormato["resp"];

      
    }else{
      $variable=2;
    }

    return ($variable);
}


function consultarPersonaDiligenciaFormato($idInvestigacion)
{
  global $con;

    $respuesta=array();
    $consultarPersonaDiligenciaFormato = "CALL manejoInvestigacionesSOAT (22,'','','','','','','','','','','','','".$idInvestigacion."','','','','','','','','',@resp,@resp2,@resp3)";
      
      $queryPersonaDiligenciaFormato=mysqli_query($con,$consultarPersonaDiligenciaFormato);
      $respPersonaDiligenciaFormato=mysqli_fetch_assoc($queryPersonaDiligenciaFormato);
        $respuesta["diligencia_formato_declaracion"]=$respPersonaDiligenciaFormato["diligencia_formato_declaracion"];
        $respuesta["fecha_diligencia_formato_declaracion"]=$respPersonaDiligenciaFormato["fecha_diligencia_formato_declaracion"];
        if ($respuesta["diligencia_formato_declaracion"]==2){
           $respuesta["nombre"]=$respPersonaDiligenciaFormato["nombre"];
           $respuesta["relacion"]=$respPersonaDiligenciaFormato["relacion"];
           $respuesta["telefono"]=$respPersonaDiligenciaFormato["telefono"];
           $respuesta["direccion"]=$respPersonaDiligenciaFormato["direccion"];
           $respuesta["tipo_identificacion"]=$respPersonaDiligenciaFormato["tipo_identificacion"];
           $respuesta["identificacion"]=$respPersonaDiligenciaFormato["identificacion"];
        }
        else if ($respuesta["diligencia_formato_declaracion"]==4 || $respuesta["diligencia_formato_declaracion"]==5)
        {
           $respuesta["observacion_diligencia_formato_declaracion"]=$respPersonaDiligenciaFormato["observacion_diligencia_formato_declaracion"];          
        }
  
     return ($respuesta);
}

function consultarInformacionAsignacion($idInvestigacion)
{
  global $con;

    $data=array();
    $consultarInformacionInvestigacion="SELECT b.descripcion as tipo_general_caso,a.* FROM investigaciones a LEFT JOIN definicion_tipos b ON a.tipo_caso=b.descripcion2 WHERE b.id_tipo=31 and a.id='".$idInvestigacion."'";
    $queryInformacionInvestigacion=mysqli_query($con,$consultarInformacionInvestigacion);
    $resInformacionInvestigacion=mysqli_fetch_assoc($queryInformacionInvestigacion);
    mysqli_next_result($con);
    $consultarSoporteInvestigacion="SELECT * FROM multimedia_investigacion WHERE id_multimedia='10'";
    $querySoporteInvestigacion=mysqli_query($con,$consultarSoporteInvestigacion);
    $resSoporteInvestigacion=mysqli_fetch_assoc($querySoporteInvestigacion);
    $data["tipo_caso"]=$resInformacionInvestigacion["tipo_caso"];
    $data["rutaSoporte"]=$resSoporteInvestigacion["ruta"];
    $data["fecha_entrega"]=$resInformacionInvestigacion["fecha_entrega"];
    if ($resInformacionInvestigacion["tipo_general_caso"]==5)
    {
      mysqli_next_result($con);
      $consultarDetalleValidacionesIPS="SELECT * FROM detalle_investigaciones_validaciones WHERE id_investigacion='".$idInvestigacion."'";
      $queryDetalleValidacionesIPS=mysqli_query($con,$consultarDetalleValidacionesIPS);
      $resDetalleValidacionesIPS=mysqli_fetch_assoc($queryDetalleValidacionesIPS);
      mysqli_next_result($con);
      $consultarCPInvestigacion="SELECT * FROM multimedia_investigacion WHERE id_multimedia='11'";
      $queryCPInvestigacion=mysqli_query($con,$consultarCPInvestigacion);
      $resCPInvestigacion=mysqli_fetch_assoc($queryCPInvestigacion);
     
      $data["motivo_investigacion"]=$resDetalleValidacionesIPS["motivo_investigacion"];
      $data["rutaCP"]=$resCPInvestigacion["ruta"];
    }
    else if ($resInformacionInvestigacion["tipo_general_caso"]==1 || $resInformacionInvestigacion["tipo_general_caso"]==2 || $resInformacionInvestigacion["tipo_general_caso"]==3 || $resInformacionInvestigacion["tipo_general_caso"]==4)
    {
      mysqli_next_result($con);
      $consultarDetalleSOAT="SELECT * FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."'";
      $queryDetalleSOAT=mysqli_query($con,$consultarDetalleSOAT);
      $resDetalleSOAT=mysqli_fetch_assoc($queryDetalleSOAT);
      
      $data["motivo_investigacion"]=$resDetalleSOAT["motivo_investigacion"];
    }
    return ($data);
}

function consultarDatosPersona($tipoIdentificacion, $identificacion){
  
  global $con;

  $respuesta=array();
  $consultarPersona = "SELECT * FROM personas a WHERE a.tipo_identificacion = $tipoIdentificacion AND a.identificacion = '$identificacion'";

  if($queryPersona=mysqli_query($con,$consultarPersona)){
    
    if(mysqli_num_rows($queryPersona)){
      
      $respPersona=mysqli_fetch_assoc($queryPersona);
      $resp["respuesta"] = 1;
      
      if($respPersona["apellidos"]){
        $resp["nombre"]=$respPersona["nombres"]." ".$respPersona["apellidos"];
      }else{
        $resp["nombre"]=$respPersona["nombres"];
      }
      
      $resp["tipo_identificacion"]=$respPersona["tipo_identificacion"];
      $resp["identificacion"]=$respPersona["identificacion"];
      $resp["telefono"]=$respPersona["telefono"];
      $resp["direccion"]=$respPersona["direccion_residencia"];
      $resp["ciudad_residencia"]=$respPersona["ciudad_residencia"];
    }else{
      $resp["respuesta"] = 2;
    }
  }else{
    $resp["respuesta"] = 3;
  }

  return json_encode($resp);
}

function RegistrarProcesosJuridicos ($selectaseguradorasProcesoJudicial,$selecttipoCasoProcesoJudicial,$pjPoliza,$pjSiniestro,$fecha_accidente_procesos,$selectciudadProcesoJudicial,$pjPlaca,$selectpjTipoId,$pjId,$pjNombres,$pjApellidos,$archivo,$pjIdPersona,$pjArticulo) {

  global $con;
  session_start();
  $datos = array();

  $VerificarCaso = "SELECT a.codigo FROM procesos_judiciales a WHERE a.poliza = '$pjPoliza' AND a.siniestro = '$pjSiniestro' AND a.fecha_siniestro = '$fecha_accidente_procesos'";

  $VerificarCaso = mysqli_query($con,$VerificarCaso);
  if(!mysqli_num_rows($VerificarCaso)){

    $ultimoId = "SELECT MAX(id) AS id FROM procesos_judiciales";
    $ultimoId = mysqli_query($con,$ultimoId);
    $ultimoId = mysqli_fetch_assoc($ultimoId);
    $ultimoId = $ultimoId["id"] + 1;
    $arc = explode(".",$archivo['name']);
    $extension=end($arc);
    $nombreArchivo = base64_encode($ultimoId.rand().$pjId).".".$extension;

    if ( move_uploaded_file($archivo['tmp_name'], "../data/informes_procesos_judiciales/".$nombreArchivo)){
      $id = personasProcesoJudicial($pjIdPersona, $pjNombres, $pjApellidos, $selectpjTipoId, $pjId);

      mysqli_next_result($con);

      if($selecttipoCasoProcesoJudicial == 32 || $selecttipoCasoProcesoJudicial == 33){
        $queryRegistrarProcesoJuridico = "INSERT INTO procesos_judiciales (id_aseguradora, id_tipo_caso, poliza, siniestro, fecha_siniestro, id_ciudad, articulo, id_persona, informe, id_usuario, fecha) VALUES ('".$selectaseguradorasProcesoJudicial."', '".$selecttipoCasoProcesoJudicial."', '".$pjPoliza."', '".$pjSiniestro."', '".$fecha_accidente_procesos."', '".$selectciudadProcesoJudicial."', '".$pjArticulo."', '".$id."', '".$nombreArchivo."', '".$_SESSION['id']."', now());";
      }else{
        $queryRegistrarProcesoJuridico = "INSERT INTO procesos_judiciales (id_aseguradora, id_tipo_caso, poliza, siniestro, fecha_siniestro, id_ciudad, placa, id_persona, informe, id_usuario, fecha) VALUES ('".$selectaseguradorasProcesoJudicial."', '".$selecttipoCasoProcesoJudicial."', '".$pjPoliza."', '".$pjSiniestro."', '".$fecha_accidente_procesos."', '".$selectciudadProcesoJudicial."', '".strtoupper($pjPlaca)."', '".$id."', '".$nombreArchivo."', '".$_SESSION['id']."', now());";
      }

      if(mysqli_query($con,$queryRegistrarProcesoJuridico)){
        $ultimoID =  mysqli_insert_id($con);
        $tipoCasoCodigo = mysqli_query($con, "SELECT t.descripcion2 FROM tipo_caso t WHERE t.id =".$selecttipoCasoProcesoJudicial);
        $tipoCasoCodigo = mysqli_fetch_assoc($tipoCasoCodigo);
        $tipoCasoCodigo = $tipoCasoCodigo["descripcion2"];
        $codigo = $tipoCasoCodigo.$ultimoID;
        mysqli_next_result($con);
        $sql = "UPDATE procesos_judiciales SET codigo='".$codigo."' WHERE  id=$ultimoID;";
        mysqli_query($con,$sql);
        $datos['respuesta'] = true;
        $datos['codigo'] = $codigo;
      }else{
        $datos['respuesta'] = false;
        $datos['error'] = "NoInserta";
        unlink("../data/informes_procesos_judiciales/".$nombreArchivo);
      }
    }else{
      echo "no movido";
    }
  }else{
    $datos['respuesta'] = false;
    $datos['error'] = "Existe";
    $codigo = mysqli_fetch_assoc($VerificarCaso);
    $codigo = $codigo["codigo"];
    $datos['codigo'] = $codigo;
  }

  return json_encode($datos);
}

function BuscarProcesosJuridicos($codigo, $poliza, $siniestro, $fecha_siniestro, $identificacion, $nombre, $apellidos, $placa, $articulo){

  global $con;

  $where = "";
  $cont = 0;
  if ($codigo != "") {
    $where = "WHERE a.codigo = '".$codigo."'";
  }else{
    if($poliza != ""){
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " a.poliza = '".$poliza."'";
      $cont++;
    }
    if ($siniestro != "") {
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " a.siniestro = '".$siniestro."'";
      $cont++;
    }
    if ($fecha_siniestro != "") {
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " a.fecha_siniestro = '".$fecha_siniestro."'";
      $cont++;
    }
    if ($identificacion != "") {
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " b.identificacion = '".$identificacion."'";
      $cont++;
    }
    if ($nombre != ""){
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " b.nombres like '%".$nombre."%'";
      $cont++;
    }
    if ($apellidos != "") {
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " b.apellidos like '%".$apellidos."%'";
      $cont++;
    }
    if ($placa != "") {
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " a.placa = '".$placa."'";
      $cont++;
    }
    if ($articulo != "") {
      if($cont == 0){
        $where = " WHERE ";  
      }else{
        $where .= " AND ";
      }
      $where .= " a.articulo like '%".$articulo."%'";
      $cont++;
    }
  }

  $where .= " AND a.activo = 's' AND g.id_tipo = 5";

  $sql = "SELECT a.id, a.codigo, c.descripcion AS tipo_caso, e.nombre_aseguradora, a.poliza, a.siniestro, a.fecha_siniestro, f.nombre AS ciudad, a.placa, b.nombres, b.apellidos, b.identificacion, g.descripcion AS tipo_identificacion, a.informe, a.id_tipo_caso, a.articulo
    FROM procesos_judiciales a
    LEFT JOIN personas b ON b.id = a.id_persona
    LEFT JOIN tipo_caso c ON c.id = a.id_tipo_caso
    LEFT JOIN aseguradoras e ON e.id = a.id_aseguradora
    LEFT JOIN ciudades f ON f.id = a.id_ciudad
    LEFT JOIN definicion_tipos g ON g.id = b.tipo_identificacion ".$where;

  $datos=array();
  $datosConsulta = mysqli_query($con, $sql);

  while ($res=mysqli_fetch_array($datosConsulta,MYSQLI_ASSOC)){
    $datos[]=array(
      "id"=>$res["id"],
      "codigo"=>$res["codigo"],
      "tipo_caso"=>$res["tipo_caso"],
      "aseguradora"=>$res["nombre_aseguradora"],
      "poliza"=>$res["poliza"],
      "siniestro"=>$res["siniestro"],
      "fecha_siniestro"=>$res["fecha_siniestro"],
      "ciudad"=>$res["ciudad"],
      "placa"=>$res["placa"],
      "nombres"=>$res["nombres"],
      "apellidos"=>$res["apellidos"],
      "identificacion"=>$res["identificacion"],
      "tipo_identificacion"=>$res["tipo_identificacion"],
      "informe"=>$res["informe"],
      "id_tipo_caso"=>$res["id_tipo_caso"],
      "articulo"=>$res["articulo"]
    ); 
  }

  return $datos;

}

function consultarProcesoJuridico($idPj){
  global $con;

  $sql = "SELECT a.*, b.id as id_persona_t,b.nombres,b.apellidos,b.tipo_identificacion,b.identificacion
    FROM procesos_judiciales a
    LEFT JOIN personas b ON b.id = a.id_persona
    WHERE a.activo = 's' AND a.id = ".$idPj;
  $consulta = mysqli_query($con, $sql);
  $res = mysqli_fetch_assoc($consulta);

  $datos[]=array(
    "id"=>$res["id"],
    "codigo"=>$res["codigo"],
    "id_tipo_caso"=>$res["id_tipo_caso"],
    "id_aseguradora"=>$res["id_aseguradora"],
    "poliza"=>$res["poliza"],
    "siniestro"=>$res["siniestro"],
    "fecha_siniestro"=>$res["fecha_siniestro"],
    "id_ciudad"=>$res["id_ciudad"],
    "placa"=>$res["placa"],
    "informe"=>$res["informe"],
    "id_persona"=>$res["id_persona"],
    "nombres"=>$res["nombres"],
    "apellidos"=>$res["apellidos"],
    "identificacion"=>$res["identificacion"],
    "tipo_identificacion"=>$res["tipo_identificacion"],
    "articulo"=>$res["articulo"]
  );

  return json_encode($datos);
}

function EditarProcesosJuridicos($idProcesoJuridico,$selectaseguradorasProcesoJudicial,$selecttipoCasoProcesoJudicial,$pjPoliza,$pjSiniestro,$fecha_accidente_procesos,$selectciudadProcesoJudicial,$pjPlaca,$selectpjTipoId,$pjId,$pjNombres,$pjApellidos,$archivo,$pjIdPersona,$nombreArchivoActual,$pjArticulo){

  global $con;
  session_start();
  $datos = array();

  $res1 = false;
  $res2 = false;  
  $id = personasProcesoJudicial($pjIdPersona, $pjNombres, $pjApellidos, $selectpjTipoId, $pjId);

  if($archivo != "NO"){
    unlink("../data/informes_procesos_judiciales/".$nombreArchivoActual);
    if(move_uploaded_file($archivo['tmp_name'], "../data/informes_procesos_judiciales/".$nombreArchivoActual)){
      $res1 = true;
    }
  }else{
    $res1 = true;
  }

  if($selecttipoCasoProcesoJudicial == 32 || $selecttipoCasoProcesoJudicial == 33){
    $actualizarProceso = "UPDATE procesos_judiciales SET id_aseguradora='".$selectaseguradorasProcesoJudicial."', id_tipo_caso='".$selecttipoCasoProcesoJudicial."', poliza='".$pjPoliza."', siniestro='".$pjSiniestro."', fecha_siniestro='".$fecha_accidente_procesos."', id_ciudad='".$selectciudadProcesoJudicial."', placa=NULL, articulo='".$pjArticulo."', id_persona='".$id."', id_usuario='".$_SESSION['id']."' WHERE  id=".$idProcesoJuridico;
  }else{
    $actualizarProceso = "UPDATE procesos_judiciales SET id_aseguradora='".$selectaseguradorasProcesoJudicial."', id_tipo_caso='".$selecttipoCasoProcesoJudicial."', poliza='".$pjPoliza."', siniestro='".$pjSiniestro."', fecha_siniestro='".$fecha_accidente_procesos."', id_ciudad='".$selectciudadProcesoJudicial."', placa='".strtoupper($pjPlaca)."', articulo=NULL, id_persona='".$id."', id_usuario='".$_SESSION['id']."' WHERE  id=".$idProcesoJuridico;
  }
  
  if(mysqli_query($con, $actualizarProceso)){
    $res2 = true;
  }

  if($res1 && $res2){
    $datos["respuesta"] = true;
  }else{
    $datos["respuesta"] = false;
  }


  return json_encode($datos);
}

function personasProcesoJudicial($pjIdPersona, $pjNombres, $pjApellidos, $selectpjTipoId, $pjId){

  global $con;

  if($pjIdPersona == ""){
    $registrarPersona = "INSERT INTO personas (nombres, apellidos, tipo_identificacion, identificacion, usuario, fecha) VALUES ('".strtoupper($pjNombres)."', '".strtoupper($pjApellidos)."', '".$selectpjTipoId."', '".$pjId."', ".$_SESSION['id'].",now())";

    if(mysqli_query($con, $registrarPersona)){
      $id = mysqli_insert_id($con);
    }else{
      //error
      echo "error al crear persona";
    }
  }else{
    $ActualizarPersona = "UPDATE personas SET nombres='".strtoupper($pjNombres)."', apellidos='".strtoupper($pjApellidos)."', tipo_identificacion='".$selectpjTipoId."' WHERE identificacion=".$pjId;
    if (mysqli_query($con, $ActualizarPersona)) {
      mysqli_next_result($con);
      $id = "SELECT id FROM personas p WHERE p.tipo_identificacion = ".$selectpjTipoId." AND p.identificacion = '".$pjId."'";
      $id = mysqli_query($con, $id);
      $id = mysqli_fetch_assoc($id);
      $id = $id["id"];
    }else{
      echo "error al actualizar persona";
    }
  }
  return $id;
}

function denunciarInvestigacion($id_investigacion, $fecha, $observacion){
  global $con;

  $consulta = mysqli_query($con, "SELECT id FROM denuncias WHERE id_investigacion = ".$id_investigacion);
  

  if(mysqli_num_rows($consulta) == 0){
    if($observacion != ""){
      $sql = "INSERT INTO denuncias (id_investigacion, fecha, observacion) VALUES ($id_investigacion, '".$fecha."', '".$observacion."')";
      /*****************AGREGAR UPDATE********* */
      $adenuncia = "UPDATE investigaciones SET denuncia  = 1 WHERE id=". $id_investigacion;
    }else{
      $sql = "INSERT INTO denuncias (id_investigacion, fecha) VALUES ($id_investigacion, '".$fecha."')";
      /*****************AGREGAR********* */
      $adenuncia = "UPDATE investigaciones SET denuncia  = 1 WHERE id=". $id_investigacion;
    }
    
    if(mysqli_query($con, $sql) && mysqli_query($con, $adenuncia)){
      $respuesta = 1;
    }else{
       $respuesta = 2;
    }
  }else{
     $respuesta = 3;
  }

  return $respuesta;
}

function GuardarEntrevistaVirtual($placa,$poliza,$fecha_accidente,$codigo,$id_entrevistado,$nom_entrevistado,$id_lesionado,$nom_lesionado,$id_tomador,$nom_tomador){
  global $con;

  $queryGuardarEntrevistaVirtual = "INSERT INTO entrevista_virtual (placa, poliza, fecha_accidente, codigo, id_entrevistado, nom_entrevistado, id_lesionado, nom_lesionado, id_tomador, nom_tomador) VALUES ('".$placa."', '".$poliza."', '".$fecha_accidente."', '".$codigo."', '".$id_entrevistado."', '".$nom_entrevistado."', '".$id_lesionado."', '".$nom_lesionado."', '".$id_tomador."', '".$nom_tomador."');";

  if(mysqli_query($con,$queryGuardarEntrevistaVirtual)){
    return json_encode(mysqli_insert_id($con));;
  }else{
    return false;
  }
}

function consultarFirmas(){
  global $con;
  $sql = "SELECT * FROM entrevista_virtual ev ORDER BY ev.id DESC";

  $datos=array();
  $datosConsulta = mysqli_query($con, $sql);

  while ($res=mysqli_fetch_array($datosConsulta,MYSQLI_ASSOC)){
    $datos[]=array(
      "id"=>$res["id"],
      "nom_entrevistado"=>$res["nom_entrevistado"],
      "firmado"=>$res["firmado"],
      "fecha_firma"=>$res["fecha_firma"]
    ); 
  }
  return json_encode($datos);
}

function noDenunciarInvest($id){
  global $con;
  $resp = 2;

  $sql = "SELECT id FROM investigaciones i where id = $id";
  $datosConsulta = mysqli_query($con, $sql);

  if(mysqli_num_rows($datosConsulta) > 0){
    $consulta = "UPDATE investigaciones SET denuncia  = 2 WHERE id=". $id;
    if(mysqli_query($con, $consulta))
      $resp = 1;
  }else{
    $resp = 3;
  }

  return json_encode($resp);
}
?>