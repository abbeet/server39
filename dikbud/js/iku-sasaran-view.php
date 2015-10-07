<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$renstra = $_GET['renstra'];
	$no_sasaran = $_GET['no_sasaran'];
	$sql = "SELECT * FROM m_iku  ORDER BY kdunitkerja,no_sasaran,no_iku";
	$oIKK = mysql_query($sql);
	$nIKK = mysql_num_rows($oIKK);
	if ($nIKK != 0)
	{ ?>
		<select name="no_iku">
			<option value="" style="width:500px;">-- Pilih IKU --</option><?php
			
			while($IKK = mysql_fetch_array($oIKK)) 
			{ ?>
         	<option value="<?php echo $IKK['no_iku']; ?>" style="width:500px;"><?php echo  $IKK['no_iku'].' '.substr($IKK['nm_iku'],0,70) ?></option><?php
			} ?>
		</select><?php
	}
?>


