<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "tb_unitkerja";
	$field =  array("id","kdunit","nmunit","tugas");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kdmenteri = setup_kddept_unit($kode).'20000' ;

	$oList = mysql_query("select * from $table WHERE kdunit = '$kdmenteri' order by kdunit");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
?>
<table width="443" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="18%">Eselon I</th>
			
      <th colspan="2">Tugas Pokok</th>
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
					<td colspan="2" align="center" valign="top"><a href="index.php?p=503&q=<?php echo $col[0][$k] ?>" title="Edit Tugas Pokok">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				</tr>
				<tr class="row1">
				  <td align="center" valign="top">&nbsp;</td>
				  <td colspan="2" align="center" valign="top"><strong>Fungsi</strong></td>
				  <td colspan="2" align="center" valign="top"><a href="index.php?p=504&kdunit=<?php echo $col[1][$k] ?>" title="Tambah Fungsi">
							<img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah Fungsi</a></td>
	  </tr>
<?php 
				$sql = "SELECT * FROM tb_unitkerja_fungsi WHERE kdunit = '".$col[1][$k]."'"." order by kdfungsi";
				$oFungsi = mysql_query($sql);
				while ($Fungsi = mysql_fetch_array($oFungsi))
				{
?>				
				<tr class="row0">
				  <td align="center" valign="top">&nbsp;</td>
				  <td width="5%" align="center" valign="top"><?php echo $Fungsi['kdfungsi'] ?></td>
				  <td width="42%" align="left" valign="top"><?php echo $Fungsi['nmfungsi'] ?></td>
				  <td align="center" valign="top"><a href="index.php?p=504&q=<?php echo $Fungsi['id'] ?>" title="Edit Fungsi">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
	              <td align="center" valign="top"><a href="index.php?p=505&q=<?php echo $Fungsi['id'] ?>" title="Delete Fungsi">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
	  </tr>
				<?php
			} # akhir misi
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
	</tfoot>
</table>
