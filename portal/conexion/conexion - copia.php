<?php
	$con= mysqli_connect("localhost","global","P3rm1s0.GRed.19","siglo");
	//$con= mysqli_connect("localhost","root","","siglo");

    mysqli_set_charset($con, "utf8");
    if (!$con) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$con2= mysqli_connect("localhost","global","P3rm1s0.GRed.19","ltdaglob_u7365390");
	//$con= mysqli_connect("localhost","root","","siglo");

    mysqli_set_charset($con2, "utf8");
    if (!$con2) {
	    die("Connection failed: " . mysqli_connect_error());
	}
?>