<?php
	$host="localhost"; $user = "root"; $password = "Kr4k4t4u123"; $db = "dbskp_dikbud";
	
	@mysql_connect($host,$user,$password) or die("Can't connect to the database server. Error Message: ".mysql_error())."<br>";
	@mysql_select_db($db) or die("Can't connect to the database $db. Error Message: ".mysql_error());
?>