<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_ikk_subprogram";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$prn_link = "index.php?p=";
	
	$oList = mysql_query("select * from $table order by concat(kdprogram,kdsubprogram,kdikk)");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
		$prn[] = $prn_link."&q=".$List->$field[0];
	}
	
?>
<table width="652" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="14%">No.</th>
			<th width="16%">Deputi</th>
			<th width="32%">Uraian</th>
			<th width="31%">Alasan</th>
			<th>Cetak</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td align="left"><?php if($col[2][$k] <> $col[2][$k-1]){?><?php echo deputi_subprogram($col[2][$k]) ?><?php }?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="left"><?php echo $col[10][$k] ?></td>
					<td width="7%" align="center"><?php if($col[2][$k] <> $col[2][$k-1]){?>
						<a href="menus/master/cetak_iku_prn.php?kdunit=<?php echo kddeputi_subprogram($col[2][$k]) ?>" title="Cetak" target="_blank"><img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"></a><?php }?></td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>