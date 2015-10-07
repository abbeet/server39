<?php
	include_once "../../includes/includes.php";
	$kdunit = $_REQUEST['kdunit'];
	$kdunitkerja = substr($kdunit,0,5) ;
	if ( $kdunit == '2320100' )
	{
	$oList = mysql_query("SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000'
			   ORDER BY kdunitkerja, kdeselon desc,kdjabatan desc,kdgol desc");
	}else{
	$oList = mysql_query("SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '$kdunitkerja%'
			   ORDER BY kdunitkerja, kdeselon desc,kdjabatan desc,kdgol desc");
	}
	
	$count = mysql_num_rows($oList);
	while($List = mysql_fetch_array($oList)) {
			$col[0][] = $List['id'];
			$col[1][] = $List['nama'];
			$col[2][] = $List['nip'];
			$col[3][] = $List['kdunitkerja'];
			$col[4][] = $List['kdjabatan'];
			$col[5][] = $List['kdgol'];
			$col[7][] = $List['kdstatuspeg'];
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "daftar_rekening_" . $xkdunit . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("DAFTAR REKENING PEGAWAI<br>");
	print("UNIT KERJA : " . strtoupper(nm_unitkerja($kdunit)) . "<br><br>");	
?>
<table width="58%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="3%" rowspan="2">No.</th>
			<th rowspan="2">Nama Pegawai<br />
		  NIP</th>
			<th width="8%" rowspan="2">Gol.Ruang<br />
		  Pangkat</th>
			<th width="5%" rowspan="2">Status</th>
			<th width="15%" rowspan="2">Jabatan</th>
			<th colspan="3">Rekening Bank</th>
		    <th width="15%" rowspan="2">Unit Kerja</th>
	    </tr>
		<tr>
		  <th width="20%">Nama Bank</th>
	      <th width="5%">Nomor Rekening</th>
          <th width="10%">Atas Nama</th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$nip = $col[2][$k] ;
				$sql_bank = "SELECT * FROM mst_rekening WHERE nip = '$nip'";
				$oList = mysql_query($sql_bank) ;
				$List  = mysql_fetch_array($oList) ;
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo $col[1][$k] ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[2][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_gol($col[5][$k]).'<br>'.nm_pangkat($col[5][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[4][$k],$col[3][$k]) ?></td>
					<td align="left" valign="top"><?php echo $List['bank'] ?></td>
					<td align="center" valign="top"><?php echo $List['no_rek'] ?></td>
					<td align="left" valign="top"><?php echo 	$List['penerima'] ?></td>
					<td align="left" valign="top"><?php echo nm_unitkerja($col[3][$k]) ?></td>
			    </tr>
				
				<?php
			$kdunitkerja = 	$col[3][$k] ; 
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
	</tfoot>
</table>
