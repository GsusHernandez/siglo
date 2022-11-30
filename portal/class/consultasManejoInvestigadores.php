<?php
include('../bd/consultasInvestigadores.php');

if ($_POST["exe"]=="eliminarInvestigador")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarInvestigador($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="vigenciaInvestigador")
{
	$idRegistro=$_POST["idRegistro"];
	
	$variable=vigenciaInvestigador($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="registrarInvestigador")
{
	$nombresInvestigadoresFrm=$_POST["nombresInvestigadoresFrm"];
	$apellidoInvestigadoresFrm=$_POST["apellidoInvestigadoresFrm"];
	$tipoIdentificacionInvestigadoresFrm=$_POST["tipoIdentificacionInvestigadoresFrm"];
	$identificacionInvestigadoresFrm=$_POST["identificacionInvestigadoresFrm"];
	$lugarExpedicionInvestigadoresFrm=$_POST["lugarExpedicionInvestigadoresFrm"];
	$telefonoInvestigadoresFrm=$_POST["telefonoInvestigadoresFrm"];
	$correoInvestigadoresFrm=$_POST["correoInvestigadoresFrm"];
	$direccionInvestigadoresFrm=$_POST["direccionInvestigadoresFrm"];
	$estudiosInvestigadoresFrm=$_POST["estudiosInvestigadoresFrm"];
	$experienciaInvestigadoresFrm=$_POST["experienciaInvestigadoresFrm"];
	
	$usuario=$_POST["usuario"];
	if($_POST["imagen"] == "SI"){
		$imagenInvestigadoresFrm = $_FILES["imagenInvestigadoresFrm"];
	}else{
		$imagenInvestigadoresFrm = null;
	}

	$variable=registrarInvestigador($nombresInvestigadoresFrm,$apellidoInvestigadoresFrm,$tipoIdentificacionInvestigadoresFrm,$identificacionInvestigadoresFrm,$lugarExpedicionInvestigadoresFrm,$telefonoInvestigadoresFrm,$correoInvestigadoresFrm,$direccionInvestigadoresFrm,$estudiosInvestigadoresFrm,$experienciaInvestigadoresFrm,$imagenInvestigadoresFrm,$usuario);
	echo $variable;
}
else if ($_POST["exe"]=="consultarInvestigador")
{
	$registroInvestigador=$_POST["registroInvestigador"];
	
	
	$variable=consultarInvestigador($registroInvestigador);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="modificarInvestigador")
{
	$nombresInvestigadoresFrm=$_POST["nombresInvestigadoresFrm"];
	$apellidoInvestigadoresFrm=$_POST["apellidoInvestigadoresFrm"];
	$tipoIdentificacionInvestigadoresFrm=$_POST["tipoIdentificacionInvestigadoresFrm"];
	$identificacionInvestigadoresFrm=$_POST["identificacionInvestigadoresFrm"];
	$lugarExpedicionInvestigadoresFrm=$_POST["lugarExpedicionInvestigadoresFrm"];
	$telefonoInvestigadoresFrm=$_POST["telefonoInvestigadoresFrm"];
	$correoInvestigadoresFrm=$_POST["correoInvestigadoresFrm"];
	$direccionInvestigadoresFrm=$_POST["direccionInvestigadoresFrm"];
	$idRegistroInvestigador=$_POST["idRegistroInvestigador"];
	$estudiosInvestigadoresFrm=$_POST["estudiosInvestigadoresFrm"];
	$experienciaInvestigadoresFrm=$_POST["experienciaInvestigadoresFrm"];
	
	if($_POST["imagen"] == "SI"){
		$imagenInvestigadoresFrm = $_FILES["imagenInvestigadoresFrm"];
	}else{
		$imagenInvestigadoresFrm = null;
	}
	
	$variable=modificarInvestigador($nombresInvestigadoresFrm,$apellidoInvestigadoresFrm,$tipoIdentificacionInvestigadoresFrm,$identificacionInvestigadoresFrm,$lugarExpedicionInvestigadoresFrm,$telefonoInvestigadoresFrm,$correoInvestigadoresFrm,$direccionInvestigadoresFrm,$idRegistroInvestigador,$estudiosInvestigadoresFrm,$experienciaInvestigadoresFrm,$imagenInvestigadoresFrm);
	echo $variable;
}
else if ($_POST["exe"]=="asignarCasosCuentaInv")
{
	$id_usuario = $_POST['xd'];
	$id_investigador = $_POST['investigadorAsignarCuentaInv'];
	$periodo = $_POST['periodoAsignarCuentaInv'];
	$numero = $_POST['numeroAsignarCuentaInv'];
	$casos=$_POST["valores"];
	
	$variable=asignarCasosCuentaInv($id_investigador, $periodo, $numero, $casos, $id_usuario);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="crearCuentaInv")
{
	$id_usuario = $_POST['xd'];
	$id_investigador = $_POST['investigadorAsignarCuentaInv'];
	$periodo = $_POST['periodoAsignarCuentaInv'];
	$numero = $_POST['numeroAsignarCuentaInv'];
	$casos=$_POST["valores"];
	
	$variable=crearCuentaInv($id_investigador, $periodo, $numero, $casos, $id_usuario);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="eliminarCasoCuentaInv")
{
	$id_investigacion = $_POST['xd'];
	$id_cuenta = $_POST['cuenta'];
	
	$variable=eliminarCasoCuentaInv($id_investigacion, $id_cuenta);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="cerrarCuentaCobroInv")
{
	$id_cuenta = $_POST['numVerCuentaInv'];
	$viaticosVerCasosInv = $_POST['viaticosVerCasosInv'];
	$adicionalVerCasosInv = $_POST['adicionalVerCasosInv'];
	$observacionVerCasosInv = $_POST['observacionVerCasosInv'];
	$subtotal = $_POST['subtotalVerCasosInv'];
	$total = $_POST['totalVerCasosInv'];
	$idCasos = json_decode($_POST['idCasos1']);
	$valorCasos = json_decode($_POST['valorCasos1']);
	$tarifaCasos = json_decode($_POST['tarifaCasos1']);
	$cantidad = count(json_decode($_POST['valorCasos1']));
	$id_usuario = $_POST['id_usuario'];
	
	$variable=cerrarCuentaCobroInv($id_cuenta, $viaticosVerCasosInv, $adicionalVerCasosInv, $subtotal, $total, $cantidad, $idCasos, $valorCasos, $tarifaCasos, $observacionVerCasosInv, $id_usuario);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
else if ($_POST["exe"]=="habilitarCuentaCobroInv")
{
	$id_cuenta = $_POST['numVerCuentaInv'];
	
	$variable=habilitarCuentaCobroInv($id_cuenta);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($variable);
}
?>