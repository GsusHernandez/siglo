<?php
include('../bd/consultasPersonas.php');

if ($_POST["exe"]=="registrarPersonas"){
	$tipoIdentificacionPersonasFrm=$_POST["tipoIdentificacionPersonasFrm"];
	$sexoPersonasFrm=$_POST["sexoPersonasFrm"];
	$nombresPersonasFrm=$_POST["nombresPersonasFrm"];
	$apellidosPersonasFrm=$_POST["apellidosPersonasFrm"];
	$identificacionPersonasFrm=$_POST["identificacionPersonasFrm"];
	$edadPersonasFrm=$_POST["edadPersonasFrm"];
	$telefonoPersonasFrm=$_POST["telefonoPersonasFrm"];
	$direccionPersonasFrm=$_POST["direccionPersonasFrm"];
	$barrioPersonasFrm=$_POST["barrioPersonasFrm"];
	$ciudadPersonasFrm=$_POST["ciudadPersonasFrm"];
	$usuario=$_POST["usuario"];
	$ocupacionPersonasFrm=$_POST["ocupacionPersonasFrm"];
	
	$variable=registrarPersonas($tipoIdentificacionPersonasFrm,$sexoPersonasFrm,$nombresPersonasFrm,$apellidosPersonasFrm,$identificacionPersonasFrm,$edadPersonasFrm,$telefonoPersonasFrm,$direccionPersonasFrm,$barrioPersonasFrm,$ciudadPersonasFrm,$usuario,$ocupacionPersonasFrm);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarPersonas"){
	$identificacionPersona=$_POST["identificacionPersona"];
	$tipoConsulta=$_POST["tipoConsulta"];
	$variable=consultarPersonas($identificacionPersona,$tipoConsulta);


	echo json_encode($variable);
}
else if($_POST["exe"]=="modificarPersonas"){
	$tipoIdentificacionPersonasFrm=$_POST["tipoIdentificacionPersonasFrm"];
	$sexoPersonasFrm=$_POST["sexoPersonasFrm"];
	$nombresPersonasFrm=$_POST["nombresPersonasFrm"];
	$apellidosPersonasFrm=$_POST["apellidosPersonasFrm"];
	$identificacionPersonasFrm=$_POST["identificacionPersonasFrm"];
	$edadPersonasFrm=$_POST["edadPersonasFrm"];
	$telefonoPersonasFrm=$_POST["telefonoPersonasFrm"];
	$direccionPersonasFrm=$_POST["direccionPersonasFrm"];
	$barrioPersonasFrm=$_POST["barrioPersonasFrm"];
	$ciudadPersonasFrm=$_POST["ciudadPersonasFrm"];
	$ocupacionPersonasFrm=$_POST["ocupacionPersonasFrm"];
	$idPersonas=$_POST["idPersonas"];
	
	$variable=modificarPersonas($tipoIdentificacionPersonasFrm,$sexoPersonasFrm,$nombresPersonasFrm,$apellidosPersonasFrm,$identificacionPersonasFrm,$edadPersonasFrm,$telefonoPersonasFrm,$direccionPersonasFrm,$barrioPersonasFrm,$ciudadPersonasFrm,$ocupacionPersonasFrm,$idPersonas);
	echo json_encode($variable);
}

?>