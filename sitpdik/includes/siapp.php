<?php
	#@
	#-=-=-=-=-=-=-=-=-=-=- Table alasan -=-=-=-=-=-=-=-=-=-=-#
	
	function alasan($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("alasan",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function alasan_id($kode_alasan) 
	{
		$query = alasan("kode = '".$kode_alasan."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table cuti -=-=-=-=-=-=-=-=-=-=-#
	
	function cuti($u,$where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("cuti_".$u,$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function get_jumlah_cuti($u,$nip,$tahun)
	{
		$query = cuti($u,"nip = '".$nip."' AND tahun = '".$tahun."'","");
		$result = mysql_fetch_array($query);
		
		return $result['jumlah'];
	}
	
	function cuti_list($kode_bidang,$tahun) 
	{
		$u = substr($kode_bidang,0,2);
		
		$sql = "
			SELECT 
				a.id,
				a.nip,
				a.tahun,
				a.jumlah,
				b.nama,
				b.nip_baru,
				b.kode_bidang,
				d.nama as nama_bidang 
			FROM 
				cuti_".$u." a LEFT JOIN 
				pegawai b ON a.nip = b.nip LEFT JOIN 
				unit d ON b.kode_bidang = d.kode 
			WHERE 
				b.kode_bidang LIKE '".$kode_bidang."%' AND 
				a.tahun = '".$tahun."' AND 
				(
					b.status = '01' OR 
					b.status = '02' OR 
					b.status = '06' OR 
					b.status = '07' OR 
					b.status = '16'
				) 
			ORDER BY 
				b.kode_bidang,
				b.jabatan_struktural DESC,
				b.kode_golongan DESC,
				b.nip
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function cuti_pegawai($kode_bidang,$tahun,$nip) 
	{
		$u = substr($kode_bidang,0,2);
		
		$sql = "
			SELECT 
				a.id,
				a.nip,
				a.tahun,
				a.jumlah,
				b.nama,
				b.nip_baru,
				b.kode_bidang,
				d.nama as nama_bidang 
			FROM 
				cuti_".$u." a LEFT JOIN 
				pegawai b ON a.nip = b.nip LEFT JOIN 
				unit d ON b.kode_bidang = d.kode 
			WHERE 
				a.tahun = '".$tahun."' AND 
				a.nip = '".$nip."'
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function cuti_list_2($KdUnitKerja,$tahun) 
	{
		$u = substr($KdUnitKerja,0,2);
		
		$sql = "
			SELECT 
				a.id,
				a.nip,
				a.tahun,
				a.jumlah,
				b.NamaLengkap,
				b.Nip,
				b.KdUnitKerja,
				d.nama as nama_bidang 
			FROM 
				cuti_".$u." a LEFT JOIN 
				m_idpegawai b ON a.nip = b.Nib LEFT JOIN 
				unit d ON b.KdUnitKerja = d.kode 
			WHERE 
				b.KdUnitKerja LIKE '".$kode_bidang."%' AND 
				a.tahun = '".$tahun."' AND 
				(
					b.KdStatusPeg = '1' OR 
					b.KdStatusPeg = '2'
				) 
			ORDER BY 
				b.KdUnitKerja,
				b.KdEselon DESC,
				b.KdGol DESC,
				b.Nib
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table golongan = kd_gol -=-=-=-=-=-=-=-=-=-=-#
	
	function golongan($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("golongan",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function golongan_list() 
	{
		$query = golongan("","KdGol");
		
		return $query;
		
	}
	
	function golongan_id($kode_golongan) 
	{
		$query = golongan("KdGol = '".$kode_golongan."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table import -=-=-=-=-=-=-=-=-=-=-#
	
	function import($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("import",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function last_import($u)
	{
		$oImport = import("`".$u."` = '1'","date_until DESC");
		$Import = mysql_fetch_array($oImport);
		
		return $Import['date_until'];
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table jadwal_kerja -=-=-=-=-=-=-=-=-=-=-#
	
	function jadwal_kerja($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("jadwal_kerja",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function jadwal_kerja_id($kode) 
	{
		$query = jadwal_kerja("kode = '".$kode."'");
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table jadwal_shift -=-=-=-=-=-=-=-=-=-=-#
	
	function jadwal_shift($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("jadwal_shift",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function jadwal_shift_id($date,$nip) 
	{
		$query = jadwal_shift("nip = '".$nip."' AND tanggal = '".$date."'","jam_masuk");
		$result = mysql_fetch_array($query);
		$jadwal_shift = $result['jam_kerja'];
		
		return $jadwal_shift;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table jam_kerja -=-=-=-=-=-=-=-=-=-=-#
	
	function jam_kerja($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("jam_kerja",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function jam_kerja_list($u) 
	{
		$query = jam_kerja("kode LIKE '".$u."%'","kode");
		
		return $query;
	}
	
	function jam_kerja_id($kode) 
	{
		$query = jam_kerja("kode = '".$kode."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function jam_masuk($tanggal,$nip) 
	{
		$Pegawai = pegawai_id($nip);
		$kode_jadwal_kerja = $Pegawai->jadwal_kerja;
		$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
		
		if (mysql_num_rows($oJadwalKerja) != 0)
		{
			$oJadwalKerja2 = jadwal_kerja("date_from <= '".$tanggal."' AND date_until >= '".$tanggal."'");
			$nJadwalKerja2 = mysql_num_rows($oJadwalKerja2);
			
			if ($nJadwalKerja2 == 0) $JadwalKerja = mysql_fetch_array($oJadwalKerja);
			else $JadwalKerja = mysql_fetch_array($oJadwalKerja2);
			
			$nama_hari = strtolower(nama_hari($tanggal));
			$kode_jam_kerja = $JadwalKerja[$nama_hari];
			$JamKerja = jam_kerja_id($kode_jam_kerja);
			$jam_masuk = substr($JamKerja->jam_masuk,0,5);
		}
		else
		{
			$oJadwalShift = jadwal_shift("tanggal = '".$tanggal."' AND nip = '".$nip."'");
			$JadwalShift = mysql_fetch_array($oJadwalShift);
			$jam_masuk = $JadwalShift['jam_masuk'];
		}
		
		return $jam_masuk;
	}
	
	function jam_keluar($tanggal,$nip) 
	{
		$Pegawai = pegawai_id($nip);
		$kode_jadwal_kerja = $Pegawai->jadwal_kerja;
		$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
		
		if (mysql_num_rows($oJadwalKerja) != 0)
		{
			$oJadwalKerja2 = jadwal_kerja("date_from <= '".$tanggal."' AND date_until >= '".$tanggal."'");
			$nJadwalKerja2 = mysql_num_rows($oJadwalKerja2);
			
			if ($nJadwalKerja2 == 0) $JadwalKerja = mysql_fetch_array($oJadwalKerja);
			else $JadwalKerja = mysql_fetch_array($oJadwalKerja2);
			
			$nama_hari = strtolower(nama_hari($tanggal));
			$kode_jam_kerja = $JadwalKerja[$nama_hari];
			$JamKerja = jam_kerja_id($kode_jam_kerja);
			$jam_keluar = substr($JamKerja->jam_keluar,0,5);
		}
		else
		{
			$oJadwalShift = jadwal_shift("tanggal = '".$tanggal."' AND nip = '".$nip."'");
			$JadwalShift = mysql_fetch_array($oJadwalShift);
			$jam_keluar = $JadwalShift['jam_keluar'];
		}
		
		return $jam_keluar;
	}
	
	function kekurangan_masuk($tanggal,$jam,$nip) 
	{
		$batas_masuk = jam_masuk($tanggal,$nip);
		$result = selisih_waktu($batas_masuk,$jam);
		
		return $result;
	}
	
	function kekurangan_keluar($tanggal,$jam,$nip) 
	{
		$batas_keluar = jam_keluar($tanggal,$nip);
		$result = selisih_waktu($jam,$batas_keluar);
			
		return $result;
	}
	
	function cek_TL1($TL1,$tanggal,$nip,$jam,$kekurangan)
	{
		$oJadwalKerja = jadwal_kerja("date_from <= '".$tanggal."' AND date_until >= '".$tanggal."'");
		$nJadwalKerja = mysql_num_rows($oJadwalKerja);
		
		if ($nJadwalKerja == 0)
		{
			if ($TL1 == 1)
			{
				$batas_keluar = jam_keluar($tanggal,$nip);
				$selisih = (60 * (substr($jam ,0,2) - substr($batas_keluar,0,2))) + substr($jam,3,2) - substr($batas_keluar,3,2);
									
				if ($selisih >= $kekurangan) $TL1 = 0;
			}
		}
		
		return $TL1;
	}
	
	function cek_1234($Kekurangan)
	{
		$TL_PSW = array(0,0,0,0,0);
		
		if ($Kekurangan >= 1 and $Kekurangan <= 30) $TL_PSW[1] = 1;
		else if ($Kekurangan >= 31 and $Kekurangan <= 60) $TL_PSW[2] = 1;
		else if ($Kekurangan >= 61 and $Kekurangan <= 90) $TL_PSW[3] = 1;
		else if ($Kekurangan > 90) $TL_PSW[4] = 1;
		
		return $TL_PSW;
	}
	
	function kekurangan_keluar_sementara($tanggal,$jam,$jam2)
	{
		$hari = strtolower(nama_hari($tanggal));
		
		if ($tanggal >= "2013-07-10" and $tanggal <= "2013-08-09")
		{			
			if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I4");
			else $jam_istirahat = jam_kerja_id("I3");
		}
		else
		{
			if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I2");
			else $jam_istirahat = jam_kerja_id("I1");
		}
		
		$istirahat_awal = $jam_istirahat->jam_keluar;
		$istirahat_akhir = $jam_istirahat->jam_masuk;
		
		if ($jam > $jam2)
		{
			$jam3 = $jam;
			$jam = $jam2;
			$jam2 = $jam3;
		}
		
		if ($jam < $istirahat_awal)
		{
			if ($jam2 < $istirahat_awal) $kekurangan = selisih_waktu($jam,$jam2);
			else if ($jam2 >= $istirahat_awal and $jam2 <= $istirahat_akhir) $kekurangan = selisih_waktu($jam,$istirahat_awal);
			else $kekurangan = selisih_waktu($jam,$istirahat_awal) + selisih_waktu($istirahat_akhir,$jam2);
		}
		else if ($jam >= $istirahat_awal and $jam <= $istirahat_akhir)
		{
			if ($jam2 >= $istirahat_awal and $jam2 <= $istirahat_akhir) $kekurangan = 0;
			else $kekurangan = selisih_waktu($istirahat_akhir,$jam2);
		}
		else $kekurangan = selisih_waktu($jam,$jam2);
		
		return $kekurangan;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table jenis_shift -=-=-=-=-=-=-=-=-=-=-#
		
	function jenis_shift($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("jenis_shift",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function jenis_shift_list($u) 
	{
		$query = jenis_shift("kode LIKE '".$u."%'","kode");
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table libur -=-=-=-=-=-=-=-=-=-=-#
		
	function libur($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("libur",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function libur_list($tahun,$status) 
	{
		$query = libur("tanggal LIKE '".$tahun."%' AND status LIKE '%".$status."%'","tanggal");
		
		return $query;
	}
	
	function get_jumlah_cuti_bersama($tahun)
	{
		$query = libur_list($tahun,"C");
		$jumlah = mysql_num_rows($query);
		
		return $jumlah;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table pegawai = m_idpegawai -=-=-=-=-=-=-=-=-=-=-#
		
	function pegawai($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("pegawai",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function pegawai_list($kode_bidang,$wordkey = "",$aktif = 0,$sort_by) 
	{
		if ($aktif == 1)
		{
			if ($wordkey == "") 
			{
				$query = pegawai("kode_bidang LIKE '".$kode_bidang."%' AND (status = '01' OR status = '02' OR status = '06' OR status = '07' OR 
				status = '16')",$sort_by);
			}
			else 
			{
				$query = pegawai("(kode_bidang LIKE '".$kode_bidang."%') AND (nip LIKE '%".$wordkey."%' OR nip_baru LIKE '%".$wordkey."%' OR 
				nama LIKE '%".$wordkey."%') AND (status = '01' OR status = '02' OR status = '06' OR status = '07' OR status = '16')",$sort_by);
			}
		}
		else
		{
			if ($wordkey == "") $query = pegawai("kode_bidang LIKE '".$kode_bidang."%'",$sort_by);
			else 
			{
				$query = pegawai("(kode_bidang LIKE '".$kode_bidang."%') AND (nip LIKE '%".$wordkey."%' OR nip_baru LIKE '%".$wordkey."%' OR 
				nama LIKE '%".$wordkey."%')",$sort_by);
			}
		}
		
		return $query;
	}
	
	function pegawai_id($nip) 
	{
		$query = pegawai("nip = '".$nip."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function pegawai_presensi($kode_bidang) 
	{
		$query = pegawai("kode_bidang LIKE '".$kode_bidang."%' AND (status = '01' OR status = '02' OR status = '06' OR status = '07' OR 
		status = '16')","kode_bidang,jabatan_struktural DESC,kode_golongan DESC,nip");
			
		return $query;
	}
	
	function get_kapus($kode_unit) 
	{
		$query = pegawai("kode_bidang LIKE '".$kode_unit."00' AND jabatan_struktural = '21'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function get_atasan($nip) 
	{
		$Pegawai = pegawai_id($nip);
		
		if ($Pegawai->status_jab == 1)
		{
			$kode_bidang = $Pegawai->kode_bidang;
			$cek = substr($kode_bidang,-2);
			
			if ($cek == '00') $query = pegawai("kode_bidang LIKE '".substr($kode_bidang,0,2)."10'");
			else
			{
				$cek = substr($kode_bidang,-1);
				
				if ($cek != '0') $query = pegawai("kode_bidang LIKE '".substr($kode_bidang,0,3)."0' AND status_jab = '1'");
				else $query = pegawai("kode_bidang LIKE '".substr($kode_bidang,0,2)."00' AND status_jab = '1'");
			}
		}
		else $query = pegawai("kode_bidang LIKE '".$Pegawai->kode_bidang."' AND status_jab = '1'");
		
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function get_jabatan($nip)
	{
		$Pegawai = pegawai_id($nip);
		
		if ($Pegawai->jabatan_struktural == 0)
		{
			$JabFung = kd_fungsional_id($Pegawai->jabatan_fungsional);
			$jabatan = $JabFung['NmFungsi'];
		}
		else
		{
			if (substr($Pegawai->kode_bidang,0,3) == "000")
			{
				$deputi = substr($Pegawai->kode_bidang,3,1);
				
				switch ($deputi)
				{
					case "0": 
						
						$jabatan = "Kepala Badan Tenaga Nuklir Nasional"; 
					
					break;
					
					case "1": 
					
						$jabatan = "Sekretaris Utama"; 
					
					break;
					
					case "2": 
					
						$jabatan = "Deputi Kepala Bidang Penelitian Dasar dan Terapan"; 
					
					break;
					
					case "3": 
					
						$jabatan = "Deputi Kepala Bidang Pengembangan Teknologi dan Energi Nuklir"; 
					
					break;
					
					case "4": 
					
						$jabatan = "Deputi Kepala Bidang Pengembangan Teknologi Daur Bahan Nuklir dan Rekayasa"; 
					
					break;
					
					case "5": 
					
						$jabatan = "Deputi Kepala Bidang Pendayagunaan Hasil Litbang & Pemasyarakatan Ilmu Pengetahuan dan Teknologi Nuklir"; 
						
					break;
				}
			}
			else
			{
				$bidang = subbidang_id($Pegawai->kode_bidang);
				$jabatan = "Kepala ".$bidang->nama;
			}
		}
		
		return $jabatan;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table presensi -=-=-=-=-=-=-=-=-=-=-#
		
	function presensi($u,$where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("presensi_".$u,$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function presensi_id($id,$u) 
	{
		$query = presensi($u,"id = '".$id."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function absensi_list($kode_unit,$nip,$bulan,$tanggal,$kode_alasan) 
	{
		if ($kode_alasan == "") $kode_alasan = "%".$kode_alasan."%";
		
		$sql = "
			SELECT 
				a.id,
				a.tanggal,
				b.nama,
				a.kode_alasan,
				a.keterangan 
			FROM 
				presensi_".$kode_unit." a LEFT JOIN 
				pegawai b ON a.nip = b.nip 
			WHERE 
				b.kode_bidang LIKE '".$kode_unit."%' AND 
				(
					b.status = '02' OR 
					b.status = '16'
				) AND 
				a.jam = '00:00:00' AND 
				a.status = '' AND 
				a.nip LIKE '%".$nip."%' AND 
				a.tanggal LIKE '".$bulan."%' AND 
				a.kode_alasan != 'TB' AND 
				a.kode_alasan != 'DPK/DPB' AND 
				a.tanggal LIKE '%".$tanggal."%' AND 
				a.kode_alasan LIKE '".$kode_alasan."' 
			ORDER BY 
				a.tanggal,
				a.nip
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function get_cuti_tahunan($u,$nip,$y)
	{
		$cuti = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		
		$sql = "
			SELECT 
				MID(tanggal,6,2) AS bulan,
				sum(CT) AS cuti 
			FROM presensi_".$u." 
			WHERE 
				nip = '".$nip."' AND 
				tanggal LIKE '".$y."%' AND
				CT = '1' 
			GROUP BY LEFT(tanggal,7)
		";
		
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query))
		{
			$k = $result['bulan'] + 0;
			$cuti[$k] = $result['cuti'];
		}
		
		return $cuti;
	}
	
	function get_cuti($u,$nip,$y)
	{
		$cuti = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		
		$sql = "
			SELECT 
				MID(tanggal,6,2) AS bulan,
				sum(cuti) AS cuti 
			FROM presensi_".$u." 
			WHERE 
				nip = '".$nip."' AND 
				tanggal LIKE '".$y."%' AND 
				cuti = '1' AND 
				CT = '1' 
			GROUP BY LEFT(tanggal,7)
		";
		
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query))
		{
			$k = $result['bulan'] + 0;
			$cuti[$k] = $result['cuti'];
		}
		
		return $cuti;
	}
	
	function get_potong_cuti($u,$nip,$y)
	{
		$potong_cuti = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		
		$sql = "
			SELECT 
				MID(tanggal,6,2) AS bulan,
				sum(izin) AS izin 
			FROM presensi_".$u." 
			WHERE 
				nip = '".$nip."' AND 
				tanggal LIKE '".$y."%' AND 
				izin = '1' AND 
				CT = '1' 
			GROUP BY LEFT(tanggal,7)
		";
		
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query))
		{
			$k = $result['bulan'] + 0;
			$potong_cuti[$k] = $result['izin'];
		}
		
		return $potong_cuti;
	}
	
	function insert_new_presensi($nip,$tanggal,$jam,$src) 
	{
		#echo $nip." - ".$tanggal." - ".$jam." - ".$src."<BR>";
		
		if ($nip != "")
		{
			$TL[1] = 0;
			$TL[2] = 0;
			$TL[3] = 0;
			$TL[4] = 0;
								
			$PSW[1] = 0;
			$PSW[2] = 0;
			$PSW[3] = 0;
			$PSW[4] = 0;
			
			$m = substr($tanggal,0,7);
			
			$Pegawai = pegawai_id($nip);
			$u = substr($Pegawai->kode_bidang,0,2);
			$kode_jadwal_kerja = $Pegawai->jadwal_kerja;
			
			$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
			
			cek_rekapitulasi($nip,$m,$u);
			
			if (mysql_num_rows($oJadwalKerja) != 0)
			{
				$oJadwalKerja2 = jadwal_kerja("date_from <= '".$tanggal."' AND date_until >= '".$tanggal."'");
				$nJadwalKerja2 = mysql_num_rows($oJadwalKerja2);
				
				if ($nJadwalKerja2 == 0) $JadwalKerja = mysql_fetch_array($oJadwalKerja);
				else $JadwalKerja = mysql_fetch_array($oJadwalKerja2);
				
				$NamaHari = strtolower(nama_hari($tanggal));
				$JamKerja = $JadwalKerja[$NamaHari];
				
				$oPresensi = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam = '".$jam."' AND (status = '0' OR status = '1' OR 
				status = '9')");
				
				$nPresensi = mysql_num_rows($oPresensi);
				
				if ($nPresensi == 0)
				{	
					$oPresensi2 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND (status = '0' OR status = '1' OR status = '9')","jam");
					$nPresensi2 = mysql_num_rows($oPresensi2);
					
					if ($nPresensi2 == 0) 
					{
						$oLibur = libur("tanggal = '".$tanggal."'");
						$nLibur = mysql_num_rows($oLibur);
						$hari = strtolower(nama_hari($tanggal));
						
						if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
						{
							$status = "1";
							$kode_alasan = "";
							$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
							$hadir = 1;
							$TL = cek_1234($kekurangan);
							
							$sql = "
								INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
								VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
								'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$JamKerja."','".$src."','10')
							";
							
							#echo "10. ".$sql."<br>";
							
							$query = mysql_query($sql);
						}
						else $query = true;
					}
					else if ($nPresensi2 == 1) 
					{
						$Presensi2 = mysql_fetch_array($oPresensi2);
							
						if ($Presensi2['jam'] == '00:00:00') 
						{
							$oLibur = libur("tanggal = '".$tanggal."'");
							$nLibur = mysql_num_rows($oLibur);
							$hari = strtolower(nama_hari($tanggal));
							
							if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
							{
								$status = "1";
								$kode_alasan = "";
								$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
								$hadir = 1;
								$TL = cek_1234($kekurangan);
								
								$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi2['id']."'";
								$query = mysql_query($sql);
								
								$sql = "
									INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
									VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
									'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$JamKerja."','".$src."','11')
								";
								
								#echo "11. ".$sql."<br>";
								
								$query = mysql_query($sql);
							}
							else $query = true;
						}
						else 
						{
							if ($jam < $Presensi2['jam'])
							{
								$oLibur = libur("tanggal = '".$tanggal."'");
								$nLibur = mysql_num_rows($oLibur);
								$hari = strtolower(nama_hari($tanggal));
								
								if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
								{
									$status = "1";
									$kode_alasan = "";
									$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
									$hadir = 1;
									$TL = cek_1234($kekurangan);								
									$TL[1] = cek_TL1($TL[1],$tanggal,$nip,$Presensi2['jam'],$kekurangan);
								
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 	
										VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
										'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$JamKerja."','".$src."','12')
									";
									
									#echo "12. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$status = "9";
									$kode_alasan = "";
									$kekurangan = get_kekurangan($nip,$tanggal,$Presensi2['jam'],$status,$kode_alasan);
									$hadir = 0;
									$TL[1] = 0;
									$TL[2] = 0;
									$TL[3] = 0;
									$TL[4] = 0;
									$PSW = cek_1234($kekurangan);
									
									$sql = "
										UPDATE presensi_".$u." 
										SET 
											status = '".$status."',
											kekurangan = '".$kekurangan."',
											hadir = '".$hadir."',
											TL1 = '".$TL[1]."',
											TL2 = '".$TL[2]."',
											TL3 = '".$TL[3]."',
											TL4 = '".$TL[4]."',
											PSW1 = '".$PSW[1]."',
											PSW2 = '".$PSW[2]."',
											PSW3 = '".$PSW[3]."',
											PSW4 = '".$PSW[4]."',
											cek = '13'
										WHERE id = '".$Presensi2['id']."'
									";
									
									#echo "13. ".$sql."<br>";
									
									$query = mysql_query($sql);
								}
								else $query = true;
							}
							else 
							{
								$oLibur = libur("tanggal = '".$tanggal."'");
								$nLibur = mysql_num_rows($oLibur);
								$hari = strtolower(nama_hari($tanggal));
								
								if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
								{
									$TL[1] = cek_TL1($Presensi2['TL1'],$tanggal,$nip,$jam,$Presensi2['kekurangan']);
								}
								
								if ($TL[1] != $Presensi2['TL1'])
								{
									$sql = "UPDATE presensi_".$u." SET TL1 = '".$TL[1]."',cek = '14' WHERE id = '".$Presensi2['id']."'";
									
									#echo "14. ".$sql."<br>";
									
									$query = mysql_query($sql);
								}
								
								$oLibur = libur("tanggal = '".$tanggal."'");
								$nLibur = mysql_num_rows($oLibur);
								$hari = strtolower(nama_hari($tanggal));
								
								if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
								{
									$status = "9";
									$kode_alasan = "";
									$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
									$PSW = cek_1234($kekurangan);
								
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$PSW[1]."',
										'".$PSW[2]."','".$PSW[3]."','".$PSW[4]."','".$JamKerja."','".$src."','15')
									";
									
									#echo "15. ".$sql."<br>";
									
									$query = mysql_query($sql);
								}
								else $query = true;
							}
						}
					}
					else 
					{
						$oPresensi3 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '1'");
						$Presensi3 = mysql_fetch_array($oPresensi3);
						
						if ($jam < $Presensi3['jam'])
						{
							$oLibur = libur("tanggal = '".$tanggal."'");
							$nLibur = mysql_num_rows($oLibur);
							$hari = strtolower(nama_hari($tanggal));
							
							if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
							{
								$status = "1";
								$kode_alasan = "";
								$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
								$hadir = 1;
								$TL = cek_1234($kekurangan);
								
								$oPresensi4 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
								$Presensi4 = mysql_fetch_array($oPresensi4);
								
								$TL[1] = cek_TL1($TL[1],$tanggal,$nip,$Presensi4['jam'],$kekurangan);
								
								$sql = "
									INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
									VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
									'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$JamKerja."','".$src."','16')
								";
								
								#echo "16. ".$sql."<br>";
								
								$query = mysql_query($sql);
								
								$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi3['id']."'";
								$query = mysql_query($sql);
							}
							else $query = true;
						}
						else
						{
							$oPresensi4 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
							$Presensi4 = mysql_fetch_array($oPresensi4);
							
							if ($jam > $Presensi4['jam'])
							{
								$oLibur = libur("tanggal = '".$tanggal."'");
								$nLibur = mysql_num_rows($oLibur);
								$hari = strtolower(nama_hari($tanggal));
								
								if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
								{
									$oPresensi5 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '1'");
									$Presensi5 = mysql_fetch_array($oPresensi5);
									$TL[1] = cek_TL1($Presensi5['TL1'],$tanggal,$nip,$jam,$Presensi5['kekurangan']);
								}
								
								if ($TL[1] != $Presensi5['TL1'])
								{
									$sql = "UPDATE presensi_".$u." SET TL1 = '".$TL[1]."',cek = '17' WHERE id = '".$Presensi5['id']."'";
									
									#echo "17. ".$sql."<br>";
									
									$query = mysql_query($sql);
								}
								
								$oLibur = libur("tanggal = '".$tanggal."'");
								$nLibur = mysql_num_rows($oLibur);
								$hari = strtolower(nama_hari($tanggal));
								
								if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
								{
									$status = "9";
									$kode_alasan = "";
									$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
									$PSW = cek_1234($kekurangan);
								
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$PSW[1]."',
										'".$PSW[2]."','".$PSW[3]."','".$PSW[4]."','".$JamKerja."','".$src."','18')
									";
									
									#echo "18. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi4['id']."'";
									$query = mysql_query($sql);
								}
								else $query = true;
							}
							else $query = true;
						}
					}
				}
				else $query = true;
			}
			else
			{
				$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
				
				$oJadwalShiftKemarin = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
				$nJadwalShiftKemarin = mysql_num_rows($oJadwalShiftKemarin);
				
				if ($nJadwalShiftKemarin != 0)
				{
					$JadwalShiftKemarin = mysql_fetch_array($oJadwalShiftKemarin);
					$oId[] = $JadwalShiftKemarin['id'];
					$oNip[] = $JadwalShiftKemarin['nip'];
					$oTanggal[] = $JadwalShiftKemarin['tanggal'];
					$oJamKerja[] = $JadwalShiftKemarin['jam_kerja'];
					$oJamMasuk[] = $JadwalShiftKemarin['jam_masuk'];
					$oJamKeluar[] = $JadwalShiftKemarin['jam_keluar'];
					$oCekMasuk[] = $JadwalShiftKemarin['cek_masuk'];
					$oCekKeluar[] = $JadwalShiftKemarin['cek_keluar'];
					$oCek[] = $JadwalShiftKemarin['cek'];
				}
				
				$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
				$nJadwalShift = mysql_num_rows($oJadwalShift);
				
				if ($nJadwalShift != 0)
				{
					while ($JadwalShift = mysql_fetch_array($oJadwalShift))
					{
						$oId[] = $JadwalShift['id'];
						$oNip[] = $JadwalShift['nip'];
						$oTanggal[] = $JadwalShift['tanggal'];
						$oJamKerja[] = $JadwalShift['jam_kerja'];
						$oJamMasuk[] = $JadwalShift['jam_masuk'];
						$oJamKeluar[] = $JadwalShift['jam_keluar'];
						$oCekMasuk[] = $JadwalShift['cek_masuk'];
						$oCekKeluar[] = $JadwalShift['cek_keluar'];
						$oCek[] = $JadwalShift['cek'];
					}
				}
				
				$n = count(@$oId);
				
				if ($n > 0)
				{
					for ($k = 0; $k < $n; $k++)
					{
						#echo "<BR>";
						
						if ($oCekMasuk[$k] == 0)
						{
							$oPresensi = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."'","status");
							$nPresensi = mysql_num_rows($oPresensi);
							
							if ($nPresensi == 0)
							{
								$status = "1";
								$kode_alasan = "";
								
								if ($oJamMasuk[$k] > $oJamKeluar[$k] and $k == 0 and $tanggal > $oTanggal[$k])
								{
									$hour = substr($jam,0,2);
									$hour += 24;
									$hour .= substr($jam,2,6);
								}
								else $hour = $jam;
								
								$kekurangan = selisih_waktu($oJamMasuk[$k],$hour);
								$hadir = 1;
								$TL = cek_1234($kekurangan);
								
								$sql = "
									INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
									VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
									'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$oId[$k]."','".$src."','30')
								";
								
								#echo "30. ".$sql."<br>";
								
								$query = mysql_query($sql);
								
								$status = "9";
								$kode_alasan = "";
								$jam = "00:00:00";
								$kekurangan = 450 - $kekurangan;			
								$PSW = cek_1234($kekurangan);
											
								$sql = "
									INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
									VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$PSW[1]."','".$PSW[2]."',
									'".$PSW[3]."','".$PSW[4]."','".$oId[$k]."','".$src."','31')
								"; 
								
								#echo "31. ".$sql."<br>";
								
								$query = mysql_query($sql);
								
								$sql = "UPDATE jadwal_shift SET cek_masuk = '1',cek = '1' WHERE id = '".$oId[$k]."'";
								$query = mysql_query($sql);
								
								$k = $n;
							}
							else if ($nPresensi == 1)
							{
								$Presensi = mysql_fetch_array($oPresensi);
								
								if ($Presensi['jam'] == "00:00:00")
								{
									$status = "1";
									$kode_alasan = "";
									
									if ($oJamMasuk[$k] > $oJamKeluar[$k] and $k == 0 and $tanggal > $oTanggal[$k])
									{
										$hour = substr($jam,0,2);
										$hour += 24;
										$hour .= substr($jam,2,6);
									}
									else $hour = $jam;
									
									$kekurangan = selisih_waktu($oJamMasuk[$k],$hour);
									$hadir = 1;
									$TL = cek_1234($kekurangan);
									
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
										'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$oId[$k]."','".$src."','32')
									";
									
									#echo "32. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$status = "9";
									$kode_alasan = "";
									$jam = "00:00:00";
									$kekurangan = 450 - $kekurangan;			
									$PSW = cek_1234($kekurangan);
												
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$PSW[1]."','".$PSW[2]."',
										'".$PSW[3]."','".$PSW[4]."','".$oId[$k]."','".$src."','33')
									"; 
									
									#echo "33. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi['id']."'";
									$query = mysql_query($sql);
									
									$sql = "UPDATE jadwal_shift SET cek_masuk = '1',cek = '1' WHERE id = '".$oId[$k]."'";
									$query = mysql_query($sql);
								
									$k = $n;
								}
								else
								{
									$query = true;
									$k = $n;
								}
							}
							else 
							{
								$query = true;
								$k = $n;
							}
						}
						else if ($oCekKeluar[$k] == 0)
						{
							$oPresensi = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."'","status");
							$nPresensi = mysql_num_rows($oPresensi);
							
							if ($nPresensi == 1)
							{
								$Presensi = mysql_fetch_array($oPresensi);
								
								if ($Presensi['jam'] == "00:00:00")
								{
									$status = "1";
									$kode_alasan = "";
								
									if ($oJamMasuk[$k] > $oJamKeluar[$k] and $k == 0 and $tanggal > $oTanggal[$k])
									{
										$hour = substr($jam,0,2);
										$hour += 24;
										$hour .= substr($jam,2,6);
									}
									else $hour = $jam;
									
									$kekurangan = selisih_waktu($oJamMasuk[$k],$hour);
									$hadir = 1;
									$TL = cek_1234($kekurangan);
									
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
										'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$oId[$k]."','".$src."','34')
									";
									
									#echo "34. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$status = "9";
									$kode_alasan = "";
									$jam = "00:00:00";
									$kekurangan = 450 - $kekurangan;
									$PSW = cek_1234($kekurangan);
												
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$PSW[1]."','".$PSW[2]."',
										'".$PSW[3]."','".$PSW[4]."','".$oId[$k]."','".$src."','35')
									"; 
									
									#echo "35. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi['id']."'";
									$query = mysql_query($sql);
									
									$sql = "UPDATE jadwal_shift SET cek_masuk = '1',cek = '1' WHERE id = '".$oId[$k]."'";
									$query = mysql_query($sql);
									
									$k = $n;
								}
								else
								{
									if ($jam < $Presensi['jam'] and $tanggal == $Presensi['tanggal'])
									{
										$status = "1";
										$kode_alasan = "";
									
										if ($oJamMasuk[$k] > $oJamKeluar[$k] and $k == 0 and $tanggal > $oTanggal[$k])
										{
											$hour = substr($jam,0,2);
											$hour += 24;
											$hour .= substr($jam,2,6);
										}
										else $hour = $jam;
									
										$kekurangan = selisih_waktu($oJamMasuk[$k],$hour);
										$kekurangan_in = $kekurangan;
										$hadir = 1;
										$TL = cek_1234($kekurangan);
										
										/*
										if ($TL[1] == 1)
										{
											$batas_keluar = $oJamKeluar[$k];
											$selisih = (60 * (substr($Presensi['jam'] ,0,2) - substr($batas_keluar,0,2))) + substr($Presensi['jam'],3,2) - 
											substr($batas_keluar,3,2);
																
											if ($selisih >= $kekurangan) $TL[1] = 0;
										}
										*/
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 	
											VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
											'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$oId[$k]."','".$src."','36')
										";
										
										#echo "36. ".$sql."<br>";
										
										$query = mysql_query($sql);
										
										$status = "9";
										$kode_alasan = "";
										
										if ($oJamMasuk[$k] > $oJamKeluar[$k] and $tanggal == $oTanggal[$k])
										{
											$hour = substr($oJamKeluar[$k],0,2);
											$hour += 24;
											$hour .= substr($oJamKeluar[$k],2,6);
										}
										else $hour = $oJamKeluar[$k];
								
										$kekurangan = selisih_waktu($Presensi['jam'],$hour);
										
										if ($kekurangan + $kekurangan_in > 450) $kekurangan = 450 - $kekurangan_in;
										
										$hadir = 0;
										$TL[1] = 0;
										$TL[2] = 0;
										$TL[3] = 0;
										$TL[4] = 0;
										$PSW = cek_1234($kekurangan);
										
										$sql = "
											UPDATE presensi_".$u." 
											SET 
												status = '".$status."',
												kekurangan = '".$kekurangan."',
												hadir = '".$hadir."',
												TL1 = '".$TL[1]."',
												TL2 = '".$TL[2]."',
												TL3 = '".$TL[3]."',
												TL4 = '".$TL[4]."',
												PSW1 = '".$PSW[1]."',
												PSW2 = '".$PSW[2]."',
												PSW3 = '".$PSW[3]."',
												PSW4 = '".$PSW[4]."',
												cek = '37'
											WHERE id = '".$Presensi['id']."'
										";
										
										#echo "37. ".$sql."<br>";
										
										$query = mysql_query($sql);
										
										$sql = "UPDATE jadwal_shift SET cek_keluar = '1',cek = '1' WHERE id = '".$oId[$k]."'";
										$query = mysql_query($sql);
								
										$k = $n;
									}
									else
									{
										/*
										if ($Presensi['TL1'] == 1)
										{
											$batas_keluar = $oJamKeluar[$k];
											$selisih = (60 * (substr($jam ,0,2) - substr($batas_keluar,0,2))) + substr($jam,3,2) - 
											substr($batas_keluar,3,2);
																
											if ($selisih >= $Presensi['kekurangan']) $TL[1] = 0;
											else $TL[1] = $Presensi['TL1'];
										}
										
										if ($TL[1] != $Presensi['TL1'])
										{
											$sql = "UPDATE presensi_".$u." SET TL1 = '".$TL[1]."',cek = '38' WHERE id = '".$Presensi['id']."'";
											
											#echo "38. ".$sql."<br>";
											
											$query = mysql_query($sql);
										}
										*/
										
										$status = "9";
										$kode_alasan = "";
										
										if ($oJamMasuk[$k] > $oJamKeluar[$k] and $tanggal == $oTanggal[$k])
										{
											$hour = substr($oJamKeluar[$k],0,2);
											$hour += 24;
											$hour .= substr($oJamKeluar[$k],2,6);
										}
										else $hour = $oJamKeluar[$k];
										
										$kekurangan = selisih_waktu($jam,$hour);
										
										if ($kekurangan + $Presensi['kekurangan'] > 450) $kekurangan = 450 - $Presensi['kekurangan'];
										
										$PSW = cek_1234($kekurangan);
									
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
											VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$PSW[1]."',
											'".$PSW[2]."','".$PSW[3]."','".$PSW[4]."','".$oId[$k]."','".$src."','39')
										";
										
										#echo "39. ".$sql."<br>";
										
										$query = mysql_query($sql);
										
										$sql = "UPDATE jadwal_shift SET cek_keluar = '1',cek = '1' WHERE id = '".$oId[$k]."'";
										$query = mysql_query($sql);
										
										$k = $n;
									}
								}
							}
							else 
							{
								$oPresensi2 = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '9'");
								$nPresensi2 = mysql_num_rows($oPresensi2);
								
								if ($nPresensi2 != 0)
								{
									$Presensi2 = mysql_fetch_array($oPresensi2);
									
									if ($jam > $Presensi2['jam'])
									{
										$oPresensi3 = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '1'");
										$Presensi3 = mysql_fetch_array($oPresensi3);
										
										if (($jam < $Presensi3['jam'] and $tanggal == $Presensi3['tanggal']) or 
										($jam > $Presensi3['jam'] and $tanggal < $Presensi3['tanggal']))
										{
											$status = "1";
											$kode_alasan = "";
											
											if ($oJamMasuk[$k] > $oJamKeluar[$k] and $k == 0 and $tanggal > $oTanggal[$k])
											{
												$hour = substr($jam,0,2);
												$hour += 24;
												$hour .= substr($jam,2,6);
											}
											else $hour = $jam;
										
											$kekurangan = selisih_waktu($oJamMasuk[$k],$hour);
											$kekurangan_in = $kekurangan;
											$hadir = 1;
											$TL = cek_1234($kekurangan);
											
											/*
											if ($TL[1] == 1)
											{
												$batas_keluar = $oJamKeluar[$k];
												$selisih = (60 * (substr($Presensi3['jam'] ,0,2) - substr($batas_keluar,0,2))) + 
												substr($Presensi3['jam'],3,2) - substr($batas_keluar,3,2);
																	
												if ($selisih >= $kekurangan) $TL[1] = 0;
											}
											*/
											
											$sql = "
												INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,
												cek) 
												VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."',
												'".$TL[1]."','".$TL[2]."','".$TL[3]."','".$TL[4]."','".$oId[$k]."','".$src."','40')
											";
											
											#echo "40. ".$sql."<br>";
											
											$query = mysql_query($sql);
											
											$status = "9";
											$kode_alasan = "";
											
											if ($oJamMasuk[$k] > $oJamKeluar[$k] and $tanggal > $oTanggal[$k])
											{
												$hour = substr($oJamKeluar[$k],0,2);
												$hour += 24;
												$hour .= substr($oJamKeluar[$k],2,6);
											}
											else $hour = $oJamKeluar[$k];
										
											$kekurangan = selisih_waktu($Presensi3['jam'],$hour);
											
											if ($kekurangan + $kekurangan_in > 450) $kekurangan = 450 - $kekurangan_in;
											
											$hadir = 0;
											$TL[1] = 0;
											$TL[2] = 0;
											$TL[3] = 0;
											$TL[4] = 0;
											$PSW = cek_1234($kekurangan);
											
											$sql = "
												UPDATE presensi_".$u." 
												SET 
													status = '".$status."',
													kekurangan = '".$kekurangan."',
													hadir = '".$hadir."',
													TL1 = '".$TL[1]."',
													TL2 = '".$TL[2]."',
													TL3 = '".$TL[3]."',
													TL4 = '".$TL[4]."',
													PSW1 = '".$PSW[1]."',
													PSW2 = '".$PSW[2]."',
													PSW3 = '".$PSW[3]."',
													PSW4 = '".$PSW[4]."',
													cek = '41'
												WHERE id = '".$Presensi3['id']."'
											";
											
											#echo "41. ".$sql."<br>";
											
											$query = mysql_query($sql);
											
											$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi2['id']."'";
											$query = mysql_query($sql);
											
											$sql = "UPDATE jadwal_shift SET cek_keluar = '1',cek = '1' WHERE id = '".$oId[$k]."'";
											$query = mysql_query($sql);
											
											$k = $n;
										}
										else
										{
											$oPresensi4 = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '1'");
											$Presensi4 = mysql_fetch_array($oPresensi4);
											
											/*
											if ($Presensi4['TL1'] == 1)
											{
												$batas_keluar = $oJamKeluar[$k];
												$selisih = (60 * (substr($jam ,0,2) - substr($batas_keluar,0,2))) + substr($jam,3,2) - 
												substr($batas_keluar,3,2);
												
												if ($selisih >= $Presensi4['kekurangan']) $TL[1] = 0;
												else $TL[1] = $Presensi4['TL1'];
											}
											
											if ($TL[1] != $Presensi4['TL1'])
											{
												$sql = "UPDATE presensi_".$u." SET TL1 = '".$TL[1]."',cek = '42' WHERE id = '".$Presensi4['id']."'";
												
												#echo "42. ".$sql."<br>";
												
												$query = mysql_query($sql);
											}
											*/
											
											$status = "9";
											$kode_alasan = "";
											
											if ($oJamMasuk[$k] > $oJamKeluar[$k] and $tanggal == $oTanggal[$k])
											{
												$hour = substr($oJamKeluar[$k],0,2);
												$hour += 24;
												$hour .= substr($oJamKeluar[$k],2,6);
											}
											else $hour = $oJamKeluar[$k];
											
											$kekurangan = selisih_waktu($jam,$hour);
											
											if ($kekurangan + $Presensi4['kekurangan'] > 450) $kekurangan = 450 - $Presensi4['kekurangan'];
											
											$PSW = cek_1234($kekurangan);
										
											$sql = "
												INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
												VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$PSW[1]."',
												'".$PSW[2]."','".$PSW[3]."','".$PSW[4]."','".$oId[$k]."','".$src."','43')
											";
											
											#echo "43. ".$sql."<br>";
											
											$query = mysql_query($sql);
											
											$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi2['id']."'";
											$query = mysql_query($sql);
											
											$sql = "UPDATE jadwal_shift SET cek_keluar = '1',cek = '1' WHERE id = '".$oId[$k]."'";
											$query = mysql_query($sql);
											
											$k = $n;
										}
									}
									else
									{
										$query = true;
										$k = $n;
									}
								}
								else
								{
									$query = true;
									$k = $n;
								}
							}
						}
						else
						{
							$oPresensi = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '1'");
							$Presensi = mysql_fetch_array($oPresensi);
							
							if ($jam < $Presensi['jam'] and $tanggal == $Presensi['tanggal'])
							{
								$status = "1";
								$kode_alasan = "";
							
								if ($oJamMasuk[$k] > $oJamKeluar[$k] and $k == 0 and $tanggal > $oTanggal[$k])
								{
									$hour = substr($jam,0,2);
									$hour += 24;
									$hour .= substr($jam,2,6);
								}
								else $hour = $jam;
								
								$kekurangan = selisih_waktu($oJamMasuk[$k],$hour);
								$hadir = 1;
								$TL = cek_1234($kekurangan);
								
								$oPresensi2 = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '9'");
								$Presensi2 = mysql_fetch_array($oPresensi2);
								
								/*
								if ($TL[1] == 1)
								{
									$batas_keluar = $oJamKeluar[$k];
									$selisih = (60 * (substr($Presensi2['jam'] ,0,2) - substr($batas_keluar,0,2))) + substr($Presensi2['jam'],3,2) - 
									substr($batas_keluar,3,2);
														
									if ($selisih >= $kekurangan) $TL[1] = 0;
								}
								*/
								
								$sql = "
									INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,hadir,TL1,TL2,TL3,TL4,jam_kerja,src,cek) 
									VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$hadir."','".$TL[1]."',
									'".$TL[2]."','".$TL[3]."','".$TL[4]."','".$oId[$k]."','".$src."','44')
								";
								
								#echo "44. ".$sql."<br>";
								
								$query = mysql_query($sql);
								
								$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi['id']."'";
								$query = mysql_query($sql);
							}
							else
							{
								$oPresensi2 = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '9'");
								$Presensi2 = mysql_fetch_array($oPresensi2);
								
								if (($jam > $Presensi2['jam'] and $tanggal == $Presensi2['tanggal']) or $tanggal > $Presensi2['tanggal'])
								{
									$oPresensi3 = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$oId[$k]."' AND status = '1'");
									$Presensi3 = mysql_fetch_array($oPresensi3);
									
									/*
									if ($Presensi3['TL1'] == 1)
									{
										$batas_keluar = $oJamKeluar[$k];
										$selisih = (60 * (substr($jam ,0,2) - substr($batas_keluar,0,2))) + substr($jam,3,2) - 
										substr($batas_keluar,3,2);
										
										if ($selisih >= $Presensi3['kekurangan']) $TL[1] = 0;
										else $TL[1] = $Presensi3['TL1'];
									}
									
									if ($TL[1] != $Presensi3['TL1'])
									{
										$sql = "UPDATE presensi_".$u." SET TL1 = '".$TL[1]."',cek = '45' WHERE id = '".$Presensi3['id']."'";
										
										#echo "45. ".$sql."<br>";
										
										$query = mysql_query($sql);
									}
									*/
									
									$status = "9";
									$kode_alasan = "";
									
									if ($oJamMasuk[$k] > $oJamKeluar[$k] and $tanggal == $oTanggal[$k])
									{
										$hour = substr($oJamKeluar[$k],0,2);
										$hour += 24;
										$hour .= substr($oJamKeluar[$k],2,6);
									}
									else $hour = $oJamKeluar[$k];
								
									$kekurangan = selisih_waktu($jam,$hour);
									
									if ($kekurangan + $Presensi3['kekurangan'] > 450) $kekurangan = 450 - $Presensi3['kekurangan'];
									
									$PSW = cek_1234($kekurangan);
								
									$sql = "
										INSERT INTO presensi_".$u." (nip,tanggal,jam,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
										VALUES ('".$nip."','".$tanggal."','".$jam."','".$status."','".$kekurangan."','".$PSW[1]."',
										'".$PSW[2]."','".$PSW[3]."','".$PSW[4]."','".$oId[$k]."','".$src."','46')
									";
									
									#echo "46. ".$sql."<br>";
									
									$query = mysql_query($sql);
									
									$sql = "DELETE FROM presensi_".$u." WHERE id = '".$Presensi2['id']."'";
									$query = mysql_query($sql);
								}
								else 
								{
									$query = true;
									$k = $n;
								}
							}
						}
					}
				}
				else $query = true;
			}
		}
		else $query = true;
		
		if (@$query) $result = true;
		else $result = false;
		
		return $result;
	}
	
	function insert_keluar_sementara($nip,$tanggal,$jam,$src)
	{
		if ($nip != "")
		{
			$KS[1] = 0;
			$KS[2] = 0;
			$KS[3] = 0;
			$KS[4] = 0;
			
			$Pegawai = pegawai_id($nip);
			$u = substr($Pegawai->kode_bidang,0,2);
			$kode_jadwal_kerja = $Pegawai->jadwal_kerja;
			
			$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
			
			if (mysql_num_rows($oJadwalKerja) != 0)
			{
				$oJadwalKerja2 = jadwal_kerja("date_from <= '".$tanggal."' AND date_until >= '".$tanggal."'");
				$nJadwalKerja2 = mysql_num_rows($oJadwalKerja2);
				
				if ($nJadwalKerja2 == 0) $JadwalKerja = mysql_fetch_array($oJadwalKerja);
				else $JadwalKerja = mysql_fetch_array($oJadwalKerja2);
				
				$NamaHari = strtolower(nama_hari($tanggal));
				$JamKerja = $JadwalKerja[$NamaHari];
			
				$oPresensi = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND (jam = '".$jam."' OR jam2 = '".$jam."') AND status != '0' AND 
				status != '1' AND status != '9'");
				
				$nPresensi = mysql_num_rows($oPresensi);
				
				if ($nPresensi == 0)
				{	
					$oPresensi2 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status != '0' AND status != '1' AND status != '9'",
					"status");
					
					$nPresensi2 = mysql_num_rows($oPresensi2);
					
					if ($nPresensi2 == 0) 
					{
						$oLibur = libur("tanggal = '".$tanggal."'");
						$nLibur = mysql_num_rows($oLibur);
						$hari = strtolower(nama_hari($tanggal));
						
						if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu")
						{
							$jam2 = "00:00:00";
							$status = "2";
							
							$oPresensi3 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
							$nPresensi3 = mysql_num_rows($oPresensi3);
							
							if ($nPresensi3 == 0) $jam3 = jam_keluar($tanggal,$nip);
							else
							{
								if ($tanggal >= "2013-07-10" and $tanggal <= "2013-08-09")
								{			
									if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I4");
									else $jam_istirahat = jam_kerja_id("I3");
								}
								else
								{
									if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I2");
									else $jam_istirahat = jam_kerja_id("I1");
								}
								
								$istirahat_awal = $jam_istirahat->jam_keluar;
								
								if ($jam < $istirahat_awal) $jam3 = $istirahat_awal;
								else
								{
									$Presensi3 = mysql_fetch_array($oPresensi3);
									$jam_keluar = jam_keluar($tanggal,$nip);
									
									if ($Presensi3['jam'] < $jam_keluar) $jam3 = $Presensi3['jam'];
									else $jam3 = $jam_keluar;
								}
							}
							
							$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam3);
							$kekurangan = $kekurangan2;
							
							$KS = cek_1234($kekurangan2);
							
							$sql = "
								INSERT INTO presensi_".$u." 
									(nip,tanggal,jam,jam2,status,kekurangan,kekurangan2,KS1,KS2,KS3,KS4,jam_kerja,src,cek)
								VALUES
									('".$nip."','".$tanggal."','".$jam."','".$jam2."','".$status."','".$kekurangan."','".$kekurangan2."',
									'".$KS[1]."','".$KS[2]."','".$KS[3]."','".$KS[4]."','".$JamKerja."','".$src."','80')
							";
							
							#echo "80. ".$sql."<br>";
							
							$query = mysql_query($sql);
						}
						else $query = true;
					}
					else if ($nPresensi2 == 1)
					{
						$Presensi2 = mysql_fetch_array($oPresensi2);
						
						if ($Presensi2['jam2'] == '00:00:00') 
						{
							$oLibur = libur("tanggal = '".$tanggal."'");
							$nLibur = mysql_num_rows($oLibur);
							$hari = strtolower(nama_hari($tanggal));
							
							if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
							{
								if ($jam < $Presensi2['jam']) $jam2 = $Presensi2['jam'];
								else
								{
									$jam2 = $jam;
									$jam = $Presensi2['jam'];
								}
								
								$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam2);
								
								if ($Presensi2['kode_alasan'] == "") $kekurangan = $kekurangan2;
								else $kekurangan = 0;
								
								$KS = cek_1234($kekurangan2);
								
								$sql = "
									UPDATE presensi_".$u." 
									SET
										jam = '".$jam."',
										jam2 = '".$jam2."',
										kekurangan = '".$kekurangan."',
										kekurangan2 = '".$kekurangan2."',
										KS1 = '".$KS[1]."',
										KS2 = '".$KS[2]."',
										KS3 = '".$KS[3]."',
										KS4 = '".$KS[4]."'
									WHERE id = '".$Presensi2['id']."'
								";
								
								#echo "80".$sql."<br>";
								
								$query = mysql_query($sql);
							}
							else $query = true;
						}
						else 
						{
							$oLibur = libur("tanggal = '".$tanggal."'");
							$nLibur = mysql_num_rows($oLibur);
							$hari = strtolower(nama_hari($tanggal));
							
							if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu")
							{
								$jam2 = "00:00:00";
								$status = "3";
								
								$oPresensi3 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
								$nPresensi3 = mysql_num_rows($oPresensi3);
								
								if ($nPresensi3 == 0) $jam3 = jam_keluar($tanggal,$nip);
								else
								{
									if ($tanggal >= "2013-07-10" and $tanggal <= "2013-08-09")
									{			
										if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I4");
										else $jam_istirahat = jam_kerja_id("I3");
									}
									else
									{
										if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I2");
										else $jam_istirahat = jam_kerja_id("I1");
									}
									
									$istirahat_awal = $jam_istirahat->jam_keluar;
									
									if ($jam < $istirahat_awal) $jam3 = $istirahat_awal;
									else
									{
										$Presensi3 = mysql_fetch_array($oPresensi3);
										$jam_keluar = jam_keluar($tanggal,$nip);
										
										if ($Presensi3['jam'] < $jam_keluar) $jam3 = $Presensi3['jam'];
										else $jam3 = $jam_keluar;
									}
								}
								
								$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam3);
								$kekurangan = $kekurangan2;
								
								$KS = cek_1234($kekurangan2);
								
								$sql = "
									INSERT INTO presensi_".$u." 
										(nip,tanggal,jam,jam2,status,kekurangan,kekurangan2,KS1,KS2,KS3,KS4,jam_kerja,src,cek)
									VALUES
										('".$nip."','".$tanggal."','".$jam."','".$jam2."','".$status."','".$kekurangan."','".$kekurangan2."',
										'".$KS[1]."','".$KS[2]."','".$KS[3]."','".$KS[4]."','".$JamKerja."','".$src."','81')
								";
								
								#echo "81. ".$sql."<br>";
								
								$query = mysql_query($sql);
							}
							else $query = true;
						}
					}
					else 
					{
						$oPresensi3 = presensi("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam2 = '00:00:00' AND status != '0' AND 
						status != '1' AND status != '9'", "status");
						
						$nPresensi3 = mysql_num_rows($oPresensi3);
						
						if ($nPresensi3 == 0)
						{
							$status = 1;
							
							while ($Presensi3 = mysql_fetch_array($oPresensi3))
							{
								$status = $Presensi3['status'];
							}
							
							
							$jam2 = "00:00:00";
							$status++;
							
							$oPresensi4 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
							$nPresensi4 = mysql_num_rows($oPresensi4);
							
							if ($nPresensi4 == 0) $jam3 = jam_keluar($tanggal,$nip);
							else
							{
								if ($tanggal >= "2013-07-10" and $tanggal <= "2013-08-09")
								{			
									if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I4");
									else $jam_istirahat = jam_kerja_id("I3");
								}
								else
								{
									if ($hari == "jumat") $jam_istirahat = jam_kerja_id("I2");
									else $jam_istirahat = jam_kerja_id("I1");
								}
								
								$istirahat_awal = $jam_istirahat->jam_keluar;
								
								if ($jam < $istirahat_awal) $jam3 = $istirahat_awal;
								else
								{
									$Presensi4 = mysql_fetch_array($oPresensi4);
									$jam_keluar = jam_keluar($tanggal,$nip);
									
									if ($Presensi4['jam'] < $jam_keluar) $jam3 = $Presensi4['jam'];
									else $jam3 = $jam_keluar;
								}
							}
							
							$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam3);
							$kekurangan = $kekurangan2;
							
							$KS = cek_1234($kekurangan2);
							
							$sql = "
								INSERT INTO presensi_".$u." 
									(nip,tanggal,jam,jam2,status,kekurangan,kekurangan2,KS1,KS2,KS3,KS4,jam_kerja,src,cek)
								VALUES
									('".$nip."','".$tanggal."','".$jam."','".$jam2."','".$status."','".$kekurangan."','".$kekurangan2."',
									'".$KS[1]."','".$KS[2]."','".$KS[3]."','".$KS[4]."','".$JamKerja."','".$src."','82')
							";
							
							#echo "82. ".$sql."<br>";
							
							$query = mysql_query($sql);
						}
						else
						{
							$Presensi3 = mysql_fetch_array($oPresensi3);
							
							$oLibur = libur("tanggal = '".$tanggal."'");
							$nLibur = mysql_num_rows($oLibur);
							$hari = strtolower(nama_hari($tanggal));
							
							if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
							{
								if ($jam < $Presensi3['jam']) $jam2 = $Presensi3['jam'];
								else
								{
									$jam2 = $jam;
									$jam = $Presensi3['jam'];
								}
								
								$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam2);
								
								if ($Presensi3['kode_alasan'] == "") $kekurangan = $kekurangan2;
								else $kekurangan = 0;
								
								$KS = cek_1234($kekurangan2);
								
								$sql = "
									UPDATE presensi_".$u." 
									SET
										jam = '".$jam."',
										jam2 = '".$jam2."',
										kekurangan = '".$kekurangan."',
										kekurangan2 = '".$kekurangan2."',
										KS1 = '".$KS[1]."',
										KS2 = '".$KS[2]."',
										KS3 = '".$KS[3]."',
										KS4 = '".$KS[4]."'
									WHERE id = '".$Presensi3['id']."'
								";
								
								#echo $sql."<br>";
								
								$query = mysql_query($sql);
							}
							else $query = true;
						}
					}
				}
				else $query = true;
			}
			else
			{
				$oPresensi = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND (jam = '".$jam."' OR jam2 = '".$jam."') AND status != '0' AND 
				status != '1' AND status != '9'");
				
				$nPresensi = mysql_num_rows($oPresensi);
				
				if ($nPresensi == 0)
				{	
					$oPresensi2 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status != '0' AND status != '1' AND status != '9'",
					"status");
					
					$nPresensi2 = mysql_num_rows($oPresensi2);
					
					if ($nPresensi2 == 0) 
					{
						$jam2 = "00:00:00";
						$status = "2";
						
						$oPresensi3 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
						$nPresensi3 = mysql_num_rows($oPresensi3);
						
						if ($nPresensi3 == 0)
						{
							$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
							$nJadwalShift = mysql_num_rows($oJadwalShift);
							
							if ($nJadwalShift != 0)
							{
								$JadwalShift = mysql_fetch_array($oJadwalShift);
								
								if ($JadwalShift['jam_masuk'] > $JadwalShift['jam_keluar'] and $tanggal == $JadwalShift['tanggal'])
								{
									$jam3 = substr($JadwalShift['jam_keluar'],0,2);
									$jam3 += 24;
									$jam3 .= substr($JadwalShift['jam_keluar'],2,6);
								}
								else $jam3 = $JadwalShift['jam_keluar'];
							}
							else
							{
								$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
								
								$oJadwalShift2 = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
								$nJadwalShift2 = mysql_num_rows($oJadwalShift2);
								
								if ($nJadwalShift2 != 0)
								{
									$JadwalShift2 = mysql_fetch_array($oJadwalShift2);
									
									if ($JadwalShift2['jam_masuk'] > $JadwalShift2['jam_keluar'] and $tanggal > $JadwalShift['tanggal'])
									{
										$jam3 = substr($JadwalShift2['jam_keluar'],0,2);
										$jam3 += 24;
										$jam3 .= substr($JadwalShift2['jam_keluar'],2,6);
									}
									else $jam3 = $JadwalShift2['jam_keluar'];
								}
							}
						}
						else
						{
							$Presensi3 = mysql_fetch_array($oPresensi3);
							
							$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
							$nJadwalShift = mysql_num_rows($oJadwalShift);
							
							if ($nJadwalShift != 0)
							{
								$JadwalShift = mysql_fetch_array($oJadwalShift);
								
								if ($JadwalShift['jam_masuk'] > $JadwalShift['jam_keluar'] and $tanggal == $JadwalShift['tanggal'])
								{	
									$jam_presensi = substr($Presensi3['jam'],0,2);
									$jam_presensi += 24;
									$jam_presensi .= substr($Presensi3['jam'],2,6);
									
									$jam_shift = substr($JadwalShift['jam_keluar'],0,2);
									$jam_shift += 24;
									$jam_shift .= substr($JadwalShift['jam_keluar'],2,6);
									
									if ($jam_presensi < $jam_shift) $jam3 = $jam_presensi;
									else $jam3 = $jam_shift;
								}
								else
								{
									if ($Presensi3['jam'] < $JadwalShift['jam_keluar']) $jam3 = $Presensi3['jam'];
									else $jam3 = $JadwalShift['jam_keluar'];
								}
							}
							else
							{
								$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
								
								$oJadwalShift2 = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
								$nJadwalShift2 = mysql_num_rows($oJadwalShift2);
								
								if ($nJadwalShift2 != 0)
								{
									$JadwalShift2 = mysql_fetch_array($oJadwalShift2);
									
									if ($JadwalShift2['jam_masuk'] > $JadwalShift2['jam_keluar'] and $tanggal > $JadwalShift2['tanggal'])
									{	
										$jam_presensi = substr($Presensi3['jam'],0,2);
										$jam_presensi += 24;
										$jam_presensi .= substr($Presensi3['jam'],2,6);
										
										$jam_shift = substr($JadwalShift2['jam_keluar'],0,2);
										$jam_shift += 24;
										$jam_shift .= substr($JadwalShift2['jam_keluar'],2,6);
										
										if ($jam_presensi < $jam_shift) $jam3 = $Presensi3['jam'];
										else $jam3 = $JadwalShift2['jam_keluar'];
									}
									else
									{
										if ($Presensi3['jam'] < $JadwalShift2['jam_keluar']) $jam3 = $Presensi3['jam'];
										else $jam3 = $JadwalShift2['jam_keluar'];
									}
								}
								else $jam3 = $Presensi3['jam'];
							}
						}
						
						$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam3);
						$kekurangan = $kekurangan2;
						
						$KS = cek_1234($kekurangan2);
						
						$sql = "
							INSERT INTO presensi_".$u." 
								(nip,tanggal,jam,jam2,status,kekurangan,kekurangan2,KS1,KS2,KS3,KS4,jam_kerja,src,cek)
							VALUES
								('".$nip."','".$tanggal."','".$jam."','".$jam2."','".$status."','".$kekurangan."','".$kekurangan2."',
								'".$KS[1]."','".$KS[2]."','".$KS[3]."','".$KS[4]."','".$JamKerja."','".$src."','90')
						";
						
						#echo "90. ".$sql."<br>";
						
						$query = mysql_query($sql);
					}
					else if ($nPresensi2 == 1)
					{
						$Presensi2 = mysql_fetch_array($oPresensi2);
						
						if ($Presensi2['jam2'] == '00:00:00') 
						{
							if ($jam < $Presensi2['jam']) $jam2 = $Presensi2['jam'];
							else
							{
								$jam2 = $jam;
								$jam = $Presensi2['jam'];
							}
							
							$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam2);
							
							if ($Presensi2['kode_alasan'] == "") $kekurangan = $kekurangan2;
							else $kekurangan = 0;
							
							$KS = cek_1234($kekurangan2);
							
							$sql = "
								UPDATE presensi_".$u." 
								SET
									jam = '".$jam."',
									jam2 = '".$jam2."',
									kekurangan = '".$kekurangan."',
									kekurangan2 = '".$kekurangan2."',
									KS1 = '".$KS[1]."',
									KS2 = '".$KS[2]."',
									KS3 = '".$KS[3]."',
									KS4 = '".$KS[4]."'
								WHERE id = '".$Presensi2['id']."'
							";
							
							#echo $sql."<br>";
							
							$query = mysql_query($sql);
						}
						else 
						{
							$jam2 = "00:00:00";
							$status = "3";
							
							$oPresensi3 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
							$nPresensi3 = mysql_num_rows($oPresensi3);
							
							if ($nPresensi3 == 0)
							{
								$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
								$nJadwalShift = mysql_num_rows($oJadwalShift);
								
								if ($nJadwalShift != 0)
								{
									$JadwalShift = mysql_fetch_array($oJadwalShift);
									
									if ($JadwalShift['jam_masuk'] > $JadwalShift['jam_keluar'] and $tanggal == $JadwalShift['tanggal'])
									{
										$jam3 = substr($JadwalShift['jam_keluar'],0,2);
										$jam3 += 24;
										$jam3 .= substr($JadwalShift['jam_keluar'],2,6);
									}
									else $jam3 = $JadwalShift['jam_keluar'];
								}
								else
								{
									$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
									
									$oJadwalShift2 = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
									$nJadwalShift2 = mysql_num_rows($oJadwalShift2);
									
									if ($nJadwalShift2 != 0)
									{
										$JadwalShift2 = mysql_fetch_array($oJadwalShift2);
										
										if ($JadwalShift2['jam_masuk'] > $JadwalShift2['jam_keluar'] and $tanggal > $JadwalShift['tanggal'])
										{
											$jam3 = substr($JadwalShift2['jam_keluar'],0,2);
											$jam3 += 24;
											$jam3 .= substr($JadwalShift2['jam_keluar'],2,6);
										}
										else $jam3 = $JadwalShift2['jam_keluar'];
									}
								}
							}
							else
							{
								$Presensi3 = mysql_fetch_array($oPresensi3);
								
								$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
								$nJadwalShift = mysql_num_rows($oJadwalShift);
								
								if ($nJadwalShift != 0)
								{
									$JadwalShift = mysql_fetch_array($oJadwalShift);
									
									if ($JadwalShift['jam_masuk'] > $JadwalShift['jam_keluar'] and $tanggal == $JadwalShift['tanggal'])
									{	
										$jam_presensi = substr($Presensi3['jam'],0,2);
										$jam_presensi += 24;
										$jam_presensi .= substr($Presensi3['jam'],2,6);
										
										$jam_shift = substr($JadwalShift['jam_keluar'],0,2);
										$jam_shift += 24;
										$jam_shift .= substr($JadwalShift['jam_keluar'],2,6);
										
										if ($jam_presensi < $jam_shift) $jam3 = $jam_presensi;
										else $jam3 = $jam_shift;
									}
									else
									{
										if ($Presensi3['jam'] < $JadwalShift['jam_keluar']) $jam3 = $Presensi3['jam'];
										else $jam3 = $JadwalShift['jam_keluar'];
									}
								}
								else
								{
									$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
									
									$oJadwalShift2 = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
									$nJadwalShift2 = mysql_num_rows($oJadwalShift2);
									
									if ($nJadwalShift2 != 0)
									{
										$JadwalShift2 = mysql_fetch_array($oJadwalShift2);
										
										if ($JadwalShift2['jam_masuk'] > $JadwalShift2['jam_keluar'] and $tanggal > $JadwalShift2['tanggal'])
										{	
											$jam_presensi = substr($Presensi3['jam'],0,2);
											$jam_presensi += 24;
											$jam_presensi .= substr($Presensi3['jam'],2,6);
											
											$jam_shift = substr($JadwalShift2['jam_keluar'],0,2);
											$jam_shift += 24;
											$jam_shift .= substr($JadwalShift2['jam_keluar'],2,6);
											
											if ($jam_presensi < $jam_shift) $jam3 = $Presensi3['jam'];
											else $jam3 = $JadwalShift2['jam_keluar'];
										}
										else
										{
											if ($Presensi3['jam'] < $JadwalShift2['jam_keluar']) $jam3 = $Presensi3['jam'];
											else $jam3 = $JadwalShift2['jam_keluar'];
										}
									}
									else $jam3 = $Presensi3['jam'];
								}
							}
							
							$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam3);
							$kekurangan = $kekurangan2;
							
							$KS = cek_1234($kekurangan2);
							
							$sql = "
								INSERT INTO presensi_".$u." 
									(nip,tanggal,jam,jam2,status,kekurangan,kekurangan2,KS1,KS2,KS3,KS4,jam_kerja,src,cek)
								VALUES
									('".$nip."','".$tanggal."','".$jam."','".$jam2."','".$status."','".$kekurangan."','".$kekurangan2."',
									'".$KS[1]."','".$KS[2]."','".$KS[3]."','".$KS[4]."','".$JamKerja."','".$src."','91')
							";
							
							#echo "91. ".$sql."<br>";
							
							$query = mysql_query($sql);
						}
					}
					else 
					{
						$oPresensi3 = presensi("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam2 = '00:00:00' AND status != '0' AND 
						status != '1' AND status != '9'", "status");
						
						$nPresensi3 = mysql_num_rows($oPresensi3);
						
						if ($nPresensi3 == 0)
						{
							$status = 1;
							
							while ($Presensi3 = mysql_fetch_array($oPresensi3))
							{
								$status = $Presensi3['status'];
							}
							
							
							$jam2 = "00:00:00";
							$status++;
							
							$oPresensi4 = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
							$nPresensi4 = mysql_num_rows($oPresensi4);
							
							if ($nPresensi4 == 0)
							{
								$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
								$nJadwalShift = mysql_num_rows($oJadwalShift);
								
								if ($nJadwalShift != 0)
								{
									$JadwalShift = mysql_fetch_array($oJadwalShift);
									
									if ($JadwalShift['jam_masuk'] > $JadwalShift['jam_keluar'] and $tanggal == $JadwalShift['tanggal'])
									{
										$jam3 = substr($JadwalShift['jam_keluar'],0,2);
										$jam3 += 24;
										$jam3 .= substr($JadwalShift['jam_keluar'],2,6);
									}
									else $jam3 = $JadwalShift['jam_keluar'];
								}
								else
								{
									$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
									
									$oJadwalShift2 = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
									$nJadwalShift2 = mysql_num_rows($oJadwalShift2);
									
									if ($nJadwalShift2 != 0)
									{
										$JadwalShift2 = mysql_fetch_array($oJadwalShift2);
										
										if ($JadwalShift2['jam_masuk'] > $JadwalShift2['jam_keluar'] and $tanggal > $JadwalShift['tanggal'])
										{
											$jam3 = substr($JadwalShift2['jam_keluar'],0,2);
											$jam3 += 24;
											$jam3 .= substr($JadwalShift2['jam_keluar'],2,6);
										}
										else $jam3 = $JadwalShift2['jam_keluar'];
									}
								}
							}
							else
							{
								$Presensi4 = mysql_fetch_array($oPresensi4);
								
								$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L'","jam_masuk");
								$nJadwalShift = mysql_num_rows($oJadwalShift);
								
								if ($nJadwalShift != 0)
								{
									$JadwalShift = mysql_fetch_array($oJadwalShift);
									
									if ($JadwalShift['jam_masuk'] > $JadwalShift['jam_keluar'] and $tanggal == $JadwalShift['tanggal'])
									{	
										$jam_presensi = substr($Presensi4['jam'],0,2);
										$jam_presensi += 24;
										$jam_presensi .= substr($Presensi4['jam'],2,6);
										
										$jam_shift = substr($JadwalShift['jam_keluar'],0,2);
										$jam_shift += 24;
										$jam_shift .= substr($JadwalShift['jam_keluar'],2,6);
										
										if ($jam_presensi < $jam_shift) $jam3 = $jam_presensi;
										else $jam3 = $jam_shift;
									}
									else
									{
										if ($Presensi4['jam'] < $JadwalShift['jam_keluar']) $jam3 = $Presensi4['jam'];
										else $jam3 = $JadwalShift['jam_keluar'];
									}
								}
								else
								{
									$kemarin = date("Y-m-d",strtotime($tanggal) - 1);
									
									$oJadwalShift2 = jadwal_shift("nip = '".$nip."' AND tanggal = '".$kemarin."' AND jam_masuk > jam_keluar");
									$nJadwalShift2 = mysql_num_rows($oJadwalShift2);
									
									if ($nJadwalShift2 != 0)
									{
										$JadwalShift2 = mysql_fetch_array($oJadwalShift2);
										
										if ($JadwalShift2['jam_masuk'] > $JadwalShift2['jam_keluar'] and $tanggal > $JadwalShift2['tanggal'])
										{	
											$jam_presensi = substr($Presensi4['jam'],0,2);
											$jam_presensi += 24;
											$jam_presensi .= substr($Presensi4['jam'],2,6);
											
											$jam_shift = substr($JadwalShift2['jam_keluar'],0,2);
											$jam_shift += 24;
											$jam_shift .= substr($JadwalShift2['jam_keluar'],2,6);
											
											if ($jam_presensi < $jam_shift) $jam3 = $Presensi4['jam'];
											else $jam3 = $JadwalShift2['jam_keluar'];
										}
										else
										{
											if ($Presensi4['jam'] < $JadwalShift2['jam_keluar']) $jam3 = $Presensi4['jam'];
											else $jam3 = $JadwalShift2['jam_keluar'];
										}
									}
									else $jam3 = $Presensi4['jam'];
								}
							}
							
							$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam3);
							$kekurangan = $kekurangan2;
							
							$KS = cek_1234($kekurangan2);
							
							$sql = "
								INSERT INTO presensi_".$u." 
									(nip,tanggal,jam,jam2,status,kekurangan,kekurangan2,KS1,KS2,KS3,KS4,jam_kerja,src,cek)
								VALUES
									('".$nip."','".$tanggal."','".$jam."','".$jam2."','".$status."','".$kekurangan."','".$kekurangan2."',
									'".$KS[1]."','".$KS[2]."','".$KS[3]."','".$KS[4]."','".$JamKerja."','".$src."','92')
							";
							
							#echo "92. ".$sql."<br>";
							
							$query = mysql_query($sql);
						}
						else
						{
							$Presensi3 = mysql_fetch_array($oPresensi3);
							
							if ($jam < $Presensi3['jam']) $jam2 = $Presensi3['jam'];
							else
							{
								$jam2 = $jam;
								$jam = $Presensi3['jam'];
							}
							
							$kekurangan2 = kekurangan_keluar_sementara($tanggal,$jam,$jam2);
							
							if ($Presensi3['kode_alasan'] == "") $kekurangan = $kekurangan2;
							else $kekurangan = 0;
							
							$KS = cek_1234($kekurangan2);
							
							$sql = "
								UPDATE presensi_".$u." 
								SET
									jam = '".$jam."',
									jam2 = '".$jam2."',
									kekurangan = '".$kekurangan."',
									kekurangan2 = '".$kekurangan2."',
									KS1 = '".$KS[1]."',
									KS2 = '".$KS[2]."',
									KS3 = '".$KS[3]."',
									KS4 = '".$KS[4]."'
								WHERE id = '".$Presensi3['id']."'
							";
							
							#echo $sql."<br>";
							
							$query = mysql_query($sql);
						}
					}
				}
				else $query = true;
			}
		}
		else $query = true;
		
		if ($query) $result = true;
		else $result = false;
		
		return $result;
	}
	
	function update_presensi($id,$status,$kode_alasan,$keterangan,$u) 
	{
		$Presensi = presensi_id($id,$u);
		
		$table = "presensi";
		$field = get_field($table);
		
		$nip = $Presensi->nip;
		$tanggal = $Presensi->tanggal;
		$tahun = substr($tanggal,0 ,4);
		$jam = $Presensi->jam;
		$jam2 = $Presensi->jam2;
		$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
		$kekurangan2 = 0;
		$hadir = $Presensi->hadir;
		$tidak_hadir = $Presensi->tidak_hadir;
		$dl_ln = 0;
		$dl_non_sppd = 0;
		$dl_non_sppd2 = 0;
		$dl_sppd = 0;
		$cuti = 0;
		$sakit = 0;
		$sakit2 = 0;
		$izin = 0;
		$izin2 = 0;
		$tanpa_keterangan = 0;
		$dpk_dpb = 0;
		$tugas_belajar = 0;
		$TL[1] = 0;
		$TL[2] = 0;
		$TL[3] = 0;
		$TL[4] = 0;
		$KS1 = 0;
		$KS2 = 0;
		$KS3 = 0;
		$KS4 = 0;
		$PSW[1] = 0;
		$PSW[2] = 0;
		$PSW[3] = 0;
		$PSW[4] = 0;
		$CT = 0;
		$CB = 0;
		$CSRI = 0;
		$CSRJ = 0;
		$CM = 0;
		$CP = 0;
		$CLTN = 0;
		$TK = 0;
		$TBplus = 0;
		$TBmin = 0;
		$UP = 0;
		$jam_kerja = $Presensi->jam_kerja;
		$src = $Presensi->src;
		$cek = $Presensi->cek;
		
		switch ($kode_alasan)
		{
				
			case "DL LN":
			
				if ($status == "") $dl_ln = 1;
			
			break;
				
			case "DL NON SPPD":
			
				if ($status == "") $dl_non_sppd = 1;
				else if ($status == "1")
				{
					$hadir = 1;
					$tidak_hadir = 0;
					$dl_non_sppd2 = 1;
				}
				else $dl_non_sppd2 = 1;
			
			break;
				
			case "DL SPPD":
				
				if ($status == "") $dl_sppd = 1;
				else if ($status == "1")
				{
					$hadir = 0;
					$tidak_hadir = 1;
					$dl_sppd = 1;
				}
			
			break;
				
			case "S":
				
				if ($status == "") 
				{
					$sakit = 1;
					$CSRJ = 1;
				}
				else if ($status == "1")
				{
					$hadir = 1;
					$tidak_hadir = 0;
					$sakit2 = 1;
				}
				else $sakit2 = 1;
				
			break;
				
			case "CSRJ":
				
				if ($status == "") 
				{
					$sakit = 1;
					$CSRJ = 1;
				}
				
			break;
				
			case "CSRI":
				
				if ($status == "") 
				{
					$sakit = 1;
					$CSRI = 1;
				}
				
			break;
				
			case "I":
			
				if ($status == "") 
				{
					$izin = 1;
					$TK = 1;
				}
				else if ($status == "1")
				{
					$hadir = 1;
					$tidak_hadir = 0;
					$izin2 = 1;
				}
				else $izin2 = 1;
			
			break;
			
			case "ICP":
			
				if ($status == "")
				{
					$izin = 1;
					$CP = 1;
				}
			
			break;
			
			case "IPC":
			
				if ($status == "")
				{
					$izin = 1;
					$CT = 1;
				}
			
			break;
			
			case "ITK":
			
				if ($status == "")
				{
					$izin = 1;
					$TK = 1;
				}
			
			break;
				
			case "TK":
			
				if ($status == "")
				{
					$tanpa_keterangan = 1;
					$TK = 1;
				}
				else if ($status == "1")
				{
					$tanpa_keterangan = 0;
					$TK = 0;
					$hadir = 1;
					$tidak_hadir = 0;
				}
				else if ($status == "9")
				{
					$tanpa_keterangan = 0;
					$TK = 0;
					$hadir = 0;
					$tidak_hadir = 0;
				}
			
			break;
				
			case "DPK/DPB":
			
				if ($status == "") $dpk_dpb = 1;
			
			break;
				
			case "CT":
			
				if ($status == "") 
				{
					$cuti = 1;
					$CT = 1;
				}
			
			break;
			
			case "CB":
			
				if ($status == "") 
				{
					$cuti = 1;
					$CB = 1;
				}
				
			break;
				
			case "CM":
			
				if ($status == "") 
				{
					$cuti = 1;
					$CM = 1;
				}
			
			break;
				
			case "CP":
			
				if ($status == "") 
				{
					$cuti = 1;
					$CP = 1;
				}
			
			break;
			
			case "CLTN":
			
				if ($status == "") 
				{
					$cuti = 1;
					$CLTN = 1;
				}	
			
			break;
				
			case "TB 3+":
			
				if ($status == "") 
				{
					$tugas_belajar = 1;
					$TBplus = 1;
				}
			
			break;
				
			case "TB 3-":
			
				if ($status == "") 
				{
					$tugas_belajar = 1;
					$TBmin = 1;
				}	
			
			break;
				
			default:
				
				if ($status == "")
				{
					$tanpa_keterangan = 1;
					$TK = 1;
				}
				else if ($status == "1")
				{
					$tanpa_keterangan = 0;
					$TK = 0;
					$hadir = 1;
					$tidak_hadir = 0;
				}
				
			break;
		}
		
		if ($status == "1")
		{
			$kekurangan3 = get_kekurangan($nip,$tanggal,$jam,$status,'');
		
			$TL = cek_1234($kekurangan3);
			
			$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
			$row = mysql_fetch_array($rs);
			
			$TL[1] = cek_TL1($TL[1],$tanggal,$nip,$row['jam'],$kekurangan3);
			
			if ($kode_alasan == "DL NON SPPD" or $kode_alasan == "DL SPPD" or $kode_alasan == "DL LN")
			{
				$TL[1] = 0;
				$TL[2] = 0;
				$TL[3] = 0;
				$TL[4] = 0;
			}
		}
		else if ($status == "9")
		{
			$kekurangan3 = get_kekurangan($nip,$tanggal,$jam,$status,"");
			
			$PSW = cek_1234($kekurangan3);
			
			if ($kode_alasan == "DL NON SPPD" or $kode_alasan == "DL SPPD" or $kode_alasan == "DL LN")
			{
				$PSW[1] = 0;
				$PSW[2] = 0;
				$PSW[3] = 0;
				$PSW[4] = 0;
			}
		}
		
		$TL1 = $TL[1];
		$TL2 = $TL[2];
		$TL3 = $TL[3];
		$TL4 = $TL[4];
		$PSW1 = $PSW[1];
		$PSW2 = $PSW[2];
		$PSW3 = $PSW[3];
		$PSW4 = $PSW[4];
		
		foreach ($field as $k=>$val) 
		{
			$value[$k] = $$val;
		}
		
		$sql = sql_update($table."_".$u,$field,$value);
		
		return $sql;
	}
	
	function get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan) 
	{
		$kurang = 0;
		$y = substr($tanggal,0,4);
		
		if ($kode_alasan == '' or $kode_alasan == 'TK') 
		{
			switch ($status) 
			{
				case "1":
				
					$Pegawai = pegawai_id($nip);
					$u = substr($Pegawai->kode_bidang,0,2);
					$kode_jadwal_kerja = $Pegawai->jadwal_kerja;
					
					$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
					
					if (mysql_num_rows($oJadwalKerja) != 0)
					{
						if ($jam == "00:00:00") 
						{
							$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
							$row = mysql_fetch_array($rs);
							$jam = $row['jam'];
							$kurang = $row['kekurangan'];
						}
						
						$kekurangan = kekurangan_masuk($tanggal,$jam,$nip);
						
						if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
					}
					else
					{
					 	$jadwal_shift = jadwal_shift_id($tanggal,$nip);
						$jam_kerja = jam_kerja_id($jadwal_shift);
						
						if ($jam_kerja) $over_date = $jam_kerja->over_date;
						else $over_date = "";
						
						if ($over_date == 1)
						{
							if ($jam == "00:00:00")
							{
								$besok = date("Y-m-d",strtotime($tanggal)+1);
								$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$besok."' AND status = '9'");
								$row = mysql_fetch_array($rs);
								$jam = $row['jam'];
								$kurang = $row['kekurangan'];
							}
							
							$kekurangan = kekurangan_masuk($tanggal,$jam,$nip);
							
							if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
						}
						else
						{
							if ($jam == "00:00:00") 
							{
								$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '9'");
								$row = mysql_fetch_array($rs);
								$jam = $row['jam'];
								$kurang = $row['kekurangan'];
							}
							
							$kekurangan = kekurangan_masuk($tanggal,$jam,$nip);
							
							if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
						}
					}
					
				break;
				
				case "9":
				
					$Pegawai = pegawai_id($nip);
					$u = substr($Pegawai->kode_bidang,0,2);
					$kode_jadwal_kerja = $Pegawai->jadwal_kerja;
					
					$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
					
					if (mysql_num_rows($oJadwalKerja) != 0)
					{
						if ($jam == "00:00:00") 
						{
							$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '1'");
							$row = mysql_fetch_array($rs);
							$jam = $row['jam'];
							$kurang = $row['kekurangan'];
						}
						
						$kekurangan = kekurangan_keluar($tanggal,$jam,$nip);
						
						if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
					}
					else
					{
						$kemarin = date("Y-m-d",strtotime($tanggal)-1);
					 	$jadwal_shift = jadwal_shift_id($kemarin,$nip);
						$jam_kerja = jam_kerja_id($jadwal_shift);
						
						if ($jam_kerja) $over_date = $jam_kerja->over_date;
						else $over_date = "";
					
						if ($over_date == 1)
						{
							if ($jam == "00:00:00")
							{
								$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$kemarin."' AND status = '1'");
								$row = mysql_fetch_array($rs);
								$jam = $row['jam'];
								$kurang = $row['kekurangan'];
							}
							
							$kekurangan = kekurangan_keluar($kemarin,$jam,$nip);
							
							if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
						}
						else
						{
							if ($jam == "00:00:00") 
							{
								$rs = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."' AND status = '1'");
								$row = mysql_fetch_array($rs);
								$jam = $row['jam'];
								$kurang = $row['kekurangan'];
							}
							
							$kekurangan = kekurangan_keluar($tanggal,$jam,$nip);
							
							if ($kekurangan + $kurang > 450) $kekurangan = 450 - $kurang;
							
							#echo "dua<br>";
						}
					}
					
				break;
				
				case "":
				
					$kekurangan = 450;
				
				break;
			}
		}
		else $kekurangan = 0;
		
		return $kekurangan;
	}
	
	function isi_absensi($kode_unit) 
	{
		$hari_ini = date("Y-m-d");
		
		$kekurangan = 0;
		$oImport = import("`".$kode_unit."` = '0'");
				
		while ($Import = mysql_fetch_array($oImport)) 
		{
			if ($Import['date_from'] < $hari_ini)
			{
				$src = $Import['id'];
				$date_from = strtotime($Import['date_from']);
				$date_until = strtotime($Import['date_until']);
				
				for ($date = $date_from; $date <= $date_until; $date += 86400) 
				{
					$tanggal = date("Y-m-d",$date);
					$y = substr($tanggal,0,4);
					$m = substr($tanggal,0,7);
					
					$oPegawai = pegawai_list($kode_unit,"","1","nip");
					
					while ($Pegawai = mysql_fetch_array($oPegawai)) 
					{
						$nip = $Pegawai['nip'];
						$u = substr($Pegawai['kode_bidang'],0,2);
						
						cek_rekapitulasi($nip,$m,$u);
						
						$kode_jadwal_kerja = $Pegawai['jadwal_kerja'];
						$oJadwalKerja = jadwal_kerja_id($kode_jadwal_kerja);
						
						if (mysql_num_rows($oJadwalKerja) != 0)
						{
							$oJadwalKerja2 = jadwal_kerja("date_from <= '".$tanggal."' AND date_until >= '".$tanggal."'");
							$nJadwalKerja2 = mysql_num_rows($oJadwalKerja2);
							
							if ($nJadwalKerja2 == 0) $JadwalKerja = mysql_fetch_array($oJadwalKerja);
							else $JadwalKerja = mysql_fetch_array($oJadwalKerja2);
							
							$NamaHari = strtolower(nama_hari($tanggal));
							$JamKerja = $JadwalKerja[$NamaHari];
					
							$oLibur = libur("tanggal = '".$tanggal."'");
							$nLibur = mysql_num_rows($oLibur);
							$hari = strtolower(nama_hari($tanggal));
							
							if ($nLibur == 0 and $hari != "sabtu" and $hari != "minggu") 
							{
								$oPresensi = presensi($u,"nip = '".$nip."' AND tanggal = '".$tanggal."'");
								$num = mysql_num_rows($oPresensi);
								
								if ($num == 0) 
								{
									if ($Pegawai['status'] == '01' or $Pegawai['status'] == '02') 
									{
										$jam = "00:00:00";
										$status = "";
										$kode_alasan = "TK";
										$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
										$tidak_hadir = 1;
										$tanpa_keterangan = 1;
										$TK = 1;
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,tidak_hadir,tanpa_keterangan,TK,
											jam_kerja,src,cek) 
											VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$tidak_hadir."',
											'".$tanpa_keterangan."','".$TK."','".$JamKerja."','".$src."','50')
										"; 
										
										$query = mysql_query($sql);
									}
									else if ($Pegawai['status'] == '06' or $Pegawai['status'] == '07') 
									{
										$jam = "00:00:00";
										$status = "";
										$kode_alasan = "DPK/DPB";
										$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
										$tidak_hadir = 1;
										$dpk_dpb = 1;
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,tidak_hadir,dpk_dpb,jam_kerja,src,cek) 
											VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$tidak_hadir."','".$dpk_dpb."',
											'".$JamKerja."','".$src."','51')
										"; 
										
										$query = mysql_query($sql);
									}
									else if ($Pegawai['status'] == '16') 
									{
										$jam = "00:00:00";
										$status = "";
										$kode_alasan = "TB";
										$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
										$tidak_hadir = 1;
										$tugas_belajar = 1;
										$TBplus = 1;
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,tidak_hadir,tugas_belajar,TBplus,jam_kerja,src,
											cek) 
											VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$tidak_hadir."',
											'".$tugas_belajar."','".$TBplus."','".$JamKerja."','".$src."','52')
										"; 
										
										$query = mysql_query($sql);
									}
								}
								else if ($num == 1) 
								{
									$Presensi = mysql_fetch_array($oPresensi);
									
									if ($Presensi['jam'] != '00:00:00')
									{
										$jam = "00:00:00";
										$status = "9";
										$kode_alasan = "";
										$jam = "00:00:00";
										$kekurangan = get_kekurangan($nip,$tanggal,$jam,$status,$kode_alasan);
										
										$PSW[1] = 0;
										$PSW[2] = 0;
										$PSW[3] = 0;
										$PSW[4] = 0;
										
										$PSW = cek_1234($kekurangan);
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
											VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$PSW[1]."','".$PSW[2]."',
											'".$PSW[3]."','".$PSW[4]."','".$JamKerja."','".$src."','53')
										"; 
										
										$query = mysql_query($sql);
									}
								}
							}
						}
						else
						{						
							$oJadwalShift = jadwal_shift("nip = '".$nip."' AND tanggal = '".$tanggal."' AND jam_kerja != 'L' AND cek = '0'","jam_masuk");
							$nJadwalShift = mysql_num_rows($oJadwalShift);
							
							if ($nJadwalShift != 0)
							{
								while ($JadwalShift = mysql_fetch_array($oJadwalShift))
								{
									if ($JadwalShift['cek_masuk'] == '0')
									{
										$status = "";
										$kode_alasan = "TK";
										$kekurangan = 450;
										$tidak_hadir = 1;
										$tanpa_keterangan = 1;
										$TK = 1;
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,tidak_hadir,tanpa_keterangan,TK,
											jam_kerja,src,cek) 
											VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$tidak_hadir."',
											'".$tanpa_keterangan."','".$TK."','".$JadwalShift['id']."','".$src."','71')
										";
										
										$query = mysql_query($sql);
										
										$sql = "UPDATE jadwal_shift SET cek = '1' WHERE id = '".$JadwalShift['id']."'";
										$query = mysql_query($sql);
									}
									else if ($JadwalShift['cek_keluar'] == '0')
									{
										$oPresensi = presensi($u,"nip = '".$nip."' AND jam_kerja = '".$JadwalShift['id']."' AND status = '1'");
										$Presensi = mysql_fetch_array($oPresensi);
										
										$status = "9";
										$kode_alasan = "";
										$jam = "00:00:00";
										$kekurangan = 450 - $Presensi['kekurangan'];
										
										$PSW[1] = 0;
										$PSW[2] = 0;
										$PSW[3] = 0;
										$PSW[4] = 0;
										
										$PSW = cek_1234($kekurangan);
										
										$sql = "
											INSERT INTO presensi_".$u." (nip,tanggal,status,kekurangan,PSW1,PSW2,PSW3,PSW4,jam_kerja,src,cek) 
											VALUES ('".$nip."','".$tanggal."','".$status."','".$kekurangan."','".$PSW[1]."','".$PSW[2]."',
											'".$PSW[3]."','".$PSW[4]."','".$JadwalShift['id']."','".$src."','72')
										"; 
										
										$query = mysql_query($sql);
										
										$sql = "UPDATE jadwal_shift SET cek = '1' WHERE id = '".$JadwalShift['id']."'";
										$query = mysql_query($sql);
									}
								}
							}
						}
					}
				}
				
				$sql = "UPDATE import SET `".$kode_unit."` = '1' WHERE id = '".$Import['id']."'";
				$rs = mysql_query($sql);
			}
		}
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table regu_anggota -=-=-=-=-=-=-=-=-=-=-#
	
	function regu_anggota($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("regu_anggota",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table regu_shift -=-=-=-=-=-=-=-=-=-=-#
	
	function regu_shift($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("regu_shift",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table rekapitulasi -=-=-=-=-=-=-=-=-=-=-#
	
	function rekapitulasi($kode_bidang,$bulan) 
	{
		$u = substr($kode_bidang,0,2);
		
		$sql = "
			SELECT 
				a.nip,
				a.bulan,
				a.kekurangan,
				a.hadir,
				a.tidak_hadir,
				a.dl_ln,
				a.dl_non_sppd,
				a.dl_sppd,
				a.cuti,
				a.sakit,
				a.izin,
				a.tanpa_keterangan,
				a.dpk_dpb,
				a.tugas_belajar,
				a.TL1,
				a.TL2,
				a.TL3,
				a.TL4,
				a.PSW1,
				a.PSW2,
				a.PSW3,
				a.PSW4,
				a.CT,
				a.CB,
				a.CSRI,
				a.CSRJ,
				a.CM,
				a.CP,
				a.CLTN,
				a.TBmin,
				a.TBplus,
				b.nama,
				b.nip_baru,
				b.kode_bidang,
				b.status,
				b.jabatan_struktural,
				b.jabatan_fungsional,
				b.kode_golongan,
				c.NmGol1,
				d.nama as nama_bidang 
			FROM 
				rekapitulasi_".$u." a LEFT JOIN 
				pegawai b ON a.nip = b.nip LEFT JOIN 
				golongan c ON b.kode_golongan = c.KdGol LEFT JOIN 
				unit d ON b.kode_bidang = d.kode 
			WHERE 
				b.kode_bidang LIKE '".$kode_bidang."%' AND 
				a.bulan = '".$bulan."' AND 
				(
					b.status = '01' OR 
					b.status = '02' OR 
					b.status = '06' OR 
					b.status = '07' OR 
					b.status = '16'
				) 
			ORDER BY 
				b.kode_bidang,
				b.jabatan_struktural DESC,
				b.kode_golongan DESC,
				nip
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function rekapitulasi_2($kode_bidang,$bulan) 
	{
		$u = substr($kode_bidang,0,2);
		
		$sql = "
			SELECT 
				a.nip,
				a.kode_bidang,
				a.bulan,
				a.kekurangan,
				a.hadir,
				a.tidak_hadir,
				a.dl_ln,
				a.dl_non_sppd,
				a.dl_sppd,
				a.cuti,
				a.sakit,
				a.izin,
				a.tanpa_keterangan,
				a.dpk_dpb,
				a.tugas_belajar,
				a.TL1,
				a.TL2,
				a.TL3,
				a.TL4,
				a.KS1,
				a.KS2,
				a.KS3,
				a.KS4,
				a.PSW1,
				a.PSW2,
				a.PSW3,
				a.PSW4,
				a.CT,
				a.CB,
				a.CSRI,
				a.CSRJ,
				a.CM,
				a.CP,
				a.CLTN,
				a.TK,
				a.TBmin,
				a.TBplus,
				a.UP,
				b.nama,
				b.nip_baru,
				b.jabatan_struktural,
				b.jabatan_fungsional,
				b.kode_golongan,
				c.NmGol1,
				d.nama as nama_bidang 
			FROM 
				rekapitulasi_".$u." a LEFT JOIN 
				pegawai b ON a.nip = b.nip LEFT JOIN 
				golongan c ON b.kode_golongan = c.KdGol LEFT JOIN 
				unit d ON a.kode_bidang = d.kode 
			WHERE 
				a.kode_bidang LIKE '".$kode_bidang."%' AND 
				a.bulan = '".$bulan."' 
			ORDER BY 
				a.kode_bidang,
				a.jabatan_struktural DESC,
				a.kode_golongan DESC,
				a.nip
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
		
	function rekapitulasi_total($nip,$u,$bulan)
	{
		$m = substr($bulan,5,2) + 0;
		$y = substr($bulan,0,4);
		$jml = 0;
		
		for ($i = 1; $i <= $m; $i++)
		{
			if ($i <= 9) $i = '0'.$i;
			$bulan = $y.'-'.$i;
			
			$sql = "
				SELECT sum(kekurangan) as total 
				FROM rekapitulasi_".$u." 
				WHERE 
					nip = '".$nip."' AND 
					bulan = '".$bulan."'
			";
			
			$query = mysql_query($sql);
			$result = mysql_fetch_array($query);
			$jml += $result['total'];
		}
			
		return $jml;
	}
	
	function rekapitulasi_pegawai($nip,$bulan,$u) 
	{
		
		$sql = "
			SELECT * 
			FROM rekapitulasi_".$u." 
			WHERE 
				nip = '".$nip."' AND 
				bulan = '".$bulan."'
		";
		
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function update_rekapitulasi($kode_unit,$id,$hadir,$kekurangan,$dl_ln,$dl_non_sppd,$dl_sppd,$c,$s,$i,$tk,$dpk_dpb,$tb) 
	{
		$Rekapitulasi = rekapitulasi_id($kode_unit,$id);
		$hadir += $Rekapitulasi->hadir;
		$kekurangan += $Rekapitulasi->kekurangan;
		$dl_ln += $Rekapitulasi->dl_ln;
		$dl_non_sppd += $Rekapitulasi->dl_non_sppd;
		$dl_sppd += $Rekapitulasi->dl_sppd;
		$c += $Rekapitulasi->c;
		$s += $Rekapitulasi->s;
		$i += $Rekapitulasi->i;
		$tk += $Rekapitulasi->tk;
		$dpk_dpb += $Rekapitulasi->dpk_dpb;
		$tb += $Rekapitulasi->tb;
		
		$sql = "
			UPDATE rekapitulasi_".$kode_unit." 
			SET
				hadir = '".$hadir."',
				kekurangan = '".$kekurangan."',
				dl_ln = '".$dl_ln."',
				dl_non_sppd = '".$dl_non_sppd."',
				dl_sppd = '".$dl_sppd."',
				c = '".$c."',
				s = '".$s."',
				i = '".$i."',
				tk = '".$tk."',
				dpk_dpb = '".$dpk_dpb."',
				tb = '".$tb."'
			WHERE id = '".$id."'
		";
		
		return $sql;
	}
	
	function cek_rekapitulasi($nip,$m,$u)
	{
		$oRekapitulasi = rekapitulasi_pegawai($nip,$m,$u);
		$nRekapitulasi = mysql_num_rows($oRekapitulasi);
		
		if ($nRekapitulasi == 0)
		{
			$pegawai = pegawai_id($nip);
			
			$iRekapitulasi = "
				INSERT INTO rekapitulasi_".$u." (id,nip,kode_bidang,jabatan_struktural,kode_golongan,bulan) 
				VALUES ('','".$nip."','".$pegawai->kode_bidang."','".$pegawai->jabatan_struktural."','".$pegawai->kode_golongan."','".$m."')
			";
			
			mysql_query($iRekapitulasi);
		}
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table status = kd_stkepeg -=-=-=-=-=-=-=-=-=-=-#
		
	function status($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("status",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function status_list()
	{
		$query = status();
		
		return $query;
	}
	
	function status_id($kode) 
	{
		$query = status("kode = '".$kode."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table unit = kd_unit -=-=-=-=-=-=-=-=-=-=-#
		
	function unit($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("unit",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function unit_list() 
	{
		$query = unit("kode LIKE '__00' AND kode NOT LIKE '0_00'","kode");
		
		return $query;
		
	}
	
	function unit_id($kode_unit) 
	{
		$query = unit("kode LIKE '".$kode_unit."00'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function unit_kantor_pusat() 
	{
		$query = unit("kode LIKE '__00' AND kode NOT LIKE '0_00' AND kode_kawasan='1'","singkatan");
		
		return $query;	
	}
		
	function bidang_list($kode_unit) 
	{
		$query = unit("kode LIKE '".$kode_unit."_0' AND kode NOT LIKE '__00'","kode");
		
		return $query;
	}
	
	function bidang_id($kode_bidang) 
	{
		$query = unit("kode LIKE '".$kode_bidang."0'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
		
	function subbidang_list($kode_bidang) 
	{
		$query = unit("kode LIKE '".$kode_bidang."%' AND kode NOT LIKE '___0'","kode");
		
		return $query;
	}
	
	function subbidang_id($kode) 
	{
		$query = unit("kode LIKE '".$kode."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function bidang_subbidang_list($kode_unit)
	{
		$query = unit("kode LIKE '".$kode_unit."%'","kode");
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table upacara -=-=-=-=-=-=-=-=-=-=-#
		
	function upacara($where_clause = "",$sort_by = "") 
	{
		$sql = sql_select("upacara",$where_clause,$sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function upacara_list($tahun) 
	{
		$query = upacara("tanggal LIKE '".$tahun."%'","tanggal");
		
		return $query;
	}
	
	function upacara_id($id) 
	{
		$query = upacara("id = '".$id."'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=-  -=-=-=-=-=-=-=-=-=-=-#
	
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
	
	function get_jumlah_hari_kerja($u,$m,$y) 
	{	
		$bulan = $y."-".$m;
		$jumlah_hari = jumlah_hari($m,$y);
		$tgl = $bulan."-".$jumlah_hari;
		$hari_kerja = 0;
		
		$date_until = last_import($u);
		
		if ($tgl >= date("Y-m-d") or $tgl >= $date_until) $jumlah_hari = substr($date_until,8,2) + 0;
	
		for ($x = 1; $x <= $jumlah_hari; $x++) 
		{
			if ($x < 10) $x = "0".$x;
			
			$tgl = $bulan."-".$x;
			$oLibur = libur("tanggal = '".$tgl."'");
			$nLibur = mysql_num_rows($oLibur);
			$hari = strtolower(nama_hari($tgl));
			if ($hari != "sabtu" and $hari != "minggu" and $nLibur == 0) $hari_kerja++;
		}
		
		return $hari_kerja;
	}
	
	function format_nip_baru($nip_baru) 
	{
		$tgl_lahir = substr($nip_baru,0,8);
		$tgl_masuk = substr($nip_baru,8,6);
		$jns_kelamin = substr($nip_baru,14,1);
		$no_urut = substr($nip_baru,15,3);
		$nip_baru = $tgl_lahir." ".$tgl_masuk." ".$jns_kelamin." ".$no_urut;
		
		return $nip_baru;
	}
	
	function write_log($text,$unit,$ket) 
	{
		$filename = dateformat(now(),"Ymd_His")."_".$unit."_".$_SESSION['xusername']."_".$ket.".txt";
		$filedir = "menus/siapp/log/".$filename;
		$fr = fopen($filedir,'w');
		
		if (!$fr) echo "Error!!";
		else 
		{
			fwrite($fr,$text);
			fclose($fr);
		}
	}
?>