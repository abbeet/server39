<?php
	checkauthentication();
	$table = "suratmasuk";
	$field = get_field($table);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
	$q = ekstrak_get(@$get[1]);
	
	if (@$_POST['lokasifile'])
	{
		//extract($_POST);
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
		$DicatatOleh		= @$_SESSION['xunit_'.$session_name];
		$IdUser				= @$_SESSION['xusername_'.$session_name];
		$Disposisi			= "Surat baru ditambahkan pada " . date( " d F Y  H:i:s");
		/**if ($IdSuratMasuk != "")
		{
			
			if ($NoSurat != "")
			{
				$sql = sql_select("suratmasuk", "NoSurat", "NoSurat = '".$NoSurat."' AND NoSurat != '".$id."'");
				$ocheck = mysql_query($sql);
				$ncheck = mysql_num_rows($ocheck);
				
				if ($ncheck == 0)
				{
					foreach ($field as $k=>$val) 
					{
						$value[$k] = $$val;
					}
	*/				
					if ($id == "") 
					{
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
							
			//$nosuratextended = $nosurat." [".$iduser."-".now()."]";
			
								mysql_query("INSERT INTO suratmasuk( IdSifat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Disposisi, Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat, StatusDisposisi) 
													  VALUES ('".$IdSifatSurat."', '".$IdKategori."', 
															  '".$IdKlasifikasi."', '".$TglTerima."', '".$NoSurat."', 
															  '".$TglSurat."', '".$AsalSurat."', '".$Perihal."', 
															  '".$Lampiran."', '".$TujuanSurat."', '".$Disposisi."',
															  '".$Retensi."', '".$Keterangan."', '".$DicatatOleh."', '".$exis_no."','".$IdUser."', 1)") or  die(mysql_error());
								} else {
								mysql_query("INSERT INTO suratmasuk( IdSifat, IdKategori, IdKlasifikasi, TglTerima, NoSurat, TglSurat, AsalSurat, Perihal, Lampiran, TujuanSurat, Disposisi, Retensi, Keterangan, DicatatOleh, NoUrut, UserBuat) 
													  VALUES ('".$IdSifatSurat."', '".$IdKategori."', 
															  '".$IdKlasifikasi."', '".$TglTerima."', '".$NoSurat."', 
															  '".$TglSurat."', '".$AsalSurat."', '".$Perihal."', 
															  '".$Lampiran."', '".$TujuanSurat."', '".$Disposisi."',
															  '".$Retensi."', '".$Keterangan."', '".$DicatatOleh."', '".$exis_no."','".$IdUser."')") or  die(mysql_error());
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
						$sql = "INSERT INTO lokasifile (NoSurat, NamaFile, Date) VALUES ('".$NoSurat."', '".basename($nama_baru)."', now())";
						$query = mysql_query($sql);
						
						$sql = "INSERT INTO lokasifile_backup (NoSurat, NamaFile, date) VALUES ('".$NoSurat."', '".basename($nama_baru)."', now())";
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
						
						//end upload surat 
						
						/*
						$sql 	= sql_insert($table, $field, $value);
						//$query	= mysql_query($sql);
						
						if ($query == 1)
						{
							$msg	= "Tambah surat masuk berhasil. Id = ".$IdSuratMasuk.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Tambah surat masuk gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
						*/
					} 
					else 
					{
						/*$field[]	= "IdSuratMasuk";
						$value[]	= $IdSuratMasuk;
						$value[0]	= $id;
						$sql 		= sql_update($table, $field, $value);
						$query		= mysql_query($sql);
						
						if ($query == 1) 
						{
							$msg = "Ubah surat masuk berhasil. Id = ".$id.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Ubah surat masuk gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;			
						}*/
					}
				/*}
				else
				{
					$msg = "Tambah/Ubah jenis surat gagal. Id jenis surat sudah digunakan. Id = ".$IdSuratMasuk.".";
					update_log($msg, $table, $susername, 0);
					$_SESSION['errmsg'] = $msg;
				}
			}
			
			else
			{
				$msg = "Tambah/Ubah jenis surat gagal. Nama jenis surat kosong.";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else 
		{
			$msg = "Tambah/Ubah jenis surat gagal. Id jenis surat kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
		} */?>
						
     <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>">
	  <?php
       
	   exit();
	   echo $_SESSION['errmsg'];
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("suratmasuk", "*", "IdSuratMasuk = '".$q."'", "IdSuratMasuk");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			$list 	= mysql_fetch_array($olist);
			$idsuratmasuk		= $list['IdSuratMasuk'];
			$idsifat 			= $list['IdSifat'];
			$idkategori			= $list['IdKategori'];
			$idklasifikasi		= $list['IdKlasifikasi']; 
			$tglterima			= $list['TglTerima'];
			$nosurat			= $list['NoSurat']; 
			$tglsurat			= $list['TglSurat']; 
			$asalsurat			= $list['AsalSurat']; 
			$perihal			= $list['Perihal']; 
			$lampiran			= $list['Lampiran']; 
			$tujuansurat		= $list['TujuanSurat'];
			$retensi			= $list['Retensi']; 
			$lokasifile			= $list['LokasiFile']; 
			$tujuansurat		= $list['TujuanSurat']; 
			$keterangan			= $list['Keterangan'];
			
		}
		
		else
		{
			$idsuratmasuk		= "";
			$idsifat 			= "";
			$idkategori			= "";
			$idklasifikasi		= ""; 
			$tglterima			= "";
			$nosurat			= "";
			$tglsurat			= ""; 
			$asalsurat			= ""; 
			$perihal			= "";
			$lampiran			= "";
			$tujuansurat		= "";
			$retensi			= "";
			$lokasifile			= "";
			$tujuansurat		= ""; 
			$keterangan			= "";
		}
	}
	
	else 
	{
			$idsuratmasuk		= "";
			$idsifat 			= "";
			$idkategori			= "";
			$idklasifikasi		= ""; 
			$tglterima			= "";
			$nosurat			= "";
			$tglsurat			= ""; 
			$asalsurat			= ""; 
			$perihal			= "";
			$lampiran			= "";
			$tujuansurat		= "";
			$retensi			= "";
			$lokasifile			= "";
			$tujuansurat		= ""; 
			$keterangan			= "";
	}
?>
<script type="text/javascript">
	
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
<form method="post" name="lokasifile" enctype="multipart/form-data">
	<table class="admintable" cellspacing="1">
		<tr> 
                  <td align="left" valign="top" class="key"><strong>Tanggal Surat</strong></td>
                  <td><input name="TglSurat" type="text" class="formAll" id="TglSurat" size="15" readonly="1" value="<?=$tglsurat?>"/> 
                    &nbsp;<img src="images/icons/icon_Calendar.gif" id="triggerIMG" width="20" height="20" hspace="5" title="Tanggal Surat" onMouseOver="this.style.background='red';" onMouseOut="this.style.background=''" /><img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"> 
                    <script type="text/javascript">
						  	Calendar.setup({
								inputField		: "TglSurat",
								
								button			: "triggerIMG",
								align			: "BR",
								firstDay		: 1,
								weekNumbers		: false,
								singleClick		: true,
								showOthers		: true
							});
						  </script></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>No. Surat</strong></td>
                  <td><input name="NoSurat" type="text" class="form" id="NoSurat" value="<?=$nosurat?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Diterima Tanggal</strong></td>
                  <td><input name="TglTerima" type="text" class="formAll" id="TglTerima" size="15" readonly="1" value="<?=$TglTerima?>"/> 
                    &nbsp;<img src="images/icons/icon_Calendar.gif" id="triggerIMG2" width="20" height="20" hspace="5" title="Tanggal Terima Surat" onMouseOver="this.style.background='red';" onMouseOut="this.style.background=''" /><img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"> 
                    <script type="text/javascript">
						  	Calendar.setup({
								inputField		: "TglTerima",
								
								button			: "triggerIMG2",
								align			: "BR",
								firstDay		: 1,
								weekNumbers		: false,
								singleClick		: true,
								showOthers		: true
							});
						  </script></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Asal Surat</strong></td>
                  <td><input name="AsalSurat" type="text" class="form" id="AsalSurat" value="<?php echo $usernamex ?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Perihal</strong></td>
                  <td><textarea name="Perihal" cols="50" id="Perihal" class="form"><?=$perihal?></textarea> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Tujuan Surat</strong></td>
                  <td><input name="TujuanSurat" type="text" class="form" id="TujuanSurat" value="<?=$tujuansurat?>" size="30">
                  <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
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
				 	if ($_GET["id"] == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdSifat]==$idsifat) {
					echo "<OPTION VALUE='".$rows[IdSifat]."'selected>".$rows[NmSifat]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdSifat]."'>".$rows[NmSifat]."</OPTION>";
					}
					}
					echo "</select>";
				?>
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
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
				 	if ($_GET["id"] == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdKategori]==$idkategori) {
					echo "<OPTION VALUE='".$rows[IdKategori]."'selected>".$rows[NmKategori]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdKategori]."'>".$rows[NmKategori]."</OPTION>";
					}
					}
					echo "</select>";
				
				?>
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
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
				 	if ($_GET["id"] == "") {		
					echo "<option value=''>- pilih-</option>";}	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[IdKlasifikasi]==$idklasifikasi) {
					echo "<OPTION VALUE='".$rows[IdKlasifikasi]."'selected>".$rows[NmKlasifikasi]."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[IdKlasifikasi]."'>".$rows[NmKlasifikasi]."</OPTION>";
					}
					}
					echo "</select>";
					
				?>
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Lampiran</strong></td>
                  <td><input name="Lampiran" type="text" class="form" id="Lampiran" value="<?=$lampiran?>" size="30"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
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
                <tr> 
                  <td align="left" valign="top" class="key"><strong>Keterangan</strong></td>
                  <td><input name="Keterangan" type="text" class="form" id="Keterangan" value="<?=$keterangan?>" size="50"> 
                    <img src="images/icons/required.gif" alt="" width="12" height="14" border="0" align="top"></td>
                </tr>
              <tr>
			<td class="key">Unggah</td>
			<td>
                Pilih Jumlah File
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
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo enkripsi($p_next); ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="Btn_Submit('lokasifile')">Unggah</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
                <input type="hidden" name="lokasifile" value="1" />
			</td>
		</tr>
	</table>
</form>

