<?php
	// Database configuration
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "inventory";
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
?>

