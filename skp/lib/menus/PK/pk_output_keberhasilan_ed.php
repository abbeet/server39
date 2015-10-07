<?php
	checkauthentication();
	$table = "thuk_kak_output_ukp4_pp39";
	$field = get_field($table);
	$err = false;
	$pagess = $_REQUEST['pagess'];
	$p = $_GET['p'];
	$q = $_GET['q'];
	$o = $_GET['o'];

	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$oOutput_bp = mysql_query("SELECT * FROM thbp_kak_output WHERE id = '$o' ");
	$Output_bp = mysql_fetch_array($oOutput_bp);

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
				$value[1] = $Output_bp['th'];
				$value[2] = $Output_bp['kdunitkerja'];
				$value[3] = $Output_bp['kdgiat'];
				$value[4] = $Output_bp['kdoutput'];
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $Output_bp['th'];
				$value[2] = $Output_bp['kdunitkerja'];
				$value[3] = $Output_bp['kdgiat'];
				$value[4] = $Output_bp['kdoutput'];
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?><form action="" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr> 
      <td width="150" class="key">TAHUN</td>
      <td width="562"><strong><?php echo $Output_bp['th'] ?></strong></td>
    </tr>
    
    <tr> 
      <td class="key">UNIT KERTA </td>
      <td><?php echo nm_unit($Output_bp['kdunitkerja']) ?></td>
    </tr>
    
    
    <tr> 
      <td class="key">KEGIATAN</td>
      <td><?php echo '['.$Output_bp['kdgiat'].'] '.nm_giat($Output_bp['kdgiat']) ?></td>
    </tr>
    <tr> 
      <td class="key">OUTPUT</td>
      <td><?php echo '['.$Output_bp['kdoutput'].'] '.nm_output($Output_bp['kdgiat'].$Output_bp['kdoutput']) ?></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Kriteria Keberhasilan </strong></div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key" align="center"><textarea name="<?php echo $field[5] ?>" rows="5" cols="80"><?php echo $value[5] ?></textarea></td>
    </tr>
    
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Ukuran Keberhasilan </strong></div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key" align="center"><textarea name="<?php echo $field[6] ?>" rows="5" cols="80"><?php echo $value[6] ?></textarea></td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>')">Batal</a>          </div>
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