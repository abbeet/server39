<?php

	/*function selisih_waktu($awal,$akhir) 
	{
		$selisih = (60 * (substr(@$awal,0,2) - substr(@$akhir,0,2))) + substr(@$awal,3,2) - substr(@$akhir,3,2);
		
		if (@$selisih > 0) $selisih = 0;
		if (@$selisih < -450) $selisih = -450;
		
		return @$selisih * -1;
	}*/
	
	/*function nama_hari($ymd)
	{
        $days = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $w = date("w", strtotime($ymd));
        
		return $days[$w];
	}*/
	
	function get_sanksi($menit) 
	{
		$sanksi = "";
		
		if ($menit >= 2250 and $menit <= 2699) $sanksi = "A";
		elseif ($menit >= 2700 and $menit <= 4949) $sanksi = "B";
		elseif ($menit >= 4950 and $menit <= 7199) $sanksi = "C";
		elseif ($menit >= 7200 and $menit <= 9449) $sanksi = "D";
		elseif ($menit >= 9450 and $menit <= 11699) $sanksi = "E";
		elseif ($menit >= 11700 and $menit <= 13949) $sanksi = "F";
		elseif ($menit >= 13950 and $menit <= 16199) $sanksi = "G";
		elseif ($menit >= 16200 and $menit <= 18449) $sanksi = "H";
		elseif ($menit >= 18450 and $menit <= 20699) $sanksi = "I";
		elseif ($menit >= 20700) $sanksi = "J";
		
		return $sanksi;
	}
		
	function rekapitulasi_total($nip, $bulan)
	{
		$m = substr($bulan,5,2) + 0;
		$y = substr($bulan,0,4);
		$jml = 0;
		
		for ($i = 1; $i <= $m; $i++)
		{
			if ($i <= 9) $i = '0'.$i;
			$bulan = $y.'-'.$i;
			
			$sql = "SELECT SUM(kekurangan_masuk) AS total_masuk, SUM(kekurangan_keluar) AS total_keluar FROM rekapitulasi WHERE nip = '".$nip."' AND 
			bulan = '".$bulan."'";
			
			#echo $sql."<BR>";
			
			$query = mysql_query($sql);
			$result = mysql_fetch_array($query);
			$tot = $result['total_masuk'] + $result['total_keluar'];
			$jml += $tot;
		}
			
		return $jml;
	}
	
	function get_jumlah_hari_kerja($m, $y) 
	{	
		$bulan = $y."-".$m;
		$jumlah_hari = jumlah_hari($m, $y);
		$tgl = $bulan."-".$jumlah_hari;
		$hari_kerja = 0;
		
		#$date_until = last_import($u);
		
		#if ($tgl >= date("Y-m-d") or $tgl >= $date_until) $jumlah_hari = substr($date_until,8,2) + 0;
	
		for ($x = 1; $x <= $jumlah_hari; $x++) 
		{
			if ($x < 10) $x = "0".$x;
			
			$tgl = $bulan."-".$x;
			
			#$oLibur = libur("tanggal = '".$tgl."'");
			#$nLibur = mysql_num_rows($oLibur);
			
			$s_libur = "SELECT * FROM libur WHERE tanggal = '".$tgl."'";
			$q_libur = mysql_query($s_libur);
			$n_libur = mysql_fetch_array($q_libur);
			
			$hari = strtolower(nama_hari($tgl));
			
			if ($hari != "sabtu" and $hari != "minggu" and $nLibur == 0) $hari_kerja++;
		}
		
		return $hari_kerja;
	}
	
	function get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, $status) 
	{
		$kurang = 0;
		
		switch ($status) 
		{
			case "masuk":
			
				if ($jam_masuk == "00:00:00") 
				{
					$jam_masuk = $jam_keluar;
					$kurang = kekurangan_keluar($batas_keluar, $jam_keluar);
				}
				
				$kekurangan = kekurangan_masuk($batas_masuk, $jam_masuk);
				
				if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
					
			break;
			
			case "keluar":
			
				if ($jam_keluar == "00:00:00") 
				{
					$jam_keluar = $jam_masuk;
					$kurang = kekurangan_masuk($batas_masuk, $jam_masuk);
				}
				
				#echo 'f. '.$kurang."<BR>";
				
				$kekurangan = kekurangan_keluar($batas_keluar, $jam_keluar);
				
				#echo 'g. '.$kekurangan."<BR>";
				
				if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
				
				#echo 'h. '.$kekurangan."<BR>";
				
			break;
		}
		

		return $kekurangan;
	}
	
	function kekurangan_masuk($batas_masuk, $jam_masuk) 
	{
		$result = selisih_waktu($batas_masuk, $jam_masuk);
		
		return $result;
	}
	
	function kekurangan_keluar($batas_keluar, $jam_keluar) 
	{
		
		$result = selisih_waktu($jam_keluar, $batas_keluar);
		
		return $result;
	}
	
	function cek_TL($kekurangan_masuk)
	{
		$TL = array($kekurangan_masuk, 0, 0, 0);
		
		if ($kekurangan_masuk >= 1 and $kekurangan_masuk <= 90) $TL[1] = 1;
		else if ($kekurangan_masuk >= 91 and $kekurangan_masuk <= 120) $TL[2] = 1;
		else if ($kekurangan_masuk > 120) $TL[3] = 1;
		
		return $TL;
	}
	
	function cek_PSW($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar)
	{
		$PSW = array(0, 0, 0, 0, 0);
		
		$kekurangan_masuk = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "masuk");
		
		#echo 'd. '.$kekurangan_masuk."<BR>";
		
		$TL = cek_TL($kekurangan_masuk);
		
		if ($TL[1] == 1)
		{
			$kekurangan_keluar = (60 * (substr($jam_keluar,0,2) - substr(@$batas_keluar,0,2))) + substr($jam_keluar,3,2) - substr($batas_keluar,3,2);
			
			#echo 'i. '.$kekurangan_keluar."<BR>";
			
			$kekurangan_keluar = $kekurangan_masuk - $kekurangan_keluar;
			$kekurangan_keluar = max(0, $kekurangan_keluar);
		}
		else
		{
			$kekurangan_keluar = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "keluar");
		}
		
		#echo 'e. '.$kekurangan_keluar."<BR>";
		
		if ($kekurangan_keluar >= 1 and $kekurangan_keluar <= 30) $PSW[1] = 1;
		else if ($kekurangan_keluar >= 31 and $kekurangan_keluar <= 60) $PSW[2] = 1;
		else if ($kekurangan_keluar >= 61 and $kekurangan_keluar <= 90) $PSW[3] = 1;
		else if ($kekurangan_keluar > 90) $PSW[4] = 1;
		
		return $PSW;
	}
?>