<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'];
	$th = $_SESSION['xth'];
	$bl = date('m');
	if (substr($bl,0,1) == '0')  $bl = substr($bl,1,1);
	if (substr($bl,0,1) <> '0')  $bl = $bl;

	if($cari=='') $kdbulan = $bl;
	
	if($_REQUEST['cari']){
		$kdbulan = $_REQUEST['kdbulan'];
	}

	$sql = "select KDSATKER, sum(jumlah) as pagu_satker from $table  WHERE THANG = '$th' group by KDSATKER";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['KDSATKER'];
		$col[1][] 	= $Satker['pagu_satker'];
		$jmlh 	   += $Satker['pagu_satker'];
	}
	
?>
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Sampai dengan Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 12; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
<br />
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    
    <tr>
      <th rowspan="2">Unit Eselon II</th>
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#006600">Lembaga</font><br /><strong>Satuan Kerja</strong><br/><font color="#0000FF">Kegiatan</font><br/><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu Anggaran</th>
      <th colspan="3">Reaisasi Anggaran</th>
      <th width="10%" rowspan="2">Sisa<br />Anggaran</th>
    </tr>
    <tr>
      <th>Bulan ini </th>
      <th>s.d Bulan ini </th>
      <th>(%)</th>
    </tr>
  </thead>
  <tbody>
  <?php 
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri_bulan = real_menteri_bulan($th,$kdbulan) ;
	$real_menteri_sdbulan = real_menteri_sdbulan($th,$kdbulan) ;
	$renc_menteri_sdbulan = renc_menteri_sdbulan($th,$kdbulan) ;
  ?>
    <tr>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo '023' ?></strong></font></td>
      <td align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('231000')) ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan,"0",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri_sdbulan,"0",",",".") ?></strong></font></td>
    </tr>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="8">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row0"; ?>
    <tr class="<?php echo $class ?>">
      <td width="6%" align="center" valign="top">&nbsp;</td>
      <?php 
	$real_satker_bulan = real_satker_bulan($th,$col[0][$k],$kdbulan) ;
	$real_satker_sdbulan = real_satker_sdbulan($th,$col[0][$k],$kdbulan) ;
	?>
      <td width="6%" align="center" valign="top"><strong><?php echo $col[0][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[0][$k]) ?></strong></td>
      <td width="12%" align="right" valign="top"><strong><?php echo number_format($col[1][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan,"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top"><?php echo number_format($real_satker_sdbulan/$col[1][$k]*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($col[1][$k]-$real_satker_sdbulan,"0",",",".") ?></strong></td>
    </tr>
	<?php 
	$kdsatker = $col[0][$k] ;
	$sql = "select a.KDGIAT, sum(a.jumlah) as pagu_giat, b.kdunitkerja from $table a LEFT OUTER JOIN m_kegiatan b ON ( a.KDGIAT = b.kdgiat and a.THANG = b.th )  WHERE a.THANG = '$th' and a.KDSATKER = '$kdsatker' group by a.KDGIAT order by b.kdunitkerja";
//	$sql = "select KDGIAT, sum(jumlah) as pagu_giat from $table  WHERE THANG = '$th' AND KDSATKER = '$kdsatker' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$real_giat_bulan = real_giat_bulan($th,$col[0][$k],$Giat['KDGIAT'],$kdbulan) ;
	$real_giat_sdbulan = real_giat_sdbulan($th,$col[0][$k],$Giat['KDGIAT'],$kdbulan) ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if ( $Giat['kdunitkerja'] <> $kdunitkerja ) { ?><font color="#0000FF"><?php echo strtoupper(nm_unit($Giat['kdunitkerja'])) ?></font><?php }?></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_sdbulan,"0",",",".") ?></font></td>
      <td align="center" valign="top"><?php if ( $Giat['pagu_giat'] <> 0 ) {?><font color="#0000FF"><?php echo number_format($real_giat_sdbulan/$Giat['pagu_giat']*100,"2",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat']-$real_giat_sdbulan,"0",",",".") ?></font></td>
    </tr>
	<?php 
	$sql = "select KDOUTPUT, sum(jumlah) as pagu_output from $table  WHERE THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$real_output_bulan = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan) ;
	$real_output_sdbulan = real_output_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan) ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_sdbulan,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format($real_output_sdbulan/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output']-$real_output_sdbulan,"0",",",".") ?></font></td>
    </tr>
    <?php
		} // OUTPUT
		} // GIAT
		} // SATKER
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>
