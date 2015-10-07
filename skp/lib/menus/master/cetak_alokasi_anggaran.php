<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_aldana_kegiatan";

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
	$oList = mysql_query("select b.kddept as kd_dept, b.kdunit as kd_unit, b.kdprogram as kd_program from $table a JOIN tb_giat b ON a.kdgiat=b.kdgiat GROUP BY CONCAT(b.kddept,b.kdunit,b.kdprogram) ORDER BY CONCAT(b.kddept,b.kdunit,b.kdprogram) desc");
	while($List = mysql_fetch_array($oList)) {
 ?>
    <tr> 
      <td align="left" colspan="8"><?php echo strtoupper(nm_program($List['kd_dept'].$List['kd_unit'].$List['kd_program'])) ?></td>
    </tr>
    <?php
	$oList_deputi = mysql_query("select b.kdunitkerja as kd_unitkerja,sum(dana_2010) as jmldana_2010, sum(dana_2011) as jmldana_2011, sum(dana_2012) as jmldana_2012,
			sum(dana_2013) as jmldana_2013, sum(dana_2014) as jmldana_2014 from $table a JOIN tb_giat b ON a.kdgiat=b.kdgiat
			WHERE b.kddept='$List[kd_dept]' AND b.kdunit='$List[kd_unit]' AND b.kdprogram='$List[kd_program]'
			GROUP BY left(b.kdunitkerja,4) ORDER BY left(b.kdunitkerja,4)");
	while($List_deputi = mysql_fetch_array($oList_deputi)) {
	$kddeputi = substr($List_deputi['kd_unitkerja'],0,3);
 ?>
    <tr> 
      <td align="left">&nbsp;</td>
      <td align="left"><strong><?php echo pilar_deputi(substr($List_deputi['kd_unitkerja'],0,3).'000') ?></strong></td>
      <td align="left"><?php echo number_format($List_deputi['jmldana_2010'],"0",",",".") ?></td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <?php
	$oList = mysql_query("select a.kdgiat, a.dana_2010, a.dana_2011, a.dana_2012, a.dana_2013, a.dana_2014, b.kdunitkerja from $table a JOIN tb_giat b ON a.kdgiat=b.kdgiat 
					WHERE left(b.kdunitkerja,3)='$kddeputi' ORDER BY b.kdunitkerja");
	$count = mysql_num_rows($oList);
	$i = 1;
	while($List = mysql_fetch_object($oList)) {
		$col[1][] = $i++ ;
		$col[2][] = $List->kdgiat;
		$col[3][] = $List->dana_2010;
		$col[4][] = $List->dana_2011;
		$col[5][] = $List->dana_2012;
		$col[6][] = $List->dana_2013;
		$col[7][] = $List->dana_2014;
		$col[8][] = $List->kdunitkerja;
	}
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="8">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[1] as $k=>$val) {
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
			}
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>
