<?php
checkauthentication();

	$table = "suratkeluar";
	$field = get_field($table);
	$addlink = 95;
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
	$q = ekstrak_get(@$get[1]);
	$r = ekstrak_get(@$get[2]);
	//echo $q;
	
		$olist = mysql_query("SELECT * FROM suratkeluar WHERE NoSurat = '".$q."'") or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		while ($list = mysql_fetch_array($olist))
			{
				$tgl 		= $list['TglSurat'];
				$nosurat	= $list['NoSurat'];
				$asal		= $list['AsalSurat'];
				$perihal	= $list['Perihal'];
				$tujuan 	= $list['TujuanSurat'];
				$sifat 		= $list['IdSifat'];
				$kategori	= $list['IdKategori'];
				$klasifikasi= $list['IdKlasifikasi'];
				$lampiran	= $list['Lampiran'];
				$keterangan	= $list['Keterangan'];
				$asal		= $list['AsalSurat'];
				
				
			}
			
?>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>jQuery UI Tabs - Default functionality</title>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
</head>
<body>

<form method="post" name="beritasuratkeluar" enctype="multipart/form-data" action="index.php?p=<?php echo enkripsi($addlink."&q=".$nosurat[$i]); ?>">
 <table class="admintable" cellspacing="1">
	      
	     
	      <tr>
	        <td class="key">Tanggal Surat</td>
	        <td>
	             <input name="TglSurat" type="text" class="form" id="TglSurat" size="10" readonly value="<?php echo $tgl;?>"/> <input name="IdBerita" type="hidden" class="form" id="IdBerita" size="10" readonly value="<?php echo $r;?>"/></td>
	        </tr>
	      
	      <tr>
	        <td class="key">No.Surat</td>
	        <td>
	          <input name="NoSurat" type="text" class="formAll" id="NoSurat" size="50" readonly value="<?php echo $nosurat;?>"/>	          </td>
	        </tr>
	      
          <tr>
	        <td class="key">Asal Surat</td>
	        <td>
	       <input name="AsalSurat" type="text" class="formAll" id="AsalSurat" size="50" readonly value="<?php echo $asal ;?>"/>
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Perihal</td>
	        <td>
	        <textarea name="Perihal" cols="50" id="Perihal" class="form" readonly><?php echo $perihal;?></textarea>
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Tujuan</td>
	        <td><textarea  name="TujuanSurat" cols="60" class="form" id="TujuanSurat" readonly><?php echo $tujuan; ?></textarea>
	    
   	          </td>
                
	        </tr>
            
            <tr>
	        <td class="key">Sifat Surat</td>
	        <td>
	        <input name="SifatSurat" type="text" class="form" id="SifatSurat" size="50" readonly value="<?php echo GetSifatSurat($sifat);?>"/><input name="IdSifatSurat" type="hidden" class="form" id="IdSifatSurat" size="50" readonly value="<?php echo $sifat;?>"/>
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Kategori Surat</td>
	        <td><input name="KategoriSurat2" type="text" class="form" id="KategoriSurat" size="50" readonly value="<?php echo GetKategoriSurat($kategori);?>"/><input name="IdKategori" type="hidden" class="form" id="IdKategori" size="50" readonly value="<?php echo $kategori;?>"/></td>
	        </tr>
            
            <tr>
	        <td class="key">Klasifikasi Surat</td>
	        <td><input name="KlasifikasiSurat2" type="text" class="form" id="KlasifikasiSurat" size="50" readonly value="<?php echo GetKlasifikasiSurat($klasifikasi);?>"/><input name="IdKlasifikasi" type="hidden" class="form" id="IdKlasifikasi" size="50" readonly value="<?php echo $klasifikasi;?>"/></td>
	        </tr>
            <tr>
	        <td class="key">Lampiran</td>
	        <td>
	          <input name="Lampiran" type="text" class="formAll" id="Lampiran" size="50" readonly value="<?php $lampiran; ?>"/> 
	          </td>
	        </tr>
            <tr>
	        <td class="key">Keterangan</td>
	        <td>
	          <input name="Keterangan" type="text" class="formAll" id="Keterangan" size="50" readonly value="<?php $keterangan; ?>"/> 
	          </td>
	        </tr>
          <tr>
				<td class="key">File</td>
				<td>  <?php
					$oFile = mysql_query("SELECT * FROM lokasifile WHERE NoSurat = '".$nosurat."'") or die(mysql_error());
					if (mysql_num_rows($oFile) == 0) {
                  	?>
              		<tr align="center" bgcolor="#FFFFFF">
                		<td class="fontred"><font color="#FF0000"><strong>[No Data Found]</strong></td>
              		</tr>
              		<?php
                    } else {
                        $i	= 1;
                         while($Listx = mysql_fetch_object($oFile)) {
                    ?>
                	<a href="javascript:poptastic('/sitpdik/files/<?=$Listx->NamaFile?>');">
                  	<?=$i?>
                	.
                  	<?=$Listx->NamaFile;?>
				  	</a><br />
				  	<?php
                	$i++;
                        }
                  	}
					?>
                </td>
			</tr>
          <tr> 
                  <td width="136" align="center" valign="top">&nbsp;</td>
                  <td colspan="2">
                  <div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo enkripsi($p_next); ?>')">Batal</a>
					</div>
				</div>
                <div class="button2-left">
					<div class="next">
						<a onclick="Btn_Submit('beritasuratkeluar')">Catat Surat</a>
					</div>
				</div>
                <div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
                <input type="hidden" name="jenissurat" value="1" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
                </td>
      </tr>
	      
	      </table>
          </form>

</body>
</html>