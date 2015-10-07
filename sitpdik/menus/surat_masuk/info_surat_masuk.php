<?php
checkauthentication();
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$q = ekstrak_get(@$get[1]);
	
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 

	$oEdit = mysql_query("SELECT * FROM suratmasuk WHERE NoSurat = '".$NoSurat."' and DicatatOleh = '$KdSatker' ") or die(mysql_error());

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
	}

?>
<script>
var halamanbaru;
function poptastic(url)
{
	halamanbaru=window.open(url,'Surat','height=600,width=800');
	if (window.focus) {halamanbaru.focus()}
}
</script>

<table class="admintable" cellspacing="1">
                <tr> 
                  <td align="justify" valign="top" class="key"><div align="right"><strong>Pengirim</strong></div></td>
                  <td> <input name="Pengirim" type="text" readonly  class="form" id="Pengirim" value="<?php echo GetNama($Pengirim);?>" size="30">
                  </td>
                </tr>
                <tr> 
                  <td align="justify" valign="top" class="key"><div align="right"><strong>Tanggal Kirim</strong></div></td>
                  <td><input name="WaktuKirim" type="text" readonly  class="form" id="WaktuKirim" value="<?=ViewDateTimeFormat($WaktuKirim, 2)?>" size="30">
                  </td>
                </tr>
                <tr> 
                  <td align="justify" valign="top" class="key"><div align="right"><strong>Perihal</strong></div></td>
                  <td> <input name="Perihal" type="text" readonly  class="form" id="Perihal" value="<?=$Perihal?>" size="100">
                  </td>
                </tr>
                <tr> 
                  <td height="105" align="justify" valign="top" class="key"><div align="right"><strong>Isi Berita</strong></div></td>
                  <td><textarea name="Isi" cols="100" rows="10" readonly class="form" id="Isi"><?php  echo $Isi ?></textarea>
                  </td>
                </tr>
                 <tr> 
                  <td align="justify" valign="top" class="key"><div align="right"><strong>File Attachment</strong></div></td>
                  <td class="fontred"> 
                   <?php
					$oFile = mysql_query("SELECT * FROM lokasifile WHERE NoSurat = '".$NoSurat."'") or die(mysql_error());
					if (mysql_num_rows($oFile) == 0) {
                  	?>
              	<strong>[No Data Found]</strong>
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
</table>

