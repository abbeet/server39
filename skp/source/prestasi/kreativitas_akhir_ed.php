<?php
	checkauthentication();
	$table = "dtl_skp_kreativitas";
	$field = array("id","id_skp","no_kreativitas","nama_kreativitas");
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
	if( $q == '' )	$simpan = 'Tambah' ;
	if( $q <> '' )	$simpan = 'Simpan' ;
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
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
				$value[1] = $id_skp ;
				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=441&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $id_skp ;
				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=441&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=441&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>
	<script type="text/javascript">
		function form_submit()
		{
			document.forms['form'].submit();
		}
	</script>
	<form action="index.php?p=441&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" method="post" name="form">
	<table width="755" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="2" align="center"><strong>PEJABAT PENILAI</strong></td>
		  <td colspan="2" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td class="key">Nama</td>
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
		    <td>
			<?php echo nm_jabatan_ij($row['kdjabatan']);
				  ?>			</td>
	    </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td>
		  <?php echo trim(nm_unitkerja(substr(kdunitkerja_peg($row['tahun'],$row['nib_atasan']),0,4).'00')).' - RISTEK' ;
				?>		  </td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo nm_unitkerja(substr($row['kdunitkerja'],0,4)).' - RISTEK' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>Kegiatan Kreativitas SKP Detil </strong></td>
	  </tr>
		
		<tr>
		  <td class="key">Lihat Akitivitas Harian</td>
		  <td colspan="3"><b><a href="index.php?p=417&id_skp=<?php echo $id_skp; ?>&pagess=<?php echo $_GET['pagess']; ?>&cari=<?php echo $_GET['cari']; ?>" target="_blank">Kegiatan Kreativitas</a></b></td>
		</tr>
		<tr>
		  <td class="key">No Urut Kegiatan Kreativitas</td>
		  <td colspan="3"><input type="text" name="<?php echo $field[2] ?>" size="3" value="<?php echo $value[2] ?>" /></td>
	  </tr>
		
		<tr>
		  <td class="key">Kegiatan Kreativitas</td>
		  <td colspan="3"><textarea name="<?php echo $field[3] ?>" rows="3" cols="70"><?php echo $value[3] ?></textarea></td>
		</tr>
		
	  
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">			
				<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>				  </div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onClick="form_submit();"><?php echo $simpan ?></a>					</div>
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
		  <th width="5%">No.</th>
		  <th width="31%">Kegiatan Tugas Tambahan </th>
		  <th width="6%" colspan="2">Aksi</th>
	  </tr>
		
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th colspan="2" align="center">3</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_skp_kreativitas WHERE id_skp = '$id_skp' ORDER BY no_kreativitas");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="4">Tidak ada data!</td></tr><?php
		}
		else {
			$totalAK=0;
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[2][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[3][$k] ?></td>
					<?php $totalAK = $totalAK + $col[3][$k]; ?>
				  <td align="center" valign="top">
		  <a href="index.php?p=441&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>			  	  </td>
				  <td align="center" valign="top">
		  <a href="index.php?p=442&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Hapus">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>				  </td>
				</tr>
			<?php
			}
			} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"><div align="center">Total</div></td><td></td>
		    <td></td>
		</tr>
	</tfoot>
</table>
</body>