<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "dt_pk";
	$field = array("id","th","kdunitkerja","no_sasaran","nourut_pk","indikator","target","no_iku","anggaran");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	
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
<!--a href="menus/kinerja/pk_eselon1_pdf.php?th=<?php echo $th ?>" title="Cetak PK Ditjenbud" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1"> PDF</font></a>&nbsp;&nbsp;|
<a href="menus/kinerja/pk_eselon1_xls.php?th=<?php echo $th ?>" title="Cetak PK Ditjenbud" target="_blank">
			  <font size="1">XLS</font></a-->
<table width="652" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th>Sasaran Strategis</th> 
      <th colspan="2">Indikator Kinerja</th>
      <th width="8%">Target</th>
      <th width="11%">Anggaran</th>
      <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="7">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$total += $col[8][$k] ;
				if( $col[3][$k] <> $col[3][$k-1] ) $no = 1;
				else $no += 1 ; ?>
    <tr class="<?php echo $class ?>">
      <td width="44%" align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){  ?><?php echo nm_sasaran($col[1][$k],$col[2][$k],$col[3][$k]) ?><?php } ?></td>
      <td width="3%" align="center" valign="top"><?php echo $col[4][$k] ?></td>
      <td width="15%" align="left" valign="top"><?php echo $col[5][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="right" valign="top"><?php echo number_format($col[8][$k],"0",",",".") ?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
    </tr>
    <?php
			}
		} ?>
    <tr class="<?php echo $class ?>">
      <td colspan="4" align="right" valign="top"><strong>Jumlah Anggaran</strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($total,"0",",",".") ?></strong></td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
  
  <tfoot>
    <tr> 
      <td colspan="7"><font color="#003399"><strong>Jumlah Alokasi anggaran program Direktorat Jenderal Kebudayaan sebesar Rp. <?php echo number_format(pagu_menteri($th),"0",",",".") ?></strong></font></td>
    </tr>
  </tfoot>
</table>
