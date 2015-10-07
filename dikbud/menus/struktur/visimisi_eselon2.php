<?php
	checkauthentication();
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "tb_unitkerja";
	$field =  array("id","kdunit","nmunit","visi");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kdmenteri = setup_kddept_unit($kode) ;
	$kdeselon2 = $kdmenteri.'2';

if ( $_REQUEST['cari_unit'] )
{
     $xkdunit = $_REQUEST['xkdunit'];
}	

switch ( $xlevel )
{
	case 6 :
	$oList = mysql_query("select * from $table WHERE kdunit = '$xkdunit' order by kdunit");
	break ;
	
	default :
	$oList = mysql_query("select * from $table WHERE ( kdunit = '2320100' or kdunit = '2320200' or kdunit = '2320300' or kdunit = '2320400' or kdunit = '2320500' or kdunit = '2320600') order by kdunit");
	break ;
}	
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>
<table width="634" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="30%">Eselon II</th>
			
      <th colspan="2">Visi</th>
			<th width="8%" colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="row1">
					<td align="left" valign="top"><?php echo $col[2][$k] ?></td>
				  <td colspan="2" align="left" valign="top"><?php echo $col[3][$k] ?></td>
					<td colspan="2" align="center" valign="top">
						<a href="index.php?p=570&q=<?php echo $col[0][$k] ?>" title="Edit Visi">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				</tr>
				<tr class = "row1">
				  <td align="left" valign="top">&nbsp;</td>
				  <td colspan="2" align="center" valign="top"><strong>Misi<strong></td>
				  <td colspan="2" align="center" valign="top"><a href="index.php?p=571&kdunit=<?php echo $col[1][$k] ?>" title="Tambah Misi">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Misi</a></td>
	  			</tr>
<?php 
				$sql = "SELECT * FROM tb_unitkerja_misi WHERE kdunit = '".$col[1][$k]."'"." order by kdmisi";
				$oMisi = mysql_query($sql);
				while ($Misi = mysql_fetch_array($oMisi))
				{
?>				
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				  <td width="5%" align="center" valign="top"><?php echo $Misi['kdmisi'] ?></td>
				  <td width="42%" align="left" valign="top"><?php echo $Misi['nmmisi'] ?></td>
				  <td align="center" valign="top"><a href="index.php?p=571&q=<?php echo $Misi['id'] ?>" title="Edit Misi">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
	              <td align="center" valign="top"><a href="index.php?p=572&q=<?php echo $Misi['id'] ?>" title="Delete Misi">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
				<?php
				} # akhir misi
				?>
	  			</tr>
				<tr class = "row1">
				  <td height="28" align="center" valign="top">&nbsp;</td>
				  <td colspan="2" align="center" valign="top"><strong>Tujuan</strong></td>
				  <td colspan="2" align="center" valign="top"><a href="index.php?p=573&kdunit=<?php echo $col[1][$k] ?>" title="Tambah Tujuan">
				  <img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Tujuan</a></td>
			   </tr>
	  		<?php
				$sql = "SELECT * FROM tb_unitkerja_tujuan WHERE kdunit = '".$col[1][$k]."'"." order by kdtujuan";
				$oTujuan = mysql_query($sql);
				while ($Tujuan = mysql_fetch_array($oTujuan))
				{
				?>	
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><?php echo $Tujuan['kdtujuan'] ?></td>
				  <td align="left" valign="top"><?php echo $Tujuan['nmtujuan'] ?></td>
				  <td align="center" valign="top"><a href="index.php?p=573&q=<?php echo $Tujuan['id'] ?>" title="Edit Tujuan">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				  <td align="center" valign="top"><a href="index.php?p=574&q=<?php echo $Tujuan['id'] ?>" title="Delete Tujuan">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
				  <?php
			} # akhir tujuan
			?>
	  		</tr>
	  		<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>
