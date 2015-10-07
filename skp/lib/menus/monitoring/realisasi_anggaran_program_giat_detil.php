<?php
	checkauthentication();
	
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = 173 ;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$kddept = $_REQUEST['kddept'];
	$kdunit = $_REQUEST['kdunit'];
	$kdprogram = $_REQUEST['kdprogram'];
	$th = $_REQUEST['th'];
	$kdgiat = $_REQUEST['kdgiat'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select THANG,sum(JUMLAH) as pagu_giat, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDPROGRAM = '$kdprogram' and KDGIAT='$kdgiat' group by KDGIAT";
	$aGiat = mysql_query($sql);
	$count = mysql_num_rows($aGiat);
	
	while ($Giat = mysql_fetch_array($aGiat))
	{
		$col[0][] 	= $Giat['THANG'];
		$col[2][] 	= $Giat['pagu_giat']/1000;
		$col[3][] 	= $Giat['jan']/1000;
		$col[4][] 	= $Giat['peb']/1000;
		$col[5][] 	= $Giat['mar']/1000;
		$col[6][] 	= $Giat['apr']/1000;
		$col[7][] 	= $Giat['mei']/1000;
		$col[8][] 	= $Giat['jun']/1000;
		$col[9][] 	= $Giat['jul']/1000;
		$col[10][] 	= $Giat['agt']/1000;
		$col[11][] 	= $Giat['sep']/1000;
		$col[12][] 	= $Giat['okt']/1000;
		$col[13][] 	= $Giat['nop']/1000;
		$col[14][] 	= $Giat['des']/1000;
		
	}

?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=175&kddept=<?php echo $kddept ?>&kdunit_dipa=<?php echo $kdunit ?>&kdprogram=<?php echo $kdprogram ?>&th=<?php echo $th ?>')">Kembali</a></div>
</div><br><br>
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Kegiatan / <br>
        Output / <br>Akun</th>
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
	$real = realisasi_giat($th,$kdsatker,$kdgiat)/1000 ;
	$real = realisasi_giat_prog($th,$kddept,$kdunit,$kdprogram,$kdgiat)/1000 ;
	$real_1 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,1)/1000;
	$real_2 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,2)/1000;
	$real_3 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,3)/1000;
	$real_4 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,4)/1000;
	$real_5 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,5)/1000;
	$real_6 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,6)/1000;
	$real_7 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,7)/1000;
	$real_8 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,8)/1000;
	$real_9 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,9)/1000;
	$real_10 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,10)/1000;
	$real_11 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,11)/1000;
	$real_12 = realisasi_giat_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,12)/1000;
	?>
      <td rowspan="2" align="center"><strong><?php echo $kdgiat ?></strong></td>
      <td rowspan="2" align="left"><strong><?php echo nm_giat($kdgiat) ?></strong></td>
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
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_9,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_10,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_11,"0",",",".") ?></strong></td>
      <td width="22%" align="right" class="row7"><strong><?php echo number_format($real_12,"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDPROGRAM = '$kdprogram' and KDGIAT='$kdgiat' group by KDOUTPUT order by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$kdoutput = $Output['KDOUTPUT'] ;
	$real = realisasi_output_prog($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput)/1000 ;
	$real_1 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,1)/1000;
	$real_2 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,2)/1000;
	$real_3 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,3)/1000;
	$real_4 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,4)/1000;
	$real_5 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,5)/1000;
	$real_6 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,6)/1000;
	$real_7 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,7)/1000;
	$real_8 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,8)/1000;
	$real_9 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,9)/1000;
	$real_10 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,10)/1000;
	$real_11 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,11)/1000;
	$real_12 = realisasi_output_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,12)/1000;
?>
    <tr> 
      <td width="14%" rowspan="2" align="center"><font color="#FF0000"><?php echo $kdoutput ?></font></td>
      <td width="64%" rowspan="2" align="left"><font color="#FF0000"><?php echo nm_output($kdgiat.$kdoutput) ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['pagu_output']/1000,"0",",",".") ?></font></td>
      <td rowspan="2" align="right" valign="middle"><font color="#FF0000"><?php echo number_format(($real/($Output['pagu_output']/1000))*100,"2",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['jan']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['peb']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['mar']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['apr']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['mei']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['jun']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['jul']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['agt']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['sep']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['okt']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['nop']/1000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#FF0000"><?php echo number_format($Output['des']/1000,"0",",",".") ?></font></td>
    </tr>
    <tr> 
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_1,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_2,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_3,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_4,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_5,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_6,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_7,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_8,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_9,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_10,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_11,"0",",",".") ?></font></td>
      <td width="22%" align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_12,"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDAKUN, sum(JUMLAH) as pagu_akun, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDPROGRAM = '$kdprogram' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' group by KDAKUN order by KDAKUN";
	$aAkun = mysql_query($sql);
	while ($Akun = mysql_fetch_array($aAkun))
	{
	$kdakun =  $Akun['KDAKUN'] ;
	$real = realisasi_akun_prog($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun)/1000 ;
	$real_1 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,1)/1000;
	$real_2 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,2)/1000;
	$real_3 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,3)/1000;
	$real_4 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,4)/1000;
	$real_5 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,5)/1000;
	$real_6 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,6)/1000;
	$real_7 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,7)/1000;
	$real_8 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,8)/1000;
	$real_9 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,9)/1000;
	$real_10 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,10)/1000;
	$real_11 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,11)/1000;
	$real_12 = realisasi_akun_prog_bl($th,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdakun,12)/1000;
?>
    <tr> 
      <td rowspan="2" align="center" valign="top"><?php echo $kdakun ?><br>
	  </td>
      <td rowspan="2" align="left" valign="top"><?php echo nm_akun($kdakun) ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['pagu_akun']/1000,"0",",",".") ?></td>
      <td rowspan="2" align="right" valign="middle"><?php echo number_format(($real/($Akun['pagu_akun']/1000))*100,"2",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['jan']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['peb']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['mar']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['apr']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['mei']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['jun']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['jul']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['agt']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['sep']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['okt']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['nop']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Akun['des']/1000,"0",",",".") ?></td>
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
		} # AKUN
		} # OUTPUT
		} # GIAT
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="21">&nbsp;</td>
    </tr>
  </tfoot>
</table>
