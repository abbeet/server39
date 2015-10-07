<?php
	checkauthentication();
	$table = "mst_info_jabatan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$kdunit = $_SESSION['xkdunit'] ;
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
//					$value[3] = nm_jabatan_ij($value[2]);
					if( substr($value[2],0,3) <> '001' )  $value[3] = nm_jabatan_ij($value[2]);
					if( substr($value[2],0,3) == '001' and $value[1] <> '9100' )  $value[3] = 'Kepala '.nm_unitkerja($value[1]);
					if( substr($value[2],0,3) == '001' and $value[1] == '9100' )  $value[3] = 'Ketua '.nm_unitkerja($value[1]);
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
					if( substr($value[2],0,3) <> '001' )  $value[3] = nm_jabatan_ij($value[2]);
					if( substr($value[2],0,3) == '001' and $value[1] <> '9100' )  $value[3] = 'Kepala '.nm_unitkerja($value[1]);
					if( substr($value[2],0,3) == '001' and $value[1] == '9100' )  $value[3] = 'Ketua '.nm_unitkerja($value[1]);
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
	<table width="497" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Unit Kerja </td>
		  <td width="250"><select name="<?php echo $field[1] ?>">
                      <!--option value="<?php echo $value[1] ?>"><?php echo  '['.$value[1].'] '.nm_unitkerja($value[1]) ?></option-->
					  <option value="<?php echo $value[1] ?>"><?php echo  nm_unitkerja($value[1]) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select kdunit,left(nmunit,60) as namaunit from kd_unitkerja where left(kdunit,2) = '$kdunit'");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <!--option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['kdunit'].' '.$row['namaunit']; ?></option-->
					  <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['namaunit']; ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
			<td class="key"> Nama Jabatan </td>
			<td><select name="<?php echo $field[2] ?>">
                      <!--option value="<?php echo $value[2] ?>"><?php echo  '['.$value[2].'] '.substr(nm_jabatan_ij($value[2]),0,60) ?></option-->
					  <option value="<?php echo $value[2] ?>"><?php echo  substr(nm_jabatan_ij($value[2]),0,60) ?></option>
                      <option value="">- Pilih Jabatan -</option>
                    <?php
							$query = mysql_query("select kode,left(nmjabatan,60) as nama_jabatan from kd_jabatan order by nmjabatan");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <!--option value="<?php echo $row['kode'] ?>"><?php echo  '['.$row['kode'].'] '.$row['nama_jabatan']; ?></option-->
					  <option value="<?php echo $row['kode'] ?>"><?php echo  $row['nama_jabatan']; ?></option>
                    <?php
						} ?>
                  </select></td>
		</tr>
		<tr>
		  <td class="key">Jumlah</td>
		  <td><input type="text" name="<?php echo $field[5] ?>" size="5" value="<?php echo $value[5] ?>"/></td>
	  </tr>
		<tr>
		  <td class="key">Grade</td>
		  <td><input type="text" name="<?php echo $field[6] ?>" size="5" value="<?php echo $value[6] ?>"/></td>
	  </tr>
		
		<tr>
		  <td class="key">Ihtisar Jabatan </td>
		  <td><textarea name="<?php echo $field[4] ?>" rows="3" cols="60"><?php echo $value[4] ?></textarea></td>
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