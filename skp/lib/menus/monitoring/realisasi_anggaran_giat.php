<?php
	checkauthentication();
	
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$sw = $_REQUEST['sw'];
	
	$th = date('Y');
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];

	$sql = "select THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
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
		
	}

echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama Satuan Kerja / <br>
        Nama Kegiatan</th>
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
    <tr class="<?php echo $class ?>"> 
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
      <td rowspan="2" align="center"><strong><?php echo $kddept ?></strong></td>
      <td rowspan="2" align="left"><strong><?php echo nm_unit(substr($kddept,1,2).'0000') ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="22%" rowspan="2" align="right" valign="middle"><strong><?php echo number_format(($real/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[3][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[4][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[5][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[6][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[7][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[8][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[9][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[10][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[11][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[12][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[13][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right"><strong><?php echo number_format($col[14][$k],"0",",",".") ?></strong></td>
    </tr>
    <tr class="<?php echo $class ?>"> 
      <td align="right"><?php echo number_format($real,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_1,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_2,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_3,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_4,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_5,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_6,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_7,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_8,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_9,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_10,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_11,"0",",",".") ?></td>
      <td width="22%" align="right"><?php echo number_format($real_12,"0",",",".") ?></td>
    </tr>
    <?php 
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT='$kddept' and KDSATKER = '$xusername' group by KDSATKER order by KDSATKER";
			break;
		case '4':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
	}
	
	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	$kdsatker = $Satker['KDSATKER'] ;
	$real = realisasi_satker($th,$kdsatker)/1000 ;
	$real_1 = realisasi_satker_bl($th,$kdsatker,1)/1000;
	$real_2 = realisasi_satker_bl($th,$kdsatker,2)/1000;
	$real_3 = realisasi_satker_bl($th,$kdsatker,3)/1000;
	$real_4 = realisasi_satker_bl($th,$kdsatker,4)/1000;
	$real_5 = realisasi_satker_bl($th,$kdsatker,5)/1000;
	$real_6 = realisasi_satker_bl($th,$kdsatker,6)/1000;
	$real_7 = realisasi_satker_bl($th,$kdsatker,7)/1000;
	$real_8 = realisasi_satker_bl($th,$kdsatker,8)/1000;
	$real_9 = realisasi_satker_bl($th,$kdsatker,9)/1000;
	$real_10 = realisasi_satker_bl($th,$kdsatker,10)/1000;
	$real_11 = realisasi_satker_bl($th,$kdsatker,11)/1000;
	$real_12 = realisasi_satker_bl($th,$kdsatker,12)/1000;
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="14%" rowspan="2" align="center"><font color="#FF0000"><strong><?php echo $kdsatker ?></strong></font></td>
      <td width="64%" rowspan="2" align="left"><font color="#FF0000"><strong><?php echo nm_satker($kdsatker) ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['pagu_satker']/1000,"0",",",".") ?></strong></font></td>
      <td rowspan="2" align="right" valign="middle"><font color="#FF0000"><strong><?php echo number_format(($real/($Satker['pagu_satker']/1000))*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['jan']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['peb']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['mar']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['apr']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['mei']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['jun']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['jul']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['agt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['sep']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['okt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['nop']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#FF0000"><strong><?php echo number_format($Satker['des']/1000,"0",",",".") ?></strong></font></td>
    </tr>
    <tr class="<?php echo $class ?>"> 
      <td align="right"><font color="#FF0000"><?php echo number_format($real,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_1,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_2,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_3,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_4,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_5,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_6,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_7,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_8,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_9,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_10,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_11,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#FF0000"><?php echo number_format($real_12,"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat =  $Giat['KDGIAT'] ;
	$real = realisasi_giat($th,$kdsatker,$kdgiat)/1000 ;
	$real_1 = realisasi_giat_bl($th,$kdsatker,$kdgiat,1)/1000;
	$real_2 = realisasi_giat_bl($th,$kdsatker,$kdgiat,2)/1000;
	$real_3 = realisasi_giat_bl($th,$kdsatker,$kdgiat,3)/1000;
	$real_4 = realisasi_giat_bl($th,$kdsatker,$kdgiat,4)/1000;
	$real_5 = realisasi_giat_bl($th,$kdsatker,$kdgiat,5)/1000;
	$real_6 = realisasi_giat_bl($th,$kdsatker,$kdgiat,6)/1000;
	$real_7 = realisasi_giat_bl($th,$kdsatker,$kdgiat,7)/1000;
	$real_8 = realisasi_giat_bl($th,$kdsatker,$kdgiat,8)/1000;
	$real_9 = realisasi_giat_bl($th,$kdsatker,$kdgiat,9)/1000;
	$real_10 = realisasi_giat_bl($th,$kdsatker,$kdgiat,10)/1000;
	$real_11 = realisasi_giat_bl($th,$kdsatker,$kdgiat,11)/1000;
	$real_12 = realisasi_giat_bl($th,$kdsatker,$kdgiat,12)/1000;
?>
    <tr class="<?php echo $class ?>"> 
      <td rowspan="2" align="center" valign="top"><font color="#0000FF"><strong><?php echo $Giat['KDGIAT'] ?>&nbsp;</strong></font><br>
	  <a href="index.php?p=158&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>" title="Realisasi Output Detil"><font size="1">Detil>></font></a>
	  </td>
      <td rowspan="2" align="left" valign="top"><font color="#0000FF"><strong><?php echo nm_giat($Giat['KDGIAT']) ?>&nbsp;</strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['pagu_giat']/1000,"0",",",".") ?></strong></font></td>
      <td rowspan="2" align="right" valign="middle"><font color="#0000FF"><strong><?php echo number_format(($real/($Giat['pagu_giat']/1000))*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['jan']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['peb']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['mar']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['apr']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['mei']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['jun']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['jul']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['agt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['sep']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['okt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['nop']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($Giat['des']/1000,"0",",",".") ?></strong></font></td>
    </tr>
    <tr class="<?php echo $class ?>"> 
      <td align="right"><font color="#0000FF"><?php echo number_format($real,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_1,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_2,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_3,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_4,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_5,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_6,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_7,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_8,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_9,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_10,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_11,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#0000FF"><?php echo number_format($real_12,"0",",",".") ?></font></td>
    </tr>
    <?php
		} # GIAT
		} # SATKER
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="21">&nbsp;</td>
    </tr>
  </tfoot>
</table>
