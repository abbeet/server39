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
	$table = "d_trktrm";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select * from $table WHERE THANG='$th' AND KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDGIAT";
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
      <th colspan="2" rowspan="2">Nama Kegiatan</th>
      <th rowspan="2">Anggaran</th>
      <th colspan="13">Rencana Penarikan Bulan Ke</th>
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
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <tr class="<?php echo $class ?>"> 
      <td width="10%" align="center"><strong><?php echo $kdgiat ?></strong></td>
      <td colspan="2" align="left"><strong><?php echo nm_giat($kdgiat) ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['RPHPAGU'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML01'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML02'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML03'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML04'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML05'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML06'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML07'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML08'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML09'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML10'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML11'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML12'],"0",",",".") ?></strong></td>
      <td width="36%" align="right"><strong><?php echo number_format($Giat['JML01']+
	  																 $Giat['JML02']+
	  																 $Giat['JML03']+
	  																 $Giat['JML04']+
	  																 $Giat['JML05']+
	  																 $Giat['JML06']+
	  																 $Giat['JML07']+
	  																 $Giat['JML08']+
	  																 $Giat['JML09']+
	  																 $Giat['JML10']+
	  																 $Giat['JML11']+
	  																 $Giat['JML12'],"0",",",".") ?></strong></td>
    </tr>
	<?php 
		$sql = "select JNSBELANJA, sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML01,
					sum(JML02) as JML02,
					sum(JML03) as JML03,
					sum(JML04) as JML04,
					sum(JML05) as JML05,
					sum(JML06) as JML06,
					sum(JML07) as JML07,
					sum(JML08) as JML08,
					sum(JML09) as JML09,
					sum(JML10) as JML10,
					sum(JML11) as JML11,
					sum(JML12) as JML12
					from $table WHERE THANG='$th' AND KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by JNSBELANJA";
	$aTarik = mysql_query($sql);
	while($Tarik = mysql_fetch_array($aTarik))
	{
	?>
    <tr class="<?php echo $class ?>">
      <td align="center">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo $Tarik['JNSBELANJA'] ?></font></td>
      <td colspan="2" align="left">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo nm_jnsbelanja($Tarik['JNSBELANJA']) ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['RPHPAGU'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML01'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML02'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML03'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML04'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML05'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML06'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML07'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML08'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML09'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML10'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML11'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML12'],"0",",",".") ?></font></td>
      <td align="right">
	  <?php switch ( $Tarik['JNSBELANJA'] )
	  {
	  		case '51': ?>
			<font color='#FF0000'>
			<?php 
			break;
			case '52':?>
			<font color='#009966'>
			<?php 
			break;
			case '53':?>
			<font color='#0000FF'>
			<?php 
			break;
		}?>
	  <?php echo number_format($Tarik['JML01']+
	  																 $Tarik['JML02']+
	  																 $Tarik['JML03']+
	  																 $Tarik['JML04']+
	  																 $Tarik['JML05']+
	  																 $Tarik['JML06']+
	  																 $Tarik['JML07']+
	  																 $Tarik['JML08']+
	  																 $Tarik['JML09']+
	  																 $Tarik['JML10']+
	  																 $Tarik['JML11']+
	  																 $Tarik['JML12'],"0",",",".") ?></font></td>
    </tr>
	<?php } ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="19">&nbsp;</td>
    </tr>
  </tfoot>
</table>
