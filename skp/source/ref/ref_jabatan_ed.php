<?php
	checkauthentication();
	$table = "kd_jabatan";
	$field = array("id","kode","kdkel","kdjab","nmjabatan","klsjabatan","kdunitkerja","tahun");
	$err = false;
	$p = $_GET['p'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
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
				$value[1] = $value[2].$value[3];
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
				$value[1] = $value[2].$value[3];
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
	<table width="643" cellspacing="1" class="admintable">
		
		<tr>
		  <td class="key">Tahun</td>
		  <td colspan="2"><input type="text" name="<?php echo $field[7] ?>" size="10" value="<?php echo $value[7] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Satker</td>
		  <td colspan="2"><select name="<?php echo $field[6] ?>">
                      <option value="<?php echo $value[6] ?>"><?php echo  nm_unitkerja($value[6]) ?></option>
                      <option value="">- Pilih Satker -</option>
                    <?php
							$query = mysql_query("select * from kd_unitkerja where kdsatker <> '' ");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
						} ?>
          </select></td>
	  </tr>
		<tr>
		  <td width="142" class="key">Kelompok Jabatan </td>
		  <td width="274" colspan="2"><select name="<?php echo $field[2] ?>"  id="combobox">
                      <option value="<?php echo $value[2] ?>"><?php echo  substr(nm_keljabatan($value[2]),0,60) ?></option>
                      <option value="">- Pilih Kelompok Jabatan -</option>
                    <?php
							$query = mysql_query("select kdkel,left(nmkel,60) as nama_keljabatan from kd_keljabatan ");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdkel'] ?>"><?php echo  $row['nama_keljabatan']; ?></option>
                    <?php
						} ?>
          </select></td>
	  </tr>
		<tr>
		  <td class="key">Kode Jabatan </td>
		  <td colspan="2"><input type="text" name="<?php echo $field[3] ?>" size="10" value="<?php echo $value[3] ?>" /></td>
	  </tr>
		
		<tr>
		  <td class="key">Nama Jabatan </td>
		  <td colspan="2"><input type="text" name="<?php echo $field[4] ?>" size="70" value="<?php echo $value[4] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Kelas Jabatan </td>
		  <td colspan="2"><input type="text" name="<?php echo $field[5] ?>" size="5" value="<?php echo $value[5] ?>" />&nbsp;&nbsp;(Misal: 1,2,3,... dst)</td>
	  </tr>
		
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">			
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