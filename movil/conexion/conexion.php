<?php
	$con= mysqli_connect("192.168.0.105","dbsiglo","jQuijano90G!oba!R3d.","siglo");
	
    mysqli_set_charset($con, "utf8");
    if (!$con) {
    die("Connection failed: " . mysqli_connect_error());

}
?>