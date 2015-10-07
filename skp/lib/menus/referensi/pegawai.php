<?php
	checkauthentication();
	$p = $_GET['p'];
	$u = $_GET['u'];
	$b = $_GET['b'];
	$subbidang = $_GET['subbidang'];
	
	if ($u == "") $u = $_SESSION['unit_kerja'];
	if ($b == "") $b = $u."0";
	if ($subbidang == "") $subbidang = $b."0";
	
	if (substr($subbidang,2,2) == "00") $bidang = $u;
	else if (substr($subbidang,3,1) == "0") $bidang = $b;
	else $bidang = $subbidang;
	
	$table = "pegawai";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p)."&u=".$u."&b=".$b."&subbidang=".$subbidang;
	$del_link = "index.php?p=".get_delete_link($p)."&u=".$u."&b=".$b."&subbidang=".$subbidang;
	
	$oList = pegawai_list($bidang,"kode_bidang,status_jab DESC,nip");
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
		<table class="admintable" cellspacing="1"><?php
			if ($_SESSION['unit_kerja'] == '12') { ?>
				<tr>
					<td class="key">Unit Kerja</td>
					<td>
						<select name="u" id="u" onchange="get_bidang(u.value)"><?php
							$oUnit = unit_kantor_pusat();
							while ($Unit = mysql_fetch_object($oUnit)) { ?>
								<option value="<?php echo substr($Unit->kode,0,2) ?>" <?php if (substr($Unit->kode,0,2) == $u) echo "selected" ?>><?php echo $Unit->nama ?></option><?php
							} ?>
						</select>
					</td>
				</tr><?php
			} ?>
			<tr>
				<td class="key">Bidang</td>
				<td>
					<div id="bidang-view"><?php
						$oBidang = bidang_list($u);
						$num = mysql_num_rows($oBidang);
						if ($num != 0) {	?>	
							<select name="b" onchange="get_subbidang(b.value)">
								<option value="">Semua Bidang</option><?php
								while ($Bidang = mysql_fetch_object($oBidang)) { ?>
									<option value="<?php echo substr($Bidang->kode,0,3) ?>" <?php if (substr($Bidang->kode,0,3) == $b) echo "selected" ?>><?php echo $Bidang->nama ?></option><?php
								} ?>
							</select><?php
						} ?>
					</div>
				</td>
			</tr>
			<tr>
				<td class="key">Sub Bidang</td>
				<td>
					<div id="subbidang-view"><?php
						$oSubBidang = subbidang_list($b);
						$num = mysql_num_rows($oSubBidang);
						if ($num != 0) {	?>	
							<select name="subbidang">
								<option value="">Semua Sub Bidang</option><?php
								while ($SubBidang = mysql_fetch_object($oSubBidang)) { ?>
									<option value="<?php echo $SubBidang->kode ?>" <?php if ($SubBidang->kode == $subbidang) echo "selected" ?>><?php echo $SubBidang->nama ?></option><?php
								} ?>
							</select><?php
						} ?>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
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
			<th width="10%">NIP</th>
			<th width="15%">NIP Baru</th>
			<th>Nama</th>
			<th width="8%">Golongan</th>
			<th width="20%">Jabatan</th>
			<th width="15%">Status</th>
			<th colspan="2" width="6%">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="<?php echo count($field)+1 ?>">Tidak ada data!</td></tr><?php
		}
		else {
			$bid = $u.'0';
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1";
				
				if (substr($col[5][$k],0,3) != $bid) { ?>
					<tr class="row3">
						<td align="center" colspan="<?php echo count($field)+1 ?>"><b><?php echo bidang_id(substr($col[5][$k],0,3))->nama ?></b></td>
					</tr><?php					
				} ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1 ?></td>
					<td align="center"><?php echo $val ?></td>
					<td align="center"><?php echo format_nip_baru($col[7][$k]) ?></td>
					<td><?php echo $col[1][$k] ?></td>
					<td align="center"><?php echo golongan_id($col[2][$k])->NmGol1 ?></td>
					<td><?php echo $col[3][$k] ?></td>
					<td><?php echo status_id($col[6][$k])->nama; ?></td>
					<td align="center">
						<a href="<?php echo $ed[$k] ?>" title="Ubah">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
					</td>
					<td align="center">
						<a href="<?php echo $del[$k] ?>" title="Hapus">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">
						</a>
					</td>
				</tr><?php
				$bid = substr($col[5][$k],0,3);
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo count($field)+1 ?>">&nbsp;</td>
		</tr>
	</tfoot>
</table>