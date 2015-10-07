<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "tb_program";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$oList = mysql_query("select * from $table order by kddept,kdunit,kdprogram");
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
			<th width="9%" rowspan="2">No.</th>
			<th colspan="3">Kode</th>
			<th width="29%" rowspan="2">Nama Program </th>
			<th width="25%" rowspan="2">Outcome</th>
			<th colspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="13%">Departemen</th>
		  <th width="5%">Unit</th>
		  <th width="9%">Program</th>
		  <th colspan="2">&nbsp;</th>
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
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="center"><?php echo $col[2][$k] ?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="left"><?php echo $col[5][$k] ?></td>
					<td width="3%" align="center">
						<a href="<?php echo $ed[$k] ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="7%" align="center">
						<a href="<?php echo $del[$k] ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
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
