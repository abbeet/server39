<?php
	checkauthentication();
	$table = "mst_skp";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$kdunit = $_REQUEST['xkdunit'];
	$th = $_SESSION['xth'];
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
			} 
			else {
				// UPDATE
				$nib_atasan = $_REQUEST['nib_atasan'];
//				$sql = sql_update($table,$field,$value);
				$sql = "UPDATE $table SET nib_atasan = '$nib_atasan' WHERE id = '$q'";
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit']?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit']?>"><?php		
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
<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit']?>" method="post" name="form">
	<table width="497" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Tahun</td>
		  <td width="250"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $th ?>" disabled="disabled"/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><select name="<?php echo $field[2] ?>" disabled="disabled">
            <option value="<?php echo $value[2] ?>" ><?php echo  '['.$value[2].'] '.nama_peg($value[2]) ?></option>
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
		  <td><select name="<?php echo $field[4] ?>" onchange="get_atasan(this.value,<?php echo $kdunit ?>)" disabled="disabled">
            <?php if ( $q <> '' ) {?>
            <option value="<?php echo $value[4] ?>"><?php echo  '['.$value[4].'] '.nm_jabatan_ij($value[4]) ?></option>
            <?php } ?>
            <option value="">- Pilih Jabatan -</option>
            <?php
							$query = mysql_query("select kode_jabatan,nmjabatan from mst_info_jabatan,kd_jabatan where left(kdunitkerja,2) = '$kdunit' and kode_jabatan=kode group by kode_jabatan order by kode_jabatan");
					
						while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kode_jabatan'] ?>"><?php echo  '['.$row['kode_jabatan'].'] '.$row['nmjabatan']; ?></option>
            <?php
						} ?>
          </select></td>
		</tr>
		<tr>
		  <td class="key">Atasan pada SKP</td>
		  <td><div id="atasan-view">
		    <select name="<?php echo $field[10] ?>">
              <option value="<?php echo $value[10] ?>"><?php echo  '['.$value[10].'] '.nama_peg($value[10]) ?></option>
              <option value="">- Pilih Nama Pegawai -</option>
              <?php
			  				$unit_atasan = substr($value[3],0,4) ;
							$query = mysql_query("select nip,left(nama,70) as namapeg from m_idpegawai where left(kdunitkerja,4) = '$unit_atasan' and kdeselon <> '00' order by nama");
					
						while($row = mysql_fetch_array($query)) { ?>
              <option value="<?php echo $row['nip'] ?>"><?php echo  '['.$row['nip'].'] '.$row['namapeg']; ?></option>
              <?php
						} ?>
            </select>
		  </div></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&xkdunit=<?php echo $_REQUEST['xkdunit']?>')">Batal</a>					</div>
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