
<script type="text/javascript">

function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}

</script>
<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp","commit","waktu_durasi","satuan_waktu");
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
	$kdunit = $_SESSION['xkdunit'];
	$kdbulan = $_GET['kdbulan'];
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	if( $q == '' )	$simpan = 'Tambah' ;
	if( $q <> '' )	$simpan = 'Simpan' ;
	if ($kdbulan == "") $kdbulan = date("m")+0;
	
if ( $_REQUEST['cari'] )
{
     $kdbulan = $_REQUEST['kdbulan'];
}	
	
	$sql = "SELECT * FROM mst_skp WHERE tahun = '$th' and nip = '$xusername_sess' and left(kdunitkerja,4) = '$kdunit'";

	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	$nib = $row['nip'];
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=388&kdbulan=<?php echo $kdbulan ?>"><?php
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=388&kdbulan=<?php echo $kdbulan ?>"><?php
				exit();
			}
		}
		else {?>
		
			 <meta http-equiv="refresh" content="0;URL=index.php?p=388&kdbulan=<?php echo $kdbulan ?>"><?php		
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
	<form action="index.php?p=388&kdbulan=<?php echo $kdbulan ?>" method="post" name="form">
	
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
		  <?php echo trim(nm_unitkerja(substr(kdunitkerja_peg($row['tahun'],$row['nib_atasan']),0,4).'00')).' - RISTEK' ?>		  </td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo nm_unitkerja(substr($row['kdunitkerja'],0,4).'00').' - RISTEK' ?></td>
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
		  <td class="key">Keterkaitan dengan SKP </td>
		  <td colspan="3"><select name="<?php echo $field[6] ?>">
                      <option value="<?php echo $value[6] ?>"><?php echo  substr(nm_skp($value[6]),0,80).'...' ?></option>
                      <option value="">- Pilih SKP -</option>
                    <?php
				$query = mysql_query("select id,nama_tugas,no_tugas from dtl_skp where id_skp = '$id_skp' order by no_tugas");
				while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['id'] ?>"><?php echo  $row['no_tugas'].'. '.substr($row['nama_tugas'],0,80).'...'; ?></option>
                    <?php
						} ?>
                      <option value="-1">*)Tugas Tambahan</option>
                      <option value="-2">**)Tugas Kreatifitas</option>
                      <option value="-3">***)Tugas Lainnya/ Tidak terkait dengan SKP</option>
                  </select></td>
	  </tr>
      
<tr>

<?php //waktu durasi ?>

		  <td class="key">Waktu Pengerjaan</td>
		  <td colspan="3"><input type="text" name="<?php echo $field[8] ?>" id="item_waktu"  size="10" value="<?php if($value[8]!=0) 
		  echo number_format($value[8],2,'.','') ?>" />&nbsp;		  	   
		  <select name="<?php echo $field[9] ?>">
						<option value="menit" <?php if($value[9]=="menit") echo "selected"; ?>>menit</option>			
						<option value="jam" <?php if($value[9]=="jam") echo "selected"; ?>>jam</option>
						<option value="hari" <?php if($value[9]=="hari") echo "selected"; ?>>hari</option>
						<option value="minggu" <?php if($value[9]=="minggu") echo "selected"; ?>>minggu</option>
						<option value="bulan" <?php if($value[9]=="bulan") echo "selected"; ?>>bulan</option>
						<option value="tahun" <?php if($value[9]=="tahun") echo "selected"; ?>>tahun</option>
		  </select></td>
	  </tr>     
      
		<tr>
		  <td class="key">Status isian aktivitas </td>
		  <td colspan="3">
		  <input name="<?php echo $field[7] ?>" type="radio" value="0" <?php if( $value[7] == 0 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Draft&nbsp;&nbsp;
	  	<input name="<?php echo $field[7] ?>" type="radio" value="1" <?php if( $value[7] == 1 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Setuju&nbsp;&nbsp;
		  </td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">	
				<div class="button2-right">
					<div class="prev">
						<a href="index.php?p=1">Kembali</a></div>
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

<br />
</form>
<div align="right">
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Pilih Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 12; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" />
	</form>
</div><br />
<form action="index.php?p=388&kdbulan=<?php echo $kdbulan ?>" method="post" name="form1">
<table width="65%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
        	<td align="right" colspan="9"><a href="javascript:javascript:(function(){function checkFrames(w) {try {var inputs = w.document.getElementsByTagName('input');for (var i=0; i < inputs.length; i++) {if (inputs[i].type &#038;& inputs[i].type == 'checkbox'){inputs[i].checked = !inputs[i].checked;}}} catch (e){}if(w.frames &#038;& w.frames.length>0){for(var i=0;i<w .frames.length;i++){var fr=w.frames[i];checkFrames(fr);}}}checkFrames(window);})()">Toggle all</w></a> | <input name="commit" type="submit" id="commit" value="Persetujuan"></td>
		<tr>
		  <th width="6%">No.</th>
		  <th width="12%">Tanggal</th>
		  <th width="27%">Uraian Kegiatan/Kejadian</th>
          <th width="8%">Durasi</th>
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
		  <th align="center">7</th>
		  <th colspan="3" align="center">8</th>
	  </tr>
	</thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and Month(tgl) = '$kdbulan' ORDER BY tgl");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
	
	<?php
	$checkbox = $_POST['checkbox'];
$commit = $_POST['commit'];

$oListx = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' ORDER BY tgl");
	$countx = mysql_num_rows($oListx);
if($commit){
for($i=0;$i<$countx;$i++){
		$commit_id = $checkbox[$i];
		$sql = "update dtl_aktivitas SET  commit='1' where id='$commit_id'";
		//echo "hai ". $commit_id; 
		
		$result = mysql_query($sql);
}
if($result){
	?>
<meta http-equiv="refresh" content="0;URL=index.php?p=388&kdbulan=<?php echo $kdbulan ?>">

<?php
}}
	?>
	
	
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="10">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				  <td height="37" align="center" valign="top"><?php echo $k+1 ?></td>
					<td align="center" valign="top"><?php echo reformat_tgl($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
                    <td align="left" valign="top"><?php echo $col[8][$k]." ".$col[9][$k] ?></td>
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
			      <td width="6%" align="center" valign="top">
				  <?php if ( $col[7][$k] <> '1' ) { ?>
		  <a href="index.php?p=388&q=<?php echo $col[0][$k] ?>&kdbulan=<?php echo $kdbulan ?>" title="Edit">
			  <img src="css/images/edit_f2.png" border="0" width="16" height="16"></a>
			  	<?php } ?>
			   	  </td>
				  <td width="5%" align="center" valign="top">
				  <?php if ( $col[7][$k] <> '1' ) { ?>
		  <a href="index.php?p=389&q=<?php echo $col[0][$k] ?>&kdbulan=<?php echo $kdbulan ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Hapus">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>
			  	  <?php } ?>
			  	  </td>
				  <td width="6%" align="center" valign="top"><?php if ( $col[7][$k] <> '1' ) { ?>
				  	
				  	<input name="checkbox[]" id="checkbox[]" type="checkbox" value="<?php echo $col[0][$k] ?>" /><?php  } ?></td>
				</tr>
<?php } 
	  } ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</form>
<?php 
	function nm_skp($id) {
		$data = mysql_query("select nama_tugas from dtl_skp where id='$id'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nama_tugas']);
		return $result;
	}
?>
