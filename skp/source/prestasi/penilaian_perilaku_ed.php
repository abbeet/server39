<?php
	checkauthentication();
	$table = "mst_perilaku";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$id = $_REQUEST['id'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	$sw = $_REQUEST['sw'];
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	

if ( $sw <> '' ) {

	$sql = "SELECT * FROM dtl_penilaian_perilaku WHERE id_skp = '$id'";
	$qu_nilai = mysql_query($sql);
	$nilai = mysql_fetch_array($qu_nilai);
	$q = $nilai['id'];

	switch ( $sw )
	{
		case 1 ;
		$nilai_1 = $_REQUEST['jml_nilai'];
		if ( $q == '' )    mysql_query("INSERT INTO dtl_penilaian_perilaku(id,id_skp,nib_penilai,nilai_1)
		                                VALUES('','$id','$row[nib_atasan]','$nilai_1')");
		else mysql_query("UPDATE dtl_penilaian_perilaku SET nilai_1 = '$nilai_1' WHERE id = '$q' ");
		break;
		case 2 ;
		$nilai_2 = $_REQUEST['jml_nilai'];
		if ( $q == '' )    mysql_query("INSERT INTO dtl_penilaian_perilaku(id,id_skp,nib_penilai,nilai_2)
		                                VALUES('','$id','$row[nib_atasan]','$nilai_2')");
		else mysql_query("UPDATE dtl_penilaian_perilaku SET nilai_2 = '$nilai_2' WHERE id = '$q' ");
		break;
		case 3 ;
		$nilai_3 = $_REQUEST['jml_nilai'];
		if ( $q == '' )    mysql_query("INSERT INTO dtl_penilaian_perilaku(id,id_skp,nib_penilai,nilai_3)
		                                VALUES('','$id','$row[nib_atasan]','$nilai_3')");
		else mysql_query("UPDATE dtl_penilaian_perilaku SET nilai_3 = '$nilai_3' WHERE id = '$q' ");
		break;
		case 4 ;
		$nilai_4 = $_REQUEST['jml_nilai'];
		if ( $q == '' )    mysql_query("INSERT INTO dtl_penilaian_perilaku(id,id_skp,nib_penilai,nilai_4)
		                                VALUES('','$id','$row[nib_atasan]','$nilai_4')");
		else mysql_query("UPDATE dtl_penilaian_perilaku SET nilai_4 = '$nilai_4' WHERE id = '$q' ");
		break;
		case 5 ;
		$nilai_5 = $_REQUEST['jml_nilai'];
		if ( $q == '' )    mysql_query("INSERT INTO dtl_penilaian_perilaku(id,id_skp,nib_penilai,nilai_5)
		                                VALUES('','$id','$row[nib_atasan]','$nilai_5')");
		else mysql_query("UPDATE dtl_penilaian_perilaku SET nilai_5 = '$nilai_5' WHERE id = '$q' ");
		break;
		case 6 ;
		$nilai_6 = $_REQUEST['jml_nilai'];
		if ( $q == '' )    mysql_query("INSERT INTO dtl_penilaian_perilaku(id,id_skp,nib_penilai,nilai_6)
		                                VALUES('','$id','$row[nib_atasan]','$nilai_6')");
		else mysql_query("UPDATE dtl_penilaian_perilaku SET nilai_6 = '$nilai_6' WHERE id = '$q' ");
		break;
	}
}

	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM dtl_penilaian_perilaku WHERE id_skp = '$id'";
	$qu_nilai = mysql_query($sql);
	$nilai = mysql_fetch_array($qu_nilai);
	$q = $nilai['id'];
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if ($q == "") {
				//ADD NEW		
			} 
			else {
				// UPDATE
				$nilai_1 = $_REQUEST['nilai_1'];
				$nilai_2 = $_REQUEST['nilai_2'];
				$nilai_3 = $_REQUEST['nilai_3'];
				$nilai_4 = $_REQUEST['nilai_4'];
				$nilai_5 = $_REQUEST['nilai_5'];
				$nilai_6 = $_REQUEST['nilai_6'];
				$sql = "UPDATE dtl_penilaian_perilaku SET nilai_1 = '$nilai_1',nilai_2 = '$nilai_2',
								nilai_3 = '$nilai_3',nilai_4 = '$nilai_4',
								nilai_5 = '$nilai_5',nilai_6 = '$nilai_6' WHERE id = '$q' ";
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=255&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=255&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>&id=<?php echo $id ?>&q=<?php echo $q ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="497" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="125" class="key">Tahun</td>
		  <td width="250"><?php echo $row['tahun'] ?></td>
	  </tr>
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><?php echo nama_peg($row['nip']) ?></td>
		</tr>
		<tr>
		  <td class="key">Jabatan </td>
		  <td><?php echo nm_jabatan_ij($row['kdjabatan']) ?></td>
		</tr>
		<tr>
		  <td class="key">Atasan Pegawai </td>
		  <td><?php echo nama_peg($row['nib_atasan']) ?></td>
	  </tr>
		<tr>
		  <td class="key">Jabatan Atasan </td>
		  <td><?php echo jabatan_peg($row['tahun'],$row['nib_atasan']) ?></td>
	  </tr>
		<tr>
		  <td colspan="2" align="center"><strong>Penilaian Perilaku</strong></td>
	  </tr>
		<tr>
		  <td colspan="2">
		  <table width="95%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
		  <th width="11%">No.</th>
		  <th width="41%">Aspek Yang Dinilai </th>
		  <th width="24%">Nilai</th>
		  <th width="24%">Kriteria Penilaian </th>
		</tr>
	</thead>
	<tbody>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top">1.</td>
					<td align="left" valign="top">Layanan</td>
					<td align="center" valign="top"><input type="text" name="nilai_1" size="10" value="<?php echo $nilai['nilai_1']  ?>" /></td>
					<td align="center" valign="top">
					<a href="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $nilai['id'] ?>&kdjns=1&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Kriteria Penilaian Layanan">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kriteria Penilaian</font></a></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">2.</td>
				  <td align="left" valign="top">Integritas</td>
				  <td align="center" valign="top"><input type="text" name="nilai_2" size="10" value="<?php echo $nilai['nilai_2']  ?>" /></td>
				  <td align="center" valign="top">
				  <a href="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $nilai['id'] ?>&kdjns=2&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Kriteria Penilaian Integritas">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kriteria Penilaian</font></a>				  </td>
		    </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">3.</td>
				  <td align="left" valign="top">Komitmen</td>
				  <td align="center" valign="top"><input type="text" name="nilai_3" size="10" value="<?php echo $nilai['nilai_3']  ?>" /></td>
				  <td align="center" valign="top">
				  <a href="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $nilai['id'] ?>&kdjns=3&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Kriteria Penilaian Komitmen">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kriteria Penilaian</font></a>				  </td>
		    </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">4.</td>
				  <td align="left" valign="top">Disiplin</td>
				  <td align="center" valign="top"><input type="text" name="nilai_4" size="10" value="<?php echo $nilai['nilai_4']  ?>" /></td>
				  <td align="center" valign="top">
				  <a href="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $nilai['id'] ?>&kdjns=4&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Kriteria Penilaian Disiplin">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kriteria Penilaian</font></a>				  </td>
		    </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">5.</td>
				  <td align="left" valign="top">Kerjasama</td>
				  <td align="center" valign="top"><input type="text" name="nilai_5" size="10" value="<?php echo $nilai['nilai_5']  ?>" /></td>
				  <td align="center" valign="top">
				  <a href="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $nilai['id'] ?>&kdjns=5&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Kriteria Penilaian Kerjasama">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kriteria Penilaian</font></a>				  </td>
		    </tr>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">6.</td>
				  <td align="left" valign="top">Kepemimpinan</td>
				  <td align="center" valign="top"><input type="text" name="nilai_6" size="10" value="<?php echo $nilai['nilai_6']  ?>" /></td>
				  <td align="center" valign="top">
				  <a href="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $nilai['id'] ?>&kdjns=6&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Kriteria Penilaian Kepemimpinan">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kriteria Penilaian</font></a>				  </td>
		    </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
	</tfoot>
</table>		  </td>
	  </tr>
		
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>