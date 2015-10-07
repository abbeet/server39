<?php
	checkauthentication();
	$table = "thuk_kak_output_capaian_hasil";
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
				$value[5] = $Output_capaian['persen_capaian_b3'];
				$value[6] = $Output_capaian['persen_capaian_b6'];
				$value[7] = $Output_capaian['persen_capaian_b9'];
				$value[8] = $Output_capaian['persen_capaian_b12'];
				$value[9] = $Output_capaian['pelaksanaan_b3'];
				$value[10] = $Output_capaian['pelaksanaan_b6'];
				$value[11] = $Output_capaian['pelaksanaan_b9'];
				$value[12] = $Output_capaian['pelaksanaan_b12'];
				$value[13] = $Output_capaian['capaian_b3'];
				$value[14] = $Output_capaian['capaian_b6'];
				$value[15] = $Output_capaian['capaian_b9'];
				$value[16] = $Output_capaian['capaian_b12'];
				if($kdtriwulan == 1 ){
					$value[18] = $Output_capaian['persen_hasil_b6'];
					$value[19] = $Output_capaian['persen_hasil_b9'];
					$value[20] = $Output_capaian['persen_hasil_b12'];
					$value[22] = $Output_capaian['uraian_hasil_b6'];
					$value[23] = $Output_capaian['uraian_hasil_b9'];
					$value[24] = $Output_capaian['uraian_hasil_b12'];
				}elseif($kdtriwulan == 2 ){
					$value[17] = $Output_capaian['persen_hasil_b3'];
					$value[19] = $Output_capaian['persen_hasil_b9'];
					$value[20] = $Output_capaian['persen_hasil_b12'];
					$value[21] = $Output_capaian['uraian_hasil_b3'];
					$value[23] = $Output_capaian['uraian_hasil_b9'];
					$value[24] = $Output_capaian['uraian_hasil_b12'];
				}elseif($kdtriwulan == 3 ){
					$value[17] = $Output_capaian['persen_hasil_b3'];
					$value[18] = $Output_capaian['persen_hasil_b6'];
					$value[20] = $Output_capaian['persen_hasil_b12'];
					$value[21] = $Output_capaian['uraian_hasil_b3'];
					$value[22] = $Output_capaian['uraian_hasil_b6'];
					$value[24] = $Output_capaian['uraian_hasil_b12'];
				}elseif($kdtriwulan == 4 ){
					$value[17] = $Output_capaian['persen_hasil_b3'];
					$value[18] = $Output_capaian['persen_hasil_b6'];
					$value[19] = $Output_capaian['persen_hasil_b9'];
					$value[21] = $Output_capaian['uraian_hasil_b3'];
					$value[22] = $Output_capaian['uraian_hasil_b6'];
					$value[23] = $Output_capaian['uraian_hasil_b9'];
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
      <td class="key">Persentase Hasil</td>
      <td><input type="text" name="<?php echo $field[17] ?>" value="<?php echo $value[17] ?>" size="10" />        &nbsp;&nbsp;%</td>
    </tr>
    
    <tr>
      <td class="key">Uraian Hasil  </td>
      <td><textarea name="<?php echo $field[21] ?>" rows="3" cols="70"><?php echo $value[21] ?></textarea></td>
    </tr>
<?php } ?>
<?php if( $kdtriwulan == 2 ) {?>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Triwulan II (B6) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase Hasil </td>
      <td><input type="text" name="<?php echo $field[18] ?>" value="<?php echo $value[18] ?>" size="10" />&nbsp;&nbsp;%</td>
    </tr>
    
    <tr>
      <td class="key">Uraian Hasil  </td>
      <td><textarea name="<?php echo $field[22] ?>" rows="3" cols="70"><?php echo $value[22] ?></textarea></td>
    </tr>
<?php } ?>	
<?php if( $kdtriwulan == 3 ) {?>
    <tr>
      <td colspan="2" class="key"><div align="center"><strong>Triwulan III (B9) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase Hasil </td>
      <td><input type="text" name="<?php echo $field[19] ?>" value="<?php echo $value[19] ?>" size="10"> 
        &nbsp;&nbsp;%</td>
    </tr>
    
    <tr>
      <td class="key">Uraian Hasil </td>
      <td><textarea name="<?php echo $field[23] ?>" rows="3" cols="70"><?php echo $value[23] ?></textarea></td>
    </tr>
<?php } ?>	
<?php if( $kdtriwulan == 4 ) {?>
    <tr>
      <td colspan="2" class="key"><div align="center"><strong>Triwulan VI (B12) </strong></div></td>
    </tr>
    <tr>
      <td class="key">Persentase Hasil </td>
      <td><input type="text" name="<?php echo $field[20] ?>" value="<?php echo $value[20] ?>" size="10"> 
        &nbsp;&nbsp;%</td>
    </tr>
    
    <tr>
      <td class="key">Uraian Hasil  </td>
      <td><textarea name="<?php echo $field[24] ?>" rows="3" cols="70"><?php echo $value[24] ?></textarea></td>
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