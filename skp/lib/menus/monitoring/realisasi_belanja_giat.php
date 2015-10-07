<?php
	checkauthentication();
	
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$sw = $_REQUEST['sw'];
	
	$th = date('Y');
	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept from $table WHERE THANG='$th' group by KDDEPT";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept'];
	}

echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="14%" rowspan="3">Kode APBN</th>
      <th width="64%" rowspan="3">Nama Kegiatan</th>
      <th rowspan="3">Pagu<br>
        Anggaran</th>
      <th colspan="12">Realisasi Anggaran<br>
        ( dalam ribuan rupiah )</th>
    </tr>
    <tr> 
      <th colspan="3">Belanja Pegawai </th>
      <th colspan="3">Belanja Barang </th>
      <th colspan="3">Belanja Modal </th>
      <th rowspan="2">Jumlah<br />
        Realisasi</th>
      <th rowspan="2">%</th>
      <th rowspan="2">Sisa</th>
    </tr>
    <tr>
      <th>DIPA</th>
      <th>Realisasi</th>
      <th>%</th>
      <th>DIPA</th>
      <th>Realisasi</th>
      <th>%</th>
      <th>DIPA</th>
      <th>Realisasi</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="21">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="row6"> 
	 <?php
	$pagu_51 = pagudipa_lembaga_jnsbel($th,51);
	$pagu_52 = pagudipa_lembaga_jnsbel($th,52);
	$pagu_53 = pagudipa_lembaga_jnsbel($th,53);
	$real_51 = realisasi_lembaga_jnsbel($th,51);
	$real_52 = realisasi_lembaga_jnsbel($th,52);
	$real_53 = realisasi_lembaga_jnsbel($th,53);
	$real_tot = $real_51 + $real_52 + $real_53;
	?>
      <td align="center"><strong><?php echo '042' ?></strong></td>
      <td align="left"><strong><?php echo 'KEMENTERIAN RISTEK' ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[2][$k]/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($pagu_51/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($real_51/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($pagu_52/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($real_52/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($pagu_53/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($real_53/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format($real_tot/1000,"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(($real_tot/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(($col[2][$k]-$real_tot)/1000,"0",",",".") ?></strong></td>
    </tr>
    
    <?php 
	
	switch ($xlevel)
	{
		case '1':
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' group by KDGIAT order by KDGIAT";
			break;
		case '3':
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' and KDSATKER = '$xusername' group by KDGIAT order by KDGIAT";
			break;
		case '4':
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' group by KDGIAT order by KDGIAT";
			break;
		default:
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' group by KDGIAT order by KDGIAT";
			break;
	}

	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat =  $Giat['KDGIAT'] ;
	$pagu_51 = pagudipa_giat_jnsbel($th,$kdgiat,51);
	$pagu_52 = pagudipa_giat_jnsbel($th,$kdgiat,52);
	$pagu_53 = pagudipa_giat_jnsbel($th,$kdgiat,53);
	$real_51 = realisasi_giat_jnsbel($th,$kdgiat,51);
	$real_52 = realisasi_giat_jnsbel($th,$kdgiat,52);
	$real_53 = realisasi_giat_jnsbel($th,$kdgiat,53);
	$real_tot = $real_51 + $real_52 + $real_53;
?>
    <tr class="row6"> 
      <td align="center" valign="top"><?php echo $Giat['KDGIAT'] ?></td>
      <td align="left" valign="top"><?php echo nm_giat($Giat['KDGIAT']) ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Giat['pagu_giat']/1000,"0",",",".") ?></td>
      <td align="right"><?php echo number_format($pagu_51/1000,"0",",",".") ?></td>
      <td align="right"><?php echo number_format($real_51/1000,"0",",",".") ?></td>
      <td align="right"><?php if( $pagu_51 <> 0 ){?><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?><?php } ?></td>
      <td align="right"><?php echo number_format($pagu_52/1000,"0",",",".") ?></td>
      <td align="right"><?php echo number_format($real_52/1000,"0",",",".") ?></td>
      <td align="right"><?php if( $pagu_52 <> 0 ){?><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?><?php } ?></td>
      <td align="right"><?php echo number_format($pagu_53/1000,"0",",",".") ?></td>
      <td align="right"><?php echo number_format($real_53/1000,"0",",",".") ?></td>
      <td align="right"><?php if( $pagu_53 <> 0 ){?><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?><?php } ?></td>
      <td align="right"><?php echo number_format($real_tot/1000,"0",",",".") ?></td>
      <td align="right"><?php echo number_format(($real_tot/$Giat['pagu_giat'])*100,"2",",",".") ?></td>
      <td align="right"><?php echo number_format(($Giat['pagu_giat']-$real_tot)/1000,"0",",",".") ?></td>
    </tr>
    
    <?php
		} # GIAT
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
