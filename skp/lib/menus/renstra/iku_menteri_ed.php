<?php
	checkauthentication();
	$table = "m_iku_program";
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
	
  <table cellspacing="1" class="admintable">
    <tr>
      <td class="key">Periode Renstra</td>
      <td><select name="<?php echo $field[1] ?>">
          <option value="<?php echo $value[1] ?>"><?php echo  $value[1] ?></option>
          <option value="">- Periode Renstra -</option>
          <option value="<?php echo '2010-2014' ?>"><?php echo  '2010-2014' ?></option>
          <option value="<?php echo '2015-2019' ?>"><?php echo  '2015-2019' ?></option>
          <option value="<?php echo '2020-2024' ?>"><?php echo  '2020-2024' ?></option>
        </select></td>
    </tr>
    <tr> 
      <td class="key">Kode IKU</td>
      <td><input type="text" name="<?php echo $field[3] ?>" size="10" value="<?php echo $value[3] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">IKU</td>
      <td><textarea name="<?php echo $field[4] ?>" rows="3" cols="50"><?php echo $value[4] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Target</td>
      <td><input type="text" name="<?php echo $field[5] ?>" size="50" value="<?php echo $value[5] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Alasan</td>
      <td><textarea name="<?php echo $field[7] ?>" rows="3" cols="50"><?php echo $value[7] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Program</td>
      <td><select name="<?php echo $field[2] ?>">
          <option value="<?php echo $value[2] ?>"><?php echo  nm_program('04201'.$value[2]) ?></option>
          <option value="">- Pilih Program -</option>
          <?php
							$query = mysql_query("select kddept,kdunit,kdprogram,left(nmprogram,60) as namaprogram from tb_program ");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdprogram'] ?>"><?php echo  $row['kddept'].'.'.$row['kdunit'].'.'.$row['kdprogram'].' '.$row['namaprogram']; ?></option>
          <?php
						} ?>
        </select></td>
    </tr>
    <tr> 
      <td class="key">Deputi Pelaksana </td>
      <td><select name="<?php echo $field[6] ?>">
          <option value="<?php echo $value[6] ?>"><?php echo  $value[6].' '.nm_unit($value[6]) ?></option>
          <option value="">- Pilih Deputi -</option>
          <?php
							$query = mysql_query("select kdunit, left(nama_unit_kerja,60) as namadeputi from tb_unitkerja where right(kdunit,3)='000' and right(kdunit,4)<>'0000'");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['kdunit'].' '.$row['namadeputi']; ?></option>
          <?php
						} ?>
        </select></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>	
          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />	
      </td>
    </tr>
  </table>
</form>