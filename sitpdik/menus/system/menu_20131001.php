<?php
	checkauthentication();
	$p = $_GET['p'];
	$field = get_field("xmenu");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$oList = xmenu_list();
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
		
		$oList2 = xmenu_list($List->$field[0]);
		while($List2 = mysql_fetch_object($oList2)) {
			$List2->name = "&nbsp; &nbsp; ".$List2->name;
			foreach ($field as $k=>$val) {
				$col[$k][] = $List2->$val;
			}
			$ed[] = $ed_link."&q=".$List2->$field[0];
			$del[] = $del_link."&q=".$List2->$field[0];
			
			$oList3 = xmenu_list($List2->$field[0]);
			while($List3 = mysql_fetch_object($oList3)) {
				$List3->name = "&nbsp; &nbsp; &nbsp; &nbsp; ".$List3->name;
				foreach ($field as $k=>$val) {
					$col[$k][] = $List3->$val;
				}
				$ed[] = $ed_link."&q=".$List3->$field[0];
				$del[] = $del_link."&q=".$List3->$field[0];
				
				$oList4 = xmenu_list($List3->$field[0]);
				while($List4 = mysql_fetch_object($oList4)) {
					$List3->name = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".$List3->name;
					foreach ($field as $k=>$val) {
						$col[$k][] = $List4->$val;
					}
					$ed[] = $ed_link."&q=".$List4->$field[0];
					$del[] = $del_link."&q=".$List4->$field[0];
				}
			}
		}
	}
?>

<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th nowrap="nowrap">Nama</th>
			<th width="14%">Judul</th>
			<th>Tipe</th>
			<th width="6%">Parent ID</th>
			<th width="6%">Tampil</th>
			<th width="6%">Level Akses</th>
			<th width="6%">Aksi</th>
			<th width="10%">Letak File</th>
			<th width="6%">Order</th>
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
					<td nowrap="nowrap"><?php echo $col[1][$k] ?></td>
					<td><?php echo $col[2][$k] ?></td>
					<td><?php echo $col[3][$k] ?></td>
					<td align="center"><?php echo $col[4][$k] ?></td>
					<td align="center"><?php 
						if ($col[5][$k] == 1) { ?>
							<img src="css/images/tick.png" border="0" width="16" height="16"><?php
						}
						else { ?>
							<img src="css/images/cancel_f2.png" border="0" width="16" height="16"><?php
						} ?>
					</td>
					<td align="center"><?php 
						if ($col[6][$k] == "0,1,2,3,4,5,6,7,8,9") echo "All";
						else echo $col[6][$k]; ?>
					</td>
					<td align="center"><?php echo $col[7][$k] ?></td>
					<td><?php echo $col[8][$k] ?></td>
					<td align="center"><?php echo $col[9][$k] ?></td>
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