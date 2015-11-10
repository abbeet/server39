<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_akun";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = date('Y');
	
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' group by KDSATKER";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['THANG'];
		$col[1][] 	= $Satker['KDSATKER'];
		$col[2][] 	= $Satker['pagu_satker'];
		$jmlh 	   += $Satker['pagu_satker'];
	}


echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<br />
<table width="738" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="6%">No.</th>
		  <th>Kode Satker </th>
		  <th>Nama Satuan Kerja </th>
		  <th>Anggaran</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $k+1; ?></td>
					<td width="7%" align="center"><a href="index.php?p=120&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>" title="Data Detil Kegiatan"><?php echo $col[1][$k] ?></a></td>
					<td width="71%" align="left"><?php echo nm_satker($col[1][$k]) ?></td>
					<td width="16%" align="right"><?php echo number_format($col[2][$k],"0",",",".") ?></td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
	</tfoot>
</table>
