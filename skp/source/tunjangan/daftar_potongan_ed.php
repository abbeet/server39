<?php
	checkauthentication();
	$table = "mst_potongan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$pagess = $_REQUEST['pagess'];
	$kdbulan = $_REQUEST['kdbulan'];
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
				$kdunitkerja = $value[6];
				$grade = $value[17];
				$kdpot_10 = $value[8];
				$kdpot_11 = $value[9];
				$kdpot_12 = $value[10];
				$kdpot_13 = $value[11];
				$kdpot_14 = $value[12];
				$kdpot_15 = $value[13];
				$kdpot_16 = $value[14];
				$kdpot_01 = $value[18];
				$kdpot_02 = $value[19];
				$kdpot_03 = $value[20];
				$kdpot_04 = $value[21];
				$kdpot_05 = $value[22];
				$kdpot_06 = $value[23];
				$kdpot_07 = $value[24];
				$kdpot_08 = $value[25];
				$kdpot_21 = $value[26];
				$kdpot_22 = $value[27];
				$kdpot_31 = $value[28];
				$kdpot_32 = $value[29];
				$kdpot_33 = $value[30];
				$kdpot_34 = $value[31];
				$kdpot_40 = $value[32];
				$kdpot_tk = $value[33];
				$kdpot_cm = $value[34];
//				$sql = "UPDATE $table SET kdunitkerja = '$kdunitkerja', grade = '$grade', 
	//				kdpot_10 = '$kdpot_10', kdpot_11 = '$kdpot_11', kdpot_12 = '$kdpot_12', kdpot_13 = '$kdpot_13', kdpot_14 = '$kdpot_14', kdpot_15 = '$kdpot_15', kdpot_16 = '$kdpot_16' , 
//					kdpot_01 = '$kdpot_01', kdpot_02 = '$kdpot_02', kdpot_03 = '$kdpot_03', kdpot_04 = '$kdpot_04', kdpot_05 = '$kdpot_05', kdpot_06 = '$kdpot_06', kdpot_07 = '$kdpot_07', kdpot_08 = '$kdpot_08',
//					kdpot_21 = '$kdpot_21', kdpot_22 = '$kdpot_22', kdpot_31 = '$kdpot_31', kdpot_32 = '$kdpot_32', kdpot_33 = '$kdpot_33', kdpot_34 = '$kdpot_34', kdpot_40 = '$kdpot_40', where id = '$q' ";
//				$sql = sql_update($table,$field,$value);
				$sql = "UPDATE $table SET kdunitkerja = '$kdunitkerja', grade = '$grade', 
					kdpot_01 = '$kdpot_01', kdpot_02 = '$kdpot_02', kdpot_03 = '$kdpot_03', kdpot_04 = '$kdpot_04', kdpot_05 = '$kdpot_05', kdpot_06 = '$kdpot_06', kdpot_07 = '$kdpot_07', kdpot_08 = '$kdpot_08',
					kdpot_31 = '$kdpot_31', kdpot_32 = '$kdpot_32', kdpot_33 = '$kdpot_33', kdpot_34 = '$kdpot_34', 
					kdpot_10 = '$kdpot_10', kdpot_11 = '$kdpot_11', kdpot_12 = '$kdpot_12', kdpot_13 = '$kdpot_13', kdpot_14 = '$kdpot_14', kdpot_15 = '$kdpot_15', kdpot_16 = '$kdpot_16',
					kdpot_21 = '$kdpot_21', kdpot_22 = '$kdpot_22', kdpot_40 = '$kdpot_40', kdpot_tk = '$kdpot_tk',
					kdpot_cm = '$kdpot_cm'
					where id = '$q' ";
				$rs = mysql_query($sql);
				
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
	<table width="746" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="220" class="key">Potongan TK  Bulan </td>
		  <td width="517"><input type="text" name="<?php echo $field[2] ?>" size="5" value="<?php echo $value[2] ?>" readonly/>&nbsp;Tahun&nbsp;<input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Satuan Kerja </td>
		  <td><input type="text" name="<?php echo $field[5] ?>" size="60" value="<?php echo nm_satker($value[5]) ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="60" value="<?php echo nama_peg($value[3]) ?>" readonly/></td>
	  </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td><select name="<?php echo $field[6] ?>">
                      <option value="<?php echo $value[6] ?>"><?php echo  '['.$value[6].'] '.nm_unitkerja($value[6]) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
switch ( $xlevel )
{
        case '7':				
		        if ( $xusername == '017279' )
				{	
				$query = mysql_query("select kdunit,left(nmunit,60) as namaunit from kd_unitkerja where left(kdunit,2) = '11' or left(kdunit,2) = '12' or left(kdunit,2) = '13' or left(kdunit,2) = '14' or right(kdunit,3) = '000' order by kdunit");
				}else{
				$query = mysql_query("select kdunit,left(nmunit,60) as namaunit from kd_unitkerja where left(kdunit,2) = '$xkdunit' order by kdunit");
				}
		break;
		
		default:
				$query = mysql_query("select kdunit,left(nmunit,60) as namaunit from kd_unitkerja order by kdunit");
		break;
}		
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['kdunit'].' '.$row['namaunit']; ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
		  <td class="key">Grade</td>
		  <td><input type="text" name="<?php echo $field[17] ?>" size="10" value="<?php echo $value[17] ?>"/></td>
	  </tr>
		
		<tr>
		  <td colspan="2" align="center"><strong>JUMLAH KEHADIRAN :</strong></td>
	  </tr>
		<tr>
		  <td class="key"><strong>Terlambat (TL)</strong></td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
          <td class="key">TL1</td>
		  <td><input type="text" name="<?php echo $field[18] ?>" size="5" value="<?php echo $value[18] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">TL2</td>
		  <td><input type="text" name="<?php echo $field[19] ?>" size="5" value="<?php echo $value[19] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">TL3</td>
		  <td><input type="text" name="<?php echo $field[20] ?>" size="5" value="<?php echo $value[20] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">TL4</td>
		  <td><input type="text" name="<?php echo $field[21] ?>" size="5" value="<?php echo $value[21] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key"><strong>Keluar Sementara</strong></td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
          <td class="key">KS1</td>
		  <td><input type="text" name="<?php echo $field[28] ?>" size="5" value="<?php echo $value[28] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">KS2</td>
		  <td><input type="text" name="<?php echo $field[29] ?>" size="5" value="<?php echo $value[29] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">KS3</td>
		  <td><input type="text" name="<?php echo $field[30] ?>" size="5" value="<?php echo $value[30] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		
		<tr>
          <td class="key">KS4</td>
		  <td><input type="text" name="<?php echo $field[31] ?>" size="5" value="<?php echo $value[31] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td class="key"><strong>Pulang Sebelum Waktu (PSW)</strong></td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
          <td class="key">PSW1</td>
		  <td><input type="text" name="<?php echo $field[22] ?>" size="5" value="<?php echo $value[22] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">PSW2</td>
		  <td><input type="text" name="<?php echo $field[23] ?>" size="5" value="<?php echo $value[23] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
          <td class="key">PSW3</td>
		  <td><input type="text" name="<?php echo $field[24] ?>" size="5" value="<?php echo $value[24] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		
		<tr>
          <td class="key">PSW4</td>
		  <td><input type="text" name="<?php echo $field[25] ?>" size="5" value="<?php echo $value[25] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td colspan="2" align="center"><strong>JUMLAH CUTI :</strong></td>
	  </tr>
		<tr>
		  <td class="key">Tanpa Keterangan</td>
		  <td>
		  <?php switch ( $value[2] )
		  {
		       case '01':
		  ?>
		  <input type="text" name="<?php echo $field[33] ?>" size="5" value="<?php echo $value[33] ?>"/>
		  &nbsp;hari&nbsp;
				<?php 
				break;
				case '02':
				?>
		  <input type="text" name="<?php echo $field[33] ?>" size="5" value="<?php echo $value[33] ?>"/>
		  &nbsp;hari&nbsp;
				<?php 
				break;
				case '03':
				?>
		  <input type="text" name="<?php echo $field[8] ?>" size="5" value="<?php echo $value[8] ?>"/>
		  &nbsp;hari&nbsp;
		  <font color="#FF3399">[tgl. 7 s/d 30 Maret 2013]</font>&nbsp;&nbsp;
		  <input type="text" name="<?php echo $field[33] ?>" size="5" value="<?php echo $value[33] ?>"/>
		  &nbsp;hari&nbsp;<font color="#FF3399">[tgl. 1 s/d 6 Meret 2013]</font>
				<?php 
				break;
				default:
				?>
		        <input type="text" name="<?php echo $field[8] ?>" size="5" value="<?php echo $value[8] ?>"/>
		  &nbsp;hari&nbsp;
				<?php 
				break;
		}
				?>				
		  </td>
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
		  <td>
		  <?php switch ( $value[2] )
		  {
		       case '01':
		  ?>
		  <input type="text" name="<?php echo $field[34] ?>" size="5" value="<?php echo $value[34] ?>"/>
		  &nbsp;hari&nbsp;
				<?php 
				break;
				case '02':
				?>
		  <input type="text" name="<?php echo $field[34] ?>" size="5" value="<?php echo $value[34] ?>"/>
		  &nbsp;hari&nbsp;
				<?php 
				break;
				case '03':
				?>
		  <input type="text" name="<?php echo $field[13] ?>" size="5" value="<?php echo $value[13] ?>"/>
		  &nbsp;hari&nbsp;
		  <font color="#FF3399">[tgl. 7 s/d 30 Maret 2013]</font>&nbsp;&nbsp;
		  <input type="text" name="<?php echo $field[34] ?>" size="5" value="<?php echo $value[34] ?>"/>
		  &nbsp;hari&nbsp;<font color="#FF3399">[tgl. 1 s/d 6 Meret 2013]</font>
				<?php 
				break;
				default:
				?>
		        <input type="text" name="<?php echo $field[13] ?>" size="5" value="<?php echo $value[13] ?>"/>
		  &nbsp;hari&nbsp;
				<?php 
				break;
		}
				?>				
		  </td>
	  </tr>
		<tr>
		  <td class="key">Cuti Penting </td>
		  <td><input type="text" name="<?php echo $field[14] ?>" size="5" value="<?php echo $value[14] ?>"/>
		    &nbsp;hari</td>
	  </tr>
		<tr>
		  <td colspan="2" align="center"><strong>PENDIDIKAN DAN PELATIHAN :</strong></td>
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
		  <td class="key">&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
          <td class="key">Tidak Mengikuti Upacara Bendera</td>
		  <td><input type="text" name="<?php echo $field[32] ?>" size="5" value="<?php echo $value[32] ?>"/>
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