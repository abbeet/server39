<?php
	#@
	session_start();
	include_once "includes.php";
	$xlogin 	= @$_POST['xlogin'];
	$xusername 	= @$_POST['xusername'];
	$xpassword 	= @$_POST['xpassword'];
	
	if ($xlogin == "28B60A2D") 
	{
		if ($xusername != "")
		{
			if ($xpassword != "")
			{
				$ouser = xuser("username, password, unit, aktif, reset, kunci", "username = '".$xusername."'");
				$nuser = mysql_num_rows($ouser);
				
				if ($nuser == 1)
				{
					$xuser = mysql_fetch_array($ouser);
					
					if ($xuser['aktif'] == "1")
					{
						$len = strlen($xpassword);
						
						if (decode_password($xuser['password'], $len) == md5($xpassword))
						{
							$session_name = "Kh41r4";
							
							$_SESSION[$session_name] 				= 1;
							$_SESSION['xusername_'.$session_name] 	= $xuser['username'];
							$_SESSION['xunit_'.$session_name] 		= $xuser['unit'];
							$_SESSION['kunci_'.$session_name] 		= $xuser['kunci'];
							
							$ouserlevel = xuserlevel("level", "username = '".$xuser['username']."'");
							$xuserlevel = mysql_fetch_array($ouserlevel);
							
							$_SESSION['xlevel_'.$session_name] = $xuserlevel['level'];
							
							$msg = "Login berhasil.";
							
							update_log($msg, 'xlogin', $xuser['username'], 1);
							last_login($xuser['username']);
							
							if ($xuser['reset'] == "0")
							{ ?>
							
								<meta http-equiv="refresh" content="0;URL=../index.php" /><?php
								
							}
							
							else
							{ ?>
							
								<meta http-equiv="refresh" content="0;URL=../index.php?p=<?php echo enkripsi(55); ?>" /><?php
								
							}
						}
						
						else
						{
							$msg = "Kata sandi salah.";
							
							$_SESSION['errmsg'] = $msg;
							update_log($msg, 'xlogin', $xuser['username'], 0); ?>
						
							<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
						}
					}
					
					else
					{
						$msg = "Nama pengguna tidak aktif. Silakan hubungi admin anda.";
						
						$_SESSION['errmsg'] = $msg;
						update_log($msg, 'xlogin', $xuser['username'], 0); ?>
					
						<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
					}
				}
				
				else
				{
					$msg = "Nama pengguna tidak terdaftar.";
					
					$_SESSION['errmsg'] = $msg;
					update_log($msg, 'xlogin', $xusername, 0); ?>
				
					<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
				}
			}
			
			else
			{
				$msg = "Kata sandi kosong.";
				
				$_SESSION['errmsg'] = $msg;
				update_log($msg, 'xlogin', $xusername, 0); ?>
				
				<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
			}
		}
		
		else
		{
			$msg = "Nama pengguna kosong.";
			
			$_SESSION['errmsg'] = $msg;
			update_log($msg, 'xlogin', $xusername, 0); ?>
			
			<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
		}
	}
	
	else 
	{ ?>
	
		<meta http-equiv="refresh" content="0;URL=../login.php" /><?php
	
	}
?>