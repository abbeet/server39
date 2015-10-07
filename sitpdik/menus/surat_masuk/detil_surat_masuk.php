<?php
checkauthentication();
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$q = ekstrak_get(@$get[1]);
	
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 

	$oEdit = mysql_query("SELECT * FROM suratmasuk WHERE NoSurat = '".$q."'") or die(mysql_error());

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

        <form id="example3" class="example"  name="frmAdministrator" method="post" action="surat_masuk_edit.php?id=<?=$_GET["id"]?>">
          <table class="admintable" cellspacing="1">
                  <tr>
                    <td class="key"><strong>Tanggal Surat</strong></td>
                    <td><input name="TglSurat" type="text" class="formAll" id="TglSurat" size="15" readonly="1" value="<?=ViewDateTimeFormat($TglSurat, 6 )?>"/>                   </td>
                  </tr>
                  <tr>
                    <td class="key"><strong>No. Surat</strong></td>
                    <td><input name="NoSurat" type="text" readonly="1" class="form" id="NoSurat" value="<?=$NoSurat?>" size="30"></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Diterima Tanggal</strong></td>
                    <td><input name="TglTerima" type="text" class="formAll" id="TglTerima" size="15" readonly="1" value="<?=ViewDateTimeFormat($TglTerima, 6)?>"/>                      </td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Asal Surat</strong></td>
                    <td><input name="AsalSurat" type="text"  readonly="1" class="form" id="AsalSurat" value="<?=$AsalSurat?>" size="30"></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Tujuan Surat</strong></td>
                    <td><input name="TujuanSurat" type="text" class="formAll" id="TujuanSurat" size="30" readonly="1" value="<?=$TujuanSurat?>"/></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Sifat Surat </strong></td>
                    <td width="72%"><input name="IdSifat" type="text" class="formAll" id="IdSifat" size="30" readonly="1" value="<?=GetSifatSurat($IdSifat)?>"/></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Kategori Surat </strong></td>
                    <td width="72%"><input name="IdKategori" type="text" class="formAll" id="IdKategori" size="30" readonly="1" value="<?=GetKategoriSurat($IdKategori)?>"/></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Klasifikasi Surat </strong></td>
                    <td width="72%"><input name="IdKlasifikasi" type="text" class="formAll" id="IdKlasifikasi" size="30" readonly="1" value="<?=GetKlasifikasiSurat($IdKlasifikasi)?>"/></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Lampiran</strong></td>
                    <td><input name="Lampiran" type="text" class="form" id="Lampiran" value="<?=$Lampiran?>" size="30" readonly="1" ></td>
                  </tr>
                  <tr>
                    <td class="key"><strong>File Upload </strong></td>
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
                    <td class="key"><strong>Retensi Surat</strong></td>
                    <td><input name="Retensi" type="text" class="form" id="Retensi" value="<?=$Retensi?>" size="20" readonly="1" >
                    </td>
                  </tr>
                  <tr>
                    <td class="key"><strong>Keterangan</strong></td>
                    <td><input name="Keterangan" type="text" class="form" id="Keterangan" value="<?=$Keterangan?>" size="100" readonly="1" ></td>
                  </tr>
                </table>
        </form>

