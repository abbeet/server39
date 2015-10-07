<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_skp";
	$field = array("id","tahun","nib","kdunitkerja","kdjabatan","kdgol","is_approved_awal","tgl_approved_awal", "is_approved_akhir", "tgl_approved_akhir","nib_atasan", "jabatan_atasan", "kdgol_atasan","grade","tanggal_mulai","tanggal_selesai"); 
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
		case '10':
		$xkdunit = $_REQUEST['xkdunit'];
		$cari = $_REQUEST['nib'] ;
		if ( $xkdunit == '' and $cari <> '')
		{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";			
		}elseif( $xkdunit <> '' and $cari <> '') 
		{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";			
		}else{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";		
		}		
		break;
	default:
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
	} 
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari&xkdunit=$xkdunit"; 	#nama file  (nama file ini)
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
		case '10':
		$xkdunit = $_REQUEST['xkdunit'];
		$cari = $_REQUEST['nib'] ;
		if ( $xkdunit == '' and $cari <> '')
		{
		$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
		}elseif ( $xkdunit <> '' and $cari <> '' )
		{
		$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
		}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nib LIMIT $start, $limit");
		}	
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
<?php if ( $xlevel == 1 or $xlevel == 10 ) {?>
<div align="left">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Unit Kerja : 
		<select name="xkdunit">
                      <option value="<?php echo @$xkdunit ?>"><?php echo  skt_unitkerja($xkdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select left(kdunit,2) as kode_unit ,sktunit from kd_unitkerja where (right(kdunit,3) <> '000' or kdunit = '0000' or 
										kdunit = '1000' or kdunit = '2000' or kdunit = '3000' or kdunit = '4000' or kdunit = '5000') group by left(kdunit,2) order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo @$row['kode_unit'] ?>"><?php echo  $row['sktunit']; ?></option>
                    <?php
					} ?>	
	  </select>
	  	NIB <input type="text" name="nib" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Tampilkan" name="cari"/>
		<a href="index.php?p=428">Reset</a>
	</form>
</div>
<?php }?><br />
<table width="62%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%" rowspan="2">No.</th>
			<th width="14%" rowspan="2">Nama Pegawai </th>
			<th colspan="4">SKP Terakhir/Baru </th>
	      <th colspan="4">SKP Sebelumnya </th>
			<th rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="10%">Jabatan</th>
		  <th width="8%">Grade</th>
		  <th width="8%">TMT</th>
		  <th width="8%"><font color="#3333FF">Edit</font></th>
		  <th width="11%">Jabatan</th>
	      <th width="13%">Grade</th>
          <th width="13%">TMT</th>
	      <th width="13%"><font color="#3333FF">Edit</font></th>
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
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br />
				  <?php echo 'NIP. '.reformat_nipbaru(nip_peg($col[2][$k])) ?></td>
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
					<td align="center" valign="top"><?php echo reformat_tgl($col[14][$k]) ?></td>
					<td align="center" valign="top">
					<a href="index.php?p=444&q=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit Penutupan SKP">
			       <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Jabatan baru</font></a>					</td>
		          <?php  //------         SKP Sebelumnya 
			  		$nib = $col[2][$k] ;
					$oSKP_Lalu = mysql_query("SELECT * FROM mst_skp_mutasi WHERE tahun = '$th' AND nib = '$nib' ");
			  		$SKP_Lalu  = mysql_fetch_array($oSKP_Lalu);
			  ?>
			  
					<td align="left" valign="top"><?php if( substr($SKP_Lalu['kdunitkerja'],1,3) == '000' and substr($SKP_Lalu['kdjabatan'],0,4) == '0011' ) 
						  {
					      		echo nm_jabatan_eselon1($SKP_Lalu['kdunitkerja']);
						  } 
						  elseif ( substr($SKP_Lalu['kdjabatan'],1,3) <> '000' and substr($SKP_Lalu['kdjabatan'],0,3) == '001' )
					      {
						        echo 'Kepala '.nm_unitkerja($SKP_Lalu['kdunitkerja']);
						  }else{
							    echo nm_jabatan_ij($SKP_Lalu['kdjabatan']);
						  } ?></td>
                    <td align="center" valign="top"><?php echo nil_grade($SKP_Lalu['kdjabatan']) ?></td>
                    <td align="center" valign="top"><?php echo reformat_tgl($SKP_Lalu['tanggal_mulai']) ?><br />s/d<br /><?php echo reformat_tgl($SKP_Lalu['tanggal_selesai']) ?></td>
                    <td align="center" valign="top">
					<a href="index.php?p=445&q=<?php echo $SKP_Lalu['id'] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit Penutupan SKP">
			       <img src="css/images/edit_f2.png" border="0" width="24" height="15"><font size="1">Data Sebelumnya</font></a>					</td>
                  <td width="5%" align="center" valign="top"><?php if ( empty( $SKP_Lalu) )
				  { ?>
                    <a href="index.php?p=429&id_skp=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit Penutupan SKP">
			      <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Penutupan SKP</font></a>
				  <?php } ?>				  </td>
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
<?php 
	function xx($nib) {
		$data = mysql_query("select nip from mst_tk where nib = '$nib'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nip'];
		return $result;
	}
?>