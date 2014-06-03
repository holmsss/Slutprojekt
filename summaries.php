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


<div id="su_list">
<?php

	$host = "localhost";
	$dbname = "summary";
	$username= "summary";
	$password = "RAc7jUsBX89tMsef";
	$dsn = "mysql:host=$host;dbname=$dbname";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	$pdo = new PDO($dsn, $username, $password, $attr);

	// add form data to summaries table, if form sent
	if(!empty($_POST))
	{
		if($_POST['author_name'] !== "" && $_POST['title'] !== "" && $_POST['content'] !== "" && $_POST['subject_id'] !== "")
		{
			$author_name = filter_input(INPUT_POST, 'author_name', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
			$title 		 = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
			$content     = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
			$subject_id  = filter_input(INPUT_POST, 'subject_id', FILTER_VALIDATE_INT);
			$statement = $pdo->prepare("INSERT INTO summaries (subject_id, author_name, date, title, content) VALUES (:subject_id, :author_name, NOW(), :title, :content)");
			$statement->bindParam(":subject_id", $subject_id);
			$statement->bindParam(":author_name", $author_name);
			$statement->bindParam(":title", $title);
			$statement->bindParam(":content", $content);
			if(!$statement->execute())
				print_r($statement->errorInfo());
		}
	}


// show details on one summary if user clicked summary link else show all summaries
	if(!empty($_GET) && isset($_GET['summary_id']))
	{
		if($_GET['summary_id'] !== "")
		{
			$summary_id = filter_input(INPUT_GET, "summary_id", FILTER_VALIDATE_INT);

			
			// show summary details
			$sum_statement = $pdo->prepare("SELECT summaries.*, subjects.name AS 'subject_name' FROM summaries JOIN subjects ON summaries.subject_id=subjects.id WHERE summaries.id=:summary_id");
			$sum_statement->bindParam(":summary_id", $summary_id);
			if($sum_statement->execute())
			{
				if($row = $sum_statement->fetch())
				{
					echo "<h1>{$row['title']}</h1>
						<div id=\"s_list\">
							<p>{$row['date']}</p>
							<p>av {$row['author_name']}</p>
							<p>Ämne: {$row['subject_name']}</p>
							<p>{$row['content']}</p>
							<p><a href=\"summaries.php\">Tillbaka</a></p>
						</div>";


			//show comment form
			?>
		</div>


			<form  id="post_summary"action="summaries.php?summary_id={$row['id']}" method="POST">
				<p>
					<label for="author_name">Ditt namn:</label>
					<input type="text" name="author_name" />
				</p>

				<p>
					<label for="content">Kommentar</label>
					<input type="text" name="content" />
				</p>
				<input id="submit_summary" type="submit" />

			</form>
			<?php

				}
			}
				
			else
				print_r($sum_statement->errorInfo());



			//show all comments belonging to chosen summary
		}
	}
	else{
		
	// show all posts from summaries table
	echo "<ul>";
	foreach($pdo->query("SELECT * FROM summaries ORDER BY date DESC") as $row)
	{
		echo "<li><a href=\"?summary_id={$row['id']}\">{$row['title']}, av {$row['author_name']} ({$row['date']})</a></li>";
	}
	echo "</ul>";
	}

?>



