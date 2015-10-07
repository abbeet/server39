<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
	$th = $_REQUEST['th'];
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
    $kdsatker = $_REQUEST['kdsatker'];
	if ( $kdbulan1 <= 9 )    $kdbulan1 = '0'.$kdbulan1 ;
	else   $kdbulan1 = $kdbulan1 ;
	
	if ( $kdbulan2 <= 9 )    $kdbulan2 = '0'.$kdbulan2 ;
	else   $kdbulan2 = $kdbulan2 ;
	
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY grade ORDER BY grade desc");

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
		$total    +=  $List['jumlah'];
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "rekap_nominatif_total_" . $kdsatker ."_" . $kdbulan1 .'_'. $kdbulan2 . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("REKAPITULASI DAFTAR TUNJANGAN KINERJA PEGAWAI<br>");
	print("BADAN TENAGA NUKLIR NASIONAL<br>");
	$b1=(int) $kdbulan1;
	$b2=(int) $kdbulan2;
	if ( $b2 == 13 )     print("BULAN " . strtoupper(nama_bulan($b1)) . " S/D DESEMBER DAN BULAN " . strtoupper(nama_bulan($b2)) . " TAHUN " . $th. "<br><br>");
	else     print("BULAN " . strtoupper(nama_bulan($b1)) . " S/D ". strtoupper(nama_bulan($b2)) . " $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_satker($kdsatker)) . "<br><br>");	
?>
<table width="89%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="9%">No.</th>
			<th width="22%">Kelas Jabatan </th>
            <th width="14%">Jumlah<br />Penerima</th>
            <th width="17%">Tunjangan Kinerja<br />Per Kelas Jabatan</th>
            <th width="20%">1. Tunjangan Kinerja<br />2. Pajak<br />3. Jumlah</th>
          <th width="18%">1. Faktor Pengurang<br />
          2. Potongan Pajak<br />3. Jumlah Netto</th>
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
					<td rowspan="3" align="left" valign="top"><?php echo 'Kelas Jabatan '.$col[0][$k] ?></td>
			        <td rowspan="3" align="center" valign="top"><?php echo $col[1][$k] ?></td>
			        <td rowspan="3" align="right" valign="top"><?php echo rp_grade($col[3][$k],$col[0][$k],1) ?></td>
			        <td align="right" valign="top"><?php echo $col[4][$k] ?></td>
			        <td align="right" valign="top"><?php echo 0 ?></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
				  <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td height="20" align="right" valign="top"><?php echo $col[4][$k] +  $col[5][$k]  ?></td>
				  <td align="right" valign="top"><?php echo $col[4][$k] ?></td>
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
				  <td align="right" valign="top"><strong><?php echo 0 ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo $total_tk + $total_pj ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_tk ?></strong></td>
	  </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
