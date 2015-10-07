<?php
	checkauthentication();
	$table = "unit";
	$field = get_field($table);
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['unit'])
	{
		extract($_POST);
		
		if ($kdunit != "")
		{
			if ($nmunit != "")
			{
				$sql = sql_select("unit", "kdunit", "kdunit = '".$kdunit."' AND kdunit != '".$id."'");
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
							$msg	= "Tambah unit berhasil. Id = ".$kdunit.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Tambah unit gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
					} 
					
					else 
					{
						$field[]	= "kdunit";
						$value[]	= $kdunit;
						$value[0]	= $id;
						$sql 		= sql_update($table, $field, $value);
						$query		= mysql_query($sql);
						
						if ($query == 1) 
						{
							$msg = "Ubah unit berhasil. Id = ".$id.".";
							update_log($msg, $table, $susername, 1);
							$_SESSION['errmsg'] = $msg;
						}
						
						else 
						{
							$msg = "Ubah unit gagal. Error = ".mysql_error().".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;			
						}
					}
				}
				
				else
				{
					$msg = "Tambah/Ubah unit gagal. Id unit sudah digunakan. Id = ".$kdunit.".";
					update_log($msg, $table, $susername, 0);
					$_SESSION['errmsg'] = $msg;
				}
			}
			
			else
			{
				$msg = "Tambah/Ubah unit gagal. Nama unit kosong.";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else 
		{
			$msg = "Tambah/Ubah unit gagal. Id unit kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
		} ?>
						
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        exit();
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("unit", "*", "kdunit = '".$q."'", "kdunit");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			$list 	= mysql_fetch_array($olist);
			$id 	= $list['kdunit'];
			$nama	= $list['nmunit'];
			$skt	= $list['sktunit'];
		}
		
		else
		{
			$id 	= "";
			$nama 	= "";
			$skt 	= "";
		}
	}
	
	else 
	{
		$id 	= "";
		$nama	= "";
		$skt 	= "";
	}
?>

<form method="post" name="unit">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Kode</td>
			<td><input type="text" name="kdunit" size="40" value="<?php echo $id; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Nama</td>
			<td><textarea name="nmunit" cols="31"><?php echo $nama; ?></textarea></td>
		</tr>
		<tr>
			<td class="key">Singkatan</td>
			<td><input type="text" name="sktunit" size="40" value="<?php echo $skt; ?>" /></td>
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
						<a onclick="Btn_Submit('unit')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="unit" value="1" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>