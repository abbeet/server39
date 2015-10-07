 
<?php

$L1 = mysql_connect('localhost', 'root', 'Kr4k4t4u123');
$DB1 = mysql_select_db('dbskp_dikbud', $L1);   

$L2 = mysql_connect('localhost', 'root', 'Kr4k4t4u123');
$DB2 = mysql_select_db('sitpdik', $L2);   

$re = mysql_query("SELECT * FROM dbskp_dikbud.m_idpegawai",$L1);

while($row=mysql_fetch_assoc($re))
{
	if ($row["kdeselon"]=='41') {
		$tingkat = 'SEKSI';
	} else if ($row["kdeselon"]=='31') {
		$tingkat = 'SUBDIT';
	} else if ($row["kdeselon"]=='21') {
		$tingkat = 'DIT';
	} else if ($row["kdeselon"]=='11') {
		$tingkat = 'DITJEN';
	} else {
		$tingkat = 'STAF';
	}
	if ($row["kdunitkerja"]=='') {
		//echo "Kode Unit Kosong";
	} else {
	//echo "INSERT INTO xuser_pegawai (username, nama, level, unit, password, alamat, telepon, email, lastlogin, aktif, reset, kunci) VALUES ('".$row["nip"]."','".safe($row["nama"])."','".$tingkat."','".$row["kdunitkerja"]."','5b4bec75d8b46e693da22199faafdd97','','','','','1','1','') ON DUPLICATE KEY UPDATE  xuser_pegawai.level = '".$tingkat."', xuser_pegawai.unit ='".$row["kdunitkerja"]."'";
    mysql_query("INSERT INTO xuser_pegawai (username, nama, level, unit, password, alamat, telepon, email, lastlogin, aktif, reset, kunci) VALUES ('".$row["nip"]."','".safe($row["nama"])."','".$tingkat."','".$row["kdunitkerja"]."','5b4bec75d8b46e693da22199faafdd97','','','','','1','1','') ON DUPLICATE KEY UPDATE  xuser_pegawai.level = '".$tingkat."', xuser_pegawai.unit ='".$row["kdunitkerja"]."'",$L2) or die(mysql_error());
}
}
echo "Proses Import Selesai...."


?>

