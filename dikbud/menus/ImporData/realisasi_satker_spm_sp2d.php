<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = setup_kddept_keu() ;
	$kdunit = setup_kdunit_keu() ;
	$kdmenteri = setup_kddept_unit().'20000';
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	
	if ( $xlevel == 3 or $xlevel == 4 or $xlevel == 5 or $xlevel == 6 or $xlevel == 7 or $xlevel == 8 )
	{
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker from d_item WHERE THANG = '$th' AND KDDEPT = '$kddept' AND KDUNIT = '$kdunit' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER ORDER BY KDSATKER";
	}else{
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker from d_item WHERE THANG = '$th' AND KDDEPT = '$kddept' AND KDUNIT = '$kdunit' GROUP BY KDSATKER ORDER BY KDSATKER";
	}
	
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['KDSATKER'];
		$col[1][] 	= $Satker['pagu_satker'];
	}

?>
<?php if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{ ?>
<a href="index.php?p=631" title="Grafik Realisasi"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a>
<br />
<?php } ?>
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu<br />Anggaran</th>
      <th colspan="2">Realisasi<br />Anggaran SPM</th>
      <th colspan="2">Realisasi<br />Anggaran SP2D</th>
      <th colspan="3">Selisih<br />SPM - SP2D</th>
    </tr>
    <tr>
      <th>Rupiah</th>
      <th>%</th>
      <th>Rupiah</th>
      <th>%</th>
      <th>Rupiah</th>
      <th>%</th>
      <th>Detil</th>
    </tr>
  </thead>
  <tbody>
<?php
		if ($count == 0) 
		{ ?>    <tr> 
      <td align="center" colspan="10">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$real_satker_spm = real_satker_spm($th,$col[0][$k]) ;
				$real_satker_sp2d = real_satker_sp2d($th,$col[0][$k]) ;
				?>
    <tr class="<?php echo $class ?>"> 
      <td width="6%" align="center"><strong><?php echo $col[0][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[0][$k]) ?></strong></td>
      <td width="12%" align="right"><strong><?php echo number_format($col[1][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right"><strong><?php echo number_format($real_satker_spm,"0",",",".") ?></strong></td>
      <td width="7%" align="center"><strong><?php echo number_format($real_satker_spm/$col[1][$k]*100,"2",",",".") ?></strong></td>
      <td width="7%" align="right"><strong><?php echo number_format($real_satker_sp2d,"0",",",".") ?></strong></td>
      <td width="7%" align="center"><strong><?php echo number_format($real_satker_sp2d/$col[1][$k]*100,"2",",",".") ?></strong></td>
      <td width="7%" align="right"><strong><?php echo number_format($real_satker_spm - $real_satker_sp2d,"0",",",".") ?></strong></td>
      <td width="7%" align="center"><strong><?php echo number_format(($real_satker_spm - $real_satker_sp2d)/$col[1][$k]*100,"2",",",".") ?></strong></td>
      <td width="7%" align="center"><a href="index.php?p=631&kdsatker=<?php echo $col[0][$k] ?>" title="Grafik Realisasi"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a></td>
    </tr>
    <?php 
	$kdsatker = $col[0][$k] ;
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from d_item WHERE KDDEPT = '$kddept' AND KDUNIT = '$kdunit' AND THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDGIAT ORDER BY KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$real_giat_spm = real_giat_spm($th,$kdsatker,$Giat['KDGIAT']) ;
	$real_giat_sp2d = real_giat_sp2d($th,$kdsatker,$Giat['KDGIAT']) ;
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_spm,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_spm/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_sp2d,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_sp2d/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_spm - $real_giat_sp2d,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo number_format(($real_giat_spm - $real_giat_sp2d)/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output from d_item WHERE KDDEPT = '$kddept' AND KDUNIT = '$kdunit' AND THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT = '$Giat[KDGIAT]' GROUP BY KDOUTPUT ORDER BY KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$real_output_spm = real_output_spm($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT']) ;
	$real_output_sp2d = real_output_sp2d($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT']) ;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_spm,"0",",",".") ?>
		<?php if ( $real_output_spm <> 0 ) { ?>
		<br>
		<a href="index.php?p=627&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="Data SPM Detil"><font size="1"> 
        Detil>></font></a>
		<?php } ?>
	  </font></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format($real_output_spm/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_sp2d,"0",",",".") ?>
		<?php if ( $real_output_sp2d <> 0 ) { ?>
		<br>
		<a href="index.php?p=628&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="Data SPM Detil"><font size="1"> 
        Detil>></font></a>
		<?php } ?>
	  </font></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format($real_output_sp2d/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_spm-$real_output_sp2d,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format(($real_output_spm-$real_output_sp2d)/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="center" valign="top">
	  <?php if ( $real_output_spm-$real_output_sp2d > 0 ) {?>
	  <a href="index.php?p=562&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="Data SPM Detil"><font size="1"> 
        Detil>></font></a>
		<?php } ?>
		</td>
    </tr>
    <?php
		} # OUTPUT
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="10">&nbsp;</td>
    </tr>
  </tfoot>
</table>
