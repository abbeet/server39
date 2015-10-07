<?php
	checkauthentication();
	$p = $_GET['p'];
	$y = $_GET['y'];
	$s = $_GET['s'];
	
	if ($y == "") $y = date("Y");
	
	$table = "libur";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p)."&s=".$s."&y=".$y;
	$del_link = "index.php?p=".get_delete_link($p)."&s=".$s."&y=".$y;
	
	$oList = libur_list($y,$s);
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>
<form action="" method="get" name="form">
	<input name="p" type="hidden" value="<?php echo $p ?>">
	<fieldset>
		<table class="admintable" cellspacing="1">
			<tr>
				<td class="key">Libur/Cuti Bersama</td>
				<td>
					<select name="s">
						<option value=""></option>
						<option value="L" <?php if ($s == "L") echo "selected" ?>>Libur</option>
						<option value="C" <?php if ($s == "C") echo "selected" ?>>Cuti Bersama</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="key">Tahun</td>
				<td>
					<select name="y">
						<option value=""></option><?php
						for ($i=$y-10; $i<=$y+10; $i++) { ?>
							<option value="<?php echo $i ?>" <?php if ($i == $y) echo "selected" ?>><?php echo $i ?></option><?php
						} ?>
					</select>
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
			<th width="10%">Tanggal</th>
			<th>Keterangan</th>
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
					<td align="center"><?php echo dmy($col[1][$k]) ?></td>
					<td><?php echo $col[2][$k] ?></td>
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
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?php echo count($field)+2 ?>">&nbsp;</td>
		</tr>
	</tfoot>
</table>