<?php
include('../bd/consultasPeriodosCuentaCobroInvestigadores.php');

if ($_POST["exe"]=="eliminarPeriodosCuentaCobroInvestigadores")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarPeriodosCuentaCobroInvestigadores($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="registrarPeriodosCuentaCobroInvestigadores"){
	$descripcion_periodo=$_POST["descripcion_periodo"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=registrarPeriodosCuentaCobroInvestigadores($descripcion_periodo,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="modificarPeriodosCuentaCobroInvestigadores"){
	$descripcion_periodo=$_POST["descripcion_periodo"];
	$id_periodo=$_POST["id_periodo"];
	
	$variable=modificarPeriodosCuentaCobroInvestigadores($descripcion_periodo,$id_periodo);
	echo $variable;
}
else if ($_POST["exe"]=="vigenciaPeriodosCuentaCobroInvestigadores")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=vigenciaPeriodosCuentaCobroInvestigadores($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="consultarPeriodoCCInvestigaciones")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=consultarPeriodoCCInvestigaciones($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="guardarValoresCasosCuentaCobro")
{
	$idUsuario=$_POST["idUsuario"];
	$idCuentaCobroInvestigador=$_POST["idCuentaCobroInvestigador"];
	$casosCuentaCobro=$_POST["casosCuentaCobro"];
	//$soporteCotizacionProveedor=$_FILES["soporteCotizacionProveedor"];
	$valorBiaticoFrmCuentaCobro=$_POST["valorBiaticoFrmCuentaCobro"];
	$valorAdicionalFrmCuentaCobro=$_POST["valorAdicionalFrmCuentaCobro"];
	$observacionesFrmCuentaCobro=$_POST["observacionesFrmCuentaCobro"];
	$variable=guardarValoresCasosCuentaCobro($casosCuentaCobro,$valorBiaticoFrmCuentaCobro,$valorAdicionalFrmCuentaCobro,$observacionesFrmCuentaCobro,$idCuentaCobroInvestigador,$idUsuario);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarInformacionCuentaCobro")
{
	$idCuentaCobro=$_POST["idCuentaCobro"];
	$variable=consultarInformacionCuentaCobro($idCuentaCobro);
	echo $variable;
}
else if ($_POST["exe"]=="vigenciaInvestigadoresCuentaCobroPeriodo")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=vigenciaInvestigadoresCuentaCobroPeriodo($idRegistro);
	echo $variable;
}


?>