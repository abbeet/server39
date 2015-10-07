<?php
	checkauthentication();
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdunit_kerja = substr($xkdunit,0,4);
	$kddeputi = substr($xkdunit,0,3);
	$table = "v_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
		
	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}

	$aDeputi = mysql_query($sql);
	$count = mysql_num_rows($aDeputi);
	
	while ($Deputi = mysql_fetch_array($aDeputi))
	{
		$col[0][] 	= $Deputi['THANG'];
		$col[1][] 	= $Deputi['kddeputi'];
		$col[2][] 	= $Deputi['pagu_deputi']/1000;
		$col[3][] 	= $Deputi['jan']/1000;
		$col[4][] 	= $Deputi['peb']/1000;
		$col[5][] 	= $Deputi['mar']/1000;
		$col[6][] 	= $Deputi['apr']/1000;
		$col[7][] 	= $Deputi['mei']/1000;
		$col[8][] 	= $Deputi['jun']/1000;
		$col[9][] 	= $Deputi['jul']/1000;
		$col[10][] 	= $Deputi['agt']/1000;
		$col[11][] 	= $Deputi['sep']/1000;
		$col[12][] 	= $Deputi['okt']/1000;
		$col[13][] 	= $Deputi['nop']/1000;
		$col[14][] 	= $Deputi['des']/1000;
		
	}
?>
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode </th>
      <th rowspan="2">Unit Kerja</th>
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
	$kddeputi = $col[1][$k];
	$real = realisasi_deputi($th,$kddeputi)/1000 ;
	$real_1 = realisasi_deputi_bl($th,$kddeputi,1)/1000;
	$real_2 = realisasi_deputi_bl($th,$kddeputi,2)/1000;
	$real_3 = realisasi_deputi_bl($th,$kddeputi,3)/1000;
	$real_4 = realisasi_deputi_bl($th,$kddeputi,4)/1000;
	$real_5 = realisasi_deputi_bl($th,$kddeputi,5)/1000;
	$real_6 = realisasi_deputi_bl($th,$kddeputi,6)/1000;
	$real_7 = realisasi_deputi_bl($th,$kddeputi,7)/1000;
	$real_8 = realisasi_deputi_bl($th,$kddeputi,8)/1000;
	$real_9 = realisasi_deputi_bl($th,$kddeputi,9)/1000;
	$real_10 = realisasi_deputi_bl($th,$kddeputi,10)/1000;
	$real_11 = realisasi_deputi_bl($th,$kddeputi,11)/1000;
	$real_12 = realisasi_deputi_bl($th,$kddeputi,12)/1000;
	?>
      <td rowspan="2" align="center"><strong><?php echo $kddeputi ?></strong></td>
      <td rowspan="2" align="left"><strong><?php echo ket_unit($kddeputi.'000') ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="22%" rowspan="2" align="right" valign="middle"><strong><?php echo number_format(($real/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[3][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[4][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[5][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[6][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[7][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[8][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[9][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[10][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[11][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[12][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[13][$k],"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[14][$k],"0",",",".") ?></strong></td>
    </tr>
    <tr> 
      <td align="right" class="row7"><strong><?php echo number_format($real,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_1,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_2,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_3,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_4,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_5,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_6,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_7,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_8,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong>><?php echo number_format($real_9,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_10,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_11,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_12,"0",",",".") ?></strong></td>
    </tr>
    <?php 
	
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '5':
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '4':
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		default:
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
	}

	$aUnit = mysql_query($sql);
	while ($Unit = mysql_fetch_array($aUnit))
	{
	$kdunitkerja = $Unit['kdunit_kerja'] ;
	$real = realisasi_unit($th,$kdunitkerja)/1000 ;
	$real_1 = realisasi_unit_bl($th,$kdunitkerja,1)/1000;
	$real_2 = realisasi_unit_bl($th,$kdunitkerja,2)/1000;
	$real_3 = realisasi_unit_bl($th,$kdunitkerja,3)/1000;
	$real_4 = realisasi_unit_bl($th,$kdunitkerja,4)/1000;
	$real_5 = realisasi_unit_bl($th,$kdunitkerja,5)/1000;
	$real_6 = realisasi_unit_bl($th,$kdunitkerja,6)/1000;
	$real_7 = realisasi_unit_bl($th,$kdunitkerja,7)/1000;
	$real_8 = realisasi_unit_bl($th,$kdunitkerja,8)/1000;
	$real_9 = realisasi_unit_bl($th,$kdunitkerja,9)/1000;
	$real_10 = realisasi_unit_bl($th,$kdunitkerja,10)/1000;
	$real_11 = realisasi_unit_bl($th,$kdunitkerja,11)/1000;
	$real_12 = realisasi_unit_bl($th,$kdunitkerja,12)/1000;
?>
    <tr"> 
      <td width="14%" rowspan="2" align="center"><?php echo $kdunitkerja ?><br>
	  <a href="index.php?p=195&kdunitkerja=<?php echo $kdunitkerja ?>&th=<?php echo $th ?>" title="Realisasi Kegiatan Detil"><font size="1">Detil Unit>></font></a>
	  </td>
      <td width="64%" rowspan="2" align="left"><?php echo ket_unit($kdunitkerja.'00') ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['pagu_unit']/1000,"0",",",".") ?></td>
      <td rowspan="2" align="right" valign="middle"><?php echo number_format(($real/($Unit['pagu_unit']/1000))*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['jan']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['peb']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['mar']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['apr']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['mei']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['jun']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['jul']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['agt']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['sep']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['okt']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['nop']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Unit['des']/1000,"0",",",".") ?></td>
    </tr>
    <tr> 
      <td align="right" class="row7"><?php echo number_format($real,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_1,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_2,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_3,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_4,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_5,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_6,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_7,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_8,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_9,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_10,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_11,"0",",",".") ?></td>
      <td width="22%" align="right" class="row7"><?php echo number_format($real_12,"0",",",".") ?></td>
    </tr>
    <?php
		} # UNIT
		} # DEPUTI
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="21">&nbsp;</td>
    </tr>
  </tfoot>
</table>
