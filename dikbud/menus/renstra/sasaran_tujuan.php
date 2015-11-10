<?php
	checkauthentication();
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "tb_unitkerja_tujuan";
	$field =  array("id","kdunitkerja","kdtujuan","no_sasaran","nm_sasaran","kdunit_terkait","kdtujuan");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kdmenteri = setup_kddept_unit().'20000' ;

	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdunit = '2320000' ";
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
		
	$oList = mysql_query("SELECT * FROM $table WHERE kdunit = '$kdmenteri' ORDER BY kdtujuan");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_array($oList)) 
		{
			$col[0][] = $List['id'];
			$col[1][] = $List['kdunit'];
			$col[2][] = $List['kdtujuan'];
			$col[3][] = $List['nmtujuan'];
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
		  <th width="21%" height="45" rowspan="2">Kementerian/Lembaga</th>
			<th colspan="2"><font color="#0000FF">Tujuan</font></th>
	    </tr>
		<tr>
		  <th colspan="2">Sasaran</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="3">Tidak ada data!</td></tr>
		<?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row1";
				else $class = "row1"; ?>
			<tr class="<?php echo $class ?>">
			  <td align="left"><?php if ( $col[1][$k] <> $col[1][$k-1] ) {?><?php echo nm_unit($col[1][$k]) ?><?php } ?></td>
	          <td colspan="2" align="left"><font color="#0000FF"><?php echo $col[3][$k] ?></font></td>
      </tr>
<?php 
	$kdunit = $col[1][$k] ;
	$kdtujuan = $col[2][$k] ;
	$oList = mysql_query("SELECT * FROM m_sasaran_utama WHERE ta = '$th' and left(no_sasaran,1) = '$kdtujuan' ORDER BY no_sasaran");
	while($List = mysql_fetch_array($oList)) 
		{
?>	  
		<tr>
			<td>&nbsp;</td>
		    <td width="3%" align="center" class="row6"><?php echo substr($List['no_sasaran'],1,1) ?></td>
		    <td width="59%"  class="row6"><?php echo $List['nm_sasaran'] ?></td>
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