<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$th = $_GET['th'];
	$sql = "SELECT * FROM m_iku_utama  WHERE ta = '$th' AND kdunit = '$kdunitkerja' ORDER BY kdunit,no_iku";
	$oIKK = mysql_query($sql);
	$nIKK = mysql_num_rows($oIKK);
	if ($nIKK != 0)
	{ ?>
		<select name="no_iku">
			<option value="" >-- Pilih Indikator Kinerja --</option><?php
			
			while($IKK = mysql_fetch_array($oIKK)) 
			{ ?>
         	<option value="<?php echo $IKK['no_iku']; ?>" style="width:500px;"><?php echo  substr($IKK['nm_iku'],0,80) ?></option><?php
			} ?>
		</select><?php
	}
?>


