<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];

	$th = $_SESSION['xth'];
	
	$sql = "select KDDEPT,KDUNIT,THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' group by KDDEPT";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept']/1000;
		$col[3][] 	= $Dept['jan']/1000;
		$col[4][] 	= $Dept['peb']/1000;
		$col[5][] 	= $Dept['mar']/1000;
		$col[6][] 	= $Dept['apr']/1000;
		$col[7][] 	= $Dept['mei']/1000;
		$col[8][] 	= $Dept['jun']/1000;
		$col[9][] 	= $Dept['jul']/1000;
		$col[10][] 	= $Dept['agt']/1000;
		$col[11][] 	= $Dept['sep']/1000;
		$col[12][] 	= $Dept['okt']/1000;
		$col[13][] 	= $Dept['nop']/1000;
		$col[14][] 	= $Dept['des']/1000;
		$col[15][] 	= $Dept['KDDEPT'];
		$col[16][] 	= $Dept['KDUNIT'];
	}

?>
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama program</th>
      <th rowspan="2">Pagu<br>
        Anggaran/<br>
        Realisasi</th>
      <th rowspan="2">(%)</th>
      <th colspan="12">Rencana Penarikan / Realisasi Anggaran<br>
        ( dalam ribuan rupiah )</th>
    </tr>
    <tr> 
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="22">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr> 
      <?php 
	$real = realisasi_dept($th,$kddept)/1000 ;
	$real_1 = realisasi_dept_bl($th,$kddept,1)/1000;
	$real_2 = realisasi_dept_bl($th,$kddept,2)/1000;
	$real_3 = realisasi_dept_bl($th,$kddept,3)/1000;
	$real_4 = realisasi_dept_bl($th,$kddept,4)/1000;
	$real_5 = realisasi_dept_bl($th,$kddept,5)/1000;
	$real_6 = realisasi_dept_bl($th,$kddept,6)/1000;
	$real_7 = realisasi_dept_bl($th,$kddept,7)/1000;
	$real_8 = realisasi_dept_bl($th,$kddept,8)/1000;
	$real_9 = realisasi_dept_bl($th,$kddept,9)/1000;
	$real_10 = realisasi_dept_bl($th,$kddept,10)/1000;
	$real_11 = realisasi_dept_bl($th,$kddept,11)/1000;
	$real_12 = realisasi_dept_bl($th,$kddept,12)/1000;
	?>
      <td rowspan="2" align="center"><strong><?php echo $kddept.'.'.$kdunit ?></strong></td>
      <td rowspan="2" align="left"><strong><?php echo nm_unit(substr($kddept,1,2).'0000') ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td rowspan="2" align="right" valign="middle"><strong><?php echo number_format(($real/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[3][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[4][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[5][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[6][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[7][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[8][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[9][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[10][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[11][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[12][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[13][$k],"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[14][$k],"0",",",".") ?></strong></td>
    </tr>
    <tr> 
      <td align="right" class="row7"><strong><?php echo number_format($real,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_1,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_2,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_3,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_4,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_5,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_6,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_7,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_8,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_9,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_10,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_11,"0",",",".") ?></strong></td>
      <td align="right" class="row7"><strong><?php echo number_format($real_12,"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$kddept 		= $col[15][$k] ;
	$kdunit_dipa 	= $col[16][$k] ;
	$sql = "select KDPROGRAM, sum(JUMLAH) as pagu_program, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT='$kddept' and KDUNIT='$kdunit_dipa' group by KDPROGRAM order by KDPROGRAM";
	$aProgram = mysql_query($sql);
	while ($Program = mysql_fetch_array($aProgram))
	{
	$kdprogram = $Program['KDPROGRAM'] ;
	$real = realisasi_program($th,$kddept,$kdunit_dipa,$kdprogram)/1000 ;
	$real_1 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,1)/1000;
	$real_2 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,2)/1000;
	$real_3 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,3)/1000;
	$real_4 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,4)/1000;
	$real_5 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,5)/1000;
	$real_6 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,6)/1000;
	$real_7 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,7)/1000;
	$real_8 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,8)/1000;
	$real_9 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,9)/1000;
	$real_10 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,10)/1000;
	$real_11 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,11)/1000;
	$real_12 = realisasi_program_bl($th,$kddept,$kdunit_dipa,$kdprogram,12)/1000;
?>
    <tr> 
      <td rowspan="2" align="center"><?php echo $kddept.'.'.$kdunit_dipa.'.'.$kdprogram ?><br>
	  <a href="index.php?p=175&kddept=<?php echo $kddept ?>&kdunit_dipa=<?php echo $kdunit_dipa ?>&kdprogram=<?php echo $kdprogram ?>&th=<?php echo $th ?>" title="Realisasi Kegiatan"><font size="1">Detil>></font></a>
	  </td>
      <td rowspan="2" align="left"><?php echo nm_program($kddept.$kdunit_dipa.$kdprogram) ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['pagu_program']/1000,"0",",",".") ?></td>
      <td rowspan="2" align="right" valign="middle"><?php echo number_format(($real/($Program['pagu_program']/1000))*100,"2",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['jan']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['peb']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['mar']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['apr']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['mei']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['jun']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['jul']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['agt']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['sep']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['okt']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['nop']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['des']/1000,"0",",",".") ?></td>
    </tr>
    <tr> 
      <td align="right" class="row7"><?php echo number_format($real,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_1,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_2,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_3,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_4,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_5,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_6,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_7,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_8,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_9,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_10,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_11,"0",",",".") ?></td>
      <td align="right" class="row7"><?php echo number_format($real_12,"0",",",".") ?></td>
    </tr>
    <?php
		} # PROGRAM
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="21">&nbsp;</td>
    </tr>
  </tfoot>
</table>
