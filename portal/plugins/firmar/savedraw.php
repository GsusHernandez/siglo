<?php
//print_r($_POST);
$img = $_POST['base64'];
$id_firma = $_POST['id_firma'];
$terminos = $_POST['terminos'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = uniqid().'-'.$id_firma.'.png';

include('../../conexion/conexion.php');
global $con;

if(file_put_contents('firmas/'.$fileName, $fileData)){
	if(mysqli_query($con,"UPDATE entrevista_virtual SET firma = '$fileName', firmado = 's', fecha_firma = NOW(), consentimiento_firma = '$terminos' WHERE id = '$id_firma'")){
    $variable=1;
  }else{
    $variable=2;
  }
  echo $variable;
}

//header("Location: ./index.php");

?>