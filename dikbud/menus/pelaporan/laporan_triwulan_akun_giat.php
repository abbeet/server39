<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'];
	$bl = date('m');
	if (substr($bl,0,1) == '0')  $bl = substr($bl,1,1);
	if (substr($bl,0,1) <> '0')  $bl = $bl;
switch ( $bl )
	{
		case 1:
		$kdtriwulan = 1;
		break;
		case 2:
		$kdtriwulan = 1;
		break;
		case 3:
		$kdtriwulan = 1;
		break;
		case 4:
		$kdtriwulan = 2;
		break;
		case 5:
		$kdtriwulan = 2;
		break;
		case 6:
		$kdtriwulan = 2;
		break;
		case 7:
		$kdtriwulan = 3;
		break;
		case 8:
		$kdtriwulan = 3;
		break;
		case 9:
		$kdtriwulan = 3;
		break;
		case 10:
		$kdtriwulan = 4;
		break;
		case 11:
		$kdtriwulan = 4;
		break;
		case 12:
		$kdtriwulan = 4;
		break;
	}	
		

	if($cari=='') $kdtriwulan = $kdtriwulan;
	
	if($_REQUEST['cari']){
		$kdtriwulan = $_REQUEST['kdtriwulan'];
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
		Sampai dengan Triwulan : 
		<select name="kdtriwulan"><?php
									
					for ($i = 1; $i <= 4; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdtriwulan) echo "selected"; ?>><?php echo 'Triwulan '.nmromawi($i) ?></option><?php
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
      <th rowspan="2"><font color="#006600">Lembaga</font><br />Akun</th>
      <th rowspan="2">Pagu Anggaran</th>
      <th colspan="3">Reaisasi Anggaran</th>
      <th width="10%" rowspan="2">Sisa<br />Anggaran</th>
    </tr>
    <tr>
      <th>Triwulan ini </th>
      <th>s.d Triwulan ini </th>
      <th>(%)</th>
    </tr>
  </thead>
  <tbody>
  <?php 
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri_triwulan = real_menteri_triwulan($th,$kdtriwulan) ;
	$real_menteri_sdtriwulan = real_menteri_sdtriwulan($th,$kdtriwulan) ;
  ?>
    <tr>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo '084' ?></strong></font></td>
      <td align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('840000')) ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_triwulan,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdtriwulan,"0",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdtriwulan/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri_sdtriwulan,"0",",",".") ?></strong></font></td>
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
	$real_satker_triwulan = real_satker_triwulan($th,$col[0][$k],$kdtriwulan) ;
	$real_satker_sdtriwulan = real_satker_sdtriwulan($th,$col[0][$k],$kdtriwulan) ;
	?>
      <td width="6%" align="center" valign="top"><strong><?php echo $col[0][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[0][$k]) ?></strong></td>
      <td width="12%" align="right" valign="top"><strong><?php echo number_format($col[1][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_triwulan,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdtriwulan,"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top"><?php echo number_format($real_satker_sdtriwulan/$col[1][$k]*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($col[1][$k]-$real_satker_sdtriwulan,"0",",",".") ?></strong></td>
    </tr>
	<?php 
	$kdsatker = $col[0][$k] ;
	$sql = "select a.KDGIAT, sum(a.jumlah) as pagu_giat, b.kdunitkerja from $table a LEFT OUTER JOIN m_kegiatan b ON ( a.KDGIAT = b.kdgiat and a.THANG = b.th )  WHERE a.THANG = '$th' and a.KDSATKER = '$kdsatker' group by a.KDGIAT order by b.kdunitkerja";
//	$sql = "select KDGIAT, sum(jumlah) as pagu_giat from $table  WHERE THANG = '$th' AND KDSATKER = '$kdsatker' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$real_giat_triwulan = real_giat_triwulan($th,$col[0][$k],$Giat['KDGIAT'],$kdtriwulan) ;
	$real_giat_sdtriwulan = real_giat_sdtriwulan($th,$col[0][$k],$Giat['KDGIAT'],$kdtriwulan) ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if ( $Giat['kdunitkerja'] <> $kdunitkerja ) { ?><font color="#0000FF"><?php echo strtoupper(nm_unit($Giat['kdunitkerja'])) ?></font><?php }?></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_triwulan,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_sdtriwulan,"0",",",".") ?></font></td>
      <td align="center" valign="top"><?php if ( $Giat['pagu_giat'] <> 0 ) {?><font color="#0000FF"><?php echo number_format($real_giat_sdtriwulan/$Giat['pagu_giat']*100,"2",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat']-$real_giat_sdtriwulan,"0",",",".") ?></font></td>
    </tr>
	<?php 
	$sql = "select KDAKUN, sum(jumlah) as pagu_akun from $table  WHERE THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$Giat[KDGIAT]' group by KDAKUN";
	$aAkun = mysql_query($sql);
	while ($Akun = mysql_fetch_array($aAkun))
	{
	$real_giat_triwulan_akun = real_giat_triwulan_akun($th,$col[0][$k],$Giat['KDGIAT'],$kdtriwulan,$Akun['KDAKUN']) ;
	$real_giat_sdtriwulan_akun = real_giat_sdtriwulan_akun($th,$col[0][$k],$Giat['KDGIAT'],$kdtriwulan,$Akun['KDAKUN']) ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><?php echo $Akun['KDAKUN'] ?></td>
      <td align="left"><?php echo nm_akun($Akun['KDAKUN']) ?></td>
      <td align="right" valign="top"><?php echo number_format($Akun['pagu_akun'],"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_giat_triwulan_akun,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_giat_sdtriwulan_akun,"0",",",".") ?></td>
      <td align="center" valign="top"><?php echo number_format($real_giat_sdtriwulan_akun/$Akun['pagu_akun']*100,"2",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($Akun['pagu_akun']-$real_giat_sdtriwulan_akun,"0",",",".") ?></td>
    </tr>
    <?php
		} // AKUN
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
