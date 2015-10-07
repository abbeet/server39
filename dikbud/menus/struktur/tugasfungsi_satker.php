<?php
	checkauthentication();
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "tb_unitkerja";
	$field =  array("id","kdunit","nmunit","tugas");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);

	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
switch ( $xlevel )
{
	case 3 :
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunit = '$xkdunit' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ";
	break ;
	
	case 4 :
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunit = '$xkdunit' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ";
	break ;

	case 5 :
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunit = '$xkdunit' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ";
	break ;

	default :
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunit > '2320600' and kdsatker <> '' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ";
	break ;
}	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari"; 	#nama file  (nama file ini)
	$limit = 10; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
	
switch ( $xlevel )
{
	case 3 :
	$oList = mysql_query("SELECT * FROM $table WHERE kdunit = '$xkdunit' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ORDER BY kdunit LIMIT $start, $limit");
	break ;
	
	case 4 :
	$oList = mysql_query("SELECT * FROM $table WHERE kdunit = '$xkdunit' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ORDER BY kdunit LIMIT $start, $limit");
	break ;

	case 5 :
	$oList = mysql_query("SELECT * FROM $table WHERE kdunit = '$xkdunit' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ORDER BY kdunit LIMIT $start, $limit");
	break ;

	default :
	$oList = mysql_query("SELECT * FROM $table WHERE kdunit > '2320600' and kdsatker <> '' and (nmunit LIKE '%$cari%' OR kdunit LIKE '%$cari%' OR tugas LIKE '%$cari%') ORDER BY kdunit LIMIT $start, $limit");
	break ;
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

<table width="443" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="18%">Satker Mandiri</th>
			
      <th colspan="2">Tugas Pokok</th>
			<th width="8%" colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="row1">
					<td align="left" valign="top"><?php echo $col[2][$k] ?></td>
				  <td colspan="2" align="left" valign="top"><?php echo $col[3][$k] ?></td>
					<td colspan="2" align="center" valign="top"><a href="index.php?p=580&q=<?php echo $col[0][$k] ?>" title="Edit Tugas Pokok">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				</tr>
				<tr class="row1">
				  <td align="center" valign="top">&nbsp;</td>
				  <td colspan="2" align="center" valign="top"><strong>Fungsi</strong></td>
				  <td colspan="2" align="center" valign="top"><a href="index.php?p=581&kdunit=<?php echo $col[1][$k] ?>" title="Tambah Fungsi">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Fungsi</a></td>
	  </tr>
<?php 
				$sql = "SELECT * FROM tb_unitkerja_fungsi WHERE kdunit = '".$col[1][$k]."'"." order by kdfungsi";
				$oFungsi = mysql_query($sql);
				while ($Fungsi = mysql_fetch_array($oFungsi))
				{
?>				
				<tr class="row0">
				  <td align="center" valign="top">&nbsp;</td>
				  <td width="5%" align="center" valign="top"><?php echo $Fungsi['kdfungsi'] ?></td>
				  <td width="42%" align="left" valign="top"><?php echo $Fungsi['nmfungsi'] ?></td>
				  <td align="center" valign="top"><a href="index.php?p=581&q=<?php echo $Fungsi['id'] ?>" title="Edit Fungsi">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
	              <td align="center" valign="top"><a href="index.php?p=582&q=<?php echo $Fungsi['id'] ?>" title="Delete Fungsi">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
				<?php
			} # akhir misi
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>
