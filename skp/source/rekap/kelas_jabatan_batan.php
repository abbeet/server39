<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "kd_unitkerja";
	$field = get_field($table);
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);

	$oList = mysql_query("SELECT left(kdunit,2) as kodeunit,sktunit FROM $table where kdunit <> '6000' and kdunit <> '7000' and kdunit <> '8000' and kdunit <> '9000' GROUP BY left(kdunit,2) ORDER BY left(kdunit,2)");

	$count = mysql_num_rows($oList);
	while ($List = mysql_fetch_array($oList))
	{
		$col[0][] 	= $List['kodeunit'];
		$col[1][] 	= $List['sktunit'];
		$j_17 = jmlgrade_unit(17,$List['kodeunit'],$th);
		$j_16 = jmlgrade_unit(16,$List['kodeunit'],$th);
		$j_15 = jmlgrade_unit(15,$List['kodeunit'],$th);
		$j_14 = jmlgrade_unit(14,$List['kodeunit'],$th);
		$j_13 = jmlgrade_unit(13,$List['kodeunit'],$th);
		$j_12 = jmlgrade_unit(12,$List['kodeunit'],$th);
		$j_11 = jmlgrade_unit(11,$List['kodeunit'],$th);
		$j_10 = jmlgrade_unit(10,$List['kodeunit'],$th);
		$j_9 = jmlgrade_unit(9,$List['kodeunit'],$th);
		$j_8 = jmlgrade_unit(8,$List['kodeunit'],$th);
		$j_7 = jmlgrade_unit(7,$List['kodeunit'],$th);
		$j_6 = jmlgrade_unit(6,$List['kodeunit'],$th);
		$j_5 = jmlgrade_unit(5,$List['kodeunit'],$th);
		$j_4 = jmlgrade_unit(4,$List['kodeunit'],$th);
		$j_3 = jmlgrade_unit(3,$List['kodeunit'],$th);
		$j_2 = jmlgrade_unit(2,$List['kodeunit'],$th);
		$j_1 = jmlgrade_unit(1,$List['kodeunit'],$th);
		$jml_17[] = $j_17 ;
		$jml_16[] = $j_16 ;
		$jml_15[] = $j_15 ;
		$jml_14[] = $j_14 ;
		$jml_13[] = $j_13 ;
		$jml_12[] = $j_12 ;
		$jml_11[] = $j_11 ;
		$jml_10[] = $j_10 ;
		$jml_9[] = $j_9 ;
		$jml_8[] = $j_8 ;
		$jml_7[] = $j_7 ;
		$jml_6[] = $j_6 ;
		$jml_5[] = $j_5 ;
		$jml_4[] = $j_4 ;
		$jml_3[] = $j_3 ;
		$jml_2[] = $j_2 ;
		$jml_1[] = $j_1 ;
		$tot_17 += $j_17 ;
		$tot_16 += $j_16 ;
		$tot_15 += $j_15 ;
		$tot_14 += $j_14 ;
		$tot_13 += $j_13 ;
		$tot_12 += $j_12 ;
		$tot_11 += $j_11 ;
		$tot_10 += $j_10 ;
		$tot_9 += $j_9 ;
		$tot_8 += $j_8 ;
		$tot_7 += $j_7 ;
		$tot_6 += $j_6 ;
		$tot_5 += $j_5 ;
		$tot_4 += $j_4 ;
		$tot_3 += $j_3 ;
		$tot_2 += $j_2 ;
		$tot_1 += $j_1 ;
		$tot[] = $j_17 +
		           $j_16 +
				   $j_15 +
		           $j_14 +
				   $j_13 +
		           $j_12 +
				   $j_11 +
		           $j_10 +
				   $j_9 +
		           $j_8 +
				   $j_7 +
		           $j_6 +
				   $j_5 +
		           $j_4 +
				   $j_3 +
		           $j_2 +
				   $j_1 ;
		$total +=  $j_17 +
				   $j_15 +
				   $j_15 +
		           $j_14 +
				   $j_13 +
		           $j_12 +
				   $j_11 +
		           $j_10 +
				   $j_9 +
		           $j_8 +
				   $j_7 +
		           $j_6 +
				   $j_5 +
		           $j_4 +
				   $j_3 +
		           $j_2 +
				   $j_1 ;
	}
	
?>
<a href="source/master/pemangku_jabatan_prn.php?kdunit=<?php echo $xkdunit ?>" title="Cetak Pemegang Jabatan" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak</font></a>
<table width="70%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%" rowspan="2">No.</th>
			<th width="37%" rowspan="2">Unit Kerja  </th>
            <th colspan="17">Kelas Jabatan </th>
          <th width="12%" rowspan="2">Jumlah</th>
		</tr>
		<tr>
		  <th width="10%">17</th>
	      <th width="12%">16</th>
	      <th width="11%">15</th>
	      <th width="11%">14</th>
	      <th width="12%">13</th>
	      <th width="12%">12</th>
	      <th width="12%">11</th>
	      <th width="12%">10</th>
	      <th width="12%">9</th>
	      <th width="12%">8</th>
	      <th width="12%">7</th>
	      <th width="12%">6</th>
	      <th width="12%">5</th>
          <th width="12%">4</th>
          <th width="12%">3</th>
          <th width="12%">2</th>
	      <th width="12%">1</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="20">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo $col[1][$k] ?></td>
			        <td align="center" valign="top"><?php echo $jml_17[$k] ?></td>
			        <td align="center" valign="top"><?php echo $jml_16[$k] ?></td>
			        <td align="center" valign="top"><?php echo $jml_15[$k] ?></td>
			        <td align="center" valign="top"><?php echo $jml_14[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_13[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_12[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_11[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_10[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_9[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_8[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_7[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_6[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_5[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_4[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_3[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_2[$k] ?></td>
				    <td align="center" valign="top"><?php echo $jml_1[$k] ?></td>
				    <td align="center" valign="top"><?php echo $tot[$k] ?></td>
				</tr>
				<?php
			}
		} ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><strong>Total</strong></td>
				  <td align="center" valign="top"><strong><?php echo $tot_17 ?></strong></td>
				  <td align="center" valign="top"><strong><?php echo $tot_16 ?></strong></td>
				  <td align="center" valign="top"><strong><?php echo $tot_15 ?></strong></td>
				  <td align="center" valign="top"><strong><?php echo $tot_14 ?></strong></td>
				  <td align="center" valign="top"><strong><?php echo $tot_13 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_12 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_11 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_10 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_9 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_8 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_7 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_6 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_5 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_4 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_3 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_2 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $tot_1 ?></strong></td>
	              <td align="center" valign="top"><strong><?php echo $total ?></strong></td>
	  </tr>				
	</tbody>
	<tfoot>
		<tr>
			<td colspan="20">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php 
	function jmlgrade_unit($kdgrade,$kdunit,$th) {
		$data = mysql_query("select count(nib) as jumlah from v_grade_skp where tahun = '$th' and left(kdunitkerja,2) = '$kdunit' and klsjabatan = '$kdgrade' group by klsjabatan");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jumlah'];
		return $result;
	}

?>