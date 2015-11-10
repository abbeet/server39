<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "dt_pk";
	$field = array("id","th","kdunitkerja","no_sasaran","nourut_pk","indikator","target","no_iku","anggaran",
					"rencana_1","rencana_2","rencana_3","rencana_4",
					"rencana_aksi_1","rencana_aksi_2","rencana_aksi_3","rencana_aksi_4");
	
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$kdtriwulan = $_REQUEST['kdtriwulan'];
	
	if($_REQUEST['cari']){
		$kdtriwulan = $_REQUEST['kdtriwulan'];
	}

	$oList = mysql_query("select * from $table WHERE th = '$th' and kdunitkerja = '2320000' order by nourut_pk");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<table width="806" cellpadding="1" class="adminlist">
  <thead>
    
    <tr>
      <th width="3%" rowspan="3">No.</th>
      <th width="20%" rowspan="3">Indikator Kinerja </th>
      <th width="7%" rowspan="3">Target</th>
      <th colspan="8">Rencana Aksi</th>
      <th width="10%" rowspan="3">Anggaran</th>
      <th colspan="2" rowspan="3">Aksi</th>
    </tr>
    <tr>
      <th colspan="2">Tw I </th>
      <th width="7%" colspan="2">Tw II </th>
      <th width="7%" colspan="2">Tw III </th>
      <th width="7%" colspan="2">Tw IV </th>
    </tr>
    <tr>
      <th width="3%">%</th>
      <th width="4%">Rencana</th>
      <th width="7%">%</th>
      <th width="7%">Rencana</th>
      <th width="7%">%</th>
      <th width="7%">Rencana</th>
      <th width="7%">%</th>
      <th width="7%">Rencana</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="14">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><?php echo $col[4][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[5][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[9][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[13][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[10][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[14][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[11][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[15][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[12][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[16][$k] ?></td>
      <td align="right" valign="top"><?php echo number_format($col[8][$k],"0",",",".") ?></td>
      <td width="3%" align="center" valign="top"><a href="index.php?p=615&q=<?php echo $col[0][$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a></td>
      <td width="7%" align="center" valign="top"><a href="index.php?p=616&q=<?php echo $col[0][$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="14">&nbsp;</td>
    </tr>
  </tfoot>
</table>
