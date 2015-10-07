<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "setup_dept";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select KDDEPT, KDUNIT from $table ";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['KDDEPT'];
		$col[1][] 	= nm_dept($Dept['KDDEPT']);
		$col[2][] 	= $Dept['KDUNIT'];
	}

?>
<table width="526" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th>Kode APBN</th>
      <th>Kepenterian / Program / Satuan Kerja</th>
      <th>Kegiatan / Output</th>
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
      <td width="9%" align="center"><strong><?php echo $col[0][$k].'.'.$col[2][$k] ?></strong></td>
      <td width="73%" align="left"><strong><?php echo  $col[1][$k] ?></strong></td>
      <td width="18%" align="left">&nbsp;</td>
    </tr>
    <?php 
	$kddept = $col[0][$k] ;
	$kdunit = $col[2][$k] ;
	$sql = "select KDPROGRAM,NMPROGRAM from t_program WHERE KDDEPT='$kddept' and KDUNIT='$kdunit' order by KDPROGRAM";
	$aProg = mysql_query($sql);
	while ($Prog = mysql_fetch_array($aProg))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><?php echo $kddept.'.'.$kdunit.'.'.$Prog['KDPROGRAM'] ?>&nbsp;</td>
      <td align="left" valign="top"><?php echo  $Prog['NMPROGRAM'] ?>&nbsp;</td>
      <td align="center" valign="top"><a href="index.php?p=163&kddept=<?php echo $kddept ?>&kdunit=<?php echo $kdunit ?>&kdprogram=<?php echo $Prog['KDPROGRAM'] ?>" title="Kegiatan dan Output"><font size="2">Kegiatan/Output>></font></a></td>
    </tr>
    <?php 
	$kdprogram = $Prog['KDPROGRAM'] ;
	$sql = "select KDSATKER,NMSATKER from t_satker WHERE KDDEPT='$kddept' and KDUNIT='$kdunit' order by KDSATKER";
	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><?php echo $Satker['KDSATKER'] ?></td>
      <td align="left" valign="top"><?php echo $Satker['NMSATKER'] ?></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <?php
		} # SATKER
		} # PROGRAM
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>
