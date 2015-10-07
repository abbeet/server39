<?php
	checkauthentication();
	$table = "kategorisurat";
	$h = ekstrak_get($get[1]);
	$q = ekstrak_get($get[2]);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent']."&h=".$h;
		
	$sql = sql_delete($table, "IdKategori", $q);
	$query = mysql_query($sql);
	
	if ($query == 1)
	{
		$msg = "Hapus kategori surat berhasil. Id = ".$q.".";
		update_log($msg, $table, $susername, 1);
		$_SESSION['errmsg'] = $msg;
	}
	else
	{
		$msg = "Hapus kategori surat gagal. Id = ".$q.".";
		update_log($msg, $table, $susername, 0);
		$_SESSION['errmsg'] = $msg;
	} ?>
	
	<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo enkripsi($p_next); ?>"><?php
	
	exit();
?>