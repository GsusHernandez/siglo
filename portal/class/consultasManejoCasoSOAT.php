<?php
include('../bd/consultasCasoSOAT.php');

if ($_POST["exe"]=="registrarCasoSOAT"){

	$aseguradoraFrmCasosGM=$_POST["aseguradoraFrmCasosGM"];
	$tipoCasoFrmCasosGM=$_POST["tipoCasoFrmCasosGM"];
	$tipoAuditoriaFrmCasosGM=$_POST["tipoAuditoriaFrmCasosGM"];
	$fechaAccidenteFrmCasosGM=$_POST["fechaAccidenteFrmCasosGM"];
	$lugarAccidenteFrmCasosGM=$_POST["lugarAccidenteFrmCasosGM"];
	$ciudadFrmCasosGM=$_POST["ciudadFrmCasosGM"];
	$tipoZonaFrmCasosGM=$_POST["tipoZonaFrmCasosGM"];
	$investigadorFrmCasosGM=$_POST["investigadorFrmCasosGM"];
	$diasDeInvestigadorFrmCasosGM=$_POST["diasDeInvestigadorFrmCasosGM"];
	$idCasoFrmCasosGM=$_POST["idCasoFrmCasosGM"];
	$usuario=$_POST["usuario"];
	$identificadoresCaso=$_POST["identificadoresCaso"];
	$barrioAccidenteFrmCasosGM=$_POST["barrioAccidenteFrmCasosGM"];
	$fechaConocimientoFrmCasosGM=$_POST["fechaConocimientoFrmCasosGM"];
	
	$variable=registrarCasoSOAT($fechaConocimientoFrmCasosGM,$barrioAccidenteFrmCasosGM,$aseguradoraFrmCasosGM,$tipoCasoFrmCasosGM,$fechaAccidenteFrmCasosGM,$lugarAccidenteFrmCasosGM,$ciudadFrmCasosGM,$tipoZonaFrmCasosGM,$investigadorFrmCasosGM,$idCasoFrmCasosGM,$usuario,$identificadoresCaso,$tipoAuditoriaFrmCasosGM,$diasDeInvestigadorFrmCasosGM);
	echo $variable;
}
else if ($_POST["exe"]=="subirConsolidadoAsignarInvestigadoresMundialMok")
{
	$fechaEntrega=$_POST["fechaEntrega"];
	$idUsuario=$_POST["idUsuario"];
	$arcConsolidadoMultimedia=$_FILES["arcConsolidadoMultimedia"];
	$variable=subirConsolidadoAsignarInvestigadoresMundialMok($arcConsolidadoMultimedia,$idUsuario,$fechaEntrega);
	
	echo $variable;
}

else if ($_POST["exe"]=="subirAsignarCensosAnalistas"){
	$idAseguradora=$_POST["idAseguradora"];
	$fechaEntrega=$_POST["fechaEntrega"];
	$excelCensoAnalista=$_FILES["excelCensoAnalista"];
	$idUsuario=$_POST["idUsuario"];
	$variable=subirAsignarCensosAnalistas($idAseguradora, $fechaEntrega, $excelCensoAnalista, $idUsuario);
	
	echo $variable;
}
else if ($_POST["exe"]=="addCensoInvestigador"){

	$ci_investigador=$_POST["id_investigador"];
	$ci_aseguradora=$_POST["aseguradora"];
	$ci_tipo_caso=$_POST["tipo_caso"];
	$ci_fecha_accidente=$_POST["fecha_accidente"];
	$ci_fecha_conocimiento=$_POST["fecha_conocimiento"];
	$ci_placa=$_POST["placa"];
	$ci_poliza=$_POST["poliza"];
	$ci_ciudad=$_POST["ciudad"];
	$ci_lugar_accidente=$_POST["lugar_accidente"];
	$ci_ips=$_POST["ips"];
	$ci_id_servicio_ambulancia=$_POST["id_servicio_ambulancia"];
	
	if($ci_id_servicio_ambulancia == 's'){
		$ci_tipo_traslado=$_POST["tipo_traslado"];
		$ci_lugar_raslado=$_POST["lugar_raslado"];
	}else{
		$ci_tipo_traslado=NULL;
		$ci_lugar_raslado=NULL;
	}
	
	$ci_identLes=$_POST["ciIdentLes"];
	$ci_nombreLes=$_POST["ciNombreLes"];
	$ci_apellidoLes=$_POST["ciApellidoLes"];
	$ci_tipoLes = $_POST["ciTipoLes"];
	$ci_observaciones=$_POST["observaciones"];

	$variable=enviarCasoCenso($ci_investigador, $ci_aseguradora,$ci_tipo_caso,$ci_fecha_accidente,$ci_fecha_conocimiento,$ci_placa,$ci_poliza,$ci_ciudad,$ci_lugar_accidente,$ci_ips,$ci_id_servicio_ambulancia,$ci_tipo_traslado,$ci_lugar_raslado,$ci_identLes,$ci_nombreLes,$ci_apellidoLes,$ci_tipoLes,$ci_observaciones);
	echo $variable;
}
else if ($_POST["exe"]=="asignarInvestigadorCuentaCobro"){

	$idInvestigador=$_POST["idInvestigador"];
	$periodoAsignar=$_POST["periodoAsignar"];
	$tipoAuditoriaAsignar=$_POST["tipoAuditoriaAsignar"];
	$resultadoAsignar=$_POST["resultadoAsignar"];
	$tipoZonaAsignar=$_POST["tipoZonaAsignar"];
	$tipoCasoAsignar=$_POST["tipoCasoAsignar"];
	$idCaso=$_POST["idCaso"];
	$idUsuario=$_POST["idUsuario"];	
	$variable=asignarInvestigadorCuentaCobro($idInvestigador,$periodoAsignar,$tipoAuditoriaAsignar,$resultadoAsignar,$tipoZonaAsignar,$tipoCasoAsignar,$idCaso,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="eliminarIndicadorCaso")
{
	$idIndicador=$_POST["idRegistro"];
	$variable=eliminarIndicadorCaso($idIndicador);
	
	echo ($variable);
}
else if ($_POST["exe"]=="consultarInformacionAsignarInvestigadorCuentaCobro")
{
	$idCaso=$_POST["idCaso"];
	
	$variable=consultarInformacionAsignarInvestigadorCuentaCobro($idCaso);
	echo $variable;
}
else if ($_POST["exe"]=="subirArchivoInformeFinal2")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	$informeFinal2=$_FILES["informeFinal2"];
	$variable=subirArchivoInformeFinal2($informeFinal2,$idInvestigacion,$idUsuario);
	
	echo ($variable);
}
else if ($_POST["exe"]=="consultarCasoSOAT")
{
	$idCaso=$_POST["idCaso"];
	$variable=consultarCasoSOAT($idCaso);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="modificarCasoSOAT")
{
	$aseguradoraFrmCasosGM=$_POST["aseguradoraFrmCasosGM"];
	$tipoCasoFrmCasosGM=$_POST["tipoCasoFrmCasosGM"];
	$fechaAccidenteFrmCasosGM=$_POST["fechaAccidenteFrmCasosGM"];
	$lugarAccidenteFrmCasosGM=$_POST["lugarAccidenteFrmCasosGM"];
	$ciudadFrmCasosGM=$_POST["ciudadFrmCasosGM"];
	$tipoZonaFrmCasosGM=$_POST["tipoZonaFrmCasosGM"];
	$tipoAuditoriaFrmCasosGM=$_POST["tipoAuditoriaFrmCasosGM"];
	$investigadorFrmCasosGM=$_POST["investigadorFrmCasosGM"];
	$diasDeInvestigadorFrmCasosGM=$_POST["diasDeInvestigadorFrmCasosGM"];
	$idCasoFrmCasosGM=$_POST["idCasoFrmCasosGM"];
	$usuario=$_POST["usuario"];
	$identificadoresCaso=$_POST["identificadoresCaso"];
	$idCaso=$_POST["idCaso"];
	$barrioAccidenteFrmCasosGM=$_POST["barrioAccidenteFrmCasosGM"];
	$fechaConocimientoFrmCasosGM=$_POST["fechaConocimientoFrmCasosGM"];
	
	$variable=modificarCasoSOAT($fechaConocimientoFrmCasosGM,$barrioAccidenteFrmCasosGM,$aseguradoraFrmCasosGM,$tipoCasoFrmCasosGM,$fechaAccidenteFrmCasosGM,$lugarAccidenteFrmCasosGM,$ciudadFrmCasosGM,$tipoZonaFrmCasosGM,$investigadorFrmCasosGM,$idCasoFrmCasosGM,$usuario,$identificadoresCaso,$idCaso,$tipoAuditoriaFrmCasosGM,$diasDeInvestigadorFrmCasosGM);
	echo $variable;
}
else if ($_POST["exe"]=="eliminarCasoSOAT")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarCasoSOAT($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="asignarAnalistaCaso")
{
	$idCasoSoat=$_POST["idCasoSoat"];
	$idAnalista=$_POST["idAnalista"];
	$idUsuario=$_POST["idUsuario"];
	
	$variable=asignarAnalistaCaso($idAnalista,$idCasoSoat,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="modificarDetalleCasoSOAT")
{
	$aseguradoraFrmCasosGM=$_POST["aseguradoraFrmCasosGM"];
	$tipoCasoFrmCasosGM=$_POST["tipoCasoFrmCasosGM"];
	$fechaAccidenteFrmCasosGM=$_POST["fechaAccidenteFrmCasosGM"];
	$lugarAccidenteFrmCasosGM=$_POST["lugarAccidenteFrmCasosGM"];
	$ciudadFrmCasosGM=$_POST["ciudadFrmCasosGM"];
	$tipoZonaFrmCasosGM=$_POST["tipoZonaFrmCasosGM"];
	$investigadorFrmCasosGM=$_POST["investigadorFrmCasosGM"];
	$idCasoFrmCasosGM=$_POST["idCasoFrmCasosGM"];
	$usuario=$_POST["usuario"];
	$identificadoresCaso=$_POST["identificadoresCaso"];
	$idCaso=$_POST["idCaso"];
	
	$variable=modificarCasoSOAT($aseguradoraFrmCasosGM,$tipoCasoFrmCasosGM,$fechaAccidenteFrmCasosGM,$lugarAccidenteFrmCasosGM,$ciudadFrmCasosGM,$tipoZonaFrmCasosGM,$investigadorFrmCasosGM,$idCasoFrmCasosGM,$usuario,$identificadoresCaso,$idCaso);
	echo $variable;
}
else if ($_POST["exe"]=="consultarDetalleCasoSOAT")
{
	$idCaso=$_POST["idCaso"];
	$variable=consultarDetalleCasoSOAT($idCaso);
	
	echo $variable;
}
else if ($_POST["exe"]=="modificarDetalleInvestigacion")
{
	$visitaLugarHechosInformeFrm=$_POST["visitaLugarHechosInformeFrm"];
	$registroAutoridadesTecnicaInformeFrm=$_POST["registroAutoridadesTecnicaInformeFrm"];
	$inspeccionTecnicaInformeFrm=$_POST["inspeccionTecnicaInformeFrm"];
	$ConsultaRUNTInformeFrm=$_POST["ConsultaRUNTInformeFrm"];
	$causalNoConsultaRUNTInformeFrm=$_POST["causalNoConsultaRUNTInformeFrm"];
	$puntoReferenciaInformeFrm=$_POST["puntoReferenciaInformeFrm"];
	$furipsInformeFrm=$_POST["furipsInformeFrm"];
	$conclusionesInformeFrm=$_POST["conclusionesInformeFrm"];
	$idInvestigacionFrmInforme=$_POST["idInvestigacionFrmInforme"];
	$contactoTomadorInformeFrm=$_POST["contactoTomadorInformeFrm"];
	$observacionContactoTomadorInformeFrm=$_POST["observacionContactoTomadorInformeFrm"];
	$versionesHechosDiferenteInformeFrm=$_POST["versionesHechosDiferenteInformeFrm"];
	$cantidadOcupantesInformeFrm=$_POST["cantidadOcupantesInformeFrm"];
	$cantidadPersonasTrasladoInformeFrm=$_POST["cantidadPersonasTrasladoInformeFrm"];
	
	$idUsuario=$_POST["idUsuario"];
	$aConsideracion=$_POST["aConsideracion"];
	$motivoOcurrencia=$_POST["motivoOcurrencia"];
	
	$variable=modificarDetalleInvestigacion($contactoTomadorInformeFrm,$observacionContactoTomadorInformeFrm,$visitaLugarHechosInformeFrm,$registroAutoridadesTecnicaInformeFrm,$inspeccionTecnicaInformeFrm,$ConsultaRUNTInformeFrm,$causalNoConsultaRUNTInformeFrm,$puntoReferenciaInformeFrm,$furipsInformeFrm,$conclusionesInformeFrm,$idInvestigacionFrmInforme,$idUsuario,$aConsideracion,$versionesHechosDiferenteInformeFrm,$cantidadOcupantesInformeFrm,$cantidadPersonasTrasladoInformeFrm,$motivoOcurrencia);
	echo $variable;
}
else if ($_POST["exe"]=="subirArchivoMultimediaInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	if(isset($_FILES["archivoMultimedia1"])){
		$archivoMultimedia1=$_FILES["archivoMultimedia1"];
	}else{
		$archivoMultimedia2 = array();
	}
	if(isset($_FILES["archivoMultimedia2"])){
		$archivoMultimedia2=$_FILES["archivoMultimedia2"];
	}else{
		$archivoMultimedia2 = array();
	}
	$seccionMultimediaFrmMultimedia=$_POST["seccionMultimediaFrmMultimedia"];
	$variable=subirArchivoMultimediaInvestigacion($archivoMultimedia1,$archivoMultimedia2,$idInvestigacion,$seccionMultimediaFrmMultimedia,$idUsuario);
	
	echo json_encode($variable);

}
else if ($_POST["exe"]=="eliminarMultimediaInvestigacion")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarMultimediaInvestigacion($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="consultarInformeFinalInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarInformeFinalInvestigacion($idInvestigacion);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="subirArchivoInformeFinal")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	$informeFinal=$_FILES["informeFinal"];
	$variable=subirArchivoInformeFinal($informeFinal,$idInvestigacion,$idUsuario);
	
	echo ($variable);

}
else if ($_POST["exe"]=="deshabilitarInformeFinal")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	$variable=deshabilitarInformeFinal($idInvestigacion,$idUsuario);
	echo ($variable);

}
else if ($_POST["exe"]=="modificarDetalleInvestigacionMuerte")
{
	$fiscaliaCasoInformeMuerteFrm=$_POST["fiscaliaCasoInformeMuerteFrm"];
	$procesoFiscaliaInformeMuerteFrm=$_POST["procesoFiscaliaInformeMuerteFrm"];
	$noCroquisInformeMuerteFrm=$_POST["noCroquisInformeMuerteFrm"];
	$siniestroInformeMuerteFrm=$_POST["siniestroInformeMuerteFrm"];
	$hechosInformeMuerteFrm=$_POST["hechosInformeMuerteFrm"];
	$conclusionesInformeMuerteFrm=$_POST["conclusionesInformeMuerteFrm"];
	$idInvestigacionFrmInformeMuerte=$_POST["idInvestigacionFrmInformeMuerte"];
	$idUsuario=$_POST["idUsuario"];
	$variable=modificarDetalleInvestigacionMuerte($idInvestigacionFrmInformeMuerte,$fiscaliaCasoInformeMuerteFrm,$procesoFiscaliaInformeMuerteFrm,$noCroquisInformeMuerteFrm,$siniestroInformeMuerteFrm,$hechosInformeMuerteFrm,$conclusionesInformeMuerteFrm,$conclusionesInformeMuerteFrm,$idUsuario);
	echo ($variable);

}
else if ($_POST["exe"]=="registrarAsignacionInvestigacion")
{
	$idAseguradoraFrmAsignarInvestigacion=$_POST["idAseguradoraFrmAsignarInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	$tipoCasoFrmAsignarInvestigacion=$_POST["tipoCasoFrmAsignarInvestigacion"];
	$motivoInvestigacionFrmAsignarInvestigacion=$_POST["motivoInvestigacionFrmAsignarInvestigacion"];	
	$fechaEntregaFrmAsignarInvestigacion=$_POST["fechaEntregaFrmAsignarInvestigacion"];
	$soporteFile=$_FILES["soporteFile"];
	
	$variable=registrarAsignacionInvestigacion($idAseguradoraFrmAsignarInvestigacion,$fechaEntregaFrmAsignarInvestigacion,$tipoCasoFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$idUsuario);
	
	echo ($variable);

}
else if ($_POST["exe"]=="subirConsolidadoSIRASEstado")
{
	$fechaEntrega=$_POST["fechaEntrega"];
	$idUsuario=$_POST["idUsuario"];
	$arcConsolidadoMultimedia=$_FILES["arcConsolidadoMultimedia"];
	$variable=subirConsolidadoSIRASEstado($arcConsolidadoMultimedia,$idUsuario,$fechaEntrega);
	
	echo $variable;
}
else if ($_POST["exe"]=="subirConsolidadoAsignarInvestigadoresMundial")
{
	$fechaEntrega=$_POST["fechaEntrega"];
	$idUsuario=$_POST["idUsuario"];
	$arcConsolidadoMultimedia=$_FILES["arcConsolidadoMultimedia"];
	$variable=subirConsolidadoAsignarInvestigadoresMundial($arcConsolidadoMultimedia,$idUsuario,$fechaEntrega);
	
	echo $variable;
}
else if ($_POST["exe"]=="subirConsolidadoAsignarAnalistasMundial")
{
	$idUsuario=$_POST["idUsuario"];
	$arcConsolidadoMultimedia=$_FILES["arcConsolidadoMultimedia"];
	$variable=subirConsolidadoAsignarAnalistasMundial($arcConsolidadoMultimedia,$idUsuario);
	
	echo $variable;

}
else if ($_POST["exe"]=="autorizarCasoSOAT")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=autorizarCasoSOAT($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="registrarObservaciones")
{
	$seccionInformeFrmObservaciones=$_POST["seccionInformeFrmObservaciones"];
	$observacionesFrmObservaciones=$_POST["observacionesFrmObservaciones"];
	$usuario=$_POST["usuario"];
	$idInvestigacionFrmObservaciones=$_POST["idInvestigacionFrmObservaciones"];

	$variable=registrarObservacionesInformeInvestigaciones($idInvestigacionFrmObservaciones,$seccionInformeFrmObservaciones,$observacionesFrmObservaciones,$usuario);
	echo $variable;
}
else if ($_POST["exe"]=="modificarObservaciones")
{
	$seccionInformeFrmObservaciones=$_POST["seccionInformeFrmObservaciones"];
	$observacionesFrmObservaciones=$_POST["observacionesFrmObservaciones"];
	
	$idInvestigacionFrmObservaciones=$_POST["idInvestigacionFrmObservaciones"];
	$idObservacionInforme=$_POST["idObservacionInforme"];
	$variable=modificarObservacionesInformeInvestigaciones($idObservacionInforme,$idInvestigacionFrmObservaciones,$seccionInformeFrmObservaciones,$observacionesFrmObservaciones);
	echo $variable;
}
else if ($_POST["exe"]=="eliminarObservacionInformeInvestigacion")
{

	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarObservacionInformeInvestigacion($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="consultarObservaciones")
{

	$idObservacionInforme=$_POST["idObservacionInforme"];
	$variable=consultarObservacionesInformeInvestigaciones($idObservacionInforme);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="registrarTestigoInforme")
{
	$idPersona=$_POST["idPersona"];
	$usuario=$_POST["usuario"];
	$idInvestigacionTestigos=$_POST["idInvestigacionTestigos"];

	$variable=registrarTestigoInforme($idInvestigacionTestigos,$idPersona,$usuario);
	echo $variable;
}
else if ($_POST["exe"]=="eliminarTestigoInformeInvestigacion")
{

	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarTestigoInformeInvestigacion($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="seleccionarLesionadoDiligenciaFormato")
{

	$idLesionado=$_POST["idLesionado"];
	$idInvestigacion=$_POST["idInvestigacion"];
	$fechaDiligenciaFormatoFrm=$_POST["fechaDiligenciaFormatoFrm"];
	$variable=seleccionarLesionadoDiligenciaFormato($idLesionado,$idInvestigacion,$fechaDiligenciaFormatoFrm);
	echo $variable;
}
else if ($_POST["exe"]=="guardarPersonaDiligenciaFormato")
{

	$nombreAcompanante=$_POST["nombreAcompanante"];
	$tipoIdentificacionAcompanante=$_POST["tipoIdentificacionAcompanante"];
	$identificacionAcompanante=$_POST["identificacionAcompanante"];
	$telefonoAcompanante=$_POST["telefonoAcompanante"];
	$direccionAcompanante=$_POST["direccionAcompanante"];
	$relacionAcompanante=$_POST["relacionAcompanante"];
	$idUsuario=$_POST["idUsuario"];
	$idInvestigacion=$_POST["idInvestigacion"];
	$opcionDiligenciaFormato=$_POST["opcionDiligenciaFormato"];
	$fechaDiligenciaFormatoFrm=$_POST["fechaDiligenciaFormatoFrm"];
	$variable=guardarPersonaDiligenciaFormato($nombreAcompanante,$tipoIdentificacionAcompanante,$identificacionAcompanante,$telefonoAcompanante,$direccionAcompanante,$relacionAcompanante,$idUsuario,$idInvestigacion,$opcionDiligenciaFormato,$fechaDiligenciaFormatoFrm);
	echo $variable;
}
else if ($_POST["exe"]=="seleccionarInvestigadorDiligenciaFormato")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$opcionDiligenciaFormato=$_POST["opcionDiligenciaFormato"];
	$fechaDiligenciaFormatoFrm=$_POST["fechaDiligenciaFormatoFrm"];
	$variable=seleccionarInvestigadorDiligenciaFormato($idInvestigacion,$opcionDiligenciaFormato,$fechaDiligenciaFormatoFrm);
	echo $variable;
}
else if ($_POST["exe"]=="guardarObservacionesDiligenciaFormato")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$opcionDiligenciaFormato=$_POST["opcionDiligenciaFormato"];
	$observacionDiligenciaFormato=$_POST["observacionDiligenciaFormato"];
	$fechaDiligenciaFormatoFrm=$_POST["fechaDiligenciaFormatoFrm"];
	$variable=guardarObservacionesDiligenciaFormato($idInvestigacion,$opcionDiligenciaFormato,$observacionDiligenciaFormato,$fechaDiligenciaFormatoFrm);
	echo $variable;
}
else if ($_POST["exe"]=="consultarPersonaDiligenciaFormato")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarPersonaDiligenciaFormato($idInvestigacion);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarInformacionAsignacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarInformacionAsignacion($idInvestigacion);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="modificarAsignacionInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$motivoInvestigacionFrmAsignarInvestigacion=$_POST["motivoInvestigacionFrmAsignarInvestigacion"];	
	$fechaEntregaFrmAsignarInvestigacion=$_POST["fechaEntregaFrmAsignarInvestigacion"];
	$soporteFile=$_FILES["soporteFile"];
	$idUsuario=$_POST["idUsuario"];	
	$variable=modificarAsignacionInvestigacion($fechaEntregaFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$idInvestigacion,$idUsuario);
	echo ($variable);
}
else if ($_POST["exe"]=="guardarCambioEstado")
{
	
	
	$idInvestigacion=$_POST["idInvestigacion"];
	$observacionesCambioEstado=$_POST["observacionesCambioEstado"];
	$idUsuario=$_POST["idUsuario"];

	
	$variable=guardarCambioEstado($idInvestigacion,$observacionesCambioEstado,$idUsuario);
	
	echo ($variable);

}
else if ($_POST["exe"]=="terminarPlanillarCaso")
{
	$usuario=$_POST["usuario"];
	$idCaso=$_POST["idCaso"];
	

	$variable=terminarPlanillarCaso($usuario,$idCaso);
	
	echo ($variable);
}
else if ($_POST["exe"]=="actualizarCargueInvestigacionSOAT")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$idUsuario=$_POST["idUsuario"];

	$variable=actualizarCargueInvestigacionSOAT($idInvestigacion,$idUsuario);
	
	echo ($variable);
}
else if ($_POST["exe"]=="crearAmpliacionInvestigacionSOAT")
{
	$idUsuario=$_POST["idUsuario"];
	$identificadorFrmAmpliarInvestigacion=$_POST["identificadorFrmAmpliarInvestigacion"];
	$fechaInicioFrmAmpliarInvestigacion=$_POST["fechaInicioFrmAmpliarInvestigacion"];
		$fechaEntregaFrmAmpliarInvestigacion=$_POST["fechaEntregaFrmAmpliarInvestigacion"];
		$motivoInvestigacionFrmAmpliarInvestigacion=$_POST["motivoInvestigacionFrmAmpliarInvestigacion"];
$idCasoFrmAmpliarInvestigacion=$_POST["idCasoFrmAmpliarInvestigacion"];
$investigadorFrmAmpliarInvestigacion=$_POST["investigadorFrmAmpliarInvestigacion"];
	$variable=crearAmpliacionInvestigacionSOAT($investigadorFrmAmpliarInvestigacion,$identificadorFrmAmpliarInvestigacion,$fechaInicioFrmAmpliarInvestigacion,$fechaEntregaFrmAmpliarInvestigacion,$motivoInvestigacionFrmAmpliarInvestigacion,$idCasoFrmAmpliarInvestigacion,$idUsuario);
	
	echo ($variable);
}
else if ($_POST["exe"]=="autorizarFacturacionInvestigacion")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=autorizarFacturacionInvestigacion($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="autorizarFacturacionMultipleInvestigaciones")
{
	$idInvestigaciones=$_POST["idInvestigaciones"];
	$idUsuario=$_POST["idUsuario"];
	$variable=autorizarFacturacionMultipleInvestigaciones($idInvestigaciones,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="consultarDatosPersona") {
	$tipoIdentificacion=$_POST["tipoIdentificacion"];
	$identificacion=$_POST["identificacion"];
	$variable=consultarDatosPersona($tipoIdentificacion,$identificacion);
	echo $variable;
}
else if ($_POST["exe"]=="RegistrarProcesosJuridicos"){
	$selectaseguradorasProcesoJudicial = $_POST["selectaseguradorasProcesoJudicial"];
	$selecttipoCasoProcesoJudicial = $_POST["selecttipoCasoProcesoJudicial"];
	$pjPoliza = $_POST["pjPoliza"];
	$pjSiniestro = $_POST["pjSiniestro"];
	$fecha_accidente_procesos = $_POST["fecha_accidente_procesos"];
	$selectciudadProcesoJudicial = $_POST["selectciudadProcesoJudicial"];
	$pjPlaca = $_POST["pjPlaca"];
	$selectpjTipoId = $_POST["selectpjTipoId"];
	$pjId = $_POST["pjId"];
	$pjNombres = $_POST["pjNombres"];
	$pjApellidos = $_POST["pjApellidos"];
	$archivo = $_FILES["subirInformeProcesoJudicial"];
	$pjIdPersona = $_POST["pjIdPersona"];
	$pjArticulo = $_POST["pjArticulo"];
	$variable = RegistrarProcesosJuridicos($selectaseguradorasProcesoJudicial,$selecttipoCasoProcesoJudicial,$pjPoliza,$pjSiniestro,$fecha_accidente_procesos,$selectciudadProcesoJudicial,$pjPlaca,$selectpjTipoId,$pjId,$pjNombres,$pjApellidos,$archivo,$pjIdPersona, $pjArticulo);
	echo $variable;
}
else if ($_POST["exe"]=="BuscarProcesosJuridicos"){
	$codigo = $_POST["codigo"];
	$poliza = $_POST["poliza"];
	$siniestro = $_POST["siniestro"];
	$fecha_siniestro = $_POST["fecha_siniestro"];
	$identificacion = $_POST["identificacion"];
	$nombre = $_POST["nombre"];
	$apellidos = $_POST['apellidos'];
	$placa = $_POST["placa"];
	$articulo = $_POST["articulo"];
	$respuesta = BuscarProcesosJuridicos($codigo, $poliza, $siniestro, $fecha_siniestro, $identificacion, $nombre, $apellidos, $placa, $articulo);
	echo json_encode($respuesta);
}
else if ($_POST["exe"]=="consultarProcesoJuridico") {
	$idPj = $_POST['idPj'];
	$respuesta = consultarProcesoJuridico($idPj);
	echo $respuesta;
}
else if ($_POST["exe"]=="EditarProcesosJuridicos"){
	$idProcesoJuridico = $_POST["idProcesoJuridico"];
	$selectaseguradorasProcesoJudicial = $_POST["selectaseguradorasProcesoJudicial"];
	$selecttipoCasoProcesoJudicial = $_POST["selecttipoCasoProcesoJudicial"];
	$pjPoliza = $_POST["pjPoliza"];
	$pjSiniestro = $_POST["pjSiniestro"];
	$fecha_accidente_procesos = $_POST["fecha_accidente_procesos"];
	$selectciudadProcesoJudicial = $_POST["selectciudadProcesoJudicial"];
	$pjPlaca = $_POST["pjPlaca"];
	$selectpjTipoId = $_POST["selectpjTipoId"];
	$pjId = $_POST["pjId"];
	$pjNombres = $_POST["pjNombres"];
	$pjApellidos = $_POST["pjApellidos"];
	$pjIdPersona = $_POST["pjIdPersona"];
	$pjArticulo = $_POST["pjArticulo"];

	if($_POST['nuevoArchivo'] == "SI"){
		$archivo = $_FILES["subirInformeProcesoJudicial"];
	}else{
		$archivo = $_POST['nuevoArchivo'];
	}

	$nombreArchivoActual = $_POST['nombreArchivoActual'];
	
	$variable = EditarProcesosJuridicos($idProcesoJuridico,$selectaseguradorasProcesoJudicial,$selecttipoCasoProcesoJudicial,$pjPoliza,$pjSiniestro,$fecha_accidente_procesos,$selectciudadProcesoJudicial,$pjPlaca,$selectpjTipoId,$pjId,$pjNombres,$pjApellidos,$archivo,$pjIdPersona, $nombreArchivoActual, $pjArticulo);
	echo $variable;
}else if ($_POST["exe"]=="denunciarInvestigacion"){
	$id_investigacion = $_POST["id_investigacion"];
	$fechaDenuncia = $_POST["fechaDenuncia"];
	$observacion = $_POST["observacion"];
	$respuesta = denunciarInvestigacion($id_investigacion, $fechaDenuncia, $observacion);

	echo json_encode($respuesta);
}
else if ($_POST["exe"]=="GuardarEntrevistaVirtual"){

	$placa = $_POST["placa"];
	$poliza = $_POST["poliza"];
	$fecha_accidente = $_POST["fecha_accidente"];
	$codigo = $_POST["codigo"];
	$id_entrevistado = $_POST["id_entrevistado"];
	$nom_entrevistado = $_POST["nom_entrevistado"];
	$id_lesionado = $_POST["id_lesionado"];
	$nom_lesionado = $_POST["nom_lesionado"];
	$id_tomador = $_POST["id_tomador"];
	$nom_tomador = $_POST["nom_tomador"];

	$variable = GuardarEntrevistaVirtual($placa,$poliza,$fecha_accidente,$codigo,$id_entrevistado,$nom_entrevistado,$id_lesionado,$nom_lesionado,$id_tomador,$nom_tomador);
	echo $variable;
}
else if ($_POST["exe"]=="consultarFirmas"){
	$variable = consultarFirmas();
	echo $variable;
}
else if($_POST["exe"] == "noDenunciarInvest") {
	
	$id = $_POST["id"];
	$respuesta = noDenunciarInvest($id);
	echo ($respuesta);
}
?>