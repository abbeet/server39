<?php
	checkauthentication();
	
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$pagess = $_REQUEST['pagess'];
	$p = $_GET['p'];
	$th = $_REQUEST['th'];
	$kdgiat = $_REQUEST['kdgiat'];
	$kdoutput = $_REQUEST['kdoutput'];
	$kdsatker = $_REQUEST['kdsatker'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$oList_kak_output = mysql_query("SELECT kdunitkerja FROM thbp_kak_output WHERE th = '$th' and kdsatker = '$kdsatker' AND kdgiat = '$kdgiat' and kdoutput = '$kdoutput' ");
	$List_kak_output = mysql_fetch_array($oList_kak_output);

?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>')">Kembali</a></div>
</div><br><br>
<?php			
echo "<strong> Tahun Anggaran : ".$th. "</strong><br>" ;
echo "<strong> Unit Kerja : [".$List_kak_output['kdunitkerja'].'] '.nm_unit($List_kak_output['kdunitkerja']) . "</strong><br>" ;
echo "<strong> Satker : [".$kdsatker.'] '.nm_satker($kdsatker) . "</strong><br>" ;
echo "<strong> Kegiatan : [".$kdgiat.'] '.nm_giat($kdgiat). "</strong>" ;
?>
<br />
<table width="738" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="10%">Kode APBN</th>
      <th colspan="4">Ooutput / Sub Output <br>
        Komponen / Sub Komponen <br>
        Akun / Uraian </th>
      <th width="14%">Anggaran</th>
    </tr>
  </thead>
  <tbody>
    
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output from $table WHERE THANG='$th' and kdsatker = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	$Output = mysql_fetch_array($aOutput);
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#FF0000"><?php echo $kdoutput ?></font></td>
      <td colspan="4" align="left"><font color="#FF0000"><?php echo nm_output($kdgiat.$kdoutput) ?>&nbsp;</font></td>
      <td align="right"><font color="#FF0000"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDSOUTPUT, sum(JUMLAH) as pagu_soutput from $table WHERE THANG='$th' and kdsatker = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' group by KDSOUTPUT";
	$aSOutput = mysql_query($sql);
	while ($SOutput = mysql_fetch_array($aSOutput))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#FF0000"><?php echo $kdoutput.'.' ?></font><font color="#339900"><?php echo $SOutput['KDSOUTPUT'] ?></font></td>
      <td colspan="4" align="left"><font color="#339900"><?php echo nm_suboutput($kdgiat.$kdoutput.$SOutput['KDSOUTPUT'],$th) ?>&nbsp;</font></td>
      <td align="right"><font color="#339900"><?php echo number_format($SOutput['pagu_soutput'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDKMPNEN, sum(JUMLAH) as pagu_kmpnen from $table WHERE THANG='$th' and kdsatker = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$SOutput[KDSOUTPUT]' group by KDKMPNEN";
	$aKmpnen = mysql_query($sql);
	while ($Kmpnen = mysql_fetch_array($aKmpnen))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#3333FF"><?php echo $Kmpnen['KDKMPNEN'] ?></font></td>
      <td colspan="4" align="left"><font color="#3333FF"><?php echo nm_kmpnen($kdgiat.$kdoutput.$SOutput['KDSOUTPUT'].$Kmpnen['KDKMPNEN'],$th) ?>&nbsp;</font></td>
      <td align="right"><font color="#3333FF"><?php echo number_format($Kmpnen['pagu_kmpnen'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDSKMPNEN, sum(JUMLAH) as pagu_skmpnen from $table WHERE THANG='$th' and kdsatker = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$SOutput[KDSOUTPUT]' and KDKMPNEN='$Kmpnen[KDKMPNEN]' group by KDSKMPNEN";
	$aSKmpnen = mysql_query($sql);
	while ($SKmpnen = mysql_fetch_array($aSKmpnen))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#3333FF"><?php echo $Kmpnen['KDKMPNEN'].'.' ?></font><font color="#660066"><?php echo $SKmpnen['KDSKMPNEN'] ?></font></td>
      <td colspan="4" align="left"><font color="#660066"><?php echo nm_skmpnen($kdgiat.$kdoutput.$SOutput['KDSOUTPUT'].$Kmpnen['KDKMPNEN'].$SKmpnen['KDSKMPNEN'],$th) ?>&nbsp;</font></td>
      <td align="right"><font color="#660066"><?php echo number_format($SKmpnen['pagu_skmpnen'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDAKUN, sum(JUMLAH) as pagu_akun from $table WHERE THANG='$th' and kdsatker = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$SOutput[KDSOUTPUT]' and KDKMPNEN='$Kmpnen[KDKMPNEN]' and KDSKMPNEN='$SKmpnen[KDSKMPNEN]' group by KDAKUN order by KDAKUN";
	$aAkun = mysql_query($sql);
	while ($Akun = mysql_fetch_array($aAkun))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center">&nbsp;</td>
      <td width="6%" align="center"><strong><?php echo $Akun['KDAKUN'] ?></strong></td>
      <td colspan="3" align="left"><strong><?php echo nm_akun($Akun['KDAKUN']) ?></strong></td>
      <td align="right"><strong><?php echo number_format($Akun['pagu_akun'],"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$sql = "select NMITEM, JUMLAH, VOLKEG,HARGASAT,SATKEG from $table WHERE THANG='$th' and kdsatker = '$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$SOutput[KDSOUTPUT]' and KDKMPNEN='$Kmpnen[KDKMPNEN]' and KDSKMPNEN='$SKmpnen[KDSKMPNEN]' and KDAKUN = '$Akun[KDAKUN]'";
	$aItem = mysql_query($sql);
	while ($Item = mysql_fetch_array($aItem))
	{
	?>
    <tr class="<?php echo $class ?>">
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td width="44%" align="left"><?php echo $Item['NMITEM'] ?>&nbsp;</td>
      <td width="13%" align="center"><?php if( $Item['VOLKEG'] <> 0 ){?><?php echo $Item['VOLKEG'].' '.$Item['SATKEG'] ?><?php }?>&nbsp;</td>
      <td width="13%" align="right"><?php if( $Item['HARGASAT'] <> 0 ){?><?php echo number_format($Item['HARGASAT'],"0",",",".") ?><?php }?>&nbsp;</td>
      <td align="right"><?php if( $Item['JUMLAH'] <> 0 ){?><?php echo number_format($Item['JUMLAH'],"0",",",".") ?><?php }else{?>&nbsp;<?php }?></td>
    </tr>
    <?php
		} # ITEM
		} # AKUN
		} # SUB KMPNEN
		} # KMPNEN
		} # SUB OUTPUT
	?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>
