<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=330";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	$kdbulan1 = date('m');
	$kdbulan2 = date('m');

if ( $_REQUEST['cari_satker'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan1 = $_REQUEST['kdbulan1'];
     $kdbulan2 = $_REQUEST['kdbulan2'];
}	
	
//if ( $_REQUEST['cari'] )
{
     if ( $_REQUEST['kdsatker'] == '' )   $kdsatker = $_SESSION['xusername'];
	 else   $kdsatker = $_REQUEST['kdsatker'] ;
     $kdbulan1 = $_REQUEST['kdbulan1'];
     $kdbulan2 = $_REQUEST['kdbulan2'];
}	

switch ($xlevel)
	{
		case '7':
		$kdbulan1 = $_REQUEST['kdbulan1'];
		if ( strlen($kdbulan1) == 1 )    $kdbulan1 = '0'.$kdbulan1 ;
		$kdbulan2 = $_REQUEST['kdbulan2'];
		if ( strlen($kdbulan2) == 1 )    $kdbulan2 = '0'.$kdbulan2 ;
	$query = "SELECT nib FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY nip";
			break;
		
		case '2':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan'";
			break;
		
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan'";
			break;
	} 
	
//	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = mysql_num_rows(mysql_query($query));
//	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&kdsatker=$kdsatker&kdbulan1=$kdbulan1&kdbulan2=$kdbulan2"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

switch ($xlevel)
	{
		case '7':
		$kdbulan1 = $_REQUEST['kdbulan1'];
		if ( strlen($kdbulan1) == 1 )    $kdbulan1 = '0'.$kdbulan1 ;
		$kdbulan2 = $_REQUEST['kdbulan2'];
		if ( strlen($kdbulan2) == 1 )    $kdbulan2 = '0'.$kdbulan2 ;
	$oList = mysql_query("SELECT count(nib) as jumlah, nib,norec,sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY nib ORDER BY nib, grade desc LIMIT $start, $limit");
	$rs = mysql_query("SELECT sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2'");
			break;
		
		case '2':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan' ORDER BY grade desc, kdgol desc, kdjabatan LIMIT $start, $limit");
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' ORDER BY grade desc , nib , kdgol desc, kdjabatan LIMIT $start, $limit");
			brek;
	} 

	// hitung total dari rs (semua data tanpa paging)
	$row = mysql_fetch_array($rs);
	$total = $row['jml_terima'];
	
	$count = mysql_num_rows($oList);
	
	//$total = 0 ;
	//$no = 0 ;
	$no = ($pagess-1)*$limit;
	while($List = mysql_fetch_object($oList)) {
			$no += 1 ;
			$col[0][] = $no ;
			$col[1][] = $List->nib;
			$col[2][] = $List->norec;
			$col[3][] = $List->jml_terima;
			//$total += $List->jml_terima ;
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
		Satker : 
		<select name="kdsatker">
                      <option value="<?php echo $kdsatker ?>"><?php echo  substr(nm_satker($kdsatker),0,60) ?></option>
                      <option value="">- Pilih Satker -</option>
                    <?php
							$query = mysql_query("select left(nmsatker,60) as nama_satker, kdsatker from kd_satker group by kdsatker order by kdsatker");
					while( $row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['nama_satker']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari_satker"/>
	</form>
</div>
<?php }?>
<div align="right">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Bulan : 
		<select name="kdbulan1"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan1) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>&nbsp;&nbsp;s/d&nbsp;&nbsp;
<select name="kdbulan2"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan2) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>		<input type="submit" value="Cari" name="cari"/>
	</form>
	
</div>
<?php
if ( substr($kdbulan1,0,1) == '0' )  $nama_bulan1 = nama_bulan(substr($kdbulan1,1,1));
else  $nama_bulan1 = nama_bulan($kdbulan1);
if ( substr($kdbulan2,0,1) == '0' )  $nama_bulan2 = nama_bulan(substr($kdbulan2,1,1));
else  $nama_bulan2 = nama_bulan($kdbulan2);
echo '<strong>'.'Bulan '.$nama_bulan1.' s/d '.$nama_bulan2.' '.$th.'</strong>' ?><br />
<a href="source/tunjangan/expor_bank1_xls.php?kdsatker=<?php echo $kdsatker ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Cetak Slip"><img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Excel</font></a>
<table width="76%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="8%">No.</th>
		  <th width="19%">Nomor Rekening </th>
		  <th width="22%">Jumlah</th>
		  <th width="23%">Nama Pegawai </th>
	      <th width="23%">Total</th>
	  </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
	      <th>(5)</th>
	  </tr>
	</thead>
	<tbody>
<?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="13">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    				 <tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[0][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[2][$k] ?></td>
					<td align="right" valign="top"><?php echo number_format($col[3][$k],"0",",",".") ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[1][$k]) ?></td>
				    <td align="right" valign="top"><?php if ( $col[0][$k] == 1 ) { ?><?php echo number_format($total,"0",",",".") ?><?php } ?></td>
			    </tr>
		<?php
		}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>
