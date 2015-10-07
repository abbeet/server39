<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "t_satker";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$oList = mysql_query("select KDSATKER,NMSATKER,KDDEPT,KDUNIT,KDUNITKERJA from $table order by KDSATKER");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<table width="503" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="6%">No.</th>
      <th width="8%">Kode</th>
      <th width="60%">Satuan Kerja (Satker)</th>
      <th width="18%">Unit Kerja </th>
      <th width="8%">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="5">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><?php echo $k+1 ?></td>
      <td align="center"><?php echo $col[0][$k] ?></td>
      <td align="left"><?php echo $col[1][$k] ?></td>
      <td align="left"><?php echo ket_unit($col[4][$k]) ?></td>
      <td align="center"><a href="<?php echo $ed[$k] ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="5">&nbsp;</td>
    </tr>
  </tfoot>
</table>
