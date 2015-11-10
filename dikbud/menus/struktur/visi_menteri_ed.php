<?php
	checkauthentication();
	$table = "tb_unitkerja";
	$field =  array("id","kdunit","nmunit","visi");
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if ($q == "") {
				//ADD NEW				
				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$visi = $value[3] ;
				$sql = "UPDATE $table SET visi = '$visi' WHERE id = '$q'";
//				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	<table width="589" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Kode</td>
		  <td width="250" class="row7"><input type="text" size="10" value="<?php echo $value[1] ?>"  disabled="disabled"></td>
	  </tr>
		<tr>
			<td class="key"> Kementerian </td>
			<td><input type="text" size="80" value="<?php echo $value[2] ?>" disabled="disabled"/></td>
		</tr>
		
		<tr>
		  <td class="key">Visi</td>
		  <td><textarea name="<?php echo $field[3] ?>" cols="70" rows="2"><?php echo $value[3] ?></textarea></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>