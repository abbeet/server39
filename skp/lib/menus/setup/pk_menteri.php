<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_iku_program";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = '2012';
	$oList = mysql_query("select * from $table order by concat(kdprogram,kddeputi,kdiku)");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?><?php echo '<strong> Tahun : '.$th.'</strong>' ?>
<table width="921" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="26%">Sasaran Strategis </th>
			<th width="24%">Indikator Kinerja Outcome </th>
			<th width="19%">Target</th>
			<th width="31%">Program</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="4">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="left"><?php if( $col[6][$k] <> $col[6][$k-1] ){ ?><?php echo outcome_deputi($col[6][$k]) ?><?php }?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="left"><?php echo $col[5][$k] ?></td>
					<td align="left"><?php if( nm_program(kdprogram_subprogram($col[6][$k])) <> nm_program(kdprogram_subprogram($col[6][$k-1])) ){ ?><?php echo nm_program(kdprogram_subprogram($col[6][$k])) ?><?php }?></td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"><?php echo '<strong> Jumlah Anggaran Tahun '.$th.' Rp.  '.number_format(anggaran_program($th,kdprogram_subprogram($col[6][$k])),"0",",",".").',- </strong>' ?></td>
		</tr>
	</tfoot>
</table>
