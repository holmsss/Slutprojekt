<?php
mysql_connect("localhost", "root", "");
mysql_select_db("summary");
$sql = mysql_query(SELECT * FROM summaries WHERE name = 