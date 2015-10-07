<?php
	checkauthentication();

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = $_REQUEST['kddept'];
	$kdunit = $_REQUEST['kdunit_dipa'];
	$kdprogram = $_REQUEST['kdprogram'];
	$th = $_REQUEST['th'];
	
	$sql = "select THANG,sum(JUMLAH) as pagu_prog, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDPROGRAM = '$kdprogram' group by KDDEPT,KDUNIT,KDPROGRAM";
	$aProgram = mysql_query($sql);
	$count = mysql_num_rows($aProgram);
	
	while ($Program = mysql_fetch_array($aProgram))
	{
		$col[0][] 	= $Program['THANG'];
		$col[2][] 	= $Program['pagu_prog']/1000;
		$col[3][] 	= $Program['jan']/1000;
		$col[4][] 	= $Program['peb']/1000;
		$col[5][] 	= $Program['mar']/1000;
		$col[6][] 	= $Program['apr']/1000;
		$col[7][] 	= $Program['mei']/1000;
		$col[8][] 	= $Program['jun']/1000;
		$col[9][] 	= $Program['jul']/1000;
		$col[10][] 	= $Program['agt']/1000;
		$col[11][] 	= $Program['sep']/1000;
		$col[12][] 	= $Program['okt']/1000;
		$col[13][] 	= $Program['nop']/1000;
		$col[14][] 	= $Program['des']/1000;
		
	}
?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
</div><br><br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama Program / <br>
        Nama Kegiatan</th>
      <th width="22%" rowspan="2">Pagu<br>
        Anggaran/<br>
        Realisasi</th>
      <th width="22%" rowspan="2">(%)</th>
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
      <td align="center" colspan="22">Ti<span class="row6"><?php echo number_format($Giat['jun']/1000,"0",",",".") ?></span>dak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <?php 
	$sql = "select THANG, sum(JUMLAH) as pagu_prog, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDPROGRAM = '$kdprogram' group by KDDEPT,KDUNIT,KDPROGRAM";
	
	$aProgram = mysql_query($sql);
	while ($Program = mysql_fetch_array($aProgram))
	{
//	$kdsatker = $Satker['KDSATKER'] ;
	$real = realisasi_program($th,$kddept,$kdunit,$kdprogram)/1000 ;
	$real_1 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,1)/1000;
	$real_2 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,2)/1000;
	$real_3 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,3)/1000;
	$real_4 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,4)/1000;
	$real_5 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,5)/1000;
	$real_6 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,6)/1000;
	$real_7 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,7)/1000;
	$real_8 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,8)/1000;
	$real_9 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,9)/1000;
	$real_10 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,10)/1000;
	$real_11 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,11)/1000;
	$real_12 = realisasi_program_bl($th,$kddept,$kdunit,$kdprogram,12)/1000;
?>
    <tr bordercolor="#999999"> 
      <td width="14%" rowspan="2" align="center"><strong><?php echo $kddept.'.'.$kdunit.'.'.$kdprogram ?></strong></td>
      <td width="64%" rowspan="2" align="left"><strong><?php echo nm_program($kddept.$kdunit.$kdprogram) ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['pagu_prog']/1000,"0",",",".") ?></strong></td>
      <td rowspan="2" align="right" valign="middle"><strong><?php echo number_format(($real/($Program['pagu_prog']/1000))*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['jan']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['peb']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['mar']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['apr']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['mei']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['jun']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['jul']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['agt']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['sep']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['okt']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['nop']/1000,"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Program['des']/1000,"0",",",".") ?></strong></td>
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
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDPROGRAM = '$kdprogram' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat =  $Giat['KDGIAT'] ;
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
    <tr> 
      <td rowspan="2" align="center" valign="top"><?php echo $Giat['KDGIAT'] ?><br>
        <a href="index.php?p=176&kddept=<?php echo $kddept ?>&kdunit=<?php echo $kdunit ?>&kdprogram=<?php echo $kdprogram ?>&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>" title="Realisasi Output Detil"><font size="1">Detil>></font></a> 
        </font></td>
      <td rowspan="2" align="left" valign="top"><?php echo nm_giat($Giat['KDGIAT']) ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['pagu_giat']/1000,"0",",",".") ?></td>
      <td rowspan="2" align="right" valign="middle"><?php echo number_format(($real/($Giat['pagu_giat']/1000))*100,"2",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['jan']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['peb']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['mar']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['apr']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['mei']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6">&nbsp;</td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['jul']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['agt']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['sep']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['okt']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['nop']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['des']/1000,"0",",",".") ?></td>
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
		} # GIAT
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
