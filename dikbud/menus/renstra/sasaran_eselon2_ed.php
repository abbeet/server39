<?php
	checkauthentication();
	$table = "m_sasaran_utama";
	$err = false;
	$p = $_GET['p'];
	$th = $_SESSION['xth'];
	$kdunit = $_SESSION['xkdunit'];
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	$batal = 'Kembali';
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
				$sql = "INSERT INTO $table VALUE ('','$th','$kdunit','$no_sasaran','$nm_sasaran')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=512"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdunit = '$kdunit' , no_sasaran = '$no_sasaran', nm_sasaran = '$nm_sasaran' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=512"><?php
				exit();
			} ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=512"><?php		
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

<form action="index.php?p=<?php echo $_GET['p']; ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="803" cellspacing="1" class="admintable">
		
		<tr>
			<td width="173" class="key">Eselon II </td>
			<td width="621">
			<select name="kdunit">
                      <option value="<?php echo @$value['kdunit'] ?>"><?php echo  nm_unit(@$value['kdunit']) ?></option>
                      <option value="">- Pilih Eselon II -</option>
                    <?php
					switch ( $xlevel )
					{
						case 6 :
							$query = mysql_query("select kdunit, nmunit from tb_unitkerja where  kdunit = '$kdunit' order by kdunit");
							break;
						default :
							$query = mysql_query("select kdunit, nmunit from tb_unitkerja where ( kdunit = '2320100' or kdunit = '2320200' or kdunit = '2320300' or kdunit = '2320400' or kdunit = '2320500' or kdunit = '2320600') order by kdunit");
							break;
					}	
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['nmunit']); ?></option>
                    <?php
					} ?>	
	  </select>
			</td>
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

<?php
switch ( $xlevel )
{
	case 6 :
	$sql = "SELECT * FROM $table WHERE ta = '$th' and kdunit = '$kdunit' ORDER BY kdunit,no_sasaran";
	break;
	
	default :
	$sql = "SELECT * FROM $table WHERE ta = '$th' and ( kdunit = '2320100' or kdunit = '2320200' or kdunit = '2320300' or kdunit = '2320400' or kdunit = '2320500' or kdunit = '2320600') ORDER BY kdunit,no_sasaran";
	break;
}
	$aMisi = mysql_query($sql);
	$count = mysql_num_rows($aMisi);
	
	while ($Misi = mysql_fetch_array($aMisi))
	{
		$col[0][] = $Misi['id'];
		$col[1][] = $Misi['no_sasaran'];
		$col[2][] = $Misi['nm_sasaran'];
		$col[3][] = $Misi['kdunit'];
	}
?>
<table width="277" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="40%">Eselon II</th>
			<th colspan="2">Sasaran</th>
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
					<td align="left"><?php if ( $col[3][$k] <> $col[3][$k-1] ) { ?><?php echo nm_unit($col[3][$k]) ?><?php } ?></td>
					<td width="5%" align="center"><?php echo $col[1][$k] ?></td>
					<td width="40%" align="left"><?php echo $col[2][$k] ?></td>
					<td width="7%" align="center">
						<a href="index.php?p=512&q=<?php echo $col[0][$k]; ?>" title="Edit">
					<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="11%" align="center">
						<a href="index.php?p=513&q=<?php echo $col[0][$k]; ?>" title="Delete">
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

