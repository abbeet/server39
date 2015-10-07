<?php
	checkauthentication();
	$table = "mst_potongan";
	$field = get_field($table);
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdbulan = $_REQUEST['kdbulan'];
	$pagess = $_REQUEST['pagess'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
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
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>"><?php
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<table width="617" cellspacing="1" class="admintable">
	<tr>
		<td width="120" class="key">id</td>
		<td width="488"><input type="text" size="5" readonly="readonly" value="<?php echo $value[0] ?>" /></td>
	</tr>
	<tr>
	  <td class="key">Bulan</td>
	  <td><input type="text" size="5" readonly="readonly" value="<?php echo $value[2] ?>" />&nbsp;&nbsp;Tahun&nbsp;&nbsp;<input type="text" size="5" readonly="readonly" value="<?php echo $value[1] ?>" /></td>
  </tr>
	<tr>
		<td class="key">Nip</td>
		<td><input type="text" size="20" readonly="readonly" value="<?php echo $value[3] ?>" /></td>
	</tr>
	<tr>
		<td class="key">Nama Nama </td>
		<td><input type="text" size="80" readonly="readonly" value="<?php echo nama_peg($value[3]) ?>" /></td>
	</tr>
	<tr>
	  <td class="key">Grade</td>
	  <td><input type="text" size="5" readonly="readonly" value="<?php echo $value[17] ?>" /></td>
  </tr>
	

	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>')">Batal</a>					</div>
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
