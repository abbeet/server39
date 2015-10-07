<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	//$addlink	= 66;
	//$edlink 	= 56;
	$dellink	= 103;
	$beritakeluarviewlink = 79;
	$disposisiviewlink = 80;
	$beritamasukviewlink = 81;
	$memoviewlink = 82;
	
	if (@$_POST['c'])
	{
		$sql = sql_select("berita", "*", "Penerima = '".$susername."' AND Perihal LIKE '%".$c."%'", "WaktuKirim DESC");
	}
	
	else
	{
		$sql = sql_select("berita", "*", "Penerima = '".$susername."'", "WaktuKirim DESC");
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
<form name="form1" method="post" action="index.php?p=<?php echo enkripsi($p."&q=".$q); ?>">
| <a href="javascript:javascript:(function(){function checkFrames(w) {try {var inputs = w.document.getElementsByTagName('input');for (var i=0; i < inputs.length; i++) {if (inputs[i].type &#038;& inputs[i].type == 'checkbox'){inputs[i].checked = !inputs[i].checked;}}} catch (e){}if(w.frames &#038;& w.frames.length>0){for(var i=0;i<w .frames.length;i++){var fr=w.frames[i];checkFrames(fr);}}}checkFrames(window);})()">Toggle all</w></a>
|          
<input name="delete" type="submit" id="delete" value="Delete"> 
<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th width="2%"><strong>Cek</strong></th>
            <th width="15%"><strong>Asal Surat</strong></th>
            <th><strong>Perihal</strong></th>
            <th><strong>Tgl. Kirim</strong></th>
			<th colspan="2" width="6%" nowrap="nowrap">
            	Aksi
            </th>
		</tr>
	</thead>
	<tbody><?php
		
		if ($nlist == 0)
		{ ?>
			
            <tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		
		}
		
		else
		{
			$i = 0;
			
			while ($list = mysql_fetch_array($olist))
			{
				$id[$i]				= $list['IdBerita'];
				$perihal[$i]		= $list['Perihal'];
				$nosurat[$i]		= $list['NoSurat'];
				$statusberita[$i]	= $list['StatusBerita'];
				$pengirim[$i]		= $list['Pengirim'];
				$waktukirim[$i]		= $list['WaktuKirim'];
				
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($i + 1); ?></td>
					<td align="center"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $id[$i] ; ?>"></td>
					<td><?php	switch($statusberita[$i]) {
						case 0:
							?>
                            <a href="index.php?p=<?php echo enkripsi($beritakeluarviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Surat Baru !">
							<img src="images/message_outbox.gif" border="0"  /> 
					  		</a>
                            <?php
							break;
						case 1:
							?>
                       		<a href="index.php?p=<?php echo enkripsi($beritamasukviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Surat Telah dibaca !">
							<img src="images/messaging.png" border="0" /> 
					  		</a>
                            <?php
							break;
						case 2:
							?>
                       		<a href="index.php?p=<?php echo enkripsi($beritamasukviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Disposisi Surat Baru !">
							<img src="images/new_message_disposisi.png" border="0"   /> 
					  		</a>
                            <?php
							break;
						case 3:
							?>
                       		<a href="index.php?p=<?php echo enkripsi($disposisiviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Catat Disposisi Surat Baru !">
							<img src="images/new_message_disposisi.png" border="0"   /> 
					  		</a>
                            <?php
							break;
						case 4:
							?>
                       		<a href="index.php?p=<?php echo enkripsi($memoviewlink."&q=".$id[$i]); ?>" title="Memo Baru !">
							<img src="images/message_outbox.gif" border="0"   /> 
					  		</a>
                            <?php
							break;
						case 5:
							?>
                       		<a href="index.php?p=<?php echo enkripsi($beritamasukviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Surat Telah dibaca !">
							<img src="images/message_disposisi.png" border="0" /> 
					  		</a>
                            <?php
							break;
							
					}
				    ?>
                  <?=GetNama($pengirim[$i]) ?> </td>
                  <td>
                  <?=$perihal[$i] ?>
                </td>
                <td>
                  <?=ViewDateTimeFormat($waktukirim[$i] , 2)?>
               </td>
					<td  align="center">
				<?php	if ($statusberita[$i] == 0 ) {
					?><a href="index.php?p=<?php echo enkripsi($beritakeluarviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Lihat">
							<img src="css/images/view.gif" border="0" width="16" height="16" /> 
					  </a>
					<?php
						} else if ($statusberita[$i] == 3 ) {
					?><a href="index.php?p=<?php echo enkripsi($disposisiviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Lihat">
							<img src="css/images/view.gif" border="0" width="16" height="16" /> 
					  </a>
                     <?php
						} else {
					?><a href="index.php?p=<?php echo enkripsi($beritamasukviewlink."&q=".$nosurat[$i]."&r=".$id[$i]); ?>" title="Lihat">
							<img src="css/images/view.gif" border="0" width="16" height="16" /> 
					  </a>
                     <?php
						} ?> 
                    </td>
                    <td align="center" title="Hapus">
                        <img src="css/images/stop_f2.png" border="0" width="16" height="16" 
                        onclick="del('<?php echo enkripsi($dellink."&q=".$id[$i]); ?>')">
					</td>
                    
                   
					
				</tr><?php
				
				$i++;
			}
		} ?>
        
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7"><?php 
				
				if ($pagination == "") echo "&nbsp;";
				else echo $pagination; ?>
            
            </td>
		</tr>
	</tfoot>
</table>
<?php

 
$checkbox = $_POST['checkbox'];
$delete = $_POST['delete'];

if($delete){
for($i=0;$i<$totpages;$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM berita WHERE IdBerita='". $del_id."'";
$result = mysql_query($sql);
}
if($result){
echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($p."&q=".$q)."\">";
}
}
mysql_close();
?>
</form>