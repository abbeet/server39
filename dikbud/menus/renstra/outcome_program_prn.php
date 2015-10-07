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
	$size = 10;
	$ln = 5;
	$margin = 25;
	$tinggi = 275 ;
	$w = array(5,150);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'OUTCOME UTAMA','',1,'C');
	
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
	
	$w1 = array(0,65,95);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln*2,'Program',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln*2,'Outcome',$border,1,'C');
	$pdf->SetFont($font,'',$size);
    
	$no = 0 ;
	$oList = mysql_query("select * from m_program_outcome WHERE ta = '$th' order by concat(kdprogram,kdoutcome)");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	
	if ( $kdprogram <> $row['kdprogram'] )     $arrSasaran = $pdf->SplitToArray($w1[1],$ln,nm_program($th,'04801'.$row['kdprogram']));
	if ( $kdprogram == $row['kdprogram'] )     $arrSasaran = $pdf->SplitToArray($w1[1],$ln,'');
	$arrIku = $pdf->SplitToArray($w1[2],$ln,$row['nmoutcome']);	
	if ($max<count($arrSasaran)) $max=count($arrSasaran);
	if ($max<count($arrIku)) $max=count($arrIku);
	
	if ( $kdprogram <> $row['kdprogram'] )     $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
	if ( $kdprogram == $row['kdprogram'] )     $pdf->Line($margin+$w1[0]+$w1[1], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
	$kdprogram = $row['kdprogram'] ;
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrSasaran[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrIku[$i],'LR',1,'L');
	}
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>