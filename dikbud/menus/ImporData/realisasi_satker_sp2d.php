<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "m_spmmak";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = setup_kddept_keu() ;
	$kdmenteri = setup_kddept_unit().'20000';
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	
	if ( $xlevel == 3 or $xlevel == 4 or $xlevel == 5 or $xlevel == 6 or $xlevel == 7 or $xlevel == 8 )
	{
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select THANG, KDSATKER, sum(NILMAK) as real_satker from $table WHERE THANG='$th' AND left(KDAKUN,1) = '5' AND KDSATKER = '$kdsatker' group by KDSATKER";
	}else{
	$sql = "select THANG, KDSATKER, sum(NILMAK) as real_satker from $table WHERE THANG='$th' AND left(KDAKUN,1) = '5' group by KDSATKER";
	}
	
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['THANG'];
		$col[1][] 	= $Satker['KDSATKER'];
		$col[2][] 	= $Satker['real_satker'];
		$jmlh 	   += $Satker['real_satker'];
	}

	if ( $xlevel <> '1' and $xlevel <> '2' and $xlevel <> '9') {
	$sql = "select tgl_upload from dt_fileupload_keu WHERE kdfile = 'M_SPMIND' and kdsatker = '$kdsatker' order by tgl_upload desc";
	}else{
	$sql = "select tgl_upload from dt_fileupload_keu WHERE kdfile = 'M_SPMIND' order by tgl_upload desc";
    }
	$aUpload = mysql_query($sql);
	$Upload = mysql_fetch_array($aUpload);

echo "<strong> Upload SAKPA terakhir pada panggal : ".reformat_tanggal(substr($Upload['tgl_upload'],0,10)). "</strong><br>";
echo "<strong> Pukul : ".substr($Upload['tgl_upload'],10,9). "</strong><br>"; ?>
<?php if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{  ?>
<a href="index.php?p=630" title="Grafik Realisasi"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a>
<br />
<?php } ?>
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu<br />Anggaran</th>
      <th colspan="2">Realisasi<br />Anggaran SP2D</th>
      <th width="10%" rowspan="2">Data Detil</th>
    </tr>
    <tr>
      <th>Rupiah</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody>
	<?php 
	if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	//-----------------------------
	$sql = "select sum(NILMAK) as real_menteri from m_spmmak WHERE THANG='$th' AND left(KDAKUN,1) = '5' group by THANG";
	$aMenteri = mysql_query($sql);
	$Menteri = mysql_fetch_array($aMenteri);
	$pagu_menteri = pagu_menteri($th) ;
	?>
    <tr>
      <td align="center"><font color="#33CC33"><strong><?php echo $kddept ?></strong></font></td>
      <td align="left"><font color="#33CC33"><strong><?php echo strtoupper(nm_unit($kdmenteri)) ?></strong></font></td>
      <td align="right"><font color="#33CC33"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#33CC33"><strong><?php echo number_format($Menteri['real_menteri'],"0",",",".") ?></strong></font></td>
      <td align="center"><font color="#33CC33"><strong><?php if ( $pagu_menteri <> 0 ) { ?><?php echo number_format(($Menteri['real_menteri']/$pagu_menteri)*100,"2",",",".") ?><?php } ?></strong></font></td>
      <td align="center">&nbsp;</td>
    </tr>
<?php
		} #----- akhir if
		if ($count == 0) 
		{ ?>    <tr> 
      <td align="center" colspan="6">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
	<?php 
	$pagu_satker = pagu_satker($th,$col[1][$k]) ;
	?>
      <td width="6%" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" align="right"><strong><?php echo number_format($pagu_satker,"0",",",".") ?></strong></td>
      <td width="11%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="7%" align="center"><strong><?php if ( $pagu_satker > 0 ) { ?><?php echo number_format(($col[2][$k]/$pagu_satker)*100,"2",",",".") ?><?php } ?></strong></td>
      <td align="center"><a href="index.php?p=630&kdsatker=<?php echo $col[1][$k] ?>" title="Grafik Realisasi"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(TOTNILMAK) as real_giat from m_spmind WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT<>'0000' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$pagu_giat = pagu_giat($th,$col[1][$k],$Giat['KDGIAT']) ;
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($pagu_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['real_giat'],"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php if ( $pagu_giat > 0 ) { ?><?php echo number_format($Giat['real_giat']/$pagu_giat*100,"2",",",".") ?><?php } ?></font></td>
      <td align="center"><a href="index.php?p=413&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Data Realisasi Detil"><font size="1"> 
        Detil SP2D >></font></a></td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(TOTNILMAK) as real_output from m_spmind WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$Giat[KDGIAT]' AND ( KDOUTPUT <> '00' AND KDOUTPUT <> '000') group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	
	$pagu_output = pagu_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT']) ;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($pagu_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['real_output'],"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#993333"><?php if ( $pagu_output > 0 ) { ?><?php echo number_format($Output['real_output']/$pagu_output*100,"2",",",".") ?><?php } ?></font></td>
      <td align="center"><a href="index.php?p=414&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="Data Realisasi Detil"><font size="1"> 
        Detil SP2D >></font></a></td>
    </tr>
    <?php
		} # OUTPUT
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
