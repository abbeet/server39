<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "m_idpegawai";
	$field = array("id","nip","nama","kdunitkerja","kdgol","kdeselon","kdjabatan","kdstatuspeg","tmtjabatan");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=460";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$kdunit = $_SESSION['xkdunit'] ;
 	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
 
	if ( $_REQUEST['xcari'] )
	{
		if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 		else   $kdunit = $_SESSION['xkdunit'];
		//$kdunit = $_REQUEST['kdunit'];
		$cari = $_REQUEST['cari'];
	}
	$kdunitkerja = substr($kdunit,0,5) ;
	
	if ( $kdunit == '2320100' )
	{
			$sql  = mysql_query("SELECT nip FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000' ");
	}else{
			$sql  = mysql_query("SELECT nip FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' ");
	}
	
	$jml_pegawai = mysql_num_rows($sql) ;
	
?>
<div align="right">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
<?php if ( $xlevel == 1 ) { ?>		
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
<?php } ?>	  
		Cari Nama : <input type="text" name="cari" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Tampilkan" name="xcari"/>
	</form>
</div>
<?php

	if ( $kdunit == '2320100' )
	{
		$query  = "SELECT COUNT(*) as num FROM $table WHERE (kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000' ) AND nama LIKE '%$cari%' ";
	}else{
		$query  = "SELECT COUNT(*) as num FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' AND nama LIKE '%$cari%'";
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
		$start = 0;	
	#halaman awal
	if ( $kdunit == '2320100' )
	{
	$query  = "SELECT * FROM $table WHERE (kdunitkerja LIKE '$kdunitkerja%' OR kdunitkerja = '2320000' ) AND nama LIKE '%$cari%' 
			   ORDER BY kdunitkerja, kdeselon desc,kdjabatan desc,kdgol desc 
			   LIMIT $start, $limit";
	}else{
	$query  = "SELECT * FROM $table WHERE kdunitkerja LIKE '$kdunitkerja%' AND nama LIKE '%$cari%' 
			   ORDER BY kdunitkerja, kdeselon desc,kdjabatan desc,kdgol desc 
			   LIMIT $start, $limit";
	}		   
	$oList = mysql_query($query) ;
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
<a href="source/master/pemegang_jabatan_prn.php?kdunit=<?php echo $kdunit ?>" title="Cetak Pemegang Jabatan" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak PDF</font></a>&nbsp;|&nbsp;
<a href="source/master/pemegang_jabatan_xls.php?kdunit=<?php echo $kdunit ?>" title="Cetak Pemegang Jabatan" target="_blank">
			  <font size="1">Excel</font></a>&nbsp;&nbsp;<font color="#FF0000">Jumlah Pegawai : <?php echo $jml_pegawai ?></font>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="3%" rowspan="2">No.</th>
			<th rowspan="2">Nama Pegawai<br />
		  NIP</th>
			<th width="8%" rowspan="2">Gol.Ruang<br />
		  Pangkat</th>
			<th width="5%" rowspan="2">Status</th>
			<th colspan="4">Jabatan </th>
		    <th width="20%" rowspan="2">Unit Kerja</th>
		    <th colspan="2" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="20%">Nama Jabatan</th>
	      <th width="5%">Eselon</th>
          <th width="5%">Grade</th>
	      <th width="5%">TMT</th>
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
					<td align="left" valign="top"><?php echo $col[2][$k] ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[1][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_gol($col[4][$k]).'<br>'.nm_pangkat($col[4][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php if ( $col[6][$k] <> '' ) { ?><?php echo nm_jabatan_ij($col[6][$k],$col[3][$k]) ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[5][$k] <> '' ) {?><?php echo nm_eselon($col[5][$k]) ?><?php } ?></td>
					<td align="center" valign="top"><?php if ( $col[6][$k] <> '' ) { ?><?php echo 	grade_jabatan_ij($col[6][$k],$col[3][$k]) ?><?php } ?></td>
					<td align="center" valign="top"><?php echo reformat_tgl($col[8][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_unitkerja($col[3][$k]) ?></td>
				    <td width="3%" align="center" valign="top">
					<a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $kdunit ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
				    <td width="4%" align="center" valign="top">
					<a href="<?php echo $del[$k] ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $kdunit ?>" title="Delete">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr>
				
				<?php
			$kdunitkerja = 	$col[3][$k] ; 
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
#variabel query
	$targetpage = "index.php?p=$p&cari=$cari&kdunit=$kdunit"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

	$oList = mysql_query("SELECT * FROM $table WHERE left(kdunitkerja,5) = '$kdunit' ORDER BY kdjabatan desc ,kdgol desc  LIMIT $start, $limit");

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