<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_skp";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=263";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	$kdunitkerja = $xkdunit.'00' ;
	$kddeputi = substr($xkdunit,0,1) ;
	
switch ($xlevel)
	{
		case '1':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '3':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '4':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,3) = '$kdbidang' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '5':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and kdunitkerja = '$kdsubbidang' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '6':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and nib = '$xusername' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '8':
		if ( $kddeputi <> '1' )
		{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,1) = '$kddeputi' and right(kdunitkerja,2) = '00' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";
		}else{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and (left(kdunitkerja,1) = '1' or left(kdunitkerja,1) = '6' or left(kdunitkerja,1) = '7' or left(kdunitkerja,1) = '8' or left(kdunitkerja,1) = '9' ) and right(kdunitkerja,2) = '00' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";
		}
			break;
		case '9':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdjabatan,4) = '0011' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";
			break;
		default:
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
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

switch ($xlevel)
	{
		case '1':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan,nib  LIMIT $start, $limit");
			break;
		case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja,kdjabatan, nib LIMIT $start, $limit");
			break;
		case '3':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
			break;
		case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,3) = '$kdbidang' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan,nib LIMIT $start, $limit");
			break;
		case '5':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdunitkerja = '$kdsubbidang' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan,nib LIMIT $start, $limit");
			break;
		case '6':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and nib = '$xusername' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan,nib LIMIT $start, $limit");
			break;
		case '8':
		if ( $kddeputi <> '1' )
		{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,1) = '$kddeputi' and right(kdunitkerja,2) = '00' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja,kdjabatan, nib LIMIT $start, $limit");
		}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and (left(kdunitkerja,1) = '1' or left(kdunitkerja,1) = '6' or left(kdunitkerja,1) = '7' or left(kdunitkerja,1) = '8' or left(kdunitkerja,1) = '9' ) and right(kdunitkerja,2) = '00' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
		}
			break;
		case '9':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdjabatan,4) = '0011' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
			break;
		default:
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
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
		Cari NIB: 
		<input type="text" name="cari" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Cari" />
		<a href="index.php?p=251">Reset</a>
	</form>
</div><br />
<table width="62%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%" rowspan="2">No.</th>
			<th width="14%" rowspan="2">Unit Kerja </th>
			<th width="14%" rowspan="2">Nama Pegawai </th>
			<th width="10%" rowspan="2">Jabatan</th>
		    <th width="8%" rowspan="2">Grade</th>
	      <th colspan="2">Atasan</th>
			<th width="9%" rowspan="2">Status</th>
			<th colspan="3" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="11%">Nama</th>
	      <th width="13%">Jabatan</th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="11">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){?><?php echo nm_unitkerja($col[3][$k]) ?><?php }?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru(nip_peg($col[2][$k])) ?></td>
					<td align="left" valign="top">
					<?php if( substr($col[3][$k],1,3) == '000' and substr($col[4][$k],0,4) == '0011' ) 
						  {
					      		echo nm_jabatan_eselon1($col[3][$k]);
						  } 
						  elseif ( substr($col[3][$k],1,3) <> '000' and substr($col[4][$k],0,3) == '001' )
					      {
						        echo 'Kepala '.nm_unitkerja($col[3][$k]);
						  }else{
							    echo nm_jabatan_ij($col[4][$k]);
						  } ?></td>
					<td align="center" valign="top"><?php echo nil_grade($col[4][$k]) ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[10][$k]) ?></td>
                    <td align="left" valign="top"><?php echo $col[11][$k] ?></td>
                    <td align="center" valign="top">
					<?php if ( $col[2][$k] == $xusername ) 
					{
					?>
					<?php // ------- Datanya sendiri --------?>
					<?php if( $col[6][$k] == '0' ) {?>
					<font color="#FF0000"><?php echo 'Draf' ?></font>
					<?php }else{?>
					<font color="#006633"><?php echo status_approv_pegawai($col[6][$k]).'<br>'.reformat_tgl($col[7][$k]) ?></font>
					<?php }?>
					
					<?php }else{ #---   data pegawai dibawahnya -----?>
					
					<?php if( $col[6][$k] == '0' ) {?>
					<font color="#FF0000"><?php echo 'Draf' ?></font>
					<?php }else{?>
					<font color="#006633"><?php echo status_approv_pegawai($col[6][$k]).'<br>'.reformat_tgl($col[7][$k]) ?></font>
					<?php }?>
					
					<?php } # ------ akhir status data yang tampil ?>					</td>
                  <td width="5%" align="center" valign="top">
				  <?php if ( $xlevel == 0 or $xlevel == 1 or  $xlevel == 2 ) {?>
		  <a href="index.php?p=263&q=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit Atasan SKP">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Atasan</font></a><br />
			  <?php } ?>
			  <?php if ( $col[6][$k] == '1' and $col[2][$k] == $xusername ) 
			  { 
			  }else{?>
			  <a href="index.php?p=264&id_skp=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit SKP">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">SKP</font></a><br />
			  <?php } ?>
			  	  </td>
				  <td width="5%" align="center" valign="top"><a href="source/prestasi/buat_skp_prn.php?id_skp=<?php echo $col[0][$k] ?>" title="Cetak SKP" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">SKP</font></a></td>
				  <td width="6%" align="center" valign="top">
				  <?php // ------- Datanya sendiri --------?>
					<?php if( $col[6][$k] == '0' and $col[2][$k] == $xusername ) {?>
					<a href="index.php?p=266&id_skp=<?php echo $col[0][$k] ?>&sw=0" title="Approved Pegawai"><img src="css/images/edit_f2.png" border="0" width="16" height="16">
					<font color="#0033FF"><?php echo status_approv_pegawai($col[6][$k]) ?></font></a>
				  <?php } ?>
			  	  <?php if ( $col[6][$k] == '1' and  $col[8][$k] == '0' and $col[2][$k] <> $xusername ) { ?>
				  <a href="index.php?p=266&id_skp=<?php echo $col[0][$k] ?>&sw=0" title="Dikembalikan ke Pegawai">
					<img src="css/images/edit_f2.png" border="0" width="16" height="16"><font color="#FF0000">Kembali ke pegawai</font></a>	
					<?php } ?></td>
				</tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="11">&nbsp;</td>
		</tr>
	</tfoot>
</table>
