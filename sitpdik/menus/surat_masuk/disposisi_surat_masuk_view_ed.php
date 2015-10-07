<?php
checkauthentication();
	$table = "suratmasuk";
	$field = get_field($table);
	$p_ubahstatus = 29;
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	
	$q = ekstrak_get(@$get[1]);
	

		$TglSurat			= $_POST["TglSurat"];
		$NoSurat			= $_POST["NoSurat"];
		$TglTerima			= $_POST["TglTerima"];
		$AsalSurat	 		= $_POST["AsalSurat"];
		$Perihal			= trim($_POST["Perihal"]);
		$TujuanSurat		= $_POST["TujuanSurat"];
		$IdSifatSurat		= $_POST["IdSifatSurat"];
		$IdKategori			= $_POST["IdKategori"];
		$IdKlasifikasi		= $_POST["IdKlasifikasi"];
		$Lampiran			= $_POST["Lampiran"];
		$LokasiFile			= $_POST["LokasiFileOLD"];
		$Keterangan			= $_POST["Keterangan"];
		$Retensi			= $_POST["Retensi"];
		$n					= $_POST["n"];
		//$tl					= $_POST["tl"];
		$tl_status			= $_POST["tl_status"];
		$tglawal			= $_POST["date_from"];
		$tglakhir			= $_POST["date_until"];

	
if ($q != "") {
	$oEdit = mysql_query("SELECT * FROM suratmasuk WHERE IdSuratMasuk = '".$q."'") or die(mysql_error());

	if (mysql_num_rows($oEdit) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$Edit	= mysql_fetch_object($oEdit);
							$IdSifat 			= $Edit->IdSifat;
							$IdKategori			= $Edit->IdKategori;
							$IdKlasifikasi		= $Edit->IdKlasifikasi; 
							$TglTerima			= $Edit->TglTerima;
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
							$tl					= $Edit->tl;
							$tl_status			= $Edit->tl_status;
							$tglawal			= $Edit->tglawal;
							$tglakhir			= $Edit->tglakhir;
							$IdSuratMasuk		=$Edit->IdSuratMasuk;
			
					
			mysql_query("UPDATE suratmasuk SET 
							tl_status 			= '".$tl_status."'
							
							WHERE IdSuratMasuk = '".$IdSuratMasuk."'") or die(mysql_error());
					
			mysql_query("UPDATE suratmasuk SET 
							
							tglawal			= '".$tglawal."'
						
							
							WHERE IdSuratMasuk = '".$IdSuratMasuk."'") or die(mysql_error());	
							
			mysql_query("UPDATE suratmasuk SET 
							tglakhir		= '".$tglakhir."'
							
							WHERE IdSuratMasuk = '".$IdSuratMasuk."'") or die(mysql_error());		
							
			
	}
	
	echo $tl_status;
	//echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($p_next)."\">";
		//	exit();
}
	
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>User Edit - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
var halamanbaru;
function poptastic(url)
{
	halamanbaru=window.open(url,'Surat','height=600,width=800');
	if (window.focus) {halamanbaru.focus()}
}
</script>
<body>
<table class="admintable">
        <form name="ubahstatus" method="post" action="index.php?p=<?php echo enkripsi($p_ubahstatus); ?>">
                <tr> 
                  <td class="key"><strong>Tanggal Surat</strong></td>
                  <td> <input name="TglSurat" type="text" readonly  class="form" id="TglSurat" value="<?=ViewDateTimeFormat($TglSurat,6)?>" size="30"></td>
                </tr>
                <tr> 
                  <td class="key"><strong>No. Surat</strong></td>
                  <td><input name="NoSurat" type="text" readonly  class="form" id="NoSurat" value="<?=$NoSurat?>" size="50"></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Diterima Tanggal</strong></td>
                  <td> <input name="TglTerima" type="text" readonly  class="form" id="TglTerima" value="<?=ViewDateTimeFormat($TglTerima,6)?>" size="30"></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Asal Surat</strong></td>
                  <td><input name="AsalSurat" readonly type="text" class="form" id="AsalSurat" value="<?=$AsalSurat?>" size="50"></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Isi Ringkas</strong></td>
                  <td><textarea name="Perihal" cols="50" readonly id="Perihal" class="form"><?=$Perihal?></textarea></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Tujuan Surat</strong></td>
                  <td><input name="TujuanSurat" readonly type="text" class="form" id="TujuanSurat" value="<?=$TujuanSurat?>" size="50"></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Sifat Surat </strong></td>
                  <td width="72%"><input name="IdSifat" type="text" class="formAll" id="IdSifat" size="30" readonly value="<?=GetSifatSurat($IdSifat)?>"/></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Kategori Surat </strong></td>
                  <td width="72%"><input name="IdKategori" type="text" class="formAll" id="IdKategori" size="30" readonly value="<?=GetKategoriSurat($IdKategori)?>"/></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Klasifikasi Surat </strong></td>
                  <td width="72%"><input name="IdKlasifikasi" type="text" class="formAll" id="IdKlasifikasi" size="30" readonly value="<?=GetKlasifikasiSurat($IdKlasifikasi)?>"/></td>
                </tr>
                <tr> 
                  <td class="key"><strong>Lampiran</strong></td>
                  <td><input name="Lampiran" readonly type="text" class="form" id="Lampiran" value="<?=$Lampiran?>" size="50"></td>
                </tr>
                <tr> 
                  <td class="key"><strong>File Upload :</strong></td>
                  <td align="left" valign="top" class="fontred"> 
      
                    <?php
					$oFile = mysql_query("SELECT * FROM lokasifile WHERE NoSurat = '".$NoSurat."'") or die(mysql_error());
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
                    <a href="javascript:poptastic('/sitpdik/files/<?=$List->NamaFile?>');">
                	
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
                  <td class="key"><strong>Keterangan</strong></td>
                  <td><input name="Keterangan" readonly type="text" class="form" id="Keterangan" value="<?=$Keterangan?>" size="50"></td>
                </tr>
               
             <!--  <tr> 
                  <td class="key"><strong>Perlu Tindak Lanjut</strong></td>
                  <td>
                    <p>
                  <label>
                    <input type="radio" name="tl" value="1" <?php if ($tl == 1) echo "checked=\"checked\""; ?> id="yes" disabled>
                    Ya</label>
                 
                  <label>
                    <input type="radio" name="tl" value="0" <?php if ($tl == 0) echo "checked=\"checked\""; ?> id="no" disabled>
                    Tidak</label>
              
              </p>
                  </td>
                </tr>-->
                
                <tr> 
                  <td class="key"><strong>Status Tindak Lanjut</strong></td>
                  <td>
                    <p>
                  <label>
                    <input type="radio" name="tl_status" value="1" <?php if ($tl_status == 1) echo "checked=\"checked\""; ?> id="status1" >
                    Sudah</label>
                 
                  <label>
                    <input type="radio" name="tl_status" value="0" <?php if ($tl_status == 0) echo "checked=\"checked\""; ?> id="status2"  >
                    Belum</label>
                    
                      <input type="radio" name="tl_status" value="2" <?php if ($tl_status == 2) echo "checked=\"checked\""; ?> id="status2" >
                    Tidak Perlu Tindak Lanjut</label>
                  
                  </td>
                </tr>
                <tr> 
                  <td class="key"><strong>Tanggal Akhir Tindak Lanjut</strong></td>
                  <td>
                    <input name="date_from" type="text" class="form" id="date_from" size="10" value="<?=$tglawal?>"/>&nbsp;
                      <img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
	          <script type="text/javascript">
						Calendar.setup({
							inputField : "date_from",
							button : "a_triggerIMG",
							align : "BR",
							firstDay : 1,
							weekNumbers : false,
							singleClick : true,
							showOthers : true,
							ifFormat : "%Y-%m-%d"
						});
					</script>
	          
	          &nbsp; s.d &nbsp;
	          
	          <input name="date_until" type="text" class="form" id="date_until" size="10" value="<?=$tglakhir?>"/>&nbsp;
              <img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
	          <script type="text/javascript">
						Calendar.setup({
							inputField : "date_until",
							button : "b_triggerIMG",
							align : "BR",
							firstDay : 1,
							weekNumbers : false,
							singleClick : true,
							showOthers : true,
							ifFormat : "%Y-%m-%d"
						});
					</script>
	          
                  </td>
                </tr>
                
               
                <tr> 
                  <td width="26%" align="center" valign="top">&nbsp;</td>
                  <td colspan="2">
                  			
				<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo enkripsi($p_next); ?>')">Batal</a>
					</div>
				</div>
                <div class="button2-left">
					<div class="next">
						<a onClick="Btn_Submit('ubahstatus')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="Submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Submit" />
				<input type="hidden" name="ubahstatus" value="1" />
				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
                  
                  </td>
              </tr>
              
                  
      </form>
     <script type="text/javascript" language="JavaScript">
document.forms['ubahstatus'].elements['tl_status'].focus();
</script>    
</table>
</body>
</html>
