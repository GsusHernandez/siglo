<?php
include('../bd/consultasBasicas.php');
if ($_POST["exe"]=="verificarDescargaInforme")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$conResultado = $_POST["conResultado"];
	$aseguradora = $_POST["aseguradora"];
	
	$variable=verificarDescargaInforme($idInvestigacion, $conResultado, $aseguradora);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarInvestigadoresPeriodos")
{
	$parametro=$_POST["parametro"];	
	$variable=consultarInvestigadoresPeriodos($parametro);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarPeriodosCuentasInv")
{
	$parametro=$_POST["parametro"];
	$variable=consultarPeriodosCuentasInv($parametro);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarParametroAmparo")
{
	$idAmparo=$_POST["idAmparo"];
	$variable=consultarParametroAmparo($idAmparo);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarOpcion")
{
	$idOpcion=$_POST["idOpcion"];
	$variable=consultarOpcion($idOpcion);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarAmparosAseguradora")
{
	$idAseguradora=$_POST["idAseguradora"];
	$tipoCasos=$_POST["tipoCasos"];
	$variable=consultarAmparosAseguradora($idAseguradora,$tipoCasos);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarIndicadorFraude")
{
	$idCaso=$_POST["idCaso"];
	$idResultado=$_POST["idResultado"];
	$variable=consultarIndicadorFraude($idCaso,$idResultado);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarResultadosAseguradora")
{
	$idCaso=$_POST["idCaso"];
	$variable=consultarResultadosAseguradora($idCaso);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarFuncionReporte")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=consultarFuncionReporte($idRegistro);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarAutorizacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarAutorizacion($idInvestigacion);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="descargarInformesMasivo")
{
	$idAseguradora=$_POST["idAseguradora"];
	$fechaInicioDescargaInformes=$_POST["fechaInicioDescargaInformes"];
	$fechaFinDescargaInformes=$_POST["fechaFinDescargaInformes"];
	$tipoCasoDescargaInformes=$_POST["tipoCasoDescargaInformes"];
	$opcionesDescargaInformes=$_POST["opcionesDescargaInformes"];
	$variable=descargarInformesMasivo($idAseguradora,$fechaInicioDescargaInformes,$fechaFinDescargaInformes,$tipoCasoDescargaInformes,$opcionesDescargaInformes);

	echo $variable;
}
else if ($_POST["exe"]=="consultarLesionadosInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarLesionadosInvestiagcion($idInvestigacion);
	echo $variable;
}
else if ($_POST["exe"]=="consultarFotografiasSalud")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarFotografiasSalud($idInvestigacion);
	echo $variable;
}
else if ($_POST["exe"]=="consultarTipoPlanoCaso")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=consultarTipoPlanoCaso($idRegistro);
	echo $variable;
}
else if($_POST["exe"]=="consultarErroresEps"){
	$datos = consultarErroresEps();
	echo json_encode($datos);
}
else if($_POST["exe"]=="ActualizarEps"){
	$datos = ActualizarEps();
	echo json_encode($datos);
}
else if($_POST["exe"]=="ReportarCargueAchivoPlano"){
	$datos = ReportarCargueAchivoPlano();
	echo json_encode($datos);
}
else if($_POST["exe"]=="consultarReportesInvesticaciones"){
	$datos = consultarReportesInvesticaciones();
	echo json_encode($datos);
}
else if($_POST["exe"]=="ConsultarOcurrenciasInicio"){
	$datos = ConsultarOcurrenciasInicio($_POST["id_usuario"], $_POST["tipo_usuario"]);
	echo json_encode($datos);
}
else if($_POST["exe"]=="consultarMisCasosSinPDF"){
	$datos = consultarMisCasosSinPDF($_POST["id_usuario"]);
	echo json_encode($datos); 
}
else if($_POST["exe"]=="consultarMisCasosPendientes"){
	$datos = consultarMisCasosPendientes($_POST["id_usuario"]);
	echo json_encode($datos); 
}
else if($_POST["exe"]=="consultarTopMayoresIncidencias"){
	$tipo_usuario = $_POST["tipo_usuario"];
	$datos = consultarTopMayoresIncidencias($tipo_usuario);
	echo json_encode($datos);
}
else if ($_POST["exe"]== "ConsultarTipoCasoProcesoJuridico") {
	$aseguradora = $_POST["aseguradora"];
	$respuesta =  ConsultarTipoCasoProcesoJuridico($aseguradora);
    echo json_encode($respuesta);
}
else if ($_POST["exe"] == "consultarPersonaPJ"){
	$identificacion = $_POST["identificacion"];
	$selectpjTipoId = $_POST["selectpjTipoId"];
	$respuesta = consultarPersonaPJ($identificacion,$selectpjTipoId);
	echo json_encode($respuesta);
}
else if ($_POST["exe"]=="consultarPeriodosCuentasAna")
{
	$parametro=$_POST["parametro"];
	$variable=consultarPeriodosCuentasAna($parametro);
	echo ($variable);
}
else if ($_POST["exe"]=="ConsultarDatosMensuales"){
	$variable=ConsultarDatosMensuales();
	echo ($variable);
}
else if ($_POST['exe']=="consultarOcurrenciasAseguradoras"){
	$id_aseguradora=$_POST["id_aseguradora"];
	$variable=consultarOcurrenciasAseguradoras($id_aseguradora);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarPeriodosFacturas")
{
	$parametro=$_POST["parametro"];
	$variable=consultarPeriodosFacturas($parametro);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarNombreFacturas")
{
	$parametro=$_POST["parametro"];
	$parametro2=$_POST["parametro2"];
	$variable=consultarNombreFacturas($parametro, $parametro2);
	echo ($variable);
}
?>