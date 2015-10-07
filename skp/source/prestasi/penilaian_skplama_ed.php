
<?php
	checkauthentication();
	$table = "dtl_penilaian_skp_akhir";
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
	
	$sql = "SELECT * FROM mst_skp_mutasi WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	$sql = "SELECT jabatan_penilai FROM mst_penilai WHERE id_skp = '$id_skp' and nib_penilai = '$nib_penilai'";
	$qu_2 = mysql_query($sql);
	$row_2 = mysql_fetch_array($qu_2);
	if ( empty($row_2) )     $jabatan_penilai = $row['jabatan_atasan'];
	else     $jabatan_penilai = $row_2['jabatan_penilai'];
	
	
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
				$catatan        =$_REQUEST['catatan'];
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
				$catat    = $catatan[$i];
					if ($id <> ''){
				 		mysql_query("UPDATE dtl_penilaian_skp_akhir SET jumlah_nilai = '$jumlah', kualitas_nilai = '$kualitas', waktu_nilai = '$waktu', biaya_nilai = '$biaya', penghitungan = '$hitung', nilai_capaian = '$capaian' , catatan = '$catat' where id = '$id'");
					}else{
				 		mysql_query("INSERT INTO dtl_penilaian_skp_akhir(nib_penilai,id_skp,no_tugas,jumlah_nilai,kualitas_nilai,waktu_nilai,biaya_nilai,catatan)
									 values ('$nib', '$skp', '$tugas', '$jumlah', '$kualitas', '$waktu', '$biaya','$catat')");
					}
				}
				
				$tugas_tambahan_nilai_akhir = $_REQUEST['tugas_tambahan_nilai_akhir'];
				$kreativitas_nilai_akhir = $_REQUEST['kreativitas_nilai_akhir'];
				
				$nilai_skp = total_nilai_capaian_akhir($nib_penilai,$id_skp) + $tugas_tambahan_nilai_akhir + $kreativitas_nilai_akhir ;
				
				$sql = "SELECT * FROM mst_skp_mutasi WHERE id = '$id_skp'";
				$qu = mysql_query($sql);
				$row = mysql_fetch_array($qu);
	
				$sql = "SELECT jabatan_penilai FROM mst_penilai WHERE id_skp = '$id_skp' and nib_penilai = '$nib_penilai'";
				$qu_2 = mysql_query($sql);
				$row_2 = mysql_fetch_array($qu_2);
				if ( empty($row_2) )
				{
				mysql_query("INSERT INTO mst_penilai(id,id_skp,nib_penilai,jabatan_penilai,tahun,tugas_tambahan_nilai_akhir,kreativitas_nilai_akhir,nilai_skp)
								VALUES ('','$id_skp','$nib_penilai','$row[jabatan_atasan]','$row[tahun]','$tugas_tambahan_nilai_akhir','$kreativitas_nilai_akhir','$nilai_skp')");
				}else{
				 mysql_query("UPDATE mst_penilai SET tugas_tambahan_nilai_akhir = '$tugas_tambahan_nilai_akhir', kreativitas_nilai_akhir = '$kreativitas_nilai_akhir',
				 					nilai_skp = '$nilai_skp' where id_skp = '$id_skp' AND nib_penilai = '$nib_penilai'");
				}
				
				$status_real_akhir = $_REQUEST['status_real_akhir'];
				if ( $status_real_akhir == '2' )  $tgl_real_akhir = date('Y-m-d');
				else $tgl_real_akhir = $row['tgl_real_akhir'];
				
				 mysql_query("UPDATE mst_skp_mutasi SET status_real_akhir = '$status_real_akhir', tgl_real_akhir = '$tgl_real_akhir'
				 					 where id = '$id_skp'");
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=457&id_skp=<?php echo $id_skp ?>&nib_penilai=<?php echo $nib_penilai ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php
				exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=457&id_skp=<?php echo $id_skp ?>&nib_penilai=<?php echo $nib_penilai ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>"><?php		
		}
	} 
	?>
    
    <head>

    </head>
    
	<form action="index.php?p=457&id_skp=<?php echo $id_skp ?>&nib_penilai=<?php echo $nib_penilai ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" method="post" name="form" id="form">
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
		  <td rowspan="3" valign="top"><?php echo $jabatan_penilai ?></td>
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
		  <td colspan="4" align="center" class="row7"><strong>Penilaian  Capaian SKP Detil </strong></td>
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
          <th width="6%" rowspan="2">Catatan<br />Penilai</th>
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
          <th align="center">19</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no = 0 ;
	while($skp_dtl = mysql_fetch_array($qu_3))
	{
	$no += 1 ;
	$perhitungan = nilai_perhitungan_akhir($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ;
	$total_hitung += $perhitungan ;
	?>
    
    
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $skp_dtl['no_tugas'] ?></td>
				  <td align="left" valign="top"><?php echo $skp_dtl['nama_tugas'] ?>
					<?php if ( jml_detil_aktivitas($row['nib'],$id_skp,$skp_dtl['id']) <> 0 ) { ?>
					<br />
					<a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $id_skp ?>&id_dtl_skp=<?php echo $skp_dtl['id'] ?>&nib_penilai=<?php echo $nib_penilai ?>&sw=2&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Lihat Detil Aktivitas Harian" target="_blank">[Aktivitas Harian]</a>
					<?php } ?>
					<?php if ( ada_laporan($id_skp,$skp_dtl['no_tugas']) <> 0 ) { ?>
					<br />
					<?php file_laporan($id_skp,$skp_dtl['no_tugas']) ?>
					<?php } ?>
					</td>
					<td align="center" valign="top"><?php echo number_format($skp_dtl['ak_target'],"4",",",".") ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['jumlah_target'].' '.$skp_dtl['satuan_jumlah'] ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['kualitas_target'].' %' ?></td>
					<td align="center" valign="top"><?php echo $skp_dtl['waktu_target'].' '.$skp_dtl['satuan_waktu'] ?></td>
                    <td align="right" valign="top"><?php echo number_format($skp_dtl['biaya_target'],"0",",",".") ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['ak_real']?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['jumlah_real'].' '.$skp_dtl['satuan_jumlah'] ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['kualitas_real'].' %' ?></td>
                    <td align="center" valign="top"><?php echo $skp_dtl['waktu_real'].' '.$skp_dtl['satuan_waktu'] ?></td>
                    <td align="right" valign="top"><?php echo $skp_dtl['biaya_real']?></td>
                    <td align="left" valign="top"><input name="jumlah_nilai[]" type="text" id="jumlah_nilai" size="5" value="<?php echo nilai_jumlah($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onfocus="startCalculate(<?php echo $no-1;?>)" onblur="stopCalc()" <?php if ($row['status_real_akhir'] == 0) echo "disabled=\"disabled\""; ?> /><?php echo $skp_dtl['satuan_jumlah'] ?>
                    
                    
                    <input name="nox[]" id="nox" type="hidden" size="5" value="<?php echo $skp_dtl['jumlah_target'] ?>"/>
                    
                      <input name="no_tugas[]" type="hidden" size="5" value="<?php echo $skp_dtl['no_tugas'] ?>"/>
					<input name="id_nilai[]" type="hidden" size="3" value="<?php echo id_penilaian($nib_penilai,$id_skp,$skp_dtl['no_tugas'])?>"/></td>
                  <td align="left" valign="top"><input name="kualitas_nilai[]" type="text" id="kualitas_nilai" size="5" value="<?php echo nilai_kualitas($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onfocus="startCalculate(<?php echo $no-1;?>)" onblur="stopCalc()" <?php if ($row['status_real_akhir'] == 0) echo "disabled=\"disabled\""; ?> />		     <input name="noxy[]" id="noxy" type="hidden" size="5" value="<?php echo $skp_dtl['kualitas_target'] ?>"/>%</td>
                    <td align="left" valign="top"><input name="waktu_nilai[]" type="text" id="waktu_nilai" size="5" value="<?php echo nilai_waktu($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onfocus="startCalculate(<?php echo $no-1;?>)" onblur="stopCalc()" <?php if ($row['status_real_akhir'] == 0) echo "disabled=\"disabled\""; ?> />
                  <input name="noxyz[]" id="noxyz" type="hidden" size="5" value="<?php echo $skp_dtl['waktu_target'] ?>"/><?php echo $skp_dtl['satuan_waktu'] ?></td>
                    <td align="left" valign="top">
                    
					<?php if ( $skp_dtl['biaya_target'] <> 0 ) { ?>
					<input name="biaya_nilai[]" type="text" id="biaya_nilai" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" onFocus="startCalculate(<?php echo $no-1;?>)" onBlur="stopCalc()"/><input name="noxyz1[]" id="noxyz1" type="hidden" size="5" value="<?php echo $skp_dtl['biaya_target'] ?>"/>
					<?php }else{ ?>
					<input type="text" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>" disabled="disabled"/>
					<input name="biaya_nilai[]" type="hidden" id="biaya_nilai" size="5" value="<?php echo nilai_biaya($nib_penilai,$id_skp,$skp_dtl['no_tugas']) ?>"/><input name="noxyz1[]" id="noxyz1" type="hidden" size="5" value="<?php echo $skp_dtl['biaya_target'] ?>"/>
					<?php } ?>								</td>
			        <td align="center" valign="top">
                    <input name="penghitungan[]" id="penghitungan"  type="text" size="5" value="<?php echo number_format(nilai_perhitungan_akhir($nib_penilai,$id_skp,$skp_dtl['no_tugas']),"2",".",",") ?>"/></td>
		          <td align="center" valign="top">
                  
                  <!--ajie 18 june-->
                  
					<input name="nilai_capaian[]" id="nilai_capaian" type="text" size="5" value="<?php echo number_format(nilai_capaian($nib_penilai,$id_skp,$skp_dtl['no_tugas']),"2",".",",") ?>" onFocus="startCalculate(<?php echo $no-1;?>)" onBlur="stopCalc()"/></td>
				
                <td align="center" valign="top">
                  
                  <textarea name="catatan[]" id="catatan" rows="3" cols="30"><?php echo catat($nib_penilai,$id_skp,$skp_dtl['no_tugas']); ?> </textarea></td>
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
		
		if (d==0){
			var v = 3;} else {
			var v = 4;}	
				
					
		document.form.nilai_capaian[i].value = 	((parseInt(a,10)/parseInt(e,10)*100 ) + (parseInt(b,10)/parseInt(f,10)*100 ) + j + m)/v;
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
				  <td align="left" valign="top"><strong>Tugas Tambahan</strong>
				  <?php if ( jml_detil_aktivitas($row['nib'],$id_skp,-1) <> 0 ) { ?>
					<br />
					<a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $id_skp ?>&id_dtl_skp=<?php echo -1 ?>&nib_penilai=<?php echo $nib_penilai ?>&sw=2&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Lihat Detil Aktivitas Harian" target="_blank">[Aktivitas Harian]</a>
					<?php } ?>				  </td>
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
				  <td align="center" valign="top"><input name="tugas_tambahan_nilai_akhir" type="text" size="5" value="<?php echo $List_tambahan['tugas_tambahan_nilai_akhir'] ?>"/></td>
                  
                  		          <td align="center" valign="top">&nbsp;</td>
		    </tr>
<?php 
	$oList = mysql_query("SELECT * FROM dtl_skp_tugas_tambahan WHERE id_skp = '$id_skp' ORDER BY no_tugas");
	while($List = mysql_fetch_array($oList)) {
?>			
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><?php echo $List['no_tugas'] ?></td>
				  <td align="left" valign="top"><?php echo $List['nama_tugas'] ?>				  </td>
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
                  <td align="center" valign="top">&nbsp;</td>
		    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top"><strong>III</strong></td>
				  <td align="left" valign="top"><strong>Kreativitas</strong>
<?php if ( jml_detil_aktivitas($row['nib'],$id_skp,-2) <> 0 ) { ?>
					<br />
					<a href="index.php?p=410&nib=<?php echo $row['nib'] ?>&id_skp=<?php echo $id_skp ?>&id_dtl_skp=<?php echo -2 ?>&nib_penilai=<?php echo $nib_penilai ?>&sw=2&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>" title="Lihat Detil Aktivitas Harian" target="_blank">[Aktivitas Harian]</a>
					<?php } ?>				  </td>
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
				  <td align="center" valign="top"><input name="kreativitas_nilai_akhir" type="text" size="5" value="<?php echo $List_tambahan['kreativitas_nilai_akhir'] ?>"/></td>
                  
                   <td align="center" valign="top">&nbsp;</td>
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
                  <td align="center" valign="top">&nbsp;</td>
		    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td colspan="17" align="center" valign="top"><strong>NILAI CAPAIAN SKP</strong></td>
				  <td align="center" valign="top">
                  
                  
<!-- ajie -->				 
                 <?php 
	$datax = mysql_query("SELECT SUM(nilai_capaian) AS total_capaian FROM dtl_penilaian_skp_akhir where id_skp ='$id_skp' and nib_penilai = '$xusername_sess' ");
	
		
		$nx = mysql_query("select COUNT(*) as tot from dtl_penilaian_skp_akhir where id_skp = '$id_skp' and nib_penilai = '$xusername_sess' ");
		
		$resultx = mysql_fetch_assoc($datax) ;
		$resulty = mysql_fetch_assoc($nx);
		
		$x = $resultx['total_capaian'] ;	
		
		if ( !empty($resulty['tot'])) {
			$y =$resulty['tot'] ;
			$z = $x / $y;
			}
		else {
			$z= 0 ;
			}	
			
		
		
		
		
		
				 ?>
                 
                  <input name="nilai_skp" type="text" size="5" value="<?php echo number_format(($z +$List_tambahan['tugas_tambahan_nilai_akhir']+$List_tambahan['kreativitas_nilai_akhir']),"2",".",",") ?>"/>
                 
                 
                 <!-- <input name="nilai_skp" type="text" size="5" value="<?php //echo number_format((total_nilai_capaian($nib_penilai,$id_skp)+
				  																	//$List_tambahan['tugas_tambahan_nilai_awal']+
																					//$List_tambahan['kreativitas_nilai_awal']),"2",".",",") ?>"/>  -->                                                                                    </td>
                                                                                     <td align="center" valign="top">&nbsp;</td>
		    </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" align="right">Status Kirim</td>
		    <td colspan="16" align="left">
			<input name="status_real_akhir" type="radio" value="0" <?php if( $row['status_real_akhir'] == 0 ) echo 'checked="checked"' ?>/>&nbsp;&nbsp;Draf&nbsp;&nbsp;
	  		<input name="status_real_akhir" type="radio" value="1" <?php if( $row['status_real_akhir'] == 1 ) echo 'checked="checked"' ?> />&nbsp;&nbsp;Dikirim Pegawai&nbsp;&nbsp;
	  		<input name="status_real_akhir" type="radio" value="2" <?php if( $row['status_real_akhir'] == 2 ) echo 'checked="checked"' ?> />&nbsp;&nbsp;Dinilai Atasan&nbsp;&nbsp;			</td>
		    </tr>
	</tfoot>
</table>		  </td>
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
		$data = mysql_query("select id from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['id']);
		return $result;
	}
		
	function nilai_jumlah($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select jumlah_nilai from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['jumlah_nilai'])+0;
		return $result;
	}
	
	function nilai_kualitas($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select kualitas_nilai from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['kualitas_nilai'])+0;
		return $result;
	}
	
	function nilai_waktu($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select waktu_nilai from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['waktu_nilai'])+0;
		return $result;
	}
	
	function nilai_biaya($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select biaya_nilai from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['biaya_nilai'])+0;
		return $result;
	}
	// ajie 18 june 2013
function nilai_capaian($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select nilai_capaian from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nilai_capaian'])+0;
		return $result;
	}
		function nilai_id($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select id from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['id']);
		return $result;
	}

	
	function total_nilai_capaian_akhir($nib_penilai,$id_skp) {
		
		$data = mysql_query("SELECT SUM(nilai_capaian) AS total_capaian FROM dtl_penilaian_skp_akhir where id_skp ='$id_skp' and nib_penilai = '$nib_penilai' ");
		$rdata = mysql_fetch_array($data);
		$data = $rdata['total_capaian']; 
		$n = mysql_query("select COUNT(*) as n from dtl_penilaian_skp_akhir where id_skp = '$id_skp' and nib_penilai = '$nib_penilai'");
		$rn = mysql_fetch_array($n);
		$n = $rn['n'];
		$result = $data/$n ;
		return $result;
	}
	
	function jml_detil_aktivitas($nib,$id_skp,$id_dtl_skp) {
		$data = mysql_query("select count(id) as jumlah from  dtl_aktivitas where nib = '$nib' and id_skp = '$id_skp' and id_dtl_skp = '$id_dtl_skp' group by id_dtl_skp");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jumlah'];
		return $result;
	}
	//ajie 16 juli	
	function catat($nib_penilai,$id_skp,$no_tugas) {
		$data = mysql_query("select catatan from dtl_penilaian_skp_akhir where nib_penilai = '$nib_penilai' and id_skp = '$id_skp' and no_tugas = '$no_tugas'");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['catatan'];
		return $result;
	}
	
	function ada_laporan($id_skp,$no_tugas) {
		$n = 0 ;
		$data = mysql_query("select nama_file,ket_file from  dtl_skp_file where no_tugas = '$no_tugas' and id_skp = '$id_skp' order by no_urut");
		while($rdata = mysql_fetch_array($data))
		{ 
		$n += 1 ;
		}
		return $n ;
	}
	
	function file_laporan($id_skp,$no_tugas) {
		$no = 0 ;
		$data = mysql_query("select nama_file,ket_file from  dtl_skp_file where no_tugas = '$no_tugas' and id_skp = '$id_skp' order by no_urut");
		while($rdata = mysql_fetch_array($data))
		{ 
		$no += 1 ;
		?>
		<a href="file_skp/<?php echo $rdata['nama_file'] ?>" target="_blank">
		<font color="#FF00FF"><?php echo '[Laporan '.$no.']' ?></font></a>
		<?php if ( $no >= 2 ) echo '<br>'; 
		}
		return;
	}	
	
	?>