<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
 	$th = $_REQUEST['th'];
	$kdsatker = $_SESSION['kdsatker'];
	$kdbulan = $_REQUEST['kdbulan'];
	// start export
	header("Content-type: application/octet-stream");
	$filename = "rekap_penerima_" . $kdsatker ."_" . $kdbulan . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("REKAP PENERIMA TUNJANGAN KINERJA PEGAWAI<br>");
	print("BADAN TENAGA NUKLIR NASIONAL<br>");
	$b=(int) $kdbulan;
	if ( $b <> 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . " $th<br><br>");
	if ( $b == 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . "TAHUN "." $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_satker($kdsatker)) . "<br><br>");	
?>
<table width="70%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="7%" rowspan="2">No.</th>
			<th width="37%" rowspan="2">Kelas Jabatan </th>
            <th width="10%" rowspan="2">Jumlah<br />Penerima</th>
            <th width="12%" rowspan="2">Tunjangan Kinerja<br />Per Kelas Jabatan</th>
            <th width="11%" rowspan="2">Tunjangan<br />Kinerja<br />Sebelum Pajak</th>
            <th width="11%" rowspan="2">Tunjangan<br />Pajak</th>
		    <th width="12%" rowspan="2">Jumlah Bruto</th>
		    <th colspan="3">Potongan</th>
		    <th width="12%" rowspan="2">Tunjangan Kinerja<br />Dibayarkan</th>
	    </tr>
		<tr>
		  <th width="12%">Pajak </th>
	      <th width="12%">Faktor<br />Pengurang</th>
	      <th width="12%">Jumlah<br />Potongan</th>
	  </tr>
	</thead>
	<tbody>
<?php 
 switch ($xlevel)
	{
		case '7':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan' GROUP BY grade ORDER BY grade desc");
			break;
		case '2':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan' GROUP BY grade ORDER BY grade desc");
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' GROUP BY grade ORDER BY grade desc");
			brek;
	} 
	$no = 0 ;
	while ($List = mysql_fetch_array($oList))
	{
		$no += 1 ;
		$col_1 	= $List['grade'];
		$col_2 	= $List['jumlah'];
		$col_3 	= $List['tj_pajak'];
		$col_4 	= $List['kdunit'];
		$col_5 	= $List['jml_tunker'];
		$col_6 	= $List['jml_pajak'];
		$col_7   = $List['jml_terima'];
		$col_8   = $List['jml_tunker'] - $List['jml_terima'];
		$col_9   = $List['jml_pajak'] + $List['jml_tunker'] - $List['jml_terima'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total    +=  $List['jumlah'];
		$total_pot += $List['jml_tunker'] - $List['jml_terima'];
		$total_trm    +=  $List['jml_terima'];
		$tunker = rp_grade($List['kdunit'],$List['grade'],1) ;
		if ( $tunker * $List['jumlah'] <> $List['jml_tunker'] ) 
		{
		    $col_10 = '(*)';
			$xx = 1 ;
		}else{
		    $col_10 = ' ';
		}
?>	
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $no.'.' ?></td>
					<td align="left" valign="top"><?php echo 'Kelas Jabatan '.$col_1 ?></td>
			        <td align="center" valign="top"><?php echo $col_2.' '.$col_10 ?></td>
			        <td align="right" valign="top"><?php echo rp_grade($col_4,$col_1,1) ?></td>
			        <td align="right" valign="top"><?php echo $col_5 ?></td>
			        <td align="right" valign="top"><?php echo $col_6 ?></td>
				    <td align="right" valign="top"><?php echo $col_5 + $col_6 ?></td>
				    <td align="right" valign="top"><?php echo $col_6 ?></td>
				    <td align="right" valign="top"><?php echo $col_8 ?></td>
				    <td align="right" valign="top"><?php echo $col_5 + $col_8 ?></td>
				    <td align="right" valign="top"><?php echo $col_7 ?></td>
			    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><strong>Jumlah</strong></td>
				  <td align="center" valign="top"><strong><?php echo $total ?></strong></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong><?php echo $total_tk ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo total_tk + $total_pj ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_pj ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_pot ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_pot + $total_pj ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo $total_trm ?></strong></td>
      </tr>				
	</tbody>
	<tfoot>
		<tr>
			<td colspan="11">
			<?php if ( $xx == 1 )
				  { 
				  echo 'Catatan :<br />(*) Jumlah penerima yang tertera pada isian ini, beberapa pegawai tidak menerima Tunjangan Kinerja 1 bulan penuh';
				  }else{ echo '';
			      } ?>			</td>
		</tr>
	</tfoot>
</table>
