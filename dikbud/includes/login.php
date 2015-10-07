<?php
	session_start();
	include_once "includes.php";
	$xlogin = $_POST['xlogin'];
	$xusername = $_POST['xusername'];
	$xpassword = md5($_POST['xpassword']);
	
	if ($xlogin) {
		$sql = check_login($xusername,$xpassword);
		
		if ($xusername == "" && $xpassword == "") {
			$_SESSION['errmsg'] = "Password / Username Salah silahkan ulangi kembali!";
			update_log($sql,'xlogin',0); ?>
			
			<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
		} 
		else {					
			$rs = mysql_query($sql);
			$count = mysql_num_rows($rs);
			
			if ($count == 0) {
				$_SESSION['errmsg'] = "Password / Username salah silahkan ulangi kembali!";
				update_log($sql,'xlogin',0); ?>
				<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
			} 
			else {
				$xuser = mysql_fetch_object($rs);
				
				@session_start();
				@session_id();
				@session_register('sukki'); $_SESSION['sukki'] = 1;
				@session_register('xusername'); $_SESSION['xusername'] = $xuser->username;
				@session_register('xlevel'); $_SESSION['xlevel'] = $xuser->level;
				@session_register('xuserid'); $_SESSION['xuserid'] = $xuser->id;
				@session_register('xuserpass'); $_SESSION['xuserpass'] = $xuser->password;
				@session_register('xkdunit'); $_SESSION['xkdunit'] = $xuser->kdunit;
				@session_register('xth'); $_SESSION['xth'] = date('Y');
				update_log($sql,'xlogin',1);
				update_lastvisit($xuser->id); ?>
				<meta http-equiv="refresh" content="0;URL=../index.php" /><?php
			}
		}
	}
	else { ?>
		<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
	}
?>