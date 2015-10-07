<?php
	checkauthentication();
	$table = "kd_unitkerja_fungsi";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$u = $_GET['u'];
	$cari = $_REQUEST['cari'];
	$pagess = $_REQUEST['pagess'];
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=239&u=<?php echo $u; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdunit = '$kdunit', kdfungsi = '$kdfungsi', nmfungsi = '$nmfungsi' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=239&u=<?php echo $u; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=239&u=<?php echo $u; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
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

<form action="index.php?p=<?php echo $_GET['p']; ?>&u=<?php echo $u; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table cellspacing="1" class="admintable">
		<tr>
			<td class="key">Nama Unit Kerja</td>
			<td>
				<select name="KdUnit" disabled="disabled"><?php
					$sql = "SELECT * FROM kd_unitkerja ORDER BY kdunit";
					$aUnitKerja = mysql_query($sql);
					
					while ($UnitKerja = mysql_fetch_array($aUnitKerja))
					{ ?>
						<option value="<?php echo $UnitKerja['kdunit']; ?>" <?php if ($u == $UnitKerja['kdunit']) echo "selected"; ?>><?php echo $UnitKerja['nmunit']; ?></option><?php
					} ?>
				</select>
				<input type="hidden" name="kdunit" value="<?php echo $u; ?>" />
			</td>
		</tr>
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="kdfungsi" size="3" value="<?php echo @$value['kdfungsi'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Nama Fungsi</td>
			<td><textarea name="nmfungsi" cols="40" rows="5"><?php echo @$value['nmfungsi'] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=233&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>
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
<br />
<?php
	$sql = "SELECT * FROM $table WHERE kdunit = '$u' ORDER BY kdfungsi";
	$aFungsi = mysql_query($sql);
	$count = mysql_num_rows($aFungsi);
	
	while ($Fungsi = mysql_fetch_array($aFungsi))
	{
		$col[0][] = $Fungsi['id'];
		$col[1][] = $Fungsi['kdfungsi'];
		$col[2][] = $Fungsi['nmfungsi'];
	}
?>
<table cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%">No. Urut</th>
			<th>Nama Fungsi</th>
			<th colspan="2" width="6%">Aksi</th>
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
					<td align="center">
						<a href="index.php?p=239&u=<?php echo $u; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">
						</a>
					</td>
					<td align="center">
						<a href="index.php?p=240&u=<?php echo $u; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">
						</a>
					</td>
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