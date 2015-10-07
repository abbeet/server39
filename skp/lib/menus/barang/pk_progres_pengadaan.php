<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "thuk_ren_pengadaan";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'];
	
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(*) as num FROM $table WHERE  th = '$th' and (nama_pekerjaan LIKE '%$cari%' OR kdsatker LIKE '%$cari%')";
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
		
	$oList = mysql_query("SELECT * FROM $table WHERE th = '$th' and (nama_pekerjaan LIKE '%$cari%' OR kdsatker LIKE '%$cari%') ORDER BY kdsatker LIMIT $start, $limit");
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
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Cari : <input type="text" name="cari" value="<?php echo @$cari; ?>" />
		<input type="submit" value="Cari" />
		<a href="http://183.91.67.3/siplapan/index.php?p=33">Reset</a>
	</form>
</div><br />
<table width="652" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%">No.</th>
			<th width="10%">Kode</th>
			<th width="21%">Satker</th>
			<th width="28%">Nama Pekerjaan </th>
			<th width="11%">Pagu</th>
			<th width="18%">Rencana Proses Pengadaan Barang/Jasa </th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo (($pagess-1)*$limit)+($k+1) ?></td>
					<td align="center"><?php if($col[2][$k] <> $col[2][$k-1]){?><?php echo $col[2][$k] ?><?php }?></td>
					<td align="left"><?php if($col[2][$k] <> $col[2][$k-1]){?><?php echo nm_satker($col[2][$k]) ?><?php }?></td>
					<td align="left"><?php echo $col[3][$k] ?></td>
					<td align="right"><?php echo number_format($col[4][$k],"0",",",".") ?></td>
					<td align="center"><?php echo reformat_tgl($col[5][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[48][$k]) ?></td>
					<td width="3%" align="center">
						<a href="<?php echo $ed[$k] ?>&pagess=<?php echo $pagess ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td rowspan="8" align="center">&nbsp;</td>
				  <td rowspan="8" align="right" valign="top"><strong>Rencana:</strong></td>
				  <td align="right">Pengumuman Lelang</td>
				  <td align="left"><?php if ( $col[6][$k] < date ( 'Y-m-d' ) and $col[7][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[5][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[6][$k]) ?></td>
				  <td rowspan="8" align="right" valign="top"><strong>Realisasi:</strong></td>
				  <td align="left"><?php if( $col[7][$k] <> '0000-00-00' ) {?><?php if( $col[7][$k] > $col[6][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[7][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[8][$k]) ?></font><?php } ?></td>
				  <td rowspan="8" align="center">&nbsp;</td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right">Pendaftaran Lelang</td>
				  <td height="20" align="left"><?php if ( $col[12][$k] < date ( 'Y-m-d' ) and $col[13][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[11][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[12][$k]) ?></td>
	              <td align="left"><?php if( $col[13][$k] <> '0000-00-00' ) {?><?php if( $col[13][$k] > $col[12][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[13][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[14][$k]) ?></font><?php }?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top">Aanwijzing</td>
				  <td align="left"><?php if ( $col[18][$k] < date ( 'Y-m-d' ) and $col[19][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[17][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[18][$k]) ?></td>
	              <td align="left"><?php if( $col[19][$k] <> '0000-00-00' ) {?><?php if( $col[19][$k] > $col[18][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[19][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[20][$k]) ?></font><?php }?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top">Penawaran</td>
				  <td align="left"><?php if ( $col[24][$k] < date ( 'Y-m-d' ) and $col[25][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[23][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[24][$k]) ?></td>
	              <td align="left"><?php if( $col[25][$k] <> '0000-00-00' ) {?><?php if( $col[25][$k] > $col[24][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[25][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[26][$k]) ?></font><?php }?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top">Evaluasi</td>
				  <td align="left"><?php if ( $col[30][$k] < date ( 'Y-m-d' ) and $col[31][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[29][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[30][$k]) ?></td>
				  <td align="left"><?php if( $col[31][$k] <> '0000-00-00' ) {?><?php if( $col[31][$k] > $col[30][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[31][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[32][$k]) ?></font><?php }?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top">Penetapan</td>
				  <td align="left"><?php if ( $col[36][$k] < date ( 'Y-m-d' ) and $col[37][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[35][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[36][$k]) ?></td>
				  <td align="left"><?php if( $col[37][$k] <> '0000-00-00' ) {?><?php if( $col[37][$k] > $col[36][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[37][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[38][$k]) ?></font><?php }?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top">Kontrak</td>
				  <td align="left"><?php if ( $col[42][$k] < date ( 'Y-m-d' ) and $col[43][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[41][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[42][$k]) ?></td>
				  <td align="left"><?php if( $col[43][$k] <> '0000-00-00' ) {?><?php if( $col[43][$k] > $col[42][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[43][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[44][$k]) ?></font><?php }?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top">Serah Terima Barang </td>
				  <td align="left"><?php if ( $col[48][$k] < date ( 'Y-m-d' ) and $col[49][$k] == '0000-00-00' ) {?><blink><?php } ?><?php echo reformat_tgl($col[47][$k]).'<strong>  s/d  </strong>'.reformat_tgl($col[48][$k]) ?></td>
				  <td align="left"><?php if( $col[49][$k] <> '0000-00-00' ) {?><?php if( $col[49][$k] > $col[48][$k] ) { ?><font color="#FF0000" ><?php }else{ ?><font color="#00954A" ><?php }?><?php echo reformat_tgl($col[49][$k]).'<br><strong>  No Doc.  </strong>'.trim($col[50][$k]) ?></font><?php }?></td>
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
