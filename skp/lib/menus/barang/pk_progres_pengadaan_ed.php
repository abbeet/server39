<?php
	checkauthentication();
	$table = "thuk_ren_pengadaan";
	$field = get_field($table);
	$err = false;
	$pagess = $_REQUEST['pagess'];
	$p = $_GET['p'];
	$q = $_GET['q'];
	$o = $_GET['o'];

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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>"><?php
				exit();
			} 
			else {
				// UPDATE
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
	} ?><form action="" method="post" name="form" enctype="multipart/form-data">
	
  <table width="762" cellspacing="1" class="admintable">
    <tr>
                  <td width="185" class="key">Tahun</td>
                  <td width="568" colspan="3"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php if( $q == '' ) { echo $th ; }else{ ?><?php echo $value[1] ?><?php }?>" readonly/></td>
    </tr>
    
    <tr>
                  <td class="key">Satker</td>
                  <td colspan="3"><input type="text" name="<?php echo $field[2] ?>" size="20" value="<?php echo $value[2]?>" readonly/><br /><textarea rows="1" cols="70" readonly><?php echo nm_satker($value[2]) ?></textarea></td>
    </tr>
    <tr>
                  <td class="key">Nama Pekerjaan </td>
                  <td colspan="3"><textarea name="<?php echo $field[3] ?>" rows="2" cols="70" readonly><?php echo $value[3] ?></textarea>                  </td>
    </tr>
    		<tr>
                  <td class="key">Pagu</td>
                  <td colspan="3"><input type="text" name="<?php echo $field[4] ?>" size="20" value="<?php echo $value[4] ?>" readonly/></td>
    </tr>
    <tr>
      <td colspan="2" class="key"><table width="684" cellpadding="1" class="adminlist">
                    <thead>
                      <tr>
                        <th width="24">No.</th>
                        <th width="101">Tahap<br />
                        Pengadaan </th>
                        <th width="98">Rencana</th>
                        <th width="212">Realisasi</th>
                        <th width="225">Catatan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">1.</td>
                        <td rowspan="2" align="left">Pengumuman Lelang </td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[5] ?>" type="text" size="12" value="<?php echo $value[5] ?>" readonly/> s/d<br />
                          <input name="<?php echo $field[6] ?>" type="text" size="12" value="<?php echo $value[6] ?>" readonly/></td>
                        <td align="left"> Tanggal <input name="<?php echo $field[7] ?>" type="text" class="form" id="<?php echo $field[7] ?>" size="12" value="<?php echo $value[7] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[7] ?>",
					button			: "a_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[10] ?>" rows="2" cols="30"><?php echo $value[10] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[8] ?>" type="text" size="30" value="<?php echo $value[8] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">2.</td>
                        <td rowspan="2" align="left">Pendaftaran Lelang </td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[11] ?>" type="text" size="12" value="<?php echo $value[11] ?>" readonly/> s/d <br /><input name="<?php echo $field[12] ?>" type="text" size="12" value="<?php echo $value[12] ?>" readonly/>                    </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[13] ?>" type="text" class="form" id="<?php echo $field[13] ?>" size="12" value="<?php echo $value[13] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[13] ?>",
					button			: "b_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[16] ?>" rows="2" cols="30"><?php echo $value[16] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[14] ?>" type="text" size="30" value="<?php echo $value[14] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">3.</td>
                        <td rowspan="2" align="left">Aanwijzing</td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[17] ?>" type="text" size="12" value="<?php echo $value[17] ?>" readonly/> s/d <br /><input name="<?php echo $field[18] ?>" type="text" size="12" value="<?php echo $value[18] ?>" readonly/>                    </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[19] ?>" type="text" class="form" id="<?php echo $field[19] ?>" size="12" value="<?php echo $value[19] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="c_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[19] ?>",
					button			: "c_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[22] ?>" rows="2" cols="30"><?php echo $value[22] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[20] ?>" type="text" size="30" value="<?php echo $value[20] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">4.</td>
                        <td rowspan="2" align="left">Penawaran</td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[23] ?>" type="text" size="12" value="<?php echo $value[23] ?>" readonly/> s/d <br /><input name="<?php echo $field[24] ?>" type="text" size="12" value="<?php echo $value[24] ?>" readonly/>                    </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[25] ?>" type="text" class="form" id="<?php echo $field[25] ?>" size="12" value="<?php echo $value[25] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="d_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[25] ?>",
					button			: "d_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[28] ?>" rows="2" cols="30"><?php echo $value[28] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[26] ?>" type="text" size="30" value="<?php echo $value[26] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">5.</td>
                        <td rowspan="2" align="left">Evaluasi</td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[29] ?>" type="text" size="12" value="<?php echo $value[29] ?>" readonly/> s/d<br /><input name="<?php echo $field[30] ?>" type="text" size="12" value="<?php echo $value[30] ?>" readonly/>                   </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[31] ?>" type="text" class="form" id="<?php echo $field[31] ?>" size="12" value="<?php echo $value[31] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="e_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[31] ?>",
					button			: "e_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[34] ?>" rows="2" cols="30"><?php echo $value[34] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[32] ?>" type="text" size="30" value="<?php echo $value[32] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">6.</td>
                        <td rowspan="2" align="left">Penetapan</td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[35] ?>" type="text" size="12" value="<?php echo $value[35] ?>" readonly/> s/d<br /><input name="<?php echo $field[36] ?>" type="text" size="12" value="<?php echo $value[36] ?>" readonly/>                    </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[37] ?>" type="text" class="form" id="<?php echo $field[37] ?>" size="12" value="<?php echo $value[37] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="f_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[37] ?>",
					button			: "f_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[40] ?>" rows="2" cols="30"><?php echo $value[40] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[38] ?>" type="text" size="30" value="<?php echo $value[38] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">7.</td>
                        <td rowspan="2" align="left">Kontrak</td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[41] ?>" type="text" size="12" value="<?php echo $value[41] ?>" readonly/> s/d<br /><input name="<?php echo $field[42] ?>" type="text" size="12" value="<?php echo $value[42] ?>" readonly/>                    </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[43] ?>" type="text" class="form" id="<?php echo $field[43] ?>" size="12" value="<?php echo $value[43] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="g_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[43] ?>",
					button			: "g_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[46] ?>" rows="2" cols="30"><?php echo $value[46] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[44] ?>" type="text" size="30" value="<?php echo $value[44] ?>"/></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td rowspan="2" align="center">8.</td>
                        <td rowspan="2" align="left">Serah Terima </td>
                        <td rowspan="2" align="left"><input name="<?php echo $field[47] ?>" type="text" class="form" size="12" value="<?php echo $value[47] ?>" readonly/> s/d <br /><input name="<?php echo $field[48] ?>" type="text" class="form" size="12" value="<?php echo $value[48] ?>" readonly/>                    </td>
                        <td align="left"> Tanggal <input name="<?php echo $field[49] ?>" type="text" class="form" id="<?php echo $field[49] ?>" size="12" value="<?php echo $value[49] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="h_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[49] ?>",
					button			: "h_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td rowspan="2" align="left"><textarea name="<?php echo $field[52] ?>" rows="2" cols="30"><?php echo $value[52  ] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="left">No Doc.<input name="<?php echo $field[50] ?>" type="text" size="30" value="<?php echo $value[50] ?>"/></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="5">&nbsp;</td>
                      </tr>
                    </tfoot>
                  </table></td>
    </tr>
    
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
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