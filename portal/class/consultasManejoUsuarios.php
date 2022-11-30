<?php
include('../bd/consultasUsuarios.php');

if ($_POST["exe"]=="eliminarUsuario")
{
	$idRegistro=$_POST["idRegistro"];
	$variable=eliminarUsuario($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="vigenciaUsuario")
{
	$idRegistro=$_POST["idRegistro"];
	
	$variable=vigenciaUsuarios($idRegistro);
	echo $variable;
}
else if ($_POST["exe"]=="registrarUsuario")
{
	$nombresUsuarioFrm=$_POST["nombresUsuarioFrm"];
	$apellidoUsuarioFrm=$_POST["apellidoUsuarioFrm"];
	$userUsuarioFrm=$_POST["userUsuarioFrm"];
	$correoUsuarioFrm=$_POST["correoUsuarioFrm"];
	$contrasenaUsuarioFrm=$_POST["contrasenaUsuarioFrm"];
	$tipoUserUsuarioFrm=$_POST["tipoUserUsuarioFrm"];
	$aseguradoraUsuarioFrm=$_POST["aseguradoraUsuarioFrm"];
	$investigadorUsuarioFrm=$_POST["investigadorUsuarioFrm"];
	$usuario=$_POST["usuario"]; 
	
	$variable=registrarUsuario($nombresUsuarioFrm,$apellidoUsuarioFrm,$userUsuarioFrm,$correoUsuarioFrm,$contrasenaUsuarioFrm,$usuario,$tipoUserUsuarioFrm,$aseguradoraUsuarioFrm,$investigadorUsuarioFrm);
	echo $variable;
}
else if ($_POST["exe"]=="consultarUsuario")
{
	$registroUsuario=$_POST["registroUsuario"];
	$variable=consultarUsuario($registroUsuario);
	echo json_encode($variable);
}
else if ($_POST["exe"]=="modificarUsuario")
{
	$nombresUsuarioFrm=$_POST["nombresUsuarioFrm"];
	$apellidoUsuarioFrm=$_POST["apellidoUsuarioFrm"];
	$userUsuarioFrm=$_POST["userUsuarioFrm"];
	$correoUsuarioFrm=$_POST["correoUsuarioFrm"];
	$contrasenaUsuarioFrm=$_POST["contrasenaUsuarioFrm"];
	$registroUsuario=$_POST["registroUsuario"];
	$tipoUserUsuarioFrm=$_POST["tipoUserUsuarioFrm"];
	$aseguradoraUsuarioFrm=$_POST["aseguradoraUsuarioFrm"];
	$investigadorUsuarioFrm=$_POST["investigadorUsuarioFrm"];
	
	$variable=modificarUsuario($nombresUsuarioFrm,$apellidoUsuarioFrm,$userUsuarioFrm,$correoUsuarioFrm,$contrasenaUsuarioFrm,$registroUsuario,$tipoUserUsuarioFrm,$aseguradoraUsuarioFrm,$investigadorUsuarioFrm);
	echo $variable;
}
else if ($_POST["exe"]=="cambiarPaswordUsuario")
{
	
	$idUsuario=$_POST["idUsuario"];
	$actualContrasenaFrmCPass=$_POST["actualContrasenaFrmCPass"];
	$nuevaContrasenaFrmCPass=$_POST["nuevaContrasenaFrmCPass"];
	
	
	$variable=cambiarPaswordUsuario($actualContrasenaFrmCPass,$nuevaContrasenaFrmCPass,$idUsuario);
	echo $variable;
}
else if ($_POST["exe"]=="asignarOpcionesUsuarios")
{
	
	$idUsuarioOpcion=$_POST["idUsuarioOpcion"];
		$idUsuario=$_POST["idUsuario"];
	$opcionesAsignar=$_POST["opcionesAsignar"];
	
	
	$variable=asignarOpcionesUsuarios($idUsuarioOpcion,$idUsuario,$opcionesAsignar);
	echo $variable;
}
else if ($_POST["exe"]=="asignarOpcionesUsuarios")
{
	
	$idUsuarioOpcion=$_POST["idUsuarioOpcion"];
		$idUsuario=$_POST["idUsuario"];
	$opcionesAsignar=$_POST["opcionesAsignar"];
	
	
	$variable=asignarOpcionesUsuarios($idUsuarioOpcion,$idUsuario,$opcionesAsignar);
	echo $variable;
}
?>