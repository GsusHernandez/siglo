<?php
	$con= mysqli_connect("localhost","grbd","Global.2021","siglo");
	//$con= mysqli_connect("localhost","root","","siglo2");

    mysqli_set_charset($con, "utf8");
    if (!$con) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_next_result($con);
	$actualizarEstadoUsuarios="update usuarios set vigente='s' where tipo_usuario=1 and empleado='s'";

	mysqli_query($con,$actualizarEstadoUsuarios);
?>