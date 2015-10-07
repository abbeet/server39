<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "kd_jabatan";
	$field = array("id","kode","kdkel","kdjab","nmjabatan","klsjabatan","kdunitkerja","tahun");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];

 	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
 
	if ( $_REQUEST['xcari'] )
	{
		$kdunit = $_REQUEST['kdunit'];
		$cari = $_REQUEST['cari'];
	}
	$kdunitkerja = substr($kdunit,0,5) ;

	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' AND left(nmjabatan,12) <> 'Kepala DINAS' AND ( KdKel LIKE '%$cari%' OR KdJab LIKE '%$cari%' OR NmJabatan LIKE '%$cari%' ) order by kode";
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
		
	$oList = mysql_query("SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' AND left(nmjabatan,12) <> 'Kepala DINAS' AND ( KdKel LIKE '%$cari%' OR KdJab LIKE '%$cari%' OR NmJabatan LIKE '%$cari%') ORDER BY kdunitkerja,klsjabatan desc,kdkel,kdjab,nmjabatan LIMIT $start, $limit");
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
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Unit Kerja : 
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  nm_unitkerja($kdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select * from kd_unitkerja WHERE kdsatker <> '' and left(nmunit,5) <> 'DINAS' order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
					} ?>	
	  </select>
		Cari Jabatan : <input type="text" name="cari" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Tampilkan" name="xcari"/>
	</form>
</div>
<a href="source/ref/nama_jabatan_prn.php?kdunit=<?php echo $kdunit ?>" title="Cetak Nama Jabatan" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak PDF</font></a>&nbsp;|&nbsp;
<a href="source/ref/nama_jabatan_xls.php?kdunit=<?php echo $kdunit ?>" title="Cetak Nama Jabatan" target="_blank">
			  <font size="1">Excel</font></a>
<table width="69%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th width="10%">Kode</th>
			<th>Nama Jabatan </th>
			
            <th width="30%">Satker</th>
            <th width="5%">Grade</th>
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
					<td align="center" valign="top"><?php echo $col[2][$k].'.'.$col[3][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
				    <td align="left" valign="top"><?php echo nm_unitkerja($col[6][$k]) ?></td>
				    <td align="center" valign="top"><?php echo $col[5][$k] ?></td>
		          <td width="5%" align="center" valign="top">
				      <?php if ( $xlevel == '1' ) {?>
					  <a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
						  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>  
					  <?php }?>									</td>
					<td width="5%" align="center" valign="top">
				      <?php if ( $xlevel == '1' ) {?>
						<a href="<?php echo $del[$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>
					  <?php }?>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
	</tfoot>
</table>
