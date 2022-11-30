<?php

include_once '../plugins/lib/nusoap.php';
include_once '../conexion/conexion.php';
$servicio = new soap_server();

$ns = "urn:wssiglowsdl";
$servicio->configureWSDL("WSSiglo",$ns);
$servicio->schemaTargetNamespace = $ns;

$servicio->register("marcarCarguesEstado", 
	array('codigo' => 'xsd:string'), 
	array('return' => 'xsd:string'), 
	$ns,
    $ns.'#marcarCarguesEstado',
    'rpc',
    'encoded',
    'Mensaje Del WS' );

function marcarCarguesEstado($codigo){
	global $con;

	$arrayCodigos = explode(',', $codigo);
	$Result = "";
	$filas = 0;
	$id_anterior = 0;

	foreach ($arrayCodigos as $inv) {
		$idCaso = intval(preg_replace('/[^0-9]+/', '', $inv), 10); 
		
		if($id_anterior != $idCaso){

			$id_anterior = $idCaso;
		   	
		   	$sqlCon = mysqli_query($con, "SELECT a.id_investigacion FROM control_cargue a
		   		WHERE a.id_investigacion = $idCaso AND DATE_FORMAT(a.fecha, '%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y-%m-%d')");
		   	
		   	if($sqlCon){

		   		if(mysqli_num_rows($sqlCon) == 0){

		   			$sqlInsert = "INSERT INTO control_cargue (id_investigacion, fecha, id_usuario) VALUES($idCaso, CURRENT_TIMESTAMP(), 56)";

					if(mysqli_query($con, $sqlInsert)){

		   				$sqlUpdate = "UPDATE investigaciones SET conteo_cargue = conteo_cargue + 1 WHERE id = $idCaso";
		   				mysqli_query($con, $sqlUpdate);
						$Result .= $inv."-1,";
					}else{
						$Result .= $inv."-3,";
					}	
		   		}else{
		   			$Result .= $inv."-1,";
		   		}
			}else{
				$sqlInsert = "INSERT INTO control_cargue (id_investigacion, fecha, id_usuario) VALUES($idCaso, CURRENT_TIMESTAMP(), 56)";

				if(mysqli_query($con, $sqlInsert)){

	   				$sqlUpdate = "UPDATE investigaciones SET conteo_cargue = conteo_cargue + 1 WHERE id = $idCaso;";
	   				mysqli_query($con, $sqlUpdate);
					$Result .= $inv."-1,";
				}else{
					$Result .= $inv."-3,";
				}	
			}
		}else{
			$Result .= $inv."-1,";
		}
		$filas++;
	}   	

	if($filas > 0){
		$Result = substr($Result, 0, -1);
	}

	return $Result;
	//return json_encode($Result);
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents("php://input");
$servicio->service($HTTP_RAW_POST_DATA);

?>