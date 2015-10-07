<?
	isset($_POST['id_pegawai']) or die('Kurang Parameter');
	
	include 'connect.inc.php';
	$ID = getPost('id_pegawai');
	$query = mysql_query("DELETE FROM master_pegawai WHERE ID = '$ID'");
	if(mysql_affected_rows() == 1) echo 'ok';
	else echo 'failed';
?>
