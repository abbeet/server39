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

	$sql = "select KDAKUN, sum(jumlah) as pagu_akun from $table  WHERE THANG = '$th' group by KDAKUN";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['KDAKUN'];
		$col[1][] 	= $Satker['pagu_akun'];
		$jmlh 	   += $Satker['pagu_akun'];
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
      <td align="center" colspan="7">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row0"; ?>
    <tr class="<?php echo $class ?>">
      <?php 
	$real_menteri_triwulan_akun = real_menteri_triwulan_akun($th,$kdtriwulan,$col[0][$k]) ;
	$real_menteri_sdtriwulan_akun = real_menteri_sdtriwulan_akun($th,$kdtriwulan,$col[0][$k]) ;
	?>
      <td width="6%" align="center" valign="top"><strong><?php echo $col[0][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_akun($col[0][$k]) ?></strong></td>
      <td width="12%" align="right" valign="top"><strong><?php echo number_format($col[1][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_menteri_triwulan_akun,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_menteri_sdtriwulan_akun,"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top"><?php if ( $col[1][$k] <> 0 ) { ?><strong><?php echo number_format($real_menteri_sdtriwulan_akun/$col[1][$k]*100,"2",",",".") ?></strong><?php } ?></td>
      <td align="right" valign="top"><strong><?php echo number_format($col[1][$k]-$real_menteri_sdtriwulan_akun,"0",",",".") ?></strong></td>
    </tr>
    <?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>
