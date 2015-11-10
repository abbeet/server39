<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
//	$kdunit = substr($kdunitkerja,0,4).'00';
	$th = $_GET['th'];
	$renstra = th_renstra($th);
	$sql = "SELECT * FROM m_sasaran  WHERE ta = '$renstra' AND kdunitkerja = '$kdunitkerja' ORDER BY no_sasaran";
	$oSasaran = mysql_query($sql);
	$nSasaran = mysql_num_rows($oSasaran);
	if ($nSasaran != 0)
	{ ?>
		<select name="no_sasaran"">
			<option value="" style="width:500px;">-- Pilih Sasaran --</option><?php
			
			while($Sasaran = mysql_fetch_array($oSasaran)) 
			{ ?>
         	<option value="<?php echo $Sasaran['no_sasaran']; ?>" style="width:500px;"><?php echo  $Sasaran['no_sasaran'].' '.substr($Sasaran['nm_sasaran'],0,70) ?></option><?php
			} ?>
		</select><?php
	}
?>


