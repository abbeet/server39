<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$th = $_GET['th'];
	$sql = "SELECT * FROM m_ikk  WHERE th = '$th' AND kdunitkerja = '$kdunitkerja' ORDER BY kdunitkerja,no_ikk";
	$oIKK = mysql_query($sql);
	$nIKK = mysql_num_rows($oIKK);
	if ($nIKK != 0)
	{ ?>
		<select name="no_ikk" onchange="get_indikator(this.value,<?php echo $kdunitkerja ?>,<?php echo $th ?>)">
			<option value="" >-- Pilih IKK --</option><?php
			
			while($IKK = mysql_fetch_array($oIKK)) 
			{ ?>
         	<option value="<?php echo $IKK['no_ikk']; ?>" style="width:500px;"><?php echo  $IKK['no_ikk'].' '.substr($IKK['nm_ikk'],0,70) ?></option><?php
			} ?>
		</select><?php
	}
?>


