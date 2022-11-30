<?php
include('../bd/consultasCasoValidaciones.php');
if ($_POST["exe"]=="registrarCasoValidaciones")
{
	$aseguradoraFrmCasosValidaciones=$_POST["aseguradoraFrmCasosValidaciones"];
	$ciudadEntidadFrmCasosValidaciones=$_POST["ciudadEntidadFrmCasosValidaciones"];
	$nombreEntidadFrmCasosValidaciones=$_POST["nombreEntidadFrmCasosValidaciones"];
	$identificacionEntidadFrmCasosValidaciones=$_POST["identificacionEntidadFrmCasosValidaciones"];
	$digVerEntidadFrmCasosValidaciones=$_POST["digVerEntidadFrmCasosValidaciones"];
	$fechaMatriculaFrmCasosValidaciones=$_POST["fechaMatriculaFrmCasosValidaciones"];
	$direccionEntidadFrmCasosValidaciones=$_POST["direccionEntidadFrmCasosValidaciones"];
	$telefonoEntidadFrmCasosValidaciones=$_POST["telefonoEntidadFrmCasosValidaciones"];
	$investigadorFrmCasosValidaciones=$_POST["investigadorFrmCasosValidaciones"];
	$actividadEconomicaFrmCasosValidaciones=$_POST["actividadEconomicaFrmCasosValidaciones"];
	$usuario=$_POST["usuario"];
	$identificadoresCaso=$_POST["identificadoresCaso"];
	
	$variable=registrarCasoValidaciones($aseguradoraFrmCasosValidaciones,$ciudadEntidadFrmCasosValidaciones,$nombreEntidadFrmCasosValidaciones,$identificacionEntidadFrmCasosValidaciones,$digVerEntidadFrmCasosValidaciones,$fechaMatriculaFrmCasosValidaciones,$direccionEntidadFrmCasosValidaciones,$telefonoEntidadFrmCasosValidaciones,$investigadorFrmCasosValidaciones,$actividadEconomicaFrmCasosValidaciones,$usuario,$identificadoresCaso);
	echo $variable;
}
else if ($_POST["exe"]=="consultarRepresentanteLegal")
{
	$idInvestigacion=$_POST["idInvestigacion"];
	
	$variable=consultarRepresentanteLegal($idInvestigacion);
	echo $variable;
}
else if ($_POST["exe"]=="consultarInformacionAsignarInvestigadorCuentaCobro")
{
	$idCaso=$_POST["idCaso"];
	
	$variable=consultarInformacionAsignarInvestigadorCuentaCobro($idCaso);
	echo $variable;
}
else if ($_POST["exe"]=="modificarRepresentanteLegal")
{
	$tipoIdentificacionRepresentanteLegalFrm=$_POST["tipoIdentificacionRepresentanteLegalFrm"];
	$identificacionRepresentanteLegalFrm=$_POST["identificacionRepresentanteLegalFrm"];
	$apellidosRepresentanteLegalFrm=$_POST["apellidosRepresentanteLegalFrm"];
	$nombresRepresentanteLegalFrm=$_POST["nombresRepresentanteLegalFrm"];
	$idInvestigacionFrmRepresentanteLegal=$_POST["idInvestigacionFrmRepresentanteLegal"];
	$correoRepresentanteLegalFrm=$_POST["correoRepresentanteLegalFrm"];
	
	$variable=modificarRepresentanteLegal($idInvestigacionFrmRepresentanteLegal,$nombresRepresentanteLegalFrm,$apellidosRepresentanteLegalFrm,$tipoIdentificacionRepresentanteLegalFrm,$identificacionRepresentanteLegalFrm,$correoRepresentanteLegalFrm);
	echo $variable;
}
else if ($_POST["exe"]=="eliminarCasoValidacion")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarCasoValidacion($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="consultarCasoValidaciones")
{
	$idCaso=$_POST["idCaso"];
	$variable=consultarCasoValidaciones($idCaso);
	echo $variable;
}
else if ($_POST["exe"]=="modificarCasoValidaciones")
{
	$aseguradoraFrmCasosValidaciones=$_POST["aseguradoraFrmCasosValidaciones"];
	$ciudadEntidadFrmCasosValidaciones=$_POST["ciudadEntidadFrmCasosValidaciones"];
	$nombreEntidadFrmCasosValidaciones=$_POST["nombreEntidadFrmCasosValidaciones"];
	$identificacionEntidadFrmCasosValidaciones=$_POST["identificacionEntidadFrmCasosValidaciones"];
	$digVerEntidadFrmCasosValidaciones=$_POST["digVerEntidadFrmCasosValidaciones"];
	$fechaMatriculaFrmCasosValidaciones=$_POST["fechaMatriculaFrmCasosValidaciones"];
	$direccionEntidadFrmCasosValidaciones=$_POST["direccionEntidadFrmCasosValidaciones"];
	$telefonoEntidadFrmCasosValidaciones=$_POST["telefonoEntidadFrmCasosValidaciones"];
	$investigadorFrmCasosValidaciones=$_POST["investigadorFrmCasosValidaciones"];
	$actividadEconomicaFrmCasosValidaciones=$_POST["actividadEconomicaFrmCasosValidaciones"];
	$idCasoFrmCasosValidaciones=$_POST["idCasoFrmCasosValidaciones"];
	$identificadoresCaso=$_POST["identificadoresCaso"];
	$usuario=$_POST["usuario"];
	
	$variable=modificarCasoValidaciones($aseguradoraFrmCasosValidaciones,$ciudadEntidadFrmCasosValidaciones,$nombreEntidadFrmCasosValidaciones,$identificacionEntidadFrmCasosValidaciones,$digVerEntidadFrmCasosValidaciones,$fechaMatriculaFrmCasosValidaciones,$direccionEntidadFrmCasosValidaciones,$telefonoEntidadFrmCasosValidaciones,$investigadorFrmCasosValidaciones,$actividadEconomicaFrmCasosValidaciones,$idCasoFrmCasosValidaciones,$identificadoresCaso,$usuario);
	echo $variable;
}
else if ($_POST["exe"]=="registrarAsignacionInvestigacion")
{
	$idAseguradoraFrmAsignarInvestigacion=$_POST["idAseguradoraFrmAsignarInvestigacion"];
	$idUsuario=$_POST["idUsuario"];
	$tipoCasoFrmAsignarInvestigacion=$_POST["tipoCasoFrmAsignarInvestigacion"];
	$motivoInvestigacionFrmAsignarInvestigacion=$_POST["motivoInvestigacionFrmAsignarInvestigacion"];	
	$fechaEntregaFrmAsignarInvestigacion=$_POST["fechaEntregaFrmAsignarInvestigacion"];
	$soporteFile=$_FILES["soporteFile"];
	$cartaPresentacionFile=$_FILES["cartaPresentacionFile"];
	$variable=registrarAsignacionInvestigacion($idAseguradoraFrmAsignarInvestigacion,$fechaEntregaFrmAsignarInvestigacion,$tipoCasoFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$cartaPresentacionFile,$idUsuario);
	
	echo ($variable);

}
else if ($_POST["exe"]=="modificarAsignacionInvestigacion")
{
		$idInvestigacion=$_POST["idInvestigacion"];

	$motivoInvestigacionFrmAsignarInvestigacion=$_POST["motivoInvestigacionFrmAsignarInvestigacion"];	
	$fechaEntregaFrmAsignarInvestigacion=$_POST["fechaEntregaFrmAsignarInvestigacion"];
	 
	$soporteFile=$_FILES["soporteFile"];
	$cartaPresentacionFile=$_FILES["cartaPresentacionFile"];
	$idUsuario=$_POST["idUsuario"];
	$variable=modificarAsignacionInvestigacion($idInvestigacion,$fechaEntregaFrmAsignarInvestigacion,$motivoInvestigacionFrmAsignarInvestigacion,$soporteFile,$cartaPresentacionFile,$idUsuario);
	
	echo ($variable);

}


?>