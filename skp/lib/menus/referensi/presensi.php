<?php
	checkauthentication();
	$table = "presensi";
	$field = get_field($table);
	$p = $_GET['p'];
	$u = $_GET['u'];
	$b = $_GET['b'];
	$subbidang = $_GET['subbidang'];
	$q = $_GET['q'];
	$m = $_GET['m']+0;
	$y = $_GET['y'];
	
	$url = "m=".$m."&y=".$y."&u=".$u."&b=".$b."&subbidang=".$subbidang;
	$ed_link = "index.php?p=".get_edit_link($p)."&".$url;
	
	if ($u == "") $u = $_SESSION['unit_kerja'];
	
	if ($m == "") $m = date("n");
	if ($y == "") $y = date("Y");
	
	if ($m < 10) $m = "0".$m;
	
	$jumlah_hari = jumlah_hari($m,$y);
	
	isi_absensi($u);
				
	for ($i=1; $i<=$jumlah_hari; $i++) {
		if ($i < 10) $day = "0".$i;
		else $day = $i;
		
		$date = $y."-".$m."-".$day;
		
		$oLibur = libur("tanggal='".$date."'");
		$count = mysql_num_rows($oLibur);
		
		if ($count != 0) {
			$Libur = mysql_fetch_object($oLibur);
			$col[0][] = "-"; #id
			$col[1][] = "-"; #nip
			$col[2][] = $date; #tanggal
			$col[3][] = "-"; #jam
			$col[4][] = "-"; #status
			$col[5][] = "-"; #kekurangan
			$col[6][] = "-"; #alasan
			$col[7][] = $Libur->keterangan; #keterangan
			$ed[] = "#";
			$rowspan[] = "1";
			$class[] = "row2";
		}
		else {		
			$oList = presensi($u, "nip='".$q."' AND tanggal='".$date."'", "jam");
			$count = mysql_num_rows($oList);
			$counts += $count;
			
			if ($count != 0) {
				$oList = presensi($u, "nip='".$q."' AND tanggal='".$date."'", "jam");
				
				$l = 0;
				while($List = mysql_fetch_object($oList)) {					
					foreach ($field as $k=>$val) {
						$col[$k][] = $List->$val;
					}
					$ed[] = $ed_link."&q=".$List->$field[0];
					$rowspan[] = $count;
					
					$d = substr($List->tanggal,8,2)+0;
					if ($d%2 == 1) $class[] = "row1";
					else $class[] = "row0";													
				}
			}
			else {
				$Hari = nama_hari($date);
				
				if ($Hari == "Sabtu" or $Hari == "Minggu") {
					$col[0][] = "-";
					$col[1][] = "-";
					$col[2][] = $date;
					$col[3][] = "-";
					$col[4][] = "-";
					$col[5][] = "-";
					$col[6][] = "-";
					$col[7][] = $Hari;
					$ed[] = "#";
					$rowspan[] = "1";
					$class[] = "row2";
				}
				else {
					$col[0][] = "";
					$col[1][] = "";
					$col[2][] = $date;
					$col[3][] = "";
					$col[4][] = "";
					$col[5][] = "";
					$col[6][] = "";
					$col[7][] = "";
					$ed[] = "#";
					$rowspan[] = "1";
					$d = substr($date,8,2)+0;
					if ($d%2 == 1) $class[] = "row1";
					else $class[] = "row0";
				}
			}
		}
	}
?>

<script language="javascript" src="js/autocombo.js"></script>
<form action="" method="get" name="form">
	<input name="p" type="hidden" value="<?php echo $p ?>">
	<input name="b" type="hidden" value="<?php echo $b ?>">
	<fieldset>
		<table class="admintable" cellspacing="1">
			<tr>
				<td class="key">Cetak</td>
				<td>
					<a href="menus/siapp/presensi/presensi_print.php?<?php echo $url ?>&q=<?php echo $q ?>&t=pdf" target="_blank">PDF</a> &nbsp; | &nbsp; 
					<a href="menus/siapp/presensi/presensi_print.php?<?php echo $url ?>&q=<?php echo $q ?>&t=excel" target="_blank">Excel</a> &nbsp; | &nbsp; 
					<a href="menus/siapp/presensi/presensi_print.php?<?php echo $url ?>&q=<?php echo $q ?>&t=calc" target="_blank">Open Office</a></td>
			</tr>
			<tr>
				<td class="key">Bulan</td>
				<td>
					<select name="m">
						<option></option><?php
						for ($month=1; $month<=12; $month++) { ?>
							<option value="<?php echo $month ?>" <?php if ($month == $m) echo "selected" ?>><?php echo nama_bulan($month) ?></option><?php
						} ?>
					</select>
					<select name="y">
						<option></option><?php
						for ($year=date("Y")-10; $year<=date("Y")+10; $year++) { ?>
							<option value="<?php echo $year ?>" <?php if ($year == $y) echo "selected" ?>><?php echo $year ?></option><?php
						} ?>
					</select>
				</td>
			</tr><?php
			if ($_SESSION['unit_kerja'] == '12') { ?>
				<tr>
					<td class="key">Unit Kerja</td>
					<td>
						<select name="u" id="u" onchange="get_pegawai(u.value)"><?php
							$oUnit = unit_kantor_pusat();
							while ($Unit = mysql_fetch_object($oUnit)) { ?>
								<option value="<?php echo substr($Unit->kode,0,2) ?>" <?php if (substr($Unit->kode,0,2) == $u) echo "selected" ?>><?php echo $Unit->nama ?></option><?php
							} ?>
						</select>
					</td>
				</tr><?php
			} ?>
			<tr>
				<td class="key">Nama</td>
				<td>
					<div id="pegawai-view"><?php
						$oPegawai = pegawai_list($u, "nama");
						$num = mysql_num_rows($oPegawai);
						if ($num != 0) { ?>
							<select name="q">
								<option></option><?php
								while ($Pegawai = mysql_fetch_object($oPegawai)) { ?>
									<option value="<?php echo $Pegawai->nip ?>" <?php if ($Pegawai->nip == $q) echo "selected" ?>><?php echo $Pegawai->nama ?></option><?php
								} ?>
							</select><?php
						} ?>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>		
					<div class="button2-right">
						<div class="prev">
							<a onclick="Back('index.php?p=31&<?php echo $url ?>')">Kembali</a>
						</div>
					</div>
					<div class="button2-left">
						<div class="next">
							<a onclick="form.submit();">OK</a>
						</div>
					</div>
					<div class="clr"></div>
					<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="OK" type="submit">
				</td>
			</tr>
		</table>
	</fieldset>
</form>
<fieldset><?php
	$oImport = import("","date_until DESC");
	$Import = mysql_fetch_object($oImport); ?>
	Update data terakhir: <?php echo $Import->date_until ?>
</fieldset>
<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th width="12%">Tanggal</th>
			<th width="10%">Jam</th>
			<th width="8%">Status</th>
			<th width="12%">Kekurangan<br />(menit)</th>
			<th width="10%">Alasan</th>
			<th>Keterangan</th>
			<th width="4%">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($counts == 0) { ?>
			<tr><td align="center" colspan="<?php echo count($field)+1 ?>">Tidak ada data!</td></tr><?php
		}
		else {
			$l = 0;
			foreach ($col[0] as $k=>$val) { ?>
				
				<tr class="<?php echo $class[$k] ?>"><?php
					
					if ($tanggal != $col[2][$k]) {
						$l++; ?>
						<td align="center" rowspan="<?php echo $rowspan[$k] ?>"><?php echo $l ?></td>
						<td align="center" rowspan="<?php echo $rowspan[$k] ?>"><?php echo dmy($col[2][$k]) ?></td><?php
					} ?>
					
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="center"><?php echo strtoupper($col[4][$k]) ?></td>
					<td align="right"><?php 
						if ($col[5][$k] > 0) { ?>
							<font color="#f00"><?php echo $col[5][$k] ?></font><?php
						}
						else echo $col[5][$k]; ?>
					</td>
					<td align="center"><?php echo $col[6][$k] ?></td>
					<td><?php echo strtoupper($col[7][$k]) ?></td>
					<td align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
					</td>
				</tr><?php
				
				$tanggal = $col[2][$k];
			}
					
			$bulan = $y."-".$m;
			$oRekapitulasi = rekapitulasi($u, "bulan='".$bulan."' AND nip='".$q."'");
			$Rekapitulasi = mysql_fetch_object($oRekapitulasi);
			$Ket = "Hari Kerja: ".get_jumlah_hari_kerja($m,$y)."; &nbsp;";
			$Ket .= "Hadir: ".$Rekapitulasi->hadir."; &nbsp;";
			if ($Rekapitulasi->dl_ln != 0) $Ket .= "DL LN: ".$Rekapitulasi->dl_ln."; &nbsp;";
			if ($Rekapitulasi->dl_non_sppd != 0) $Ket .= "DL NON SPPD: ".$Rekapitulasi->dl_non_sppd."; &nbsp;";
			if ($Rekapitulasi->dl_sppd != 0) $Ket .= "DL SPPD: ".$Rekapitulasi->dl_sppd."; &nbsp;";
			if ($Rekapitulasi->c != 0) $Ket .= "CUTI: ".$Rekapitulasi->c."; &nbsp;";
			if ($Rekapitulasi->s != 0) $Ket .= "SAKIT: ".$Rekapitulasi->s."; &nbsp;";
			if ($Rekapitulasi->i != 0) $Ket .= "IZIN: ".$Rekapitulasi->i."; &nbsp;";
			if ($Rekapitulasi->tk != 0) $Ket .= "TK: ".$Rekapitulasi->tk."; &nbsp;";
			if ($Rekapitulasi->dpk_dpb != 0) $Ket .= "DPK/DPB: ".$Rekapitulasi->dpk_dpb."; &nbsp;";
			if ($Rekapitulasi->tb != 0) $Ket .= "TB: ".$Rekapitulasi->tb."; &nbsp;";
			
			$sanksi = get_sanksi($Rekapitulasi->kekurangan);
			if ($sanksi != "") $Ket .= "Sanksi: ".$sanksi."; &nbsp;"; ?>
			
			<tr class="row0">
				<td colspan="4" align="center"><b>T O T A L</b></td>
				<td align="right"><font color="#f00"><b><?php echo $Rekapitulasi->kekurangan ?></b></font></td>
				<td colspan="3"><b><?php echo $Ket ?></b></td>
			</tr><?php
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo count($field)+1 ?>">&nbsp;</td>
		</tr>
	</tfoot>
</table>