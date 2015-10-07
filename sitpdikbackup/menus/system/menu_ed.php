<?php
	checkauthentication();
	$table = "xmenu";
	$field = get_field($table);
	
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get(@$get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
	
	if (@$_POST['xmenu']) 
	{	
		extract($_POST);
		
		foreach ($field as $k=>$val) 
		{
			$value[$k] = $$val;
		}
		
		if ($id == "") 
		{				
			$sql 	= sql_insert($table, $field, $value);
			$sql 	= str_replace("''", "NULL", $sql);
			$query 	= mysql_query($sql);
			
			if ($query == 1)
			{
				$id 	= mysql_insert_id();
				$msg	= "Tambah menu berhasil. Id = ".$id.".";
				
				$oposition = xposition("kode");
				$nposition = mysql_num_rows($oposition);
				
				if ($nposition > 0)
				{
					while ($xposition = mysql_fetch_array($oposition))
					{
						$val = @$$xposition['kode'];
						
						if ($val != "")
						{
							$field 	= get_field("xmenutype");
							$value 	= array("", $id, $val);
							
							$sql	= sql_insert("xmenutype", $field, $value);
							$query2	= mysql_query($sql);
							
							if ($query2 <> 1) $msg .= " Tambah menu type gagal. Error = ".mysql_error().".";
						}
					}
				}
				
				$olevel = xlevel("kode");
				$nlevel = mysql_num_rows($olevel);
				
				if ($nlevel > 0)
				{
					while ($xlevel = mysql_fetch_array($olevel))
					{
						$val = "level_".$xlevel['kode'];
						$val = @$$val;
						
						if ($val != "")
						{
							$field 	= get_field("xmenulevel");
							$value 	= array("", $id, $val);
							
							$sql	= sql_insert("xmenulevel", $field, $value);
							$query3	= mysql_query($sql);
							
							if ($query3 <> 1) $msg .= " Tambah menu level gagal. Error = ".mysql_error().".";
						}
					}
				}
				
				update_log($msg, $table, $susername, 1);
				$_SESSION['errmsg'] = $msg;
			}
			
			else 
			{
				$msg = "Tambah menu gagal. Error = ".mysql_error().".";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;
			}
		} 
		
		else 
		{
			$sql 	= sql_update($table, $field, $value);
			$sql	= str_replace("''", "NULL", $sql);
			$query	= mysql_query($sql);
			
			if ($query == 1) 
			{
				$msg = "Ubah menu berhasil. Id = ".$id.".";
				
				$oposition = xposition("kode");
				$nposition = mysql_num_rows($oposition);
				
				if ($nposition > 0)
				{
					while ($xposition = mysql_fetch_array($oposition))
					{
						$val = @$$xposition['kode'];
						
						$ocheck = xmenutype("id", "menu = '".$id."' AND type = '".$xposition['kode']."'");
						$ncheck = mysql_num_rows($ocheck);
						
						if ($ncheck > 0)
						{
							$check = mysql_fetch_array($ocheck);
							
							if ($val == "")
							{
								$sql 	= sql_delete("xmenutype", "id", $check['id']);
								$query2	= mysql_query($sql);
								
								if ($query2 <> 1) $msg .= " Ubah menu type gagal. Error = ".mysql_error().".";
							}
						}
						
						else
						{
							if ($val != "")
							{
								$field 	= get_field("xmenutype");
								$value 	= array("", $id, $val);
								
								$sql 	= sql_insert("xmenutype", $field, $value);
								$query3 = mysql_query($sql);
								
								if ($query3 <> 1) $msg .= " Ubah menu type gagal. Error = ".mysql_error().".";
							}
						}
					}
				}
				
				$olevel = xlevel("kode");
				$nlevel = mysql_num_rows($olevel);
				
				if ($nlevel > 0)
				{
					while ($xlevel = mysql_fetch_array($olevel))
					{
						$val = "level_".$xlevel['kode'];
						$val = @$$val;
						
						$ocheck = xmenulevel("id", "menu = '".$id."' AND level = '".$xlevel['kode']."'");
						$ncheck = mysql_num_rows($ocheck);
						
						if ($ncheck > 0)
						{
							$check = mysql_fetch_array($ocheck);
							
							if ($val == "")
							{
								$sql 	= sql_delete("xmenulevel", "id", $check['id']);
								$query2	= mysql_query($sql);
								
								if ($query2 <> 1) $msg .= " Ubah menu level gagal. Error = ".mysql_error().".";
							}
						}
						
						else
						{
							if ($val != "")
							{
								$field 	= get_field("xmenulevel");
								$value 	= array("", $id, $val);
								
								$sql 	= sql_insert("xmenulevel", $field, $value);
								$query3 = mysql_query($sql);
								
								if ($query3 <> 1) $msg .= " Ubah menu level gagal. Error = ".mysql_error().".";
							}
						}
					}
				}
				
				update_log($msg, $table, $susername, 1);
				$_SESSION['errmsg'] = $msg;
			}
			
			else 
			{
				$msg = "Ubah menu gagal. Error = ".mysql_error().".";
				update_log($msg, $table, $susername, 0);
				$_SESSION['errmsg'] = $msg;			
			}
		} ?>
			
        <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next."&q=".$parent); ?>"><?php
        
        exit();
	} 
	
	else if ($q != "") 
	{
		$sql = sql_select("xmenu m LEFT JOIN xmenutype mt ON m.id = mt.menu LEFT JOIN xmenulevel ml ON m.id = ml.menu", "m.id, m.name, m.title, m.parent, 
		m.published, m.src, m.ordering, mt.type, ml.level", "m.id = '".$q."'", "m.ordering");
		
		$olist = mysql_query($sql) or die(mysql_error());
		$nlist = mysql_num_rows($olist);
		
		if ($nlist > 0)
		{
			$flag_posname = "";
			$flag_levname = "";
			$positionname 	= array();
			$levelname 		= array();
			
			while ($list = mysql_fetch_array($olist))
			{
				$id 		= $list['id'];
				$menuname	= $list['name'];
				$judul 		= $list['title'];
				$parent 	= $list['parent'];
				$published 	= $list['published'];
				$src 		= $list['src'];
				$ordering 	= $list['ordering'];
				
				if ($flag_posname != $list['type']) 	$positionname[] = $list['type'];
				if ($flag_levname != $list['level'])	$levelname[]	= $list['level'];
			}
		}
		
		else
		{
			$id 			= "";
			$menuname 		= "";
			$judul 			= "";
			$parent 		= "";
			$published 		= "";
			$src 			= "";
			$ordering 		= "";
			$positionname 	= array();
			$levelname 		= array();
		}
	}
	
	else 
	{
		$id 			= "";
		$menuname 		= "";
		$judul 			= "";
		$parent 		= "";
		$published 		= "";
		$src 			= "";
		$ordering 		= "";
		$positionname 	= array();
		$levelname 		= array();
	}
?>

<form method="post" name="xmenu">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="name" size="40" value="<?php echo $menuname; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Judul</td>
			<td><input type="text" name="title" size="40" value="<?php echo $judul; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Tipe</td>
			<td><?php
            	
				$oposition = xposition("kode, name");
				$nposition = mysql_num_rows($oposition);
				
				if ($nposition > 0)
				{
					while ($xposition = mysql_fetch_array($oposition))
					{ ?>
						
						<input type="checkbox" name="<?php echo $xposition['kode']; ?>" value="<?php echo $xposition['kode']; ?>" <?php 
						if (in_array($xposition['kode'], $positionname)) echo "checked=\"checked\""; ?>><?php echo $xposition['name']; ?>&nbsp;<?php
					 
					}
				}
				
				else echo "&nbsp;"; ?>
			
            </td>
		</tr>
		<tr>
			<td class="key">Parent ID</td>
			<td>
				<select name="parent" size="9">
					<option value="" <?php if ($parent == "") echo "selected"; ?>></option><?php	
					
					$oparentid = select_parent("NOT LIKE 'submenu'");
					$nparentid = mysql_num_rows($oparentid);
					
					if ($nparentid > 0)
					{
						$i 		= 1;
						$flag	= "";
						
						while ($parentid = mysql_fetch_array($oparentid)) 
						{
							if ($flag != $parentid['id'])
							{ ?>
							
								<option value="<?php echo $parentid['id']; ?>" <?php if ($parentid['id'] == $parent) echo "selected";  ?>><?php 
										
									echo $i.'. '.$parentid['name']; ?>&nbsp; &nbsp;
								
								</option><?php
							
								$oparentid2 = select_parent("NOT LIKE 'submenu'",$parentid['id']);
								$nparentid2 = mysql_num_rows($oparentid2);
								
								if ($nparentid2 > 0)
								{
									$j 		= 1;
									$flag2 	= "";
									
									while ($parentid2 = mysql_fetch_array($oparentid2)) 
									{
										if ($flag2 != $parentid2['id'])
										{ ?>
										
											<option value="<?php echo $parentid2['id']; ?>" <?php if ($parentid2['id'] == $parent) echo "selected"; ?>>
												
												&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $j.'. '.$parentid2['name']; ?>&nbsp; &nbsp;
												
											</option><?php
										
											$oparentid3 = select_parent("NOT LIKE 'submenu'",$parentid2['id']);
											$nparentid3 = mysql_num_rows($oparentid3);
											
											if ($nparentid3 > 0)
											{
												$k 		= 1;
												$flag3 	= "";
												
												while ($parentid3 = mysql_fetch_array($oparentid3)) 
												{
													if ($flag3 != $parentid3['id'])
													{ ?>
												
														<option value="<?php echo $parentid3['id']; ?>" <?php if ($parentid3['id'] == $parent) 
														echo "selected"; ?>>
														
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $k.'. '.$parentid3['name']; ?>
                                                            &nbsp; &nbsp;
															
														</option><?php
													
														$oparentid4 = select_parent("NOT LIKE 'submenu'",$parentid3['id']);
														$nparentid4 = mysql_num_rows($oparentid4);
														
														if ($nparentid4 > 0)
														{
															$l 		= 1;
															$flag4	= "";
															
															while ($parentid4 = mysql_fetch_array($oparentid4)) 
															{
																if ($flag4 != $parentid4['id'])
																{ ?>
															
																	<option value="<?php echo $parentid4['id']; ?>" <?php if ($parentid4['id'] == $parent) 
																	echo "selected" ?>>
																		
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $l.'. '.
																		$parentid4['name']; ?>&nbsp; &nbsp;
																		
																	</option><?php
																	
																	$l++;
																
																}
																
																$flag4 = $parentid4['id'];
															}
														}
														
														$k++;
													}
													
													$flag3 = $parentid3['id'];
												}
											}
											
											$j++;
										}
										
										$flag2 = $parentid2['id'];
									}
								}
								
								$i++;
							}
							
							$flag = $parentid['id'];
						}
					} ?>
					
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Tampil</td>
			<td>
				<input type="radio" name="published" value="1" <?php if ($published == 1) echo "checked=\"checked\""; ?>/>Ya&nbsp;
				<input type="radio" name="published" value="0" <?php if ($published == 0) echo "checked=\"checked\""; ?>/>Tidak
			</td>
		</tr>
		<tr>
			<td class="key">Level Akses</td>
			<td><?php
				
				$olevel = xlevel("kode, name", "", "ordering");
				$nlevel = mysql_num_rows($olevel);
				
				if ($nlevel > 0)
				{
					while ($xlevel = mysql_fetch_array($olevel)) 
					{ ?>
					
						<input type="checkbox" name="level_<?php echo $xlevel['kode']; ?>" value="<?php echo $xlevel['kode']; ?>" <?php 
						if (in_array($xlevel['kode'], $levelname)) echo "checked=\"checked\""; ?> /><?php echo $xlevel['name']; ?><br /><?php
					}
				}
				
				else echo "&nbsp;"; ?>
				
			</td>
		</tr>
		<tr>
			<td class="key">Letak File</td>
			<td><input type="text" name="src" size="40" value="<?php echo $src; ?>" /></td>
		</tr>
		<tr>
			<td class="key">Urutan</td>
			<td><input type="text" name="ordering" size="5" value="<?php echo $ordering; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo enkripsi($p_next."&q=".$parent); ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="Btn_Submit('xmenu')">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
				<input type="hidden" name="xmenu" value="1" />
`				<input type="hidden" name="id" value="<?php echo $q; ?>" />
			</td>
		</tr>
	</table>
</form>