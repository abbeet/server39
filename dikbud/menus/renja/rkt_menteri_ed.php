<?php
	checkauthentication();
	$table = "th_rkt";
	$field = array("id","th","kdunitkerja","no_sasaran","no_iku","no_rkt","nm_rkt","target","sub_rkt");
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$th = $_SESSION['xth']+1;
	$renstra = th_renstra($th);
	$kdunitkerja = '820000';

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
				$value[1] = $th ;
				$value[2] = $kdunitkerja ;
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
				$value[1] = $th ;
				$value[2] = $kdunitkerja ;
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
      <td class="key">Tahun</td>
      <td><strong><?php echo $th ?></strong></td>
    </tr>
    

    <tr> 
      <td class="key">Sasaran</td>
      <td><select name="<?php echo $field[3] ?>">
          <option value="<?php echo $value[3] ?>"><?php echo  $value[3].' '.substr(nm_sasaran($th,'480000',$value[3]),0,70) ?></option>
          <option value="">- Pilih Sasaran -</option>
          <?php
							$query = mysql_query("select * from m_sasaran where ta = '$renstra' and kdunitkerja = '820000' ");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['no_sasaran'] ?>"><?php echo  $row['no_sasaran'].' '.substr($row['nm_sasaran'],0,70) ?></option>
          <?php
						} ?>
        </select></td>
    </tr>
    <tr>
      <td class="key">IKU</td>
      <td><select name="<?php echo $field[4] ?>">
          <option value="<?php echo $value[4] ?>"><?php echo  $value[4].' '.substr(nm_iku($renstra,'820000',$value[4]),0,70) ?></option>
          <option value="">- Pilih IKU -</option>
          <?php
							$query = mysql_query("select * from m_iku where ta = '$renstra' and kdunitkerja = '820000' ");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['no_iku'] ?>"><?php echo  $row['no_iku'].' '.substr($row['nm_iku'],0,70) ?></option>
          <?php
						} ?>
        </select></div></td>
    </tr>
    <tr> 
      <td class="key">No.Urut</td>
      <td><input type="text" name="<?php echo $field[5] ?>" size="5" value="<?php echo $value[5] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Rencana Kinerja</td>
      <td><textarea name="<?php echo $field[6] ?>" rows="2" cols="70"><?php echo $value[6] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Target</td>
      <td><input type="text" name="<?php echo $field[7] ?>" size="50" value="<?php echo $value[7] ?>" /></td>
    </tr>
    <tr>
      <td class="key">Ada sub RKT </td>
      <td>
	    <input name="<?php echo $field[8] ?>" type="radio" value="0" <?php if( $value[8] == 0 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Tidak&nbsp;&nbsp;
	  	<input name="<?php echo $field[8] ?>" type="radio" value="1" <?php if( $value[8] == 1 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Ya&nbsp;&nbsp;	  </td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />      </td>
    </tr>
  </table>
</form>
