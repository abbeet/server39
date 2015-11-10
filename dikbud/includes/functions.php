<?php		
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
		date_default_timezone_set("Asia/Jakarta");
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
	
	function reformat_tgl($tgl) {
		$d = substr($tgl,8,2);
		$m = substr($tgl,5,2);
		$y = substr($tgl,0,4);
		$result = $d.'-'.$m.'-'.$y;
		return $result;
	}

	function reformat_tanggal($tgl) {
		$d = substr($tgl,8,2);
		$m = substr($tgl,5,2);
		$y = substr($tgl,0,4);
		if( substr($m,0,1) == '0' )  $m = substr($m,1,1) ;
		$result = $d.' '.nama_bulan($m).' '.$y;
		return $result;
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

	function nm_status($kode) {
		if ($kode == '0') $hasil = '';
		if ($kode == '1') $hasil = 'Draf';
		if ($kode == '2') $hasil = 'Kirim';
		return $hasil;
	}

	function nmromawi($kode) {
		if ($kode == 1 ) $hasil = 'I';
		if ($kode == 2 ) $hasil = 'II';
		if ($kode == 3 ) $hasil = 'III';
		if ($kode == 4 ) $hasil = 'IV';
		return $hasil;
	}

	function nmalfa($kode) {
		if ($kode == 1 ) $hasil = 'a';
		if ($kode == 2 ) $hasil = 'b';
		if ($kode == 3 ) $hasil = 'c';
		if ($kode == 4 ) $hasil = 'd';
		if ($kode == 5 ) $hasil = 'e';
		if ($kode == 6 ) $hasil = 'f';
		if ($kode == 7 ) $hasil = 'g';
		if ($kode == 8 ) $hasil = 'h';
		return $hasil;
	}

	function dateformat($date,$format) {
		$result = date($format, strtotime($date));
		return $result;
	}
	
function th_renstra($th)
{
if( $th >= 2010 and $th <= 2014)	$hasil = '2010-2014' ;
if( $th >= 2015 and $th <= 2019)	$hasil = '2015-2019' ;
if( $th >= 2020 and $th <= 2024)	$hasil = '2020-2024' ;
return($hasil);
}

	function setup_kddept_keu() {
		$data = mysql_query("select KDDEPT from setup_dept");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['KDDEPT']);
		return $result;
	}

	function setup_kdunit_keu() {
		$data = mysql_query("select KDUNIT from setup_dept");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['KDUNIT']);
		return $result;
	}

	function setup_kddept_unit() {
		$data = mysql_query("select KDDEPT from setup_dept");
		$rdata = mysql_fetch_array($data);
		$result = substr($rdata['KDDEPT'],1,2);
		return $result;
	}

	function nm_unit($kode) {
		$data = mysql_query("select nmunit from tb_unitkerja where kdunit='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmunit']);
		return $result;
	}
	
	function kd_satker($kode) {
		$data = mysql_query("select kdsatker from tb_unitkerja where kdunit='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['kdsatker']);
		return $result;
	}
	
	function skt_unit($kode) {
		$data = mysql_query("select sktunit from tb_unitkerja where kdunit='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['sktunit']);
		return $result;
	}
	
	function nm_iku($th,$kdunit,$no_sasaran,$no_iku) {
		$sql = "select nm_iku from m_iku_utama where ta = '$th' and kdunit = '$kdunit' and no_sasaran = '$no_sasaran' and no_iku = '$no_iku'"; #echo $sql."<br>";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nm_iku'];
		return $result;
	}
	
	function nm_sasaran($th,$kdunit,$no_sasaran) {
		$sql = "select nm_sasaran from m_sasaran_utama where ta = '$th' and kdunit = '$kdunit' and no_sasaran = '$no_sasaran'"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nm_sasaran'];
		return $result;
	}
	
	function nm_program($th,$kdprog) {
		$kddept = substr($kdprog,0,3);
		$kdunit = substr($kdprog,3,2);
		$kdprogram = substr($kdprog,5,2);
		$data = mysql_query("select nmprogram from m_program where ta = '$th' and kddept = '$kddept' and kdunit = '$kdunit' and kdprogram = '$kdprogram' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmprogram']);
		return $result;
	}
	
	function nm_kegiatan($th,$kdunit,$kdgiat) {
		$data = mysql_query("select nmgiat from m_kegiatan where th = '$th' and kdunitkerja = '$kdunit' and kdgiat = '$kdgiat' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmgiat']);
		return $result;
	}
	
	function nm_giat($kdgiat) {
		$data = mysql_query("select nmgiat from m_kegiatan where kdgiat = '$kdgiat' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmgiat']);
		return $result;
	}
	
	function nm_satker($kdsatker) {
		$data = mysql_query("select NMSATKER from t_satker where KDSATKER = '$kdsatker' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NMSATKER']);
		return $result;
	}
	
	function nm_output_th($th,$kode) {
		$kdgiat = substr($kode,0,4);
		$kdoutput = substr($kode,4,3);
		$table = 't_output'.$th ;
		$data = mysql_query("select NMOUTPUT from $table where KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NMOUTPUT']);
		return $result;
	}

	function sat_output_th($th,$kode) {
		$kdgiat = substr($kode,0,4);
		$kdoutput = substr($kode,4,3);
		$table = 't_output'.$th ;
		$data = mysql_query("select SAT from $table where KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['SAT']);
		return $result;
	}

	function vol_output($th,$kdsatker,$kdgiat,$kdoutput) {
		$data = mysql_query("select VOL from d_output where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['VOL'];
		return $result;
	}

	function nm_suboutput($kode,$th) {
		$kdgiat = substr($kode,0,4);
		$kdoutput = substr($kode,4,3);
		$kdsoutput = substr($kode,7,3);
		$data = mysql_query("select URSOUTPUT from d_soutput where THANG='$th' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['URSOUTPUT']);
		return $result;
	}

	function nm_kmpnen($kode,$th) {
		$kdgiat = substr($kode,0,4);
		$kdoutput = substr($kode,4,3);
		$kdsoutput = substr($kode,7,3);
		$kdkmpnen = substr($kode,10,3);
		$data = mysql_query("select URKMPNEN from d_kmpnen where THANG='$th' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN='$kdkmpnen'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['URKMPNEN']);
		return $result;
	}

	function nm_skmpnen($kode,$th) {
		$kdgiat = substr($kode,0,4);
		$kdoutput = substr($kode,4,3);
		$kdsoutput = substr($kode,7,3);
		$kdkmpnen = substr($kode,10,3);
		$kdskmpnen = substr($kode,13,3);
		$data = mysql_query("select URSKMPNEN from d_skmpnen where THANG='$th' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN='$kdkmpnen' and KDSKMPNEN='$kdskmpnen'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['URSKMPNEN']);
		return $result;
	}
	
	function nm_akun($kdakun) {
		$sql = "select NMAKUN from t_akun where KDAKUN = '$kdakun'"; #echo $sql."<br>";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['NMAKUN'];
		return $result;
	}
	
	function pagu_menteri($th) {
		$sql = "select sum(Jumlah) as pagu_menteri from d_item where THANG = '$th' and KDDEPT = '023' group by KDDEPT"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_menteri'];
		return $result;
	}

	function pagu_satker($th,$kdsatker) {
		$sql = "select sum(Jumlah) as pagu_satker from d_item where THANG = '$th' and KDSATKER = '$kdsatker' group by KDSATKER"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		if ( empty($rdata) )  $result = 0 ;
		else  $result = $rdata['pagu_satker'];
		return $result;
	}
	
	function pagu_giat($th,$kdsatker,$kdgiat) {
		$sql = "select sum(Jumlah) as pagu_giat from d_item where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' group by KDGIAT"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_giat'];
		return $result;
	}
	
	function pagu_unitkerja($th,$kdunitkerja) {
		$sql_giat = "select kdgiat from m_kegiatan where th = '$th' and kdunitkerja = '$kdunitkerja' order by kdgiat"; 
		$data_giat = mysql_query($sql_giat);
		while( $rdata_giat = mysql_fetch_array($data_giat))
		{
		$sql = "select sum(Jumlah) as pagu_giat from d_item where THANG = '$th' and KDGIAT = '$rdata_giat[kdgiat]' group by KDGIAT"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result += $rdata['pagu_giat'];
		} 
		return $result;
	}
	
	function pagu_output($th,$kdsatker,$kdgiat,$kdoutput) {
		$sql = "select sum(Jumlah) as pagu_output from d_item where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' group by KDOUTPUT"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_output'];
		return $result;
	}
	
	function real_menteri_bulan($th,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	
	function real_menteri_triwulan($th,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDGIAT <> '0000'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2 )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_sdtriwulan($th,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDGIAT <> '0000'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_bulan_akun($th,$kdbulan,$kdakun) { 
		
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDAKUN = '$kdakun' AND NOSP2D <> ' '"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}
	
	function real_satker_bulan_akun($th,$kdsatker,$kdbulan,$kdakun) { 
		
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and KDAKUN = '$kdakun' AND NOSP2D <> ' '"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}
	
	function real_menteri_sdbulan_akun($th,$kdbulan,$kdakun) { 
		
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDAKUN = '$kdakun' AND NOSP2D <> ' '"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}

	function real_satker_sdbulan_akun($th,$kdsatker,$kdbulan,$kdakun) { 
		
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and KDAKUN = '$kdakun' AND NOSP2D <> ' '"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}
	
	function real_satker_bulan($th,$kdsatker,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_satker_triwulan($th,$kdsatker,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2 )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_satker_triwulan_akun($th,$kdsatker,$kdtriwulan,$kdakun) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and KDAKUN = '$kdakun' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2 )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_triwulan_akun($th,$kdtriwulan,$kdakun) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDAKUN = '$kdakun' and NOSP2D = '$rdata_ind[NOSP2D]' "; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2 )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_sdbulan($th,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and NOSPM = '$rdata_ind[NOSPM]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_sdbulan_jnsbel($th,$kdbulan,$kdbel) { 
	switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '51' AND NOSP2D <> ' '"; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' AND NOSP2D <> ' '"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '53' AND NOSP2D <> ' '"; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,3) = '524' AND NOSP2D <> ' '"; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '57' AND NOSP2D <> ' '"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		return $result;
	}

	function real_menteri_sdtriwulan_jnsbel($th,$kdtriwulan,$kdbel) { 
	switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
	
	switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '51' AND NOSP2D <> ' '"; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' AND NOSP2D <> ' '"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '53' AND NOSP2D <> ' '"; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,3) = '524' AND NOSP2D <> ' '"; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '57' AND NOSP2D <> ' '"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		return $result;
	}
	
	function real_satker_sdbulan($th,$kdsatker,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_satker_sdtriwulan($th,$kdsatker,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_satker_sdtriwulan_akun($th,$kdsatker,$kdtriwulan,$kdakun) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and KDAKUN = '$kdakun' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_sdtriwulan_akun($th,$kdtriwulan,$kdakun) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDGIAT <> '0000' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDAKUN = '$kdakun' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_satker_sdbulan_jnsbel($th,$kdsatker,$kdbulan,$kdbel) { 
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '51' AND NOSP2D <> ' '"; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' AND NOSP2D <> ' '"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '53' AND NOSP2D <> ' '"; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '57' AND NOSP2D <> ' '"; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,3) = '524' AND NOSP2D <> ' '"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}
	
	function real_satker_sdtriwulan_jnsbel($th,$kdsatker,$kdtriwulan,$kdbel) { 
	switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '51' AND NOSP2D <> ' '"; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' AND NOSP2D <> ' '"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '53' AND NOSP2D <> ' '"; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '57' AND NOSP2D <> ' '"; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,3) = '524' AND NOSP2D <> ' '"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}
	
	function real_giat_bulan($th,$kdsatker,$kdgiat,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_triwulan($th,$kdsatker,$kdgiat,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2 )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_bulan_akun($th,$kdsatker,$kdgiat,$kdbulan,$kdakun) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' AND KDAKUN = '$kdakun' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_triwulan_akun($th,$kdsatker,$kdgiat,$kdtriwulan,$kdakun) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' AND KDAKUN = '$kdakun' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2 )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_sdbulan($th,$kdsatker,$kdgiat,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_sdtriwulan($th,$kdsatker,$kdgiat,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
function real_giat_sdbulan_akun($th,$kdsatker,$kdgiat,$kdbulan,$kdakun) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' AND KDAKUN = '$kdakun' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}	
	
function real_giat_sdtriwulan_akun($th,$kdsatker,$kdgiat,$kdtriwulan,$kdakun) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' AND KDAKUN = '$kdakun' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}		
	
	function real_giat_sdbulan_jnsbel($th,$kdsatker,$kdgiat,$kdbulan,$kdbel) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '51' "; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524'"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '53' "; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '57' "; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,3) = '524' "; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_sdtriwulan_jnsbel($th,$kdsatker,$kdgiat,$kdtriwulan,$kdbel) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '51' "; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524'"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '53' "; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '57' "; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,3) = '524' "; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_bulan($th,$kdsatker,$kdgiat,$kdoutput,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' "; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) == $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_triwulan($th,$kdsatker,$kdgiat,$kdoutput,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan1 = 1;
			$bulan2 = 3;
			break;
			case 2:
			$bulan1 = 4;
			$bulan2 = 6;
			break;
			case 3:
			$bulan1 = 7;
			$bulan2 = 9;
			break;
			case 4:
			$bulan1 = 10;
			$bulan2 = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) >= $bulan1 and substr($rdata['TGSP2D'],5,2) <= $bulan2  )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_sdbulan($th,$kdsatker,$kdgiat,$kdoutput,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_sdtriwulan($th,$kdsatker,$kdgiat,$kdoutput,$kdtriwulan) { 
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' GROUP BY KDAKUN"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
function real_output_sdbulan_jnsbel($th,$kdsatker,$kdgiat,$kdoutput,$kdbulan,$kdbel) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '51' GROUP BY KDAKUN"; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' GROUP BY KDAKUN"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '53' GROUP BY KDAKUN"; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '57' GROUP BY KDAKUN"; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,3) = '524' GROUP BY KDAKUN"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}	
	
	function real_output_sdtriwulan_jnsbel($th,$kdsatker,$kdgiat,$kdoutput,$kdtriwulan,$kdbel) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		switch ( $kdtriwulan )
		{
			case 1:
			$bulan = 3;
			break;
			case 2:
			$bulan = 6;
			break;
			case 3:
			$bulan = 9;
			break;
			case 4:
			$bulan = 12;
			break;
		}
		
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '51' GROUP BY KDAKUN"; 
		break;
		case '52':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' GROUP BY KDAKUN"; 
		break;
		case '53':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '53' GROUP BY KDAKUN"; 
		break;
		case '57':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,2) = '57' GROUP BY KDAKUN"; 
		break;
		case '524':
		$sql = "select TGSP2D,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]' and left(KDAKUN,3) = '524' GROUP BY KDAKUN"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSP2D'],5,2) <= $bulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}	
	
	function pagudipa_menteri($th) 
	{
	$kode = substr($kdunitkerja,0,2);
	$sql = "select sum(JUMLAH) as pagu from d_item WHERE THANG='$th' and KDDEPT = '023' group by KDDEPT"; 
	$aPagu = mysql_query($sql);
	$Pagu = mysql_fetch_array($aPagu);
	$result = $Pagu['pagu'];
	return $result;
	}
	
	function nosasaran_iku($th,$kdunit,$no_iku) {
		$data = mysql_query("select no_sasaran from m_iku where ta='$th' and kdunitkerja = '$kdunit' and no_iku = '$no_iku' ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['no_sasaran'];
		return $result;
	}
	
	function ket_unit($kode) {
		$data = mysql_query("select sktunit from tb_unitkerja where kdunit='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['sktunit']);
		return $result;
	}
	
	function nm_ikk($ta,$kdunit,$no_ikk) {
		$data = mysql_query("select nm_ikk from m_ikk where th='$ta' and kdunitkerja = '$kdunit' and no_ikk = '$no_ikk' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nm_ikk']);
		return $result;
	}
	
	function visi_unit($kdunit) {
		$sql = "select visi from tb_unitkerja WHERE kdunit = '$kdunit'";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['visi'];
		return $result;
	}
		
	function tusi_unit($kdunit) {
		$sql = "select tugas from tb_unitkerja WHERE kdunit = '$kdunit'";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['tugas'];
		return $result;
	}
	
	function cover_semester1($th,$kdunit) {
		$sql = "select nama_file from dt_fileupload WHERE th ='$th' AND kdunitkerja = '$kdunit' and nourut = 0 and keterangan = 'Semester1' ";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nama_file'];
		return $result;
	}
	
	function cover_semester2($th,$kdunit) {
		$sql = "select nama_file from dt_fileupload WHERE th ='$th' AND kdunitkerja = '$kdunit' and nourut = 0 and keterangan = 'Semester2' ";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nama_file'];
		return $result;
	}
	
	function cover_tahunan($th,$kdunit) {
		$sql = "select nama_file from dt_fileupload WHERE th ='$th' AND kdunitkerja = '$kdunit' and nourut = 0 and keterangan = 'Tahunan' ";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nama_file'];
		return $result;
	}
	
	function cover_lakip($th,$kdunit) {
		$sql = "select nama_file from dt_fileupload WHERE th ='$th' AND kdunitkerja = '$kdunit' and nourut = 0 and keterangan = 'Lakip' ";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nama_file'];
		return $result;
	}
	
	function cover_renstra($th,$kdunit) {
		$sql = "select nama_file from dt_fileupload WHERE th = '$th' AND kdunitkerja = '$kdunit' and nourut = 0 and keterangan = 'Renstra' ";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nama_file'];
		return $result;
	}
	
	function renc_menteri_sdbulan($th,$kdbulan) { 
		
	switch ( $kdbulan )
	{
		case 1 ;
		$sql = "select sum(JML01) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 2 ;
		$sql = "select sum(JML01 + JML02) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 3 ;
		$sql = "select sum(JML01 + JML02 + JML03) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 4 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 5 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 6 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 7 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 8 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 9 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 10 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 11 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
		
		case 12 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11 + JML12) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
	}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['rencana'];
		return $result;
	}
	
	function renc_menteri_sdtriwulan($th,$kdtriwulan) { 
		
	switch ( $kdtriwulan )
	{
		case 1 ;
		$sql = "select sum(JML01 + JML02 + JML03) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
	
		case 2 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
	
		case 3 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
	
		case 4 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11 + JML12) as rencana from d_trktrm where THANG = '$th' GROUP BY THANG"; 
		break;
	}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['rencana'];
		return $result;
	}
	
	function renc_satker_sdbulan($th,$kdsatker,$kdbulan) { 
		
	switch ( $kdbulan )
	{
		case 1 ;
		$sql = "select sum(JML01) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 2 ;
		$sql = "select sum(JML01 + JML02) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 3 ;
		$sql = "select sum(JML01 + JML02 + JML03) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 4 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 5 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 6 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 7 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 8 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 9 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 10 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML010) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 11 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
		
		case 12 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11 + JML12) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
	}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['rencana'];
		return $result;
	}
	
	function renc_satker_sdtriwulan($th,$kdsatker,$kdtriwulan) { 
		
	switch ( $kdtriwulan )
	{
		case 1 ;
		$sql = "select sum(JML01 + JML02 + JML03) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
	
		case 2 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
	
		case 3 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
	
		case 4 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11 + JML12) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER"; 
		break;
	}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['rencana'];
		return $result;
	}
	
	function renc_giat_sdbulan($th,$kdsatker,$kdgiat,$kdbulan) { 
		
	switch ( $kdbulan )
	{
		case 1 ;
		$sql = "select sum(JML01) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 2 ;
		$sql = "select sum(JML01 + JML02) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 3 ;
		$sql = "select sum(JML01 + JML02 + JML03) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 4 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 5 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 6 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 7 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 8 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 9 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 10 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 11 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 12 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11 + JML12) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
	}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['rencana'];
		return $result;
	}
	
	function renc_giat_sdtriwulan($th,$kdsatker,$kdgiat,$kdtriwulan) { 
		
	switch ( $kdtriwulan )
	{
		case 1 ;
		$sql = "select sum(JML01 + JML02 + JML03) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 2 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 3 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
		
		case 4 ;
		$sql = "select sum(JML01 + JML02 + JML03 + JML04 + JML05 + JML06 + JML07 + JML08 + JML09 + JML10 + JML11 + JML12) as rencana from d_trktrm where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' GROUP BY KDGIAT"; 
		break;
	}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['rencana'];
		return $result;
	}
	
	function nm_jnsbelanja($kode) {
		if ($kode == '51') $hasil = 'Belanja Pegawai';
		if ($kode == '52') $hasil = 'Belanja Barang';
		if ($kode == '53') $hasil = 'Belanja Modal';
		if ($kode == '57') $hasil = 'Belanja Sosial';
		return $hasil;
	}
	
	function real_menteri_spm_bulan($th,$kddept,$kdunit,$kdbulan) { 
		$result = 0 ;
		
		$data_satker = mysql_query("select KDSATKER from t_satker ");
		while($rdata_satker = mysql_fetch_array($data_satker))
		{
		$kdsatker = $rdata_satker['KDSATKER'];
		
		$sql_ind = "select * from m_spmind where THANG = '$th' AND KDSATKER = '$kdsatker' and KDDEPT = '$kddept' and KDUNIT = '$kdunit' and KDGIAT <> '0000' and TGSPM <> '0000-00-00'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		
			if ( substr($rdata_ind['TGSPM'],5,2) == $kdbulan )  $result += $rdata_ind['TOTNILMAK'];
		
		} #END WHILE 
		} #satker
		return $result;
	}
	
	function real_menteri_spm_sdbulan($th,$kddept,$kdunit,$kdbulan) { 
		$result = 0 ;
		
		$data_satker = mysql_query("select KDSATKER from t_satker ");
		while($rdata_satker = mysql_fetch_array($data_satker))
		{
		$kdsatker = $rdata_satker['KDSATKER'];
		
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT <> '0000' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' AND KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSPM'],5,2) <= $kdbulan ) $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		} #satker
		return $result;
	}
	
	function real_satker_spm_bulan($th,$kdsatker,$kdbulan) { 
		$result = 0 ;
				
		$sql_ind = "select * from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT <> '0000' and TGSPM <> '0000-00-00'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		
			if ( substr($rdata_ind['TGSPM'],5,2) == $kdbulan )  $result += $rdata_ind['TOTNILMAK'];
		
		} #END WHILE 
		return $result;
	}
	
	function real_satker_spm_sdbulan($th,$kdsatker,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT <> '0000' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' AND KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSPM'],5,2) <= $kdbulan ) $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_spm_bulan($th,$kdsatker,$kdgiat,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select * from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' and TGSPM <> '0000-00-00'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		
			if ( substr($rdata_ind['TGSPM'],5,2) == $kdbulan )  $result += $rdata_ind['TOTNILMAK'];
		
		} #END WHILE 
		return $result;
	}
	
	function real_giat_spm_sdbulan($th,$kdsatker,$kdgiat,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select * from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' and TGSPM <> '0000-00-00'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		
			if ( substr($rdata_ind['TGSPM'],5,2) <= $kdbulan )  $result += $rdata_ind['TOTNILMAK'];
		
		} #END WHILE 
		return $result;
	}
	
	function real_output_spm_bulan($th,$kdsatker,$kdgiat,$kdoutput,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select * from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' AND KDOUTPUT = '$kdoutput' and TGSPM <> '0000-00-00'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		
			if ( substr($rdata_ind['TGSPM'],5,2) == $kdbulan )  $result += $rdata_ind['TOTNILMAK'];
		
		} #END WHILE 
		return $result;
	}
	
	function real_output_spm_sdbulan($th,$kdsatker,$kdgiat,$kdoutput,$kdbulan) { 
		$result = 0 ;
		$sql_ind = "select * from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' AND KDOUTPUT = '$kdoutput' and TGSPM <> '0000-00-00'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		
			if ( substr($rdata_ind['TGSPM'],5,2) <= $kdbulan )  $result += $rdata_ind['TOTNILMAK'];
		
		} #END WHILE 
		return $result;
	}
	
	function real_menteri_sp2d($th,$kddept,$kdunit) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' AND KDGIAT <> '0000' AND NOSP2D <> ' ' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and NOSP2D = '$rdata_ind[NOSP2D]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_spm($th,$kddept,$kdunit) { 
		$result = 0 ;
		
		$data_satker = mysql_query("select KDSATKER from t_satker ");
		while($rdata_satker = mysql_fetch_array($data_satker))
		{
		$kdsatker = $rdata_satker['KDSATKER'];
		
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' AND KDSATKER = '$kdsatker' AND KDGIAT <> '0000'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' AND KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		} #spmind
		
		} #satker
		return $result;
	}
	
	function real_satker_sp2d($th,$kdsatker) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' 
					AND KDGIAT <> '0000' AND NOSP2D <> ' ' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_satker_spm($th,$kdsatker) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' 
					AND KDGIAT <> '0000'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_sp2d($th,$kdsatker,$kdgiat) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and
		KDGIAT = '$kdgiat' AND NOSP2D <> ' ' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_giat_spm($th,$kdsatker,$kdgiat) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and
		KDGIAT = '$kdgiat' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_sp2d($th,$kdsatker,$kdgiat,$kdoutput) { 
		$result = 0 ;
		$sql_ind = "select NOSP2D from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and
		KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput' AND NOSP2D <> ' '"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSP2D = '$rdata_ind[NOSP2D]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_spm($th,$kdsatker,$kdgiat,$kdoutput) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and
		KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		$sql = "select NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]'"; 
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			$result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_menteri_spm_sdbulan_jnsbel($th,$kddept,$kdunit,$kdbulan,$kdbel) { 
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '51'"; 
		break;
		case '52':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524'"; 
		break;
		case '53':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '53' "; 
		break;
		case '524':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,3) = '524'"; 
		break;
		case '57':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and left(KDAKUN,2) = '57' "; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSPM'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		return $result;
	}
	
	function real_satker_spm_sdbulan_jnsbel($th,$kdsatker,$kdbulan,$kdbel) { 
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '51'"; 
		break;
		case '52':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524'"; 
		break;
		case '53':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '53'"; 
		break;
		case '57':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,2) = '57'"; 
		break;
		case '524':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and left(KDAKUN,3) = '524'"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSPM'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		
		return $result;
	}
	
	function real_giat_spm_sdbulan_jnsbel($th,$kdsatker,$kdgiat,$kdbulan,$kdbel) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '51' "; 
		break;
		case '52':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524'"; 
		break;
		case '53':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '53' "; 
		break;
		case '57':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '57' "; 
		break;
		case '524':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,3) = '524' "; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSPM'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}
	
	function real_output_spm_sdbulan_jnsbel($th,$kdsatker,$kdgiat,$kdoutput,$kdbulan,$kdbel) { 
		$result = 0 ;
		$sql_ind = "select NOSPM from m_spmind where THANG = '$th' and KDSATKER = '$kdsatker' and KDGIAT = '$kdgiat' and KDOUTPUT = '$kdoutput'"; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
		/// Data detil
		switch ( $kdbel )
	{
		case '51':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '51' GROUP BY KDAKUN"; 
		break;
		case '52':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '52' and left(KDAKUN,3) <> '524' GROUP BY KDAKUN"; 
		break;
		case '53':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM= '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '53' GROUP BY KDAKUN"; 
		break;
		case '57':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM = '$rdata_ind[NOSPM]' and left(KDAKUN,2) = '57' GROUP BY KDAKUN"; 
		break;
		case '524':
		$sql = "select TGSPM,NILMAK from m_spmmak where THANG = '$th' and KDSATKER = '$kdsatker' and NOSPM= '$rdata_ind[NOSPM]' and left(KDAKUN,3) = '524' GROUP BY KDAKUN"; 
		break;
	}	
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data))
		{
			if ( substr($rdata['TGSPM'],5,2) <= $kdbulan )   $result += $rdata['NILMAK'];
		}
		/// Akhir Data detil
		
		}
		return $result;
	}	
	
?>