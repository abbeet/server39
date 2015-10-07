<?php
	function map($x,$y)
	{
		if($x==$y)
			return "checked";
	}
	
	checkauthentication();
	$table = "xuser";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xuserid_sess = $_SESSION['xuserid'];
	$xuserlevel_sess = $_SESSION['xlevel'];
	$xuserpass_sess = $_SESSION['xuserpass'];
	$xmenu_p = xmenu_id($p);
	$p_next = 43;

	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $xuserid_sess;
			$username = $xusername_sess;
			$level = $xuserlevel_sess;
			$password = $xuserpass_sess;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
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
			}
			?>
				
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else {
		$value = get_value($table,$field,"id=$xuserid_sess");
	}
	?>

<form method="post" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Algoritma Pengujian yang digunakan</td>
			<td><input type="checkbox" name="<?php echo $field[2] ?>" value="1" 
			<?php echo map($value[2],1) ?>/> TF/IDF 
			<input type="checkbox" name="<?php echo $field[3] ?>" value="1" 
			<?php echo map($value[3],1) ?>/> BM25 (Best Match 25)</td>
		</tr>
		<tr>
			<td class="key">Perhitungan Hasil Akhir</td>
		    <td>
		      <label>
		      <input type="radio" name="<?php echo $field[4] ?>" value="0" <?php echo map($value[4],0) ?>>
  Minimun </label>
		      <label>
		      <input type="radio" name="<?php echo $field[4] ?>" value="1" <?php echo map($value[4],1) ?>>
  Rata-rata </label>
		      <label>
		      <input type="radio" name="<?php echo $field[4] ?>" value="2" <?php echo map($value[4],2) ?>>
  Maksimum </label>
	      </td>
		</tr>
		<tr>
			<td class="key">Prosentase minimum yang tampil</td>
			<td><input type="text" name="<?php echo $field[5] ?>" value="<?php echo $value[5] ?>" /></td>
		</tr>		


		<tr>
			<td class="key">Uji dengan 2-bahasa</td>
			<td><input type="checkbox" name="<?php echo $field[6] ?>" value="1"  
			<?php echo map($value[6],1) ?>/> </td>
		</tr>


		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=43')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</td>
		</tr>
	</table>
</form>