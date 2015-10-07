<?php
	#@
	include "../../includes/includes.php";

	$id = @$_GET['id'];
	$oBidang = bidang_list($id);
	$nBidang = mysql_num_rows($oBidang);
	
	if ($nBidang != 0) 
	{ ?>	
		
		<select name="b" onchange="get_subbidang(b.value)">
			<option value="None"></option>
			<option value="All">Semua Bidang</option><?php
			
			while ($Bidang = mysql_fetch_array($oBidang)) 
			{ ?>
			
				<option value="<?php echo substr($Bidang['kode'],0,3); ?>"><?php echo $Bidang['nama']; ?></option><?php
			
			} ?>
		
		</select><?php
	
	}
?>


