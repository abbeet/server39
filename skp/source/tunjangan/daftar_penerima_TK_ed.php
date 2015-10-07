<?php
	checkauthentication();
	$table = "mst_tk";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];;
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$kurang  = $_REQUEST['kurang'];
				$norec   = $_REQUEST['norec'];
				$sql = "UPDATE $table SET kurang = '$kurang', norec = '$norec' where id = '$q' ";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="692" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="158" class="key">Gaji Bulan </td>
		  <td width="525"><input type="text" name="<?php echo $field[2] ?>" size="5" value="<?php echo $value[2] ?>" readonly/>&nbsp;&nbsp;<input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Satuan Kerja </td>
		  <td><input type="text" name="<?php echo $field[5] ?>" size="60" value="<?php echo nm_satker($value[5]) ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="60" value="<?php echo nama_peg($value[3]) ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="60" value="<?php echo nm_unitkerja($value[6]) ?>" readonly/></td>
		</tr>
		<tr>
		  <td class="key">Nama Jabatan</td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="80" value="<?php echo nm_info_jabatan($value[6],$value[8]) ?>" readonly/></td>
		</tr>
		<tr>
		  <td class="key">Grade</td>
		  <td><input type="text" size="5" value="<?php echo $value[9] ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Tunjangan Kinerja </td>
		  <td><input type="text" size="20" value="<?php echo number_format($value[12],"0",",",".") ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Pajak</td>
		  <td><input type="text" size="20" value="<?php echo number_format($value[17],"0",",",".") ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Potongan</td>
		  <td><input type="text" size="5" name = "kurang" value="<?php echo $value[18] ?>" />&nbsp;%</td>
	  </tr>
		<tr>
		  <td class="key">Nomor Rekening </td>
		  <td><input type="text" size="50" name = "norec" value="<?php echo $value[19] ?>" /></td>
	  </tr>
		
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>					</div>
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