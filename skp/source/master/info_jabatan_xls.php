<?php
	include_once "../../includes/includes.php";
	$table = "mst_info_jabatan";
	$field = array("id","kdunitkerja","kdjabatan","jumlah","grade");
	$kdunit = $_REQUEST['kdunit'];
	
	$xkdunit = substr($kdunit,0,5) ;
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '%$xkdunit%' ORDER BY kdunitkerja,grade desc");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_array($oList)) {
			$col[0][] = $List['id'];
			$col[1][] = $List['kdunitkerja'];
			$col[2][] = $List['kdjabatan'];
			$col[3][] = $List['jumlah'];
			$col[4][] = $List['grade'];
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "nama_jabatan_" . $kdunit . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("DAFTAR NAMA JABATAN<br>");
	print( strtoupper(nm_unitkerja($kdunit)) . "<br><br>");	
?>
<table cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="6%">No.</th>
			<th width="12%">Unit Kerja</th>
			<th width="13%">Nama Jabatan </th>
			
            <th width="7%">Jumlah</th>
            <th width="7%">Grade</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if( $col[1][$k] <> $col[1][$k-1] ){?><?php echo nm_unitkerja($col[1][$k]) ?><?php }?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[2][$k],$col[1][$k]) ?></td>
					<td align="center" valign="top"><?php echo $col[3][$k] ?></td>
				    <td align="center" valign="top"><?php echo $col[4][$k] ?></td>
				</tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>
