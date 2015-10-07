<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$kddeputi = substr($xkdunit,0,3);
	$table = "v_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = date('Y');
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];
	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept from $table WHERE THANG='$th' group by KDDEPT";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept'];
	}


echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<br />
<table width="399" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode </th>
      <th rowspan="3">Deputi</th>
      <th rowspan="3">Pagu<br>
        Anggaran</th>
      <th colspan="12">Realisasi Anggaran<br>
        ( dalam ribuan rupiah )</th>
    </tr>
    <tr> 
      <th colspan="3">Belanja Pegawai </th>
      <th colspan="3">Belanja Barang </th>
      <th colspan="3">Belanja Modal </th>
      <th rowspan="2">Jumlah<br />Realisasi</th>
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
    <tr> 
      <?php 
	$pagu_51 = pagudipa_lembaga_jnsbel($th,51);
	$pagu_52 = pagudipa_lembaga_jnsbel($th,52);
	$pagu_53 = pagudipa_lembaga_jnsbel($th,53);
	$real_51 = realisasi_lembaga_jnsbel($th,51);
	$real_52 = realisasi_lembaga_jnsbel($th,52);
	$real_53 = realisasi_lembaga_jnsbel($th,53);
	$real_tot = $real_51 + $real_52 + $real_53;
	?>
      <td align="center"><span class="style1"><?php echo $kddept ?></span></td>
      <td align="left"><span class="style1"><?php echo nm_unit(substr($kddept,1,2).'0000') ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($col[2][$k]/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($pagu_51/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($real_51/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($pagu_52/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($real_52/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($pagu_53/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($real_53/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format($real_tot/1000,"0",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format(($real_tot/$col[2][$k])*100,"2",",",".") ?></span></td>
      <td width="22%" align="right"><span class="style1"><?php echo number_format(($col[2][$k]-$real_tot)/1000,"0",",",".") ?></span></td>
    </tr>
    
    <?php 
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select THANG, left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select THANG, left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}
	$aDeputi = mysql_query($sql);
	while ($Deputi = mysql_fetch_array($aDeputi))
	{
	$kddeputi = $Deputi['kddeputi'] ;
	$pagu_51 = pagudipa_deputi_jnsbel($th,$kddeputi,51);
	$pagu_52 = pagudipa_deputi_jnsbel($th,$kddeputi,52);
	$pagu_53 = pagudipa_deputi_jnsbel($th,$kddeputi,53);
	$real_51 = realisasi_deputi_jnsbel($th,$kddeputi,51);
	$real_52 = realisasi_deputi_jnsbel($th,$kddeputi,52);
	$real_53 = realisasi_deputi_jnsbel($th,$kddeputi,'53');
	$real_tot = $real_51 + $real_52 + $real_53;
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="14%" align="center"><?php echo $kddeputi ?>	  </td>
      <td width="64%" align="left"><?php echo ket_unit($kddeputi.'000') ?></td>
      <td align="right" valign="top"><?php echo number_format($Deputi['pagu_deputi']/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($pagu_51/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_51/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($pagu_52/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_52/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($pagu_53/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_53/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_tot/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($real_tot/$Deputi['pagu_deputi'])*100,"2",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($col[2][$k]-$real_tot)/1000,"0",",",".") ?></td>
    </tr>
    
    <?php
		} # DEPUTI
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
