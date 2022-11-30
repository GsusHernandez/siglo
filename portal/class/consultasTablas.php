<?php
include('../bd/consultaTablas.php');
if ($_POST["exeTabla"]=="consultarEstadosInvestigacion")
{

	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarEstadosInvestigacion($idInvestigacion);
	echo $variable;
}

else if ($_POST["exeTabla"]=="consultarTipoCasosAseguradoraCuentaCobro")
{

	$idCuentaCobro=$_POST["idCuentaCobro"];
	
	$variable=consultarTipoCasosAseguradoraCuentaCobro($idCuentaCobro);
	echo ($variable);

}
else if ($_POST["exeTabla"]=="consultarCuentaCobroInvestigadores")
{

	$idPeriodo=$_POST["idPeriodo"];
	
	$variable=consultarCuentaCobroInvestigadores($idPeriodo);
	echo $variable;

}


else if ($_POST["exeTabla"]=="consultarDuplicadoCasosAutorizadosFacturacion")
{

	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarDuplicadoCasosAutorizadosFacturacion($idInvestigacion);
	echo $variable;
	
}
else if ($_POST["exeTabla"]=="consultarCasosValidaciones")
{
	$codigoFrmBuscarValIPS=$_POST["codigoFrmBuscarValIPS"];
	$identificacionFrmBuscarValIPS=$_POST["identificacionFrmBuscarValIPS"];
	$razonSocialFrmBuscarValIPS=$_POST["razonSocialFrmBuscarValIPS"];
	$identificadorFrmBuscarValIPS=$_POST["identificadorFrmBuscarValIPS"];
	$usuario=$_POST["usuario"];
	$tipoConsultaBuscar=$_POST["tipoConsultaBuscar"];
	
	$variable=consultarCasosValidaciones($codigoFrmBuscarValIPS,$identificacionFrmBuscarValIPS,$razonSocialFrmBuscarValIPS,$identificadorFrmBuscarValIPS,$tipoConsultaBuscar,$usuario);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarCasosValidacionesHistorico")
{
	$codigoFrmBuscarValIPS=$_POST["codigoFrmBuscarValIPS"];
	$identificacionFrmBuscarValIPS=$_POST["identificacionFrmBuscarValIPS"];
	$razonSocialFrmBuscarValIPS=$_POST["razonSocialFrmBuscarValIPS"];
	$identificadorFrmBuscarValIPS=$_POST["identificadorFrmBuscarValIPS"];
	$usuario=$_POST["usuario"];
	$tipoConsultaBuscar=$_POST["tipoConsultaBuscar"];
	
	$variable=consultarCasosValidacionesHistorico($codigoFrmBuscarValIPS,$identificacionFrmBuscarValIPS,$razonSocialFrmBuscarValIPS,$identificadorFrmBuscarValIPS,$tipoConsultaBuscar,$usuario);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarUsuarios")
{
	$nombreUsuarioBuscar=$_POST["nombreUsuarioBuscar"];
	$userUsuarioBuscar=$_POST["userUsuarioBuscar"];
	$variable=consultaTablaUsuarios($userUsuarioBuscar,$nombreUsuarioBuscar);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarEventosUsuario")
{
	$idUsuario=$_POST["idUsuario"];
	
	$variable=consultarEventosUsuario($idUsuario);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarEmpleadosNomina")
{
	$nombreEmpleadoNomina=$_POST["nombreEmpleadoNomina"];
	$apellidoEmpleadoNomina=$_POST["apellidoEmpleadoNomina"];
	$identificacionEmpleadoNomina=$_POST["identificacionEmpleadoNomina"];
	$tipoEmpleadoNomina=$_POST["tipoEmpleadoNomina"];
	$variable=consultaTablaEmpleadosNomina($nombreEmpleadoNomina,$apellidoEmpleadoNomina,$identificacionEmpleadoNomina,$tipoEmpleadoNomina);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarAseguradoras")
{
	$nombreBuscarAseguradora=$_POST["nombreBuscarAseguradora"];
	$identificacionBuscarAseguradora=$_POST["identificacionBuscarAseguradora"];
	$variable=consultaTablaAseguradora($nombreBuscarAseguradora,$identificacionBuscarAseguradora);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarClinicas")
{
	$nombreBuscarClinica=$_POST["nombreBuscarClinica"];
	$identificacionBuscarClinica=$_POST["identificacionBuscarClinica"];
	$variable=consultaTablaClinica($nombreBuscarClinica,$identificacionBuscarClinica);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarOpcionesUsuarios")
{
	$userOpcionesUsuarios=$_POST["userOpcionesUsuarios"];
	
	$variable=consultarOpcionesUsuarios($userOpcionesUsuarios);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarClinicasAseguradoras")
{
	$idAsignacionClinica = $_POST["idAsignacionClinica"];
	
	$variable=consultarClinicasAseguradoras($idAsignacionClinica);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarAmparosAseguradoras")
{
	$idAsignacionAmparo = $_POST["idAsignacionAmparo"];
	
	$variable=consultarAmparosAseguradoras($idAsignacionAmparo);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarClinicaCiudadesAseguradoras")
{
	$idRegistroAseguradoraClinicaCiudad = $_POST["idAsegAmparo"];
	
	$variable=consultarClinicaCiudadesAseguradoras($idRegistroAseguradoraClinicaCiudad);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarRangoValorTarifaAmparo")
{
	$idAsegAmparo = $_POST["idAsegAmparo"];
	$idCiudad =$_POST["idCiudad"];
	
	$variable=consultarRangoValorTarifaAmparo($idAsegAmparo,$idCiudad);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarIndicadorAseguradoras")
{
	$idAsignacionIndicador = $_POST["idAsignacionIndicador"];
	
	
	$variable=consultarIndicadorAseguradoras($idAsignacionIndicador);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarResolucionesFacturacion")
{
	$variable=consultarResolucionesFacturacion();
	echo $variable;

}
else if ($_POST["exeTabla"]=="consultarPeriodosCuentaCobroInvestigadores")
{
	$variable=consultarPeriodosCuentaCobroInvestigadores();
	echo $variable;

}
else if ($_POST["exeTabla"]=="consultarInvestigadores")
{
	$nombreInvestigadorBuscar=$_POST["nombreInvestigadorBuscar"];
	$identificacionInvestigadorBuscar=$_POST["identificacionInvestigadorBuscar"];
	$variable=consultarInvestigadores($nombreInvestigadorBuscar,$identificacionInvestigadorBuscar);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarAsignacionInvestigadoresClinicas")
{
	$nombreInvestigadorBuscar=$_POST["nombreInvestigadorBuscar"];
	$idClinica=$_POST["idClinica"];
	$variable=consultarAsignacionInvestigadoresClinicas($idClinica);
	echo $variable;
}

else if ($_POST["exeTabla"]=="consultarIndicativoCasosSOAT")
{

	$idCaso=$_POST["idCaso"];
	
	$variable=consultarIndicativoCasosSOAT($idCaso);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarLesionadosCasoSOAT")
{
	$idCaso=$_POST["idCaso"];
	$variable=consultarLesionadosCasoSOAT($idCaso);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarPersonas")
{
	$identificacionPersona=$_POST["identificacionPersona"];
	$variable=consultarPersonas($identificacionPersona);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarPolizasVehiculos")
{
	$idVehiculo=$_POST["idVehiculo"];
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarPolizasVehiculos($idVehiculo,$idInvestigacion);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarVehiculos")
{
	$placaVehiculo=$_POST["placaVehiculo"];
	
	$variable=consultarVehiculos($placaVehiculo);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarMultimediaInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarMultimediaInvestigacion($idInvestigacion);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarBeneficiariosInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarBeneficiariosInvestigacion($idInvestigacion);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarCasosSOAT")
{
	$codigoFrmBuscarSOAT=$_POST["codigoFrmBuscarSOAT"];
	$nombresFrmBuscarSOAT=$_POST["nombresFrmBuscarSOAT"];
	$apellidosFrmBuscarSOAT=$_POST["apellidosFrmBuscarSOAT"];
	$identificacionFrmBuscarSOAT=$_POST["identificacionFrmBuscarSOAT"];
	$placaFrmBuscarSOAT=$_POST["placaFrmBuscarSOAT"];
	$polizaFrmBuscarSOAT=$_POST["polizaFrmBuscarSOAT"];
	$identificadorFrmBuscarSOAT=$_POST["identificadorFrmBuscarSOAT"];
	$usuario=$_POST["usuario"];
	$tipoConsultaBuscar=$_POST["tipoConsultaBuscar"];
	$fechaAccidenteFrmBuscarSOAT=$_POST["fechaAccidenteFrmBuscarSOAT"];
	if(isset($_POST["fechaDigitacionFrmBuscarSOAT"])) { 
		$fechaDigitacionFrmBuscarSOAT=$_POST["fechaDigitacionFrmBuscarSOAT"]; 
	} else { $fechaDigitacionFrmBuscarSOAT = ''; }
	if(isset($_POST["aseguradoraFrmBuscarSOAT"])) { 
		$aseguradoraFrmBuscarSOAT=$_POST["aseguradoraFrmBuscarSOAT"]; 
	} else { $aseguradoraFrmBuscarSOAT = ''; }

	
	$variable=consultarCasosSOAT($codigoFrmBuscarSOAT,$nombresFrmBuscarSOAT,$apellidosFrmBuscarSOAT,$identificacionFrmBuscarSOAT,$placaFrmBuscarSOAT,$polizaFrmBuscarSOAT,$identificadorFrmBuscarSOAT,$tipoConsultaBuscar,$fechaAccidenteFrmBuscarSOAT,$fechaDigitacionFrmBuscarSOAT,$aseguradoraFrmBuscarSOAT,$usuario);
	echo $variable;
}
else if ($_POST["exeTabla"]=="reportCargueInformes")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$aseguradoraReporteBasico=$_POST["aseguradoraReporteBasico"];
	$variable=reporteCargueInformes($fechaInicioReporteBasico,$fechaFinReporteBasico,$aseguradoraReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="reportRegistroDiarioSOAT")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$aseguradoraReporteBasico=$_POST["aseguradoraReporteBasico"];
	$tipoCasoReporteBasico=$_POST["tipoCasoReporteBasico"];
	$usuarioReporteBasico=$_POST["usuarioReporteBasico"];
	$variable=reporteRegistroDiarioSOAT($fechaInicioReporteBasico,$fechaFinReporteBasico,$aseguradoraReporteBasico,$tipoCasoReporteBasico,$usuarioReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="reportRegistroDiarioValidacionesIPS")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$aseguradoraReporteBasico=$_POST["aseguradoraReporteBasico"];
	$tipoCasoReporteBasico=$_POST["tipoCasoReporteBasico"];
	$variable=reportRegistroDiarioValidacionesIPS($fechaInicioReporteBasico,$fechaFinReporteBasico,$aseguradoraReporteBasico,$tipoCasoReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosMundial")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosMundialAmpliacion")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosMundialAmpliacion($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosAsignadosMundial")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosAsignadosMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosEstado")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosEstado($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoSIRASEstado")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoSIRASEstado($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosEquidad")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];

	$variable=archivoPlanoCensosEquidad($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosSolidaria")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosAsignadoSolidaria")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosAsignadoSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}

else if ($_POST["exeTabla"]=="archivoPlanoGastosMedicosMundial")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoGastosMedicosMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoGastosMedicosMundialAmpliacion")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoGastosMedicosMundialAmpliacion($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoMuerteMundial")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoMuerteMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoMuerteMundialAmpliacion")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoMuerteMundialAmpliacion($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoIncapacidadPermanenteMundial")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoIncapacidadPermanenteMundial($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarObservacionesInformeInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarObservacionesInformeInvestigacion($idInvestigacion);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarTestigosInformeInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarTestigosInformeInvestigacion($idInvestigacion);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarLesionadosDiligenciaInformeInvestigacion")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	$variable=consultarLesionadosDiligenciaInformeInvestigacion($idInvestigacion);
	echo $variable;
}
else if ($_POST["exeTabla"]=="reportCasosDiariosAnalista")
{
	$fechaInicioCasosDiarioAnalista=$_POST["fechaInicioCasosDiarioAnalista"];
	$fechaFinCasosDiarioAnalista=$_POST["fechaFinCasosDiarioAnalista"];
	$idAnalistaCasosDiarioAnalista=$_POST["idAnalistaCasosDiarioAnalista"];
	$variable=reportCasosDiariosAnalista($fechaInicioCasosDiarioAnalista,$fechaFinCasosDiarioAnalista,$idAnalistaCasosDiarioAnalista);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarCasosSOATHistorico")
{
	$codigoFrmBuscarSOAT=$_POST["codigoFrmBuscarSOAT"];
	$nombresFrmBuscarSOAT=$_POST["nombresFrmBuscarSOAT"];
	$apellidosFrmBuscarSOAT=$_POST["apellidosFrmBuscarSOAT"];
	$identificacionFrmBuscarSOAT=$_POST["identificacionFrmBuscarSOAT"];
	$placaFrmBuscarSOAT=$_POST["placaFrmBuscarSOAT"];
	$polizaFrmBuscarSOAT=$_POST["polizaFrmBuscarSOAT"];
	$identificadorFrmBuscarSOAT=$_POST["identificadorFrmBuscarSOAT"];
	$usuario=$_POST["usuario"];
	$tipoConsultaBuscar=$_POST["tipoConsultaBuscar"];

	
	$variable=consultarCasosSOATHistorico($codigoFrmBuscarSOAT,$nombresFrmBuscarSOAT,$apellidosFrmBuscarSOAT,$identificacionFrmBuscarSOAT,$placaFrmBuscarSOAT,$polizaFrmBuscarSOAT,$identificadorFrmBuscarSOAT,$tipoConsultaBuscar,$usuario);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultarInvestigacionesFacturacion")
{
	$variable=consultarInvestigacionesFacturacion();
	echo $variable;	
}
else if ($_POST["exeTabla"]=="reportInvestigacionesAutorizadasFacturacion")
{
	$fechaFinInvestigacionesAutorizadasFacturacion=$_POST["fechaFinInvestigacionesAutorizadasFacturacion"];
	$fechaInicioInvestigacionesAutorizadasFacturacion=$_POST["fechaInicioInvestigacionesAutorizadasFacturacion"];
	$aseguradoraInvestigacionesAutorizadasFacturacion=$_POST["aseguradoraInvestigacionesAutorizadasFacturacion"];
	$tipoRporteInvestigacionesAutorizadasFacturacion=$_POST["tipoRporteInvestigacionesAutorizadasFacturacion"];
	$variable=reportInvestigacionesAutorizadasFacturacion($fechaInicioInvestigacionesAutorizadasFacturacion,$fechaFinInvestigacionesAutorizadasFacturacion,$aseguradoraInvestigacionesAutorizadasFacturacion,$tipoRporteInvestigacionesAutorizadasFacturacion);
	echo $variable;	
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosSolidaria2")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosSolidaria2($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoCensosAsignadoSolidaria2")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoCensosAsignadoSolidaria2($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoGastosMedicosSolidaria")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoGastosMedicosSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoMuerteSolidaria")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoMuerteSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="archivoPlanoIncapacidadesSolidaria")
{
	$fechaFinReporteBasico=$_POST["fechaFinReporteBasico"];
	$fechaInicioReporteBasico=$_POST["fechaInicioReporteBasico"];
	$tipoGenerarArchivoPlano=$_POST["tipoGenerarArchivoPlano"];
	$variable=archivoPlanoIncapacidadesSolidaria($tipoGenerarArchivoPlano,$fechaInicioReporteBasico,$fechaFinReporteBasico);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultaReportePendienteAnalistas"){
	
	$aseguradoraCensoAnalista=$_POST["aseguradoraCensoAnalista"];
	$tipoCasoCensoAnalista=$_POST["tipoCasoCensoAnalista"];
	$analistaCensoAnalista=$_POST["analistaCensoAnalista"];
	$fCargueCensoAnalista=$_POST["fCargueCensoAnalista"];
	$variable=consultaReportePendienteAnalistas($aseguradoraCensoAnalista,$tipoCasoCensoAnalista,$analistaCensoAnalista,$fCargueCensoAnalista);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultaCasosCuentaCobroInv"){
	
	$investigadorCuentaInv=$_POST["investigadorCuentaInv"];
	$aseguradoraCuentaInv=$_POST["aseguradoraCuentaInv"];
	$tipoCasoCuentaInv=$_POST["tipoCasoCuentaInv"];
	$fLimiteCuentaInv=$_POST["fLimiteCuentaInv"];
	$variable=consultaCasosCuentaCobroInv($investigadorCuentaInv,$aseguradoraCuentaInv,$tipoCasoCuentaInv,$fLimiteCuentaInv);
	echo $variable;
}
else if ($_POST["exeTabla"]=="verCasosCuentaCobroInv"){
	
	$investigadorVerCuentaInv=$_POST["investigadorVerCuentaInv"];
	$periodoVerCuentaInv=$_POST["periodoVerCuentaInv"];
	
	if(isset($_POST["numeroVerCuentaInv"])){
		$idVerCuentaInv=$_POST["numeroVerCuentaInv"];
	}else{
		$idVerCuentaInv='';
	}

	if($periodoVerCuentaInv != ''){
		$periodoTemp = explode("/", $periodoVerCuentaInv);

		$periodoVerCuentaInv = $periodoTemp[0];
		$numeroVerCuentaInv = $periodoTemp[1];
	}else{
		$numeroVerCuentaInv = '';
	}

	$variable=verCasosCuentaCobroInv($investigadorVerCuentaInv,$periodoVerCuentaInv, $numeroVerCuentaInv, $idVerCuentaInv);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultaCasosCuentaCobroAnalista"){
	
	$analistaCuentaAna=$_POST["analistaCuentaAna"];
	$aseguradoraCuentaAna=$_POST["aseguradoraCuentaAna"];
	$tipoCasoCuentaAna=$_POST["tipoCasoCuentaAna"];
	$codigoCuentaAna=$_POST["codigoCuentaAna"];
	$fLimiteCuentaAna=$_POST["fLimiteCuentaAna"];
	$variable=consultaCasosCuentaCobroAnalista($analistaCuentaAna,$aseguradoraCuentaAna,$tipoCasoCuentaAna,$codigoCuentaAna,$fLimiteCuentaAna);
	echo $variable;
}
else if ($_POST["exeTabla"]=="verCasosCuentaCobroAna"){
	
	$analistaVerCuentaAna=$_POST["analistaVerCuentaAna"];
	$periodoVerCuentaAna=$_POST["periodoVerCuentaAna"];

	$periodoTemp = explode("/", $periodoVerCuentaAna);

	$periodoVerCuentaAna = $periodoTemp[0];
	$numeroVerCuentaInv = $periodoTemp[1];

	$variable=verCasosCuentaCobroAna($analistaVerCuentaAna,$periodoVerCuentaAna, $numeroVerCuentaInv);
	echo $variable;
}
else if ($_POST["exeTabla"]=="verGrupoCuentaCobroAnalista"){
	
	$periodoCuentaAna=$_POST["periodoVerGrupoCuentasAna"];
	$numPerCuentaAna = '';

	if($periodoCuentaAna != ''){
		$periodoTemp = explode("/", $periodoCuentaAna);

		$periodoCuentaAna = $periodoTemp[0];
		$numPerCuentaAna = $periodoTemp[1];
	}

	$analistaCuentaAna=$_POST["analistaVerGrupoCuentaAna"];
	$estadoCuentaAna=$_POST["estadoVerGrupoCuentaAna"];
	$numeroCuentaAna=$_POST["numeroVerGrupoCuentaAna"];
	$variable=verGrupoCuentaCobroAnalista($periodoCuentaAna, $numPerCuentaAna, $analistaCuentaAna, $estadoCuentaAna, $numeroCuentaAna);
	echo $variable;
}
else if ($_POST["exeTabla"]=="buscarDenuncias"){
	
	$aseguradoraDenuncias=$_POST["aseguradoraDenuncias"];
	$tipoCasoDenuncias=$_POST["tipoCasoDenuncias"];
	$fLimiteDenuncias=$_POST["fLimiteDenuncias"];
	$variable=buscarDenuncias($aseguradoraDenuncias, $tipoCasoDenuncias, $fLimiteDenuncias);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultaDenuncias"){
	
	$aseguradoraDenuncias=$_POST["aseguradoraRepDenuncias"];
	$dptoDenuncias=$_POST["dptoDenuncias"];
	$ipsDenuncias=$_POST["ipsDenuncias"];
	$indicadorDenuncias=$_POST["indicadorDenuncias"];
	$fechaInicioDenuncias=$_POST["fechaInicioDenuncias"];
	$fechaFinDenuncias=$_POST["fechaFinDenuncias"];
	$agruparDenuncias=$_POST["agruparDenuncias"];
	$variable=consultaDenuncias($aseguradoraDenuncias, $dptoDenuncias, $ipsDenuncias, $indicadorDenuncias, $fechaInicioDenuncias, $fechaFinDenuncias, $agruparDenuncias);
	echo $variable;
}
else if ($_POST["exeTabla"]=="consultaCasosAFacturar"){
	
	$idAseguradora=$_POST["aseguradoraFacturar"];
	$tipoCaso=$_POST["tipoCasoFacturar"];
	$fechaLimite=$_POST["fLimiteFacturar"];
	$codigo=$_POST["codigoFacturar"];
	$variable=consultaCasosAFacturar($codigo, $idAseguradora, $tipoCaso, $fechaLimite);
	echo $variable;
}
else if ($_POST['exeTabla']=="verFactura"){
	$id_factura=$_POST["facturaVerFactura"];
	$variable=verFactura($id_factura);
	echo ($variable);
}
?>
