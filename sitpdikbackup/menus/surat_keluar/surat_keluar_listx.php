<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	$addlink	= 33;
	$edlink 	= 78;
	//$dellink	= 63;
	
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
	
	if (@$_POST['c'])
	{
		$sql = sql_select("suratkeluar", "*", "TujuanSurat LIKE '%".$c."%' OR Perihal LIKE '%".$c."%' OR NoSurat LIKE '%".$c."%'" , "IdSuratKeluar");
	}
	
	else
	{
		$sql = sql_select("suratkeluar", "*", "AsalSurat = '$usernamex'", "IdSuratKeluar");
	}
	
	$olist = mysql_query($sql) or die(mysql_error());
	$totpages = mysql_num_rows($olist);
	
	$targetpage = "index.php?p=";
	$limit = 10;
	
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
    <input type="submit" value="&nbsp; &nbsp; Cari &nbsp; &nbsp;" />
</form>
<?php 
$tes = mysql_query("select unit from xuser where username = 'admintu dirjenbud'");
$tesx = mysql_fetch_object($tes);
//echo $tesx;

?>
<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="7%">#</th>
			<th width="16%"><span class="tableheader"><strong>No. Surat</strong><br />
            <strong>Tgl. Surat</strong></span></th>
			<th width="10%"><span class="tableheader"><strong>Asal Surat</strong></span></th>
            <th width="21%"><strong>Perihal</strong></th>
            <th width="13%"><span class="tableheader"><strong>Tgl. Input</strong></span></th>
             <th width="16%"><strong>Kepada</strong></th>
			<th>
            	<a href="index.php?p=<?php echo enkripsi($addlink); ?>"><img src="css/images/add-icon.png" width="16" height="16" /> Tambah</a>
          </th>
		</tr>
	</thead>
	<tbody><?php
		
		if ($nlist == 0)
		{ ?>
			
            <tr><td align="center" colspan="8">Tidak ada data!</td></tr><?php
		
		}
		
		else
		{
			$i = 0;
			
			while ($list = mysql_fetch_array($olist))
			{
				$id[$i]			= $list['IdSuratKeluar'];
				$nosurat[$i]		= $list['NoSurat'];
				$asal[$i]	= $list['AsalSurat'];
				$perihal[$i]	= $list['Perihal'];
				$tgl[$i]	= $list['WaktuBuat'];
				$tujuan[$i]	= $list['TujuanSurat'];
				
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($i + 1); ?></td>
					<td align="center"><?php echo $nosurat[$i]; ?></td>
					<td><?php echo $asal[$i]; ?></td>
                    <td><?php echo $perihal[$i]; ?></td>
                     <td><?php echo $tgl[$i]; ?></td>
                      <td><?php echo $tujuan[$i]; ?></td>
					<td width="17%" align="center">
						<a href="index.php?p=<?php echo enkripsi($edlink."&q=".$id[$i]); ?>" title="view">
							<img src="css/images/view.gif"" border="0" width="16" height="16">
						</a>
					</td>
					
				</tr><?php
				
				$i++;
			}
		} ?>
        
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8"><?php 
				
				if ($pagination == "") echo "&nbsp;";
				else echo $pagination; ?>
            
            </td>
		</tr>
	</tfoot>
</table>