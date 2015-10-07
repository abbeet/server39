<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	$addlinksurat	= 83;
	//$beritakeluarviewlink = 78;
	//$disposisiviewlink = 79;
	$disposisisuratmasukviewlink = 94;
	//$memoviewlink = 81;
	
	$IdUser = @$_SESSION['xusername_'.$session_name];
	$KdSatker = @$_SESSION['xunit_'.$session_name]; 
	
	
	if (@$_POST['c'])
	{
		$sql = sql_select("suratmasuk", "*", "DicatatOleh = '".$KdSatker."' AND StatusDisposisi = 0 AND StatusDistribusi = 0 AND Perihal LIKE '%".$c."%'", "TglTerima DESC");
	}
	
	else
	{
		$sql = sql_select("suratmasuk", "*", "DicatatOleh = '".$KdSatker."' AND StatusDisposisi = 0 AND StatusDistribusi = 0", "TglTerima DESC");
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
  if ($_SESSION['MM__AdminRole']=="3" or $_SESSION['MM__AdminRole']=="4") {

?>
| <a href="javascript:javascript:(function(){function checkFrames(w) {try {var inputs = w.document.getElementsByTagName('input');for (var i=0; i < inputs.length; i++) {if (inputs[i].type &#038;& inputs[i].type == 'checkbox'){inputs[i].checked = !inputs[i].checked;}}} catch (e){}if(w.frames &#038;& w.frames.length>0){for(var i=0;i<w .frames.length;i++){var fr=w.frames[i];checkFrames(fr);}}}checkFrames(window);})()">Toggle all</w></a>
|          
<input name="delete" type="submit" id="delete" value="Delete"> 
<?php
  }
?>
<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th rowspan="2" width="4%">#</th>
             <?php 

  if ($_SESSION['MM__AdminRole']=="3" or $_SESSION['MM__AdminRole']=="4") {

?>
			<th width="2%"><strong>Cek</strong></th>
<?php
  }
  ?>

            <th rowspan="2" width="10%"><strong>No. Surat</strong><br>
                <strong>Tgl. Surat </strong></th>
            <th rowspan="2" width="15%"><strong>Asal Surat</strong></th>
            <th rowspan="2" width="28%"><strong>Perihal</strong></th>
            <th rowspan="2" width="9%"><strong>Tgl. Terima</strong></th>
			<th rowspan="2" width="9%"><strong>Tgl. Input</strong></th>
            <th rowspan="2" width="9%" align="center"><strong>Kepada</strong></font></th>
            <th rowspan="2" colspan="3" width="6%" nowrap="nowrap">
            	<strong>Aksi</strong>
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
				$id[$i]				= $list['IdSuratMasuk'];
				$perihal[$i]		= $list['Perihal'];
				$nosurat[$i]		= $list['NoSurat'];
				$tglsurat[$i]		= $list['TglSurat'];
				$asalsurat[$i]		= $list['AsalSurat'];
				$tglterima[$i]		= $list['TglTerima'];
				$waktubuat[$i]		= $list['WaktuBuat'];
				$tujuansurat[$i]	= $list['TujuanSurat'];
				$disposisi[$i]		= $list['Disposisi'];
				
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($i + 1); ?></td>
                     <?php 
  						if ($_SESSION['MM__AdminRole']=="3" or $_SESSION['MM__AdminRole']=="4") {
					?>
					<td align="center"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $id[$i] ; ?>"></td>
                    <?php
					  }
					 ?>
                    <td>
                  <?=$nosurat[$i] ?><br>
				  <?=ViewDateTimeFormat($tglsurat[$i], 6) ?>
                </td>
                <td>
                  <?=$asalsurat[$i] ?> 
                </td>
                <td>
                  <?=$perihal[$i] ?>
                </td>
                <td>
                  <?=ViewDateTimeFormat($tglterima[$i], 6) ?>
               </td>
			   <td>
                  <?=ViewDateTimeFormat($waktubuat[$i],2) ?>
               </td>
                <td align="center">
                  <?=$tujuansurat[$i] ?>
               </td>
             <!--  <td class="tablebody">
                  <?=$disposisi[$i] ?>
                </td>-->
                    
                    
                    
                  
					<td  align="center">
				<a href="index.php?p=<?php echo enkripsi($disposisisuratmasukviewlink."&q=".$id[$i]); ?>" title="Lihat">
							<img src="css/images/view.gif" border="0" width="16" height="16" /> 
					  </a>
                    </td>
 <?php 

  if ($_SESSION['MM__AdminRole']=="3" or $_SESSION['MM__AdminRole']=="4") {

?>                   
                    <td align="center">
						<a href="index.php?p=<?php echo enkripsi($addlinksurat."&q=".$id[$i]); ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
                       
					</td>
                    
                    <td align="center" title="Hapus">
                        <img src="css/images/stop_f2.png" border="0" width="16" height="16" 
                        onclick="del('<?php echo enkripsi($dellink."&q=".$id[$i]); ?>')">
					</td>
                    <?php
  }
					?>
                   
					
				</tr><?php
				
				$i++;
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