<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Footer() 
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
			$this->Cell(0,10,'Hal '.$this->PageNo().' dari {nb}',0,0,'R');
		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$id_skp = $_REQUEST['id_skp'];
	$sw = $_REQUEST['sw'];
	/*	
	//$status = $_POST['kode'];
	//$sw = $_REQUEST['sw'];
	//$tgl = date ('Y-m-d') ;

	if ( $status == '0' and $sw == '0' )	mysql_query("UPDATE mst_skp SET is_approved_awal = '0', tgl_approved_awal = '0000-00-00' WHERE id = '$id_skp'");
	if ( $status == '1' and $sw == '0' )	mysql_query("UPDATE mst_skp SET is_approved_awal = '1', tgl_approved_awal = '$tgl' WHERE id = '$id_skp'");
	if ( $status == '0' and $sw == '1' )	mysql_query("UPDATE mst_skp SET is_approved_akhir = '0', tgl_approved_akhir = '0000-00-00' WHERE id = '$id_skp'");
	if ( $status == '1' and $sw == '1' )	mysql_query("UPDATE mst_skp SET is_approved_akhir = '1', tgl_approved_akhir = '$tgl' WHERE id = '$id_skp'");
	
	if ( $status <> '' and $sw <> '' ) #------ cetak aja tanpa approv
	{
	
	if ($status == 1 )
	{
	
	$tgl = date ('Y-m-d') ;
	
	if ( $sw == '' ) { # approved pegawai status kirim
		mysql_query("UPDATE mst_skp SET is_approved_awal = '1', tgl_approved_awal = '$tgl' WHERE id = '$id_skp'");
	}else{   # approved atasan status kirim
		mysql_query("UPDATE mst_skp SET is_approved_akhir = '1', tgl_approved_akhir = '$tgl' WHERE id = '$id_skp'");
	}
	
	}else{
	
	if ( $sw == '' ) {  # approved pegawai status batal
		mysql_query("UPDATE mst_skp SET is_approved_awal = '0', tgl_approved_awal = '0000-00-00' WHERE id = '$id_skp'");
	}else{  # approved atasan status batal
		mysql_query("UPDATE mst_skp SET is_approved_akhir = '0', tgl_approved_akhir = '0000-00-00' WHERE id = '$id_skp'");
	}
	
	}
	
	} # endif
	
*/

	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 10;
	$tinggi = 275 ;
	$w = array(0,190);
	
	if ( $sw == 1 )
	{
	$sql = "SELECT * FROM mst_skp_mutasi WHERE id = '$id_skp'";
	}else{
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	}
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'FORMULIR SASARAN KERJA','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'PEGAWAI NEGERI SIPIL','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'TAHUN '.$row['tahun'],'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(10,30,45,15,30,60);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1]+$w1[2],$ln,'I. PEJABAT PENILAI',$border,0,'L');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$pdf->Cell($w1[3],$ln,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$pdf->Cell($w1[4]+$w1[5],$ln,'II. PEGAWAI NEGERI SIPIL YANG DINILAI',$border,1,'L');
	$pdf->SetFont($font,'',$size);

	$max = 0 ;
	$arrNo_1	  = $pdf->SplitToArray($w1[0],$ln,'1');
	$arrLabel_1	  = $pdf->SplitToArray($w1[1],$ln,'Nama');
	$arrField_1	  = $pdf->SplitToArray($w1[2],$ln,trim(nama_peg($row['nib_atasan'])));
	$arrNo_2	  = $pdf->SplitToArray($w1[3],$ln,'1');
	$arrLabel_2	  = $pdf->SplitToArray($w1[4],$ln,'Nama');
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,trim(nama_peg($row['nip'])));

	if ($max<count($arrField_1)) $max=count($arrField_1);
	if ($max<count($arrField_2)) $max=count($arrField_2);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo_1[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrField_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNo_2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrLabel_2[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrField_2[$i],'LR',1,'L');
	}

	$max = 0 ;
	$arrNo_1	  = $pdf->SplitToArray($w1[0],$ln,'2');
	$arrLabel_1	  = $pdf->SplitToArray($w1[1],$ln,'NIP');
	$arrField_1	  = $pdf->SplitToArray($w1[2],$ln,reformat_nipbaru($row['nib_atasan']));
	$arrNo_2	  = $pdf->SplitToArray($w1[3],$ln,'2');
	$arrLabel_2	  = $pdf->SplitToArray($w1[4],$ln,'NIP');
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,reformat_nipbaru($row['nip']));

	if ($max<count($arrField_1)) $max=count($arrField_1);
	if ($max<count($arrField_2)) $max=count($arrField_2);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo_1[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrField_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNo_2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrLabel_2[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrField_2[$i],'LR',1,'L');
	}

	$max = 0 ;
	$arrNo_1	  = $pdf->SplitToArray($w1[0],$ln,'3');
	$arrLabel_1	  = $pdf->SplitToArray($w1[1],$ln,'Pangkat/Gol.');
	$arrField_1	  = $pdf->SplitToArray($w1[2],$ln,nm_pangkat(kdgol_peg($row['tahun'],$row['nib_atasan'])).' ('.nm_gol(kdgol_peg($row['tahun'],$row['nib_atasan'])).')');
	$arrNo_2	  = $pdf->SplitToArray($w1[3],$ln,'3');
	$arrLabel_2	  = $pdf->SplitToArray($w1[4],$ln,'Pangkat/Gol.');
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')');

	if ($max<count($arrField_1)) $max=count($arrField_1);
	if ($max<count($arrField_2)) $max=count($arrField_2);
	

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo_1[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrField_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNo_2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrLabel_2[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrField_2[$i],'LR',1,'L');
	}

	
	$max = 0 ;
	$arrNo_1	  = $pdf->SplitToArray($w1[0],$ln,'4');
	$arrLabel_1	  = $pdf->SplitToArray($w1[1],$ln,'Jabatan');
	$arrField_1	  = $pdf->SplitToArray($w1[2],$ln,jabatan_peg($row['tahun'],$row['nib_atasan']));
	$arrNo_2	  = $pdf->SplitToArray($w1[3],$ln,'4');
	$arrLabel_2	  = $pdf->SplitToArray($w1[4],$ln,'Jabatan');
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,nm_jabatan_ij($row['kdjabatan']));

	if ($max<count($arrField_1)) $max=count($arrField_1);
	if ($max<count($arrField_2)) $max=count($arrField_2);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo_1[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrField_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNo_2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrLabel_2[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrField_2[$i],'LR',1,'L');
	}

	$max = 0 ;
	$arrNo_1	  = $pdf->SplitToArray($w1[0],$ln,'5');
	$arrLabel_1	  = $pdf->SplitToArray($w1[1],$ln,'Unit Kerja');
	$arrField_1	  = $pdf->SplitToArray($w1[2],$ln,nm_unitkerja(substr($row['kdunitkerja'],0,4).'00').'-RISTEK');  
	$arrNo_2	  = $pdf->SplitToArray($w1[3],$ln,'5');
	$arrLabel_2	  = $pdf->SplitToArray($w1[4],$ln,'Unit Kerja');
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,nm_unitkerja(substr(kdunitkerja_peg($row['tahun'],$row['nib_atasan']),0,4).'00').'-RISTEK');

	if ($max<count($arrField_1)) $max=count($arrField_1);
	if ($max<count($arrField_2)) $max=count($arrField_2);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo_1[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrField_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNo_2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrLabel_2[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrField_2[$i],'LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());

	$w2 = array(10,75,15,25,20,20,25);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w2[0],$ln*3,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w2[0]);
	$pdf->Cell($w2[1],$ln*3,'III. KEGIATAN TUGAS JABATAN',$border,0,'L');
	$pdf->SetFont($font,'B',$size-3);
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln*2,'ANGKA',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y+6);
	$pdf->Cell($w2[2],$ln,'KREDIT',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln*3,'',$border,0,'C');
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
	$pdf->Cell($w2[3]+$w2[4]+$w2[5]+$w2[6],$ln,'TARGET',$border,1,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y);
	$pdf->Cell($w2[3],$ln,'Kuantitas',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y+4);
	$pdf->Cell($w2[3],$ln,'/Output',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y);
	$pdf->Cell($w2[3],$ln*2,'',$border,0,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y);
	$pdf->Cell($w2[4],$ln,'Kualitas',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y+4);
	$pdf->Cell($w2[4],$ln,'/Mutu',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y);
	$pdf->Cell($w2[4],$ln*2,'',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]);
	$pdf->Cell($w2[5],$ln*2,'Waktu',$border,0,'C');
	
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$y);
	$pdf->Cell($w2[6],$ln,'Biaya',$noborder,1,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$y+4);
	$pdf->Cell($w2[6],$ln,'(ribuan)',$noborder,1,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$y);
	$pdf->Cell($w2[6],$ln*2,'',$border,1,'C');
	$pdf->SetFont($font,'',$size);
	$oList = mysql_query("SELECT id,no_tugas,nama_tugas,ak_target,jumlah_target,satuan_jumlah,kualitas_target, waktu_target, satuan_waktu, biaya_target FROM dtl_skp WHERE id_skp = '$id_skp' ORDER BY no_tugas Asc");
	
	$totalAK=0.0;
	$totalMenit=0;
	while($List = mysql_fetch_array($oList)) {

	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,$List['no_tugas'].'.');
	$arrUraian	  = $pdf->SplitToArray($w2[1],$ln,trim($List['nama_tugas']));
	$AK = $List['ak_target'];
	$totalAK = $totalAK + $AK;
	$arrAk_kredit = $pdf->SplitToArray($w2[2],$ln,number_format($AK,"4",",","."));
	$arrOutput	  = $pdf->SplitToArray($w2[3],$ln,$List['jumlah_target'].' '.trim($List['satuan_jumlah']));
	$arrMutu	  = $pdf->SplitToArray($w2[4],$ln,$List['kualitas_target'].' %');
	$nWaktu = $List['waktu_target'];
	$sWaktu = trim($List['satuan_waktu']);
	
	$arrWaktu	  = $pdf->SplitToArray($w2[5],$ln,$nWaktu.' '.$sWaktu);
	$arrBiaya	  = $pdf->SplitToArray($w2[5],$ln,number_format($List['biaya_target']/1000,"0",",","."));

	$konversi = array("menit"=>1, "jam"=>60, "hari"=>300, "minggu"=>1500,
	                  "bulan"=>6000, "tahun"=>72000);
	$sWaktu = strtolower($sWaktu);
	// penghitungan total waktu
	$totalMenit=$totalMenit+($nWaktu*$konversi[$sWaktu]);
	
	if ($max<count($arrUraian)) $max=count($arrUraian);
	if ($max<count($arrOutput)) $max=count($arrOutput);
	if ($max<count($arrWaktu)) $max=count($arrWaktu);
	
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell($w2[2],$ln,$arrAk_kredit[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
		$pdf->Cell($w2[3],$ln,$arrOutput[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]);
		$pdf->Cell($w2[4],$ln,$arrMutu[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]);
		$pdf->Cell($w2[5],$ln,number_format($arrWaktu[$i],"0",",","."),'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
		$pdf->Cell($w2[6],$ln,$arrBiaya[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$pdf->GetY());
	}  

// rekap	
$pdf->SetX($margin);
$pdf->Cell($w2[0],$ln,'','LR',0,'C');
$pdf->SetX($margin+$w2[0]);
$pdf->Cell($w2[1],$ln,'T o t a l','LR',0,'C');
$pdf->SetX($margin+$w2[0]+$w2[1]);
// total angka kredit
$totalAK = number_format($totalAK,"4",",",".");
$pdf->Cell($w2[2],$ln,$totalAK,'LR',0,'C');
$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
$pdf->Cell($w2[3],$ln,'','',0,'L');
$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]);
$pdf->Cell($w2[4],$ln,'','',0,'C');
$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]);
// total menit
if(substr($row['kdjabatan'],0,3) != '001')
{
	$pdf->Cell($w2[5],$ln,number_format($totalMenit,"0",",",".") . ' menit','',0,'L');
}
else
{
	$pdf->Cell($w2[5],$ln,'','',0,'L');
}
$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
$pdf->Cell($w2[6],$ln,'','R',1,'R');
$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$pdf->GetY());
	
# AKHIR WHILE
	if ( $pdf->GetY() >= 240 ) 	$pdf->AddPage();
//------------------ Tanda Tangan	
	$w3 = array(50,80,50);
	$pdf->Ln();
	
	if ( $row['is_approved_akhir'] == '1' ) {
	$tanggal = $row['tahun'].'-01-01' ;
	$pdf->SetX($margin);
	$pdf->Cell($w3[0],$ln,'','',0,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,kota_unit(substr($row['kdunitkerja'],0,2)).', '.reformat_tanggal($tanggal),'',1,'C');
	}
	$pdf->SetX($margin);
	$pdf->Cell($w3[0],$ln,'Pejabat Penilai','',0,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,'Pegawai Negeri Sipil yang dinilai,','',1,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$ln = 4 ;
	$pdf->SetX($margin);
	$pdf->Cell($w3[0],$ln,trim(nama_peg($row['nib_atasan'])),'',0,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,trim(nama_peg($row['nip'])),'',1,'C');
	$pdf->SetX($margin);
	$pdf->Cell($w3[0],$ln,'NIP. '.reformat_nipbaru($row['nib_atasan']),'',0,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,'NIP. '.reformat_nipbaru($row['nip']),'',1,'C');
	
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>