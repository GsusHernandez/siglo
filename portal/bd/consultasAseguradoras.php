<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');


function eliminarAseguradoras($aseguradora,$usuarioActual){
      global $con;
$consultarEliminarAseguradora="CALL manejoAseguradoras (4,'','','','','','','','".$aseguradora."','','','','',@resp)";

if (mysqli_query($con,$consultarEliminarAseguradora))
{

  $consultaRespuestaEliminarAseguradora=mysqli_query($con,"SELECT @resp as resp");
  $respEliminarAseguradora=mysqli_fetch_assoc($consultaRespuestaEliminarAseguradora);
  $variable=$respEliminarAseguradora["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}




function vigenciaAseguradora($aseguradora,$usuarioActual){
       global $con;
$consultarVigenciaAseguradora="CALL manejoAseguradoras (3,'','','','','','','','".$aseguradora."','','','','',@resp)";

if (mysqli_query($con,$consultarVigenciaAseguradora))
{

  $consultaRespuestaVigenciaAseguradora=mysqli_query($con,"SELECT @resp as resp");
  $respVigenciaAseguradora=mysqli_fetch_assoc($consultaRespuestaVigenciaAseguradora);
  $variable=$respVigenciaAseguradora["resp"];

  
}else{
  $variable=2;
}
      return ($variable);

}

function registrarAseguradora($nombreAseguradora, $nitAseguradora, $digVerAseguradora, $dirAseguradora, $telAseguradora, $responsableAseguradora, $cargoAseguradora,$indicativoAseguradora, $usuarioCreaAseguradora,$atenderFrmAseg,$noAtenderFrmAseg){
   global $con;
   $consultarCrearAseguradora="CALL manejoAseguradoras(1,'".$nombreAseguradora."','".$nitAseguradora."','".$digVerAseguradora."','".$dirAseguradora."','".$telAseguradora."','".$responsableAseguradora."','".$cargoAseguradora."','','".$indicativoAseguradora."','".$atenderFrmAseg."','".$noAtenderFrmAseg."','".$usuarioCreaAseguradora."',@resp)";

if (mysqli_query($con,$consultarCrearAseguradora))
{

  $consultaRespuestaCrearAseguradora=mysqli_query($con,"SELECT @resp as resp");
  $respCrearAseguradora=mysqli_fetch_assoc($consultaRespuestaCrearAseguradora);
  $variable=$respCrearAseguradora["resp"];

  
}else{
  $variable=2;
}
     return ($variable);
}


function modificarAseguradora($nombreAseguradora, $nitAseguradora, $digVerAseguradora, $dirAseguradora, $telAseguradora, $responsableAseguradora, $cargoAseguradora, $aseguradora,$indicativoAseguradora,$atenderFrmAseg,$noAtenderFrmAseg){
   global $con;
   $consultarModificarAseguradora="CALL manejoAseguradoras (2,'".$nombreAseguradora."','".$nitAseguradora."','".$digVerAseguradora."','".$dirAseguradora."','".$telAseguradora."','".$responsableAseguradora."','".$cargoAseguradora."','".$aseguradora."','".$indicativoAseguradora."','".$atenderFrmAseg."','".$noAtenderFrmAseg."','',@resp)";

if (mysqli_query($con,$consultarModificarAseguradora))
{

  $consultaRespuestaModificarAseguradora=mysqli_query($con,"SELECT @resp as resp");
  $respModificarAseguradora=mysqli_fetch_assoc($consultaRespuestaModificarAseguradora);
  $variable=$respModificarAseguradora["resp"];

  
}else{
  $variable=20;
}
     return ($variable);
}







function consultarInformacionAseguradora($idAseguradora){
  global $con;
	  $data=array();
    $consultarAseguradora="CALL manejoAseguradoras (5,'','','','','','','','".$idAseguradora."','','','','',@resp)"; 
	$consultarInformacionAseguradora=mysqli_query($con,$consultarAseguradora);

	if (mysqli_num_rows($consultarInformacionAseguradora)>0){
		$resInformacionAseguradora=mysqli_fetch_array($consultarInformacionAseguradora,MYSQLI_ASSOC);
		
		$data["id"]=$resInformacionAseguradora["id"];
    $data["nombre"]=$resInformacionAseguradora["nombre_aseguradora"];
    	$data["identificacion"]=$resInformacionAseguradora["identificacion"];
    	$data["dig_ver"]=$resInformacionAseguradora["dig_ver"];
    	$data["direccion"]=$resInformacionAseguradora["direccion"];
      $data["telefono"]=$resInformacionAseguradora["telefono"];
      $data["responsable"]=$resInformacionAseguradora["responsable"];
      $data["cargo"]=$resInformacionAseguradora["cargo"];
      $data["vigente"]=$resInformacionAseguradora["vigente"];
      $data["indicativo"]=$resInformacionAseguradora["indicativo"];
      $data["resultado_atender"]=$resInformacionAseguradora["resultado_atender"];
      $data["resultado_no_atender"]=$resInformacionAseguradora["resultado_no_atender"];  
	}
	return $data;
}





function asignarClinicaAseguradora($idAseguradora,$idUsuario,$clinicasAsignar)
{
  global $con;

$consultarAsignarClinicas="CALL manejoAseguradorasClinicas(1,'".$idAseguradora."','','',@resp)";

if (mysqli_query($con,$consultarAsignarClinicas))
{
 $variable=0;
  $consultaRespuestaAsignacionClinica=mysqli_query($con,"SELECT @resp as resp");
  $respAsignacionClinica=mysqli_fetch_assoc($consultaRespuestaAsignacionClinica);
  if ($respAsignacionClinica["resp"]==1)
  {
    $clinicasDecodificdas=json_decode($clinicasAsignar);
    foreach ($clinicasDecodificdas as $passClinicaDecodificadas) {
      $consultarAseguradoraClinica="CALL manejoAseguradorasClinicas(2,'".$idAseguradora."','".$passClinicaDecodificadas->codigoClinica."','".$idUsuario."',@resp)";
      if (mysqli_query($con,$consultarAseguradoraClinica)){
        $consultaRespuestaAsignarClinica=mysqli_query($con,"SELECT @resp as resp");
        $respAsignarClinica=mysqli_fetch_assoc($consultaRespuestaAsignarClinica);
        $variable=$respAsignarClinica["resp"];

      }
    }
  }

  
}
else
{
  $variable=22;
}
  return ($variable);
}


  function asignarAmparosAseguradora($idAseguradora, $idAmparoMetodo, $idMetodoFact, $idUsuario)
  {

  global $con;

   $asignarAmparosAseguradora="CALL manejoAseguradoraAmparoTarifas (1,'".$idAseguradora."','".$idAmparoMetodo."','".$idMetodoFact."','','','','','','','','','".$idUsuario."',@resp)";

  if (mysqli_query($con,$asignarAmparosAseguradora))
  {
  $consultaAsignarAmparosAseguradora=mysqli_query($con,"SELECT @resp as resp");
  $respAsignarAmparosAseguradora=mysqli_fetch_assoc($consultaAsignarAmparosAseguradora);
  $variable=$respAsignarAmparosAseguradora["resp"];

  
  }else{
    $variable=2;
  }
      return ($variable);
  }



  

function eliminarAmparoAseguradora($idRegistro,$idUsuario){
      global $con;
$consultarEliminarAmparoAseguradora="CALL manejoAseguradoraAmparoTarifas (2,'','','','','','','','','','','".$idRegistro."','',@resp)";

if (mysqli_query($con,$consultarEliminarAmparoAseguradora))
{

  $consultaRespuestaEliminarAmparoAseguradora=mysqli_query($con,"SELECT @resp as resp");
  $respEliminarAmparoAseguradora=mysqli_fetch_assoc($consultaRespuestaEliminarAmparoAseguradora);
  $variable=$respEliminarAmparoAseguradora["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}


function asignarClinicaCiudadesAmpAseg($idAsegAmparo,$idClinica,$idCiudad,$usuario){
   global $con;
$consultarasignarClinicaCiudadesAmpAseg="CALL manejoAseguradoraAmparoTarifas (9,'','','','".$idClinica."','".$idCiudad."','','','','','','".$idAsegAmparo."','".$usuario."',@resp)";

if (mysqli_query($con,$consultarasignarClinicaCiudadesAmpAseg))
{

  $consultaRespuestaAsignarClinicaCiudadesAmpAseg=mysqli_query($con,"SELECT @resp as resp");
  $respAsignarClinicaCiudadesAmpAseg=mysqli_fetch_assoc($consultaRespuestaAsignarClinicaCiudadesAmpAseg);
  $variable=$respAsignarClinicaCiudadesAmpAseg["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}



function eliminarClinicaCiudadTarifaAmparo($idRegistro,$idUsuario){
      global $con;
    $consultarEliminarAmparoAseguradora="CALL manejoAseguradoraAmparoTarifas (10,'','','','','','','','','','','".$idRegistro."','".$idUsuario."',@resp)";

    if (mysqli_query($con,$consultarEliminarAmparoAseguradora))
    {

      $consultaRespuestaEliminarAmparoAseguradora=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarAmparoAseguradora=mysqli_fetch_assoc($consultaRespuestaEliminarAmparoAseguradora);
      $variable=$respEliminarAmparoAseguradora["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);
}

function registrarTarifaValorCaso($idAmparoMetodoFact,$valorCasoUnico,$idUsuario){
  global $con;
    $consultaRegistrarTarifaValorCaso="CALL manejoAseguradoraAmparoTarifas (3,'','','','','','','','','','".$valorCasoUnico."','".$idAmparoMetodoFact."','".$idUsuario."',@resp)";

    if (mysqli_query($con,$consultaRegistrarTarifaValorCaso))
    {

      $consultaRespuestaRegistrarTarifaValorCaso=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarTarifaValorCaso=mysqli_fetch_assoc($consultaRespuestaRegistrarTarifaValorCaso);
      $variable=$respRegistrarTarifaValorCaso["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}



function registrarTarifaValorCasoResultado($idAmparoMetodoFact,$valorCasoAtender,$valorCasoNoAtender,$idUsuario){
  global $con;
    $consultaRegistrarTarifaValorCasoNoAtender="CALL manejoAseguradoraAmparoTarifas (6,'','','','','','2','','','','".$valorCasoNoAtender."','".$idAmparoMetodoFact."','".$idUsuario."',@resp)";

       $consultaRegistrarTarifaValorCasoAtender="CALL manejoAseguradoraAmparoTarifas (6,'','','','','','1','','','','".$valorCasoAtender."','".$idAmparoMetodoFact."','".$idUsuario."',@resp)";

    if (mysqli_query($con,$consultaRegistrarTarifaValorCasoNoAtender) && mysqli_query($con,$consultaRegistrarTarifaValorCasoAtender))
    {

      $consultaRespuestaRegistrarTarifaValorCasoResultado=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarTarifaValorCasoResultado=mysqli_fetch_assoc($consultaRespuestaRegistrarTarifaValorCasoResultado);
      $variable=$respRegistrarTarifaValorCasoResultado["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}


function registrarTarifaValorCasoZona($idAmparoMetodoFact,$valorCasoUrbano,$valorCasoRural,$idUsuario){
  global $con;
    $consultaRegistrarTarifaValorCasoRural="CALL manejoAseguradoraAmparoTarifas (8,'','','','','','','2','','','".$valorCasoRural."','".$idAmparoMetodoFact."','".$idUsuario."',@resp)";

       $consultaRegistrarTarifaValorCasoUrbano="CALL manejoAseguradoraAmparoTarifas (8,'','','','','','','1','','','".$valorCasoUrbano."','".$idAmparoMetodoFact."','".$idUsuario."',@resp)";

    if (mysqli_query($con,$consultaRegistrarTarifaValorCasoRural) && mysqli_query($con,$consultaRegistrarTarifaValorCasoUrbano))
    {

      $consultaRespuestaRegistrarTarifaValorCasoRural=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarTarifaValorCasoZona=mysqli_fetch_assoc($consultaRespuestaRegistrarTarifaValorCasoRural);
      $variable=$respRegistrarTarifaValorCasoZona["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}



function consultarTarifaValorCaso($idAmparoMetodoFact){
  global $con;
  $data=array();
    $consultaTarifaValorCaso="CALL manejoAseguradoraAmparoTarifas (4,'','','','','','','','','','','".$idAmparoMetodoFact."','',@resp)";

  $consultarTarifaValorCaso=mysqli_query($con,$consultaTarifaValorCaso);

  if (mysqli_num_rows($consultarTarifaValorCaso)>0){
    $resTarifaValorCaso=mysqli_fetch_array($consultarTarifaValorCaso,MYSQLI_ASSOC);
    
    $data["id"]=$resTarifaValorCaso["id"];
    $data["valor_caso"]=$resTarifaValorCaso["valor_caso"];
    
      
  }
  return $data;
}



function consultarTarifaValorCasoResultado($idAmparoMetodoFact){
  global $con;
  $data=array();
    $consultaTarifaValorCasoResultado="CALL manejoAseguradoraAmparoTarifas (5,'','','','','','','','','','','".$idAmparoMetodoFact."','',@resp)";

  $consultarTarifaValorCasoResultado=mysqli_query($con,$consultaTarifaValorCasoResultado);

  if (mysqli_num_rows($consultarTarifaValorCasoResultado)>0){
    $resTarifaValorCasoResultado=mysqli_fetch_array($consultarTarifaValorCasoResultado,MYSQLI_ASSOC);
     
        $data["valor_caso_atender"]=$resTarifaValorCasoResultado["valor_atender"];     
        $data["valor_caso_no_atender"]=$resTarifaValorCasoResultado["valor_no_atender"];     
      
      
    }
    
       
  
  return $data;
}


function consultarTarifaValorCasoZona($idAmparoMetodoFact){
  global $con;
  $data=array();
    $consultaTarifaValorCasoZona="CALL manejoAseguradoraAmparoTarifas (7,'','','','','','','','','','','".$idAmparoMetodoFact."','',@resp)";

  $consultarTarifaValorCasoZona=mysqli_query($con,$consultaTarifaValorCasoZona);

  if (mysqli_num_rows($consultarTarifaValorCasoZona)>0){
    $resTarifaValorCasoZona=mysqli_fetch_array($consultarTarifaValorCasoZona,MYSQLI_ASSOC);
     
        $data["valor_caso_urbano"]=$resTarifaValorCasoZona["valor_urbano"];     
        $data["valor_caso_rural"]=$resTarifaValorCasoZona["valor_rural"];     
      
      
    }
    
       
  
  return $data;
}

function asignarIndicadorNoAtenderAseg($idAseguradora,$codigoNoAtender,$idIndicador,$usuario){
  global $con;
    $consultaRegistrarIndicadorAseguradora="CALL manejoIndicadorAseguradora (2,'".$idAseguradora."','".$idIndicador."','".$codigoNoAtender."','','".$usuario."',@resp)";

    if (mysqli_query($con,$consultaRegistrarIndicadorAseguradora))
    {

      $consultaRespuestaRegistrarIndicadorAseguradora=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarIndicadorAseguradora=mysqli_fetch_assoc($consultaRespuestaRegistrarIndicadorAseguradora);
      $variable=$respRegistrarIndicadorAseguradora["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}


function asignarIndicadorAtenderAseg($idAseguradora,$codigoAtender,$idIndicador,$usuario){
  global $con;
    $consultaRegistrarIndicadorAseguradora="CALL manejoIndicadorAseguradora (1,'".$idAseguradora."','".$idIndicador."','".$codigoAtender."','','".$usuario."',@resp)";

    if (mysqli_query($con,$consultaRegistrarIndicadorAseguradora))
    {

      $consultaRespuestaRegistrarIndicadorAseguradora=mysqli_query($con,"SELECT @resp as resp");
      $respRegistrarIndicadorAseguradora=mysqli_fetch_assoc($consultaRespuestaRegistrarIndicadorAseguradora);
      $variable=$respRegistrarIndicadorAseguradora["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}


function eliminarIndicadorAseguradora($idRegistro){
  global $con;
    $consultaEliminarIndicadorAseguradora="CALL manejoIndicadorAseguradora (3,'','','','".$idRegistro."','',@resp)";

    if (mysqli_query($con,$consultaEliminarIndicadorAseguradora))
    {

      $consultaRespuestaEliminarIndicadorAseguradora=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarIndicadorAseguradora=mysqli_fetch_assoc($consultaRespuestaEliminarIndicadorAseguradora);
      $variable=$respEliminarIndicadorAseguradora["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}
 
 function agregarRangoValorTarifa($idRegistroCiudad,$idRegistroAsegAmparo,$rangoDesde,$rangoHasta,$valorCaso,$idUsuario){
    global $con;
    $consultaInsertarTarifaRango="CALL manejoAseguradoraAmparoTarifas (11,'','','','','".$idRegistroCiudad."','','','".$rangoDesde."','".$rangoHasta."','".$valorCaso."','".$idRegistroAsegAmparo."','".$idUsuario."',@resp)";

    if (mysqli_query($con,$consultaInsertarTarifaRango))
    {

      $consultaRespuestaInsertarTarifaRango=mysqli_query($con,"SELECT @resp as resp");
      $respInsertarTarifaRango=mysqli_fetch_assoc($consultaRespuestaInsertarTarifaRango);
      $variable=$respInsertarTarifaRango["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);
 }

function eliminarRangoValorTarifa($idRegistro){
  global $con;
    $consultaEliminarRangoValorTarifa="CALL manejoAseguradoraAmparoTarifas (12,'','','','','','','','','','','".$idRegistro."','',@resp)";

    if (mysqli_query($con,$consultaEliminarRangoValorTarifa))
    {

      $consultaRespuestaEliminarRangoValorTarifa=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarRangoValorTarifa=mysqli_fetch_assoc($consultaRespuestaEliminarRangoValorTarifa);
      $variable=$respEliminarRangoValorTarifa["resp"];

      
    }else{
      $variable=2;
    }
      return ($variable);

}
?>