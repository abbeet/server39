<?php
	checkauthentication();
	$table = "dtl_skp";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$id_skp = $_REQUEST['id_skp'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	$sw = $_REQUEST['sw'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			{
				// UPDATE
				$no_tugas = $_REQUEST['no_tugas'];
				$ak_real = $_REQUEST['ak_real'];
				$jumlah_real = $_REQUEST['jumlah_real'];
				$kualitas_real = $_REQUEST['kualitas_real'];
				$waktu_real = $_REQUEST['waktu_real'];
				$biaya_real = $_REQUEST['biaya_real'];
				$status_real_akhir = $_REQUEST['status_real_akhir'];
				if ( $status_real_akhir == '1' )  $tgl_real_akhir = date('Y-m-d');
				else  $tgl_real_akhir = '0000-00-00' ;
				$id_skp = $id_skp ;
				for ($i = 0; $i<count($no_tugas); $i++)
				{
					$ak 		= $ak_real[$i] ;
					$id_tugas 	= $no_tugas[$i];
					$jumlah 	= $jumlah_real[$i];
					$kualitas 	= $kualitas_real[$i];
					$waktu 		= $waktu_real[$i];
					$biaya 		= $biaya_real[$i];
								
					mysql_query("UPDATE dtl_skp SET ak_real = '$ak', jumlah_real = '$jumlah', kualitas_real = '$kualitas', waktu_real = '$waktu', biaya_real = '$biaya' where id_skp = '$id_skp' AND no_tugas = '$id_tugas' ");
				}
				mysql_query("UPDATE mst_skp SET tgl_kemajuan_akhir = '$tgl_kemajuan_akhir', tgl_kemajuan_akhir = '$tgl_kemajuan_akhir', status_real_akhir = '$status_real_akhir', tgl_real_akhir = '$tgl_real_akhir'
								 WHERE id = '$id_skp' ");
/*
				$value[10] = $id_skp ;
			$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				}*/ 
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=407&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=407&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>
	<form action="index.php?p=269&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="755" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="2" align="center"><strong>PEJABAT PENILAI</strong></td>
		  <td colspan="2" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td height="21" class="key">Nama</td>
		  <td width="207"><?php echo nama_peg($row['nib_atasan']) ?><input type="hidden" name="<?php echo $field[10] ?>" size="20" value="<?php echo $row['id'] ?>" /></td>
	      <td width="131" class="key">Nama</td>
	      <td width="178"><?php echo nama_peg($row['nip']) ?></td>
      </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru($row['nib_atasan']) ?></td>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru($row['nip']) ?></td>
	  </tr>
		<tr>
		  <td width="224" class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat(kdgol_peg($row['tahun'],$row['nib_atasan'])).' ('.nm_gol(kdgol_peg($row['tahun'],$row['nib_atasan'])).')' ?></td>
		  <td class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></td>
	    </tr>
		<tr>
			<td class="key"> Jabatan </td>
			<td><?php echo jabatan_peg($row['tahun'],$row['nib_atasan']) ?></td>
		    <td class="key">Jabatan</td>
		    <td><?php echo nm_jabatan_ij($row['kdjabatan']) ?></td>
	    </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td><?php echo nm_unitkerja(substr(kdunitkerja_peg($row['tahun'],$row['nib_atasan']),0,4).'00').' - RISTEK' ?></td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo nm_unitkerja(substr($row['kdunitkerja'],0,4).'00').' - RISTEK' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>SKP Detil </strong></td>
	  </tr>
		<tr>
		  <td colspan="4" class="key">
		  <table width="95%" cellpadding="1" class="adminlist">
	<thead>
<?php 
	$sql = "SELECT * FROM $table WHERE id_skp = '$id_skp' order by no_tugas";
	$qu = mysql_query($sql);
?>		
		<tr>
		  <th width="4%" rowspan="2">No.</th>
		  <th width="17%" rowspan="2">Kegiatan Tugas Jabatan </th>
		  <th width="4%" rowspan="2">AK</th>
		  <th colspan="4">Target</th>
		  <th width="6%" rowspan="2">AK</th>
		  <th colspan="4">Realisasi</th>
		  </tr>
		<tr>
		  <th width="10%">Kuantitas<br>/Output</th>
	      <th width="10%">Kualitas<br>/Mutu</th>
	      <th width="7%">Waktu</th>
	      <th width="6%">Biaya</th>
	      <th width="11%">Kuantitas<br>/Output</th>
	      <th width="8%">Kualitas<br>/Mutu</th>
	      <th width="7%">Waktu</th>
	      <th width="10%">Biaya</th>
	  </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
		  <th align="center">6</th>
		  <th align="center">7</th>
		  <th align="center">8</th>
		  <th align="center">9</th>
		  <th align="center">10</th>
		  <th align="center">11</th>
		  <th align="center">12</th>
		  </tr>
	</thead>
	<tbody>
	<?php 
	while($skp_dtl = mysql_fetch_array($qu))
	{
	?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $skp_dtl['no_tugas'] ?>
					<input name="no_tugas[]" type="hidden" size="2" value="<?php echo $skp_dtl['no_tugas']?>"/></td>
					<td align="left" valign="top"><?php echo $skp_dtl['nama_tugas'] ?></td>
					<td align="center" valign="top"><?php echo number_format($skp_dtl['ak_target'],"4",",",".") ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['jumlah_target'].' '.$skp_dtl['satuan_jumlah'] ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['kualitas_target'].' %'?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['waktu_target'].' '.$skp_dtl['satuan_waktu'] ?></td>
                    <td align="right" valign="top"><?php echo number_format($skp_dtl['is_budget_use'],"0",",",".") ?></td>
                    <td align="left" valign="top"><input name="ak_real[]" type="text" size="5" value="<?php echo $skp_dtl['ak_real']?>"/></td>
                    <td align="left" valign="top"><input name="jumlah_real[]" type="text" size="5" value="<?php echo $skp_dtl['jumlah_real']?>"/><?php echo $skp_dtl['satuan_jumlah'] ?></td>
                    <td align="left" valign="top"><input name="kualitas_real[]" type="text" size="5" value="<?php echo $skp_dtl['kualitas_real']?>"/>%</td>
                    <td align="left" valign="top"><input name="waktu_real[]" type="text" size="5" value="<?php echo $skp_dtl['waktu_real']?>"/><?php echo $skp_dtl['satuan_waktu'] ?></td>
                    <td align="left" valign="top"><input name="biaya_real[]" type="text" size="5" value="<?php echo $skp_dtl['biaya_real']?>"/></td>
                </tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" align="right">Status Kirim</td>
		    <td colspan="9" align="left">
			<input name="status_real_akhir" type="radio" value="0" <?php if( $row['status_real_akhir'] == 0 ) echo 'checked="checked"' ?>/>&nbsp;&nbsp;Draf&nbsp;&nbsp;
	  		<input name="status_real_akhir" type="radio" value="1" <?php if( $row['status_real_akhir'] == 1 ) echo 'checked="checked"' ?> />&nbsp;&nbsp;Kirim&nbsp;&nbsp;
			</td>
		    </tr>
	</tfoot>
</table>		  </td>
	    </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">			
				<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>		
				  </div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onClick="form.submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>