<?php
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "dnddb";
	$dbPort = 3308;

	$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort) or die("Couldn't make connection.");

	$characterid = $_POST["id"];
	$health = $_POST["hp"];
	$hitdie = $_POST["hit_die_current"];
	$name = $_POST["name"];
	
	$sql = "UPDATE character SET hp=$health, hit_die_current=$hitdie WHERE id=$cid";
	mysqli_query($conn, $sql);
	
	header("Location: ../character.php?$name");