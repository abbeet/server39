<?php
	checkauthentication();
	$table = "klasifikasisurat";
	$field = get_field($table);
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['klasifikasisurat'])
	{
		extract($_POST);
		
		if ($IdKlasifikasi != "")
		{
			if ($NmKlasifikasi != "")
			{
				$sql = sql_select("klasifikasisurat", "IdKlasifikasi", "IdKlasifikasi = '".$IdKlasifikasi."' AND IdKlasifikasi != '".$id."'");
				$ocheck = mysql_query($sql);
				$ncheck = mysql_num_rows($ocheck);
				
				if ($ncheck == 0)
				{
					foreach ($field as $k=>$val) 
					{
						$value[$k] = $$val;
					}
					
					if ($id == "") 
					{
						$sql 	= sql_insert($table, $field, $value);
						$query	= mysql_query($sql);
						
						if ($query == 1)
						{
							$msg	= "Tambah klasifikasi surat berhasil. Id = ".$IdKlasifikasi.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Tambah klasifikasi surat gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
					} 
					
					else 
					{
						$field[]	= "IdKlasifikasi";
						$value[]	= $IdKlasifikasi;
						$value[0]	= $id;
						$sql 		= sql_update($table, $field, $value);
						$query		= mysql_query($sql);
						
						if ($query == 1) 
						{
							$msg = "Ubah klasifikasi surat berhasil. Id = ".$id.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Ubah klasifikasi surat gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;			
						}
					}
				}
				
				else
				{
					$msg = "Tambah/ubah klasifikasi surat gagal. Id klasifikasi surat sudah digunakan. Id = ".$IdKlasifikasi.".";
					update_log($msg, $table, $susername, 0);
					$_SESSION['errmsg'] = $msg;
				}
			}
			
			else
			{
				$msg = "Tambah/ubah klasifikasi surat gagal. Nama klasifikasi surat kosong.";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else 
		{
			$msg = "Tambah/ubah klasifikasi surat gagal. Id klasifikasi surat kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
		} ?>
						
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        exit();
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("klasifikasisurat", "*", "IdKlasifikasi = '".$q."'", "IdKlasifikasi");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			$list 	= mysql_fetch_array($olist);
			$id 	= $list['IdKlasifikasi'];
			$nama	= $list['NmKlasifikasi'];
		}
		
		else
		{
			$id 	= "";
			$nama 	= "";
		}
	}
	
	else 
	{
		$id 	= "";
		$nama	= "";
	}
?>

<form method="post" name="klasifikasisurat">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Kode</td>
			<td><input type="text" name="IdKlasifikasi" size="40" value="<?php echo $id; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Klasifikasi Surat</td>
			<td><input type="text" name="NmKlasifikasi" size="40" value="<?php echo $nama; ?>" /></td>
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
						<a onclick="Btn_Submit('klasifikasisurat')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="klasifikasisurat" value="1" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>