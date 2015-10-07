<?php
	checkauthentication();
	$table = "tb_unitkerja";
	$field =  array("id","kdunit","nmunit","sktunit","kdsatker");
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$kddept = setup_kddept_keu() ;
	$kdunitx = setup_kdunit_keu() ;
	
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $_REQUEST['pagess'] ?>"><?php
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $_REQUEST['pagess'] ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $_REQUEST['pagess'] ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $_REQUEST['pagess'] ?>" method="post" name="form">
	<table width="497" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Kode</td>
		  <td width="250"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" /></td>
	  </tr>
		<tr>
			<td class="key"> Unit Kerja </td>
			<td><input type="text" name="<?php echo $field[2] ?>" size="80" value="<?php echo $value[2] ?>" /></td>
		</tr>
		<tr>
		  <td class="key">Singkatan</td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="40" value="<?php echo $value[3] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Kode Satker</td>
		  <td><select name="<?php echo $field[4] ?>">
          <option value="<?php echo $value[4] ?>"><?php echo  '['.$value[4].'] '.substr(nm_satker($value[4]),0,70) ?></option>
          <option value="">- Pilih Satker -</option>
          <?php
switch ( $xlevel )
{
	 default:
	 $query = mysql_query("select KDSATKER, left(NMSATKER,70) as nama_satker from t_satker WHERE KDDEPT = '$kddept' AND KDUNIT = '$kdunitx' order by NMSATKER");
	 break;
}	 
		  while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['KDSATKER'] ?>"><?php echo  '['.$row['KDSATKER'].'] '.$row['nama_satker']; ?></option>
          <?php
						} ?>
        </select></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $_REQUEST['pagess'] ?>')">Batal</a>					</div>
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