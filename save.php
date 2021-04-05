<?php
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "dnddb";
	$dbPort = 3308;

	$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort) or die("Couldn't make connection.");

	$characterid = $_GET["id"];
	$health = $_GET["hp"];
	$hitdie = $_GET["hit_die_current"];
	$name = $_GET["name"];
	
	$sql = "UPDATE characters SET hp=$health, hit_die_current=$hitdie WHERE id=$characterid";
	
	//echo $sql;
	
	mysqli_query($conn, $sql);
	
	echo '<p>Save Worked Probably</p>';
	
	header("Location: ../character.php?name=$name");