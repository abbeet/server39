<?php
	checkauthentication();
	$table = "mst_penilai";
	$field = array("id","id_skp","nib_penilai","jabatan_penilai","tahun");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	if( $q == '' )	$simpan = 'Tambah' ;
	if( $q <> '' )	$simpan = 'Simpan' ;
	$id_skp = $_REQUEST['id_skp'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdunit = substr($xkdunit,0,2);
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp' ORDER BY kdunitkerja,kdjabatan,grade";
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
				$value[3] = jabatan_peg($value[2]) ;
				$value[4] = $row['tahun'];
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=270&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $id_skp ;
				$value[3] = jabatan_peg($value[2]) ;
				$value[4] = $row['tahun'];
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=270&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=270&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>
	<form action="index.php?p=270&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form">
	<table width="755" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="4" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td colspan="3" class="key">Nama</td>
		  <td width="553"><?php echo nama_peg($row['nib']) ?></td>
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
		  <td colspan="4" align="center" class="row7">&nbsp;</td>
	  </tr>
		
		<tr>
		  <td width="189" class="key">Nama Pegawai </td>
		  <td colspan="3"><select name="<?php echo $field[2] ?>">
                      <option value="<?php echo $value[2] ?>"><?php echo  '['.$value[2].'] '.nama_peg($value[2]) ?></option>
                      <option value="">- Pilih Nama Pegawai -</option>
                    <?php
							$query = mysql_query("select Nib,left(NamaLengkap,60) as namapeg from m_idpegawai where ( left(KdUnitKerja,2) = '$kdunit' or KdUnitKerja= '0000' or KdUnitKerja= '1000' or KdUnitKerja= '2000' or KdUnitKerja= '3000' or KdUnitKerja= '4000' or KdUnitKerja= '5000'  )  and (KdStatusPeg = '1' or KdStatusPeg = '2' ) order by NamaLengkap");
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['Nib'] ?>"><?php echo  $row['Nib'].' '.$row['namapeg']; ?></option>
                    <?php
						} ?>
                  </select></td>
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
		  <th width="6%">No.</th>
		  <th width="43%">Nama Penilai </th>
		  <th width="43%">Jabatan</th>
		  <th colspan="2">Aksi</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT id,nib_penilai,jabatan_penilai FROM mst_penilai WHERE id_skp = '$id_skp' ORDER BY nib_penilai");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
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
					<td align="center" valign="top"><?php echo ($k+1) ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo $col[3][$k] ?></td>
				  <td width="3%" align="center" valign="top">
		  <a href="index.php?p=270&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>
			  	  </td>
				  <td width="5%" align="center" valign="top">
		  <a href="index.php?p=294&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Edit">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>
				  </td>
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
