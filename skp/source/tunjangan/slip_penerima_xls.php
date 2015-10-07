<?php
	include_once "../../includes/includes.php";
	$table = "mst_tk";
	$field = get_field($table);
 	$th = $_REQUEST['th'];
    $kdsatker = $_REQUEST['kdsatker'];
    $kdbulan1 = $_REQUEST['kdbulan1'];
    $kdbulan2 = $_REQUEST['kdbulan2'];
		if ( strlen($kdbulan1) == 1 )    $kdbulan1 = '0'.$kdbulan1 ;
		else $kdbulan1 = $kdbulan1 ;
		if ( strlen($kdbulan2) == 1 )    $kdbulan2 = '0'.$kdbulan2 ;
		else $kdbulan2 = $kdbulan2 ;
	$oList = mysql_query("SELECT nib,nip,norec, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY nib ORDER BY nib");

	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_array($oList)) {
		$col[0][] += 1 ;
		$col[1][] = $List['nib'];
		$col[2][] = $List['nip'];
		$col[3][] = $List['norec'];
		$col[4][] = $List['jml_tunker'];
		$col[5][] = $List['jml_pajak'];
		$col[6][] = $List['jml_terima'];
		$col[7][] = $List['jml_tunker'] - $List['jml_terima'];
		$col[8][] = $List['jml_tunker'] - $List['jml_terima'] + $List['jml_pajak'];
	}
	// start export
	header("Content-type: application/octet-stream");
	$filename = "slip_penerimaan_" . $kdsatker ."_" . $kdbulan1 ."_" . $kdbulan2. ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("SLIP PENERIMAAN TUNJANGAN KINERJA PEGAWAI<br>");
	$b1=(int) $kdbulan1;
	$b2=(int) $kdbulan2;
	print("BULAN " . strtoupper(nama_bulan($b1)) ." S/D " . strtoupper(nama_bulan($b2)). " $th<br>");
	print("SATUAN KERJA : " . strtoupper(nm_satker($kdsatker)) . "<br><br>");	
?>
<table width="76%" cellpadding="1" border="1">
	<thead>
		
		<tr>
		  <th width="6%">No.</th>
		  <th width="15%">Nama Pegawai</th>
		  <th width="17%">NIP<br />
		    Pangkat/Gol<br />Status</th>
		  <th width="21%">Nomor Rekening<br />Nama Jabatan/ TMT<br />
		  Kelas Jabatan</th>
		  <th width="15%">Pajak</th>
		  <th width="8%">Tunjangan<br />
	      Kinerja</th>
		  <th width="7%">Potongan</th>
	      <th width="11%">Jumlah<br />Diterima</th>
      </tr>
		<tr>
		  <th>1</th>
		  <th>2</th>
		  <th>3</th>
		  <th>4</th>
		  <th>5</th>
		  <th>6</th>
		  <th>7</th>
		  <th>8=6-7</th>
	  </tr>
	</thead>
	<tbody>
	<?php foreach ($col[0] as $k=>$val) {
				$no += 1 ;
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				 <tr class="<?php echo $class ?>">
					<td align="center" valign="top"><strong><?php echo $no .'.' ?></strong></td>
					<td align="left" valign="top"><strong><?php echo nama_peg($col[1][$k]) ?></strong></td>
					<td align="center" valign="top"><strong><?php echo reformat_nipbaru($col[2][$k]) ?></strong></td>
					<td align="center" valign="top"><strong><?php echo "'".$col[3][$k] ?></strong></td>
					<td align="right" valign="top"><strong><?php echo $col[5][$k] ?></strong></td>
					<td align="right" valign="top"><strong><?php echo $col[4][$k] ?></strong></td>
			        <td align="right" valign="top"><strong><?php echo $col[7][$k] ?></strong></td>
				    <td align="right" valign="top"><strong><?php echo $col[6][$k] ?></strong></td>
			    </tr>
<?php 
	$nib = $col[1][$k] ;
	$oList_bulan = mysql_query("SELECT bulan,kdgol,kdpeg,kdunitkerja,kdjabatan, tmtjabatan, grade, jml_hari, tunker, pajak_tunker, nil_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' and nib = '$nib' ORDER BY bulan, tmtjabatan");
	while( $List_bulan = mysql_fetch_array($oList_bulan))
	{
		if ( substr($List_bulan['bulan'],0,1) == '0' )  $kdbl = substr($List_bulan['bulan'],1,1) ;
		else $kdbl = $List_bulan['bulan'] ;
?>				
					<tr class="<?php echo $class ?>">
					  <td align="center" valign="top">&nbsp;</td>
					  <td align="right" valign="top"><?php echo strtoupper(nama_bulan($kdbl)) ?></td>
					  <td align="center" valign="top"><?php echo nm_pangkat(substr($List_bulan['kdgol'],0,1).hurufkeangka(substr($List_bulan['kdgol'],1,1))).' ('.nm_gol(substr($List_bulan['kdgol'],0,1).hurufkeangka(substr($List_bulan['kdgol'],1,1))).')' ?><br /><?php echo '('.status_peg($List_bulan['kdpeg']).')' ?></td>
					  <td align="left" valign="top"><?php echo nm_info_jabatan($List_bulan['kdunitkerja'],$List_bulan['kdjabatan']).' ('.reformat_tgl($List_bulan['tmtjabatan']).')' ?><br /><?php echo 'Kelas Jabatan '.$List_bulan['grade'] ?><?php if ( $List_bulan['jml_hari'] <> 0 ) { ?><br /><?php echo '('.$List_bulan['jml_hari'].' hari dari .'.hari_bulan($th,$kdbl).' hari kerja)' ?><?php }?></td>
					  <td align="right" valign="top"><?php echo $List_bulan['pajak_tunker'] ?></td>
					  <td align="right" valign="top"><?php echo $List_bulan['tunker'] ?></td>
					  <td align="right" valign="top"><?php echo $List_bulan['tunker'] - $List_bulan['nil_terima'] ?></td>
					  <td align="right" valign="top"><?php echo $List_bulan['nil_terima'] ?></td>
				    </tr>
				
				<?php
		}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</tfoot>
</table>
