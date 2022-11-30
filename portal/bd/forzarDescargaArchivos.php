<?php
include('../conexion/conexion.php');
 
global $con;
$idCaso=$_GET["id_caso"];
$consultarInformacionCaso=mysqli_query($con,"SELECT * FROM investigaciones where id='".$idCaso."'");
mysqli_next_result($con);
$resInformacionCaso=mysqli_fetch_assoc($consultarInformacionCaso);
$consultarAudios=mysqli_query($con,"SELECT * FROM multimedia_investigacion WHERE id_investigacion='".$idCaso."' AND id_multimedia=15");
$nombreArchivoZip="AUDIOS CASO ".$resInformacionCaso["codigo"].".zip";
$zip = new ZipArchive();

$zip->open($nombreArchivoZip,ZipArchive::CREATE);

while ($resAudio=mysqli_fetch_assoc($consultarAudios)){
    $path = "../data/audios/".$resAudio["ruta"];
    $zip->addFile($path,$archivo);
}

$zip->close();
//header("Content-disposition: attachment; filename=".$archivo);
//header("Content-type: audio/mp3");
//readfile($path);
header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename=$nombreArchivoZip");
// leemos el archivo creado
readfile($nombreArchivoZip);
// Por último eliminamos el archivo temporal creado
unlink($nombreArchivoZip);//Destruye el archivo temporal
?>