<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "xuser";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$oList = xuser_list();
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>

<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th>Nama</th>
			<th width="12%">Unit Kerja</th>
			<th width="12%">Level Akses</th>
			<th width="12%">Last Visited</th>
			<th width="4%">id</th>
			<th colspan="2" width="6%">Aksi</th>
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
					<td align="center"><?php echo unit_id($col[2][$k])->singkatan ?></td>
					<td align="center"><?php echo $col[4][$k] ?></td>
					<td align="center"><?php
						$lastvisit = explode(" ",$col[5][$k]);
						$date = date("d M Y",strtotime($lastvisit[0]));
						if ($col[5][$k] != '0000-00-00 00:00:00') echo $date." ".$lastvisit[1] ?>
					</td>
					<td align="center"><?php echo $val ?></td>
					<td align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
					</td>
					<td align="center">
						<a href="<?php echo $del[$k] ?>" title="Hapus">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">
						</a>
					</td>
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