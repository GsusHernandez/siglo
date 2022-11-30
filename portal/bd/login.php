<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');

session_start();

function login($usuario, $password){
  $correo=addslashes($usuario);
  $clave=addslashes($password);
  global $con;
  
 // $consultaLogin = mysqli_query($con,"SELECT * FROM usuarios WHERE usuario = '".$correo."' AND passwd = '".md5(sha1(md5(sha1($clave))))."' AND vigente = 's' AND empleado = 's'");
 
 $consultaLogin = mysqli_query($con, "SELECT * FROM usuarios WHERE usuario = '".$correo."' AND vigente = 's' AND empleado = 's'");

  if (mysqli_num_rows($consultaLogin) > 0){

    $verificarPass = mysqli_query($con, "SELECT * FROM usuarios WHERE usuario = '".$correo."' AND passwd = '".md5(sha1(md5(sha1($clave))))."' AND vigente = 's' AND empleado = 's'");

    if (mysqli_num_rows($verificarPass) === 0){
      $sqlContraseñaMaestra = mysqli_query($con, "SELECT * FROM usuarios WHERE usuario = 'globalred'  AND passwd = '".md5(sha1(md5(sha1($clave))))."' AND vigente = 's' AND empleado = 's'");
    }

    $datosLoguin = mysqli_fetch_assoc($consultaLogin);
    $_SESSION = $datosLoguin;

    $consultaPermisos = mysqli_query($con,"SELECT a.id,a.codigo,a.opcion_padre, a.descripcion, a.tipo_opcion, a.ruta, a.ruta_script, a.ruta_modales, a.icono FROM opciones a LEFT JOIN opciones_usuarios b on a.id=b.opcion WHERE b.usuario='".$_SESSION['id']."' and a.vigente='s'");
    guardarLogSesion($_SESSION['id'],"1");

    if(mysqli_num_rows($consultaPermisos) > 0){
      $ultimoTipo = 0;
      while ($opcion = mysqli_fetch_assoc($consultaPermisos)) {
        //$_SESSION["opcionesCOmpl"][] = $opcion;
        if($ultimoTipo != $opcion['tipo_opcion']){
          $_SESSION["opciones"]["tipo"][$opcion['tipo_opcion']][] = $opcion;
        }else{
          $ultimoTipo = $opcion['tipo_opcion'];
        }        
        $_SESSION["opciones"]["codigo"][$opcion['codigo']] = $opcion;
        $_SESSION["opciones"]["padre"][$opcion['codigo']] = $opcion;
      }
      $variable = 1;
    }else{
      $variable = 3;
    }
  }else{
    $variable=2;
  }

  return ($variable);
}

function logout($usuario){

  global $con;
  
  if (guardarLogSesion($usuario,"5")==1) {
    session_destroy();
    $_SESSION=array();
    $respuesta=1; 
  }else{
    $respuesta=2; 
  }

  return $respuesta;
} ?>