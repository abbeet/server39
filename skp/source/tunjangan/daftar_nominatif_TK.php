<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=316";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
 	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
	
	if ( $_REQUEST['kdbulan'] == '' )  $kdbulan = date('m') - 1 ;
	else  $kdbulan = $_REQUEST['kdbulan'];
	
if ( $_REQUEST['cari'] )
{
	$kdunit = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
}	
	$xkdunit = substr($kdunit,0,5) ;
	
if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
if ( $kdunit == '2320100' )
{
	$sql  = mysql_query("SELECT nip FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' AND 
							(kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000') ");
}else{
	$sql  = mysql_query("SELECT nip FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' AND kdunitkerja LIKE '$xkdunit%' ");
}
$jml_pegawai = mysql_num_rows($sql) ;

$data_status = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
				AND bulan = '$kdbulan' AND tahun = '$th'");
$rdata_status = mysql_fetch_array($data_status) ;
		
switch ($xlevel)
	{
		case '4':
		if ( $kdunit == '2320100' )
		{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
					 ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' )";
		}else{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
					  kdunitkerja LIKE '$xkdunit%' ";
		}
		break;
		
		default:
		if ( $kdunit == '2320100' )
		{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
					  (kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000')";
		}else{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%'";
		}
		break;
	} 
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&kdunit=$kdunit&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

switch ($xlevel)
	{
		case '4':
		if ( $kdunit == '2320100' )
		{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' ) 
									ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}else{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									kdunitkerja LIKE '$xkdunit%' 
									ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}
		break;
		
		default:
		if ( $kdunit == '2320100' )
		{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									 ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' )
									  ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}else{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan'  
										and kdunitkerja LIKE '$xkdunit%' 
										ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
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
<div align="right">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
<?php if ( $xlevel == 1 ) {?>
		Unit Kerja : 
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  nm_unitkerja($kdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select * from kd_unitkerja WHERE kdsatker <> '' and left(nmunit,5) <> 'DINAS' 
												  order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
					} ?>	
	  </select>
<?php }?>
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
echo '<strong>'.nm_unitkerja($kdunit).'</strong><br>' ;
echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ;
?>
<br />
</font>
<a href="source/tunjangan/daftar_nominatif_prn.php?kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak PDF</font></a>&nbsp;|&nbsp;
<a href="source/tunjangan/daftar_nominatif_xls.php?kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>&nbsp;&nbsp;<font color="#FF0000">Jumlah Pegawai : <?php echo $jml_pegawai ?></font>
<?php if ( $rdata_status['status_verifikasi_nominatif'] == '1' ) { ?>
		&nbsp;&nbsp;<font color="#006600">[ Status Verifikasi : <?php echo status_nama($rdata_status['status_verifikasi_nominatif']).
		' tanggal '.reformat_tgl($rdata_status['tanggal_verifikasi_nominatif']) ?> ]</font>
<?php }elseif ( $rdata_status['status_verifikasi_nominatif'] == '0' ) { ?>
		&nbsp;&nbsp;<font color="#006600">[ Status Verifikasi : <?php echo status_nama($rdata_status['status_verifikasi_nominatif']) ?> ]</font>
<?php } ?>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="3%">No.</th>
			<th>Nama Pegawai / NIP </th>
			<th width="10%">Pangkat/<br />
	      Gol</th>
			<th width="5%">Status<br />(PNS/<br />CPNS)</th>
			<th width="20%">Nama Jabatan/<br />TMT</th>
		    <th width="5%">Grade</th>
            <th width="10%">Tunjangan<br />Kinerja</th>
            <th width="10%">Pajak<br />Tunjangan<br />Kinerja</th>
		    <th width="10%">Tunjangan Kinerja<br />
	      Setelah Ditambah<br />Pajak</th>
		    <th colspan="3">Aksi</th>
		</tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6)</th>
		  <th>(7)</th>
		  <th>(8)</th>
		  <th>(9=7+8)</th>
		  <th colspan="3">&nbsp;</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="12">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
//				$gaji_bruto    = $col[11][$k] + rp_grade(substr($col[6][$k],0,2),$col[9][$k],$col[22][$k]);
//				$pajak_total   = nil_pajak($gaji_bruto,$col[10][$k],$col[16][$k]); ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[3][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_pangkat($col[6][$k]).'<br>'.nm_gol($col[6][$k]) ?></td>
					<td align="center" valign="top"><?php echo nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[5][$k],$col[4][$k]) ?>
					<br /><?php echo '['.reformat_tgl($col[8][$k]).']' ?></td>
					<td align="center" valign="top"><?php echo $col[9][$k] ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[10][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format(($col[10][$k]+$col[11][$k]),"0",",",".") ?></td>
				    <td width="2%" align="center" valign="top">
					<?php if ( status_ver($kdunit,$th,$kdbulan) <> '1' ) {?>
					<a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>"
					 title="Edit Data Tunkin Bulan <?php echo $nama_bulan ?> Pegawai ini">
			  		 <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>
					<?php } ?> 
			  </td>
				    <td width="4%" align="center" valign="top">
					<?php if ( status_ver($kdunit,$th,$kdbulan) <> '1' ) {?>
					<a href="<?php echo $del[$k] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>" title="Delete">
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
			<td colspan="12">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php 
function status_ver($kdunit,$th,$bulan) {
		$data = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
				AND bulan = '$bulan' AND tahun = '$th'");
		$rdata = mysql_fetch_array($data) ;
		$status = $rdata['status_verifikasi_nominatif'] ;
		return $status;
	}
	
function status_nama($kode) {
	switch ( $kode )
	{
		case '0':
		   $nmstatus = 'Belum Diverifikasi' ;
		   break;
		   
		case '1':
		   $nmstatus = 'Telah Diverifikasi' ;
		   break;
		   
		 default:  
			$nmstatus = '' ;
			break;
	}		
		return $nmstatus;
	}
?>