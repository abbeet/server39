<?php
	checkauthentication();
	$table = "m_program_outcome";
	$err = false;
	$p = $_GET['p'];
	$th = $_GET['th'];
	$kdprogram = $_GET['kdprogram'];
	$kddept = setup_kddept_keu();
	$kdunit_dipa = setup_kdunit_keu();
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	if ( $kdprogram == '' )   $batal = 'Batal';
	else   $batal = 'Kembali';
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$kdmenteri = setup_kddept_unit($kode).'0000' ;

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW				
				$sql = "INSERT INTO $table VALUE ('','$th','$kddept','$kdunit_dipa','$kdprogram','$kdoutcome',
				'$nmoutcome','$kdunitkerja')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=412&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdoutcome = '$kdoutcome', nmoutcome = '$nmoutcome', kdunitkerja = '$kdunitkerja' WHERE id = '$q'";
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=412&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=412&th=<?php echo $th ?>&kdoutcome=<?php echo $kdoutcome ?>&kdprogram=<?php echo $kdprogram ?>"><?php		
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

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
	
	
<form action="index.php?p=<?php echo $_GET['p']; ?>&q=<?php echo $q ?>&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>" method="post" name="form">
	<table width="551" cellspacing="1" class="admintable">
		<tr>
		  <td width="62" class="key">Kode </td>
		  <td width="480">
		  <?php if ( $kdprogram <> '' ) { ?>
		  <input type="text" size="15" value="<?php echo $kddept.'.'.$kdunit_dipa.'.'.$kdprogram ?>"  disabled="disabled">
		  <?php }else{  ?><input type="text" size="15" value="<?php echo @$value['kddept'].'.'.@$value['kdunit'].'.'.@$value['kdprogram'] ?>"  disabled="disabled">
		  <?php }?>		  </td>
	  </tr>
		<tr>
			<td class="key">Program</td>
			<td>
			<?php if ( $kdprogram <> '' ) {?><textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program($th,$kddept.$kdunit_dipa.$kdprogram) ?></textarea>
			<?php }else{  ?><textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program(@$value['ta'],@$value['kddept'].@$value['kdunit'].@$value['kdprogram']) ?></textarea>
			<?php } ?>			</td>
		</tr>
		
		<tr>
		  <td class="key">No. Urut </td>
		  <td><input type="text" name="kdoutcome" size="3" value="<?php echo @$value['kdoutcome'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Outcome</td>
			<td><textarea name="nmoutcome" cols="60" rows="2"><?php echo @$value['nmoutcome'] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Eselon II Pelaksana Program </td>
		  <td><select name="kdunitkerja">
          <option value="<?php echo @$value['kdunitkerja'] ?>"><?php echo  substr(nm_unit(@$value['kdunitkerja']),0,70) ?></option>
          <option value="">- Pilih Unit Kerja -</option>
          <?php
switch ( $xlevel )
{
	 default:
	 $query = mysql_query("select kdunit, left(nmunit,70) as nama_unit from tb_unitkerja WHERE right(kdunit,3) <> '000' and right(kdunit,2) = '00'and kdunit <> '$kdmenteri' order by kdunit");
	 break;
}	 
		  while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nama_unit']; ?></option>
          <?php
						} ?>
        </select></td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=411')"><?php echo $batal ?></a>					</div>
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
<?php if ( $kdprogram <> '' ) { #----- Tambah data ------?>

<?php
	$sql = "SELECT * FROM $table WHERE ta = '$th' and kdprogram = '$kdprogram' ORDER BY kdoutcome";
	$aOutcome = mysql_query($sql);
	$count = mysql_num_rows($aOutcome);
	
	while ($Outcome = mysql_fetch_array($aOutcome))
	{
		$col[0][] = $Outcome['id'];
		$col[1][] = $Outcome['kdoutcome'];
		$col[2][] = $Outcome['nmoutcome'];
		$col[3][] = $Outcome['kdunitkerja'];
	}
?>
<table width="564" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="9%">No. Urut</th>
			<th width="59%">Outcome</th>
			<th width="22%">Eselon II Pelaksana Program</th>
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
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td align="left"><?php echo nm_unit($col[3][$k]) ?></td>
					<td width="4%" align="center">
						<a href="index.php?p=412&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="6%" align="center">
						<a href="index.php?p=441&q=<?php echo $col[0][$k] ?>&id=<?php echo $q ?>" title="Delete">
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