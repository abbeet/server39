<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "t_output";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 
	$query = "SELECT COUNT(a.KDOUTPUT) as num FROM $table a JOIN t_giat b ON a.KDGIAT = b.KdGiat WHERE a.KDOUTPUT LIKE '%$cari%' OR a.NMOUTPUT LIKE '%$cari%' OR a.SAT LIKE '%$cari%' OR a.KDGIAT LIKE '%$cari%' OR b.NmGiat LIKE '%$cari%'";
//	$query = "SELECT COUNT(*) as num FROM $table WHERE KDOUTPUT LIKE '%$cari%' OR NMOUTPUT LIKE '%$cari%' OR SAT LIKE '%$cari%' OR KDGIAT LIKE '%$cari%'";
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

	$oList = mysql_query("SELECT a.KDGIAT, b.NmGiat, a.KDOUTPUT, a.NMOUTPUT, a.SAT FROM $table a JOIN t_giat b ON a.KDGIAT = b.KdGiat WHERE a.KDOUTPUT LIKE '%$cari%' OR a.NMOUTPUT LIKE '%$cari%' OR a.SAT LIKE '%$cari%' OR a.KDGIAT LIKE '%$cari%' OR b.NmGiat LIKE '%$cari%' LIMIT $start, $limit");
//	$oList = mysql_query("SELECT * FROM $table WHERE KDOUTPUT LIKE '%$cari%' OR NMOUTPUT LIKE '%$cari%' OR SAT LIKE '%$cari%' OR KDGIAT LIKE '%$cari%' ORDER BY KDGIAT,KDOUTPUT LIMIT $start, $limit");
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
		<a href="http://183.91.67.3/sipristek/index.php?p=85">Reset</a>
	</form>
</div><br />
<table width="652" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="3%">No.</th>
      <th width="9%">Kode Kegiatan</th>
      <th width="31%">Kegiatan </th>
      <th width="6%">Kode Output</th>
      <th width="37%">Output</th>
      <th width="14%">Satuan</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="6">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><?php echo (($pagess-1)*$limit)+($k+1) ?></td>
      <td align="center"> 
        <?php if($col[0][$k] <> $col[0][$k-1]){?>
        <?php echo $col[0][$k]; ?> 
        <?php }?>
      </td>
      <td align="left"> 
        <?php if($col[0][$k] <> $col[0][$k-1]){?>
        <?php echo nm_giat($col[0][$k]) ?> 
        <?php }?>
      </td>
      <td align="center"><?php echo $col[1][$k] ?></td>
      <td align="left"><?php echo $col[2][$k] ?></td>
      <td align="left"><?php echo $col[3][$k] ?></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
