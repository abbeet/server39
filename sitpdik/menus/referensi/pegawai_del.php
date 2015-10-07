<?php
	checkauthentication();
	$table = "xuser_pegawai";
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get($get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
		
	$sql = sql_delete($table, "username", $q);
	$query = mysql_query($sql);
	
	if ($query == 1)
	{
		$msg = "Hapus nama pegawai berhasil. Id = ".$q.".";
		update_log($msg, $table, $susername, 1);
		$_SESSION['errmsg'] = $msg;
	}
	else
	{
		$msg = "Hapus nama pegawai gagal. Id = ".$q.".";
		update_log($msg, $table, $susername, 0);
		$_SESSION['errmsg'] = $msg;
	} ?>
	
	<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
	
	exit();
?>