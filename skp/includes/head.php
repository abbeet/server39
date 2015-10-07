<?php
	checkauthentication();
	
	$sql = xhead("type='css'");
	$count = mysql_num_rows($sql);
	
	if ($count != 0) {
		while ($xhead = mysql_fetch_object($sql)){ ?>
			<link href="<?php echo $xhead->src ?>" rel="stylesheet" type="text/css" /><?php
		}
	}
	
	$sql = "SELECT * FROM xhead WHERE type = 'js'";

	$sql = xhead("type='js'");
	$count = mysql_num_rows($sql);
	
	if ($count != 0) {
		while ($xhead = mysql_fetch_object($sql)){ ?>
			<script language="javascript" src="<?php echo $xhead->src ?>"></script><?php
		}
	} 
?>
