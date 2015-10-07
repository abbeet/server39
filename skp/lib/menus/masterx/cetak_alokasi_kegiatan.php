<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_aldana_kegiatan";

	$oList = mysql_query("select a.*, b.kdunitkerja from $table a JOIN tb_giat b ON a.kdgiat = b.kdgiat order by b.kdunitkerja");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		$col[1][] = $i;
		$col[2][] = $List->kdgiat;
		$col[3][] = $List->dana_2010;
		$col[4][] = $List->dana_2011;
		$col[5][] = $List->dana_2012;
		$col[6][] = $List->dana_2013;
		$col[7][] = $List->dana_2014;
		$col[8][] = $List->kdunitkerja;
	}

?>
<table width="633" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="7%" rowspan="2">No.</th>
      <th rowspan="2" width="21%">Kegiatan</th>
      <th colspan="5">Alokasi</th>
      <th width="9%" rowspan="2">Unit</th>
    </tr>
    <tr> 
      <th width="11%">2010</th>
      <th width="12%">2011</th>
      <th width="11%">2012</th>
      <th width="10%">2013</th>
      <th width="10%">2014</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="8">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><?php echo $col[1][$k] ?></td>
      <td align="left"><?php echo nm_giat($col[2][$k]) ?></td>
      <td align="center"><?php echo number_format($col[3][$k],"0",",",".") ?></td>
      <td align="center"><?php echo number_format($col[4][$k],"0",",",".") ?></td>
      <td align="center"><?php echo number_format($col[5][$k],"0",",",".") ?></td>
      <td align="center"><?php echo number_format($col[6][$k],"0",",",".") ?></td>
      <td align="center"><?php echo number_format($col[7][$k],"0",",",".") ?></td>
      <td align="center"><?php echo nm_unit($col[8][$k]) ?></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>
