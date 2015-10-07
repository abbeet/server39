<?php
	checkauthentication();
	$table = "thuk_kak_output_capaian_hasil";
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
	
	$oCapaian_b12 = mysql_query("SELECT ukuran FROM thuk_kak_output_ukp4_pp39 WHERE th = '$Output_bp[th]' and kdunitkerja = '$Output_bp[kdunitkerja]' and kdgiat = '$Output_bp[kdgiat]' and kdoutput = '$Output_bp[kdoutput]' ");
	$Capaian_b12 = mysql_fetch_array($oCapaian_b12);

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
				$value[16] = $Capaian_b12['ukuran'];
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
				$value[16] = $Capaian_b12['ukuran'];
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
      <td class="key">UNIT ESELON</td>
      <td><?php echo nm_unit($Output_bp['kdunitkerja']) ?></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
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
      <td colspan="2" class="key"><div align="center"><strong>Capaian/Target Triwulan I </strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase</td>
      <td><input type="text" name="<?php echo $field[5] ?>" value="<?php echo $value[5] ?>" size="10"> 
        &nbsp;&nbsp;%</td>
    </tr>
    <tr>
      <td class="key">Uraian</td>
      <td><textarea name="<?php echo $field[13] ?>" rows="3" cols="70"><?php echo $value[13] ?></textarea></td>
    </tr>
    <!--tr>
      <td class="key">Tahapan Pelaksanaan </td>
      <td><textarea name="<?php #echo $field[9] ?>" rows="3" cols="70"><?php #echo $value[9] ?></textarea></td>
    </tr-->
    
    
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Capaian/Target Triwulan II </strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase</td>
      <td><input type="text" name="<?php echo $field[6] ?>" value="<?php echo $value[6] ?>" size="10" />&nbsp;&nbsp;%</td>
    </tr>
    <tr>
      <td class="key">Uraian</td>
      <td><textarea name="<?php echo $field[14] ?>" rows="3" cols="70"><?php echo $value[14] ?></textarea></td>
    </tr>
    <!--tr>
      <td class="key">Tahapan Pelaksanaan </td>
      <td><textarea name="<?php #echo $field[10] ?>" rows="3" cols="70"><?php #echo $value[10] ?></textarea></td>
    </tr-->
    <tr>
      <td colspan="2" class="key"><div align="center"><strong>Capaian/Target Triwulan III </strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase</td>
      <td><input type="text" name="<?php echo $field[7] ?>" value="<?php echo $value[7] ?>" size="10"> 
        &nbsp;&nbsp;%</td>
    </tr>
    <tr>
      <td class="key">Uraian</td>
      <td><textarea name="<?php echo $field[15] ?>" rows="3" cols="70"><?php echo $value[15] ?></textarea></td>
    </tr>
    <!--tr>
      <td class="key">Tahapan Pelaksanaan </td>
      <td><textarea name="<?php #echo $field[11] ?>" rows="3" cols="70"><?php #echo $value[11] ?></textarea></td>
    </tr-->
    <tr>
      <td colspan="2" class="key"><div align="center"><strong>Capaian/Target Triwulan VI</strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase</td>
      <td><input type="text" name="<?php echo $field[8] ?>" value="<?php echo $value[8] ?>" size="10"> 
        &nbsp;&nbsp;%</td>
    </tr>
    <tr>
      <td class="key">Uraian</td>
      <td><textarea name="<?php echo $field[16] ?>" rows="3" cols="70" readonly="readonly"><?php echo $Capaian_b12['ukuran'] ?></textarea></td>
    </tr>
    <!--tr>
      <td class="key">Tahapan Pelaksanaan </td>
      <td><textarea name="<?php #echo $field[12] ?>" rows="3" cols="70"><?php #echo $value[12] ?></textarea></td>
    </tr-->
    
    
    
    
    
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