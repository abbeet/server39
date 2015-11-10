<?php
	checkauthentication();
	$table = "m_kegiatan";
	$err = false;
	$p = $_GET['p'];
	$kdprog = $_GET['kdprog'];
	$th = $_GET['th'];
	$q = $_GET['q'];
	$simpan = 'Simpan';
	$batal = 'Batal';
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
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET rencana_alokasi_1 = '$rencana_alokasi_1',
										rencana_alokasi_2 = '$rencana_alokasi_2',
										rencana_alokasi_3 = '$rencana_alokasi_3',
										rencana_alokasi_4 = '$rencana_alokasi_4',
										rencana_alokasi_5 = '$rencana_alokasi_5'
				 						 WHERE id = '$q'";
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=524&th=<?php echo $th ?>&kdprog=<?php echo $kdprog ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=524&th=<?php echo $th ?>&kdprog=<?php echo $kdprog ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aGiat = mysql_query($sql);
		$value = mysql_fetch_array($aGiat);
	}
	else {
		$value = array();
	} ?>

<form action="index.php?p=<?php echo $_GET['p']; ?>&th=<?php echo $th ?>&kdprog=<?php echo $kdprog ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="663" cellspacing="1" class="admintable">
		<tr>
		  <td width="123" class="key">Kode Program</td>
		  <td width="531">
		  <input type="text" size="10" value="<?php echo @$value['kddept'].'.'.@$value['kdunit'].'.'.@$value['kdprogram'] ?>"  disabled="disabled">
		  </td>
	  </tr>
		<tr>
			<td class="key">Program</td>
			<td>
			<textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program(@$value['th'],@$value['kddept'].@$value['kdunit'].@$value['kdprogram']) ?></textarea>
			</td>
		</tr>
		
		<tr>
		  <td class="key">Kode Kegiatan</td>
		  <td><input type="text" name="kdgiat" size="8" value="<?php echo @$value['kdgiat'] ?>" disabled="disabled"/></td>
	  </tr>
		<tr>
			<td class="key">Nama Kegiatan</td>
			<td><textarea disabled="disabled" name="nmgiat" cols="70" rows="2"><?php echo @$value['nmgiat'] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Alokasi Anggaran</td>
		  <td><input type="text" name="kdgiat" size="20" value="<?php echo @$value['rencana_alokasi_1'] ?>" /></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=371')"><?php echo $batal ?></a>					</div>
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
<?php if ( $kdprog <> '' ) { #----- Tambah data ------?>

<?php
	$kddept = substr($kdprog,0,3);
	$kdunit = substr($kdprog,3,2);
	$kdprogram = substr($kdprog,5,2);
	$sql = "SELECT * FROM $table WHERE th = '$th' and kddept = '$kddept' and kdunit = '$kdunit' and kdprogram = '$kdprogram' ORDER BY kdgiat";
	$aGiat = mysql_query($sql);
	$count = mysql_num_rows($aGiat);
	
	while ($Giat = mysql_fetch_array($aGiat))
	{
		$col[0][] = $Giat['id'];
		$col[1][] = $Giat['kdgiat'];
		$col[2][] = $Giat['nmgiat'];
		$col[3][] = $Giat['kdunitkerja'];
		$col[4][] = $Giat['jns_giat'];
	}
?>
<table width="376" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="11%">Kode</th>
			<th width="29%">Nama Kegiatan </th>
			<th width="46%">Unit Kerja</th>
			<th width="46%">Jenis Kegiatan </th>
			<th colspan="2">Aksi</th>
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
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td align="left"><?php echo nm_unit($col[3][$k]) ?></td>
					<td align="center"><?php echo $col[4][$k] ?></td>
					<td width="5%" align="center">
						<a href="index.php?p=400&th=<?php echo $th ?>&kdprog=<?php echo $_REQUEST['kdprog'] ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="9%" align="center">
						<a href="index.php?p=401&th=<?php echo $th ?>&kdprog=<?php echo $_REQUEST['kdprog'] ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
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

<?php } # ----- Akhir tambah data ----- ?>