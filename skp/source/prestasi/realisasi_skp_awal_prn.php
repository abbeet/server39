<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();
	$id_skp = $_REQUEST['id_skp'];
	$status = $_POST['kode'];
	$sw = $_REQUEST['sw'];
	if ($status == 1 )
	{
	$tgl = date ('Y-m-d') ;
	if ( $sw == '' ) {
		mysql_query("UPDATE mst_skp SET is_approved_awal = '1', tgl_approved_awal = '$tgl' WHERE id = '$id_skp'");
	}else{
		mysql_query("UPDATE mst_skp SET is_approved_akhir = '1', tgl_approved_akhir = '$tgl' WHERE id = '$id_skp'");
	}
	}
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 15;
	$tinggi = 275 ;
	$w = array(0,180);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'KEMAJUAN SASARAN KERJA','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'PEGAWAI NEGERI SIPIL','',1,'C');
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);

	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Jangka waktu penilaian : '.reformat_tanggal($row['tgl_kemajuan_awal']).' s/d '.reformat_tanggal($row['tgl_kemajuan_akhir']),'',1,'C');
	$pdf->Ln()*2;
	
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'A. DATA UMUM','',1,'L');

	$w1 = array(10,30,45,15,30,50);
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
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,trim(nm_jabatan_ij($row['kdjabatan'])));

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
	$arrField_1	  = $pdf->SplitToArray($w1[2],$ln,trim(nm_unitkerja(substr(kdunitkerja_peg($row['tahun'],$row['nib_atasan']),0,4).'00')).' - RISTEK');
	$arrNo_2	  = $pdf->SplitToArray($w1[3],$ln,'5');
	$arrLabel_2	  = $pdf->SplitToArray($w1[4],$ln,'Unit Kerja');
	$arrField_2	  = $pdf->SplitToArray($w1[5],$ln,trim(nm_unitkerja(substr($row['kdunitkerja'],0,4).'00')).' - RISTEK');

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
	$pdf->Ln()*2;
	
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'B. TARGET DAN REALISASI','',1,'L');

	$w2 = array(5,41,13,13,13,13,15);
	$pdf->SetFont($font,'B',$size-3);
	$pdf->SetX($margin);
	$pdf->Cell($w2[0],$ln*3,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w2[0]);
	$pdf->Cell($w2[1],$ln*3,'III. TUGAS JABATAN',$border,0,'L');
	$pdf->SetFont($font,'B',$size-4);
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln*2,'ANGKA',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y+6);
	$pdf->Cell($w2[2],$ln,'KREDIT',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln*3,'',$border,0,'C');
	$pdf->SetFont($font,'B',$size-3);
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
	$pdf->Cell($w2[3]+$w2[4]+$w2[5]+$w2[6],$ln,'TARGET',$border,0,'C');
	$pdf->SetFont($font,'B',$size-4);
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$y);
	$pdf->Cell($w2[2],$ln*2,'ANGKA',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$y+6);
	$pdf->Cell($w2[2],$ln,'KREDIT',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$y);
	$pdf->Cell($w2[2],$ln*3,'',$border,0,'C');
	$pdf->SetFont($font,'B',$size-3);
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]+$w2[4]+$w2[5]+$w2[6]);
	$pdf->Cell($w2[3]+$w2[4]+$w2[5]+$w2[6],$ln,'REALISASI',$border,1,'C');
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
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
	$pdf->Cell($w2[6],$ln*2,'Biaya',$border,0,'C');
	
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]+$w2[4]+$w2[5]+$w2[6],$y);
	$pdf->Cell($w2[3],$ln,'Kuantitas',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]+$w2[4]+$w2[5]+$w2[6],$y+4);
	$pdf->Cell($w2[3],$ln,'/Output',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]+$w2[4]+$w2[5]+$w2[6],$y);
	$pdf->Cell($w2[3],$ln*2,'',$border,0,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]+$w2[5]+$w2[6],$y);
	$pdf->Cell($w2[4],$ln,'Kualitas',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]+$w2[5]+$w2[6],$y+4);
	$pdf->Cell($w2[4],$ln,'/Mutu',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]+$w2[5]+$w2[6],$y);
	$pdf->Cell($w2[4],$ln*2,'',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]+$w2[6]);
	$pdf->Cell($w2[5],$ln*2,'Waktu',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]);
	$pdf->Cell($w2[6],$ln*2,'Biaya',$border,1,'C');

	$pdf->SetFont($font,'',$size-3);
	$oList = mysql_query("SELECT * FROM dtl_skp WHERE id_skp = '$id_skp' ORDER BY no_tugas");
	while($List = mysql_fetch_array($oList)) {

	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,$List['no_tugas'].'.');
	$arrUraian	  = $pdf->SplitToArray($w2[1],$ln,trim($List['nama_tugas']));
	$arrAk_kredit = $pdf->SplitToArray($w2[2],$ln,number_format($List['ak_target'],"4",",","."));
	$arrOutput	  = $pdf->SplitToArray($w2[3],$ln,$List['jumlah_target'].' '.trim($List['satuan_jumlah']));
	$arrMutu	  = $pdf->SplitToArray($w2[4],$ln,$List['kualitas_target'].' %');
	$arrWaktu	  = $pdf->SplitToArray($w2[5],$ln,$List['waktu_target'].' '.trim($List['satuan_waktu']));
	$arrBiaya	  = $pdf->SplitToArray($w2[6],$ln,number_format($List['biaya_target'],"0",",","."));
	$arrAk_kredit_r  = $pdf->SplitToArray($w2[2],$ln,number_format($List['ak_real_awal'],"4",",","."));
	$arrOutput_r	 = $pdf->SplitToArray($w2[3],$ln,$List['jumlah_real_awal'].' '.trim($List['satuan_jumlah']));
	$arrMutu_r	 	 = $pdf->SplitToArray($w2[4],$ln,$List['kualitas_real_awal'].' %');
	$arrWaktu_r	 	 = $pdf->SplitToArray($w2[5],$ln,$List['waktu_real_awal'].' '.trim($List['satuan_waktu']));
	$arrBiaya_r	  	 = $pdf->SplitToArray($w2[6],$ln,number_format($List['biaya_real_awal'],"0",",","."));

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
		$pdf->Cell($w2[5],$ln,$arrWaktu[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
		$pdf->Cell($w2[6],$ln,$arrBiaya[$i],'LR',0,'R');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6]);
		$pdf->Cell($w2[2],$ln,$arrAk_kredit_r[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]+$w2[4]+$w2[5]+$w2[6]);
		$pdf->Cell($w2[3],$ln,$arrOutput_r[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]+$w2[5]+$w2[6]);
		$pdf->Cell($w2[4],$ln,$arrMutu_r[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]+$w2[6]);
		$pdf->Cell($w2[5],$ln,$arrWaktu_r[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]);
		$pdf->Cell($w2[6],$ln,$arrBiaya_r[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$pdf->GetY());
	}  # AKHIR WHILE
	
	$pdf->SetFont($font,'B',$size-3);
	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,'IV');
	$arrUraian	  = $pdf->SplitToArray($w2[1],$ln,'TUGAS TAMBAHAN');

	if ($max<count($arrUraian)) $max=count($arrUraian);
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell(+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$ln,'','LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$pdf->GetY());
	
	$pdf->SetFont($font,'',$size-3);
	$oList = mysql_query("SELECT * FROM dtl_skp_tugas_tambahan WHERE id_skp = '$id_skp' ORDER BY no_tugas");
	while($List = mysql_fetch_array($oList)) {

	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,$List['no_tugas'].'.');
	$arrUraian	  = $pdf->SplitToArray($w2[1],$ln,trim($List['nama_tugas']));

	if ($max<count($arrUraian)) $max=count($arrUraian);
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell(+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$ln,'','LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$pdf->GetY());
	}  # AKHIR WHILE

	$pdf->SetFont($font,'B',$size-3);
	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,'V');
	$arrUraian	  = $pdf->SplitToArray($w2[1],$ln,'KREATIVITAS');

	if ($max<count($arrUraian)) $max=count($arrUraian);
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell(+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$ln,'','LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$pdf->GetY());
	
	$pdf->SetFont($font,'',$size-3);
	$oList = mysql_query("SELECT * FROM dtl_skp_kreativitas WHERE id_skp = '$id_skp' ORDER BY no_kreativitas");
	while($List = mysql_fetch_array($oList)) {

	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,$List['no_kreativitas'].'.');
	$arrUraian	  = $pdf->SplitToArray($w2[1],$ln,trim($List['nama_kreativitas']));

	if ($max<count($arrUraian)) $max=count($arrUraian);
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell(+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$ln,'','LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]*2+$w2[3]*2+$w2[4]*2+$w2[5]*2+$w2[6]*2,$pdf->GetY());
	}  # AKHIR WHILE

# AKHIR WHILE
	if ( $pdf->GetY() >= 240 ) 	$pdf->AddPage();
//------------------ Tanda Tangan	
	$w3 = array(50,80,50);
	$pdf->Ln();
	
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,'Pegawai Negeri Sipil yang dinilai,','',1,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$ln = 4 ;
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,trim(nama_peg($row['nip'])),'',1,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,'NIP. '.reformat_nipbaru($row['nip']),'',1,'C');

	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>