<?php
include('../bd/consultasResolucionFacturacion.php');

if ($_POST["exe"]=="eliminarResolucionFacturacion")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarResolucionFacturacion($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="registrarResolucionesFacturacion"){
	$numero_resolucion=$_POST["numero_resolucion"];
	$fecha_resolucion=$_POST["fecha_resolucion"];
	$num_inicial_resolucion=$_POST["num_inicial_resolucion"];
	$num_final_resolucion=$_POST["num_final_resolucion"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=registrarResolucionesFacturacion($numero_resolucion,$fecha_resolucion,$num_inicial_resolucion,$num_final_resolucion,$idUsuario);
	echo $variable;
}
?>