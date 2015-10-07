<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp","commit","approv");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$sw = $_GET['sw'];
	$id_skp = $_REQUEST['id_skp'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$tgl1 = date("Y").'-'.date("m").'-01';
	$tgl2 = date("Y-m-d");

if ( $_REQUEST['tanggal'] )
{
     $tgl1 = $_REQUEST['tgl_1'];
     $tgl2 = $_REQUEST['tgl_2'];
}	

	$sql = "SELECT * FROM mst_skp WHERE tahun = '$th' and id = '$id_skp' ";

	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	$nib = $row['nib'];
	$id_skp = $row['id'];
	
?>	
	<form action="index.php?p=406&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="497" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">&nbsp;</td>
		  <td width="250">&nbsp;</td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><strong><?php echo nama_peg($row['nib']) ?></strong></td>
	  </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><strong><?php echo reformat_nipbaru(nip_peg($row['nib'])) ?></strong></td>
	  </tr>
		<tr>
		  <td class="key">Pangkat/Gol.Ruang</td>
		  <td><strong><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></strong></td>
	  </tr>
		<tr>
		  <td class="key">Jabatan</td>
		  <td><strong>
			<?php if( substr($row['kdunitkerja'],1,3) == '000' and substr($row['kdjabatan'],0,4) == '0011' ) 
				  {
					    echo nm_jabatan_eselon1($row['kdunitkerja']);
				  } 
				  elseif ( substr($row['kdunitkerja'],1,3) <> '000' and substr($row['kdjabatan'],0,3) == '001' )
				  {
						echo 'Kepala '.nm_unitkerja($row['kdunitkerja']);
				  }else{
						echo nm_jabatan_ij($row['kdjabatan']);
				  } ?>			</strong></td>
	  </tr>
		<tr>
		  <td class="key">Unit Kerja</td>
		  <td><strong><?php echo skt_unitkerja(substr($row['kdunitkerja'],0,2)).' - BATAN' ?></strong></td>
	  </tr>
<tr>
			<td>&nbsp;</td>
			<td colspan="3">	
				<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>				  </div>
				</div>
		</tr>  </table>
	<br>
	Tanggal &nbsp;&nbsp;<input name="tgl_1" type="text" class="form" id="tgl_1" 
					size="10" value="<?php echo $tgl1 ?>"/>&nbsp;
				
				<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "tgl_1",
						button : "a_triggerIMG",
						align : "BR",
						firstDay : 1,
						weekNumbers : false,
						singleClick : true,
						showOthers : true,
						ifFormat : "%Y-%m-%d"
					});
				</script>&nbsp;&nbsp;s/d &nbsp;&nbsp;
				<input name="tgl_2" type="text" class="form" id="tgl_2" 
					size="10" value="<?php echo $tgl2 ?>"/>&nbsp;
				
				<img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "tgl_2",
						button : "b_triggerIMG",
						align : "BR",
						firstDay : 1,
						weekNumbers : false,
						singleClick : true,
						showOthers : true,
						ifFormat : "%Y-%m-%d"
					});
				</script>
				<input type="submit" value="Tampilkan" name="tanggal"/>
	</form>
<br /><a href="source/prestasi/laporan_aktivitas_prn.php?id_skp=<?php echo $id_skp ?>&tgl1=<?php echo $tgl1 ?>&tgl2=<?php echo $tgl2 ?>" title="Cetak Laporan Aktivitas Harian" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a>&nbsp;&nbsp;|
<a href="source/prestasi/laporan_aktivitas_xls.php?id_skp=<?php echo $id_skp ?>&nib=<?php echo $row['nib'] ?>&th=<?php echo $th ?>&tgl1=<?php echo $tgl1 ?>&tgl2=<?php echo $tgl2 ?>" title="Cetak Laporan Aktivitas Harian" target="_blank"><font size="1">Excel</font></a>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="3%" rowspan="2">No.</th>
		  <th width="12%" rowspan="2">Tanggal</th>
		  <th width="37%" rowspan="2">Uraian Kegiatan/Kejadian</th>
		  <th width="19%" rowspan="2">Hasil</th>
		  <th width="22%" rowspan="2">Keterkaitan dengan SKP </th>
          <th colspan="2">Status</th>
      </tr>
		<tr>
		  <th width="22%">Persetujuan<br />Pegawai</th>
	      <th width="22%">Persetujuan<br />Atasan</th>
	  </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
	      <th align="center">&nbsp;</th>
	      <th align="center">&nbsp;</th>
	  </tr>
	</thead>
	<?php 
if ( $tgl1 <> '' and $tgl2 <> '' )
{
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and tgl >= '$tgl1' and tgl <= '$tgl2' ORDER BY tgl desc");
}else{
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' ORDER BY tgl desc");
}
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
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $k+1 ?></td>
					<td align="center" valign="top"><?php echo reformat_tgl($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[5][$k] ?></td>
					<td align="left" valign="top"><?php echo nm_skp($col[6][$k]) ?></td>
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
						echo "<font color='#0000FF'>Tidak Setuju</font>";
						break;
						default:
						echo "<font color='#FF0000'>Draft</font>";
						break;
					} ?>					</td>
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