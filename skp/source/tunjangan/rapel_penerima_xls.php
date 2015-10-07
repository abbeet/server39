<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
 	$th = $_REQUEST['th'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
    $kdbulan1 = $_REQUEST['kdbulan1'];
    $kdbulan2 = $_REQUEST['kdbulan2'];
	$kdsatker = $_REQUEST['kdsatker'];
	
	$jml_peg = 0 ;
	$count = $kdbulan2 - $kdbulan1 + 1 ;
	for ($i = $kdbulan1 ; $i <= $kdbulan2 ; $i++)
	{
		if ( $i <= 9 )    $kdbulan = '0'.$i ;
		else $kdbulan = $i ;
		$oList = mysql_query("SELECT kdsatker, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' GROUP BY bulan ");
		$List = mysql_fetch_array($oList);
		$col[0][] 	= $i ;
		$col[1][] 	= jmlpeg_bulan($th,$kdbulan,$List['kdsatker']);
		$col[4][] 	= $List['jml_tunker'];
		$col[5][] 	= $List['jml_pajak'];
		$col[6][] 	= $List['jml_terima'];
		$col[7][] 	= $List['jml_tunker'] - $List['jml_terima'] ;
		$col[8][] 	= $List['jml_tunker'] - $List['jml_terima'] + $List['jml_pajak'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total_trm +=  $List['jml_terima'];
		$total    +=  jmlpeg_bulan($th,$kdbulan,$List['kdsatker']);
		if ( jmlpeg_bulan($th,$kdbulan,$List['kdsatker']) > $jml_peg )   $jml_peg = jmlpeg_bulan($th,$kdbulan,$List['kdsatker']) ;
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "rapel_penerimaan_" . $kdsatker ."_" . $kdbulan1 ."_" . $kdbulan2. ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("REKAPITULASI PENERIMAAN TUNJANGAN KINERJA PEGAWAI<br>");
	$b1=(int) $kdbulan1;
	$b2=(int) $kdbulan2;
	print("BULAN " . strtoupper(nama_bulan($b1)) ." S/D " . strtoupper(nama_bulan($b2)). " $th<br>");
	print("SATUAN KERJA : " . strtoupper(nm_satker($kdsatker)) . "<br><br>");	
?>
<table width="70%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%" rowspan="2">No.</th>
			<th width="37%" rowspan="2">Bulan</th>
            <th width="10%" rowspan="2">Jumlah<br />Penerima</th>
            <th width="11%" rowspan="2">Tunjangan<br />Kinerja<br />Sebelum Pajak</th>
            <th width="11%" rowspan="2">Tunjangan<br />Pajak</th>
		    <th width="12%" rowspan="2">Jumlah<br />Bruto </th>
		    <th colspan="3">POTONGAN</th>
		    <th width="12%" rowspan="2">Jumlah Diterima</th>
		</tr>
		<tr>
		  <th width="12%">Pajak</th>
	      <th width="12%">Pengurang</th>
	      <th width="12%">Jumlah</th>
	  </tr>
		<tr>
		  <th>1</th>
		  <th>2</th>
		  <th>3</th>
		  <th>4</th>
		  <th>5</th>
		  <th>6=4+5</th>
		  <th>7</th>
		  <th>8</th>
		  <th>9=7+8</th>
		  <th>10=6-9</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="10">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo strtoupper(nama_bulan($col[0][$k])) ?></td>
			        <td align="center" valign="top"><?php echo $col[1][$k] ?></td>
			        <td align="right" valign="top"><?php echo $col[4][$k] ?></td>
			        <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
				    <td align="right" valign="top"><?php echo $col[4][$k] + $col[5][$k] ?></td>
				    <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
				    <td align="right" valign="top"><?php echo $col[7][$k] ?></td>
				    <td align="right" valign="top"><?php echo $col[8][$k] ?></td>
				    <td align="right" valign="top"><?php echo $col[6][$k] ?></td>
				</tr>
				<?php
			}
		} ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><strong>Jumlah</strong></td>
				  <td align="center" valign="top"><strong><?php echo $jml_peg ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_tk ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_tk + $total_pj ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_tk - $total_trm ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_tk - $total_trm + $total_pj ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_trm ?></strong></td>
	  </tr>				
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10"></td>
		</tr>
	</tfoot>
</table>
