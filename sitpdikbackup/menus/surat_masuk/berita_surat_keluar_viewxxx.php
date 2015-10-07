<?php
checkauthentication();

	$table = "suratkeluar";
	$field = get_field($table);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
	$q = ekstrak_get(@$get[1]);

if ($_POST["Submit"]) {
	$TglSurat			= $_POST["TglSurat"];
	$NoSurat			= $_POST["NoSurat"];
	$TglTerima			= $_POST["TglTerima"];
	$AsalSurat	 		= $_POST["AsalSurat"];
	$Perihal			= $_POST["Perihal"];
	$TujuanSurat		= $_POST["TujuanSurat"];
  	$IdSifatSurat		= $_POST["IdSifatSurat"];
	$IdKategoriSurat	= $_POST["IdKategoriSurat"];
	$IdKlasifikasiSurat	= $_POST["IdKlasifikasiSurat"];
	$Lampiran			= $_POST["Lampiran"];
	$LokasiFile			= $_POST["LokasiFile"];
	$Keterangan			= $_POST["Keterangan"];


	


	if ($AsalSurat == "") {
		$bError		 = true;
		$sMessage	.= ". Masukkan Asal Surat dengan benar<br />";
	}
	
	if ($Perihal == "") {
		$bError		 = true;
		$sMessage	 .= ". Masukkan Perihal dengan benar<br />";
	}
	if ($IdSifatSurat == "") {
		$bError		 = true;
		$sMessage	 .= ". Pilih Sifat Surat dengan benar<br />";
	}
	if ($IdKategoriSurat == "") {
		$bError		 = true;
		$sMessage	 .= ". Pilih Kategori Surat dengan benar<br />";
	}
	if ($IdKlasifikasiSurat == "") {
		$bError		 = true;
		$sMessage	 .= ". Pilih Klasifikasi Surat dengan benar<br />";
	}
	

	if ($bError != true) {
		if ($_GET["id"] == "") {
			/* ADD NEW
			*/
			mysql_query("INSERT INTO suratkeluar( IdSifat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Disposisi, Retensi, LokasiFile, Keterangan) 
								  VALUES ('".$IdSifatSurat."', '".$IdKategoriSurat."', 
								  		  '".$IdKlasifikasiSurat."', '".$TglTerima."', '".$NoSurat."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihal."', 
										  '".$Lampiran."', '".$TujuanSurat."', '".$Disposisi."',
										  '".$Retensi."', '".$LokasiFile."', '".$Keterangan."')");

			//echo "<meta http-equiv=\"refresh\" content=\"0;URL=update_success.php?act=add_surat_masuk\">";
			exit();
		} else {
			// UPDATE
				mysql_query("UPDATE suratkeluar SET 
							IdSifat 			= '".$IdSifat."',
							IdKategori			= '".$IdKategori."',
							IdKlasifikasi		= '".$IdKlasifikasi."', 
							TglTerima			= '".$TglTerima."',
							NoSurat				= '".$NoSurat."', 
							TglSurat			= '".$TglSurat."', 
							AsalSurat			= '".$AsalSurat."', 
							Perihal				= '".$Perihal."', 
							Lampiran			= '".$Lampiran."', 
							TujuanSurat			= '".$TujuanSurat."', 
							Retensi				= '".$Retensi."', 
							LokasiFile			= '".$LokasiFile."', 
							TujuanSurat			= '".$TujuanSurat."', 
							Keterangan			= '".Keterangan."'
							WHERE IdSuratKeluar = '".$_GET["id"]."'") or die(mysql_error());
				//echo "<meta http-equiv=\"refresh\" content=\"0;URL=update_success.php?act=update_user\">";
				exit();
			
		}
	}
} else if ($_GET["id"] != "") {
	$oEdit = mysql_query("SELECT * FROM suratkeluar WHERE NoSurat = '".$_GET["id"]."'") or die(mysql_error());

	if (mysql_num_rows($oEdit) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$Edit	= mysql_fetch_object($oEdit);
							$IdSifat 			= $Edit->IdSifat;
							$IdKategori			= $Edit->IdKategori;
							$IdKlasifikasi		= $Edit->IdKlasifikasi; 
							$TglTerima			= date( "Y-m-d");
							$NoSurat			= $Edit->NoSurat; 
							$TglSurat			= $Edit->TglSurat; 
							$AsalSurat			= $Edit->AsalSurat; 
							$Perihal			= $Edit->Perihal; 
							$Lampiran			= $Edit->Lampiran; 
							$TujuanSurat		= $Edit->TujuanSurat;
							$Retensi			= $Edit->Retensi; 
							$LokasiFile			= $Edit->LokasiFile; 
							$TujuanSurat		= $Edit->TujuanSurat; 
							$Keterangan			= $Edit->Keterangan;
	}
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>User Edit - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="calendar/skins/aqua/theme.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/global.js"></script></head>
<script language="JavaScript" src="calendar/calendar.js"></script>
<script language="JavaScript" src="calendar/lang/calendar-en.js"></script>
<script language="JavaScript" src="calendar/calendar-setup.js"></script>
<script>
var halamanbaru;
function poptastic(url)
{
	halamanbaru=window.open(url,'Surat','height=600,width=800');
	if (window.focus) {halamanbaru.focus()}
}
</script>
<body>
<table width="100%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="left" valign="top"><br>
    
        <form name="frmAdministrator" method="post" action="surat_keluar_edit.php?id=<?=$_GET["id"]?>">
          <table width="57%" border="0" align="center" cellpadding="3" cellspacing="1" class="datatable">
            <?php
				  if ($bError) {
				?>
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td align="left" valign="top" class="errorstatus"><img src="images/icons/error.gif" alt="" width="16" height="16" border="0" align="absmiddle" hspace="3" vspace="3"><strong>Error Message(s) :</strong><br />
                  <br />
                  <?=$sMessage?>
              </td>
            </tr>
            
            <?php
				  }
				?>
            <tr>
        		<td background="images/glossyback2.gif" align="center" colspan="2"><p><span class="titlepage">:: 
                Lihat Surat Keluar ::</span> </p></td>
        	</tr>
            <tr>
            	
            <td colspan="2"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                <tr> 
                  <td align="left" valign="top"><strong>Tanggal Surat</strong></td>
                  <td align="left" valign="top">:</td>
                  <td> <input name="TglSurat" type="text" readonly="1"  class="form" id="TglSurat" value="<?=ViewDateTimeFormat($TglSurat,6)?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"> 
                  </td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>No. Surat</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><input name="NoSurat" type="text" readonly="1"  class="form" id="NoSurat" value="<?=$NoSurat?>" size="30"> 
                      <input name="idberita" type="hidden" class="form" id="idberita" value="<?=$_GET["idberita"]?>" size="30">
					<img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Diterima Tanggal</strong></td>
                  <td align="left" valign="top">:</td>
                  <td> <input name="TglTerima" type="text" readonly="1"  class="form" id="TglTerima" value="<?=ViewDateTimeFormat($TglTerima,6)?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"> 
                  </td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Asal Surat</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><input name="AsalSurat" readonly="1" type="text" class="form" id="AsalSurat" value="<?=$AsalSurat?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Isi Ringkas</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><textarea name="Perihal" cols="50" readonly="1" id="Perihal" class="form"><?=$Perihal?></textarea> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Tujuan Surat</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><input name="TujuanSurat" readonly="1" type="text" class="form" id="TujuanSurat" value="<?=$TujuanSurat?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Sifat Surat </strong></td>
                  <td width="2%" align="left" valign="top">:</td>
                  <td width="72%"><input name="IdSifat" type="text" class="formAll" id="IdSifat" size="30" readonly="1" value="<?=GetSifatSurat($IdSifat)?>"/>
                  <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Kategori Surat </strong></td>
                  <td width="2%" align="left" valign="top">:</td>
                  <td width="72%"><input name="IdKategori" type="text" class="formAll" id="IdKategori" size="30" readonly="1" value="<?=GetKategoriSurat($IdKategori)?>"/>
                  <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Klasifikasi Surat </strong></td>
                  <td width="2%" align="left" valign="top">:</td>
                  <td width="72%"><input name="IdKlasifikasi" type="text" class="formAll" id="IdKlasifikasi" size="30" readonly="1" value="<?=GetKlasifikasiSurat($IdKlasifikasi)?>"/>
                  <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Lampiran</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><input name="Lampiran" readonly="1" type="text" class="form" id="Lampiran" value="<?=$Lampiran?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>File Upload :</strong></td>
                  <td align="left" valign="top">:</td>
                  <td align="left" valign="top" class="fontred"> 
      
                    <?php
					$oFile = mysql_query("SELECT * FROM $Tb_File_Masuk WHERE NoSurat = '".$NoSurat."'") or die(mysql_error());
					if (mysql_num_rows($oFile) == 0) {
                  	?>
              		<tr align="center" bgcolor="#FFFFFF">
                		<td class="fontred"><strong>[No Data Found]</strong></td>
              		</tr>
              		<?php
                    } else {
                        $i	= 1;
                         while($List = mysql_fetch_object($oFile)) {
                    ?>
                    <a href="javascript:poptastic('/sitpbatan/files/<?=$List->NamaFile?>');">
                	
                  	<?=$i?>
                	.
                  	<?=$List->NamaFile;?>
				  	</a><br />
				  	<?php
                	$i++;
                        }
                  	}
					?>
                  
                  </td>
                </tr>
                <tr> 
                  <td align="left" valign="top"><strong>Keterangan</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><input name="Keterangan" readonly="1" type="text" class="form" id="Keterangan" value="<?=$Keterangan?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td colspan="3" align="left" valign="top"><hr align="center" width="100%"></td>
                </tr>
                <tr> 
                  <td width="26%" align="center" valign="top">&nbsp;</td>
                  <td colspan="2">
                  <?php 
				  if ($_SESSION['MM__AdminRole'] == 5) {
                  	?>
                  <!-- <input name="Distribusi" type="button" class="button" id="Distribusi" value="Distribusi" onClick="location.href='distribusi_add.php?ID=<?=$_GET["id"]?>&NoSurat=<?=$NoSurat?>&Perihal=<?=$Perihal?>'">-->
                  <?php
				  } else {
				  ?>
                  <input name="Diposisi" type="button" class="button" id="Disposisi" value="Disposisi" onClick="location.href='disposisi_add.php?ID=<?=$_GET["id"]?>&NoSurat=<?=$NoSurat?>&Perihal=<?=$Perihal?>'">
                  <?php
				  }
				  ?>
                  <input name="Back" type="button" class="button" id="Back" value="Back" onClick="location.href='berita_masuk_list.php?pg=<?=$newpg?>'">
				  <input name="CatatSuratMasuk" type="button" class="button" id="CatatSuratMasuk" value="Catat Surat Masuk" onClick="location.href='berita_surat_masuk_edit.php?ID=<?=$_GET["id"]?>&idberita=<?=$_GET["idberita"]?>&NoSurat=<?=$NoSurat?>&Perihal=<?=$Perihal?>'">
				</td>
                </tr>
              </table></td>
              </tr>
              </table>
                  
      </form>
        <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
