<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_iku_program";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$oList = mysql_query("select * from $table order by concat(kdprogram,kddeputi,kdiku)");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<a href="menus/master/cetak_ikumenteri_prn.php" title="Cetak" target="_blank">Cetak<img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"></a>
<table width="652" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="10%">No.</th>
			<th width="43%">Uraian</th>
			<th width="47%">Alasan</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="3">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="left"><?php echo $col[7][$k] ?></td>
				</tr>
				<?php
			}
		} ?>
	</tbody>
	
	
	<tfoot>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</tfoot>
</table>
