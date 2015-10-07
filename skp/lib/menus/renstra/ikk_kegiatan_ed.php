<?php
	checkauthentication();
	$table = "m_ikk_kegiatan";
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
				$value[2] = $_REQUEST['kdgiat'];
				$value[3] = $_REQUEST['kdoutput'];
				$value[10] = $_REQUEST['kdunitkerja'];
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
				$value[2] = $_REQUEST['kdgiat'];
				$value[3] = $_REQUEST['kdoutput'];
				$value[10] = $_REQUEST['kdunitkerja'];
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

<script language="javascript" src="js/autocombo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td class="key">Periode Renstra</td>
      <td><select name="<?php echo $field[1] ?>">
          <option value="<?php echo $value[1] ?>"><?php echo  $value[1] ?></option>
          <option value="">- Periode Renstra -</option>
          <option value="<?php echo '2010,2014' ?>"><?php echo  '2010-2014' ?></option>
          <option value="<?php echo '2015,2019' ?>"><?php echo  '2015-2019' ?></option>
          <option value="<?php echo '2020,2024' ?>"><?php echo  '2020-2024' ?></option>
        </select></td>
    </tr>
    <tr>
      <td class="key">Unit Kerja</td>
      <td><select name="kdunitkerja" id="kdunitkerja" onChange="get_unitkerja(kdunitkerja.value)">
          <option value="" style="width:500px;">-- Pilih Unit Kerja --</option>
          <?php
					$sql = "SELECT * FROM tb_unitkerja where right(kdunit,3)<>'000' ORDER BY kdunit";
					$oUnit = mysql_query($sql);
					while ($Unit = mysql_fetch_array($oUnit))
					{ ?>
          <option value="<?php echo $Unit['kdunit']; ?>" style="width:500px;" <?php if ($Unit['kdunit'] == $value[10]) echo "selected"; ?>><?php echo $Unit['kdunit'].' '.substr($Unit['nama_unit_kerja'],0,70) ?></option>
          <?php
					} ?>
        </select></td>
    </tr>
    <tr> 
      <td class="key">Kegiatan</td>
      <td><select name="kdgiat" id="kdgiat" onChange="get_giat(kdgiat.value)">
          <option value="" style="width:500px;">-- Pilih Kegiatan --</option>
          <?php
					$sql = "SELECT * FROM tb_giat ORDER BY kdunitkerja,kdgiat";
					$oGiat = mysql_query($sql);
					while ($Giat = mysql_fetch_array($oGiat))
					{ ?>
          <option value="<?php echo $Giat['kdgiat']; ?>" style="width:500px;" <?php if ($Giat['kdgiat'] == $value[2]) echo "selected"; ?>><?php echo $Giat['kdunitkerja'].' '.$Giat['kdgiat'].' '.substr($Giat['nmgiat'],0,70) ?></option>
          <?php
					} ?>
        </select></td>
    </tr>
    <tr> 
      <td class="key">Output</td>
      <td> <div id="output-view"> 
          <select name="kdoutput">
            <option value="" style="width:500px;">-- Pilih Output --</option>
            <?php
						
						$sql = "SELECT * FROM t_output WHERE KDGIAT = '".$value[2]."' ORDER BY KDOUTPUT";
						$oOutput = mysql_query($sql);
					
						while($Output = mysql_fetch_array($oOutput)) 
						{ ?>
            <option value="<?php echo $Output['KDOUTPUT']; ?>" style="width:500px;" <?php if ($Output['KDOUTPUT'] == $value[3]) echo "selected"; ?>><?php echo  $Output['KDOUTPUT'].' '.substr($Output['NMOUTPUT'],0,70); ?></option>
            <?php
						} ?>
          </select>
        </div></td>
    </tr>
    <tr> 
      <td class="key">Indikator</td>
      <td><textarea name="<?php echo $field[4] ?>" rows="3" cols="50"><?php echo $value[4] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Target</td>
      <td>2010&nbsp; <input type="text" name="<?php echo $field[5] ?>" size="10" value="<?php echo $value[5] ?>" /> 
        &nbsp; 2011&nbsp; <input type="text" name="<?php echo $field[6] ?>" size="10" value="<?php echo $value[6] ?>" /> 
        &nbsp; 2012&nbsp; <input type="text" name="<?php echo $field[7] ?>" size="10" value="<?php echo $value[7] ?>" /> 
        &nbsp; 2013&nbsp; <input type="text" name="<?php echo $field[8] ?>" size="10" value="<?php echo $value[8] ?>" /> 
        &nbsp; 2014&nbsp; <input type="text" name="<?php echo $field[9] ?>" size="10" value="<?php echo $value[9] ?>" /> 
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