<?php
	checkauthentication();
	$table = "dtl_skp";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$id_skp = $_GET['id_skp'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
 ?>

<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=335&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>
					</div>
</div><br /><br />

<table width="59%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="5%" rowspan="2">No.</th>
		  <th width="67%" rowspan="2">Kegiatan Tugas Jabatan </th>
		  <th colspan="3">Catatan Harian Pelaksanaan Tugas</th>
	  </tr>
		<tr>
		  <th width="10%">Jumlah</th>
	      <th width="10%">Lihat</th>
	      <th>Cetak</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT id,no_tugas,nama_tugas FROM dtl_skp WHERE id_skp = '$id_skp' ORDER BY no_tugas");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td height="23" colspan="5" align="center">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$jumlah = jml_detil_aktivitas($row['nib'],$row['id'],$col[0][$k]) ;
				?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[1][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[2][$k] ?></td>
					<td align="center" valign="top"><?php echo $jumlah ?></td>
				    <td align="center" valign="top"><?php if ( $jumlah <> 0 ) { ?><a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $row['id'] ?>&id_dtl_skp=<?php echo $col[0][$k] ?>&sw=<?php echo $_REQUEST['sw'] ?>&pagess=<?php echo $_REQUEST['pagess'] ?>&cari=<?php echo $_REQUEST['cari'] ?>" title="Lihat Aktivitas Harian">Lihat Detil</a><?php } ?></td>
			      <td width="8%" align="center" valign="top"></tr>
				
			<?php
			}
			} 
			$jml_tambahan = jml_detil_aktivitas($row['nib'],$row['id'],-1) ;
			$jml_kreativitas = jml_detil_aktivitas($row['nib'],$row['id'],-2) ;
			$jml_lainnya = jml_detil_aktivitas($row['nib'],$row['id'],-3) ;
			?>
<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $col[1][$k]+1 ?></td>
				  <td align="left" valign="top"><?php echo 'Tugas Tambahan' ?></td>
				  <td align="center" valign="top"><?php echo $jml_tambahan ?></td>
	              <td align="center" valign="top"><?php if ( $jml_tambahan <> 0 ) { ?><a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $row['id'] ?>&id_dtl_skp=<?php echo -1 ?>" title="Lihat Aktivitas Harian">Lihat Detil</a><?php }	?></td>
      <td align="center" valign="top">	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $col[1][$k]+2 ?></td>
				  <td align="left" valign="top"><?php echo 'Kreativitas' ?></td>
				  <td align="center" valign="top"><?php echo $jml_kreativitas ?></td>
	              <td align="center" valign="top"><?php if ( $jml_kreativitas <> 0 ) { ?><a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $row['id'] ?>&id_dtl_skp=<?php echo -2 ?>" title="Lihat Aktivitas Harian">Lihat Detil</a><?php }	?></td>
      <td align="center" valign="top">	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $col[1][$k]+3 ?></td>
				  <td align="left" valign="top"><?php echo 'Tugas Lainnya' ?></td>
				  <td align="center" valign="top"><?php echo $jml_lainnya ?></td>
				  <td align="center" valign="top"><?php if ( $jml_lainnya <> 0 ) { ?><a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $row['id'] ?>&id_dtl_skp=<?php echo -3 ?>" title="Lihat Aktivitas Harian">Lihat Detil</a><?php }	?></td>
				  <td align="center" valign="top">                
	  </tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>
<?php 
	function jml_detil_aktivitas($nib,$id_skp,$id_dtl_skp) {
		$data = mysql_query("select count(id) as jumlah from  dtl_aktivitas where nib = '$nib' and id_skp = '$id_skp' and id_dtl_skp = '$id_dtl_skp' group by id_dtl_skp");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jumlah'];
		return $result;
	}
?>