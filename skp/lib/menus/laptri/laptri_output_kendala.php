<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$kddeputi = substr($xkdunit,0,3);
	$kdtriwulan = $_REQUEST['kdtriwulan'];
	$cari = $kdtriwulan ;
	$table = "thbp_kak_kegiatan";
	$field = get_field($table);
	$ed_link = "index.php?p=187";

	$th = $_SESSION['xth'];
	$bl = date('m');
	
	if( $bl <= 4 ) 				$kdtriwulan = 1 ;
	if( $bl >= 5 and $bl <= 7) 	$kdtriwulan = 2 ;
	if( $bl >= 8 and $bl <= 10) $kdtriwulan = 3 ;
	if( $bl >= 11 ) 			$kdtriwulan = 4 ;
	
	if($_REQUEST['cari']){
		$kdtriwulan = $_REQUEST['kdtriwulan'];
		$cari = $kdtriwulan ;
		$pagess = $_REQUEST['pagess'];
	}

	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	switch ($xlevel)
	{
		case '1':
			$query = "SELECT COUNT(*) as num FROM $table WHERE th LIKE '%$cari%'";
			break;
		case '3':
			$query = "SELECT COUNT(*) as num FROM $table WHERE th LIKE  '%$cari%' AND kdsatker = '".$xusername."'";
			break;
		case '4':
			$query = "SELECT COUNT(*) as num FROM $table WHERE th LIKE  '%$cari%' AND left(kdunitkerja,3) = '".$kddeputi."'";
			break;
		case '5':
			$query = "SELECT COUNT(*) as num FROM $table WHERE th LIKE  '%$cari%' AND left(kdunitkerja,4) = '".$kdunit."'";
			break;
		default:
			$query = "SELECT COUNT(*) as num FROM $table WHERE th LIKE '%$cari%'";
			break;
	}
	
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari"; 	#nama file  (nama file ini)
	$limit = 2; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
		
	switch ($xlevel)
	{
		case '1':
			$oList = mysql_query("SELECT * FROM $table WHERE th LIKE '%$cari%' ORDER BY kdsatker LIMIT $start, $limit");
			break;
		case '3':
			$oList = mysql_query("SELECT * FROM $table WHERE th LIKE '%$cari%' AND kdsatker = '".$xusername."' GROUP BY kdsatker ORDER BY kdsatker LIMIT $start, $limit");
			break;
		case '4':
			$oList = mysql_query("SELECT * FROM $table WHERE th LIKE '%$cari%' AND left(kdunitkerja,3) = '".substr($xkdunit,0,3)."' GROUP BY kdsatker ORDER BY kdsatker LIMIT $start, $limit");
			break;
		case '5':
			$oList = mysql_query("SELECT * FROM $table WHERE th LIKE '%$cari%' AND left(kdunitkerja,4) = '".substr($xkdunit,0,4)."' GROUP BY kdsatker ORDER BY kdsatker LIMIT $start, $limit");
			break;
		default:
			$oList = mysql_query("SELECT * FROM $table WHERE th LIKE '%$cari%' ORDER BY kdsatker LIMIT $start, $limit");
			break;
	}
	
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	
		$ed[] = $ed_link;
		$prn[] = $prn_link;
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
		Triwulan : 
		<select name="kdtriwulan"><?php
									
					for ($i = 1; $i <= 4; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdtriwulan) echo "selected"; ?>><?php echo nmromawi($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<strong><?php echo 'Triwulan '.nmromawi($kdtriwulan) ?></strong><br />
<table width="840" cellpadding="1" class="adminlist">
  <thead>
    
    <tr>
      <th width="6%" rowspan="2">No.</th>
      <th width="8%" rowspan="2">Unit Kerja</th>
      <th colspan="2">Kode</th>
      <th rowspan="2">Nama Satker dan Kegiatan /<br>
        Output</th>
      <th width="13%" rowspan="2">Kendala</th>
      <th width="15%" rowspan="2">Tindak Lanjut<br />
      yang Diperlukan</th>
      <th width="23%" rowspan="2">Pihak yang Diharapkan<br />
      dapat Membantu<br />Menyelesaikan Masalah</th>
      <th rowspan="2">Aksi</th>
    </tr>
    <tr>
      <th width="5%">Satker</th>
      <th width="5%">Giat</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="12">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			
			$sql = "SELECT SUM(jml_anggaran_indikatif) as jml_anggaran FROM thbp_kak_kegiatan WHERE th LIKE '%".$cari."%'";
			$qu = mysql_query($sql);
			$row = mysql_fetch_array($qu);
			?>
    <?php
			
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><strong><?php echo (($pagess-1)*$limit)+($k+1) ?></strong></td>
      <td align="left"> <strong> 
        <?php if( $col[2][$k] <> $col[2][$k-1] ){ ?>
        <?php echo ket_unit($col[2][$k]) ?>
        <?php } ?>
      </strong></td>
      <td align="center"><strong><?php echo $col[10][$k] ?></strong></td>
      <td align="center"><strong><?php echo $col[3][$k] ?></strong></td>
      <td align="left"><strong><?php echo nm_satker($col[10][$k]) ?><br /><?php echo nm_giat($col[3][$k]) ?></strong></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td width="4%" align="center">&nbsp;</td>
    </tr>
    <?php 
	$th = $col[1][$k];
	$kdsatker = $col[10][$k];
	$kdgiat = $col[3][$k];
	$oList_kak_output = mysql_query("SELECT * FROM thbp_kak_output WHERE th = '$th' and kdsatker = '$kdsatker' AND kdgiat = '$kdgiat' ORDER BY kdoutput ");
	while($List_kak_output = mysql_fetch_array($oList_kak_output)){
	$kdoutput = $List_kak_output['kdoutput'] ;

	$oList = mysql_query("SELECT * FROM thuk_kak_output_ukp4_pp39 WHERE th = '$th' AND kdunitkerja = '$List_kak_output[kdunitkerja]' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput'");
	$List = mysql_fetch_array($oList);
	
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center"><?php echo $kdoutput ?></td>
      <td width="26%" align="left"><?php echo nm_output($kdgiat.$kdoutput) ?></td>
      <td align="left">
	  <?php 
	  	switch ($kdtriwulan)
		{
		case '1':
			echo $List['kendala_b3'] ;
			break;
		case '2':
			echo $List['kendala_b6'] ;
			break;
		case '3':
			echo $List['kendala_b9'] ;
			break;
		case '4':
			echo $List['kendala_b12'] ;
			break;
		}
	  ?>	  </td>
      <td align="left">
<?php 	switch ($kdtriwulan)
		{
		case '1':
			echo $List['tindak_lanjut_b3'] ;
			break;
		case '2':
			echo $List['tindak_lanjut_b6'] ;
			break;
		case '3':
			echo $List['tindak_lanjut_b9'] ;
			break;
		case '4':
			echo $List['tindak_lanjut_b12'] ;
			break;
		}
?>	  </td>
      <td align="left">
	  <?php 
	  	switch ($kdtriwulan)
		{
		case '1':
			echo $List['dapat_membantu_b3'] ;
			break;
		case '2':
			echo $List['dapat_membantu_b6'] ;
			break;
		case '3':
			echo $List['dapat_membantu_b9'] ;
			break;
		case '4':
			echo $List['dapat_membantu_b12'] ;
			break;
		}
	  ?>	  </td>
      <td align="center"> <a href="<?php echo $ed[$k] ?>&amp;q=<?php echo $List['id'] ?>&amp;o=<?php echo $List_kak_output['id'] ?>&kdtriwulan=<?php echo $kdtriwulan ?>&pagess=<?php echo $pagess?>" title="Edit Presentase Capaian dan Hasil"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a> </td>
    </tr>
    
    <?php
		}
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="12">&nbsp;</td>
    </tr>
  </tfoot>
</table>
