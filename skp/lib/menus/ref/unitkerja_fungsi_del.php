<?php
	checkauthentication();
	$table = "tb_unitkerja_fungsi";
	$p = $_GET['p'];
	$u = $_GET['u'];
	$form = $_POST['form'];
	$q = $_POST['q'];
		
	if (isset($form)) 
	{
		$sql = "DELETE FROM $table WHERE id = $q";
		$rs = mysql_query($sql);
		if ($rs) 
		{
			update_log($sql,$table,1);
			$_SESSION['errmsg'] = "Hapus data berhasil.";
		}
		else 
		{
			update_log($sql,$table,0);
			$_SESSION['errmsg'] = "Hapus data gagal!";
		} ?>
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=68&u=<?php echo $u; ?>"><?php
		exit();
	}
	else 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$oFungsi = mysql_query($sql);
		$value = mysql_fetch_array($oFungsi);
	}
?>

<table width="488" cellspacing="1" class="admintable">
	<tr>
		<td class="key">Kode Unit Kerja</td>
		<td><input type="text" size="40" readonly="readonly" value="<?php echo $value['kdunit'] ?>" /></td>
	</tr>
	<tr>
		<td class="key">Kode Fungsi</td>
		<td><input type="text" size="40" readonly="readonly" value="<?php echo $value['kdfungsi'] ?>" /></td>
	</tr>
	<tr>
	  <td class="key">Fungsi</td>
	  <td><input type="text" size="40" readonly="readonly" value="<?php echo $value['nmfungsi'] ?>" /></td>
  </tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&u=<?php echo $u; ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=68')">Batal</a>
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
