<?php
	checkauthentication();
	$table = "th_rkt_sub";
//	$field = get_field($table);
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_REQUEST['q'];
	$th = $_SESSION['xth']+1;
	$id = $_GET['id'];
	$sw = $_REQUEST['sw'];
	$renstra = th_renstra($th);

	$oRKT = mysql_query("SELECT * FROM th_rkt WHERE  id = '$id' ");
	$RKT = mysql_fetch_array($oRKT);
	
	$oSub = mysql_query("SELECT * FROM $table WHERE  id = '$q' ");
	$Sub = mysql_fetch_array($oSub);

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
		<meta http-equiv="refresh" content="0;URL=index.php?p=399&id=<?php echo $_GET['id']; ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>"><?php
		exit();
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=375&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>"><?php
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
	  <td width="381"><input type="text" size="10" readonly="readonly" value="<?php echo $th ?>" /></td>
  </tr>
	<tr>
	  <td class="key">Eselon I</td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo nm_unit($RKT['kdunitkerja']) ?></textarea></td>
  </tr>
	<tr>
	  <td class="key">Sasaran</td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo nm_sasaran(th_renstra($th),$RKT['kdunitkerja'],$RKT['no_sasaran']) ?></textarea></td>
  </tr>
	
	
	<tr>
		<td class="key">Kinerja</td>
		<td><textarea readonly="readonly" cols="60" rows="2"><?php echo $RKT['nm_rkt'] ?></textarea></td>
	</tr>
	<tr>
	  <td class="key">Sub Kinerja </td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo $Sub['nm_rkt_sub'] ?></textarea></td>
  </tr>
	<tr>
	  <td class="key">Target</td>
	  <td><input type="text" size="50" readonly="readonly" value="<?php echo $Sub['target'] ?>" /></td>
  </tr>
	
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&id=<?php echo $_GET['id']; ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>&sw=<?php echo $sw ?>">				
				<div class="button2-right">
					<div class="prev">
					<?php if ( $sw == '' ) { ?>
						<a onclick="Back('index.php?p=399&id=<?php echo $_GET['id']; ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>')">Batal</a>
						<?php }else{?>
						<a onclick="Back('index.php?p=375&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>')">Batal</a>
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
