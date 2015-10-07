<?php
	checkauthentication();
	$kdjab = $_REQUEST['kdjab'];
	$table = "t_bantu";
	$table_bantu = "t_kelompok";
	$kdjenjang = substr($kdjab,3,2);
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$cari = $_REQUEST['cari'];
	$pagess = $_REQUEST['pagess'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
?>	
<?php
$sql = "SELECT * FROM $table WHERE kdjab = '$kdjab' ORDER BY kdkelompok,kditem";
$aTabelBantu = mysql_query($sql);
$count = mysql_num_rows($aTabelBantu);
	
while ($TabelBantu = mysql_fetch_array($aTabelBantu))
{
	$col[0][] = $TabelBantu['id'];
	$col[1][] = $TabelBantu['kdkelompok'];
	$col[3][] = $TabelBantu['kditem'];
	$col[4][] = $TabelBantu['nmitem'];
	$col[5][] = $TabelBantu['angka_kredit'];
	$col[6][] = $TabelBantu['satuan'];
	$col[7][] = $TabelBantu['min_target'];
	$col[8][] = $TabelBantu['mak_target'];
}
?>
<div class="button2-right">
<div class="prev">
<a onclick="Back('index.php?p=236&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>
</div>
</div><br /><br />
<font color="#990000" size="3"><strong><?php echo 'Jabatan : '. nm_jabatan_ij($kdjab) ?></strong></font><br />
<table width="73%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%" rowspan="2">No. Urut</th>
			<th width="21%" rowspan="2">Kelompok Kegiatan</th>
			<th width="6%" rowspan="2">Kode</th>
			<th width="28%" rowspan="2">Item Kegiatan </th>
			<th width="7%" rowspan="2">Angka<br />Kredit</th>
			<th width="10%" rowspan="2">Satuan</th>
			<th colspan="2">Target</th>
		</tr>
		<tr>
		  <th width="10%">Minimum</th>
	      <th width="11%">Maksimum</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php if ( $col[1][$k] <> $col[1][$k-1] ) {?><?php echo nmromawi($col[1][$k]) ?><?php }?></td>
					<td align="left"><?php if ( $col[1][$k] <> $col[1][$k-1] ) {?><?php echo nm_kelompok_bantu($kdjab,$col[1][$k]) ?><?php }?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="center"><?php echo $col[5][$k] ?></td>
					<td align="center"><?php echo $col[6][$k] ?></td>
					<td align="center"><?php echo $col[7][$k] ?></td>
					<td align="center"><?php if ( $col[8][$k] == -1 ) {?><?php echo 'Tidak ada batasan'; ?><?php }else{ ?><?php echo $col[8][$k] ?><?php }?></td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
	</tfoot>
</table>
