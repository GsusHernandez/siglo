<?php
include('../bd/consultasAseguradoras.php');

if ($_POST["exe"]=="eliminarAseguradoras")
{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=eliminarAseguradoras($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="vigenciaAseguradora"){
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	$variable=vigenciaAseguradora($idRegistro,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="registrarAseguradora"){

	$nombreAseguradora 		= $_POST['nombreAseguradora'];
	$nitAseguradora 		= $_POST['nitAseguradora'];
	$digVerAseguradora 		= $_POST['digVerAseguradora'];
	$dirAseguradora 		= $_POST['dirAseguradora'];
	$telAseguradora 		= $_POST['telAseguradora'];
	$responsableAseguradora = $_POST['responsableAseguradora'];
	$cargoAseguradora 		= $_POST['cargoAseguradora'];
	$indicativoAseguradora 		= $_POST['indicativoAseguradora'];
	$usuarioCreaAseguradora = $_POST['usuario'];
	$atenderFrmAseg = $_POST['atenderFrmAseg'];
	$noAtenderFrmAseg = $_POST['noAtenderFrmAseg'];


	$variable = registrarAseguradora($nombreAseguradora, $nitAseguradora, $digVerAseguradora, $dirAseguradora, $telAseguradora, $responsableAseguradora, $cargoAseguradora, $indicativoAseguradora,$usuarioCreaAseguradora,$indicativoAseguradora,$atenderFrmAseg,$noAtenderFrmAseg);

	echo $variable;

	}
	else if ($_POST["exe"]=="modificarAseguradora"){

	$nombreAseguradora 		= $_POST['nombreAseguradora'];
	$nitAseguradora 		= $_POST['nitAseguradora'];
	$digVerAseguradora 		= $_POST['digVerAseguradora'];
	$dirAseguradora 		= $_POST['dirAseguradora'];
	$telAseguradora 		= $_POST['telAseguradora'];
	$responsableAseguradora = $_POST['responsableAseguradora'];
	$cargoAseguradora 		= $_POST['cargoAseguradora'];
	$indicativoAseguradora 		= $_POST['indicativoAseguradora'];
	$registroAseguradora = $_POST['registroAseguradora'];
	$atenderFrmAseg = $_POST['atenderFrmAseg'];
	$noAtenderFrmAseg = $_POST['noAtenderFrmAseg'];



	$variable = modificarAseguradora($nombreAseguradora, $nitAseguradora, $digVerAseguradora, $dirAseguradora, $telAseguradora, $responsableAseguradora, $cargoAseguradora, $registroAseguradora,$indicativoAseguradora,$atenderFrmAseg,$noAtenderFrmAseg);

	echo $variable;

	}
	else if ($_POST["exe"]=="consultarAseguradora")
	{
	$registroAseguradora = $_POST['registroAseguradora'];


	$variable = consultarInformacionAseguradora($registroAseguradora);

	echo json_encode($variable);

	}
	else if ($_POST["exe"]=="asignarClinicaAseguradora")
	{
	
	$idAseguradora=$_POST["idAseguradora"];
		$idUsuario=$_POST["idUsuario"];
	$clinicasAsignar=$_POST["clinicasAsignar"];
	
	
	$variable=asignarClinicaAseguradora($idAseguradora,$idUsuario,$clinicasAsignar);
	echo $variable;
	}
	else if ($_POST["exe"]== "asignarAmparosAseguradora")
	{
	$idAseguradora  = $_POST['idAseguradora'];
	$idAmparoMetodo = $_POST['idAmparoMetodo'];
	$idMetodoFact   = $_POST['idMetodoFact'];
	$idUsuario      = $_POST['usuario'];

	$variable = asignarAmparosAseguradora($idAseguradora, $idAmparoMetodo, $idMetodoFact, $idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "eliminarAmparoAseguradora")
	{
	$idRegistro=$_POST["idRegistro"];
	$idUsuario=$_POST["idUsuario"];
	

	$variable = eliminarAmparoAseguradora($idRegistro,$idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "asignarClinicaCiudadesAmpAseg")
	{
	$idAsegAmparo=$_POST["idAsegAmparo"];
	$idClinica=$_POST["idClinica"];
	$idCiudad=$_POST["idCiudad"];
	$usuario=$_POST["usuario"];
	
	

	$variable = asignarClinicaCiudadesAmpAseg($idAsegAmparo,$idClinica,$idCiudad,$usuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "eliminarClinicaCiudadTarifaAmparo")
	{
	$idRegistro=$_POST["idRegistro"];
	
	$idUsuario=$_POST["idUsuario"];

	$variable = eliminarClinicaCiudadTarifaAmparo($idRegistro,$idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "registrarTarifaValorCaso")
	{
	$idAmparoMetodoFact=$_POST["idAmparoMetodoFact"];
	$valorCasoUnico=$_POST["valorCasoUnico"];
	$idUsuario=$_POST["idUsuario"];

	$variable = registrarTarifaValorCaso($idAmparoMetodoFact,$valorCasoUnico,$idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "consultarTarifaValorCaso")
	{
	$idAmparoMetodoFact=$_POST["idAmparoMetodoFact"];


	$variable = consultarTarifaValorCaso($idAmparoMetodoFact);

	echo json_encode($variable);
	}
	else if ($_POST["exe"]== "consultarResultadosAseguradora")
	{
	$idAseguradora=$_POST["idAseguradora"];


	$variable = consultarResultadosAseguradora($idAseguradora);

	echo json_encode($variable);
	}
	else if ($_POST["exe"]== "asignarIndicadorNoAtenderAseg")
	{
	$idAseguradora=$_POST["idAseguradora"];
	$codigoNoAtender=$_POST["codigoNoAtender"];
	$idIndicador=$_POST["idIndicador"];
	$usuario=$_POST["usuario"];
	$variable = asignarIndicadorNoAtenderAseg($idAseguradora,$codigoNoAtender,$idIndicador,$usuario);

	echo ($variable);
	}
	else if ($_POST["exe"]== "asignarIndicadorAtenderAseg")
	{
	$idAseguradora=$_POST["idAseguradora"];
	$codigoAtender=$_POST["codigoAtender"];
	$idIndicador=$_POST["idIndicador"];
	$usuario=$_POST["usuario"];

	$variable = asignarIndicadorAtenderAseg($idAseguradora,$codigoAtender,$idIndicador,$usuario);

	echo ($variable);
	}
	else if ($_POST["exe"]== "eliminarIndicadorAseguradora")
	{

	$idRegistro=$_POST["idRegistro"];

	$variable = eliminarIndicadorAseguradora($idRegistro);

	echo ($variable);
	}
	else if ($_POST["exe"]== "consultarTarifaValorCasoResultado")
	{
	$idAmparoMetodoFact=$_POST["idAmparoMetodoFact"];


	$variable = consultarTarifaValorCasoResultado($idAmparoMetodoFact);

	echo json_encode($variable);
	}
	else if ($_POST["exe"]== "registrarTarifaValorCasoResultado")
	{
	$idAmparoMetodoFact=$_POST["idAmparoMetodoFact"];
	$valorCasoAtender=$_POST["valorCasoAtender"];
	$valorCasoNoAtender=$_POST["valorCasoNoAtender"];
	$idUsuario=$_POST["idUsuario"];

	$variable = registrarTarifaValorCasoResultado($idAmparoMetodoFact,$valorCasoAtender,$valorCasoNoAtender,$idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "consultarTarifaValorCasoZona")
	{
	$idAmparoMetodoFact=$_POST["idAmparoMetodoFact"];


	$variable = consultarTarifaValorCasoZona($idAmparoMetodoFact);

	echo json_encode($variable);
	}
	else if ($_POST["exe"]== "registrarTarifaValorCasoZona")
	{
	$idAmparoMetodoFact=$_POST["idAmparoMetodoFact"];
	$valorCasoUrbano=$_POST["valorCasoUrbano"];
	$valorCasoRural=$_POST["valorCasoRural"];
	$idUsuario=$_POST["idUsuario"];

	$variable = registrarTarifaValorCasoZona($idAmparoMetodoFact,$valorCasoUrbano,$valorCasoRural,$idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "agregarRangoValorTarifa")
	{
	$idRegistroCiudad=$_POST["idRegistroCiudadValorTarifa"];
	$idRegistroAsegAmparo=$_POST["idRegistroAsegAmparoValorTarifa"];
	$rangoDesde=$_POST["valorRangoDesde"];
	$rangoHasta=$_POST["valorRangoHasta"];
	$valorCaso=$_POST["valorCaso"];
	$idUsuario=$_POST["usuario"];

	$variable = agregarRangoValorTarifa($idRegistroCiudad,$idRegistroAsegAmparo,$rangoDesde,$rangoHasta,$valorCaso,$idUsuario);

	echo $variable;
	}
	else if ($_POST["exe"]== "eliminarRangoValorTarifa")
	{

	$idRegistro=$_POST["idRegistro"];

	$variable = eliminarRangoValorTarifa($idRegistro);

	echo ($variable);
	}
	
	
?>