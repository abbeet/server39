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
	$kdjab = $_REQUEST['kdjab'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 15;
	$tinggi = 275 ;
	$w = array(0,180);
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'FORMULIR BANTU SASARAN KERJA PEGAWAI','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'JABATAN '.strtoupper(trim(nm_jabatan_ij($kdjab))),'',1,'C');
	$pdf->Ln()*2;
	$w2 = array(10,50,20,30,20,20,30);
	$pdf->SetFont($font,'B',$size-1);
	$y = $pdf->GetY();
	$pdf->SetX($margin);
	$pdf->Cell($w2[0],$ln*2,'No.',$border,0,'C');
	$pdf->SetX($margin+$w2[0]);
	$pdf->Cell($w2[1],$ln*2,'Butir Kegiatan Pokok',$border,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln,'AK',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y+4);
	$pdf->Cell($w2[2],$ln,'Satuan',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1],$y);
	$pdf->Cell($w2[2],$ln*2,'',$border,0,'C');

	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
	$pdf->Cell($w2[3]+$w2[4],$ln,'Target Output',$border,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2],$y+5);
	$pdf->Cell($w2[3],$ln,'Batasan',$border,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3],$y+5);
	$pdf->Cell($w2[4],$ln,'Target',$border,0,'C');

	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y);
	$pdf->Cell($w2[5],$ln,'Prakiraan',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y+5);
	$pdf->Cell($w2[5],$ln,'AK',$noborder,0,'C');
	$pdf->SetXY($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4],$y);
	$pdf->Cell($w2[5],$ln*2,'',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
	$pdf->Cell($w2[6],$ln*2,'Indikator',$border,1,'C');
	
	$pdf->SetX($margin);
	$pdf->Cell($w2[0],$ln,'(1)',$border,0,'C');
	$pdf->SetX($margin+$w2[0]);
	$pdf->Cell($w2[1],$ln,'(2)',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]);
	$pdf->Cell($w2[2],$ln,'(3)',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
	$pdf->Cell($w2[3],$ln,'(4)',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]);
	$pdf->Cell($w2[4],$ln,'(5)',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]);
	$pdf->Cell($w2[5],$ln,'(6)=(3)x(5)',$border,0,'C');
	$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
	$pdf->Cell($w2[6],$ln,'(7)',$border,1,'C');

	$ln = 4 ;
	$sql = "SELECT kdkelompok FROM t_bantu WHERE kdjab = '$kdjab' GROUP BY kdkelompok ORDER BY kdkelompok";
	$qu = mysql_query($sql);
	while($Kelompok = mysql_fetch_array($qu))
	{
	$pdf->SetFont($font,'B',$size-1);
	$max = 0 ;
	$arrNo    	= $pdf->SplitToArray($w2[0],$ln,nmromawi($Kelompok['kdkelompok']) );
	$arrUraian   = $pdf->SplitToArray($w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$ln,trim(nm_kelompok_bantu($kdjab,$Kelompok['kdkelompok'])) );

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$ln,$arrUraian[$i],'LR',1,'L');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$pdf->GetY());
	
	$pdf->SetFont($font,'',$size-2);
	$sql_item = "SELECT * FROM t_bantu WHERE kdjab = '$kdjab' and kdkelompok = '$Kelompok[kdkelompok]' ORDER BY kditem";
	$qu_item = mysql_query($sql_item);
	while($Item = mysql_fetch_array($qu_item))
	{
	$max = 0 ;
	$arrNo    	= $pdf->SplitToArray($w2[0],$ln,$Item['kditem'] );
	$arrUraian   = $pdf->SplitToArray($w2[1],$ln,trim($Item['nmitem']) );
	$arrSatuanAK   = $pdf->SplitToArray($w2[2],$ln,trim($Item['angka_kredit']) );
	if ( $Item['mak_target'] == -1 ) $arrBatasan   = $pdf->SplitToArray($w2[3],$ln,$Item['min_target'].' - tidak ada batasan' );
	else $arrBatasan   = $pdf->SplitToArray($w2[3],$ln,$Item['min_target'].' - '.$Item['mak_target'] );
	$arrSatuan   = $pdf->SplitToArray($w2[6],$ln,trim($Item['satuan']) );

	if ($max<count($arrUraian)) $max=count($arrUraian);
	if ($max<count($arrBatasan)) $max=count($arrBatasan);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w2[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]);
		$pdf->Cell($w2[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w2[0]+$w2[1]);
		$pdf->Cell($w2[2],$ln,$arrSatuanAK[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]);
		$pdf->Cell($w2[3],$ln,$arrBatasan[$i],'LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]);
		$pdf->Cell($w2[4],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]);
		$pdf->Cell($w2[5],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]);
		$pdf->Cell($w2[6],$ln,$arrSatuan[$i],'LR',1,'C');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w2[0]+$w2[1]+$w2[2]+$w2[3]+$w2[4]+$w2[5]+$w2[6],$pdf->GetY());
	} # while item
	} # while kelompok
	
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>