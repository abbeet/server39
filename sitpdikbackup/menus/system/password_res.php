<?php
	checkauthentication();
	$table = "xuser";
	$field = array("username", "password", "reset");
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['xuser'])
	{
		extract($_POST);
		
		if ($password != "")
		{
			if ($retrypassword != "")
			{
				if ($password == $retrypassword)
				{
					$username 	= $id;
					
					$len		= strlen($password);
					$password 	= encode_password(md5($password), $len);
					$reset		= "1";
					
					foreach ($field as $k=>$val) 
					{
						$value[$k] = $$val;
					}
					
					$sql 		= sql_update($table, $field, $value);
					$sql		= str_replace("''", "NULL", $sql);
					$query		= mysql_query($sql);
					
					if ($query == 1) 
					{
						$msg = "Ubah kata sandi berhasil. Id = ".$id.".";
						update_log($msg, $table, $susername, 1);
						$_SESSION['errmsg'] = $msg;
					}
					
					else 
					{
						$msg = "Ubah kata sandi gagal. Error = ".mysql_error().".";
						update_log($msg, $table, $susername, 0);
						$_SESSION['errmsg'] = $msg;			
					}
				}
				
				else
				{
					$msg = "Ubah kata sandi gagal. Kata sandi baru tidak sama. Id = ".$id.".";
					update_log($msg, $table, $susername, 0);
					$_SESSION['errmsg'] = $msg;
				}
			}
			
			else
			{
				$msg = "Ubah kata sandi gagal. Ulangi kata sandi baru 2 kali. Id = ".$id.".";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else
		{
			$msg = "Ubah kata sandi gagal. Kata sandi baru kosong. Id = ".$id.".";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
		} ?>
			
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        exit();
	}
?>

<form method="post" name="xuser">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Kata Sandi</td>
			<td><input type="password" name="password" size="40" value="" /></td>
		</tr>
		<tr>
			<td class="key">Ulangi Kata Sandi</td>
			<td><input type="password" name="retrypassword" size="40" value="" /></td>
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
						<a onclick="Btn_Submit('xuser')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="xuser" value="1" />
                <input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>