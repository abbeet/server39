<?php
	include "../../includes/includes.php";

	$id = $_GET['id'];
	$oSubbidang = subbidang_list($id);
	$num = mysql_num_rows($oSubbidang);
	
	if ($num != 0 and $id != "") 
	{	?>	
		
		<select name="s" id="subbidang">
			<option value="">Semua Sub Bidang</option><?php
			
			while ($Subbidang = mysql_fetch_object($oSubbidang)) 
			{ ?>
				<option value="<?php echo $Subbidang->kode ?>"><?php echo $Subbidang->nama ?></option><?php
			} ?>
		
		</select><?php
	}
?>


