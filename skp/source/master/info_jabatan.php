<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_info_jabatan";
	$field = array("id","kdunitkerja","kdjabatan","jumlah","grade");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=298";
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	//$kdunit = $_SESSION['xkdunit'] ;
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
	
	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
 
	if ( $_REQUEST['cari'] )
	{
		$kdunit = $_REQUEST['kdunit'];
	}
	$kdunitkerja = substr($kdunit,0,5) ;
		
if ( $xlevel == 1 ) {?>
<div align="left">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Unit Kerja : 
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  nm_unitkerja($kdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select * from kd_unitkerja WHERE left(nmunit,5) <> 'DINAS' AND kdsatker <> '' group by left(kdunit,5) order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div>
<?php }

 switch ( $xlevel )
 {
	case '4':
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ";
	break;
	
    default:
	if ( $kdunit == '2320100' )
	{
  	  $query = "SELECT COUNT(*) as num FROM $table WHERE ( kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000' )";
	}else{
  	  $query = "SELECT COUNT(*) as num FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ";
	} 
	break;
}	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari&kdunit=$kdunit"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
	
 switch ( $xlevel )
 {
	case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ORDER BY kdunitkerja,grade desc 
			LIMIT $start, $limit");
	break;

    default:
	if ( $kdunit == '2320100' )
	 {
	 $sql = "SELECT * FROM $table WHERE ( kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000' ) 
			ORDER BY kdunitkerja,grade desc LIMIT $start, $limit"; #echo $sql."<BR>";
	$oList = mysql_query($sql);
     }else{
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ORDER BY kdunitkerja,grade desc 
			LIMIT $start, $limit");
	 } 
	break;
}	

	#$oList = mysql_query($query) ;
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

<a href="source/master/info_jabatan_prn.php?kdunit=<?php echo $kdunit ?>" title="Cetak Informasi Jabatan" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak PDF</font></a>&nbsp;|&nbsp;
<a href="source/master/info_jabatan_xls.php?kdunit=<?php echo $kdunit ?>" title="Cetak Informasi Jabatan" target="_blank">
			  <font size="1">Excel</font></a>
<table cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="6%">No.</th>
			<th width="12%">Unit Kerja</th>
			<th width="13%">Nama Jabatan </th>
			
            <th width="7%">Jml.</th>
            <th width="7%">Grade</th>
          <th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if( $col[1][$k] <> $col[1][$k-1] ){?><?php echo nm_unitkerja($col[1][$k]) ?><?php }?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[2][$k],$col[1][$k]) ?></td>
					<td align="center" valign="top"><?php echo $col[3][$k] ?></td>
				    <td align="center" valign="top"><?php echo $col[4][$k] ?></td>
			      <td width="4%" align="center" valign="top">
		  <a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $kdunit ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
				<td width="4%" align="center" valign="top"><a href="<?php echo $del[$k] ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $kdunit ?>" title="Delete">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a></td>
				</tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php 
#variabel query
	$targetpage = "index.php?p=$p&cari=$cari&kdunit=$kdunit"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
	
 switch ( $xlevel )
 {
	case '4':
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ORDER BY kdunitkerja,grade desc 
			LIMIT $start, $limit");
	break;

    default:
	if ( $kdunit == '2320100' )
	 {
	$oList = mysql_query("SELECT * FROM $table WHERE ( kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000' ) 
			ORDER BY kdunitkerja,grade desc 
			LIMIT $start, $limit");
     }else{
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ORDER BY kdunitkerja,grade desc 
			LIMIT $start, $limit");
	 } 
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