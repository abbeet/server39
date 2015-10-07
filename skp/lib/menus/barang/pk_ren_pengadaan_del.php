<?php
	checkauthentication();
	$table = "thuk_ren_pengadaan";
	$field = get_field($table);
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	
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
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
                  <td width="190" class="key">Tahun</td>
      <td width="522" colspan="3"><input type="text" size="10" value="<?php echo $value[1] ?>" readonly/></td>
    </tr>
    
    <tr>
                  <td class="key">Satker</td>
                  <td colspan="3"><textarea name="<?php echo $field[2] ?>" rows="2" cols="60" readonly><?php echo nm_satker($value[2]) ?></textarea></td>
    </tr>
    <tr>
                  <td class="key">Nama Pekerjaan </td>
                  <td colspan="3"><textarea rows="2" cols="60" readonly><?php echo $value[3] ?></textarea>                  </td>
                </tr>
    		<tr>
                  <td class="key">Pagu</td>
                  <td colspan="3"><input type="text" size="20" value="<?php echo number_format($value[4],"0",",",".") ?>" readonly/></td>
                </tr>
    <tr>
      <td colspan="2" class="key">&nbsp;</td>
    </tr>
    
    <tr>
      <td class="key">&nbsp;</td>
      <td><form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>">
        <div class="button2-right"> 
          <div class="prev"> <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
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
