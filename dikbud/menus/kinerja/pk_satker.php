<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "dt_pk";
	$field = array("id","th","kdunitkerja","no_sasaran","nourut_pk","indikator","target","no_iku","anggaran");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	$xlevel = $_SESSION['xlevel'];
	$th = $_SESSION['xth'];
	if ( $xlevel <> '6'  )
	{
		if ( $_REQUEST['xkdunit'] <> '' )    
		   {
		      $xkdunit = $_REQUEST['xkdunit'];
			}else{
			  $xkdunit = $_SESSION['xkdunit'];
			}
	}
	
	
if (isset($_POST["cari"]))
{
   $xkdunit = $_REQUEST['kdunit'];
}
	
	$oList = mysql_query("select * from $table WHERE th = '$th' and kdunitkerja = '$xkdunit' order by kdunitkerja,no_sasaran,nourut_pk");
	
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<?php if ( $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 ) {?>
<div align="right">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Satker Mandiri: 
		<select name="kdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  nm_unit($xkdunit) ?></option>
                      <option value="">- Pilih Satker Mandiri -</option>
                    <?php
	switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select * from tb_unitkerja where kdunit > '2320600' and kdsatker <> '' order by kdunit");
			break;
		case '3':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '4':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '5':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '8':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		default:
			$query = mysql_query("select * from tb_unitkerja where kdunit > '2320600' and kdsatker <> '' order by kdunit");
			break;
	}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['nmunit']); ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div> 
<?php }?><br>
<!--a href="menus/PK/pk_unit_prn.php?th=<?php echo $th ?>&kdunit=<?php echo $xkdunit ?>" title="Cetak PK Unit Kerja" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak Format 1 </font></a>&nbsp;&nbsp;
<a href="menus/PK/pk_unit_1_prn.php?th=<?php echo $th ?>&kdunit=<?php echo $xkdunit ?>" title="Cetak PK Unit Kerja" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak Format 2 </font></a>&nbsp;&nbsp;
<br /-->
<table width="652" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="14%">Eselon II </th> 
      <th width="25%">Sasaran Strategis</th>
      <th width="4%">No.</th>
      <th width="24%">Indikator</th>
      <th width="9%">Target</th>
      <th width="12%">Anggaran</th>
      <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="8">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo nm_unit($col[2][$k]) ?><?php } ?></td> 
      <td align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){  ?><?php echo nm_sasaran($col[1][$k],$col[2][$k],$col[3][$k]) ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[4][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[5][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="right" valign="top"><?php echo number_format($col[8][$k],"0",",",".") ?></td>
      <td width="4%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="8%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>

