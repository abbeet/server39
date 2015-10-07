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
	$kdsatker = $_REQUEST['kdsatker'];
	$th = $_REQUEST['th'];
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];

	$sql = "select THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDSATKER";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['THANG'];
		$col[2][] 	= $Satker['pagu_dept']/1000;
		$col[3][] 	= $Satker['jan']/1000;
		$col[4][] 	= $Satker['peb']/1000;
		$col[5][] 	= $Satker['mar']/1000;
		$col[6][] 	= $Satker['apr']/1000;
		$col[7][] 	= $Satker['mei']/1000;
		$col[8][] 	= $Satker['jun']/1000;
		$col[9][] 	= $Satker['jul']/1000;
		$col[10][] 	= $Satker['agt']/1000;
		$col[11][] 	= $Satker['sep']/1000;
		$col[12][] 	= $Satker['okt']/1000;
		$col[13][] 	= $Satker['nop']/1000;
		$col[14][] 	= $Satker['des']/1000;
		
	}
?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
</div><br><br>
<?php			
echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama Satuan Kerja / <br>
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
      <td align="center" colspan="22">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <?php 
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDDEPT='$kddept' and KDSATKER='$kdsatker' group by KDSATKER order by KDSATKER";
	
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
      <td width="14%" rowspan="2" align="center"><font color="#336600"><strong><?php echo $kdsatker ?></strong></font></td>
      <td width="64%" rowspan="2" align="left"><font color="#336600"><strong><?php echo nm_satker($kdsatker) ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['pagu_satker']/1000,"0",",",".") ?></strong></font></td>
      <td rowspan="2" align="right" valign="middle"><font color="#336600"><strong><?php echo number_format(($real/($Satker['pagu_satker']/1000))*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['jan']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['peb']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['mar']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['apr']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['mei']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['jun']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['jul']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['agt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['sep']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['okt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['nop']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#336600"><strong><?php echo number_format($Satker['des']/1000,"0",",",".") ?></strong></font></td>
    </tr>
    <tr class="<?php echo $class ?>"> 
      <td align="right"><font color="#336600"><?php echo number_format($real,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_1,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_2,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_3,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_4,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_5,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_6,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_7,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_8,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_9,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_10,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_11,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#336600"><?php echo number_format($real_12,"0",",",".") ?></font></td>
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
      <td rowspan="2" align="center" valign="top"><font color="#666666"><strong><?php echo $Giat['KDGIAT'] ?>&nbsp;</strong><br>
        <a href="index.php?p=160&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>" title="Realisasi Output Detil"><font size="1">Detil>></font></a> 
        </font></td>
      <td rowspan="2" align="left" valign="top"><font color="#666666"><strong><?php echo nm_giat($Giat['KDGIAT']) ?>&nbsp;</strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['pagu_giat']/1000,"0",",",".") ?></strong></font></td>
      <td rowspan="2" align="right" valign="middle"><font color="#666666"><strong><?php echo number_format(($real/($Giat['pagu_giat']/1000))*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['jan']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['peb']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['mar']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['apr']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['mei']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['jun']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['jul']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['agt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['sep']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['okt']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['nop']/1000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#666666"><strong><?php echo number_format($Giat['des']/1000,"0",",",".") ?></strong></font></td>
    </tr>
    <tr class="<?php echo $class ?>"> 
      <td align="right"><font color="#666666"><?php echo number_format($real,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_1,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_2,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_3,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_4,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_5,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_6,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_7,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_8,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_9,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_10,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_11,"0",",",".") ?></font></td>
      <td width="22%" align="right"><font color="#666666"><?php echo number_format($real_12,"0",",",".") ?></font></td>
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
