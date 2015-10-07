<?php
	checkauthentication();
	$table = "m_sasaran";
	$field =  array("id","ta","kdunitkerja","no_sasaran","nm_sasaran");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$th = $_SESSION['xth'];

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
      <td class="key">Unit Kerja</td>
      <td><select name="<?php echo $field[2] ?>">
          <option value="<?php echo $value[2] ?>"><?php echo  substr(nm_unit($value[2]),0,70) ?></option>
          <option value="">- Pilih Unit Kerja -</option>
          <?php
switch ( $xlevel )
{
	 default:
	 $query = mysql_query("select kdunit, left(nmunit,70) as nama_unit from tb_unitkerja order by kdunit");
	 break;
}	 
		  while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nama_unit']; ?></option>
          <?php
						} ?>
        </select></td>
    </tr>
    <tr> 
      <td width="104" class="key">No. Urut </td>
      <td width="608"><input type="text" name="<?php echo $field[3] ?>" size="5" value="<?php echo $value[3] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Sasaran</td>
      <td><textarea name="<?php echo $field[4] ?>" rows="3" cols="70"><?php echo $value[4] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
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