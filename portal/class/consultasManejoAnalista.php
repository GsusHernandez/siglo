<?php
include('../bd/consultasAnalistas.php');

if ($_POST["exe"]=="asignarCasosCuentaAna"){
	$id_usuario = $_POST['xd'];
	$periodo = $_POST['periodoAsignarCuentaAna'];
	$numero = $_POST['numeroAsignarCuentaAna'];
	$casos=$_POST["valores"];
	
	$variable=asignarCasosCuentaAna($periodo, $numero, $casos, $id_usuario);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="crearCuentaAnalista")
{
	$id_usuario = $_POST['xd'];
	$periodo = $_POST['periodoAsignarCuentaAna'];
	$numero = $_POST['numeroAsignarCuentaAna'];
	$casos=$_POST["valores"];
	
	$variable=crearCuentaAna($periodo, $numero, $casos, $id_usuario);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="eliminarCasoCuentaAna")
{
	$id_investigacion = $_POST['xd'];
	$id_cuenta = $_POST['cuenta'];
	$origen = $_POST['origen'];
	
	$variable=eliminarCasoCuentaAna($id_investigacion, $id_cuenta, $origen);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="guardarCuentaCobroAna")
{
	$id_cuenta = $_POST['numVerCuentaAna'];
	$descuentoVerCasosAna = $_POST['descuentoVerCasosAna'];
	$adicionalVerCasosAna = $_POST['adicionalVerCasosAna'];
	$observacionVerCasosAna = $_POST['observacionVerCasosAna'];
	$subtotal = $_POST['subtotalVerCasosAna'];
	$total = $_POST['totalVerCasosAna'];
	$idCasos = json_decode($_POST['idCasos1']);
	$valorCasos = json_decode($_POST['valorCasos1']);
	$tarifaCasos = json_decode($_POST['tarifaCasos1']);
	$cantidad = count(json_decode($_POST['valorCasos1']));
	$id_usuario = $_POST['id_usuario'];
	$origenCasos = json_decode($_POST['origenCasos1']);
	
	$variable=guardarCuentaCobroAna($id_cuenta, $descuentoVerCasosAna, $adicionalVerCasosAna, $subtotal, $total, $cantidad, $idCasos, $valorCasos, $tarifaCasos, $observacionVerCasosAna, $id_usuario, $origenCasos);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="cerrarCuentaCobroAna")
{
	$id_cuenta = $_POST['numVerCuentaInv'];
	$descuentoVerCasosAna = $_POST['descuentoVerCasosAna'];
	$adicionalVerCasosAna = $_POST['adicionalVerCasosAna'];
	$observacionVerCasosAna = $_POST['observacionVerCasosAna'];
	$subtotal = $_POST['subtotalVerCasosAna'];
	$total = $_POST['totalVerCasosAna'];
	$idCasos = json_decode($_POST['idCasos1']);
	$valorCasos = json_decode($_POST['valorCasos1']);
	$tarifaCasos = json_decode($_POST['tarifaCasos1']);
	$cantidad = count(json_decode($_POST['valorCasos1']));
	$id_usuario = $_POST['id_usuario'];
	
	$variable=cerrarCuentaCobroAna($id_cuenta, $viaticosVerCasosAna, $adicionalVerCasosAna, $subtotal, $total, $cantidad, $idCasos, $valorCasos, $tarifaCasos, $observacionVerCasosAna, $id_usuario);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="habilitarCuentaCobroAna")
{
	$id_cuenta = $_POST['numVerCuentaAna'];
	
	$variable=habilitarCuentaCobroAna($id_cuenta);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="exportarCuentaCobroExcel")
{
	$id_cuenta = $_POST["id_cuenta"];
	$periodoTexto = $_POST["periodoTexto"];

	$json = exportarCuentaCobroExcel($id_cuenta, $periodoTexto);
	echo json_encode($json);
}
else if ($_POST["exe"]=="cerrarCuentasAnalista")
{
	$cuentas = $_POST["valores"];
	$id_usuario = $_POST["xd"];
	$json = cerrarCuentasAnalista($cuentas, $id_usuario);
	echo json_encode($json);
}
else if ($_POST["exe"] == "abrirCuentasAnalista")
{
	$cuentas = $_POST["valores"];
	$id = $_POST["xd"];

	$json = abrirCuentasAnalista($cuentas, $id);
	echo json_encode($json);
}
else if($_POST["exe"] == "crearCuentasAnalista"){
	$id_analista = $_POST["analistaCrearCuentaAna"];
	$periodo_ana = $_POST["periodoCrearCuentaAna"];
	$numero = $_POST["numeroCrearCuentaAna"];

	$sql = crearCuentaAnalista($id_analista, $periodo_ana, $numero);
	echo json_encode($sql);
}
?>