<?php
	checkauthentication();
	$table = "xlevel";
	$field = get_field($table);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	
	$q = ekstrak_get(@$get[1]);
	
	if (@$_POST['xlevel'])
	{
		extract($_POST);
		
		if ($kode != "")
		{
			if ($name != "")
			{
				$sql = sql_select("xlevel", "kode", "kode = '".$kode."' AND kode != '".$id."'");
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
							$msg	= "Tambah level pengguna berhasil. Id = ".$kode.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Tambah level pengguna gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
					} 
					
					else 
					{
						$field[]	= "kode";
						$value[]	= $kode;
						$value[0]	= $id;
						$sql 		= sql_update($table, $field, $value);
						$query		= mysql_query($sql);
						
						if ($query == 1) 
						{
							$msg = "Ubah level pengguna berhasil. Id = ".$id.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Ubah level pengguna gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;			
						}
					}
				}
				
				else
				{
					$msg = "Tambah/Ubah level pengguna gagal. Id level pengguna sudah digunakan. Id = ".$kode.".";
					update_log($msg, $table, $susername, 0);
					$_SESSION['errmsg'] = $msg;
				}
			}
			
			else
			{
				$msg = "Tambah/Ubah level pengguna gagal. Nama level pengguna kosong.";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else 
		{
			$msg = "Tambah/Ubah level pengguna gagal. Id level pengguna kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
		} ?>
						
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        exit();
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("xlevel", "*", "kode = '".$q."'", "kode");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			$list 	= mysql_fetch_array($olist);
			$id 	= $list['kode'];
			$nama	= $list['name'];
			$urutan	= $list['ordering'];
		}
		
		else
		{
			$id 	= "";
			$nama 	= "";
			$urutan	= "";
		}
	}
	
	else 
	{
		$id 	= "";
		$nama	= "";
		$urutan	= "";
	}
?>

<form method="post" name="xlevel">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Kode</td>
			<td><input type="text" name="kode" size="40" value="<?php echo $id; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="name" size="40" value="<?php echo $nama; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Urutan</td>
			<td><input type="text" name="ordering" size="10" value="<?php echo $urutan; ?>" /></td>
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
						<a onclick="Btn_Submit('xlevel')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="xlevel" value="1" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>