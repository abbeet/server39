<?php
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");

	class PDF extends FPDF {
		function Header() {
	$kdunit = '420000';
	$border = 1;
	$borderless = 0;
	$marginL = 13;
	$marginT = 25;
	$marginR = 200;
	$marginB = 287;
	$font = "Arial";
	$fsize1 = 9; $h = $fsize1/2;
	$fsize2 = 10; $hh = $fsize2/2;
	$fsize3 = 12; $hhh = $fsize3/2;
	$w = array(75,100,75);
	$th = date('Y');
	$renstra = th_renstra($th);
	
	$this->SetFont($font,'B',$fsize3);
	$this->SetX($marginL+$w[0]);
	$this->Cell($w[1],$hhh,'INDIKATOR KINERJA UTAMA '.$renstra,$borderless,1,'C');
	$this->SetX($marginL+$w[0]);
	$this->Cell($w[1],$hhh,trim(nm_unit($kdunit)),$borderless,1,'C');	
	$this->Ln();
		}
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = '420000';
	$border = 1;
	$borderless = 0;
	$marginL = 25;
	$marginT = 30;
	$marginR = 200;
	$marginB = 287;
	$font = "Arial";
	$fsize1 = 9; $h = $fsize1/2;
	$fsize2 = 10; $hh = $fsize2/2;
	$fsize3 = 12; $hhh = $fsize3/2;
	$w = array(10,120,120);
	
	$pdf->SetFont($font,'B',$fsize2);
	$pdf->SetX($marginL);
	$pdf->Cell($w[0],$hh*2,'No.',$border,0,'C');
	$pdf->SetX($marginL+$w[0]);
	$pdf->Cell($w[1],$hh*2,'Uraian',$border,0,'C');
	$pdf->SetX($marginL+$w[0]+$w[1]);
	$pdf->Cell($w[2],$hh*2,'Alasan',$border,1,'C');
	$pdf->SetFont($font,'',$fsize2);

	if($kdunit=='420000'){
		$oList = mysql_query("select iku,alasan from m_iku_program order by concat(kdprogram,kddeputi,kdiku)");
	}else{
		$oList_subprogram = mysql_query("select kdsubprogram from tb_subprogram where kddeputi='$kdunit'");
		$List_subprogram = mysql_fetch_array($oList_subprogram);
		$oList = mysql_query("select ikk,alasan from m_ikk_subprogram where kdsubprogram='$List_subprogram[kdsubprogram]' order by kdikk");
	}

	while($List = mysql_fetch_array($oList)) {
	
	$max=0;	
	$no += 1 ;
	$arrNomor 	= $pdf->SplitToArray($w[0],$hhh,$no.'.');
	if($kdunit=='420000')	$arrUraian  = $pdf->SplitToArray($w[1],$hhh,trim($List['iku']));
	if($kdunit<>'420000')	$arrUraian  = $pdf->SplitToArray($w[1],$hhh,trim($List['ikk']));

	$arrAlasan  = $pdf->SplitToArray($w[2],$hhh,trim($List['alasan']));
	if ($max<count($arrUraian)) $max=count($arrUraian);
	if ($max<count($arrAlasan)) $max=count($arrAlasan);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($marginL);
		$pdf->Cell($w[0],$hhh,$arrNomor[$i],'LR',0,'C');
		$pdf->SetX($marginL+$w[0]);
		$pdf->Cell($w[1],$hhh,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($marginL+$w[0]+$w[1]);
		$pdf->Cell($w[2],$hhh,$arrAlasan[$i],'LR',1,'L');
	}
	
	$pdf->Line($marginL, $pdf->GetY(), $marginL+$w[0]+$w[1]+$w[2],$pdf->GetY());

	}		# akhir while
	$pdf->SetFont($font,'B',$fsize2);
	$w = array(12,3,235);
	$pdf->Ln();
	$pdf->SetX($marginL);
	$pdf->Cell($w[0]+$w[1]+$w[2],$hh,'Tugas dan Fungsi Kementerian Riset dan Teknologi',$noborder,1,'L');
	$pdf->SetX($marginL);
	$pdf->Cell($w[0],$hh,'Tugas',$noborder,0,'L');
	$pdf->SetX($marginL+$w[0]);
	$pdf->Cell($w[1],$hh,':',$noborder,0,'C');
	$pdf->SetFont($font,'',$fsize2);
	$pdf->SetX($marginL+$w[0]+$w[1]);
	$pdf->MultiCell($w[2],$hh,tugas_unit($kdunit),$noborder,1,'L');
	$pdf->Ln();

	$pdf->SetFont($font,'B',$fsize2);
	$pdf->SetX($marginL);
	$pdf->Cell($w[0],$hh,'Fungsi',$noborder,0,'L');
	$pdf->SetX($marginL+$w[0]);
	$pdf->Cell($w[1],$hh,':',$noborder,1,'L');
	$pdf->SetFont($font,'',$fsize2);
	$wf = array(5,245);

	$oList = mysql_query("select * from tb_unitkerja_fungsi where kdunit='$kdunit' order by kdfungsi ");
	while($List = mysql_fetch_array($oList)) {
	
	$max=0;	
	$arrNomor 	= $pdf->SplitToArray($wf[0],$hh,trim($List['kdfungsi']).'.');
	$arrFungsi  = $pdf->SplitToArray($wf[1],$hh,trim($List['nmfungsi']));
	if ($max<count($arrFungsi)) $max=count($arrFungsi);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($marginL);
		$pdf->Cell($wf[0],$hh,$arrNomor[$i],'',0,'L');
		$pdf->SetX($marginL+$wf[0]);
		$pdf->Cell($wf[1],$hh,$arrFungsi[$i],'',1,'L');
	}
	
	}	# akhir while
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>