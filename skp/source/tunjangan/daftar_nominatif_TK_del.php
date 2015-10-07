<?php
	checkauthentication();
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdbulan = $_REQUEST['kdbulan'];
	$kdunit = $_REQUEST['kdunit'];
	$pagess = $_REQUEST['pagess'];
	
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
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>
		&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>"><?php
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
		<?php if ( substr($value[2],0,1) == '0' )   $bulan = substr($value[2],1,1) ;
			  else     $bulan = $value[2] ;?>
		<td><input type="text" size="30" readonly="readonly" value="<?php echo nama_bulan($bulan).' '.$value[1] ?>" /></td>
	</tr>
	<tr>
		<td class="key">Nama Pegawai </td>
		<td><input type="text" size="70" readonly="readonly" value="<?php echo nama_peg($value[3]) ?>" /></td>
	</tr>
	<tr>
	  <td class="key">Jabatan</td>
	  <td><input type="text" size="70" readonly="readonly" value="<?php echo nm_jabatan_ij($value[5],$value[4]) ?>" /></td>
  </tr>
	
	
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>
			&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>">				
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>
						&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>')">Batal</a>					</div>
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
