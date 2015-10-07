<?php
	checkauthentication();
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "m_sasaran_utama";
	$field =  array("id","ta","no_sasaran","nm_sasaran");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kdmenteri = setup_kddept_unit($kode).'20000' ;
	$renstra = th_renstra($th);
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(*) as num FROM $table where kdunit = '$kdmenteri'";
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
		
	$oList = mysql_query("SELECT * FROM $table WHERE ta = '$th' and kdunit = '$kdmenteri' ORDER BY no_sasaran");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_array($oList)) 
		{
			$col[0][] = $List['id'];
			$col[1][] = $List['no_sasaran'];
			$col[2][] = $List['nm_sasaran'];
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
<table width="843" cellpadding="1" class="adminlist">
	<thead>
		<tr>
		  <th width="23%" height="45" rowspan="3">Kementerian/Lembaga</th>
			<th colspan="7"><font color="#0000FF">Sasaran Strategis</font></th>
		  <th colspan="2" rowspan="3"><a href="index.php?p=525" title="Input Sasaran Strategis">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Update Sasaran Strategis</a></th>
		</tr>
		<tr>
		  <th colspan="2" rowspan="2">Indikator Kinerja Utama (IKU)</th>
	      <th colspan="5">Target</th>
      </tr>
		<tr>
		  <th><?php echo substr($renstra,0,4) ?></th>
	      <th><?php echo substr($renstra,0,4)+1 ?></th>
	      <th><?php echo substr($renstra,0,4)+2 ?></th>
	      <th><?php echo substr($renstra,0,4)+3 ?></th>
	      <th><?php echo substr($renstra,0,4)+4 ?></th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="10">Tidak ada data!</td></tr>
		<?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row1";
				else $class = "row1"; ?>
			<tr class="<?php echo $class ?>">
			  <td align="left"><?php if ( $k == 0 ) {?><?php echo nm_unit($kdmenteri) ?><?php } ?></td>
	          <td colspan="7" align="left"><font color="#0000FF"><?php echo $col[2][$k] ?></font></td>
	          <td colspan="2" align="center"><a href="index.php?p=521&no_sasaran=<?php echo $col[1][$k] ?>" title="Tambah Indikator Kinerja Utama">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah IKU</a></td>
	  </tr>
<?php 
	$no_sasaran = $col[1][$k] ;
	$oList = mysql_query("SELECT * FROM m_iku_utama WHERE ta = '$th' AND no_sasaran = '$no_sasaran' and kdunit = '$kdmenteri' ORDER BY no_iku");
	while($List = mysql_fetch_array($oList)) 
		{
?>	  
		<tr>
			<td>&nbsp;</td>
		    <td width="4%" align="center" class="row6"><?php echo $List['no_iku'] ?></td>
		    <td width="26%"  class="row6"><?php echo $List['nm_iku'] ?></td>
		    <td width="7%" align="center"  class="row6"><?php echo $List['target_1'] ?></td>
		    <td width="7%" align="center"  class="row6"><?php echo $List['target_2'] ?></td>
		    <td width="7%" align="center"  class="row6"><?php echo $List['target_3'] ?></td>
		    <td width="7%" align="center"  class="row6"><?php echo $List['target_4'] ?></td>
		    <td width="7%" align="center"  class="row6"><?php echo $List['target_5'] ?></td>
		    <td width="5%" align="center"><a href="index.php?p=521&q=<?php echo $List['id'] ?>" title="Edit Sasaran">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
		    <td width="7%" align="center"><a href="index.php?p=522&q=<?php echo $List['id'] ?>" title="Delete Sasaran">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
		</tr>
<?php 
	$oList_iku = mysql_query("SELECT * FROM m_iku WHERE ta = '$th' AND kdunitkerja = '$kdunit' AND kdtujuan = '$kdtujuan' AND no_sasaran = '$List[no_sasaran]' ORDER BY no_iku");
	while($List_iku = mysql_fetch_array($oList_iku)) 
		{
?>	  
		
	  		<?php
			}
			}
			}
		} ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
<?php 
function tujuan_renstra($kdunit,$kdtujuan) {
		$data = mysql_query("select nmtujuan from tb_unitkerja_tujuan where kdunit = '$kdunit' and kdtujuan = '$kdtujuan' ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nmtujuan'];
		return $result;
}
	
function sasaran_renstra($th,$kdunit,$kdtujuan,$kdsasaran) {
		$data = mysql_query("select nm_sasaran from m_sasaran where ta = '$th' AND kdunitkerja = '$kdunit' and kdtujuan = '$kdtujuan' and no_sasaran = '$kdsasaran'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nm_sasaran'];
		return $result;
}	
?>