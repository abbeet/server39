<?php
	checkauthentication();
	
	$sql = xmenu_type("LIKE '%left%'","0");
	$count = mysql_num_rows($sql);
	
?>
	<div class="dtree">
		<a href="javascript: d.openAll();">buka</a> | <a href="javascript: d.closeAll();">tutup</a><br /><br />
		<script type="text/javascript">
			d = new dTree('d');                                    
			d.add(0,-1,'Menu');<?php
			
			if ($count != 0) {
				while ($leftmenu = mysql_fetch_object($sql)) {					
					$sql2 = xmenu_type("LIKE '%left%'",$leftmenu->id);
					$count2 = mysql_num_rows($sql2);
					
					if ($count2 == 0) { ?>
						d.add(<?php echo $leftmenu->id ?>,<?php echo $leftmenu->parent ?>,'<?php echo $leftmenu->name ?>','index.php?p=<?php echo $leftmenu->id ?>');<?php
					}
					else { ?>
						d.add(<?php echo $leftmenu->id ?>,<?php echo $leftmenu->parent ?>,'<?php echo $leftmenu->name ?>');<?php
						
						while ($leftmenu2 = mysql_fetch_object($sql2)) {							
							$sql3 = xmenu_type("LIKE '%left%'",$leftmenu2->id);
							$count3 = mysql_num_rows($sql3);
							
							if ($count3 == 0) { ?>
								d.add(<?php echo $leftmenu2->id ?>,<?php echo $leftmenu2->parent ?>,'<?php echo $leftmenu2->name ?>','index.php?p=<?php echo $leftmenu2->id ?>');<?php
							}
							else { ?>
								d.add(<?php echo $leftmenu2->id ?>,<?php echo $leftmenu2->parent ?>,'<?php echo $leftmenu2->name ?>');<?php
								
								while ($leftmenu3 = mysql_fetch_object($sql3)) {									
									$sql4 = xmenu_type("LIKE '%left%'",$leftmenu3->id);
									$count4 = mysql_num_rows($sql4);
									
									if ($count4 == 0) { ?>
										d.add(<?php echo $leftmenu3->id ?>,<?php echo $leftmenu3->parent ?>,'<?php echo $leftmenu3->name ?>','index.php?p=<?php echo $leftmenu3->id ?>');<?php
									}
								}
							}
						}
					}
				}
			} ?>
			document.write(d); 
		</script>                       
	</div>