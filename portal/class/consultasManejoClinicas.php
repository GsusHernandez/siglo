<?php 

include('../bd/consultasClinicas.php');



if ($_POST['exe']== "eliminarClinicas") {


	$idRegistro 		= $_POST['idRegistro'];
	//$usuario		= $_POST['usuario'];

	$variable = eliminarClinicas($idRegistro);

	echo $variable; 
}

else if ($_POST['exe']== "permitirClinicas") {


	$idRegistro 		= $_POST['idRegistro'];
	//$usuario		= $_POST['usuario'];

	$variable = permitirClinicas($idRegistro);

	echo $variable; 
}



else if ($_POST['exe']== "registrarClinicas") {

	$nombreClinica 		= $_POST['nombreClinica'];
	$nitClinica 		= $_POST['nitClinica'];
	$digVerNitClinica	= $_POST['digVerNitClinica'];
	$CiudadClinica 		= $_POST['CiudadClinica'];
	$telClinica 		= $_POST['telClinica'];
	$dirClinica 		= $_POST['dirClinica'];
	$usuario		    = $_POST['usuario'];




	$variable=registrarClinicas($nombreClinica, $nitClinica, $digVerNitClinica, $CiudadClinica, $telClinica, $dirClinica, $usuario);

	echo $variable; 
}


else if ($_POST['exe']== "editarClinicas") {

	
	$nombreClinica 		= $_POST['nombreClinica'];
	$nitClinica 		= $_POST['nitClinica'];
	$digVerNitClinica	= $_POST['digVerNitClinica'];
	$CiudadClinica 		= $_POST['CiudadClinica'];
	$telClinica 		= $_POST['telClinica'];
	$dirClinica 		= $_POST['dirClinica'];
	$idRegistroClinica	= $_POST['idRegistroClinica'];




	$variable=modificarClinicas($nombreClinica, $nitClinica, $digVerNitClinica, $CiudadClinica, $telClinica, $dirClinica, $idRegistroClinica);

	echo $variable; 
}

else if ($_POST['exe']== "consultarClinicas") {

	$idClinica			= $_POST['registroClinica'];
	



	$variable=consultarClinicas($idClinica);

	echo json_encode($variable); 
}



else if ($_POST['exe']== "asignarInvestigadorClinica") {

	$idRegistroClinica			= $_POST['idRegistroClinica'];
	$idInvestigador			= $_POST['idInvestigador'];
	$usuario=$_POST["usuario"];



	$variable=asignarInvestigadorClinica($idRegistroClinica,$idInvestigador,$usuario);

	echo ($variable); 
}

else if ($_POST['exe']== "eliminarAsignacionInvestigadorIps") {

	$idRegistro			= $_POST['idRegistro'];
	


	$variable=eliminarAsignacionInvestigadorIps($idRegistro);

	echo ($variable); 
}






 ?>