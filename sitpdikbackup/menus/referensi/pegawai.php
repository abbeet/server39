<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	$addlink	= "101"."&h=".$h;
	$edlink 	= "101"."&h=".$h;
	$dellink	= "102"."&h=".$h;
	
	$adjacents 	= 3;
	
	if ($slevel == "DEV")
	{
		if (@$_POST['c'])
		{	
			$sql = sql_select("pegawai p LEFT OUTER JOIN unit u ON p.unit = u.kdunit", "p.nip, p.nama, p.eselon, p.alamat, p.telepon, u.nmunit", 
			"p.nip LIKE '%".$c."%' OR p.nama LIKE '%".$c."%'", "p.unit");
		}
		
		else
		{
			$sql = sql_select("pegawai p LEFT OUTER JOIN unit u ON p.unit = u.kdunit", "p.nip, p.nama, p.eselon, p.alamat, p.telepon, u.nmunit", "", 
			"p.unit");
		}
	}
	
	else
	{
		if (@$_POST['c'])
		{	
			$sql = sql_select("pegawai p LEFT OUTER JOIN unit u ON p.unit = u.kdunit", "p.nip, p.nama, p.eselon, p.alamat, p.telepon, u.nmunit", "p.unit 
			 LIKE '".substr($sunit, 0, 5)."%' AND (p.nip LIKE '%".$c."%' OR p.nama LIKE '%".$c."%')", "p.unit");
		}
		
		else
		{
			$sql = sql_select("pegawai p LEFT OUTER JOIN unit u ON p.unit = u.kdunit", "p.nip, p.nama, p.eselon, p.alamat, p.telepon, u.nmunit", "p.unit LIKE		
			 '".substr($sunit, 0, 5)."%'", "p.unit");
		}
	}
	
	$olist = mysql_query($sql) or die(mysql_error());
	$totpages = mysql_num_rows($olist);
	
	$targetpage = "index.php?p=";
	$limit = 20;
	
	if ($h) $start = ($h - 1) * $limit;
	else $start = 0;
	
	$sql .= " LIMIT ".$start.", ".$limit;
	$olist = mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($olist);
	
	if ($h == 0) $h = 1;
	$prev = $h - 1;
	$next = $h + 1;
	$lastpage = ceil($totpages/$limit);
	$lpm1 = $lastpage - 1;
 
	$pagination = "";
	
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		
		if ($h > 1) $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$prev)."\"><< Sebelumnya</a>";
		else $pagination.= "<span class=\"disabled\"><< Sebelumnya</span>";
		
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
				else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter)."\">".$counter."</a>";
			}
		}
		
		elseif ($lastpage > 5 + ($adjacents * 2))
		{
			if ($h < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
					else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter)."\">".$counter."</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lpm1)."\">".$lpm1."</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lastpage)."\">".$lastpage."</a>";
			}
			
			elseif ($lastpage - ($adjacents * 2) > $h && $h > ($adjacents * 2))
			{
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=1")."\">1</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=2")."\">2</a>";
				$pagination.= "...";
				
				for ($counter = $h - $adjacents; $counter <= $h + $adjacents; $counter++)
				{
					if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
					else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter)."\">".$counter."</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lpm1)."\">".$lpm1."</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lastpage)."\">".$lastpage."</a>";
			}
			
			else
			{
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=1")."\">1</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=2")."\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
					else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter)."\">".$counter."</a>";
				}
			}
		}
		
		if ($h < $counter - 1)  $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$next)."\">Selanjutnya >></a>";
		else $pagination.= "<span class=\"disabled\">Selanjutnya >></span>";
		
		$pagination.= "</div>";		
	}
?>

<script language="javascript">
	
	function del(q)
	{
		var r = confirm("Apakah Anda yakin ingin menghapus?");
		
		if (r == true)
		{
	  		window.location.href = "index.php?p="+q;
		}
	}

</script>

<form name="cari" method="post" action="index.php?p=<?php echo enkripsi($p."&q=".$q); ?>">
	<img src="css/images/view.gif" border="0" width="16" height="16" />
    <input type="text" name="c" size="40" value="<?php echo @$c; ?>" />
    <input type="submit" value="&nbsp; &nbsp; Cari &nbsp; &nbsp;" /><?php
    
	if ($c != "")
	{ ?>
		
        &nbsp;<a href="index.php?p=<?php echo enkripsi($p); ?>" style="font-size:12px;">Reset</a><?php
     
	} ?>
    
</form>

<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th>Nip</th>
			<th width="15%">Nama</th>
			<th width="12%">Unit Kerja</th>
			<th width="12%">Eselon</th>
			<th width="12%">Alamat</th>
			<th width="12%">Telepon</th>
			<th colspan="2" width="6%" nowrap="nowrap">
            	<a href="index.php?p=<?php echo enkripsi($addlink); ?>"><img src="css/images/add-icon.png" width="16" height="16" /> Tambah</a>
            </th>
		</tr>
	</thead>
	<tbody><?php
		
		if ($nlist == 0)
		{ ?>
			
            <tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
		
		}
		
		else
		{
			$i = 0;
			
			while ($list = mysql_fetch_array($olist))
			{	
				$id[$i]			= $list['nip'];
				$nama[$i]		= $list['nama'];
				$unit[$i]		= $list['nmunit'];
				$eselon[$i]		= $list['eselon'];
				$alamat[$i]		= $list['alamat'];
				$telepon[]		= $list['telepon'];
				
				$i++;
			}
			
			foreach ($id as $i => $col)
			{
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($limit * ($h - 1)) + $i + 1; ?></td>
					<td><?php echo $id[$i]; ?></td>
					<td><?php echo $nama[$i]; ?></td>
					<td align="center"><?php echo $unit[$i]; ?></td>
					<td align="center"><?php 
						
						switch ($eselon[$i])
						{
							case "1": echo "Eselon 1"; break;
							case "2": echo "Eselon 2"; break;
							case "3": echo "Eselon 3"; break;
							case "4": echo "Eselon 4"; break;
							default: echo "";
						} ?>
                    
                    </td>
					<td align="center"><?php echo $alamat[$i]; ?></td>
					<td align="center"><?php echo $telepon[$i]; ?></td>
					<td align="center">
						<a href="index.php?p=<?php echo enkripsi($edlink."&q=".$id[$i]); ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
					</td>
					<td align="center" title="Hapus">
                        <img src="css/images/stop_f2.png" border="0" width="16" height="16" 
                        onclick="del('<?php echo enkripsi($dellink."&q=".$id[$i]); ?>')">
					</td>
				</tr><?php
			
			}
		} ?>
        
	</tbody>
	<tfoot>
		<tr>
			<td colspan="9"><?php 
				
				if ($pagination == "") echo "&nbsp;";
				else echo $pagination; ?>
            
            </td>
		</tr>
	</tfoot>
</table>