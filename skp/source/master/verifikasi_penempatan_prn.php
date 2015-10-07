<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
	$kdunit = $_REQUEST['kdunit'];
	$th = $_REQUEST['th'];
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 8;
	$tinggi = 275 ;
	$w = array(0,180);
	if ( substr(date('m'),0,1) == '0' )  $bulan = substr(date('m'),1,1);
	else $bulan = date('m');
	$this->Ln();
	$this->SetFont($font,'B',$size+2);
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,'DAFTAR PEMEGANG JABATAN','',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit.'00'))),'',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,'Bulan : '.nama_bulan($bulan).' '.$th,'',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln*5,'','',1,'C');
	$this->SetY(20);
	$this->SetFont($font,'',$size-3);
	$this->Cell(0, 10, 'Hal. ' . $this->PageNo(),0,1,'R');
	$w1 = array(10,50,55,10,60,12);
	$this->SetFont($font,'B',$size);
	$this->SetX($margin);
	$this->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
	$this->SetX($margin+$w1[0]);
	$this->Cell($w1[1],$ln,'Bidang/Bagian',$noborder,0,'C');
	$y = $this->GetY();
	$this->SetXY($margin+$w1[0],$y+4);
	$this->Cell($w1[1],$ln,'SubBidang/SubBagian',$noborder,0,'C');
	$this->SetXY($margin+$w1[0],$y);
	$this->Cell($w1[1],$ln*2,'',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]);
	$this->Cell($w1[2],$ln*2,'Nama Pegawai',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$this->Cell($w1[3],$ln*2,'Gol.',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$this->Cell($w1[4],$ln*2,'Nama Jabatan',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
	$this->Cell($w1[5],$ln*2,'Grade',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	$th = $_REQUEST['th'];
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 8;
	$tinggi = 275 ;
	$w = array(0,180);
	$pdf->SetFont($font,'',$size);
	$w1 = array(10,50,55,10,60,12);    
	$no = 0 ;
	$sql = "SELECT * FROM mst_skp WHERE left(kdunitkerja,2) = '$kdunit' and tahun = '$th' ORDER BY kdunitkerja,kdjabatan,kdgol";
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	if ( $row['kdunitkerja'] <> $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,trim(nm_unitkerja($row['kdunitkerja'])));
	if ( $row['kdunitkerja'] == $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,'');
	$arrJabatan   = $pdf->SplitToArray($w1[4],$ln,nm_info_jabatan($row['kdunitkerja'],$row['kdjabatan']));
	$arrNama	  = $pdf->SplitToArray($w1[2],$ln,nama_peg($row['nib'])."\n".'NIP. '.reformat_nipbaru(nip_peg($row['nib'])));
	$arrGol	      = $pdf->SplitToArray($w1[3],$ln,nm_gol($row['kdgol']));
	$arrGrade	  = $pdf->SplitToArray($w1[5],$ln,nil_grade($row['kdjabatan']));

	if ($max<count($arrUnit)) $max=count($arrUnit);
	if ($max<count($arrJabatan)) $max=count($arrJabatan);
	if ($max<count($arrNama)) $max=count($arrNama);

	if ( $row['kdunitkerja'] <> $kdunitkerja )   $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
	if ( $row['kdunitkerja'] == $kdunitkerja )   $pdf->Line($margin+$w1[0]+$w1[1], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
	$kdunitkerja = $row['kdunitkerja'];
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrUnit[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrNama[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrGol[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrJabatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrGrade[$i],'LR',1,'C');
	}
//	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
	
	    if($pdf->GetY() >= 270 )
		{
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
		$pdf->AddPage();	
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
	    }
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
	$pdf->SetFont($font,'',$size-3);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Dicetak tgl. '.date ('d-m-Y H:i:s'),'',1,'L');
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>