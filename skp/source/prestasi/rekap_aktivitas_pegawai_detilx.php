<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp","commit","approv");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$sw = $_GET['sw'];
	$id_skp 	= $_REQUEST['id_skp'];
	$nib 		= $_REQUEST['nib'];
	$id_dtl_skp = $_REQUEST['id_dtl_skp'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$kdbulan = $_GET['kdbulan'];
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	?>	
	<script type="text/javascript">
		function form_submit()
		{
			document.forms['form'].submit();
		}
	</script>
	
<?php if ( $sw != 2 and $sw != 1 ) { ?>	
<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>')">Kembali</a>
					</div>
</div><br /><br />
<?php } ?>
<table width="65%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
		  <th align="left"><strong>
	      Kegiatan Tugas Jabatan (SKP) : <?php echo nm_skp($id_dtl_skp) ?><strong>
	      </th>
	  </tr>
	</thead>
</table>
<br />
<table width="65%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
		  <th width="4%" rowspan="2">No.</th>
		  <th width="12%" rowspan="2">Tanggal</th>
		  <th width="41%" rowspan="2">Uraian Kegiatan/Kejadian</th>
		  <th width="28%" rowspan="2">Hasil</th>
		  <th colspan="2">Status</th>
      </tr>
		<tr>
		  <th width="8%">Pegawai</th>
	      <th width="7%">Atasan</th>
	  </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
	      <th align="center">6</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and nib = '$nib' and id_dtl_skp = '$id_dtl_skp' ORDER BY tgl");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="6">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				  <td height="37" align="center" valign="top"><?php echo $k+1 ?></td>
					<td align="center" valign="top"><?php echo reformat_tgl($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[5][$k] ?></td>
					<td align="center" valign="top">
					<?php 
					switch ( $col[7][$k] )
					{
						case '1':
						echo "<font color='#0000FF'>Setuju</font>";
						break;
					
						default:
						echo "<font color='#FF0000'>Draft</font>";
						break;
					} ?>					</td>
			        <td align="center" valign="top">
					<?php 
					switch ( $col[8][$k] )
					{
						case '1':
						echo "<font color='#0000FF'>Setuju</font>";
						break;
						case '2':
						echo "<font color='#FF0000'>Tidak Setuju</font>";
						break;
						default:
						echo "<font color='#FF0000'>Draft</font>";
						break;
					} ?>	
					</td>
				</tr>
<?php } 
	  } ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
<?php 
	function nm_skp($id) {
		$data = mysql_query("select nama_tugas from dtl_skp where id='$id'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nama_tugas']);
		return $result;
	}
?>