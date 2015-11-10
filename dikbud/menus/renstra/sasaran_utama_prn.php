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
	$th = $_REQUEST['th'];
	$renstra = th_renstra($th);
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 11;
	$ln = 7;
	$margin = 25;
	$tinggi = 275 ;
	$w = array(5,150);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'SASARAN STRATEGIS UTAMA','',1,'C');
	
	$max = 0 ;
	$arrUnit   = $pdf->SplitToArray($w[1],$ln,trim(strtoupper(nm_unit('480000'))));
	if ($max<count($arrUnit)) $max=count($arrUnit);
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUnit[$i],'',1,'C');
	}
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Periode Renstra '.$renstra,'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(20,140);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln*2,'Sasaran Strategis Utama',$border,1,'C');
	$pdf->SetFont($font,'',$size);
    
	$no = 0 ;
	$oList = mysql_query("select * from m_sasaran WHERE ta = '$th' and kdunitkerja = '480000' order by no_sasaran");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,trim($row['no_sasaran']).'.');
	$arrSasaran   = $pdf->SplitToArray($w1[1],$ln,trim($row['nm_sasaran']));

	if ($max<count($arrSasaran)) $max=count($arrSasaran);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrSasaran[$i],'LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1],$pdf->GetY());
	}

	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>