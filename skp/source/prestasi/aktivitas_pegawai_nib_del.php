<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp");
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
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=388"><?php
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
		<td class="key">Tanggal</td>
		<td><input name="text" type="text" value="<?php echo reformat_tgl($value[2]) ?>" size="30" readonly="readonly" /></td>
	</tr>
	<tr>
		<td class="key">Nama Aktivitas  </td>
		<td><textarea name="" cols="70" rows="2" readonly="readonly"><?php echo $value[4] ?></textarea></td>
	</tr>
	<tr>
	  <td class="key">Hasil</td>
	  <td><textarea name="" cols="70" rows="2" readonly="readonly"><?php echo $value[5] ?></textarea></td>
  </tr>
	
	<tr>
		<td>&nbsp;</td>
		
		
		<script type="text/javascript">
			function del_submit()
			{
				document.forms['form'].submit();
			}
		</script>
		
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=388')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="del_submit();">Hapus</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Hapus" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</form>		</td>
	</tr>
</table>
