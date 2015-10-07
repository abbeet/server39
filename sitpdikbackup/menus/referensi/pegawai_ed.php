<?php
	checkauthentication();
	$table = "pegawai";
	$field = get_field($table);
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['pegawai'])
	{
		extract($_POST);
		
		if ($nip != "")
		{
			$sql = "SELECT * FROM pegawai WHERE nip = '".$nip."' AND nip != '".$id."'";
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
							foreach ($field as $k=>$val) 
							{
								$value[$k] = $$val;
							}
					
							$sql 		= sql_insert($table, $field, $value);
							$sql 		= str_replace("''", "NULL", $sql);
							$query 		= mysql_query($sql);
							
							if ($query == 1)
							{
								$msg	= "Tambah pegawai berhasil. Id = ".$nip.".";
								
								$field	= get_field("xuser");
								$value	= array($nip, $unit, $password, $email, NULL, "1", "1", NULL);
								
								$sql	= sql_insert("xuser", $field, $value);
								$query2 = mysql_query($sql);
								
								if ($query2 == 1)
								{
									switch ($eselon)
									{
										case "1": $level = "DITJEN"; break;
										case "2": $level = "DIT"; break;
										case "3": $level = "SUBDIT"; break;
										case "4": $level = "SEKSI"; break;
										default: $level = "STAF";
									}
									
									$field 	= get_field("xuserlevel");
									$value 	= array("", $nip, $level);
									
									$sql	= sql_insert("xuserlevel", $field, $value);
									$query3	= mysql_query($sql);
									
									if ($query3 <> 1) $msg .= " Tambah user level gagal. Error = ".mysql_error().".";
									
									update_log($msg, $table, $susername, 1);
									$_SESSION['errmsg'] = $msg;
								}
								
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
					foreach ($field as $k=>$val) 
					{
						$value[$k] = $$val;
					}
								
					$field[]	= "nip";
					$value[]	= $nip;
					$value[0]	= $id;
					
					$sql 		= sql_update($table, $field, $value);
					$sql		= str_replace("''", "NULL", $sql);
					$query		= mysql_query($sql);
					
					if ($query == 1) 
					{
						$msg = "Ubah pegawai berhasil. Id = ".$nip.".";
						
						if ($nip != $id)
						{
							$sql = "UPDATE xuser SET username = '".$nip."' WHERE username = '".$id."'";
							$query2 = mysql_query($sql);
							
							if ($query2 == 1)
							{
								switch ($eselon)
								{
									case "1": $level = "DITJEN"; break;
									case "2": $level = "DIT"; break;
									case "3": $level = "SUBDIT"; break;
									case "4": $level = "SEKSI"; break;
									default: $level = "STAF";
								}
								
								$ocheck = xuserlevel("id, level", "username = '".$nip."'");
								$ncheck = mysql_num_rows($ocheck);
								
								if ($ncheck > 0)
								{
									$check = mysql_fetch_array($ocheck);
									
									if ($level != $check['level'])
									{
										$field 	= array("id", "level");
										$value 	= array($check['id'], $level);
										$sql 	= sql_update("xuserlevel", $field, $value);
										$query3 = mysql_query($sql);
										
										if ($query3 <> 1) $msg .= " Ubah user level gagal. Error = ".mysql_error().".";
									}
								}
								
								else
								{
									if ($level != "")
									{
										$field 	= get_field("xuserlevel");
										$value 	= array("", $username, $level);
										
										$sql 	= sql_insert("xuserlevel", $field, $value);
										$query3 = mysql_query($sql);
										
										if ($query3 <> 1) $msg .= " Ubah user level gagal. Error = ".mysql_error().".";
									}
								}
								
								update_log($msg, $table, $susername, 1);
								$_SESSION['errmsg'] = $msg;
							}
						}
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
				$msg = "Tambah/ubah pegawai gagal. Nip pegawai sudah digunakan. Id = ".$nip.".";
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
		$sql = sql_select("pegawai p LEFT OUTER JOIN unit u ON p.unit = u.kdunit LEFT JOIN xuser us ON p.nip = us.username", "p.nip, p.nama, p.eselon, 
		p.alamat, p.telepon, u.kdunit, us.email", "p.nip = '".$q."'", "p.nip");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			
			while ($list = mysql_fetch_array($olist))
			{
				$id 		= $list['nip'];
				$nama		= $list['nama'];
				$unit		= $list['kdunit'];
				$eselon		= $list['eselon'];
				$alamat		= $list['alamat'];
				$telepon	= $list['telepon'];
				$email		= $list['email'];
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
	}
?>

<form method="post" name="pegawai">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nip</td>
			<td><input type="text" name="nip" size="40" value="<?php echo $id; ?>" /></td>
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
			<td class="key">Eselon</td>
			<td>
            	<select name="eselon">
                	<option value=""></option>
                	<option value="1" <?php if ($eselon == "1") echo "selected"; ?>>Eselon 1</option>
                	<option value="2" <?php if ($eselon == "2") echo "selected"; ?>>Eselon 2</option>
                	<option value="3" <?php if ($eselon == "3") echo "selected"; ?>>Eselon 3</option>
                	<option value="4" <?php if ($eselon == "4") echo "selected"; ?>>Eselon 4</option>
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