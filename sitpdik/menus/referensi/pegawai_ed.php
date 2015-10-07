<?php
	checkauthentication();
	$table = "xuser_pegawai";
	$field = array("username", "nama", "level", "unit", "password", "alamat", "telepon", "email");
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['pegawai'])
	{
		extract($_POST);
		
		if ($username != "")
		{
			$sql = "SELECT * FROM xuser_pegawai WHERE username = '".$username."' AND username != '".$id."'";
			$ocheck = mysql_query($sql);
			$ncheck = mysql_num_rows($ocheck);
			
			if ($ncheck == 0)
			{
				if ($id == "") 
				{
					if ($password != "")
					{
						if ($password == $password2)
						{
							$username = str_replace("'", "", $username);
							$len 		= strlen($password);
							$password 	= encode_password(md5($password), $len);
							
							foreach ($field as $k=>$val) 
							{
								$value[$k] = $$val;
							}
					
							$sql 		= sql_insert($table, $field, $value);
							$sql 		= str_replace("''", "NULL", $sql);
							$query 		= mysql_query($sql);
							
							if ($query == 1)
							{
								$msg	= "Tambah pegawai berhasil. Id = ".$username.".";
								update_log($msg, $table, $susername, 1);
								$_SESSION['errmsg'] = $msg;
							}
							
							else 
							{
								$msg = "Tambah pegawai gagal. Error = ".mysql_error().".";
								update_log($msg, $table, $susername, 0);
								$_SESSION['errmsg'] = $msg;
							}
						}
						
						else
						{
							$msg = "Tambah pegawai gagal. Kata sandi tidak sama.";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
					}
					
					else
					{
						$msg = "Tambah pegawai gagal. Kata sandi kosong.";
						update_log($msg, $table, $susername, 0);
						$_SESSION['errmsg'] = $msg;
					}
				}
				
				else 
				{
					$username = str_replace("'", "", $username);
					
					foreach ($field as $k=>$val) 
					{
						$value[$k] = $$val;
					}
								
					$field[]	= "username";
					$value[]	= $username;
					$value[0]	= $id;
					
					$sql 		= sql_update($table, $field, $value);
					$sql		= str_replace("''", "NULL", $sql);
					$query		= mysql_query($sql);
					
					if ($query == 1) 
					{
						$msg = "Ubah pegawai berhasil. Id = ".$username.".";
						update_log($msg, $table, $susername, 1);
						$_SESSION['errmsg'] = $msg;
					}
						
					else 
					{
						$msg = "Ubah pegawai gagal. Error = ".mysql_error().".";
						update_log($msg, $table, $susername, 0);
						$_SESSION['errmsg'] = $msg;			
					}
				}
			}
				
			else
			{
				$msg = "Tambah/ubah pegawai gagal. Nip pegawai sudah digunakan. Id = ".$username.".";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else
		{
			$msg = "Tambah/ubah pegawai gagal. Nip pegawai kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
			$err = true;
		} ?>
							
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        
        exit();
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("xuser_pegawai", "username, nama, level, alamat, telepon, unit, email, password", "username = '".$q."'", "unit, username");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			
			while ($list = mysql_fetch_array($olist))
			{
				$id 		= $list['username'];
				$nama		= $list['nama'];
				$unit		= $list['unit'];
				$eselon		= $list['level'];
				$alamat		= $list['alamat'];
				$telepon	= $list['telepon'];
				$email		= $list['email'];
				$password	= $list['password'];
			}
		}
		
		else
		{
			$id 		= "";
			$nama		= "";
			$unit		= "";
			$eselon		= "";
			$alamat		= "";
			$telepon	= "";
			$email		= "";
			$password	= "";
		}
	}
	
	else 
	{
		$id 		= "";
		$nama		= "";
		$unit		= "";
		$eselon		= "";
		$alamat		= "";
		$telepon	= "";
		$email		= "";
		$password	= "";
	}
?>

<form method="post" name="pegawai">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nip</td>
			<td><input type="text" name="username" size="40" value="<?php echo $id; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="nama" size="40" value="<?php echo $nama; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Unit Kerja</td>
			<td>
            	<select name="unit">
                	<option value=""></option><?php
                    
					if ($slevel == "DEV")
					{
						$ounit = unit("kdunit, nmunit", "", "kdunit");
						$nunit = mysql_num_rows($ounit);
					}
					
					else
					{
						$ounit = unit("kdunit, nmunit", "kdunit LIKE '".substr($sunit, 0, 5)."%'", "kdunit");
						$nunit = mysql_num_rows($ounit);
					}
					
					if ($nunit > 0)
					{
						while ($xunit = mysql_fetch_array($ounit))
						{ ?>
						
							<option value="<?php echo $xunit['kdunit']; ?>" <?php if ($xunit['kdunit'] == $unit) echo "selected"; ?>><?php 
								
								echo "[".$xunit['kdunit']."] ".$xunit['nmunit']; ?>
                            
                            </option><?php
						
						}
					} ?>
                
                </select>
            </td>
		</tr>
		<tr>
			<td class="key">Jabatan</td>
			<td>
            	<select name="level">
                	<option value=""></option>
                	<option value="DITJEN" <?php if ($eselon == "DITJEN") echo "selected"; ?>>Direktur Jenderal</option>
                	<option value="DIT" <?php if ($eselon == "DIT") echo "selected"; ?>>Direktur / Sesditjen</option>
                	<option value="SUBDIT" <?php if ($eselon == "SUBDIT") echo "selected"; ?>>Ka. Bagian / Ka. Subdit</option>
                	<option value="SEKSI" <?php if ($eselon == "SEKSI") echo "selected"; ?>>Ka. Subbag / Ka. Seksi</option>
                	<option value="UPT" <?php if ($eselon == "UPT") echo "selected"; ?>>Ka. UPT</option>
                	<option value="STAF" <?php if ($eselon == "STAF") echo "selected"; ?>>Staf</option>
                </select>
            </td>
		</tr>
		<tr>
			<td class="key">Alamat</td>
			<td><input type="text" name="alamat" size="40" value="<?php echo $alamat; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Telepon</td>
			<td><input type="text" name="telepon" size="40" value="<?php echo $telepon; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Email</td>
			<td><input type="text" name="email" size="40" value="<?php echo $email; ?>" /></td>
		</tr><?php
        
		if ($q == "")
		{ ?>
			
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="key">Password</td>
                <td><input type="password" name="password" size="40" value="" /></td>
            </tr>
            <tr>
                <td class="key">Ketik Ulang Password</td>
                <td><input type="password" name="password2" size="40" value="" /></td>
            </tr><?php
        
		}
		
		else
		{ ?>
			
			<input type="hidden" name="password" value="<?php echo $password; ?>" /><?php
		
		} ?>
        
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
						<a onclick="Btn_Submit('pegawai')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="pegawai" value="1" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>