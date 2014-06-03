<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<title> Sammanfattningar.se </title>
	</head>

	<header>

		<h1 id="title"><a href="startpage.html">sammanfattningar.se</a></h1>

</header>


<ul>
	<li><a href="add_subject.php">Add subject</a></li>

<?php

	$host = "localhost";
	$dbname = "summary";
	$username= "summary";
	$password = "RAc7jUsBX89tMsef";
	$dsn = "mysql:host=$host;dbname=$dbname";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	$pdo = new PDO($dsn, $username, $password, $attr);

	// add new subject from form
	if(!empty($_POST))
	{
		if($_POST['subject_name'] !== "")
		{
			$_POST = null;
			$subject_name = filter_input(INPUT_POST, 'subject_name');
			$statement = $pdo->prepare("INSERT INTO subjects (name) VALUES (:subject_name)");
			$statement->bindParam(":subject_name", $subject_name);
			if(!$statement->execute())
				print_r($statement->errorInfo());
		}
	}

	// show all posts from subject table
	foreach($pdo->query("SELECT * FROM subjects ORDER BY name") as $row)
	{	
		echo "<li><a href=\"summaries.php?subject_id={$row['id']}\">{$row['name']}</a></li>";
	}

	


?>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title> Sammanfattningar.se </title>
	</head>

</ul>

</html>