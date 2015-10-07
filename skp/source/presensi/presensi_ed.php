<?php
	#@
	/*
		File 			: /source/presensi/presensi_ed.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 19 Nov 2014
		Selesai Tanggal : 24 Nov 2014
		Fungsi 			: Menambahkan/mengubah alasan bagi pegawai yang terlambat/pulang lebih awal/tidak masuk kerja
		
		Revisi/Modifikasi :
		30 Nov 2014		: Menambahkan hitung otomatis untuk potongan cuti sakit (CS).
		
	*/
	
	checkauthentication();
	
	$err = false;
	$p = $_GET['p'];
	$u = $_GET['u'];
	$q = $_GET['q'];
	$x = $_GET['x'];
	$z = $_GET['z'];
	
	if (@$_POST['xPresensi']) 
	{		
		if ($err != true)
		{
			if (isset($_POST['q']))
			{
				extract($_POST);
				
				$s_presensi = "SELECT * FROM presensi WHERE id = '".$q."'";
				$q_presensi = mysql_query($s_presensi);
				$presensi = mysql_fetch_array($q_presensi);
				
				$nip = $presensi['nip'];
				$tanggal = $presensi['tanggal'];
				$m = substr($tanggal, 5, 2);
				$y = substr($tanggal, 0, 4);
				$tahun = substr($tanggal,0 ,4);
				$batas_masuk = $presensi['batas_masuk'];
				$batas_keluar = $presensi['batas_keluar'];
				$jam_masuk = $presensi['jam_masuk'];
				$jam_keluar = $presensi['jam_keluar'];
				$kekurangan_masuk = $presensi['kekurangan_masuk'];
				$kekurangan_keluar = $presensi['kekurangan_keluar'];
				$kode_alasan_masuk = $presensi['kode_alasan_masuk'];
				$kode_alasan_keluar = $presensi['kode_alasan_keluar'];
				$hadir = $presensi['hadir'];
				$tidak_hadir = $presensi['tidak_hadir'];
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
				$tugas_belajar = 0;
				$TL[0] = 0;
				$TL[1] = 0;
				$TL[2] = 0;
				$TL[3] = 0;
				$PSW[0] = 0;
				$PSW[1] = 0;
				$PSW[2] = 0;
				$PSW[3] = 0;
				$PSW[4] = 0;
				$CT = 0;
				$CB = 0;
				$CSRI = 0;
				$CM = 0;
				$CM3 = 0;
				$CP = 0;
				$CLTN = 0;
				$DK = 0;
				$TK = 0;
				$TBmin = 0;
				$UP = 0;
				$jam_kerja = $presensi['jam_kerja'];
				$src = $presensi['src'];
				$cek = $presensi['cek'];
				
				$url = "m=".$m."&y=".$y."&u=".$u."&b=".$b."&s=".$s."&r=".$r."&q=".$nip;
				
				switch ($kode_alasan)
				{
						
					case "DL LN":
					
						if ($status == "Tidak Masuk") $dl_ln = 1;
					
					break;
						
					case "DL NON SPPD":
					
						if ($status == "Tidak Masuk") $dl_non_sppd = 1;
						else if ($status == "Datang" or $status == "Pulang")
						{
							$hadir = 1;
							$tidak_hadir = 0;
							$dl_non_sppd2 = 1;
						}
					
					break;
						
					case "DL SPPD":
						
						if ($status == "Tidak Masuk") $dl_sppd = 1;
						else if ($status == "Datang" or $status == "Pulang")
						{
							$hadir = 0;
							$tidak_hadir = 1;
							$dl_sppd = 1;
						}
					
					break;
						
					case "S":
						
						if ($status == "Datang" or $status == "Pulang")
						{
							$hadir = 1;
							$tidak_hadir = 0;
							$sakit2 = 1;
						}
						
					break;
						
					case "CS":
						
						if ($status == "Tidak Masuk") 
						{
							$sakit = 1;
							$CSRI = 1;
						}
						
					break;
						
					case "DK":
					
						if ($status == "Tidak Masuk") 
						{
							$izin = 1;
							$DK = 1;
						}
					
					break;
						
					case "I":
					
						if ($status == "Datang" or $status == "Pulang")
						{
							$hadir = 1;
							$tidak_hadir = 0;
							$izin2 = 1;
						}
					
					break;
						
					case "TK":
					
						if ($status == "Tidak Masuk")
						{
							$tanpa_keterangan = 1;
							$TK = 1;
						}
						else if ($status == "Datang")
						{
							$tanpa_keterangan = 0;
							$TK = 0;
							$hadir = 1;
							$tidak_hadir = 0;
						}
						else if ($status == "Pulang")
						{
							$tanpa_keterangan = 0;
							$TK = 0;
							$hadir = 0;
							$tidak_hadir = 0;
						}
					
					break;
						
					case "CT":
					
						if ($status == "Tidak Masuk") 
						{
							$cuti = 1;
							$CT = 1;
						}
					
					break;
					
					case "CB":
					
						if ($status == "Tidak Masuk") 
						{
							$cuti = 1;
							$CB = 1;
						}
						
					break;
						
					case "CM":
					
						if ($status == "Tidak Masuk") 
						{
							$cuti = 1;
							$CM = 1;
						}
					
					break;
						
					case "CM3":
					
						if ($status == "Tidak Masuk") 
						{
							$cuti = 1;
							$CM3 = 1;
						}
					
					break;
						
					case "CP":
					
						if ($status == "Tidak Masuk") 
						{
							$cuti = 1;
							$CP = 1;
						}
					
					break;
					
					case "CLTN":
					
						if ($status == "Tidak Masuk") 
						{
							$cuti = 1;
							$CLTN = 1;
						}	
					
					break;
						
					case "TB":
					
						if ($status == "Tidak Masuk") 
						{
							$tugas_belajar = 1;
							$TBmin = 1;
		
						}	
					
					break;
						
					case "LA":
					
						$LA = 1;
					
					break;
						
					default:
						
						if ($status == "Tidak Masuk")
						{
							$tanpa_keterangan = 1;
							$TK = 1;
						}
						else if ($status == "Datang" or $status == "Pulang")
						{
							$tanpa_keterangan = 0;
							$TK = 0;
							$hadir = 1;
							$tidak_hadir = 0;
						}
						
					break;
				}
				
				if ($status == "Datang")
				{
					if ($kode_alasan == "" or $kode_alasan == "TK")
					{
						$kekurangan_masuk = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "masuk");
					}
					else $kekurangan_masuk = 0;
					
					$cek_TL = cek_TL($kekurangan_masuk);
					
					if ($kode_alasan == "DL NON SPPD" or $kode_alasan == "DL SPPD" or $kode_alasan == "DL LN" or $kode_alasan == "LA")
					{
						$cek_TL[0] = 0;
						$cek_TL[1] = 0;
						$cek_TL[2] = 0;
						$cek_TL[3] = 0;
					}
					
					$kode_alasan_masuk = $kode_alasan;
					$keterangan_masuk = $keterangan;
					
					if ($kode_alasan_keluar == "" or $kode_alasan_keluar == "TK")
					{
						$kekurangan_keluar = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "keluar");
					}
					else $kekurangan_keluar = 0;
					
					$cek_PSW = cek_PSW($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar);
					
					if ($kode_alasan == "DL NON SPPD" or $kode_alasan == "DL SPPD" or $kode_alasan == "DL LN" or $kode_alasan == "LA")
					{
						$cek_PSW[0] = 0;
						$cek_PSW[1] = 0;
						$cek_PSW[2] = 0;
						$cek_PSW[3] = 0;
						$cek_PSW[4] = 0;
					}
				}
				else if ($status == "Pulang")
				{
					if ($kode_alasan == "" or $kode_alasan == "TK")
					{
						$kekurangan_keluar = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "keluar");
					}
					else $kekurangan_keluar = 0;
					
					$cek_PSW = cek_PSW($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar);
					
					if ($kode_alasan == "DL NON SPPD" or $kode_alasan == "DL SPPD" or $kode_alasan == "DL LN" or $kode_alasan == "LA")
					{
						$cek_PSW[0] = 0;
						$cek_PSW[1] = 0;
						$cek_PSW[2] = 0;
						$cek_PSW[3] = 0;
						$cek_PSW[4] = 0;
					}
					
					$kode_alasan_keluar = $kode_alasan;
					$keterangan_keluar = $keterangan;
					
					if ($kode_alasan_masuk == "" or $kode_alasan_masuk == "TK")
					{
						$kekurangan_masuk = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "masuk");
					}
					else $kekurangan_masuk = 0;
					
					$cek_TL = cek_TL($kekurangan_masuk);
				}
				else if ($status == "Tidak Masuk")
				{
					if ($kode_alasan == "" or $kode_alasan == "TK") $kekurangan_masuk = 450;
					else $kekurangan_masuk = 0;
					
					$kode_alasan_masuk = $kode_alasan;
					$keterangan_masuk = $keterangan;
				}
				
				$TL = $cek_TL[0];
				$TL1 = $cek_TL[1];
				$TL2 = $cek_TL[2];
				$TL3 = $cek_TL[3];
				$PSW = $cek_PSW[0];
				$PSW1 = $cek_PSW[1];
				$PSW2 = $cek_PSW[2];
				$PSW3 = $cek_PSW[3];
				$PSW4 = $cek_PSW[4];
				
				$s_update = "UPDATE presensi SET nip = '".$nip."', tanggal = '".$tanggal."', kekurangan_masuk = '".$kekurangan_masuk."', 
				kekurangan_keluar = '".$kekurangan_keluar."', kode_alasan_masuk = '".$kode_alasan_masuk."', kode_alasan_keluar = '".$kode_alasan_keluar."', 
				keterangan_masuk = '".$keterangan_masuk."', keterangan_keluar = '".$keterangan_keluar."', hadir = '".$hadir."', 
				tidak_hadir = '".$tidak_hadir."', dl_ln = '".$dl_ln."', dl_non_sppd = '".$dl_non_sppd."', dl_non_sppd2 = '".$dl_non_sppd2."', 
				dl_sppd = '".$dl_sppd."', cuti = '".$cuti."', sakit = '".$sakit."', sakit2 = '".$sakit2."', izin = '".$izin."', izin2 = '".$izin2."', 
				tanpa_keterangan = '".$tanpa_keterangan."', dpk_dpb = '".$dpk_dpb."', tugas_belajar = '".$tugas_belajar."', TL = '".$TL."', TL1 = '".$TL1."',
				TL2 = '".$TL2."', TL3 = '".$TL3."', PSW = '".$PSW."', PSW1 = '".$PSW1."', PSW2 = '".$PSW2."', PSW3 = '".$PSW3."', 
				PSW4 = '".$PSW4."', CT = '".$CT."', CB = '".$CB."', CSRI = '".$CSRI."', CSRJ = '".$CSRJ."', CM = '".$CM."', CM3 = '".$CM3."', 
				CP = '".$CP."', CLTN = '".$CLTN."', DK = '".$DK."', TK = '".$TK."', TBmin = '".$TBmin."', TBplus = '".$TBplus."', UP = '".$UP."', 
				LA = '".$LA."', src = '".$filename."' WHERE id = '".$q."'";
				
				$rs = mysql_query($s_update);
				
				#START 30 Nov 2014 #########################################################################
				
				$s_potongan = "SELECT id FROM potongan WHERE nip = '".$nip."' AND bulan = '".$y."-".$m."'";
				$q_potongan = mysql_query($s_potongan);
				$potongan = mysql_fetch_array($q_potongan);
				
				$s_rekapitulasi = "SELECT CSRI FROM rekapitulasi WHERE nip = '".$nip."' AND bulan = '".$y."-".$m."'";
				$q_rekapitulasi = mysql_query($s_rekapitulasi);
				$rekapitulasi = mysql_fetch_array($q_rekapitulasi);
				
				if ($rekapitulasi['CSRI'] >= 1 and $rekapitulasi['CSRI'] <= 2) $potongan_cs = 0;
				else if ($rekapitulasi['CSRI'] >= 3 and $rekapitulasi['CSRI'] <= 14) $potongan_cs = 25;
				else if ($rekapitulasi['CSRI'] >= 15 and $rekapitulasi['CSRI'] <= 30) $potongan_cs = 50;
				
				$s_update_cs = "UPDATE potongan SET CSRI = '".$potongan_cs."' WHERE id = '".$potongan['id']."'";
				$q_update_cs = mysql_query($s_update_cs);
				
				#END 30 Nov 2014 ###########################################################################
				
				if ($rs) 
				{	
					update_log("Ubah data presensi berhasil. NIP = ".$nip, "presensi", 1);
					$_SESSION['errmsg'] = "Ubah data presensi berhasil."; ?>
					
                    <meta http-equiv="refresh" content="0;URL=index.php?p=468&<?php echo $url; ?>"><?php
				}
				else 
				{
					update_log("Ubah data presensi gagal. NIP = ".$nip, "presensi", 0);
					$_SESSION['errmsg'] = "Ubah data presensi gagal."; ?>
					
                    <meta http-equiv="refresh" content="0;URL=index.php?p=468&<?php echo $url; ?>"><?php
				}
			}
		}
		else
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=468&<?php echo $url; ?>"><?php		
		}
	} 
	else if (isset($_GET["q"]))
	{
		$s_presensi = "SELECT * FROM presensi WHERE id = '".$_GET['q']."'";
		$q_presensi = mysql_query($s_presensi);
		$presensi = mysql_fetch_array($q_presensi);
		
		$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$presensi['nip']."'";
		$q_pegawai = mysql_query($s_pegawai);
		$pegawai = mysql_fetch_array($q_pegawai);
	}
	else
	{
		$presensi = array();
		$pegawai = array();
	}
?>
<script language="javascript" src="lib/autocombo/autocombo.js"></script>

<link href="css/general.css" rel="stylesheet" type="text/css" />
<div id="divResult" style="font-size:11px;text-align:center;display:none"></div>

<form name="xPresensi" method="post" action="">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">NIP</td>
			<td>
				<input type="text" name="nip_baru" size="20" value="<?php echo $presensi['nip']; ?>" readonly />
				<input type="hidden" name="nip" value="<?php echo $value['nip']; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="nama" size="40" value="<?php echo trim($pegawai['nama']); ?>" readonly /></td>
		</tr>
		<tr>
			<td class="key">Tanggal</td>
			<td><input type="text" name="tanggal" size="10" value="<?php echo $presensi['tanggal']; ?>" readonly /></td>
		</tr><?php
        
		if ($z == 1)
		{ ?>
            
            <tr>
                <td class="key">Jam</td>
                <td><input type="text" name="jam" size="10" value="<?php echo $presensi['jam_masuk']; ?>" readonly /></td>
            </tr>
            <tr>
                <td class="key">Kekurangan</td>
                <td><input type="text" name="kekurangan" size="10" value="<?php echo $presensi['kekurangan_masuk']; ?>" readonly /> menit</td>
            </tr>
            <tr>
                <td class="key">status</td>
                <td><input type="text" name="status" size="10" value="Tidak Masuk" readonly /></td>
            </tr>
            <tr>
                <td class="key">Alasan</td>
                <td>
                    <select name="kode_alasan">
                        <option value=""></option><?php
                        
						$s_alasan = "SELECT * FROM alasan WHERE absen = '1' ORDER BY keterangan";
						$q_alasan = mysql_query($s_alasan);
                        
                        while ($alasan = mysql_fetch_array($q_alasan)) 
                        { ?>
                            <option value="<?php echo $alasan['kode']; ?>" <?php if ($alasan['kode'] == $presensi['kode_alasan_masuk']) echo "selected"; ?>><?php echo $alasan['keterangan']; ?></option><?php
                        } ?>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">Keterangan</td>
                <td><input type="text" name="keterangan" size="40" value="<?php echo strtoupper($presensi['keterangan_masuk']); ?>" /></td>
            </tr><?php
        
		}
		else
		{ 
			if ($x == 0)
			{ ?>
            
                <tr>
                    <td class="key">Jam Datang</td>
                    <td><input type="text" name="jam" size="10" value="<?php echo $presensi['jam_masuk']; ?>" readonly /></td>
                </tr>
                <tr>
                    <td class="key">Kekurangan</td>
                    <td><input type="text" name="kekurangan" size="10" value="<?php echo $presensi['kekurangan_masuk']; ?>" readonly /> menit</td>
                </tr>
                <tr>
                    <td class="key">status</td>
                    <td><input type="text" name="status" size="10" value="Datang" readonly /></td>
                </tr>
                <tr>
                    <td class="key">Alasan</td>
                    <td>
                        <select name="kode_alasan">
                            <option value=""></option><?php
							
							$s_alasan = "SELECT * FROM alasan WHERE masuk = '1' ORDER BY keterangan";
							$q_alasan = mysql_query($s_alasan);
                            
                            while ($alasan = mysql_fetch_array($q_alasan)) 
                            { ?>
                                <option value="<?php echo $alasan['kode']; ?>" <?php if ($alasan['kode'] == $presensi['kode_alasan_masuk']) echo "selected"; ?>><?php echo $alasan['keterangan']; ?></option><?php
                            } ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="key">Keterangan</td>
                    <td><input type="text" name="keterangan" size="40" value="<?php echo strtoupper($presensi['keterangan_masuk']); ?>" /></td>
                </tr><?php
		
			}
			else if ($x == 1)
			{ ?>
            
                <tr>
                    <td class="key">Jam Pulang</td>
                    <td><input type="text" name="jam" size="10" value="<?php echo $presensi['jam_keluar']; ?>" readonly /></td>
                </tr>
                <tr>
                    <td class="key">Kekurangan</td>
                    <td><input type="text" name="kekurangan" size="10" value="<?php echo $presensi['kekurangan_keluar']; ?>" readonly /> menit</td>
                </tr>
                <tr>
                    <td class="key">status</td>
                    <td><input type="text" name="status" size="10" value="Pulang" readonly /></td>
                </tr>
                <tr>
                    <td class="key">Alasan</td>
                    <td>
                        <select name="kode_alasan">
                            <option value=""></option><?php
							
							$s_alasan = "SELECT * FROM alasan WHERE masuk = '1' ORDER BY keterangan";
							$q_alasan = mysql_query($s_alasan);
                            
                            while ($alasan = mysql_fetch_array($q_alasan)) 
                            { ?>
                                <option value="<?php echo $alasan['kode']; ?>" <?php if ($alasan['kode'] == $presensi['kode_alasan_keluar']) echo "selected"; ?>><?php echo $alasan['keterangan']; ?></option><?php
                            } ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="key">Keterangan</td>
                    <td><input type="text" name="keterangan" size="40" value="<?php echo strtoupper($presensi['keterangan_keluar']); ?>" /></td>
                </tr><?php
			
			}
		} ?>
        
        <tr>
            <td>&nbsp;</td>
            <td>
                <div class="button2-right">
                    <div class="prev">
                        <a onclick="Cancel('index.php?p=468')">Batal</a>
                    </div>
                </div>
                <div class="button2-left">
                    <div class="next">
                        <a onclick="Btn_Submit('xPresensi');">Proses</a>
                    </div>
                </div>
                <div class="clr"></div>
                <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Proses" type="submit">
                <input name="xPresensi" type="hidden" value="1" />
                <input name="q" type="hidden" value="<?php echo @$_GET['q']; ?>" />
				<input name="u" type="hidden" value="<?php echo $_GET['u']; ?>" />
				<input name="b" type="hidden" value="<?php echo $_GET['b']; ?>" />
				<input name="s" type="hidden" value="<?php echo $_GET['s']; ?>" />
				<input name="x" type="hidden" value="<?php echo $x; ?>" />
            </td>
        </tr>
	</table>
</form>