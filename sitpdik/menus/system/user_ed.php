<?php
	checkauthentication();
	$table = "xuser_pegawai";
	$field = get_field($table);
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['xuser'])
	{
		extract($_POST);
		
		if ($username != "")
		{
			$sql = "SELECT username FROM xuser_pegawai WHERE username = '".$username."' AND username != '".$id."'";
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
							$username	= str_replace("'", "", $username);
							$len 		= strlen($password);
							$password 	= encode_password(md5($password), $len);
							$reset		= "1";
							
							foreach ($field as $k=>$val) 
							{
								$value[$k] = $$val;
							}
					
							$sql 		= sql_insert($table, $field, $value);
							$sql 		= str_replace("''", "NULL", $sql);
							$query 		= mysql_query($sql);
							
							if ($query == 1)
							{
								$msg	= "Tambah pengguna berhasil. Id = ".$username.".";
								
								update_log($msg, $table, $susername, 1);
								$_SESSION['errmsg'] = $msg;
							}
							
							else 
							{
								$msg = "Tambah pengguna gagal. Error = ".mysql_error().".";
								update_log($msg, $table, $susername, 0);
								$_SESSION['errmsg'] = $msg;
							}
						}
						
						else
						{
							$msg = "Tambah pengguna gagal. Kata sandi tidak sama.";
							update_log($msg, $table, $susername, 0);
							$_SESSION['errmsg'] = $msg;
						}
					}
					
					else
					{
						$msg = "Tambah pengguna gagal. Kata sandi kosong.";
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
						$msg = "Ubah pengguna berhasil. Id = ".$username.".";
						
						update_log($msg, $table, $susername, 1);
						$_SESSION['errmsg'] = $msg;
					}
						
					else 
					{
						$msg = "Ubah pengguna gagal. Error = ".mysql_error().".";
						update_log($msg, $table, $susername, 0);
						$_SESSION['errmsg'] = $msg;			
					}
				}
			}
				
			else
			{
				$msg = "Tambah/ubah pengguna gagal. Nama pengguna sudah digunakan. Id = ".$username.".";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		}
		
		else
		{
			$msg = "Tambah/ubah pengguna gagal. Nama pengguna kosong.";
			update_log($msg, $table, $susername, 0);
			$_SESSION['errmsg'] = $msg;
			$err = true;
		} ?>
							
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
        
        exit();
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("xuser_pegawai", "username, password, email, lastlogin, aktif, reset, kunci, level, unit, nama", "username = '".$q."'", 
		"username");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{	
			while ($list = mysql_fetch_array($olist))
			{
				$id 		= $list['username'];
				$nama		= $list['nama'];
				$levelname	= $list['level'];
				$password	= $list['password'];
				$login		= $list['lastlogin'];
				$unit		= $list['unit'];
				$aktif 		= $list['aktif'];
				$reset 		= $list['reset'];
				$kunci		= $list['kunci'];
				$email		= $list['email'];
			}
		}
		
		else
		{
			$id 		= "";
			$nama		= "";
			$password	= "";
			$email		= "";
			$login		= "";
			$unit 		= "";
			$aktif 		= "";
			$reset 		= "";
			$kunci		= "";
			$email		= "";
			$levelname 	= "";
		}
	}
	
	else 
	{
		$id 		= "";
		$nama		= "";
		$password	= "";
		$email		= "";
		$login		= "";
		$unit 		= "";
		$aktif 		= "";
		$reset 		= "";
		$kunci		= "";
		$email		= "";
		$levelname 	= "";
	}
?>

<form method="post" name="xuser">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nama Pengguna (Nip)</td>
			<td><input type="text" name="username" size="40" value="<?php echo $id; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Nama Pegawai</td>
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
			<td class="key">Level Akses</td>
			<td><?php
				
				if ($slevel == "DEV") $olevel = xlevel("kode, name", "", "ordering");
				else $olevel = xlevel("kode, name", "kode NOT LIKE 'DEV' AND kode NOT LIKE 'ADM' AND kode NOT LIKE 'MEN' AND kode NOT LIKE 'WAMEN' AND kode 
				NOT LIKE 'DITJEN'", "ordering");
				
				$nlevel = mysql_num_rows($olevel);
				
				if ($nlevel > 0)
				{
					while ($xlevel = mysql_fetch_array($olevel)) 
					{ ?>
					
						<input type="radio" name="level" value="<?php echo $xlevel['kode']; ?>" <?php 
						if ($levelname == $xlevel['kode']) echo "checked=\"checked\""; ?> /><?php echo $xlevel['name']; ?><br /><?php
					}
				}
				
				else echo "&nbsp;"; ?>
				
			</td>
		</tr>
		<tr>
			<td class="key">Email</td>
			<td><input type="text" name="email" size="40" value="<?php echo $email; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Aktif</td>
			<td>
				<input type="radio" name="aktif" value="1" <?php if ($aktif == 1) echo "checked=\"checked\""; ?>/>Ya&nbsp;
				<input type="radio" name="aktif" value="0" <?php if ($aktif == 0) echo "checked=\"checked\""; ?>/>Tidak
			</td>
		</tr><?php
        
		if ($q == "")
		{ ?>
		
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
						<a onclick="Btn_Submit('xuser')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="xuser" value="1" />
                <input type="hidden" name="password3" value="<?php echo $password; ?>" />
                <input type="hidden" name="lastlogin" value="<?php echo $login; ?>" />
                <input type="hidden" name="reset" value="<?php echo $reset; ?>" />
                <input type="hidden" name="kunci" value="<?php echo $kunci; ?>" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>