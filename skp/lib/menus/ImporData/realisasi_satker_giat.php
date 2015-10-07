<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$table = "m_spmind";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = date('Y');
	
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(TOTNILMAK) as real_satker from $table WHERE THANG='$th' AND KDGIAT<>'0000' group by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(TOTNILMAK) as real_satker from $table WHERE THANG='$th' AND KDSATKER = '$xusername' AND KDGIAT<>'0000' group by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(TOTNILMAK) as real_satker from $table WHERE THANG='$th' AND KDGIAT<>'0000' group by KDSATKER";
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
      <th>Nama Satuan Kerja / <br>
        Nama Kegiatan</th>
      <th>Anggaran</th>
      <th width="18%">Data Detil</th>
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
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td width="7%" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="68%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="7%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td align="right">&nbsp;</td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(TOTNILMAK) as real_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT<>'0000' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><?php echo $Giat['KDGIAT'] ?>&nbsp;</td>
      <td align="left" valign="top"><?php echo nm_giat($Giat['KDGIAT']) ?>&nbsp;</td>
      <td align="right" valign="top"><?php echo number_format($Giat['real_giat'],"0",",",".") ?></td>
      <td align="center"> <a href="index.php?p=155&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Data DIPA Detil"><font size="1">Realisasi</font><font size="1"> 
        Detil >></font></a> </td>
    </tr>
    <?php
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
