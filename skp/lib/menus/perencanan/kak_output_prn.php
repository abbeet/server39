<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");

	class PDF extends FPDF {
		function Header() {
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 7;
			$lnmin = $ln - 3;
			$margin = 15;
			$w = array(35,115,35);
			$x = array(0,115);
			$this->SetFont($font,'B',$size+6);
/*
			$posX = $this->GetX();
			$posY = $this->GetY();
			$this->SetX(15);
			$this->SetLineWidth(0.3);
			$this->Cell(185, 220, '',$border);
			$this->SetLineWidth(0.2);
			$posX = $this->SetXY($posX,$posY);
*/
		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();
	
	$k = $_REQUEST['k'];
	$o  = $_REQUEST['o'];
	$q  = $_REQUEST['q'];
	$oKegiatan_bp = mysql_query("SELECT * FROM thbp_kak_kegiatan WHERE id = '$k' ");
	$Kegiatan_bp = mysql_fetch_array($oKegiatan_bp);
	
	$oOutput_bp = mysql_query("SELECT * FROM thbp_kak_output WHERE id = '$o' ");
	$Output_bp = mysql_fetch_array($oOutput_bp);

	$oOutput_uk = mysql_query("SELECT * FROM thuk_kak_output WHERE id = '$q' ");
	$Output_uk = mysql_fetch_array($oOutput_uk);

	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 7;
	$margin = 15;
	$tinggi = 275 ;
	
//------------------------------ cetak cover	
	$w = array(30,1,120,1);
	$pdf->SetFont($font,'B',$size+10);
	$y = $pdf->GetY()+25 ;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'PROPOSAL KEGIATAN','',1,'C');
	$pdf->SetXY($margin+$w[0],$y+10);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'TAHUN '.$Kegiatan_bp['th'],'',1,'C');
	$y = $pdf->GetY()+20 ;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'','',1,'C');

	$pdf->Line($margin+$w[0], $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln-2,'','LR',1,'L');
	$pdf->SetFont($font,'B',$size+5);

	$max = 0 ;
	$arrNmGiat  = $pdf->SplitToArray($w[2],$ln,trim(nm_giat($Kegiatan_bp['kdgiat'])));
	if ($max<count($arrNmGiat)) $max=count($arrNmGiat);

	for($i=0;$i<$max;$i++)
	{
	$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'','L',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrNmGiat[$i],'',0,'C');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,'','R',1,'L');
	}
	
	$max = 0 ;
	$arrNmOutput  = $pdf->SplitToArray($w[2],$ln,'Output : '.trim(nm_output($Output_bp['kdgiat'].$Output_bp['kdoutput'])));
	if ($max<count($arrNmOutput)) $max=count($arrNmOutput);

	for($i=0;$i<$max;$i++)
	{
	$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'','L',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrNmOutput[$i],'',0,'C');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,'','R',1,'L');
	}

	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln-2,'','LR',1,'L');
	$pdf->Line($margin+$w[0], $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());

	$pdf->SetFont($font,'B',$size+3);
	$y = $pdf->GetY()+40 ;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'PROGRAM :','',1,'C');

	$max = 0 ;
	$arrNmProgram  = $pdf->SplitToArray($w[2],$ln,strtoupper(trim(nm_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram']))));
	if ($max<count($arrNmProgram)) $max=count($arrNmProgram);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrNmProgram[$i],'',1,'C');
	}

	$y = $pdf->GetY()+5 ;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'UNIT KERJA :','',1,'C');

	$max = 0 ;
	$arrNmDeputi  = $pdf->SplitToArray($w[2],$ln,trim(nm_unit(substr($Kegiatan_bp['kdunitkerja'],0,3).'000')));
	if ($max<count($arrNmDeputi)) $max=count($arrNmDeputi);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrNmDeputi[$i],'',1,'C');
	}
	
	$max = 0 ;
	$arrNmUnit  = $pdf->SplitToArray($w[2],$ln,trim(nm_unit($Kegiatan_bp['kdunitkerja'])));
	if ($max<count($arrNmUnit)) $max=count($arrNmUnit);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrNmUnit[$i],'',1,'C');
	}
	
	$y = $pdf->GetY()+30 ;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'KEMENTERIAN RISET DAN TEKNOLOGI','',1,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'Tahun '.( $Kegiatan_bp['th'] -1 ),'',1,'C');
//-------------------------------------------------------  akhir cover
	$pdf->AddPage();
	$margin = 10;
	$ln = 5 ;
	$w = array(0,50,3,140);
	$pdf->SetFont($font,'B',$size+3);
	$y = $pdf->GetY()+10;
	$pdf->Ln();
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3],$ln,'KERANGKA ACUAN KERJA','',1,'C');
	$y = $pdf->GetY();
	$pdf->Ln();

	$pdf->SetFont($font,'',$size+1);
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'KEMENTERIAN/LEMBAGA');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(nm_unit(substr($Kegiatan_bp['kdunitkerja'],0,2).'0000')));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'UNIT KERJA');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(nm_unit($Kegiatan_bp['kdunitkerja'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'PROGRAM');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(nm_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'OUTCOME');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(outcome_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'KEGIATAN');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(nm_giat($Kegiatan_bp['kdgiat'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'OUTPUT');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(nm_output($Output_bp['kdgiat'].$Output_bp['kdoutput'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'KOORDINATOR');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim($Output_bp['id_pjawab']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
	$wi = array(0,6,6,170);
	
	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'1.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2]+$wi[3],$ln,'Latar Belakang','',1,'L');

	$pdf->SetFont($font,'',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'a.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Dasar Hukum','',1,'L');

	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[3],$ln,trim($Output_uk['dasar_hukum']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
		$pdf->Cell($wi[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'b.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Gambaran Umum','',1,'L');

	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[3],$ln,trim($Output_uk['gambaran_umum']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
		$pdf->Cell($wi[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$pdf->Ln();
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'c.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Keterkaitan Output dengan IKU','',1,'L');

	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[3],$ln,trim($Output_uk['kait_output_iku']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
		$pdf->Cell($wi[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$pdf->Ln();
	
	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'2.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2]+$wi[3],$ln,'Maksud dan Tujuan','',1,'L');

	$pdf->SetFont($font,'',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'a.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Maksud','',1,'L');

	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[3],$ln,trim($Output_uk['maksud']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
		$pdf->Cell($wi[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'b.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Tujuan','',1,'L');

	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[3],$ln,trim($Output_uk['tujuan']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
		$pdf->Cell($wi[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'3.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2]+$wi[3],$ln,'Kegiatan yang Dilaksanakan','',1,'L');
	$pdf->SetFont($font,'',$size+1);
	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[2]+$wi[3],$ln,trim($Output_uk['uraian_kegiatan']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2]+$wi[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
	
	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'4.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2]+$wi[3],$ln,'Indikator Kinerja, Volume dan Satuan Ukur','',1,'L');

	$wik = array(0,6,6,50,3,120);
	$pdf->SetFont($font,'',$size+1);
	$oOutput_ikk = mysql_query("SELECT ikk FROM m_ikk_kegiatan WHERE kdgiat = '$Output_uk[kdgiat]' AND kdoutput = '$Output_uk[kdoutput]' ");
	$Output_ikk = mysql_fetch_array($oOutput_ikk);
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($wik[2],$ln,'a.');
	$arrLabel	  = $pdf->SplitToArray($wik[3],$ln,'Indikator Kinerja');
	$arrTitik	  = $pdf->SplitToArray($wik[4],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($wik[5],$ln,trim($Output_ikk['ikk']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wik[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wik[0]);
		$pdf->Cell($wik[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]);
		$pdf->Cell($wik[2],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]);
		$pdf->Cell($wik[3],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]+$wik[3]);
		$pdf->Cell($wik[4],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]+$wik[3]+$wik[4]);
		$pdf->Cell($wik[5],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($wik[2],$ln,'b.');
	$arrLabel	  = $pdf->SplitToArray($wik[3],$ln,'Volume dan Satuan Ukur');
	$arrTitik	  = $pdf->SplitToArray($wik[4],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($wik[5],$ln,$Output_bp['volume'].' '.nm_satuan($Output_bp['kdsatuan']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wik[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wik[0]);
		$pdf->Cell($wik[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]);
		$pdf->Cell($wik[2],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]);
		$pdf->Cell($wik[3],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]+$wik[3]);
		$pdf->Cell($wik[4],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]+$wik[3]+$wik[4]);
		$pdf->Cell($wik[5],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
	
	$pdf->SetFont($font,'B',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'5.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2]+$wi[3],$ln,'Cara Pelaksanaan Kegiatan','',1,'L');

	$pdf->SetFont($font,'',$size+1);
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'a.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Metode Pelaksanaan','',1,'L');

	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($wi[3],$ln,trim($Output_uk['metode']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($wi[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]);
		$pdf->Cell($wi[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]);
		$pdf->Cell($wi[2],$ln,'','',0,'L');
		$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
		$pdf->Cell($wi[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
	$pdf->SetX($margin+$wi[0]);
	$pdf->Cell($wi[1],$ln,'','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]);
	$pdf->Cell($wi[2],$ln,'b.','',0,'L');
	$pdf->SetX($margin+$wi[0]+$wi[1]+$wi[2]);
	$pdf->Cell($wi[3],$ln,'Tahapan Pelaksanaan/Komponen','',1,'L');
	
	$w = array(0,6,6,50,3,120);
	$pdf->SetFont($font,'',$size+1);
	$no = 0 ;
	$oKomponen = mysql_query("SELECT nmkomponen FROM thuk_kak_komponen WHERE th='$Output_uk[th]' and kdgiat = '$Output_uk[kdgiat]' AND kdoutput = '$Output_uk[kdoutput]' ORDER BY kdkomponen");
	while($Komponen = mysql_fetch_array($oKomponen))
	{
	$no += 1 ;
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($wik[2],$ln,$no );
	$arrUraian	  = $pdf->SplitToArray($wik[3],$ln,trim($Komponen['nmkomponen']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[2]);
		$pdf->Cell($wik[0],$ln,'','',0,'L');
		$pdf->SetX($margin+$wik[0]);
		$pdf->Cell($wik[1],$ln,'','',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]);
		$pdf->Cell($wik[2],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]);
		$pdf->Cell($wik[3],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]+$wik[3]);
		$pdf->Cell($wik[4],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$wik[0]+$wik[1]+$wik[2]+$wik[3]+$wik[4]);
		$pdf->Cell($wik[5],$ln,$arrUraian[$i],'',1,'L');
	}
	
//------------------ Tanda Tangan	
	$wj = array(5,60);
	$pdf->Ln();
	$pdf->SetX($margin+$wj[0]);
	$pdf->Cell($wj[1],$ln,'Penanggung Jawab Kegiatan','',1,'C');

	$pdf->SetX($margin+$wj[0]);
	$pdf->Cell($wj[1],$ln,trim(nm_unit($Kegiatan_bp['kdunitkerja'])),'',1,'C');
	$pdf->SetX($margin+$wj[0]);
	$pdf->Cell($wj[1],$ln*5,'','',1,'C');
	$pdf->SetX($margin+$wj[0]);
	$pdf->Cell($wj[1],$ln,$Kegiatan_uk['id_pjawab'],'',1,'C');


	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>