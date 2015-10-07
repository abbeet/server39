<?php
	checkauthentication();
	$p = $_GET['p'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$table = "xuser";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
//	$oList = xuser_list();
	if ( $xlevel == 2 )
	{
	$oList = mysql_query( "SELECT * FROM $table WHERE kode_unit = '$xkdunit' and level <> '1' ORDER BY kode_unit");
	}else{
	$oList = mysql_query( "SELECT * FROM $table ORDER BY kode_unit");
	}
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
			<th>Username / Nama</th>
			<th width="12%">Unit Kerja </th>
			<th width="15%">Level</th>
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
					<td><?php if ( substr($col[1][$k],0,1) == '1' or substr($col[1][$k],0,1) == '2' ) { ?><?php echo $col[1][$k].' ('.nama_peg($col[1][$k]).')' ?><?php }else{ ?><?php echo $col[1][$k] ?><?php } ?></td>
					<td align="center"><?php echo nm_unitkerja($col[2][$k]) ?>
					</td>
					<td align="center"><?php 
						$oLevel = mysql_query("SELECT name FROM xlevel WHERE id = '".$col[4][$k]."'");
						$Level = mysql_fetch_array($oLevel);
						echo $Level['name']; ?>
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