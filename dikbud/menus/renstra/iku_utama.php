<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "m_sasaran";
	$field =  array("id","ta","kdunitkerja","no_sasaran","nm_sasaran");
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
		
	$oList = mysql_query("SELECT * FROM $table WHERE ta = '$th' ORDER BY kdunitkerja,no_sasaran LIMIT $start, $limit");
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
<a href="menus/renstra/iku_utama_prn.php?th=<?php echo $th ?>" title="Cetak Indikator Kinerja Utama" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>
<table width="586" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="18%">Kementerian<br />
		  /Lembaga</th>
			
          <th colspan="2">Sasaran Utama / Indikator Kinerja Utama</th>
			<th width="28%">Target</th>
		    <th colspan="2">Aksi</th>
	    </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="6">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="left" valign="top"><?php if ( $col[2][$k] <> $col[2][$k-1] ) {?><?php echo nm_unit($col[2][$k]) ?><?php }?></td>
			      <td colspan="2" align="left" valign="top"><strong><?php echo $col[4][$k] ?></strong></td>
					<td align="center" valign="top">											</td>
				    <td colspan="2" align="center" valign="top"><a href="index.php?p=396&th=<?php echo $col[1][$k] ?>&kdunit=<?php echo $col[2][$k] ?>&nosas=<?php echo $col[3][$k] ?>" title="Tambah IKU">
							<img src="css/images/menu/icon-16-new.png" border="0" width="27" height="23"></a></td>
			    </tr>
<?php 
				$sql = "SELECT * FROM m_iku WHERE kdunitkerja = '".$col[2][$k]."'"." and no_sasaran = '".$col[3][$k]."'"." order by no_iku";
				$oIKU = mysql_query($sql);
				while ($IKU = mysql_fetch_array($oIKU))
				{
?>				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td width="4%" align="center" valign="top"><?php echo $IKU['no_iku'] ?></td>
				  <td colspan="2" align="left" valign="top"><?php echo $IKU['nm_iku'] ?></td>
				  <td width="11%" align="center" valign="top"><a href="index.php?p=396&q=<?php echo $IKU['id'] ?>" title="Edit IKU">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>&nbsp;&nbsp;
				  <a href="index.php?p=417&th=<?php echo $col[1][$k] ?>&kdunit=<?php echo $col[2][$k] ?>&noiku=<?php echo $IKU['no_iku'] ?>" title="Tambah Target IKU">
				  <img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16"></a>				  </td>
	              <td width="5%" align="center" valign="top"><a href="index.php?p=397&q=<?php echo $IKU['id'] ?>" title="Delete IKU">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
<?php 
				$sql = "SELECT * FROM m_iku_target WHERE kdunitkerja = '".$col[2][$k]."'"." and no_iku = '".$IKU['no_iku']."'"." order by no_target";
				$oTarget = mysql_query($sql);
				while ($Target = mysql_fetch_array($oTarget))
				{
?>				
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td colspan="2" align="center" valign="top"></td>
				  <td align="left" valign="top"><?php echo $Target['target'] ?></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
	  </tr>
				<?php
			} # akhir Target
			} # akhir IKU
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
