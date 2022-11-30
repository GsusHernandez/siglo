<?php 

include('../bd/consultaTablas.php'); 

if ($_POST["exeTabla"]=="consultarCasosSOAT")
{
	$codigoFrmBuscarSOAT=$_POST["codigoFrmBuscarSOAT"];
	$nombresFrmBuscarSOAT=$_POST["nombresFrmBuscarSOAT"];
	$apellidosFrmBuscarSOAT=$_POST["apellidosFrmBuscarSOAT"];
	$identificacionFrmBuscarSOAT=$_POST["identificacionFrmBuscarSOAT"];
	$placaFrmBuscarSOAT=$_POST["placaFrmBuscarSOAT"];
	$polizaFrmBuscarSOAT=$_POST["polizaFrmBuscarSOAT"];
	$identificadorFrmBuscarSOAT=$_POST["identificadorFrmBuscarSOAT"];
	$fechaAccidenteBuscar = $_POST["fechaAccideneteBuscar"];
	$usuario=$_POST["usuario"];
	$tipoConsultaBuscar=$_POST["tipoConsultaBuscar"];

	
	$variable=consultarCasosSOAT($codigoFrmBuscarSOAT,$nombresFrmBuscarSOAT,$apellidosFrmBuscarSOAT,$identificacionFrmBuscarSOAT,$placaFrmBuscarSOAT,$polizaFrmBuscarSOAT,$identificadorFrmBuscarSOAT, $tipoConsultaBuscar,$usuario); 
	echo $variable;
}









?>