<?php
checkauthentication();

	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$adddisposisi = 96;
	$disposisilist = 93;
	$kotaksuratlist = 27;

	$q = ekstrak_get(@$get[1]);
	$id = ekstrak_get(@$get[2]);
	$NoSurat = ekstrak_get(@$get[3]);
	$Perihal = ekstrak_get(@$get[4]);
	$BeritaFlag = ekstrak_get(@$get[5]);
	$StatusDisposisi = ekstrak_get(@$get[6]);

$xlevel = @$_SESSION['xlevel_'.$session_name];
$IdUser = @$_SESSION['v_xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 


date_default_timezone_set('Asia/Jakarta');
//$Perihal			=$_GET["Perihal"];
//$NoSurat			=$_GET["NoSurat"];
//$id					=$_GET["Id"];
//$BeritaFlag			=$_GET["BeritaFlag"];


function GetName($id) {
	global $Tb_User;

	$oGet	= mysql_query("SELECT IdSuratMasuk, NoSurat FROM suratmasuk WHERE IdSuratMasuk = '".$id."'") or die(mysql_error());

	if ($Get = mysql_fetch_object($oGet)) {
		return $Get->NoSurat;
	}
}


if ($_POST["Submit"]) {
			
	 		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($adddisposisi."&q=".$id[$i]."&id=".$q."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi)."\">";
			
			 
			exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Disposisi Surat - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/global.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/global.js"></script>
</head>

<body>
<table width="100%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="left" valign="top"><br>
        <form name="frmAdministrator" method="post" action="">
          <input type="hidden" name="id" value="<?php echo $q;?>">
          <input readonly="1" name="Perihal" type="hidden" class="formAll" id="Perihal" size="100"  value="<?=$Perihal?>"/>
          <input   name="NoSurat"  type="hidden" class="formAll" id="NoSurat" size="100" readonly value="<?=$NoSurat?>"/>
          <input readonly="1" name="BeritaFlag"  type="hidden" class="formAll" id="BeritaFlag" size="100"  value="<?=$BeritaFlag?>"/>

		  <p>&nbsp;</p>
          <p align="center"><strong>Apakah anda ingin mendisposisikan lagi Surat Masuk dengan No. Surat '<span class="fontred">
            <?=$NoSurat?>
          </span>' ?</strong></p>
          <p align="center">
            <input name="Submit" type="submit" class="button" value="Yes">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
			
            if ($BeritaFlag == "1") {
			?>
			<input name="BnNo" type="button" class="button" id="BnNo" value="No" onClick="location.href='index.php?p=<?php echo enkripsi($kotaksuratlist); ?>'">
            
			<?php
            } else {
			?>
            <input name="BnNo" type="button" class="button" id="BnNo" value="No" onClick="location.href='index.php?p=<?php echo enkripsi($disposisilist); ?>'">
			
            <?php
            }
			?>
          
          </p>
          <p>&nbsp; </p>
          <p>&nbsp; </p>
        </form>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
