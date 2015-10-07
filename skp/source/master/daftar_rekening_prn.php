<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
	$kdunit = $_REQUEST['kdunit'];
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 9;
	$ln = 5;
	$margin = 5;
	$tinggi = 275 ;
	$w = array(0,270);
	if ( substr(date('m'),0,1) == '0' )  $bulan = substr(date('m'),1,1);
	else $bulan = date('m');
	$this->Ln();
	$this->SetFont($font,'B',$size+2);
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,'DAFTAR REKENING PEGAWAI','',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit))),'',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln*5,'','',1,'C');
	$this->SetY(20);
	$this->SetFont($font,'',$size-3);
	$this->Cell(0, 10, 'Hal. ' . $this->PageNo(),0,1,'R');
	$w1 = array(15,50,53,12,55,40,25,40);
	$this->SetFont($font,'B',$size);
	$this->SetX($margin);
	$this->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
	$this->SetX($margin+$w1[0]);
	$this->Cell($w1[1],$ln,'Bidang/Bagian',$noborder,0,'C');
	$y = $this->GetY();
	$this->SetXY($margin+$w1[0],$y+4);
	$this->Cell($w1[1],$ln,'SubBidang/SubBagian',$noborder,0,'C');
	$this->SetXY($margin+$w1[0],$y);
	$this->Cell($w1[1],$ln*2,'',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]);
	$this->Cell($w1[2],$ln*2,'Nama Pegawai',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$this->Cell($w1[3],$ln*2,'Gol.',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$this->Cell($w1[4],$ln*2,'Nama Jabatan',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
	$this->Cell($w1[5],$ln*2,'Nama Bank',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
	$this->Cell($w1[6],$ln*2,'Nomor Rek.',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
	$this->Cell($w1[7],$ln*2,'Nama Penerima',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 9;
	$ln = 5;
	$margin = 5;
	$tinggi = 275 ;
	$w = array(0,180);
	$pdf->SetFont($font,'',$size);
	$w1 = array(15,50,53,12,55,40,25,40);
	$no = 0 ;
	
	$xkdunit = substr($kdunit,0,5) ;
	if ( $kdunit == '2320100' )
	{
	$sql = "SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '%$xkdunit%' OR kdunitkerja = '2320000' ORDER BY kdunitkerja, kdeselon desc,kdjabatan desc,kdgol";
	}else{
	$sql = "SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '%$xkdunit%' ORDER BY kdunitkerja, kdeselon desc,kdjabatan desc,kdgol";
	}
	
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$nip = $row['nip'];
		$sql_bank = "SELECT * FROM mst_rekening WHERE nip = '$nip'";
		$oList = mysql_query($sql_bank) ;
		$List  = mysql_fetch_array($oList) ;
	
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	if ( $row['kdunitkerja'] <> $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,trim(nm_unitkerja($row['kdunitkerja'])));
	if ( $row['kdunitkerja'] == $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,'');
	$arrJabatan   = $pdf->SplitToArray($w1[4],$ln,nm_jabatan_ij($row['kdjabatan'],$row['kdunitkerja'])."\n".'['.reformat_tgl($row['tmtjabatan']).']');
	$arrNama	  = $pdf->SplitToArray($w1[2],$ln,nama_peg($row['nip'])."\n".'NIP. '.reformat_nipbaru($row['nip']));
	$arrGol	      = $pdf->SplitToArray($w1[3],$ln,nm_gol($row['kdgol'])."\n".nm_status_peg($row['kdstatuspeg']));
	$arrBank     = $pdf->SplitToArray($w1[5],$ln,trim($List['bank']));
	$arrNorek     = $pdf->SplitToArray($w1[6],$ln,trim($List['no_rek']));
	$arrPenerima  = $pdf->SplitToArray($w1[7],$ln,trim($List['penerima']));

	if ($max<count($arrUnit)) $max=count($arrUnit);
	if ($max<count($arrJabatan)) $max=count($arrJabatan);
	if ($max<count($arrNama)) $max=count($arrNama);

	if ( $row['kdunitkerja'] <> $kdunitkerja )   $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$pdf->GetY());
	if ( $row['kdunitkerja'] == $kdunitkerja )   $pdf->Line($margin+$w1[0]+$w1[1], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$pdf->GetY());
	$kdunitkerja = $row['kdunitkerja'];
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrUnit[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrNama[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrGol[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrJabatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrBank[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrNorek[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,$arrPenerima[$i],'LR',1,'L');
	}
//	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$pdf->GetY());
	
	    if($pdf->GetY() >= 270 )
		{
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$pdf->GetY());
		$pdf->AddPage();	
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$pdf->GetY());
	    }
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$pdf->GetY());
	$pdf->SetFont($font,'',$size-3);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Dicetak tgl. '.date ('d-m-Y H:i:s'),'',1,'L');
	$pdf->SetDisplayMode('real');
	$pdf->Output('daftar_rekening.pdf','I');

?>