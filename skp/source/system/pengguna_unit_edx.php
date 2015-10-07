<?php
	checkauthentication();
	$level = $_SESSION['xlevel'];
	$kdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];
	$table = "xuser";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			if ($q == "") {
				//ADD NEW			
				$username = $_REQUEST['username'];	
				$password = md5($_REQUEST['password']);
				$level = $_REQUEST['level'];
				$kode_unit = $_REQUEST['kode_unit'];
				$sql = "INSERT INTO $table (id,username,password,level,kode_unit) value ('','$username','$password','$level','$kode_unit')";
//				$sql = sql_insert($table,$field,$value);
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
				$username = $_REQUEST['username'];	
				$password = md5($_REQUEST['password']);
				$level = $_REQUEST['level'];
				$kode_unit = $_REQUEST['kode_unit'];
				$sql = "UPDATE $table SET username = '$username', password = '$password', level = '$level', kode_unit = '$kode_unit' WHERE id = '$q'";
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
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	<table width="825" cellspacing="1" class="admintable">
		<tr>
		  <td class="key">Unit Kerja</td>
		  <td>
			<select name="kode_unit">
                      <option value="<?php echo $value[2] ?>"><?php echo  skt_unitkerja($value[2]) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
					if ( $level == '2' )
					{
							$query = mysql_query("select left(kdunit,2) as kdunitkerja,sktunit from kd_unitkerja where left(kdunit,2) = '$kdunit' order by kdunit");
					}else{
							$query = mysql_query("select left(kdunit,2) as kdunitkerja,sktunit from kd_unitkerja where right(kdunit,2) = '00' order by kdunit");
					}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunitkerja'] ?>"><?php echo  $row['sktunit']; ?></option>
                    <?php
					} ?>	
	  </select>		  </td>
	  </tr>
		
		<tr>
			<td width="110" class="key">Username</td>
			<td width="324"><input type="text" name="username" size="40" value="<?php echo $value[1] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Password</td>
			<td><input type="password" name="password" size="40" value="" /></td>
		</tr>
		<tr>
		  <td class="key">Level</td>
		  <td>
	  			<input name="level" type="radio" value="2" <?php if( $value[4] == '2' ) echo 'checked="checked"' ?>/> 
        		&nbsp;&nbsp;Admin SIKAP Unit Kerja<br />
	  			<input name="level" type="radio" value="3" <?php if( $value[4] == '3' ) echo 'checked="checked"' ?>/> 
        		&nbsp;&nbsp;Eselon II<br />
	  			<input name="level" type="radio" value="4" <?php if( $value[4] == '4' ) echo 'checked="checked"' ?>/> 
        		&nbsp;&nbsp;Eselon III<br />
	  			<input name="level" type="radio" value="5" <?php if( $value[4] == '5' ) echo 'checked="checked"' ?>/> 
        		&nbsp;&nbsp;Eselon IV<br />
	  			<input name="level" type="radio" value="6" <?php if( $value[4] == '6' ) echo 'checked="checked"' ?>/> 
        		&nbsp;&nbsp;Staf
						  </td>
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