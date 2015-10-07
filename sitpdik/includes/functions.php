<?php		
	function safe($value){
   		return mysql_real_escape_string($value);
	} 
	
	function checkauthentication() 
	{
		@session_start();
		$session_name = "Kh41r4";
		
		if (!isset($_SESSION['xusername_'.$session_name]) or !isset($_SESSION[$session_name])) 
		{
			echo '<meta http-equiv="refresh" content="0;URL=login.php">';
			exit();
		}
	}
	
	function sql_select($table, $field = "*", $where_clause = "", $order_by = "") 
	{
		$sql = "SELECT ".$field." FROM ".$table;
		
		if ($where_clause != "") $sql .= " WHERE ".$where_clause;
		if ($order_by != "") $sql .= " ORDER BY ".$order_by;
		
		return $sql;	
	}
		
	function sql_insert($table, $field = "", $value) 
	{
		$sql = "INSERT INTO ".$table;
		
		if ($field != "") 
		{
			$sql .= " (";
			
			if (is_array($field)) 
			{
				foreach ($field as $k=>$val) 
				{
					$sql .= $val;
					if ($k < count($field) - 1) $sql .= ", ";
				}
			}
			else $sql .= $field;
			
			$sql .= ")";
		}
		
		$sql .= " VALUES (";
		
		if (is_array($value)) 
		{
			foreach ($value as $k=>$val) 
			{
				$sql .= "'".$val."'";
			
				if ($k < count($value) - 1) $sql .= ", ";
			}
		}
		else $sql .= $value;
		
		$sql .= ")";
		
		return $sql;
	}
	
	function sql_update($table, $field, $value) 
	{
		$sql = "UPDATE ".$table." SET ";
		foreach ($field as $k=>$val) 
		{
			if ($k != 0) 
			{
				$sql .= $val." = '".$value[$k]."'";
			
				if ($k < count($field) - 1) $sql .= ", ";
			}
		}
		$sql .= " WHERE ".$field[0]." = '".$value[0]."'";
		
		return $sql;
	}
		
	function sql_delete($table, $field, $value) 
	{
		$sql = "DELETE FROM ".$table." WHERE ".$field." = '".$value."'";
	
		return $sql;
	}
	
	function now() 
	{
		return date("Y-m-d H:i:s");
	}
		
	function Sum($x)
	{
		foreach ($x as $val)
		{
			$y += $val;
		}
		
		return $y;
	}
	
	function Rate($x)
	{
		if (count($x) != 0) $y = Sum($x) / count($x);
		else $y = 0;
		
		return $y;
	}
	
	function StdDev($x)
	{
		foreach ($x as $val)
		{
			$x2 = pow($val, 2);
			$sumx2 += $x2;
		}
		
		if (count($x) != 0) $a = pow(Sum($x), 2) / count($x);
		
		$b = $sumx2 - $a;
		
		if (count($x) != 1) $c = $b / (count($x) - 1);
		
		return pow($c, 0.5);
	}
	
	function Terbilang($x) 
	{
  		$abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  		
		if ($x < 12) $terbilang = " ".$abil[$x];
  		elseif ($x < 20) $terbilang = Terbilang($x - 10)."belas";
  		elseif ($x < 100) $terbilang = Terbilang($x / 10)." puluh".Terbilang($x % 10);
  		elseif ($x < 200) $terbilang = " seratus".Terbilang($x - 100);
  		elseif ($x < 1000) $terbilang = Terbilang($x / 100)." ratus".Terbilang($x % 100);
  		elseif ($x < 2000) $terbilang = " seribu".Terbilang($x - 1000);
  		elseif ($x < 1000000) $terbilang = Terbilang($x / 1000)." ribu".Terbilang($x % 1000);
  		elseif ($x < 1000000000) $terbilang = Terbilang($x / 1000000)." juta".Terbilang($x % 1000000);
		
		return $terbilang;
	}
	
	function ymd($d, $m, $y) 
	{
		$ymd = $y.'-'.$m.'-'.$d;
		
		return $ymd;
	}
	
	function dmy ($ymd)
	{
		return date("d-m-Y", strtotime($ymd));
	}
	
	function dmy_to_ymd ($dmy) 
	{
		$d = substr($dmy, 0, 2);
		$m = substr($dmy, 3, 2);
		$y = substr($dmy, 6, 4);
		
		return ymd($d, $m, $y);
	}
	
	function nama_bulan($m) 
	{
		$months = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
		
		return $months[$m];
	}
	
	function jumlah_hari($m, $y) 
	{
		$ymd = ymd('01', $m, $y);
		
		return date("t", strtotime($ymd));
	}
	
	function menit_ke_jam($menit) 
	{
		$sisa = $menit % 60;
		$jam = ($menit - $sisa) / 60;
	
		if ($sisa < 0) $sisa *= -1;
		if ($sisa < 10) $sisa = "0".$sisa;
	
		return $jam.".".$sisa;
	}
	
	function nama_hari($ymd) 
	{
		$days = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
		$w = date("w", strtotime($ymd));
		
		return $days[$w];
	}
	
	function selisih_waktu($awal, $akhir) 
	{
		$selisih = (60 * (substr($awal, 0, 2) - substr($akhir, 0, 2))) + substr($awal, 3, 2) - substr($akhir, 3, 2);
		
		if ($selisih > 0) $selisih = 0;
		if ($selisih < -450) $selisih = -450;
		
		return $selisih * -1;
	}
		
	function dateformat($date, $format) 
	{
		$result = date($format, strtotime($date));
	
		return $result;
	}
	
	function timeformat($time, $separator_awal = ":", $separator_akhir = ":")
	{
		$waktu = explode($separator_awal, $time);
		$jam = $waktu[0] + 0;
		$menit = $waktu[1] + 0;
		$detik = $waktu[2] + 0;
		
		if ($jam < 10) $jam = "0".$jam;
		if ($menit < 10) $menit = "0".$menit;
		if ($detik < 10) $detik = "0".$detik;
		
		$result = $jam.$separator_akhir.$menit.$separator_akhir.$detik;
		
		return $result;
	}
	
	function enkripsi($text)
	{
		@session_start();
		$session_name = "Kh41r4";
		
		$kunci 	= @$_SESSION['kunci_'.$session_name];
		$a 		= base64_encode($text.$kunci);
		$b 		= substr($a, 0, 2);
		$c 		= substr($a, 2);
		$d		= encode_password($b, 1);
		$result	= $d.$c;
		
		#$result = $text;
		
		return $result;
	}
	
	function dekripsi($text)
	{
		@session_start();
		$session_name = "Kh41r4";
		
		$a			= substr($text, 0, 2);
		$b			= substr($text, 2);
		$c			= encode_password($a, 1);
		$d			= $c.$b;
		$dekripsi 	= base64_decode($d);
		$result 	= str_replace(@$_SESSION['kunci_'.$session_name], "", $dekripsi);
		
		#$result = $text;
		
		return $result;
	}
	
	function ekstrak_get($text)
	{
		$ekstrak = explode("=", $text);
		$result = @$ekstrak[1];
		
		return $result;
	}
	
	function encode_password($text, $len)
	{
		$x = substr($text, 0, $len);
		$y = substr($text, $len);
		
		$result = $y.$x;
		
		return $result;
	}
	
	function decode_password($text, $len)
	{
		$len *= -1;
		$x = substr($text, 0, $len);
		$y = substr($text, $len);
		
		$result = $y.$x;
		
		return $result;
	}
?>