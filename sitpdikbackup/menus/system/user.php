<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	$addlink	= "65"."&h=".$h;
	$edlink 	= "52"."&h=".$h;
	$dellink	= "53"."&h=".$h;
	$reslink 	= "54"."&h=".$h;
	
	$adjacents 	= 3;
	
	if ($slevel == "DEV")
	{
		if (@$_POST['c'])
		{	
			$sql = sql_select("xuser u LEFT OUTER JOIN xuserlevel ul ON u.username = ul.username LEFT JOIN xlevel l ON ul.level = l.kode LEFT JOIN unit un ON
			 u.unit = un.kdunit LEFT JOIN pegawai p ON u.username = p.nip", "u.username, u.email, u.lastlogin, u.aktif, l.name, un.nmunit, p.nama", 
			 "u.username LIKE '%".$c."%'", "ul.level");
		}
		
		else
		{
			$sql = sql_select("xuser u LEFT OUTER JOIN xuserlevel ul ON u.username = ul.username LEFT JOIN xlevel l ON ul.level = l.kode LEFT JOIN unit un ON
			 u.unit = un.kdunit LEFT JOIN pegawai p ON u.username = p.nip", "u.username, u.email, u.lastlogin, u.aktif, l.name, un.nmunit, p.nama", "", 
			 "ul.level");
		}
	}
	
	else
	{
		if (@$_POST['c'])
		{	
			$sql = sql_select("xuser u LEFT OUTER JOIN xuserlevel ul ON u.username = ul.username LEFT JOIN xlevel l ON ul.level = l.kode LEFT JOIN unit un ON
			 u.unit = un.kdunit LEFT JOIN pegawai p ON u.username = p.nip", "u.username, u.email, u.lastlogin, u.aktif, l.name, un.nmunit, p.nama", "u.unit 
			 LIKE '".substr($sunit, 0, 5)."%' AND u.username LIKE '%".$c."%' AND ul.level NOT LIKE 'DEV'", "ul.level");
		}
		
		else
		{
			$sql = sql_select("xuser u LEFT OUTER JOIN xuserlevel ul ON u.username = ul.username LEFT JOIN xlevel l ON ul.level = l.kode LEFT JOIN unit un ON
			 u.unit = un.kdunit LEFT JOIN pegawai p ON u.username = p.nip", "u.username, u.email, u.lastlogin, u.aktif, l.name, u.unit, p.nama", "u.unit LIKE		
			  '".substr($sunit, 0, 5)."%' AND ul.level NOT LIKE 'DEV'", "ul.level");
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
			<th>Nama Pengguna</th>
			<th width="15%">Nama</th>
			<th width="12%">Unit Kerja</th>
			<th width="12%">Level Akses</th>
			<th width="12%">Email</th>
			<th width="12%">Login Terakhir</th>
			<th width="6%">Aktif</th>
			<th colspan="3" width="6%" nowrap="nowrap">
            	<a href="index.php?p=<?php echo enkripsi($addlink); ?>"><img src="css/images/add-icon.png" width="16" height="16" /> Tambah</a>
            </th>
		</tr>
	</thead>
	<tbody><?php
		
		if ($nlist == 0)
		{ ?>
			
            <tr><td align="center" colspan="11">Tidak ada data!</td></tr><?php
		
		}
		
		else
		{
			$i 			= 0;
			$flag_id	= "";
			
			while ($list = mysql_fetch_array($olist))
			{
				if ($flag_id != $list['username'])
				{
					if ($i > 0)
					{	
						$levname[$i - 1] 	= implode(", ", $levelname);
						$levelname 			= array();
					}
					
					$id[$i]			= $list['username'];
					$unit[$i]		= $list['nmunit'];
					$email[$i]		= $list['email'];
					$login[$i]		= $list['lastlogin'];
					$aktif[$i]		= $list['aktif'];
					$levelname[]	= $list['name'];
					$namapegawai[]	= $list['nama'];
					
					$i++;
				}
				
				else
				{
					if (!in_array($list['levelname'], $levelname)) $levelname[] = $list['levelname'];
				}
				
				$flag_id	= $list['username'];
			}
			
			$levname[$i - 1] = implode(", ", $levelname);
			
			foreach ($id as $i => $col)
			{
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($limit * ($h - 1)) + $i + 1; ?></td>
					<td><?php echo $id[$i]; ?></td>
					<td><?php echo $namapegawai[$i]; ?></td>
					<td align="center"><?php echo $unit[$i]; ?></td>
					<td align="center"><?php echo $levname[$i]; ?></td>
					<td align="center"><?php echo $email[$i]; ?></td>
					<td align="center"><?php echo $login[$i]; ?></td>
					<td align="center"><?php 
						
						if ($aktif[$i] == 1)
						{ ?>
							
                            <img src="css/images/tick.png" border="0" width="16" height="16"><?php
						
						}
						
						else
						{ ?>
							
                            <img src="css/images/cancel_f2.png" border="0" width="16" height="16"><?php
						
						} ?>
					
                    </td>
					<td align="center">
						<a href="index.php?p=<?php echo enkripsi($reslink."&q=".$id[$i]); ?>" title="Reset Password">
							<img src="css/images/icon-16-config.png" border="0" width="16" height="16">
						</a>
					</td>
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
			<td colspan="11"><?php 
				
				if ($pagination == "") echo "&nbsp;";
				else echo $pagination; ?>
            
            </td>
		</tr>
	</tfoot>
</table>