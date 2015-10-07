<table width="70%">
	<tr>
		<td valign="top">
			<div class="listview_common"><?php
				
				/*switch ($xlevel)
				{	
					#Owner
					case "DEV": ?>
						
						<a href="index.php?p=30"><img src="css/images/import.gif" alt="">Import Data Presensi</a>
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=31"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=72"><img src="css/images/statistik.gif" alt="">Rekapitulasi Tunjangan Kinerja</a>
						<a href="index.php?p=41"><img src="css/images/loket.gif" alt="">Data Pegawai</a>
						<a href="index.php?p=42"><img src="css/images/libur.gif" alt="">Hari Libur/Cuti Bersama</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a>
						<a href="index.php?p=80"><img src="css/images/keluar_sementara.gif" alt="">Keluar Sementara</a>
						<a href="index.php?p=82"><img src="css/images/upacara_bendera.gif" alt="">Upacara Bendera</a>
						<a href="index.php?p=103"><img src="css/images/pegawai_shift.gif" alt="">
							Pegawai Shift<br />
							<font color="red" style="text-decoration:blink;">[New]</font>
						</a>
						<a href="index.php?p=97"><img src="css/images/jadwal_shift.gif" alt="">
							Jadwal Shift<br />
							<font color="red" style="text-decoration:blink;">[New]</font>
						</a><?php
						
					break;
					
					#Administrator
					case "ADM": ?>
						
						<a href="index.php?p=30"><img src="css/images/import.gif" alt="">Import Data Presensi</a>
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=31"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=72"><img src="css/images/statistik.gif" alt="">Rekapitulasi Tunjangan Kinerja</a>
						<a href="index.php?p=41"><img src="css/images/loket.gif" alt="">Data Pegawai</a>
						<a href="index.php?p=42"><img src="css/images/libur.gif" alt="">Hari Libur/Cuti Bersama</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a>
						<a href="index.php?p=80"><img src="css/images/keluar_sementara.gif" alt="">Keluar Sementara</a>
						<a href="index.php?p=82"><img src="css/images/upacara_bendera.gif" alt="">Upacara Bendera</a>
						<a href="index.php?p=103"><img src="css/images/pegawai_shift.gif" alt="">
							Pegawai Shift<br />
							<font color="red" style="text-decoration:blink;">[New]</font>
						</a>
						<a href="index.php?p=97"><img src="css/images/jadwal_shift.gif" alt="">
							Jadwal Shift<br />
							<font color="red" style="text-decoration:blink;">[New]</font>
						</a><?php
						
						break;
					
					#Operator
					case "OPR": ?>
						
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=31"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=72"><img src="css/images/statistik.gif" alt="">Rekapitulasi Tunjangan Kinerja</a>
						<a href="index.php?p=41"><img src="css/images/loket.gif" alt="">Data Pegawai</a>
						<a href="index.php?p=42"><img src="css/images/libur.gif" alt="">Hari Libur/Cuti Bersama</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a>
						<a href="index.php?p=80"><img src="css/images/keluar_sementara.gif" alt="">Keluar Sementara</a>
						<a href="index.php?p=82"><img src="css/images/upacara_bendera.gif" alt="">Upacara Bendera</a>
						<a href="index.php?p=103"><img src="css/images/pegawai_shift.gif" alt="">
							Pegawai Shift<br />
							<font color="red" style="text-decoration:blink;">[New]</font>
						</a>
						<a href="index.php?p=97"><img src="css/images/jadwal_shift.gif" alt="">
							Jadwal Shift<br />
							<font color="red" style="text-decoration:blink;">[New]</font>
						</a><?php
						
					break;
					
					#Kapus
					case "ES2": ?>
						
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=31"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a><?php
						
					break;
					
					#Kabid
					case "ES3": ?>
						
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=31"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a><?php
						
					break;
					
					#Kasub
					case "ES4": ?>
						
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=31"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a><?php
						
					break;
					
					#Staf
					case "STF": ?>
						
						<a href="index.php?p=29"><img src="css/images/presensi.gif" alt="">Presensi Pegawai</a>
						<a href="index.php?p=67"><img src="css/images/laporan.gif" alt="">Rekapitulasi Presensi</a>
						<a href="index.php?p=78"><img src="css/images/cuti.gif" alt="">Cuti Tahunan</a><?php
						
					break;
						
				}*/ ?>
				
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<h3>
            	Saran dan Masukkan dapat dialamatkan ke : Bidang Sistem Informasi - PPIN <br />
            	telp: 021-7562860 ext 7203 <br />
                fax: 021-7560923<br />
                email:<BR /><img src="css/images/h_green/email_layanan.png" />
            </h3>
		</td>
	</tr>
</table>