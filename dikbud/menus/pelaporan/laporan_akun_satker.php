<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = setup_kddept_keu() ;
	$kdunit = setup_kdunit_keu() ;
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$th = $_SESSION['xth'];
	
	$bl = date('m');
	if (substr($bl,0,1) == '0')  $bl = substr($bl,1,1);
	if (substr($bl,0,1) <> '0')  $bl = $bl;

	if($cari=='') $kdbulan = $bl;
	
	if($_REQUEST['cari']){
		$kdbulan = $_REQUEST['kdbulan'];
	}

	if ( $xlevel == 3 or $xlevel == 4 or $xlevel == 5 or $xlevel == 6 or $xlevel == 7 or $xlevel == 8 )
	{
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker = '$kdsatker' order by kdunit";
	}else{
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker <> '' order by kdunit";
	}
	
	//$sql = "select KDSATKER, sum(jumlah) as pagu_satker from $table  WHERE THANG = '$th' group by KDSATKER";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$pagu_satker = pagu_satker($th,$Satker['kdsatker']) ;
		if ( $pagu_satker > 0 )
		{
		$col[1][] 	= $Satker['kdsatker'];
		$col[2][] 	= $pagu_satker ;
		}
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
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#006600">Lembaga</font><br />Akun</th>
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
if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri_bulan = real_menteri_bulan($th,$kdbulan) ;
	$real_menteri_sdbulan = real_menteri_sdbulan($th,$kdbulan) ;
	$renc_menteri_sdbulan = renc_menteri_sdbulan($th,$kdbulan) ;
  ?>
    <tr>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo '023' ?></strong></font></td>
      <td align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('231000')) ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan,"0",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri_sdbulan,"0",",",".") ?></strong></font></td>
    </tr>
    <?php
	}  # endif satker
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="7">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[1] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row0"; ?>
    <tr class="<?php echo $class ?>">
      <?php 
	$real_satker_bulan = real_satker_bulan($th,$col[1][$k],$kdbulan) ;
	$real_satker_sdbulan = real_satker_sdbulan($th,$col[1][$k],$kdbulan) ;
	?>
      <td width="6%" align="center" valign="top"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" align="right" valign="top"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan,"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top"><?php echo number_format($real_satker_sdbulan/$col[2][$k]*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($col[2][$k]-$real_satker_sdbulan,"0",",",".") ?></strong></td>
    </tr>
	<?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDAKUN, sum(jumlah) as pagu_akun from $table  WHERE THANG = '$th' AND KDSATKER = '$kdsatker' group by KDAKUN";
	$aAkun = mysql_query($sql);
	while ($Akun = mysql_fetch_array($aAkun))
	{
	$real_satker_bulan_akun = real_satker_bulan_akun($th,$col[1][$k],$kdbulan,$Akun['KDAKUN']) ;
	$real_satker_sdbulan_akun = real_satker_sdbulan_akun($th,$col[1][$k],$kdbulan,$Akun['KDAKUN']) ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Akun['KDAKUN'] ?></font></td>
      <td align="left"><font color="#0000FF"><?php echo nm_akun($Akun['KDAKUN']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Akun['pagu_akun'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_satker_bulan_akun,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_satker_sdbulan_akun,"0",",",".") ?></font></td>
      <td align="center" valign="top"><?php if ( $Akun['pagu_akun'] <> 0 ) {?><font color="#0000FF"><?php echo number_format($real_satker_sdbulan_akun/$Akun['pagu_akun']*100,"2",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Akun['pagu_akun']-$real_satker_sdbulan_akun,"0",",",".") ?></font></td>
    </tr>
    <?php
		} // AKUN
		} // SATKER
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>
