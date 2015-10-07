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
	
	if (isset($form)) {	
		if ($username == "") {
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Nama pengguna kosong!";
			$err = true;
		}
		
		$sql = sql_select($table,"username='".$username."'");
		$rs = mysql_query($sql);
		$count = mysql_num_rows($rs);
		
		if ($count != 0 and $q == '') {
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Username sudah ada!";
			$err = true;
		}
		
		if ($password == "" and $valpassword == "") {
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Password kosong!";
			$err = true;
		}
		
		if ($password != $retrypassword) {
			$_SESSION['errmsg'] = "Input/Ubah data gagal! Konfirmasi password tidak sama!";
			$err = true;
		}
		
		if ($err != true) {			
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
			
			if ($q == "") {
				//ADD NEW
				$value[3] = md5($password);
				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else {
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	}
?>

<form action="index.php?p=<?php echo $p ?>" method="post" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="<?php echo $field[1] ?>" size="40" value="<?php echo $value[1] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Unit Kerja</td>
			<td>
				<select name="<?php echo $field[2] ?>">
					<option value=""></option><?php
					$oUnit = unit_list();
					while ($Unit = mysql_fetch_object($oUnit)) { ?>
						<option value="<?php echo substr($Unit->kode,0,2) ?>" <?php if (substr($Unit->kode,0,2) == $value[2]) echo "selected" ?>><?php echo $Unit->singkatan ?></option><?php
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Level Akses</td>
			<td><?php
				$rs = xlevel("id > ".$xlevel_session,"id");
				while ($xlevel = mysql_fetch_object($rs)) { ?>
					<input name="level<?php echo $xlevel->id ?>" type="checkbox" value="<?php echo $xlevel->id ?>" <?php if (strpos($value[4],$xlevel->id) !== false) echo "checked=\"checked\"" ?> /><?php echo $xlevel->name ?><br /><?php
				} ?>
			</td>
		</tr><?php
		
		if (empty($_GET['q'])) { ?>
			<tr>
				<td class="key">Password</td>
				<td><input type="password" name="<?php echo $field[3] ?>" size="40" value="" /></td>
			</tr>
			<tr>
				<td class="key">Konfirmasi Password</td>
				<td><input type="password" name="retrypassword" size="40" value="" /></td>
			</tr><?php
		}
		else { ?>
			<input type="hidden" name="<?php echo $field[3] ?>" value="<?php echo $value[3] ?>" />
			<input type="hidden" name="retrypassword" value="<?php echo $value[3] ?>" /><?php
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
				<input name="valpassword" type="hidden" value="<?php echo $value[3] ?>" />
				<input name="lastvisit" type="hidden" value="<?php echo $value[5] ?>" />
			</td>
		</tr>
	</table>
</form>