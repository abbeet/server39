<?php
	checkauthentication();
	$kdjab = $_REQUEST['kdjab'];
	$table = "t_bantu";
	$table_bantu = "t_kelompok";
	$kdjenjang = substr($kdjab,3,2);
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
				$kditem = $_REQUEST['kditem'];
				$nmitem = $_REQUEST['nmitem'];
				$satuan = $_REQUEST['satuan'];
				$angka_kredit = $_REQUEST['angka_kredit'];
				$min_target = $_REQUEST['min_target'];
				$mak_target = $_REQUEST['mak_target'];
				$sql = "INSERT INTO $table (id,kdjab,kdkelompok,kditem,nmitem,satuan,angka_kredit,min_target,mak_target)
						 VALUES ('','$kdjab','$kdkelompok','$kditem','$nmitem','$satuan','$angka_kredit',
						 '$min_target','$mak_target')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=376&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$kdjab = $kdjab ;
				$kdkelompok = $_REQUEST['kdkelompok'];
				$kditem = $_REQUEST['kditem'];
				$nmitem = $_REQUEST['nmitem'];
				$satuan = $_REQUEST['satuan'];
				$angka_kredit = $_REQUEST['angka_kredit'];
				$min_target = $_REQUEST['min_target'];
				$mak_target = $_REQUEST['mak_target'];
				$sql = "UPDATE $table SET kdkelompok = '$kdkelompok', kditem = '$kditem', nmitem = '$nmitem' , satuan = '$satuan', angka_kredit = '$angka_kredit', min_target = '$min_target', mak_target = '$mak_target'  WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=376&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=376&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
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
			<td width="409"><strong><?php echo nm_jabatan_ij($kdjab) ?></strong></td>
		    <td width="53" align="right"><a href="index.php?p=382&kdjab=<?php echo $kdjab; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit"><img src="css/images/edit_f2.png" border="0" width="16" height="16">Copy</a></td>
		</tr>
		
		<tr>
		  <td class="key">Kelompok</td>
		  <td colspan="2"><select name="kdkelompok">
          <option value="<?php echo @$value['kdkelompok'] ?>"><?php echo substr(nm_kelompok_bantu($kdjab,@$value['kdkelompok']),0,60) ?></option>
          <option value="">- Kelompok -</option>
          <?php
							$query = mysql_query("select * from t_kelompok where kdjab = '$kdjab' order by kdkelompok");
					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdkelompok'] ?>"><?php echo  substr($row['nmkelompok'],0,60) ?></option>
          <?php
						} ?>
        </select></td>
	  </tr>
		<tr>
		  <td class="key">Kode Item </td>
		  <td colspan="2"><input type="text" name="kditem" size="8" value="<?php echo @$value['kditem'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Nama Item </td>
			<td colspan="2"><textarea name="nmitem" cols="70" rows="3"><?php echo @$value['nmitem'] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Angka Kredit</td>
		  <td colspan="2"><input type="text" name="angka_kredit" size="15" value="<?php echo @$value['angka_kredit'] ?>" /></td>
	  </tr>
		<tr>
          <td class="key">Satuan</td>
		  <td colspan="2"><input type="text" name="satuan" size="50" value="<?php echo @$value['satuan'] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Target</td>
		  <td colspan="2">Minimum&nbsp;&nbsp;<input type="text" name="min_target" size="10" value="<?php echo @$value['min_target'] ?>" />
		  	  &nbsp;&nbsp;Maksimum&nbsp;&nbsp;<input type="text" name="mak_target" size="10" value="<?php echo @$value['mak_target'] ?>" />&nbsp;<font color="#990033">isi -1 apabila tidak ada batasan</font>		  </td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">			
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
$sql = "SELECT * FROM $table WHERE kdjab = '$kdjab' ORDER BY kdkelompok,kditem";
$aTabelBantu = mysql_query($sql);
$count = mysql_num_rows($aTabelBantu);
	
while ($TabelBantu = mysql_fetch_array($aTabelBantu))
{
	$col[0][] = $TabelBantu['id'];
	$col[1][] = $TabelBantu['kdkelompok'];
	$col[3][] = $TabelBantu['kditem'];
	$col[4][] = $TabelBantu['nmitem'];
	$col[5][] = $TabelBantu['angka_kredit'];
	$col[6][] = $TabelBantu['satuan'];
	$col[7][] = $TabelBantu['min_target'];
	$col[8][] = $TabelBantu['mak_target'];
}
?>
<table width="73%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="6%" rowspan="2">No. Urut<br />Kelompok</th>
			<th width="14%" rowspan="2">Kelompok Kegiatan</th>
			<th width="6%" rowspan="2">No.Urut<br />Item</th>
			<th width="21%" rowspan="2">Item Kegiatan </th>
			<th width="7%" rowspan="2">Angka<br />Kredit</th>
			<th width="12%" rowspan="2">Satuan</th>
			<th colspan="2">Target</th>
			<th colspan="2" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="11%">Minimum</th>
	      <th width="15%">Maksimum</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="11">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php if ( $col[1][$k] <> $col[1][$k-1] ) {?><?php echo nmromawi($col[1][$k]) ?><?php }?></td>
					<td align="left"><?php if ( $col[1][$k] <> $col[1][$k-1] ) {?><?php echo nm_kelompok_bantu($kdjab,$col[1][$k]) ?><?php }?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="left"><?php echo $col[4][$k] ?></td>
					<td align="center"><?php echo $col[5][$k] ?></td>
					<td align="center"><?php echo $col[6][$k] ?></td>
					<td align="center"><?php echo $col[7][$k] ?></td>
					<td align="center"><?php if ( $col[8][$k] == -1 ) {?><?php echo 'Tidak ada batasan'; ?><?php }else{ ?><?php echo $col[8][$k] ?><?php }?></td>
					<td width="3%" align="center">
						<a href="index.php?p=376&kdjab=<?php echo $kdjab; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="5%" align="center">
						<a href="index.php?p=377&kdjab=<?php echo $kdjab; ?>&q=<?php echo $col[0][$k]; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="11">&nbsp;</td>
		</tr>
	</tfoot>
</table>
