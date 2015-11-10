<?php
	checkauthentication();
	$table = "m_iku";
	$err = false;
	$p = $_GET['p'];
	$th = $_SESSION['xth'];
	$kdunit = $_GET['kdunit'];
	$kdtujuan = $_GET['kdtujuan'];
	$no_sasaran = $_GET['no_sasaran'];
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	if ( $kdunit == '' )   $batal = 'Batal';
	else   $batal = 'Kembali';
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$sql = "SELECT * FROM m_sasaran WHERE ta = '$th' and kdtujuan = '$kdtujuan' and no_sasaran = '$no_sasaran'";
	$aSasaran = mysql_query($sql);
	$Sasaran = mysql_fetch_array($aSasaran);
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW				
				$sql = "INSERT INTO $table (id,ta,kdunitkerja,kdtujuan,no_sasaran,no_iku,nm_iku,kdunit_terkait,no_iku_utama) 
						VALUE ('','$th','$kdunit','$kdtujuan','$no_sasaran','$no_iku','$nm_iku','$kdunit_terkait','$no_iku_utama')";
				$rs = mysql_query($sql);
				
				if ($rs) 
				{
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=514&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET no_iku = '$no_iku', nm_iku = '$nm_iku', kdunit_terkait = '$kdunit_terkait', no_iku_utama = '$no_iku_utama' WHERE id = '$q'";
				$rs = mysql_query($sql);
				
				if ($rs) 
				{	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				<?php if ( $kdunit == '' ) { ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>">
				<?php }else{ ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=514&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=514&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aFungsi = mysql_query($sql);
		$value = mysql_fetch_array($aFungsi);
	}
	else {
		$value = array();
	} ?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>

<form action="index.php?p=<?php echo $_GET['p']; ?>&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="679" cellspacing="1" class="admintable">
		
		
		<tr>
		  <td width="119" class="key">Tujuan</td>
		  <td width="551">
		  <?php if ( $kdunit == '' ) { ?>
		  <textarea name="nmtujuan" cols="70" rows="2" disabled="disabled"><?php echo renstra_tujuan(@$value['kdunitkerja'],@$value['kdtujuan']) ?></textarea>
		  <?php }else{ ?>
		  <textarea name="nmtujuan" cols="70" rows="2" disabled="disabled"><?php echo renstra_tujuan($kdunit,$kdtujuan) ?></textarea>
		  <?php } ?>
		  </textarea></td>
		</tr>
		<tr>
		  <td width="119" class="key">Sasaran</td>
		  <td width="551">
		  <?php if ( $kdunit == '' ) { ?>
		  <textarea name="nmsasaran" cols="70" rows="2" disabled="disabled"><?php echo renstra_sasaran($th,@$value['kdunitkerja'],@$value['kdtujuan'],@$value['no_sasaran']) ?></textarea>
		  <?php }else{ ?>
		  <textarea name="nmsasaran" cols="70" rows="2" disabled="disabled"><?php echo renstra_sasaran($th,$kdunit,$kdtujuan,$no_sasaran) ?></textarea>
		  <?php } ?>
		  </textarea></td>
		</tr>
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="no_iku" size="3" value="<?php echo @$value['no_iku'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Indikator Kinerja</td>
			<td><textarea name="nm_iku" cols="70" rows="2"><?php echo @$value['nm_iku'] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Eselon I Terkait</td>
		  <td><select name="kdunit_terkait">
          <option value="<?php echo @$value['kdunit_terkait'] ?>"><?php echo  substr(nm_unit(@$value['kdunit_terkait']),0,80) ?></option>
          <option value="">- Pilih Unit Kerja -</option>
          <?php
switch ( $xlevel )
{
	 default:
	 $query = mysql_query("select kdunit, left(nmunit,80) as nama_unit from tb_unitkerja WHERE right(kdunit,3) = '000' order by kdunit");
	 break;
}	 
		  while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nama_unit']; ?></option>
          <?php
						} ?>
        </select></td>
	  </tr>
		<tr>
		  <td class="key">Mendukung IKU</td>
		  <td><select name="no_iku_utama">
          <option value="<?php echo @$value['no_iku_utama'] ?>"><?php echo  substr(iku_utama($th,@$value['no_iku_utama']),0,80) ?></option>
          <option value="">- Pilih IKU -</option>
          <?php
switch ( $xlevel )
{
	 default:
	 $query = mysql_query("select no_iku, left(nm_iku,80) as nama_iku from m_iku_utama WHERE ta = '$th' order by no_iku");
	 break;
}	 
		  while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['no_iku'] ?>"><?php echo  $row['nama_iku']; ?></option>
          <?php
						} ?>
        </select></td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=510')"><?php echo $batal ?></a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();"><?php echo $simpan ?></a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>
<br />
<?php if ( $kdunit <> '' ) { #----- Tambah data ------?>

<?php
	$sql = "SELECT * FROM $table WHERE kdunitkerja = '$kdunit' and ta = '$th' and kdtujuan = '$kdtujuan' and no_sasaran = '$no_sasaran' ORDER BY no_iku";
	$aFungsi = mysql_query($sql);
	$count = mysql_num_rows($aFungsi);
	
	while ($Fungsi = mysql_fetch_array($aFungsi))
	{
		$col[0][] = $Fungsi['id'];
		$col[1][] = $Fungsi['no_iku'];
		$col[2][] = $Fungsi['nm_iku'];
		$col[3][] = $Fungsi['kdunit_terkait'];
		$col[4][] = $Fungsi['no_iku_utama'];
	}
?>
<table width="423" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="20%">Sasaran Strategis </th>
			<th colspan="2">Indikator Kinerja </th>
			<th>Eselon I Terkait</th>
			<th>IKU Terkait</th>
			<th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="8">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="left"><?php if ( $k == 0 ) { ?><?php echo renstra_sasaran($th,$kdunit,$kdtujuan,$no_sasaran) ?><?php } ?></td>
					<td width="5%" align="center"><?php echo $col[1][$k] ?></td>
					<td width="43%" align="left"><?php echo $col[2][$k] ?></td>
					<td width="18%" align="left"><?php echo nm_unit($col[3][$k]) ?></td>
					<td width="18%" align="left"><?php echo iku_utama($th,$col[4][$k]) ?></td>
					<td width="5%" align="center">
						<a href="index.php?p=514&kdunit=<?php echo $kdunit; ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="5%" align="center">
						<a href="index.php?p=515&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</tfoot>
</table>

<?php } # ----- Akhir tambah data ----- ?>
<?php 
function renstra_tujuan($kdunit,$kdtujuan) {
		$data = mysql_query("select nmtujuan from tb_unitkerja_tujuan where kdunit = '$kdunit' and kdtujuan = '$kdtujuan' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nmtujuan']);
		return $result;
}
function renstra_sasaran($th,$kdunit,$kdtujuan,$kdsasaran) {
		$data = mysql_query("select nm_sasaran from m_sasaran where ta = '$th' and kdunitkerja = '$kdunit' and kdtujuan = '$kdtujuan' and no_sasaran = '$kdsasaran' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nm_sasaran']);
		return $result;
}
function iku_utama($th,$no_iku) {
		$data = mysql_query("select nm_iku from m_iku_utama where ta = '$th' AND no_iku = '$no_iku'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nm_iku'];
		return $result;
}

?>