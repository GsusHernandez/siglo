<?php
include('../bd/consultasFacturacion.php');

if ($_POST["exe"]=="GenerarFacturaVentaParticular")
{
	$idProcedimiento=$_POST["idProcedimiento"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=GenerarFacturaVentaParticular($idProcedimiento,$idUsuario);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="GenerarFacturaVentaTotalRelacion")
{
	$idCliente=$_POST["idCliente"];
	$fechaInicioFacturaRangoFecha=$_POST["fechaInicioFacturaRangoFecha"];
	$fechaFinFacturaRangoFecha=$_POST["fechaFinFacturaRangoFecha"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=GenerarFacturaVentaTotalRelacion($idCliente,$fechaInicioFacturaRangoFecha,$fechaFinFacturaRangoFecha,$idUsuario);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="GenerarFacturaVentaIndividualClientes")
{
	$idCliente=$_POST["idCliente"];
	$fechaInicioFacturaRangoFecha=$_POST["fechaInicioFacturaRangoFecha"];
	$fechaFinFacturaRangoFecha=$_POST["fechaFinFacturaRangoFecha"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=GenerarFacturaVentaIndividualClientes($idCliente,$fechaInicioFacturaRangoFecha,$fechaFinFacturaRangoFecha,$idUsuario);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultaViewFactura")
{
	$idFactura=$_POST["idFactura"];
	echo ("reports/reportFactura.php?idFact=".$idFactura);
}
else if ($_POST["exe"]=="eliminarRegistroFacturas")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarFactura($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="viewRangoFacturas")
{
	$tipoID=$_POST["tipoID"];
	$numeroInicialViewFacturas=$_POST["numeroInicialViewFacturas"];
	$numeroFinalViewFacturas=$_POST["numeroFinalViewFacturas"];
	$variable=vireRangoFacturas($tipoID,$numeroInicialViewFacturas,$numeroFinalViewFacturas);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultaGestionPagosFacturas")
{
	$idFactura=$_POST["idFactura"];
	$variable=consultaGestionPagosFacturas($idFactura);
	echo json_encode($variable);
}

?>