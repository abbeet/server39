<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_ikk_kegiatan";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	
switch ( $xlevel )
{
    case '3':
	$oList = mysql_query("select * from $table WHERE ta='$renstra' and kdunitkerja = '$xkdunit' order by kdunitkerja, kdgiat, no_sasaran, no_ikk ");
	break;
    default:
	$oList = mysql_query("select * from $table WHERE ta='$renstra' order by kdunitkerja, kdgiat, no_sasaran, no_ikk ");
	break;
}	
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<?php if ( $xlevel <> '3' ) {?>
<a href="menus/renstra/iku_unit_prn.php?th=<?php echo $th ?>" title="Cetak IKU Satker" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak</font></a><br />
<?php }?>
<strong><?php echo 'Periode Renstra : '.$renstra ?></strong><br>
<table width="710" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="7%" rowspan="2">Satuan Kerja  </th> 
      <th width="12%" rowspan="2">Kegiatan</th>
      <th width="13%" rowspan="2">Sasaran Strategis </th>
      <th width="4%" rowspan="2">No.</th>
      <th width="31%" rowspan="2">Indikator Kinerja</th>
      <th height="28" colspan="5">Target</th>
      <th colspan="3" rowspan="2">Aksi</th>
    </tr>
    <tr>
      <th width="3%" align="center"><?php echo  substr($renstra,0,4) ?></th>
      <th width="3%" align="center"><?php echo  substr($renstra,0,4)+1 ?></th>
      <th width="3%" align="center"><?php echo  substr($renstra,0,4)+2 ?></th>
      <th width="3%" align="center"><?php echo  substr($renstra,0,4)+3 ?></th>
      <th width="10%" align="center"><?php echo  substr($renstra,0,4)+4 ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="13">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if( $col[10][$k] <> $col[10][$k-1] ){  ?><?php echo nm_unit($col[10][$k]) ?><?php } ?></td> 
      <td align="left" valign="top"><?php if( $col[10][$k] <> $col[10][$k-1] or $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo nm_giat($col[2][$k]) ?><?php } ?></td>
      <td align="left" valign="top"><?php if( $col[10][$k] <> $col[10][$k-1] or $col[16][$k] <> $col[16][$k-1] ){  ?><?php echo nm_sasaran($renstra,$col[10][$k],$col[16][$k]) ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[3][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[4][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[5][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[7][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[8][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[9][$k] ?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="5%" align="center" valign="top"><?php if ( $col[10][$k] <> $col[10][$k-1] ) {?><a href="menus/renstra/iku_unit_1_prn.php?th=<?php echo $th ?>&kdunit=<?php echo $col[10][$k] ?>" title="Cetak IKU Satker" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"></a><?php }?></td>
    </tr>
    
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="13">&nbsp;</td>
    </tr>
  </tfoot>
</table>
