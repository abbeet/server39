<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_pk";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$renstra = th_renstra($th);

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
	$kddeputi = substr($xkdunit,0,3) ;

if ( $xlevel == '4' )
{
	$oList = mysql_query("select * from $table WHERE th='$th' and kdunitkerja = '$xkdunit' order by kdunitkerja,no_sasaran,no_pk ");
}else{
	$oList = mysql_query("select * from $table WHERE th='$th' and kdunitkerja = '231000' order by kdunitkerja,no_sasaran,no_pk ");
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
<a href="menus/kinerja/penetapan_kinerja_deputi_prn.php?th=<?php echo $th ?>&kdunit=<?php echo $xkdunit ?>" title="Cetak PK Eselon I" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16" />PDF</a>
<table width="767" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="7%" height="28">Eselon I</th> 
      <th width="23%">Sasaran Strategis </th>
      <th width="4%">No.</th>
      <th width="35%">Indikator Kinerja Utama </th>
      <th width="8%">Target</th>
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
      <td align="left" valign="top"><?php if( $col[6][$k] <> $col[6][$k-1] or $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo nm_sasaran($renstra,$col[2][$k],$col[6][$k]) ?><?php }?></td>
      <td align="center" valign="top"><?php echo $col[3][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[4][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[7][$k] ?></td>
      <td align="right" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo number_format(pagudipa_deputi($col[1][$k],$col[2][$k]),"0",",",".") ?><?php }?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>&xkdunit=<?php echo $xkdunit ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>	  </td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="8%" colspan="2" align="center" valign="top">
<?php if ( $col[20][$k] == 1 ) { ?>
		<a href="index.php?p=349&id=<?php echo $col[0][$k] ?>&xkdunit=<?php echo $col[2][$k] ?>" title="Edit Sub PK"> 
        <img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16">Sub</a>
		<?php }?>	  </td>
    </tr>
	<?php if ( $col[20][$k] == 1 ) {
	$no_pk = $col[3][$k] ;
	$kdunit = $col[2][$k] ;
	$sql_sub = "SELECT * FROM th_pk_sub WHERE th = '$th' AND kdunitkerja = '$kdunit' AND no_pk = '$no_pk' ORDER BY no_pk_sub";
	$aSubPK = mysql_query($sql_sub);
	while($SubPK = mysql_fetch_array($aSubPK))
	{
	?>
    
    
    <?php
		} # end while 
		} # endif
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="10">&nbsp;</td>
    </tr>
  </tfoot>
</table>
