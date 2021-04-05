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
		<script src="javascript/character.js?version=1"></script>
		<?php 
			echo '<title>' . $_GET["name"] . '</title>';
		?>
		
	</head>
	<body>
		<?php
			$data = $_GET["name"];
			$sql = "SELECT * FROM characters WHERE name=?;";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql))
			{
				echo "SQL statement failed";
			}
			else
			{
				mysqli_stmt_bind_param($stmt, "s", $data);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$resultCheck = mysqli_num_rows($result);
				
				if($resultCheck > 0)
				{
					$info = mysqli_fetch_assoc($result);
					
					//skills
					$data_skill = $info["id"];
					$sql_skill = "SELECT * FROM skills WHERE characterid=?;";
					$stmt_skill = mysqli_stmt_init($conn);
					mysqli_stmt_prepare($stmt_skill, $sql_skill);
					mysqli_stmt_bind_param($stmt_skill, "i", $data_skill);
					mysqli_stmt_execute($stmt_skill);
					$result_skill = mysqli_stmt_get_result($stmt_skill);
					$info_skill = [];
					while($row = mysqli_fetch_assoc($result_skill))
					{
						array_push($info_skill, $row);
					}
					
					//Attacks
					$data_attack = $info["id"];
					$sql_attack = "SELECT * FROM attacks WHERE characterid=?;";
					$stmt_attack = mysqli_stmt_init($conn);
					mysqli_stmt_prepare($stmt_attack, $sql_attack);
					mysqli_stmt_bind_param($stmt_attack, "i", $data_attack);
					mysqli_stmt_execute($stmt_attack);
					$result_attack = mysqli_stmt_get_result($stmt_attack);
					$info_attack = [];
					while($row = mysqli_fetch_assoc($result_attack))
					{
						array_push($info_attack, $row);
					}
					
					//Counters
					$data_counter = $info["id"];
					$sql_counter = "SELECT * FROM counters WHERE characterid=?;";
					$stmt_counter = mysqli_stmt_init($conn);
					mysqli_stmt_prepare($stmt_counter, $sql_counter);
					mysqli_stmt_bind_param($stmt_counter, "i", $data_counter);
					mysqli_stmt_execute($stmt_counter);
					$result_counter = mysqli_stmt_get_result($stmt_counter);
					$info_counter = [];
					while($row = mysqli_fetch_assoc($result_counter))
					{
						array_push($info_counter, $row);
					}
					
					$js_array_skill = json_encode($info_skill);
					$js_array_attack = json_encode($info_attack);
					$js_array_counter = json_encode($info_counter);
					$js_array = json_encode($info);
					echo "<script>var javascript_array = ". $js_array . ";\n";
					echo "var javascript_array_skill = ". $js_array_skill . ";\n";
					echo "var javascript_array_attack = ". $js_array_attack . ";\n";
					echo "var javascript_array_counter = ". $js_array_counter . ";\n";
					echo 'focusCharacter = new Character(javascript_array, javascript_array_skill, javascript_array_attack, javascript_array_counter);'; 
					echo '</script>';
					
					echo '<h1>' . $_GET["name"] . '</h1>';
					echo '<p>Str:' . $info["strengthScore"] . 
					' Dex:' . $info["dexterityScore"] . 
					' Con:' . $info["constitutionScore"] .
					' Int:' . $info["intelligenceScore"] .
					' Wis:' . $info["wisdomScore"] .
					' Cha:' . $info["charismaScore"] .
					' AC:' . $info["armor_class"].
					' Speed:' . $info["speed"].
					'</p>';
					
					echo '<div id="result"></div><br>';
						
					echo '<h3>General:</h3>';
					echo '<button type="button" onclick="rollInitiative(focusCharacter)">Initiative</button>';
					
					echo '<div id="health"><p>HP: ' . $info["hp"] . ' / ' . $info["max_hp"]  . '</p></div>';

					echo '<button type="button" onclick="updateHealth(focusCharacter, 1)">^</button>';
					echo '<button type="button" onclick="updateHealth(focusCharacter, -1)">V</button>';
					echo '<button type="button" onclick="setHealth(focusCharacter, ' . $info["max_hp"] .')">Reset</button>';
					echo '</p>';
					
					echo '<div id="hitdie"><p>HitDie: ' . $info["hit_die_current"] . ' / ' . $info["hit_die_total"]  . '</p></div>';
					for ($x = 1; $x <= $info["hit_die_total"]; $x++) {
						echo '<button type="button" onclick="rollHitDie(focusCharacter, ' . $x . ')">' . $x . '</button>';
					}
					echo '<button type="button" onclick="resetHitDie(focusCharacter)">Reset</button>';
					
					echo '<h3>Saving Throws:</h3>';
					echo '<button type="button" onclick="createRollStringSaveThrow(focusCharacter, \'str\')">Strength</button>';
					echo '<button type="button" onclick="createRollStringSaveThrow(focusCharacter, \'dex\')">Dexterity</button>';
					echo '<button type="button" onclick="createRollStringSaveThrow(focusCharacter, \'con\')">Constitution</button>';
					echo '<button type="button" onclick="createRollStringSaveThrow(focusCharacter, \'int\')">Intelligence</button>';
					echo '<button type="button" onclick="createRollStringSaveThrow(focusCharacter, \'wis\')">Wisdom</button>';
					echo '<button type="button" onclick="createRollStringSaveThrow(focusCharacter, \'cha\')">Charisma</button>';
					
					echo '<br>';
					echo '<h3>Skill Checks</h3>';
					foreach ($info_skill as $value_skill)
					{
						echo '<button type="button" onclick="createRollStringSkillCheck(focusCharacter, ' . $value_skill["id"] . ')">' . $value_skill["name"] . '</button>';
					}
					echo '<br>';
					echo '<h3>Attacks</h3>';
					foreach ($info_attack as $value_attack)
					{
						echo '<button type="button" onclick="createRollStringAttack(focusCharacter, ' . $value_attack["id"] . ')">' . $value_attack["name"] . '</button>';
					}
					echo '<br>';
					echo '<h3>Counters</h3>';
					foreach ($info_counter as $value_counter)
					{
						echo '<div id="counter' . $value_counter["id"] . '"><p>' . $value_counter["name"] . ': ' . $value_counter["counter_current"] . ' / ' . $value_counter["counter_max"] . '</p></div>';
						echo '<button type="button" onclick="changeCounter(focusCharacter, 1, ' . $value_counter["id"] . ')">^</button>';
						echo '<button type="button" onclick="changeCounter(focusCharacter, -1, ' . $value_counter["id"] . ')">V</button>';
					}
					
					echo '<br><br><br>';
					echo '<div id="saveDiv">';
					echo '<a href="save.php?name=' . $info["name"] . '&hp=' . $info["hp"] . '&hit_die_current=' . $info["hit_die_current"] . '&id=' . $info["id"] . '">Save</a>';
					echo '</div>';
				}
				else
				{
					echo '<p>This character does not exist</p>'; 
				}
			}
		?>
		
	</body>
</html>