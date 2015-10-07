<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp","commit");
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
	if( $q == '' )	$simpan = 'Tambah' ;
	if( $q <> '' )	$simpan = 'Simpan' ;
	
	$sql = "SELECT * FROM mst_skp WHERE tahun = '$th' and nib = '$xusername_sess' ";

	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	$nib = $row['nib'];
	$id_skp = $row['id'];
	
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
				$value[3] = $nib ;
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=388"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $id_skp ;
				$value[3] = $nib ;
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=388"><?php
				exit();
			}
		}
		else {?>
		
			<meta http-equiv="refresh" content="0;URL=index.php?p=388"><?php		
			exit();
	
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
	<form action="index.php?p=388" method="post" name="form">
	
	<table width="755" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="2" align="center"><strong>PEJABAT PENILAI</strong></td>
		  <td colspan="2" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td class="key">Nama</td>
		  <td width="207"><?php echo nama_peg($row['nib_atasan']) ?><input type="hidden" name="<?php echo $field[10] ?>" size="20" value="<?php echo $row['id'] ?>" /></td>
	      <td width="131" class="key">Nama</td>
	      <td width="178"><?php echo nama_peg($row['nib']) ?></td>
      </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib_atasan'])) ?></td>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib'])) ?></td>
	  </tr>
		<tr>
		  <td width="224" class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol_atasan']).' ('.nm_gol($row['kdgol_atasan']).')' ?></td>
		  <td class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></td>
	    </tr>
		<tr>
			<td class="key"> Jabatan </td>
			<td><?php echo $row['jabatan_atasan'] ?></td>
		    <td class="key">Jabatan</td>
		    <td>
			<?php if( substr($row['kdunitkerja'],1,3) == '000' and substr($row['kdjabatan'],0,4) == '0011' ) 
				  {
					    echo nm_jabatan_eselon1($row['kdunitkerja']);
				  } 
				  elseif ( substr($row['kdunitkerja'],1,3) <> '000' and substr($row['kdjabatan'],0,3) == '001' )
				  {
						echo 'Kepala '.nm_unitkerja($row['kdunitkerja']);
				  }else{
						echo nm_jabatan_ij($row['kdjabatan']);
				  } ?>			</td>
	    </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td>
		  <?php if ( kdunitkerja_peg($row['nib_atasan']) == '0000' ) 
		  		{
		  			echo 'BATAN';
				}else{
		        	echo trim(skt_unitkerja(substr(kdunitkerja_peg($row['nib_atasan']),0,2))).' - BATAN' ;
				}?>		  </td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo skt_unitkerja(substr($row['kdunitkerja'],0,2)).' - BATAN' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7">&nbsp;</td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>CATATAN HARIAN PELAKSANAAN TUGAS </strong></td>
	  </tr>
		
		<tr>
		  <td class="key">Tanggal</td>
		  <td colspan="3"><input name="<?php echo $field[2]; ?>" type="text" class="form" id="<?php echo $field[2]; ?>" 
					size="10" value="<?php echo $value[2]; ?>"/>&nbsp;
				
				<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
				<script type="text/javascript">
					Calendar.setup({
						inputField : "<?php echo $field[2]; ?>",
						button : "a_triggerIMG",
						align : "BR",
						firstDay : 1,
						weekNumbers : false,
						singleClick : true,
						showOthers : true,
						ifFormat : "%Y-%m-%d"
					});
				</script></td>
	  </tr>
		
		
		<tr>
		  <td class="key">Aktivitas</td>
		  <td colspan="3"><textarea name="<?php echo $field[4] ?>" rows="3" cols="70"><?php echo $value[4] ?></textarea></td>
		</tr>
		
		<tr>
		  <td class="key">Hasil<br><font color="#993366">jika ada</font></td>
		  <td colspan="3"><textarea name="<?php echo $field[5] ?>" rows="3" cols="70"><?php echo $value[5] ?></textarea></td>
	  </tr>
		<tr>
		  <td class="key">Keterkaitan denga SKP </td>
		  <td colspan="3"><select name="<?php echo $field[6] ?>">
                      <option value="<?php echo $value[6] ?>"><?php echo  substr(nm_skp($value[6]),0,80).'...' ?></option>
                      <option value="">- Pilih SKP -</option>
                    <?php
				$query = mysql_query("select id,nama_tugas,no_tugas from dtl_skp where id_skp = '$id_skp' order by no_tugas");
				while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['id'] ?>"><?php echo  $row['no_tugas'].' '.substr($row['nama_tugas'],0,80).'...'; ?></option>
                    <?php
						} ?>
                      <option value="-1">*)Tugas Tambahan</option>
                      <option value="-2">**)Tugas Kreatifitas</option>
                  </select></td>
	  </tr>
		<tr>
		  <td class="key">Status isian aktivitas </td>
		  <td colspan="3">
		  <input name="<?php echo $field[7] ?>" type="radio" value="0" <?php if( $value[7] == 0 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Draft&nbsp;&nbsp;
	  	<input name="<?php echo $field[7] ?>" type="radio" value="1" <?php if( $value[7] == 1 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Commit&nbsp;&nbsp;
		  </td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">	
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
<table width="65%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="6%">No.</th>
		  <th width="12%">Tanggal</th>
		  <th width="27%">Uraian Kegiatan/Kejadian</th>
		  <th width="8%">Hasil</th>
		  <th width="20%">Keterkaitan dengan SKP </th>
	      <th width="10%">Status</th>
	      <th colspan="3">Aksi</th>
	  </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
		  <th align="center">6</th>
		  <th colspan="3" align="center">7</th>
	  </tr>
	</thead>
	<?php 
	$tgl_batas = date("Y-m-d") - 40 ;
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and tgl >= '$tgl_batas' ORDER BY tgl desc");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
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
					<td align="left" valign="top"><?php echo nm_skp($col[6][$k]) ?></td>
				    <td align="center" valign="top">
					<?php 
					switch ( $col[7][$k] )
					{
						case '1':
						echo "<font color='#0000FF'>Commit</font>";
						break;
					
						default:
						echo "<font color='#FF0000'>Draft</font>";
						break;
					} ?>					</td>
			      <td width="6%" align="center" valign="top">
		  <a href="index.php?p=388&q=<?php echo $col[0][$k] ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>			  	  </td>
				  <td width="5%" align="center" valign="top">
		  <a href="index.php?p=389&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Hapus">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>				  </td>
				  <td width="6%" align="center" valign="top"><?php if ( $col[7][$k] <> '1' ) { ?><input type="checkbox" value="<?php echo $col[7][$k] ?>" /><?php } ?></td>
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