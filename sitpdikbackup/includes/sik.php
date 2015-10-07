<?php
	#-=-=-=-=-=-=-=-=-=-=- Table kd_eselon -=-=-=-=-=-=-=-=-=-=-#
	
	function kd_eselon($where_clause = "", $sort_by = "")
	{
		$sql = sql_select("kd_eselon", $where_clause, $sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function kd_eselon_list()
	{
		$query = kd_eselon("", "Kdeselon");
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table kd_fungsional -=-=-=-=-=-=-=-=-=-=-#
	
	function kd_fungsional($where_clause = "", $sort_by = "")
	{
		$sql = sql_select("kd_fungsional", $where_clause, $sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function kd_fungsional_list()
	{
		$query = kd_fungsional("", "KdFungsi");
		
		return $query;
	}
	
	function kd_fungsional_id($KdFungsi)
	{
		$query = kd_fungsional("KdFungsi = '".$KdFungsi."'");
		$result = mysql_fetch_array($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table kd_gol = golongan -=-=-=-=-=-=-=-=-=-=-#
	
	function kd_gol($where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("kd_gol", $where_clause, $sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function kd_gol_list() 
	{
		$query = kd_gol("", "KdGol");
		
		return $query;
		
	}
	
	function kd_gol_id($KdGol) 
	{
		$query = kd_gol("KdGol = '" . $KdGol . "'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table kd_jabatan -=-=-=-=-=-=-=-=-=-=-#
	
	function kd_jabatan($where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("kd_jabatan", $where_clause, $sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table m_idpegawai = pegawai -=-=-=-=-=-=-=-=-=-=-#
		
	function m_idpegawai($where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("m_idpegawai", $where_clause, $sort_by);
		$query = mysql_query($sql);
		
		return $query;
	}
	
	function m_idpegawai_list($KdUnitKerja, $wordkey = "", $aktif = 0, $sort_by) 
	{
		if ($aktif == 1)
		{
			if ($wordkey == "") 
			{
				$query = m_idpegawai("KdUnitKerja LIKE '" . $KdUnitKerja . "%'", $sort_by);
			}
			else 
			{
				$query = pegawai("(KdUnitKerja LIKE '" . $KdUnitKerja . "%') AND (Nib LIKE '%" . $wordkey . "%' OR 
					Nip LIKE '%" . $wordkey . "%' OR NamaLengkap LIKE '%" . $wordkey . "%')", $sort_by);
			}
		}
		else
		{
			if ($wordkey == "") 
			{
				$query = m_idpegawai("KdUnitKerja LIKE '" . $KdUnitKerja . "%' AND (KdStatusPeg = '1' OR KdStatusPeg = '2')",
					$sort_by);
			}
			else 
			{
				$query = m_idpegawai("(KdUnitKerja LIKE '" . $KdUnitKerja . "%') AND (Nib LIKE '%" . $wordkey . "%' OR 
					Nip LIKE '%" . $wordkey . "%' OR NamaLengkap LIKE '%" . $wordkey . "%') AND (KdStatusPeg = '1' OR 
					KdStatusPeg = '2')", $sort_by);
			}
		}
		
		return $query;
	}
	
	function m_idpegawai_id($Nib) 
	{
		$query = m_idpegawai("Nib = '" . $Nib . "'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	function get_jabatan_2($Nib)
	{
		$Pegawai = m_idpegawai_id($Nib);
		
		echo $Pegawai->jabatan_fungsional;
		
		if ($Pegawai->KdEselon == "")
		{
			$oJab = kd_jabatan("Kode = '".$Pegawai->KdKelJabatan.$Pegawai->KdFungsional."'");
			$Jab = mysql_fetch_object($oJab);
			$jabatan = @$Jab->NmJabatan;
		}
		else
		{
			if (substr($Pegawai->KdUnitKerja, 0, 3) == "000")
			{
				$deputi = substr($Pegawai->KdUnitKerja, 3, 1);
				
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
						$jabatan = "Deputi Kepala Bidang Pendayagunaan Hasil Litbang & Pemasyarakatan Ilmu Pengetahuan dan 
							Teknologi Nuklir"; 
					break;
				}
			}
			else
			{
				$bidang = subbidang_id_2($Pegawai->KdUnitKerja);
				$jabatan = "Kepala " . $bidang->NmUnit;
			}
		}
		
		return $jabatan;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table kd_unit = unit -=-=-=-=-=-=-=-=-=-=-#
		
	function kd_unit($where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("kd_unit", $where_clause, $sort_by);
		#echo $sql."<br>";
		$query = mysql_query($sql);
		
		return $query;
	}
		
	function bidang_list_2($KdUnit) 
	{
		$query = kd_unit("KdUnit LIKE '" . $KdUnit . "_0' AND KdUnit NOT LIKE '__00'", "KdUnit");
		
		return $query;
	}
	
	function bidang_id_2($KdUnit) 
	{
		$query = kd_unit("KdUnit LIKE '" . $KdUnit . "0'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
		
	function subbidang_list_2($KdUnit) 
	{
		$query = kd_unit("KdUnit LIKE '" . $KdUnit . "%' AND KdUnit NOT LIKE '___0'", "KdUnit");
		
		return $query;
	}
	
	function subbidang_id_2($KdUnit) 
	{
		$query = kd_unit("KdUnit LIKE '" . $KdUnit . "'");
		$result = mysql_fetch_object($query);
		
		return $result;
	}
	
	#-=-=-=-=-=-=-=-=-=-=-  -=-=-=-=-=-=-=-=-=-=-#
	
	function sik_connection()
	{
		$link = mysql_connect('183.91.67.3', 'abrarhedar', 'fathia');
		
		if (!$link) 
		{
			die('Could not connect: ' . mysql_error());
		}
	
		return $link;
	}
	
	#-=-=-=-=-=-=-=-=-=-=-  -=-=-=-=-=-=-=-=-=-=-#
?>