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
	
if ( $_REQUEST['cari'] )
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
	$oList = mysql_query("SELECT count(nib) as jumlah, nib,nip,norec FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY nib ORDER BY nib, grade desc LIMIT $start, $limit");
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
		Pilih Bulan : 
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
	  </select>		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div>
<?php
if ( substr($kdbulan1,0,1) == '0' )  $nama_bulan1 = nama_bulan(substr($kdbulan1,1,1));
else  $nama_bulan1 = nama_bulan($kdbulan1);
if ( substr($kdbulan2,0,1) == '0' )  $nama_bulan2 = nama_bulan(substr($kdbulan2,1,1));
else  $nama_bulan2 = nama_bulan($kdbulan2);
echo '<strong>'.'Bulan '.$nama_bulan1.' s/d '.$nama_bulan2.' '.$th.'</strong>' ?><br />
<a href="source/tunjangan/slip_penerima_prn.php?kdsatker=<?php echo $kdsatker ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Cetak Slip" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>&nbsp;&nbsp;|
<a href="source/tunjangan/slip_penerima_xls.php?kdsatker=<?php echo $kdsatker ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Cetak Slip"><font size="1">Excel</font></a>
<table width="76%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="6%">No.</th>
		  <th width="15%">Nama Pegawai</th>
		  <th width="22%">NIP<br />
		    Pangkat/Gol<br />Status</th>
		  <th width="25%">Nomor Rekening<br />Nama Jabatan/ TMT<br />
		  Kelas Jabatan</th>
		  <th width="6%">Pajak</th>
		  <th width="8%">Tunjangan<br />
	      Kinerja</th>
		  <th width="7%">Potongan</th>
	      <th width="11%">Jumlah<br />Diterima</th>
      </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6)</th>
		  <th>(7)</th>
		  <th>(8=6-7)</th>
	  </tr>
	</thead>
	<tbody>
<?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="16">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    				 <tr class="<?php echo $class ?>">
					<td align="center" valign="top"><strong><?php echo $limit*($pagess-1)+($k+1); ?></strong></td>
					<td align="left" valign="top"><strong><?php echo nama_peg($col[3][$k]) ?></strong></td>
					<td align="center" valign="top"><strong><?php echo 'NIP. '.reformat_nipbaru($col[4][$k]) ?></strong></td>
					<td align="center" valign="top"><strong><?php echo $col[19][$k] ?></strong></td>
					<td align="center" valign="top">&nbsp;</td>
					<td align="right" valign="top">&nbsp;</td>
			        <td align="right" valign="top">&nbsp;</td>
				    <td align="right" valign="top">&nbsp;</td>
			    </tr>
<?php 
	$nib = $col[3][$k] ;
	$tunker = 0 ;
	$pajak_tunker = 0 ;
	$potongan = 0 ;
	$terima = 0 ;
	$oList_bulan = mysql_query("SELECT bulan,kdgol,kdpeg,kdunitkerja,kdjabatan, tmtjabatan, grade, jml_hari, tunker, pajak_tunker, nil_terima FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' and nib = '$nib' ORDER BY bulan, tmtjabatan");
	while( $List_bulan = mysql_fetch_array($oList_bulan))
	{
		if ( substr($List_bulan['bulan'],0,1) == '0' )  $kdbl = substr($List_bulan['bulan'],1,1) ;
		else $kdbl = $List_bulan['bulan'] ;
		$tunker += $List_bulan['tunker'] ;
		$pajak_tunker += $List_bulan['pajak_tunker'] ;
		$potongan += $List_bulan['tunker'] - $List_bulan['nil_terima'] ;
		$terima += $List_bulan['nil_terima'] ;
?>				
					<tr class="<?php echo $class ?>">
					  <td align="center" valign="top">&nbsp;</td>
					  <td align="right" valign="top"><?php echo strtoupper(nama_bulan($kdbl)) ?></td>
					  <td align="center" valign="top"><?php echo nm_pangkat(substr($List_bulan['kdgol'],0,1).hurufkeangka(substr($List_bulan['kdgol'],1,1))).' ('.nm_gol(substr($List_bulan['kdgol'],0,1).hurufkeangka(substr($List_bulan['kdgol'],1,1))).')' ?><br /><?php echo '('.status_peg($List_bulan['kdpeg']).')' ?></td>
					  <td align="left" valign="top"><?php echo nm_info_jabatan($List_bulan['kdunitkerja'],$List_bulan['kdjabatan']).' ('.reformat_tgl($List_bulan['tmtjabatan']).')' ?><br /><?php echo 'Kelas Jabatan '.$List_bulan['grade'] ?><?php if ( $List_bulan['jml_hari'] <> 0 ) { ?><br /><?php echo '('.$List_bulan['jml_hari'].' hari dari .'.hari_bulan($th,$kdbl).' hari kerja)' ?><?php }?></td>
					  <td align="right" valign="top"><?php echo number_format($List_bulan['pajak_tunker'],"0",",",".") ?></td>
					  <td align="right" valign="top"><?php echo number_format($List_bulan['tunker'],"0",",",".") ?></td>
					  <td align="right" valign="top"><?php echo number_format($List_bulan['tunker'] - $List_bulan['nil_terima'],"0",",",".") ?></td>
					  <td align="right" valign="top"><?php echo number_format($List_bulan['nil_terima'],"0",",",".") ?></td>
				    </tr>
					<?php }?>
					<tr class="<?php echo $class ?>">
					  <td align="center" valign="top">&nbsp;</td>
					  <td align="right" valign="top">&nbsp;</td>
					  <td colspan="2" align="center" valign="top"><font color="#0000FF"><strong>Jumlah</strong></font></td>
					  <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($pajak_tunker,"0",",",".") ?></strong></font></td>
					  <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($tunker,"0",",",".") ?></strong></font></td>
					  <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($potongan,"0",",",".") ?></strong></font></td>
					  <td align="right" valign="top"><font color="#0000FF"><strong><?php echo number_format($terima,"0",",",".") ?></strong></font></td>
	  </tr>
				
				<?php
//		}
		}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</tfoot>
</table>
