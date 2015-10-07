<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_rkt";
	$field = array("id","th","kdunitkerja","no_rkt","nm_rkt","no_iku","no_sasaran","target","sub_rkt"); 

	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
//	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
//	if ( $_REQUEST['$xkdunit'] == '' )    $xkdunit = $_SESSION['xkdunit'];
//	else    $xkdunit = $_REQUEST['xkdunit'];
	$renstra = th_renstra($th);
	$xkdsatker = satker_th_unit($th,$xkdunit);

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
		if ( $_REQUEST['xkdunit'] == '' or substr($_REQUEST['xkdunit'],3,3) == '000' ) $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND left(kdunitkerja,3) = '$kddeputi' ORDER BY kdunitkerja,no_sasaran,no_rkt");
		else $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_rkt");
	break;
	case '5':
		if ( $_REQUEST['xkdunit'] == '' or substr($_REQUEST['xkdunit'],2,4) == '000' ) $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND left(kdunitkerja,4) = '$kdunit' ORDER BY kdunitkerja,no_rkt");
		else $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_sasaran,no_pk");
	break;
	case '7':
	$oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_rkt");
	break;
	default:
	$oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' ORDER BY kdunitkerja,no_rkt");
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
<?php if ( $xlevel <> 3 ) {?>
<div align="right">
	<form action="" method="post">
		Satuan Keja : 
		<select name="xkdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  substr(ket_unit($xkdunit),0,60) ?></option>
                      <option value="">- Pilih Satker -</option>
                    <?php
					switch ( $xlevel )
					{
						case '4';
						$query = mysql_query("select ket_unit_kerja, kdunit from tb_unitkerja where right(kdunit,4) <> '0000' and left(kdunit,3) = '$kddeputi' group by kdunit order by kdunit");
						break;
						
						case '5';
						$query = mysql_query("select ket_unit_kerja, kdunit from tb_unitkerja where right(kdunit,3) <> '000' and left(kdunit,4) = '$kdunit' group by kdunit order by kdunit");
						break;
	
						case '7';
						$query = mysql_query("select ket_unit_kerja, kdunit from tb_unitkerja where right(kdunit,3) <> '000' left(kdunit,5) = '$kdbid' group by kdunit order by kdunit");
						break;

						default:
						$query = mysql_query("select ket_unit_kerja, kdunit from tb_unitkerja where right(kdunit,3) <> '000'  group by kdunit order by kdunit");
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
<?php }?>
<br />
<table width="767" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="7%" height="28">Satuan Kerja </th> 
      <th width="14%">Sasaran Strategis </th>
      <th width="4%">No.</th>
      <th width="41%">Indikator Kinerja Utama </th>
      <th width="14%">Target</th>
      <th colspan="4">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="9">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo nm_unit($col[2][$k]) ?><?php } ?></td> 
      <td align="left" valign="top"><?php if( $col[6][$k] <> $col[6][$k-1] ){  ?><?php echo nm_sasaran($renstra,$col[2][$k],$col[6][$k]) ?><?php }?></td>
      <td align="center" valign="top"><?php echo $col[3][$k] ?></td>
      <td align="left" valign="top"><?php if ( $col[5][$k] <> 0 ) {?><?php echo 'IKU '.$col[5][$k].' : '.$col[4][$k] ?><?php }else{ ?><?php echo $col[4][$k] ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[7][$k] ?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="4%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="4%" colspan="2" align="center" valign="top"><?php if ( $col[8][$k] == 1 ) { ?>
		<a href="index.php?p=390&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Input Sub RKT"> 
        <img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16">Sub</a>
		<?php }?></td>
    </tr>
	<?php if ( $col[8][$k] == 1 ) {
	$no_rkt = $col[3][$k] ;
	$kdunit = $col[2][$k] ;
	$sql_sub = "SELECT * FROM th_rkt_sub WHERE th = '$th' AND kdunitkerja = '$kdunit' AND no_rkt = '$no_rkt' ORDER BY no_rkt_sub";
	$aSub = mysql_query($sql_sub);
	while($Sub = mysql_fetch_array($aSub))
	{
	?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><?php echo nmalfa($Sub['no_rkt_sub']) ?></td>
      <td align="left" valign="top"><?php echo $Sub['nm_rkt_sub'] ?></td>
      <td align="center" valign="top"><?php echo $Sub['target'] ?></td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top"><a href="index.php?p=390&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>&q=<?php echo $Sub['id']?>&sw=1" title="Edit Sub RKT"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16">Sub</a></td>
      <td align="center" valign="top"><a href="index.php?p=391&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>&q=<?php echo $Sub['id']?>&sw=1" title="Delete Sub RKT"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16">Sub</a></td>
    </tr>
    
    <?php
		}
		}
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="9">&nbsp;</td>
    </tr>
  </tfoot>
</table>
