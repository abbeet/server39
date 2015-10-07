<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker","prosen_potongan","nil_potongan","nil_terima");
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
//--------- jumlah peawai
if ( $kdunit == '2320100' )
{
	$sql  = mysql_query("SELECT nip FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' AND 
							(kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000') ");
}else{
	$sql  = mysql_query("SELECT nip FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' AND kdunitkerja LIKE '$xkdunit%' ");
}
$jml_pegawai = mysql_num_rows($sql) ;
//--------- status verifikasi
$data_status = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
				AND bulan = '$kdbulan' AND tahun = '$th'");
$rdata_status = mysql_fetch_array($data_status) ;
				
switch ($xlevel)
	{
		case '4':
		if ( $kdunit == '2320100' )
		{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
					  ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000')";
		}else{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%' ";
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
									( kdunitkerja LIKE '$xkdunit%'  OR kdunitkerja = '2320000' )
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
<a href="source/tunjangan/daftar_penerima_prn.php?kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak PDF</font></a>&nbsp;|&nbsp;
<a href="source/tunjangan/daftar_penerima_xls.php?kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>&nbsp;&nbsp;<font color="#FF0000">Jumlah Pegawai : <?php echo $jml_pegawai ?></font>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="3%" rowspan="3">No.</th>
			<th rowspan="3">Nama Pegawai /<br /> NIP / Gol / Status</th>
			<th width="20%" rowspan="3">Nama Jabatan/<br />TMT / <br /> Grade</th>
		    <th width="8%" rowspan="3">Tunjangan<br />Kinerja</th>
            <th width="8%" rowspan="3">Pajak<br />Tunjangan<br />Kinerja</th>
		    <th width="8%" rowspan="3">Tunjangan Kinerja<br />
	      Setelah Ditambah<br />Pajak</th>
		    <th colspan="4">Potongan</th>
		    <th width="8%" rowspan="3">Jumlah<br />Dibayarkan</th>
		    <th width="8%" rowspan="3">Nomor<br />Rekening</th>
	    </tr>
		<tr>
		  <th width="8%" rowspan="2">Pajak</th>
	      <th width="8%" colspan="2">Kehadiran</th>
	      <th width="8%" rowspan="2">Jumlah Potongan</th>
      </tr>
		<tr>
		  <th>(%)</th>
	      <th>Rp.</th>
	  </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6=4+5)</th>
		  <th>(7)</th>
		  <th>(8)</th>
		  <th>(9=4x8)		  </th>
		  <th>(10=7+9)</th>
		  <th>(11=6-10)</th>
		  <th>(12)</th>
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
				$nip = $col[3][$k] ;
				$sql_bank = "SELECT no_rek FROM mst_rekening WHERE nip = '$nip'";
				$oList_bank = mysql_query($sql_bank) ;
				$List_bank  = mysql_fetch_array($oList_bank) ;
				
				$potongan_p = 0 ;
				$potongan_r = 0 ;
				if ( $rdata_status['status_verifikasi_potongan'] == '1' )
				{
				$bulan = $th.'-'.$kdbulan ;
				$sql_pot = "SELECT TOT FROM potongan WHERE nip = '$nip' and bulan = '$bulan'";
				$oList_pot = mysql_query($sql_pot) ;
				$List_pot  = mysql_fetch_array($oList_pot) ;
				$potongan_p = $List_pot['TOT'] ;
				$potongan_r = ( $potongan_p/100 ) * $col[10][$k] ;
				}
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[3][$k]).'<br>'.nm_gol($col[6][$k]).' / '.nm_status_peg($col[7][$k]) ?></td>
					<td align="left" valign="top"><?php echo nm_jabatan_ij($col[5][$k],$col[4][$k]) ?>
					<br /><?php echo '['.reformat_tgl($col[8][$k]).']' ?><br /><?php echo 'Grade '.$col[9][$k] ?></td>
					<td align="right" valign="top"><?php echo number_format($col[10][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format(($col[10][$k]+$col[11][$k]),"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($potongan_p,"2",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($potongan_r,"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col[11][$k]+$potongan_r,"0",",",".") ?></td>
				    <td align="right" valign="top"><strong><?php echo number_format(($col[10][$k]-$potongan_r),"0",",",".") ?></strong></td>
				    <td align="left" valign="top"><?php echo $List_bank['no_rek'] ?></td>
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
