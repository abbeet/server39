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
	$kdbidang = substr(kdunitkerja_peg($th,$xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($th,$xusername);
	$kdunitkerja = $xkdunit.'00' ;
	$kddeputi = substr($xkdunit,0,1) ;

switch ($xlevel)
	{
		case '1':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,4) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,4) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '3':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,4) = '$xkdunit' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '4':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,5) = '$kdbidang' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '5':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and kdunitkerja = '$kdsubbidang' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '6':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and nib = '$xusername' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '8':
		if ( $kddeputi <> '1' )
		{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,3) = '$kddeputi' and right(kdunitkerja,2) = '00' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";
		}else{
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and (left(kdunitkerja,1) = '1' or left(kdunitkerja,1) = '6' or left(kdunitkerja,1) = '7' or left(kdunitkerja,1) = '8' or left(kdunitkerja,1) = '9' ) and right(kdunitkerja,2) = '00' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";
		}
			break;
		case '9':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdjabatan,4) = '0011' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%')";
			break;
		default:
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
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
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nip LIMIT $start, $limit");
			break;
		case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nip LIMIT $start, $limit");
			break;
		case '3':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nip LIMIT $start, $limit");
			break;
		case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,3) = '$kdbidang' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nip LIMIT $start, $limit");
			break;
		case '5':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdunitkerja = '$kdsubbidang' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nip LIMIT $start, $limit");
			break;
		case '6':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and nib = '$xusername' and nib_atasan = '$xusername' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nip LIMIT $start, $limit");
			break;
		case '8':
		if ( $kddeputi <> '1' )
		{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,1) = '$kddeputi' and right(kdunitkerja,2) = '00' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja,kdjabatan, nip LIMIT $start, $limit");
		}else{
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and (left(kdunitkerja,1) = '1' or left(kdunitkerja,1) = '6' or left(kdunitkerja,1) = '7' or left(kdunitkerja,1) = '8' or left(kdunitkerja,1) = '9' ) and right(kdunitkerja,2) = '00' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nip LIMIT $start, $limit");
		}
			break;
		case '9':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdjabatan,4) = '0011' and (nip LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja, kdjabatan, nip LIMIT $start, $limit");
			break;
		default:
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY nib_atasan,kdunitkerja,kdjabatan,nib LIMIT $start, $limit");
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
		<a href="index.php?p=244">Reset</a>
	</form>
</div><br />
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="6%" rowspan="2">No.</th>
			<th width="9%" rowspan="2">Nama Pegawai </th>
			<th width="9%" rowspan="2">Jabatan</th>
			<th width="10%" rowspan="2">Unit Kerja  </th>
			
      <th colspan="2">Atasan</th>
			<th width="8%" rowspan="2">Nilai<br />
			SKP</th>
			<th width="10%" rowspan="2">Nilai Perilaku </th>
			<th width="14%" rowspan="2">Nilai Prestasi<br />60% N.SKP + 40% N.Perilaku</th>
		</tr>
		<tr>
		  <th width="11%">Nama</th>
	      <th width="23%">Jabatan</th>
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
				$nilai_skp = total_nilai_capaian_akhir($col[10][$k],$col[0][$k],$col[1][$k]) ;
				$nib = $col[2][$k] ;
				$sql = "SELECT id,n_layanan FROM mst_perilaku WHERE nib = '$nib'";
				$qu = mysql_query($sql);
				$row = mysql_fetch_array($qu);
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru(nip_peg($col[2][$k])) ?></td>
					<td align="left" valign="top"><?php if( substr($col[3][$k],1,3) == '000' and substr($col[4][$k],0,4) == '0011' ) 
						  {
					      		echo nm_jabatan_eselon1($col[3][$k]);
						  } 
						  elseif ( substr($col[3][$k],1,3) <> '000' and substr($col[4][$k],0,3) == '001' )
					      {
						        echo 'Kepala '.nm_unitkerja($col[3][$k]);
						  }else{
							    echo nm_jabatan_ij($col[4][$k]);
						  } 
						  $nilai_perilaku = perilaku_total($col[0][$k]) ;
						  ?></td>
					<td align="left" valign="top"><?php echo nm_unitkerja($col[3][$k]) ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[10][$k]) ?></td>
                    <td align="left" valign="top"><?php echo $col[11][$k] ?></td>
                    <td align="center" valign="top"><?php if ( $nilai_skp <> 0 ) { ?><?php echo number_format($nilai_skp,"2",",",".") ?><?php } ?></td>
                    <td align="center" valign="top"><?php if ( $nilai_perilaku <> 0 ) { ?><?php echo number_format($nilai_perilaku,"2",",",".") ?><?php } ?></td> 
                  <td align="center" valign="top"><?php if ( $nilai_perilaku <> 0 and $nilai_skp <> 0 ) { ?><?php echo number_format(($nilai_perilaku*0.4)+($nilai_skp*0.6),"2",",",".") ?><?php } ?>
			  </td>
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
<?php 
function total_nilai_capaian_akhir($nib_penilai,$id_skp,$tahun) {
		
		$data = mysql_query("SELECT nilai_skp FROM mst_penilai where id_skp ='$id_skp' and nib_penilai = '$nib_penilai' and tahun = '$tahun' ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nilai_skp']; 
		
		return $result;
	}
?>