<?php

/*	@session_start();
	include_once "includes/includes.php";
	$title = get_title();
	$version = get_version();
	$copyright = get_copyright();   */

	/*session_start();
	include_once "includes/includes.php";
	$errmsg = @$_SESSION['errmsg'];
	$title = get_title();
	$copyright = get_copyright(); */
	
	 
	session_start();
	include_once "includes/includes.php";
	$errmsg = @$_SESSION['errmsg'];
	$title = get_title();
	$copyright = get_copyright();

	
	if (@$_POST['xlogin']) 
	{
		$xlogin = $_POST['xlogin'];
		$xusername = $_POST['xusername'];
		$xpassword = md5($_POST['xpassword']);
		
		$sql = check_login($xusername,$xpassword);
		
		if ($xusername == "" && $xpassword == "")
		{
			$_SESSION['errmsg'] = "Password / Username Salah silahkan ulangi kembali!";
			update_log($sql,'xlogin',0);
		} 
		else
		{					
			$rs = mysql_query($sql);
			$count = mysql_num_rows($rs);
			
			if ($count == 0)
			{
				$_SESSION['errmsg'] = "Password / Username salah silahkan ulangi kembali!";
				update_log($sql,'xlogin',0);
			} 
			else 
			{
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
				<meta http-equiv="refresh" content="0;URL=../skpRistek/index.php" /><?php
				exit;
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
		<title><?php echo $title ?></title>
		<meta name="robots" content="index, follow" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="author" content="RapidxHTML" />
		<link href="../skp/css/style.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="../skp/lib/ajaxcrud/js/jquery.js"></script>
		<script language="javascript" src="../skp/js/newsticker.js"></script>
		<!--[if lte IE 7]><link href="css/iehacks.css" rel="stylesheet" type="text/css" /><![endif]-->
		<!--script type="text/javascript" src="js/jquery.js"></script-->
		<!--[if IE 6]>
		<script type="text/javascript" src="js/ie6pngfix.js"></script>
		<script type="text/javascript">
		DD_belatedPNG.fix('img, ul, ol, li, div, p, a, h1, h2, h3, h4, h5, h6');
		</script>
		<![endif]-->
		<!-- untuk slider -->
		<script type="text/javascript" src="../skp/slider/jquery.js"></script>
		<script type="text/javascript" src="../skp/slider/easySlider1.7.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){	
			$("#slider").easySlider({
				auto: true, 
				continuous: true,
				numeric: true
			});
		});	
		</script>
	
		<link href="../skp/slider/screen.css" rel="stylesheet" type="text/css" media="screen"/>	
	</head>

	<body>
	
		<!-- wrapper -->
		<div class="rapidxwpr floatholder">
	
			<!-- header -->
			<div id="header">
	
				<!-- logo -->
				<a href="../skp/index.php">
					<img id="logo" class="correct-png" src="../skp/images/logo.png" alt="Home" title="Home" /></a>
				<!-- / logo -->
	
				<!-- topmenu -->
				
				<!-- / topmenu -->
			</div>
			<!-- / header -->

			<!-- main body -->
			<div id="middle">
	                     <p align="center"><marquee></marquee>
	                       <marquee>
	                       <strong><font size="+1" color="#0000FF">SKP Dikbud dalam pengembangan.....<font></strong>
                           </marquee>
</p>
				<!-- main image -->
				<div class="main-image">
					<img src="" alt="" />
					
				</div>
				<!-- / main image -->
	
				<div id="main" class="clearingfix">
					<div id="mainmiddle" class="floatbox">
	
						<!-- right column -->
						<div id="right" class="clearingfix">
	
							<!-- benefits box -->
						  <div class="benefits">
							<div class="benefits-bg clearingfix">
									<h4><font size="+1"><b>Login</b></font></h4><?php
										
									if (isset($_SESSION['errmsg'])) 
									{ ?>
										<div style="text-decoration:blink; color:#FF0000"; align="center">
											<?php echo $_SESSION['errmsg']; unset($_SESSION['errmsg']); ?>
										</div><?php
									} ?>
									
									<script type="text/javascript">
										function login_submit()
										{
											document.forms['xlogin'].submit();
										}
									</script>
									
									<form name="xlogin" method="post" action="includes/login.php">
										<table>
											<tr>
												<td>Username&nbsp;</td>
												<td>&nbsp;<input type="text" name="xusername" /></td>
											</tr>
											<tr>
												<td>Password&nbsp;</td>
												<td>&nbsp;<input type="password" name="xpassword" /></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>
													<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Login" type="submit">
													<input name="xlogin" type="hidden" value="1" />
													<div class="button2-left">
														<div class="next">
															<a onClick="login_submit();">Login</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td><br>Dukungan:</td>
												<td></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><img src=""></td>
											</tr>
											<tr>
												<td>Telp</td>
												<td>...........................</td>
											</tr>
										</table>
									</form>
							</div>
						  </div>
							<!-- / benefits box -->
							<!-- right column -->
							<td>&nbsp;</td>
						
                      </div>
						<!-- / right column -->
	                     
						<!-- content column -->
					  <div id="content" class="clearingfix">
							<div class="floatbox">								
<!-- welcome -->
<!--
<div class="welcome">
	<h1>Selamat Datang<br />
	  <span><font size="3" color="#339933"><b>Di Sistem Informasi Perencanaan, Monitoring dan Evaluasi</b></font></span></h1>
	</div>
<!-- / welcome -->

<!-- features -->
<div class="box">
	<div class="box-bg">
<!--ini bagian slider-->
<div id="container">
	<div id="judul">
		<h1>Selamat Datang<br />
	  <span><font size="4" color="#740e0e"><b>di Sistem Informasi Sasaran Kinerja Pegawai DIKBUD </b></font></span></h1>
		</div>
	<div id="isi">
		<div id="slider">
			<ul>		
				<li><a href="../skp/slider/01.png"><img src="../skp/slider/01.png" alt="slider 1" /></a></li>
				<li><a href="../skp/slider/02.png"><img src="../skp/slider/02.png" alt="slider 2" /></a></li>
				<li><a href="../skp/slider/03.png"><img src="../skp/slider/03.png" alt="slider 3" /></a></li>
			</ul>
		</div>
	</div>
</div>
	</div>
</div>
<!-- / features -->
		</div>
	</div>
<!-- / content column -->
	
					</div>
				</div>
	
		  </div>
			<!-- / main body -->
	
		</div>
		<!-- / wrapper -->
	
		<!-- footer -->
		<div class="rapidxwpr">
			<div id="footer" class="clearingfix">
	
				<!-- footermenu -->
				
				<!-- / footermenu -->
				<!-- credits -->
				<div class="credits2">
					<a> </a>
				</div>
				<div class="credits">
					<a href="http://www.batan.go.id/ppin"><?php echo $copyright ?></a>
				</div>
				<!-- / credits -->
	
			</div>
		</div>				
		<!-- / footer -->
	
	</body>
</html>