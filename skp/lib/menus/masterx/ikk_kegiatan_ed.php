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
      <td class="key">Kegiatan</td>
      <td> <select name="kdgiat" id="kdgiat" onchange="get_giat(kdgiat.value)">
          <option value="" style="width:500px;">-- Pilih Kegiatan --</option>
          <?php
					$sql = "SELECT * FROM tb_giat ORDER BY kdgiat";
					$oGiat = mysql_query($sql);
					while ($Giat = mysql_fetch_array($oGiat))
					{ ?>
          <option value="<?php echo $Giat['kdgiat']; ?>" style="width:500px;" <?php if ($Giat['kdgiat'] == $value[2]) echo "selected"; ?>><?php echo $Giat['nmgiat'] ?></option>
          <?php
					} ?>
        </select> </td>
    </tr>
    <tr> 
      <td class="key">Output</td>
      <td> <div id="output-view"> 
          <select name="kdoutput">
            <option value="" style="width:500px;">-- Pilih Output --</option>
            <?php
						
						$sql = "SELECT * FROM tb_output WHERE kdgiat = '".$value[2]."' ORDER BY kdoutput";
						$oOutput = mysql_query($sql);
					
						while($Output = mysql_fetch_array($oOutput)) 
						{ ?>
            <option value="<?php echo $Output['kdoutput']; ?>" style="width:500px;" <?php if ($Output['kdoutput'] == $value[3]) echo "selected"; ?>><?php echo  $Output['nmoutput']; ?></option>
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
      <td class="key">Apakah Masuk Renja</td>
      <td>&nbsp;</td>
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