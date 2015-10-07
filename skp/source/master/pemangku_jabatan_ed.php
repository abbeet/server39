<?php
	checkauthentication();
	$table = "mst_skp";
	$field = array("id","tahun","nip","kdunitkerja","kdjabatan","kdgol","nib_atasan"); 
	$err = false;
	$p = $_GET['p'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	if ( $_REQUEST['xkdunit'] == ''  )   $kdunit = $_SESSION['xkdunit'];
	$kdunit = $_REQUEST['xkdunit'];
	
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
				$value[3] = kdunitkerja_nip($nib) ;
				$value[5] = kdgol_nip($nib) ;
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php $_REQUEST['xkdunit'] ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $th ;
				$nib = $value[2];
				$kdunitkerja = kdunitkerja_nip($nib) ;
				$kdgol = kdgol_nip($nib) ;
				$kdjabatan = $value[4] ;
				$nib_atasan = $value[6] ;
				$sql = "UPDATE $table SET nip = '$nib' , kdunitkerja = '$kdunitkerja' , kdjabatan = '$kdjabatan' , kdgol = '$kdgol' , nib_atasan = '$nib_atasan' WHERE id = '$q' ";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>"><?php		
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
<form action="index.php?p=<?php echo $_GET['p'] ?>&q=<?php echo $q ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>" method="post" name="form">
	<table width="638" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="188" class="key">Tahun</td>
		  <td width="441"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $th ?>" readonly=""/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><select name="<?php echo $field[2] ?>" onchange="get_jabatan(nip.value)">
            <option value="<?php echo $value[2] ?>"><?php echo  '['.$value[2].'] '.nama_peg($value[2]) ?></option>
            <option value="">- Pilih Nama Pegawai -</option>
            <?php
							$query = mysql_query("select nip,left(nama,60) as namapeg from m_idpegawai order by nama");
					
						while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['nip'] ?>"><?php echo  $row['nip'].' '.$row['namapeg']; ?></option>
            <?php
						} ?>
          </select></td>
		</tr>
		<tr>
		  <td class="key">Jabatan pada SKP </td>
		  <td><div id="jabatan-view">
		    <select name="<?php echo $field[4] ?>"  onchange="get_atasan(this.value,<?php echo $kdunit ?>)">
              <option value="<?php echo $value[4] ?>"><?php echo  '['.$value[4].'] '.nm_jabatan_ij($value[4]) ?></option>
              <option value="">- Pilih Jabatan -</option>
              <?php
							$query = mysql_query("select kode_jabatan, nama_jabatan from mst_info_jabatan
							where left(kdunitkerja,2) = '$kdunit' order by kode_jabatan");
					
						while($row = mysql_fetch_array($query)) { ?>
              <!--option value="<?php echo $row['kode_jabatan'] ?>"><?php echo  '['.$row['kode_jabatan'].'] '.$row['nama_jabatan']; ?></option-->
              <?php
						} ?>
            </select>
		  </div></td>
	  </tr>
		
		<tr>
		  <td class="key">Atasan/Penilai pada SKP</td>
		  <td><div id="atasan-view"><select name="<?php echo $field[6] ?>">
                      <option value="<?php echo $value[6] ?>"><?php echo  '['.$value[6].'] '.nama_peg($value[6]) ?></option>
                      <option value="">- Pilih Nama Penilai -</option>
                    <?php
							$query = mysql_query("select nip,nama from m_idpegawai where (left(kdunitkerja,4) = '$kdunit' and kdeselon <> '00') or right(kdunitkerja,3) = '000' or left(kdunitkerja,3) = '427' order by nama");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['nip'] ?>"><?php echo  '['.$row['nip'].'] '.$row['nama']; ?></option>
                    <?php
						} ?>
                  </select></div></td>
	  </tr>
		
		
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit'] ?>')">Batal</a>					</div>
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