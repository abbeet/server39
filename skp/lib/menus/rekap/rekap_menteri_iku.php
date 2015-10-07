<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_iku_program";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = date('Y');
	$renstra = th_renstra($th);
	
	$oList = mysql_query("select * from $table WHERE ta='$renstra' order by concat(kdprogram,kddeputi,kdiku)");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?> <strong><?php echo 'Periode Renstra : '.$renstra ?></strong><br>
<a href="menus/rekap/cetak_menteri_iku.php" title="Cetak" target="_blank">Cetak<img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"></a>
<table width="652" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="7%">No.</th>
      <th width="45%">IKU</th>
      <th width="48%">Alasan</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="3">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>">
      <td align="center"><?php echo $k+1 ?></td>
      <td align="left"><?php echo $col[4][$k] ?></td>
      <td align="left"><?php echo $col[7][$k] ?></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="3"><strong> <?php echo 'Tugas dan Fungsi '.trim(ucwords(strtolower(nm_unit('420000')))) ?></strong><br><br>
	  <?php echo '<strong> Tugas : </strong>'.tugas_unit('420000')?><br><br>
	  <?php echo '<strong> Fungsi : </strong>' ?><br>
<?php $nom = 0 ;
	  $oList = mysql_query("select nmfungsi from tb_unitkerja_fungsi where kdunit='420000' order by kdfungsi ");
	  while($List = mysql_fetch_array($oList)) {
	  $nom += 1 ;
	  echo $nom.'.'.$List['nmfungsi']. '<br>' ;
	  }
?>
	  &nbsp;</td>
    </tr>
  </tfoot>
</table>
