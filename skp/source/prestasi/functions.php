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
	
// fungsi untuk mengetahui tanggal terakhir di bulan dan tahun tertentu
function days_in_month($year, $month)
{
        return date("t", strtotime($year . "-" . $month . "-01"));
}

// fungsi untuk mengetahui nama hari
function nama_hari($ymd) {
        $days = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $w = date("w", strtotime($ymd));
        return $days[$w];
}
	function nama_bulan($m) {
		$months = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember","Ke 13");
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

	function status_approv_pegawai($kode) {
		if ($kode == 0 ) $hasil = 'Kirim ke atasan';
		if ($kode == 1 ) $hasil = 'Dikirim';
		return $hasil;
	}

	function status_approv_atasan($kode) {
		if ($kode == 0 ) $hasil = 'Persetujuan?';
		if ($kode == 1 ) $hasil = 'Setuju';
		return $hasil;
	}

	function nm_jabatan_keu($kode) {
		if ($kode == '1' ) $hasil = 'Kuasa Pengguna Anggaran';
		if ($kode == '2' ) $hasil = 'Pejabat Pembuat Komitmen';
		if ($kode == '3' ) $hasil = 'Bendahara Pengeluaran';
		return $hasil;
	}

	function kota_satker($kdsatker) {
	    switch ( $kdsatker )
		{  
		    case '017290' :
			    $hasil = 'Yogyakarta';
			    break;
			case '017283' :
			    $hasil = 'Bandung';
				break;
			case '524334' :
			    $hasil = 'Yogyakarta';
				break;
			default :
			    $hasil = 'Jakarta';
				break;
		}		
		return $hasil;
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
		if ($kode == 5 ) $hasil = 'V';
		if ($kode == 6 ) $hasil = 'VI';
		if ($kode == 7 ) $hasil = 'VII';
		if ($kode == 8 ) $hasil = 'VIII';
		if ($kode == 9 ) $hasil = 'IX';
		if ($kode == 10 ) $hasil = 'X';
		if ($kode == 11 ) $hasil = 'XI';
		if ($kode == 12 ) $hasil = 'XII';
		if ($kode == 13 ) $hasil = 'XIII';
		if ($kode == 14 ) $hasil = 'XIV';
		if ($kode == 15 ) $hasil = 'XV';
		return $hasil;
	}

	function hurufkeangka($kode) {
		if ($kode == 'A' ) $hasil = '1';
		if ($kode == 'B' ) $hasil = '2';
		if ($kode == 'C' ) $hasil = '3';
		if ($kode == 'D' ) $hasil = '4';
		if ($kode == 'E' ) $hasil = '5';
		return $hasil;
	}

	function dateformat($date,$format) {
		$result = date($format, strtotime($date));
		return $result;
	}
	
	function kota_unit($kode) {
		$nmkota='Jakarta';
		if($kode=='23') $nmkota='Bandung';
		if($kode=='22' or $kode=='91') $nmkota='Yogyakarta';
		return($nmkota);
	}

	function reformat_nipbaru($nip) {
		$result = substr($nip,0,8).' '.substr($nip,8,6).' '.substr($nip,14,1).' '.substr($nip,15,3);
		return $result;
	}

	function nm_unitkerja($kode) {
		$data = mysql_query("select nmunit from kd_unitkerja where kdunit='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmunit']);
		return $result;
	}

	function nm_jabatan_eselon1($kode) {
		$data = mysql_query("select nmjabatan from kd_unitkerja where kdunit='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmjabatan']);
		return $result;
	}

	function status_libur($tgl) {
		$data = mysql_query("select status from libur where tanggal='$tgl'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['status']);
		return $result;
	}

	function nm_satker($kode) {
		$data = mysql_query("select nmsatker from kd_satker where kdsatker='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmsatker']);
		return $result;
	}

	function skt_unitkerja($kode) {
		$data = mysql_query("select sktunit from kd_unitkerja where left(kdunit,2)='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['sktunit']);
		return $result;
	}

	function nm_stskawin($kode) {
		$data = mysql_query("select Ket from t_stskawin where KdKawin='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['Ket']);
		return $result;
	}

	function nm_kedudukan_gj($kode) {
		$data = mysql_query("select KetDuduk from t_kedudukan where KdDuduk='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['KetDuduk']);
		return $result;
	}

	function nil_grade($kode) {
		$data = mysql_query("select klsjabatan from kd_jabatan where kode='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['klsjabatan']);
		return $result;
	}

	function rp_grade($kdunit,$kdgrade,$kdpeg) {
	   switch ( $kdunit )
	   {
	    case '23':
		$data = mysql_query("select terima_2 from kd_grade where kd_grade = '$kdgrade'");
		$rdata = mysql_fetch_array($data);
		if ( $kdpeg == '1' )   $result = $rdata['terima_2'];
		if ( $kdpeg == '2' )   $result = $rdata['terima_2'] * 80/100 ;
		break;
		
		case '22':
		$data = mysql_query("select terima_3 from kd_grade where kd_grade = '$kdgrade'");
		$rdata = mysql_fetch_array($data);
		if ( $kdpeg == '1' )   $result = $rdata['terima_3'];
		if ( $kdpeg == '2' )   $result = $rdata['terima_3'] * 80/100 ;
		break;
		
		case '91':
		$data = mysql_query("select terima_3 from kd_grade where kd_grade = '$kdgrade'");
		$rdata = mysql_fetch_array($data);
		if ( $kdpeg == '1' )   $result = $rdata['terima_3'];
		if ( $kdpeg == '2' )   $result = $rdata['terima_3'] * 80/100 ;
		break;

		default:
		$data = mysql_query("select terima_1 from kd_grade where kd_grade = '$kdgrade'");
		$rdata = mysql_fetch_array($data);
		if ( $kdpeg == '1' )   $result = $rdata['terima_1'];
		if ( $kdpeg == '2' )   $result = $rdata['terima_1'] * 80/100 ;
		break;
	}
		return $result;
	}

	function persen_pajak($kode) {
		$data = mysql_query("select pajak from kd_pajak where kdgol = '$kode'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pajak'];
		return $result;
	}

	function nm_gol($kode) {
		$data = mysql_query("select NmGol from kd_gol where KdGol='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NmGol']);
		return $result;
	}
	
	function nm_pangkat($kode) {
		$data = mysql_query("select NmGol2 from kd_gol where KdGol='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NmGol2']);
		return $result;
	}

	function nm_keljabatan($kode) {
		$data = mysql_query("select nmkel from kd_keljabatan where kdkel='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmkel']);
		return $result;
	}


	function nm_eselon($kode) {
		$data = mysql_query("select Nmeselon from kd_eselon where Kdeselon='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['Nmeselon']);
		return $result;
	}

	function nm_jabatan_ij($kode) {
		$data = mysql_query("select kode,nmjabatan from kd_jabatan where kode='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmjabatan']);
		return $result;
	}
	
	function grade_jabatan_ij($kode) {
		$data = mysql_query("select klsjabatan from kd_jabatan where kode='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['klsjabatan']);
		return $result;
	}

	function nm_jabatan($kdunitkerja,$kdeselon,$kdkeljabatan,$kdfungsional) {
		if ( $kdeselon <> '' ){
				if ( $kdunitkerja == '9100' )    $result = 'Ketua '.nm_unitkerja($kdunitkerja) ;
				if ( $kdunitkerja <> '9100' )    $result = 'Kepala '.nm_unitkerja($kdunitkerja) ;
		}else{
			if ( $kdkeljabatan <> '' and $kdfungsional <> ''){
			 	$result =  nm_jabfung($kdkeljabatan,$kdfungsional) ;
			}else{
			    $result = '';
			}
		}
		return $result;
	}
	
	function nm_kedudukan($kode) {
		$data = mysql_query("select NmKedudukan from kd_kedudukan where KdKedudukan='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NmKedudukan']);
		return $result;
	}
	
	function nm_jabfung($kdkeljabatan,$kdfungsional) {
		$data = mysql_query("select nmjabatan from kd_jabatan where kdkel = '$kdkeljabatan' and kdjab = '$kdfungsional' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmjabatan']);
		return $result;
	}

	function nm_info_jabatan($kdunitkerja,$kode_jabatan) {
		$data = mysql_query("select nama_jabatan from mst_info_jabatan where kdunitkerja = '$kdunitkerja' and kode_jabatan = '$kode_jabatan' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nama_jabatan']);
		if ( $result == '' and substr($kode_jabatan,0,3) <> '001' and substr($kode_jabatan,0,2) <> '99' )      $result = nm_jabfung(substr($kode_jabatan,0,3),substr($kode_jabatan,3,2)) ;
		return $result;
	}

	function jml_info_jabatan($kdunitkerja,$kode_jabatan) {
		$data = mysql_query("select jumlah from mst_info_jabatan where kdunitkerja = '$kdunitkerja' and kode_jabatan = '$kode_jabatan' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['jumlah']);
		return $result;
	}

	function nama_peg($kode) {
		$data = mysql_query("select NamaLengkap from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NamaLengkap']);
		return $result;
	}
	
	function nama_pegawai($kode) {
		$data = mysql_query("select NamaLengkap from m_idpegawai where Nip='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['NamaLengkap']);
		return $result;
	}

	function kdeselon_peg($kode) {
		$data = mysql_query("select KdEselon from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['KdEselon']);
		return $result;
	}

	function nip_peg($kode) {
		$data = mysql_query("select Nip from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['Nip']);
		return $result;
	}
	
	function jabatan_peg($kode) {
		$data = mysql_query("select KdUnitKerja,KdEselon,KdKelJabatan,KdFungsional from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim(nm_jabatan($rdata['KdUnitKerja'],$rdata['KdEselon'],$rdata['KdKelJabatan'],$rdata['KdFungsional']));
		return $result;
	}

	function jabstruk_peg($kode) {
		$data = mysql_query("select KdUnitKerja,KdEselon from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		if( $rdata['KdEselon'] <> '' and $rdata['KdUnitKerja'] <> '9100' )   $result = 'Kepala '.trim(nm_unitkerja($rdata['KdUnitKerja']));
		if( $rdata['KdEselon'] <> '' and $rdata['KdUnitKerja'] == '9100' )   $result = 'Ketua'.trim(nm_unitkerja($rdata['KdUnitKerja']));

		if( $rdata['KdEselon'] == '' )   $result = '' ;
		return $result;
	}

	function kdunitkerja_peg($kode) {
		$data = mysql_query("select KdUnitKerja from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['KdUnitKerja'];
		return $result;
	}
	
	function jml_j2($th,$kdunit,$kdjabatan) {
		$data = mysql_query("select count(nib) as jml_j2 from mst_skp where kdunitkerja = '$kdunit' and kdjabatan = '$kdjabatan' and tahun = '$th'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jml_j2'];
		return $result;
	}

	function kdgol_peg($kode) {
		$data = mysql_query("select KdGol from m_idpegawai where Nib='$kode'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['KdGol'];
		return $result;
	}

	function nilai_perhitungan($nib_penilai,$id_skp,$no_tugas) {
		$data_nilai = mysql_query("select jumlah_nilai,kualitas_nilai,waktu_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$jml_data = mysql_num_rows($data_nilai);
		$rdata_nilai = mysql_fetch_array($data_nilai);
		
		$data_target = mysql_query("select jumlah_target,kualitas_target,waktu_target from dtl_skp where id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata_target = mysql_fetch_array($data_target);
		if ($jml_data <> 0 )
		{
		$result = ($rdata_nilai['jumlah_nilai']/$rdata_target['jumlah_target'])*100 + 
				  ($rdata_nilai['kualitas_nilai']/$rdata_target['kualitas_target'])*100 +
				  ((( 1.76 * $rdata_target['waktu_target']) - $rdata_nilai['waktu_nilai']) / $rdata_target['waktu_target'])*100
		;
		}else{
		$result = 0 ;
		}
		return $result;
	}
	
	function nilai_capaian_total($nib_penilai,$id_skp) {
		$no = 0 ;
		$data_nilai = mysql_query("select no_tugas,jumlah_nilai,kualitas_nilai,waktu_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp'");
		while($rdata_nilai = mysql_fetch_array($data_nilai)){
		$no_tugas = $rdata_nilai['no_tugas'];
		$no += 1 ;
		$data_target = mysql_query("select jumlah_target,kualitas_target,waktu_target from dtl_skp where id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata_target = mysql_fetch_array($data_target);
		
		if ( $rdata_target['jumlah_target'] == 0 )   $jumlah_target = $rdata_nilai['jumlah_nilai'] ;
		else $jumlah_target = $rdata_nilai['jumlah_target'] ;
		
		if ( $rdata_target['kualitas_target'] == 0 ) $kualitas_target = $rdata_nilai['kualitas_nilai'] ;
		else $kualitas_target = $rdata_target['kualitas_target'] ;

		if ( $rdata_target['waktu_target'] == 0 ) $waktu_target = $rdata_nilai['waktu_nilai'] ;
		else $waktu_target = $rdata_target['waktu_target'] ;
		
		$penghitungan += ($rdata_nilai['jumlah_nilai']/$jumlah_target)*100 + 
				  ($rdata_nilai['kualitas_nilai']/$kualitas_target)*100 ;
//				  ((( 1.76 * $waktu_target) - $rdata_nilai['waktu_nilai']) / $waktu_target)*100
//		;
//		$penghitungan += ($rdata_nilai['jumlah_nilai']/$rdata_target['jumlah_target'])*100 + 
//				         ($rdata_nilai['kualitas_nilai']/$rdata_target['kualitas_target'])*100 +
//        				 ($rdata_target['waktu_target']/ $rdata_target['waktu_target'])*100	;
		}
		if ( $no == 0 )  $result = 0 ;
		if ( $no <> 0 )  $result = ($penghitungan/3)/$no ;
		return $result;
	}

	function nilai_total($nib_penilai,$id_skp) {
		$no = 0 ;
		$data_nilai = mysql_query("select nilai_capaian from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp'");
		while($rdata_nilai = mysql_fetch_array($data_nilai)){
		$no += 1 ;
		$penghitungan += $rdata_nilai['nilai_capaian'];
		}
		if ( $no == 0 )  $result = 0 ;
		if ( $no <> 0 )  $result = $penghitungan/$no ;
		return $result;
	}

	function perilaku_total($id_skp) {
		$no = 0 ;
		$data_nilai = mysql_query("select * from dtl_penilaian_perilaku where id_skp = '$id_skp'");
		$rdata_nilai = mysql_fetch_array($data_nilai);
		$penghitungan = $rdata_nilai['nilai_1'] +
						$rdata_nilai['nilai_2'] +
						$rdata_nilai['nilai_3'] +
						$rdata_nilai['nilai_4'] +
						$rdata_nilai['nilai_5'] +
						$rdata_nilai['nilai_6'] ;
		if ( $rdata_nilai['nilai_6'] == 0  )   $n = 5 ;
		else   $n = 6 ;
		return $penghitungan/$n;
	}

	function nama_nilai($kode) {
		if ($kode >= 91 ) 					$hasil = 'Sangat Baik';
		if ($kode <= 90 and $kode >= 76 ) 	$hasil = 'Baik';
		if ($kode <= 75 and $kode >= 61 ) 	$hasil = 'Cukup';
		if ($kode <= 60 and $kode >= 51 ) 	$hasil = 'Kurang';
		if ($kode <= 50 and $kode >= 0 ) 	$hasil = 'Buruk';
		return $hasil;
	}
	
	function status_peg($kode) {
		if ($kode == 1 )  $hasil = 'PNS';
		if ($kode == 2 )  $hasil = 'CPNS';
		return $hasil;
	}

	function biaya_jab($gaji) {
         $biaya_jab = $gaji * (5/100) ;
		 if ( $biaya_jab >= 500000 )    $biaya_jab = 500000 ;
		return $biaya_jab;
	}
	
	function nil_ptkp($kdstkawin) {
		$data = mysql_query("select ptkp from t_stskawin where KdKawin = '$kdstkawin'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['ptkp'];
		return $result;
	}
	
	function hari_bulan($th,$bl) {
	    if ( substr($bl,0,1) == '0' )   $bl = substr($bl,1,1) ;
		$data = mysql_query("select jmlhari from ref_jmlhari where bulan = '$bl' and tahun = '$th'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jmlhari'];
		return $result;
	}

	function persen_pot($kdpot) {
		$data = mysql_query("select nilpot from ref_potongan where kdpot = '$kdpot'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nilpot'];
		return $result;
	}
/*
	function nil_pajak($gaji,$kdstkawin,$iwp) {
	     $x = 12 * ( $gaji - $iwp - biaya_jab($gaji) ) ;
         $pkp = $x - nil_ptkp($kdstkawin) ;
         if ( $pkp > 500000000 )                           $pajak = ( $pkp * (30/100))/12 ;
         if ( $pkp <= 500000000 and $pkp > 250000000 )     $pajak = ( $pkp * (25/100))/12 ;
         if ( $pkp <= 250000000 and $pkp > 50000000 )      $pajak = ( $pkp * (15/100))/12 ;
         if ( $pkp <= 50000000 )                           $pajak = ( $pkp * (5/100))/12 ;
		return $pajak;
	}
*/

	function nil_pajak($gaji,$kdstkawin,$iwp) {
	     $x = 12 * ( $gaji - $iwp - biaya_jab($gaji) ) ;
         $pkp = $x - nil_ptkp($kdstkawin) ;
         if ( $pkp > 500000000 )  
		 {
		     $pajak_1 = 50000000 * 0.05 ;
			 $pajak_2 = 200000000 * 0.15 ;
			 $pajak_3 = 250000000 * 0.25 ;
			 $pajak_4 = ( $pkp - 500000000 ) * 0.30 ; 
		     $pajak = ( $pajak_1 + $pajak_2 + $pajak_3 + $pajak_4 ) /12 ;
         }elseif ( $pkp <= 500000000 and $pkp > 250000000 ) {
		     $pajak_1 = 50000000 * 0.05 ;
			 $pajak_2 = 200000000 * 0.15 ;
			 $pajak_3 = ( $pkp - 250000000 ) * 0.25 ; 
		     $pajak = ( $pajak_1 + $pajak_2 + $pajak_3 ) /12 ;
         }elseif ( $pkp <= 250000000 and $pkp > 50000000 ) {
		     $pajak_1 = 50000000 * 0.05 ;
			 $pajak_2 = ( $pkp - 50000000 ) * 0.15 ; 
		     $pajak = ( $pajak_1 + $pajak_2 ) /12 ;
         }elseif ( $pkp <= 50000000 ) {
		     $pajak = ( $pkp * 0.05)/12 ;
		 }
		return $pajak;
	}
	
	function kdsatker_unit($kdunit) {
		$data = mysql_query("select kdsatker from kd_satker where kdunitkerja = '$kdunit'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['kdsatker'];
		return $result;
	}
	
	function nip_mst_tk($nib) {
		$data = mysql_query("select nip from mst_tk where nib = '$nib'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nip'];
		return $result;
	}
	
	function kdgol_mst_tk($nib) {
		$data = mysql_query("select kdgol from mst_tk where nib = '$nib'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['kdgol'];
		return $result;
	}

	function nmjabatan_mst_tk($nib,$th,$kdbulan) {
		$data = mysql_query("select kdunitkerja,kdjabatan from mst_tk where nib = '$nib' and tahun = '$th' and bulan = '$kdbulan' ");
		$rdata = mysql_fetch_array($data);
		$result = nm_info_jabatan($rdata['kdunitkerja'],$rdata['kdjabatan']);
		return $result;
	}
	
	function kdpeg_mst_tk($nib,$th,$kdbulan) {
		$data = mysql_query("select kdpeg from mst_tk where nib = '$nib' and tahun = '$th' and bulan = '$kdbulan'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['kdpeg'];
		return $result;
	}
	
	function tunker_mst_tk($nib,$th,$kdbulan,$grade) {
		$data = mysql_query("select tunker from mst_tk where nib = '$nib' and tahun = '$th' and bulan = '$kdbulan' and grade = '$grade'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['tunker'];
		return $result;
	}
	
	function jmlpeg_bulan($th,$kdbulan,$kdsatker) {
		$result = 0 ;
		$data = mysql_query("select distinct nib from mst_tk where tahun = '$th' and bulan = '$kdbulan' and kdsatker = '$kdsatker'");
		$result = mysql_num_rows($data);
		return $result;
	}
	
	function nib_pejabat($th,$kdsatker,$kdpejabat) {
		$data = mysql_query("select nib from ref_pejabat where th = '$th' and kdpejabat = '$kdpejabat' and kdsatker = '$kdsatker'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nib'];
		return $result;
	}
	
	function nm_kelompok_bantu($kdjab,$kdkelompok) {
		$data = mysql_query("select nmkelompok from  t_kelompok where kdjab = '$kdjab' and kdkelompok = '$kdkelompok'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nmkelompok'];
		return $result;
	}
?>