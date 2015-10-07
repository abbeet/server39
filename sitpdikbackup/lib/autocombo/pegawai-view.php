<?php
	include "../../includes/includes.php";

	$id = $_GET['id'];
	$oPegawai = pegawai_list($id, "nama");
	$num = mysql_num_rows($oPegawai);
	if ($num != 0) { ?>	
		<select name="q">
			<option value=""></option><?php
			while ($Pegawai = mysql_fetch_object($oPegawai)) { ?>
				<option value="<?php echo $Pegawai->nip ?>"><?php echo $Pegawai->nama ?></option><?php
			} ?>
		</select><?php
	}
?>


