<?php
checkauthentication();

	$oEdit = mysql_query("SELECT * FROM suratkeluar WHERE NoSurat = '".$NoSurat."'") or die(mysql_error());

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

<table width="100%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="left" valign="top"><br>
   
        <form id="example3" class="example"  name="frmAdministrator" method="post" action="surat_keluar_edit.php?id=<?=$_GET["id"]?>">
          <table width="57%" border="0" align="center" cellpadding="3" cellspacing="1" class="datatable">
            <?php
				  if ($bError) {
				?>

            <?php
				  }
				?>
           
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr>
                    <td align="left" valign="top"><strong>Tanggal Surat</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="TglSurat" type="text" class="formAll" id="TglSurat" size="15" readonly="1" value="<?=ViewDateTimeFormat($TglSurat, 6 )?>"/>                   </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>No. Surat</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="NoSurat" type="text" readonly="1" class="form" id="NoSurat" value="<?=$NoSurat?>" size="30"></td>
                  </tr>
                  <!--
				  <tr>
                    <td align="left" valign="top"><strong>Diterima Tanggal</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="TglTerima" type="text" class="formAll" id="TglTerima" size="15" readonly="1" value="<?=ViewDateTimeFormat($TglTerima, 6)?>"/>                      </td>
                  </tr>
				  -->
                  <tr>
                    <td align="left" valign="top"><strong>Asal Surat</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="AsalSurat" type="text"  readonly="1" class="form" id="AsalSurat" value="<?=$AsalSurat?>" size="30"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>Tujuan Surat</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="TujuanSurat" type="text" class="formAll" id="TujuanSurat" size="30" readonly="1" value="<?=$TujuanSurat?>"/></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>Sifat Surat </strong></td>
                    <td width="2%" align="left" valign="top">:</td>
                    <td width="72%"><input name="IdSifat" type="text" class="formAll" id="IdSifat" size="30" readonly="1" value="<?=GetSifatSurat($IdSifat)?>"/></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>Kategori Surat </strong></td>
                    <td width="2%" align="left" valign="top">:</td>
                    <td width="72%"><input name="IdKategori" type="text" class="formAll" id="IdKategori" size="30" readonly="1" value="<?=GetKategoriSurat($IdKategori)?>"/></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>Klasifikasi Surat </strong></td>
                    <td width="2%" align="left" valign="top">:</td>
                    <td width="72%"><input name="IdKlasifikasi" type="text" class="formAll" id="IdKlasifikasi" size="30" readonly="1" value="<?=GetKlasifikasiSurat($IdKlasifikasi)?>"/></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>Lampiran</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="Lampiran" type="text" class="form" id="Lampiran" value="<?=$Lampiran?>" size="30" readonly="1" ></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>File Upload </strong></td>
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
                    <td align="left" valign="top"><strong>Retensi Surat</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="Retensi" type="text" class="form" id="Retensi" value="<?=$Retensi?>" size="20" readonly="1" >
                      Hari </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><strong>Keterangan</strong></td>
                    <td align="left" valign="top">:</td>
                    <td><input name="Keterangan" type="text" class="form" id="Keterangan" value="<?=$Keterangan?>" size="30" readonly="1" ></td>
                  </tr>
                 
               
                </table>
                  <br>              </td>
            </tr>
          </table>
        </form>
	 
        <p>&nbsp;</p></td>
  </tr>
</table>

