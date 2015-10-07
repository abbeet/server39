<?php
	checkauthentication();
	$table = "m_ikk_subprogram";
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
				$kodesubprogram = $_REQUEST['kodesubprogram'];		
				$value[1] = substr($kodesubprogram,0,2);
				$value[2] = substr($kodesubprogram,2,2);
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
				$kodesubprogram = $_REQUEST['kodesubprogram'];		
				$value[1] = substr($kodesubprogram,0,2);
				$value[2] = substr($kodesubprogram,2,2);
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
	} ?><form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td class="key">Periode Renstra</td>
      <td><select name="<?php echo $field[12] ?>">
          <option value="<?php echo $value[12] ?>"><?php echo  $value[12] ?></option>
          <option value="">- Periode Renstra -</option>
          <option value="<?php echo '2010-2014' ?>"><?php echo  '2010-2014' ?></option>
          <option value="<?php echo '2015-2019' ?>"><?php echo  '2015-2019' ?></option>
          <option value="<?php echo '2020-2024' ?>"><?php echo  '2020-2024' ?></option>
        </select></td>
    </tr>
    <tr> 
      <td width="104" class="key">Kode IKU</td>
      <td width="608"><input type="text" name="<?php echo $field[3] ?>" size="10" value="<?php echo $value[3] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">IKU</td>
      <td><textarea name="<?php echo $field[4] ?>" rows="3" cols="50"><?php echo $value[4] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Alasan</td>
      <td><textarea name="<?php echo $field[10] ?>" rows="3" cols="50"><?php echo $value[10] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Pilar</td>
      <td><select name="kodesubprogram">
          <?php $kodesubprogram = $value[1].$value[2]; ?>
          <option value="<?php echo $value[1].$value[2] ?>"><?php echo  nm_subprogram('04201'.$value[1].$value[2]) ?></option>
          <option value="">- Pilih Sub Program -</option>
          <?php
							$query = mysql_query("select kdprogram,kdsubprogram, left(nmsubprogram,60) as namasubprogram from tb_subprogram ");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdprogram'].$row['kdsubprogram'] ?>"><?php echo  $row['kdprogram'].'.'.$row['kdsubprogram'].' '.$row['namasubprogram']; ?></option>
          <?php
						} ?>
        </select> </td>
    </tr>
    <tr> 
      <td colspan="2" class="key" align="left"><div align="left"><strong>Mendukung 
          IKU Kementerian : 
          <input name="<?php echo $field[11] ?>" type="radio" value="1" <?php if($value[11]== 1 ){ ?> checked <?php }?>/>
          &nbsp;Ya&nbsp;&nbsp;&nbsp; 
          <input name="<?php echo $field[11] ?>" type="radio" value="0" <?php if($value[11]== 0 ){ ?> checked <?php }?>/>
          &nbsp;Tidak&nbsp;&nbsp;&nbsp; </strong></div></td>
    </tr>
    <tr> 
      <td class="key">Target</td>
      <td>2010&nbsp;
        <input type="text" name="<?php echo $field[5] ?>" size="10" value="<?php echo $value[5] ?>" />
        &nbsp; 2011&nbsp;
        <input type="text" name="<?php echo $field[6] ?>" size="10" value="<?php echo $value[6] ?>" />
        &nbsp; 2012&nbsp;
        <input type="text" name="<?php echo $field[7] ?>" size="10" value="<?php echo $value[7] ?>" />
        &nbsp; 2013&nbsp;
        <input type="text" name="<?php echo $field[8] ?>" size="10" value="<?php echo $value[8] ?>" />
        &nbsp; 2014&nbsp;
        <input type="text" name="<?php echo $field[9] ?>" size="10" value="<?php echo $value[9] ?>" />
        &nbsp; </td>
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