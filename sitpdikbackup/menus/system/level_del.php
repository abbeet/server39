<?php
	checkauthentication();
	$table = "xlevel";
	$q = ekstrak_get($get[1]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
		
	$sql = sql_delete($table, "kode", $q);
	$query = mysql_query($sql);
	
	if ($query == 1)
	{
		$msg = "Hapus level pengguna berhasil. Id = ".$q.".";
		update_log($msg, $table, $susername, 1);
		$_SESSION['errmsg'] = $msg;
	}
	else
	{
		$msg = "Hapus level pengguna gagal. Id = ".$q.".";
		update_log($msg, $table, $susername, 0);
		$_SESSION['errmsg'] = $msg;
	} ?>
	
	<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
	
	exit();
?>