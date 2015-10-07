<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
			$kdunit = $_REQUEST['kdunit'];
			$kdsatker = $_REQUEST['kdsatker'];
			$kdbulan = $_REQUEST['kdbulan'];
			if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
			if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
			$th = $_REQUEST['th'];
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 4;
			$margin = 5;
			$tinggi = 275 ;
			$w = array(0,280);
			$this->Ln();
			$this->SetFont($font,'B',$size+2);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'REKAPITULASI KEHADIRAN PEGAWAI','',1,'C');
			$this->SetX($margin+$w[0]);
			if ( $kdunit <> '' )    $this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit.'00'))),'',1,'C');
			if ( $kdsatker <> '' )    $this->Cell($w[1],$ln,'SATKER : '.trim(strtoupper(nm_satker($kdsatker))),'',1,'C');
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'Bulan : '.nama_bulan($kdbl).' '.$th,'',1,'C');
//			$this->Ln();
	
			$this->SetY(20);
			$this->SetFont($font,'',$size-3);
			$this->Cell(0, 10, 'Hal. ' . $this->PageNo(),0,1,'R');
//			if ($this->PageNo() != 1) $this->Line($margin, $this->GetY(), $margin+180,$this->GetY());
//			$this->Ln();

			$w1 = array(10,45,45,15,15,20,10,15);
			$this->SetFont($font,'B',$size);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*3,'NO.',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$ya = $this->GetY();
			$y = $this->GetY();
			$this->Cell($w1[1],$ln*3,'Jabatan',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]);
			$this->Cell($w1[2],$ln*3,'Nama / NIP',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
			$this->Cell($w1[3],$ln*3,'Grade',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
			$this->Cell($w1[4],$ln*3,'Gol',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
			$y = $this->GetY();
			$this->Cell($w1[5],$ln,'Tanpa',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+4);
			$this->Cell($w1[5],$ln,'Ket.(TK)',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y);
			$this->Cell($w1[5],$ln*2,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6],$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y);
//			$y = $this->GetY();
			$this->Cell($w1[6]*12,$ln,'CUTI',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+4);
			$this->Cell($w1[6]*2,$ln,'CT',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*2,$y+4);
			$this->Cell($w1[6]*2,$ln,'CB',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*4,$y+4);
			$this->Cell($w1[6]*2,$ln,'CSRI',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*6,$y+4);
			$this->Cell($w1[6]*2,$ln,'CSRJ',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*8,$y+4);
			$this->Cell($w1[6]*2,$ln,'CM',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*10,$y+4);
			$this->Cell($w1[6]*2,$ln,'CP',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*2,$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*3,$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*4,$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*5,$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*6,$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*7,$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*8,$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*9,$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*10,$y+8);
			$this->Cell($w1[6],$ln,'Hari',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*11,$y+8);
			$this->Cell($w1[6],$ln,'(%)',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12,$ya+2);
			$this->Cell($w1[7],$ln,'Jumlah',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12,$ya+6);
			$this->Cell($w1[7],$ln,'Pot.',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12,$ya);
			$this->Cell($w1[7],$ln*3,'',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	$kdsatker = $_REQUEST['kdsatker'];
	$kdbulan = $_REQUEST['kdbulan'];
	if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
	if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
	$th = $_REQUEST['th'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 4;
	$margin = 5;
	$tinggi = 275 ;
	$w1 = array(10,45,45,15,15,20,10,15);
	$pdf->SetFont($font,'',$size-2);
    
	$no = 0 ;
	if ( $kdunit <> '' ) 
	{
	$sql = "SELECT * FROM mst_potongan WHERE left(kdunitkerja,2) = '$kdunit' and tahun = '$th' and bulan = '$kdbulan' ORDER BY kdunitkerja,grade desc, kdgol desc";
	}else{
	$sql = "SELECT * FROM mst_potongan WHERE kdsatker = '$kdsatker' and tahun = '$th' and bulan = '$kdbulan' ORDER BY grade desc, kdgol desc, kdunitkerja";
	}
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrUnit	  = $pdf->SplitToArray($w1[1],$ln,trim(nmjabatan_mst_tk($row['nib'],$th,$kdbulan)));
	$arrNama	  = $pdf->SplitToArray($w1[2],$ln,nama_peg($row['nib'])."\n".'NIP. '.reformat_nipbaru(nip_peg($row['nib'])));
	$arrGrade     = $pdf->SplitToArray($w1[3],$ln,$row['grade']);
	$arrGol	      = $pdf->SplitToArray($w1[4],$ln,nm_gol(substr($row['kdgol'],0,1).hurufkeangka(substr($row['kdgol'],1,1))));
	if ( $row['kdpot_10'] <> 0 )   $arrPot_10    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_10']);
	if ( $row['kdpot_10'] == 0 )   $arrPot_10    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_11'] <> 0 )   $arrPot_11    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_11']);
	if ( $row['kdpot_11'] == 0 )   $arrPot_11    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_12'] <> 0 )   $arrPot_12    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_12']);
	if ( $row['kdpot_12'] == 0 )   $arrPot_12    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_13'] <> 0 )   $arrPot_13    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_13']);
	if ( $row['kdpot_13'] == 0 )   $arrPot_13    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_14'] <> 0 )   $arrPot_14    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_14']);
	if ( $row['kdpot_14'] == 0 )   $arrPot_14    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_15'] <> 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_15']);
	if ( $row['kdpot_15'] == 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_16'] <> 0 )   $arrPot_16    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_16']);
	if ( $row['kdpot_16'] == 0 )   $arrPot_16    = $pdf->SplitToArray($w1[6],$ln,'');
	
	$nilpot_10 = $row['kdpot_10'] * persen_pot('10') ;
	$nilpot_11 = $row['kdpot_11'] * persen_pot('11') ;
	$nilpot_12 = $row['kdpot_12'] * persen_pot('12') ;
	$nilpot_13 = $row['kdpot_13'] * persen_pot('13') ;
	$nilpot_14 = $row['kdpot_14'] * persen_pot('14') ;
	$nilpot_15 = $row['kdpot_15'] * persen_pot('15') ;
	$nilpot_16 = $row['kdpot_16'] * persen_pot('16') ;
	
	$totpot = $nilpot_10 + $nilpot_11 + $nilpot_12 + $nilpot_13 + $nilpot_14 + $nilpot_15 + $nilpot_16 ;
	if ( $row['kdpot_10'] <> 0 )   $arrNil_10    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_10,"1",",",".").'%' );
	if ( $row['kdpot_10'] == 0 )   $arrNil_10    = $pdf->SplitToArray($w1[6],$ln, '' );
	if ( $row['kdpot_11'] <> 0 )   $arrNil_11    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_11,"1",",",".").'%' );
	if ( $row['kdpot_11'] == 0 )   $arrNil_11    = $pdf->SplitToArray($w1[6],$ln, '' );
	if ( $row['kdpot_12'] <> 0 )   $arrNil_12    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_12,"1",",",".").'%' );
	if ( $row['kdpot_12'] == 0 )   $arrNil_12    = $pdf->SplitToArray($w1[6],$ln, '' );
	if ( $row['kdpot_13'] <> 0 )   $arrNil_13    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_13,"1",",",".").'%' );
	if ( $row['kdpot_13'] == 0 )   $arrNil_13    = $pdf->SplitToArray($w1[6],$ln, '' );
	if ( $row['kdpot_14'] <> 0 )   $arrNil_14    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_14,"1",",",".").'%' );
	if ( $row['kdpot_14'] == 0 )   $arrNil_14    = $pdf->SplitToArray($w1[6],$ln, '' );
	if ( $row['kdpot_15'] <> 0 )   $arrNil_15    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_15,"1",",",".").'%' );
	if ( $row['kdpot_15'] == 0 )   $arrNil_15    = $pdf->SplitToArray($w1[6],$ln, '' );
	if ( $row['kdpot_16'] <> 0 )   $arrNil_16    = $pdf->SplitToArray($w1[6],$ln, number_format($nilpot_16,"1",",",".").'%' );
	if ( $row['kdpot_16'] == 0 )   $arrNil_16    = $pdf->SplitToArray($w1[6],$ln, '' );
	
	$arrTotPot    = $pdf->SplitToArray($w1[5],$ln, number_format($totpot,"1",",",".").'%' );

	if ($max<count($arrNama)) $max=count($arrNama);
	if ($max<count($arrUnit)) $max=count($arrUnit);
	$kdunit = $row['kdunitkerja'] ;
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrUnit[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrNama[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrGrade[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrGol[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[6],$ln,$arrPot_10[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]);
		$pdf->Cell($w1[6],$ln,$arrNil_10[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*2);
		$pdf->Cell($w1[6],$ln,$arrPot_11[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*3);
		$pdf->Cell($w1[6],$ln,$arrNil_11[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*4);
		$pdf->Cell($w1[6],$ln,$arrPot_12[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*5);
		$pdf->Cell($w1[6],$ln,$arrNil_12[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*6);
		$pdf->Cell($w1[6],$ln,$arrPot_13[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*7);
		$pdf->Cell($w1[6],$ln,$arrNil_13[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*8);
		$pdf->Cell($w1[6],$ln,$arrPot_14[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*9);
		$pdf->Cell($w1[6],$ln,$arrNil_14[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*10);
		$pdf->Cell($w1[6],$ln,$arrPot_15[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*11);
		$pdf->Cell($w1[6],$ln,$arrNil_15[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*12);
		$pdf->Cell($w1[6],$ln,$arrPot_16[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*13);
		$pdf->Cell($w1[6],$ln,$arrNil_16[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*14);
		$pdf->Cell($w1[7],$ln,$arrTotPot[$i],'LR',1,'C');
	}
	  if($pdf->GetY() >= 180 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }
	}
	$pdf->SetFont($font,'',$size-3);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Dicetak tgl. '.date ('d-m-Y H:i:s'),'',1,'L');
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');



?>