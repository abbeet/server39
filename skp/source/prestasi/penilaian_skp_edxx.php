
<?php
	checkauthentication();
	$table = "dtl_penilaian_skp";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$id_skp = $_REQUEST['id_skp'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	$nib_penilai = $_REQUEST['nib_penilai'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	$sql = "SELECT jabatan_penilai FROM mst_penilai WHERE id_skp = '$id_skp' and nib_penilai = '$nib_penilai'";
	$qu_2 = mysql_query($sql);
	$row_2 = mysql_fetch_array($qu_2);
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			    
				$id_nilai = $_REQUEST['id_nilai'];
				$no_tugas = $_REQUEST['no_tugas'];
				$id_skp   = $id_skp ;
				$nib_penilai = $nib_penilai ;
				$nilai_jumlah   = $_REQUEST['jumlah_nilai'];
				$nilai_kualitas = $_REQUEST['kualitas_nilai'];
				$nilai_waktu    = $_REQUEST['waktu_nilai'];
				$nilai_biaya    = $_REQUEST['biaya_nilai'];
				$penghitungan   = $_REQUEST['penghitungan'];
				$nilai_capaian  = $_REQUEST['nilai_capaian'];
				$nilai_skp 		= $_REQUEST['nilai_skp'];
				
				for ($i = 0 ; $i < count($no_tugas) ; $i++)
				{
				$id 	  = $id_nilai[$i];
				$tugas    = $no_tugas[$i];
				$skp      = $id_skp;
				$nib  	  = $nib_penilai;
				$jumlah   = $nilai_jumlah[$i];
				$kualitas = $nilai_kualitas[$i];
				$waktu    = $nilai_waktu[$i];
				$biaya    = $nilai_biaya[$i];
				$hitung   = $penghitungan[$i];
				$capaian  = $nilai_capaian[$i];
					if ($id <> ''){
				 		mysql_query("UPDATE dtl_penilaian_skp SET jumlah_nilai = '$jumlah', kualitas_nilai = '$kualitas', waktu_nilai = '$waktu', biaya_nilai = '$biaya', penghitungan = '$hitung', nilai_capaian = '$capaian' where id = '$id'");
					}else{
				 		mysql_query("INSERT INTO dtl_penilaian_skp(nib_penilai,id_skp,no_tugas,jumlah_nilai,kualitas_nilai,waktu_nilai,biaya_nilai)
									 values ('$nib', '$skp', '$tugas', '$jumlah', '$kualitas', '$waktu', '$biaya')");
					}
				}
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=254&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=254&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	?>
    
    <head>
<script type="text/javascript">

function startCalculate(i){
//alert(i);
interval=setInterval("Calculate('"+i+"')",100);
}

function Calculate(i){
var a=document.form.jumlah_nilai[i].value;
var b=document.form.kualitas_nilai[i].value;
var c=document.form.waktu_nilai[i].value
document.form.penghitungan[i].value =  parseInt(a,10) + parseInt(b,10) + parseInt(c,10) ;
}

function stopCalc(){
clearInterval(interval);
}

</script> 
    </head>
    
	<form action="index.php?p=271&id_skp=<?php echo $id_skp ?>&nib_penilai=<?php echo $nib_penilai ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form" id="form">
	<table width="775" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="2" align="center"><strong>PEJABAT PENILAI</strong></td>
		  <td colspan="2" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td height="21" class="key">Nama</td>
		  <td width="273"><?php echo nama_peg($nib_penilai) ?></td>
	      <td width="172" class="key">Nama</td>
	      <td width="19"><?php echo nama_peg($row['nib']) ?></td>
      </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($nib_penilai)) ?></td>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib'])) ?></td>
	  </tr>
		<tr>
		  <td width="296" class="key">Jabatan</td>
		  <td rowspan="3" valign="top"><?php echo $row_2['jabatan_penilai'] ?></td>
		  <td class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></td>
	    </tr>
		<tr>
			<td class="key">&nbsp;</td>
			<td class="key">Jabatan</td>
		    <td><?php echo nm_jabatan_ij($row['kdjabatan']) ?></td>
	    </tr>
		<tr>
		  <td class="key">&nbsp;</td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo skt_unitkerja(substr($row['kdunitkerja'],0,2)).' - BATAN' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>Penilaian Akhir Capaian SKP</strong></td>
	  </tr>
		
		<tr>
		  <td colspan="4" class="key">
		  <table width="88%" cellpadding="1" class="adminlist">
	<thead>
<?php 
	$sql = "SELECT * FROM dtl_skp WHERE id_skp = '$id_skp'";
	$qu_3 = mysql_query($sql);
?>		
		<tr>
		  <th width="3%" rowspan="2">No.</th>
		  <th width="10%" rowspan="2">Kegiatan Tugas Jabatan </th>
		  <th width="3%" rowspan="2">AK</th>
		  <th colspan="4">Target</th>
		  <th width="3%" rowspan="2">AK</th>
		  <th colspan="4">Realisasi oleh Pegawai </th>
		  <th colspan="4">Realisasi oleh Penilaian</th>
		  <th width="6%" rowspan="2">Perhitungan</th>
		  <th width="6%" rowspan="2">Nilai Capaian</th>
		</tr>
		<tr>
		  <th width="8%">Kuantitas<br>/Output</th>
	      <th width="7%">Kualitas<br>/Mutu</th>
	      <th width="6%">Waktu</th>
	      <th width="5%">Biaya</th>
	      <th width="8%">Kuantitas<br>/Output</th>
	      <th width="7%">Kualitas<br>/Mutu</th>
	      <th width="6%">Waktu</th>
	      <th width="6%">Biaya</th>
	      <th width="8%">Kuantitas<br />Output</th>
	      <th width="7%">Kualitas<br />Mutu</th>
	      <th width="7%">Waktu</th>
	      <th width="6%">Biaya</th>
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
		  <th align="center">13</th>
		  <th align="center">14</th>
		  <th align="center">15</th>
		  <th align="center">16</th>
		  <th align="center">17</th>
		  <th align="center">18</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no = 0 ;
	while($skp_dtl = mysql_fetch_array($qu_3))
	{
	$no += 1 ;
	$perhitungan = nilai_perhitungan($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ;
	$total_hitung += $perhitungan ;
	?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $skp_dtl['no_tugas'] ?></td>
					<td align="left" valign="top"><?php echo $skp_dtl['nama_tugas'] ?></td>
					<td align="center" valign="top"><?php echo number_format($skp_dtl['ak_target'],"4",",",".") ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['jumlah_target'].' '.$skp_dtl['satuan_jumlah'] ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['kualitas_target'].' %' ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['waktu_target'].' '.$skp_dtl['satuan_waktu'] ?></td>
                    <td align="right" valign="top"><?php echo number_format($skp_dtl['is_budget_use'],"0",",",".") ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['ak_real']?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['jumlah_real'].' '.$skp_dtl['satuan_jumlah'] ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['kualitas_real'].' %' ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['waktu_real'].' '.$skp_dtl['satuan_waktu'] ?></td>
                    <td align="right" valign="top"><?php echo $skp_dtl['biaya_real']?></td>
                    <td align="left" valign="top">
					<input name="jumlah_nilai[]" type="text" id="jumlah_nilai" size="5" value="<?php echo nilai_jumlah($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onFocus="startCalculate(<?php echo $no-1;?>)" onBlur="stopCalc()" /><input name="no_tugas[]" type="hidden" size="5" value="<?php echo $skp_dtl['no_tugas'] ?>"/>
					<input name="id_nilai[]" type="hidden" size="3" value="<?php echo id_penilaian($nib_penilai,$id_skp,$skp_dtl['no_tugas'])?>"/></td>
                    <td align="left" valign="top">
					<input name="kualitas_nilai[]" type="text" id="kualitas_nilai" size="5" value="<?php echo nilai_kualitas($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onFocus="startCalculate(<?php echo $no-1;?>)" onBlur="stopCalc()"/></td>
                    <td align="left" valign="top">
					<input name="waktu_nilai[]" type="text" id="waktu_nilai" size="5" value="<?php echo nilai_waktu($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onFocus="startCalculate(<?php echo $no-1;?>)" onBlur="stopCalc()"/></td>
                    <td align="left" valign="top">
					<input name="biaya_nilai[]" type="text" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>"/></td>
			        <td align="center" valign="top">
					<input name="penghitungan[]" id="penghitungan"  type="text" size="5"/></td>
			        <td align="center" valign="top">
					<input name="nilai_capaian[]" type="text" size="5" value="<?php echo number_format($perhitungan/3,"2",".",",") ?>"/></td>
				</tr>
	<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td colspan="17" align="center" valign="top"><strong>NILAI CAPAIAN SKP</strong></td>
				  <td align="center" valign="top">
				  <input name="nilai_skp" type="text" size="5" value="<?php echo number_format(($total_hitung/3)/$no,"2",".",",") ?>"/></td>
		    </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
	</tfoot>
</table>		  </td>
	    </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">			
				<div class="button2-right">
					<div class="prev">
						<a onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>				  </div>
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
<br />

<?php 
	function id_penilaian($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select id from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['id']);
		return $result;
	}
	
	function nilai_jumlah($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select jumlah_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['jumlah_nilai']);
		return $result;
	}
	
	function nilai_kualitas($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select kualitas_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['kualitas_nilai']);
		return $result;
	}
	
	function nilai_waktu($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select waktu_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['waktu_nilai']);
		return $result;
	}
	
	function nilai_biaya($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select biaya_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['biaya_nilai']);
		return $result;
	}
	
	function nilai_id($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select id from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['id']);
		return $result;
	}
	
?>