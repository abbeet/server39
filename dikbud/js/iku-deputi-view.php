<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$th = $_GET['th'];
	$renstra = th_renstra($th);
	$sql = "SELECT * FROM m_iku  WHERE ta = '$renstra' AND kdunitkerja = '$kdunitkerja' ORDER BY kdunitkerja,no_sasaran,no_iku";
	$oIKK = mysql_query($sql);
	$nIKK = mysql_num_rows($oIKK);
	if ($nIKK != 0)
	{ ?>
		<select name="no_ikk" onchange="get_indikator_deputi(this.value,<?php echo $kdunitkerja ?>,<?php echo $th ?>)">
			<option value="" style="width:500px;">-- Pilih IKU --</option><?php
			
			while($IKK = mysql_fetch_array($oIKK)) 
			{ ?>
         	<option value="<?php echo $IKK['no_iku']; ?>" style="width:500px;"><?php echo  $IKK['no_iku'].' '.substr($IKK['nm_iku'],0,70) ?></option><?php
			} ?>
		</select><?php
	}
?>


