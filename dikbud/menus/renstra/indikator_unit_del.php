<?php
	checkauthentication();
	$table = "m_ikk";
	$field =  array("id","th","kdunitkerja","kdgiat","no_ikk","nm_ikk","target_thawal","target_thakhir");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdgiat = $_GET['kdgiat'];
	$th = $_GET['th'];
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
		<?php if ( $kdgiat == '' ) { ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=516&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>"><?php
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
    <td class="key">Kode Kegiatan</td>
    <td><input name="text" type="text" value="<?php echo $value[3] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Nama Kegiatan</td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo nm_giat($value[3]) ?></textarea></td>
  </tr>
  <tr>
    <td class="key">Unit Kerja</td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo nm_unit($value[2]) ?></textarea></td>
  </tr>
  <tr>
    <td class="key">Nomor Urut IKK </td>
    <td><input name="text" type="text" value="<?php echo $value[4] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Indikator Kinerja Kegiatan </td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $value[4] ?></textarea></td>
  </tr>
  <tr>
    <td class="key">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td> <form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>">
        <div class="button2-right"> 
          <div class="prev"> 
		  <?php if ( $kdgiat == '' ) { ?>
		  <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
		  <?php }else{ ?>
		  <a onclick="Back('index.php?p=516&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>')">Batal</a>
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
