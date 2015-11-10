<?php
	checkauthentication();
	$table = "xmenu";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_session = $_SESSION['xusername'];
	$xlevel_session = $_SESSION['xlevel'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) {		
		if ($err != true) {
			$type = $left.','.$top.','.$sub;
			
			$rs = xlevel("","id");
			$level = "";
			while ($xlevel = mysql_fetch_object($rs)) {
				$a = "level".$xlevel->id;
				$level .= $$a.",";
			}
			
			$lastmodified = now();
			$modifiedby = $xusername_session;
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
				$sql = sql_update($table,$field,$value);
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

<form action="index.php?p=<?php echo $p ?>" method="post" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="<?php echo $field[1] ?>" size="40" value="<?php echo $value[1] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Judul</td>
			<td><input type="text" name="<?php echo $field[2] ?>" size="40" value="<?php echo $value[2] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Tipe</td>
			<td>
				<input type="checkbox" name="left" value="left" <?php if (strpos($value[3],'left') !== false) echo "checked=\"checked\"" ?>>Left Menu&nbsp;
				<input type="checkbox" name="top" value="top" <?php if (strpos($value[3],'top') !== false) echo "checked=\"checked\"" ?>>Top Menu&nbsp;
				<input type="checkbox" name="sub" value="sub" <?php if (strpos($value[3],'sub') !== false) echo "checked=\"checked\"" ?>>Sub Menu
			</td>
		</tr>
		<tr>
			<td class="key">Parent ID</td>
			<td>
				<select name="<?php echo $field[4]?>" size="9">
					<option value="0" <?php if ($value[4] == 0) echo "selected" ?>></option><?php	
						
					$rs = xmenu_type("NOT LIKE '%sub%'",0);
					$i = 1;					
					while ($xmenu1 = mysql_fetch_object($rs)) { ?>
						
						<option value="<?php echo $xmenu1->id ?>" <?php if ($xmenu1->id == $value[4]) echo "selected" ?>>
							<?php echo $i.'. '.$xmenu1->name ?>&nbsp; &nbsp;
						</option><?php
						
						$rs1 = xmenu_type("NOT LIKE '%sub%'",$xmenu1->id);
						$j = 1;
						while ($xmenu2 = mysql_fetch_object($rs1)) { ?>
							
							<option value="<?php echo $xmenu2->id ?>" <?php if ($xmenu2->id == $value[4]) echo "selected" ?>>
								&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $j.'. '.$xmenu2->name ?>&nbsp; &nbsp;
							</option><?php
							
							$rs3 = xmenu_type("NOT LIKE '%sub%'",$xmenu2->id);
							$k = 1;
							while ($xmenu3 = mysql_fetch_object($rs3)) { ?>
								<option value="<?php echo $xmenu3->id ?>" <?php if ($xmenu3->id == $value[4]) echo "selected" ?>>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $k.'. '.$xmenu3->name ?>&nbsp; &nbsp;
								</option><?php
								
								$rs4 = xmenu_type("NOT LIKE '%sub%'",$xmenu3->id);
								$l = 1;
								while ($xmenu4 = mysql_fetch_object($rs4)) { ?>
									<option value="<?php echo $xmenu4->id ?>" <?php if ($xmenu4->id == $value[4]) echo "selected" ?>>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $l.'. '.$xmenu4->name ?>&nbsp; &nbsp;
									</option><?php
									$l++;
								}
								$k++;						
							}
							$j++;
						}
						$i++;
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Tampil</td>
			<td>
				<input type="radio" name="<?php echo $field[5] ?>" value="1" <?php if ($value[5] == 1) echo "checked=\"checked\"" ?>/>Ya&nbsp;
				<input type="radio" name="<?php echo $field[5] ?>" value="0" <?php if ($value[5] == 0) echo "checked=\"checked\"" ?>/>Tidak
			</td>
		</tr>
		<tr>
			<td class="key">Level Akses</td>
			<td><?php
				$rs = xlevel("id >= '".$xlevel_session."'","id");
				while ($xlevel = mysql_fetch_object($rs)) { ?>
					<input name="level<?php echo $xlevel->id ?>" type="checkbox" value="<?php echo $xlevel->id ?>" <?php if (strpos($value[6],$xlevel->id) !== false) echo "checked=\"checked\"" ?> /><?php echo $xlevel->name ?><br /><?php
				} ?>
			</td>
		</tr>
		<tr>
			<td class="key">Aksi</td>
			<td>
				<input type="radio" name="<?php echo $field[7] ?>" value="" <?php if ($value[7] == "") echo "checked=\"checked\"" ?>/>None&nbsp;
				<input type="radio" name="<?php echo $field[7] ?>" value="ed" <?php if ($value[7] == "ed") echo "checked=\"checked\"" ?>/>Edit&nbsp;
				<input type="radio" name="<?php echo $field[7] ?>" value="del" <?php if ($value[7] == "del") echo "checked=\"checked\"" ?>/>Delete
			</td>
		</tr>
		<tr>
			<td class="key">Letak File</td>
			<td><input type="text" name="<?php echo $field[8] ?>" size="40" value="<?php echo $value[8] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Urutan</td>
			<td><input type="text" name="<?php echo $field[9] ?>" size="5" value="<?php echo $value[9] ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</td>
		</tr>
	</table>
</form>