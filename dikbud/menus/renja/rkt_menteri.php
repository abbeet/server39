<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "th_rkt";
	$field = array("id","th","kdunitkerja","no_sasaran","no_iku","no_sasaran","no_rkt","nm_rkt","target","sub_rkt");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'] + 1;
	$renstra = th_renstra($th);

	$oList = mysql_query("select * from $table WHERE th ='$th' and kdunitkerja = '480000' order by no_rkt");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<strong><font size="2"><?php echo 'Rencana Kinerja Tahun : '.$th ?></font></strong><br>
<a href="menus/renstra/rkt_menteri_prn.php?th=<?php echo $th ?>" title="Cetak RKT Kementerian" target="_blank"> <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a><br />
<table width="652" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="26%">Sasaran Strategis Utama </th>
      <th width="4%">No.</th>
      <th width="42%">Rencana Kinerja Utama </th>
      <th width="14%">Terget</th>
      <th colspan="4">Aksi</th>
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
      <td align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){  ?><?php echo nm_sasaran($th,'480000',$col[3][$k]) ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="left" valign="top"><?php if ( $col[4][$k] <> 0 ) { ?><?php echo '[IKU '.$col[4][$k].'] '.$col[7][$k] ?><?php }else{ ?><?php echo $col[7][$k] ?><?php }?></td>
      <td align="center" valign="top"><?php echo $col[8][$k] ?></td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $ed[$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="3%" align="center" valign="top"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td colspan="2" align="center" valign="top"><?php if( $col[9][$k] == '1' ) {?><a href="index.php?p=278&id=<?php echo $col[0][$k] ?>" title="Tambah Sub">
							<img src="css/images/menu/icon-16-new.png" border="0" width="16" height="16">Sub</a><?php }?></td>
    </tr>
<?php 		    
			$no_rkt = $col[6][$k] ;
			$sql_sub = "SELECT * FROM th_rkt_sub WHERE th = '$th' AND kdunitkerja = '480000' AND no_rkt = '$no_rkt' ORDER BY no_rkt_sub";
			$aSub = mysql_query($sql_sub);
	        while($Sub = mysql_fetch_array($aSub))
			{
?> 
	   <tr class="<?php echo $class ?>">
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><?php echo $no_rkt.'.'.nmalfa($Sub['no_rkt_sub']) ?></td>
      <td align="left" valign="top"><?php echo $Sub['nm_rkt_sub'] ?></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="4%" align="center" valign="top"><a href="index.php?p=278&id=<?php echo $col[0][$k] ?>&q=<?php echo $SubIku['id'] ?>&sw=1" title="Tambah Sub"><img src="css/images/edit_f2.png" border="0" width="16" height="16">Sub</a></td>
      <td width="4%" align="center" valign="top"><a href="index.php?p=306&id=<?php echo $col[0][$k] ?>&q=<?php echo $SubIku['id'] ?>&sw=1" title="Tambah Sub"><img src="css/images/stop_f2.png" border="0" width="16" height="16">Sub</a></td>
    </tr>
    <?php
		}
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>
