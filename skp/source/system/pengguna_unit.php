<?php
	checkauthentication();
	$p = $_GET['p'];
	$th = $_SESSION['xth'];
	$table = "xuser";
	$field = get_field($table);
	$kdunit = $_SESSION['xkdunit'];
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
		
	$oList = mysql_query("select * from $table where kode_unit = '$kdunit' order by username");
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
			<th width="10%">No.</th>
			<th width="35%">Username</th>
			<th width="35%">Nama Lengkap</th>
			<th width="27%">Level</th>
			<th width="16%">Unit Kerja</th>
			<th colspan="2">Aksi</th>
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
					<td align="left"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo nama_peg($col[1][$k]) ?></td>
					<td align="center">
					<?php 
						$oLevel = mysql_query("SELECT name FROM xlevel WHERE id = '".$col[4][$k]."'");
						$Level = mysql_fetch_array($oLevel);
						echo $Level['name']; ?>
					</td>
					<td align="center"><?php echo skt_unitkerja($col[2][$k]) ?></td>
					<td width="5%" align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="7%" align="center">
						<a href="<?php echo $del[$k] ?>" title="Hapus">
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
