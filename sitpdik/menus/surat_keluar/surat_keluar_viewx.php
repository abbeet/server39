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
	
	
		$olist = mysql_query("SELECT * FROM suratkeluar WHERE IdSuratKeluar = $q ") or die(mysql_error());
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
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>



<script>
$(function() {
$( "#tabs" ).tabs();
});
</script>

<script>
var halamanbaru;
function poptastic(url)
{
	halamanbaru=window.open(url,'Surat','height=600,width=800');
	if (window.focus) {halamanbaru.focus()}
}
</script>
</head>
<body>
<div id="tabs">
<ul>
<li><a href="#tabs-1">Info Surat</a></li>
<li><a href="#tabs-2">Status Surat</a></li>

</ul>
<div id="tabs-1">
<p>

 <table class="admintable" cellspacing="1">
	      
	     
	      <tr>
	        <td class="key">Tanggal Surat</td>
	        <td>
	             <input name="TglSurat" type="text" class="form" id="TglSurat" size="10" readonly value="<?php echo $tgl;?>"/></td>
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
	        <input name="SifatSurat" type="text" class="form" id="SifatSurat" size="50" readonly value="<?php echo GetSifatSurat($sifat);?>"/>&nbsp;
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Kategori Surat</td>
	        <td><input name="KategoriSurat" type="text" class="form" id="KategoriSurat" size="50" readonly value="<?php echo GetKategoriSurat($kategori);?>"/></td>
	        </tr>
            
            <tr>
	        <td class="key">Klasifikasi Surat</td>
	        <td><input name="KlasifikasiSurat" type="text" class="form" id="KlasifikasiSurat" size="50" readonly value="<?php echo GetKlasifikasiSurat($klasifikasi);?>"/></td>
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
                  <td colspan="2"><input name="BnCancel" type="button" class="button" id="BnCancel" value="Kembali" onClick="Cancel('surat_keluar_list.php?pg=<?=$newpg?>')"></td>
      </tr>
	      
	      </table>

</p>
</div>
<div id="tabs-2">
<p>
        <?php
		$oListx		 = "SELECT * FROM status_surat_keluar WHERE Pengirim = '".$usernamex."' and NoSurat = '".$nosurat."' ";

		$SQLListx	 = mysql_query($oListx) or die(mysql_errno()." : ".mysql_error());
		?>      
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
              <tr align="center" valign="middle" bgcolor="#FFFFFF">
                <td rowspan="2" width="39" height="38" background="images/glossyback2.gif" class="tableheader"><strong>No.</strong></td>
           
                <td rowspan="2" width="212" background="images/glossyback2.gif" class="tableheader"><strong>Penerima</strong></td>
                <td rowspan="2" width="92" background="images/glossyback2.gif" class="tableheader"><strong>Tgl. Baca</strong></td>
                
                
                
              </tr>
              <tr align="center" valign="middle" bgcolor="#FFFFFF"> 
                  
              </tr>
              <?php
                    if (mysql_num_rows($SQLListx) == 0) {
                  ?>
              <tr align="center" bgcolor="#FFFFFF">
                <td colspan="3" class="fontred">[No Data Found]</td>
              </tr>
              <?php
                    } else {
                        $i	= 1+$Pg;
                        $bgcolor = "#efefef";
    
                        while($Listx = mysql_fetch_object($SQLListx)) {
                    ?>
              <tr align="center" bgcolor="<?=$bgcolor?>">
                <td>
                  <?=$i?>
                .</td>
                <td>
                  <?=$Listx->Penerima ?>
                </td>
                <td>
                  <?=$Listx->WaktuBaca ?>
               </td>
              </tr>
              <?php
                            if ($bgcolor == "#efefef") { $bgcolor = "#dedede"; } else { $bgcolor = "#efefef"; }
                            $i++;
                        }
                    }
                    ?>
            </table>

</p>
</div>

</div>
</body>
</html>