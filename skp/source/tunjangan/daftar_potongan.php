<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_potongan";
	$field = get_field($table);
	$ed_link = "index.php?p=348";
	$del_link = "index.php?p=356";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	$kdbulan = $_REQUEST['kdbulan'];
	
	if ( $kdbulan == '' ) $kdbulan = date('m');

if ( $_REQUEST['cari_satker'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan = $_REQUEST['kdbulan'];
}	
	
if ( $_REQUEST['cari'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan = $_REQUEST['kdbulan'];
}	

switch ($xlevel)
	{
		case '7':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan'";
			break;
		case '2':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
		if ( $xkdunit == '13' )
		{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and ( left(kdunitkerja,2) = '$xkdunit' or  kdunitkerja = '0000' or kdunitkerja = '1000' or kdunitkerja = '2000' or kdunitkerja = '3000' or kdunitkerja = '4000' or kdunitkerja = '5000' ) and bulan = '$kdbulan'";
		}else{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan'";
		}
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan'";
			break;
	} 
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&kdsatker=$kdsatker&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

switch ($xlevel)
	{
		case '7':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan' ORDER BY grade desc, kdgol desc,kdunitkerja LIMIT $start, $limit");
			break;
		case '2':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
		if ( $xkdunit == '13' )
		{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and ( left(kdunitkerja,2) = '$xkdunit' or  kdunitkerja = '0000' or kdunitkerja = '1000' or kdunitkerja = '2000' or kdunitkerja = '3000' or kdunitkerja = '4000' or kdunitkerja = '5000' ) and bulan = '$kdbulan' ORDER BY kdunitkerja, grade desc,kdgol desc LIMIT $start, $limit");
		}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan' ORDER BY kdunitkerja, grade desc, kdgol desc LIMIT $start, $limit");
		}
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' ORDER BY grade desc, kdgol, kdunitkerja desc LIMIT $start, $limit");
			brek;
	} 

	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
	if ($pagess == 0) $pagess = 1;	#jika variabel kosong maka defaultnya halaman pertama.
	$prev = $pagess - 1;					#halaman sebelumnya
	$next = $pagess + 1;					#halaman berikutnya
	$lastpage = ceil($total_pages/$limit);		
	$lpm1 = $lastpage - 1;						
 
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		#Link halaman sebelumnya
		if ($pagess > 1) 
			$pagination.= "<a href=\"$targetpage&pagess=$prev\"><< Sebelumnya</a>";
		else
			$pagination.= "<span class=\"disabled\"><< Sebelumnya</span>";	
 
		#halaman
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $pagess)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	#enough pages to hide some
		{
 
			if($pagess < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $pagess)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&pagess=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=$lastpage\">$lastpage</a>";		
			}
 
			elseif($lastpage - ($adjacents * 2) > $pagess && $pagess > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&pagess=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=2\">2</a>";
				$pagination.= "...";
				for ($counter = $pagess - $adjacents; $counter <= $pagess + $adjacents; $counter++)
				{
					if ($counter == $pagess)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&pagess=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=$lastpage\">$lastpage</a>";		
			}
 
			else
			{
				$pagination.= "<a href=\"$targetpage&pagess=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $pagess)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
				}
			}
		}
 
		#link halaman selanjutnya
		if ($pagess < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&pagess=$next\">Selanjutnya >></a>";
		else
			$pagination.= "<span class=\"disabled\">Selanjutnya >></span>";
		$pagination.= "</div>\n";		
	}
	
	echo $pagination;
?>
<?php if ( $xlevel == 1 ) {?>
<div align="left">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Satker : 
		<select name="kdsatker">
                      <option value="<?php echo $kdsatker ?>"><?php echo  substr(nm_satker($kdsatker),0,60) ?></option>
                      <option value="">- Pilih Satker -</option>
                    <?php
							$query = mysql_query("select left(nmsatker,60) as nama_satker, kdsatker from kd_satker group by kdsatker order by kdsatker");
					while( $row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['nama_satker']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari_satker"/>
	</form>
</div>
<?php }?>
<div align="right">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Pilih Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
					<?php if ( $pagess == '' ) {?>
						<option value="<?php echo $i; ?>" <?php if ($i == date("m") ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					}else{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					}
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div>
<?php 
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ?><br />
<?php if ( $xlevel == 2 ) 
      {?>
<a href="source/tunjangan/daftar_potongan_prn.php?kdunit=<?php echo $xkdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak</font></a>
<?php }else{  
	if ( $xlevel == 7 )    $kdsatker = $xusername ;
?>	
<a href="source/tunjangan/daftar_potongan_prn.php?kdsatker=<?php echo $kdsatker ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>&nbsp;&nbsp;|
<a href="source/tunjangan/daftar_potongan_pdg_xls.php?kdsatker=<?php echo $kdsatker ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>
<?php } ?>		  
<table width="65%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="2%" rowspan="3">No.</th>
			<th width="4%" rowspan="3"><?php if ( $xlevel == 2 ) {?>Unit Kerja<?php }else{ ?>Jabatan<?php } ?></th>
			<th width="4%" rowspan="3">Nama Pegawai</th>
			<th width="2%" rowspan="3">NIP</th>
			<th width="2%" rowspan="3">Grade</th>
		    <th colspan="12">Catatan Kehadiran Harian </th>
		    <th rowspan="3">Tanpa<br />Ket.</th>
		    <th colspan="6">Cuti</th>
            <th colspan="2" rowspan="2">Pendidikan dan Pelatihan </th>
            <th width="5%" rowspan="3">Tidak<br />Mengukuti<br />Upacara</th>
            <th width="5%" rowspan="3">Jumlah<br />
          Potongan<br />(%)</th>
		    <th colspan="2" rowspan="3">Aksi</th>
		</tr>
		<tr>
		  <th colspan="4">Terlambat (TL) </th>
		  <th colspan="4">Keluar Sementara (KS)</th>
		  <th colspan="4">Pulang Sebelum Waktu (PSW)</th>
		  <th rowspan="2">CT</th>
	      <th rowspan="2">CB</th>
	      <th rowspan="2">CSRI</th>
	      <th rowspan="2">CSRJ</th>
	      <th rowspan="2">CM</th>
	      <th rowspan="2">CP</th>
      </tr>
		<tr>
		  <th width="2%">TL1</th>
	      <th width="2%">TL2</th>
	      <th width="2%">TL3</th>
	      <th width="1%">TL4</th>
	      <th width="1%">KS1</th>
	      <th width="1%">KS2</th>
	      <th width="1%">KS3</th>
	      <th width="1%">KS4</th>
	      <th width="6%">PSW1</th>
	      <th width="3%">PSW2</th>
	      <th width="3%">PSW3</th>
	      <th width="4%">PSW4</th>
	      <th width="5%">kurang dari 3 bulan </th>
	      <th width="5%">3 bulan atau lebih </th>
	  </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6)</th>
		  <th>(7)</th>
		  <th>(8)</th>
		  <th>(9)</th>
		  <th>(10)</th>
		  <th>(11)</th>
		  <th>(12)</th>
		  <th>(13)</th>
		  <th>(14)</th>
		  <th>(15)</th>
		  <th>(16)</th>
		  <th>(17)</th>
		  <th>(18)</th>
		  <th>(19)</th>
		  <th>(20)</th>
		  <th>(21)</th>
		  <th>(22)</th>
		  <th>(23)</th>
		  <th>(24)</th>
		  <th>(25)</th>
		  <th>(26)</th>
		  <th>(27)</th>
		  <th>(28)</th>
		  <th colspan="2">&nbsp;</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="30">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				// bulan januari dan maret TK masih 3%
				if($kdbulan=='01' or $kdbulan=='02')
					$nilpot_10 = $col[8][$k] * 3;
				else
					$nilpot_10 = $col[8][$k] * persen_pot('10') ;
				$nilpot_11 = $col[9][$k] * persen_pot('11') ;
				$nilpot_12 = $col[10][$k] * persen_pot('12') ;
				$nilpot_13 = $col[11][$k] * persen_pot('13') ;
				$nilpot_14 = $col[12][$k] * persen_pot('14') ;
				$nilpot_15 = $col[13][$k] * persen_pot('15') ;
				$nilpot_16 = $col[14][$k] * persen_pot('16') ;
				$nilpot_01 = $col[18][$k] * persen_pot('01') ;
				$nilpot_02 = $col[19][$k] * persen_pot('02') ;
				$nilpot_03 = $col[20][$k] * persen_pot('03') ;
				$nilpot_04 = $col[21][$k] * persen_pot('04') ;
				$nilpot_05 = $col[22][$k] * persen_pot('05') ;
				$nilpot_06 = $col[23][$k] * persen_pot('06') ;
				$nilpot_07 = $col[24][$k] * persen_pot('07') ;
				$nilpot_08 = $col[25][$k] * persen_pot('08') ;
				$nilpot_21 = $col[26][$k] * persen_pot('21') ;
				$nilpot_22 = $col[27][$k] * persen_pot('22') ;
				$nilpot_23 = $col[28][$k] * persen_pot('31') ;
				$nilpot_24 = $col[29][$k] * persen_pot('32') ;
				$nilpot_25 = $col[30][$k] * persen_pot('33') ;
				$nilpot_26 = $col[31][$k] * persen_pot('34') ;
				$nilpot_27 = $col[32][$k] * persen_pot('40') ;
				$nilpot_28 = $col[33][$k] * persen_pot('tk') ;
				$nilpot_29 = $col[34][$k] * persen_pot('cm') ;
				$totpot = $nilpot_10 + $nilpot_11 + $nilpot_12 + $nilpot_13 + $nilpot_14 + $nilpot_15 + $nilpot_16 +
						$nilpot_01 + $nilpot_02 + $nilpot_03 + $nilpot_04 + $nilpot_05 + $nilpot_06 + $nilpot_07 + $nilpot_08+
						$nilpot_21 + $nilpot_22 + $nilpot_23 + $nilpot_24 + $nilpot_25 + $nilpot_26 + $nilpot_27 + $nilpot_28+
						$nilpot_29 ;
//				$gaji_bruto    = $col[11][$k] + rp_grade(substr($col[6][$k],0,2),$col[9][$k]);
//				$pajak_total   = nil_pajak($gaji_bruto,$col[10][$k],$col[16][$k]); ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top">
					<?php if ( $xlevel == 2 ) {?>
					<?php if ( $col[6][$k] <> $col[6][$k-1] ) {?><?php echo nm_unitkerja($col[6][$k]) ?><?php }?>
					<?php }else{ ?>
					<?php echo nmjabatan_mst_tk($col[3][$k],$th,$kdbulan) ?>
					<?php } ?>					</td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]).'<br>'.$col[3][$k] ?></td>
					<td align="center" valign="top"><?php echo reformat_nipbaru($col[4][$k]) ?></td>
					<td align="center" valign="top"><?php echo $col[17][$k] ?></td>
					<td align="center" valign="top"><?php if ( $col[18][$k] <> 0 ) { ?><?php echo $col[18][$k].'<br>'.$nilpot_01.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[19][$k] <> 0 ) { ?><?php echo $col[19][$k].'<br>'.$nilpot_02.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[20][$k] <> 0 ) { ?><?php echo $col[20][$k].'<br>'.$nilpot_03.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[21][$k] <> 0 ) { ?><?php echo $col[21][$k].'<br>'.$nilpot_04.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[28][$k] <> 0 ) { ?><?php echo $col[28][$k].'<br>'.$nilpot_23.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[29][$k] <> 0 ) { ?><?php echo $col[29][$k].'<br>'.$nilpot_24.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[30][$k] <> 0 ) { ?><?php echo $col[30][$k].'<br>'.$nilpot_25.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[31][$k] <> 0 ) { ?><?php echo $col[31][$k].'<br>'.$nilpot_26.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[22][$k] <> 0 ) { ?><?php echo $col[22][$k].'<br>'.$nilpot_05.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[23][$k] <> 0 ) { ?><?php echo $col[23][$k].'<br>'.$nilpot_06.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[24][$k] <> 0 ) { ?><?php echo $col[24][$k].'<br>'.$nilpot_07.' %' ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[25][$k] <> 0 ) { ?><?php echo $col[25][$k].'<br>'.$nilpot_08.' %' ?><?php } ?></td>
					<td width="4%" align="center" valign="top"><?php if ( $col[8][$k] <> 0 ) { ?><?php echo $col[8][$k].'<br>'.$nilpot_10.' %' ?><?php } ?>
					<?php if ( $col[33][$k] <> 0 ) { ?><br /><?php echo $col[33][$k].'(* <br>'.$nilpot_28.' %' ?><?php } ?>
					</td>
					<td width="4%" align="center" valign="top"><?php if ( $col[9][$k] <> 0 ) { ?><?php echo $col[9][$k].'<br>'.$nilpot_11.' %' ?><?php } ?></td>
			        <td width="4%" align="right" valign="top"><?php if ( $col[10][$k] <> 0 ) { ?><?php echo $col[10][$k].'<br>'.$nilpot_12.' %' ?><?php } ?></td>
			        <td width="4%" align="right" valign="top"><?php if ( $col[11][$k] <> 0 ) { ?><?php echo $col[11][$k].'<br>'.$nilpot_13.' %' ?><?php } ?></td>
			        <td width="4%" align="right" valign="top"><?php if ( $col[12][$k] <> 0 ) { ?><?php echo $col[12][$k].'<br>'.$nilpot_14.' %' ?><?php } ?></td>
			        <td width="4%" align="right" valign="top"><?php if ( $col[13][$k] <> 0 ) { ?><?php echo $col[13][$k].'<br>'.$nilpot_15.' %' ?><?php } ?>
					<?php if ( $col[34][$k] <> 0 ) { ?><br /><?php echo $col[34][$k].'(* <br>'.$nilpot_29.' %' ?><?php } ?>
					</td>
				    <td width="4%" align="right" valign="top"><?php if ( $col[14][$k] <> 0 ) { ?><?php echo $col[14][$k].'<br>'.$nilpot_16.' %' ?><?php } ?></td>
				    <td align="right" valign="top"><?php if ( $col[26][$k] <> 0 ) { ?><?php echo $col[26][$k].'<br>'.$nilpot_21.' %' ?><?php } ?></td>
				    <td align="right" valign="top"><?php if ( $col[27][$k] <> 0 ) { ?><?php echo $col[27][$k].'<br>'.$nilpot_22.' %' ?><?php } ?></td>
				    <td align="right" valign="top"><?php if ( $col[32][$k] <> 0 ) { ?><?php echo $col[32][$k].'<br>'.$nilpot_27.' %' ?><?php } ?></td>
				    <td align="right" valign="top"><?php echo $totpot.' %' ?></td>
				    <td width="2%" align="center" valign="top"><?php if ( $col[15][$k] <> '1'  ) {?><a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>
			  &nbsp;&nbsp;
<a href="<?php echo $del[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>" title="Delete">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>
			  <?php } ?></td>
				</tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="30"><font color="#CC3300">(* sesuai Peraturan Kepala Batan No.216 Tahun 2012 dan berlaku sebelum tgl. 7 Maret 2013</font></td>
		</tr>
	</tfoot>
</table>
<?php 
	function ubah_databulan($bulan) {
	    if ( substr($bulan,0,1) == '0' )  $bulan = substr($bulan,1,1);
		return $bulan;
	}

?>