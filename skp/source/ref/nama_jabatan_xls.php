<?php
	include_once "../../includes/includes.php";
	$table = "kd_jabatan";
	$field = array("id","kode","kdkel","kdjab","nmjabatan","klsjabatan","kdunitkerja","tahun");
	$kdunit = $_REQUEST['kdunit'];

	$kdunitkerja = substr($kdunit,0,5) ;
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%'
			 ORDER BY kdunitkerja,klsjabatan desc,kdkel,kdjab,nmjabatan");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_array($oList)) {
			$col[0][] = $List['id'];
			$col[2][] = $List['kdkel'];
			$col[3][] = $List['kdjab'];
			$col[4][] = $List['nmjabatan'];
			$col[5][] = $List['klsjabatan'];
			$col[6][] = $List['kdunitkerja'];
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
<table width="69%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th width="10%">Kode</th>
			<th>Nama Jabatan </th>
			
            <th width="30%">Satker</th>
            <th width="5%">Grade</th>
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
					<td align="center" valign="top"><?php echo $col[2][$k].'.'.$col[3][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
				    <td align="left" valign="top"><?php echo nm_unitkerja($col[6][$k]) ?></td>
				    <td align="center" valign="top"><?php echo $col[5][$k] ?></td>
	            </tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>
