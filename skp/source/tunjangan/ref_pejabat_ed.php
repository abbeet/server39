<?php
	checkauthentication();
	$table = "ref_pejabat";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$th = $_SESSION['xth'];
	$kdsatker = $_REQUEST['kdsatker'];
	$q = $_REQUEST['q'];
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
				$sql = "INSERT INTO $table VALUE ('','$th','$kdsatker','$kdpejabat','$nmjabatan','$nib')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=360&kdsatker=<?php echo $kdsatker ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdpejabat = '$kdpejabat', nmjabatan = '$nmjabatan', nib = '$nib' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=360&kdsatker=<?php echo $kdsatker ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=360&kdsatker=<?php echo $kdsatker; ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aPejabat = mysql_query($sql);
		$value = mysql_fetch_array($aPejabat);
	}
	else {
		$value = array();
	} ?>

<form action="index.php?p=<?php echo $_GET['p']; ?>&kdsatker=<?php echo $kdsatker; ?>" method="post" name="form">
	<table width="671" cellspacing="1" class="admintable">
		<tr>
			<td width="151" class="key">Satker</td>
			<td width="179"><strong><?php echo '['.$kdsatker.'] '.nm_satker($kdsatker) ?></strong></td>
		</tr>
		<tr>
		  <td class="key">Kode Jabatan </td>
		  <td><select name="kdpejabat">
              <option value="1"><?php echo ' Kuasa Pengguna Anggaran ' ?></option>
              <option value="2"><?php echo ' Pejabat Pembuat Komitmen ' ?></option>
              <option value="3"><?php echo ' Bendahara Pengeluaran ' ?></option>
          </select></td>
	  </tr>
		
		<tr>
		  <td class="key">Pemegang Jabatan </td>
		  <td><select name="nib">
			  <?php
					$sql = "SELECT nib FROM mst_tk where kdsatker = '$kdsatker' group by nib ORDER BY nib";
					$aPegawai = mysql_query($sql);
					
					while ($Pegawai = mysql_fetch_array($aPegawai))
					{ ?>
              <option value="<?php @$value['nib'] ?>" <?php if (@$value['nib'] == $Pegawai['nib']) echo "selected"; ?>><?php echo $Pegawai['nib'].' '.nama_peg($Pegawai['nib']) ?></option>
			  <?php
					} ?>
            </select></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=359')">Kembali</a>					</div>
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
<br />
<?php
	$sql = "SELECT * FROM $table WHERE th = '$th' and kdsatker = '$kdsatker' ORDER BY kdpejabat";
	$aPejabat = mysql_query($sql);
	$count = mysql_num_rows($aPejabat);
	
	while ($Pejabat = mysql_fetch_array($aPejabat))
	{
		$col[0][] = $Pejabat['id'];
		$col[1][] = $Pejabat['kdpejabat'];
		$col[2][] = $Pejabat['nmjabatan'];
		$col[3][] = $Pejabat['nib'];
	}
?>
<table cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="4%">No. Urut</th>
			<th>Nama Jabatan </th>
			<th>Pejabat</th>
			<th>NIP</th>
			<th colspan="2" width="6%">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo nm_jabatan_keu($col[1][$k]) ?></td>
					<td align="left"><?php echo nama_peg($col[3][$k]) ?></td>
					<td align="left"><?php echo reformat_nipbaru(nip_peg($col[3][$k])) ?></td>
					<td align="center">
						<a href="index.php?p=239&u=<?php echo $u; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td align="center">
						<a href="index.php?p=240&u=<?php echo $u; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
	</tfoot>
</table>
