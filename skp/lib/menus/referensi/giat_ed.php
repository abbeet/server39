<?php
	checkauthentication();
	$table = "tb_giat";
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
				$kodeprogram = $_REQUEST['kodeprogram'];		
				$value[3] = substr($kodeprogram,0,3);
				$value[4] = substr($kodeprogram,3,2);
				$value[5] = substr($kodeprogram,5,2);
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

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	<table width="384" cellspacing="1" class="admintable">
		<tr>
			<td width="125" class="key">Kode </td>
			<td width="250"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" /></td>
		</tr>
		
		<tr>
			<td class="key">Nama Kegiatan</td>
			<td><input type="text" name="<?php echo $field[2] ?>" size="40" value="<?php echo $value[2] ?>" /></td>
		</tr>
		<tr>
		  <td class="key">Program</td>
		  <td><select name="kodeprogram"><?php $kodeprogram = $value[3].$value[4].$value[5]; ?>
						<option value="<?php echo $kodeprogram ?>"><?php echo  $value[3].'.'.$value[4].'.'.$value[5].' '.nm_program($value[3].$value[4].$value[5]) ?></option>
						<option value="">- Pilih Program -</option><?php
							$query = mysql_query("select kddept,kdunit,kdprogram,left(nmprogram,50) as namaprogram from tb_program ");
					
						while($row = mysql_fetch_array($query)) { ?>
							<option value="<?php echo $row['kddept'].$row['kdunit'].$row['kdprogram'] ?>"><?php echo  $row['kddept'].'.'.$row['kdunit'].'.'.$row['kdprogram'].' '.$row['namaprogram']; ?></option><?php
						} ?>
					</select></td>
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