<?php
	checkauthentication();
	$table = "dtl_ij_tugas";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$id_if = $_REQUEST['id_if'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_info_jabatan WHERE id = '$id_if'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
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
				$value[1] = $id_if ;
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
				$value[1] = $id_if ;
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
	
<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="565" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="172" class="key">Unit Kerja </td>
		  <td width="384"><?php echo nm_unitkerja($row['kdunitkerja']).' ['.skt_unitkerja(substr($row['kdunitkerja'],0,2)).']' ?></td>
		</tr>
		<tr>
			<td class="key"> Nama Jabatan </td>
			<td><input type="hidden" name="<?php echo $field[1] ?>" size="1" value="<?php echo $row['id'] ?>"/><?php echo $row['nama_jabatan'] ?></td>
		</tr>
		<tr>
		  <td colspan="2" align="center"><strong>Uraian Tugas</strong></td>
	  </tr>
		<tr>
		  <td class="key">No Urut </td>
		  <td><input type="text" name="<?php echo $field[2] ?>" size="3" value="<?php echo $value[2] ?>" /></td>
	  </tr>
		
		<tr>
		  <td class="key">Nama Tugas  </td>
		  <td><textarea name="<?php echo $field[3] ?>" rows="3" cols="60"><?php echo $value[3] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Bahan Kerja</td>
		  <td><textarea name="<?php echo $field[4] ?>" rows="3" cols="60"><?php echo $value[4] ?></textarea></td>
	  </tr>
		<tr>
		  <td class="key">Perangkat Kerja</td>
		  <td><textarea name="<?php echo $field[5] ?>" rows="3" cols="60"><?php echo $value[5] ?></textarea></td>
	  </tr>
		<tr>
		  <td class="key">Hasil Kerja</td>
		  <td><textarea name="<?php echo $field[6] ?>" rows="3" cols="60"><?php echo $value[6] ?></textarea></td>
	  </tr>
		<tr>
		  <td class="key">Effort</td>
		  <td><textarea name="<?php echo $field[7] ?>" rows="3" cols="60"><?php echo $value[7] ?></textarea></td>
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