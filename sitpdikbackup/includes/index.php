<?php
	@session_start();
	include_once "includes/includes.php";
	checkauthentication();
	$p = @$_GET['p'];
	$errmsg = @$_SESSION['errmsg'];
	$xlevel = @$_SESSION['xlevel'];
	$xusername =@ $_SESSION['xusername'];
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
		<link href="css/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
		
		<?php include "includes/head.php"; ?>
		
	</head>
	<body id="minwidth-body">
		<div id="border-top" class="h_green">
			<div>
				<div>
				<!--span class="version"><?php #echo $version ?></span--></div>
			</div>
		</div>
		<div id="header-box">
			<div id="module-status">
				<span class="loggedin-users">Selamat datang, <b><?php echo $xusername ?></b></span>
				<span class="logout"><a href="includes/logout.php">Logout</a></span>
			</div><?php
			
			if (is_published("topmenu")) { ?>
				<div class="suckertreemenu"><?php
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
									<table width="100%">
										<tr>
											<td><?php 
								
									if (!isset($p)) echo "Home";
									else echo $xmenu->title; ?>
									
											</td>
											<td align="right">
											<!-- LiveZilla Chat Button Link Code (ALWAYS PLACE IN BODY ELEMENT) ><a href="javascript:void(window.open('http://183.91.67.5/chatsvr/chat.php?intgroup=U0lBUFA=&intid=YWJyYXJoZWRhcg__&pref=user','','width=590,height=610,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src="http://183.91.67.5/chatsvr/image.php?id=01&type=inlay" width="120" height="30" border="0" alt="LiveZilla Live Help"></a><!-- http://www.LiveZilla.net  Chat Button Link Code -->
											</td>
										</tr>
									</table>
									
								</div>
								<div class="clr"></div>
							</div>
						<div class="b"><div class="b"><div class="b"></div></div></div>
  					</div><?php
					
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
												<fieldset id="treeview" style="width:175px;"><?php
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