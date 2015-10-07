<?php
	function map($x,$y)
	{
		if($x==$y)
			return "selected";
	}

	checkauthentication();
	$table = "document";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$sw = $_REQUEST['sw'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$xx = $_POST['kd_doc'];
	
	if (isset($form)) {		
			if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if($sw==2){
			// upload file ke direktori dokumen
//			echo "isi nama file = " . $value[5] ; 
			$file_lama = "files/" .$value[5] ;
//			$x  = "files/tes_mike.txt" ;
			$hasil = unlink($file_lama);
			if(!$hasil)
				echo "penghapusan gagal";
			
			$file_name=$_FILES['nama_file']['name'];
			$source=$_FILES['nama_file']['tmp_name'];
			$target = "files/" . $file_name;
			move_uploaded_file($source, $target);
			$_SESSION['errmsg'] = "Update file dokumen berhasil .....!". $file_name . 'id '. $q ;
//			$value[5]=$file_name;
			mysql_query("update $table set nama_file='$file_name' where id='$q'");
			}
			
			//--------------------
			if ($q == "") {		
			if($sw=='' or $sw==1){  //--
			// upload file ke direktori dokumen
			$file_name=$_FILES['nama_file']['name'];
			$source=$_FILES['nama_file']['tmp_name'];
			$target = "files/" . $file_name;
			move_uploaded_file($source, $target);
			$value[5]=$file_name;
			}
			//---------------------
				//ADD NEW		
				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil .....!".$sw;
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} 
				?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>">
				
				<?php
				exit();
			} 
			else {
				
				// UPDATE
				if($sw==1)
				{  ## cek ubah diskripsi dokumen
					$sql = sql_update($table,$field,$value);
					$rs = mysql_query($sql);
				
					if ($rs)
					{	
						update_log($sql,$table,1);
						$_SESSION['errmsg'] = "Edit data berhasil!";
					}
					else 
					{
						update_log($sql,$table,0);
						$_SESSION['errmsg'] = "Edit data gagal!";	
					} 					
				}    
				#--- akhir if sw?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				//exit();
			}
		}
		else { ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
		else {
		$value = "";
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>&sw=<?php echo $sw ?>" method="post" enctype="multipart/form-data" name="form">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">Kode Dokumen </td>
			<td><input type="text" name="<?php echo $field[1] ?>" size="40" value="<?php echo $value[1] ?>" <?php if($sw==2){?> disabled="disabled"<?php }?>/></td>
		</tr>
		<tr>
			<td class="key">Judul</td>
			<td><input type="text" name="<?php echo $field[2] ?>" size="70" value="<?php echo $value[2] ?>" <?php if($sw==2){?> disabled="disabled"<?php }?>/></td>
		</tr>
		<tr>
		  <td class="key">Penulis</td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="40" value="<?php echo $value[3] ?>" <?php if($sw==2){?> disabled="disabled"<?php }?>/></td>
	  </tr>
		<tr>
		  <td class="key">Bahasa</td>
		  
		  <td><select name="<?php echo $field[4] ?>" <?php if($sw==2){?>disabled="disabled"<?php }?>>
				<option value="id" <?php echo map($value[4],"id") ?>>Indonesia</option>
				<option value="en" <?php echo map($value[4],"en") ?>>Inggris</option>
			</select></td>
	  </tr>

	  <tr>
		  <td class="key">Nama File <input type="hidden" name="<?php echo $field[5] ?>" size="40" value="<?php echo $value[5] ?>"/> </td>
		  <td><?php if($sw==1) { echo $value[5]; }else{ ?>
		  <input type="file" name="nama_file" size="50" value="">
		  <?php }?>
		  </td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>					</div>
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