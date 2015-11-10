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
	$kdunit = $_REQUEST['kdunit'];
	$renstra = th_renstra($th);
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 11;
	$ln = 5;
	$margin = 25;
	$tinggi = 275 ;
	$w = array(0,180);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'INDIKATOR KINERJA UTAMA','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,nm_unit($kdunit),'',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Periode Renstra '.$renstra,'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(50,110);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*2,'Sasaran Strategis',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln*2,'Indikator Kinerja Utama',$border,1,'C');
	$pdf->SetFont($font,'',$size);
    
	$no = 0 ;
	$oList = mysql_query("select * from m_ikk_kegiatan WHERE ta = '$renstra' and kdunitkerja = '$kdunit' order by kdunitkerja,kdgiat,no_ikk");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	if ( $kdsasaran <> $row['no_sasaran'] )   $arrSasaran		= $pdf->SplitToArray($w1[0],$ln,nm_sasaran($renstra,$row['kdunitkerja'],$row['no_sasaran']));
	if ( $kdsasaran == $row['no_sasaran'] )   $arrSasaran		= $pdf->SplitToArray($w1[0],$ln,'');

	$arrIndikator   = $pdf->SplitToArray($w1[1],$ln,'[IKU '.$row['nm_ikk'].']'.trim($row['nm_ikk']));
	
	if ($max<count($arrSasaran)) $max=count($arrSasaran);
	if ($max<count($arrIndikator)) $max=count($arrIndikator);

	if ( $kdsasaran <> $row['no_sasaran'] )    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1],$pdf->GetY());
	if ( $kdsasaran == $row['no_sasaran'] )    $pdf->Line($margin+$w1[0], $pdf->GetY(), $margin+$w1[0]+$w1[1],$pdf->GetY());
    $kdsasaran = $row['no_sasaran'] ;

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrSasaran[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrIndikator[$i],'LR',1,'L');
	}
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1],$pdf->GetY());
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>