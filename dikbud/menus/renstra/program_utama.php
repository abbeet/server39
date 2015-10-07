<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "m_program";
	$field =  array("id","ta","kddept","kdunit","kdprogram","nmprogram");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);

	$oList = mysql_query("select * from $table WHERE ta = '$th' order by kdprogram");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<strong><font size="+1"><?php echo 'Periode Renstra : '.$renstra ?></font></strong><br><br />
<a href="menus/renstra/program_utama_prn.php?th=<?php echo $th ?>" title="Cetak Program Utama Kementerian" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>
<table cellpadding="1" class="adminlist"><br />
<table width="539" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="31%">Kementerian/Lembaga</th>
      <th colspan="2">Program</th>
      <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="5">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="left"><?php if ( $col[2][$k] <> $col[2][$k-1] ) { ?><?php echo nm_unit(substr($col[2][$k],1,2).'0000') ?><?php } ?></td>
      <td width="4%" align="center"><?php echo $col[2][$k].'.'.$col[3][$k].'.'.$col[4][$k] ?></td>
      <td width="31%" align="left"><?php echo $col[5][$k] ?></td>
      <td width="4%" align="center"> <a href="<?php echo $ed[$k] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="7%" align="center"> <a href="<?php echo $del[$k] ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="5">&nbsp;</td>
    </tr>
  </tfoot>
</table>
