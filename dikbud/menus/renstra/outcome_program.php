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
	$kdmenteri = setup_kddept_unit($kode).'20000' ;
	
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
		
	$oList = mysql_query("SELECT * FROM $table WHERE ta = '$th' ORDER BY kdprogram LIMIT $start, $limit");
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
<a href="menus/renstra/outcome_program_prn.php?th=<?php echo $th ?>" title="Cetak Outcome Utama" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>
<table width="696" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="13%" rowspan="2">Lembaga</th>
			
          <th colspan="7"><font color="#009900"><strong>Nama Program</strong></font>            </th>
			<th colspan="2" rowspan="2">Aksi</th>
	    </tr>
		<tr>
		  <th colspan="7"><font color="#0033CC">Outcome</font></th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="10">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td width="13%"align="left" valign="top"><?php if ( $col[2][$k] <> $col[2][$k-1] ) {?><?php echo nm_unit($kdmenteri) ?><?php }?></td>
			      <td align="center" valign="top"><font color="#009900"><strong><?php echo $col[2][$k].'.'.$col[3][$k].'.'.$col[4][$k] ?></strong></font></td>
					<td colspan="6" align="left" valign="top"><font color="#009900"><strong><?php echo $col[5][$k] ?></strong></font></td>
					<td colspan="2" align="center" valign="top"><a href="index.php?p=412&th=<?php echo $col[1][$k] ?>&kdprogram=<?php echo $col[4][$k] ?>" title="Tambah Outcome Program">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Outcome</a></td>
			    </tr>
<?php 
				$id = $col[0][$k] ;
				$sql = "SELECT * FROM m_program_outcome WHERE ta = '".$col[1][$k]."'"." and kddept = '".$col[2][$k]."'"." and kdprogram = '".$col[4][$k]."'"." order by kdoutcome";
				$oOutcome = mysql_query($sql);
				while ($Outcome = mysql_fetch_array($oOutcome))
				{
?>				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td width="3%" align="center" valign="top"><font color="#0033CC"><?php echo $Outcome['kdoutcome'] ?></font></td>
				  <td colspan="4" align="left" valign="top"><font color="#0033CC"><?php echo $Outcome['nmoutcome'] ?></font></td>
				  <td colspan="2" align="left" valign="top"><font color="#0033CC"><?php echo nm_unit($Outcome['kdunitkerja']) ?></font></td>
				  <td width="5%" align="center" valign="top"><a href="index.php?p=412&q=<?php echo $Outcome['id'] ?>" title="Edit IKU">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
	              <td width="11%" align="center" valign="top"><a href="index.php?p=441&id=<?php echo $id ?>&q=<?php echo $Outcome['id'] ?>&sw=1" title="Delete Outcome">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td rowspan="2" align="center" valign="top">&nbsp;</td>
				  <td colspan="2" rowspan="2" align="center" valign="top"><strong>Indikator</strong></td>
				  <td colspan="5" align="center" valign="top"><strong>Target</strong></td>
				  <td colspan="2" rowspan="2" align="center" valign="top"><a href="index.php?p=519&th=<?php echo $col[1][$k] ?>&kdprogram=<?php echo $col[4][$k] ?>&kdoutcome=<?php echo $Outcome['kdoutcome'] ?>" title="Tambah Indikator">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Indikator</a></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4) ?></strong></td>
	              <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+1 ?></strong></td>
	              <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+2 ?></strong></td>
	              <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+3 ?></strong></td>
	              <td width="8%" align="center" valign="top"><strong><?php echo substr($renstra,0,4)+4 ?></strong></td>
	  </tr>
<?php 
				$sql = "SELECT * FROM m_outcome_indikator WHERE ta = '".$col[1][$k]."'"." and kdprogram = '".$col[4][$k]."'"." and kdoutcome = '".$Outcome[kdoutcome]."'"." order by kd_indikator";
				$oIndikator = mysql_query($sql);
				while ($Indikator = mysql_fetch_array($oIndikator))
				{
?>				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><?php echo $Indikator['kd_indikator'] ?></td>
				  <td width="30%" align="left" valign="top"><?php echo $Indikator['nm_indikator'] ?></td>
				  <td align="center" valign="top"><?php echo $Indikator['target_1'] ?></td>
				  <td align="center" valign="top"><?php echo $Indikator['target_2'] ?></td>
				  <td align="center" valign="top"><?php echo $Indikator['target_3'] ?></td>
				  <td align="center" valign="top"><?php echo $Indikator['target_4'] ?></td>
				  <td align="center" valign="top"><?php echo $Indikator['target_5'] ?></td>
				  <td width="5%" align="center" valign="top"><a href="index.php?p=519&q=<?php echo $Indikator['id'] ?>" title="Edit Indikator">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				  <td width="11%" align="center" valign="top"><a href="index.php?p=520&id=<?php echo $id ?>&q=<?php echo $Indikator['id'] ?>&sw=1" title="Delete Indikator">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
				 
			<?php
			} # akhir indikator
			} # akhir outcome
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10">&nbsp;</td>
		</tr>
	</tfoot>
</table>
