<?php
	error_reporting (E_ALL ^ E_NOTICE);
	include_once "includes.php";
	update_log('','xlogout',1);
	@session_start();
	@session_unregister();
	@session_unset();
	@session_destroy();
	@session_start();
	$_SESSION['errmsg'] = "Anda telah logout. Terima kasih.";
?>

<meta http-equiv="refresh" content="0;URL=../login.php">