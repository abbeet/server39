<?php
	checkauthentication();
	$q = ekstrak_get(@$get[1]);
	$c = @$_POST['c'];
	
	$edlink = 33;
	
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

<form name="cari" method="post" action="index.php?p=<?php echo enkripsi($p."&q=".$q); ?>" >

	<img src="css/images/view.gif" border="0" width="16" height="16" />
    <input type="text" name="c" size="40" value="<?php echo @$c; ?>" />
    <input type="submit" value="&nbsp; &nbsp; Cari &nbsp; &nbsp;" />
	
    <font style="font-size:12px;"><?php
    
		$omenu	= xmenu("id, name, parent, src", "id = '".$q."'");
		$xmenu 	= mysql_fetch_array($omenu);
		$pagination = "";
		
		if ($q != "")
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
<a href="index.php?p=<?php echo enkripsi($edlink); ?>"><img src="css/images/add-icon.png" width="16" height="16" /> Tambah</a>
<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th>No.Surat-Tgl Surat</th>
			<th>Asal Surat</th>
			<th width="10%">Perihal</th>
			<th width="6%">Tgl Input</th>
			<th width="6%">Kepada</th>
		
			
			<th colspan="2" width="6%" nowrap="nowrap">
            	
            </th>
		</tr>
	</thead>
	<tbody><?php
		
		if ($q == "") $parent = "IS NULL";
		else $parent = " = '".$q."'";
		
		if (@$_POST['c'])
		{
			$sql = sql_select("xmenu m, xmenutype mt, xposition p, xmenulevel ml, xlevel l", "m.id, m.name AS menuname, m.title, m.parent, m.published, 
			m.src, m.ordering, p.name AS positionname, l.name AS levelname", "m.id = mt.menu AND mt.type = p.kode AND m.id = ml.menu AND ml.level = l.kode 
			AND (m.id LIKE '%".$c."%' OR m.name LIKE '%".$c."%' OR m.title LIKE '%".$c."%')", "m.id, m.ordering, p.name, l.name");
		}
		
		else
		{
			$sql = sql_select("xmenu m, xmenutype mt, xposition p, xmenulevel ml, xlevel l", "m.id, m.name AS menuname, m.title, m.parent, m.published, 
			m.src, m.ordering, p.name AS positionname, l.name AS levelname", "m.id = mt.menu AND mt.type = p.kode AND m.id = ml.menu AND ml.level = l.kode 
			AND m.parent ".$parent, "m.id, m.ordering, p.name, l.name");
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
					$parent[$i]		= $list['parent'];
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
					<td align="center"><?php echo $parent[$i]; ?></td>
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
		
					
					<td align="center">
						<a href="index.php?p=<?php echo enkripsi($edlink."&q=".$id[$i]); ?>" title="Ubah">
							<img src="css/images/view.gif"" border="0" width="16" height="16">
						</a>
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