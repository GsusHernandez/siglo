<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');


session_start();

function login($usuario, $password){
	$correo=addslashes($usuario);
	$clave=addslashes($password);
      global $con;
      if ($_SERVER['REMOTE_ADDR']=="::1"){
    $server="RED LOCAL GLOBAL RED LTDA";
  }else{
    $server=$_SERVER['REMOTE_ADDR'];
  }
  
$consultarLogin="CALL login ('".$correo."','".md5(sha1(md5(sha1($clave))))."','".$server."',@resp,@userResp)";

if (mysqli_query($con,$consultarLogin))
{

  $consultaRespuestaLogin=mysqli_query($con,"SELECT @resp as resp,@userResp as userResp ");
  $respLogin=mysqli_fetch_assoc($consultaRespuestaLogin);
  
  $variable=$respLogin["resp"]; 
  if ($variable==1)
    {
  $_SESSION["s_id"] =$respLogin["userResp"];
  }
    
    
  
}else{
  $variable=2;
}
      return ($variable);


  }



  

  function logout($usuario){
    global $con;
    if (guardarLogSesion($usuario,"5")==1)
            {
              session_destroy();
              $_SESSION=array();
              $respuesta=1; 
            }else{
              $respuesta=2; 
            }
  return $respuesta;

  }


?>