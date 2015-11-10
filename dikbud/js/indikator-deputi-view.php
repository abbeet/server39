<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$no_ikk = $_GET['no_ikk'];
	$th = $_GET['th'];
	$renstra = th_renstra($th);
	$sql = "SELECT * FROM m_iku WHERE ta = '$renstra' and kdunitkerja = '$kdunitkerja' and no_iku = '$no_ikk'";
	$oIKK = mysql_query($sql);
	$IKK = mysql_fetch_array($oIKK);
	$nIKK = mysql_num_rows($oIKK);
	if ($nIKK != 0)
	{ ?>
<textarea name="nm_pk" rows="4" cols="70"><?php echo $IKK['nm_iku']; ?></textarea>
	<?php }?>