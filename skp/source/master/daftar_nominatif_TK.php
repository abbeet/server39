<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=316";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	$kdbulan = $_REQUEST['kdbulan'];
	
	if ( $kdbulan == '' ) $kdbulan = date('m');

if ( $_REQUEST['cari_satker'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan = $_REQUEST['kdbulan'];
}	
	
if ( $_REQUEST['cari'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan = $_REQUEST['kdbulan'];
}	

switch ($xlevel)
	{
		case '7':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan'";
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
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&kdsatker=$kdsatker&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

switch ($xlevel)
	{
		case '7':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan' ORDER BY grade desc, kdgol desc, kdjabatan LIMIT $start, $limit");
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
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<?php 
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ?><br />
<a href="index.php?p=368?kdsatker=<?php echo $xusername ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>&nbsp;|&nbsp;
<a href="source/tunjangan/daftar_nominatif_xls.php?kdsatker=<?php echo $xusername ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="3%">No.</th>
			<th width="7%">Nama Pegawai / NIP </th>
			<th width="7%">Pangkat/<br />
	      Gol</th>
			<th width="7%">Status<br />(PNS/<br />CPNS)</th>
			<th width="19%">Nama Jabatan/<br />TMT</th>
		    <th width="5%">Grade</th>
            <th width="8%">Gaji<br />Seluruhnya</th>
            <th width="8%">Tunjangan<br />Kinerja</th>
            <th width="9%">Penghasilan<br />Bruto</th>
            <th width="9%">Pajak<br />Seluruh<br />Penghasilan</th>
		    <th width="9%">Pajak<br />Gaji</th>
		    <th width="8%">Pajak<br />Tunjangan<br />Kinerja</th>
		    <th width="9%">Tunjangan Kinerja<br />
	      Setelah Ditambah<br />Pajak</th>
		    <th colspan="4">Aksi</th>
		</tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>&nbsp;</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6)</th>
		  <th>(7)</th>
		  <th>(8=6+7)</th>
		  <th>(9)</th>
		  <th>(10)</th>
		  <th>(11=9-10)</th>
		  <th>(12=7+11)</th>
		  <th colspan="4">&nbsp;</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="17">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
//				$gaji_bruto    = $col[11][$k] + rp_grade(substr($col[6][$k],0,2),$col[9][$k],$col[22][$k]);
//				$pajak_total   = nil_pajak($gaji_bruto,$col[10][$k],$col[16][$k]); ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[4][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_pangkat(substr($col[7][$k],0,1).hurufkeangka(substr($col[7][$k],1,1))).'('. nm_gol(substr($col[7][$k],0,1).hurufkeangka(substr($col[7][$k],1,1))).')' ?></td>
					<td align="center" valign="top"><?php echo status_peg($col[22][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_info_jabatan($col[6][$k],$col[8][$k]) ?>
					<?php if ( $col[21][$k] <> 0 ) 
					{
					echo '<br>'.'( '.$col[21][$k].' hari dari '.hari_bulan($th,$kdbulan).' hari kerja )';
					}
					?><br /><?php echo reformat_tgl($col[24][$k]) ?>					</td>
					<td align="center" valign="top"><?php echo $col[9][$k] ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[12][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format(($col[11][$k]+$col[12][$k]),"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format(($col[13][$k]+$col[17][$k]),"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col[13][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col[17][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format(($col[12][$k]+$col[17][$k]),"0",",",".") ?></td>
				    <td width="2%" align="center" valign="top"><?php if ( $col[14][$k] <> '1'  ) {?>
					<a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>" title="Edit Data Tunkin Bulan <?php echo $nama_bulan ?> Pegawai ini">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>
			  <?php } ?></td>
				    <td width="2%" align="center" valign="top"><?php if ( $col[14][$k] <> '1'  ) {?>
					<a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>&sw=1" title="Tambah Data Tunkin Bulan <?php echo $nama_bulan ?> Pegawai ini"><img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16"></a>
					<?php } ?>
					</td>
				    <td width="4%" align="center" valign="top"><?php if ( $col[14][$k] <> '1'  ) {?>
<a href="<?php echo $del[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>" title="Delete">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>
			  		<?php } ?>
					</td>
				</tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="17">&nbsp;</td>
		</tr>
	</tfoot>
</table>
