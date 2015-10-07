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
			$col[2][] = $List['nip'];
			$col[3][] = $List['kdunitkerja'];
			$col[4][] = $List['kdjabatan'];
			$col[5][] = $List['kdgol'];
			$col[6][] = $List['tmtjabatan'];
			$col[7][] = $List['kdstatuspeg'];
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "pemegang_jabatan_" . $xkdunit . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("DAFTAR PEMEGANG JABATAN<br>");
	print("UNIT KERJA : " . strtoupper(nm_unitkerja($kdunit)) . "<br><br>");	
?>
<table width="58%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th width="29%">Bidang/Bagian<br />SubBidang/SubBaagian</th>
			<th width="24%">Nama Pegawai </th>
			<th width="5%">Gol<br />Status</th>
			<th width="19%">Nama Jabatan<br />TMT</th>
		    <th width="8%">Grade</th>
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
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){?><?php echo nm_unitkerja($col[3][$k]) ?><?php }?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[2][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_gol($col[5][$k]).'<br>'.nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[4][$k],$col[3][$k]).'<br>'.'['.reformat_tgl($col[6][$k]).']' ?></td>
					<td align="center" valign="top"><?php echo nil_grade($col[4][$k],$col[3][$k]) ?></td>
			    </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
