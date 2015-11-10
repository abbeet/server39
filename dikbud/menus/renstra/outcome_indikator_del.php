<?php
	checkauthentication();
	$table = "m_outcome_indikator";
	$field =  array("id","ta","kdprogram","kdoutcome","kd_indikator","nm_indikator");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdprogram = $_GET['kdprogram'];
	$kdoutcome = $_GET['kdoutcome'];
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
		<?php if ( $kdprogram == '' ) { ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=519&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>"><?php
		}
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
		$th = $value[1];
		$kdprogram = $value[2] ;
		$kdoutcome = $value[3] ;
	$sql = "SELECT * FROM m_program_outcome WHERE ta = '$th' and kdprogram = '$kdprogram' and kdoutcome = '$kdoutcome'";
	$aOutcome = mysql_query($sql);
	$Outcome = mysql_fetch_array($aOutcome);
	}
?>

<table cellspacing="1" class="admintable">
  <tr>
    <td width="105" class="key">Id</td>
    <td width="446"><input type="text" size="5" readonly="readonly" value="<?php echo $value[0] ?>" /></td>
  </tr>
  

  <tr>
    <td class="key">Kode Program </td>
    <td><input name="text2" type="text" value="<?php echo $value[3] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Program</td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo nm_program($th,$Outcome['kddept'].$Outcome['kdunit'].$Outcome['kdprogram']) ?></textarea></td>
  </tr>
  <tr>
    <td class="key">Outcome</td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $Outcome['nmoutcome'] ?></textarea></td>
  </tr>
  <tr>
    <td class="key">Nomor Urut Indikator </td>
    <td><input name="text" type="text" value="<?php echo $value[4] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Indikator  </td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $value[5] ?></textarea></td>
  </tr>
  <tr>
    <td class="key">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td> <form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>">
        <div class="button2-right"> 
          <div class="prev"> 
		  <?php if ( $kdprogram == '' ) { ?>
		  <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
		  <?php }else{ ?>
		  <a onclick="Back('index.php?p=519&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>')">Batal</a>
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
