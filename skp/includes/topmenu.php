<?php
	checkauthentication();
	
	$sql = xmenu_type("LIKE '%top%'","0");
	$count = mysql_num_rows($sql);
	if ($count != 0) { ?>
		<ul id="menu"><?php
			while ($topmenu = mysql_fetch_object($sql)){
				$sql2 = xmenu_type("LIKE '%top%'",$topmenu->id);
				$count2 = mysql_num_rows($sql2);
				
				if ($count2 == 0) { ?>
					<li><a href="index.php?p=<?php echo $topmenu->id ?>"><?php echo $topmenu->name ?></a><?php
				}
				else { ?>
					<li class="node"><a><?php echo $topmenu->name ?></a>
						<ul style="width: 150px;"><?php
							while ($topmenu2 = mysql_fetch_object($sql2)){
								$sql3 = xmenu_type("LIKE '%top%'",$topmenu2->id);
								$count3 = mysql_num_rows($sql3);
								
								if ($count3 == 0) { ?>
									<li style="width: 150px;"><a class="icon-16-section" href="index.php?p=<?php echo $topmenu2->id ?>"><?php echo $topmenu2->name ?></a></li><?php
								}
								else { ?>
									<li style="width: 150px;" class="node"><a class="icon-16-section"><?php echo $topmenu2->name ?></a>
										<ul style="width: 150px;"><?php
											while ($topmenu3 = mysql_fetch_object($sql3)){
												$sql4 = xmenu_type("LIKE '%top%'",$topmenu3->id);
												$count4 = mysql_num_rows($sql4);
												
												if ($count4 == 0) { ?>
													<li style="width: 150px;"><a class="icon-16-category" href="index.php?p=<?php echo $topmenu3->id ?>"><?php echo $topmenu3->name ?></a></li><?php
												}
												else { ?>
													<li style="width: 150px;" class="node"><a class="icon-16-category"><?php echo $topmenu3->name ?></a>
														<ul style="width: 150px;"><?php
															while ($topmenu4 = mysql_fetch_object($sql4)) { ?>
																<li style="width: 150px;"><a href="index.php?p=<?php echo $topmenu4->id ?>"><?php $topmenu4->name ?></a></li><?php
															} ?>
														</ul>
													</li><?php
												}
											} ?>
										</ul>
									</li><?php
								}
							} ?>
						</ul>
					</li><?php
				}
			} ?>
		</ul><?php
	}
?>