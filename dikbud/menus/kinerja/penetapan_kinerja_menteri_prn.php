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
	$margin = 20;
	$tinggi = 275 ;
	$w = array(0,180);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'FORMULIR PENETAPAN KINERJA','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,trim(strtoupper(nm_unit('820000'))),'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(70,70,30);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*2,'Sasaran Strategis Utama',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln*2,'Indikator Kinerja Utama',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln*2,'Target',$border,1,'C');
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln,'(1)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln,'(2)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln,'(3)',$border,1,'C');
	$pdf->SetFont($font,'',$size);
    $renstra = th_renstra($th);
	$no = 0 ;
	$oList = mysql_query("select * from th_pk WHERE th = '$th' and kdunitkerja = '820000' order by no_pk");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	if ( $kdsasaran <> $row['no_sasaran'] )   $arrSasaran		= $pdf->SplitToArray($w1[0],$ln,nm_sasaran($renstra,$row['kdunitkerja'],$row['no_sasaran']));
	if ( $kdsasaran == $row['no_sasaran'] )   $arrSasaran		= $pdf->SplitToArray($w1[0],$ln,'');

	if ( $row['sub_pk'] == '1' )
	{
	        $iku_sub  = trim($row['nm_pk'])."\n" ;
			$oList_sub = mysql_query("select * from th_pk_sub WHERE th = '$th' and kdunitkerja = '820000' and no_pk = '$row[no_pk]' order by no_pk_sub");
			while($row_sub = mysql_fetch_array($oList_sub))
			{
			$iku_sub          = $iku_sub.nmalfa($row_sub['no_pk_sub']).'. '.$row_sub['nm_pk_sub']."\n" ;
			}
			$arrIndikator     = $pdf->SplitToArray($w1[1],$ln,trim($iku_sub));
	}else{		
			$arrIndikator    = $pdf->SplitToArray($w1[1],$ln,trim($row['nm_pk']));
	}

//	$arrIndikator   = $pdf->SplitToArray($w1[1],$ln,trim($row['nm_pk']));
	$arrTarget   	= $pdf->SplitToArray($w1[2],$ln,trim($row['target']));
	
	if ($max<count($arrSasaran)) $max=count($arrSasaran);
	if ($max<count($arrIndikator)) $max=count($arrIndikator);

	if ( $kdsasaran <> $row['no_sasaran'] )    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
	if ( $kdsasaran == $row['no_sasaran'] )    $pdf->Line($margin+$w1[0], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
    $kdsasaran = $row['no_sasaran'] ;

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrSasaran[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrIndikator[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTarget[$i],'LR',1,'C');
	}
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2],$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*2,'','',1,'L');
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln,'Jumlah Pagu Anggaran '. $th .' :  Rp. '.number_format(pagudipa_lapan($th,'820000'),"0",",",".").',-','',1,'L');
	
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>