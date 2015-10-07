<?php
	#@
	/*
		File 			: /source/presensi/import.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 10 Nov 2014
		Selesai Tanggal : 14 Nov 2014
		Fungsi 			: Mengupload data presensi dalam format .xlsx atau .xls ke dalam database
		
		Revisi / Modifikasi :
		25 Nov 2014		: Data yang diupload diubah dari .csv menjadi .xls
		26 Nov 2014		: Menambahkan update untuk table potongan
	*/
	
	require('lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
	require('lib/spreadsheet-reader-master/SpreadsheetReader.php');
	
	checkauthentication();
	set_time_limit(6000);
	#error_reporting('E_NONE');
	
	$err = false;
	$p = $_GET['p'];
	$date_from = @$_POST['date_from'];
	$date_until = @$_POST['date_until'];
	$unit_kerja = $_SESSION['xkdunit'];
	$Session['xusername'] = $_SESSION['xusername'];
	
	if (@$_POST['xImport']) 
	{	
		if ($_FILES["file"]["error"] > 0) 
		{
			$_SESSION['errmsg'] = "Upload data gagal! ".$_FILES["file"]["error"];
			$err = true;
		}
		
		if ($err != true) 
		{
			$date = date ("Ymd_His");
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); #echo $ext."<BR>";
			$filename = $unit_kerja."_".$date.".".$ext;
			$filedir = "data_presensi/".$filename;
			
			if ($ext == "xls")
			{
				$ex = move_uploaded_file($_FILES["file"]["tmp_name"],$filedir);
				$myfile = fopen("data_presensi/".$unit_kerja."_".$date.".txt", "w");
				$log_txt = "";
			}
			else
			{
				update_log("Upload data gagal! File harus dalam format Excel (.xls)","import",0);
				
				$_SESSION['errmsg'] = "Upload data gagal! File harus dalam format Excel (.xls)"; ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p; ?>"><?php
			}
			
			$fr = new SpreadsheetReader($filedir);
			
			if (!$fr)
			{
				update_log("Upload data gagal! File tidak bisa di buka","import",0);
				
				$_SESSION['errmsg'] = "Upload data gagal! File tidak bisa di buka"; ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p; ?>"><?php
				
			}
			else 
			{
				$c = 1;
				$date_from_text = "9999-99-99";
				$date_until_text = "0000-00-00";
				
				$Sheets = $fr->Sheets();
				
				foreach ($Sheets as $Index=>$Name)
				{
					$fr->ChangeSheet($Index);
					
					foreach ($fr as $Key=>$Row)
					{	
						$exec = false;
						$tanggal = "";
						$batas_masuk = "";
						$batas_keluar = "";
						$jam_masuk = "";
						$jam_keluar = "";
						$status = "";
						$kekurangan_masuk = "";
						$kekurangan_keluar = "";
						$kode_alasan_masuk = "";
						$kode_alasan_keluar = "";
						$keterangan_masuk = "";
						$keterangan_keluar = "";
						$hadir = "";
						$tidak_hadir = "";
						$dl_ln = "";
						$dl_non_sppd = "";
						$dl_non_sppd2 = "";
						$dl_sppd = "";
						$cuti = "";
						$sakit = "";
						$sakit2 = "";
						$izin = "";
						$izin2 = "";
						$tanpa_keterangan = "";
						$dpk_dpb = "";
						$tugas_belajar = "";
						$TL[1] = "";
						$TL[2] = "";
						$TL[3] = "";
						$PSW[0] = "";
						$PSW[1] = "";
						$PSW[2] = "";
						$PSW[3] = "";
						$PSW[4] = "";
						$CT = "";
						$CB = "";
						$CSRI = "";
						$CSRJ = "";
						$CM = "";
						$CM3 = "";
						$CP = "";
						$CLTN = "";
						$DK = "";
						$TK = "";
						$TBmin = "";
						$TBplus = "";
						$UP = "";
						$jam_kerja = "";
						$src = "";
						$cek = "";
						
						switch ($unit_kerja)
						{	
							default:
							
								if ($Key != 1)
								{
									$log_txt .= $Key." | ".$Row[0]." | ".$Row[1]." | ".$Row[2]." | ".$Row[3]." | ".$Row[4]." | ".$Row[6]."\n";
									
									$nip = $Row[0];
									$tgl = $Row[2];
									$tgl = explode("-", $tgl);
									$y = $tgl[2];
									$m = $tgl[1];
									$d = $tgl[0];
									
									#if ($m <= 9) $m = '0'.$m;
									#if ($d <= 9) $d = '0'.$d;
									
									$tanggal = $y."-".$m."-".$d;
									
									$sql = "SELECT * FROM jadwal_kerja WHERE kode = 'N'";
									$o_jadwal = mysql_query($sql);
									$jadwal = mysql_fetch_array($o_jadwal);
									
									$hari = strtolower(nama_hari($tanggal));
									
									$sql = "SELECT * FROM jam_kerja WHERE kode = '".$jadwal[$hari]."'";
									$o_jam = mysql_query($sql);
									$jam = mysql_fetch_array($o_jam);
									
									$batas_masuk = $jam['jam_masuk'];
									$batas_keluar = $jam['jam_keluar'];
									
									#echo $hari."<BR>";
									
									if ($hari == 'sabtu')
									{
										$status = 0;
										$keterangan = 'Sabtu';
									}
									else if ($hari == 'minggu')
									{
										$status = 0;
										$keterangan = 'Minggu';
									}
									else if ($Row[6] == "Libur Nasional")
									{
										$sql = "SELECT * FROM libur WHERE tanggal = '".$tanggal."'";
										$o_libur = mysql_query($sql);
										$n_libur = mysql_num_rows($o_libur);
										
										if ($n_libur != 0)
										{
											$libur = mysql_fetch_array($o_libur);
											
											if ($libur['status'] == 'C')
											{
												$status = 3;
												$keterangan = $libur['keterangan'];
											}
											else if ($libur['status'] == 'L')
											{
												$status = 0;
												$keterangan = $libur['keterangan'];
											}
										}
									}
									else
									{
										$jam_masuk = $Row[3];
										$jam_keluar = $Row[4];
										
										if ($jam_masuk == "" and $jam_keluar == "") $status = 1;
										else $status = 2;
									}
								}
								
							break;
						}
							
						if ($tanggal >= $date_from and $tanggal <= $date_until)
						{
							$sql = "SELECT * FROM presensi WHERE nip = '".$nip."' AND tanggal = '".$tanggal."'"; 
							
							$log_txt .= $sql."\n";
							
							$qry = mysql_query($sql);
							$nro = mysql_num_rows($qry);
							
							if ($nro == 0)
							{
								$sql2 = "SELECT * FROM rekapitulasi WHERE nip = '".$nip."' AND bulan = '".$y."-".$m."'"; 
								
								$log_txt .= $sql2."\n";
								
								$qry2 = mysql_query($sql2);
								$nro2 = mysql_num_rows($qry2);
								
								if ($nro2 == 0)
								{
									$sql3 = "INSERT INTO rekapitulasi (nip, kdunit, bulan) VALUES ('".$nip."', '".$unit_kerja."', '".$y."-".$m."')"; 
									
									$log_txt .= $sql3."\n";
									
									$qry3 = mysql_query($sql3);
								}
								
								$sql9 = "SELECT * FROM potongan WHERE nip = '".$nip."' AND bulan = '".$y."-".$m."'"; 
								
								$log_txt .= $sql2."\n";
								
								$qry9 = mysql_query($sql9);
								$nro9 = mysql_num_rows($qry9);
								
								if ($nro9 == 0)
								{
									$sql10 = "INSERT INTO potongan (nip, kdunit, bulan) VALUES ('".$nip."', '".$unit_kerja."', '".$y."-".$m."')"; 
									
									$log_txt .= $sq10."\n";
									
									$qry10 = mysql_query($sql10);
								}
								
								#echo $status."<BR>";
								
								if ($status == 2)
								{
									if ($jam_masuk == "") $jam_masuk = "00:00:00";
									if ($jam_keluar == "") $jam_keluar = "00:00:00";
									
									$kekurangan_masuk = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "masuk");
									$kekurangan_keluar = get_kekurangan($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "keluar");
									
									$TL = cek_TL($kekurangan_masuk);
									$PSW = cek_PSW($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar);
								
									$sql4 = "INSERT INTO presensi (nip, kdunit, tanggal, batas_masuk, batas_keluar, jam_masuk, jam_keluar, `status`, 
									kekurangan_masuk, kekurangan_keluar, hadir, TL, TL2, TL3, PSW, PSW1, PSW2, PSW3, PSW4, jam_kerja, src, cek)
									VALUES ('".$nip."', '".$unit_kerja."', '".$tanggal."', '".$batas_masuk."', '".$batas_keluar."', '".$jam_masuk."', 
									'".$jam_keluar."', '".$status."', '".$kekurangan_masuk."', '".$kekurangan_keluar."', '1', '".$TL[0]."', '".$TL[2]."', 
									'".$TL[3]."', '".$PSW[0]."', '".$PSW[1]."', '".$PSW[2]."', '".$PSW[3]."', '".$PSW[4]."', 'N', '".$filename."', '1');";
									
									$exec = mysql_query($sql4); 
									
									$log_txt .= $sql4."\n";
								}
								else if ($status == 1)
								{
									$sql5 = "INSERT INTO presensi (nip, kdunit, tanggal, batas_masuk, batas_keluar, `status`, kekurangan_masuk, tidak_hadir, 
									tanpa_keterangan, TK, jam_kerja, src, cek)
									VALUES ('".$nip."', '".$unit_kerja."', '".$tanggal."', '".$batas_masuk."', '".$batas_keluar."', '".$status."', '450', 
									'1', '1', '1', 'N', '".$filename."', '2');";
									
									$exec = mysql_query($sql5); 
									
									$log_txt .= $sql5."\n";
								}
								else if ($status == 3)
								{
									$sql6 = "INSERT INTO presensi (nip, kdunit, tanggal, `status`, keterangan_masuk, tidak_hadir, cuti, CT, jam_kerja, src, 
									cek)
									VALUES ('".$nip."', '".$unit_kerja."', '".$tanggal."', '".$status."', '".$keterangan."', '1', '1', '1', 'N', 
									'".$filename."', '3');";
									
									$exec = mysql_query($sql6); 
									
									$log_txt .= $sql6."\n";
								}
								else if ($status == 0)
								{
									$sql7 = "INSERT INTO presensi (nip, kdunit, tanggal, `status`, keterangan_masuk, jam_kerja, src, cek)
									VALUES ('".$nip."', '".$unit_kerja."', '".$tanggal."', '".$status."', '".$keterangan."', 'N', '".$filename."', '4');";
									
									$exec = mysql_query($sql7); 
									
									$log_txt .= $sql7."\n";
								}
							}
							else if ($nro == 1)
							{
								$fet = mysql_fetch_array($qry);
								
								if ($fet['status'] == 1)
								{
									if ($status == 2)
									{
										if ($jam_masuk == "") $jam_masuk = "00:00:00";
										if ($jam_keluar == "") $jam_keluar = "00:00:00";
										
										$kekurangan_masuk = get_kekurangan($nip, $batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "masuk");
										$kekurangan_keluar = get_kekurangan($nip, $batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar, "keluar");
										
										$TL = cek_TL($kekurangan_masuk);
										$PSW = cek_PSW($batas_masuk, $batas_keluar, $jam_masuk, $jam_keluar);
									
										$sql8 = "UPDATE presensi SET nip = '".$nip."', tanggal = '".$tanggal."', batas_masuk = '".$batas_masuk."', 
										batas_keluar = '".$batas_keluar."', jam_masuk = '".$jam_masuk."', jam_keluar = '".$jam_keluar."', 
										`status` = '".$status."', kekurangan_masuk = '".$kekurangan_masuk."', kekurangan_keluar = '".$kekurangan_keluar."', 
										hadir = '1', tidak_hadir = '0', dl_ln = '0', dl_non_sppd = '0', dl_non_sppd2 = '0', dl_sppd = '0', cuti = '0', 
										sakit = '0', sakit2 = '0', izin = '0', izin2 = '0', tanpa_keterangan = '0', dpk_dpb = '0', tugas_belajar = '0', 
										TL = '".$TL[0]."', TL2 = '".$TL[2]."', TL3 = '".$TL[3]."', PSW = '".$PSW[0]."', PSW1 = '".$PSW[1]."', 
										PSW2 = '".$PSW[2]."', PSW3 = '".$PSW[3]."', PSW4 = '".$PSW[4]."', CT = '0', CB = '0', CSRI = '0', CSRJ = '0', 
										CM = '0', CM3 = '0', CP = '0', CLTN = '0', DK = '0', TK = '0', TBmin = '0', TBplus = '0', UP = '0', 
										src = '".$filename."', cek = '5')";
										
										$exec = mysql_query($sql8); 
										
										$log_txt .= $sql8."\n";
									}
									else $exec = true;
								}
								else $exec = true;
							}
							else $exec = true;
							
							if (!$exec) 
							{
								update_log("Upload data gagal! Error pada baris ke-".$c,"import",0);
								$_SESSION['errmsg'] = "Upload data gagal! Error pada baris ke-".$c; ?>
								
								<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p; ?>"><?php
								
								exit;
							}
						}
						
						if ($tanggal < $date_from_text) $date_from_text = $tanggal;
						if ($tanggal > $date_until_text) $date_until_text = $tanggal;
						
						$c++;
					}
				}
				
				if ($exec) 
				{
					$_SESSION['errmsg'] = "Upload data berhasil!";
					
					if ($date_from_text > $date_from) $date_from = $date_from_text;
					if ($date_until_text < $date_until) $date_until = $date_until_text;
						
					$sql = "
						INSERT INTO import (date_from, date_until, file, importby) 
						VALUES ('".$date_from."', '".$date_until."', '".$filename."', '".$Session['xusername']."')
					"; 
					
					$log_txt .= $sql."\n";
					
					mysql_query($sql);
					update_log("Upload data berhasil!","import",1);
				}
			}
						
			fwrite($myfile, $log_txt);
		} ?>
			
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p; ?>"><?php
	
	} ?>

	<form action="index.php?p=<?php echo $_GET['p']; ?>" method="post" name="xImport" enctype="multipart/form-data">
		<table class="admintable" cellspacing="1">
        	<tr>
				<td class="key">&nbsp;</td>
				<td><font color="red">*Upload data MAKSIMUM dalam 1 bulan</font></td>
            </tr>
			<tr>
				<td class="key">Tanggal</td>
				<td>
					<input name="date_from" type="text" class="form" id="date_from" size="10" value=""/>&nbsp;
					<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
					<script type="text/javascript">
						Calendar.setup({
							inputField : "date_from",
							button : "a_triggerIMG",
							align : "BR",
							firstDay : 1,
							weekNumbers : false,
							singleClick : true,
							showOthers : true,
							ifFormat : "%Y-%m-%d"
						});
					</script>
					
					&nbsp; s.d &nbsp;
					
					<input name="date_until" type="text" class="form" id="date_until" size="10" value=""/>&nbsp;
					<img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
					<script type="text/javascript">
						Calendar.setup({
							inputField : "date_until",
							button : "b_triggerIMG",
							align : "BR",
							firstDay : 1,
							weekNumbers : false,
							singleClick : true,
							showOthers : true,
							ifFormat : "%Y-%m-%d"
						});
					</script>
				</td>
			</tr>
			<tr>
				<td class="key">File</td>
				<td><input type="file" name="file" size="40" value="" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<div class="button2-right">
						<div class="prev">
							<a onclick="Cancel('index.php?p=1')">Batal</a>
						</div>
					</div>
					<div class="button2-left">
						<div class="next">
							<a onclick="Btn_Submit('xImport');">Proses</a>
						</div>
					</div>
					<div class="clr"></div>
					<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Proses" type="submit">
					<input name="xImport" type="hidden" value="1" />
					<input name="q" type="hidden" value="<?php echo @$_GET['q']; ?>" />
				</td>
			</tr>
		</table>
	</form>