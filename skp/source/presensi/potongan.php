<?php
	#@
	/*
		File 			: /source/presensi/rekapitulasi.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 26 Nov 2014
		Selesai Tanggal : 26 Nov 2014
		Fungsi 			: Menampilkan rekapitulasi potongan tunjangan kinerja pegawai dalam persen
		
		Revisi/Modifikasi :
		26 Nov 2014		: Tambah Edit Potongan
		04 Des 2014		: Mengubah Query Rekapitulasi.Jika kdunit = SETDITJEN, maka tampilkan juga DITJEN
		04 Des 2014		: Menambahkan Status Verifikasi potongan
		04 Des 2014		: Menambahkan Keterangan
		
	*/
	
	checkauthentication();
	$p = @$_GET['p'];
	$m = @$_GET['m']+0;
	$y = @$_GET['y'];
	$u = @$_GET['u'];
	$b = @$_GET['b'];
	$s = @$_GET['s'];
	
	if ($m == "") $m = date("n");
	if ($m < 10) $m = "0".$m;
	if ($y == "") $y = date("Y");
	if ($u == "") $u = substr($_SESSION['xkdunit'], 0, 5);
	if ($b == "") $b = "None";
	if ($b == "All") $b = $u."0";
	if ($s == "") $s = $b."0";
	
	$bulan = $y."-".$m;
	$url = "m=".$m."&y=".$y."&u=".$u."&b=".$b."&s=".$s."&r=475";
	$ed_link = "index.php?p=468&".$url;
	
	if (substr($s,5,2) == "00") $bidang = $u;
	else if (substr($s,6,1) == "0") $bidang = $b;
	else $bidang = $s;
	
	if (@$_POST['xVerifikasi'])
	{
		extract($_POST);
		
		#if ($ver == 1)
		#{
			$s_rekap = "SELECT * FROM potongan WHERE kdunit LIKE '".$b_ver."' AND bulan = '".$y_ver."-".$m_ver."'";
			
			$q_rekap = mysql_query($s_rekap);
			$n_rekap = mysql_num_rows($q_rekap);
			
			if ($n_rekap > 0)
			{
				while ($rekap = mysql_fetch_array($q_rekap))
				{
					$tot = $rekap['TL2'] + $rekap['TL3'] + $rekap['PSW1'] + $rekap['PSW2'] + $rekap['PSW3'] + $rekap['PSW4'] + $rekap['TK'] + $rekap['DK'] + 
					$rekap['CB'] + $rekap['CSRI'] + $rekap['CM'] + $rekap['CP'] + $rekap['DIS'] + $rekap['BS'];
						
					$total = min($tot, 100);
					
					$s_update = "UPDATE potongan SET TOT = '".$total."' WHERE id = '".$rekap['id']."'";
					$q_update = mysql_query($s_update);
				}
				
				$s_update_ver = "UPDATE proses_verifikasi SET status_verifikasi_potongan = '".$ver."', tanggal_verifikasi_potongan = '".date("Y-m-d")."' 
				WHERE id = '".$id_ver."'";
				
				#echo $s_update_ver."<BR>";
				
				$q_update_ver = mysql_query($s_update_ver);
				
				if ($q_update_ver) 
				{	
					update_log("Verifikasi potongan berhasil.", "potongan", 1);
					$_SESSION['errmsg'] = "Verifikasi potongan berhasil."; ?>
					
                    <meta http-equiv="refresh" content="0;URL=index.php?p=475&<?php echo $url; ?>"><?php
				}
				else 
				{
					update_log("Verifikasi potongan gagal.", "potongan", 0);
					$_SESSION['errmsg'] = "Verifikasi potongan berhasil."; ?>
					
                    <meta http-equiv="refresh" content="0;URL=index.php?p=475&<?php echo $url; ?>"><?php
				}
			}
		#}
	}
?>

<script language="javascript" src="lib/autocombo/autocombo.js"></script>
<form action="" method="get" name="xRekapitulasi">
	<input name="p" type="hidden" value="<?php echo $p; ?>">
	<fieldset>
		<table class="admintable" cellspacing="1">
			<!--tr>
				<td class="key">Cetak Rekapitulasi</td>
				<td>
					<a href="menus/siapp/presensi/tunjangan_kinerja_excel.php?<?php #echo $url; ?>&t=excel" target="_blank">
						<img src="css/images/excel.gif" width="16" height="16" />&nbsp;Excel
					</a> &nbsp; | &nbsp; 
					<a href="menus/siapp/presensi/tunjangan_kinerja_excel.php?<?php #echo $url; ?>&t=calc" target="_blank">
						<img src="css/images/openoffice.gif" width="16" height="16" />&nbsp;Open Office
					</a>
				</td>
			</tr-->
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
							
                            <option value="<?php echo $year; ?>" <?php if ($year == $y) echo "selected"; ?>><?php echo $year; ?></option><?php
						
						} ?>
					
                    </select>
				</td>
			</tr>
			<tr>
				<td class="key">Bidang / Bagian</td>
				<td>
					<div id="bidang-view"><?php
						
						#$oBidang = bidang_list($u);
						
						$s_bidang = "SELECT * FROM kd_unitkerja WHERE kdunit LIKE '".$u."_0' AND kdunit NOT LIKE '%00' ORDER BY kdunit";
						#echo $s_bidang."<BR>";
						$q_bidang = mysql_query($s_bidang);
						$n_bidang = mysql_num_rows($q_bidang);
						
						if ($n_bidang != 0) 
						{ ?>	
							
                            <select name="b" onchange="get_subbidang(b.value)">
								<option value="None"></option>
								<option value="All" <?php if ($b == $u."0") echo "selected"; ?>>SEMUA BIDANG / BAGIAN</option><?php
								
								while ($Bidang = mysql_fetch_array($q_bidang)) 
								{ ?>
									
                                    <option value="<?php echo substr($Bidang['kdunit'], 0, 6); ?>" <?php if (substr($Bidang['kdunit'], 0, 6) == $b) 
									echo "selected"; ?>><?php echo $Bidang['nmunit']; ?></option><?php
									
								} ?>
                                
							</select><?php 
						
						}
						else if ($_SESSION['xkdunit'] == "00")
						{ ?>
							
                            <input type="hidden" name="b" value="000" /><?php
						
						} ?>
					</div>
				</td>
			</tr>
			<tr>
				<td class="key">Sub Bidang / Sub Bagian</td>
				<td>
					<div id="subbidang-view"><?php
						
						#$oSubBidang = subbidang_list($b);
						
						$s_subbidang = "SELECT * FROM kd_unitkerja WHERE kdunit LIKE '".$b."%' AND kdunit NOT LIKE '%0' ORDER BY kdunit";
						#echo $s_subbidang."<BR>";
						$q_subbidang = mysql_query($s_subbidang);
						$n_subbidang = mysql_num_rows($q_subbidang);
						
						if ($n_subbidang != 0) 
						{ ?>	
							
                            <select name="s">
								<option value="">Semua Sub Bidang / Sub Bagian</option><?php
								
								while ($subbidang = mysql_fetch_array($q_subbidang)) 
								{ ?>
                                
									<option value="<?php echo $subbidang['kdunit']; ?>" <?php if ($subbidang['kdunit'] == $s) echo "selected"; ?>><?php 
									
										echo $subbidang['nmunit']; ?>
                                    
                                    </option><?php
								
								} ?>
							
                            </select><?php
						
						} ?>
					
                    </div>
				</td>
			</tr>
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
					<div class="button2-left">
						<div class="next">
							<a onclick="Btn_Submit('xRekapitulasi');">OK</a>
						</div>
					</div>
					<div class="clr"></div>
					<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="OK" type="submit">
				</td>
			</tr>
		</table>
	</fieldset>
</form>
 
<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th rowspan="3" width="2%">#</th>
			<th rowspan="3">Nama</th>
			<th rowspan="3" width="2%">Status<br />Kepegawaian<br />(PNS/CPNS)</th>
			<th colspan="8">Catatan Kehadiran Harian <font color="#f00">(dalam %)</font></th>
			<th colspan="4">Cuti <font color="#f00">(dalam %)</font></th>
			<th rowspan="3" title="Hukuman Disiplin">DIS</th>
			<th rowspan="3" title="Pemberhentian Sementara">BS</th>
			<th rowspan="3" title="Total">TOTAL<BR /><font color="#f00">(dalam %)</font></th>
			<th rowspan="3" title="Keterangan">Keterangan</th><?php
            
			if ($Session['xlevel'] <= 4 and ($ver['status_verifikasi_potongan'] == "0" or $ver['status_verifikasi_potongan'] == ""))
			{ ?>
			
            	<th rowspan="3" width="3%">Aksi</th><?php
            
			} ?>
            
		</tr>
		<tr>
			<th colspan="2">Terlambat Datang</th>
			<th colspan="4">Pulang Sebelum Waktu</th>
			<th rowspan="2" width="3%" title="Tanpa Keterangan">TK</th>
			<th rowspan="2" width="3%" title="Dengan Keterangan">DK</th>
			<th rowspan="2" width="3%" title="Cuti Besar">CB</th>
			<th rowspan="2" width="3%" title="Cuti Sakit">CS</th>
			<th rowspan="2" width="3%" title="Cuti Melahirkan">CM</th>
			<th rowspan="2" width="3%" title="Cuti Penting">CP</th>
		</tr>
		<tr>
			<th width="3%" title="Terlambat 91 - 120 menit">TL2</th>
			<th width="3%" title="Terlambat > 120 menit">TL3</th>
			<th width="3%" title="Pulang Sebelum Waktu 1 - 30 menit">PSW1</th>
			<th width="3%" title="Pulang Sebelum Waktu 31 - 60 menit">PSW2</th>
			<th width="3%" title="Pulang Sebelum Waktu 61 - 90 menit">PSW3</th>
			<th width="3%" title="Pulang Sebelum Waktu > 91 menit">PSW4</th>
	</thead>
	<tbody><?php
	
		if ($b != "None")
		{
			#$oList = rekapitulasi_2($bidang, $bulan);
			
			if ($_SESSION['xkdunit'] == "2320100" and $_SESSION['xlevel'] <= 3 and $b == $u."0")
			{
				$s_rekapitulasi = "SELECT a.id, a.nip, a.bulan, a.TL, a.TL1, a.TL2, a.TL3, a.TL4, a.KS, a.KS1, a.KS2, a.KS3, a.KS4, 
				a.PSW, a.PSW1, a.PSW2, a.PSW3, a.PSW4, a.CT, a.CB, a.CSRI, a.CSRJ, a.CM, a.CM3, a.CP, a.CLTN, a.DK, a.DK, a.TK, a.TBmin, a.TBplus, a.UP, 
				a.DIS, a.BS, a.keterangan, b.nama, b.kdeselon, b.kdgol, b.kdunitkerja, b.kdstatuspeg, c.NmGol, d.nmunit FROM potongan a LEFT JOIN 
				m_idpegawai b ON a.nip = b.nip LEFT JOIN kd_gol c ON b.kdgol = c.KdGol LEFT JOIN kd_unitkerja d ON b.kdunitkerja = d.kdunit WHERE 
				(b.kdunitkerja LIKE '".$bidang."%' OR b.kdunitkerja = '2320000') AND a.bulan = '".$bulan."' ORDER BY b.kdunitkerja, b.kdeselon DESC, 
				b.kdgol DESC, a.nip";
			}
			else
			{
				$s_rekapitulasi = "SELECT a.id, a.nip, a.bulan, a.TL, a.TL1, a.TL2, a.TL3, a.TL4, a.KS, a.KS1, a.KS2, a.KS3, a.KS4, 
				a.PSW, a.PSW1, a.PSW2, a.PSW3, a.PSW4, a.CT, a.CB, a.CSRI, a.CSRJ, a.CM, a.CM3, a.CP, a.CLTN, a.DK, a.DK, a.TK, a.TBmin, a.TBplus, a.UP, 
				a.DIS, a.BS, a.keterangan, b.nama, b.kdeselon, b.kdgol, b.kdunitkerja, b.kdstatuspeg, c.NmGol, d.nmunit FROM potongan a LEFT JOIN 
				m_idpegawai b ON a.nip = b.nip LEFT JOIN kd_gol c ON b.kdgol = c.KdGol LEFT JOIN kd_unitkerja d ON b.kdunitkerja = d.kdunit WHERE 
				b.kdunitkerja LIKE '".$bidang."%' AND a.bulan = '".$bulan."' ORDER BY b.kdunitkerja, b.kdeselon DESC, b.kdgol DESC, a.nip";
			}
			
			$q_rekapitulasi = mysql_query($s_rekapitulasi);
			$n_rekapitulasi = mysql_num_rows($q_rekapitulasi);
		}
		else $n_rekapitulasi = 0;
	
		if ($n_rekapitulasi == 0) 
		{ ?>
			
            <tr><td align="center" colspan="24">Tidak ada data!</td></tr><?php
		
		}
		else 
		{
			$bid = $u.'0';
			$k = 1;
			
			while ($col = mysql_fetch_array($q_rekapitulasi))
			{
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1";
				
				if (@$col['kdunitkerja'] != $bid and $_SESSION['xkdunit'] != "00") 
				{ ?>
					
                    <tr class="row3">
						<td align="center" colspan="24"><b><?php echo @$col['nmunit']; ?></b></td>
					</tr><?php
				
				} ?>
				
				<tr class="<?php echo $class; ?>">
					<td align="center"><?php echo $k; ?></td>
					<td>
						<a href="<?php echo $ed_link."&q=".@$col['nip']; ?>"><?php 
								
							echo @$col['nama']; ?>
						
						</a><br /><?php 
						
						echo @$col['nip']; ?>&nbsp; &nbsp; &nbsp;|&nbsp; &nbsp; &nbsp;<?php 
						echo @$col['NmGol']; ?>
						
					</td>
					<td align="center"><?php 
					
						if (@$col['kdstatuspeg'] == '2') echo "CPNS";
						else echo "PNS"; ?>
						
					</td>
					<td align="center" title="TL2"><?php 
						
						if (@$col['TL2'] != 0) { ?><font color="#f00"><?php echo @$col['TL2']; ?></font><?php }
						else echo @$col['TL2']; ?>
						
					</td>
					<td align="center" title="TL3"><?php 
						
						if (@$col['TL3'] != 0) { ?><font color="#f00"><?php echo @$col['TL3']; ?></font><?php }
						else echo @$col['TL3']; ?>
						
					</td>
					<td align="center" title="PSW1"><?php 
						
						if (@$col['PSW1'] != 0) { ?><font color="#f00"><?php echo @$col['PSW1']; ?></font><?php }
						else echo @$col['PSW1']; ?>
						
					</td>
					<td align="center" title="PSW2"><?php 
						
						if (@$col['PSW2'] != 0) { ?><font color="#f00"><?php echo @$col['PSW2']; ?></font><?php }
						else echo @$col['PSW2']; ?>
						
					</td>
					<td align="center" title="PSW3"><?php 
						
						if (@$col['PSW3'] != 0) { ?><font color="#f00"><?php echo @$col['PSW3']; ?></font><?php }
						else echo @$col['PSW3']; ?>
						
					</td>
					<td align="center" title="PSW4"><?php 
						
						if (@$col['PSW4'] != 0) { ?><font color="#f00"><?php echo @$col['PSW4']; ?></font><?php }
						else echo @$col['PSW4']; ?>
						
					</td>
					<td align="center" title="TK"><?php 
						
						if (@$col['TK'] != 0) { ?><font color="#f00"><?php echo @$col['TK']; ?></font><?php }
						else echo @$col['TK']; ?>
						
					</td>
					<td align="center" title="TK"><?php 
						
						if (@$col['DK'] != 0) { ?><font color="#f00"><?php echo @$col['DK']; ?></font><?php }
						else echo @$col['DK']; ?>
						
					</td>
					<td align="center" title="CB"><?php 
						
						if (@$col['CB'] != 0) { ?><font color="#f00"><?php echo @$col['CB']; ?></font><?php }
						else echo @$col['CB']; ?>
						
					</td>
					<td align="center" title="CS"><?php 
						
						if (@$col['CSRI'] != 0) { ?><font color="#f00"><?php echo @$col['CSRI']; ?></font><?php }
						else echo @$col['CSRI']; ?>
						
					</td>
					<td align="center" title="CM"><?php 
						
						if (@$col['CM'] != 0) { ?><font color="#f00"><?php echo @$col['CM']; ?></font><?php }
						else echo @$col['CM']; ?>
						
					</td>
					<td align="center" title="CP"><?php 
						
						if (@$col['CP'] != 0) { ?><font color="#f00"><?php echo @$col['CP']; ?></font><?php }
						else echo @$col['CP']; ?>
						
					</td>
					<td align="center" title="DIS"><?php 
						
						if (@$col['DIS'] != 0) { ?><font color="#f00"><?php echo @$col['DIS']; ?></font><?php }
						else echo @$col['DIS']; ?>
						
					</td>
					<td align="center" title="BS"><?php 
						
						if (@$col['BS'] != 0) { ?><font color="#f00"><?php echo @$col['BS']; ?></font><?php }
						else echo @$col['BS']; ?>
						
					</td>
					<td align="center" title="BS"><?php 
						
						$tot = $col['TL2'] + $col['TL3'] + $col['PSW1'] + $col['PSW2'] + $col['PSW3'] + $col['PSW4'] + $col['TK'] + $col['DK'] + $col['CB'] +
						$col['CSRI'] + $col['CM'] + $col['CP'] + $col['DIS'] + $col['BS'];
						
						echo "<font color='#f00'>".min($tot, 100)."</font>"; ?>
						
					</td>
					<td title="Keterangan"><?php echo @$col['keterangan']; ?></td><?php
						
					if ($Session['xlevel'] <= 4 and ($ver['status_verifikasi_potongan'] == "0" or $ver['status_verifikasi_potongan'] == ""))
					{ ?>
					
						<td align="center" nowrap="nowrap">
                            <a class="thickbox" href="index.php?p=476&<?php echo $url; ?>&q=<?php echo $col['id']; ?>" title="Edit Potongan">
                                <img src="css/images/edit_f2.png" border="0" width="16" height="16">
                            </a>
						</td><?php
					
					} ?>
						
				</tr><?php
				
				$bid = @$col['kdunitkerja'];
				$k++;
			}
			
		} ?>
		
	</tbody>
	<tfoot>
		<tr>
			<td colspan="24">&nbsp;</td>
		</tr>
	</tfoot>
</table><BR /><?php

$s_verifikasi = "SELECT * FROM proses_verifikasi WHERE tahun = '".$y."' AND bulan = '".$m."' AND kdunitkerja = '".$_SESSION['xkdunit']."'";

$q_verifikasi = mysql_query($s_verifikasi);
$n_verifikasi = mysql_num_rows($q_verifikasi);

if ($n_verifikasi == 0)
{
	$s_insert = "INSERT proses_verifikasi (tahun, bulan, kdunitkerja) VALUES ('".$y."', '".$m."', '".$_SESSION['xkdunit']."')";
	
	$q_insert = mysql_query($s_insert);
	
	$s_verifikasi = "SELECT * FROM proses_verifikasi WHERE tahun = '".$y."' AND bulan = '".$m."' AND 
	kdunitkerja = '".$_SESSION['xkdunit']."'";

	$q_verifikasi = mysql_query($s_verifikasi);
}

$verifikasi = mysql_fetch_array($q_verifikasi);

#if (($verifikasi['status_verifikasi_potongan'] == "0" or $verifikasi['status_verifikasi_potongan'] == "") and $n_rekapitulasi > 0)
#{ ?>
				
	<form action="index.php?p=<?php echo $p; ?>&<?php echo $url; ?>" method="post" name="xVerifikasi">
		<fieldset>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">Status Verifikasi</td>
					<td>
						<input name="ver" type="radio" value="0" <?php if ($verifikasi['status_verifikasi_potongan'] == "0" or 
						$verifikasi['status_verifikasi_potongan'] == "" or $n_verifikasi == 0) echo "checked='checked'"; ?> /> Draft&nbsp;
						<input name="ver" type="radio" value="1" <?php if ($verifikasi['status_verifikasi_potongan'] == "1") echo "checked='checked'"; ?> /> 
						Verifikasi
						<input name="id_ver" type="hidden" value="<?php echo $verifikasi['id']; ?>" />
						<input name="m_ver" type="hidden" value="<?php echo $m; ?>" />
						<input name="y_ver" type="hidden" value="<?php echo $y; ?>" />
						<input name="b_ver" type="hidden" value="<?php echo $_SESSION['xkdunit']; ?>" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div class="button2-left">
							<div class="next">
								<a onclick="Btn_Submit('xVerifikasi');">OK</a>
							</div>
						</div>
						<div class="clr"></div>
						<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="OK" type="submit">
						<input name="xVerifikasi" type="hidden" value="1" />
					</td>
				</tr>
			</table>
		</fieldset>
	</form><?php

#} ?>