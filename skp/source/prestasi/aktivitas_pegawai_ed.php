<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_aktivitas WHERE id = '$q'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	$tahun = $row['tahun'];
	$bulan = $row['bulan'];
	$nib = $row['nib'];
	
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
//				$sql = sql_insert($table,$field,$value);
//				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=264&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			} 
			else {
				// UPDATE
//				$value[10] = $id_skp ;
//				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=264&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=264&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
//		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>
	<form action="index.php?p=264&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" method="post" name="form">
	<table width="755" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="4" align="center"><strong>PROFILE PEGAWAI </strong></td>
	  </tr>
		<tr>
		  <td colspan="3" class="key">Nama</td>
		  <td width="504"><?php echo nama_peg($row['nib']) ?></td>
      </tr>
		<tr>
		  <td colspan="3" class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib'])) ?></td>
	  </tr>
		<tr>
		  <td colspan="3" class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></td>
	    </tr>
		<tr>
			<td colspan="3" class="key">Jabatan</td>
			<td><?php echo nm_jabatan_ij($row['kdjabatan']) ?></td>
	    </tr>
		<tr>
		  <td colspan="3" class="key">Unit Kerja</td>
		  <td><?php echo skt_unitkerja(substr($row['kdunitkerja'],0,2)).' - BATAN' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>Aktivitasi Pegawai </strong></td>
	  </tr>
		
		<tr>
		  <td width="224" class="key">Tanggal</td>
		  <td colspan="3"><input type="text" name="<?php echo $field[1] ?>" size="5" value="<?php echo $value[1] ?>" /></td>
	  </tr>
		
		<tr>
		  <td class="key">Aktivitas</td>
		  <td colspan="3"><textarea name="<?php echo $field[2] ?>" rows="5" cols="80"><?php echo $value[2] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Hasil</td>
		  <td colspan="3"><textarea name="<?php echo $field[2] ?>" rows="5" cols="80"><?php echo $value[2] ?></textarea></td>
	  </tr>
		
		
		
		
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">			
				<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>		
									</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onClick="form.submit();"><?php echo $simpan ?></a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="<?php echo $simpan ?>" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>
<br />
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="13%">Tanggal</th>
		  <th width="43%">Aktivitas</th>
		  <th width="38%">Hasil</th>
		  <th colspan="2">Aksi</th>
	  </tr>
		
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th colspan="2" align="center">4</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE tahun = '$tahun' and bulan = '$bulan' and nib = '$nib' ORDER BY tgl");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_array($oList)) {
		$col[0][] = $List['id'];
		$col[1][] = $List['tgl'].'-'.$List['bulan'].'-'.$List['tahun'];
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[1][$k] ?></td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
				  <td width="2%" align="center" valign="top">
		  <a href="index.php?p=264&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>			  	  </td>
				  <td width="4%" align="center" valign="top">
		  <a href="index.php?p=293&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Hapus">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>				  </td>
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
