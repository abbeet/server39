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
	$pdf->Cell($w[1],$ln,'INDIKATOR KINERJA UTAMA','',1,'C');
	
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
	$pdf->Cell($w1[1],$ln*2,'Sasaran Strategis Utama',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln*2,'Indikator Kinerja Utama',$border,1,'C');
	$pdf->SetFont($font,'',$size);
    
	$no = 0 ;
	$oList = mysql_query("select * from m_iku WHERE ta = '$th' and kdunitkerja = '480000' order by no_iku");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	
	if ( $kd_sasaran <> $row['no_sasaran'] )     $arrSasaran = $pdf->SplitToArray($w1[1],$ln,nm_sasaran($th,'480000',$row['no_sasaran']));
	if ( $kd_sasaran == $row['no_sasaran'] )     $arrSasaran = $pdf->SplitToArray($w1[1],$ln,'');

	if ( $row['sub_iku'] == '1' )
	{
	        $iku_sub  = '[IKU '.$row['no_iku'].'] '.$row['nm_iku']."\n" ;
			$oList_sub = mysql_query("select * from m_iku_sub WHERE ta = '$th' and kdunitkerja = '480000' and no_iku = '$row[no_iku]' order by no_iku_sub");
			while($row_sub = mysql_fetch_array($oList_sub))
			{
			$iku_sub       = $iku_sub.nmalfa($row_sub['no_iku_sub']).'. '.$row_sub['nm_iku_sub']."\n" ;
			}
			$arrIku       = $pdf->SplitToArray($w1[2],$ln,trim($iku_sub));
	}else{		
			$arrIku       = $pdf->SplitToArray($w1[2],$ln,'[IKU '.$row['no_iku'].'] '.trim($row['nm_iku']));
	}
	
	if ($max<count($arrSasaran)) $max=count($arrSasaran);
	if ($max<count($arrIku)) $max=count($arrIku);
	
	if ( $kd_sasaran <> $row['no_sasaran'] )     $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
	if ( $kd_sasaran == $row['no_sasaran'] )     $pdf->Line($margin+$w1[0]+$w1[1], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
	$kd_sasaran = $row['no_sasaran'] ;
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