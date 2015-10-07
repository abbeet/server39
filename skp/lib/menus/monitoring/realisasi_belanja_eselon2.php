<?php
	checkauthentication();
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$kddeputi = substr($xkdunit,0,3);
	$kdunit_kerja = substr($xkdunit,0,4);
	$table = "v_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
//	$kddeputi = '421';
	$th = date('Y');
		
	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select left(kdunitkerja,3) as kddeputi, THANG,sum(JUMLAH) as pagu_deputi from $table WHERE THANG='$th' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}

	$aDeputi = mysql_query($sql);
	$count = mysql_num_rows($aDeputi);
	
	while ($Deputi = mysql_fetch_array($aDeputi))
	{
		$col[0][] 	= $Deputi['THANG'];
		$col[1][] 	= $Deputi['kddeputi'];
		$col[2][] 	= $Deputi['pagu_deputi'];
	}
echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode </th>
      <th rowspan="3">Unit Kerja</th>
      <th rowspan="3">Pagu<br>
        Anggaran</th>
      <th colspan="12">Realisasi Anggaran <br>
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
	$kddeputi = $col[1][$k];
	$pagu_51 = pagudipa_deputi_jnsbel($th,$kddeputi,51);
	$pagu_52 = pagudipa_deputi_jnsbel($th,$kddeputi,52);
	$pagu_53 = pagudipa_deputi_jnsbel($th,$kddeputi,53);
	$real_51 = realisasi_deputi_jnsbel($th,$kddeputi,51);
	$real_52 = realisasi_deputi_jnsbel($th,$kddeputi,52);
	$real_53 = realisasi_deputi_jnsbel($th,$kddeputi,'53');
	$real_tot = $real_51 + $real_52 + $real_53;
	?>
      <td align="center"><span class="style1"><?php echo $kddeputi ?></span></td>
      <td align="left"><span class="style1"><?php echo ket_unit($kddeputi.'000') ?></span></td>
      <td width="12%" align="right"><span class="style1"><?php echo number_format($col[2][$k]/1000,"0",",",".") ?></span></td>
      <td width="7%" align="right"><span class="style1"><?php echo number_format($pagu_51/1000,"0",",",".") ?></span></td>
      <td width="11%" align="right"><span class="style1"><?php echo number_format($real_51/1000,"0",",",".") ?></span></td>
      <td width="8%" align="right"><span class="style1"><?php if( $pagu_51 <> 0 ) {?><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?><?php } ?></span></td>
      <td width="7%" align="right"><span class="style1"><?php echo number_format($pagu_52/1000,"0",",",".") ?></span></td>
      <td width="11%" align="right"><span class="style1"><?php echo number_format($real_52/1000,"0",",",".") ?></span></td>
      <td width="3%" align="right"><span class="style1"><?php if( $pagu_52 <> 0 ) {?><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?><?php } ?></span></td>
      <td width="7%" align="right"><span class="style1"><?php echo number_format($pagu_53/1000,"0",",",".") ?></span></td>
      <td width="4%" align="right"><span class="style1"><?php echo number_format($real_53/1000,"0",",",".") ?></span></td>
      <td width="4%" align="right"><span class="style1"><?php if( $pagu_53 <> 0 ) {?><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?><?php } ?></span></td>
      <td width="4%" align="right"><span class="style1"><?php echo number_format($real_tot/1000,"0",",",".") ?></span></td>
      <td width="4%" align="right"><span class="style1"><?php echo number_format(($real_tot/$col[2][$k])*100,"2",",",".") ?></span></td>
      <td width="4%" align="right"><span class="style1"><?php echo number_format(($col[2][$k]-$real_tot)/1000,"0",",",".") ?></span></td>
    </tr>
    
    <?php 
	
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '4':
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '5':
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		default:
	$sql = "select THANG, left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
	}

	$aUnit = mysql_query($sql);
	while ($Unit = mysql_fetch_array($aUnit))
	{
	$kdunitkerja = $Unit['kdunit_kerja'] ;
	$pagu_51 = pagudipa_unit_jnsbel($th,$kdunitkerja,51);
	$pagu_52 = pagudipa_unit_jnsbel($th,$kdunitkerja,52);
	$pagu_53 = pagudipa_unit_jnsbel($th,$kdunitkerja,53);
	$real_51 = realisasi_unit_jnsbel($th,$kdunitkerja,51);
	$real_52 = realisasi_unit_jnsbel($th,$kdunitkerja,52);
	$real_53 = realisasi_unit_jnsbel($th,$kdunitkerja,53);
	$real_tot = $real_51 + $real_52 + $real_53;
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="7%" align="center"><?php echo $kdunitkerja ?></td>
      <td width="7%" align="left"><?php echo ket_unit($kdunitkerja.'00') ?></td>
      <td align="right" valign="top"><?php echo number_format($Unit['pagu_unit']/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($pagu_51/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_51/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php if( $pagu_51 <> 0 ) {?><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?><?php } ?></td>
      <td align="right" valign="top"><?php echo number_format($pagu_52/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_52/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php if( $pagu_52 <> 0 ) {?><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?><?php } ?></td>
      <td align="right" valign="top"><?php echo number_format($pagu_53/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($real_53/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php if( $pagu_53 <> 0 ) {?><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?><?php } ?></td>
      <td align="right" valign="top"><?php echo number_format($real_tot/1000,"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($real_tot/$Unit['pagu_unit'])*100,"2",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format(($Unit['pagu_unit']-$real_tot)/1000,"0",",",".") ?></td>
    </tr>
    
    <?php
		} # UNIT
		} # DEPUTI
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php 

?>