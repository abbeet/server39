<?php
	include_once "includes.php";
	
	update_log('Logout success.','xlogout', @$_GET['u'], 1);
	session_start();
	session_unset();
	session_destroy();
	session_start();
	$_SESSION['errmsg'] = "Logout success.";
?>

<meta http-equiv="refresh" content="0;URL=../login.php">