<?php
	include ("../../lib/fpdf/fpdf.php");
	include ("../../include/dbh.php");
	include ("../../include/functions.php");
	include ("../../include/query.php");

class PDF extends FPDF {
	function Header() {
	$border = 1;
	$borderless = 0;
	$marginL = 12;
	$marginT = 10;
	$marginR = 200;
	$marginB = 287;
	$font = "Arial";
	$fsize1 = 9; $h = $fsize1/2;
	$fsize2 = 10; $hh = $fsize2/2;
	$fsize3 = 12; $hhh = $fsize3/2;
	$this->SetLeftMargin($marginL);

	$w = array(50,100,50);
	
	$this->SetFont($font,'B',$fsize3);
	$this->SetX($marginL+$w[0]);
	$this->Cell($w[1],$hh,'INDIKATOR KINERJA UTAMA 2010-2014',$borderless,1,'c');
	$this->Cell($w[1],$hh,'KEMENTERIAN RISET DAN TEKNOLOGI',$borderless,1,'L');
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
	$status = $_REQUEST[status];
	$font = "Arial";
	$fsize1 = 9; $h = $fsize1/2;
	$fsize2 = 10; $hh = $fsize2/2;
	$fsize3 = 12; $hhh = $fsize3/2;
	$pdf->SetLeftMargin($marginL);
	
	$pdf->Output();

?>