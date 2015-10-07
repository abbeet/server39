<?php
	checkauthentication();
	$table = "th_pk";
	$field = get_field($table);
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	
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
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<table width="509" cellspacing="1" class="admintable">
	<tr>
	  <td width="119" class="key">Tahun</td>
	  <td width="381"><input type="text" size="10" readonly="readonly" value="<?php echo $value[1] ?>" /></td>
  </tr>
	<tr>
	  <td class="key">Deputi/Sestama</td>
	  <td><input type="text" size="60" readonly="readonly" value="<?php echo nm_unit($value[2]) ?>" /></td>
  </tr>
	<tr>
	  <td class="key">Sasaran</td>
	  <td><textarea readonly="readonly" cols="60" rows="3"><?php echo nm_sasaran(th_renstra($value[1]),$value[2],$value[6]) ?></textarea></td>
  </tr>
	<tr>
	  <td class="key">IKU</td>
	  <td><textarea readonly="readonly" cols="60" rows="3"><?php echo 'IKU '.$value[5].' : '.nm_iku(th_renstra($value[1]),$value[2],$value[5]) ?></textarea></td>
  </tr>
	<tr>
		<td class="key">No. Urut </td>
		<td><input type="text" size="5" readonly="readonly" value="<?php echo $value[3] ?>" /></td>
	</tr>
	<tr>
		<td class="key">Kinerja</td>
		<td><textarea readonly="readonly" cols="60" rows="3"><?php echo $value[4] ?></textarea></td>
	</tr>
	<tr>
	  <td class="key">Target</td>
	  <td><input type="text" size="60" readonly="readonly" value="<?php echo $value[7] ?>" /></td>
  </tr>
	
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>					</div>
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
