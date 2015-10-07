<?php
	checkauthentication();
	
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$sw = $_REQUEST['sw'];
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];

	$th = date('Y');
	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept from $table WHERE THANG='$th' group by KDDEPT";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept'];
	}

echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<style type="text/css">
<!--
.style1 {color: #006633}
.style2 {color: #0066FF}
-->
</style>

<br />
<table width="741" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th>Kode APBN</th>
      <th>Nama Satuan Kerja / <br>
        Nama Kegiatan /<br />
		Output</th>
      <th>Pagu<br>
        Anggaran</th>
      <th>Unit Kerja</th>
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
      <td align="center"><strong><?php echo $kddept.'.'.$kdunit ?></strong></td>
      <td align="left"><strong><?php echo nm_unit(substr($kddept,1,2).'0000') ?></strong></td>
      <td width="11%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="15%" align="right">&nbsp;</td>
    </tr>
    
    <?php 
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' and KDDEPT='042' group by KDSATKER order by KDSATKER";
	
	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	$kdsatker = $Satker['KDSATKER'] ;
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="12%" align="center"><font color="#FF0000"><?php echo $kdsatker ?></font></td>
      <td width="62%" align="left"><font color="#FF0000"><?php echo nm_satker($kdsatker) ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Satker['pagu_satker'],"0",",",".") ?></font></td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <?php 
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat =  $Giat['KDGIAT'] ;
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><span class="style1"><?php echo $Giat['KDGIAT'] ?></span></td>
      <td align="left" valign="top"><span class="style1"><?php echo nm_giat($Giat['KDGIAT']) ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></span></td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDOUTPUT order by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$kdoutput =  $Output['KDOUTPUT'] ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><span class="style2"><?php echo $kdoutput?></span></td>
      <td align="left" valign="top"><span class="style2"><?php echo nm_output($kdgiat.$kdoutput) ?></span></td>
      <td align="right" valign="top"><span class="style2"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></span></td>
      <td align="left" valign="top"><?php echo ket_unit_output($th,$kdgiat,$kdoutput) ?>&nbsp;</td>
    </tr>
    
    <?php
		} # OUTPUT
		} # GIAT
		} # SATKER
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="9">&nbsp;</td>
    </tr>
  </tfoot>
</table>
