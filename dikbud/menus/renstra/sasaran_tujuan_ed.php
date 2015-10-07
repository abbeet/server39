<?php
	checkauthentication();
	$table = "m_sasaran";
	$err = false;
	$p = $_GET['p'];
	$th = $_SESSION['xth'];
	$kdunit = $_GET['kdunit'];
	$kdtujuan = $_GET['kdtujuan'];
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	if ( $kdunit == '' )   $batal = 'Batal';
	else   $batal = 'Kembali';
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW				
				$sql = "INSERT INTO $table (id,ta,kdunitkerja,kdtujuan,no_sasaran,nm_sasaran) VALUE ('','$th','$kdunit','$kdtujuan','$no_sasaran','$nm_sasaran')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=512&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET no_sasaran = '$no_sasaran', nm_sasaran = '$nm_sasaran' WHERE id = '$q'";
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=512&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=512&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>"><?php		
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

<form action="index.php?p=<?php echo $_GET['p']; ?>&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="679" cellspacing="1" class="admintable">
		
		
		<tr>
		  <td width="119" class="key">Tujuan</td>
		  <td width="551">
		  <?php if ( $kdunit == '' ) { ?>
		  <textarea name="nmtujuan" cols="70" rows="2" disabled="disabled"><?php echo renstra_tujuan(@$value['kdunitkerja'],@$value['kdtujuan']) ?>
		  <?php }else{ ?>
		  <textarea name="nmtujuan" cols="70" rows="2" disabled="disabled"><?php echo renstra_tujuan($kdunit,$kdtujuan) ?>
		  <?php } ?>
		  </textarea></td>
		</tr>
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="no_sasaran" size="3" value="<?php echo @$value['no_sasaran'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Sasaran Strategis </td>
			<td><textarea name="nm_sasaran" cols="70" rows="2"><?php echo @$value['nm_sasaran'] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=509')"><?php echo $batal ?></a>					</div>
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
	$sql = "SELECT * FROM $table WHERE kdunitkerja = '$kdunit' and ta = '$th' and kdtujuan = '$kdtujuan' ORDER BY kdtujuan,no_sasaran";
	$aFungsi = mysql_query($sql);
	$count = mysql_num_rows($aFungsi);
	
	while ($Fungsi = mysql_fetch_array($aFungsi))
	{
		$col[0][] = $Fungsi['id'];
		$col[1][] = $Fungsi['kdtujuan'];
		$col[2][] = $Fungsi['no_sasaran'];
		$col[3][] = $Fungsi['nm_sasaran'];
	}
?>
<table width="423" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="42%">Tujuan</th>
			<th colspan="2">Sasaran Strategis </th>
			<th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="6">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="left"><?php if ( $col[1][$k] <> $col[1][$k-1] ) { ?><?php echo renstra_tujuan($kdunit,$col[1][$k]) ?><?php } ?></td>
					<td width="3%" align="center"><?php echo $col[2][$k] ?></td>
					<td width="34%" align="left"><?php echo $col[3][$k] ?></td>
					<td width="5%" align="center">
						<a href="index.php?p=512&kdunit=<?php echo $kdunit; ?>&kdtujuan=<?php echo $kdtujuan ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="5%" align="center">
						<a href="index.php?p=513&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
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
?>