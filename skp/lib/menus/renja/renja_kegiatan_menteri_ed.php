<?php
	checkauthentication();
	$table = "thbp_kak_kegiatan";
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
				$value[4] = substr($kodeprogram,0,3);
				$value[5] = substr($kodeprogram,3,2);
				$value[6] = substr($kodeprogram,5,2);
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
				$kodeprogram = $_REQUEST['kodeprogram'];
				$value[4] = substr($kodeprogram,0,3);
				$value[5] = substr($kodeprogram,3,2);
				$value[6] = substr($kodeprogram,5,2);
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
	<table width="721" cellspacing="1" class="admintable">
		
		<tr>
		  <td class="key">Tahun</td>
		  <td><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td><select name="<?php echo $field[2] ?>">
            <option value="<?php echo $value[2] ?>"><?php echo  $value[2].' '.nm_unit($value[2]) ?></option>
            <option value="">- Pilih Unit Kerja -</option>
		    <?php
			$query = mysql_query("select kdunit, left(nama_unit_kerja,60) as nmunit from tb_unitkerja WHERE right(kdunit,3)<>'000' order by kdunit");
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['kdunit'].' '.$row['nmunit']; ?></option>
		    <?php
			} ?>
          </select>		</td>
	  </tr>
		<tr>
			<td width="104" class="key">Kegiatan</td>
			<td width="608"><select name="<?php echo $field[3] ?>">
            <option value="<?php echo $value[3] ?>"><?php echo  $value[3].' '.nm_giat($value[3]) ?></option>
            <option value="">- Pilih Kegiatan -</option>
		    <?php
			$query = mysql_query("select kdgiat, left(nmgiat,60) as namagiat from tb_giat order by nmgiat");
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kdgiat'] ?>"><?php echo  $row['kdgiat'].' '.$row['namagiat']; ?></option>
		    <?php
			} ?>
          </select>		</td>
		</tr>
		

		<tr>
		  <td class="key">Program</td>
		  <td><select name="kodeprogram">
            <option value="<?php echo $value[4].$value[5].$value[6] ?>"><?php echo  $value[4].$value[5].$value[6].' '.nm_program($value[4].$value[5].$value[6]) ?></option>
            <option value="">- Pilih Program -</option>
		    <?php
			$query = mysql_query("select kddept,kdunit,kdprogram, left(nmprogram,60) as namaprogram from tb_program order by nmprogram");
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kddept'].$row['kdunit'].$row['kdprogram'] ?>"><?php echo  $row['kddept'].$row['kdunit'].$row['kdprogram'].' '.$row['namaprogram']; ?></option>
		    <?php
			} ?>
          </select>		</td>
	  </tr>
		<tr>
		  
      <td class="key">Pagu Indikatif</td>
		  <td><input type="text" name="<?php echo $field[7] ?>" size="20" value="<?php echo $value[7] ?>" /></td>
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