<?php
	checkauthentication();
	$table = "xuser";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_session = $_SESSION['xusername'];
	$xlevel_session = $_SESSION['xlevel'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{	
		if ($username == "") 
		{
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Nama pengguna kosong!";
			$err = true;
		}
		
		$sql = sql_select("xuser", "username='".$username."'");
		$rs = mysql_query($sql);
		$count = mysql_num_rows($rs);
		
		if ($count != 0 && $_GET['q'] == $username) 
		{
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Username sudah ada!";
			$err = true;
		}
		
		if ($password == "" and $valpassword == "") 
		{
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Password kosong!";
			$err = true;
		}
		
		if ($password != $retrypassword) 
		{
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Konfirmasi password tidak sama!";
			$err = true;
		}
		
		if ($err != true) 
		{
			$rs = xlevel("","id");
			$level = "";
			
			while ($xlevel = mysql_fetch_object($rs)) {
				$a = "level".$xlevel->id;
				$level .= $$a.",";
			}
				
			$lastmodified = now();
			$modifiedby = $xusername_session;			
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			#INSERT INTO xuser (id,username,password,level,lastmodified,modifiedby) VALUES ('','xxx','xxx','f561aaf6ef0bf14d4208bb46a4ccb3ad','2011-09-21 11:21:30','abrarhedar')
			
			if ($q == "") 
			{
				//ADD NEW
				$value[2] = md5($password);
				$sql = sql_insert("xuser", $field, $value);
				$rs = mysql_query($sql);
				
				if ($rs) 
				{
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else 
			{
				// UPDATE
				$sql = sql_update("xuser",$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) 
				{
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<!meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$value = get_value("xuser",$field,"id='".$_GET['q']."'");
	}
	else 
	{
		$value = "";
	}
	
	if (isset($form2)) 
	{
		if ($password == "") 
		{
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Password kosong!";
			$err = true;
		}
		
		if ($password != $retrypassword) 
		{
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Konfirmasi password tidak sama!";
			$err = true;
		}
		
		if ($err != true) 
		{
			$lastmodified = now();
			$modifiedby = $xusername_session;
			
			// UPDATE
			$sql = "UPDATE xuser SET password = '".md5($password)."', lastmodified = '".$lastmodified."', modifiedby = '".$modifiedby."' WHERE id = '".$q."'";
			$rs = mysql_query($sql);
			
			if ($rs) 
			{
				update_log($sql,$table,1);
				$_SESSION['errmsg'] = "Ubah data berhasil!";
			}
			else 
			{
				update_log($sql,$table,0);
				$_SESSION['errmsg'] = "Ubah data gagal!";			
			} ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		}
		else 
		{ ?>
			<!meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
?>

<form action="index.php?p=<?php echo $p ?>" method="post" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="<?php echo $field[1] ?>" size="40" value="<?php echo $value[1] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Level Akses</td>
			<td><?php
				$rs = xlevel("id > ".$xlevel_session,"id");
				while ($xlevel = mysql_fetch_object($rs)) { ?>
					<input name="level<?php echo $xlevel->id ?>" type="checkbox" value="<?php echo $xlevel->id ?>" <?php if (strpos($value[3],$xlevel->id) !== false) echo "checked=\"checked\"" ?> /><?php echo $xlevel->name ?><br /><?php
				} ?>
			</td>
		</tr>
		<tr>
			<td class="key">Unit Kerja</td>
			<td>
				<select name="kdunit">
					<option></option><?php
					$oUnit = mysql_query("SELECT * FROM tb_unitkerja where kdsatker <> '' ORDER BY KDUNIT");
					
					while ($Unit = mysql_fetch_array($oUnit))
					{ ?>
							<option value="<?php echo $Unit['kdunit']; ?>" <?php if ($Unit['kdunit'] == $value[7]) echo "selected"; ?>><?php echo $Unit['nmunit']; ?></option><?php
					} ?>
				</select>
			</td>
		</tr><?php
		
		if (empty($_GET['q'])) { ?>
			<tr>
				<td class="key">Password</td>
				<td><input type="password" name="<?php echo $field[2] ?>" size="40" value="" /></td>
			</tr>
			<tr>
				<td class="key">Konfirmasi Password</td>
				<td><input type="password" name="retrypassword" size="40" value="" /></td>
			</tr><?php
		}
		else { ?>
			<input type="hidden" name="<?php echo $field[2] ?>" value="<?php echo $value[2] ?>" />
			<input type="hidden" name="retrypassword" value="<?php echo $value[2] ?>" /><?php
		} ?>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
				<input name="valpassword" type="hidden" value="<?php echo $value[2] ?>" />
			</td>
		</tr>
	</table>
</form>
<br />
<br /><?php

if (!empty($_GET['q']))
{ ?>
	<fieldset title="Reset Password">
		<form action="index.php?p=<?php echo $p ?>" method="post" name="form2">
			<table class="admintable" cellspacing="1">
				<tr>
					<td colspan="2" align="center"><b>Reset Password</b></td>
				</tr>
				<tr>
					<td class="key">Password Baru</td>
					<td><input type="password" name="<?php echo $field[2] ?>" size="40" value="" /></td>
				</tr>
				<tr>
					<td class="key">Konfirmasi Password Baru</td>
					<td><input type="password" name="retrypassword" size="40" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>			
						<div class="button2-right">
							<div class="prev">
								<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>
							</div>
						</div>
						<div class="button2-left">
							<div class="next">
								<a onclick="form2.submit();">Simpan</a>
							</div>
						</div>
						<div class="clr"></div>
						<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
						<input name="form2" type="hidden" value="1" />
						<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset><?php
} ?>