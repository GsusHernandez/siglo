<?php 

include('../conexion/conexion.php');




function eliminarClinicas($idClinica){
global $con;
$consultarEliminarClinica="CALL manejoClinicas(4,'','','','','','','".$idClinica."','','',@resp)";

if (mysqli_query($con,$consultarEliminarClinica))
{

  $consultaRespuestaEliminarClinica=mysqli_query($con,"SELECT @resp as resp");
  $respEliminarClinica=mysqli_fetch_assoc($consultaRespuestaEliminarClinica);
  $variable=$respEliminarClinica["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}


function permitirClinicas($idClinica){
global $con;
$consultarPermitirClinica="CALL manejoClinicas(3,'','','','','','','".$idClinica."','','',@resp)";

if (mysqli_query($con,$consultarPermitirClinica))
{

  $consultaRespuestaPermitirClinica=mysqli_query($con,"SELECT @resp as resp");
  $respPermitirClinica=mysqli_fetch_assoc($consultaRespuestaPermitirClinica);
  $variable=$respPermitirClinica["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}

function registrarClinicas($nombreClinica, $nitClinica, $digVerNitClinica, $CiudadClinica, $telClinica, $dirClinica, $usuario){

     global $con;


    $insertarClinicas = "CALL manejoClinicas (1,'".$nombreClinica."', '".$nitClinica."', '".$digVerNitClinica."', '".$CiudadClinica."', '".$telClinica."', '".$dirClinica."','', '".$usuario."','',@resp)";

                     


    if (mysqli_query($con,$insertarClinicas))
    {

    $consultaRespuestaCrearClinicas=mysqli_query($con,"SELECT @resp as resp");
    $respCrearClinicas=mysqli_fetch_assoc($consultaRespuestaCrearClinicas);
    $variable=$respCrearClinicas["resp"];
      
      
    }else{
       $variable = 2;
    }
        
      
     return ($variable);

}

function modificarClinicas($nombreClinica, $nitClinica, $digVerNitClinica, $CiudadClinica, $telClinica, $dirClinica, $idRegistro){

     global $con;


    $modificarClinicas = "CALL manejoClinicas (2, '".$nombreClinica."', '".$nitClinica."', '".$digVerNitClinica."', '".$CiudadClinica."', '".$telClinica."', '".$dirClinica."', '".$idRegistro."','','',@resp)";

                     


    if (mysqli_query($con,$modificarClinicas))
    {

    $consultaRespuestaModificarClinicas=mysqli_query($con,"SELECT @resp as resp");
    $respModoficarClinicas=mysqli_fetch_assoc($consultaRespuestaModificarClinicas);
    $variable=$respModoficarClinicas["resp"];
      
      
    }else{
       $variable = 22;
    }
        
      
     return ($variable);




}


function consultarClinicas($idClinica){
  global $con;
    $data=array();
    $consultaInformacionClinica="CALL manejoClinicas(5,'','','','','','','".$idClinica."','','',@resp)";
    $consultarInformacionClinica=mysqli_query($con,$consultaInformacionClinica);
     if (mysqli_num_rows($consultarInformacionClinica)>0){
      $resInformacionClinica=mysqli_fetch_array($consultarInformacionClinica,MYSQLI_ASSOC);
      $data["id"]=$resInformacionClinica["id"];
      $data["nombre_ips"]=$resInformacionClinica["nombre_ips"];
      $data["identificacion"]=$resInformacionClinica["identificacion"];
      $data["dig_ver"]=$resInformacionClinica["dig_ver"];
      $data["direccion"]=$resInformacionClinica["direccion"];
      $data["telefono"]=$resInformacionClinica["telefono"];
 
    $data["ciudad"]=$resInformacionClinica["ciudad"];
      
    
    
  }
  return $data;
}


function asignarInvestigadorClinica($idRegistroClinica,$idInvestigador,$usuario){
  global $con;
    $data=array();
    $consultaAsignarInvestigadorClinica="CALL manejoClinicas(6,'','','','','','','".$idRegistroClinica."','".$usuario."','".$idInvestigador."',@resp)";
    
    if (mysqli_query($con,$consultaAsignarInvestigadorClinica))
    {

    $consultaRespuestaAsignarInvestigadorClinica=mysqli_query($con,"SELECT @resp as resp");
    $respAsignarInvestigadorClinica=mysqli_fetch_assoc($consultaRespuestaAsignarInvestigadorClinica);
    $variable=$respAsignarInvestigadorClinica["resp"];
      
      
    }else{
       $variable = 22;
    }
        
      
     return ($variable);

}






function eliminarAsignacionInvestigadorIps($idClinica){
global $con;
$consultarEliminarAsignacionInvestigadorIps="CALL manejoClinicas(7,'','','','','','','".$idClinica."','','',@resp)";

if (mysqli_query($con,$consultarEliminarAsignacionInvestigadorIps))
{

  $consultaRespuestaEliminarAsignacionInvestigadorIps=mysqli_query($con,"SELECT @resp as resp");
  $respEliminarAsignacionInvestigadorIps=mysqli_fetch_assoc($consultaRespuestaEliminarAsignacionInvestigadorIps);
  $variable=$respEliminarAsignacionInvestigadorIps["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}

 ?>