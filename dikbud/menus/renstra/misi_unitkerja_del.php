<?php
	checkauthentication();
	$table = "tb_unitkerja_misi";
	$field =  array("id","kdunit","kdmisi","nmmisi");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdunit = $_GET['kdunit'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) {
		$sql = sql_delete($table,$field[0],$q);
		$rs = mysql_query($sql);
		if ($rs) {
			update_log($sql,$table,1);
			$_SESSION['errmsg'] = "Hapus data berhasil.";
		}
		else {
			update_log($sql,$table,0);
			$_SESSION['errmsg'] = "Hapus data gagal!";
		} ?>
		<?php if ( $kdunit == '' ) { ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=391&kdunit=<?php echo $kdunit ?>"><?php
		}
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<table cellspacing="1" class="admintable">
  <tr>
    <td width="105" class="key">Id</td>
    <td width="446"><input type="text" size="5" readonly="readonly" value="<?php echo $value[0] ?>" /></td>
  </tr>
  <tr> 
    <td class="key">Kode </td>
    <td><input type="text" size="5" readonly="readonly" value="<?php echo $value[1] ?>" /></td>
  </tr>
  <tr> 
    <td class="key">Unit Kerja </td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo nm_unit($value[1]) ?></textarea></td>
  </tr>
  <tr>
    <td class="key">No. Urut</td>
    <td><input type="text" size="5" readonly="readonly" value="<?php echo $value[2] ?>" /></td>
  </tr>
  <tr>
    <td class="key">Misi</td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $value[3] ?></textarea></td>
  </tr>
  <tr>
    <td class="key">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td> <form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&kdunit=<?php echo $kdunit ?>">
        <div class="button2-right"> 
          <div class="prev"> 
		  <?php if ( $kdunit == '' ) { ?>
		  <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
		  <?php }else{ ?>
		  <a onclick="Back('index.php?p=391&kdunit=<?php echo $kdunit ?>')">Batal</a>
		  <?php } ?>
		  </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Hapus</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Hapus" type="submit">
        <input name="form" type="hidden" value="1" />
        <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
      </form></td>
  </tr>
</table>
