<?php
	checkauthentication();
	$table = "m_aldana_kegiatan";
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
				$value[1] = '2010,2014';
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
      <td class="key">Periode Renstra</td>
      <td><input type="text" name="<?php echo $field[1] ?>" size="20" value="<?php echo $value[1] ?>" /></td>
    </tr>
    <tr>
      <td class="key">Unit Kerja</td>
      <td><input type="text" name="<?php echo $field[8] ?>" size="7" value="<?php echo $value[8] ?>" readonly /><br><?php echo nm_unit($value[8]) ?></td>
    </tr>
    <tr> 
      <td width="104" class="key">Kegiatan</td>
      <td width="608"><select name="<?php echo $field[2] ?>">
          <option value="<?php echo $value[2] ?>"><?php echo  $value[2].' '.substr(nm_giat($value[2]),0,70) ?></option>
          <option value="">- Pilih Kegiatan -</option>
          <?php
							$query = mysql_query("select KdGiat, left(NmGiat,70) as namagiat from t_giat where KDDEPT='042' order by NmGiat");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['KdGiat'] ?>"><?php echo  $row['KdGiat'].' '.$row['namagiat']; ?></option>
          <?php
						} ?>
        </select> </td>
    </tr>
    <tr> 
      <td class="key">Alokasi Anggaran 2010</td>
      <td><input type="text" name="<?php echo $field[3] ?>" size="20" value="<?php echo $value[3] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Alokasi Anggaran 2011 </td>
      <td><input type="text" name="<?php echo $field[4] ?>" size="20" value="<?php echo $value[4] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Alokasi Anggaran 2012 </td>
      <td><input type="text" name="<?php echo $field[5] ?>" size="20" value="<?php echo $value[5] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Alokasi Anggaran 2013 </td>
      <td><input type="text" name="<?php echo $field[6] ?>" size="20" value="<?php echo $value[6] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Alokasi Anggaran 2014 </td>
      <td><input type="text" name="<?php echo $field[7] ?>" size="20" value="<?php echo $value[7] ?>" /></td>
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