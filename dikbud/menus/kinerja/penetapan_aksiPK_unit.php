<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_pk";
	$field = array("id","th","kdunitkerja","no_pk","nm_pk","target","rencana_1","rencana_2","rencana_3","rencana_4","aksi_1","aksi_2","aksi_3","aksi_4");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];

if ( $xlevel == '3' )
{
	if ( $_REQUEST['kdsatker'] == '' )
	{
		$xkdsatker = $_SESSION['xusername'];
	}else{
		$xkdsatker = $_REQUEST['xkdsatker'];
	}
	
	if ( $_REQUEST['cari_unit'] )
	{
     	$xkdsatker = $_REQUEST['xkdsatker'];
	}	
$xkdunit = kode_unit($xkdsatker) ;	

}else{
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
}
	$kdunit = substr($xkdunit,0,4);
	$kddeputi = substr($xkdunit,0,3);
	$kdbid = substr($xkdunit,0,5);

switch ( $xlevel )
{
	case '4':
		if ( $_REQUEST['xkdunit'] == '' or substr($_REQUEST['xkdunit'],3,3) == '000' ) $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND left(kdunitkerja,3) = '$kddeputi' ORDER BY kdunitkerja,no_sasaran,no_pk");
		else $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_pk");
	break;
	case '5':
		if ( $_REQUEST['xkdunit'] == '' or substr($_REQUEST['xkdunit'],2,4) == '000' ) $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND left(kdunitkerja,4) = '$kdunit' ORDER BY kdunitkerja,no_pk");
		else $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_sasaran,no_pk");
	break;
	case '7':
	$oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_pk");
	break;
	default:
	$oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_pk");
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
<div align="right">
	<form action="" method="post">
		Eselon II : 
		<select name="xkdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  substr(ket_unit($xkdunit),0,60) ?></option>
                      <option value="">- Pilih Eselon II -</option>
                    <?php
						$query = mysql_query("select left(nmunit,60) as namaunit, kdunit from tb_unitkerja where right(kdunit,3) <> '000'  group by kdunit order by kdunit");
					while( $row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['namaunit']); ?></option>
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
      <th width="4%">Progres<br />(%)</th>
      <th width="11%">Uraian</th>
      <th width="5%">Progres<br />(%)</th>
      <th width="12%">Uraian</th>
      <th width="5%">Progres<br />(%)</th>
      <th width="13%">Uraian</th>
      <th width="5%">Progres<br />(%)</th>
      <th width="12%">Uraian</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="12">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>">
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
      <td colspan="12">&nbsp;</td>
    </tr>
  </tfoot>
</table>
