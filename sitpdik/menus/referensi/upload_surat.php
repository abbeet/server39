<?php
	checkauthentication();
	$table = "lokasifile";
	$field = get_field($table);
	
	$p_next = 75;
	
	if (@$_POST['lokasifile'])
	{
		extract($_POST);
		
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
						$sql = "INSERT INTO ".$table." (NoSurat, NamaFile, Date) VALUES ('".$NoSurat."', '".basename($nama_baru)."', now())";
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
		
		else 
		{
			$msg = "Unggah surat gagal. No surat kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
		} ?>
						
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        exit();
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
			<td class="key">No. Surat</td>
			<td><input type="text" name="NoSurat" size="40" value="" /></td>
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