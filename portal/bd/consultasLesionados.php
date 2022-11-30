<?php 

include('../conexion/conexion.php');

function modificarVictima($idVictima,$fechaIngresoVictimaFrm,$fechaEgresoVictimaFrm,$ipsVictimaFrm,$condicionVictimaFrm,$resultadoVictimaFrm,$indicadorFraudeVictimaFrm,$idRegistroInvestigacionVictimaSOAT,$idPersonaVictima,$observacionesVictimaFrm){

     global $con;
     $data=array();

     $consultaModificarVictima="CALL manejoLesionadosSOAT(8,'".$idVictima."', '".$fechaIngresoVictimaFrm."', '".$fechaEgresoVictimaFrm."', '".$ipsVictimaFrm."', '".$condicionVictimaFrm."', '', '', '','','','','','','','','','','".$observacionesVictimaFrm."','','".$resultadoVictimaFrm."','".$indicadorFraudeVictimaFrm."','','','".$idPersonaVictima."','',@resp)";

     if (mysqli_query($con,$consultaModificarVictima)){
        mysqli_next_result($con);
        $consultaRespuestaModificarVictimas=mysqli_query($con,"SELECT @resp as resp");
        mysqli_next_result($con);
        $infoVictima=consultarVictima($idRegistroInvestigacionVictimaSOAT);
        $data["nombre_persona"]=$infoVictima["nombre_persona"];
        $respModificarVictimas=mysqli_fetch_assoc($consultaRespuestaModificarVictimas);
        $data["resultado"]=$respModificarVictimas["resp"];
      }else{
         $data["resultado"]=2;
      }

      return $data;
}

function consultarObservacionLesionadoPrincipal($idCaso)
{
  global $con;
    $data=array();
    
      $consultaInformacionLesionadoPrincipal="CALL manejoLesionadosSOAT(6,'', '', '', '', '', '', '','','','','','','','','','','','','".$idCaso."','','','','','','',@resp)";
    
    
    $queryInformacionLesionadoPrincipal=mysqli_query($con,$consultaInformacionLesionadoPrincipal);

     if (mysqli_num_rows($queryInformacionLesionadoPrincipal)>0){
      $resInformacionLesionadoPrincipal=mysqli_fetch_array($queryInformacionLesionadoPrincipal,MYSQLI_ASSOC);

      $data["observaciones"]=$resInformacionLesionadoPrincipal["observaciones"];
    

      
    
    
  }
  return $data;
}


function registrarLesionados($idLesionado,$fechaIngresoLesionadoFrm,$fechaEgresoLesionadoFrm,$ipsLesionadoFrm,$condicionLesionadoFrm,$resultadoLesionadoFrm,$indicadorFraudeLesionadoFrm,$servicioAmbulanciaLesionadoFrm,$tipoServicioAmbulanciaLesionadoFrm,$lugarTrasladoAmbulanciaLesionadoFrm,$tipoVehiculoTrasladoLesionadoFrm,$seguridadSocialLesionadoFrm,$epsLesionadoFrm,$regimenLesionadoFrm,$estadoSeguridadSocialLesionadoFrm,$causalNoConsultaSeguridadSocialLesionadoFrm,$lesionesLesionadoFrm,$tratamientoLesionadoFrm,$relatoLesionadoFrm,$observacionesLesionadoFrm,$usuario,$idRegistroInvestigacionLesionadoSOAT,$remitidoLesionadoFrm,$ipsRemitidoLesionadoFrm)
{
  $data=array();
     global $con;


    $insertarLesionados = "CALL manejoLesionadosSOAT (1,'".$idLesionado."', '".$fechaIngresoLesionadoFrm."', '".$fechaEgresoLesionadoFrm."', '".$ipsLesionadoFrm."', '".$condicionLesionadoFrm."', '".$servicioAmbulanciaLesionadoFrm."', '".$tipoServicioAmbulanciaLesionadoFrm."','".$lugarTrasladoAmbulanciaLesionadoFrm."','".$tipoVehiculoTrasladoLesionadoFrm."','".$seguridadSocialLesionadoFrm."','".$epsLesionadoFrm."','".$regimenLesionadoFrm."','".$estadoSeguridadSocialLesionadoFrm."','".$causalNoConsultaSeguridadSocialLesionadoFrm."','".$lesionesLesionadoFrm."','".$tratamientoLesionadoFrm."','".$relatoLesionadoFrm."','".$observacionesLesionadoFrm."','".$idRegistroInvestigacionLesionadoSOAT."','".$resultadoLesionadoFrm."','".$indicadorFraudeLesionadoFrm."','".$remitidoLesionadoFrm."','".$ipsRemitidoLesionadoFrm."','','".$usuario."',@resp)";

                     


    if (mysqli_query($con,$insertarLesionados))
    {

      $consultaRespuestaCrearPersonas=mysqli_query($con,"SELECT @resp as resp");
      $respCrearPersonas=mysqli_fetch_assoc($consultaRespuestaCrearPersonas);
      $variable=$respCrearPersonas["resp"];
      
        
    
    }else{
       $variable=2;
    }
        
      
     return ($variable);

}

function modificarLesionado($idRegistroInvestigacionLesionadoSOAT,$idLesionado,$fechaIngresoLesionadoFrm,$fechaEgresoLesionadoFrm,$ipsLesionadoFrm,$condicionLesionadoFrm,$resultadoLesionadoFrm,$indicadorFraudeLesionadoFrm,$servicioAmbulanciaLesionadoFrm,$tipoServicioAmbulanciaLesionadoFrm,$lugarTrasladoAmbulanciaLesionadoFrm,$tipoVehiculoTrasladoLesionadoFrm,$seguridadSocialLesionadoFrm,$epsLesionadoFrm,$regimenLesionadoFrm,$estadoSeguridadSocialLesionadoFrm,$causalNoConsultaSeguridadSocialLesionadoFrm,$lesionesLesionadoFrm,$tratamientoLesionadoFrm,$relatoLesionadoFrm,$observacionesLesionadoFrm,$idPersonaLesionado,$usuario,$remitidoLesionadoFrm,$ipsRemitidoLesionadoFrm)
{
    $data=array();
     global $con;


    $modificarLesionado = "CALL manejoLesionadosSOAT (2,'".$idLesionado."', '".$fechaIngresoLesionadoFrm."', '".$fechaEgresoLesionadoFrm."', '".$ipsLesionadoFrm."', '".$condicionLesionadoFrm."', '".$servicioAmbulanciaLesionadoFrm."', '".$tipoServicioAmbulanciaLesionadoFrm."','".$lugarTrasladoAmbulanciaLesionadoFrm."','".$tipoVehiculoTrasladoLesionadoFrm."','".$seguridadSocialLesionadoFrm."','".$epsLesionadoFrm."','".$regimenLesionadoFrm."','".$estadoSeguridadSocialLesionadoFrm."','".$causalNoConsultaSeguridadSocialLesionadoFrm."','".$lesionesLesionadoFrm."','".$tratamientoLesionadoFrm."','".$relatoLesionadoFrm."','".$observacionesLesionadoFrm."','".$idRegistroInvestigacionLesionadoSOAT."','".$resultadoLesionadoFrm."','".$indicadorFraudeLesionadoFrm."','".$remitidoLesionadoFrm."','".$ipsRemitidoLesionadoFrm."','".$idPersonaLesionado."','".$usuario."',@resp)";

                     
  if (mysqli_query($con,$modificarLesionado))
      {

      $consultaRespuestaModificarLesionado=mysqli_query($con,"SELECT @resp as resp");
      $respModificarPersonas=mysqli_fetch_assoc($consultaRespuestaModificarLesionado);
      $variable=$respModificarPersonas["resp"];
      
        
      
      }else{
         $variable = 2;
      }
        
      
     return ($variable);




}



function seleccionarReclamante($idReclamantePersona,$idInvestigacion,$usuario)
{
    global $con;
     $data=array();

     $consultaRegistrarReclamante="CALL manejoLesionadosSOAT(10,'".$idReclamantePersona."', '', '', '', '', '', '', '','','','','','','','','','','','".$idInvestigacion."','','','','','','".$usuario."',@resp)";


     if (mysqli_query($con,$consultaRegistrarReclamante))
      {
         mysqli_next_result($con);
        $consultaRespuestaCrearReclamantes=mysqli_query($con,"SELECT @resp as resp");
         $respCrearReclamantes=mysqli_fetch_assoc($consultaRespuestaCrearReclamantes);
        $variable=$respCrearReclamantes["resp"];
        
          
      
      }else{
         $variable=2;
      }

      return $variable;
}


function registrarVictima($idVictima,$fechaIngresoVictimaFrm,$fechaEgresoVictimaFrm,$ipsVictimaFrm,$condicionVictimaFrm,$resultadoVictimaFrm,$indicadorFraudeVictimaFrm,$usuario,$idRegistroInvestigacionVictimaSOAT,$observacionesVictimaFrm)
{
     global $con;
     $data=array();

     $consultaRegistrarVictima="CALL manejoLesionadosSOAT(7,'".$idVictima."', '".$fechaIngresoVictimaFrm."', '".$fechaEgresoVictimaFrm."', '".$ipsVictimaFrm."', '".$condicionVictimaFrm."', '', '', '','','','','','','','','','','".$observacionesVictimaFrm."','".$idRegistroInvestigacionVictimaSOAT."','".$resultadoVictimaFrm."','".$indicadorFraudeVictimaFrm."','','','','".$usuario."',@resp)";


     if (mysqli_query($con,$consultaRegistrarVictima))
      {
         mysqli_next_result($con);
        $consultaRespuestaCrearVictimas=mysqli_query($con,"SELECT @resp as resp");
        mysqli_next_result($con);
        $infoVictima=consultarVictima($idRegistroInvestigacionVictimaSOAT);
        @$data["nombre_persona"]=@$infoVictima["nombre_persona"];
       

        $respCrearVictimas=mysqli_fetch_assoc($consultaRespuestaCrearVictimas);
        $data["resultado"]=$respCrearVictimas["resp"];
      
      }else{
         $data["resultado"]=2;
      }

      return $data;
}



function consultarVictima($idInvestigacion)
{
    global $con;
    $data=array();
    
    $consultaInformacionVictima="CALL manejoLesionadosSOAT(9,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idInvestigacion."','',@resp)";
    
    
    $queryInformacionVictima=mysqli_query($con,$consultaInformacionVictima);
    $data["cantidad_registros_victima"]=mysqli_num_rows($queryInformacionVictima);
     if (mysqli_num_rows($queryInformacionVictima)>0){
      $resInformacionVictima=mysqli_fetch_array($queryInformacionVictima,MYSQLI_ASSOC);
      $data["id"]=$resInformacionVictima["id"];
      $data["id_persona"]=$resInformacionVictima["id_persona"];
      $data["id_investigacion"]=$resInformacionVictima["id_investigacion"];
      $data["ips"]=$resInformacionVictima["ips"];
      $data["fecha_ingreso"]=$resInformacionVictima["fecha_ingreso"];
      $data["fecha_egreso"]=$resInformacionVictima["fecha_egreso"];
      $data["condicion"]=$resInformacionVictima["condicion"];
      $data["resultado"]=$resInformacionVictima["resultado"];
      $data["indicador_fraude"]=$resInformacionVictima["indicador_fraude"];
      $data["nombre_persona"]=$resInformacionVictima["nombre_persona"];
      $data["identificacion"]=$resInformacionVictima["identificacion"];    
      $data["observaciones"]=$resInformacionVictima["observaciones"]; 
  }
  return $data;
}


function registrarBeneficiario($idBeneficiario,$parentescoBeneficiarioFrm,$usuario,$idRegistroInvestigacionBeneficiarioSOAT){

    global $con;
    $data=array();
    $consultaRegistrarBeneficiario="CALL manejoLesionadosSOAT(12,'".$idBeneficiario."', '', '', '', '', '', '', '','','','','','','','','','','".$parentescoBeneficiarioFrm."','".$idRegistroInvestigacionBeneficiarioSOAT."','','','','','','".$usuario."',@resp)";
    if (mysqli_query($con,$consultaRegistrarBeneficiario)){
        mysqli_next_result($con);
        $consultaRespuestaCrearBeneficiarios=mysqli_query($con,"SELECT @resp as resp");
        $respCrearBeneficiarios=mysqli_fetch_assoc($consultaRespuestaCrearBeneficiarios);
        $variable=$respCrearBeneficiarios["resp"];      
    }else{
        $variable=2;
    }

    return $variable;
}

function modificarBeneficiario($idRegistroInvestigacionBeneficiarioSOAT,$idBeneficiario,$parentescoBeneficiarioFrm,$idPersonaBeneficiario,$usuario)
{
  global $con;
     $data=array();

     $consultaModificarBeneficiario="CALL manejoLesionadosSOAT(14,'".$idBeneficiario."', '', '', '', '', '', '', '','','','','','','','','','','".$parentescoBeneficiarioFrm."','".$idRegistroInvestigacionBeneficiarioSOAT."','','','','','".$idPersonaBeneficiario."','".$usuario."',@resp)";


     if (mysqli_query($con,$consultaModificarBeneficiario))
      {

      $consultaRespuestaModificarBeneficiario=mysqli_query($con,"SELECT @resp as resp");
      $respModificarBeneficiario=mysqli_fetch_assoc($consultaRespuestaModificarBeneficiario);
      $variable=$respModificarBeneficiario["resp"];
      
        
      
      }else{
         $variable = 2;
      }
        
      
     return ($variable);


}
  
function consultarReclamante($idInvestigacion)
{
    global $con;
    $data=array();
    
    $consultaInformacionReclamante="CALL manejoLesionadosSOAT(11,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idInvestigacion."','',@resp)";
    
    
    $queryInformacionReclamante=mysqli_query($con,$consultaInformacionReclamante);
    $data["cantidad_registros_reclamante"]=mysqli_num_rows($queryInformacionReclamante);
     if (mysqli_num_rows($queryInformacionReclamante)>0){
      $resInformacionReclamante=mysqli_fetch_array($queryInformacionReclamante,MYSQLI_ASSOC);
      $data["id"]=$resInformacionReclamante["id"];
      $data["id_persona"]=$resInformacionReclamante["id_persona"];
      $data["identificacion_persona"]=$resInformacionReclamante["identificacion"];
      $data["id_investigacion"]=$resInformacionReclamante["id_investigacion"];
      $data["nombre_persona"]=$resInformacionReclamante["nombre_persona"];
     

      
    
    
  }
  return $data;
}


function consultarBeneficiario($idBeneficiario){
    global $con;
    $data=array();
    $consultaInformacionBeneficiario="CALL manejoLesionadosSOAT(5,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idBeneficiario."','',@resp)"; 
    $queryInformacionBeneficiario=mysqli_query($con,$consultaInformacionBeneficiario);
    $data["cantidad_registros_beneficiario"]=mysqli_num_rows($queryInformacionBeneficiario);
    if (mysqli_num_rows($queryInformacionBeneficiario)>0){
        $resInformacionBeneficiario=mysqli_fetch_array($queryInformacionBeneficiario,MYSQLI_ASSOC);
        $data["id"]=$resInformacionBeneficiario["id"];
        $data["id_persona"]=$resInformacionBeneficiario["id_persona"];
        $data["id_investigacion"]=$resInformacionBeneficiario["id_investigacion"];
        $data["parentesco"]=$resInformacionBeneficiario["parentesco"];
        $data["observaciones"]=$resInformacionBeneficiario["observaciones"];
        $data["nombre_persona"]=$resInformacionBeneficiario["nombre_persona"];
        $data["identificacion"]=$resInformacionBeneficiario["identificacion"];
    }
    return $data;
}


function consultarLesionado($idLesionado)
{
  global $con;
    $data=array();
    
      $consultaInformacionLesionado="CALL manejoLesionadosSOAT(5,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idLesionado."','',@resp)";
    
    
    $queryInformacionLesionado=mysqli_query($con,$consultaInformacionLesionado);
    $data["cantidad_registros_lesionados"]=mysqli_num_rows($queryInformacionLesionado);
     if (mysqli_num_rows($queryInformacionLesionado)>0){
      $resInformacionLesionado=mysqli_fetch_array($queryInformacionLesionado,MYSQLI_ASSOC);
      $data["id"]=$resInformacionLesionado["id"];
      $data["id_persona"]=$resInformacionLesionado["id_persona"];
      $data["id_investigacion"]=$resInformacionLesionado["id_investigacion"];
      $data["ips"]=$resInformacionLesionado["ips"];
      $data["fecha_ingreso"]=$resInformacionLesionado["fecha_ingreso"];
      $data["fecha_egreso"]=$resInformacionLesionado["fecha_egreso"];
      $data["condicion"]=$resInformacionLesionado["condicion"];
      $data["seguridad_social"]=$resInformacionLesionado["seguridad_social"];
      $data["eps"]=$resInformacionLesionado["eps"];
      $data["causal_consulta"]=$resInformacionLesionado["causal_consulta"];
      $data["regimen"]=$resInformacionLesionado["regimen"];
      $data["estado"]=$resInformacionLesionado["estado"];
      $data["lesiones"]=$resInformacionLesionado["lesiones"];
      $data["tratamiento"]=$resInformacionLesionado["tratamiento"];
      $data["relato"]=$resInformacionLesionado["relato"];
      $data["observaciones"]=$resInformacionLesionado["observaciones"];
      $data["servicio_ambulancia"]=$resInformacionLesionado["servicio_ambulancia"];
      $data["tipo_traslado_ambulancia"]=$resInformacionLesionado["tipo_traslado_ambulancia"];
      $data["tipo_vehiculo_traslado"]=$resInformacionLesionado["tipo_vehiculo_traslado"];
      $data["lugar_traslado"]=$resInformacionLesionado["lugar_traslado"];
      $data["resultado"]=$resInformacionLesionado["resultado"];
      $data["indicador_fraude"]=$resInformacionLesionado["indicador_fraude"];
      $data["nombre_persona"]=$resInformacionLesionado["nombre_persona"];
      $data["identificacion"]=$resInformacionLesionado["identificacion"];
      $data["ips_remitido"]=$resInformacionLesionado["ips_remitido"];
      $data["remitido"]=$resInformacionLesionado["remitido"];

      
    
    
  }
  return $data;
}


function cambiarTipoPersona($idPersona)
{
  global $con;
    $data=array();

      $consultaCambiarTipoPersona="CALL manejoLesionadosSOAT(3,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idPersona."','',@resp)";

  
    
    if (mysqli_query($con,$consultaCambiarTipoPersona)){
       $consultaRespuestaCambiarTipoPersona=mysqli_query($con,"SELECT @resp as resp");
      $respCambiarTipoPersona=mysqli_fetch_assoc($consultaRespuestaCambiarTipoPersona);
      $variable=$respCambiarTipoPersona["resp"];
    }
    
  return $variable;
}


function eliminarBeneficiariosCasoSOAT($idRegistro,$idUsuario)
{
    global $con;
    $data=array();

      $consultaEliminarBeneficiario="CALL manejoLesionadosSOAT(4,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idRegistro."','".$idUsuario."',@resp)";

  
    
    if (mysqli_query($con,$consultaEliminarBeneficiario)){
       $consultaRespuestaEliminarBeneficiario=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarBeneficiario=mysqli_fetch_assoc($consultaRespuestaEliminarBeneficiario);
      $variable=$respEliminarBeneficiario["resp"];
    }
    
  return $variable;
}

function eliminarPersonaLesionadoSOAT($idPersona,$idUsuario)
{
  global $con;
    $data=array();

      $consultaEliminarLesionado="CALL manejoLesionadosSOAT(13,'', '', '', '', '', '', '','','','','','','','','','','','','','','','','','".$idPersona."','".$idUsuario."',@resp)";

  
    
    if (mysqli_query($con,$consultaEliminarLesionado)){
       $consultaRespuestaEliminarLesionado=mysqli_query($con,"SELECT @resp as resp");
      $respEliminarLesionado=mysqli_fetch_assoc($consultaRespuestaEliminarLesionado);
      $variable=$respEliminarLesionado["resp"];
    }
    
  return $variable;
}

 ?>