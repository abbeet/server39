<?php
	#@
	checkauthentication();
	 $waktu     = date('is');
 $id_kirim=$_SESSION['MM__AdminID'];
 $session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
 
 $NoSurat = $waktu."/".$usernamex."/"."pre-konsep";$random_digit=rand(000,999);
 $NoSuratx=$NoSurat." [".$random_digit."]";
 $random_digit=rand(000,999);
 $NoSuratx=$NoSurat." [".$random_digit."]";
	$Session['xusername'] = $_SESSION['xusername'];
	
	
    
    if ($_POST["Submit"]) {
		extract($_POST);
	$Instruksi		=$_POST['Instruksi'];
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
	$DicatatOleh		= $_SESSION['MM__AdminIdDeputi'];
	$Disposisi			= "Surat baru ditambahkan pada " . date( " d F Y  H:i:s");

$Perihalx =trim( preg_replace( '/\s+/', ' ', $Perihal ) ); 
$Perihalxx =  preg_replace("/[^a-zA-Z0-9]+/", " ", $Perihalx);
	
	 $waktu     = date('is');
	 $random_digit=rand(000,999);
$NoSuratx=$NoSurat." [".$random_digit."]";
	
	
	

	

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
			
	
			if ($IdKategori=="00"){
			mysql_query("INSERT INTO suratkeluar( IdSifat, IdJenisSurat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Tembusan, Disposisi,                         Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat, StatusDisposisi) 
								  VALUES ('".$IdSifatSurat."', '".$IdJenisSurat."', '".$IdKategori."', 
								  		  '".$IdKlasifikasi."', '".$TglTerima."', '".$NoSuratx."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihalxx."', 
										  '".$Lampiran."', '".$TujuanSurat."',  '".$Tembusan."', '".$Disposisi."',
										  '".$Retensi."', '".$Keterangan."', '".$usernamex."', '".$exis_no."','".$usernamex."', 1)") or  die(mysql_error());
			} else {
			mysql_query("INSERT INTO suratkeluar( IdSifat, IdJenisSurat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Tembusan, Disposisi, 					                         Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat) 
								  VALUES ('".$IdSifatSurat."',  '".$IdJenisSurat."', '".$IdKategori."', 
								  		  '".$IdKlasifikasi."', '".$TglTerima."', '".$NoSuratx."', 
										  '".$TglSurat."', '".$AsalSurat."', '".$Perihalxx."', 
										  '".$Lampiran."', '".$TujuanSurat."', '".$Tembusan."', '".$Disposisi."',
										  '".$Retensi."', '".$Keterangan."', '".$usernamex."', '".$exis_no."','".$usernamex."')") or  die(mysql_error());
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
				

			
			exit();
		}}
        ?>
    
    
<link rel="stylesheet" type="text/css" href="css/jquery.comboselect.css" /> 
<script type="text/javascript" src="ck/ckeditor.js"></script>
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
	        <td class="key">No.Surat</td>
	        <td>
	          <input name="NoSurat" type="text" class="formAll" id="NoSurat" size="50" value="<?=$NoSuratx?>"/>	          </td>
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
	        <td>
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
				?> 
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
	        <td class="key">Konsep 1</td>
	        <td>
	        <textarea name="Instruksi" cols="300" id="Instruksi" class="form"><?=$Instruksi?></textarea>
                 <script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'Instruksi',
						{
							skin : 'office2003'
						});

				//]]>
				</script>
	          </td>
	        </tr>
          <tr> 
                  <td width="136" align="center" valign="top">&nbsp;</td>
                  <td colspan="2"><input name="Submit" type="submit" class="button" value="Submit"> 
                    <input name="BnCancel" type="button" class="button" id="BnCancel" value="Cancel" onClick="Cancel('surat_keluar_list.php?pg=<?=$newpg?>')"></td>
                </tr>
	      
	      </table>
	    </form>
</blockquote>
