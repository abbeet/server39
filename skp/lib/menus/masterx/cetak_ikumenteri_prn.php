<?php
	include ("lib/fpdf/fpdf.php");
	
	class PDF extends FPDF {
		function Header() {
	$border = 1;
	$borderless = 0;
	$marginL = 13;
	$marginT = 10;
	$marginR = 200;
	$marginB = 287;
	$font = "Arial";
	$fsize1 = 9; $h = $fsize1/2;
	$fsize2 = 10; $hh = $fsize2/2;
	$fsize3 = 12; $hhh = $fsize3/2;
	$w = array(50,100,50);
	
	$this->SetFont($font,'B',$fsize3);
	$this->SetX($marginL+$w[0]);
	$this->Cell($w[1],$hhh,'INDIKATOR KINERJA UTAMA 2010-2014',$borderless,1,'C');
	$this->Cell($w[1],$hhh,'KEMENTERIAN RISET DAN TEKNOLOGI',$borderless,1,'C');
		}
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$border = 1;
	$borderless = 0;
	$marginL = 13;
	$marginT = 10;
	$marginR = 200;
	$marginB = 287;
	$font = "Arial";
	$fsize1 = 9; $h = $fsize1/2;
	$fsize2 = 10; $hh = $fsize2/2;
	$fsize3 = 12; $hhh = $fsize3/2;
	$w = array(50,100,50);
	
	$pdf->SetFont($font,'B',$fsize3);
	$pdf->SetX($marginL+$w[0]);
	$pdf->Cell($w[1],$hhh,'INDIKATOR KINERJA UTAMA 2010-2014',$borderless,1,'C');
	$pdf->Cell($w[1],$hhh,'KEMENTERIAN RISET DAN TEKNOLOGI',$borderless,1,'C');
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>