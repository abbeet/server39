<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_pk";
	$field = array("id","th","kdunitkerja","no_pk","nm_pk","no_ikk","no_sasaran","target");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	
	
	$oList = mysql_query("select * from $table WHERE th='$th' and kdunitkerja = '231000' order by no_pk ");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<a href="menus/kinerja/penetapan_kinerja_menteri_prn.php?th=<?php echo $th ?>" title="Cetak PK Kementerian" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a><br />
<table width="767" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th width="23%" height="28">Sasaran Strategis </th>
      <th width="4%">No.</th>
      <th width="42%">Indikator Kinerja Utama </th>
      <th width="8%">Target</th>
      <th width="9%">Anggaran</th>
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
      <td align="left" valign="top"><?php if( $col[6][$k] <> $col[6][$k-1] ){  ?><?php echo nm_sasaran($th,$col[2][$k],$col[6][$k]) ?><?php }?></td>
      <td align="center" valign="top"><?php echo $col[3][$k] ?></td>
      <td align="left" valign="top"><?php if ( $col[5][$k] <> 0 ) {?><?php echo 'IKU '.$col[5][$k].' : '.$col[4][$k] ?><?php }else{ ?><?php echo $col[4][$k] ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[7][$k] ?></td>
      <td align="right" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo number_format(pagudipa_menteri($th),"0",",",".") ?><?php }?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>				</td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>		</td>
      <td width="8%" colspan="2" align="center" valign="top"><?php if ( $col[8][$k] == 1 ) { ?>
		<a href="index.php?p=426&id=<?php echo $col[0][$k] ?>" title="Edit Sub PK"> 
        <img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16">Sub</a>
		<?php }?></td>
    </tr>
	<?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="9">&nbsp;</td>
    </tr>
  </tfoot>
</table>