<?php
include('../conexion/conexion.php');

function eliminarUsuario($idUsuario){
  global $con;
  $consultarEliminarUsuario="CALL manejoUsuarios(4,'','','','','','".$idUsuario."','','','',@resp)";

  if (mysqli_query($con,$consultarEliminarUsuario)){

    $consultaRespuestaEliminarUsuario=mysqli_query($con,"SELECT @resp as resp");
    $respEliminarUsuario=mysqli_fetch_assoc($consultaRespuestaEliminarUsuario);
    $variable=$respEliminarUsuario["resp"];
  }else{
    $variable=2;
  }
  return ($variable);
}

function vigenciaUsuarios($idUsuario){
  global $con;
  $consultarPermitirUsuario="CALL manejoUsuarios(3,'','','','','','".$idUsuario."','','','',@resp)";

  if (mysqli_query($con,$consultarPermitirUsuario)){

    $consultaRespuestaPermitirUsuario=mysqli_query($con,"SELECT @resp as resp");
    $respPermitirUsuario=mysqli_fetch_assoc($consultaRespuestaPermitirUsuario);
    $variable=$respPermitirUsuario["resp"];
  }else{
    $variable=2;
  }
  return ($variable);
}

function registrarUsuario($nombresUsuarioFrm,$apellidoUsuarioFrm,$userUsuarioFrm,$correoUsuarioFrm,$contrasenaUsuarioFrm,$idUsuario,$tipoUserUsuarioFrm,$aseguradoraUsuarioFrm,$investigadorUsuarioFrm){
  global $con;
  $clave=generarClave($contrasenaUsuarioFrm);
  $consultarCrearUsuario="CALL manejoUsuarios(1,'".$userUsuarioFrm."','".$nombresUsuarioFrm."','".$apellidoUsuarioFrm."','".$correoUsuarioFrm."','".$clave."','".$investigadorUsuarioFrm."','".$idUsuario."','".$tipoUserUsuarioFrm."','".$aseguradoraUsuarioFrm."',@resp)";

  if (mysqli_query($con,$consultarCrearUsuario)){

    $consultaRespuestaCrearUsuario=mysqli_query($con,"SELECT @resp as resp");
    $respCrearUsuario=mysqli_fetch_assoc($consultaRespuestaCrearUsuario);
    $variable=$respCrearUsuario["resp"];
  }else{
    $variable=2;
  }
  return ($variable);
}

function consultarUsuario($registroUsuario){
  global $con;
  $data=array();
  $consultaInformacionUsuario="CALL manejoUsuarios(6,'','','','','',$registroUsuario,NULL,NULL,NULL,@resp)"; 
  $consultarInformacionUsuario=mysqli_query($con,$consultaInformacionUsuario);
  if (mysqli_num_rows($consultarInformacionUsuario)>0){
    $resInformacionUsuario=mysqli_fetch_array($consultarInformacionUsuario,MYSQLI_ASSOC);
    
    $data["id"]=$resInformacionUsuario["id"];
    $data["nombres"]=$resInformacionUsuario["nombres"];
    $data["apellidos"]=$resInformacionUsuario["apellidos"];
    $data["usuario"]=$resInformacionUsuario["usuario"];
    $data["correo"]=$resInformacionUsuario["correo"];
    $data["vigente"]=$resInformacionUsuario["vigente"];
    $data["passwd"]=$resInformacionUsuario["passwd"];
    $data["tipo_usuario"]=$resInformacionUsuario["tipo_usuario"];
    $data["id_aseguradora"]=$resInformacionUsuario["id_aseguradora"];
    $data["empleado"]=$resInformacionUsuario["empleado"];
    $data["id_investigador"]=$resInformacionUsuario["id_investigador"];
  }
  return $data;
}

function cambiarClave($contrasenaUsuarioFrm,$registroUsuario){
  global $con;
  $clave=generarClave($contrasenaUsuarioFrm);

  $consultarCambiarClaveUsuario="CALL manejoUsuarios(5,'','','','','".$clave."','".$registroUsuario."','','','',@resp)";
  mysqli_next_result($con);

  if (mysqli_query($con,$consultarCambiarClaveUsuario)){

    $consultaRespuestaCambiarUsuario=mysqli_query($con,"SELECT @resp as resp");
    $respCambiarUsuario=mysqli_fetch_assoc($consultaRespuestaCambiarUsuario);
    $variable=$respCambiarUsuario["resp"];
  }else{
    $variable="2";
  }
 return ($variable);
}

function modificarUsuario($nombresUsuarioFrm,$apellidoUsuarioFrm,$userUsuarioFrm,$correoUsuarioFrm,$contrasenaUsuarioFrm,$registroUsuario,$tipoUserUsuarioFrm,$aseguradoraUsuarioFrm,$investigadorUsuarioFrm){

  global $con;

  $consultarModificarUsuario="CALL manejoUsuarios(2,'".$userUsuarioFrm."','".$nombresUsuarioFrm."','".$apellidoUsuarioFrm."','".$correoUsuarioFrm."','','".$registroUsuario."','".$investigadorUsuarioFrm."','".$tipoUserUsuarioFrm."','".$aseguradoraUsuarioFrm."',@resp)";

  if (mysqli_query($con,$consultarModificarUsuario)){
    if ($contrasenaUsuarioFrm!=""){
      $var2=cambiarClave($contrasenaUsuarioFrm,$registroUsuario);
    }

    $consultaRespuestaModificarUsuario=mysqli_query($con,"SELECT @resp as resp");
    $respModificarUsuario=mysqli_fetch_assoc($consultaRespuestaModificarUsuario);
    $variable=$respModificarUsuario["resp"];
  }else{
    $variable=22;
  }
  return ($variable);
}

function generarClave($clave){
  $nuevaclave=md5(sha1(md5(sha1($clave))));
  return ($nuevaclave);
}

function asignarOpcionesUsuarios($idUsuarioOpcion,$idUsuario,$opcionesAsignar){
  global $con;

  $consultarOpcionesUsuarios="CALL manejoOpcionesUsuarios(1,'".$idUsuarioOpcion."','','',@resp)";

  if (mysqli_query($con,$consultarOpcionesUsuarios)){

    $variable=0;
    $consultaRespuestaOpcionesUsuarios=mysqli_query($con,"SELECT @resp as resp");
    $respOpcionesUsuarios=mysqli_fetch_assoc($consultaRespuestaOpcionesUsuarios);

    if ($respOpcionesUsuarios["resp"]==1){

      $opcionesDecodificdas=json_decode($opcionesAsignar);
      foreach ($opcionesDecodificdas as $passOpcionesDecodificadas) {

        $consultarOpcionesUsuarios="CALL manejoOpcionesUsuarios(2,'".$idUsuarioOpcion."','".$passOpcionesDecodificadas->codigoOpcion."','".$idUsuario."',@resp)";
        if (mysqli_query($con,$consultarOpcionesUsuarios)){

          $consultaRespuestaAsignarOpcion=mysqli_query($con,"SELECT @resp as resp");
          $respAsignarOpcion=mysqli_fetch_assoc($consultaRespuestaAsignarOpcion);
          $variable=$respAsignarOpcion["resp"];
        }
      }
    }    
  }else{
    $variable=22;
  }
  return ($variable);
}

function cambiarPaswordUsuario($actualContrasenaFrmCPass,$nuevaContrasenaFrmCPass,$idUsuario){
  $consultaInformacion=consultarUsuario($idUsuario);
  if (generarClave($actualContrasenaFrmCPass)==$consultaInformacion["passwd"]){

    $variable=cambiarClave($nuevaContrasenaFrmCPass,$idUsuario);
  }else{
    $variable=3;
  }
  return ($variable);
} ?>