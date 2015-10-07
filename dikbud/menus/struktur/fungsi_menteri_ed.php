<?php
	checkauthentication();
	$table = "tb_unitkerja_fungsi";
	$err = false;
	$p = $_GET['p'];
	$kdunit = $_GET['kdunit'];
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
				$sql = "INSERT INTO $table VALUE ('','$kdunit','$kdfungsi','$nmfungsi')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=501&kdunit=<?php echo $kdunit ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdfungsi = '$kdfungsi', nmfungsi = '$nmfungsi' WHERE id = '$q'";
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				}else{ ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=501&kdunit=<?php echo $kdunit ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=501&kdunit=<?php echo $kdunit ?>"><?php		
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

<form action="index.php?p=<?php echo $_GET['p']; ?>&kdunit=<?php echo $kdunit ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="551" cellspacing="1" class="admintable">
		<tr>
		  <td width="94" class="key">Kode</td>
		  <td width="448">
		  <?php if ( $kdunit <> '' ) { ?><input type="text" size="10" value="<?php echo $kdunit ?>"  disabled="disabled">
		  <?php }else{  ?><input type="text" size="10" value="<?php echo @$value['kdunit'] ?>"  disabled="disabled">
		  <?php }?>
		  </td>
	  </tr>
		<tr>
			<td class="key">Kementerian</td>
			<td>
			<?php if ( $kdunit <> '' ) {?><input type="text" size="85" value="<?php echo nm_unit($kdunit) ?>" disabled="disabled"/>
			<?php }else{  ?><input type="text" size="85" value="<?php echo nm_unit(@$value['kdunit']) ?>" disabled="disabled"/>
			<?php } ?>
			</td>
		</tr>
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="kdfungsi" size="3" value="<?php echo @$value['kdfungsi'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Fungsi</td>
			<td><textarea name="nmfungsi" cols="60" rows="2"><?php echo @$value['nmfungsi'] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=499')"><?php echo $batal ?></a>					</div>
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
	$sql = "SELECT * FROM $table WHERE kdunit = '$kdunit' ORDER BY kdfungsi";
	$aFungsi = mysql_query($sql);
	$count = mysql_num_rows($aFungsi);
	
	while ($Fungsi = mysql_fetch_array($aFungsi))
	{
		$col[0][] = $Fungsi['id'];
		$col[1][] = $Fungsi['kdfungsi'];
		$col[2][] = $Fungsi['nmfungsi'];
	}
?>
<table width="274" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="16%">No. Urut</th>
			<th width="70%">Fungsi</th>
			<th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td width="7%" align="center">
						<a href="index.php?p=501&kdunit=<?php echo $kdunit; ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="7%" align="center">
						<a href="index.php?p=502&kdunit=<?php echo $kdunit ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>

<?php } # ----- Akhir tambah data ----- ?>