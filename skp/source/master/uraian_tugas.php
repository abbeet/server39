<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_info_jabatan";
	$field = get_field($table);
	$ed_link = "index.php?p=249";
	$del_link = "index.php?p=235";
	$kdunit = $_SESSION['xkdunit'];
	$kdunitkerja = $_SESSION['xkdunit'].'00' ;
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;

 switch ( $xlevel )
 {
    case '2':
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$kdunit' and (nama_jabatan LIKE '%$cari%' OR kode_jabatan LIKE '%$cari%' OR ihtisar_jabatan LIKE '%$cari%') ";
	break;
    case '3':
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$kdunit' and (nama_jabatan LIKE '%$cari%' OR kode_jabatan LIKE '%$cari%' OR ihtisar_jabatan LIKE '%$cari%') ";
	break;
	default:
	$kdunit = $_REQUEST['kdunit'];
	$query = "SELECT COUNT(*) as num FROM $table WHERE left(kdunitkerja,2) = '$kdunit' and (nama_jabatan LIKE '%$cari%' OR kode_jabatan LIKE '%$cari%' OR ihtisar_jabatan LIKE '%$cari%') ";
	break;
}	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari&kdunit=$kdunit"; 	#nama file  (nama file ini)
	$limit = 3; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

 switch ( $xlevel )
 {
    case '2':
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$kdunit' and (nama_jabatan LIKE '%$cari%' OR kode_jabatan LIKE '%$cari%' OR ihtisar_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
	break;
    case '3':
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$kdunit' and (nama_jabatan LIKE '%$cari%' OR kode_jabatan LIKE '%$cari%' OR ihtisar_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
	break;
	default:
	$kdunit = $_REQUEST['kdunit'];
	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,2) = '$kdunit' and (nama_jabatan LIKE '%$cari%' OR kode_jabatan LIKE '%$cari%' OR ihtisar_jabatan LIKE '%$cari%') ORDER BY kdunitkerja,kode_jabatan LIMIT $start, $limit");
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
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  skt_unitkerja($kdunit) ?></option>
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
<?php }?><br />
<table cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%">No.</th>
			<th colspan="2">Nama Tugas </th>
			<th width="10%">Bahan Kerja  </th>
			
      <th width="16%">Perangkat Kerja </th>
			<th width="17%">Hasil Kerja </th>
			<th width="13%">Effort</th>
			<th width="10%">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="8">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><strong><?php echo $limit*($pagess-1)+($k+1);?></strong></td>
				  <td colspan="6" align="left" valign="top"><strong><?php echo $col[3][$k] ?></strong></td>
				  <td align="center" valign="top"><a href="<?php echo $ed_link ?>&id_if=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
			  <img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16">						</a></td>
	  </tr>
	  <?php 
	  		$id_if = $col[0][$k];
			$sql = "SELECT * FROM dtl_ij_tugas WHERE id_if = '$id_if' order by no_urut";
			$qu = mysql_query($sql);
			while($row = mysql_fetch_array($qu))
			{
	  ?>
				<tr class="<?php echo $class ?>">
					<td align="left" valign="top">&nbsp;</td>
					<td width="4%" align="center" valign="top"><?php echo $row[2] ?></td>
					<td width="23%" align="left" valign="top"><?php echo $row[3] ?></td>
					<td align="left" valign="top"><?php echo $row[4] ?></td>
					<td align="left" valign="top"><?php echo $row[5] ?></td>
                    <td align="left" valign="top"><?php echo $row[6] ?></td>
                    <td align="left" valign="top"><?php echo $row[7] ?></td>
                  <td align="center" valign="top">
		  <a href="<?php echo $ed_link ?>&q=<?php echo $row[0] ?>&id_if=<?php echo $col[0][$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr>
				
				<?php
			}
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</tfoot>
</table>
