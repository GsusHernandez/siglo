<?php

// A list of permitted file extensions
$allowed = array('pdf');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../data/soportes_asignacion_analistas/'.$_FILES['upl']['name'])){
	//if(move_uploaded_file($_FILES['upl']['tmp_name'], '../data/informes/'.$_FILES['upl']['name'])){
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;