<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
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
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th>Kode APBN</th>
      <th>Nama Satuan Kerja / <br>
        Nama Kegiatan</th>
      <th>Anggaran</th>
      <th colspan="2">Data Detil</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="10">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td width="8%" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="59%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="10%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><?php echo $Giat['KDGIAT'] ?>&nbsp;</td>
      <td align="left" valign="top"><?php echo nm_giat($Giat['KDGIAT']) ?>&nbsp;</td>
      <td align="right" valign="top"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></td>
      <td width="12%" align="center"> <a href="index.php?p=149&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Data DIPA Detil"><font size="1">DIPA 
        Detil >></font></a><br>
        <a href="index.php?p=157&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Data POJ Detil"><font size="1">POK 
        Detil >></font></a>
        </td>
      <td width="11%" align="center"><a href="index.php?p=156&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $col[0][$k] ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Rencana Penarikan Detil"><font size="1">Rencana 
        Penarikan >></font></a></td>
    </tr>
    <?php
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>
