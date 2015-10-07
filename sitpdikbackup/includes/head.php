<?php
	include "includes.php";
	
	checkauthentication();
	
	$ohead = xhead("src","type = 'css'");
	$nhead = mysql_num_rows($ohead);
	
	if ($nhead > 0)
	{
		while ($xhead = mysql_fetch_array($ohead))
		{ ?>
			
            <link href="<?php echo $xhead['src']; ?>" rel="stylesheet" type="text/css" /><?php
		
		}
	}

	$ohead = xhead("src","type = 'js'");
	$nhead = mysql_num_rows($ohead);
	
	if ($nhead > 0)
	{
		while ($xhead = mysql_fetch_array($ohead))
		{ ?>
			
			<script language="javascript" src="<?php echo $xhead['src']; ?>"></script><?php
		
		}
	} 
?>
