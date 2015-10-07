<?php
	checkauthentication();
	
	$otopmenu = menu("topmenu");
	$ntopmenu = mysql_num_rows($otopmenu);
	
	if ($ntopmenu != 0) 
	{ ?>
    
		<ul id="treemenu1"><?php
		
			while ($topmenu = mysql_fetch_array($otopmenu))
			{
				$otopmenu2 = menu("topmenu", $topmenu['id']);
				$ntopmenu2 = mysql_num_rows($otopmenu2);
				
				if ($ntopmenu2 == 0) 
				{ ?>
					
                    <li><a href="index.php?p=<?php echo enkripsi($topmenu['id']); ?>"><?php echo $topmenu['name']; ?></a><?php
				
				}
				
				else 
				{ ?>
					
                    <li class="node"><a class="mainfoldericon"><?php echo $topmenu['name']; ?></a>
						<ul style="width: 150px; visibility: hidden;"><?php
							
							while ($topmenu2 = mysql_fetch_array($otopmenu2))
							{
								$otopmenu3 = menu("topmenu", $topmenu2['id']);
								$ntopmenu3 = mysql_num_rows($otopmenu3);
								
								if ($ntopmenu3 == 0) 
								{ ?>
                                
									<li style="width: 150px;">
                                    	<a class="icon-16-section" href="index.php?p=<?php echo enkripsi($topmenu2['id']); ?>"><?php 
											
											echo $topmenu2['name']; ?>
										
                                        </a>
									</li><?php
								
								}
								
								else 
								{ ?>
									
                                    <li style="width: 150px;" class="node"><a class="icon-16-section"><?php echo $topmenu2['name']; ?></a>
										<ul style="width: 150px; visibility: hidden;"><?php
											
											while ($topmenu3 = mysql_fetch_array($otopmenu3))
											{
												$otopmenu4 = menu("topmenu", $topmenu3['id']);
												$ntopmenu4 = mysql_num_rows($otopmenu4);
												
												if ($ntopmenu4 == 0) 
												{ ?>
													
                                                    <li style="width: 150px;">
                                                    	<a class="icon-16-category" href="index.php?p=<?php echo enkripsi($topmenu3['id']); ?>"><?php 
															
															echo $topmenu3['name']; ?>
                                                        
                                                        </a>
                                                    </li><?php
												
												}
												
												else 
												{ ?>
													
                                                    <li style="width: 150px;" class="node"><a class="icon-16-category"><?php echo $topmenu3['name']; ?></a>
														<ul style="width: 150px; visibility: hidden;"><?php
															
															while ($topmenu4 = mysql_fetch_array($otopmenu4)) 
															{ ?>
																
                                                                <li style="width: 150px;">
                                                                	<a href="index.php?p=<?php echo enkripsi($topmenu4['id']); ?>"><?php 
																		
																		$topmenu4['name']; ?>
                                                                    
                                                                    </a>
                                                                </li><?php
															
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