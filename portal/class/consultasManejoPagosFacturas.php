<?php
include('../bd/consultasPagosFacturas.php');

if ($_POST["exe"]=="eliminarPagosPacientes")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarPagosPacientes($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="registrarPagoFactura"){
	$valorPago=$_POST["valorPago"];
	$metodoPago=$_POST["metodoPago"];
	$idFactura=$_POST["idFactura"];
	$idUsuario=$_POST["idUsuario"];
	$variable=registrarPagoFactura($idFactura,$metodoPago,$valorPago,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="consultarPagosFacturas"){
	$idPagoFactura=$_POST["idPagoFactura"];
	$variable=consultarInformacionPagosFacturas($idPagoFactura);
	echo json_encode($variable);
}
else if($_POST["exe"]=="editarPagoFacturas"){
	$valorPago=$_POST["valorPago"];
	$metodoPago=$_POST["metodoPago"];
	$idPagoFactura=$_POST["idFactura"];
	$idUsuario=$_POST["idUsuario"];
	$variable=editarPagoFacturas($idPagoFactura,$metodoPago,$valorPago,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="consultarInfoEstadoPagosFacturas")
{
	$idFactura=$_POST["idFactura"];
	$variable=consultarInfoEstadoPagosFacturas($idFactura);
	echo json_encode($variable);
}
?>