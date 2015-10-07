<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_pk";
	$field = array("id","th","kdunitkerja","no_pk","nm_pk","target","rencana_1","rencana_2","rencana_3","rencana_4","aksi_1","aksi_2","aksi_3","aksi_4");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
//	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
//	if ( $_REQUEST['$xkdunit'] == '' )    $xkdunit = $_SESSION['xkdunit'];
//	else    $xkdunit = $_REQUEST['xkdunit'];
	$renstra = th_renstra($th);
	$xkdsatker = satker_th_unit($th,$xkdunit);

if ( $_REQUEST['xkdunit'] == '' )
{
	$xkdunit = $_SESSION['xkdunit'];
}else{
     $xkdunit = $_REQUEST['xkdunit'];
}

if ( $_REQUEST['cari_unit'] )
{
     $xkdunit = $_REQUEST['xkdunit'];
}	
	$xkdunit = substr($xkdunit,0,3).'000' ;

	$oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_pk");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>
<div align="right">
	<form action="index.php?p=<?php echo $p?>&xkdunit=<?php echo $xkdunit ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Eselon I : 
		<select name="xkdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  substr(ket_unit(substr($xkdunit,0,3).'000'),0,60) ?></option>
                      <option value="">- Eselon I -</option>
                    <?php
			switch ( $xlevel )
			{
					case '4':
					$query = mysql_query("select ket_unit_kerja, kdunit from tb_unitkerja WHERE kdunit = '$xkdunit' group by kdunit order by kdunit");
					break;
					default:
					$query = mysql_query("select ket_unit_kerja, kdunit from tb_unitkerja WHERE right(kdunit,3) = '000' and left(kdunit,3) <> '820' group by kdunit order by kdunit");
					break;
			}
					while( $row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['ket_unit_kerja']); ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari_unit"/>
	</form>
</div>
<a href="menus/kinerja/penetapan_aksiPK_unit_prn.php?th=<?php echo $th ?>&kdunit=<?php echo $xkdunit ?>" title="Cetak Rencana Aksi PK Satker" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak</font></a><br />
<table width="767" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="5%" rowspan="3">Eselon I</th>
      <th width="5%" height="28" rowspan="3">No.</th>
      <th width="16%" rowspan="3">Indikator Kinerja Utama </th>
      <th width="6%" rowspan="3">Target</th>
      <th colspan="8">Rencana Aksi Triwulan</th>
      <th rowspan="3">Aksi</th>
    </tr>
    <tr>
      <th colspan="2">Triwulan I</th>
      <th colspan="2">Triwulan II</th>
      <th colspan="2">Triwulan III </th>
      <th colspan="2">Triwulan IV</th>
    </tr>
    <tr>
      <th width="4%">%</th>
      <th width="11%">Uraian</th>
      <th width="5%">%</th>
      <th width="12%">Uraian</th>
      <th width="5%">%</th>
      <th width="13%">Uraian</th>
      <th width="5%">%</th>
      <th width="12%">Uraian</th>
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
      <td align="left" valign="top"><?php if ( $col[2][$k] <> $col[2][$k-1] ) {?><?php echo nm_unit($col[2][$k]) ?><?php }?></td>
      <td align="center" valign="top"><?php echo $col[3][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[4][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[5][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[10][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[7][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[11][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[8][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[12][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[9][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[13][$k] ?></td>
      <td width="6%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>" title="Edit Rencana Aksi"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
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
