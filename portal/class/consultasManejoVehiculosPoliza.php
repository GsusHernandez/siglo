<?php
include('../bd/consultasVehiculosPolizas.php');

if ($_POST["exe"]=="registrarVehiculos")
{
	$tipoVehiculoFrmVehiculoPoliza=$_POST["tipoVehiculoFrmVehiculoPoliza"];
	$tipoServicioVehiculoFrmVehiculoPoliza=$_POST["tipoServicioVehiculoFrmVehiculoPoliza"];
	$placaVehiculoFrmVehiculoPoliza=$_POST["placaVehiculoFrmVehiculoPoliza"];
	$marcaVehiculoFrmVehiculoPoliza=$_POST["marcaVehiculoFrmVehiculoPoliza"];
	$modeloVehiculoFrmVehiculoPoliza=$_POST["modeloVehiculoFrmVehiculoPoliza"];
	$lineaVehiculoFrmVehiculoPoliza=$_POST["lineaVehiculoFrmVehiculoPoliza"];
	$colorVehiculoFrmVehiculoPoliza=$_POST["colorVehiculoFrmVehiculoPoliza"];
	$numVinVehiculoFrmVehiculoPoliza=$_POST["numVinVehiculoFrmVehiculoPoliza"];
	$numSerieVehiculoFrmVehiculoPoliza=$_POST["numSerieVehiculoFrmVehiculoPoliza"];
	$numChasisVehiculoFrmVehiculoPoliza=$_POST["numChasisVehiculoFrmVehiculoPoliza"];
	$numMotorVehiculoFrmVehiculoPoliza=$_POST["numMotorVehiculoFrmVehiculoPoliza"];
	$usuario=$_POST["usuario"];
	
	
	$variable=registrarVehiculos($tipoVehiculoFrmVehiculoPoliza,$tipoServicioVehiculoFrmVehiculoPoliza,$placaVehiculoFrmVehiculoPoliza,$marcaVehiculoFrmVehiculoPoliza,$modeloVehiculoFrmVehiculoPoliza,$lineaVehiculoFrmVehiculoPoliza,$colorVehiculoFrmVehiculoPoliza,$numVinVehiculoFrmVehiculoPoliza,$numSerieVehiculoFrmVehiculoPoliza,$numChasisVehiculoFrmVehiculoPoliza,$numMotorVehiculoFrmVehiculoPoliza,$usuario);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="registrarPolizas")
{
	$numeroPolizaFRM=$_POST["numeroPolizaFRM"];
	$digVerPolizaFrm=$_POST["digVerPolizaFrm"];
	$vigenciaPolizaFrm=$_POST["vigenciaPolizaFrm"];
	$tipoIdentificacionTomadorPolizaFrm=$_POST["tipoIdentificacionTomadorPolizaFrm"];
	$identificacionTomadorPolizaFrm=$_POST["identificacionTomadorPolizaFrm"];
	$nombreTomadorPolizaFrm=$_POST["nombreTomadorPolizaFrm"];
	$direccionTomadorPolizaFrm=$_POST["direccionTomadorPolizaFrm"];
	$telefonoTomadorPolizaFrm=$_POST["telefonoTomadorPolizaFrm"];
	$ciudadTomadorPolizaFrm=$_POST["ciudadTomadorPolizaFrm"];
	$ciudadExpedicionPolizaFrm=$_POST["ciudadExpedicionPolizaFrm"];
	$codSucursalPolizaFrm=$_POST["codSucursalPolizaFrm"];
	$claveProductorPolizaFrm=$_POST["claveProductorPolizaFrm"];
	$aseguradoraPolizaFrm=$_POST["aseguradoraPolizaFrm"];
	$idVehiculo=$_POST["idVehiculo"];
	$usuario=$_POST["usuario"];
	$idInvestigacionFrmVehiculos=$_POST["idInvestigacionFrmVehiculos"];
	
	
	$variable=registrarPolizas($idInvestigacionFrmVehiculos,$codSucursalPolizaFrm,$claveProductorPolizaFrm,$aseguradoraPolizaFrm,$numeroPolizaFRM,$digVerPolizaFrm,$vigenciaPolizaFrm,$tipoIdentificacionTomadorPolizaFrm,$identificacionTomadorPolizaFrm,$nombreTomadorPolizaFrm,$direccionTomadorPolizaFrm,$telefonoTomadorPolizaFrm,$ciudadTomadorPolizaFrm,$ciudadExpedicionPolizaFrm,$idVehiculo,$usuario);
	echo ($variable);
}
else if ($_POST["exe"]=="modificarPolizas")
{
	$numeroPolizaFRM=$_POST["numeroPolizaFRM"];
	$digVerPolizaFrm=$_POST["digVerPolizaFrm"];
	$vigenciaPolizaFrm=$_POST["vigenciaPolizaFrm"];
	$tipoIdentificacionTomadorPolizaFrm=$_POST["tipoIdentificacionTomadorPolizaFrm"];
	$identificacionTomadorPolizaFrm=$_POST["identificacionTomadorPolizaFrm"];
	$nombreTomadorPolizaFrm=$_POST["nombreTomadorPolizaFrm"];
	$direccionTomadorPolizaFrm=$_POST["direccionTomadorPolizaFrm"];
	$telefonoTomadorPolizaFrm=$_POST["telefonoTomadorPolizaFrm"];
	$ciudadTomadorPolizaFrm=$_POST["ciudadTomadorPolizaFrm"];
	$ciudadExpedicionPolizaFrm=$_POST["ciudadExpedicionPolizaFrm"];
	$codSucursalPolizaFrm=$_POST["codSucursalPolizaFrm"];
	$claveProductorPolizaFrm=$_POST["claveProductorPolizaFrm"];
	$aseguradoraPolizaFrm=$_POST["aseguradoraPolizaFrm"];
	$idPolizas=$_POST["idPolizas"];
	$idVehiculo=$_POST["idVehiculo"];
	$usuario=$_POST["usuario"];
	
	$variable=modificarPolizas($codSucursalPolizaFrm,$claveProductorPolizaFrm,$aseguradoraPolizaFrm,$numeroPolizaFRM,$digVerPolizaFrm,$vigenciaPolizaFrm,$tipoIdentificacionTomadorPolizaFrm,$identificacionTomadorPolizaFrm,$nombreTomadorPolizaFrm,$direccionTomadorPolizaFrm,$telefonoTomadorPolizaFrm,$ciudadTomadorPolizaFrm,$ciudadExpedicionPolizaFrm,$idPolizas,$idVehiculo,$usuario);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarPoliza")
{
	$idPoliza=$_POST["idPoliza"];
	$variable=consultarPoliza($idPoliza);


	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarVehiculo")
{
	$identificacionVehiculo=$_POST["identificacionVehiculo"];
	$tipoConsulta=$_POST["tipoConsulta"];
	$variable=consultarVehiculo($identificacionVehiculo,$tipoConsulta);


	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarVehiculoInvestigacion")
{
	$idCaso=$_POST["idCaso"];
	
	$variable=consultarVehiculoInvestigacion($idCaso);


	echo json_encode($variable);
}
else if($_POST["exe"]=="modificarVehiculos")
{
	$tipoVehiculoFrmVehiculoPoliza=$_POST["tipoVehiculoFrmVehiculoPoliza"];
	$tipoServicioVehiculoFrmVehiculoPoliza=$_POST["tipoServicioVehiculoFrmVehiculoPoliza"];
	$placaVehiculoFrmVehiculoPoliza=$_POST["placaVehiculoFrmVehiculoPoliza"];
	$marcaVehiculoFrmVehiculoPoliza=$_POST["marcaVehiculoFrmVehiculoPoliza"];
	$modeloVehiculoFrmVehiculoPoliza=$_POST["modeloVehiculoFrmVehiculoPoliza"];
	$lineaVehiculoFrmVehiculoPoliza=$_POST["lineaVehiculoFrmVehiculoPoliza"];
	$colorVehiculoFrmVehiculoPoliza=$_POST["colorVehiculoFrmVehiculoPoliza"];
	$numVinVehiculoFrmVehiculoPoliza=$_POST["numVinVehiculoFrmVehiculoPoliza"];
	$numSerieVehiculoFrmVehiculoPoliza=$_POST["numSerieVehiculoFrmVehiculoPoliza"];
	$numChasisVehiculoFrmVehiculoPoliza=$_POST["numChasisVehiculoFrmVehiculoPoliza"];
	$numMotorVehiculoFrmVehiculoPoliza=$_POST["numMotorVehiculoFrmVehiculoPoliza"];
	$idVehiculoFrmVehiculos=$_POST["idVehiculoFrmVehiculos"];
	
	$variable=modificarVehiculos($tipoVehiculoFrmVehiculoPoliza,$tipoServicioVehiculoFrmVehiculoPoliza,$placaVehiculoFrmVehiculoPoliza,$marcaVehiculoFrmVehiculoPoliza,$modeloVehiculoFrmVehiculoPoliza,$lineaVehiculoFrmVehiculoPoliza,$colorVehiculoFrmVehiculoPoliza,$numVinVehiculoFrmVehiculoPoliza,$numSerieVehiculoFrmVehiculoPoliza,$numChasisVehiculoFrmVehiculoPoliza,$numMotorVehiculoFrmVehiculoPoliza,$idVehiculoFrmVehiculos);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="seleccionarPolizaInvestigacion")
{
	$idPoliza=$_POST["idPoliza"];
	$idInvestigacion=$_POST["idInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	$variable=seleccionarPolizaInvestigacion($idPoliza,$idInvestigacion,$idUsuario);


	echo ($variable);
}
else if ($_POST["exe"]=="eliminarPolizaCasoSOAT")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$idTablaActualizar =$_POST["idTablaActualizar"];
	$variable=eliminarPolizaCasoSOAT($idRegistro, $idTablaActualizar, $idUsuario);
	echo $variable;
}
else if($_POST["exe"] == "consultarPolizasVehiculo"){
	
	$idVehiculo = $_POST["idVehiculo"];
	$variable=consultarPolizasVehiculo($idVehiculo);
	echo $variable;
}

?>