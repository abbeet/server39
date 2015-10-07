<?php
	checkauthentication();
	$p = $_GET['p'];
	$m = $_GET['m']+0;
	$y = $_GET['y'];
	$t = $_GET['t'];
	$q = $_GET['q'];
	$a = $_GET['a'];
	$u = $_GET['u'];
	
	if ($u == "") $u = $_SESSION['unit_kerja'];
	
	$table = "presensi";
	$field = get_field($table);
	
	if ($m == "") $m = date("n");
	if ($y == "") $y = date("Y");
	
	if ($m < 10) $m = "0".$m;
	
	$ed_link = "index.php?p=".get_edit_link($p)."&m=".$m."&y=".$y."&t=".$t."&q=".$q."&a=".$a;
	$del_link = "index.php?p=".get_delete_link($p)."&m=".$m."&y=".$y."&t=".$t."&q=".$q."&a=".$a;
	
	$bln = $y."-".$m;
	
	$oList = absensi_list($u, $q, $bln, $t, $a);
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>

<script language="javascript" src="js/autocombo.js"></script>
<form action="" method="get" name="form">
	<input name="p" type="hidden" value="<?php echo $p ?>">
	<fieldset>
		<table class="admintable" cellspacing="1">
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
			</tr>
		<tr>
			<td class="key">Tanggal</td>
			<td>
				<input name="t" type="text" class="form" id="t" size="10" readonly="1" value=""/>
				<script type="text/javascript">
					Calendar.setup({
						inputField		: "t",
						button			: "a_triggerIMG",
						align			: "BR",
						firstDay		: 1,
						weekNumbers		: false,
						singleClick		: true,
						showOthers		: true,
						ifFormat 		: "%Y-%m-%d"
					});
				</script>
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
					$oPegawai = pegawai_list($u,"nama");
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
			<td class="key">Alasan</td>
			<td>
				<select name="a">
					<option></option><?php
					$oAlasan = alasan();
					while ($Alasan = mysql_fetch_object($oAlasan)) { ?>
						<option value="<?php echo $Alasan->kode ?>" <?php if ($Alasan->kode == $a) echo "selected"; ?>><?php echo $Alasan->keterangan ?></option><?php
					} ?>
				</select>
			</td>
		</tr>
			<tr>
				<td>&nbsp;</td>
				<td>			
					<div class="button2-right">
						<div class="prev">
							<a href="index.php?p=<?php echo $p ?>">Reset</a>
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

<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th width="10%">Tanggal</th>
			<th>Nama</th>
			<th width="20%">Alasan</th>
			<th width="25%">Keterangan</th>
			<th colspan="2" width="6%">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="<?php echo count($field)+2 ?>">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td align="center"><?php echo dmy($col[2][$k]) ?></td>
					<td><?php echo pegawai_id($col[1][$k])->nama ?></td>
					<td><?php echo alasan_id($col[6][$k])->keterangan ?></td>
					<td><?php echo strtoupper($col[7][$k]) ?></td>
					<td align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
					</td>
					<td align="center"><?php
						$oImport = import("","date_until DESC");
						$Import = mysql_fetch_object($oImport);
						if ($col[2][$k] > $Import->date_until) { ?>
							<a href="<?php echo $del[$k] ?>" title="Hapus">
								<img src="css/images/stop_f2.png" border="0" width="16" height="16">
							</a><?php
						}
						else echo "&nbsp;"; ?>
					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo count($field)+2 ?>">&nbsp;</td>
		</tr>
	</tfoot>
</table>