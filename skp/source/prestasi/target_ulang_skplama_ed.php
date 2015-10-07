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
	if( $q == '' )	$simpan = 'Tambah' ;
	if( $q <> '' )	$simpan = 'Simpan' ;
	
	$sql = "SELECT * FROM mst_skp_mutasi WHERE id = '$id_skp'";
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
				$value[10] = $id_skp ;
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=446&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			} 
			else {
				// UPDATE
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
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=446&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=446&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<script>
function showText(c){
	if(c=="1")
	{
		document.getElementById('txt1').style.visibility="visible";
		document.getElementById('txt2').style.visibility="visible";
	}
	else
	{
		document.getElementById('txt1').style.visibility="hidden";
		document.getElementById('txt2').style.visibility="hidden";
	}
}

function updateTotal(){
	var item_ak = document.getElementById('item_ak');
	var total_ak = document.getElementById('total_ak');
	var item_waktu = document.getElementById('item_waktu');
	var total_waktu = document.getElementById('total_waktu');
	var jml_output = document.getElementById('jml_output');
	// update total AK dan total waktu
	total_ak.value = item_ak.value * jml_output.value;
	total_waktu.value = item_waktu.value * jml_output.value;;
}
</script>

<body onLoad="showText(0)">
	
	<script type="text/javascript">
		function form_submit()
		{
			document.forms['form'].submit();
		}
	</script>
	
	<form action="index.php?p=446&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" method="post" name="form">
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
				  } ?>			
			</td>
	    </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td>
		  <?php if ( kdunitkerja_peg($row['nib_atasan']) == '0000' ) 
		  		{
		  			echo 'BATAN';
				}else{
		        	echo trim(skt_unitkerja(substr(kdunitkerja_peg($row['nib_atasan']),0,2))).' - BATAN' ;
				}?>
		  </td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo skt_unitkerja(substr($row['kdunitkerja'],0,2)).' - BATAN' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>SKP Detil </strong></td>
	  </tr>
		<tr>
		  <td class="key">Form Bantu</td>
		  <td colspan="3"><b><a href="index.php?p=381&id_skp=<?php echo $id_skp; ?>&pagess=<?php echo $_GET['pagess']; ?>&cari=<?php echo $_GET['cari']; ?>">Isi SKP menggunakan Form Bantu</a></b></td>
		</tr>
		<tr>
		  <td class="key">No Urut Tugas</td>
		  <td colspan="3"><input type="text" name="<?php echo $field[1] ?>" size="3" value="<?php echo $value[1] ?>" /></td>
	  </tr>
		
		<tr>
		  <td class="key">Kegiatan Tugas Jabatan </td>
		  <td colspan="3"><textarea name="<?php echo $field[2] ?>" rows="3" cols="70"><?php echo $value[2] ?></textarea></td>
		</tr>
		
		<tr>
		  <td class="key">Kuantitas/Output</td>
		  <td colspan="3"><input type="text" name="<?php echo $field[4] ?>" id="jml_output" onChange="updateTotal()" 
		  size="10" value="<?php echo $value[4] ?>" />&nbsp;Satuan
		  	   <input type="text" name="<?php echo $field[5] ?>" size="20" value="<?php echo $value[5] ?>" />
		  	   &nbsp;<font color="#993366">(Misal : Laporan, Dokumen, Paket dst )</font></td>
	  </tr>
	  <tr>
		  <td class="key">Satuan Angka Kredit per output <font color="#993366">(jika ada)</font></td>
		  <td colspan="1"><input type="text" name="ak_per_output" id="item_ak" onChange="updateTotal()" size="10" value="<?php if($value[4]!=0) 
		      echo number_format($value[3]/$value[4],4,'.','') ?>" /></td>
		    <td class="key">Total Angka Kredit</td> 
			<td><input type="text" name="<?php echo $field[3] ?>" id="total_ak" size="10" value="<?php echo $value[3] ?>" /></td>
	  </tr>
		<tr>
		  <td class="key">Waktu Penyelesaian per output</td>
		  <td colspan="1"><input type="text" name="waktu_per_output" id="item_waktu" onChange="updateTotal()" size="10" value="<?php if($value[4]!=0) 
		  echo number_format($value[7]/$value[4],4,'.','') ?>" />&nbsp;		  	   
		  <select name="<?php echo $field[8] ?>">
						<option value="menit" <?php if($value[8]=="menit") echo "selected"; ?>>menit</option>			
						<option value="jam" <?php if($value[8]=="jam") echo "selected"; ?>>jam</option>
						<option value="hari" <?php if($value[8]=="hari") echo "selected"; ?>>hari</option>
						<option value="minggu" <?php if($value[8]=="minggu") echo "selected"; ?>>minggu</option>
						<option value="bulan" <?php if($value[8]=="bulan") echo "selected"; ?>>bulan</option>
						<option value="tahun" <?php if($value[8]=="tahun") echo "selected"; ?>>tahun</option>
		  </select></td>
		  <td class="key">Total Waktu</td><td> <input type="text" name="<?php echo $field[7] ?>" id="total_waktu" size="10" value="<?php echo $value[7] ?>" /></td>
	  </tr>
	  <tr>
		  <td class="key">Kualitas/Mutu</td>
		  <td colspan="3"><input type="text" name="<?php echo $field[6] ?>" size="10" value="<?php echo $value[6] ?>" />
	      &nbsp;<font color="#993366">(Dalam persen : 0% s/d 100%)</font></td>
	  </tr>
		<tr>
		  <td class="key">Kinerja berhubungan dengan biaya ? </td>
		  <td colspan="3">
	  	<input name="<?php echo $field[9] ?>" type="radio" id="rNo" value="<?php echo $value[9]?>" <?php if( $value[9] == 0 ) echo 'checked="checked"' ?> onChange="showText(0)"/> 
        &nbsp;&nbsp;Tidak&nbsp;&nbsp;
	  	<input name="<?php echo $field[9] ?>" type="radio" id="rYes" value="<?php echo $value[9]?>" <?php if( $value[9] > 0 ) echo 'checked="checked"' ?> onChange="showText(1)"/> 
        &nbsp;&nbsp;Ya &nbsp;&nbsp;<label id="txt1">Jumlah Anggaran (dalam Rp.)</label>
		  <input type="text" id="txt2" name="<?php echo $field[9] ?>" size="20" value="<?php echo $value[9] ?>" /></td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">			
				<div class="button2-right">
					<div class="prev">
					<?php if ( $sw == '' ) {?>
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>		
					<?php }else{ ?>	
						<a onClick="Cancel('index.php?p=252&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Kembali</a>		
					<?php } ?>
				  </div>
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
		  <th width="5%" rowspan="2">No.</th>
		  <th width="31%" rowspan="2">Kegiatan Tugas Jabatan </th>
		  <th width="10%" rowspan="2">Angka Kredit</th>
		  <th colspan="4">Target</th>
		  <th width="6%" colspan="2" rowspan="2">Aksi</th>
	  </tr>
		<tr>
		  <th width="16%">Kuantitas/Output</th>
	      <th width="19%">Kualitas/Mutu</th>
	      <th width="13%">Waktu</th>
	      <th width="13%">Biaya</th>
	  </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
		  <th align="center">6</th>
		  <th align="center">7</th>
		  <th colspan="2" align="center">8</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT id,no_tugas,nama_tugas,ak_target,jumlah_target,satuan_jumlah,kualitas_target, waktu_target, satuan_waktu, biaya_target FROM dtl_skp WHERE id_skp = '$id_skp' ORDER BY no_tugas");
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
			$totalAK=0;
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[1][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[2][$k] ?></td>
					<td align="center" valign="top"><?php echo $col[3][$k] ?></td>
					<?php $totalAK = $totalAK + $col[3][$k]; ?>
					<td align="center" valign="top"><?php echo $col[4][$k].' '.$col[5][$k] ?></td>
					<td align="center" valign="top"><?php echo $col[6][$k].' % ' ?></td>
					<td align="center" valign="top"><?php echo $col[7][$k].' '.$col[8][$k] ?></td>
                    <td align="right"><?php echo number_format($col[9][$k],"0",",",".") ?></td>
                  <td align="center" valign="top">
		  <a href="index.php?p=446&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>			  	  </td>
				  <td align="center" valign="top">
		  <a href="index.php?p=447&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Hapus">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>				  </td>
				</tr>
			<?php
			$nWaktu = $col[7][$k];
			$sWaktu = trim($col[8][$k]);
			$konversi = array("menit"=>1, "jam"=>60, "hari"=>300, "minggu"=>1500,
	                  			"bulan"=>6000, "tahun"=>72000);
			$sWaktu = strtolower($sWaktu);
				// penghitungan total waktu
			$totalMenit=$totalMenit+($nWaktu*$konversi[$sWaktu]);

			}
			} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"><div align="center">Total</div></td><td><div align="center"><b><font color="blue"><?php echo $totalAK ?></font></b></div></td><td></td>
		    <td></td>
		    <td align="center"><b><font color="blue"><?php echo number_format($totalMenit,"0",",",".") .' menit' ?></font></b>
			</td>
		    <td></td>
		    <td></td>
		    <td></td>
		</tr>
	</tfoot>
</table>
</body>