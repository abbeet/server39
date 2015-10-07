
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
				
				$tugas_tambahan_nilai_awal = $_REQUEST['tugas_tambahan_nilai_awal'];
				$kreativitas_nilai_awal = $_REQUEST['kreativitas_nilai_awal'];
				$nilai_skp_awal = total_nilai_capaian($nib_penilai,$id_skp) + $tugas_tambahan_nilai_awal + $kreativitas_nilai_awal ;
				 mysql_query("UPDATE mst_penilai SET tugas_tambahan_nilai_awal = '$tugas_tambahan_nilai_awal', kreativitas_nilai_awal = '$kreativitas_nilai_awal',
				 					nilai_skp_awal = '$nilai_skp_awal' where id_skp = '$id_skp' AND nib_penilai = '$nib_penilai'");
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=418&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=418&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	?>
    
    <head>

    </head>
    
	<form action="index.php?p=419&id_skp=<?php echo $id_skp ?>&nib_penilai=<?php echo $nib_penilai ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form" id="form">
	<table width="775" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="2" align="center"><strong>PEJABAT PENILAI</strong></td>
		  <td colspan="2" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td height="21" class="key">Nama</td>
		  <td width="249"><?php echo nama_peg($nib_penilai) ?></td>
	      <td width="197" class="key">Nama</td>
	      <td width="398"><?php echo nama_peg($row['nib']) ?></td>
      </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($nib_penilai)) ?></td>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib'])) ?></td>
	  </tr>
		<tr>
		  <td width="130" class="key">Jabatan</td>
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
		  <td colspan="4" align="center" class="row7"><strong>Penilaian Kemajuan SKP Detil </strong></td>
	  </tr>
		<tr>
		  <td colspan="4" class="key">
		  <table width="88%" cellpadding="1" class="adminlist">
	<thead>
<?php 
	$sql = "SELECT * FROM dtl_skp WHERE id_skp = '$id_skp' order by no_tugas";
	$qu_3 = mysql_query($sql);
?>		
		<tr>
		  <th width="3%" rowspan="2">No.</th>
		  <th width="10%" rowspan="2">Tugas Jabatan </th>
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
                    <td align="right" valign="top"><?php echo number_format($skp_dtl['biaya_target'],"0",",",".") ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['ak_real_awal']?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['jumlah_real_awal'].' '.$skp_dtl['satuan_jumlah'] ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['kualitas_real_awal'].' %' ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['waktu_real_awal'].' '.$skp_dtl['satuan_waktu'] ?></td>
                    <td align="right" valign="top"><?php echo $skp_dtl['biaya_real_awal']?></td>
                    <td align="left" valign="top"><input name="jumlah_nilai[]" type="text" id="jumlah_nilai" size="5" value="<?php echo nilai_jumlah($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onfocus="startCalculate(<?php echo $no-1;?>)" onblur="stopCalc()" />
                    
                    
                    <input name="nox[]" id="nox" type="hidden" size="5" value="<?php echo $skp_dtl['jumlah_target'] ?>"/>
                    
                      <input name="no_tugas[]" type="hidden" size="5" value="<?php echo $skp_dtl['no_tugas'] ?>"/>
					<input name="id_nilai[]" type="hidden" size="3" value="<?php echo id_penilaian($nib_penilai,$id_skp,$skp_dtl['no_tugas'])?>"/></td>
                  <td align="left" valign="top"><input name="kualitas_nilai[]" type="text" id="kualitas_nilai" size="5" value="<?php echo nilai_kualitas($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onfocus="startCalculate(<?php echo $no-1;?>)" onblur="stopCalc()"/>		     <input name="noxy[]" id="noxy" type="hidden" size="5" value="<?php echo $skp_dtl['kualitas_target'] ?>"/></td>
                    <td align="left" valign="top"><input name="waktu_nilai[]" type="text" id="waktu_nilai" size="5" value="<?php echo nilai_waktu($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onfocus="startCalculate(<?php echo $no-1;?>)" onblur="stopCalc()"/>
                  <input name="noxyz[]" id="noxyz" type="hidden" size="5" value="<?php echo $skp_dtl['waktu_target'] ?>"/></td>
                    <td align="left" valign="top">
                    
					<?php if ( $skp_dtl['biaya_target'] <> 0 ) { ?>
					<input name="biaya_nilai[]" type="text" id="biaya_nilai" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onFocus="startCalculate(<?php echo $no-1;?>)" onBlur="stopCalc()"/><input name="noxyz1[]" id="noxyz1" type="hidden" size="5" value="<?php echo $skp_dtl['biaya_target'] ?>"/>
					<?php }else{ ?>
					<input type="text" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" disabled="disabled"/>
					<input name="biaya_nilai[]" type="hidden" id="biaya_nilai" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>"/><input name="noxyz1[]" id="noxyz1" type="hidden" size="5" value="<?php echo $skp_dtl['biaya_target'] ?>"/>
					<?php } ?>							
                   
								</td>
			        <td align="center" valign="top">
                    <input name="penghitungan[]" id="penghitungan"  type="text" size="5" value="<?php echo number_format(nilai_perhitungan($nib_penilai,$id_skp,$skp_dtl['no_tugas']),"2",".",",") ?>"/></td>
		          <td align="center" valign="top">
					<input name="nilai_capaian[]" type="text" size="5" value="<?php echo number_format(nilai_capaian($nib_penilai,$id_skp,$skp_dtl['no_tugas']),"2",".",",") ?>"/></td>
				</tr>
                    <script type="text/javascript">
//edit terakhir 14 june 2013 ajie noorseto
function startCalculate(i){
//alert(i);
interval=setInterval("Calculate('"+i+"')",100);
}

function Calculate(i){
var a=document.form.jumlah_nilai[i].value;
var b=document.form.kualitas_nilai[i].value;
var c=document.form.waktu_nilai[i].value;
var d=document.form.biaya_nilai[i].value;

//jumlah target ajie
var e=document.form.nox[i].value;
//kualitas target ajie
var f=document.form.noxy[i].value;
//waktu target ajie
var g=document.form.noxyz[i].value;
//biaya target ajie
var k=document.form.noxyz1[i].value;


// efisiensi waktu ajie
var h=(100 - (parseInt(c,10)/parseInt(g,10)*100) );
var j = null;		
// efisiensi biaya ajie
var l=(100 - (parseInt(d,10)/parseInt(k,10)*100) );
var m = null;	



if (h<=24) {
	j = (((1.76 * parseInt(g,10)) - parseInt(c,10)) / parseInt(g,10)) * 100 ; 
	}
	else {
			j = 76 - (((((1.76 * parseInt(g,10)) - parseInt(c,10)) / parseInt(g,10)) * 100)	- 100) ; 

			}
			
if (l<=24 ) {
	
	if (k==0) {
		m = 0;
	}
	else {
	 
	m = (((1.76 * parseInt(k,10)) - parseInt(d,10)) / parseInt(k,10)) * 100 ;
	}
	}
	else {
		if (k==0) {
		m = 0;
	}
	else {
			m = 76 - (((((1.76 * parseInt(k,10)) - parseInt(d,10)) / parseInt(k,10)) * 100)	- 100);
			
			/*document.form.penghitungan[i].value =  parseInt(d,10);*/
	}
			}
			
			document.form.penghitungan[i].value =  (parseInt(a,10)/parseInt(e,10)*100 ) + (parseInt(b,10)/parseInt(f,10)*100 ) + j + m;
			
			//document.form.penghitungan[i].value = m;
			
/*var j =null;
if (h<=24){
	j=1;
	document.form.penghitungan[i].value = j;
	}
	else {
		j=2;
		document.form.penghitungan[i].value = j;
		}		*/	
			
//document.form.penghitungan[i].value =  (parseInt(a,10)/parseInt(e,10)*100 ) + (parseInt(b,10)/parseInt(f,10)*100 ) + h + parseInt(d,10);

}

function stopCalc(){
clearInterval(interval);
}

</script> 
	<?php } ?>
	<?php 
	$oList_tambahan = mysql_query("SELECT * FROM mst_penilai WHERE id_skp = '$id_skp' AND nib_penilai = '$nib_penilai' ");
	$List_tambahan = mysql_fetch_array($oList_tambahan);
	?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><strong>II</strong></td>
				  <td align="left" valign="top"><strong>Tugas Tambahan</strong></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><input name="tugas_tambahan_nilai_awal" type="text" size="5" value="<?php echo $List_tambahan['tugas_tambahan_nilai_awal'] ?>"/></td>
		    </tr>
<?php 
	$oList = mysql_query("SELECT * FROM dtl_skp_tugas_tambahan WHERE id_skp = '$id_skp' ORDER BY no_tugas");
	while($List = mysql_fetch_array($oList)) {
?>			
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $List['no_tugas'] ?></td>
				  <td align="left" valign="top"><?php echo $List['nama_tugas'] ?></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
		    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><strong>III</strong></td>
				  <td align="left" valign="top"><strong>Kreativitas</strong></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><input name="kreativitas_nilai_awal" type="text" size="5" value="<?php echo $List_tambahan['kreativitas_nilai_awal'] ?>"/></td>
		    </tr>
<?php 
	$oList = mysql_query("SELECT * FROM dtl_skp_kreativitas WHERE id_skp = '$id_skp' ORDER BY no_kreativitas");
	while($List = mysql_fetch_array($oList)) {
?>			
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $List['no_kreativitas'] ?></td>
				  <td align="left" valign="top"><?php echo $List['nama_kreativitas'] ?></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="left" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top">&nbsp;</td>
		    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td colspan="17" align="center" valign="top"><strong>NILAI CAPAIAN SKP</strong></td>
				  <td align="center" valign="top">
				  <input name="nilai_skp" type="text" size="5" value="<?php echo number_format((total_nilai_capaian($nib_penilai,$id_skp)+
				  																	$List_tambahan['tugas_tambahan_nilai_awal']+
																					$List_tambahan['kreativitas_nilai_awal']),"2",".",",") ?>"/></td>
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
		$result = trim($rdata['jumlah_nilai'])+0;
		return $result;
	}
	
	function nilai_kualitas($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select kualitas_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['kualitas_nilai'])+0;
		return $result;
	}
	
	function nilai_waktu($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select waktu_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['waktu_nilai'])+0;
		return $result;
	}
	
	function nilai_biaya($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select biaya_nilai from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['biaya_nilai'])+0;
		return $result;
	}
	
function nilai_capaian($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select nilai_capaian from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nilai_capaian'])+0;
		return $result;
	}
		function nilai_id($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select id from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['id']);
		return $result;
	}
	
	function total_nilai_capaian($nib_penilai,$id_skp) {
		$data = mysql_query("select * from dtl_penilaian_skp where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' GROUP BY id_skp");
		while($rdata = mysql_fetch_array($data))
		{
			if ( $rdata['jumlah_nilai'] <> 0 ) 
			{
			   $total_nilai = +$rdata['nilai_capaian'];
			   $n +=1 ;
			 }
		}
		$result = $total_nilai/$n ;
		return $result;
	}
?>