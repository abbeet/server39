<?php
	include "includes.php";
	
	$batas_masuk = "07:30:00";
	$batas_keluar = "16:30:00";
	$jam_masuk = "11:16:00";
	$jam_keluar = "00:00:00";
	
	$kekurangan_masuk = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "masuk");
	$kekurangan_keluar = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "keluar");
	
	echo 'a. '.$kekurangan_masuk."<BR>";
	echo 'b. '.$kekurangan_keluar."<BR>";
	
	$TL = cek_TL($kekurangan_masuk);
	
	echo 'c. '.$TL[1]."-".$TL[2]."-".$TL[3]."<BR>";
	
	$PSW = cek_PSW($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar);
	
	echo 'd. '.$PSW[1]."-".$PSW[2]."-".$PSW[3]."-".$PSW[4]."<BR>";
	
	
?>