<?php
	checkauthentication();
	$table = "xuser";
	$field = array("username","password","lastmodified","modifiedby");
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
		
	if (isset($form)) {
		$sql = check_login($xusername_sess,md5($oldpassword));
		$rs = mysql_query($sql);
		$count = mysql_num_rows($rs);
		
		if ($count == 0) {
			$_SESSION['errmsg'] = "Ubah password gagal! Password lama tidak sesuai!";
			$err = true;
		}
		
		if ($password == "") {
			$_SESSION['errmsg'] = "Ubah password gagal! Password baru kosong!";
			$err = true;
		}
		
		if ($password != $retrypassword) {
			$_SESSION['errmsg'] = "Ubah password gagal! Konfirmasi password tidak sama!";
			$err = true;
		}
		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$password = md5($password);
			$username = $xusername_sess;
						
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			// UPDATE
			$sql = sql_update($table,$field,$value);
			$rs = mysql_query($sql);
			
			if ($rs) {	
				update_log($sql,$table,1);
				$_SESSION['errmsg'] = "Ubah data berhasil!";
			}
			else {
				update_log($sql,$table,0);
				$_SESSION['errmsg'] = "Ubah data gagal!";			
			} ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p ?>"><?php
			exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p ?>" /><?php		
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Password Lama</td>
			<td><input type="password" name="oldpassword" size="40" value="" /></td>
		</tr>
		<tr>
			<td class="key">Password</td>
			<td><input type="password" name="<?php echo $field[1] ?>" size="40" value="" /></td>
		</tr>
		<tr>
			<td class="key">Konfirmasi Password</td>
			<td><input type="password" name="retrypassword" size="40" value="" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p ?>')">Batal</a>
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
			</td>
		</tr>
	</table>
</form>