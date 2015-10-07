<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
 	$th = $_REQUEST['th'];
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
	$kdsatker = $_REQUEST['kdsatker'];
	$oList = mysql_query("SELECT nib,nip,norec,sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY nib ORDER BY nib, grade desc");
	$no = 0 ;
	$count = mysql_num_rows($oList);
	while($List = mysql_fetch_object($oList)) {
			$no += 1 ;
			$col[0][] = $no ;
			$col[1][] = $List->nib;
			$col[2][] = $List->norec;
			$col[3][] = $List->jml_terima;
			$col[4][] = $List->nip;
			$total += $List->jml_terima ;
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "expor_bank_" . $kdsatker ."_" . $kdbulan1 ."_" . $kdbulan2. ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<table width="115%" cellpadding="1" border="1">
	<thead>
		
		<tr>
		  <th width="7%">No.</th>
		  <th width="20%">Nomor Rekening </th>
		  <th width="25%">Nama Pegawai</th>
		  <th width="12%">NIB</th>
		  <th width="14%">NIP</th>
		  <th width="15%">Jumlah</th>
		  <th width="7%">Total</th>
	  </tr>
		<tr>
		  <th>1</th>
		  <th>2</th>
		  <th>3</th>
		  <th>4</th>
		  <th>5</th>
		  <th>6</th>
		  <th>7</th>
	  </tr>
	</thead>
	<tbody>
<?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="15">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    				 <tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[0][$k] ?></td>
					<td align="left" valign="top"><?php echo "'".$col[2][$k] ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[1][$k]) ?></td>
					<td align="center" valign="top"><?php echo $col[1][$k] ?></td>
					<td align="center" valign="top">
					<?php echo "'".$col[4][$k] ?></td>
					<td align="right" valign="top"><?php echo $col[3][$k] ?></td>
					<td align="right" valign="top"><?php if ( $col[0][$k] == 1 ) {?><?php echo $total ?><?php }?></td>
			    </tr>
		<?php
		}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
	</tfoot>
</table>
