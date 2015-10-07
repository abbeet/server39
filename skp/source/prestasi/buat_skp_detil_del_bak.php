<?php
	checkauthentication();
	$table = "dtl_skp";
	$field = get_field($table);
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$cari = $_REQUEST['cari'];
	$pagess = $_REQUEST['pagess'];
	$id_skp = $_REQUEST['id_skp'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) {
		$sql = sql_delete($table,$field[0],$q);
		$rs = mysql_query($sql);
		if ($rs) {
			update_log($sql,$table,1);
			$_SESSION['errmsg'] = "Hapus data berhasil.";
		}
		else {
			update_log($sql,$table,0);
			$_SESSION['errmsg'] = "Hapus data gagal!";
		} ?>
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=264&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<table width="617" cellspacing="1" class="admintable">
	<tr>
		<td width="144" class="key">Id</td>
		<td width="464"><input type="text" size="5" readonly="readonly" value="<?php echo $value[0] ?>" /></td>
	</tr>
	<tr>
		<td class="key">Id SKP </td>
		<td><input name="text" type="text" value="<?php echo $value[1] ?>" size="10" readonly="readonly" /></td>
	</tr>
	<tr>
		<td class="key">Nama Tugas  </td>
		<td><textarea name="" cols="70" rows="2" readonly="readonly"><?php echo $value[2] ?></textarea></td>
	</tr>
	<tr>
	  <td class="key">No Urut </td>
	  <td><input name="text" type="text" value="<?php echo $value[3] ?>" size="10" readonly="readonly" /></td>
  </tr>
	
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=264&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Hapus</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Hapus" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</form>		</td>
	</tr>
</table>
