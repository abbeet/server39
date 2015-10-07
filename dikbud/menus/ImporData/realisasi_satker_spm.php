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

	if ( $xlevel <> '1' and $xlevel <> '2' and $xlevel <> '9') {
	$sql = "select tgl_upload from dt_fileupload_keu WHERE kdfile = 'D_SPMIND_FRM' and kdsatker = '$kdsatker' order by tgl_upload desc";
	}else{
	$sql = "select tgl_upload from dt_fileupload_keu WHERE kdfile = 'D_SPMIND_FRM' order by tgl_upload desc";
    }
	$aUpload = mysql_query($sql);
	$Upload = mysql_fetch_array($aUpload);

echo "<strong> Upload SPM terakhir pada panggal : ".reformat_tanggal(substr($Upload['tgl_upload'],0,10)). "</strong><br>";
echo "<strong> Pukul : ".substr($Upload['tgl_upload'],10,9). "</strong><br>"; ?>
<?php if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{  ?>
<a href="index.php?p=629" title="Grafik Realisasi"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a>
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
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri = real_menteri_spm($th,$kddept,$kdunit) ;
	?>
    <tr>
      <td align="center"><font color="#009933"><strong><?php echo $kddept ?></strong></font></td>
      <td align="left"><font color="#009933"><strong><?php echo strtoupper(nm_unit($kdmenteri)) ?></strong></font></td>
      <td align="right"><font color="#009933"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009933"><strong><?php echo number_format($real_menteri,"0",",",".") ?></strong></font></td>
      <td align="center"><font color="#009933"><strong><?php echo number_format($real_menteri/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td align="center">&nbsp;</td>
    </tr>
<?php
		}  # AKHIR IF
		if ($count == 0) 
		{ ?>    <tr> 
      <td align="center" colspan="6">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$real_satker = real_satker_spm($th,$col[0][$k]) ;
	if ( $real_satker <> 0 )
	{	
				?>
      <tr class="<?php echo $class ?>"> 
      <td width="6%" align="center"><strong><?php echo $col[0][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[0][$k]) ?></strong></td>
      <td width="12%" align="right"><strong><?php echo number_format($col[1][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right"><strong><?php echo number_format($real_satker,"0",",",".") ?></strong></td>
      <td width="7%" align="center"><strong><?php echo number_format($real_satker/$col[1][$k]*100,"2",",",".") ?></strong></td>
      <td align="center"><a href="index.php?p=629&kdsatker=<?php echo $col[0][$k] ?>" title="Grafik Realisasi"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a></td>
    </tr>
    <?php 
	$kdsatker = $col[0][$k] ;
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from d_item WHERE KDDEPT = '$kddept' AND KDUNIT = '$kdunit' AND THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDGIAT ORDER BY KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$real_giat = real_giat_spm($th,$kdsatker,$Giat['KDGIAT']) ;
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo number_format($real_giat/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td align="center"><a href="index.php?p=560&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Data Realisasi SPM Detil"><font size="1"> 
        Detil SPM >></font></a></td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output from d_item WHERE KDDEPT = '$kddept' AND KDUNIT = '$kdunit' AND THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT = '$Giat[KDGIAT]' GROUP BY KDOUTPUT ORDER BY KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$real_output = real_output_spm($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT']) ;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format($real_output/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="center"><a href="index.php?p=555&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="Data Realisasi SPM Detil"><font size="1"> 
        Detil SPM >></font></a></td>
    </tr>
    <?php
		
		} # OUTPUT
		} # GIAT
		} # satker
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
