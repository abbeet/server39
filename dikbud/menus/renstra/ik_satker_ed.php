<?php
	checkauthentication();
	$table = "m_iku_utama";
	$err = false;
	$p = $_GET['p'];
	$th = $_SESSION['xth'];
	$no_sasaran = $_REQUEST['no_sasaran'];
	$kdunit = $_REQUEST['kdunit'];
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	if ( $no_sasaran == '' )   $batal = 'Batal';
	else   $batal = 'Kembali';
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$renstra = th_renstra($th);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW				
				$sql = "INSERT INTO $table VALUE ('','$th', '$kdunit' , '$no_iku','$nm_iku','$no_sasaran' , '$target_1' , '$target_2' , '$target_3' , '$target_4' , '$target_5' , '$terkait_ikk')" ;
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=605&no_sasaran=<?php echo $no_sasaran ?>&kdunit=<?php echo $kdunit ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET no_iku = '$no_iku', nm_iku = '$nm_iku', target_1 = '$target_1' , terkait_ikk = '$terkait_ikk' ,
						target_2 = '$target_2' , target_3 = '$target_3' , target_4 = '$target_4' , target_5 = '$target_5' WHERE id = '$q'";
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
				<?php if ( $no_sasaran == '' ) { ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&kdunit=<?php echo $kdunit ?>"><?php
				}else{ ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=605&no_sasaran=<?php echo $no_sasaran ?>&kdunit=<?php echo $kdunit ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=605&no_sasaran=<?php echo $no_sasaran ?>&kdunit=<?php echo $kdunit ?>"><?php		
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

<form action="index.php?p=<?php echo $_GET['p']; ?>&no_sasaran=<?php echo $no_sasaran ?>&q=<?php echo $q ?>&kdunit=<?php echo $kdunit ?>" method="post" name="form">
	<table width="803" cellspacing="1" class="admintable">
		
		<tr>
			<td width="173" class="key">Unit Kerja </td>
			<td width="621">
			<input type="text" size="70" value="<?php echo nm_unit($kdunit) ?>" disabled="disabled"/>			</td>
		</tr>
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="no_iku" size="3" value="<?php echo @$value['no_iku'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Indikator Kinerja Utama </td>
			<td><textarea name="nm_iku" cols="70" rows="2"><?php echo @$value['nm_iku'] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Target <?php echo substr($renstra,0,4) ?></td>
		  <td><input type="text" name="target_1" size="70" value="<?php echo @$value['target_1'] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Target <?php echo substr($renstra,0,4)+1 ?></td>
		  <td><input type="text" name="target_2" size="70" value="<?php echo @$value['target_2'] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Target <?php echo substr($renstra,0,4)+2 ?></td>
		  <td><input type="text" name="target_3" size="70" value="<?php echo @$value['target_3'] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Target <?php echo substr($renstra,0,4)+3 ?></td>
		  <td><input type="text" name="target_4" size="70" value="<?php echo @$value['target_4'] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Target <?php echo substr($renstra,0,4)+4 ?></td>
		  <td><input type="text" name="target_5" size="70" value="<?php echo @$value['target_5'] ?>" /></td>
	  </tr>
		<tr> 
      <td class="key">Terkait IKK ?</td>
      <td>
	  	<input name="terkait_ikk" type="radio" value="1" <?php if( @$value['terkait_ikk'] == '1' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Ya&nbsp;&nbsp;
        <input name="terkait_ikk" type="radio" value="0" <?php if( @$value['terkait_ikk'] == '0' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Tidak
		</td>
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
<?php if ( $no_sasaran <> '' ) { #----- Tambah data ------?>

<?php
	$sql = "SELECT * FROM $table WHERE ta = '$th' and no_sasaran = '$no_sasaran' and kdunit = '$kdunit' ORDER BY no_iku";
	$aMisi = mysql_query($sql);
	$count = mysql_num_rows($aMisi);
	
	while ($Misi = mysql_fetch_array($aMisi))
	{
		$col[0][] = $Misi['id'];
		$col[1][] = $Misi['no_iku'];
		$col[2][] = $Misi['nm_iku'];
		$col[3][] = $Misi['target_1'];
		$col[4][] = $Misi['target_2'];
		$col[5][] = $Misi['target_3'];
		$col[6][] = $Misi['target_4'];
		$col[7][] = $Misi['target_5'];
		if ( $Misi['terkait_ikk'] == 0 )   $col[8][] = 'Tidak' ;
		else $col[8][] = 'Ya' ;  
	}
?>
<table width="274" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="16%" rowspan="2">No. Urut</th>
			<th width="70%" rowspan="2">Indikator Kinerja</th>
			<th colspan="5">Target</th>
			<th width="10%" rowspan="2">Terkait<br />IKK ?</th>
			<th rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="1%" align="center"><?php echo substr($renstra,0,4) ?></th>
	      <th width="1%" align="center"><?php echo substr($renstra,0,4)+1 ?></th>
	      <th width="1%" align="center"><?php echo substr($renstra,0,4)+2 ?></th>
	      <th width="2%" align="center"><?php echo substr($renstra,0,4)+3 ?></th>
	      <th width="5%" align="center"><?php echo substr($renstra,0,4)+4 ?></th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="10">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="center"><?php echo $col[4][$k] ?></td>
					<td align="center"><?php echo $col[5][$k] ?></td>
					<td align="center"><?php echo $col[6][$k] ?></td>
					<td align="center"><?php echo $col[7][$k] ?></td>
					<td align="center"><?php echo $col[8][$k] ?></td>
					<td width="7%" align="center">
						<a href="index.php?p=605&no_sasaran=<?php echo $no_sasaran; ?>&q=<?php echo $col[0][$k]; ?>&kdunit=<?php echo $kdunit ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10">&nbsp;</td>
		</tr>
	</tfoot>
</table>

<?php } # ----- Akhir tambah data ----- ?>