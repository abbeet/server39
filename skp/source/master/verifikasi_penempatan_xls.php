<?php
	include_once "../../includes/includes.php";
	$table = "mst_skp";
	$xkdunit = $_REQUEST['kdunit'];
	$th = $_REQUEST['th'];
	
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' ORDER BY kdunitkerja , kdjabatan,kdgol ");

	$count = mysql_num_rows($oList);
	while($List = mysql_fetch_array($oList)) {
			$col[0][] = $List['id'];
			$col[2][] = $List['nib'];
			$col[3][] = $List['kdunitkerja'];
			$col[4][] = $List['kdjabatan'];
			$col[5][] = $List['kdgol'];
	}
	// start export
	if ( substr(date('m'),0,1) == '0' )  $bulan = substr(date('m'),1,1);
	else $bulan = date('m');
	header("Content-type: application/octet-stream");
	$filename = "verifikasi_penempatan_" . $kdunit . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("VERIFIKASI PENEMPATAN PEGAWAI PER ".strtoupper(nama_bulan($bulan)).' '.$th."<br>");
	print("UNIT KERJA : " . strtoupper(nm_unitkerja($xkdunit.'00')) . "<br><br>");	
?>
<table width="58%" cellpadding="1" border="1">
	<thead>
		<tr>
			<th width="9%">No.</th>
			<th width="25%">Nama Pegawai<br />
		  NIP</th>
			<th width="15%">Golongan<br />
		  Ruang/TMT</th>
			<th width="27%">Jabatan</th>
		    <th width="12%">Kelas Jabatan</th>
            <th width="12%">Unit Kerja</th>
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
					<td align="center" valign="top"><?php if ( $col[3][$k] <> $kdunitkerja ) { ?><font color="#0033FF"><strong><?php echo $limit*($pagess-1)+($k+1); ?></strong></font><?php }else{ ?><?php echo $limit*($pagess-1)+($k+1); ?><?php } ?></td>
					<td align="left" valign="top"><?php if ( $col[3][$k] <> $kdunitkerja ) { ?><font color="#0033FF"><strong><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru(nip_peg($col[2][$k])) ?></strong></font><?php }else{ ?><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru(nip_peg($col[2][$k])) ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[3][$k] <> $kdunitkerja ) { ?><font color="#0033FF"><strong><?php echo nm_pangkat($col[5][$k]).'('.nm_gol($col[5][$k]).')<br>'.reformat_tanggal(tmtgol_peg($col[2][$k])) ?></strong></font><?php }else{ ?><?php echo nm_pangkat($col[5][$k]).'('.nm_gol($col[5][$k]).')<br>'.reformat_tanggal(tmtgol_peg($col[2][$k])) ?><?php } ?></td>
					<td align="left" valign="top"><?php if ( $col[3][$k] <> $kdunitkerja ) { ?><font color="#0033FF"><strong><?php echo nm_info_jabatan($col[3][$k],$col[4][$k]) ?></strong></font><?php }else{ ?><?php echo nm_info_jabatan($col[3][$k],$col[4][$k]) ?><?php } ?>
					<?php if ( kdeselon_peg($col[2][$k]) <> ''  and substr(kdjnsskfung_peg($col[2][$k]),0,1) == '0' ) { ?>
					<br /><font color="#0033FF"><strong><?php echo jabfung_peg($col[2][$k]) ?></strong></font>
					<?php } ?>
					</td>
					<td align="center" valign="top"><?php if ( $col[3][$k] <> $kdunitkerja ) { ?><font color="#0033FF"><strong><?php echo nil_grade($col[4][$k]) ?></strong></font><?php }else{ ?><?php echo nil_grade($col[4][$k]) ?><?php } ?>
					<?php if ( kdeselon_peg($col[2][$k]) <> ''  and substr(kdjnsskfung_peg($col[2][$k]),0,1) == '0' ) { ?>
					<br /><font color="#0033FF"><strong><?php echo nil_grade(kdjabatan_peg($col[2][$k])) ?></strong></font>
					<?php } ?>
					</td>
			        <td align="center" valign="top"><?php if ( $col[3][$k] <> $kdunitkerja ) { ?><font color="#0033FF"><strong><?php echo skt_unitkerja(substr($col[3][$k],0,2)) ?></strong></font><?php }else{ ?><?php echo skt_unitkerja(substr($col[3][$k],0,2)) ?><?php } ?></td>
				</tr>
				
				<?php
			$kdunitkerja = 	$col[3][$k] ; 
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
