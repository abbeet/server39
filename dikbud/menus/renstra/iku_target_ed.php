<?php
	checkauthentication();
	$table = "m_iku_target";
	$err = false;
	$p = $_GET['p'];
	$kdunit = $_GET['kdunit'];
	$th = $_GET['th'];
	$noiku = $_GET['noiku'];
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
				$sql = "INSERT INTO $table VALUE ('','$th','$kdunit','$noiku','$no_target','$target')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=417&th=<?php echo $th ?>&kdunit=<?php echo $kdunit ?>&noiku=<?php echo $noiku ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET no_target = '$no_target', target = '$target' WHERE id = '$q'";
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=417&th=<?php echo $th ?>&kdunit=<?php echo $kdunit ?>&noiku=<?php echo $noiku ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=417&th=<?php echo $th ?>&kdunit=<?php echo $kdunit ?>&noiku=<?php echo $noiku ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aIKU = mysql_query($sql);
		$value = mysql_fetch_array($aIKU);
	}
	else {
		$value = array();
	} ?>

<form action="index.php?p=<?php echo $_GET['p']; ?>&th=<?php echo $th ?>&kdunit=<?php echo $kdunit ?>&noiku=<?php echo $noiku ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="551" cellspacing="1" class="admintable">
		<tr>
		  <td width="94" class="key">No. IKU </td>
		  <td width="448">
		  <?php if ( $kdunit <> '' ) { ?><input type="text" size="10" value="<?php echo $noiku ?>"  disabled="disabled">
		  <?php }else{  ?><input type="text" size="10" value="<?php echo @$value['no_iku'] ?>"  disabled="disabled">
		  <?php }?>		  </td>
	  </tr>
		<tr>
			<td class="key">IKU</td>
			<td>
			<?php if ( $kdunit <> '' ) {?><input type="text" size="80" value="<?php echo nm_iku($th,$noiku) ?>" disabled="disabled"/>
			<?php }else{  ?><input type="text" size="80" value="<?php echo nm_iku(@$value['ta'],@$value['no_iku']) ?>" disabled="disabled"/>
			<?php } ?>			</td>
		</tr>
		
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="no_target" size="3" value="<?php echo @$value['no_target'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Target</td>
			<td><input type="text" name="target" size="70" value="<?php echo @$value['target'] ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=367')"><?php echo $batal ?></a>					</div>
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
	$sql = "SELECT * FROM $table WHERE ta = '$th' and kdunitkerja = '$kdunit' and no_iku = '$noiku' ORDER BY no_target";
	$aTarget = mysql_query($sql);
	$count = mysql_num_rows($aTarget);
	
	while ($Target = mysql_fetch_array($aTarget))
	{
		$col[0][] = $Target['id'];
		$col[1][] = $Target['no_target'];
		$col[2][] = $Target['target'];
	}
?>
<table width="274" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="16%">No. Urut</th>
			<th width="70%">Target</th>
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
						<a href="index.php?p=417&th=<?php echo $th ?>&kdunit=<?php echo $kdunit ?>&noiku=<?php echo $noiku ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="7%" align="center">
						<a href="index.php?p=397&th=<?php echo $th ?>&kdunit=<?php echo $kdunit ?>&nosas=<?php echo $nosas ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
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