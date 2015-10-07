<?php
	#@
	/*
		File 			: /source/presensi/presensi_print.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 30 Nov 2014
		Selesai Tanggal : 30 Nov 2014
		Fungsi 			: Cetak data presensi pegawai
		
		Revisi/Modifikasi :
		
	*/
	
	set_time_limit(600);
	include_once "../../includes/dbh.php";
	include_once "../../includes/presensi.php";
	include_once "../../includes/functions.php";
	
	$field = array('id', 'nip', 'tanggal', 'batas_masuk', 'batas_keluar', 'jam_masuk', 'jam_keluar', 'status', 'kekurangan_masuk', 'kekurangan_keluar', 
	'kode_alasan_masuk', 'kode_alasan_keluar', 'keterangan_masuk', 'keterangan_keluar', 'hadir', 'tidak_hadir', 'dl_ln', 'dl_non_sppd', 'dl_non_sppd2', 
	'dl_sppd', 'cuti', 'sakit', 'sakit2', 'izin', 'izin2', 'tanpa_keterangan', 'dpk_dpb', 'tugas_belajar', 'TL', 'TL1', 'TL2', 'TL3', 'TL4', 'KS', 'KS1', 
	'KS2', 'KS3', 'KS4', 'PSW', 'PSW1', 'PSW2', 'PSW3', 'PSW4', 'CT', 'CB', 'CSRI', 'CSRJ', 'CM', 'CM3', 'CP', 'CLTN', 'DK', 'TK', 'TBmin', 'TBplus', 'UP', 
	'jam_kerja', 'src', 'cek');
	
	extract($_POST);
	$q = @$_GET['q'];
	$m = @$_GET['m'];
	$y = @$_GET['y'];
	$t = @$_GET['t'];
	
	if (empty($m)) $m = @$_POST['m'];
	if (empty($y)) $y = @$_POST['y'];
			
	$jumlah_hari = jumlah_hari($m,$y);
		
	if (empty($n_data)) $ndata = 1;
	else $ndata = $n_data;
		
	if (empty($n_data)) 
	{
		$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$q."'";
		$q_pegawai = mysql_query($s_pegawai);
		$Pegawai = mysql_fetch_array($q_pegawai);
		
		$kode_unit = substr($Pegawai['kdunitkerja'], 0, 5);
	}
	else $kode_unit = substr($_POST['kode_unit'], 0, 5);
	
	$s_unit = "SELECT * FROM kd_unitkerja WHERE kdunit = '".$kode_unit."00'";
	$q_unit = mysql_query($s_unit);
	$unit = mysql_fetch_array($q_unit);
	
	$nama_unit = $unit->nmunit;
	
	$a_tgl = $y."-".$m."-01";
	$b_tgl = $y."-".$m."-".jumlah_hari($m + 0, $y);
	
	if (@$_POST["excel"] or @$_POST["calc"] or $t == "excel" or $t == "calc") 
	{	
		if (@$_POST["excel"] or $t == "excel") 
		{
			$ext = ".xls";
		}
		else if (@$_POST["calc"] or $t == "calc") 
		{
			$ext = ".ods";
		}
					
		header("Content-type: application/octet-stream");
		# replace excelfile.xls with whatever you want the filename <strong class="highlight">to</strong> default <strong class="highlight">to</strong>
		$filename = "presensi_".$y.$m.$ext;
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");
				
		for ($n = 1; $n <= $ndata; $n++) 
		{
			$var = "nip_".$n;
			
			if (empty($n_data)) $nip = $q;
			else $nip = $$var;
			
			$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$nip."' ORDER BY nama";
			$q_pegawai = mysql_query($s_pegawai);
			$Pegawai = mysql_fetch_array($q_pegawai); ?>
			
			<table cellspacing="0">      	
				<tr style="font: 12pt Arial, Helvetica, sans-serif">
					<td align="center" colspan="9"><strong>LAPORAN PRESENSI</strong></td>
				</tr>
				<tr style="font: 8pt Arial, Helvetica, sans-serif">
					<td align="center" colspan="9">
                    	<strong><?php echo dateformat($a_tgl, "d-M-Y") ?> s/d <?php echo dateformat($b_tgl, "d-M-Y") ?></strong>
                    </td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			
            <table style="font:8pt  Arial, Helvetica, sans-serif;">
				<tr>
					<td colspan="2">NIP</td>
					<td colspan="6">: <?php echo $Pegawai['nip']; ?></td>
				</tr>
				<tr>
					<td colspan="2">Nama</td>
					<td colspan="6">: <?php echo $Pegawai['nama']; ?></td>
				</tr>
				<tr>
					<td colspan="2">Unit Kerja</td>
					<td colspan="6">: <?php echo $nama_unit ?></td>
				</tr>
			</table>
			
            <table border="1" bordercolor="#000000" style="vertical-align:middle; font:8pt  Arial, Helvetica, sans-serif;">
				<tr align="center">
					<td><strong>No</strong></td>
					<td><strong>Tanggal</strong></td>
					<td><strong>Hari</strong></td>
					<td><strong>Status</strong></td>
					<td><strong>Jam</strong></td>
					<td><strong>Kekurangan (menit)</strong></td>
					<td><strong>Keterangan Alasan</strong></td>
					<td><strong>Tunjangan Kinerja</strong></td>
					<td><strong>Keterangan</strong></td>
				</tr><?php
				
				$total = 0;
				
				$s_presensi = "SELECT * FROM presensi WHERE nip = '".$nip."' AND tanggal LIKE '".$y."-".$m."%' ORDER BY tanggal";
				$q_presensi = mysql_query($s_presensi);
				$n_presensi = mysql_num_rows($q_presensi);
				
				if ($n_presensi == 0)
				{ ?>
                	
                    <tr align="center"><td colspan="9">Tidak Ada Data</td></tr><?php
				
				}
				else
				{
					$i = 1;
					$total = 0;
					
					while ($List = mysql_fetch_array($q_presensi))
					{
						if ($List['status'] == 2) $rowspan = 2;
						else $rowspan = 1; ?>
						
                        <tr>
                            <td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo $i++; ?></td>
                            <td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo dmy($List['tanggal']); ?></td>
                            <td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo strtoupper(nama_hari($List['tanggal'])); ?></td>
                            <td align="center" nowrap="nowrap"><?php 
							
								if ($List['status'] == 0) $status = "LIBUR";
								else if ($List['status'] == 1) $status = "TIDAK HADIR";
								else if ($List['status'] == 2) $status = "DATANG";
								else if ($List['status'] == 3) $status = "CUTI BERSAMA";
								else $status = "";
								
								echo $status; ?>
							
							</td>
							<td align="center"><?php 
								
								$jam_masuk = substr($List['jam_masuk'], 0, 5);
								
								echo $jam_masuk; ?>
							
							</td>
							<td align="right"><?php 
								
								if ($List['kekurangan_masuk'] > 0) 
								{ ?>
								
									<font color="#f00"><?php echo $List['kekurangan_masuk']; ?></font><?php
									
								}
								else echo $List['kekurangan_masuk'];
								
								$total += $List['kekurangan_masuk']; ?>
								
							</td><?php
							
							$s_alasan = "SELECT * FROM alasan WHERE kode = '".$List['kode_alasan_masuk']."'";
							$q_alasan = mysql_query($s_alasan);
							$alasan = mysql_fetch_array($q_alasan);
							$title = $alasan['keterangan']; ?>
							
							<td align="center" title="<?php echo $title; ?>"><?php 
								
								echo $List['kode_alasan_masuk']; ?>
							
							</td>
							<td align="center"><?php
								
								if ($List['TL2'] == 1) $potongan = "TL2";
								else if ($List['TL3'] == 1) $potongan = "TL3";
								else if ($List['CT'] == 1) $potongan = "CT";
								else if ($List['CB'] == 1) $potongan = "CB";
								else if ($List['CSRI'] == 1) $potongan = "CS";
								else if ($List['CM'] == 1) $potongan = "CM";
								else if ($List['CM3'] == 1) $potongan = "CM3";
								else if ($List['CP'] == 1) $potongan = "CP";
								else if ($List['CLTN'] == 1) $potongan = "CLTN";
								else if ($List['DK'] == 1) $potongan = "DK";
								else if ($List['TK'] == 1) $potongan = "TK";
								else if ($List['TBmin'] == 1) $potongan = "TB";
								else $potongan = "";
								
								echo $potongan; ?>
									
							</td>
							<td><?php echo strtoupper($List['keterangan_masuk']); ?></td>				
                        </tr><?php
						
						if ($List['status'] == 2)
						{ ?>
						
							<tr>
								<td align="center" nowrap="nowrap"><?php 
									
									$status = "PULANG";
									
									echo $status; ?>
								
								</td>
								<td align="center"><?php 
									
									$jam_keluar = substr($List['jam_keluar'], 0, 5);
									
									echo $jam_keluar; ?>
								
								</td>
								<td align="right"><?php 
									
									if ($List['kekurangan_keluar'] > 0) 
									{ ?>
									
										<font color="#f00"><?php echo $List['kekurangan_keluar']; ?></font><?php
										
									}
									else echo $List['kekurangan_keluar'];
									
									$total += $List['kekurangan_keluar']; ?>
									
								</td><?php
								
								$s_alasan = "SELECT * FROM alasan WHERE kode = '".$List['kode_alasan_keluar']."'";
								$q_alasan = mysql_query($s_alasan);
								$alasan = mysql_fetch_array($q_alasan);
								$title = $alasan['keterangan']; ?>
								
								<td align="center"><?php
									
									echo $List['kode_alasan_keluar']; ?>
								
								</td>
								<td align="center"><?php
									
									if ($List['PSW1'] == 1) $potongan = "PSW1";
									else if ($List['PSW2'] == 1) $potongan = "PSW2";
									else if ($List['PSW3'] == 1) $potongan = "PSW3";
									else if ($List['PSW4'] == 1) $potongan = "PSW4";
									else if ($List['CT'] == 1) $potongan = "CT";
									else if ($List['CB'] == 1) $potongan = "CB";
									else if ($List['CSRI'] == 1) $potongan = "CSRI";
									else if ($List['CSRJ'] == 1) $potongan = "CSRJ";
									else if ($List['CM'] == 1) $potongan = "CM";
									else if ($List['CM3'] == 1) $potongan = "CM3";
									else if ($List['CP'] == 1) $potongan = "CP";
									else if ($List['CLTN'] == 1) $potongan = "CLTN";
									else if ($List['DK'] == 1) $potongan = "DGN KET";
									else if ($List['TK'] == 1) $potongan = "TK";
									else if ($List['TBmin'] == 1) $potongan = "TB < 3 BLN";
									else if ($List['TBplus'] == 1) $potongan = "TB >= 3 BLN";
									else if ($List['UP'] == 1) $potongan = "UP";
									else $potongan = "";
									
									echo $potongan; ?>
										
								</td>
								<td><?php echo strtoupper($List['keterangan_keluar']); ?></td>
							</tr><?php
						
						}
					} ?>
					
					<tr>
						<td colspan="5" align="center">T O T A L</td>
						<td align="right"><?php echo $total; ?></td>
						<td>&nbsp;</td>
					</tr><?php
					
				} ?>
					
			</table><?php
			
		}
	}
	else if (@$_POST["excel2"] or @$_POST["calc2"] or $t == "excel2" or $t == "calc2") 
	{	
		if (@$_POST["excel2"] or $t == "excel2") 
		{
			$ext = ".xls";
		}
		else if (@$_POST["calc2"] or $t == "calc2") 
		{
			$ext = ".ods";
		}
					
		header("Content-type: application/octet-stream");
		# replace excelfile.xls with whatever you want the filename <strong class="highlight">to</strong> default <strong class="highlight">to</strong>
		$filename = "presensi_".$y.$m.$ext;
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");
				
		for ($n = 1; $n <= $ndata; $n++) 
		{
			$var = "nip_".$n;
			
			if (empty($n_data)) $nip = $q;
			else $nip = $$var;
			
			$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$nip."' ORDER BY nama";
			$q_pegawai = mysql_query($s_pegawai);
			$Pegawai = mysql_fetch_array($q_pegawai); ?>
			
			<table cellspacing="0">      	
				<tr style="font: 12pt Arial, Helvetica, sans-serif">
					<td align="center" colspan="8"><strong>LAPORAN PRESENSI</strong></td>
				</tr>
				<tr style="font: 8pt Arial, Helvetica, sans-serif">
					<td align="center" colspan="8">
                    	<strong><?php echo dateformat($a_tgl, "d-M-Y") ?> s/d <?php echo dateformat($b_tgl, "d-M-Y") ?></strong>
                    </td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			
            <table style="font:8pt  Arial, Helvetica, sans-serif;">
				<tr>
					<td colspan="2">NIP</td>
					<td colspan="6">: <?php echo $Pegawai['nip_baru']; ?></td>
				</tr>
				<tr>
					<td colspan="2">Nama</td>
					<td colspan="6">: <?php echo $Pegawai['nama']; ?></td>
				</tr>
				<tr>
					<td colspan="2">Unit Kerja</td>
					<td colspan="6">: <?php echo $nama_unit ?></td>
				</tr>
			</table>
			
            <table border="1" bordercolor="#000000" style="vertical-align:middle; font:8pt  Arial, Helvetica, sans-serif;">
				<tr align="center">
					<td><strong>No</strong></td>
					<td><strong>Tanggal</strong></td>
					<td><strong>Hari</strong></td>
					<td><strong>Status</strong></td>
					<td><strong>Jam</strong></td>
					<td><strong>Kekurangan (menit)</strong></td>
					<td><strong>Keterangan Alasan</strong></td>
					<td><strong>Tunjangan Kinerja</strong></td>
					<td><strong>Keterangan</strong></td>
				</tr><?php
				
				$total = 0;
				
				$s_presensi = "SELECT * FROM presensi WHERE nip = '".$nip."' AND tanggal LIKE '".$y."-".$m."%' ORDER BY tanggal";
				$q_presensi = mysql_query($s_presensi);
				$n_presensi = mysql_num_rows($q_presensi);
				
				if ($n_presensi == 0)
				{ ?>
                	
                    <tr align="center"><td colspan="9">Tidak Ada Data</td></tr><?php
				
				}
				else
				{
					$i = 1;
					$total = 0;
					
					while ($List = mysql_fetch_array($q_presensi))
					{
						if ($List['status'] == 2) $rowspan = 2;
						else $rowspan = 1; ?>
						
                        <tr>
                            <td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo $i++; ?></td>
                            <td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo dmy($List['tanggal']); ?></td>
                            <td align="center" rowspan="<?php echo $rowspan; ?>"><?php echo strtoupper(nama_hari($List['tanggal'])); ?></td>
                            <td align="center" nowrap="nowrap"><?php 
							
								if ($List['status'] == 0) $status = "LIBUR";
								else if ($List['status'] == 1) $status = "TIDAK HADIR";
								else if ($List['status'] == 2) $status = "DATANG";
								else if ($List['status'] == 3) $status = "CUTI BERSAMA";
								else $status = "";
								
								echo $status; ?>
							
							</td>
							<td align="center"><?php 
								
								$jam_masuk = substr($List['jam_masuk'], 0, 5);
								
								echo $jam_masuk; ?>
							
							</td>
							<td align="right"><?php 
								
								if ($List['kekurangan_masuk'] > 0) 
								{ ?>
								
									<font color="#f00"><?php echo $List['kekurangan_masuk']; ?></font><?php
									
								}
								else echo $List['kekurangan_masuk'];
								
								$total += $List['kekurangan_masuk']; ?>
								
							</td><?php
							
							$s_alasan = "SELECT * FROM alasan WHERE kode = '".$List['kode_alasan_masuk']."'";
							$q_alasan = mysql_query($s_alasan);
							$alasan = mysql_fetch_array($q_alasan);
							$title = $alasan['keterangan']; ?>
							
							<td align="center" title="<?php echo $title; ?>"><?php 
								
								echo $List['kode_alasan_masuk']; ?>
							
							</td>
							<td align="center"><?php
								
								if ($List['TL2'] == 1) $potongan = "TL2";
								else if ($List['TL3'] == 1) $potongan = "TL3";
								else if ($List['CT'] == 1) $potongan = "CT";
								else if ($List['CB'] == 1) $potongan = "CB";
								else if ($List['CSRI'] == 1) $potongan = "CS";
								else if ($List['CM'] == 1) $potongan = "CM";
								else if ($List['CM3'] == 1) $potongan = "CM3";
								else if ($List['CP'] == 1) $potongan = "CP";
								else if ($List['CLTN'] == 1) $potongan = "CLTN";
								else if ($List['DK'] == 1) $potongan = "DK";
								else if ($List['TK'] == 1) $potongan = "TK";
								else if ($List['TBmin'] == 1) $potongan = "TB";
								else $potongan = "";
								
								echo $potongan; ?>
									
							</td>
							<td><?php echo strtoupper($List['keterangan_masuk']); ?></td>				
                        </tr><?php
						
						if ($List['status'] == 2)
						{ ?>
						
							<tr>
								<td align="center" nowrap="nowrap"><?php 
									
									$status = "PULANG";
									
									echo $status; ?>
								
								</td>
								<td align="center"><?php 
									
									$jam_keluar = substr($List['jam_keluar'], 0, 5);
									
									echo $jam_keluar; ?>
								
								</td>
								<td align="right"><?php 
									
									if ($List['kekurangan_keluar'] > 0) 
									{ ?>
									
										<font color="#f00"><?php echo $List['kekurangan_keluar']; ?></font><?php
										
									}
									else echo $List['kekurangan_keluar'];
									
									$total += $List['kekurangan_keluar']; ?>
									
								</td><?php
								
								$s_alasan = "SELECT * FROM alasan WHERE kode = '".$List['kode_alasan_keluar']."'";
								$q_alasan = mysql_query($s_alasan);
								$alasan = mysql_fetch_array($q_alasan);
								$title = $alasan['keterangan']; ?>
								
								<td align="center"><?php
									
									echo $List['kode_alasan_keluar']; ?>
								
								</td>
								<td align="center"><?php
									
									if ($List['PSW1'] == 1) $potongan = "PSW1";
									else if ($List['PSW2'] == 1) $potongan = "PSW2";
									else if ($List['PSW3'] == 1) $potongan = "PSW3";
									else if ($List['PSW4'] == 1) $potongan = "PSW4";
									else if ($List['CT'] == 1) $potongan = "CT";
									else if ($List['CB'] == 1) $potongan = "CB";
									else if ($List['CSRI'] == 1) $potongan = "CSRI";
									else if ($List['CSRJ'] == 1) $potongan = "CSRJ";
									else if ($List['CM'] == 1) $potongan = "CM";
									else if ($List['CM3'] == 1) $potongan = "CM3";
									else if ($List['CP'] == 1) $potongan = "CP";
									else if ($List['CLTN'] == 1) $potongan = "CLTN";
									else if ($List['DK'] == 1) $potongan = "DGN KET";
									else if ($List['TK'] == 1) $potongan = "TK";
									else if ($List['TBmin'] == 1) $potongan = "TB < 3 BLN";
									else if ($List['TBplus'] == 1) $potongan = "TB >= 3 BLN";
									else if ($List['UP'] == 1) $potongan = "UP";
									else $potongan = "";
									
									echo $potongan; ?>
										
								</td>
								<td><?php echo strtoupper($List['keterangan_keluar']); ?></td>
							</tr><?php
						
						}
					} ?>
					
					<tr>
						<td colspan="6" align="center">T O T A L</td>
						<td align="right"><?php echo $total; ?></td>
						<td>&nbsp;</td>
					</tr><?php
					
				} ?>
					
			</table><?php
			
		}
	}
	/*
	else if (@$_POST["pdf"] or $t == "pdf") 
	{	
		require("../../lib/fpdf17/fpdf.php");
		
		class PDF extends FPDF 
		{
			function Header() 
			{	
				$q = @$_GET['q'];
				$m = @$_GET['m'];
				if (empty($m)) $m = @$_POST['m'];
				$y = @$_GET['y'];
				if (empty($y)) $y = @$_POST['y'];
				$t = @$_GET['t'];
				
				$kode_unit = @$_POST['kode_unit'];		
				if (empty($kode_unit)) $kode_unit = substr(pegawai_id($q)->kode_bidang,0,2);
				
				$nama_unit = unit_id($kode_unit)->nama;	
				
				if ($m < 10) $m = "0".($m+0);
				$a_tgl = $y."-".$m."-01";
				$b_tgl = $y."-".$m."-".jumlah_hari($m+0,$y);
				$this->Image("../../../css/images/logo_batan.jpg", $x=10, $z=10, $w=17, $h=17, "jpg");
				$this->SetFont($family = "Arial", "B", $size = 13);
				$this->SetXY($x2=$x+$w+3, $z+4);
				$this->Cell(0, $h2=5, "BADAN TENAGA NUKLIR NASIONAL", 0, 1, "", 0, "");
				$this->SetX($x2);
				$this->SetFont($family = "Arial", "B", $size = 10);
				$this->Cell(0,$h2, strtoupper($nama_unit), 0, 0, "", 0, "");
				
				$this->SetY($z+$h+$h2);
				$this->SetFont($family, "B", $size4=12);
				$this->Cell(0, $h4=6, "LAPORAN ABSENSI", 0, 1, "C", 0, "");
				$this->SetFont($family, "B", $size2 = 8);
				
				$a = dateformat($a_tgl, "d-M-Y");
				$b = dateformat($b_tgl, "d-M-Y");
				$txt = $a." s/d ".$b;
				$this->Cell(0, $h3=4, $txt, 0, 1, "C", 0, "");	
				$this->Ln($h4);
			}
		}
		
		$pdf = new PDF();
		
		for ($n=1; $n<=$ndata; $n++) 
		{
			$var = "nip_".$n;
			
			if (empty($n_data)) $nip = $q;
			else $nip = @$$var;
			
			if (!empty($nip)) 
			{					
				$oPegawai = pegawai("nip='".$nip."'","nama");
				$Pegawai = mysql_fetch_object($oPegawai);
				
				$pdf->AddPage();
				$pdf->SetLeftMargin($margin=10);
				$pdf->SetRightMargin($margin);
				$pdf->SetX($margin);
				$pdf->SetFont($family = "Arial", "", $size2=8);
				$w = array(20,5,130);
				$pdf->Cell($w[0], $h3=5, "NIP", 0, 0, "", 0, "");
				$pdf->Cell($w[1], $h3, ":", 0, 0, "", 0, "");
				$nip_baru = format_nip_baru($Pegawai->nip_baru);
				$pdf->Cell(0, $h3, $nip_baru, 0, 1, "", 0, "");
				$pdf->Cell($w[0], $h3, "Nama", 0, 0, "", 0, "");
				$pdf->Cell($w[1], $h3, ":", 0, 0, "", 0, "");
				$pdf->Cell(0, $h3, $Pegawai->nama, 0, 1, "", 0, "");
				$pdf->Cell($w[0], $h3, "Unit Kerja", 0, 0, "", 0, "");
				$pdf->Cell($w[1], $h3, ":", 0, 0, "", 0, "");
				$pdf->Cell(0, $h3, $nama_unit, 0, 1, "", 0, "");
				$pdf->Cell($w[0], $h3, "Jabatan", 0, 0, "", 0, "");
				$pdf->Cell($w[1], $h3, ":", 0, 0, "", 0, "");
				
				$jabatan = get_jabatan($nip);
				
				$pdf->Cell($w[0]+$w[1]+$w[2], $h3, $jabatan, 0, 0, "", 0, "");
				$txt = "Tanggal Cetak: ".date("d/m/Y");
				$pdf->Cell(0, $h3, $txt, 0, 1, "R", 0, "");
				
				$w2 = array(7,18,20,21,18,18,22,66); //jumlah 190	
				$z = $pdf->GetY();
				$pdf->SetFont($family, "B", $size2);
				$pdf->Cell($w2[0], $h3*2, "NO", 1, 0, "C", 0, "");
				$pdf->Cell($w2[1], $h3*2, "TANGGAL", 1, 0, "C", 0, "");
				$pdf->Cell($w2[2], $h3*2, "JAM MASUK", 1, 0, "C", 0, "");
				$pdf->Cell($w2[3], $h3*2, "JAM KELUAR", 1, 0, "C", 0, "");
				$pdf->Cell($w2[4]+$w2[5], $h3, "LEBIH/KURANG (MENIT)", 1, 1, "C", 0, "");
				$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]);
				$pdf->Cell($w2[4], $h3, "MASUK", 1, 0, "C", 0, "");
				$pdf->Cell($w2[5], $h3, "KELUAR", 1, 0, "C", 0, "");
				$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$z);
				$pdf->Cell($w2[6], $h3*2, "TOTAL MENIT", 1, 0, "C", 0, "");
				$pdf->Cell($w2[7], $h3*2, "KETERANGAN", 1, 1, "C", 0, "");
				
				$total = 0;
				
				for ($i=1; $i<=$jumlah_hari; $i++) 
				{
					if ($i < 10) $day = "0".$i;
					else $day = $i;
					
					$date = $y."-".$m."-".$day;
					
					$oList = presensi($kode_unit, "nip='".$nip."' AND tanggal='".$date."'", "jam");
					$count = mysql_num_rows($oList);
					@$counts += $count;
					
					if ($count == 1) 
					{
						$List = mysql_fetch_object($oList);
						$aTanggal = $date; #tanggal
						$aJMasuk = $List->jam; #jam masuk
						$aJKeluar = $List->jam; #jam keluar
						$aKMasuk = $List->kekurangan; #kekurangan masuk
						$aKKeluar = $List->kekurangan; #kekurangan keluar
						$aTotal = $List->kekurangan; #total
						if ($List->keterangan == "") $aKeterangan = alasan_id($List->kode_alasan)->keterangan;
						else if ($List->kode_alasan == "") $aKeterangan = $List->keterangan;
						else $aKeterangan = alasan_id($List->kode_alasan)->keterangan." (".$List->keterangan.")";
					}
					else if ($count > 1) 
					{				
						$oIn = presensi($kode_unit, "nip='".$nip."' AND tanggal='".$date."' AND status='1'");
						$In = mysql_fetch_object($oIn);
						$oOut = presensi($kode_unit, "nip='".$nip."' AND tanggal='".$date."' AND status='9'");
						$Out = mysql_fetch_object($oOut);
						
						$aTanggal = $date; #tanggal
						$aJMasuk = $In->jam; #jam masuk
						$aJKeluar = $Out->jam; #jam keluar
						$aKMasuk = $In->kekurangan; #kekurangan masuk
						$aKKeluar = $Out->kekurangan; #kekurangan keluar
						$aTotal = $In->kekurangan + $Out->kekurangan; #total
						
						if ($In->keterangan != "" or $In->kode_alasan != "") 
						{
							if ($In->keterangan == "") $aKeterangan = alasan_id($In->kode_alasan)->keterangan." ";
							else if ($In->kode_alasan == "") $aKeterangan = $In->keterangan." ";
							else $aKeterangan = alasan_id($In->kode_alasan)->keterangan." (".$In->keterangan.") ";
						}
						
						if ($Out->keterangan != "" or $Out->kode_alasan != "") 
						{
							if ($Out->keterangan == "") $aKeterangan .= alasan_id($Out->kode_alasan)->keterangan;
							else if ($Out->kode_alasan == "") $aKeterangan .= $Out->keterangan;
							else $aKeterangan .= alasan_id($Out->kode_alasan)->keterangan." (".$Out->keterangan.")";
						}
					}
					else 
					{
						$Hari = nama_hari($date);
						
						if ($Hari == "Sabtu" or $Hari == "Minggu") 
						{
							$aTanggal = $date; #tanggal
							$aJMasuk = "-"; #jam masuk
							$aJKeluar = "-"; #jam keluar
							$aKMasuk = "-"; #kekurangan masuk
							$aKKeluar = "-"; #kekurangan keluar
							$aTotal = "-"; #total
							$aKeterangan = $Hari; #keterangan
						}
						else 
						{
							$oLibur = libur("tanggal='".$date."'");
							$count = mysql_num_rows($oLibur);
							
							if ($count != 0) 
							{
								$Libur = mysql_fetch_object($oLibur);
								$aTanggal = $date; #tanggal
								$aJMasuk = "-"; #jam masuk
								$aJKeluar = "-"; #jam keluar
								$aKMasuk = "-"; #kekurangan masuk
								$aKKeluar = "-"; #kekurangan keluar
								$aTotal = "-"; #total
								$aKeterangan = $Libur->keterangan; #keterangan
							}
							else 
							{		
								$aTanggal = $date;
								$aJMasuk = "";
								$aJKeluar = "";
								$aKMasuk = "";
								$aKKeluar = "";
								$aTotal = "";
								$aKeterangan = "";
							}
						}
					}
					
					$pdf->SetFont($family, "", $size2); 
					$pdf->Cell($w2[0], $h3, $i, 1, 0, "C", 0, "");
					$dmy = dmy($aTanggal);
					$pdf->Cell($w2[1], $h3, $dmy, 1, 0, "C", 0, "");
					$msk = $aJMasuk;			
					$pdf->Cell($w2[2], $h3, $msk, 1, 0, "C", 0, "");
					$klr = $aJKeluar;
					$pdf->Cell($w2[3], $h3, $klr, 1, 0, "C", 0, "");
					$lk_masuk = $aKMasuk;
					$pdf->Cell($w2[4], $h3, $lk_masuk, 1, 0, "R", 0, "");
					$lk_keluar = $aKKeluar;
					$pdf->Cell($w2[5], $h3, $lk_keluar, 1, 0, "R", 0, "");
					$total_menit = $aTotal;
					$pdf->Cell($w2[6], $h3, $total_menit, 1, 0, "R", 0, "");
					$ket = strtoupper(@$aKeterangan);							
					$pdf->Cell($w2[7], $h3, $ket, 1, 1, "", 0, "");	
					$total += $aTotal;
					$aKeterangan = "";
				}
				
				$pdf->Cell($w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5], $h3, "TOTAL", 1, 0, "C", 0, "");
				$pdf->Cell($w2[6], $h3, $total, 1, 0, "R", 0, "");
				$pdf->Cell($w2[7], $h3, "", 1, 1, "C", 0, "");
			}
		}
		
		$pdf->Output('[SIAPP]Presensi_'.$y.$m.'.pdf','I');
	}
	else if (@$_POST["pdf2"] or $t == "pdf2") 
	{	
		require("../../../lib/fpdf17/fpdf.php");
		
		class PDF extends FPDF 
		{
			function Header() 
			{	
				$q = $_GET['q'];
				$m = $_GET['m'];
				if (empty($m)) $m = @$_POST['m'];
				$y = $_GET['y'];
				if (empty($y)) $y = @$_POST['y'];
				$t = $_GET['t'];
							
				if (empty($n_data)) $kode_unit = substr(pegawai_id($q)->kode_bidang,0,2);
				else $kode_unit = @$_POST['kode_unit'];
				
				$nama_unit = unit_id($kode_unit)->nama;	
				
				if ($m < 10) $m = "0".($m+0);
				$a_tgl = $y."-".$m."-01";
				$b_tgl = $y."-".$m."-".jumlah_hari($m+0,$y);
				#$this->Image("../../../css/images/logo_batan.jpg", $x=10, $z=10, $w=17, $h=17, "jpg");
				#$this->SetFont($family = "Arial", "B", $size = 13);
				#$this->SetXY($x2=$x+$w+3, $z+4);
				#$this->Cell(0, $h2=5, "BADAN TENAGA NUKLIR NASIONAL", 0, 1, "", 0, "");
				#$this->SetX($x2);
				#$this->SetFont($family = "Arial", "B", $size = 10);
				#$this->Cell(0,$h2, strtoupper($nama_unit), 0, 0, "", 0, "");
				
				$this->SetY($z+$h+$h2+33);
				$this->SetFont($family = "Arial", "B", $size4=12);
				$this->Cell(0, $h4=6, "LAPORAN PELANGGARAN JAM KERJA", 0, 1, "C", 0, "");
				$this->SetFont($family, "B", $size2 = 10);
				
				$txt = 'Bulan '.nama_bulan($m+0);
				$this->Cell(0, $h3=4, $txt, 0, 1, "C", 0, "");	
				$this->Ln($h4);
			}
		}
		
		$pdf = new PDF();
		
		for ($n=1; $n<=$ndata; $n++) 
		{
			$var = "nip_".$n;
			
			if (empty($n_data)) $nip = $q;
			else $nip = $$var;
			
			if (!empty($nip)) 
			{					
				$oPegawai = pegawai("nip='".$nip."'","nama");
				$Pegawai = mysql_fetch_object($oPegawai);
				
				$pdf->AddPage();
				$pdf->SetLeftMargin($margin=10);
				$pdf->SetRightMargin($margin);
				$pdf->SetX($margin);
				$pdf->SetFont($family, "", $size2=8);
								
				$w2 = array(7,18,40,35,18,18,21,15,18); //jumlah 190	
				$z = $pdf->GetY();
				$pdf->SetFont($family, "B", $size2);
				$h3=5;
				
				$pdf->Cell($w2[0], $h3*5, "NO", 1, 0, "C", 0, "");
				$pdf->Cell($w2[1], $h3*5, "TANGGAL", 1, 0, "C", 0, "");
				$pdf->Cell($w2[2], $h3*5, "NAMA", 1, 0, "C", 0, "");
				$pdf->Cell($w2[3], $h3*5, "NIP", 1, 0, "C", 0, "");
				
				$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$z+0.5*$h3);
				$pdf->MultiCell($w2[4], $h3, "Akumulasi Datang Terlambat (jam)", 0, "C", 0);
				
				$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$z+0.5*$h3);
				$pdf->MultiCell($w2[5], $h3, "Akumulasi Pulang Lebih Awal (jam)", 0, "C", 0);
				
				$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$z);
				$pdf->MultiCell($w2[6], $h3, "Akumulasi Meninggalkan Kantor Sementara (jam)", 0, "C", 0);
				$zz = $pdf->GetY();
				
				$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$z+$h3);
				$pdf->MultiCell($w2[7], $h3, "Tidak Masuk (hari)", 0, "C", 0);
				
				$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7],$z+1.5*$h3);
				$pdf->MultiCell($w2[8], $h3, "Jumlah (jam/hari)", 0, "C", 0);
				
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$z,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7]+$w2[8],$z);
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$z,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$zz);
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$z,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$zz);
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$z,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$zz);
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7],$z,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7],$zz);
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7]+$w2[8],$z,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7]+$w2[8],$zz);
				$pdf->Line($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$zz,$margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]+$w2[7]+$w2[8],$zz);
				
				$pdf->SetY($zz);
				
				$j = 1;
				$total_terlambat = 0;
				$total_pulang_awal = 0;
				$total_tidak_masuk = 0;
				$total = 0;
				
				for ($i=1; $i<=$jumlah_hari; $i++) 
				{
					if ($i < 10) $day = "0".$i;
					else $day = $i;
					
					$date = $y."-".$m."-".$day;
					
					$oList = presensi($kode_unit, "nip='".$nip."' AND tanggal='".$date."'", "jam");
						
					$count = mysql_num_rows($oList);
					
					if ($count == 1) 
					{
						$List = mysql_fetch_object($oList);
						
						if ($List->kekurangan != 0) 
						{
							$pdf->SetFont($family, "", $size2); 
							$pdf->Cell($w2[0], $h3, $j++, 1, 0, "C", 0, "");
							$dmy = dmy($date);
							$pdf->Cell($w2[1], $h3, $dmy, 1, 0, "C", 0, "");
							$nama = $Pegawai->nama;			
							$pdf->Cell($w2[2], $h3, $nama, 1, 0, "", 0, "");
							$nipo = format_nip_baru($Pegawai->nip_baru);
							$pdf->Cell($w2[3], $h3, $nipo, 1, 0, "C", 0, "");
							$masuk = 0;
							$pdf->Cell($w2[4], $h3, $masuk, 1, 0, "R", 0, "");
							$keluar = 0;
							$pdf->Cell($w2[5], $h3, $keluar, 1, 0, "R", 0, "");
							$sementara = 0;
							$pdf->Cell($w2[6], $h3, $sementara, 1, 0, "R", 0, "");
							$tidak_masuk = 1;							
							$pdf->Cell($w2[7], $h3, $tidak_masuk, 1, 0, "R", 0, "");	
							$jumlah = 450;
							$pdf->Cell($w2[8], $h3, $jumlah, 1, 1, "R", 0, "");	
							
							$total_tidak_masuk++;
							$total += 450;
						}
					}
					else if ($count > 1) 
					{				
						$oIn = presensi($kode_unit, "nip='".$nip."' AND tanggal='".$date."' AND status='1'");
						$In = mysql_fetch_object($oIn);
						$oOut = presensi($kode_unit, "nip='".$nip."' AND tanggal='".$date."' AND status='9'");
						$Out = mysql_fetch_object($oOut);
						
						if ($In->kekurangan != 0 or $Out->kekurangan != 0) 
						{
							$pdf->SetFont($family, "", $size2); 
							$pdf->Cell($w2[0], $h3, $j++, 1, 0, "C", 0, "");
							$dmy = dmy($date);
							$pdf->Cell($w2[1], $h3, $dmy, 1, 0, "C", 0, "");
							$nama = $Pegawai->nama;			
							$pdf->Cell($w2[2], $h3, $nama, 1, 0, "L", 0, "");
							$nipo = format_nip_baru($Pegawai->nip_baru);
							$pdf->Cell($w2[3], $h3, $nipo, 1, 0, "C", 0, "");
							$masuk = $In->kekurangan;
							$pdf->Cell($w2[4], $h3, $masuk, 1, 0, "R", 0, "");
							$keluar = $Out->kekurangan;
							$pdf->Cell($w2[5], $h3, $keluar, 1, 0, "R", 0, "");
							$sementara = 0;
							$pdf->Cell($w2[6], $h3, $sementara, 1, 0, "R", 0, "");
							$tidak_masuk = 0;							
							$pdf->Cell($w2[7], $h3, $tidak_masuk, 1, 0, "R", 0, "");	
							$jumlah = $In->kekurangan + $Out->kekurangan;
							$pdf->Cell($w2[8], $h3, $jumlah, 1, 1, "R", 0, "");
							
							$total_terlambat += $In->kekurangan;
							$total_pulang_awal += $Out->kekurangan;
						}
					}
				}
				
				$pdf->Cell($w2[0]+$w2[1]+$w2[2]+$w2[3], $h3, "T O T A L", 1, 0, "C", 0, "");
				$pdf->Cell($w2[4], $h3, $total_terlambat, 1, 0, "R", 0, "");
				$pdf->Cell($w2[5], $h3, $total_pulang_awal, 1, 0, "R", 0, "");
				$pdf->Cell($w2[6], $h3, '0', 1, 0, "R", 0, "");
				$pdf->Cell($w2[7], $h3, $total_tidak_masuk, 1, 0, "R", 0, "");
				$total += $total_terlambat + $total_pulang_awal;
				$pdf->Cell($w2[8], $h3, $total, 1, 0, "R", 0, "");
			}
			
			$pdf->SetFont($family, "", $size2 = 10);
			$pdf->Ln(3*$h3);
			$margin_ttd = 120;
			$pdf->SetX($margin_ttd);
			$pdf->Cell(0, $h3, 'Yang melaporkan,', 0, 1, "", 0, "");
			
			$Atasan = get_atasan($nip);
			$jabatan = $Atasan->jabatan;
			
			$pdf->SetX($margin_ttd);
			$pdf->MultiCell(0, $h3, $jabatan, 0, "", 0);
			
			$pdf->Ln(4*$h3);
			$pdf->SetX($margin_ttd);
			$namae = $Atasan->nama;
			$pdf->Cell(0, $h3, $namae, 0, 1, "", 0, "");
			
			$pdf->SetX($margin_ttd);
			$nipe = format_nip_baru($Atasan->nip_baru);
			$pdf->Cell(0, $h3, 'NIP. '.$nipe, 0, 1, "", 0, "");
		}
		
		$pdf->Output('doc.pdf','I');
	}
	*/
?>