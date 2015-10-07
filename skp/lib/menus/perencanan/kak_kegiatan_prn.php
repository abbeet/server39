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
	
	$id = $_REQUEST['id'];
	$q  = $_REQUEST['q'];
	$oKegiatan_bp = mysql_query("SELECT * FROM thbp_kak_kegiatan WHERE id = '$id' ");
	$Kegiatan_bp = mysql_fetch_array($oKegiatan_bp);
	
	$oKegiatan_uk = mysql_query("SELECT * FROM thuk_kak_kegiatan WHERE id = '$q' ");
	$Kegiatan_uk = mysql_fetch_array($oKegiatan_uk);

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

	$max = 0 ;
	$arrNmGiat  = $pdf->SplitToArray($w[2],$ln,trim(nm_giat($Kegiatan_bp['kdgiat'])));
	if ($max<count($arrNmGiat)) $max=count($arrNmGiat);

	$pdf->Line($margin+$w[0], $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln-2,'','LR',1,'L');
	$pdf->SetFont($font,'B',$size+5);
	for($i=0;$i<$max;$i++)
	{
	$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'','L',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrNmGiat[$i],'',0,'C');
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
	$w = array(10,30,5,140);
	$pdf->SetFont($font,'B',$size+3);
	$y = $pdf->GetY()+10;
	$pdf->Ln();
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3],$ln,'PROPOSAL KEGIATAN','',1,'C');
	$y = $pdf->GetY();
	$pdf->Ln();
	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($w[1]+$w[2]+$w[3],$ln,trim(nm_giat($Kegiatan_bp['kdgiat'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,$arrUraian[$i],'',1,'C');
	}

	$y = $pdf->GetY()+5;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3],$ln,'','',1,'C');

	$pdf->SetFont($font,'',$size+2);
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'DEPUTI');
	$arrTitik	  = $pdf->SplitToArray($w[2],$ln,':');
	$arrUraian	  = $pdf->SplitToArray($w[3],$ln,trim(nm_unit(substr($Kegiatan_bp['kdunitkerja'],0,3).'000')));
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

	$pdf->Ln();
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'Program');
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
	$arrLabel	  = $pdf->SplitToArray($w[1],$ln,'Outcome');
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

	$pdf->Ln();
		$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Tugas Pokok','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
		$pdf->SetFont($font,'',$size+2);
	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($w[1]+$w[2]+$w[3],$ln,trim(tugas_unit($Kegiatan_bp['kdunitkerja'])));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,$arrUraian[$i],'',1,'L');
	}

	$pdf->Ln();
		$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Fungsi','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
	$pdf->SetFont($font,'',$size+2);
	$wb = array(10,6,25,5,170);
	$sql = "SELECT * FROM tb_unitkerja_fungsi WHERE kdunit = '".$Kegiatan_bp[kdunitkerja]."'";
	$oFungsi = mysql_query($sql);
	while ($Fungsi = mysql_fetch_array($oFungsi))
	{
	$max = 0 ;
	$arrNomor	  = $pdf->SplitToArray($wb[1],$ln,trim($Fungsi['kdfungsi']).'.');
	$arrUraian	  = $pdf->SplitToArray($wb[2]+$wb[3]+$wb[4],$ln,trim($Fungsi['nmfungsi']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$wb[0]);
		$pdf->Cell($wb[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wb[0]+$wb[1]);
		$pdf->Cell($wb[2]+$wb[3]+$wb[4],$ln,$arrUraian[$i],'',1,'L');
	}
	
	}
	
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Tujuan','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
	$pdf->SetFont($font,'',$size+2);
	$sql = "SELECT alasan FROM m_iku_program WHERE kddeputi = '".substr($Kegiatan_bp[kdunitkerja],0,3).'000'."'";
	$oTujuan = mysql_query($sql);
	$n = 0 ;
	while ($Tujuan = mysql_fetch_array($oTujuan))
	{ 
	$max = 0 ;
	$n += 1 ;
	$arrNomor	  = $pdf->SplitToArray($wb[1],$ln,$n .'.');
	$arrUraian	  = $pdf->SplitToArray($wb[2]+$wb[3]+$wb[4],$ln,trim($Tujuan['alasan']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$wb[0]);
		$pdf->Cell($wb[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wb[0]+$wb[1]);
		$pdf->Cell($wb[2]+$wb[3]+$wb[4],$ln,$arrUraian[$i],'',1,'L');
	}
	
	}
	
	$pdf->Ln();
		$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Sasaran','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
	$pdf->SetFont($font,'',$size+2);
	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($w[1]+$w[2]+$w[3],$ln,trim(outcome_deputi(substr($Kegiatan_bp[kdunitkerja],0,3).'000')));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$pdf->Ln();
		$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'Indikator Kinerja Utama (IKU)','',1,'L');
	$pdf->SetFont($font,'',$size+2);
	$sql = "SELECT iku FROM m_iku_program WHERE kddeputi = '".substr($Kegiatan_bp[kdunitkerja],0,3).'000'."'";
	$oIKU = mysql_query($sql);
	$n = 0 ;
	while ($IKU = mysql_fetch_array($oIKU))
	{ 
	$n += 1 ;
	$arrNomor	  = $pdf->SplitToArray($wb[1],$ln,$n .'.');
	$arrUraian	  = $pdf->SplitToArray($wb[2]+$wb[3]+$wb[4],$ln,trim($IKU['iku']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$wb[0]);
		$pdf->Cell($wb[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wb[0]+$wb[1]);
		$pdf->Cell($wb[2]+$wb[3]+$wb[4],$ln,$arrUraian[$i],'',1,'L');
	}
	
	}

	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'Indikator Kinerja Kegiatan (IKK)','',1,'L');
	$pdf->SetFont($font,'',$size+2);
	$sql = "SELECT ikk FROM m_ikk_kegiatan WHERE kdgiat = '".$Kegiatan_bp[kdgiat]."'";
	$oIKK = mysql_query($sql);
	$n = 0 ;
	while ($IKK = mysql_fetch_array($oIKK))
	{ 
	$n += 1 ;
	$arrNomor		  = $pdf->SplitToArray($wb[1],$ln,$n .'.');
	$arrUraian	  = $pdf->SplitToArray($wb[2]+$wb[3]+$wb[4],$ln,trim($IKK['ikk']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$wb[0]);
		$pdf->Cell($wb[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$wb[0]+$wb[1]);
		$pdf->Cell($wb[2]+$wb[3]+$wb[4],$ln,$arrUraian[$i],'',1,'L');
	}
	
	}
	
	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin);
	$pdf->Cell($w[0],$ln,'','',0,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Output','',0,'L');
	$pdf->SetX($margin+$w[0]+$w[1]);
	$pdf->Cell($w[2],$ln,'','',1,'L');

	$pdf->SetFont($font,'',$size);
	$wo = array(10,10,60,30,30,40);
	$pdf->SetX($margin+$wo[0]);
	$pdf->Cell($wo[1],$ln*2,'Kode',$border,0,'C');
	$pdf->SetX($margin+$wo[0]+$wo[1]);
	$pdf->Cell($wo[2],$ln*2,'Output',$border,0,'C');
	$pdf->SetX($margin+$wo[0]+$wo[1]+$wo[2]);
	$pdf->Cell($wo[3],$ln*2,'Volume',$border,0,'C');
	$pdf->SetX($margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]);
	$pdf->Cell($wo[4],$ln*2,'Anggaran',$border,0,'C');
	$pdf->SetX($margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]+$wo[4]);
	$pdf->Cell($wo[5],$ln*2,'Penanggung Jawab',$border,1,'C');
	$lno = 4 ;
	$sql = "SELECT * FROM thbp_kak_output WHERE kdgiat = '".$Kegiatan_bp[kdgiat]."' and th = '". $Kegiatan_bp[th]."' order by kdoutput" ;
	$oOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($oOutput))
	{
	$jml_anggaran += $Output['jml_anggaran'] ;
	$arrNomor	  = $pdf->SplitToArray($wo[1],$ln,$Output['kdoutput']);
	$arrUraian	  = $pdf->SplitToArray($wo[2],$ln,trim(nm_output($Output['kdgiat'].$Output['kdoutput'])));
	$arrVolume	  = $pdf->SplitToArray($wo[3],$ln,trim($Output['volume'].' '.nm_satuan($Output['kdsatuan'])));
	$arrAnggaran  = $pdf->SplitToArray($wo[4],$ln,number_format($Output['jml_anggaran'],"0",",","."));
	$arrNama	  = $pdf->SplitToArray($wo[5],$ln,trim($Output['id_pjawab']));
	
	if ($max<count($arrUraian)) $max=count($arrUraian);
	if ($max<count($arrNama)) $max=count($arrNama);
	
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$wo[0]);
		$pdf->Cell($wo[1],$lno,$arrNomor[$i],'LR',0,'C');
		$pdf->SetX($margin+$wo[0]+$wo[1]);
		$pdf->Cell($wo[2],$lno,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$wo[0]+$wo[1]+$wo[2]);
		$pdf->Cell($wo[3],$lno,$arrVolume[$i],'LR',0,'C');
		$pdf->SetX($margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]);
		$pdf->Cell($wo[4],$lno,$arrAnggaran[$i],'LR',0,'R');
		$pdf->SetX($margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]+$wo[4]);
		$pdf->Cell($wo[5],$lno,$arrNama[$i],'LR',1,'L');
		if( $pdf->GetY() >= 265 )
		{
			$pdf->Line($margin+$wo[0], $pdf->GetY(), $margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]+$wo[4]+$wo[5],$pdf->GetY());
			$pdf->AddPage();
			$pdf->Ln()*2;
			$pdf->Line($margin+$wo[0], $pdf->GetY(), $margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]+$wo[4]+$wo[5],$pdf->GetY());
		}
	}
	$pdf->Line($margin+$wo[0], $pdf->GetY(), $margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]+$wo[4]+$wo[5],$pdf->GetY());
	}
	$pdf->Line($margin+$wo[0], $pdf->GetY(), $margin+$wo[0]+$wo[1]+$wo[2]+$wo[3]+$wo[4]+$wo[5],$pdf->GetY());

	$pdf->SetFont($font,'B',$size+2);
	
	$pdf->Ln();
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Input','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
		
		$pdf->SetFont($font,'',$size+2);
		$w_in = array(10,5,16,10,130);
		$pdf->SetX($margin);
		$pdf->Cell($w_in[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w_in[0]);
		$pdf->Cell($w_in[1],$ln,'a.','',0,'L');
		$pdf->SetX($margin+$w_in[0]+$w_in[1]);
		$pdf->Cell($w_in[2],$ln,'Dana','',0,'L');
		$pdf->SetX($margin+$w_in[0]+$w_in[1]+$w_in[2]);
		$pdf->Cell($w_in[3],$ln,': Rp. ','',0,'L');
		$pdf->SetX($margin+$w_in[0]+$w_in[1]+$w_in[2]+$w_in[3]);
		$pdf->Cell($w_in[4],$ln,number_format($jml_anggaran,"0",",",".").',-','',1,'L');

		$pdf->SetX($margin);
		$pdf->Cell($w_in[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w_in[0]);
		$pdf->Cell($w_in[1],$ln,'b.','',0,'L');
		$pdf->SetX($margin+$w_in[0]+$w_in[1]);
		$pdf->Cell($w_in[2],$ln,'SDM','',0,'L');
		$pdf->SetX($margin+$w_in[0]+$w_in[1]+$w_in[2]);
		$pdf->Cell($w_in[3]+$w_in[4],$ln,': '.$Kegiatan_uk['jml_sdm'].' Orang','',1,'L');

		$pdf->SetX($margin);
		$pdf->Cell($w_in[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w_in[0]);
		$pdf->Cell($w_in[1],$ln,'b.','',0,'L');
		$pdf->SetX($margin+$w_in[0]+$w_in[1]);
		$pdf->Cell($w_in[2]+$w_in[2]+$w_in[3],$ln,'Alat Yang Akan Dibeli :','',1,'L');
	
		$wa = array(15,8,35,20,20,20,20,27,18);
		$pdf->SetFont($font,'',$size-1);
		$y = $pdf->GetY();
		$pdf->SetX($margin+$wa[0]);
		$pdf->Cell($wa[1],$ln*2,'No.',$border,0,'C');
		$pdf->SetX($margin+$wa[0]+$wa[1]);
		$pdf->Cell($wa[2],$ln*2,'Nama Alat',$border,0,'C');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]);
		$pdf->Cell($wa[3],$ln*2,'Volume',$border,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3],$y);
		$pdf->Cell($wa[4],$ln,'Harga',$noborder,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3],$y+4);
		$pdf->Cell($wa[4],$ln,'Satuan',$noborder,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3],$y);
		$pdf->Cell($wa[4],$ln*2,'',$border,0,'C');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]);
		$pdf->Cell($wa[5],$ln*2,'Harga',$border,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5],$y);
		$pdf->Cell($wa[6],$ln,'Penempatan',$noborder,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5],$y+4);
		$pdf->Cell($wa[6],$ln,'Alat',$noborder,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5],$y);
		$pdf->Cell($wa[6],$ln*2,'',$border,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6],$y);
		$pdf->Cell($wa[7],$ln,'Alasan',$noborder,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6],$y+4);
		$pdf->Cell($wa[7],$ln,'Pengadaan',$noborder,0,'C');
		$pdf->SetXY($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6],$y);
		$pdf->Cell($wa[7],$ln*2,'',$border,0,'C');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]+$wa[7]);
		$pdf->Cell($wa[8],$ln*2,'Status',$border,1,'C');
	$lna = 4 ;	
	$sql = "SELECT * FROM thuk_kak_alat WHERE kdgiat = '".$Kegiatan_bp[kdgiat]."' and th = '". $Kegiatan_bp[th]."' order by id" ;
	$oAlat = mysql_query($sql);
	while ($Alat = mysql_fetch_array($oAlat))
	{
	$no += 1 ;
	$jmlh		 		+= $Output['jml_anggaran'] ;
	$arrNomor	  		= $pdf->SplitToArray($wa[1],$lna,$no);
	$arrUraian	  		= $pdf->SplitToArray($wa[2],$lna,trim($Alat['nmalat']));
	$arrVolume	  		= $pdf->SplitToArray($wa[3],$lna,trim($Alat['volume'].' '.($Alat['satuan'])));
	$arrHargaSatuan  	= $pdf->SplitToArray($wa[4],$lna,number_format($Alat['harga_satuan'],"0",",","."));
	$arrHarga	    	= $pdf->SplitToArray($wa[5],$lna,number_format($Alat['harga_satuan']*$Alat['volume'],"0",",","."));
	$arrPenempatan	  	= $pdf->SplitToArray($wa[6],$lna,trim($Alat['penempatan']));
	$arrAlasanPengadaan	= $pdf->SplitToArray($wa[7],$lna,trim($Alat['alasan_pengadaan']));
	if($Alat['status_alat']=='1')  $arrStatus	= $pdf->SplitToArray($wa[8],$lna,'Dihibahkan');
	if($Alat['status_alat']=='0')  $arrStatus	= $pdf->SplitToArray($wa[8],$lna,'Dipakai Sendiri');

	if ($max<count($arrUraian)) $max=count($arrUraian);
	if ($max<count($arrVolume)) $max=count($arrVolume);
	if ($max<count($arrPenempatan)) $max=count($arrPenempatan);
	if ($max<count($arrAlasanPengadaan)) $max=count($arrAlasanPengadaan);
	if ($max<count($arrStatus)) $max=count($arrStatus);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$wa[0]);
		$pdf->Cell($wa[1],$lna,$arrNomor[$i],'LR',0,'C');
		$pdf->SetX($margin+$wa[0]+$wa[1]);
		$pdf->Cell($wa[2],$lna,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]);
		$pdf->Cell($wa[3],$lna,$arrVolume[$i],'LR',0,'C');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]);
		$pdf->Cell($wa[4],$lna,$arrHargaSatuan[$i],'LR',0,'R');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]);
		$pdf->Cell($wa[5],$lna,$arrHarga[$i],'LR',0,'R');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]);
		$pdf->Cell($wa[6],$lna,$arrPenempatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]);
		$pdf->Cell($wa[7],$lna,$arrAlasanPengadaan[$i],'LR',0,'L');
		$pdf->SetX($margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]+$wa[7]);
		$pdf->Cell($wa[8],$lna,$arrStatus[$i],'LR',1,'L');

		if( $pdf->GetY() >= 265 )
		{
			$pdf->Line($margin+$wa[0], $pdf->GetY(), $margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]+$wa[7]+$wa[8],$pdf->GetY());
			$pdf->AddPage();
			$pdf->Ln()*2;
			$pdf->Line($margin+$wa[0], $pdf->GetY(), $margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]+$wa[7]+$wa[8],$pdf->GetY());
		}
	}
			$pdf->Line($margin+$wa[0], $pdf->GetY(), $margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]+$wa[7]+$wa[8],$pdf->GetY());
	}
			$pdf->Line($margin+$wa[0], $pdf->GetY(), $margin+$wa[0]+$wa[1]+$wa[2]+$wa[3]+$wa[4]+$wa[5]+$wa[6]+$wa[7]+$wa[8],$pdf->GetY());

	$pdf->Ln();
		$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Metodologi','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
		$pdf->SetFont($font,'',$size+2);
	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($w[1]+$w[2]+$w[3],$ln,trim($Kegiatan_uk['metodologi']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$pdf->Ln();
		$pdf->SetFont($font,'B',$size+2);
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,'','',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,'Referensi','',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,'','',1,'L');
		$pdf->SetFont($font,'',$size+2);
	$max = 0 ;
	$arrUraian	  = $pdf->SplitToArray($w[1]+$w[2]+$w[3],$ln,trim($Kegiatan_uk['referensi']));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1]+$w[2]+$w[3],$ln,$arrUraian[$i],'',1,'L');
	}

//------------------ Tanda Tangan	
	$wj = array(110,60);
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