<?php
	checkauthentication();
	$table = "mst_skp_mutasi";
	$field = array("id","tahun","nib","kdunitkerja","kdjabatan","kdgol","grade","tanggal_mulai" ,"tanggal_selesai"); 
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
			} 
			else {
				// UPDATE
				$kdgol = $value[5];
				$tanggal_mulai = $value[7];
				$tanggal_selesai = $value[7];
				$sql = "UPDATE $table SET kdgol = '$kdgol' , tanggal_mulai = '$tanggal_mulai' , tanggal_selesai = '$tanggal_selesai' WHERE id = '$q' ";
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
		  <td width="250"><input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $th ?>" disabled="disabled"/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><select name="<?php echo $field[2] ?>" disabled="disabled">
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
		  <select name="<?php echo $field[4] ?>" disabled="disabled">
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
		  <td class="key">TMT Jabatan Mulai</td>
		  <td><input name="<?php echo $field[7] ?>" type="text" class="form" id="<?php echo $field[7] ?>" 
					size="10" value="<?php echo $value[7] ?>"/>		    &nbsp;
				
				<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "<?php echo $field[7] ?>",
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
		  <td class="key">TMT Jabatan Selesai</td>
		  <td><input name="<?php echo $field[8] ?>" type="text" class="form" id="<?php echo $field[8] ?>" 
					size="10" value="<?php echo $value[8] ?>"/>&nbsp;
				
				<img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "<?php echo $field[8] ?>",
						button : "b_triggerIMG",
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
		  <td><select name="<?php echo $field[5] ?>" readonly="">
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