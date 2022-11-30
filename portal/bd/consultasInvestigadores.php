<?php
include('../conexion/conexion.php');


function eliminarInvestigador($idInvestigador){
  global $con;
  $consultarEliminarInvestigador="CALL manejoInvestigadores(4,'','','','','','','','".$idInvestigador."','','','','','',@resp)";

  if (mysqli_query($con,$consultarEliminarInvestigador)){

    $consultaRespuestaEliminarInvestigador=mysqli_query($con,"SELECT @resp as resp");
    $respEliminarInvestigador=mysqli_fetch_assoc($consultaRespuestaEliminarInvestigador);
    $variable=$respEliminarInvestigador["resp"];
  }else{
    $variable=2;
  }
  return ($variable);
}

function vigenciaInvestigador($idInvestigador){
  global $con;
  $consultarPermitirInvestigador="CALL manejoInvestigadores(3,'','','','','','','','".$idInvestigador."','','','','','',@resp)";

  if (mysqli_query($con,$consultarPermitirInvestigador)){
    $consultaRespuestaPermitirInvestigador=mysqli_query($con,"SELECT @resp as resp");
    $respPermitirInvestigador=mysqli_fetch_assoc($consultaRespuestaPermitirInvestigador);
    $variable=$respPermitirInvestigador["resp"];
  }else{
    $variable=2;
  }
  return ($variable);
}

function registrarInvestigador($nombresInvestigadoresFrm,$apellidoInvestigadoresFrm,$tipoIdentificacionInvestigadoresFrm,$identificacionInvestigadoresFrm,$lugarExpedicionInvestigadoresFrm,$telefonoInvestigadoresFrm,$correoInvestigadoresFrm,$direccionInvestigadoresFrm,$estudiosInvestigadoresFrm,$experienciaInvestigadoresFrm,$imagenInvestigadoresFrm,$usuario){
  global $con;

  $nombreArchivo = "";
  if (!empty($imagenInvestigadoresFrm)){
    $extension=explode("/",$imagenInvestigadoresFrm['type']);

    $nombreArchivo = $identificacionInvestigadoresFrm."-".str_replace(' ', '', $apellidoInvestigadoresFrm).".".$extension[1];
    $ruta="data/fotos_perfil/".$nombreArchivo;

    move_uploaded_file($imagenInvestigadoresFrm['tmp_name'], "../".$ruta);
  }else{
    $nombreArchivo = null;
  }

  $consultarCrearInvestigadores="CALL manejoInvestigadores(1,'".$nombresInvestigadoresFrm."','".$apellidoInvestigadoresFrm."','".$tipoIdentificacionInvestigadoresFrm."','".$identificacionInvestigadoresFrm."','".$telefonoInvestigadoresFrm."','".$correoInvestigadoresFrm."','".$direccionInvestigadoresFrm."','','".$usuario."','".$lugarExpedicionInvestigadoresFrm."','".$estudiosInvestigadoresFrm."','".$experienciaInvestigadoresFrm."','".$nombreArchivo."',@resp)";

  if (mysqli_query($con,$consultarCrearInvestigadores)){
    $consultaRespuestaCrearInvestigadores=mysqli_query($con,"SELECT @resp as resp");
    $respCrearInvestigadores=mysqli_fetch_assoc($consultaRespuestaCrearInvestigadores);
    $variable=$respCrearInvestigadores["resp"];
  }else{
    $variable=3;
  }
  return ($variable);
}

function consultarInvestigador($idRegistroInvestigador){
  global $con;
  $data=array();
  $consultaInformacionInvestigador="CALL manejoInvestigadores(5,'','','','','','','','".$idRegistroInvestigador."','','','','','',@resp)";

  $consultarInformacionInvestigador=mysqli_query($con,$consultaInformacionInvestigador);

  if (mysqli_num_rows($consultarInformacionInvestigador)>0){
    $resInformacionInvestigador=mysqli_fetch_array($consultarInformacionInvestigador,MYSQLI_ASSOC);
    
    $data["id"]=$resInformacionInvestigador["id"];
    $data["nombres"]=$resInformacionInvestigador["nombres"];
    $data["apellidos"]=$resInformacionInvestigador["apellidos"];
    $data["tipo_identificacion"]=$resInformacionInvestigador["tipo_identificacion"];
    $data["identificacion"]=$resInformacionInvestigador["identificacion"];
    $data["lugar_expedicion"]=$resInformacionInvestigador["lugar_expedicion"];
    $data["telefono"]=$resInformacionInvestigador["telefono"];
    $data["direccion"]=$resInformacionInvestigador["direccion"];
    $data["correo"]=$resInformacionInvestigador["correo"];
    $data["estudios"]=$resInformacionInvestigador["estudios"];
    $data["experiencia"]=$resInformacionInvestigador["experiencia"];
    $data["vigente"]=$resInformacionInvestigador["vigente"]; 
  }
  return $data;
}

function modificarInvestigador($nombresInvestigadoresFrm,$apellidoInvestigadoresFrm,$tipoIdentificacionInvestigadoresFrm,$identificacionInvestigadoresFrm,$lugarExpedicionInvestigadoresFrm,$telefonoInvestigadoresFrm,$correoInvestigadoresFrm,$direccionInvestigadoresFrm,$idRegistroInvestigador,$estudiosInvestigadoresFrm,$experienciaInvestigadoresFrm,$imagenInvestigadoresFrm){
  global $con;

  $nombreArchivo = "";
  if (!empty($imagenInvestigadoresFrm)){
    $extension=explode("/",$imagenInvestigadoresFrm['type']);

    $nombreArchivo = $identificacionInvestigadoresFrm."-".str_replace(' ', '', $apellidoInvestigadoresFrm).".".$extension[1];
    $ruta="data/fotos_perfil/".$nombreArchivo;

    if(file_exists("../".$ruta)){
      unlink("../".$ruta);
      move_uploaded_file($imagenInvestigadoresFrm['tmp_name'], "../".$ruta);
    }else{
      move_uploaded_file($imagenInvestigadoresFrm['tmp_name'], "../".$ruta);
    }
  }else{
    $nombreArchivo = null;
  }  

  $consultarModificarInvestigador="CALL manejoInvestigadores(2,'".$nombresInvestigadoresFrm."','".$apellidoInvestigadoresFrm."','".$tipoIdentificacionInvestigadoresFrm."','".$identificacionInvestigadoresFrm."','".$telefonoInvestigadoresFrm."','".$correoInvestigadoresFrm."','".$direccionInvestigadoresFrm."','".$idRegistroInvestigador."','','".$lugarExpedicionInvestigadoresFrm."','".$estudiosInvestigadoresFrm."','".$experienciaInvestigadoresFrm."','".$nombreArchivo."',@resp)";

  if (mysqli_query($con,$consultarModificarInvestigador)){

    $consultaRespuestaModificarInvestigador=mysqli_query($con,"SELECT @resp as resp");
    $respModificarInvestigador=mysqli_fetch_assoc($consultaRespuestaModificarInvestigador);
    $variable=$respModificarInvestigador["resp"];
  }else{
    $variable=22;
  }
  return ($variable);
}

function asignarCasosCuentaInv($id_investigador, $periodo, $numero, $casos, $id_usuario ){
  global $con;

  $queryCuenta="SELECT id, estado FROM cuenta_cobro_investigador WHERE id_investigador = $id_investigador AND periodo = '$periodo' AND numero = '$numero'";
  $respCuenta = mysqli_query($con,$queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0){
    $datosCuenta = mysqli_fetch_assoc($respCuenta);
    if($datosCuenta['estado'] != 2){
      foreach ($casos as $caso) {
        $in=0;
        mysqli_query($con,"INSERT INTO investigaciones_cuenta_investigador (id_cuenta_cobro, id_investigacion) VALUES(".$datosCuenta['id'].", ".intval($caso).");");
      }
      
      $variable=1;
    }else{
      $variable=3;
    }
  }else{
    $variable=2;
  }
  
  return ($variable);
}

function crearCuentaInv($id_investigador, $periodo, $numero, $casos, $id_usuario ){
  global $con;

  $queryCuenta="SELECT * FROM cuenta_cobro_investigador WHERE id_investigador = $id_investigador AND periodo = '$periodo' AND numero = '$numero'";
  $respCuenta = mysqli_query($con,$queryCuenta);

  if (mysqli_num_rows($respCuenta) == 0){

    $queryInsertCuenta="INSERT INTO cuenta_cobro_investigador (id_investigador, periodo, numero, id_usuario) VALUES($id_investigador, '$periodo', $numero, $id_usuario);";
    
    if(mysqli_query($con,$queryInsertCuenta)){
      $variable=asignarCasosCuentaInv($id_investigador, $periodo, $numero, $casos, $id_usuario);
    }else{
      $variable=2;
    }
  }else{
    $variable=2;
  }
  
  return ($variable);
}

function eliminarCasoCuentaInv($id_investigacion, $id_cuenta){
  global $con;

  $queryCasoCuenta="SELECT * FROM investigaciones_cuenta_investigador WHERE id_cuenta_cobro = $id_cuenta AND id_investigacion = $id_investigacion";
  $respCasoCuenta = mysqli_query($con,$queryCasoCuenta);

  if (mysqli_num_rows($respCasoCuenta) > 0){
    if(mysqli_query($con,"DELETE FROM investigaciones_cuenta_investigador WHERE id_cuenta_cobro = $id_cuenta AND id_investigacion = $id_investigacion")){
      $variable=1;
    }else{
      $variable=3;
    }    
  }else{
    $variable=2;
  }
  return ($variable);  
}

function cerrarCuentaCobroInv($id_cuenta, $viaticosVerCasosInv, $adicionalVerCasosInv, $subtotal, $total, $cantidad, $idCasos, $valorCasos, $tarifaCasos, $observacionVerCasosInv, $id_usuario){
  global $con;

  $queryCuenta="SELECT id FROM cuenta_cobro_investigador WHERE id = '$id_cuenta' AND estado != 2";
  $respCuenta = mysqli_query($con,$queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0){
    $cont = 0;
    foreach ($idCasos as $id) {
      mysqli_query($con,"UPDATE investigaciones_cuenta_investigador SET valor_pagado = ".intval($valorCasos[$cont]).", id_tarifa = ".intval($tarifaCasos[$cont])." WHERE id_cuenta_cobro = '$id_cuenta' AND id_investigacion = '$id'");
      $cont++;
    }

    $subtotal = str_replace('.', '', $subtotal);
    $total = str_replace('.', '', $total);

    if(mysqli_query($con,"UPDATE cuenta_cobro_investigador SET cantidad_investigaciones = $cantidad, valor_viaticos = $viaticosVerCasosInv, valor_adicional = $adicionalVerCasosInv, valor_total = $total, valor_investigaciones = $subtotal, estado = 2, fecha_cerrada = CURRENT_TIMESTAMP(), observacion = '".$observacionVerCasosInv."' WHERE id = $id_cuenta")){
      $variable=1;
    }else{
      $variable=2;
    }
  }else{
    $variable=3;
  }
  
  return ($variable);
}

function habilitarCuentaCobroInv($id_cuenta){
  global $con;

  $queryCuenta="SELECT id FROM cuenta_cobro_investigador WHERE id = '$id_cuenta'";
  $respCuenta = mysqli_query($con,$queryCuenta);

  if (mysqli_num_rows($respCuenta) > 0){ 
    mysqli_query($con,"UPDATE cuenta_cobro_investigador SET estado = 1 WHERE id = '$id_cuenta'");
    $variable=1;
  }else{
    $variable=2;    
  }

  return ($variable);
}
?>