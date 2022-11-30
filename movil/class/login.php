<?php
include('../bd/login.php');

if ($_POST["exe"]=="loginMovil")
{
	$usuario=$_POST["usuario"];
	$password=$_POST["password"];
	$variable=login($usuario, $password);
	echo $variable;
}else if ($_POST["exe"]=="logout"){
	$usuario=$_POST["usuario"];
	$variable=logout($usuario);
	echo $variable;
}
?>