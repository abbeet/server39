<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$sql = "SELECT * FROM tb_giat WHERE kdunitkerja = '$kdunitkerja' ORDER BY kdgiat";
	$oGiat = mysql_query($sql);
	$nGiat = mysql_num_rows($oGiat);
	
	if ($nGiat != 0)
	{ ?>
		<select name="kdgiat">
			<option value="" style="width:500px;">-- Pilih Kegiatan --</option><?php
			
			while($Giat = mysql_fetch_array($oGiat)) 
			{ ?>
         	<option value="<?php echo $Giat['kdgiat']; ?>" style="width:500px;"><?php echo  $Giat['nmgiat']; ?></option><?php
			} ?>
		</select><?php
	}
?>


