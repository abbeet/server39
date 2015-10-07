<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
 	$th = $_REQUEST['th'];
	$kdunit = $_REQUEST['kdunit'] ;
	$kdbulan = $_REQUEST['kdbulan'];
	$xkdunit = substr($kdunit,0,5) ;
	if ( $kdunit == '2320100' )
	{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and ( kdunitkerja LIKE '$xkdunit%' 
						  OR kdunitkerja = '2320000' ) ORDER BY grade desc,kdgol,kdjabatan ");
	}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%' ORDER BY grade desc,kdgol,kdjabatan ");
	}
	$count = mysql_num_rows($oList);
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "daftar_nominatif_" . $kdunit ."_" . $kdbulan . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("DAFTAR NOMINATIF TUNJANGAN KINERJA<br>");
	$b=(int) $kdbulan;
	if ( $b <> 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . " $th<br><br>");
	if ( $b == 13 )     print("BULAN " . strtoupper(nama_bulan($b)) . "TAHUN "." $th<br><br>");
	print("SATUAN KERJA : " . strtoupper(nm_unitkerja($kdunit)) . "<br><br>");	
?>
<table width="58%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="3%">No.</th>
			<th>Nama Pegawai / NIP </th>
			<th width="10%">Pangkat/<br />
	      Gol</th>
			<th width="5%">Status<br />(PNS/<br />CPNS)</th>
			<th width="20%">Nama Jabatan/<br />TMT</th>
		    <th width="5%">Grade</th>
            <th width="10%">Tunjangan<br />Kinerja</th>
            <th width="10%">Pajak<br />Tunjangan<br />Kinerja</th>
		    <th width="10%">Tunjangan Kinerja<br />
	      Setelah Ditambah<br />Pajak</th>
	    </tr>
		<tr>
		  <th><?php echo '(1)' ?></th>
		  <th><?php echo '(2)' ?></th>
		  <th><?php echo '(3)' ?></th>
		  <th><?php echo '(4)' ?></th>
		  <th><?php echo '(5)' ?></th>
		  <th><?php echo '(6)' ?></th>
		  <th><?php echo '(7)' ?></th>
		  <th><?php echo '(8)' ?></th>
		  <th><?php echo '(9=7+8)' ?></th>
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
//				$gaji_bruto    = $col[11][$k] + rp_grade(substr($col[6][$k],0,2),$col[9][$k],$col[22][$k]);
//				$pajak_total   = nil_pajak($gaji_bruto,$col[10][$k],$col[16][$k]); ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[3][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_pangkat($col[6][$k]).'<br>'.nm_gol($col[6][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[5][$k],$col[4][$k]) ?>
					<br /><?php echo '['.reformat_tgl($col[8][$k]).']' ?></td>
					<td align="center" valign="top"><?php echo $col[9][$k] ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[10][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format(($col[10][$k]+$col[11][$k]),"0",",",".") ?></td>
			    </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
	</tfoot>
</table>
