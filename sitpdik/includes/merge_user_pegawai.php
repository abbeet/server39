<?php
	include "includes.php";
	
	$sql = "SELECT u.username, p.nama, ul.level, u.unit, u.password, p.alamat, p.telepon, u.email, u.lastlogin, u.aktif, u.reset, u.kunci FROM xuser u 
	LEFT OUTER JOIN pegawai p ON u.username = p.nip LEFT JOIN xuserlevel ul ON u.username = ul.username";
	
	$query = mysql_query($sql);
	
	while ($rows = mysql_fetch_array($query))
	{
		if ($rows['nama'] == "") $nama = $rows['username'];
		else $nama = str_replace("'", "\'", $rows['nama']);
		
		$alamat = str_replace("'", "\'", $rows['alamat']);
		
		$sql = "SELECT * FROM xuser_pegawai WHERE username = '".$rows['username']."'";
		$ocek = mysql_query($sql) or die(mysql_error());
		$cek = mysql_num_rows($ocek);
		
		if ($cek == 0)
		{
			$sql = "INSERT INTO xuser_pegawai (username, nama, level, unit, password, alamat, telepon, email, lastlogin, aktif, reset, kunci) VALUES 
			('".$rows['username']."', '".$nama."', '".$rows['level']."', '".$rows['unit']."', '".$rows['password']."', '".$alamat."', 
			'".$rows['telepon']."', '".$rows['email']."', '".$rows['lastlogin']."', '".$rows['aktif']."', '".$rows['reset']."', '".$rows['kunci']."')";
		
			echo $sql."<BR>";
		
			mysql_query($sql) or die(mysql_error());
		}
	}
?>