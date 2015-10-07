<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "ref_aspek_perilaku";
	$field = array("id","kdaspek","kdunsur","nmunsur");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(*) as num FROM $table WHERE nmunsur LIKE '%$cari%' ";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
		
	$oList = mysql_query("SELECT * FROM $table WHERE nmunsur LIKE '%$cari%' ORDER BY kdaspek,kdunsur LIMIT $start, $limit");
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
<table width="274" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%" rowspan="2">No.</th>
			<th width="15%" rowspan="2">Aspek Yang Dinilai</th>
			<th colspan="2" rowspan="2">Uraian</th>
			<th width="35%" colspan="2">Nilai</th>
			
            <th rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="10%">Angka</th>
	      <th width="25%">Sebutan</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td height="21" colspan="7" align="center">Tidak ada data!</td>
			</tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$jml_bobot += $col[3][$k] ;
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php if ( $col[1][$k] <> $col[1][$k-1] ) { ?><?php echo nm_aspek($col[1][$k]) ?><?php } ?></td>
					<td width="5%" align="center" valign="top"><?php echo $col[2][$k] ?></td>
					<td width="60%" align="left" valign="top"><?php echo $col[3][$k] ?></td>
					<td align="center" valign="top"><?php echo nm_angka($col[2][$k]) ?></td>
				    <td align="center" valign="top"><?php echo nm_sebut($col[2][$k]) ?></td>
			      <td width="7%" align="center" valign="top">
					  <a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
						  <img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
				  <?php
			}
		} ?>
				</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php 
	function nm_angka($kode) {
		if ($kode == 1 ) $hasil = '91 - 100';
		if ($kode == 2 ) $hasil = '76 - 90';
		if ($kode == 3 ) $hasil = '61 - 75';
		if ($kode == 4 ) $hasil = '51 - 60';
		if ($kode == 5 ) $hasil = '50 kebawah';
		return $hasil;
	}

	function nm_sebut($kode) {
		if ($kode == 1 ) $hasil = 'Sangat baik';
		if ($kode == 2 ) $hasil = 'Baik';
		if ($kode == 3 ) $hasil = 'Cukup';
		if ($kode == 4 ) $hasil = 'Kurang';
		if ($kode == 5 ) $hasil = 'Buruk';
		return $hasil;
	}
	
	function nm_aspek($kode) {
		if ($kode == 1 ) $hasil = 'Orientasi Pelayanan';
		if ($kode == 2 ) $hasil = 'Integritas';
		if ($kode == 3 ) $hasil = 'Komitmen';
		if ($kode == 4 ) $hasil = 'Disiplin';
		if ($kode == 5 ) $hasil = 'Kerjasama';
		if ($kode == 6 ) $hasil = 'Kepemimpinan';
		return $hasil;
	}
?>