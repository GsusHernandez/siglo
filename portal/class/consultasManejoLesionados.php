<?php
include('../bd/consultasLesionados.php');

if ($_POST["exe"]=="registrarLesionados"){
	$idLesionado=$_POST["idLesionado"];
	$fechaIngresoLesionadoFrm=$_POST["fechaIngresoLesionadoFrm"];
	$fechaEgresoLesionadoFrm=$_POST["fechaEgresoLesionadoFrm"];
	$ipsLesionadoFrm=$_POST["ipsLesionadoFrm"];
	$condicionLesionadoFrm=$_POST["condicionLesionadoFrm"];
	$resultadoLesionadoFrm=$_POST["resultadoLesionadoFrm"];
	$indicadorFraudeLesionadoFrm=$_POST["indicadorFraudeLesionadoFrm"];
	$servicioAmbulanciaLesionadoFrm=$_POST["servicioAmbulanciaLesionadoFrm"];
	$tipoServicioAmbulanciaLesionadoFrm=$_POST["tipoServicioAmbulanciaLesionadoFrm"];
	$lugarTrasladoAmbulanciaLesionadoFrm=$_POST["lugarTrasladoAmbulanciaLesionadoFrm"];
	$tipoVehiculoTrasladoLesionadoFrm=$_POST["tipoVehiculoTrasladoLesionadoFrm"];
	$seguridadSocialLesionadoFrm=$_POST["seguridadSocialLesionadoFrm"];
	$epsLesionadoFrm=$_POST["epsLesionadoFrm"];
	$regimenLesionadoFrm=$_POST["regimenLesionadoFrm"];
	$estadoSeguridadSocialLesionadoFrm=$_POST["estadoSeguridadSocialLesionadoFrm"];
	$causalNoConsultaSeguridadSocialLesionadoFrm=$_POST["causalNoConsultaSeguridadSocialLesionadoFrm"];
	$lesionesLesionadoFrm=$_POST["lesionesLesionadoFrm"];
	$tratamientoLesionadoFrm=$_POST["tratamientoLesionadoFrm"];
	$relatoLesionadoFrm=$_POST["relatoLesionadoFrm"];
	$observacionesLesionadoFrm=$_POST["observacionesLesionadoFrm"];
	$usuario=$_POST["usuario"];
	$idRegistroInvestigacionLesionadoSOAT=$_POST["idRegistroInvestigacionLesionadoSOAT"];
	$remitidoLesionadoFrm=$_POST["remitidoLesionadoFrm"];
	$ipsRemitidoLesionadoFrm=$_POST["ipsRemitidoLesionadoFrm"];
	
	
	$variable=registrarLesionados($idLesionado,$fechaIngresoLesionadoFrm,$fechaEgresoLesionadoFrm,$ipsLesionadoFrm,$condicionLesionadoFrm,$resultadoLesionadoFrm,$indicadorFraudeLesionadoFrm,$servicioAmbulanciaLesionadoFrm,$tipoServicioAmbulanciaLesionadoFrm,$lugarTrasladoAmbulanciaLesionadoFrm,$tipoVehiculoTrasladoLesionadoFrm,$seguridadSocialLesionadoFrm,$epsLesionadoFrm,$regimenLesionadoFrm,$estadoSeguridadSocialLesionadoFrm,$causalNoConsultaSeguridadSocialLesionadoFrm,$lesionesLesionadoFrm,$tratamientoLesionadoFrm,$relatoLesionadoFrm,$observacionesLesionadoFrm,$usuario,$idRegistroInvestigacionLesionadoSOAT,$remitidoLesionadoFrm,$ipsRemitidoLesionadoFrm);
	echo $variable;
}
else if ($_POST["exe"]=="consultarLesionado"){
	$idLesionado=$_POST["idLesionado"];
	
	$variable=consultarLesionado($idLesionado);


	echo json_encode($variable);
}
else if($_POST["exe"]=="modificarLesionado")
{
	$idLesionado=$_POST["idLesionado"];
	$fechaIngresoLesionadoFrm=$_POST["fechaIngresoLesionadoFrm"];
	$fechaEgresoLesionadoFrm=$_POST["fechaEgresoLesionadoFrm"];
	$ipsLesionadoFrm=$_POST["ipsLesionadoFrm"];
	$condicionLesionadoFrm=$_POST["condicionLesionadoFrm"];
	$resultadoLesionadoFrm=$_POST["resultadoLesionadoFrm"];
	$indicadorFraudeLesionadoFrm=$_POST["indicadorFraudeLesionadoFrm"];
	$servicioAmbulanciaLesionadoFrm=$_POST["servicioAmbulanciaLesionadoFrm"];
	$tipoServicioAmbulanciaLesionadoFrm=$_POST["tipoServicioAmbulanciaLesionadoFrm"];
	$lugarTrasladoAmbulanciaLesionadoFrm=$_POST["lugarTrasladoAmbulanciaLesionadoFrm"];
	$tipoVehiculoTrasladoLesionadoFrm=$_POST["tipoVehiculoTrasladoLesionadoFrm"];
	$seguridadSocialLesionadoFrm=$_POST["seguridadSocialLesionadoFrm"];
	$epsLesionadoFrm=$_POST["epsLesionadoFrm"];
	$regimenLesionadoFrm=$_POST["regimenLesionadoFrm"];
	$estadoSeguridadSocialLesionadoFrm=$_POST["estadoSeguridadSocialLesionadoFrm"];
	$causalNoConsultaSeguridadSocialLesionadoFrm=$_POST["causalNoConsultaSeguridadSocialLesionadoFrm"];
	$lesionesLesionadoFrm=$_POST["lesionesLesionadoFrm"];
	$tratamientoLesionadoFrm=$_POST["tratamientoLesionadoFrm"];
	$relatoLesionadoFrm=$_POST["relatoLesionadoFrm"];
	$observacionesLesionadoFrm=$_POST["observacionesLesionadoFrm"];
	$idPersonaLesionado=$_POST["idPersonaLesionado"];
	$idRegistroInvestigacionLesionadoSOAT=$_POST["idRegistroInvestigacionLesionadoSOAT"];
	$usuario=$_POST["usuario"];
	$remitidoLesionadoFrm=$_POST["remitidoLesionadoFrm"];
	$ipsRemitidoLesionadoFrm=$_POST["ipsRemitidoLesionadoFrm"];

	
	$variable=modificarLesionado($idRegistroInvestigacionLesionadoSOAT,$idLesionado,$fechaIngresoLesionadoFrm,$fechaEgresoLesionadoFrm,$ipsLesionadoFrm,$condicionLesionadoFrm,$resultadoLesionadoFrm,$indicadorFraudeLesionadoFrm,$servicioAmbulanciaLesionadoFrm,$tipoServicioAmbulanciaLesionadoFrm,$lugarTrasladoAmbulanciaLesionadoFrm,$tipoVehiculoTrasladoLesionadoFrm,$seguridadSocialLesionadoFrm,$epsLesionadoFrm,$regimenLesionadoFrm,$estadoSeguridadSocialLesionadoFrm,$causalNoConsultaSeguridadSocialLesionadoFrm,$lesionesLesionadoFrm,$tratamientoLesionadoFrm,$relatoLesionadoFrm,$observacionesLesionadoFrm,$idPersonaLesionado,$usuario,$remitidoLesionadoFrm,$ipsRemitidoLesionadoFrm);
	echo ($variable);
}
else if ($_POST["exe"]=="cambiarTipoPersona")
{
	$idPersona=$_POST["idPersona"];
	$variable=cambiarTipoPersona($idPersona);
	echo ($variable);

}
else if ($_POST["exe"]=="eliminarPersonaLesionadoSOAT")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarPersonaLesionadoSOAT($idRegistro,$idUsuario);
	echo ($variable);	
}
else if ($_POST["exe"]=="consultarObservacionLesionadoPrincipal")
{
	$idCaso=$_POST["idCaso"];
	$variable=consultarObservacionLesionadoPrincipal($idCaso);


	echo json_encode($variable);
}
else if ($_POST["exe"]=="consultarVictima")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarVictima($idInvestigacion);

	echo json_encode($variable);
}
else if ($_POST["exe"]=="registrarVictima"){
	$idVictima=$_POST["idVictima"];
	$fechaIngresoVictimaFrm=$_POST["fechaIngresoVictimaFrm"];
	$fechaEgresoVictimaFrm=$_POST["fechaEgresoVictimaFrm"];
	$condicionVictimaFrm=$_POST["condicionVictimaFrm"];
	$ipsVictimaFrm=$_POST["ipsVictimaFrm"];
	$resultadoVictimaFrm=$_POST["resultadoVictimaFrm"];
	$indicadorFraudeVictimaFrm=$_POST["indicadorFraudeVictimaFrm"];
	$observacionesVictima=$_POST["observacionesVictimaFrm"];
	$usuario=$_POST["usuario"];
	$idRegistroInvestigacionVictimaSOAT=$_POST["idRegistroInvestigacionVictimaSOAT"];

	$variable=registrarVictima($idVictima,$fechaIngresoVictimaFrm,$fechaEgresoVictimaFrm,$ipsVictimaFrm,$condicionVictimaFrm,$resultadoVictimaFrm,$indicadorFraudeVictimaFrm,$usuario,$idRegistroInvestigacionVictimaSOAT,$observacionesVictima);
	
	echo json_encode($variable);
}
else if ($_POST["exe"]=="modificarVictima")
{
	$idVictima=$_POST["idVictima"];
	$fechaIngresoVictimaFrm=$_POST["fechaIngresoVictimaFrm"];
	$fechaEgresoVictimaFrm=$_POST["fechaEgresoVictimaFrm"];
	$condicionVictimaFrm=$_POST["condicionVictimaFrm"];
	$ipsVictimaFrm=$_POST["ipsVictimaFrm"];
	$resultadoVictimaFrm=$_POST["resultadoVictimaFrm"];
	$indicadorFraudeVictimaFrm=$_POST["indicadorFraudeVictimaFrm"];
	$idRegistroInvestigacionVictimaSOAT=$_POST["idRegistroInvestigacionVictimaSOAT"];
	$observacionesVictimaFrm=$_POST["observacionesVictimaFrm"];
	$idPersonaVictima=$_POST["idPersonaVictima"];

	$variable=modificarVictima($idVictima,$fechaIngresoVictimaFrm,$fechaEgresoVictimaFrm,$ipsVictimaFrm,$condicionVictimaFrm,$resultadoVictimaFrm,$indicadorFraudeVictimaFrm,$idRegistroInvestigacionVictimaSOAT,$idPersonaVictima,$observacionesVictimaFrm);

	echo json_encode($variable);
}
else if ($_POST["exe"]=="seleccionarReclamante")
{
	$idReclamantePersona=$_POST["idReclamantePersona"];
	$idInvestigacion=$_POST["idInvestigacion"];
	$usuario=$_POST["usuario"];
	$variable=seleccionarReclamante($idReclamantePersona,$idInvestigacion,$usuario);
	echo $variable;
}
else if ($_POST["exe"]=="consultarReclamante")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarReclamante($idInvestigacion);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="registrarBeneficiario")
{
	$idBeneficiario=$_POST["idBeneficiario"];
	$parentescoBeneficiarioFrm=$_POST["parentescoBeneficiarioFrm"];
	$usuario=$_POST["usuario"];
	$idRegistroInvestigacionBeneficiarioSOAT=$_POST["idRegistroInvestigacionBeneficiarioSOAT"];
	
	$variable=registrarBeneficiario($idBeneficiario,$parentescoBeneficiarioFrm,$usuario,$idRegistroInvestigacionBeneficiarioSOAT);
	echo ($variable);
}
else if ($_POST["exe"]=="eliminarBeneficiariosCasoSOAT")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarBeneficiariosCasoSOAT($idRegistro,$idUsuario);
	echo ($variable);
}
else if ($_POST["exe"]=="consultarBeneficiario")
{
	$idBeneficiario=$_POST["idBeneficiario"];
	
	$variable=consultarBeneficiario($idBeneficiario);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="modificarBeneficiario")
{
	$idBeneficiario=$_POST["idBeneficiario"];
	$parentescoBeneficiarioFrm=$_POST["parentescoBeneficiarioFrm"];
	$idPersonaBeneficiario=$_POST["idPersonaBeneficiario"];
	$idRegistroInvestigacionBeneficiarioSOAT=$_POST["idRegistroInvestigacionBeneficiarioSOAT"];
	$usuario=$_POST["usuario"];
	$variable=modificarBeneficiario($idRegistroInvestigacionBeneficiarioSOAT,$idBeneficiario,$parentescoBeneficiarioFrm,$idPersonaBeneficiario,$usuario);
	echo ($variable);
}
?>