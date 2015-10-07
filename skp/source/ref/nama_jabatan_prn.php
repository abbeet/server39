<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
	function Header() {
	
	$kdunit = $_REQUEST['kdunit'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 10;
	$tinggi = 275 ;
	$w = array(0,180);
//	$this->Ln()+3;
	$this->SetFont($font,'B',$size+2);
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,'DAFTAR NAMA JABATAN '.$sw,'',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit))),'',1,'C');
	$this->Ln()*2;
	$this->SetY(18);
	$this->SetFont($font,'',$size-3);
	$this->Cell(0, 10, 'Hal. ' . $this->PageNo(),0,1,'R');
	$w1 = array(20,60,65,15,25);
	$this->SetFont($font,'B',$size);
	$this->SetX($margin);
	$this->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
	$this->SetX($margin+$w1[0]);
	$this->Cell($w1[1],$ln*2,'Unit Kerja',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]);
	$this->Cell($w1[2],$ln*2,'Nama Jabatan',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$this->Cell($w1[3],$ln*2,'Grade',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$this->Cell($w1[4],$ln*2,'Kode',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 10;
	$tinggi = 275 ;
	$w = array(0,180);

	$w1 = array(20,60,65,15,25);
	$pdf->SetFont($font,'',$size);
	$no = 0 ;
	
		$xkdunit = substr($kdunit,0,5) ;
		$sql = "SELECT * FROM kd_jabatan WHERE kdunitkerja LIKE '$xkdunit%' ORDER BY kdunitkerja,klsjabatan desc,kode";
	
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	if ( $row['kdunitkerja'] <> $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,trim(nm_unitkerja($row['kdunitkerja'])));
	if ( $row['kdunitkerja'] == $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,'');
	$arrJabatan   = $pdf->SplitToArray($w1[2],$ln,$row['nmjabatan']);
	$arrKode	  = $pdf->SplitToArray($w1[4],$ln,substr($row['kode'],0,3).'.'.substr($row['kode'],3,5));
	$arrGrade	  = $pdf->SplitToArray($w1[3],$ln,$row['klsjabatan']);

	if ($max<count($arrUnit)) $max=count($arrUnit);
	if ($max<count($arrJabatan)) $max=count($arrJabatan);

	if ( $row['kdunitkerja'] <> $kdunitkerja )   $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$pdf->GetY());
	if ( $row['kdunitkerja'] == $kdunitkerja )   $pdf->Line($margin+$w1[0]+$w1[1], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$pdf->GetY());
	$kdunitkerja = $row['kdunitkerja'];
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrUnit[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrJabatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrGrade[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrKode[$i],'LR',1,'C');
	}
	
	    if($pdf->GetY() >= 270 )
		{
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$pdf->GetY());
		$pdf->AddPage();	
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$pdf->GetY());
	    }
	}
	
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$pdf->GetY());
	$pdf->SetFont($font,'',$size-3);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Dicetak tgl. '.date ('d-m-Y H:i:s'),'',1,'L');
	$pdf->SetDisplayMode('real');
	$pdf->Output('nama_jabatan.pdf','I');

?>