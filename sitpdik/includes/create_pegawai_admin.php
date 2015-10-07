<?php
	mysql_connect("localhost", "root", "bidsi");
	mysql_select_db("sitpdik");
	
	$sql = "SELECT * FROM xuser WHERE username LIKE 'admin%'";
	$query = mysql_query($sql);
	
	while ($rows = mysql_fetch_array($query))
	{
		$sql = "INSERT INTO pegawai (nip, nama, unit) VALUES ('".$rows['username']."', '".$rows['username']."', '".$rows['unit']."')";
		
		echo $sql."<BR>";
		
		mysql_query($sql);
	}
?>	