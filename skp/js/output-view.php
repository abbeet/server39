<?php
	include "../includes/includes.php";

	$kdgiat = $_GET['kdgiat'];
	$sql = "SELECT * FROM t_output WHERE KDGIAT = '$kdgiat' ORDER BY KDOUTPUT";
	$oOutput = mysql_query($sql);
	$nOutput = mysql_num_rows($oOutput);
	
	if ($nOutput != 0)
	{ ?>
		<select name="kdoutput">
			<option value="" style="width:500px;">-- Pilih Output --</option><?php
			
			while($Output = mysql_fetch_array($oOutput)) 
			{ ?>
         	<option value="<?php echo $Output['KDOUTPUT']; ?>" style="width:500px;"><?php echo  $Output['NMOUTPUT']; ?></option><?php
			} ?>
		</select><?php
	}
?>


