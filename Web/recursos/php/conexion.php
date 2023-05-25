<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	try {
		$bbdd = new PDO("mysql:host=$host;dbname=tiempo", $user, $pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$bbdd -> exec ("set names utf8");
	
	} catch (PDOException $e) {
		echo $e -> getMessage();
	}
?>

