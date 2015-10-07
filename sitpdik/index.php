<?php
	include_once "includes/includes.php";
	checkauthentication();
	$session_name = "Kh41r4";
	$p = @$_GET['p'];
	
	$dekripsi = dekripsi($p);
	$get = explode("&", $dekripsi);
	
	$p = $get[0];
	
	$errmsg = @$_SESSION['errmsg'];
	$slevel = @$_SESSION['xlevel_'.$session_name];
	$susername = @$_SESSION['xusername_'.$session_name];
	$snama = @$_SESSION['xnama_'.$session_name];
	$sunit = @$_SESSION['xunit_'.$session_name];
	$title = get_title();
	$version = get_version();
	$copyright = get_copyright();
	
	
	$q = ekstrak_get(@$get[1]);
	$id = ekstrak_get(@$get[2]);
	$NoSurat = ekstrak_get(@$get[3]);
	$Perihal = ekstrak_get(@$get[4]);
	$BeritaFlag = ekstrak_get(@$get[5]);
	$StatusDisposisi = ekstrak_get(@$get[6]);
$kotaksuratlist = 27;

$xlevel = @$_SESSION['xlevel_'.$session_name];
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 

?>

<html id="minwidth">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="robots" content="">
		<meta name="keywords" content="">
		<meta name="description" content="m">
		<meta name="generator" content="">
		<title><?php echo $title; ?></title>
		<link href="css/images/webicon.ico" rel="shortcut icon" type="image/x-icon">
		<?php 
		
		include "includes/head.php"; ?>
		
	</head>
	<body id="minwidth-body">
		<div id="border-top" class="h_green">
			<div>
				<div><!--span class="version"><?php #echo $version ?></span--></div>
			</div>
		</div>
		<div id="header-box">
			<div id="module-status">
				<span class="loggedin-users">Selamat datang, <b><?php echo $snama; ?></b></span>
                
                <span class="inbox">
                <a href="index.php?p=<?php echo enkripsi($kotaksuratlist); ?>"><img src="images/message_outbox.gif" width="23" height="20" border="0">
              <font color="#FF0000">
				<?php 
//menghitung jumlah email baru
				$query = "select count(NoSurat) as hitung from berita where Penerima='".$susername."' AND WaktuBaca = '0000-00-00 00:00:00'"; 
	 			$result = mysql_query($query) or die(mysql_error());

// hasilnya
				while($row = mysql_fetch_array($result)){
				echo "(". $row['hitung'] .")";
				
				}

				?></font>
                </span></a>
				
                <span class="logout"><a href="includes/logout.php?u=<?php echo $susername; ?>">Logout</a></span>
			</div><?php
			
			if (is_published("topmenu"))
			{ ?>
				
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
								<div class="toolbar" id="toolbar"></div><?php 
								
								$sql = sql_select("xmenu m, xmenulevel ml", "m.id, m.title, m.parent, m.src", "m.id = '".$p."' AND ml.level ='".$slevel."'");
								$omenu = mysql_query($sql) or die(mysql_error());
								$nmenu = mysql_num_rows($omenu);
								$xmenu = mysql_fetch_array($omenu); ?>
								
								<div class="header icon-48-generic">
									<table width="100%">
										<tr>
											<td>
												<div class="header"><?php 
													
													if ($p == "") echo "Beranda";
													else
													{
														if ($nmenu > 0) echo $xmenu['title'];
														else echo "&nbsp;";
													} ?>
                                                    
                                                </div>
									
											</td>
										</tr>
									</table>
								</div>
								<div class="clr"></div>
							</div>
						<div class="b"><div class="b"><div class="b"></div></div></div>
  					</div><?php
					
					if (isset($errmsg))
					{ ?>
						
                        <dl id="system-message">
							<dt class="message">Error</dt>
							<dd class="message message fade">
								<ul>
									<li><?php echo $errmsg; unset($_SESSION['errmsg']); ?></li>
								</ul>
							</dd>
						</dl><?php
					
					}
					
					if (is_published("submenu"))
					{ ?>
						
                        <div id="submenu-box">
							<div class="t"><div class="t"><div class="t"></div></div></div>
								<div class="m">				
									<ul id="submenu"><?php
										
										if ($xmenu['parent'] != "")
										{
											$parent = $xmenu['parent'];
											$id = $xmenu['id'];
											$link = "";
											
											while ($parent != "")
											{
												$omenu2 = xmenu("id, name, parent, src", "id = '".$id."'");
												$xmenu2 = mysql_fetch_array($omenu2);
												
												if ($xmenu2['parent'] != "")
												{
													
													$link = "<li><a href=\"index.php?p=".enkripsi($xmenu2['id'])."\">".$xmenu2['name']."</a></li>".$link;
												
												}
												else
												{
													
                                                    $link = "<li><a href=\"index.php\">".$xmenu2['name']."</a></li>".$link;
												
												}
												
												$parent = $xmenu2['parent'];
												$id = $xmenu2['parent'];
												
											}
											
											echo $link;
										}
										else echo "&nbsp;"; ?>
										
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
									
										if (is_published("leftmenu"))
										{ ?>
											
                                            <td width="20px">
												<fieldset id="treeview" style="width:185px;"><?php
													
													include "includes/leftmenu.php"; ?>
												
                                                </fieldset>
											</td><?php
										
										} ?>
										
										<td>
											<fieldset style="min-height:280px;"><?php
												
												if ($p == "") include "includes/home.php";
												else 
												{	
													if ($nmenu > 0)
													{
														if ($xmenu['src'] != "") include $xmenu['src'];
														else include "includes/home.php";
													}
													else
													{ ?>
																			
                                                        <dl id="system-message">
                                                            <dt class="message">Error</dt>
                                                            <dd class="message message fade">
                                                                <ul>
                                                                    <li>Anda tidak berhak membuka halaman ini!</li>
                                                                </ul>
                                                            </dd>
                                                        </dl><?php
													
													}
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
			<p class="copyright"><?php echo $copyright; ?></p>
		</div>
		<div style="display: none; z-index: 65555; position: fixed; top: 0px; left: 0px; visibility: hidden; opacity: 0;" id="sbox-overlay"></div>
		<div style="display: none; z-index: 65557; position: fixed; top: 50%; left: 50%;" id="sbox-window">
			<a href="#" id="sbox-btn-close"></a>
			<div style="visibility: hidden; opacity: 0;" id="sbox-content"></div>
		</div>
	</body>
</html>