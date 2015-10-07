<?php
	checkauthentication();
	
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = 193 ;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "v_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kdunitkerja = $_REQUEST['kdunitkerja'];
	$kddeputi = substr($kdunitkerja,0,3) ;
	$th = $_REQUEST['th'];
		
	$sql = "select THANG,sum(JUMLAH) as pagu_unit, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunitkerja' group by left(kdunitkerja,4)";
	$aUnit = mysql_query($sql);
	$count = mysql_num_rows($aUnit);
	
	while ($Unit = mysql_fetch_array($aUnit))
	{
		$col[0][] 	= $Unit['THANG'];
		$col[2][] 	= $Unit['pagu_unit']/1000;
		$col[3][] 	= $Unit['jan']/1000;
		$col[4][] 	= $Unit['peb']/1000;
		$col[5][] 	= $Unit['mar']/1000;
		$col[6][] 	= $Unit['apr']/1000;
		$col[7][] 	= $Unit['mei']/1000;
		$col[8][] 	= $Unit['jun']/1000;
		$col[9][] 	= $Unit['jul']/1000;
		$col[10][] 	= $Unit['agt']/1000;
		$col[11][] 	= $Unit['sep']/1000;
		$col[12][] 	= $Unit['okt']/1000;
		$col[13][] 	= $Unit['nop']/1000;
		$col[14][] 	= $Unit['des']/1000;
		
	}
?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>&kddeputi=<?php echo $kddeputi ?>&th=<?php echo $th ?>')">Kembali</a></div>
</div><br><br>
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode </th>
      <th rowspan="2">Kegiatan /<br />Output</th>
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
      <td rowspan="2" align="center"><strong><?php echo $kdunitkerja ?></strong></td>
      <td rowspan="2" align="left"><strong><?php echo ket_unit($kdunitkerja.'00') ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></span></td>
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
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunitkerja' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat = $Giat['KDGIAT'] ;
	$real = realisasi_unit_giat($th,$kdunitkerja,$kdgiat)/1000 ;
	$real_1 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,1)/1000;
	$real_2 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,2)/1000;
	$real_3 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,3)/1000;
	$real_4 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,4)/1000;
	$real_5 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,5)/1000;
	$real_6 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,6)/1000;
	$real_7 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,7)/1000;
	$real_8 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,8)/1000;
	$real_9 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,9)/1000;
	$real_10 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,10)/1000;
	$real_11 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,11)/1000;
	$real_12 = realisasi_unit_giat_bl($th,$kdunitkerja,$kdgiat,12)/1000;
?>
    <tr> 
      <td width="14%" rowspan="2" align="center"><strong><?php echo $kdgiat ?></strong></td>
      <td width="64%" rowspan="2" align="left"><strong><?php echo nm_giat($kdgiat) ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['pagu_giat']/1000,"0",",",".") ?></strong></td>
      <td rowspan="2" align="right" valign="middle"><strong><?php echo number_format(($real/($Giat['pagu_giat']/1000))*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['jan']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['peb']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['mar']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['apr']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['mei']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['jun']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['jul']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['agt']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['sep']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['okt']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['nop']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Giat['des']/1000,"0",",",".") ?></strong></td>
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
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunitkerja' and KDGIAT = '$kdgiat' group by KDOUTPUT order by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$kdoutput = $Output['KDOUTPUT'] ;
	$real = realisasi_unit_output($th,$kdunitkerja,$kdgiat,$kdoutput)/1000 ;
	$real_1 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,1)/1000;
	$real_2 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,2)/1000;
	$real_3 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,3)/1000;
	$real_4 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,4)/1000;
	$real_5 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,5)/1000;
	$real_6 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,6)/1000;
	$real_7 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,7)/1000;
	$real_8 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,8)/1000;
	$real_9 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,9)/1000;
	$real_10 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,10)/1000;
	$real_11 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,11)/1000;
	$real_12 = realisasi_unit_output_bl($th,$kdunitkerja,$kdgiat,$kdoutput,12)/1000;
?>
    <tr>
      <td rowspan="2" align="center"><font color="#FF0000"><?php echo $kdoutput ?></font></td>
      <td rowspan="2" align="left"><font color="#FF0000"><?php echo nm_output($kdgiat.$kdoutput) ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['pagu_output']/1000,"0",",",".") ?></font></td>
      <td rowspan="2" align="right" valign="middle"><font color="#FF0000"><?php echo number_format(($real/($Output['pagu_output']/1000))*100,"2",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['jan']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['peb']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['mar']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['apr']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['mei']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['jun']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['jul']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['agt']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['sep']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['okt']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['nop']/1000,"0",",",".") ?></font></td>
      <td align="right" class="row6"><font color="#FF0000"><?php echo number_format($Output['des']/1000,"0",",",".") ?></font></td>
    </tr>
    <tr>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_1,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_2,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_3,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_4,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_5,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_6,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_7,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_8,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_9,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_10,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_11,"0",",",".") ?></font></td>
      <td align="right" class="row7"><font color="#FF0000"><?php echo number_format($real_12,"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDAKUN, sum(JUMLAH) as pagu_akun, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunitkerja' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' group by KDAKUN order by KDAKUN";
	$aAkun = mysql_query($sql);
	while ($Akun = mysql_fetch_array($aAkun))
	{
	$kdakun = $Akun['KDAKUN'] ;
	$real = realisasi_unit_akun($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun)/1000 ;
	$real_1 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,1)/1000;
	$real_2 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,2)/1000;
	$real_3 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,3)/1000;
	$real_4 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,4)/1000;
	$real_5 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,5)/1000;
	$real_6 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,6)/1000;
	$real_7 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,7)/1000;
	$real_8 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,8)/1000;
	$real_9 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,9)/1000;
	$real_10 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,10)/1000;
	$real_11 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,11)/1000;
	$real_12 = realisasi_unit_akun_bl($th,$kdunitkerja,$kdgiat,$kdoutput,$kdakun,12)/1000;
?>
    <tr>
      <td rowspan="2" align="center"><?php echo $kdakun ?></td>
      <td rowspan="2" align="left"><?php echo nm_akun($kdakun) ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['pagu_akun']/1000,"0",",",".") ?></td>
      <td rowspan="2" align="right" valign="middle"><?php echo number_format(($real/($Akun['pagu_akun']/1000))*100,"2",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['jan']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['peb']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['mar']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['apr']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['mei']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['jun']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['jul']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['agt']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['sep']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['okt']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['nop']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($Akun['des']/1000,"0",",",".") ?></td>
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
		} # AKUN
		} # OUTPUT
		} # GIAT
		} # UNIT
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="21">&nbsp;</td>
    </tr>
  </tfoot>
</table>
