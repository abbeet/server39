<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "m_program";
	$field =  array("id","ta","kddept","kdunit","kdprogram","nmprogram");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(*) as num FROM $table WHERE ta = '$th'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
		
	$oList = mysql_query("SELECT * FROM $table WHERE ta = '$th' ORDER BY kddept,kdunit,kdprogram LIMIT $start, $limit");
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
<strong><font size="+1"><?php echo 'Periode Renstra : '.$renstra ?></font></strong><br><br />
<table width="709" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th colspan="2"><font color="#0000FF">Program</font></th>
			
          <th colspan="2"><font color="#996633">Kegiatan</font></th>
			<th colspan="6" rowspan="2"><font color="#996633">Satker<br />Pelaksana Kegiatan</font></th>
			<th colspan="2" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="13%"><font color="#0000FF">Kode</font></th>
	      <th><font color="#0000FF">Nama</font></th>
	      <th><font color="#996633">Kode</font></th>
	      <th><font color="#996633">Nama</font></th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="12">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row6";
				else $class = "row6"; ?>
				<tr>
					<td align="center" valign="top" bgcolor="#FFFF00"><strong><font color="#0000FF"><?php if ( $col[4][$k] <> $col[4][$k-1] ) {?><?php echo $col[2][$k].'.'.$col[3][$k].'.'.$col[4][$k] ?><?php }?></font></strong></td>
			      <td colspan="9" align="left" valign="top" bgcolor="#FFFF00"><strong><font color="#0000FF"><?php echo $col[5][$k] ?></font></strong></td>
					<td colspan="2" align="center" valign="top">
						<a href="index.php?p=400&th=<?php echo $col[1][$k] ?>&kdprog=<?php echo $col[2][$k].$col[3][$k].$col[4][$k] ?>" title="Tambah Kegiatan">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Kegiatan</a></td>
				</tr>
<?php 
				$sql = "SELECT * FROM m_kegiatan WHERE th = '".$col[1][$k]."'"." and kddept = '".$col[2][$k]."'"." and kdunit = '".$col[3][$k]."'"." and kdprogram = '".$col[4][$k]."'"." order by kdgiat";
				$oGiat = mysql_query($sql);
				while ($Giat = mysql_fetch_array($oGiat))
				{
?>				
				<tr class="row1">
				  <td align="center" valign="top">&nbsp;</td>
				  <td width="12%" align="left" valign="top"></td>
				  <td width="9%" align="center" valign="top"><font color="#996633"><?php echo $Giat['kdgiat'] ?></font></td>
				  <td width="23%" align="left" valign="top"><font color="#996633"><?php echo $Giat['nmgiat'] ?></font></td>
				  <td colspan="6" align="left" valign="top">&nbsp;</td>
				  <td width="3%" align="center" valign="top"><a href="index.php?p=400&q=<?php echo $Giat['id'] ?>" title="Edit Kegiatan">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
	              <td width="8%" align="center" valign="top"><a href="index.php?p=401&q=<?php echo $Giat['id'] ?>" title="Delete Kegiatan">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
				<tr class="row1">
				  <td rowspan="2" align="center" valign="top">&nbsp;</td>
				  <td rowspan="2" align="left" valign="top"></td>
				  <td colspan="2" rowspan="2" align="center" valign="center"><strong>Indikator Kinerja Kegiatan</strong></td>
				  <td colspan="5" align="center" valign="top"><strong>Target</strong></td>
				  <td width="10%" rowspan="2" align="center" valign="center"><strong>Menjadi Indikator Program ?</strong></td>
				  <td colspan="2" rowspan="2" align="center" valign="top"><a href="index.php?p=516&th=<?php echo $col[1][$k] ?>&kdgiat=<?php echo $Giat['kdgiat'] ?>" title="Tambah Indikator">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Indikator</a></td>
	  </tr>
				<tr class="row1">
				  <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4) ?></strong></td>
	              <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+1 ?></strong></td>
                  <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+2 ?></strong></td>
                  <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+3 ?></strong></td>
                  <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+4 ?></strong></td>
	  </tr>
<?php 
				$sql = "SELECT * FROM m_ikk WHERE th = '".$col[1][$k]."'"." and kdgiat = '".$Giat[kdgiat]."'"." and kdunitkerja = '".$Giat[kdunitkerja]."'"." order by no_ikk";
				$oIKK = mysql_query($sql);
				while ($IKK = mysql_fetch_array($oIKK))
				{
?>				
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="left" valign="top"></td>
				  <td align="center" valign="top"><?php echo $IKK['no_ikk'] ?></td>
				  <td align="left" valign="top"><?php echo $IKK['nm_ikk'] ?></td>
				  <td align="center" valign="top"><?php echo $IKK['target_1'] ?></td>
				  <td align="center" valign="top"><?php echo $IKK['target_2'] ?></td>
				  <td align="center" valign="top"><?php echo $IKK['target_3'] ?></td>
				  <td align="center" valign="top"><?php echo $IKK['target_4'] ?></td>
				  <td align="center" valign="top"><?php echo $IKK['target_5'] ?></td>
				  <td align="center" valign="top"><font color="#0000FF">
			      <?php if ( $IKK['jadi_ikk_program'] == '1' ) { 
				  		echo "<font color='#0000FF'>Ya</font>";
						}else{
						echo "<font color='#FF0000'>Tidak</font>";
						}
				  ?>				  </td>
				  <td align="center" valign="top"><a href="index.php?p=516&q=<?php echo $IKK['id'] ?>" title="Edit Indikator Kinerja Kegiatan">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				  <td align="center" valign="top"><a href="index.php?p=517&q=<?php echo $IKK['id'] ?>" title="Delete Indikator Kinerja Kegiatan">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
				<?php
			} # IKK
			} # kegiatan
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="12">&nbsp;</td>
		</tr>
	</tfoot>
</table>
