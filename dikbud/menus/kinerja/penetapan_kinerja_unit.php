<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_pk";
	$field = array("id","th","kdunitkerja","no_pk","nm_pk","no_ikk","no_sasaran","target","sub_pk");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];

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

	$kdunit = substr($xkdunit,0,4);
	$kddeputi = substr($xkdunit,0,3);
	$kdbid = substr($xkdunit,0,5);

switch ( $xlevel )
{
	case '4':
		if ( $_REQUEST['xkdunit'] == '' or substr($_REQUEST['xkdunit'],3,3) == '000' ) $oList = mysql_query("SELECT * FROM $table WHERE th = '$th' AND left(kdunitkerja,3) = '$kddeputi' and right(kdunitkerja,3) <> '000' ORDER BY kdunitkerja,no_sasaran,no_pk");
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
<br />
<a href="menus/kinerja/penetapan_kinerja_unit_prn.php?th=<?php echo $th ?>&kdunit=<?php echo $xkdunit ?>" title="Cetak PK Eselon II" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a><br />
<table width="767" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="7%" height="28">Eselon II </th> 
      <th width="14%">Sasaran Strategis </th>
      <th width="4%">No.</th>
      <th width="41%">Indikator Kinerja</th>
      <th width="14%">Target</th>
      <th width="9%">Anggaran</th>
      <th colspan="4">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
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
      <td align="left" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo nm_unit($col[2][$k]) ?><?php } ?></td> 
      <td align="left" valign="top"><?php if( $col[6][$k] <> $col[6][$k-1] ){  ?><?php echo nm_sasaran($col[1][$k],'480000',$col[6][$k]) ?><?php }?></td>
      <td align="center" valign="top"><?php echo $col[3][$k] ?></td>
      <td align="left" valign="top"><?php if ( $col[5][$k] <> 0 ) {?><?php echo 'IKK '.$col[5][$k].' : '.$col[4][$k] ?><?php }else{ ?><?php echo $col[4][$k] ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[7][$k] ?></td>
      <td align="right" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo number_format(pagu_unitkerja($col[1][$k],$col[2][$k]),"0",",",".") ?><?php }?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="4%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="4%" colspan="2" align="center" valign="top"><?php if ( $col[8][$k] == 1 ) { ?>
		<a href="index.php?p=430&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Input Sub PK"> 
        <img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16">Sub</a>
		<?php }?></td>
    </tr>
	<?php if ( $col[8][$k] == 1 ) {
	$no_pk = $col[3][$k] ;
	$kdunit = $col[2][$k] ;
	$sql_sub = "SELECT * FROM th_pk_sub WHERE th = '$th' AND kdunitkerja = '$kdunit' AND no_pk = '$no_pk' ORDER BY no_pk_sub";
	$aSubPK = mysql_query($sql_sub);
	while($SubPK = mysql_fetch_array($aSubPK))
	{
	?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><?php echo nmalfa($SubPK['no_pk_sub']) ?></td>
      <td align="left" valign="top"><?php echo $SubPK['nm_pk_sub'] ?></td>
      <td align="center" valign="top"><?php echo $SubPK['target'] ?></td>
      <td align="right" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top"><a href="index.php?p=430&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>&q=<?php echo $SubPK['id']?>&sw=1" title="Edit Sub PK"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16">Sub</a>
</td>
      <td align="center" valign="top"><a href="index.php?p=431&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>&q=<?php echo $SubPK['id']?>&sw=1" title="Delete Sub PK"> 
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
      <td colspan="10">&nbsp;</td>
    </tr>
  </tfoot>
</table>
