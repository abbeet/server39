<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$table = "m_spmmak";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'];
	
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(NILMAK) as real_satker from $table WHERE THANG='$th' AND left(KDAKUN,2) = '53' group by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(NILMAK) as real_satker from $table WHERE THANG='$th' AND KDSATKER = '$xusername' AND left(KDAKUN,2) = '53' group by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(NILMAK) as real_satker from $table WHERE THANG='$th' AND left(KDAKUN,2) = '53' group by KDSATKER";
			break;
	}

	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['THANG'];
		$col[1][] 	= $Satker['KDSATKER'];
		$col[2][] 	= $Satker['real_satker'];
		$jmlh 	   += $Satker['real_satker'];
	}


echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<br />
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th>Kode APBN</th>
      <th>Nama Satuan Kerja</th>
      <th>Realisasi<br />Anggaran</th>
      <th width="14%">Realisasi<br />Detil</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="9">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$kdsatker = $col[1][$k] ;
				?>
    <tr class="<?php echo $class ?>"> 
      <td width="7%" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="67%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td align="center"> <a href="index.php?p=232&th=<?php echo $th ?>&kdsatker=<?php echo $kdsatker ?>" title="Realisasi Belanja Modal Satker">Detil>></a></td>
    </tr>
    <?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
