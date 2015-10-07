<?php
	checkauthentication();
	$table = "dtl_skp";
	$field = array("id","no_tugas","nama_tugas","jumlah_target","satuan_jumlah","jumlah_real","kualitas_real");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$th = $_SESSION['xth'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_skp WHERE tahun = '$th' and nib = '$xusername_sess'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
 ?>

<table width="59%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="3%" rowspan="2">No.</th>
		  <th width="56%" rowspan="2">Kegiatan Tugas Jabatan </th>
		  <th width="13%">Target</th>
		  <th colspan="3">Realisasi Kemajuan SKP </th>
	      <th rowspan="2">Aksi</th>
	  </tr>
		<tr>
		  <th width="13%">Kuantitas/<br />Output</th>
		  <th width="8%">Kuantitas/<br />Output</th>
	      <th width="8%">Kualitas/<br />Mutu</th>
	      <th width="14%">File Dokumen </th>
      </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_skp WHERE id_skp = '$row[id]' ORDER BY no_tugas");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
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
					<td align="center" valign="top"><?php echo $col[3][$k].' '.$col[4][$k] ?></td>
					<td align="center" valign="top"><?php if ( $col[5][$k] <> 0 ) { ?>
				    <?php echo $col[5][$k].' '.$col[4][$k] ?><?php } ?></td>
				    <td align="center" valign="top"><?php if ( $col[5][$k] <> 0 ) { ?><?php echo $col[6][$k].' %' ?><?php } ?></td>
				    <td align="center" valign="top">&nbsp;</td>
			      <td width="6%" align="center" valign="top"><?php if ( $col[5][$k] <> 0 ) { ?><a href="index.php?p=426&id=<?php echo $col[0][$k]; ?>&id_skp=<?php echo $col[7][$k]; ?>&no_tugas=<?php echo $col[1][$k]; ?>&nama_tugas=<?php echo $col[2][$k]; ?>&nib=<?php echo $row['nib']; ?>">upload</a><?php } ?></tr>
				
			<?php
			}
			} 
			$jml_tambahan = jml_detil_aktivitas($row['nib'],$row['id'],-1) ;
			$jml_kreativitas = jml_detil_aktivitas($row['nib'],$row['id'],-2) ;
			?>
<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $col[1][$k]+1 ?></td>
				  <td align="left" valign="top"><?php echo 'Tugas Tambahan' ?></td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
	              <td align="center" valign="top">&nbsp;</td>
	              <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $col[1][$k]+2 ?></td>
				  <td align="left" valign="top"><?php echo 'Kreativitas' ?></td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
	              <td align="center" valign="top">&nbsp;</td>
	              <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">	  </tr>
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