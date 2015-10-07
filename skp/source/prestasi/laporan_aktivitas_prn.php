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
	$tgl1 = $_REQUEST['tgl1'];
	$tgl2 = $_REQUEST['tgl2'];

	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 4;
	$margin = 10;
	$tinggi = 275 ;
	$w = array(0,190);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'BUKU CATATAN HARIAN PELAKSANAAN TUGAS','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Tanggal '.reformat_tgl($tgl1).' s/d '.reformat_tgl($tgl2),'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(0,30,5,100);
	$pdf->SetFont($font,'B',$size);

	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);

//------------- data pegawai yang dinilai -------------------
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln,'PEJABAT YANG DINILAI','',1,'L');

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'NAMA PEGAWAI');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,trim(nama_peg($row['nip'])));
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'NIP');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,reformat_nipbaru($row['nip']));
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'PANGKAT/GOL.RUANG');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')');
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);	

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	// informasi tentang jabatan
	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'JABATAN');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,nm_jabatan_ij($row['kdjabatan']));
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'UNIT KERJA');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,trim(nm_unitkerja(substr($row['kdunitkerja'],0,4).'00')).' - RISTEK');  
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln,'','',1,'C');
// ------------------- data pejabat penilai --------------------------
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln,'PEJABAT PENILAI','',1,'L');

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'NAMA PEGAWAI');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,trim(nama_peg($row['nib_atasan'])));
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'NIP');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,reformat_nipbaru($row['nib_atasan']));
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'PANGKAT/GOL.RUANG');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,nm_pangkat(kdgol_peg($row['tahun'],$row['nib_atasan'])).' ('.nm_gol(kdgol_peg($row['tahun'],$row['nib_atasan'])).')');
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);	

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	// informasi tentang jabatan
	
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'JABATAN');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,jabatan_peg($row['tahun'],$row['nib_atasan']));
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrLabel	  = $pdf->SplitToArray($w1[1],$ln,'UNIT KERJA');
	$arrUraian	  = $pdf->SplitToArray($w1[3],$ln,'RISTEK');  
	$arrTitik	  = $pdf->SplitToArray($w1[2],$ln,':');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTitik[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln,'','',1,'C');

	$w2 = array(10,20,57,37,33,33);
	$pdf->SetFont($font,'B',$size-1);
	$pdf->SetX($margin);
	$pdf->Cell($w2[0],$ln*3,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w2[0]);
	$pdf->Cell($w2[1],$ln*3,'TANGGAL',$border,0,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y+2);
	$pdf->Cell($w2[2],$ln,'URAIAN',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y+6);
	$pdf->Cell($w2[2],$ln,'KEGIATAN/KEJADIAN',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln*3,'',$border,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y+2);
	$pdf->Cell($w2[3],$ln,'PENILAIAN',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y+6);
	$pdf->Cell($w2[3],$ln,'KEGIATAN/KEJADIAN',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y);
	$pdf->Cell($w2[3],$ln*3,'',$border,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y);
	$pdf->Cell($w2[4],$ln,'TANDA TANGAN',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y+4);
	$pdf->Cell($w2[4],$ln,'PEJABAT',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y+8);
	$pdf->Cell($w2[4],$ln,'YANG DINILAI',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y);
	$pdf->Cell($w2[4],$ln*3,'',$border,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y);
	$pdf->Cell($w2[5],$ln,'TANDA TANGAN',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y+4);
	$pdf->Cell($w2[5],$ln,'PEJABAT',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y+8);
	$pdf->Cell($w2[5],$ln,'PENILAI',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y);
	$pdf->Cell($w2[5],$ln*3,'',$border,1,'C');
	
	$pdf->SetFont($font,'',$size-1);
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and tgl >= '$tgl1' and tgl <= '$tgl2' ORDER BY tgl");
	
	$totalAK=0.0;
	$totalMenit=0;
	$no = 0 ;
	while($List = mysql_fetch_array($oList)) {
	$no += 1 ;
	$max = 0 ;
	$arrNo		  = $pdf->SplitToArray($w2[0],$ln,$no.'.');
	if ( $tanggal <> $List['tgl'] )    $arrTgl		  = $pdf->SplitToArray($w2[1],$ln,reformat_tgl($List['tgl']));
	else   $arrTgl		  = $pdf->SplitToArray($w2[1],$ln,'');
	$arrUraian	  = $pdf->SplitToArray($w2[2],$ln,trim($List['aktivitas']));
	$arrSetuju_P  = $pdf->SplitToArray($w2[4],$ln,nm_commit($List['commit']));
	$arrSetuju_A  = $pdf->SplitToArray($w2[5],$ln,nm_commit($List['approv']));

	if ($max<count($arrUraian)) $max=count($arrUraian);
	
	if ( $tanggal <> $List['tgl'] )   $pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$pdf->GetY());
	else    $pdf->Line($margin+$w2[0]+$w2[1], $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$pdf->GetY());
		
	$tanggal = $List['tgl'];
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrTgl[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell($w2[2],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
		$pdf->Cell($w2[3],$ln,'','LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]);
		$pdf->Cell($w2[4],$ln,$arrSetuju_P[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]);
		$pdf->Cell($w2[5],$ln,$arrSetuju_A[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
		$pdf->Cell($w2[6],$ln,'','LR',1,'R');
	}
//	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$pdf->GetY());
	}  
$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5],$pdf->GetY());
	
# AKHIR WHILE
	if ( $pdf->GetY() >= 240 ) 	$pdf->AddPage();
//------------------ Tanda Tangan	
	$w3 = array(50,80,50);
	$pdf->Ln();
	
	$tanggal = date("Y-m-d") ;
	$pdf->SetX($margin);
	$pdf->Cell($w3[0],$ln,'','',0,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,kota_unit(substr($row['kdunitkerja'],0,2)).', '.reformat_tanggal($tanggal),'',1,'C');

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

	function nm_commit($kode) {
		if ($kode == '1' ) 					$hasil = 'v';
		else    $hasil = '' ;
		return $hasil;
	}
	
	function nm_appov($kode) {
		if ($kode == '1' ) 					$hasil = 'v';
		if ($kode == '2' ) 					$hasil = 'x';
		else    $hasil = '' ;
		return $hasil;
	}
?>