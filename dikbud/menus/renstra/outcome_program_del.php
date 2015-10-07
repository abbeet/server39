<?php
	checkauthentication();
	$table = "m_program_outcome";
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_REQUEST['q'];
	$id = $_REQUEST['id'];
	$sw = $_REQUEST['sw'];
	$renstra = th_renstra($th);

	$oProgram = mysql_query("SELECT * FROM m_program WHERE  id = '$id' ");
	$Program = mysql_fetch_array($oProgram);
	
	$oOutcome = mysql_query("SELECT * FROM $table WHERE  id = '$q' ");
	$Outcome = mysql_fetch_array($oOutcome);

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) {
	    $sql = "DELETE FROM $table WHERE id = '$q'";
//		$sql = sql_delete($table,$field[0],$q);
		$rs = mysql_query($sql);
		if ($rs) {
			update_log($sql,$table,1);
			$_SESSION['errmsg'] = "Hapus data berhasil.";
		}
		else {
			update_log($sql,$table,0);
			$_SESSION['errmsg'] = "Hapus data gagal!";
		} 
		
		if ( $sw == '' ) {
		?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=390&id=<?php echo $_GET['id']; ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>"><?php
		exit();
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=411&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>"><?php
		exit();
		}
//	}
//	else {
//		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<table width="509" cellspacing="1" class="admintable">
	<tr>
	  <td width="119" class="key">Tahun</td>
	  <td width="381"><input type="text" size="10" readonly="readonly" value="<?php echo $Program['ta'] ?>" /></td>
  </tr>
	<tr>
	  <td class="key">Program</td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo $Program['nmprogram'] ?></textarea></td>
  </tr>
	
	<tr>
	  <td class="key">Outcome</td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo $Outcome['nmoutcome'] ?></textarea></td>
  </tr>
	
	
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&id=<?php echo $_GET['id']; ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>&sw=<?php echo $sw ?>">				
				<div class="button2-right">
					<div class="prev">
					<?php if ( $sw == '' ) { ?>
						<a onclick="Back('index.php?p=412&q=<?php echo $_GET['id']; ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>')">Batal</a>
						<?php }else{?>
						<a onclick="Back('index.php?p=411&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>')">Batal</a>
						<?php }?>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Hapus</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Hapus" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</form>		</td>
	</tr>
</table>
