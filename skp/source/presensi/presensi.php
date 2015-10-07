<?php
	#@
	/*
		File 			: /source/presensi/presensi.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 15 Nov 2014
		Selesai Tanggal : 16 Nov 2014
		Fungsi 			: Menampilkan data presensi pegawai
		
		Revisi/Modifikasi :
		19 Nov 2014		: Penyesuaian link/tombol edit alasan
		30 Nov 2014		: Tambah menu cetak dalam format PDF dan EXCEL
		04 Des 2014		: Mengubah Query Pegawai. Jika kdunit = SETDITJEN, maka tampilkan juga DITJEN
		04 Des 2014		: Tambahkan Status Verifikasi. Jika telah diverifikasi, maka data presensi tidak bisa diubah.
		
	*/
	
	checkauthentication();
	$table = "presensi";
	$field = array('id', 'nip', 'tanggal', 'batas_masuk', 'batas_keluar', 'jam_masuk', 'jam_keluar', 'status', 'kekurangan_masuk', 'kekurangan_keluar', 
	'kode_alasan_masuk', 'kode_alasan_keluar', 'keterangan_masuk', 'keterangan_keluar', 'hadir', 'tidak_hadir', 'dl_ln', 'dl_non_sppd', 'dl_non_sppd2', 
	'dl_sppd', 'cuti', 'sakit', 'sakit2', 'izin', 'izin2', 'tanpa_keterangan', 'dpk_dpb', 'tugas_belajar', 'TL', 'TL1', 'TL2', 'TL3', 'TL4', 'KS', 'KS1', 
	'KS2', 'KS3', 'KS4', 'PSW', 'PSW1', 'PSW2', 'PSW3', 'PSW4', 'CT', 'CB', 'CSRI', 'CSRJ', 'CM', 'CM3', 'CP', 'CLTN', 'DK', 'TK', 'TBmin', 'TBplus', 'UP', 
	'jam_kerja', 'src', 'cek');
	
	$p = $_GET['p'];
	$u = @$_GET['u'];
	$b = @$_GET['b'];
	$s = @$_GET['s'];
	$q = @$_GET['q'];
	$m = @$_GET['m'] + 0;
	$y = @$_GET['y'];
	$r = @$_GET['r'];
	$Session['xusername'] = $_SESSION['xusername'];
	$Session['xlevel'] = $_SESSION['xlevel'];
	$Session['xkdunit'] = $_SESSION['xkdunit'];
	
	if ($u == "") $u = substr($Session['xkdunit'], 0, 5);
	if ($m == "") $m = date("n");
	if ($m < 10) $m = "0".$m;
	if ($y == "") $y = date("Y");
	if ($r == "") $r = 1;
	
	$bulan = $y."-".$m;
	
	# Eselon 2 / Admin / Operator
	if ($Session['xlevel'] <= 6) $bidang = $u;
	
	# Eselon 3
	else if ($Session['xlevel'] == 7)
	{
		$s_user = "SELECT * FROM m_idpegawai WHERE nip = '".$Session['xusername']."'";
		$q_user = mysql_query($s_user);
		$user = mysql_fetch_array($q_user);
		$bidang = substr($user['kdunitkerja'],0,6);
	}
	
	# Eselon 4
	else if ($Session['xlevel'] == 8)
	{
		$s_user = "SELECT * FROM m_idpegawai WHERE nip = '".$Session['xusername']."'";
		$q_user = mysql_query($s_user);
		$user = mysql_fetch_array($q_user);
		$bidang = $user['kdunitkerja'];
	}
	
	# Staf
	else if ($Session['xlevel'] == 9)
	{
		$q = $Session['xusername'];
		$s_user = "SELECT * FROM m_idpegawai WHERE nip = '".$q."'";
		$q_user = mysql_query($s_user);
		$user = mysql_fetch_array($q_user);
		$bidang = $user['kdunitkerja'];
	}
	
	if ($Session['xkdunit'] == "2320100" and $Session['xlevel'] <= 3)
	{
		$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$q."' AND (kdunitkerja LIKE '".$bidang."%' OR kdunitkerja = '2320000')";
	}
	else
	{
		$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$q."' AND kdunitkerja LIKE '".$bidang."%'";
	}
	
	#echo $s_pegawai."<BR>";
	
	$q_pegawai = mysql_query($s_pegawai);
	$n_pegawai = mysql_num_rows($q_pegawai);
		
	if ($n_pegawai == 0)
	{
		$nip = "";
	}
	else
	{
		$pegawai = mysql_fetch_array($q_pegawai);
		$nip = $pegawai['nip'];
	}
		
	$url = "m=".$m."&y=".$y."&u=".$u."&b=".$b."&s=".$s."&r=".$r;
	$ed_link = "index.php?p=470&u=".$u;
	$jumlah_hari = jumlah_hari($m, $y);
		
	$s_presensi = "SELECT * FROM presensi WHERE nip = '".$nip."' AND tanggal LIKE '".$bulan."%' ORDER BY tanggal";
	
	#echo $s_presensi."<BR>";
	
	$q_presensi = mysql_query($s_presensi);
	$n_presensi = mysql_num_rows($q_presensi);
		
	if ($n_presensi != 0) 
	{
		$l = 0;
		
		while ($presensi = mysql_fetch_array($q_presensi)) 
		{
			foreach ($field as $k=>$val) 
			{
				$col[$val][] = $presensi[$val];
			}
			
			$ed[] = $ed_link."&q=".$presensi['id'];
			#$rowspan[] = $counta;
			
			#$d = substr($presensi['tanggal'],8,2) + 0;
			
			#if ($d % 2 == 1) $class[] = "row1";
			#else $class[] = "row0";
		}
	} ?>

	<script language="javascript" src="lib/autocombo/autocombo.js"></script>
	<link href="lib/ajaxcrud/css/thickbox.css" rel="stylesheet" type="text/css" />
	<!--script language="javascript" src="lib/ajaxcrud/js/jquery.js"></script>
	<script language="javascript" src="lib/ajaxcrud/js/thickbox.js"></script>
	<script language="javascript" src="lib/ajaxcrud/js/jquery.form.js"></script>
	<script language="javascript" src="lib/ajaxcrud/siapp/presensi.js"></script-->
	
	<form action="" method="get" name="xPresensi">
		<input name="p" type="hidden" value="<?php echo $p; ?>">
		<fieldset>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">Cetak</td>
					<td>
						<!--a href="source/presensi/presensi_print.php?<?php #echo $url; ?>&q=<?php #echo $q; ?>&t=pdf" target="_blank">
							<img src="css/images/PDF-Icon2.gif" width="16" height="16" />&nbsp;PDF
						</a> &nbsp; | &nbsp; -->
						
						<a href="source/presensi/presensi_print.php?<?php echo $url; ?>&q=<?php echo $q; ?>&t=excel" target="_blank">
							<img src="css/images/excel.gif" width="16" height="16" />&nbsp;Excel
						</a> &nbsp; | &nbsp;
						
						<a href="source/presensi/presensi_print.php?<?php echo $url; ?>&q=<?php echo $q;?>&t=calc" target="_blank">
							<img src="css/images/openoffice.gif" width="16" height="16" />&nbsp;Open Office
						</a>
					</td>
				</tr>
				<tr>
					<td class="key">Bulan</td>
					<td>
						<select name="m">
							<option></option><?php
							
							for ($month = 1; $month <= 12; $month++) 
							{ ?>
							
								<option value="<?php echo $month; ?>" <?php if ($month == $m) echo "selected"; ?>><?php 
									
									echo nama_bulan($month); ?>
									
								</option><?php
								
							} ?>
						
						</select>
						
						<select name="y">
							<option></option><?php
							
							for ($year = date("Y") - 10; $year <= date("Y") + 10; $year++) 
							{ ?>
							
								<option value="<?php echo $year; ?>" <?php if ($year == $y) echo "selected"; ?>><?php 
							
									echo $year ?>
							
								</option><?php
							
							} ?>
						
						</select><?php
						
						if ($Session['xlevel'] <= 4)
						{ ?>
							
							<input name="u" type="hidden" value="<?php echo $u; ?>">
							<input name="b" type="hidden" value="<?php echo $b; ?>">
							<input name="s" type="hidden" value="<?php echo $s; ?>"><?php
							
						} ?>
						
						<input name="r" type="hidden" value="<?php echo $r; ?>">
					</td>
				</tr><?php
				
				if ($Session['xlevel'] <= 5)
				{ ?>
					<tr>
						<td class="key">Nama</td>
						<td><?php
							
							if ($Session['xkdunit'] == "2320100" and $Session['xlevel'] <= 3)
							{
								$s_pegawai = "SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '".$bidang."%' OR kdunitkerja = '2320000' ORDER BY 
								kdunitkerja, kdgol DESC, nip";
							}
							else
							{
								$s_pegawai = "SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '".$bidang."%' ORDER BY kdunitkerja, kdgol DESC, nip";
							}
							
							$q_pegawai = mysql_query($s_pegawai);
							$n_pegawai = mysql_num_rows($q_pegawai);
							
							if ($n_pegawai != 0) 
							{ ?>
							
								<select name="q">
									<option></option><?php
									
									$kode_bidang = "";
									
									while ($pegawai = mysql_fetch_array($q_pegawai)) 
									{ 
										if ($pegawai['kdunitkerja'] != $kode_bidang)
										{
											$s_bidang = "SELECT * FROM kd_unitkerja WHERE kdunit = '".$pegawai['kdunitkerja']."'";
											$q_bidang = mysql_query($s_bidang);
											$bdg = mysql_fetch_array($q_bidang); ?>
											
											<optgroup label="<?php echo $bdg['nmunit']; ?>"></optgroup><?php
										
										} ?>
										
										<option value="<?php echo $pegawai['nip']; ?>" <?php if ($pegawai['nip'] == $q) echo "selected"; ?>><?php 
										
											echo trim($pegawai['nama']); ?>
											
										</option><?php
										
										$kode_bidang = $pegawai['kdunitkerja'];
									} ?>
								
								</select><?php
								
							} ?>
								
						</td>
					</tr><?php
				} ?>
                
                <tr>
                    <td class="key">Status Verifikasi</td>
                    <td><?php
                        
                        $s_verifikasi = "SELECT * FROM proses_verifikasi WHERE tahun = '".$y."' AND bulan = '".$m."' AND 
                        kdunitkerja = '".$_SESSION['xkdunit']."'";
    
                        $q_verifikasi = mysql_query($s_verifikasi);
                        $n_verifikasi = mysql_num_rows($q_verifikasi);
                        
                        if ($n_verifikasi == 0) echo "Belum Diverifikasi";
                        else
                        {
                            $ver = mysql_fetch_array($q_verifikasi);
                            
                            if ($ver['status_verifikasi_potongan'] == "1") echo "Telah Diverifikasi";
                            else echo "Belum Diverifikasi";
                        } ?>
                        
                    </td>
                </tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div class="button2-right">
							<div class="prev">
								<a onclick="Back('index.php?p=<?php echo $r; ?>&<?php echo $url; ?>')">Kembali</a>
							</div>
						</div>
						<div class="button2-left">
							<div class="next">
								<a onclick="Btn_Submit('xPresensi');">OK</a>
							</div>
						</div>
						<div class="clr"></div>
						<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="OK" type="submit">
					</td>
				</tr>
			</table>
		</fieldset>
	</form>
	
	<table class="adminlist" cellpadding="1" width="72%">
		<thead>
			<tr>
				<th width="3%">#</th>
				<th width="9%">Tanggal</th>
				<th width="13%">Hari</th>
				<th width="16%">Status</th>
				<th width="11%">Jam</th>
				<th width="9%">Kekurangan<br />(menit)</th>
				<th width="11%">Keterangan Alasan</th>
				<th width="8%">Tunjangan Kinerja</th>
				<th>Keterangan</th><?php
				
				if ($Session['xlevel'] <= 4 and ($ver['status_verifikasi_potongan'] == "0" or $ver['status_verifikasi_potongan'] == ""))
				{ ?>
				
					<th width="3%">Aksi</th><?php
					
				}?>
				
			</tr>
		</thead>
		<tbody><?php
		
			if ($n_presensi == 0) 
			{ ?>
			
				<tr><td align="center" colspan="10">Tidak ada data!</td></tr><?php
			
			}
			else 
			{
				$l = 0;
				$tanggal = "";
				
				foreach ($col['id'] as $k=>$val) 
				{
					#$x = 0;
					
					if ($col['status'][$k] == 0 or $col['status'] == 3)
					{
						$class[$k] = 'row1';
					}
					else if ($col['status'][$k] == 1) 
					{
						$class[$k] = 'row2';
						$z = 1;
					}
					else 
					{
						$class[$k] = 'row0';
						$z = 0;
					} ?>
					
					<tr class="<?php echo $class[$k]; ?>" id="tr<?php echo $val; ?>"><?php
						
						#if ($tanggal != $col['tanggal'][$k]) 
						#{
							$l++;
							
							if ($col['status'][$k] == 2) $rowspan = 2;
							else $rowspan = 1; ?>
							
							<td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo $l; ?></td>
							<td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo dmy($col['tanggal'][$k]); ?></td>
							<td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo strtoupper(nama_hari($col['tanggal'][$k])); ?></td><?php
							
							#$x = 1;
							$x = 0;
						#} ?>
						
						<td align="center" nowrap="nowrap"><?php 
							
							if ($col['status'][$k] == 0) $status = "LIBUR";
							else if ($col['status'][$k] == 1) $status = "TIDAK HADIR";
							else if ($col['status'][$k] == 2) $status = "DATANG";
							else if ($col['status'][$k] == 3) $status = "CUTI BERSAMA";
							else $status = "";
							
							echo $status; ?>
						
						</td>
						<td align="center"><?php 
							
							$jam_masuk = substr($col['jam_masuk'][$k],0,5);
							
							echo $jam_masuk; ?>
						
						</td>
						<td align="right"><?php 
							
							if ($col['kekurangan_masuk'][$k] > 0) 
							{ ?>
							
								<font color="#f00"><?php echo $col['kekurangan_masuk'][$k] ?></font><?php
								
							}
							else echo $col['kekurangan_masuk'][$k]; ?>
							
						</td><?php
						
						/*if ($col['dl_ln'][$k] == 1) $title = "Dinas Luar (Luar Negeri)";
						else if ($col['dl_non_sppd'][$k] == 1) $title = "Dinas Luar (Non-SPPD)";
						else if ($col['dl_non_sppd2'][$k] == 1) $title = "Dinas Luar (Non-SPPD)";
						else if ($col['dl_sppd'][$k] == 1) $title = "Dinas Luar (SPPD)";
						else if ($col['cuti'][$k] == 1) $title = "Cuti";
						else if ($col['sakit'][$k] == 1) $title = "Sakit";
						else if ($col['sakit2'][$k] == 1) $title = "Sakit";
						else if ($col['izin'][$k] == 1) $title = "Izin";
						else if ($col['izin2'][$k] == 1) $title = "Izin";
						else if ($col['tanpa_keterangan'][$k] == 1) $title = "Tanpa Keterangan";
						else if ($col['dpk_dpb'][$k] == 1) $title = "Diperbantukan/Dipekerjakan";
						else if ($col['tugas_belajar'][$k] == 1) $title = "Tugas Belajar";
						else $title = "";*/
						
						$s_alasan = "SELECT * FROM alasan WHERE kode = '".$col['kode_alasan_masuk'][$k]."'";
						$q_alasan = mysql_query($s_alasan);
						$alasan = mysql_fetch_array($q_alasan);
						$title = $alasan['keterangan']; ?>
						
						<td align="center" title="<?php echo $title; ?>"><?php 
						
							/*if ($col['dl_ln'][$k] == 1) $alasan = "DL LN";
							else if ($col['dl_non_sppd'][$k] == 1) $alasan = "DL NON SPPD";
							else if ($col['dl_non_sppd2'][$k] == 1) $alasan = "DL NON SPPD";
							else if ($col['dl_sppd'][$k] == 1) $alasan = "DL SPPD";
							else if ($col['cuti'][$k] == 1) $alasan = "CUTI";
							else if ($col['sakit'][$k] == 1) $alasan = "SAKIT";
							else if ($col['sakit2'][$k] == 1) $alasan = "SAKIT";
							else if ($col['izin'][$k] == 1) $alasan = "IZIN";
							else if ($col['izin2'][$k] == 1) $alasan = "IZIN";
							else if ($col['tanpa_keterangan'][$k] == 1) $alasan = "TK";
							else if ($col['dpk_dpb'][$k] == 1) $alasan = "DPK/DPB";
							else if ($col['tugas_belajar'][$k] == 1) $alasan = "TB";
							else $alasan = "";*/
							
							echo $col['kode_alasan_masuk'][$k]; ?>
						
						</td><?php
						
						if ($col['TL2'][$k] == 1) $title = "Terlambat 91 s/d 120 menit";
						else if ($col['TL3'][$k] == 1) $title = "Terlambat lebih dari 120 menit";
						else if ($col['KS4'][$k] == 1) $title = "Keluar Sementara lebih dari 90 menit";
						else if ($col['CT'][$k] == 1) $title = "Cuti Tahunan";
						else if ($col['CB'][$k] == 1) $title = "Cuti Besar";
						else if ($col['CSRI'][$k] == 1) $title = "Cuti Sakit";
						else if ($col['CM'][$k] == 1) $title = "Cuti Melahirkan Anak 1 dan 2";
						else if ($col['CM3'][$k] == 1) $title = "Cuti Melahirkan Anak 3";
						else if ($col['CP'][$k] == 1) $title = "Cuti Penting";
						else if ($col['CLTN'][$k] == 1) $title = "Cuti di Luar Tanggungan Negara";
						else if ($col['DK'][$k] == 1) $title = "Dengan Keterangan";
						else if ($col['TK'][$k] == 1) $title = "Tanpa Keterangan";
						else if ($col['TBmin'][$k] == 1) $title = "Tugas Belajar";
						else $title = ""; ?>
							
						<td align="center" title="<?php echo $title; ?>"><?php
							
							if ($col['TL2'][$k] == 1) $potongan = "TL2";
							else if ($col['TL3'][$k] == 1) $potongan = "TL3";
							else if ($col['CT'][$k] == 1) $potongan = "CT";
							else if ($col['CB'][$k] == 1) $potongan = "CB";
							else if ($col['CSRI'][$k] == 1) $potongan = "CS";
							else if ($col['CM'][$k] == 1) $potongan = "CM";
							else if ($col['CM3'][$k] == 1) $potongan = "CM3";
							else if ($col['CP'][$k] == 1) $potongan = "CP";
							else if ($col['CLTN'][$k] == 1) $potongan = "CLTN";
							else if ($col['DK'][$k] == 1) $potongan = "DK";
							else if ($col['TK'][$k] == 1) $potongan = "TK";
							else if ($col['TBmin'][$k] == 1) $potongan = "TB";
							else $potongan = "";
							
							echo $potongan; ?>
								
						</td>
						<td><?php echo strtoupper($col['keterangan_masuk'][$k]); ?></td><?php
						
						if ($Session['xlevel'] <= 4 and ($ver['status_verifikasi_potongan'] == "0" or $ver['status_verifikasi_potongan'] == ""))
						{ ?>
						
							<td align="center" nowrap="nowrap"><?php
								
								if ($col['status'][$k] != 0 or $col['kekurangan_masuk'][$k] != 0)
								{ ?>
									
									<a class="thickbox" href="<?php echo $ed[$k] ?>&x=<?php echo $x; ?>&z=<?php echo $z; ?>" title="Tambah Alasan">
										<img src="css/images/edit_f2.png" border="0" width="16" height="16">&nbsp;Alasan
									</a><?php
									
								}
								else echo "&nbsp;"; ?>
								
							</td><?php
						
						} ?>
						
					</tr><?php
                    
					if ($col['status'][$k] == 2)
					{
						$x = 1; ?>
					
                        <tr class="<?php echo $class[$k]; ?>" id="trk<?php echo $val; ?>">
                            <td align="center" nowrap="nowrap"><?php 
                                
                                $status = "PULANG";
                                
                                echo $status; ?>
                            
                            </td>
                            <td align="center"><?php 
                                
                                $jam_keluar = substr($col['jam_keluar'][$k],0,5);
                                
                                echo $jam_keluar; ?>
                            
                            </td>
                            <td align="right"><?php 
                                
                                if ($col['kekurangan_keluar'][$k] > 0) 
                                { ?>
                                
                                    <font color="#f00"><?php echo $col['kekurangan_keluar'][$k] ?></font><?php
                                    
                                }
                                else echo $col['kekurangan_keluar'][$k]; ?>
                                
                            </td><?php
                            
                            /*if ($col['dl_ln'][$k] == 1) $title = "Dinas Luar (Luar Negeri)";
                            else if ($col['dl_non_sppd'][$k] == 1) $title = "Dinas Luar (Non-SPPD)";
                            else if ($col['dl_non_sppd2'][$k] == 1) $title = "Dinas Luar (Non-SPPD)";
                            else if ($col['dl_sppd'][$k] == 1) $title = "Dinas Luar (SPPD)";
                            else if ($col['cuti'][$k] == 1) $title = "Cuti";
                            else if ($col['sakit'][$k] == 1) $title = "Sakit";
                            else if ($col['sakit2'][$k] == 1) $title = "Sakit";
                            else if ($col['izin'][$k] == 1) $title = "Izin";
                            else if ($col['izin2'][$k] == 1) $title = "Izin";
                            else if ($col['tanpa_keterangan'][$k] == 1) $title = "Tanpa Keterangan";
                            else if ($col['dpk_dpb'][$k] == 1) $title = "Diperbantukan/Dipekerjakan";
                            else if ($col['tugas_belajar'][$k] == 1) $title = "Tugas Belajar";
                            else $title = "";*/
							
							$s_alasan = "SELECT * FROM alasan WHERE kode = '".$col['kode_alasan_keluar'][$k]."'";
							$q_alasan = mysql_query($s_alasan);
							$alasan = mysql_fetch_array($q_alasan);
							$title = $alasan['keterangan']; ?>
                            
                            <td align="center" title="<?php echo $title; ?>"><?php 
                            
                                /*if ($col['dl_ln'][$k] == 1) $alasan = "DL LN";
                                else if ($col['dl_non_sppd'][$k] == 1) $alasan = "DL NON SPPD";
                                else if ($col['dl_non_sppd2'][$k] == 1) $alasan = "DL NON SPPD";
                                else if ($col['dl_sppd'][$k] == 1) $alasan = "DL SPPD";
                                else if ($col['cuti'][$k] == 1) $alasan = "CUTI";
                                else if ($col['sakit'][$k] == 1) $alasan = "SAKIT";
                                else if ($col['sakit2'][$k] == 1) $alasan = "SAKIT";
                                else if ($col['izin'][$k] == 1) $alasan = "IZIN";
                                else if ($col['izin2'][$k] == 1) $alasan = "IZIN";
                                else if ($col['tanpa_keterangan'][$k] == 1) $alasan = "TK";
                                else if ($col['dpk_dpb'][$k] == 1) $alasan = "DPK/DPB";
                                else if ($col['tugas_belajar'][$k] == 1) $alasan = "TB";
                                else $alasan = "";*/
                                
                                echo $col['kode_alasan_keluar'][$k]; ?>
                            
                            </td><?php
                            
							if ($col['PSW1'][$k] == 1) $title = "Pulang Sebelum Waktu 1 s/d 30 menit";
							else if ($col['PSW2'][$k] == 1) $title = "Pulang Sebelum Waktu 31 s/d 60 menit";
							else if ($col['PSW3'][$k] == 1) $title = "Pulang Sebelum Waktu 61 s/d 90 menit";
							else if ($col['PSW4'][$k] == 1) $title = "Pulang Sebelum Waktu lebih dari 90 menit";
							else if ($col['CT'][$k] == 1) $title = "Cuti Tahunan";
							else if ($col['CB'][$k] == 1) $title = "Cuti Besar";
							else if ($col['CSRI'][$k] == 1) $title = "Cuti Sakit Rawat Inap";
							else if ($col['CSRJ'][$k] == 1) $title = "Cuti Sakit Rawat Jalan";
							else if ($col['CM'][$k] == 1) $title = "Cuti Melahirkan Anak 1 dan 2";
							else if ($col['CM3'][$k] == 1) $title = "Cuti Melahirkan Anak 3";
							else if ($col['CP'][$k] == 1) $title = "Cuti Penting";
							else if ($col['CLTN'][$k] == 1) $title = "Cuti di Luar Tanggungan Negara";
							else if ($col['DK'][$k] == 1) $title = "Dengan Keterangan";
							else if ($col['TK'][$k] == 1) $title = "Tanpa Keterangan";
							else if ($col['TBmin'][$k] == 1) $title = "Tugas Belajar kurang dari 3 Bulan";
							else if ($col['TBplus'][$k] == 1) $title = "Tugas Belajar 3 Bulan atau Lebih";
							else if ($col['UP'][$k] == 1) $title = "Tidak Mengikuti Upacara Bendera";
							else $title = ""; ?>
                                
                            <td align="center" title="<?php echo $title; ?>"><?php
                                
                                if ($col['PSW1'][$k] == 1) $potongan = "PSW1";
								else if ($col['PSW2'][$k] == 1) $potongan = "PSW2";
								else if ($col['PSW3'][$k] == 1) $potongan = "PSW3";
								else if ($col['PSW4'][$k] == 1) $potongan = "PSW4";
								else if ($col['CT'][$k] == 1) $potongan = "CT";
								else if ($col['CB'][$k] == 1) $potongan = "CB";
								else if ($col['CSRI'][$k] == 1) $potongan = "CSRI";
								else if ($col['CSRJ'][$k] == 1) $potongan = "CSRJ";
								else if ($col['CM'][$k] == 1) $potongan = "CM";
								else if ($col['CM3'][$k] == 1) $potongan = "CM3";
								else if ($col['CP'][$k] == 1) $potongan = "CP";
								else if ($col['CLTN'][$k] == 1) $potongan = "CLTN";
								else if ($col['DK'][$k] == 1) $potongan = "DGN KET";
								else if ($col['TK'][$k] == 1) $potongan = "TK";
								else if ($col['TBmin'][$k] == 1) $potongan = "TB < 3 BLN";
								else if ($col['TBplus'][$k] == 1) $potongan = "TB >= 3 BLN";
								else if ($col['UP'][$k] == 1) $potongan = "UP";
								else $potongan = "";
								
								echo $potongan; ?>
                                    
                            </td>
                            <td><?php echo strtoupper($col['keterangan_keluar'][$k]); ?></td><?php
                            
                            if ($Session['xlevel'] <= 4 and ($ver['status_verifikasi_potongan'] == "0" or $ver['status_verifikasi_potongan'] == ""))
                            { ?>
                            
                                <td align="center" nowrap="nowrap"><?php
                                    
                                    if ($col['status'][$k] != 0 or $col['kekurangan_masuk'][$k] != 0)
									{ ?>
										
										<a class="thickbox" href="<?php echo $ed[$k] ?>&x=<?php echo $x; ?>&z=<?php echo $z; ?>" title="Tambah Alasan">
											<img src="css/images/edit_f2.png" border="0" width="16" height="16">&nbsp;Alasan
										</a><?php
										
									}
									else echo "&nbsp;"; ?>
                                    
                                </td><?php
                            
                            } ?>
                        
                        </tr><?php
						
					}
					
					#$tanggal = $col['tanggal'][$k];
				}
						
				#$bulan = $y."-".$m;
				
				#$oRekapitulasi = rekapitulasi_pegawai($q,$bulan,$u);
				#$Rekapitulasi = mysql_fetch_array($oRekapitulasi);
				
				$s_rekapitulasi = "SELECT * FROM rekapitulasi WHERE nip = '".$nip."' AND bulan = '".$bulan."'";
				$q_rekapitulasi = mysql_query($s_rekapitulasi);
				$rekapitulasi = mysql_fetch_array($q_rekapitulasi);
				
				$hari_kerja = get_jumlah_hari_kerja($m,$y);
				
				$Ket = "Hari Kerja: <font color=\"#f00\">".$hari_kerja."</font><BR>";
				$Ket .= "Hadir: <font color=\"#f00\">".$rekapitulasi['hadir']."</font> &nbsp;[&nbsp;";
				
				#if ($rekapitulasi['TL'] != 0) $Ket .= "TL: <font color=\"#f00\">".$rekapitulasi['TL']."</font>  &nbsp;";
				#if ($rekapitulasi['KS'] != 0) $Ket .= "KS: <font color=\"#f00\">".$rekapitulasi['KS']."</font>  &nbsp;";
				#if ($rekapitulasi['PSW'] != 0) $Ket .= "PSW: <font color=\"#f00\">".$rekapitulasi['PSW']."</font>  &nbsp;";
				
				
				#if ($rekapitulasi['TL1'] != 0) $Ket .= "TL1: ".$rekapitulasi['TL1']."  &nbsp;";
				if ($rekapitulasi['TL2'] != 0) $Ket .= "TL2: ".$rekapitulasi['TL2']."  &nbsp;";
				if ($rekapitulasi['TL3'] != 0) $Ket .= "TL3: ".$rekapitulasi['TL3']."  &nbsp;";
				#if ($rekapitulasi['TL4'] != 0) $Ket .= "TL4: ".$rekapitulasi['TL4']."  &nbsp;";
				#if ($rekapitulasi['KS1'] != 0) $Ket .= "KS1: ".$rekapitulasi['KS1']."  &nbsp;";
				#if ($rekapitulasi['KS2'] != 0) $Ket .= "KS2: ".$rekapitulasi['KS2']."  &nbsp;";
				#if ($rekapitulasi['KS3'] != 0) $Ket .= "KS3: ".$rekapitulasi['KS3']."  &nbsp;";
				#if ($rekapitulasi['KS4'] != 0) $Ket .= "KS4: ".$rekapitulasi['KS4']."  &nbsp;";
				if ($rekapitulasi['PSW1'] != 0) $Ket .= "PSW1: ".$rekapitulasi['PSW1']."  &nbsp;";
				if ($rekapitulasi['PSW2'] != 0) $Ket .= "PSW2: ".$rekapitulasi['PSW2']."  &nbsp;";
				if ($rekapitulasi['PSW3'] != 0) $Ket .= "PSW3: ".$rekapitulasi['PSW3']."  &nbsp;";
				if ($rekapitulasi['PSW4'] != 0) $Ket .= "PSW4: ".$rekapitulasi['PSW4']."  &nbsp;";
				
				
				$Ket .= "]<BR>";
				#$Ket .= "Tidak Hadir: <font color=\"#f00\">".($hari_kerja - $rekapitulasi['hadir'])."</font> &nbsp;[&nbsp;";
				$Ket .= "Tidak Hadir: <font color=\"#f00\">".($rekapitulasi['tidak_hadir'])."</font> &nbsp;[&nbsp;";
				
				if ($rekapitulasi['dl_ln'] != 0) $Ket .= "DL LN: <font color=\"#f00\">".$rekapitulasi['dl_ln']."</font>  &nbsp;";
				if ($rekapitulasi['dl_non_sppd'] != 0) $Ket .= "DL NON SPPD: <font color=\"#f00\">".$rekapitulasi['dl_non_sppd']."</font>  &nbsp;";
				if ($rekapitulasi['dl_sppd'] != 0) $Ket .= "DL SPPD: <font color=\"#f00\">".$rekapitulasi['dl_sppd']."</font  &nbsp;";
				#if ($rekapitulasi['izin'] != 0) $Ket .= "Izin: ".$rekapitulasi['izin']."  &nbsp;";
				#if ($rekapitulasi['tanpa_keterangan'] != 0) $Ket .= "TK: ".$rekapitulasi['tanpa_keterangan']."  &nbsp;";
				if ($rekapitulasi['dpk_dpb'] != 0) $Ket .= "DPK/DPB: <font color=\"#f00\">".$rekapitulasi['dpk_dpb']."</font>  &nbsp;";
				if ($rekapitulasi['tugas_belajar'] != 0) $Ket .= "TB: <font color=\"#f00\">".$rekapitulasi['tugas_belajar']."</font>  &nbsp;";
				if ($rekapitulasi['CT'] != 0) $Ket .= "CT: <font color=\"#f00\">".$rekapitulasi['CT']."</font>  &nbsp;";
				if ($rekapitulasi['CB'] != 0) $Ket .= "CB: <font color=\"#f00\">".$rekapitulasi['CB']."</font>  &nbsp;";
				if ($rekapitulasi['CSRI'] != 0) $Ket .= "CSRI: <font color=\"#f00\">".$rekapitulasi['CSRI']."</font>  &nbsp;";
				if ($rekapitulasi['CSRJ'] != 0) $Ket .= "CSRJ: <font color=\"#f00\">".$rekapitulasi['CSRJ']."</font>  &nbsp;";
				if ($rekapitulasi['CM'] != 0) $Ket .= "CM: <font color=\"#f00\">".$rekapitulasi['CM']."</font>  &nbsp;";
				if ($rekapitulasi['CM3'] != 0) $Ket .= "CM3: <font color=\"#f00\">".$rekapitulasi['CM3']."</font>  &nbsp;";
				if ($rekapitulasi['CP'] != 0) $Ket .= "CP: <font color=\"#f00\">".$rekapitulasi['CP']."</font>  &nbsp;";
				if ($rekapitulasi['CLTN'] != 0) $Ket .= "CLTN: <font color=\"#f00\">".$rekapitulasi['CLTN']."</font>  &nbsp;";
				if ($rekapitulasi['DK'] != 0) $Ket .= "DGN KET: <font color=\"#f00\">".$rekapitulasi['DK']."</font>  &nbsp;";
				if ($rekapitulasi['TK'] != 0) $Ket .= "TK: <font color=\"#f00\">".$rekapitulasi['TK']."</font>  &nbsp;";
				if ($rekapitulasi['UP'] != 0) $Ket .= "UP: <font color=\"#f00\">".$rekapitulasi['UP']."</font>  &nbsp;";
				
				$Ket .= "]<BR>";
				
				$rekapitulasi_total = rekapitulasi_total($q,$bulan);
				$Ket.= "Akumulasi Kekurangan: <font color=\"#f00\">".$rekapitulasi_total."</font><BR>";
				
				$sanksi = get_sanksi($rekapitulasi_total);
				if ($sanksi != "") $Ket .= "Sanksi: <font color=\"#f00\">".$sanksi."</font><BR>"; ?>
				
				<tr class="row0">
					<td colspan="5" align="center"><b>T O T A L</b></td>
					<td align="right"><font color="#f00"><b><?php 
						
						echo $rekapitulasi['kekurangan_masuk'] + $rekapitulasi['kekurangan_keluar']; ?></b></font>
                    
                    </td>
					<td colspan="5"><b><?php echo $Ket; ?></b></td>
				</tr><?php
				
			} ?>
			
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10">&nbsp;</td>
			</tr>
		</tfoot>
	</table>