<?php
	checkauthentication();
	$table = "mst_skp";
	$field = array("id","tahun","nib","kdunitkerja","kdjabatan","kdgol","is_approved_awal","tgl_approved_awal", "is_approved_akhir", "tgl_approved_akhir","nib_atasan", "jabatan_atasan", "kdgol_atasan","grade","tanggal_mulai"); 
	$err = false;
	$p = $_GET['p'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$kdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$q = $_GET['q'];
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
				$value[1] = $th ;
				$nib = $value[2];
				$value[3] = kdunitkerja_peg($nib) ;
				$value[5] = kdgol_peg($nib) ;
				$value[12] = kdgol_peg($value[10]) ;
				$value[11] = jabstruk_peg($value[10]) ;
				$value[6] = '0' ;
				$value[8] = '0' ;
				if ( $value[13] <> nil_grade($value[4]) )   $value[13] = nil_grade($value[4]) ;
				else $grade = $value[13] ;
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $th ;
				$nib = $value[2];
				$kdunitkerja = kdunitkerja_peg($nib) ;
				$kdjabatan = $value[4];
				if ( $value[13] <> nil_grade($value[4]) )   $grade = nil_grade($value[4]) ;
				else $grade = $value[13] ;
				$kdgol = $value[5];
				$tanggal_mulai = $value[14];
/*				$value[3] = kdunitkerja_peg($nib) ;
				$value[5] = kdgol_peg($nib) ;
				$value[12] = kdgol_peg($value[10]) ;
				$value[11] = jabstruk_peg($value[10]) ;
				$value[6] = '0' ;
				$value[8] = '0' ;
				if ( $value[13] == 0 )   $value[13] = nil_grade($value[4]) ; */
				$sql = "UPDATE $table SET nib = '$nib' , kdunitkerja = '$kdunitkerja' , kdjabatan = '$kdjabatan' , grade = '$grade', kdgol = '$kdgol' , tanggal_mulai = '$tanggal_mulai' WHERE id = '$q' ";
//				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>
<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
<script language="javascript" src="js/skp_combo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>&q=<?php echo $q ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="497" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Tahun</td>
		  <td width="250"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $th ?>" readonly=""/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><select name="<?php echo $field[2] ?>" onChange="get_jabatan(nib.value)">
                      <option value="<?php echo $value[2] ?>"><?php echo  '['.$value[2].'] '.nama_peg($value[2]) ?></option>
                      <option value="">- Pilih Nama Pegawai -</option>
                    <?php
							$query = mysql_query("select Nib,left(NamaLengkap,60) as namapeg from m_idpegawai where left(KdUnitKerja,2) = '$kdunit' and (KdStatusPeg = '1' or KdStatusPeg = '2' ) order by NamaLengkap");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['Nib'] ?>"><?php echo  $row['Nib'].' '.$row['namapeg']; ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
		  <td class="key">Jabatan pada SKP </td>
		  <td><div id="jabatan-view"> 
		  <select name="<?php echo $field[4] ?>">
                      <option value="<?php echo $value[4] ?>"><?php echo  '['.$value[4].'] '.nm_jabatan_ij($value[4]) ?></option>
                      <option value="">- Pilih Jabatan -</option>
                    <?php
							$query = mysql_query("select kode_jabatan, nama_jabatan from mst_info_jabatan
							where left(kdunitkerja,2) = '$kdunit' order by kode_jabatan");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <!--option value="<?php echo $row['kode_jabatan'] ?>"><?php echo  '['.$row['kode_jabatan'].'] '.$row['nama_jabatan']; ?></option-->
                    <?php
						} ?>
                  </select></div></td>
	  </tr>
		<tr>
		  <td class="key">TMT Jabatan </td>
		  <td><input name="<?php echo $field[14] ?>" type="text" class="form" id="<?php echo $field[14] ?>" 
					size="10" value="<?php echo $value[14] ?>"/>&nbsp;
				
				<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "<?php echo $field[14] ?>",
						button : "a_triggerIMG",
						align : "BR",
						firstDay : 1,
						weekNumbers : false,
						singleClick : true,
						showOthers : true,
						ifFormat : "%Y-%m-%d"
					});
				</script></td>
	  </tr>
		<tr>
		  <td class="key">Golongan</td>
		  <td><select name="<?php echo $field[5] ?>">
                      <option value="<?php echo $value[5] ?>"><?php echo  nm_gol($value[5]) ?></option>
                      <option value="">- Pilih Golongan -</option>
                    <?php
							$query = mysql_query("select KdGol, NmGol from kd_gol
							order by KdGol");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['KdGol'] ?>"><?php echo  nm_gol($row['KdGol']) ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
		  <td class="key">Grade</td>
		  <td><input type="text" name="<?php echo $field[13] ?>" size="10" value="<?php echo $value[13] ?>"/></td>
	  </tr>
		
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form_submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>