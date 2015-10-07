<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "kd_unitkerja";
	$field = array("id","kdunit","nmunit","kdsatker");
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
 	$kdunit = $_SESSION['xkdunit'];
	
	if ( $_REQUEST['kdbulan'] == '' )  $kdbulan = date('m') - 1 ;
	else  $kdbulan = $_REQUEST['kdbulan'];
			
if ( $_REQUEST['cari'] )
{
	$kdbulan = $_REQUEST['kdbulan'];
}	
	
if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;

	$query = "SELECT COUNT(*) as num FROM $table WHERE kdsatker <> ' ' AND left(nmunit,5) <> 'DINAS'";
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&kdunit=$kdunit&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	$limit = 40; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

		$oList = mysql_query("SELECT * FROM $table WHERE kdsatker <> ' ' AND left(nmunit,5) <> 'DINAS' 
										ORDER BY kdunit LIMIT $start, $limit");

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
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Pilih Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
					<?php if ( $pagess == '' ) {?>
						<option value="<?php echo $i; ?>" <?php if ($i == date("m") ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					}else{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					}
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div><font color="#0066CC" size="2">
<?php 
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ;
?>
<br />
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="5%" rowspan="2">Kode</th>
		  <th rowspan="2">Nama Satuan Kerja</th>
		  <th colspan="3" >Daftar Nominatif Tukin <?php echo 'Bulan '.$nama_bulan.' '.$th ?></th>
          <th colspan="2">Data Kepegawaian <?php echo 'Bulan '.$nama_bulan.' '.$th ?></th>
	  </tr>
		<tr>
		  <th width="10%">Kosong</th>
	      <th width="10%">Belum<br />Verifikasi </th>
	      <th width="10%">Telah<br />Verifikasi</th>
	      <th width="10%">Belum<br />Verifikasi</th>
	      <th width="10%">Telah<br />Verifikasi</th>
      </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6)</th>
		  <th>(7)</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$kdunit = $col[1][$k] ;
				$status_tukin = '' ;
				$data_status = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
				AND bulan = '$kdbulan' AND tahun = '$th'");
				$rdata_status = mysql_fetch_array($data_status) ;
				$status_tukin = $rdata_status['status_verifikasi_nominatif'] ;
				$status_pot = $rdata_status['status_verifikasi_potongan'] ;
				
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[1][$k]; ?></td>
					<td align="left" valign="top"><?php echo $col[2][$k] ?></td>
					<td align="center" valign="top"><font color="#FF0000"><?php if ( $status_tukin == '' ) { ?><?php echo 'v' ?><?php } ?></font></td>
					
					<td align="center" valign="top"><font color="#FF9900"><?php if ( $status_tukin == '0' ) { ?><?php echo 'v' ?><?php } ?></font></td>
					
					<td align="center" valign="top"><font color="#009900"><?php if ( $status_tukin == '1' ) { ?><?php echo 'v' ?><?php } ?></font></td>
					
			        <td align="center" valign="top"><font color="#FF9900"><?php if ( $status_pot == '0' ) { ?><?php echo 'v' ?><?php } ?></font></td>
			        <td align="center" valign="top"><font color="#009900"><?php if ( $status_pot == '1' ) { ?><?php echo 'v' ?><?php } ?></font></td>
			    </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
