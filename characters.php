<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "dnddb";
$dbPort = 3308;

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort) or die("Couldn't make connection.");

?>

<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Character Select</title>
	</head>
	<body>
		<h1>Character Select</h1><br>
		<h4>Choose Your Character</h4><br>
			
		<?php
		//Iterate and list out all the characters stored on the db
		
			$sql = "SELECT * FROM characters;";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if($resultCheck > 0)
			{
				echo '<ul>';
				while($row = mysqli_fetch_assoc($result))
				{
					echo '<li><a href="/character.php?name=' . $row["name"] . '">' . $row["name"] . '</a></li>';
				}
				echo '</ul>';
			}
			else
			{
				echo '<p>You don\'t have any characters...</p>';
			}
			
		?>
		
		
	</body>
</html>