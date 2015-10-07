<?php
	checkauthentication();
	
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$kdsatker = $_REQUEST['kdsatker'];
	$th = $_REQUEST['th'];
	$kdgiat = $_REQUEST['kdgiat'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select sum(JUMLAH) as pagu_giat, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' AND KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDGIAT";
	$aGiat = mysql_query($sql);
	$Giat = mysql_fetch_array($aGiat);

?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
</div><br><br>
<?php			
echo "<strong> Tahun Anggaran : ".$th. "</strong><br>" ;
echo "<strong> Satker : [".$kdsatker."] ".nm_satker($kdsatker). "</strong>" ;
?>
<br />
<table width="407" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th colspan="2" rowspan="2">Nama Kegiatan/ output<br>
        Sub Output / Komponen<br>
        Sub Komponen / Akun</th>
      <th rowspan="2">Anggaran</th>
      <th colspan="12">Bulan Ke</th>
    </tr>
    <tr> 
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
    </tr>
  </thead>
  <tbody>
    <tr class="<?php echo $class ?>"> 
      <td width="10%" align="center"><strong><?php echo $kdgiat ?></strong></td>
      <td colspan="2" align="left"><strong><?php echo nm_giat($kdgiat) ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['jan'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['peb'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['mar'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['apr'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['mei'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['jun'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['jul'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['agt'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['sep'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['okt'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['nop'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['des'],"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#FF0000"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td colspan="2" align="left"><font color="#FF0000"><?php echo nm_output($kdgiat.$Output['KDOUTPUT']) ?>&nbsp;</font></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['jan'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['peb'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['mar'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['apr'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['mei'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['jun'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['jul'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['agt'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['sep'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['okt'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['nop'],"0",",",".") ?></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['des'],"0",",",".") ?></td>
    </tr>
    <?php 
	$sql = "select KDSOUTPUT, sum(JUMLAH) as pagu_soutput, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$Output[KDOUTPUT]' group by KDSOUTPUT";
	$aSOutput = mysql_query($sql);
	while ($SOutput = mysql_fetch_array($aSOutput))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#FF0000"><?php echo $Output['KDOUTPUT'].'.' ?></font><font color="#339900"><?php echo $SOutput['KDSOUTPUT'] ?></font></td>
      <td colspan="2" align="left"><font color="#339900"><?php echo nm_suboutput($kdgiat.$Output['KDOUTPUT'].$SOutput['KDSOUTPUT'],$th) ?>&nbsp;</font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['pagu_soutput'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['jan'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['peb'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['mar'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['apr'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['mei'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['jun'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['jul'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['agt'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['sep'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['okt'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['nop'],"0",",",".") ?></font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['des'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDKMPNEN, sum(JUMLAH) as pagu_kmpnen, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$Output[KDOUTPUT]' and KDSOUTPUT='$SOutput[KDSOUTPUT]' group by KDKMPNEN";
	$aKmpnen = mysql_query($sql);
	while ($Kmpnen = mysql_fetch_array($aKmpnen))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#3333FF"><?php echo $Kmpnen['KDKMPNEN'] ?></font></td>
      <td colspan="2" align="left"><font color="#3333FF"><?php echo nm_kmpnen($kdgiat.$Output['KDOUTPUT'].$SOutput['KDSOUTPUT'].$Kmpnen['KDKMPNEN'],$th) ?>&nbsp;</font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['pagu_kmpnen'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['jan'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['peb'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['mar'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['apr'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['mei'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['jun'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['jul'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['agt'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['sep'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['okt'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['nop'],"0",",",".") ?></font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['des'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDSKMPNEN, sum(JUMLAH) as pagu_skmpnen, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$Output[KDOUTPUT]' and KDSOUTPUT='$SOutput[KDSOUTPUT]' and KDKMPNEN='$Kmpnen[KDKMPNEN]' group by KDSKMPNEN";
	$aSKmpnen = mysql_query($sql);
	while ($SKmpnen = mysql_fetch_array($aSKmpnen))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#3333FF"><?php echo $Kmpnen['KDKMPNEN'].'.' ?></font><font color="#660066"><?php echo $SKmpnen['KDSKMPNEN'] ?></font></td>
      <td colspan="2" align="left"><font color="#660066"><?php echo nm_skmpnen($kdgiat.$Output['KDOUTPUT'].$SOutput['KDSOUTPUT'].$Kmpnen['KDKMPNEN'].$SKmpnen['KDSKMPNEN'],$th) ?>&nbsp;</font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['pagu_skmpnen'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['jan'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['peb'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['mar'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['apr'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['mei'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['jun'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['jul'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['agt'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['sep'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['okt'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['nop'],"0",",",".") ?></font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['des'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDAKUN, sum(JUMLAH) as pagu_akun, sum(JANUARI) as jan, sum(PEBRUARI) as peb, sum(MARET) as mar, sum(APRIL) as apr, sum(MEI) as mei,
			sum(JUNI) as jun, sum(JULI) as jul, sum(AGUSTUS) as agt, sum(SEPTEMBER) as sep, sum(OKTOBER) as okt, sum(NOPEMBER) as nop,
			sum(DESEMBER) as des from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$Output[KDOUTPUT]' and KDSOUTPUT='$SOutput[KDSOUTPUT]' and KDKMPNEN='$Kmpnen[KDKMPNEN]' and KDSKMPNEN='$SKmpnen[KDSKMPNEN]' group by KDAKUN";
	$aAkun = mysql_query($sql);
	while ($Akun = mysql_fetch_array($aAkun))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center">&nbsp;</td>
      <td width="6%" align="center"><?php echo $Akun['KDAKUN'] ?>&nbsp;</td>
      <td width="48%" align="left"><?php echo nm_akun($Akun['KDAKUN']) ?>&nbsp;</td>
      <td align="right"><?php echo number_format($Akun['pagu_akun'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['jan'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['peb'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['mar'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['apr'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['mei'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['jun'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['jul'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['agt'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['sep'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['okt'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['nop'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['des'],"0",",",".") ?></td>
    </tr>
    <?php
		} # AKUN
		} # SUB KMPNEN
		} # KMPNEN
		} # SUB OUTPUT
		} # OUTPUT
	?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="18">&nbsp;</td>
    </tr>
  </tfoot>
</table>
