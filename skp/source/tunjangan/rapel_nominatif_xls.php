<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
	$th = $_REQUEST['th'];
	$kdunit = $_REQUEST['kdunit'];
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
	
	$xkdunit = substr($kdunit,0,5) ;
	if ( $kdunit == '2320100' )
	{
		$oList = mysql_query("SELECT grade, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM mst_tk WHERE tahun = '$th' 
		and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' and ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' ) GROUP BY grade ORDER BY grade desc");
	}else{
		$oList = mysql_query("SELECT grade, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM mst_tk WHERE tahun = '$th' 
		and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' and kdunitkerja LIKE '$xkdunit%' GROUP BY grade ORDER BY grade desc");
	}
	$count = mysql_num_rows($oList);
	while ($List = mysql_fetch_array($oList))
	{
		$col[0][] 	= $List['grade'];
		$col[1][] 	= $List['jumlah'];
		$col[2][] 	= $List['tj_pajak'];
		$col[3][] 	= $List['kdunit'];
		$col[4][] 	= $List['jml_tunker'];
		$col[5][] 	= $List['jml_pajak'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total    +=  jmlpeg_bulan_grade($th,$kdbulan2,$kdunit,$List['grade']) ;
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "rekap_nominatif_" . $kdunit ."_" . $kdbulan . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("REKAPITULASI TUNJANGAN KINERJA<br>");
	print("BADAN TENAGA NUKLIR NASIONAL<br>");
	$b1=(int) $kdbulan1;
	$b2=(int) $kdbulan2;
	print("BULAN " . strtoupper(nama_bulan($b1)) . " s/ d ". strtoupper(nama_bulan($b2)) . " TAHUN "." $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_unitkerja($kdunit)) . "<br><br>");	
?>
<table width="81%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="9%">No.</th>
			<th width="22%">Kelas Jabatan </th>
            <th width="14%">Jumlah<br />Penerima</th>
            <th width="17%">Tunjangan Kinerja<br />Per Kelas Jabatan</th>
            <th width="20%">1. Tunjangan Kinerja<br />2. Pajak<br />3. Jumlah</th>
          <th width="18%">1. Potongan Pajak<br />2. Jumlah Netto</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="6">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td rowspan="3" align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td rowspan="3" align="left" valign="top"><?php echo 'GRADE '.$col[0][$k] ?></td>
			        <td rowspan="3" align="center" valign="top"><?php echo jmlpeg_bulan_grade($th,$kdbulan2,$kdunit,$col[0][$k]) ?></td>
			        <td rowspan="3" align="right" valign="top"><?php echo rp_grade($col[0][$k]) ?></td>
			        <td align="right" valign="top"><?php echo $col[4][$k] ?></td>
			        <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
				  <td align="right" valign="top"><?php echo $col[4][$k] ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td height="20" align="right" valign="top"><?php echo $col[4][$k] +  $col[5][$k]  ?></td>
				  <td align="right" valign="top">&nbsp;</td>
	  </tr>
				<?php
			}
		} ?>
				<tr class="<?php echo $class ?>">
				  <td rowspan="3" align="center" valign="top">&nbsp;</td>
				  <td rowspan="3" align="center" valign="top"><strong>Jumlah</strong></td>
				  <td rowspan="3" align="center" valign="top"><strong><?php echo $total ?></strong></td>
				  <td rowspan="3" align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong><?php echo $total_tk ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_tk ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo $total_tk + $total_pj ?></strong></td>
				  <td align="right" valign="top">&nbsp;</td>
	  </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
