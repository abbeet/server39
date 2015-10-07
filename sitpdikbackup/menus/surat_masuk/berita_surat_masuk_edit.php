<?php
checkauthentication();
	$table = "suratmasuk";
	$field = get_field($table);
	$addlink = 95;
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
	$q = ekstrak_get(@$get[1]);
	
date_default_timezone_set('Asia/Jakarta');

//if (@$_POST['beritasuratkeluar']) {
	$TglSurat			= $_POST["TglSurat"];
	$NoSurat			= $_POST["NoSurat"];
	$TglTerima			= $_POST["TglTerima"];
	$AsalSurat	 		= $_POST["AsalSurat"];
	$Perihal			= trim($_POST["Perihal"]);
	$TglTerima			= date( "Y-m-d");
	$TujuanSurat		= $_POST["TujuanSurat"];
  	$IdSifatSurat		= $_POST["IdSifatSurat"];
	$IdKategori			= $_POST["IdKategori"];
	$IdBerita			= $_POST["IdBerita"];
	$IdKlasifikasi		= $_POST["IdKlasifikasi"];
	$Lampiran			= $_POST["Lampiran"];
	$LokasiFile			= $_POST["LokasiFileOLD"];
	$Keterangan			= $_POST["Keterangan"];
	$Retensi			= $_POST["Retensi"];
	$DicatatOleh		= @$_SESSION['xunit_'.$session_name];
	$IdUser				= $susername;
	$Disposisi			= "Surat baru ditambahkan pada " . date( " d F Y  H:i:s");

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
	if ($IdKategori == "") {
		$bError		 = true;
		$sMessage	 .= ". Pilih Kategori Surat dengan benar<br />";
	}
	if ($IdKlasifikasi == "") {
		$bError		 = true;
		$sMessage	 .= ". Pilih Klasifikasi Surat dengan benar<br />";
	}
	

	if ($bError != true) {

		if ($q == "") {
			/* ADD NEW
			*/
			
	//$no=0; 
    //$exis_no=''; 
    $query='SELECT MAX(NoUrut)  as max_NoUrut, TglTerima FROM suratmasuk WHERE UserBuat = $IdUser AND date_format(TglTerima,"%Y")like date_format(now(),"%Y")'; 
    if($res=mysql_query($query)){ 
        if ($row=mysql_fetch_array($res)){ 
            $no=$row['max_NoUrut'];
			$exis_no=$no+1;
        } 
        mysql_free_result($res); 
    } else {
		$exis_no = 0;
		}
     
			if ($IdKategori=="00"){
			mysql_query("INSERT INTO suratmasuk( IdSifat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Disposisi,                         Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat, StatusDisposisi) 
								  VALUES ('".$IdSifatSurat."', '".$IdKategori."', 
								  		  '".$IdKlasifikasi."', now(), '".$NoSurat."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihal."', 
										  '".$Lampiran."', '".$TujuanSurat."', '".$Disposisi."',
										  '".$Retensi."', '".$Keterangan."', '".$DicatatOleh."', '".$exis_no."','".$IdUser."', 1)") or  die(mysql_error());
			} else {
			mysql_query("INSERT INTO suratmasuk( IdSifat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Disposisi, 					                         Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat) 
								  VALUES ('".$IdSifatSurat."', '".$IdKategori."', 
								  		  '".$IdKlasifikasi."', now(), '".$NoSurat."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihal."', 
										  '".$Lampiran."', '".$TujuanSurat."', '".$Disposisi."',
										  '".$Retensi."', '".$Keterangan."', '".$DicatatOleh."', '".$exis_no."','".$IdUser."')") or  die(mysql_error());
			}							  

			$oEdit5 = mysql_query("SELECT * FROM berita WHERE IdBerita = '".$IdBerita."'") or die(mysql_error());

	if (mysql_num_rows($oEdit5) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$Edit	= mysql_fetch_object($oEdit5);
							$IdBerita 			= $Edit->IdBerita;
							$Perihal			= $Edit->Perihal;
							$Isi				= $Edit->Isi; 
							$Pengirim			= $Edit->Pengirim;
							$WaktuKirim			= $Edit->WaktuKirim; 
							$Penerima			= $Edit->Penerima; 
							$WaktuBaca			= $Edit->WaktuBaca; 
							$NoSurat			= $Edit->NoSurat; 
							$StatusBerita		= $Edit->StatusBerita; 
							$StatusDisposisi	= $Edit->StatusDisposisi; 
	
			if ($WaktuBaca == "0000-00-00 00:00:00") { 
			mysql_query("UPDATE berita SET 
							StatusBerita		= '1',
							WaktuBaca			= now()
							WHERE IdBerita = '".$IdBerita."'") or die(mysql_error());


			mysql_query("UPDATE status_surat_keluar SET 
							StatusBerita		= '1',
							WaktuBaca			= now()
							WHERE NoSurat ='$NoSurat' and Penerima='$IdUser' ") or die(mysql_error());

			
			$Disposisi = "Terakhir dibaca oleh " . $susername . " pada " . date( " d F Y  H:i:s");

							
			mysql_query("UPDATE suratkeluar SET 
							Disposisi		= '".$Disposisi ."' 
							WHERE NoSurat = '".$NoSurat."'") or die(mysql_error());
		  } 					
		}
				

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($p_next)."\">";
			exit();
		} 
	}

?>

<form id="example3" class="example"  name="frmAdministrator" method="post" action="index.php?p=<?php echo enkripsi($addlink); ?>">
<table class="admintable" cellspacing="1">
            <tr>
            <td colspan="2"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Tanggal Surat</strong></td>
                  <td><input name="TglSurat" type="text" class="formAll" id="TglSurat" size="15" readonly="1" value="<?=$TglSurat?>"/> 
                  <input name="IdBerita" type="hidden" class="formAll" id="IdBerita" size="15" readonly="1" value="<?=$IdBerita?>"/> 
                    </td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>No. Surat</strong></td>
                  <td><input name="NoSurat" type="text" class="form" id="NoSurat" readonly="1" value="<?=$NoSurat?>" size="30"></td>
                </tr>
				<tr> 
                  <td align="left" valign="top" class="key"><strong>Diterima Tanggal</strong></td>
                  <td><input name="TglTerima" type="text" class="formAll" id="TglTerima" size="15" readonly="1" value="<?=$TglTerima?>"/> 
                    </td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Asal Surat</strong></td>
                  <td><input name="AsalSurat" type="text" class="form" id="AsalSurat" readonly="1"  value="<?=$AsalSurat?>" size="30"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Perihal</strong></td>
                  <td><textarea readonly="1" name="Perihal" cols="50" id="Perihal" class="form"><?=$Perihal?></textarea></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Tujuan Surat</strong></td>
                  <td><input name="TujuanSurat" type="text" class="form" id="TujuanSurat" value="<?=$TujuanSurat?>" size="100"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Sifat Surat </strong></td>
                  <td width="72%"> 
                    <?php 
										
					echo "<select class='form' size=\"1\" name=\"IdSifatSurat\" >\n";
					//Buka table 
					$perintah="SELECT IdSifat,NmSifat FROM sifatsurat ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	if ($IdSifat == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdSifat]==$IdSifatSurat) {
					echo "<OPTION VALUE='".$rows[IdSifat]."'selected>".$rows[NmSifat]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdSifat]."'>".$rows[NmSifat]."</OPTION>";
					}
					}
					echo "</select>";
				?></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Kategori Surat </strong></td>
                  <td width="72%"> 
                    <?php 
					echo "<select class='form' size=\"1\" name=\"IdKategori\" >\n";
					//Buka table 
					$perintah="SELECT IdKategori,NmKategori FROM kategorisurat ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	if ($IdKategori == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdKategori]==$IdKategori) {
					echo "<OPTION VALUE='".$rows[IdKategori]."'selected>".$rows[NmKategori]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdKategori]."'>".$rows[NmKategori]."</OPTION>";
					}
					}
					echo "</select>";
				
				?></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Klasifikasi Surat </strong></td>
                  <td width="72%"> 
                    <?php 
										
					echo "<select class='form' size=\"1\" name=\"IdKlasifikasi\" >\n";
					//Buka table 
					$perintah="SELECT IdKlasifikasi,NmKlasifikasi FROM klasifikasisurat ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	if ($IdKlasifikasi == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdKlasifikasi]==$IdKlasifikasi) {
					echo "<OPTION VALUE='".$rows[IdKlasifikasi]."'selected>".$rows[NmKlasifikasi]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdKlasifikasi]."'>".$rows[NmKlasifikasi]."</OPTION>";
					}
					}
					echo "</select>";
					
				?></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Lampiran</strong></td>
                  <td><input name="Lampiran" readonly="1" type="text" class="form" id="Lampiran" value="<?=$Lampiran?>" size="30"></td>
                </tr>
                 <tr>  
                  <td align="left" valign="top" class="key"><strong>Retensi Surat</strong></td>
                  <td><input name="Retensi" type="text" class="formAll" id="Retensi" size="15" readonly="1" value="<?=$retensi?>"/> 
                    &nbsp;<img src="images/icons/icon_Calendar.gif" id="triggerIMG3" width="20" height="20" hspace="5" title="Tanggal Terima Surat" onMouseOver="this.style.background='red';" onMouseOut="this.style.background=''" /><img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"> 
                    <script type="text/javascript">
						  	Calendar.setup({
								inputField		: "Retensi",
								
								button			: "triggerIMG3",
								align			: "BR",
								firstDay		: 1,
								weekNumbers		: false,
								singleClick		: true,
								showOthers		: true
							});
						  </script></td>
                </tr> 
                <!--<tr> 
                <tr> 
                  <td align="left" valign="top"><strong>File Upload :</strong></td>
                  <td align="left" valign="top">:</td>
                  <td align="left" valign="top" class="fontred"> 
                  
                  	<fieldset style="border: 1px solid #CDCDCD; padding: 0px; padding-bottom:0px; margin: 0px 0">
					<legend><strong>Silahkan pilih File yang akan di Upload</strong></legend>
					<div id="fileUploadstyle">Ada masalah dengan javascript</div>
					
					<p><a href="javascript:$('#fileUploadstyle').uploadifyUpload()">Upload</a> |  <a href="javascript:$('#fileUploadstyle').uploadifyClearQueue()">Hapus</a>
				    </p>
                  	</fieldset>
                  
                  </td>
                </tr>
				 
                  <td align="left" valign="top"><strong>Retensi Surat</strong></td>
                  <td align="left" valign="top">:</td>
                  <td><input name="Retensi" type="text" class="form" id="Retensi" value="<?=$Retensi?>" size="20">
                    Hari <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr> -->
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Keteranganx</strong></td>
                  <td><input name="Keterangan" type="text" class="form" id="Keterangan" value="<?=$Keterangan?>" size="50"></td>
                </tr>
                
                <tr> 
                  <td width="26%" align="center" valign="top">&nbsp;</td>
                  <td colspan="2">
                  <div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo enkripsi($p_next); ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="Btn_Submit('frmAdministrator')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
                <input type="hidden" name="lokasifile" value="1" />
                  </td>
                </tr>
              </table>
              <br>
            </td>
              </tr>
              </table>
                  
      </form>
	 <script type="text/javascript" language="JavaScript">
document.forms['example3'].elements['TujuanSurat'].focus();
</script>
 
