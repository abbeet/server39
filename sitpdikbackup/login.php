<?php 
	session_start();
	include_once "includes/includes.php";
	$errmsg = @$_SESSION['errmsg'];
	$title = get_title();
	$copyright = get_copyright();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo @$title; ?></title>
        <link href="css/images/webicon.ico" rel="shortcut icon" type="image/x-icon">
		<meta name="robots" content="index, follow" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="author" content="RapidxHTML" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="lib/ajaxcrud/js/jquery.js"></script>
		<script language="javascript" src="js/global.js" type="text/javascript"></script>
		
		<script language="javascript" type="text/javascript">
		
			function setFocus() 
			{
				document.xlogin.xusername.select();
				document.xlogin.xusername.focus();
			}
			
		</script>
		
		<script type="text/javascript" src="lib/slider/jquery.js"></script>
		<script type="text/javascript" src="lib/slider/easySlider1.7.js"></script>
		
		<script type="text/javascript">
			
			$(document).ready(function()
			{
				$("#slider").easySlider(
				{
					auto: true, 
					continuous: true,
					numeric: true
				});
			});
			
		</script>
		
		<link href="lib/slider/screen.css" rel="stylesheet" type="text/css" media="screen"/>	
	</head>

	<body>
		<div class="rapidxwpr floatholder">
			<div id="header">
				<a href="index.php"><img id="logo" class="correct-png" src="css/images/h_green/logo.png" alt="Home" title="Home" /></a>
			</div>
			<div id="middle">
				<div class="main-image">
					<img src="" alt="" />
				</div>
				<div id="main" class="clearingfix">
					<div id="mainmiddle" class="floatbox">
						<div id="right" class="clearingfix">
							<div class="benefits">
								<div class="benefits-bg clearingfix">
									<h4><font size="+1"><b>Login</b></font></h4><?php
									
									if (isset($errmsg)) 
									{ ?>
										
										<dl id="system-message">
											<dt class="message"></dt>
											<dd class="message message fade">
												<ul>
													<li><?php echo @$errmsg; unset($_SESSION['errmsg']); ?></li>
												</ul>
											</dd>
										</dl><?php
										
									} ?>
									
									<form name="xlogin" id="form-login" method="post" action="includes/login.php">
										<table>
											<tr>
												<td>Nama Pengguna&nbsp;</td>
												<td>&nbsp;<input type="text" name="xusername" class="inputbox" size="25" /></td>
											</tr>
											<tr>
												<td>Kata Sandi&nbsp;</td>
												<td>&nbsp;<input type="password" name="xpassword" class="inputbox" size="25" /></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>
													<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" 
													value="Login" />
													
													<input type="hidden" name="xlogin" value="28B60A2D" />
													<div class="button2-left">
														<div class="next">
															<a onclick="Btn_Submit('xlogin');">Login</a>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</form>
									<h5>&nbsp;</h5>
								</div>
							</div>
						</div>
						<div id="content" class="clearingfix">
							<div class="floatbox">
								<div class="box">
									<div class="box-bg">
										<div id="container">
											<div id="judul">
												<h1><h1 style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif ; color:#555555">Selamat Datang<br/>
	  <span><font size="3" color="#555555" style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><b>di Sistem Informasi Tata Persuratan</font><br />
	  </span></h1>
											</div>
											<div id="isi">
												<div id="slider">
													<ul>
														<li><a href=""><img src="lib/slider/01x.jpg" alt="" /></a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rapidxwpr">
			<div id="footer" class="clearingfix">
				<div style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">
					<a href="http://www.batan.go.id"><font color="#555555"><?php echo $copyright ?></font></a>
			</div>
		</div>
	</body>
</html>