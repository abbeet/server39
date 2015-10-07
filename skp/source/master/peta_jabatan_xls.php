<?php
	include_once "../../includes/includes.php";
	$table = "mst_skp";
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
	$filename = "peta_jabatan_" . $xkdunit . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("PETA JABATAN<br>");
	print("UNIT KERJA : " . strtoupper(nm_unitkerja($xkdunit.'00')) . "<br><br>");	
?>
<table width="667" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="4%" rowspan="2">No.</th>
			<th width="8%" rowspan="2">Unit Kerja</th>
			<th width="9%" rowspan="2">Nama Jabatan </th>
			
            <th colspan="2">Jumlah</th>
            <th width="8%" rowspan="2">Seli<br />sih</th>
          <th width="12%" rowspan="2">Nama Pegawai </th>
			<th width="5%" rowspan="2">Gol.</th>
			<th colspan="3">Jabatan Pegawai</th>
	        <th width="21%" rowspan="2">Grade</th>
		</tr>
		<tr>
		  <th width="8%">J1</th>
	      <th width="8%">J2</th>
          <th width="8%">Struktural</th>
          <th width="9%">Fungsional</th>
	      <th width="21%">Umum</th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="12">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				<?php 
				$plus = '' ;
				$selisih = jml_j2($th,$col[3][$k],$col[4][$k]) - jml_info_jabatan($col[3][$k],$col[4][$k]) ;
				if ( $selisih >= 1 )     $plus = '+' ;
				?>
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){?><?php echo nm_unitkerja($col[3][$k]) ?><?php }?></td>
					<td align="left" valign="top"><?php if( $col[4][$k] <> $col[4][$k-1] ){?><?php echo nm_info_jabatan($col[3][$k],$col[4][$k]) ?><?php }?></td>
					<td align="center" valign="top"><?php if( $col[4][$k] <> $col[4][$k-1] ){?><?php echo jml_info_jabatan($col[3][$k],$col[4][$k]) ?><?php }?></td>
					<td align="center" valign="top"><?php if( $col[4][$k] <> $col[4][$k-1] ){?><?php echo jml_j2($th,$col[3][$k],$col[4][$k]) ?><?php }?></td>
					<td align="center" valign="top"><?php if( $col[4][$k] <> $col[4][$k-1] ){?><?php echo $plus.$selisih ?><?php }?></td>
					<td align="left"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'Nip.'.reformat_nipbaru(nip_peg($col[2][$k])) ?></td>
                    <td align="center" valign="top"><?php echo nm_gol($col[5][$k]) ?></td>
                    <td align="left" valign="top"><?php if( substr(jabatan_peg($col[2][$k]),0,6) == 'Kepala' or substr(jabatan_peg($col[2][$k]),0,5) == 'Ketua' ){?><?php echo jabatan_peg($col[2][$k]) ?><?php }?>&nbsp;</td>
                    <td align="left" valign="top"><?php if( substr(jabatan_peg($col[2][$k]),0,6) <> 'Kepala' ){?><?php echo jabatan_peg($col[2][$k]) ?><?php }?>&nbsp;</td>
                    <td align="left" valign="top"><?php if( jabatan_peg($col[2][$k]) == '' ){?><?php echo nm_info_jabatan($col[3][$k],$col[4][$k]) ?><?php }?>&nbsp;</td>
				    <td align="center" valign="top"><?php echo nil_grade($col[4][$k]) ?></td>
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
