<?php
	include "../includes/includes.php";

	$id = $_GET['id'];
	
	$sql = "SELECT kode FROM jns_buku WHERE id_jenis = '".$id."'";
	$qu = mysql_query($sql);
	$num = mysql_num_rows($qu);
	
	if ($num != 0) 
	{
		$r = mysql_fetch_array($qu);
		
		$sql = "SELECT no_buku FROM buku WHERE no_buku LIKE '".$r['kode']."%' ORDER BY no_buku DESC";
		$qu2 = mysql_query($sql);
		$r2 = mysql_fetch_array($qu2);
		$no = str_replace($r['kode'],'',$r2['no_buku']);
		$no++;
		if ($no < 10) $no = '00'.$no;
		else if ($no < 100) $no = '0'.$no; ?>	
		
		<input type="text" name="no_buku" maxlength="6" size="7" value="<?php echo $r['kode'].$no; ?>" /><?php
	}
	else
	{ ?>
		<input type="text" name="no_buku" maxlength="6" size="7" value="" /><?php
	}
?>


