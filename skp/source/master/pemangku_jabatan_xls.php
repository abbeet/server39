<?php
	include_once "../../includes/includes.php";
	$table = "mst_skp";
	$field = get_field($table);
 	$th = $_REQUEST['th'];
	$xkdunit = $_REQUEST['kdunit'];
	
	$oList = mysql_query("SELECT id,nib,kdunitkerja,kdjabatan,kdgol FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' 
	ORDER BY kdunitkerja,kdjabatan,kdgol");
	$count = mysql_num_rows($oList);
	while($List = mysql_fetch_array($oList)) {
			$col[0][] = $List['id'];
			$col[2][] = $List['nib'];
			$col[3][] = $List['kdunitkerja'];
			$col[4][] = $List['kdjabatan'];
			$col[5][] = $List['kdgol'];
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
	print("UNIT KERJA : " . strtoupper(nm_unitkerja($xkdunit.'00')) . "<br><br>");	
?>
<table width="58%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th width="29%">Bidang/Bagian<br />SubBidang/SubBaagian</th>
			<th width="24%">Nama Pegawai </th>
			<th width="5%">Gol</th>
			<th width="19%">Nama Jabatan</th>
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
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru(nip_peg($col[2][$k])) ?></td>
					<td align="center" valign="top"><?php echo nm_gol($col[5][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_info_jabatan($col[3][$k],$col[4][$k]) ?></td>
					<td align="center" valign="top"><?php echo nil_grade($col[4][$k]) ?></td>
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
