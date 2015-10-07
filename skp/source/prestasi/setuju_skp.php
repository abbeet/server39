<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_skp";
	$field = array("id","tahun","nip","kdunitkerja","kdjabatan","kdgol","nib_atasan","is_approved_awal","tgl_approved_awal","is_approved_akhir");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=263";
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($th,$xusername),0,5);
	$kdsubbidang = kdunitkerja_peg($th,$xusername);
	$kdunitkerja = $xkdunit.'00';
	$kddeputi = substr($xkdunit,0,1) ;
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;

	// hitung jumlah datanya untuk paging
	switch ($xlevel)
	{
		// admin
		case '1':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		// operator
		case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and left(kdunitkerja,4) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		// kapus
		case '3':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	((left(kdunitkerja,4) = '$xkdunit' and nib_atasan = '$xusername') or (kdunitkerja='$kdunitkerja')) and
	(nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		// kabid
		case '4':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	left(kdunitkerja,5) = '$kdbidang' and 
	(nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		// kasub
		case '5':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and kdunitkerja = '$kdsubbidang' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		// staf
		case '6':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and nip = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		// deputi
		case '8':
		if ( $kddeputi <> '1' )
		{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	left(kdunitkerja,1) = '$kddeputi' and right(kdunitkerja,2) = '00' and 
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
		}else{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	(left(kdunitkerja,1) = '1' or left(kdunitkerja,1) = '6' or left(kdunitkerja,1) = '7' or left(kdunitkerja,1) = '8' or 
	left(kdunitkerja,1) = '9' ) and right(kdunitkerja,2) = '00' and 
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
		}
			break;
		// kepala BATAN
		case '9':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	left(kdjabatan,4) = '0011' and 
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		default:
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
	} 
 	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

	// tampilkan datanya
	switch ($xlevel)
	{
		// admin
		case '1':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan LIMIT $start, $limit");
			break;
		// operator
		case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and left(kdunitkerja,4) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nip LIMIT $start, $limit");
			break;
		// kapus
		case '3':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	((left(kdunitkerja,2) = '$xkdunit' and nib_atasan = '$xusername') or (kdunitkerja='$kdunitkerja')) and
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nip LIMIT $start, $limit");
			break;
		// kabid
		case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and left(kdunitkerja,5) = '$kdbidang' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdjabatan,kdunitkerja, nip LIMIT $start, $limit");
			break;
		// kasubbid
		case '5':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and kdunitkerja = '$kdsubbidang' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdjabatan,kdunitkerja, nip LIMIT $start, $limit");
			break;
		case '6':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and nip = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nip LIMIT $start, $limit");
			break;
		// deputi
		case '8':
		if ( $kddeputi <> '1' )
		{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	left(kdunitkerja,1) = '$kddeputi' and right(kdunitkerja,2) = '00'  and 
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nib LIMIT $start, $limit");
		}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	(left(kdunitkerja,1) = '1' or left(kdunitkerja,1) = '6' or left(kdunitkerja,1) = '7' or left(kdunitkerja,1) = '8' or 
	left(kdunitkerja,1) = '9' ) and right(kdunitkerja,2) = '00' and 
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nib LIMIT $start, $limit");
		}
			break;
		// kepala BATAN
		case '9':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and 
	(left(kdjabatan,4) = '0011' or nib_atasan = '$xusername') and 
	(nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nib LIMIT $start, $limit");
			break;
		default:
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_awal = '1' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan LIMIT $start, $limit");
			break;
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
<div align="right">
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Cari NIB : <input type="text" name="cari" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Cari" />
		<a href="index.php?p=252">Reset</a>
	</form>
</div><br />
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%" rowspan="2">No.</th>
			<th width="15%" rowspan="2">Unit Kerja</th>
			<th height="50" colspan="2">Atasan</th>
			<th width="15%" rowspan="2">Nama Pegawai </th>
			<th rowspan="2">Jabatan</th>
		  <th rowspan="2" width="5%">Status</th>
		  <th colspan="2" rowspan="2">Aksi</th>
	    </tr>
		<tr>
		  <th width="15%">Jabatan</th>
		  <th width="15%">Nama</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if ( $col[3][$k] <> $col[3][$k-1] ) { ?><?php echo nm_unitkerja($col[3][$k]) ?><?php } ?></td>
					<td align="left" valign="top"><?php echo jabatan_peg($col[1][$k],$col[10][$k]) ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[10][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[10][$k]) ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[4][$k]) ?></td>
					<td width="15%" align="center" valign="top">
					<?php if( $col[8][$k] == 0 ) {?>
					<font color="#FF0000"><?php echo status_approv_pegawai($col[6][$k]).'<br>'.reformat_tgl($col[7][$k]) ?></font>
					<?php }else{?>
					<font color="#006633"><?php echo status_approv_atasan($col[8][$k]).'<br>'.reformat_tgl($col[9][$k]) ?></font>
					<?php }?>
					</td>
					<td width="10%" align="center" valign="top">
					<?php if( $col[8][$k] == 0 and $xusername <> $col[2][$k] ) {?>
					<a href="index.php?p=267&id_skp=<?php echo $col[0][$k] ?>&sw=1" title="Approved Atasan"><img src="css/images/edit_f2.png" border="0" width="16" height="16">
					<font color="#0033FF"><?php echo 'Persetujuan atasan' ?></font></a>
					<?php }elseif( $col[8][$k] == 1 and $xusername == $col[10][$k] ) {?>
					<a href="index.php?p=392&id_skp=<?php echo $col[0][$k] ?>&sw=1" title="Batal Approved Atasan"><img src="css/images/edit_f2.png" border="0" width="16" height="16">
					<font color="#FF0000"><?php echo 'Batal Persetujuan' ?></font></a>
					<?php }?>
					
					</td>
                  <td width="7%" align="center" valign="top">
			  <?php if ( $col[8][$k] == '1' or $col[6][$k] == '1' ) {?>
			  <a href="source/prestasi/buat_skp_prn.php?id_skp=<?php echo $col[0][$k] ?>" title="Cetak SKP" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">SKP</font></a>
			  <?php }?></td>
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
