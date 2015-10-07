<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "tb_satker";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$oList = tb_satker_list();
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>

<table width="738" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%">No.</th>
			<th width="17%">Kode Satker </th>
			<th width="67%">Nama Satker </th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="<?php echo count($field)+1 ?>">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td width="6%" align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
					<td width="3%" align="center">
						<a href="<?php echo $del[$k] ?>" title="Hapus">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo count($field)+1 ?>">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php 
	function cek_index($kode)
	{
		$hasil = '0' ;
		$dt_tf = mysql_query("select kd_doc from tf_document where kd_doc='$kode'");
		$vdt_tf = mysql_fetch_array($dt_tf);
		if( !empty($vdt_tf) ) $hasil='1';
		return($hasil);
	}

?>