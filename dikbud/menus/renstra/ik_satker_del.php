<?php
	checkauthentication();
	$table = "m_iku_utama";
	$field =  array("id","ta","no_iku","nm_iku","no_sasaran");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$no_sasaran = $_GET['no_sasaran'];
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
		<?php if ( $no_sasaran == '' ) { ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=605&no_sasaran=<?php echo $no_sasaran ?>&kdunit=<?php echo $kdunit ?>"><?php
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
    <td class="key">Nomor Urut IKU </td>
    <td><input name="text" type="text" value="<?php echo $value[2] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Indikator Kinerja</td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $value[3] ?></textarea></td>
  </tr>
  
  <tr> 
    <td>&nbsp;</td>
    <td> <form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&no_sasaran=<?php echo $no_sasaran ?>">
        <div class="button2-right"> 
          <div class="prev"> 
		  <?php if ( $no_sasaran == '' ) { ?>
		  <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
		  <?php }else{ ?>
		  <a onclick="Back('index.php?p=605&no_sasaran=<?php echo $no_sasaran ?>&kdunit=<?php echo $kdunit ?>')">Batal</a>
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
