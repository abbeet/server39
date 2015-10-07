<?php
	checkauthentication();
	$table = "thuk_kak_output_ukp4_pp39";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$o = $_GET['o'];
	$kdtriwulan = $_REQUEST['kdtriwulan'];
	$pagess = $_REQUEST['pagess'];

	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$oOutput_capaian = mysql_query("SELECT * FROM $table WHERE id = '$q' ");
	$Output_capaian = mysql_fetch_array($oOutput_capaian);

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
				$value[1] = $Output_capaian['th'];
				$value[2] = $Output_capaian['kdunitkerja'];
				$value[3] = $Output_capaian['kdgiat'];
				$value[4] = $Output_capaian['kdoutput'];
				$value[5] = $Output_capaian['kriteria'];
				$value[6] = $Output_capaian['ukuran'];
				if($kdtriwulan == 1 ){
					$value[8] = $Output_capaian['kendala_b6'];
					$value[9] = $Output_capaian['kendala_b9'];
					$value[10] = $Output_capaian['kendala_b12'];
					$value[12] = $Output_capaian['tindak_lanjut_b6'];
					$value[13] = $Output_capaian['tindak_lanjut_b9'];
					$value[14] = $Output_capaian['tindak_lanjut_b12'];
					$value[16] = $Output_capaian['dapat_membantu_b6'];
					$value[17] = $Output_capaian['dapat_membantu_b9'];
					$value[18] = $Output_capaian['dapat_membantu_b12'];
				}elseif($kdtriwulan == 2 ){
					$value[7] = $Output_capaian['kendala_b3'];
					$value[9] = $Output_capaian['kendala_b9'];
					$value[10] = $Output_capaian['kendala_b12'];
					$value[11] = $Output_capaian['tindak_lanjut_b3'];
					$value[13] = $Output_capaian['tindak_lanjut_b9'];
					$value[14] = $Output_capaian['tindak_lanjut_b12'];
					$value[15] = $Output_capaian['dapat_membantu_b3'];
					$value[17] = $Output_capaian['dapat_membantu_b9'];
					$value[18] = $Output_capaian['dapat_membantu_b12'];
				}elseif($kdtriwulan == 3 ){
					$value[7] = $Output_capaian['kendala_b3'];
					$value[8] = $Output_capaian['kendala_b6'];
					$value[10] = $Output_capaian['kendala_b12'];
					$value[11] = $Output_capaian['tindak_lanjut_b3'];
					$value[12] = $Output_capaian['tindak_lanjut_b6'];
					$value[14] = $Output_capaian['tindak_lanjut_b12'];
					$value[15] = $Output_capaian['dapat_membantu_b3'];
					$value[16] = $Output_capaian['dapat_membantu_b6'];
					$value[18] = $Output_capaian['dapat_membantu_b12'];
				}elseif($kdtriwulan == 4 ){
					$value[7] = $Output_capaian['kendala_b3'];
					$value[8] = $Output_capaian['kendala_b6'];
					$value[9] = $Output_capaian['kendala_b9'];
					$value[11] = $Output_capaian['tindak_lanjut_b3'];
					$value[12] = $Output_capaian['tindak_lanjut_b6'];
					$value[13] = $Output_capaian['tindak_lanjut_b9'];
					$value[15] = $Output_capaian['dapat_membantu_b3'];
					$value[16] = $Output_capaian['dapat_membantu_b6'];
					$value[17] = $Output_capaian['dapat_membantu_b9'];
				}
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdtriwulan=<?php echo $kdtriwulan ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdtriwulan=<?php echo $kdtriwulan ?>"><?php		
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
      <td width="562"><strong><?php echo $Output_capaian['th'] ?></strong></td>
    </tr>
    
    <tr> 
      <td class="key">UNIT ESELON</td>
      <td><?php echo nm_unit($Output_capaian['kdunitkerja']) ?></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr> 
      <td class="key">KEGIATAN</td>
      <td><?php echo '['.$Output_capaian['kdgiat'].'] '.nm_giat($Output_capaian['kdgiat']) ?></td>
    </tr>
    <tr> 
      <td class="key">OUTPUT</td>
      <td><?php echo '['.$Output_capaian['kdoutput'].'] '.nm_output($Output_capaian['kdgiat'].$Output_capaian['kdoutput']) ?></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<?php if( $kdtriwulan == 1 ) {?>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Triwulan I (B3) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Kendala</td>
      <td><textarea name="<?php echo $field[7] ?>" rows="3" cols="70"><?php echo $value[7] ?></textarea></td>
    </tr>
    
    <tr>
      <td class="key">Tindak Lanjut </td>
      <td><textarea name="<?php echo $field[11] ?>" rows="3" cols="70"><?php echo $value[11] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Yang diharapkan dapat membantu </td>
      <td><textarea name="<?php echo $field[15] ?>" rows="3" cols="70"><?php echo $value[15] ?></textarea></td>
    </tr>
<?php } ?>
<?php if( $kdtriwulan == 2 ) {?>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Triwulan II (B6) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Kendala</td>
      <td><textarea name="<?php echo $field[8] ?>" rows="3" cols="70"><?php echo $value[8] ?></textarea></td>
    </tr>
    
    <tr>
      <td class="key">Tindak Lanjut </td>
      <td><textarea name="<?php echo $field[12] ?>" rows="3" cols="70"><?php echo $value[12] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Yang diharapkan dapat membantu </td>
      <td><textarea name="<?php echo $field[16] ?>" rows="3" cols="70"><?php echo $value[16] ?></textarea></td>
    </tr>
<?php } ?>	
<?php if( $kdtriwulan == 3 ) {?>
    <tr>
      <td colspan="2" class="key"><div align="center"><strong>Triwulan III (B9) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Kendala</td>
      <td><textarea name="<?php echo $field[9] ?>" rows="3" cols="70"><?php echo $value[9] ?></textarea></td>
    </tr>
    
    <tr>
      <td class="key">Tindak Lanjut </td>
      <td><textarea name="<?php echo $field[13] ?>" rows="3" cols="70"><?php echo $value[13] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Yang diharapkan dapat membantu </td>
      <td><textarea name="<?php echo $field[17] ?>" rows="3" cols="70"><?php echo $value[17] ?></textarea></td>
    </tr>
<?php } ?>	
<?php if( $kdtriwulan == 4 ) {?>
    <tr>
      <td colspan="2" class="key"><div align="center"><strong>Triwulan VI (B12) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Kendala</td>
      <td><textarea name="<?php echo $field[10] ?>" rows="3" cols="70"><?php echo $value[10] ?></textarea></td>
    </tr>
    
    <tr>
      <td class="key">Tindak Lanjut </td>
      <td><textarea name="<?php echo $field[14] ?>" rows="3" cols="70"><?php echo $value[14] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Yang diharapkan dapat membantu </td>
      <td><textarea name="<?php echo $field[18] ?>" rows="3" cols="70"><?php echo $value[18] ?></textarea></td>
    </tr>
<?php } ?>    
    
    
    
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdtriwulan=<?php echo $kdtriwulan ?>')">Batal</a>          </div>
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