<?php
	include_once "../../includes/includes.php";
 	$th      = $_REQUEST['th'];
	$kdunit  = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker","prosen_potongan","nil_potongan","nil_terima");
	
	if ( $kdunit == '2320100' )
	{
		$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									 ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' )
									  ORDER BY grade desc,kdgol,kdjabatan ");
	}else{
		$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan'  
										and kdunitkerja LIKE '$xkdunit%' 
										ORDER BY grade desc,kdgol,kdjabatan ");
	}
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	
	// start export
	header("Content-type: application/octet-stream");
	$filename = "daftar_penerima_" . $kdsatker ."_" . $kdbulan . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("DAFTAR PENERIMA TUNJANGAN KINERJA<br>");
	$b=(int) $kdbulan;
	if ( $b <> 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . " $th<br><br>");
	if ( $b == 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . "TAHUN "." $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_unitkerja($kdunit)) . "<br><br>");	
?>	
<table width="58%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="3%" rowspan="3">No.</th>
			<th rowspan="3">Nama Pegawai /<br /> NIP / Gol / Status</th>
			<th width="20%" rowspan="3">Nama Jabatan/<br />TMT / <br /> Grade</th>
		    <th width="8%" rowspan="3">Tunjangan<br />Kinerja</th>
            <th width="8%" rowspan="3">Pajak<br />Tunjangan<br />Kinerja</th>
		    <th width="8%" rowspan="3">Tunjangan Kinerja<br />
	      Setelah Ditambah<br />Pajak</th>
		    <th colspan="4">Potongan</th>
		    <th width="8%" rowspan="3">Jumlah<br />Dibayarkan</th>
		    <th width="8%" rowspan="3">Nomor<br />Rekening</th>
	    </tr>
		<tr>
		  <th width="8%" rowspan="2">Pajak</th>
	      <th width="8%" colspan="2">Kehadiran</th>
	      <th width="8%" rowspan="2">Jumlah Potongan</th>
      </tr>
		<tr>
		  <th>(%)</th>
	      <th>Rp.</th>
	  </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6=4+5)</th>
		  <th>(7)</th>
		  <th>(8)</th>
		  <th>(9=4x8)		  </th>
		  <th>(10=7+9)</th>
		  <th>(11=6-10)</th>
		  <th>(12)</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="12">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$nip = $col[3][$k] ;
				$sql_bank = "SELECT no_rek FROM mst_rekening WHERE nip = '$nip'";
				$oList_bank = mysql_query($sql_bank) ;
				$List_bank  = mysql_fetch_array($oList_bank) ;
				
				$bulan = $th.'-'.$kdbulan ;
				$sql_pot = "SELECT TOT FROM potongan WHERE nip = '$nip' and bulan = '$bulan'";
				$oList_pot = mysql_query($sql_pot) ;
				$List_pot  = mysql_fetch_array($oList_pot) ;
				$potongan_p = $List_pot['TOT'] ;
				$potongan_r = ( $potongan/100 ) * $col[10][$k] ;
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[3][$k]).'<br>'.nm_gol($col[6][$k]).' / '.nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[5][$k],$col[4][$k]) ?>
					<br /><?php echo '['.reformat_tgl($col[8][$k]).']' ?><br /><?php echo 'Grade '.$col[9][$k] ?></td>
					<td align="right" valign="top"><?php echo number_format($col[10][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format(($col[10][$k]+$col[11][$k]),"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($potongan_p,"2",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($potongan_r,"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col[11][$k]+$potongan_r,"0",",",".") ?></td>
				    <td align="right" valign="top"><strong><?php echo number_format(($col[10][$k]-$potongan_r),"0",",",".") ?></strong></td>
				    <td align="left" valign="top"><?php echo $List_bank['no_rek'] ?></td>
				</tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="12">&nbsp;</td>
		</tr>
	</tfoot>
</table>
