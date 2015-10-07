<?php
	checkauthentication();
	$table = "document";
	$field = get_field($table);
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
//--------------------
	// upload file ke direktori files
	$nmfile = $field[4];
	$file_name=$_FILES[$nmfile]['name'];
	$source=$_FILES[$nmfile]['tmp_name'];
	$target = $file_name;
	move_uploaded_file($source,$target);
//--------------------									
					$_SESSION['errmsg'] = "Input data berhasil .....!".$file_name;
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} 
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Edit data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Edit data gagal!";			
				} 
				?>
				
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

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Kode Dokumen </td>
			<td><input type="text" name="<?php echo $field[1] ?>" size="40" value="<?php echo $value[1] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Judul</td>
			<td><input type="text" name="<?php echo $field[2] ?>" size="70" value="<?php echo $value[2] ?>" /></td>
		</tr>
		<tr>
		  <td class="key">Penulis</td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="40" value="<?php echo $value[3] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Nama File </td>
		  <td><input type="file" name="<?php echo $field[4] ?>" size="50" value="<?php echo $value[4] ?>"></td>
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