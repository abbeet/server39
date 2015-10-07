<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	$kdmenteri = setup_kddept_unit($kode).'1000' ;
?>
<strong><font size="+1"><?php echo 'Periode Renstra : '.$renstra ?></font></strong><br><br />
<table width="634" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="29%">Kementerian/Lembaga</th>
			
      <th colspan="3">Tujuan</th>
			<th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody>
<?php 
				$sql = "SELECT * FROM tb_unitkerja_tujuan WHERE kdunit = '480000' order by kdtujuan";
				$oTujuan = mysql_query($sql);
				while ($Tujuan = mysql_fetch_array($oTujuan))
				{
				$no += 1 ;
?>				
				<tr>
				  <td align="left" valign="top"><?php if ( $no == 1 ) { ?><?php echo nm_unit('480000') ?><?php } ?></td>
				  <td width="3%" align="center" valign="top"><?php echo $Tujuan['kdtujuan'] ?></td>
				  <td colspan="2" align="left" valign="top"><?php echo $Tujuan['nmtujuan'] ?></td>
				  <td width="5%" align="center" valign="top"></td>
	              <td width="9%" align="center" valign="top"></td>
				<?php
				} # akhir tujuan
				?>
	  			</tr>
				<tr class="<?php echo $class ?>">
				  <td height="28" align="center" valign="top">&nbsp;</td>
				  <td colspan="2" align="center" valign="top"><strong>Indikator Kinerja Utama (IKU)</strong></td>
				  <td width="12%" align="center" valign="top"><strong>Target<br />
				      <?php echo substr($renstra,0,4)+4 ?></strong></td>
				  <td colspan="2" align="center" valign="top"><a href="index.php?p=521&kdunit=<?php echo $kdmenteri ?>" title="Tambah IKU">
				  <img src="css/images/menu/add-icon.png" border="0" width="16" height="16">Tambah IKU</a></td>
			   </tr>
	  		<?php
				$sql = "SELECT * FROM m_iku_utama WHERE ta = '$th' order by no_iku";
				$oIKU = mysql_query($sql);
				while ($IKU = mysql_fetch_array($oIKU))
				{
				?>	
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><?php echo $IKU['no_iku'] ?></td>
				  <td width="42%" align="left" valign="top"><?php echo $IKU['nm_iku'] ?></td>
				  <td align="center" valign="top"><?php echo $IKU['target'] ?></td>
				  <td align="center" valign="top"><a href="index.php?p=521&q=<?php echo $IKU['id'] ?>" title="Edit IKU">
				  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a></td>
				  <td align="center" valign="top"><a href="index.php?p=522&q=<?php echo $IKU['id'] ?>" title="Delete IKU">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16"></a></td>
				  <?php
			} # akhir tujuan
			?>
	  		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</tfoot>
</table>
