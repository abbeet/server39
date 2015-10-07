<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'] ;
	
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' and LEFT(KDAKUN,2) = '53' group by KDSATKER";
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
?>

<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th>Kode APBN</th>
      <th colspan="2">Nama Satuan Kerja / <br>
        Nama Kegiatan</th>
      <th>Anggaran</th>
      <th>Data Detil </th>
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
      <td width="14%" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td colspan="2" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="16%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="16%" align="right">&nbsp;</td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and LEFT(KDAKUN,2) = '53' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat = $Giat['KDGIAT'] ;
    ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><?php echo $Giat['KDGIAT'] ?></td>
      <td colspan="2" align="left" valign="top"><?php echo nm_giat($Giat['KDGIAT']) ?></td>
      <td align="right" valign="top"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$kdgiat'  and LEFT(KDAKUN,2) = '53' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$kdoutput = $Output['KDOUTPUT'];
    ?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top">&nbsp;</td>
      <td width="5%" align="center" valign="top"><?php echo $kdoutput ?></td>
      <td width="65%" align="left" valign="top"><?php echo nm_output($kdgiat.$kdoutput) ?></td>
      <td align="right" valign="top"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></td>
      <td align="center" valign="top"> <a href="index.php?p=231&th=<?php echo $th ?>&kdsatker=<?php echo $kdsatker ?>&kdgiat=<?php echo $kdgiat ?>&kdoutput=<?php echo $kdoutput ?>" title="Anggaran Detil Belanja Modal Output">Detil>></a> </td>
    </tr>
    <?php
		} # OUTPUT
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
