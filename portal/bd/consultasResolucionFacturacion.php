<?php
include('../conexion/conexion.php');
include('consultasBasicas.php');


function registrarResolucionesFacturacion($numero_resolucion,$fecha_resolucion,$num_inicial_resolucion,$num_final_resolucion,$idUsuario)
{

  global $con;

$consultarResolucionFacturacion="CALL manejoResolucionesFacturacion(1,'".$numero_resolucion."','".$fecha_resolucion."','".$num_inicial_resolucion."','".$num_final_resolucion."','','".$idUsuario."',@resp)";

if (mysqli_query($con,$consultarResolucionFacturacion))
{

  $consultaRespuestaResolucionFacturacion=mysqli_query($con,"SELECT @resp as resp");
  $respResolucionFacturacion=mysqli_fetch_assoc($consultaRespuestaResolucionFacturacion);
  $variable=$respResolucionFacturacion["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}




function eliminarResolucionFacturacion($idRegistro)
{

  global $con;

$consultaEliminarResolucionFacturacion="CALL manejoResolucionesFacturacion(3,'','','','','".$idRegistro."','',@resp)";

if (mysqli_query($con,$consultaEliminarResolucionFacturacion))
{

  $consultaRespuestaEliminarResolucionFacturacion=mysqli_query($con,"SELECT @resp as resp");
  $respEliminarResolucionFacturacion=mysqli_fetch_assoc($consultaRespuestaEliminarResolucionFacturacion);
  $variable=$respEliminarResolucionFacturacion["resp"];

  
}else{
  $variable=2;
}
      return ($variable);
}


?>