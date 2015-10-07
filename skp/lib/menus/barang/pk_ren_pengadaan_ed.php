<?php
	checkauthentication();
	$table = "thuk_ren_pengadaan";
	$field = get_field($table);
	$err = false;
	$pagess = $_REQUEST['pagess'];
	$p = $_GET['p'];
	$q = $_GET['q'];
	$o = $_GET['o'];
	$th = $_SESSION['xth'];

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
				$field[7] = $value[7] ; $field[8] = $value[8] ; $field[9] = $value[9] ;
				$field[13] = $value[13] ; $field[14] = $value[14] ; $field[15] = $value[15] ;
				$field[19] = $value[19] ; $field[20] = $value[20] ; $field[21] = $value[21] ;
				$field[25] = $value[25] ; $field[26] = $value[26] ; $field[27] = $value[27] ;
				$field[31] = $value[31] ; $field[32] = $value[32] ; $field[33] = $value[33] ;
				$field[37] = $value[37] ; $field[38] = $value[38] ; $field[39] = $value[39] ;
				$field[43] = $value[43] ; $field[44] = $value[44] ; $field[45] = $value[45] ;
				$field[49] = $value[49] ; $field[50] = $value[50] ; $field[51] = $value[51] ;
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
                  <td width="177" class="key">Tahun</td>
                  <td width="502" colspan="3"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php if( $q == '' ) { echo $th ; }else{ ?><?php echo $value[1] ?><?php }?>" readonly/></td>
                </tr>
    
    <tr>
                  <td class="key">Satker</td>
                  <td colspan="3"><select name="<?php echo $field[2] ?>">
                      <option value="<?php echo $value[2] ?>"><?php echo  '['.$value[2].'] '.nm_satker($value[2]) ?></option>
                      <option value="">- Pilih Satker -</option>
                    <?php
							$query = mysql_query("select KDSATKER,left(NMSATKER,60) as namasatker from t_satker ");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['KDSATKER'] ?>"><?php echo  $row['namasatker']; ?></option>
                    <?php
						} ?>
                  </select></td>
                </tr>
    <tr>
                  <td class="key">Nama Pekerjaan </td>
                  <td colspan="3"><textarea name="<?php echo $field[3] ?>" rows="3" cols="60"><?php echo $value[3] ?></textarea>                  </td>
                </tr>
    		<tr>
                  <td class="key">Pagu</td>
                  <td colspan="3"><input type="text" name="<?php echo $field[4] ?>" size="20" value="<?php echo $value[4] ?>" /></td>
                </tr>
    <tr>
      <td colspan="2" class="key"><table width="693" cellpadding="1" class="adminlist">
                    <thead>
                      <tr>
                        <th width="4%">No.</th>
                        <th width="18%">Tahap Pengadaan </th>
                        <th width="21%">dari Tanggal </th>
                        <th width="19%">s/d Tanggal </th>
                        <th width="38%">Catatan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="<?php echo $class ?>">
                        <td align="center">1.</td>
                        <td align="left">Pengumuman Lelang </td>
                        <td align="center"><input name="<?php echo $field[5] ?>" type="text" class="form" id="<?php echo $field[5] ?>" size="10" value="<?php echo $value[5] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[5] ?>",
					button			: "a_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[6] ?>" type="text" class="form" id="<?php echo $field[6] ?>" size="10" value="<?php echo $value[6] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[6] ?>",
					button			: "b_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[10] ?>" rows="1" cols="40"><?php echo $value[10] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">2.</td>
                        <td align="left">Pendaftaran Lelang </td>
                        <td align="center"><input name="<?php echo $field[11] ?>" type="text" class="form" id="<?php echo $field[11] ?>" size="10" value="<?php echo $value[11] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="c_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[11] ?>",
					button			: "c_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[12] ?>" type="text" class="form" id="<?php echo $field[12] ?>" size="10" value="<?php echo $value[12] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="d_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[12] ?>",
					button			: "d_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[16] ?>" rows="1" cols="40"><?php echo $value[16] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">3.</td>
                        <td align="left">Aanwijzing</td>
                        <td align="center"><input name="<?php echo $field[17] ?>" type="text" class="form" id="<?php echo $field[17] ?>" size="10" value="<?php echo $value[17] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="e_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[17] ?>",
					button			: "e_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[18] ?>" type="text" class="form" id="<?php echo $field[18] ?>" size="10" value="<?php echo $value[18] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="f_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[18] ?>",
					button			: "f_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[22] ?>" rows="1" cols="40"><?php echo $value[22] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">4.</td>
                        <td align="left">Penawaran</td>
                        <td align="center"><input name="<?php echo $field[23] ?>" type="text" class="form" id="<?php echo $field[23] ?>" size="10" value="<?php echo $value[23] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="g_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[23] ?>",
					button			: "g_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[24] ?>" type="text" class="form" id="<?php echo $field[24] ?>" size="10" value="<?php echo $value[24] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="h_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[24] ?>",
					button			: "h_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[28] ?>" rows="1" cols="40"><?php echo $value[28] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">5.</td>
                        <td align="left">Evaluasi</td>
                        <td align="center"><input name="<?php echo $field[29] ?>" type="text" class="form" id="<?php echo $field[29] ?>" size="10" value="<?php echo $value[29] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="i_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[29] ?>",
					button			: "i_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[30] ?>" type="text" class="form" id="<?php echo $field[30] ?>" size="10" value="<?php echo $value[30] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="j_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[30] ?>",
					button			: "j_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[34] ?>" rows="1" cols="40"><?php echo $value[34] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">6.</td>
                        <td align="left">Penetapan</td>
                        <td align="center"><input name="<?php echo $field[35] ?>" type="text" class="form" id="<?php echo $field[35] ?>" size="10" value="<?php echo $value[35] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="k_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[35] ?>",
					button			: "k_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[36] ?>" type="text" class="form" id="<?php echo $field[36] ?>" size="10" value="<?php echo $value[36] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="l_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[36] ?>",
					button			: "l_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[40] ?>" rows="1" cols="40"><?php echo $value[40] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">7.</td>
                        <td align="left">Kontrak</td>
                        <td align="center"><input name="<?php echo $field[41] ?>" type="text" class="form" id="<?php echo $field[41] ?>" size="10" value="<?php echo $value[41] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="m_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[41] ?>",
					button			: "m_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[42] ?>" type="text" class="form" id="<?php echo $field[42] ?>" size="10" value="<?php echo $value[42] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="n_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[42] ?>",
					button			: "n_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[46] ?>" rows="1" cols="40"><?php echo $value[46] ?></textarea></td>
                      </tr>
                      <tr class="<?php echo $class ?>">
                        <td align="center">8.</td>
                        <td align="left">Serah Terima </td>
                        <td align="center"><input name="<?php echo $field[47] ?>" type="text" class="form" id="<?php echo $field[47] ?>" size="10" value="<?php echo $value[47] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="o_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[47] ?>",
					button			: "o_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="center"><input name="<?php echo $field[48] ?>" type="text" class="form" id="<?php echo $field[48] ?>" size="10" value="<?php echo $value[48] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="p_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[48] ?>",
					button			: "p_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
                        <td align="left"><textarea name="<?php echo $field[52] ?>" rows="1" cols="40"><?php echo $value[52] ?></textarea></td>
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