<?php	
	checkauthentication();
	extract($_POST);
	$id_skp = $_REQUEST['id_skp'];
	// sw=0 saat proses pembuatan skp, sw=1 saat persetujuan
	$sw = $_REQUEST['sw'];  
	$p_next = $_POST['p_next'];
	// status=0 untuk batal,  status=1 untuk approv
	$status = $_POST['kode'];
	$tgl = date ('Y-m-d') ;
	// proses approval
	if ( $status == '0' and $sw == '0' )
	{	
		$pesan_baru = "\n" . date('d/m/y') . " Atasan:\n" . $_POST['pesan_baru'] . "\n------------------------------\n";
		$pesan_lama = $_POST['pesan_lama'];
		$pesan = $pesan_baru . $pesan_lama;
		mysql_query("UPDATE mst_skp_mutasi SET is_approved_awal = '0', tgl_approved_awal = '0000-00-00', pesan='$pesan' WHERE id = '$id_skp'");
	}
	if ( $status == '1' and $sw == '0' )
	{
		$pesan_baru = "\n" . date('d/m/y') . " Pegawai:\n" . $_POST['pesan_baru'] . "\n------------------------------\n";
		$pesan_lama = $_POST['pesan_lama'];
		$pesan = $pesan_baru . $pesan_lama;
		mysql_query("UPDATE mst_skp_mutasi SET is_approved_awal = '1', tgl_approved_awal = '$tgl', pesan='$pesan' WHERE id = '$id_skp'");
	}
	if ( $status == '0' and $sw == '1' )	
		mysql_query("UPDATE mst_skp_mutasi SET is_approved_akhir = '0', tgl_approved_akhir = '0000-00-00' WHERE id = '$id_skp'");
	if ( $status == '1' and $sw == '1' )	
		mysql_query("UPDATE mst_skp_mutasi SET is_approved_akhir = '1', tgl_approved_akhir = '$tgl' WHERE id = '$id_skp'");
	
	//echo "$pesan";
?>
<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>">
