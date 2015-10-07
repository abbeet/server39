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
<table width="652" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%">No.</th>
			<th width="17%">Program</th>
			<th width="6%">Kode</th>
			<th width="14%">Sasaran</th>
			<th width="17%">IKU</th>
			<th width="15%">Target</th>
			<th width="18%">Alasan</th>
			<th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td align="left"><?php if($col[2][$k] <> $col[2][$k-1]){?><?php echo nm_program('04201'.$col[2][$k]) ?><br />
					<strong>Outcome : </strong><br /><?php echo outcome_program('04201'.$col[2][$k]) ?>
					<?php }?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="left"><?php if($col[6][$k] <> $col[6][$k-1]){?><?php echo outcome_deputi($col[6][$k]) ?><?php }?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="left"><?php echo $col[5][$k] ?></td>
					<td align="left"><?php echo $col[7][$k] ?></td>
					<td width="4%" align="center">
						<a href="<?php echo $ed[$k] ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="5%" align="center">
						<a href="<?php echo $del[$k] ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
	</tfoot>
</table>
