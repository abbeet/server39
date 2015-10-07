<?php		
// fungsi untuk tokenising dokumen
function tokenising($dokumen) {
	$word = strtolower(strtok($dokumen," \r\n"));
	$tmp = $word;
	// hapus karakter ' " dimana saja berada 
	// hapus . , ; : kalau berada di paling belakang
	$trashpattern = array("/'/", "/\"/", "/_/", "/!/", "/\?/", "/~/", "/&/", "/\\\\/",
	                  "/\.{1,}$/","/\-{1,}$/","/,$/", "/;$/", "/:$/", "/\(/", "/\)/", "/\[/", "/\]/");
	$word = preg_replace($trashpattern, "", $word);
	// simbol -, kalau yang mengapit bukan digit maka proses
	// kalau kata ulang, ambil salah satu
	// kalau bukan kata ulang, sambung
	if(preg_match("/(\D+)-(\D+)/",$word))
	{
		$pos = strpos($word, "-");
		$kata1 = substr($word,0,$pos);
		$kata2 = substr($word,$pos+1);
		if($kata1==$kata2)
			$word = $kata1;
		else
			$word = $kata1.$kata2;
	}
	// simbol /, kalau yang mengapit bukan digit maka proses
	// pecah menjadi lebih dari satu kata
	if(preg_match("/(\D+)\/(\D+)/",$word))
	{
		$hasil = explode("/",$word);
		foreach($hasil as $word)
		{
			if(!empty($word) or $word==="0")
				$kata[] = $word;
		}
	}
	else
	{
		if(!empty($word) or $word==="0")
			$kata[] = $word;
	}

	$word = $tmp;
	if($word==="0")
		$word=1;

	while($word)
	{
		// tokenising kata berikutnya
		// pisahkan kata dengan pembatas spasi atau carriage return
		$word = strtolower(strtok(" \r\n"));
		$tmp=$word;
		$word = preg_replace($trashpattern, "", $word);
		// simbol -, kalau yang mengapit bukan digit maka proses
		// kalau kata ulang, ambil salah satu
		// kalau bukan kata ulang, sambung
		if(preg_match("/(\D+)-(\D+)/",$word))
		{
			$pos = strpos($word, "-");
			$kata1 = substr($word,0,$pos);
			$kata2 = substr($word,$pos+1);
			if($kata1==$kata2)
				$word = $kata1;
			else
				$word = $kata1.$kata2;
		}
		// simbol /, kalau yang mengapit bukan digit maka proses
		// pecah menjadi lebih dari satu kata
		if(preg_match("/(\D+)\/(\D+)/",$word))
		{
			$hasil = explode("/",$word);
			foreach($hasil as $word)
			{
				if(!empty($word) or $word==="0")
					$kata[] = $word;
			}
		}
		else
		{
			if(!empty($word) or $word==="0")
				$kata[] = $word;
		}
		$word=$tmp;
		if($word==="0")
			$word=1;
	}
	return $kata;	
}

// fungsi untuk filtering array kata
function filtering($arr_kata, $bahasa)
{
	$trash_terms=array();
	$data_term = mysql_query("select * from trash_terms where bahasa = '$bahasa'");
	while($baris = mysql_fetch_array($data_term))
	{
		$trash_terms[] = $baris['term'];
	}

	$jml_kata = count($arr_kata);	
	$hasil = array();
	for ($i=0;$i<$jml_kata;$i++)
	{
		if (!in_array($arr_kata[$i],$trash_terms))
		{
			$hasil[] = $arr_kata[$i];
		}
	}
	return $hasil;
}

// fungsi calculate term frekuensi
function calculate_tf($arr_kata)
{
	$jml_kata = count($arr_kata);
	for ($i=0;$i<$jml_kata;$i++)
	{
		$term = stemming($arr_kata[$i]);
		// calculate tf
		if(!isset($doc_terms[$term]))
		{
			$doc_terms[$term]=0;
		}
		$doc_terms[$term]++;
	}
	return $doc_terms;
}

function calculate_tf_en($arr_kata)
{
	$jml_kata = count($arr_kata);
	for ($i=0;$i<$jml_kata;$i++)
	{
		$term = en_stemming($arr_kata[$i]);
		// calculate tf
		if(!isset($doc_terms[$term]))
		{
			$doc_terms[$term]=0;
		}
		$doc_terms[$term]++;
	}
	return $doc_terms;
}

	function checkauthentication() {
		if (!isset($_SESSION['xusername']) or !isset($_SESSION['sukki'])) {
			echo '<meta http-equiv="refresh" content="0;URL=login.php">';
			exit();
		}
	}
	
	function sql_select($table,$where_clause="",$order_by="") {
		$sql = "SELECT * FROM ".$table;
		if ($where_clause != "") $sql .= " WHERE ".$where_clause;
		if ($order_by != "") $sql .= " ORDER BY ".$order_by;
		return $sql;	
	}
		
	function sql_insert($table,$field="",$value) {
		$sql = "INSERT INTO ".$table;
		
		if ($field != "") {
			$sql .= " (";
			if (is_array($field)) {
				foreach ($field as $k=>$val) {
					$sql .= $val;
					if ($k < count($field)-1) $sql .= ",";
				}
			}
			else $sql .= $field;
			$sql .= ")";
		}
		
		$sql .= " VALUES (";
		
		if (is_array($value)) {
			foreach ($value as $k=>$val) {
				$sql .= "'".$val."'";
				if ($k < count($value)-1) $sql .= ",";
			}
		}
		else $sql .= $value;
		
		$sql .= ")";
		return $sql;
	}
	
	function sql_update($table,$field,$value) {
		$sql = "UPDATE ".$table." SET ";
		foreach ($field as $k=>$val) {
			if ($k != 0) {
				$sql .= $val."='".$value[$k]."'";
				if ($k < count($field)-1) $sql .= ",";
			}
		}
		$sql .= " WHERE ".$field[0]."='".$value[0]."'";
		return $sql;
	}
		
	function sql_delete($table,$field,$value) {
		$sql = "DELETE FROM ".$table." WHERE ".$field."='".$value."'";
		return $sql;
	}
	
	function now() {
		return date("Y-m-d H:i:s");
	}
		
	function Sum($x){
		foreach ($x as $val){
			$y+=$val;
		}
		return $y;
	}
		
	function ymd($d,$m,$y) {
		$ymd = $y.'-'.$m.'-'.$d;
		return $ymd;
	}
	
	function dmy ($ymd){
		return date("d-m-Y",strtotime($ymd));
	}
	
	function dmy_to_ymd ($dmy) {
		$d = substr($dmy,0,2);
		$m = substr($dmy,3,2);
		$y = substr($dmy,6,4);
		return ymd($d,$m,$y);
	}
	
	function nama_bulan($m) {
		$months = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
		return $months[$m];
	}
	
	function jumlah_hari($m,$y) {
		$ymd = ymd('01',$m,$y);
		return date("t", strtotime($ymd));
	}
	
	function menit_ke_jam($menit) {
		$sisa = $menit % 60;
		$jam = ($menit - $sisa) / 60;
		if ($sisa < 0) $sisa *= -1;
		if ($sisa < 10) $sisa = "0".$sisa;
		return $jam.".".$sisa;
	}
	
	function nama_hari($ymd) {
		$days = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		$w = date("w", strtotime($ymd));
		return $days[$w];
	}
	
	function selisih_waktu($awal,$akhir) {
		$selisih = (60 * (substr($awal,0,2) - substr($akhir,0,2))) + substr($awal,3,2) - substr($akhir,3,2);
		if ($selisih > 0) $selisih = 0;
		if ($selisih < -450) $selisih = -450;
		return $selisih*-1;
	}
		
	function dateformat($date,$format) {
		$result = date($format, strtotime($date));
		return $result;
	}
?>