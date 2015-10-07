<?php
	#@
	checkauthentication();
	$table = "lokasifile";
	$field = get_field($table);
	set_time_limit(6000);
	$bError = false;
	
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	
	
	$form = @$_POST['form'];
	$date_from = @$_POST['date_from'];
	$date_until = @$_POST['date_until'];
	$unit_kerja = $_SESSION['unit_kerja'];
	$Session['xusername'] = $_SESSION['xusername'];
	
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
    
    if ($_POST["Submit"]) {
		extract($_POST);
	$TglSurat			= $_POST["TglSurat"];
	$NoSurat			= $_POST["NoSurat"];
	$TglTerima			= $_POST["TglTerima"];
	$AsalSurat	 		= $_POST["AsalSurat"];
	$Perihal			= trim($_POST["Perihal"]);
	$IdJenisSurat		= $_POST["IdJenisSurat"];
  	$IdSifatSurat		= $_POST["IdSifatSurat"];
	$IdKategori			= $_POST["IdKategori"];
	$IdKlasifikasi		= $_POST["IdKlasifikasi"];
	$TujuanSurat		= $_POST["TujuanSurat"];
	$Tembusan			= $_POST["Tembusan"];
	$Lampiran			= $_POST["Lampiran"];
	$LokasiFile			= $_POST["LokasiFileOLD"];
	$Keterangan			= $_POST["Keterangan"];
	$Retensi			= $_POST["Retensi"];
	$n			= $_POST["n"];
	$DicatatOleh		= @$_SESSION['xunit_'.$session_name];
	$Disposisi			= "Surat baru ditambahkan pada " . date( " d F Y  H:i:s");

$Perihalx =trim( preg_replace( '/\s+/', ' ', $Perihal ) ); 
$Perihalxx =  preg_replace("/[^a-zA-Z0-9]+/", " ", $Perihalx);
	
	 $waktu     = date('is');
	 $random_digit=rand(000,999);
$NoSuratx=$NoSurat." [".$random_digit."]";
	
	
	if ($IdJenisSurat == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Masukkan Jenis Surat dengan benar<br />";
	}
	if ($TglSurat == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Masukkan Tanggal Surat dengan benar<br />";
	}
	if ($NoSurat == "" or $NoSurat == "-" or $NoSurat == "--" or $NoSurat == "---" or $NoSurat == "----") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Masukkan No Surat dengan benar<br />";
	}
	if ($IdUser == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Masukkan Asal Surat dengan benar<br />";
	}
	if ($Perihal == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Masukkan Perihal dengan benar<br />";
	}
	
	if ($IdSifatSurat == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Pilih Sifat Surat dengan benar<br />";
	}
	if ($IdKategori == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Pilih Kategori Surat dengan benar<br />";
	}
	if ($IdKlasifikasi == "") {
		$bError		 = true;
		$_SESSION['errmsg']	 .= ". Pilih Klasifikasi Surat dengan benar<br />";
	}

	if ($bError != true) {

		if ($_GET["id"] == "") {
     
	 		foreach ($_POST[myselect] as $IdPenerima) {
			$Disposisi = "Surat baru dikirim oleh " . $usernamex . " ke " . $IdPenerima. " pada " . date( " d F Y  H:i:s");
			mysql_query("INSERT INTO berita ( `Perihal` , `Isi` , `Pengirim` , `WaktuKirim` , `Penerima` ,`WaktuBaca` ,`NoSurat` ,`StatusBerita` ,`StatusDisposisi` ) 
			VALUES ( '$Perihalxx', '$Disposisi', '$usernamex', now(),  '$IdPenerima', '', '$NoSuratx', '0', '$ParentId' )") or die(mysql_error());
			
			
			
				mysql_query("INSERT INTO status_surat_keluar ( `Perihal` , `Isi` , `Pengirim` , `WaktuKirim` , `Penerima` ,`WaktuBaca` ,`NoSurat` ,`StatusBerita` ,`StatusDisposisi` ) 
			VALUES ( '$Perihal', '$Disposisi', '$usernamex', now(),  '$IdPenerima', '', '$NoSuratx', '0', '$ParentId' )") or die(mysql_error());
			
			
			$TujuanSuratx = $TujuanSuratx. $IdPenerima . ", ";
			$panjang = strlen($TujuanSuratx) - 2;
			$TujuanSurat = substr($TujuanSuratx,0,$panjang);
		
			}
	$unitx	= mysql_query("SELECT unit FROM xuser WHERE username = '". $usernamex ."'") or die(mysql_error());		
	
			if ($IdKategori=="00"){
			mysql_query("INSERT INTO suratkeluar( IdSifat, IdJenisSurat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Tembusan, Disposisi,                         Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat, StatusDisposisi) 
								  VALUES ('".$IdSifatSurat."', '".$IdJenisSurat."', '".$IdKategori."', 
								  		  '".$IdKlasifikasi."', '".$TglTerima."', '".$NoSuratx."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihalxx."', 
										  '".$Lampiran."', '".$TujuanSurat."',  '".$Tembusan."', '".$Disposisi."',
										  '".$Retensi."', '".$Keterangan."', '".$DicatatOleh."', '".$exis_no."','".$usernamex."', 1)") or  die(mysql_error());
			} else {
			mysql_query("INSERT INTO suratkeluar( IdSifat, IdJenisSurat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Tembusan, Disposisi, 					                         Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat) 
								  VALUES ('".$IdSifatSurat."',  '".$IdJenisSurat."', '".$IdKategori."', 
								  		  '".$IdKlasifikasi."', '".$TglTerima."', '".$NoSuratx."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihalxx."', 
										  '".$Lampiran."', '".$TujuanSurat."', '".$Tembusan."', '".$Disposisi."',
										  '".$Retensi."', '".$Keterangan."', '".$DicatatOleh."', '".$exis_no."','".$usernamex."')") or  die(mysql_error());
			}							  
				
				// upload surat
if ($NoSurat != "")
		{
			$uploaddir = 'files/';
			
			for ($i = 0; $i <= $n - 1; $i++)
			{
				$fileName 		= $_FILES['userfile'.$i]['name'];
				$random_digit	= rand(000,999);
				$nama_baru 		= $random_digit."-".$fileName;
				$fileSize 		= $_FILES['userfile'.$i]['size'];
				$tmpName  		= $_FILES['userfile'.$i]['tmp_name']; 
				$uploadfile 	= $uploaddir.$nama_baru;
				
				if ($fileSize > 0)
				{
					if (move_uploaded_file($tmpName, $uploadfile))
					{	
						$sql = "INSERT INTO ".$table." (NoSurat, NamaFile, Date) VALUES ('".$NoSuratx."', '".basename($nama_baru)."', now())";
						$query = mysql_query($sql);
						
						$sql = "INSERT INTO lokasifile_backup (NoSurat, NamaFile, date) VALUES ('".$NoSuratx."', '".basename($nama_baru)."', now())";
						$query = mysql_query($sql);
						
						$msg	= "Unggah surat berhasil. Id = ".$NoSurat.".";
						update_log($msg, $table, $susername, 1);
						$_SESSION['errmsg'] = $msg;
					}
					
					else
					{
						$msg = "Unggah surat gagal.";
						update_log($msg, $table, $susername, 0);
						$_SESSION['errmsg'] = $msg;
					}
				}
			}
		}	
				
?>
 <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>">
<?php
			
			exit();
		}}}
        ?>
    
    
<link rel="stylesheet" type="text/css" href="css/jquery.comboselect.css" /> 
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.selso.js"></script>   
<script type="text/javascript" src="js/jquery.comboselect.js"></script>  
<script type="text/javascript">
$(document).ready( function() {

$("#hidden-div").hide();
$("#hidden3-div").hide();
    $("#01").click( function() {
		$("#hidden-div").slideToggle('slow');
		$("#hidden2-div").hide();
		$("#hidden3-div").slideToggle('slow');
		$("#hidden4-div").hide();

	});
	
$("#hidden2-div").hide();
$("#hidden4-div").hide();
    $("#02").click( function() {
		$("#hidden2-div").slideToggle('slow');
		$("#hidden-div").hide();
		$("#hidden4-div").slideToggle('slow');
		$("#hidden3-div").hide();

	});

	$('#myselect').comboselect({ sort: 'left', addbtn: '>>',  rembtn: '<<' });
	$('#myselect2').comboselect({ sort: 'left', addbtn: '>>',  rembtn: '<<' });	
	
});

// fungsi upload
	function show()
	{
	   var n = document.lokasifile.jumfile.value;
	   var i;
	   var string = "";
	   
	   for (i=0; i<=n-1; i++)
	   {
		  string = string + "Pilih File: <input name=\"userfile"+ i + "\" type=\"file\"><br>";
	   }
	   
	   document.getElementById('selectfile').innerHTML = string;
	   document.lokasifile.n.value = n;
	}

</script>
	<blockquote>
	  <form method="post" name="lokasifile" enctype="multipart/form-data">
	    <table class="admintable" cellspacing="1">
	      
	      <tr>
	        <td class="key">Jenis Surat</td>
	        <td>
            <?php
			echo " 
							<select class=\"form\"  id=\"IdJenisSurat\" size=\"1\" name=\"IdJenisSurat\" ONCHANGE=\"Change();\" >\n
							<OPTION VALUE=0>- pilih -</OPTION>";
			
			$perintah="SELECT IdJenisSurat,NmJenisSurat FROM jenissurat ";
			
			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{
					echo "\n<OPTION id='".$rows[IdJenisSurat]."' VALUE='".$rows[IdJenisSurat]."'>".$rows[NmJenisSurat]."</OPTION>";
					}
					
					echo "</select>";
			
			?>
            
	         
	          </td>
	        </tr>
	      <tr>
	        <td class="key">Tanggal Surat</td>
	        <td>
	             <input name="TglSurat" type="text" class="form" id="TglSurat" size="10" readonly value="<?=$TglSurat?>"/>&nbsp;
	          <img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
	          <script type="text/javascript">
						Calendar.setup({
							inputField : "TglSurat",
							button : "a_triggerIMG",
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
	        <td class="key">No.Surat</td>
	        <td>
	          <input name="NoSurat" type="text" class="formAll" id="NoSurat" size="50" value="<?=$NoSurat?>"/>	          </td>
	        </tr>
	      
          <tr>
	        <td class="key">Asal Surat</td>
	        <td>
	       <input name="AsalSurat" type="text" class="formAll" id="AsalSurat" size="50" readonly value="<?php echo $usernamex ?>"/>
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Perihal</td>
	        <td>
	        <textarea name="Perihal" cols="50" id="Perihal" class="form"><?=$Perihal;?></textarea>
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Tujuan</td>
	        <td><div id='hidden-div'>
              <?php 
										
					echo "<select  id='myselect'  size=\"6\" name=\"myselect[]\" multiple=\"multiple\" >\n";
					//Buka table 
					$perintah="SELECT username FROM xuserlevel where level = 'ADM' ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					
					echo "\n<OPTION VALUE='".$rows[username]."'>".$rows[username]."</OPTION>";
					
					}
					echo "</select>";
					echo "<br clear=\"all\" >";
				?></div> &nbsp; <div id='hidden2-div'><textarea  name="TujuanSurat" cols="60" class="form" id="TujuanSurat"><?=$TujuanSurat?></textarea></div>
	    
                	          </td>
                
	        </tr>
            
            <tr>
	        <td class="key">Sifat Surat</td>
	        <td>
	        <?php 
										
					echo "<select class='form' size=\"1\" name=\"IdSifatSurat\" >\n";
					//Buka table 
					$perintah="SELECT IdSifat,NmSifat FROM sifatsurat ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	if ($_GET["id"] == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdSifat]==$IdSifat) {
					echo "<OPTION VALUE='".$rows[IdSifat]."'selected>".$rows[NmSifat]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdSifat]."'>".$rows[NmSifat]."</OPTION>";
					}
					}
					echo "</select>";
				?>
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Kategori Surat</td>
	        <td>
	          <?php 
					echo "<select class='form' size=\"1\" name=\"IdKategori\" >\n";
					//Buka table 
					$perintah="SELECT IdKategori,NmKategori FROM kategorisurat ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	if ($_GET["id"] == "") {		
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
				
				?> 
	          </td>
	        </tr>
            
            <tr>
	        <td class="key">Klasifikasi Surat</td>
	        <td>
	          <?php 
										
					echo "<select class='form' size=\"1\" name=\"IdKlasifikasi\" >\n";
					//Buka table 
					$perintah="SELECT IdKlasifikasi,NmKlasifikasi FROM klasifikasisurat ";
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	if ($_GET["id"] == "") {		
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
					
				?> 
	          </td>
	        </tr>
            <tr>
	        <td class="key">Lampiran</td>
	        <td>
	          <input name="Lampiran" type="text" class="formAll" id="Lampiran" size="50" value="<?=$Lampiran?>"/> 
	          </td>
	        </tr>
            <tr>
	        <td class="key">Keterangan</td>
	        <td>
	          <input name="Keterangan" type="text" class="formAll" id="Keterangan" size="50" value="<?=$Keterangan?>"/> 
	          </td>
	        </tr>
          <tr>
				<td class="key">File</td>
				<td> Pilih Jumlah File
                <select name="jumfile" onChange="show()">
                	<option value="0">0</option>	
                	<option value="1">1</option>
                	<option value="2">2</option>
                	<option value="3">3</option>
                	<option value="4">4</option>
                	<option value="5">5</option>
                	<option value="6">6</option>
                </select>
                <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                <input type="hidden" name="n"/>
                <div id="selectfile"></div>
                </td>
			</tr>
          <tr> 
                  <td width="136" align="center" valign="top">&nbsp;</td>
                  <td colspan="2"><input name="Submit" type="submit" class="button" value="Submit"> 
                    <input name="BnCancel" type="button" class="button" id="BnCancel" value="Cancel" onClick="Cancel('index.php?p=<?php echo enkripsi($p_next); ?>')"></td>
                </tr>
	      
	      </table>
	    </form>
</blockquote>
