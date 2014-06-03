<?php

// password: RAc7jUsBX89tMsef	

// värden för pdo
$host     = "localhost";
$dbname   = "summary";
$username = "summary";
$password = "RAc7jUsBX89tMsef";
// göra pdo
$dsn = "mysql:host=$host;dbname=$dbname";
$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
$pdo = new PDO($dsn, $username, $password, $attr);

if($pdo)
{
	//har ngt postats? skriv till databas
	 if(isset($_POST))
	 {
		$user_id = filter_input(INPUT_POST, 'user_id');
		$post_unfiltered = filter_input(INPUT_POST, 'post');
		$post = str_replace(' ', 'penis', $post_unfiltered);
		
		//echo $user_id. "," . $post;
		
		$statement = $pdo -> prepare("INSERT INTO posts (date, user_id, post) VALUES (NOW(), :user_id, :post)");
		
		$statement->bindParam(":user_id", $user_id);
		$statement->bindParam(":post", $post); 
		$statement->execute();
	 }
	//visa formulär för att skriva inlägg
?>

<form action="subjects.php" method="POST">

<p>
	<label for="user_id"> User: </label>
	<select name="user_id">
		<?php
		
		//<option value=0>DAMP</option>
		
		foreach ($pdo->query("SELECT * FROM users ORDER BY name") as $row)
		{
		echo "<option value=\"{$row['id']}\">{$row['name']}></option>";
		}
		?>
	</select>
</p>
<p>
	<label for="post"> Post: </label>
	<input type="text" name="post" />
</p>
<input type="submit" value="post" />

</form>
<hr/>


<?php

 echo "<ul>";
 echo "<li><a href=\"index.php\"> All users </a> </li>";
	foreach ($pdo->query("SELECT * FROM users ORDER BY name") as $row){
		echo "<li><a href=\" ?user_id={$row['id']}\">{$row['name']}</a></li>";
	}
 echo "</ul>";
 echo "<hr> </hr>";
 
 if (!empty($_GET))
 {
	$_GET = null;
	$user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
	$statement = $pdo->prepare("SELECT posts.*,users.name FROM posts JOIN users ON users.id=posts.user_id WHERE user_id=:user_id ORDER BY date");
	$statement->bindParam(":user_id", $user_id);
	
	if($statement->execute())
	{
		while($row = $statement->fetch())
		{
			echo "<p>{$row['date']} by {$row['id']} <br />
			{$row['post']} </p>";
		}
	}
	else
	{
		print_r($statement->errorInfo());
	}
	
 }
 else
 {
	foreach ($pdo->query("SELECT posts.* ,users.name AS user_name FROM posts JOIN users ON users.id=posts.user_id ORDER BY date") as $row)
	{
		echo "<p>{$row['date']} by {$row['id']} <br />
			{$row['post']} </p>";
	}
 }
 
}
else{
 echo "not connected";
}

// visa alla användare(ul)

//om user klickat på ett namn, visa dess inlägg
// annars visa alla inlägg

?>