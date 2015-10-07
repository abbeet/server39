<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	
	
	if (@$_POST['c']) $c = @$_POST['c'];
	else $c = ekstrak_get(@$get[2]);
	
	$addlink	= "65"."&h=".$h;
	$edlink 	= "52"."&h=".$h;
	$dellink	= "53"."&h=".$h;
	$reslink 	= "54"."&h=".$h;
	
	$adjacents 	= 3;
	
	if ($slevel == "DEV")
	{
		if ($c != "")
		{	
			$sql = sql_select("xuser_pegawai u LEFT OUTER JOIN xlevel l ON u.level = l.kode LEFT JOIN unit un ON u.unit = un.kdunit", "u.username, u.nama, 
			u.email, u.lastlogin, u.aktif, l.name, un.nmunit", "u.username LIKE '%".$c."%'", "u.level");
		}
		
		else
		{
			$sql = sql_select("xuser_pegawai u LEFT OUTER JOIN xlevel l ON u.level = l.kode LEFT JOIN unit un ON u.unit = un.kdunit", "u.username, u.nama, 
			u.email, u.lastlogin, u.aktif, l.name, un.nmunit", "", "u.level");
		}
	}
	
	else
	{
		if ($c != "")
		{	
			$sql = sql_select("xuser_pegawai u LEFT OUTER JOIN xlevel l ON u.level = l.kode LEFT JOIN unit un ON u.unit = un.kdunit", "u.username, u.nama, 
			u.email, u.lastlogin, u.aktif, l.name, un.nmunit", "u.unit LIKE '".substr($sunit, 0, 5)."%' AND u.username LIKE '%".$c."%' AND u.level NOT LIKE 
			'DEV'", "u.level");
		}
		
		else
		{
			$sql = sql_select("xuser_pegawai u LEFT OUTER JOIN xlevel l ON u.level = l.kode LEFT JOIN unit un ON u.unit = un.kdunit", "u.username, u.nama, 
			u.email, u.lastlogin, u.aktif, l.name, un.nmunit", "u.unit LIKE	'".substr($sunit, 0, 5)."%' AND u.level NOT LIKE 'DEV'", "u.level");
		}
	}
	
	#echo $sql."<BR>";
	
	$olist = mysql_query($sql) or die(mysql_error());
	$totpages = mysql_num_rows($olist);
	
	$targetpage = "index.php?p=";
	$limit = 15;
	
	if ($h) $start = ($h - 1) * $limit;
	else $start = 0;
	
	$sql .= " LIMIT ".$start.", ".$limit;
	
	#echo $sql."<BR>";
	
	$olist = mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($olist);
	
	if ($h == 0) $h = 1;
	$prev = $h - 1;
	$next = $h + 1;
	$lastpage = ceil($totpages/$limit);
	$lpm1 = $lastpage - 1;
 
	$pagination = "";
	
	#echo $c."<BR>";
	
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		
		if ($h > 1) $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$prev."&c=".$c)."\"><< Sebelumnya</a>";
		else $pagination.= "<span class=\"disabled\"><< Sebelumnya</span>";
		
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
				else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter."&c=".$c)."\">".$counter."</a>";
			}
		}
		
		elseif ($lastpage > 5 + ($adjacents * 2))
		{
			if ($h < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
					else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter."&c=".$c)."\">".$counter."</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lpm1."&c=".$c)."\">".$lpm1."</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lastpage."&c=".$c)."\">".$lastpage."</a>";
			}
			
			elseif ($lastpage - ($adjacents * 2) > $h && $h > ($adjacents * 2))
			{
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=1"."&c=".$c)."\">1</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=2"."&c=".$c)."\">2</a>";
				$pagination.= "...";
				
				for ($counter = $h - $adjacents; $counter <= $h + $adjacents; $counter++)
				{
					if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
					else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter."&c=".$c)."\">".$counter."</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lpm1."&c=".$c)."\">".$lpm1."</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$lastpage."&c=".$c)."\">".$lastpage."</a>";
			}
			
			else
			{
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=1"."&c=".$c)."\">1</a>";
				$pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=2"."&c=".$c)."\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $h) $pagination.= "<span class=\"current\">".$counter."</span>";
					else $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$counter."&c=".$c)."\">".$counter."</a>";
				}
			}
		}
		
		if ($h < $counter - 1)  $pagination.= "<a href=\"".$targetpage.enkripsi($p."&h=".$next."&c=".$c)."\">Selanjutnya >></a>";
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
<?php

	if ($pagination == "") echo "&nbsp;";
	else echo $pagination;
				
?>
<br />
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
			$i = 0;
			
			while ($list = mysql_fetch_array($olist))
			{
				$id[$i]			= $list['username'];
				$namapegawai[]	= $list['nama'];
				$unit[$i]		= $list['nmunit'];
				$email[$i]		= $list['email'];
				$login[$i]		= $list['lastlogin'];
				$aktif[$i]		= $list['aktif'];
				$levelname[]	= $list['name'];
				
				$i++;
			}
			
			foreach ($id as $i => $col)
			{
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($limit * ($h - 1)) + $i + 1; ?></td>
					<td><?php echo $id[$i]; ?></td>
					<td><?php echo $namapegawai[$i]; ?></td>
					<td align="center"><?php echo $unit[$i]; ?></td>
					<td align="center"><?php echo $levelname[$i]; ?></td>
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