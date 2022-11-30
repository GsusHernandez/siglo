<?php 
include('../conexion/conexion.php');

function consultarPoliza($idPoliza)
{
  global $con;
  
     $consultarInformacionPoliza = "CALL manejoPolizas (3,'', '', '', '', '', '', '', '','','','','','','','','".$idPoliza."','',@resp)";

     $data=array();
    $queryInformacionPoliza=mysqli_query($con,$consultarInformacionPoliza);
    $data["cantidad_registros_polizas"]=mysqli_num_rows($queryInformacionPoliza);
     if (mysqli_num_rows($queryInformacionPoliza)>0)
     {
      $resInformacionPoliza=mysqli_fetch_array($queryInformacionPoliza,MYSQLI_ASSOC);
      $data["id_poliza"]=$resInformacionPoliza["id"];
      $data["numero"]=$resInformacionPoliza["numero"];
      $data["digito_verificacion"]=$resInformacionPoliza["digito_verificacion"];
      $data["inicio_vigencia"]=$resInformacionPoliza["inicio_vigencia"];
      
      $data["tipo_identificacion_tomador"]=$resInformacionPoliza["tipo_identificacion_tomador"];
      $data["identificacion_tomador"]=$resInformacionPoliza["identificacion_tomador"];
      $data["nombre_tomador"]=$resInformacionPoliza["nombre_tomador"];
      $data["telefono_tomador"]=$resInformacionPoliza["telefono_tomador"];
      $data["direccion_tomador"]=$resInformacionPoliza["direccion_tomador"];
      $data["ciudad_tomador"]=$resInformacionPoliza["ciudad_tomador"];
      $data["cod_sucursal_exp"]=$resInformacionPoliza["cod_sucursal_exp"];
      $data["clave_productora"]=$resInformacionPoliza["clave_productora"];
      $data["ciudad_expedicion"]=$resInformacionPoliza["ciudad_expedicion"];
      $data["id_aseguradora"]=$resInformacionPoliza["id_aseguradora"];
      
    
    
  }
      
     return ($data);
}

function eliminarPolizaCasoSOAT($idRegistro, $idTablaActualizar, $idUsuario){
  global $con;

  $consultarEliminarPoliza="CALL manejoPolizas (5,'', '', '', '', '', '', '', '','','','','','','','','".$idRegistro."','',@resp)";

  if (mysqli_query($con,$consultarEliminarPoliza)){
    $consultaRespuestaEliminarPoliza=mysqli_query($con,"SELECT @resp as resp");
    $respEliminarPoliza=mysqli_fetch_assoc($consultaRespuestaEliminarPoliza);
    $variable=$respEliminarPoliza["resp"];
    
    if(intval($variable) == 4){
      mysqli_query($con, "INSERT INTO `error` (`id_registro`, `funcion`, `id_usuario`) VALUES ($idRegistro, $idTablaActualizar, $idUsuario);");
    }
  }else{
    $variable=2;
  }

  return ($variable);
}

function seleccionarPolizaInvestigacion($idPoliza,$idInvestigacion,$idUsuario)
{
    global $con;
  
     $seleccionarPoliza = "CALL manejoPolizas (4,'', '', '', '', '', '', '', '','','','','','','','".$idInvestigacion."','".$idPoliza."','".$idUsuario."',@resp)";


     if (mysqli_query($con,$seleccionarPoliza))
    {

    $consultaRespuestaSeleccionarPoliza=mysqli_query($con,"SELECT @resp as resp");
    $respSeleccionarPoliza=mysqli_fetch_assoc($consultaRespuestaSeleccionarPoliza);
    $data=$respSeleccionarPoliza["resp"];
  
    
      
    
    }else{
       $data = 3;
    }
        
      
     return ($data);
}


function modificarPolizas($codSucursalPolizaFrm,$claveProductorPolizaFrm,$aseguradoraPolizaFrm,$numeroPolizaFRM,$digVerPolizaFrm,$vigenciaPolizaFrm,$tipoIdentificacionTomadorPolizaFrm,$identificacionTomadorPolizaFrm,$nombreTomadorPolizaFrm,$direccionTomadorPolizaFrm,$telefonoTomadorPolizaFrm,$ciudadTomadorPolizaFrm,$ciudadExpedicionPolizaFrm,$idPolizas,$idVehiculo,$usuario = 0)
{
   global $con;

     $modificarPoliza = "CALL manejoPolizas (2,'".$numeroPolizaFRM."', '".$digVerPolizaFrm."', '".$vigenciaPolizaFrm."', '".$tipoIdentificacionTomadorPolizaFrm."', '".$identificacionTomadorPolizaFrm."', '".$nombreTomadorPolizaFrm."', '".$telefonoTomadorPolizaFrm."', '".$direccionTomadorPolizaFrm."','".$ciudadTomadorPolizaFrm."','".$codSucursalPolizaFrm."','".$claveProductorPolizaFrm."','".$ciudadExpedicionPolizaFrm."','".$aseguradoraPolizaFrm."','".$idVehiculo."','','".$idPolizas."','".$usuario."',@resp)";


     if (mysqli_query($con,$modificarPoliza))
    {

    $consultaRespuestaModificarPoliza=mysqli_query($con,"SELECT @resp as resp");
    $respModifiacrPoliza=mysqli_fetch_assoc($consultaRespuestaModificarPoliza);
    $data=$respModifiacrPoliza["resp"];
  
    
      
    
    }else{
       $data = 3;
    }
        
      
     return ($data);
}

function registrarPolizas($idInvestigacionFrmVehiculos,$codSucursalPolizaFrm,$claveProductorPolizaFrm,$aseguradoraPolizaFrm,$numeroPolizaFRM,$digVerPolizaFrm,$vigenciaPolizaFrm,$tipoIdentificacionTomadorPolizaFrm,$identificacionTomadorPolizaFrm,$nombreTomadorPolizaFrm,$direccionTomadorPolizaFrm,$telefonoTomadorPolizaFrm,$ciudadTomadorPolizaFrm,$ciudadExpedicionPolizaFrm,$idVehiculo,$usuario)
{
   global $con;

     $insertarPoliza = "CALL manejoPolizas (1,'".$numeroPolizaFRM."', '".$digVerPolizaFrm."', '".$vigenciaPolizaFrm."', '".$tipoIdentificacionTomadorPolizaFrm."', '".$identificacionTomadorPolizaFrm."', '".$nombreTomadorPolizaFrm."', '".$telefonoTomadorPolizaFrm."', '".$direccionTomadorPolizaFrm."','".$ciudadTomadorPolizaFrm."','".$codSucursalPolizaFrm."','".$claveProductorPolizaFrm."','".$ciudadExpedicionPolizaFrm."','".$aseguradoraPolizaFrm."','".$idVehiculo."','".$idInvestigacionFrmVehiculos."','','".$usuario."',@resp)";


     if (mysqli_query($con,$insertarPoliza))
    {

    $consultaRespuestaCrearPoliza=mysqli_query($con,"SELECT @resp as resp");
    $respCrearPoliza=mysqli_fetch_assoc($consultaRespuestaCrearPoliza);
    $data=$respCrearPoliza["resp"];
  
    
      
    
    }else{
       $data = 3;
    }
        
      
     return ($data);
}



function registrarVehiculos($tipoVehiculoFrmVehiculoPoliza,$tipoServicioVehiculoFrmVehiculoPoliza,$placaVehiculoFrmVehiculoPoliza,$marcaVehiculoFrmVehiculoPoliza,$modeloVehiculoFrmVehiculoPoliza,$lineaVehiculoFrmVehiculoPoliza,$colorVehiculoFrmVehiculoPoliza,$numVinVehiculoFrmVehiculoPoliza,$numSerieVehiculoFrmVehiculoPoliza,$numChasisVehiculoFrmVehiculoPoliza,$numMotorVehiculoFrmVehiculoPoliza,$usuario)
{
  $data=array();
     global $con;


    $insertarVehiculo = "CALL manejoVehiculo (1,'".$tipoVehiculoFrmVehiculoPoliza."', '".$placaVehiculoFrmVehiculoPoliza."', '".$marcaVehiculoFrmVehiculoPoliza."', '".$modeloVehiculoFrmVehiculoPoliza."', '".$lineaVehiculoFrmVehiculoPoliza."', '".$colorVehiculoFrmVehiculoPoliza."', '".$numVinVehiculoFrmVehiculoPoliza."', '".$tipoServicioVehiculoFrmVehiculoPoliza."','".$numSerieVehiculoFrmVehiculoPoliza."','".$numMotorVehiculoFrmVehiculoPoliza."','".$numChasisVehiculoFrmVehiculoPoliza."','','".$usuario."',@resp,@resp2)";

                     


    if (mysqli_query($con,$insertarVehiculo))
    {

    $consultaRespuestaCrearVehiculos=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
    $respCrearVehiculos=mysqli_fetch_assoc($consultaRespuestaCrearVehiculos);
    $data["resultado"]=$respCrearVehiculos["resp"];
    $data["id_vehiculo"]=$respCrearVehiculos["resp2"];
    
      
    
    }else{
       $data["resultado"] = 3;
    }
        
      
     return ($data);

}

function modificarVehiculos($tipoVehiculoFrmVehiculoPoliza,$tipoServicioVehiculoFrmVehiculoPoliza,$placaVehiculoFrmVehiculoPoliza,$marcaVehiculoFrmVehiculoPoliza,$modeloVehiculoFrmVehiculoPoliza,$lineaVehiculoFrmVehiculoPoliza,$colorVehiculoFrmVehiculoPoliza,$numVinVehiculoFrmVehiculoPoliza,$numSerieVehiculoFrmVehiculoPoliza,$numChasisVehiculoFrmVehiculoPoliza,$numMotorVehiculoFrmVehiculoPoliza,$idVehiculoFrmVehiculos)
{
    $data=array();
     global $con;


   $modificarVehiculo = "CALL manejoVehiculo (2,'".$tipoVehiculoFrmVehiculoPoliza."', '".$placaVehiculoFrmVehiculoPoliza."', '".$marcaVehiculoFrmVehiculoPoliza."', '".$modeloVehiculoFrmVehiculoPoliza."', '".$lineaVehiculoFrmVehiculoPoliza."', '".$colorVehiculoFrmVehiculoPoliza."', '".$numVinVehiculoFrmVehiculoPoliza."', '".$tipoServicioVehiculoFrmVehiculoPoliza."','".$numSerieVehiculoFrmVehiculoPoliza."','".$numMotorVehiculoFrmVehiculoPoliza."','".$numChasisVehiculoFrmVehiculoPoliza."','".$idVehiculoFrmVehiculos."','',@resp,@resp2)";

                     
  if (mysqli_query($con,$modificarVehiculo))
      {

      $consultaRespuestaModificarVehiculo=mysqli_query($con,"SELECT @resp as resp,@resp2 as resp2");
      $respModificarVehiculo=mysqli_fetch_assoc($consultaRespuestaModificarVehiculo);
      $data["resultado"]=$respModificarVehiculo["resp"];
      $data["id_vehiculo"]=$respModificarVehiculo["resp2"];
    
        
      
      }else{
         $data["resultado"] = 3;
      }
        
      
     return ($data);




}


function consultarVehiculoInvestigacion($idCaso)
{
  global $con;
    $data=array();
   
      $consultaInformacionVehiculo="CALL manejoVehiculo(5,'','','','','','','','','','','','".$idCaso."','',@res,@resp2)";

    
    
    $consultarInformacionVehiculo=mysqli_query($con,$consultaInformacionVehiculo);
    $data["cantidad_registros_vehiculos"]=mysqli_num_rows($consultarInformacionVehiculo);
     if (mysqli_num_rows($consultarInformacionVehiculo)>0)
     {
      $resInformacionVehiculo=mysqli_fetch_array($consultarInformacionVehiculo,MYSQLI_ASSOC);
      $data["id_vehiculo"]=$resInformacionVehiculo["id"];
      $data["tipo_vehiculo"]=$resInformacionVehiculo["tipo_vehiculo"];
      $data["placa"]=$resInformacionVehiculo["placa"];
      $data["marca"]=$resInformacionVehiculo["marca"];
      $data["modelo"]=$resInformacionVehiculo["modelo"];
      $data["linea"]=$resInformacionVehiculo["linea"];
      $data["color"]=$resInformacionVehiculo["color"];
      $data["numero_vin"]=$resInformacionVehiculo["numero_vin"];
      $data["tipo_servicio"]=$resInformacionVehiculo["tipo_servicio"];
      $data["numero_serie"]=$resInformacionVehiculo["numero_serie"];
      $data["numero_motor"]=$resInformacionVehiculo["numero_motor"];
      $data["numero_chasis"]=$resInformacionVehiculo["numero_chasis"];
      
    
    
  }
  return ($data);
}




function consultarVehiculo($identificacionVehiculo,$tipoConsulta)
{
  global $con;
    $data=array();
    if ($tipoConsulta==1){
      $consultaInformacionVehiculo="CALL manejoVehiculo(3,'','','','','','','','','','','','".$identificacionVehiculo."','',@resp,@resp2)";

    }else if ($tipoConsulta==2){
      $consultaInformacionVehiculo="CALL manejoVehiculo(4,'','".$identificacionVehiculo."','','','','','','','','','','','',@resp,@resp2)";

    }
    
    $consultarInformacionVehiculo=mysqli_query($con,$consultaInformacionVehiculo);
    $data["cantidad_registros_vehiculos"]=mysqli_num_rows($consultarInformacionVehiculo);
     if (mysqli_num_rows($consultarInformacionVehiculo)>0){
      $resInformacionVehiculo=mysqli_fetch_array($consultarInformacionVehiculo,MYSQLI_ASSOC);
      $data["id_vehiculo"]=$resInformacionVehiculo["id"];
      $data["tipo_vehiculo"]=$resInformacionVehiculo["tipo_vehiculo"];
      $data["placa"]=$resInformacionVehiculo["placa"];
      $data["marca"]=$resInformacionVehiculo["marca"];
      $data["modelo"]=$resInformacionVehiculo["modelo"];
      $data["linea"]=$resInformacionVehiculo["linea"];
      $data["color"]=$resInformacionVehiculo["color"];
      $data["numero_vin"]=$resInformacionVehiculo["numero_vin"];
      $data["tipo_servicio"]=$resInformacionVehiculo["tipo_servicio"];
      $data["numero_serie"]=$resInformacionVehiculo["numero_serie"];
      $data["numero_motor"]=$resInformacionVehiculo["numero_motor"];
      $data["numero_chasis"]=$resInformacionVehiculo["numero_chasis"];
      
    
    
  }
  return ($data);
}

function consultarPolizasVehiculo($idVehiculo){

  global $con;
  $idInvestigacion = $_POST["idInvestigacion"];
  $data=array();

  $consultarPolizas="SELECT CONCAT(b.numero,' ',b.digito_verificacion) as numero_poliza, c.nombre_aseguradora as aseguradora,b.id as id_poliza
  from polizas b
  LEFT JOIN aseguradoras c ON b.id_aseguradora=c.id
  WHERE b.id_vehiculo='".$idVehiculo."'
  ORDER BY numero_poliza ASC";

  $queryPolizas=mysqli_query($con,$consultarPolizas);

  while ($resPolizas=mysqli_fetch_array($queryPolizas,MYSQLI_ASSOC)){

    $seleccionada = "NO";

    mysqli_next_result($con);
    $consultarPolizaInvestigacion=mysqli_query($con,"SELECT * FROM detalle_investigaciones_soat WHERE id_investigacion='".$idInvestigacion."' and id_poliza='".$resPolizas["id_poliza"]."'");

    if (mysqli_num_rows($consultarPolizaInvestigacion)>0){
      $seleccionada = "SI";
    }

    $data[]=array(
      "numeroPoliza" => $resPolizas["numero_poliza"],
      "aseguradora" => $resPolizas["aseguradora"], 
      "idPoliza" => $resPolizas["id_poliza"],
      "seleccionada" => $seleccionada
    );
  }

  $results = array(
    "respuesta" => $data
  );
  return json_encode($results); 
}
?>