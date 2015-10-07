<?php
	checkauthentication();
	
	$oleftmenu = menu("leftmenu");
	$nleftmenu = mysql_num_rows($oleftmenu);
?>

<div class="dtree">
    <a href="javascript: d.openAll();">buka</a> | <a href="javascript: d.closeAll();">tutup</a><br /><br />
    <script type="text/javascript">
        d = new dTree('d');
        d.add(0,-1,'Menu');<?php
        
        if ($nleftmenu > 0)
        {
            while ($leftmenu = mysql_fetch_array($oleftmenu))
            {
                $oleftmenu2 = menu("leftmenu",$leftmenu['id']);
                $nleftmenu2 = mysql_num_rows($oleftmenu2);
                
                if ($nleftmenu2 == 0)
                { ?>
                    
                    d.add
                    (
                        <?php echo $leftmenu['id']; ?>,
                        <?php echo $leftmenu['parent'] + 0; ?>,
                        '<?php echo $leftmenu['name']; ?>',
                        'index.php?p=<?php echo enkripsi($leftmenu['id']); ?>'
                    );<?php
                
                }
                else
                { ?>
                    
                    d.add(<?php echo $leftmenu['id']; ?>,<?php echo $leftmenu['parent'] + 0; ?>,'<?php echo $leftmenu['name']; ?>');<?php
                    
                    while ($leftmenu2 = mysql_fetch_array($oleftmenu2))
                    {
                        $oleftmenu3 = menu("leftmenu",$leftmenu2['id']);
                        $nleftmenu3 = mysql_num_rows($oleftmenu3);
                        
                        if ($nleftmenu3 == 0)
                        { ?>
                            
                            d.add
                            (
                                <?php echo $leftmenu2['id']; ?>,
                                <?php echo $leftmenu2['parent'] + 0; ?>,
                                '<?php echo $leftmenu2['name']; ?>',
                                'index.php?p=<?php echo enkripsi($leftmenu2['id']); ?>'
                            );<?php
                        
                        }
                        else
                        { ?>
                            
                            d.add(<?php echo $leftmenu2['id']; ?>,<?php echo $leftmenu2['parent'] + 0; ?>,'<?php echo $leftmenu2['name']; ?>');<?php
                            
                            while ($leftmenu3 = mysql_fetch_array($oleftmenu3))
                            {
                                $oleftmenu4 = menu("leftmenu",$leftmenu3['id']);
                                $nleftmenu4 = mysql_num_rows($oleftmenu4);
                                
                                if ($nleftmenu4 == 0)
                                { ?>
                                    
                                    d.add
                                    (
                                        <?php echo $leftmenu3['id']; ?>,
                                        <?php echo $leftmenu3['parent'] + 0; ?>,
                                        '<?php echo $leftmenu3['name']; ?>',
                                        'index.php?p=<?php echo enkripsi($leftmenu3['id']); ?>'
                                    );<?php
                                
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