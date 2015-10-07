<?php
$id=mysql_connect("127.0.0.1","root","bidsi");
mysql_select_db("dbskp_batan");
// hapus dulu
$result1=mysql_query("delete from mst_tk where tahun='2012' and bulan='13'");
// append
$query="select * from mst_tk where tahun='2012' and bulan='06'";
$result2=mysql_query($query);
$i=1;
while($row=mysql_fetch_array($result2))
{
	echo $i . "<br>";
	$i++;
	$d2=$row['tahun'];
	$d3=$row['bulan'];
	$d4=$row['nib'];
	$d5=$row['nip'];
	$d6=$row['kdsatker'];
	$d7=$row['kdunitkerja'];
	$d8=$row['kdgol'];
	$d9=$row['kdjabatan'];
	$d10=$row['grade'];
	$d11=$row['kdkawin'];
	$d12=$row['gaji'];
	$d13=$row['tunker'];
	$d14=$row['pajak_gaji'];
	$d15=$row['kurang'];
	$d16=$row['status'];
	$d17=$row['tgl_status'];
	$d18=$row['iwp'];
	$d19=$row['pajak_tunker'];
	$d20=$row['norec'];
	$d21=$row['nil_terima'];
	$d22=$row['jml_hari'];
	$d23=$row['kdpeg'];
	$d24=$row['tfungsi'];
	
	mysql_query("INSERT INTO mst_tk 
	(id ,tahun ,bulan ,nib ,nip ,kdsatker ,kdunitkerja ,kdgol ,
kdjabatan ,grade ,kdkawin ,gaji ,tunker ,pajak_gaji ,kurang ,
status ,tgl_status ,iwp ,pajak_tunker ,norec ,nil_terima ,
jml_hari ,kdpeg ,tfungsi) 
VALUES (NULL,'$d2','13','$d4','$d5','$d6','$d7','$d8','$d9','$d10','$d11',
	'$d12','$d13','$d14','$d15','$d16','$d17','$d18','$d19','$d20',
	'$d21','$d22','$d23','$d24')");
}
mysql_close();
?>