<?php
	checkauthentication();
	
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;

	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$kddept 	= $_REQUEST['kddept'];
	$kdunit 	= $_REQUEST['kdunit'];
	$kdprogram  = $_REQUEST['kdprogram'];
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select KDPROGRAM,NMPROGRAM from t_program WHERE KDDEPT='$kddept' and KDUNIT='$kdunit' and KDPROGRAM='$kdprogram'";
	$aProgram = mysql_query($sql);
	$Program = mysql_fetch_array($aProgram);

?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
</div><br><br>
<table width="738" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th>Kode APBN</th>
      <th>Nama Kegiatan/ output</th>
      <th>Satuan</th>
    </tr>
  </thead>
  <tbody>
    <tr class="<?php echo $class ?>"> 
      <td width="15%" align="center"><strong><?php echo $kddept.'.'.$kdunit.'.'.$kdprogram ?></strong></td>
      <td colspan="2" align="left"><strong><?php echo $Program['NMPROGRAM'] ?></strong></td>
    </tr>
    <?php 
	$sql = "select KdGiat,NmGiat from t_giat WHERE KDDEPT='$kddept' and KDUNIT='$kdunit' and KDPROGRAM='$kdprogram' order by KdGiat";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#FF0000"><?php echo $Giat['KdGiat'] ?></font></td>
      <td colspan="2" align="left"><font color="#FF0000"><?php echo $Giat['NmGiat'] ?>&nbsp;</font></td>
    </tr>
    <?php 
	$kdgiat = $Giat['KdGiat'] ;
	$sql = "select KDOUTPUT, NMOUTPUT, SAT from t_output WHERE KDGIAT='$kdgiat' order by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	if(strlen( $Output['KDOUTPUT'] ) == 3 and substr(  $Output['KDOUTPUT'],0,1 ) =='0' ){
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><font color="#339900"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td width="67%" align="left"><font color="#339900"><?php echo $Output['NMOUTPUT'] ?></font></td>
      <td width="18%" align="left"><font color="#339900"><?php echo $Output['SAT'] ?></font></td>
    </tr>
    <?php
	}
		} # OUTPUT
		} # GIAT
	?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
