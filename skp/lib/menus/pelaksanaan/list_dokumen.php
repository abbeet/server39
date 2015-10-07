<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "document";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
//	$tf_link = "index.php?p=".get_tf_link($p);
	$oList = document_list();
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
		$tf[] = $tf_link."&q=".$List->$field[0];
	}
?>

<table width="738" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%">No.</th>
			<th width="50%">Judul Dokumen </th>
			<th width="13%">Kode Dokumen </th>
			<th width="13%">Penulis</th>
			<th width="8%">Nama File </th>
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
					<td><?php echo $col[2][$k] ?></td>
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="center"><a href="files/<?php echo $col[5][$k] ?>" title="Lihat isi file" target="_blank"><?php echo $col[5][$k] ?></a></td>
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
