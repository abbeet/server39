<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_ikk_subprogram";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = date('Y');
	$renstra = th_renstra($th);

	$oList = mysql_query("select * from $table 	WHERE ta='$renstra' order by concat(kdprogram,kdsubprogram,kdikk)");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<strong><?php echo 'Periode Renstra : '.$renstra ?></strong><br>
<table width="689" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%" rowspan="2">No.</th>
			<th rowspan="2" width="11%">Program</th>
			<th rowspan="2" width="16%">Pilar</th>
			<th width="6%" rowspan="2">Kode IKU</th>
			<th width="16%" rowspan="2">IKU</th>
			<th colspan="5">Target</th>
			<th width="9%" rowspan="2">Mendukung IKU Kementerian?</th>
			<th colspan="2" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="6%">2010</th>
	      <th width="6%">2011</th>
	      <th width="6%">2012</th>
	      <th width="6%">2013</th>
	      <th width="6%">2014</th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="13">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td align="left"><?php if($col[1][$k] <> $col[1][$k-1]){?><?php echo nm_program('04201'.$col[1][$k]) ?><br />
					<strong>Outcome :</strong><br /><?php echo outcome_program('04201'.$col[1][$k]) ?>
					<?php }?></td>
					<td align="left"><?php if($col[1][$k].$col[2][$k] <> $col[1][$k-1].$col[2][$k-1]){?><?php echo nm_subprogram('04201'.$col[1][$k].$col[2][$k]) ?><br /><strong>Outcome :</strong><br /><?php echo outcome_subprogram('04201'.$col[1][$k].$col[2][$k]) ?><br /><strong>Deputi :</strong><br /><?php echo deputi_subprogram($col[2][$k]) ?><?php }?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="left"><?php echo $col[4][$k] ?><br /><strong>Alasan :</strong><br /><?php echo $col[10][$k] ?></td>
					<td align="center"><?php echo $col[5][$k] ?></td>
					<td align="center"><?php echo $col[6][$k] ?></td>
					<td align="center"><?php echo $col[7][$k] ?></td>
					<td align="center"><?php echo $col[8][$k] ?></td>
					<td align="center"><?php echo $col[9][$k] ?></td>
					<td align="center"><?php if ($col[11][$k] == 1) { ?>
							<img src="css/images/tick.png" border="0" width="16" height="16"><?php
						}
						else { ?>
							<img src="css/images/minus.png" border="0" width="16" height="16"><?php
						} ?></td>
					<td width="3%" align="center">
						<a href="<?php echo $ed[$k] ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="4%" align="center">
						<a href="<?php echo $del[$k] ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="13">&nbsp;</td>
		</tr>
	</tfoot>
</table>
