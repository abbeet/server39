<?php
	checkauthentication();
	$xlevel = $_SESSION['xlevel'];
	$th = $_SESSION['xth'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "kd_satker";
	$field = get_field($table);
	$ed_link = "index.php?p=360";
	
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
 switch ( $xlevel )
 {
    case '7':
	$query = "SELECT COUNT(*) as num FROM $table WHERE kdsatker = '$xusername' group by kdsatker ";
	break;
	
    default:
	$query = "SELECT COUNT(*) as num FROM $table GROUP BY kdsatker ";
	break;
}	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p"; 	#nama file  (nama file ini)
	$limit = 25; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

switch ( $xlevel )
{	
    case '7':	
	$oList = mysql_query("SELECT * FROM $table WHERE kdsatker = '$xusername' group by kdsatker");
    break;
	
    default:	
	$oList = mysql_query("SELECT * FROM $table group by kdsatker");
    break;
}
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&kdsatker=".$List->$field[1];
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
<br />
<table cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%">No.</th>
			<th width="6%">Kode Satker</th>
			<th width="25%" colspan="3">Nama Satker / Pejabat</th>
			
            <th width="6%">Aksi</th>
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
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="center" valign="top"><?php echo $col[1][$k] ?></td>
					<td colspan="3" align="left" valign="top"><?php echo $col[2][$k] ?></td>
				  <td align="center" valign="top">
					  <a href="<?php echo $ed[$k] ?>" title="Edit Nama Pejabat">
						  <img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
<?php 
$oList_pejabat = mysql_query("select * from ref_pejabat where th = '$th' and kdsatker = '$xusername' order by kdpejabat ");
while($List_pejabat = mysql_fetch_array($oList_pejabat))
{
?>						  
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="left" valign="top"><?php echo nm_jabatan_keu($List_pejabat['kdpejabat']) ?></td>
				  <td align="left" valign="top"><?php echo nama_peg($List_pejabat['nib']) ?></td>
				  <td align="left" valign="top"><?php echo reformat_nipbaru(nip_peg($List_pejabat['nib'])) ?></td>
				  <td align="center" valign="top">&nbsp;</td>
	  </tr>
				<?php
			}
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
