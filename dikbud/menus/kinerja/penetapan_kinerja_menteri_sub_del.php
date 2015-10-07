<?php
	checkauthentication();
	$table = "th_pk_sub";
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_REQUEST['q'];
	$th = $_SESSION['xth'];
	$id = $_GET['id'];
	$sw = $_REQUEST['sw'];

	$oPK = mysql_query("SELECT * FROM th_pk WHERE  id = '$id' ");
	$PK = mysql_fetch_array($oPK);
	
	$oSubPK = mysql_query("SELECT * FROM $table WHERE  id = '$q' ");
	$SubPK = mysql_fetch_array($oSubPK);

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
		<meta http-equiv="refresh" content="0;URL=index.php?p=426&id=<?php echo $_GET['id']; ?>"><?php
		exit();
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=418"><?php
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
	  <td class="key">Sasaran</td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo nm_sasaran($th,'480000',$PK['no_sasaran']) ?></textarea></td>
  </tr>
	
	
	<tr>
		<td class="key">Kinerja</td>
		<td><textarea readonly="readonly" cols="60" rows="2"><?php echo $PK['nm_pk'] ?></textarea></td>
	</tr>
	<tr>
	  <td class="key">Sub Kinerja </td>
	  <td><textarea readonly="readonly" cols="60" rows="2"><?php echo $SubPK['nm_pk_sub'] ?></textarea></td>
  </tr>
	<tr>
	  <td class="key">Target</td>
	  <td><input type="text" size="50" readonly="readonly" value="<?php echo $SubPK['target'] ?>" /></td>
  </tr>
	
	<tr>
		<td>&nbsp;</td>
		<td>
			<form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&id=<?php echo $_GET['id']; ?>&sw=<?php echo $sw ?>">				
				<div class="button2-right">
					<div class="prev">
					<?php if ( $sw == '' ) { ?>
						<a onclick="Back('index.php?p=426&id=<?php echo $_GET['id']; ?>')">Batal</a>
						<?php }else{?>
						<a onclick="Back('index.php?p=418')">Batal</a>
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
