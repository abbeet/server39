<?php
	checkauthentication();
	$kdjab = $_REQUEST['kdjab'];
	$table = "t_kelompok";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$cari = $_REQUEST['cari'];
	$pagess = $_REQUEST['pagess'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	if ( $_REQUEST['q'] <> '' ) $simpan = 'Simpan';
	else $simpan = 'Tambah';
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW		
				$kdab = $kdjab ;
				$kdkelompok = $_REQUEST['kdkelompok'];
				$nmkelompok = $_REQUEST['nmkelompok'];
				$sql = "INSERT INTO $table (id,kdjab,kdkelompok,nmkelompok)
						       VALUES ('','$kdjab','$kdkelompok','$nmkelompok')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=379&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$kdjab = $kdjab ;
				$kdkelompok = $_REQUEST['kdkelompok'];
				$nmkelompok = $_REQUEST['nmkelompok'];
				$sql = "UPDATE $table SET kdkelompok = '$kdkelompok', nmkelompok = '$nmkelompok' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=379&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=379&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aTabel = mysql_query($sql);
		$value = mysql_fetch_array($aTabel);
	}
	else {
		$value = array();
	} ?>

<form action="index.php?p=<?php echo $_GET['p']; ?>&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table cellspacing="1" class="admintable">
		<tr>
			<td width="105" class="key"><strong>Nama Jabatan</strong></td>
			<td width="424"><strong><?php echo nm_jabatan_ij($kdjab) ?></strong></td>
		</tr>
		
		<tr>
		  <td class="key">Kode Kelompok </td>
		  <td><input type="text" name="kdkelompok" size="8" value="<?php echo @$value['kdkelompok'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Nama Kelompok</td>
			<td><textarea name="nmkelompok" cols="70" rows="3"><?php echo @$value['nmkelompok'] ?></textarea></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=236&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>					</div>
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
<?php
$sql = "SELECT * FROM $table WHERE kdjab = '$kdjab' ORDER BY kdkelompok";
$aTabelBantu = mysql_query($sql);
$count = mysql_num_rows($aTabelBantu);
	
while ($TabelBantu = mysql_fetch_array($aTabelBantu))
{
	$col[0][] = $TabelBantu['id'];
	$col[1][] = $TabelBantu['kdkelompok'];
	$col[2][] = $TabelBantu['nmkelompok'];
}
?>
<table width="63%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="18%">No. Urut</th>
			<th width="18%">Kode</th>
			<th width="53%">Kelompok Kegiatan </th>
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
					<td align="center"><?php echo $k+1 ?></td>
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td width="6%" align="center">
						<a href="index.php?p=379&kdjab=<?php echo $kdjab; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="5%" align="center">
						<a href="index.php?p=380&kdjab=<?php echo $kdjab; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Delete">
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
