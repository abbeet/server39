<?php
	checkauthentication();
	$table	= "xuser";
	$field 	= array("username", "password", "reset");
	
	$p_next = 55;
	
	if (@$_POST['xuser'])
	{
		extract($_POST);
		
		if ($oldpassword != "")
		{
			if ($password != "")
			{
				if ($retrypassword != "")
				{
					$ocheck	= xuser("password", "username = '".$susername."'");
					$check 	= mysql_fetch_array($ocheck);
					$len 	= strlen($oldpassword);
					
					if (md5($oldpassword) == decode_password($check['password'], $len))
					{
						if ($password == $retrypassword)
						{
							$username 	= $susername;
							
							$len		= strlen($password);
							$password 	= encode_password(md5($password), $len);
							$reset		= "0";
							
							foreach ($field as $k=>$val) 
							{
								$value[$k] = $$val;
							}
							
							$sql 		= sql_update($table, $field, $value);
							$sql		= str_replace("''", "NULL", $sql);
							$query		= mysql_query($sql);
							
							if ($query == 1) 
							{
								$msg = "Ubah kata sandi berhasil. Id = ".$susername.".";
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
							$msg = "Ubah kata sandi gagal. Kata sandi baru tidak sama. Id = ".$susername.".";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
					}
					
					else
					{
						$msg = "Ubah kata sandi gagal. Kata sandi lama salah. Id = ".$susername.".";
						update_log($msg, $table, $susername, 0);
						$_SESSION['errmsg'] = $msg;
					}
				}
				
				else
				{
					$msg = "Ubah kata sandi gagal. Ulangi kata sandi baru 2 kali. Id = ".$susername.".";
					update_log($msg, $table, $susername, 0);
					$_SESSION['errmsg'] = $msg;
				}
			}
			
			else
			{
				$msg = "Ubah kata sandi gagal. Kata sandi baru kosong. Id = ".$susername.".";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else
		{
			$msg = "Ubah kata sandi gagal. Kata sandi lama kosong. Id = ".$susername.".";
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
			<td class="key">Kata Sandi Lama</td>
			<td><input type="password" name="oldpassword" size="40" value="" /></td>
		</tr>
		<tr>
			<td class="key">Kata Sandi Baru</td>
			<td><input type="password" name="password" size="40" value="" /></td>
		</tr>
		<tr>
			<td class="key">Ulangi Kata Sandi Baru</td>
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
			</td>
		</tr>
	</table>
</form>