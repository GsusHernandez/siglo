<?php
	//$con= mysqli_connect("192.168.0.61","grbd","Global.2021","siglo");
	$con= mysqli_connect("localhost","root","","siglo2");
	//$con= mysqli_connect("localhost","grbd","Global.2021","siglo");
    mysqli_set_charset($con, "utf8");
    if (!$con) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$rutaArchivos = "http://192.168.0.106/siglo/portal/data/";
	
?>