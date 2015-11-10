<?php
	error_reporting (E_ALL ^ E_NOTICE);
	date_default_timezone_set("Asia/Jakarta");
	
	@session_start();
	include_once "includes/includes.php";
	checkauthentication();
	$p = @$_GET['p'];
	$errmsg = @$_SESSION['errmsg'];
	$xlevel = @$_SESSION['xlevel'];
	$xusername =@ $_SESSION['xusername'];
	$xth =@ $_SESSION['xth'];
	$title = get_title();
	$version = get_version();
	$copyright = get_copyright();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html id="minwidth" dir="ltr" xml:lang="en-gb" xmlns="http://www.w3.org/1999/xhtml" lang="en-gb">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="robots" content="">
		<meta name="keywords" content="">
		<meta name="description" content="m">
		<meta name="generator" content="">
		<title><?php echo $title ?></title>
		<link href="css/images/webicon.ico" rel="shortcut icon" type="image/x-icon">
		
		<?php include "includes/head.php" ?>
	
	    <style type="text/css">
<!--
.style1 {font-size: 14px}
-->
        </style>
</head>
	<body id="minwidth-body">
		<div id="border-top" class="h_lapan">
			<div>
				<div>
					<span class="version"><?php echo $version ?></span>
					<span class="title"><?php echo $title ?></span>
				</div>
			</div>
		</div>
		<div id="header-box">
			<div id="module-status">
				<span class="loggedin-users">Selamat datang, <b><?php echo $xusername ?></b></span>
				<span class="logout"><a href="includes/logout.php">Logout</a></span>
			</div><?php
			
			if (is_published("topmenu")) { ?>
				<div id="module-menu"><?php
					include "includes/topmenu.php"; ?>
				</div><?php
			} ?>
			
			<div class="clr"></div>
		</div>
		<div id="content-box">
			<div class="border">
				<div class="padding">
					<div id="toolbar-box">
   						<div class="t"><div class="t"><div class="t"></div></div></div>
							<div class="m">
								<div class="toolbar" id="toolbar"></div>
								
								<?php $xmenu = xmenu_id($p); ?>
								
								<div class="header icon-48-generic">
								
								<?php 
								
									if (!isset($p)) echo "Home";
									else echo $xmenu->title; ?>
									
								</div>
								<div class="clr"></div>
							</div>
						<div class="b"><div class="b"><div class="b"></div></div></div>
  					</div>
					<font color="#B00000" size="+1"><strong>Tahun : <?php echo $xth ?></strong></font><br />
<?php
switch ( $xlevel )
	{
		case 1 ;
			$teks = 'DIREKTORAT JENDERAL KEBUDAYAAN' ;
			break;
		case 2 ;
			$teks = 'DIREKTORAT JENDERAL KEBUDAYAAN' ;
			break;	
		case 3 ;
			$teks = nm_satker(substr($xusername,4,6)) ;
			break;
		case 4 ;
			$teks = nm_satker(substr($xusername,4,6)) ;
			break;
		case 5 ;
			$teks = nm_unit(substr($xusername,3,7)) ;
			break;	
		case 6 ;
			$teks = nm_satker(substr($xusername,4,6)) ;
			break;
		case 7 ;
			$teks = nm_satker(substr($xusername,4,6)) ;
			break;	
		case 8 ;
			$teks = nm_unit(substr($xusername,3,7)) ;
			break;	
		case 9 ;
			$teks = 'DIREKTORAT JENDERAL KEBUDAYAAN' ;
			break;		
	}
?>
					<font color="#B00000" size="+1"><strong><?php echo $teks ?></strong></font><br />
					<?php
					
					if (isset($errmsg)) { ?>
						<dl id="system-message">
							<dt class="message">Error</dt>
							<dd class="message message fade">
								<ul>
									<li><?php echo $errmsg; unset($_SESSION['errmsg']); ?></li>
								</ul>
							</dd>
						</dl><?php
					}
					
					if (is_published("submenu")) { ?>
						<div id="submenu-box">
							<div class="t"><div class="t"><div class="t"></div></div></div>
								<div class="m">				
									<ul id="submenu"><?php
									
										if (@$xmenu->type == 'sub') $parent = @$xmenu->parent;
										else $parent = $p;
										$rs = xmenu_type("LIKE '%sub%'",$parent);
										$count = mysql_num_rows($rs);
										if ($count == 0) echo "&nbsp;";
										else {
											while ($submenu = mysql_fetch_object($rs)) { ?>
												<li><a href="index.php?p=<?php echo $submenu->id ?>"><?php echo $submenu->name ?></a></li><?php 
											}
										} ?>
										
									</ul>
									<div class="clr"></div>
								</div>
							<div class="b"><div class="b"><div class="b"></div></div></div>
						</div><?php
					} ?>		
					<div id="element-box">
						<div class="t"><div class="t"><div class="t"></div></div></div>
						<div class="m">
							<table cellspacing="0" width="100%">
								<tbody>
									<tr valign="top"><?php
									
										if (is_published("leftmenu")) { ?>
											<td width="20px">
												<fieldset id="treeview" style="width:190px;"><?php
													include "includes/leftmenu.php"; ?>
												</fieldset>
											</td><?php
										} ?>
										
										<td>
											<fieldset style="min-height:280px;"><?php
											
											if (!isset($p) && @$xmenu->src == '') { 
												include "includes/home.php";
											}
											else if (strpos($xmenu->level,$xlevel) !== false) {
												include $xmenu->src;
											}
											else { ?>							
												<dl id="system-message">
													<dt class="message">Error</dt>
													<dd class="message message fade">
														<ul>
															<li>Anda tidak berhak membuka halaman ini!</li>
														</ul>
													</dd>
												</dl><?php
											} ?>
											
											</fieldset>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="clr"></div>
						</div>
						<div class="b"><div class="b"><div class="b"></div></div></div>
					</div>
					<noscript>
						Warning! JavaScript must be enabled for proper operation of the Administrator back-end.
					</noscript>
					<div class="clr"></div>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<div id="border-bottom"><div><div></div></div></div>
		<div id="footer">
			<p class="copyright"><?php echo $copyright ?></p>
		</div>
		<div style="display: none; z-index: 65555; position: fixed; top: 0px; left: 0px; visibility: hidden; opacity: 0;" id="sbox-overlay"></div>
		<div style="display: none; z-index: 65557; position: fixed; top: 50%; left: 50%;" id="sbox-window">
			<a href="#" id="sbox-btn-close"></a>
			<div style="visibility: hidden; opacity: 0;" id="sbox-content"></div>
		</div>
	</body>
</html>