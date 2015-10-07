<?php
	checkauthentication();
	$table = "document";
	$field = get_field($table);
	$p = $_GET['p'];
	$kode = $_REQUEST['kode'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	if (isset($form)) {
		$sql = sql_delete($table,$field[0],$q);
		$rs = mysql_query($sql);
		if ($rs) {
			mysql_query("delete from tf_document where kd_doc = '$kode'");
			update_log($sql,$table,1);
			$_SESSION['errmsg'] = "Hapus data berhasil.";
		}
		else {
			update_log($sql,$table,0);
			$_SESSION['errmsg'] = "Hapus data gagal!";
		} ?>
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<table class="admintable" cellspacing="1">
	<tr>
		<td class="key">id</td>
		<td><input type="text" size="5" readonly="readonly" value="<?php echo $value[0] ?>" /></td>
	</tr>
	<tr>
		<td class="key">Kode Dokumen </td>
		<td><input type="text" size="40" readonly="readonly" value="<?php echo $value[1] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Judul</td>
			<td><input type="text" size="70" readonly="readonly" value="<?php echo $value[2] ?>" /></td>
		</tr>
		<tr>
		  <td class="key">Penulis</td>
		  <td><input type="text" size="40" readonly="readonly" value="<?php echo $value[3] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Bahasa</td>
		  <td><input type="text" size="40" readonly="readonly" value="<?php echo $value[4] ?>" /></td>
	  </tr>

	  <tr>
		  <td class="key">Nama File </td>
		  <td><input type="text" name="nama_file" size="50" value="<?php echo $value[5] ?>"></td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&kode=<?php echo $kode ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Hapus</a>
					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Hapus" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</form>
		</td>
	</tr>
</table>