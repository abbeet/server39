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
			$margin = 20;
			$w = array(35,115,35);
			$x = array(0,115);
			$this->SetFont($font,'',$size-2);
			
			$this->SetY(20);
		
			if ($this->PageNo() != 1) $this->Cell(0, 10, 'Hal. ' . $this->PageNo() . "/" . '{nb}',0,2,'R');
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
	$pdf->AliasNbPages();

	$th = $_REQUEST['th'] ;
	$xlevel = $_REQUEST['xlevel'];
	$xkdunit = $_REQUEST['xkdunit'];
	$kddeputi_i = substr($xkdunit,0,3);
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 7;
	$margin = 20;
	$tinggi = 275 ;
	
//------------------------------ cetak cover	
	$w = array(30,1,100,1);
	$pdf->SetXY(150,10);
	$pdf->SetFont($font,'B',$size+2);
	$y = $pdf->GetY()+10;
	$pdf->SetY($y);
	$pdf->Image('../../css/images/logo_lapan.jpg',90,25,30,30,'jpg');
	$pdf->SetFont($font,'B',$size+4);
	$y = $pdf->GetY()+70;
	$pdf->SetY($y);
	$pdf->Cell(0,10,'BASELINE ANGGARAN','',1,'C');
	$pdf->Cell(0,10,'LEMBAGA PENERBANGAN DAN ANTARIKSA NASIONAL','',1,'C');
//	$pdf->SetXY($margin+$w[0],$y+10);
	$pdf->Cell(0,10,'TAHUN ANGGARAN '.$th,'',1,'C');	
	$pdf->SetFont($font,'B',$size+2);
	$y = $pdf->GetY()+100 ;
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'LEMBAGA PENERBANGAN DAN ANTARIKSA NASIONAL','',1,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w[0],$y);
	$pdf->Cell($w[1]+$w[2]+$w[3],$ln,'Tahun '.( $th -1 ),'',1,'C');
//-------------------------------------------------------  akhir cover
	$pdf->AddPage();
	$margin = 10;
	$ln = 5 ;

	$w = array(22,93,38,38);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w[0],$ln*2,'KODE',$border,0,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln*2,'PROGRAM / KEGIATAN',$border,0,'C');
	$pdf->SetX($margin+$w[0]+$w[1]);
	$pdf->Cell($w[2],$ln*2,'ANGGARAN '.($th-1),$border,0,'C');
	$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
	$pdf->Cell($w[3],$ln*2,'ANGGARAN '.$th,$border,1,'C');
	
	$sql = "SELECT SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa,
			       SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	$pdf->SetFont($font,'B',$size+1);
	$max = 0 ;
	$arrKode 	  = $pdf->SplitToArray($w[0],$ln,'082');
	$arrUraian	  = $pdf->SplitToArray($w[1],$ln,'LEMBAGA PENERBANGAN DAN ANTARIKSA NASIONAL');
	$arrPaguDipa  = $pdf->SplitToArray($w[2],$ln,number_format($row['jml_anggaran_dipa'],"0",",","."));
	$arrPaguIni   = $pdf->SplitToArray($w[3],$ln,number_format($row['jml_anggaran_indikatif'],"0",",","."));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrKode[$i],'LR',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrPaguDipa[$i],'LR',0,'R');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrPaguIni[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());

	switch ($xlevel)
	{
		case '1':
	$sql = "SELECT kddept,kdunit,kdprogram, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' GROUP BY concat(kddept,kdunit,kdprogram) ORDER BY concat(kddept,kdunit,kdprogram)";
	    break;
		
		case '5':
	$sql = "SELECT kddept,kdunit,kdprogram, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE kdunitkerja = '$xkdunit' and th = '$th' GROUP BY concat(kddept,kdunit,kdprogram) ORDER BY concat(kddept,kdunit,kdprogram)";
	    break;

		case '6':
	$sql = "SELECT kddept,kdunit,kdprogram, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE left(kdunitkerja,3) = '$kddeputi_i' and th = '$th' GROUP BY concat(kddept,kdunit,kdprogram) ORDER BY concat(kddept,kdunit,kdprogram)";
	    break;
		
		default:
	$sql = "SELECT kddept,kdunit,kdprogram, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' GROUP BY concat(kddept,kdunit,kdprogram) ORDER BY concat(kddept,kdunit,kdprogram)";
	    break;
	
	}
	$oProgram = mysql_query($sql);
	while($Program = mysql_fetch_array($oProgram))
	{
	$pdf->SetFont($font,'B',$size);
	$kdprogram = $Program['kdprogram'] ;
	$max = 0 ;
	$arrKode 	  = $pdf->SplitToArray($w[0],$ln,$Program['kddept'].'.'.$Program['kdunit'].'.'.$Program['kdprogram']);
	$arrUraian	  = $pdf->SplitToArray($w[1],$ln,trim(nm_program($Program['kddept'].$Program['kdunit'].$Program['kdprogram'])));
	$arrPaguDipa  = $pdf->SplitToArray($w[2],$ln,number_format($Program['jml_anggaran_dipa'],"0",",","."));
	$arrPaguIni   = $pdf->SplitToArray($w[3],$ln,number_format($Program['jml_anggaran_indikatif'],"0",",","."));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrKode[$i],'LR',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrPaguDipa[$i],'LR',0,'R');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrPaguIni[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());
	
	
	switch ($xlevel)
	{
		case '1':
	$sql = "SELECT left(kdunitkerja,3) as deputi, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)";
	    break;
		
		case '5':
	$sql = "SELECT left(kdunitkerja,3) as deputi, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and kdunitkerja = '$xkdunit' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)";
	    break;
		
		case '6':
	$sql = "SELECT left(kdunitkerja,3) as deputi, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and left(kdunitkerja,3) = '$kddeputi_i' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)";
	    break;
		
		default:
	$sql = "SELECT left(kdunitkerja,3) as deputi, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)";
	    break;
	
	}
	$oDeputi = mysql_query($sql);
	while($Deputi = mysql_fetch_array($oDeputi))
	{
	$kddeputi = $Deputi['deputi'];
	$pdf->SetFont($font,'',$size);
	$max = 0 ;
	$arrKode 	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrUraian	  = $pdf->SplitToArray($w[1],$ln,trim(nm_unit($kddeputi.'000')));
	$arrPaguDipa  = $pdf->SplitToArray($w[2],$ln,number_format($Deputi['jml_anggaran_dipa'],"0",",","."));
	$arrPaguIni   = $pdf->SplitToArray($w[3],$ln,number_format($Deputi['jml_anggaran_indikatif'],"0",",","."));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrKode[$i],'LR',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrPaguDipa[$i],'LR',0,'R');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrPaguIni[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());
	
	switch ($xlevel)
	{
		case '1':
	$sql = "SELECT kdunitkerja, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and left(kdunitkerja,3) = '$kddeputi' GROUP BY kdunitkerja ORDER BY kdunitkerja";
	break;
		case '5':
	$sql = "SELECT kdunitkerja, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and kdunitkerja = '$xkdunit' GROUP BY kdunitkerja ORDER BY kdunitkerja";
	break;
		case '6':
	$sql = "SELECT kdunitkerja, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and left(kdunitkerja,3) = '$kddeputi' GROUP BY kdunitkerja ORDER BY kdunitkerja";
	break;
		default:
	$sql = "SELECT kdunitkerja, SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa, SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and left(kdunitkerja,3) = '$kddeputi' GROUP BY kdunitkerja ORDER BY kdunitkerja";
	break;

	}
	$oUnit = mysql_query($sql);
	while($Unit = mysql_fetch_array($oUnit))
	{
	$kdunitkerja = $Unit['kdunitkerja'];
	$pdf->SetFont($font,'',$size);
	$max = 0 ;
	$arrKode 	  = $pdf->SplitToArray($w[0],$ln,'');
	$arrUraian	  = $pdf->SplitToArray($w[1],$ln,trim(nm_unit($kdunitkerja)));
	$arrPaguDipa  = $pdf->SplitToArray($w[2],$ln,number_format($Unit['jml_anggaran_dipa'],"0",",","."));
	$arrPaguIni   = $pdf->SplitToArray($w[3],$ln,number_format($Unit['jml_anggaran_indikatif'],"0",",","."));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrKode[$i],'LR',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrPaguDipa[$i],'LR',0,'R');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrPaguIni[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());

	switch ($xlevel)
	{
		case '1':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and kdunitkerja = '$kdunitkerja'  ORDER BY kdgiat";
	    break;
		
		case '5':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and kdunitkerja = '$xkdunit'  ORDER BY kdgiat";
	    break;
	
		case '6':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and kdunitkerja = '$kdunitkerja'  ORDER BY kdgiat";
	    break;

		default:
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and kdprogram = '$kdprogram' and kdunitkerja = '$kdunitkerja'  ORDER BY kdgiat";
	    break;
	}
	$oGiat = mysql_query($sql);
	while($Giat = mysql_fetch_array($oGiat))
	{
	$kdgiat = $Giat['kdgiat'];
	$pdf->SetFont($font,'B',$size-1);
	$max = 0 ;
	$arrKode 	  = $pdf->SplitToArray($w[0],$ln,$kdgiat);
	$arrUraian	  = $pdf->SplitToArray($w[1],$ln,trim(nm_giat($kdgiat)));
	$arrPaguDipa  = $pdf->SplitToArray($w[2],$ln,number_format($Giat['jml_anggaran_dipa'],"0",",","."));
	$arrPaguIni   = $pdf->SplitToArray($w[3],$ln,number_format($Giat['jml_anggaran_indikatif'],"0",",","."));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrKode[$i],'LR',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrPaguDipa[$i],'LR',0,'R');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrPaguIni[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());

	switch ($xlevel)
	{
		case '1':
	$sql = "SELECT * FROM thbp_kak_output WHERE th = '$th' and kdgiat = '$kdgiat' and kdunitkerja = '$kdunitkerja'  ORDER BY kdoutput";
	    break;
	
		case '5':
	$sql = "SELECT * FROM thbp_kak_output WHERE th = '$th' and kdgiat = '$kdgiat' and kdunitkerja = '$xkdunit'  ORDER BY kdoutput";
	    break;
		
		case '6':
	$sql = "SELECT * FROM thbp_kak_output WHERE th = '$th' and kdgiat = '$kdgiat' and kdunitkerja = '$kdunitkerja'  ORDER BY kdoutput";
	    break;
		
		default:
	$sql = "SELECT * FROM thbp_kak_output WHERE th = '$th' and kdgiat = '$kdgiat' and kdunitkerja = '$kdunitkerja'  ORDER BY kdoutput";
	    break;
	}
	$oOutput = mysql_query($sql);
	while($Output = mysql_fetch_array($oOutput))
	{
	$kdoutput = $Output['kdoutput'];
	$thn = $th - 1 ;
	$pdf->SetFont($font,'',$size-2);
	$max = 0 ;
	$arrKode 	  = $pdf->SplitToArray($w[0],$ln,$kdgiat.'.'.$kdoutput);
	$arrUraian	  = $pdf->SplitToArray($w[1],$ln,trim(nm_output($kdgiat.$kdoutput)));
	$arrPaguDipa  = $pdf->SplitToArray($w[2],$ln,number_format(pagu_output($thn,$kdunitkerja,$kdgiat,$kdoutput),"0",",","."));
	$arrPaguIni   = $pdf->SplitToArray($w[3],$ln,number_format($Output['jml_anggaran'],"0",",","."));
	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrKode[$i],'LR',0,'C');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'LR',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrPaguDipa[$i],'LR',0,'R');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrPaguIni[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w[0]+$w[1]+$w[2]+$w[3],$pdf->GetY());

	} # while output
	} # while giat
	} # while unit kerja	
	} # while deputi
	} # while program
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>