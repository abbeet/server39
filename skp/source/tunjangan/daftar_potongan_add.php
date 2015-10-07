<?php
	checkauthentication();
	$table = "mst_potongan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$pagess = $_REQUEST['pagess'];
//	$kdbulan = $_REQUEST['kdbulan'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];;
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
				$nib = $value[3];
				$value[4] = nip_mst_tk($nib) ;
				$value[7] = kdgol_mst_tk($nib) ;
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>"><?php
				exit();
			} 
			else {
				// UPDATE
//				$kdpot_10 = $value[8];
//				$kdpot_11 = $value[9];
//				$kdpot_12 = $value[10];
//				$kdpot_13 = $value[11];
//				$kdpot_14 = $value[12];
//				$kdpot_15 = $value[13];
//				$kdpot_16 = $value[14];
//				$sql = "UPDATE $table SET kdpot_10 = '$kdpot_10', kdpot_11 = '$kdpot_11', kdpot_12 = '$kdpot_12', kdpot_13 = '$kdpot_13', kdpot_14 = '$kdpot_14', kdpot_15 = '$kdpot_15', kdpot_16 = '$kdpot_16' where id = '$q' ";
//				$sql = sql_update($table,$field,$value);
//				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>&sw=<?php echo $sw ?>" method="post" name="form">
	<table width="692" cellspacing="1" class="admintable">
		
		<tr>
		  <td class="key">Pusat/Biro</td>
		  <td><strong><?php echo nm_unitkerja($xkdunit.'00') ?></strong></td>
	  </tr>
		<tr>
		  <td width="158" class="key">Potongan TK  Bulan </td>
		  <td width="525"><input type="text" name="<?php echo $field[2] ?>" size="5" value="<?php echo $value[2] ?>" />&nbsp;Tahun&nbsp;<input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" />&nbsp;( Misal : 01 Tahun 2012, 02 Tahun 2012, ...)</td>
	  </tr>
		<tr>
		  <td class="key">Satuan Kerja </td>
		  <td><select name="<?php echo $field[5] ?>">
                      <option value="<?php echo $value[5] ?>"><?php echo  $value[5].' '.nm_satker($value[5]) ?></option>
                      <option value="">- Pilih Satuan Kerja -</option>
                    <?php
				$query = mysql_query("select kdsatker,left(nmsatker,60) as namasatker from kd_satker where kdunitkerja = '$xkdunit' order by kdunitkerja");
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['kdsatker'].' '.$row['namasatker']; ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td><select name="<?php echo $field[6] ?>">
                      <option value="<?php echo $value[6] ?>"><?php echo  '['.$value[6].'] '.nm_unitkerja($value[6]) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
				if ( $xkdunit == '13' )
				{
				$query = mysql_query("select kdunit,left(nmunit,60) as namaunit from kd_unitkerja where ( left(kdunit,2) = '$xkdunit' or kdunit = '0000' or kdunit = '1000' or kdunit = '2000' or kdunit = '3000' or kdunit = '4000' or kdunit = '5000' ) order by kdunit");
				}else{
				$query = mysql_query("select kdunit,left(nmunit,60) as namaunit from kd_unitkerja where left(kdunit,2) = '$xkdunit' order by kdunit");
				}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['kdunit'].' '.$row['namaunit']; ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
          <td class="key">Nama Pegawai </td>
		  <td><select name="<?php echo $field[3] ?>">
                      <option value="<?php echo $value[3] ?>"><?php echo  nama_peg($value[3]) ?></option>
                      <option value="">- Pilih Pegawai -</option>
                    <?php
					$kdsatker = kdsatker_unit($xkdunit) ;
				$query = mysql_query("select nib from mst_tk where kdsatker = '$kdsatker' group by nib order by nib");
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['nib'] ?>"><?php echo  $row['nib'].' '.nama_peg($row['nib']); ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
		  <td class="key">Grade</td>
		  <td><input type="text" name="<?php echo $field[17] ?>" size="10" value="<?php echo $value[17] ?>" /></td>
	  </tr>
		
		<tr>
		  <td colspan="2" align="center"><strong>JUMLAH KEHADIRAN :</strong></td>
	  </tr>
		<tr>
		  <td class="key">TL1</td>
		  <td><input type="text" name="<?php echo $field[18] ?>" size="5" value="<?php echo $value[18] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">TL2</td>
		  <td><input type="text" name="<?php echo $field[19] ?>" size="5" value="<?php echo $value[19] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">TL3</td>
		  <td><input type="text" name="<?php echo $field[20] ?>" size="5" value="<?php echo $value[20] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">TL4</td>
		  <td><input type="text" name="<?php echo $field[21] ?>" size="5" value="<?php echo $value[21] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">PSW1</td>
		  <td><input type="text" name="<?php echo $field[22] ?>" size="5" value="<?php echo $value[22] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">PSW2</td>
		  <td><input type="text" name="<?php echo $field[23] ?>" size="5" value="<?php echo $value[23] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">PSW3</td>
		  <td><input type="text" name="<?php echo $field[24] ?>" size="5" value="<?php echo $value[24] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">PSW4</td>
		  <td><input type="text" name="<?php echo $field[25] ?>" size="5" value="<?php echo $value[25] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
		  <td colspan="2" align="center"><strong>JUMLAH CUTI</strong></td>
	  </tr>
		<tr>
		  <td class="key">Tanpa Keterangan</td>
		  <td><input type="text" name="<?php echo $field[8] ?>" size="5" value="<?php echo $value[8] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">Cuti Tahunan </td>
		  <td><input type="text" name="<?php echo $field[9] ?>" size="5" value="<?php echo $value[9] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">Cuti Besar </td>
		  <td><input type="text" name="<?php echo $field[10] ?>" size="5" value="<?php echo $value[10] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">Cuti Sakit Rawat Inap </td>
		  <td><input type="text" name="<?php echo $field[11] ?>" size="5" value="<?php echo $value[11] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">Cuti Sakit Rawat Jalan </td>
		  <td><input type="text" name="<?php echo $field[12] ?>" size="5" value="<?php echo $value[12] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">Cuti Melahirkan </td>
		  <td><input type="text" name="<?php echo $field[13] ?>" size="5" value="<?php echo $value[13] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key">Cuti Penting </td>
		  <td><input type="text" name="<?php echo $field[14] ?>" size="5" value="<?php echo $value[14] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td colspan="2" align="center"><strong>PENDIDIKAN DAN PELATIHAN</strong></td>
	  </tr>
		<tr>
		  <td class="key">Kurang dari 3 bulan</td>
		  <td><input type="text" name="<?php echo $field[26] ?>" size="5" value="<?php echo $value[26] ?>"/>&nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">3 Bulan atau lebih</td>
		  <td><input type="text" name="<?php echo $field[27] ?>" size="5" value="<?php echo $value[27] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdbulan=<?php echo $kdbulan ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>