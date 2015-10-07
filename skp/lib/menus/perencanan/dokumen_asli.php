<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "document";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$list_link = "index.php?p=".get_list_link($p);
//	$tf_link = "index.php?p=".get_tf_link($p);
	$oList = document_list();
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed1[] = $ed_link."&q=".$List->$field[0]."&sw=1";
		$ed2[] = $ed_link."&q=".$List->$field[0]."&sw=2";
		$del[] = $del_link."&q=".$List->$field[0]."&kode=".$List->$field[1];
		$tf[] = $tf_link."&q=".$List->$field[0];
		$list[] = $list_link."&q=".$List->$field[5] ;
	}
?>

<table width="738" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%">No.</th>
			<th>Judul Dokumen </th>
			<th width="13%">Kode Dokumen </th>
			<th width="13%">Penulis</th>
			<th width="5%">Bahasa</th>
			<th width="8%">Nama File </th>
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
					<td><?php echo $col[2][$k] ?></td>
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="center"><?php echo $col[4][$k] ?></td>
					<td align="center"><a href="<?php echo $list[$k]?>" title="Lihat isi file" target="_blank"><?php echo $col[5][$k]?></a></td>
					<td width="8%" align="center"><a href="index.php?p=56&no=<?php echo $col[1][$k] ?>&bahasa=<?php echo $col[4][$k] ?>&nama_file=<?php echo $col[5][$k] ?>" title="Index isi file">Index</a>&nbsp;<?php if(cek_index($col[1][$k])=='1') { ?><img src="css/images/tick.png" border="0" width="16" height="16"><?php }?><br /><a href="index.php?p=56&no=<?php echo $col[1][$k] ?>&bahasa=<?php echo $col[4][$k] ?>&nama_file=<?php echo $col[5][$k] ?>" title="Re-index isi file">Re-Index</a></td>
					<td width="6%" align="center">
						<a href="<?php echo $ed1[$k] ?>" title="Ubah Diskripsi Dokumen">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>
						<br />		
						<a href="<?php echo $ed2[$k] ?>" title="Ubah File Dokumen">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>			</td>
					<td width="3%" align="center">
						<a href="<?php echo $del[$k] ?>" title="Hapus">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo count($field)+1 ?>">&nbsp;</td>
