<?php
	checkauthentication();
	$table = "mst_skp";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$id_skp = $_GET['id_skp'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$kdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$oData = mysql_query("select * from $table where id = '$id_skp'");
	$Data = mysql_fetch_array($oData);
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if ($id_skp <> "") {
				// UPDATE
				$oData = mysql_query("select * from $table where id = '$id_skp'");
				$Data = mysql_fetch_array($oData);
								
				$status          = $_REQUEST['status'];
				$kdunit_baru     = $_REQUEST['kdunit_baru'];
				$tanggal_selesai = $_REQUEST['tanggal_selesai'];
				
				$oData_mutasi = mysql_query("select * from mst_skp_mutasi where id = '$id_skp'");
				$Data_mutasi = mysql_fetch_array($oData_mutasi);
				$count = mysql_num_rows($oData_mutasi);
				
				if ( $status == 1 ) 
				{
					mysql_query("INSERT INTO mst_skp ( tahun , nib , kdunitkerja , kdgol )
												VALUES ( '$Data[tahun]' , '$Data[nib]' , '$kdunit_baru' , '$Data[kdgol]' )" );
				
				if ( $count == 0 )
				{
					$sql = "INSERT INTO mst_skp_mutasi ( id , tahun , nib , kdunitkerja , kdjabatan ,kdgol , nib_atasan , jabatan_atasan , kdgol_atasan , grade , tanggal_selesai)
												VALUES ( '$Data[id]' , '$Data[tahun]' , '$Data[nib]' , '$Data[kdunitkerja]' , '$Data[kdjabatan]' , '$Data[kdgol]' ,
													     '$Data[nib_atasan]' , '$Data[jabatan_atasan]' , '$Data[kdgol_atasan]' , '$Data[grade]' , '$tanggal_selesai' ) ";
					mysql_query("DELETE FROM mst_skp WHERE id = '$id_skp'" );
				}
					
				}else{
					mysql_query("UPDATE mst_skp SET tanggal_selesai = $tanggal_selesai WHERE id = '$id_skp' " );
				}  

				
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
	?>
<script language="javascript" src="js/skp_combo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="783" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Tahun</td>
		  <td width="250"><input type="text" name="tahun" size="10" value="<?php echo $Data['tahun'] ?>" disabled="disabled"/></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><select name="nib" disabled="disabled">
                      <option value="<?php echo $Data['nib'] ?>" ><?php echo  '['.$Data['nib'].'] '.nama_peg($Data['nib']) ?></option>
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
		  <td class="key">Status</td>
		  <td>
			<input name="status" type="radio" value="0" checked="checked"/>&nbsp;&nbsp;Tutup&nbsp;&nbsp;<br />
	  		<input name="status" type="radio" value="1" />&nbsp;&nbsp;Tutup dan membuat SKP baru di BATAN pada Unit Kerja&nbsp;&nbsp;
		    <select name="kdunit_baru">
                      <option value="<?php echo $Data['kdunitkerja'] ?>"><?php echo  skt_unit(substr($Data['kdunitkerja'],0,2).'00') ?></option>
                      <option value="">- Pilih Unit Eselon II -</option>
                    <?php
							$query = mysql_query("select kdunit,sktunit from kd_unitkerja where right(kdunit,2) = '00' and right(kdunit,3) <> '000' order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['sktunit']; ?></option>
                    <?php
						} ?>
                  </select></td>
	  </tr>
		<tr>
		  <td class="key">Tanggal Tutup</td>
		  <td><input name="tanggal_selesai" type="text" class="form" id="tanggal_selesai" 
					size="10" value="<?php echo $Data['tanggal_selesai'] ?>"/>&nbsp;
				
				<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "tanggal_selesai",
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
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>					</div>
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
<?php 
function skt_unit($kode) {
		$data = mysql_query("select sktunit from kd_unitkerja where kdunit = '$kode'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['sktunit']);
		return $result;
	}
?>