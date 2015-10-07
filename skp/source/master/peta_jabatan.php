<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_info_jabatan";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=298";
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$th = $_SESSION['xth'];
	$kdunitkerja = $_SESSION['xkdunit'].'00' ;
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
switch ($xlevel)
	{
	case '1':
	$xkdunit = $_REQUEST['xkdunit'];
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' ";
	break;
		case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ";
			break;
		case '7':
	if ( $xusername == '017279' )   $xkdunit = $_REQUEST['xkdunit'];
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ";
			break;
		case '3':
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ";
			break;
		case '4':
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,3) = '$kdbidang' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ";
			break;
		case '5':
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunitkerja = '$kdsubbidang' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ";
			break;
		case '6':
	$query = "SELECT COUNT(*) as num FROM $table WHERE nib = '$xusername' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ";
			break;
	default:
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' ";
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
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
	break;
		case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
			break;
		case '7':
	if ( $xusername == '017279' )   $xkdunit = $_REQUEST['xkdunit'];
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
			break;
		case '3':
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
			break;
		case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,3) = '$kdbidang' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
			break;
		case '5':
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja = '$kdsubbidang' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
			break;
		case '6':
	$oList = mysql_query("SELECT * FROM $table WHERE nib = '$xusername' and (kdunitkerja LIKE '%$cari%' OR nama_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
			break;
	case '7':
	default:
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$xkdunit' ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
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
<?php if ( $xusername == '017279' and $xlevel = 7 ) {?>
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
<a href="source/master/peta_jabatan_prn.php?kdunit=<?php echo $xkdunit ?>&th=<?php echo $th ?>" title="Cetak Pemegang Jabatan" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak PDF</font></a>&nbsp;|&nbsp;<a href="source/master/peta_jabatan_xls.php?kdunit=<?php echo $xkdunit ?>&th=<?php echo $th ?>" title="Cetak Pemegang Jabatan" target="_blank">Excel</font></a>
<?php } ?>
<table width="667" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%" rowspan="2">No.</th>
			<th width="8%" rowspan="2">Unit Kerja</th>
			<th width="9%" rowspan="2">Nama Jabatan </th>
			
            <th width="9%" rowspan="2">Grade</th>
            <th colspan="2">Jumlah</th>
            <th width="5%" rowspan="2">Seli<br />sih</th>
          <th width="20%" rowspan="2">Nama Pegawai </th>
			<th width="5%" rowspan="2">Gol.</th>
			<th colspan="3">Jabatan Pegawai</th>
        </tr>
		<tr>
		  <th width="5%">J1</th>
	      <th width="5%">J2</th>
          <th width="8%">Struktural</th>
          <th width="9%">Fungsional</th>
	      <th width="21%">Umum</th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="12">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				<?php 
				$plus = '' ;
				$selisih = jml_j2($th,$col[1][$k],$col[2][$k]) - jml_info_jabatan($col[1][$k],$col[2][$k]) ;
				$nib = nip_peg_j2($th,$col[1][$k],$col[2][$k]) ;
				if ( $selisih >= 1 )     $plus = '+' ;
				?>
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if( $col[1][$k] <> $col[1][$k-1] ){?><?php echo nm_unitkerja($col[1][$k]) ?><?php }?></td>
					<td align="left" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){?><?php echo nm_info_jabatan($col[1][$k],$col[2][$k]) ?><?php }?></td>
					<td align="center" valign="top"><?php echo nil_grade($col[2][$k]) ?></td>
					<td align="center" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){?><?php echo jml_info_jabatan($col[1][$k],$col[2][$k]) ?><?php }?></td>
					<td align="center" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){?><?php echo jml_j2($th,$col[1][$k],$col[2][$k]) ?><?php }?></td>
					<td align="center" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){?><?php echo $plus.$selisih ?><?php }?></td>
					<td align="left" valign="top"><?php if ( $nib <> '' ) { ?><?php echo nama_peg($nib) ?><br /><?php echo 'Nip.'.reformat_nipbaru(nip_peg($nib)) ?><?php } ?></td>
                    <td align="center" valign="top"><?php echo nm_gol(kdgol_peg($nib)) ?></td>
                    <td align="left" valign="top"><?php if ( $nib <> '' ) { ?><?php if( substr(jabatan_peg($nib),0,6) == 'Kepala' or substr(jabatan_peg($nib),0,5) == 'Ketua' ){?><?php echo jabatan_peg($nib) ?><?php }?><?php } ?></td>
                    <td align="left" valign="top"><?php if ( $nib <> '' ) { ?><?php if( substr(jabatan_peg($nib),0,6) <> 'Kepala' ){?><?php echo jabatan_peg($nib) ?><?php }?><?php } ?></td>
                    <td align="left" valign="top"><?php if ( $nib <> '' ) { ?><?php if( jabatan_peg($nib) == '' ){?><?php echo nm_info_jabatan($col[1][$k],$col[2][$k]) ?><?php }?><?php } ?></td>
			    </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="12">&nbsp;</td>
		</tr>
	</tfoot>
</table>
