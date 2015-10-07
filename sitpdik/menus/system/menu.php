<?php
	checkauthentication();
	$h = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	$addlink	= "64"."&h=".$h;
	$edlink 	= "4"."&h=".$h;
	$dellink	= "5"."&h=".$h;
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

<form name="cari" method="post" action="index.php?p=<?php echo enkripsi($p); ?>">
	<img src="css/images/view.gif" border="0" width="16" height="16" />
    <input type="text" name="c" size="40" value="<?php echo @$c; ?>" />
    <input type="submit" value="&nbsp; &nbsp; Cari &nbsp; &nbsp;" />
	
    <font style="font-size:12px;"><?php
    
		$omenu	= xmenu("id, name, parent, src", "id = '".$h."'");
		$xmenu 	= mysql_fetch_array($omenu);
		$pagination = "";
		
		if ($h != "")
		{
			$id2 = $xmenu['id'];
			
			do
			{
				$omenu2 = xmenu("id, name, parent, src", "id = '".$id2."'");
				$xmenu2 = mysql_fetch_array($omenu2);
				
				if ($xmenu2['parent'] != "")
				{
					$pagination = "<a href=\"index.php?p=".enkripsi($p."&q=".$xmenu2['parent'])."\">".$xmenu2['name']."</a>".$pagination;
				}
				else
				{
					$pagination = "<a href=\"index.php?p=".enkripsi($p)."\">".$xmenu2['name']."</a>".$pagination;
				}
				
				$parent = $xmenu2['parent'];
				$id2 = $xmenu2['parent'];
			}
			while ($parent != "");
			
			$pagination = "<div class=\"pagination\">".$pagination."</div>";
		} ?>
	
    </font>
</form>

<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th>Nama</th>
			<th>Judul</th>
			<th width="10%">Tipe</th>
			<th width="6%">Parent ID</th>
			<th width="6%">Tampil</th>
			<th width="10%">Level Akses</th>
			<th width="14%">Letak File</th>
			<th width="6%">Order</th>
			<th width="4%">id</th>
			<th colspan="2" width="6%" nowrap="nowrap">
            	<a href="index.php?p=<?php echo enkripsi($addlink); ?>"><img src="css/images/add-icon.png" width="16" height="16" /> Tambah</a>
            </th>
		</tr>
	</thead>
	<tbody><?php
		
		if ($h == "") $parent = "IS NULL";
		else $parent = " = '".$h."'";
		
		if (@$_POST['c'])
		{
			$sql = sql_select("xmenu m LEFT OUTER JOIN xmenutype mt ON m.id = mt.menu LEFT JOIN xposition p ON mt.type = p.kode LEFT OUTER JOIN 
			xmenulevel ml ON m.id = ml.menu LEFT JOIN xlevel l ON ml.level = l.kode", "m.id, m.name AS menuname, m.title, m.parent, m.published, m.src,
			m.ordering, p.name AS positionname, l.name AS levelname", "m.id LIKE '%".$c."%' OR m.name LIKE '%".$c."%' OR m.title LIKE '%".$c."%'", 
			"m.ordering, p.name, l.name");
		}
		
		else
		{	
			$sql = sql_select("xmenu m LEFT OUTER JOIN xmenutype mt ON m.id = mt.menu LEFT JOIN xposition p ON mt.type = p.kode LEFT OUTER JOIN 
			xmenulevel ml ON m.id = ml.menu LEFT JOIN xlevel l ON ml.level = l.kode", "m.id, m.name AS menuname, m.title, m.parent, m.published, m.src,
			m.ordering, p.name AS positionname, l.name AS levelname", "m.parent ".$parent, "m.ordering, p.name, l.name");
		}
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist == 0)
		{ ?>
			
            <tr><td align="center" colspan="12">Tidak ada data!</td></tr><?php
		
		}
		
		else
		{
			$i 			= 0;
			$flag_id	= "";
			
			while ($list = mysql_fetch_array($olist))
			{
				if ($flag_id != $list['id'])
				{
					if ($i > 0)
					{
						$posname[$i - 1] 	= implode(", ", $positionname);
						$positionname 		= array();
						
						$levname[$i - 1] 	= implode(", ", $levelname);
						$levelname 			= array();
					}
					
					
					$id[$i]			= $list['id'];
					$menuname[$i]	= $list['menuname'];
					$judul[$i]		= $list['title'];
					
					$parent2[$i]	= $list['parent'];
					$published[$i]	= $list['published'];
					$src[$i]		= $list['src'];
					$ordering[$i]	= $list['ordering'];
					$positionname[]	= $list['positionname'];
					$levelname[]	= $list['levelname'];
					
					$i++;
				}
				
				else
				{
					if (!in_array($list['positionname'], $positionname))	$positionname[]	= $list['positionname'];
					if (!in_array($list['levelname'], $levelname)) 		$levelname[]	= $list['levelname'];
				}
				
				$flag_id	= $list['id'];
			}
			
			$posname[$i - 1] = implode(", ", $positionname);
			$levname[$i - 1] = implode(", ", $levelname);
			
			foreach ($id as $i => $col)
			{
				if ($i % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
                <tr class="<?php echo $class; ?>">
					<td align="center"><?php echo ($i + 1); ?></td>
					<td><?php
						
						$ochild = xmenu("id", "parent = '".$id[$i]."'");
						$nchild = mysql_num_rows($ochild);
						
						if ($nchild > 0)
						{ ?>
							
                            <a href="index.php?p=<?php echo enkripsi($p."&q=".$id[$i]); ?>"><?php echo $menuname[$i]; ?></a><?php
						
						}
						else echo $menuname[$i]; ?>
                    
                    </td>
					<td><?php echo $judul[$i]; ?></td>
					<td><?php echo $posname[$i]; ?></td>
					<td align="center"><?php echo $parent2[$i]; ?></td>
					<td align="center"><?php 
						
						if ($published[$i] == 1)
						{ ?>
							
                            <img src="css/images/tick.png" border="0" width="16" height="16"><?php
						
						}
						
						else
						{ ?>
							
                            <img src="css/images/cancel_f2.png" border="0" width="16" height="16"><?php
						
						} ?>
					
                    </td>
					<td><?php echo $levname[$i]; ?></td>
					<td><?php echo $src[$i]; ?></td>
					<td align="center"><?php echo $ordering[$i]; ?></td>
					<td align="center"><?php echo $id[$i]; ?></td>
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
			<td colspan="12"><?php 
				
				if ($pagination == "") echo "&nbsp;";
				else echo $pagination; ?>
            
            </td>
		</tr>
	</tfoot>
</table>