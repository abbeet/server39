<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "trash_terms";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
		
	if ($_GET['h'] != "") $filter = "term LIKE '".$_GET['h']."%'";
	else if ($_GET['c'] != "") $filter = "term LIKE '%".$_GET['c']."%'";
	else $filter = "term LIKE 'a%'";
	
	$oList = trash_terms_list($filter);
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>

<table>
	<tr>
		<td width="100%">
			<div class="button2-left">
				<div class="page"><?php
					
					for ($ascii = 65; $ascii <= 90; $ascii++)
					{
						if ($_GET['h'] == strtolower(chr($ascii)))
						{ ?>
							<span><?php echo chr($ascii) ?></span><?php
						}
						else { ?>
							<a href="<?php echo "index.php?p=34&h=".strtolower(chr($ascii)) ?>"><?php echo chr($ascii) ?></a><?php
						}
					} ?>
					
				</div>
			</div>
		</td>
		<td nowrap="nowrap">
			<form method="get" action="index.php">
				<input type="hidden" name="p" value="34" />
				Cari: <input type="text" name="c" size="40" class="text_area" />
			</form>
		</td>
	</tr>
</table>

<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">No.</th>
			<th>Kata </th>
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
					<td align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td align="center">
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
