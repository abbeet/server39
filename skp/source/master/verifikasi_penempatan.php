<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_skp";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=299";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	
	
switch ($xlevel)
	{
		case '1':
	$xkdunit = $_REQUEST['xkdunit'];
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ";
			break;
		case '7':
	if ( $xusername == '017279' )   $xkdunit = $_REQUEST['xkdunit'];
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
	$xkdunit = $_REQUEST['xkdunit'];
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja,kdjabatan  LIMIT $start, $limit");
			break;
		case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja , kdjabatan,kdgol LIMIT $start, $limit");
			break;
		case '7':
	if ( $xusername == '017279' )   $xkdunit = $_REQUEST['xkdunit'];
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY grade desc,kdunitkerja,kdjabatan LIMIT $start, $limit");
			break;
		case '3':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY grade desc ,kdunitkerja,kdjabatan LIMIT $start, $limit");
			break;
		case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,3) = '$kdbidang' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY grade desc ,kdunitkerja,kdjabatan LIMIT $start, $limit");
			break;
		case '5':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdunitkerja = '$kdsubbidang' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY grade desc ,kdunitkerja,kdjabatan LIMIT $start, $limit");
			break;
		case '6':
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and nib = '$xusername' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY grade desc ,kdunitkerja,kdjabatan LIMIT $start, $limit");
			break;
		default:
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and (nib LIKE '%$cari%' OR kdunitkerja LIKE '%$cari%' OR kdjabatan LIKE '%$cari%') ORDER BY kdunitkerja,kdjabatan LIMIT $start, $limit");
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
		<a href="index.php?p=296">Reset</a>
	</form>
</div><br />
<?php if ( $xlevel == 1 ) {?>
<div align="left">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Unit Kerja : 
		<select name="xkdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  skt_unitkerja($xkdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select left(kdunit,2) as kode_unit ,sktunit from kd_unitkerja group by left(kdunit,2) order by sktunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kode_unit'] ?>"><?php echo  $row['sktunit']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<?php }?>
<?php if ( $xusername == '017279' and $xlevel == '7' ) {?>
<div align="left">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Unit Kerja : 
		<select name="xkdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  skt_unitkerja($xkdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select left(kdunit,2) as kode_unit ,sktunit from kd_unitkerja where ( left(kdunit,2) = '11' or left(kdunit,2) = '12' or left(kdunit,2) = '13' or left(kdunit,2) = '14' or kdunit = '0000' or kdunit = '1000' or kdunit = '2000' or kdunit = '3000' or kdunit = '4000' or kdunit = '5000' ) group by left(kdunit,2) order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kode_unit'] ?>"><?php echo  $row['sktunit']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<?php }?>
<?php if ( $xlevel == '1' or $xlevel == '2' or $xlevel == '3' ) {?>
<a href="source/master/verifikasi_penempatan_xls.php?kdunit=<?php echo $xkdunit ?>&th=<?php echo $th ?>" title="Cetak Pemegang Jabatan" target="_blank"><img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Excel</font></a>			  
			  
<?php } ?>
<table width="58%" cellpadding="1" class="adminlist">
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
