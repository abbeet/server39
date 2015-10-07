<?php
	include "../../includes/includes.php";

	$id = @$_GET['id'];
	$oReguShift = regu_shift("kode_shift = '".@$id."'");
	$nReguShift = mysql_num_rows(@$oReguShift);
	
	if (@$nReguShift != 0)
	{ ?>
	
		<select name="regu">
			<option value=""></option><?php
			
			while ($ReguShift = mysql_fetch_array(@$oReguShift))
			{ ?>
			
				<option value="<?php echo @$ReguShift['id']; ?>"><?php echo @$ReguShift['nama']; ?></option><?php
			
			} ?>
			
		</select><?php
		
	}
?>


