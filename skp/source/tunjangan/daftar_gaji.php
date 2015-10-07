<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "t_gaji";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=299";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	$kdbulan = $_REQUEST['kdbulan'];
	$kdsatker = $_REQUEST['kdsatker'];

if ( $kdbulan == ' ' )    $kdbulan = date("m");
	
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
		if ( $kdbulan <> '' )   $kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan == '' )   $kdbulan = date('m') ;
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE Tahun = '$th' and KdSatker = '$xusername' and Bulan = '$kdbulan'";
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$query = "SELECT COUNT(*) as num FROM $table WHERE Tahun = '$th' and KdSatker = '$kdsatker' and Bulan = '$kdbulan'";
			break;
	} 
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
switch ( $xlevel )
{
    case '7':
	$targetpage = "index.php?p=$p&cari=$cari&xusername=$xusername&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	break;
	
	default:
	$targetpage = "index.php?p=$p&cari=$cari&kdsatker=$kdsatker&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	break;
}	
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
	$oList = mysql_query("SELECT * FROM $table WHERE Tahun = '$th' and KdSatker = '$xusername' and Bulan = '$kdbulan' ORDER BY kdjab,KdGapok LIMIT $start, $limit");
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT * FROM $table WHERE Tahun = '$th' and KdSatker = '$kdsatker' and Bulan = '$kdbulan' ORDER BY kdjab,KdGapok LIMIT $start, $limit");
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
									
					for ($i = 1; $i <= 12; $i++)
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
</div><?php 
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.'Gaji Bulan '.$nama_bulan.' '.$th.'</strong>' ?>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th width="25%">Nama Pegawai / NIP </th>
			<th width="17%">Nama Jabatan<BR />Status</th>
		    <th width="5%">Gaji Pokok<br />
		      Tunja.Istri<br />Tunja.Anak</th>
            <th width="13%">T.Struktural<br />T.Fungsional<br />T.Umum</th>
            <th width="13%">TBN<br />T.Beras<br />Pembulatan</th>
		    <th width="14%">T.Pajak</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td height="21" colspan="7" align="center">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[3] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$gaji = $col[7][$k] + $col[8][$k] + $col[9][$k] ;
				$tjab = $col[10][$k] + $col[11][$k] + $col[12][$k] ;
				$tlain = $col[13][$k] + $col[14][$k] + $col[15][$k] ;
				$gaji_bruto = $gaji + $tjab + $tlain + $col[16][$k] ;
				?>
				<tr class="<?php echo $class ?>">
					<td rowspan="3" align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td rowspan="3" align="left" valign="top"><?php echo nama_pegawai($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[3][$k]) ?><br /><?php echo nm_pangkat(substr($col[4][$k],0,1).hurufkeangka(substr($col[4][$k],1,1))).' ('.nm_gol(substr($col[4][$k],0,1).hurufkeangka(substr($col[4][$k],1,1))).')' ?><br /><?php echo nm_stskawin($col[18][$k]) ?></td>
					<td rowspan="3" align="left" valign="top"><?php echo nm_jabatan_ij($col[5][$k]) ?><br /><?php echo nm_kedudukan_gj($col[6][$k]) ?><br /><?php echo status_peg($col[21][$k]) ?></td>
					<td height="16" align="right" valign="top"><?php echo number_format($col[7][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[10][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[13][$k],"0",",",".") ?></td>
				    <td rowspan="3" align="right" valign="top"><?php echo number_format($col[16][$k],"0",",",".") ?></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo number_format($col[8][$k],"0",",",".") ?></td>
	              <td align="right" valign="top"><?php echo number_format($col[11][$k],"0",",",".") ?></td>
	              <td align="right" valign="top"><?php echo number_format($col[14][$k],"0",",",".") ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo number_format($col[9][$k],"0",",",".") ?></td>
	              <td align="right" valign="top"><?php echo number_format($col[12][$k],"0",",",".") ?></td>
	              <td align="right" valign="top"><?php echo number_format($col[15][$k],"0",",",".") ?></td>
	  </tr>
				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><strong><font color="#0000FF">Jumlah Gaji Kotor </font></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($gaji,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($tjab,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($tlain,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><font color="#0000FF"><?php echo number_format($gaji_bruto,"0",",",".") ?></font></strong></td>
	  </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
	</tfoot>
</table>
