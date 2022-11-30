<?php 

include('../conexion/conexion.php');



function registrarPersonas($tipoIdentificacionPersonasFrm,$sexoPersonasFrm,$nombresPersonasFrm,$apellidosPersonasFrm,$identificacionPersonasFrm,$edadPersonasFrm,$telefonoPersonasFrm,$direccionPersonasFrm,$barrioPersonasFrm,$ciudadPersonasFrm,$usuario,$ocupacionPersonasFrm)
{
  $data=array();
     global $con;


    $insertarPersonas = "CALL manejoPersonas (1,'".$nombresPersonasFrm."', '".$apellidosPersonasFrm."', '".$ocupacionPersonasFrm."', '".$sexoPersonasFrm."', '".$edadPersonasFrm."', '".$direccionPersonasFrm."', '".$ciudadPersonasFrm."','".$telefonoPersonasFrm."','".$barrioPersonasFrm."','".$tipoIdentificacionPersonasFrm."','".$identificacionPersonasFrm."','','".$usuario."',@resp)";

                     


    if (mysqli_query($con,$insertarPersonas))
    {

    $consultaRespuestaCrearPersonas=mysqli_query($con,"SELECT @resp as resp");
    $respCrearPersonas=mysqli_fetch_assoc($consultaRespuestaCrearPersonas);
    $data["resultado"]=$respCrearPersonas["resp"];
    if ($data["resultado"]=="1")
    {
      $consultarPersonas=consultarPersonas($identificacionPersonasFrm,2);  
      $data["id"]=$consultarPersonas["id"];
      $data["nombre_persona"]=$consultarPersonas["nombres"]." ".$consultarPersonas["apellidos"];
    }
      
    
    }else{
       $data["resultado"] = 3;
    }
        
      
     return ($data);

}

function modificarPersonas($tipoIdentificacionPersonasFrm,$sexoPersonasFrm,$nombresPersonasFrm,$apellidosPersonasFrm,$identificacionPersonasFrm,$edadPersonasFrm,$telefonoPersonasFrm,$direccionPersonasFrm,$barrioPersonasFrm,$ciudadPersonasFrm,$ocupacionPersonasFrm,$idPersonas)
{
    $data=array();
     global $con;


    $modificarPersonas = "CALL manejoPersonas (2,'".$nombresPersonasFrm."', '".$apellidosPersonasFrm."', '".$ocupacionPersonasFrm."', '".$sexoPersonasFrm."', '".$edadPersonasFrm."', '".$direccionPersonasFrm."', '".$ciudadPersonasFrm."','".$telefonoPersonasFrm."','".$barrioPersonasFrm."','".$tipoIdentificacionPersonasFrm."','".$identificacionPersonasFrm."','".$idPersonas."','',@resp)";

                     
  if (mysqli_query($con,$modificarPersonas))
      {

      $consultaRespuestaModificarPersonas=mysqli_query($con,"SELECT @resp as resp");
      $respModificarPersonas=mysqli_fetch_assoc($consultaRespuestaModificarPersonas);
      $data["resultado"]=$respModificarPersonas["resp"];
      if ($data["resultado"]=="1")
      {
        $consultarPersonas=consultarPersonas($identificacionPersonasFrm,2);  
        $data["id"]=$consultarPersonas["id"];
        $data["nombre_persona"]=$consultarPersonas["nombres"]." ".$consultarPersonas["apellidos"];
      }
        
      
      }else{
         $data["resultado"] = 3;
      }
        
      
     return ($data);




}


function consultarPersonas($identificacionPersona,$tipoConsulta)
{
  global $con;
    $data=array();
    if ($tipoConsulta==1){
      $consultaInformacionPersonas="CALL manejoPersonas(3,'','','','','','','','','','','','".$identificacionPersona."','',@resp)";

    }else if ($tipoConsulta==2){
      $consultaInformacionPersonas="CALL manejoPersonas(6,'','','','','','','','','','','".$identificacionPersona."','','',@resp)";
    }
    
    $consultarInformacionPersonas=mysqli_query($con,$consultaInformacionPersonas);
    $data["cantidad_registros_personas"]=mysqli_num_rows($consultarInformacionPersonas);
     if (mysqli_num_rows($consultarInformacionPersonas)>0){
      $resInformacionPersonas=mysqli_fetch_array($consultarInformacionPersonas,MYSQLI_ASSOC);
      $data["id"]=$resInformacionPersonas["id"];
      $data["nombres"]=$resInformacionPersonas["nombres"];
      $data["apellidos"]=$resInformacionPersonas["apellidos"];
      $data["ocupacion"]=$resInformacionPersonas["ocupacion"];
      $data["sexo"]=$resInformacionPersonas["sexo"];
      $data["edad"]=$resInformacionPersonas["edad"];
      $data["direccion_residencia"]=$resInformacionPersonas["direccion_residencia"];
      $data["ciudad_residencia"]=$resInformacionPersonas["ciudad_residencia"];
      $data["telefono"]=$resInformacionPersonas["telefono"];
      $data["barrio"]=$resInformacionPersonas["barrio"];
      $data["tipo_identificacion"]=$resInformacionPersonas["tipo_identificacion"];
      $data["identificacion"]=$resInformacionPersonas["identificacion"];
      
    
    
  }
  return $data;
}




 ?>