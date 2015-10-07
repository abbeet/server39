<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_skp";
	$field = array("id","tahun","nip","kdunitkerja","kdjabatan","kdgol","is_approved_awal","tgl_approved_awal", "is_approved_akhir", "tgl_approved_akhir","nib_atasan", "jabatan_atasan", "kdgol_atasan","grade","status_real_akhir","tgl_real_akhir");
	//$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=263";
//	$kdunitkerja = '3400' ;
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($th,$xusername),0,5);
	$kdsubbidang = kdunitkerja_peg($th,$xusername);
	$kdunitkerja = $xkdunit.'00' ;
	$kddeputi = substr($xkdunit,0,1) ;

switch ($xlevel)
	{
		case '1':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_akhir = '1' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_akhir = '1' and left(kdunitkerja,4) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		default:
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and is_approved_akhir = '1' and nip = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
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
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_akhir = '1' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan LIMIT $start, $limit");
			break;
		case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_akhir = '1' and left(kdunitkerja,4) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nip LIMIT $start, $limit");
		default:
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and is_approved_akhir = '1' and nip = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, nip LIMIT $start, $limit");
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
		Cari : <input type="text" name="cari" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Cari" />
		<a href="index.php?p=244">Reset</a>
	</form>
</div><br />
<table width="70%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%" rowspan="2">No.</th>
			<th width="12%" rowspan="2">Nama Pegawai </th>
			<th width="12%" rowspan="2">Jabatan</th>
			<th width="14%" rowspan="2">Unit Kerja  </th>
			
      <th colspan="3">Atasan</th>
			<th width="13%" colspan="4" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="13%">Nama</th>
	      <th width="11%">Jabatan</th>
          <th width="12%">Tgl.<br />Persetujuan</th>
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
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[4][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_unitkerja($col[3][$k]) ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[10][$k]) ?></td>
                    <td align="left" valign="top"><?php echo jabatan_peg($col[1][$k],$col[10][$k]) ?></td>
                    <td align="center" valign="top"><?php echo reformat_tgl($col[9][$k]) ?>
                  <td align="center" valign="top">
				  
				  <?php switch ( $col[14][$k] )
				  		 { 
						      case '0' :?>
			  <a href="index.php?p=269&id_skp=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit Realisasi SKP">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Realisasi SKP</font></a>
			  <?php     break;
					
							  case '1' : 
							  echo "<font color='#009933'>Dikirim <br>".reformat_tgl($col[15][$k])."</font>";
							  break;
							  
							  case '2' : 
							  echo "<font color='#0000FF'>Dinilai <br>".reformat_tgl($col[15][$k])."<br>(".number_format(total_nilai_capaian($col[10][$k],$col[0][$k],$col[1][$k]),"2",",",".").")</font>";
							  break;
							  
					    } ?>
			  			  </td>
				  <td align="center" valign="top">
				  <?php if ( $col[14][$k] == '0' ) { ?>
				  <a href="index.php?p=439&id_skp=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Input Tugas Tambahan">
			  	  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Tugas Tambahan</font></a>
			  	  <?php } ?>
				  </td>
				  <td align="center" valign="top">
				  <?php if ( $col[14][$k] == '0' ) { ?>
				  <a href="index.php?p=441&id_skp=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Input Kegiatan Kreativitas">
			     <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kreatifitas</font></a>
			  	  <?php } ?>
				  </td>
				  <td align="center" valign="top">
			  <a href="source/prestasi/realisasi_skp_prn.php?id_skp=<?php echo $col[0][$k] ?>" title="Cetak Realisasi SKP" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak</font></a></td>
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
	function total_nilai_capaian($nib_penilai,$id_skp,$tahun) {
		
		$data = mysql_query("SELECT nilai_skp_akhir FROM mst_penilai where id_skp ='$id_skp' and nib_penilai = '$nib_penilai' and tahun = '$tahun' ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nilai_skp_akhir']; 
		
		return $result;
	}


?>