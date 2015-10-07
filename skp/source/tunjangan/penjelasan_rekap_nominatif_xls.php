<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
	$th = $_REQUEST['th'];
	$kdbulan = $_REQUEST['kdbulan'];
    $kdsatker = $_REQUEST['kdsatker'];
	
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' and jml_hari <> 0 ORDER BY grade desc");

	$count = mysql_num_rows($oList);
	while ($List = mysql_fetch_array($oList))
	{
		$col[0][] 	= $List['id'];
		$col[1][] 	= $List['kdunitkerja'];
		$col[2][] 	= $List['kdpeg'];
		$col[3][] 	= $List['kdunitkerja'];
		$col[4][] 	= $List['tunker'];
		$col[5][] 	= $List['pajak_tunker'];
		$col[6][] 	= $List['jml_hari'];
		$col[7][] 	= $List['grade'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total    +=  $List['jumlah'];
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "penjelasan_rekap_nominatif_" . $kdsatker ."_" . $kdbulan . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("PENJELASAN TANDA (*)<br>");
	print("REKAPITULASI TUNJANGAN KINERJA<br>");
	print("BADAN TENAGA NUKLIR NASIONAL<br>");
	$b=(int) $kdbulan;
	if ( $b <> 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . " $th<br><br>");
	if ( $b == 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . "TAHUN "." $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_satker($kdsatker)) . "<br><br>");	
?>
<table width="81%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="22%">Kelas Jabatan </th>
            <th width="10%">Jumlah<br />
          Penerima</th>
            <th width="10%">Jumlah<br />Hari</th>
            <th width="21%">Tunjangan Kinerja</th>
            <th width="20%">Pajak Tunker </th>
          <th width="18%">Tunjangan ditambah Pajak </th>
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
<?php 
if ( $col[7][$k] <> $grade and $grade <> '' ) {	
	$oList_rekap = mysql_query("SELECT count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' and grade = '$grade' and jml_hari = 0 GROUP BY grade ");
	$List_rekap = mysql_fetch_array($oList_rekap);
	$penerima += $List_rekap['jumlah'] ;
	$jumlah_tunker += $List_rekap['jml_tunker'] ;
	$jumlah_pajak += $List_rekap['jml_pajak'] ;
?>				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo '' ?></td>
				  <td align="center" valign="top"><?php echo $List_rekap['jumlah'] ?></td>
				  <td align="center" valign="top"><?php echo hari_bulan($th,$kdbulan) ?></td>
				  <td align="right" valign="top"><?php echo number_format($List_rekap['jml_tunker'],"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($List_rekap['jml_pajak'],"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($List_rekap['jml_tunker']+$List_rekap['jml_pajak'],"0",",",".") ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><strong>JUMLAH</strong></td>
				  <td align="center" valign="top"><strong><?php echo $penerima.'(*)' ?></strong></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong><?php echo number_format($jumlah_tunker,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($jumlah_pajak,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($jumlah_pajak+$jumlah_tunker,"0",",",".") ?></td>
	  </tr>
	  <?php 
	  	$penerima = 0 ;
	  ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
	  </tr>
<?php	  
	  		} 
		$penerima += 1 ;
		$jumlah_tunker += $col[4][$k] ;
		$jumlah_pajak += $col[5][$k] ;
			?>
				<tr class="<?php echo $class ?>">
					<td align="left" valign="top"><?php if ( $col[7][$k] <> $col[7][$k-1] ) {?><?php echo 'Kelas Jabatan '.$col[7][$k] ?><?php }?></td>
			        <td align="center" valign="top"><?php echo 1 ?></td>
			        <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
			        <td align="right" valign="top"><?php echo $col[4][$k].'<br>'.'( '.$col[6][$k] .'/'. hari_bulan($th,$kdbulan) .' x ' .number_format(rp_grade($col[3][$k],$col[7][$k],$col[2][$k]),"0",",",".").' )' ?></td>
			        <td align="right" valign="top"><?php echo $col[5][$k] ?></td>
			        <td align="right" valign="top"><?php echo $col[4][$k]+$col[5][$k] ?></td>
				</tr>
<?php			$grade = $col[7][$k];
			}
		} ?>
		
<?php 
	$oList_rekap = mysql_query("SELECT count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' and grade = '$grade' and jml_hari = 0 GROUP BY grade ");
	$List_rekap = mysql_fetch_array($oList_rekap);
	$penerima += $List_rekap['jumlah'] ;
	$jumlah_tunker += $List_rekap['jml_tunker'] ;
	$jumlah_pajak += $List_rekap['jml_pajak'] ;
?>				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo '' ?></td>
				  <td align="center" valign="top"><?php echo $List_rekap['jumlah'] ?></td>
				  <td align="center" valign="top"><?php echo hari_bulan($th,$kdbulan) ?></td>
				  <td align="right" valign="top"><?php echo number_format($List_rekap['jml_tunker'],"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($List_rekap['jml_pajak'],"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($List_rekap['jml_tunker']+$List_rekap['jml_pajak'],"0",",",".") ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><strong>JUMLAH</strong></td>
				  <td align="center" valign="top"><strong><?php echo $penerima.'(*)' ?></strong></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong><?php echo number_format($jumlah_tunker,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($jumlah_pajak,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($jumlah_pajak+$jumlah_tunker,"0",",",".") ?></td>
	  </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
