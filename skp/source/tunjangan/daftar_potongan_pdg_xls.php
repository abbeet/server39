<?php
	include_once "../../includes/includes.php";
	$table = "mst_potongan";
	$field = get_field($table);
 	$th = $_REQUEST['th'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
	$kdsatker = $_REQUEST['kdsatker'];

switch ($xlevel)
	{
		case '7':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan' ORDER BY grade desc, kdgol desc,kdunitkerja");
			break;
		case '2':
		if ( $xkdunit == '13' )
		{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and ( left(kdunitkerja,2) = '$xkdunit' or  kdunitkerja = '0000' or kdunitkerja = '1000' or kdunitkerja = '2000' or kdunitkerja = '3000' or kdunitkerja = '4000' or kdunitkerja = '5000' ) and bulan = '$kdbulan' ORDER BY kdunitkerja, grade desc,kdgol desc");
		}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan' ORDER BY kdunitkerja, grade desc, kdgol desc");
		}
			break;
		default:
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' ORDER BY grade desc, kdgol, kdunitkerja");
			break;
	} 

	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "daftar_potongan_" . $kdsatker ."_" . $kdbulan . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("DAFTAR POTONGAN<br>");
	$b=(int) $kdbulan;
	if ( $b <> 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . " $th<br><br>");
	if ( $b == 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . "TAHUN "." $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_satker($kdsatker)) . "<br><br>");	
?>
<table width="65%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="3%" rowspan="2">No.</th>
			<th width="6%" rowspan="2"><?php if ( $xlevel == 2 ) {?>Unit Kerja<?php }else{ ?>Jabatan<?php } ?></th>
			<th width="6%" rowspan="2">Nama Pegawai</th>
			<th width="3%" rowspan="2">
	      Gol</th>
			<th width="4%" rowspan="2">NIP</th>
			<th width="3%" rowspan="2">NIB</th>
		    <th width="3%" rowspan="2">Grade</th>
		    <th colspan="2" rowspan="2">Tanpa<br />Ket.</th>
		    <th colspan="12">Jumlah Cuti bulan <?php echo nama_bulan(ubah_databulan($kdbulan)).' '.$th ?></th>
            <th width="7%" rowspan="2">Jumlah<br />
          Potongan<br />(%)</th>
	    </tr>
		<tr>
		  <th colspan="2">CT</th>
	      <th colspan="2">CB</th>
	      <th colspan="2">CSRI</th>
	      <th colspan="2">CSRJ</th>
	      <th colspan="2">CM</th>
	      <th colspan="2">CP</th>
      </tr>
		<tr>
		  <th>1</th>
		  <th>2</th>
		  <th>3</th>
		  <th>4</th>
		  <th>5</th>
		  <th>6</th>
		  <th>7</th>
		  <th colspan="2">8</th>
		  <th colspan="2">9</th>
		  <th colspan="2">10</th>
		  <th colspan="2">11</th>
		  <th colspan="2">12</th>
		  <th colspan="2">13</th>
		  <th colspan="2">14</th>
		  <th>15</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="22">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$nilpot_10 = $col[8][$k] * persen_pot('10') ;
				$nilpot_11 = $col[9][$k] * persen_pot('11') ;
				$nilpot_12 = $col[10][$k] * persen_pot('12') ;
				$nilpot_13 = $col[11][$k] * persen_pot('13') ;
				$nilpot_14 = $col[12][$k] * persen_pot('14') ;
				$nilpot_15 = $col[13][$k] * persen_pot('15') ;
				$nilpot_16 = $col[14][$k] * persen_pot('16') ;
				$totpot = $nilpot_10 + $nilpot_11 + $nilpot_12 + $nilpot_13 + $nilpot_14 + $nilpot_15 + $nilpot_16 ;
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top">
					<?php if ( $xlevel == 2 ) {?>
					<?php if ( $col[6][$k] <> $col[6][$k-1] ) {?><?php echo nm_unitkerja($col[6][$k]) ?><?php }?>
					<?php }else{ ?>
					<?php echo nmjabatan_mst_tk($col[3][$k],$th,$kdbulan) ?>
					<?php } ?>					</td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_gol(substr($col[7][$k],0,1).hurufkeangka(substr($col[7][$k],1,1))) ?></td>
					<td align="center" valign="top"><?php echo reformat_nipbaru($col[4][$k]) ?></td>
					<td align="center" valign="top"><?php echo $col[3][$k] ?></td>
					<td align="center" valign="top"><?php echo $col[17][$k] ?></td>
					<td width="1%" align="center" valign="top"><?php if ( $col[8][$k] <> 0 ) { ?><?php echo $col[8][$k] ?><?php } ?></td>
					<td width="4%" align="center" valign="top"><?php if ( $col[8][$k] <> 0 ) { ?><?php echo $nilpot_10.'%' ?><?php } ?></td>
					<td width="2%" align="center" valign="top"><?php if ( $col[9][$k] <> 0 ) { ?><?php echo $col[9][$k] ?><?php } ?></td>
			        <td width="2%" align="center" valign="top"><?php if ( $col[9][$k] <> 0 ) { ?><?php echo $nilpot_11.'%' ?><?php } ?></td>
			        <td width="1%" align="right" valign="top"><?php if ( $col[10][$k] <> 0 ) { ?><?php echo $col[10][$k] ?><?php } ?></td>
			        <td width="2%" align="right" valign="top"><?php if ( $col[10][$k] <> 0 ) { ?><?php echo $nilpot_12.'%' ?><?php } ?></td>
			        <td width="1%" align="right" valign="top"><?php if ( $col[11][$k] <> 0 ) { ?><?php echo $col[11][$k] ?><?php } ?></td>
			        <td width="4%" align="right" valign="top"><?php if ( $col[11][$k] <> 0 ) { ?><?php echo $nilpot_13.'%' ?><?php } ?></td>
			        <td width="1%" align="right" valign="top"><?php if ( $col[12][$k] <> 0 ) { ?><?php echo $col[12][$k] ?><?php } ?></td>
			        <td width="4%" align="right" valign="top"><?php if ( $col[12][$k] <> 0 ) { ?><?php echo $nilpot_14.'%' ?><?php } ?></td>
			        <td width="1%" align="right" valign="top"><?php if ( $col[13][$k] <> 0 ) { ?><?php echo $col[13][$k] ?><?php } ?></td>
				    <td width="3%" align="right" valign="top"><?php if ( $col[13][$k] <> 0 ) { ?><?php echo $nilpot_15.'%' ?><?php } ?></td>
				    <td width="1%" align="right" valign="top"><?php if ( $col[14][$k] <> 0 ) { ?><?php echo $col[14][$k] ?><?php } ?></td>
				    <td width="3%" align="right" valign="top"><?php if ( $col[14][$k] <> 0 ) { ?><?php echo $nilpot_16.'%' ?><?php } ?></td>
				    <td align="center" valign="top"><?php echo $totpot.'%' ?></td>
			    </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="22">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php 
	function ubah_databulan($bulan) {
	    if ( substr($bulan,0,1) == '0' )  $bulan = substr($bulan,1,1);
		return $bulan;
	}

?>