<?php

	$host = "localhost";
	$dbname = "summary";
	$username= "summary";
	$password = "RAc7jUsBX89tMsef";
	$dsn = "mysql:host=$host;dbname=$dbname; charset=utf8mb4";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	$pdo = new PDO($dsn, $username, $password, $attr);

?>

<!DOCTYPE html>
<html>



	<head>
		<meta http-equiv="content-Type" content="Text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<title> Sammanfattningar.se </title>
	</head>

<header>

		<h1 id="title"><a href="startpage.html">sammanfattningar.se</a></h1>

</header>


<body>


<form action="summaries.php" method="POST">
	<div id="name-head">
		<label for="author_name">Ditt namn: </label>
		<input type="text" name="author_name" id="your_name">

		<label for="title">Rubrik: </label>
		<input type="text" name="title" id="rubrik">
	</div>

		<textarea type="text" name="content" rows="10" cols="80" placeholder="Sammanfattning" id="textarea"></textarea>
		
		<label for="subject_id">Ämne: </label>
		<select name="subject_id">
		<option value="0">Välj ämne</option>

			<?php

				foreach($pdo->query("SELECT * FROM subjects ORDER BY name") as $row)
				{
					echo "<option value=\"{$row['id']}\">{$row['name']}</option>";					
				}

			?>

		</select>
	<input type="submit" value="Lägg till sammanfattning">
</form>

</body>

</html>