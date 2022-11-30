<?php
include('../bd/consultasEmpleadosNomina.php');


if ($_POST["exe"]=="registrarEmpleados"){
	$nombresEmpleadoFrm=$_POST["nombresEmpleadoFrm"];
	$apellidosEmpleadoFrm=$_POST["apellidosEmpleadoFrm"];
	$tipoIdentificacionEmpleadoFrm=$_POST["tipoIdentificacionEmpleadoFrm"];
	$identificacionEmpleadoFrm=$_POST["identificacionEmpleadoFrm"];
	$tipoEmpleadoFrm=$_POST["tipoEmpleadoFrm"];
	$telefonoEmpleadoFrm=$_POST["telefonoEmpleadoFrm"];
	$direccionEmpleadoFrm=$_POST["direccionEmpleadoFrm"];
	$correoEmpleadoFrm=$_POST["correoEmpleadoFrm"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=crearEmpleado($nombresEmpleadoFrm,$apellidosEmpleadoFrm,$tipoIdentificacionEmpleadoFrm,$identificacionEmpleadoFrm,$tipoEmpleadoFrm,$telefonoEmpleadoFrm,$direccionEmpleadoFrm,$correoEmpleadoFrm,$idUsuario);


	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarEmpleados"){
	$identificacionEmpleado=$_POST["identificacionEmpleado"];
	$idEmpleado=$_POST["idEmpleado"];
	$variable=consultarInformacionEmpleados($identificacionEmpleado,$idEmpleado);


	echo json_encode($variable);
}else if($_POST["exe"]=="modificarEmpleados"){
	$nombresEmpleadoFrm=$_POST["nombresEmpleadoFrm"];
	$apellidosEmpleadoFrm=$_POST["apellidosEmpleadoFrm"];
	$tipoIdentificacionEmpleadoFrm=$_POST["tipoIdentificacionEmpleadoFrm"];
	$identificacionEmpleadoFrm=$_POST["identificacionEmpleadoFrm"];
	$tipoEmpleadoFrm=$_POST["tipoEmpleadoFrm"];
	$telefonoEmpleadoFrm=$_POST["telefonoEmpleadoFrm"];
	$direccionEmpleadoFrm=$_POST["direccionEmpleadoFrm"];
	$correoEmpleadoFrm=$_POST["correoEmpleadoFrm"];
	$idRegistroEmpleado=$_POST["idRegistroEmpleado"];
	
	$variable=editarEmpleado($nombresEmpleadoFrm,$apellidosEmpleadoFrm,$tipoIdentificacionEmpleadoFrm,$identificacionEmpleadoFrm,$tipoEmpleadoFrm,$telefonoEmpleadoFrm,$direccionEmpleadoFrm,$correoEmpleadoFrm,$idRegistroEmpleado);
	echo json_encode($variable);
}else if($_POST["exe"]=="vigenciaEmpleadosNomina"){

	$idRegistroEmpleado=$_POST["idRegistro"];
	
$variable=vigenciaEmpleadosNomina($idRegistroEmpleado);
	echo json_encode($variable);

}else if($_POST["exe"]=="eliminarEmpleadosNomina"){

	$idRegistroEmpleado=$_POST["idRegistro"];
	
	$variable=eliminarEmpleadosNomina($idRegistroEmpleado);
	echo json_encode($variable);
}else if($_POST["exe"]=="consultarInformacionPagoEmpleado"){

	$idRegistroEmpleado=$_POST["idEmpleado"];
	
	$variable=consultarInformacionPagoEmpleado($idRegistroEmpleado);
	echo json_encode($variable);
}
?>