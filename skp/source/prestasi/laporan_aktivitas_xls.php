<?php
	include_once "../../includes/includes.php";
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp");
	$id_skp = $_REQUEST['id_skp'];
	$nib = $_REQUEST['nib'];
	$th = $_REQUEST['th'];
	$tgl1 = $_REQUEST['tgl1'];
	$tgl2 = $_REQUEST['tgl2'];

	$sql = "SELECT * FROM mst_skp WHERE tahun = '$th' and nip = '$nib' ";

	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	// start export
	header("Content-type: application/octet-stream");
	$filename = "laporan_aktifitas_" . $nib ."_" . $tgl1 ."_" . $tgl2. ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
?>	
	<table width="755" cellspacing="1">
		
		<tr>
		  <td colspan="2" align="center"><strong>BUKU HARIAN CATATAN PELAKSANAAN TUGAS</strong></td>
	  </tr>
		<tr>
		  <td colspan="2" align="center"><strong>Tanggal <?php echo reformat_tanggal($tgl1).' s/d '.reformat_tanggal($tgl2) ?></strong></td>
	  </tr>
		<tr>
		  <td colspan="2" align="left"><strong>PEJABAT YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td width="140" class="key">Nama</td>
		  <td width="606"><?php echo nama_peg($row['nip']) ?></td>
	  </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru($row['nip']) ?></td>
	  </tr>
		<tr>
		  <td class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></td>
	  </tr>
		<tr>
		  <td class="key">Jabatan</td>
		  <td><?php echo nm_jabatan_ij($row['kdjabatan']);
				  ?>          </td>
	  </tr>
		<tr>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo nm_unitkerja(substr($row['kdunitkerja'],0,4).'00').' - RISTEK' ?></td>
	  </tr>
		<tr>
		  <td colspan="2" align="center">&nbsp;</td>
	  </tr>
		<tr>
		  <td colspan="2" align="left"><strong>PEJABAT PENILAI</strong></td>
	  </tr>
		<tr>
		  <td class="key">Nama</td>
		  <td width="606"><?php echo nama_peg($row['nib_atasan']) ?><input type="hidden" name="<?php echo $field[10] ?>" size="20" value="<?php echo $row['id'] ?>" /></td>
      </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru($row['nib_atasan']) ?></td>
	  </tr>
		<tr>
		  <td width="140" class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat(kdgol_peg($row['tahun'],$row['nib_atasan'])).' ('.nm_gol(kdgol_peg($row['tahun'],$row['nib_atasan'])).')' ?></td>
	    </tr>
		<tr>
			<td class="key"> Jabatan </td>
			<td><?php echo jabatan_peg($row['tahun'],$row['nib_atasan']) ?></td>
	    </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td>
		  <?php echo trim(nm_unitkerja(substr(kdunitkerja_peg($row['tahun'],$row['nib_atasan']),0,4).'00')).' - RISTEK' ;
				?>		  </td>
	  </tr>
		<tr>
		  <td colspan="2" align="center" class="row7">&nbsp;</td>
	  </tr>
  </table>
</form>
<table width="58%" cellpadding="1" border="1">
	<thead>
		
		<tr>
		  <th width="3%">No.</th>
		  <th width="12%">Tanggal</th>
		  <th width="37%">Uraian Kegiatan/Kejadian</th>
		  <th width="19%">Hasil</th>
		  <th width="22%">Keterkaitan dengan SKP </th>
      </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and tgl >= '$tgl1' and tgl <= '$tgl2' ORDER BY tgl");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $k+1 ?>&nbsp;</td>
					<td align="center" valign="top"><?php if ( $col[2][$k] <> $col[2][$k-1] ) { ?><?php echo reformat_tgl($col[2][$k]) ?><?php } ?>&nbsp;</td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?>&nbsp;</td>
					<td align="left" valign="top"><?php echo $col[5][$k] ?>&nbsp;</td>
					<td align="left" valign="top"><?php echo nm_skp($col[6][$k]) ?>&nbsp;</td>
			    </tr>
<?php } 
	  } ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
<?php 
	function nm_skp($id) {
		$data = mysql_query("select nama_tugas from dtl_skp where id='$id'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nama_tugas']);
		return $result;
	}
?>