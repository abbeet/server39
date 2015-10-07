<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function SetDash($black=false, $white=false)
		{
			if($black and $white)
				$s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
			else
				$s='[] 0 d';
			$this->_out($s);
		}
		
		function Header() {
			$kdunit = $_REQUEST['kdunit'];
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
			$this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit.'00'))),'',1,'C');
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'Bulan : '.nama_bulan($kdbl).' '.$th,'',1,'C');
//			$this->Ln();
	
			$this->SetY(17);
			$this->SetFont($font,'',$size-3);
			$this->Cell(0, 10, 'Hal. ' . $this->PageNo(),0,1,'R');
//			if ($this->PageNo() != 1) $this->Line($margin, $this->GetY(), $margin+180,$this->GetY());
//			$this->Ln();

			$w1 = array(10,45,40,0,0,0,15,15);
			$this->SetFont($font,'B',$size);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*4,'NO.',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$ya = $this->GetY();
			$y = $this->GetY();
			$this->Cell($w1[1],$ln*4,'Unit Kerja',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]);
			$this->Cell($w1[2],$ln*4,'Nama / NIP',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
			$this->Cell($w1[6]*7,$ln,'Catatan Kehadiran',$border,0,'C');
			$y = $this->GetY();
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+4);
			$this->Cell($w1[6],$ln,'',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6],$y+4);
			$this->Cell($w1[6]*2,$ln,'Terlambat',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*3,$y+4);
			$this->Cell($w1[6]*2,$ln,'Keluar Smtara',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*5,$y+4);
			$this->Cell($w1[6]*2,$ln,'Pulang Blm Wkt',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*7,$y+2);
			$this->Cell($w1[6]*3,$ln,'Cuti',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*7,$y);
			$this->Cell($w1[6]*3,$ln*2,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*10,$y);
			$this->Cell($w1[6],$ln,'Tugas',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*10,$y+4);
			$this->Cell($w1[6],$ln,'Belajar',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*10,$y);
			$this->Cell($w1[6],$ln*2,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*11,$y);
			$this->Cell($w1[6],$ln,'Tidak',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*11,$y+4);
			$this->Cell($w1[6],$ln,'Ikut',$noborder,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+6);
			$this->Cell($w1[6],$ln,'Tanpa',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6],$y+8);
			$this->Cell($w1[6],$ln,'TL1',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*2,$y+8);
			$this->Cell($w1[6],$ln,'TL2',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*3,$y+8);
			$this->Cell($w1[6],$ln,'KS1',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*4,$y+8);
			$this->Cell($w1[6],$ln,'KS2',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*5,$y+8);
			$this->Cell($w1[6],$ln,'PSW1',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*6,$y+8);
			$this->Cell($w1[6],$ln,'PSW2',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*7,$y+8);
			$this->Cell($w1[6],$ln,'CT',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*8,$y+8);
			$this->Cell($w1[6],$ln,'CSRI',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*9,$y+8);
			$this->Cell($w1[6],$ln,'CP',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*10,$y+8);
			$this->Cell($w1[6],$ln,'TB<3',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*11,$y+8);
			$this->Cell($w1[6],$ln,'Upacara',$noborder,0,'C');
	
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+10);
			$this->Cell($w1[6],$ln,'Ket.',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6],$y+12);
			$this->Cell($w1[6],$ln,'TL3',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*2,$y+12);
			$this->Cell($w1[6],$ln,'TL4',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*3,$y+12);
			$this->Cell($w1[6],$ln,'KS3',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*4,$y+12);
			$this->Cell($w1[6],$ln,'KS4',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*5,$y+12);
			$this->Cell($w1[6],$ln,'PSW3',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*6,$y+12);
			$this->Cell($w1[6],$ln,'PSW4',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*7,$y+12);
			$this->Cell($w1[6],$ln,'CB',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*8,$y+12);
			$this->Cell($w1[6],$ln,'CSRJ',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*9,$y+12);
			$this->Cell($w1[6],$ln,'CM',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*10,$y+12);
			$this->Cell($w1[6],$ln,'TB>=3',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*11,$y+12);
			$this->Cell($w1[6],$ln,'Bendera',$noborder,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+4);
			$this->Cell($w1[6],$ln*3,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*11,$y);
			$this->Cell($w1[6],$ln*4,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*12,$ya+2);
			$this->Cell($w1[7],$ln,'Jumlah',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*12,$ya+6);
			$this->Cell($w1[7],$ln,'Pot.',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6]*12,$ya);
			$this->Cell($w1[7],$ln*4,'',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
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
	$w1 = array(10,45,40,0,0,0,15,15);
	$pdf->SetFont($font,'',$size-2);
    
	$no = 0 ;
	$sql = "SELECT * FROM mst_potongan WHERE left(kdunitkerja,2) = '$kdunit' and tahun = '$th' and bulan = '$kdbulan' ORDER BY kdunitkerja,grade desc, kdgol desc";
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	if ( $row['kdunitkerja'] <> $kdunit )  $arrUnit	  = $pdf->SplitToArray($w1[1],$ln,nm_unitkerja($row['kdunitkerja']));
	if ( $row['kdunitkerja'] == $kdunit )  $arrUnit	  = $pdf->SplitToArray($w1[1],$ln,'');
	$arrNama	  = $pdf->SplitToArray($w1[2],$ln,nama_peg($row['nib'])."\n".'NIP. '.reformat_nipbaru(nip_peg($row['nib'])));

	$nilpot_10 = $row['kdpot_10'] * persen_pot('10') ;
	$nilpot_11 = $row['kdpot_11'] * persen_pot('11') ;
	$nilpot_12 = $row['kdpot_12'] * persen_pot('12') ;
	$nilpot_13 = $row['kdpot_13'] * persen_pot('13') ;
	$nilpot_14 = $row['kdpot_14'] * persen_pot('14') ;
	$nilpot_15 = $row['kdpot_15'] * persen_pot('15') ;
	$nilpot_16 = $row['kdpot_16'] * persen_pot('16') ;
	
	$nilpot_01 = $row['kdpot_01'] * persen_pot('01') ;
	$nilpot_02 = $row['kdpot_02'] * persen_pot('02') ;
	$nilpot_03 = $row['kdpot_03'] * persen_pot('03') ;
	$nilpot_04 = $row['kdpot_04'] * persen_pot('04') ;
	$nilpot_05 = $row['kdpot_05'] * persen_pot('05') ;
	$nilpot_06 = $row['kdpot_06'] * persen_pot('06') ;
	$nilpot_07 = $row['kdpot_07'] * persen_pot('07') ;
	$nilpot_08 = $row['kdpot_08'] * persen_pot('08') ;
	
	$nilpot_31 = $row['kdpot_31'] * persen_pot('31') ;
	$nilpot_32 = $row['kdpot_32'] * persen_pot('32') ;
	$nilpot_33 = $row['kdpot_33'] * persen_pot('33') ;
	$nilpot_34 = $row['kdpot_34'] * persen_pot('34') ;
	
	$nilpot_21 = $row['kdpot_21'] * persen_pot('21') ;
	$nilpot_22 = $row['kdpot_22'] * persen_pot('22') ;
	
	$nilpot_40 = $row['kdpot_40'] * persen_pot('40') ;
	$nilpot_tk = $row['kdpot_tk'] * persen_pot('tk') ;
	$nilpot_cm = $row['kdpot_cm'] * persen_pot('cm') ;

	$totpot = $nilpot_10 + $nilpot_11 + $nilpot_12 + $nilpot_13 + $nilpot_14 + $nilpot_15 + $nilpot_16 +
				$nilpot_01 + $nilpot_02 + $nilpot_03 + $nilpot_04 + $nilpot_05 + $nilpot_06 + $nilpot_07 + $nilpot_08 +
				$nilpot_31 + $nilpot_32 + $nilpot_33 + $nilpot_34 + 
				$nilpot_21 + $nilpot_22 + $nilpot_40 + $nilpot_tk + $nilpot_cm ;
	
	if ( $row['kdpot_01'] <> 0 )   $arrPot_01    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_01']."\n".number_format($nilpot_01,"2",",",".").'%');
	if ( $row['kdpot_01'] == 0 )   $arrPot_01    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_02'] <> 0 )   $arrPot_02    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_02']."\n".number_format($nilpot_02,"2",",",".").'%');
	if ( $row['kdpot_02'] == 0 )   $arrPot_02    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_03'] <> 0 )   $arrPot_03    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_03']."\n".number_format($nilpot_03,"2",",",".").'%');
	if ( $row['kdpot_03'] == 0 )   $arrPot_03    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_04'] <> 0 )   $arrPot_04    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_04']."\n".number_format($nilpot_04,"2",",",".").'%');
	if ( $row['kdpot_04'] == 0 )   $arrPot_04    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_05'] <> 0 )   $arrPot_05    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_05']."\n".number_format($nilpot_05,"2",",",".").'%');
	if ( $row['kdpot_05'] == 0 )   $arrPot_05    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_06'] <> 0 )   $arrPot_06    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_06']."\n".number_format($nilpot_06,"2",",",".").'%');
	if ( $row['kdpot_06'] == 0 )   $arrPot_06    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_07'] <> 0 )   $arrPot_07    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_07']."\n".number_format($nilpot_07,"2",",",".").'%');
	if ( $row['kdpot_07'] == 0 )   $arrPot_07    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_08'] <> 0 )   $arrPot_08    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_08']."\n".number_format($nilpot_08,"2",",",".").'%');
	if ( $row['kdpot_08'] == 0 )   $arrPot_08    = $pdf->SplitToArray($w1[6],$ln,'');
	
	if ( $kdbulan == '03' )
	{
	if ( $row['kdpot_10'] <> 0 )   $arrPot_10    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_10'].'**)'."\n".number_format($nilpot_10,"2",",",".").'%');
	if ( $row['kdpot_10'] == 0 )   $arrPot_10    = $pdf->SplitToArray($w1[6],$ln,'');
	}else{
	if ( $row['kdpot_10'] <> 0 )   $arrPot_10    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_10']."\n".number_format($nilpot_10,"2",",",".").'%');
	if ( $row['kdpot_10'] == 0 )   $arrPot_10    = $pdf->SplitToArray($w1[6],$ln,'');
	}
	
	if ( $row['kdpot_11'] <> 0 )   $arrPot_11    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_11']."\n".number_format($nilpot_11,"2",",",".").'%');
	if ( $row['kdpot_11'] == 0 )   $arrPot_11    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_12'] <> 0 )   $arrPot_12    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_12']."\n".number_format($nilpot_12,"2",",",".").'%');
	if ( $row['kdpot_12'] == 0 )   $arrPot_12    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_13'] <> 0 )   $arrPot_13    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_13']."\n".number_format($nilpot_13,"2",",",".").'%');
	if ( $row['kdpot_13'] == 0 )   $arrPot_13    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_14'] <> 0 )   $arrPot_14    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_14']."\n".number_format($nilpot_14,"2",",",".").'%');
	if ( $row['kdpot_14'] == 0 )   $arrPot_14    = $pdf->SplitToArray($w1[6],$ln,'');

switch ( $kdbulan )
{
	case '01':
	if ( $row['kdpot_cm'] <> 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_cm']."\n".number_format($nilpot_cm,"2",",",".").'%');
	if ( $row['kdpot_cm'] == 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,'');
	break;
	
	case '02':
	if ( $row['kdpot_cm'] <> 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_cm']."\n".number_format($nilpot_cm,"2",",",".").'%');
	if ( $row['kdpot_cm'] == 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,'');
	break;
	
	case '03':
	if ( $row['kdpot_15'] <> 0 and $row['kdpot_cm'] <> 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_cm']."*)"."\n".number_format($nilpot_cm,"2",",",".").'%'."\n".$row['kdpot_15']."**)"."\n".number_format($nilpot_15,"2",",",".").'%');
	if ( $row['kdpot_15'] <> 0 and $row['kdpot_cm'] == 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_15']."**)"."\n".number_format($nilpot_15,"2",",",".").'%');
	if ( $row['kdpot_15'] == 0 and $row['kdpot_cm'] <> 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_cm']."**)"."\n".number_format($nilpot_cm,"2",",",".").'%');
	if ( $row['kdpot_15'] == 0 and $row['kdpot_cm'] == 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,'');
	break;

	default:
	if ( $row['kdpot_15'] <> 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_15']."\n".number_format($nilpot_15,"2",",",".").'%');
	if ( $row['kdpot_15'] == 0 )   $arrPot_15    = $pdf->SplitToArray($w1[6],$ln,'');
	break;
}	
	
	if ( $row['kdpot_16'] <> 0 )   $arrPot_16    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_16']."\n".number_format($nilpot_16,"2",",",".").'%');
	if ( $row['kdpot_16'] == 0 )   $arrPot_16    = $pdf->SplitToArray($w1[6],$ln,'');
	
	if ( $row['kdpot_21'] <> 0 )   $arrPot_21    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_21']."\n".number_format($nilpot_21,"2",",",".").'%');
	if ( $row['kdpot_21'] == 0 )   $arrPot_21    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_22'] <> 0 )   $arrPot_22    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_22']."\n".number_format($nilpot_22,"2",",",".").'%');
	if ( $row['kdpot_22'] == 0 )   $arrPot_22    = $pdf->SplitToArray($w1[6],$ln,'');
	
	if ( $row['kdpot_31'] <> 0 )   $arrPot_31    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_31']."\n".number_format($nilpot_31,"2",",",".").'%');
	if ( $row['kdpot_31'] == 0 )   $arrPot_31    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_32'] <> 0 )   $arrPot_32    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_32']."\n".number_format($nilpot_32,"2",",",".").'%');
	if ( $row['kdpot_32'] == 0 )   $arrPot_32    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_33'] <> 0 )   $arrPot_33    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_33']."\n".number_format($nilpot_33,"2",",",".").'%');
	if ( $row['kdpot_33'] == 0 )   $arrPot_33    = $pdf->SplitToArray($w1[6],$ln,'');
	if ( $row['kdpot_34'] <> 0 )   $arrPot_34    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_34']."\n".number_format($nilpot_34,"2",",",".").'%');
	if ( $row['kdpot_34'] == 0 )   $arrPot_34    = $pdf->SplitToArray($w1[6],$ln,'');
	
	if ( $row['kdpot_40'] <> 0 )   $arrPot_40    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_40']."\n".number_format($nilpot_40,"2",",",".").'%');
	if ( $row['kdpot_40'] == 0 )   $arrPot_40    = $pdf->SplitToArray($w1[6],$ln,'');

	if ( $kdbulan == '03' )
	{
	if ( $row['kdpot_tk'] <> 0 )   $arrPot_tk    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_tk'].'*)'."\n".number_format($nilpot_tk,"2",",",".").'%');
	if ( $row['kdpot_tk'] == 0 )   $arrPot_tk    = $pdf->SplitToArray($w1[6],$ln,'');
	}else{
	if ( $row['kdpot_tk'] <> 0 )   $arrPot_tk    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_tk']."\n".number_format($nilpot_tk,"2",",",".").'%');
	if ( $row['kdpot_tk'] == 0 )   $arrPot_tk    = $pdf->SplitToArray($w1[6],$ln,'');
	}
	
/*	if ( $kdbulan == '03' )
	{
	if ( $row['kdpot_cm'] <> 0 )   $arrPot_cm    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_cm'].'*)'."\n".number_format($nilpot_cm,"2",",",".").'%');
	if ( $row['kdpot_cm'] == 0 )   $arrPot_cm    = $pdf->SplitToArray($w1[6],$ln,'');
	}else{
	if ( $row['kdpot_cm'] <> 0 )   $arrPot_cm    = $pdf->SplitToArray($w1[6],$ln,$row['kdpot_cm']."\n".number_format($nilpot_cm,"2",",",".").'%');
	if ( $row['kdpot_cm'] == 0 )   $arrPot_cm    = $pdf->SplitToArray($w1[6],$ln,'');
	} */

	$arrTotPot    = $pdf->SplitToArray($w1[7],$ln, ''."\n".number_format($totpot,"2",",",".").'%' );

//	if ($max<count($arrNama)) $max=count($arrNama);
//	if ($max<count($arrUnit)) $max=count($arrUnit);
	if ( $kdbulan == '03' and $row['kdpot_cm'] <> 0)
	{
		$max = 5 ;
	}else{
		$max = 3 ;
	}
	
	$kdunit = $row['kdunitkerja'] ;
	for($i=0;$i<=$max;$i++)
	{
	
		
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrUnit[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrNama[$i],'LR',0,'L');
		
		if ( $i < 2 )     # baris 1 dan 2
		{
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrPot_10[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[6],$ln,$arrPot_01[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*2);
		$pdf->Cell($w1[6],$ln,$arrPot_02[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*3);
		$pdf->Cell($w1[6],$ln,$arrPot_31[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*4);
		$pdf->Cell($w1[6],$ln,$arrPot_32[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*5);
		$pdf->Cell($w1[6],$ln,$arrPot_05[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*6);
		$pdf->Cell($w1[6],$ln,$arrPot_06[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*7);
		$pdf->Cell($w1[6],$ln,$arrPot_11[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*8);
		$pdf->Cell($w1[6],$ln,$arrPot_13[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*9);
		$pdf->Cell($w1[6],$ln,$arrPot_16[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*10);
		$pdf->Cell($w1[6],$ln,$arrPot_21[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*11);
		$pdf->Cell($w1[6],$ln,$arrPot_40[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*12);
		$pdf->Cell($w1[7],$ln,$arrTotPot[$i],'LR',1,'C');
		
		// ini garis tengah
		if ( $i == 1 ) 	
		{
			$pdf->SetDash(1, 1);
			$pdf->Line($margin+$w1[0]+$w1[1]+$w1[2]+$w1[6], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*11,$pdf->GetY());
			$pdf->SetDash();
		}
		
		}elseif ( $i >= 2 and $i < 4 )  {		# ini baris ke 3 dan 4

		$j = $i-2 ;

		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrPot_tk[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[6],$ln,$arrPot_03[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*2);
		$pdf->Cell($w1[6],$ln,$arrPot_04[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*3);
		$pdf->Cell($w1[6],$ln,$arrPot_33[$j],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*4);
		$pdf->Cell($w1[6],$ln,$arrPot_34[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*5);
		$pdf->Cell($w1[6],$ln,$arrPot_07[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*6);
		$pdf->Cell($w1[6],$ln,$arrPot_08[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*7);
		$pdf->Cell($w1[6],$ln,$arrPot_12[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*8);
		$pdf->Cell($w1[6],$ln,$arrPot_14[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*9);
		$pdf->Cell($w1[6],$ln,$arrPot_15[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*10);
		$pdf->Cell($w1[6],$ln,$arrPot_22[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*11);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*12);
		$pdf->Cell($w1[7],$ln,'','LR',1,'C');
		}
		
		if ( $i >= 4 and $kdbulan == '03')
		{
		$j = $i-2 ;
//		$k = $i-4 ;
		
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*2);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*3);
		$pdf->Cell($w1[6],$ln,'','LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*4);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*5);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*6);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*7);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*8);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*9);
		$pdf->Cell($w1[6],$ln,$arrPot_15[$j],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*10);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*11);
		$pdf->Cell($w1[6],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[6]*12);
		$pdf->Cell($w1[7],$ln,'','LR',1,'C');
		}
		
	  if($pdf->GetY() >= 185 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }
	}
	
	  if($pdf->GetY() >= 175 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }
	 
	}		
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	
	  if($pdf->GetY() >= 180 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]*12+$w1[7],$pdf->GetY());
	 }
//	 }
	$pdf->SetFont($font,'',$size-3);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Dicetak tgl. '.date ('d-m-Y H:i:s'),'',1,'L');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'','',1,'L');
	
	if ( $kdbulan == '03' )
	{
	$pdf->SetFont($font,'',$size-1);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Catatan: ','',1,'L');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'*) Berdasarkan Perka No.216 Tahun 2012','',1,'L');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'**) Berdasarkan Perka No.3 Tahun 2013','',1,'L');
	}
	
	//------------ Tanda Tangan ----
	if ( $pdf->GetY() >= 150 ){
	 	$pdf->AddPage();
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3,$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$ln*2,'Jumlah Seluruhnya','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',1,'R');
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3,$pdf->GetY());
	}
	$pdf->Ln()+20;
	$w1 = array(15,60,30,60,30,60,10);
	$pdf->SetFont($font,'',$size);
	
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,kota_satker($kdsatker).', '.reformat_tanggal($tgl),'',1,'C');

	$max = 0 ;
	$arrJabatan_1	 = $pdf->SplitToArray($w1[1],$ln,'Mengetahui,');
	$arrJabatan_2	 = $pdf->SplitToArray($w1[3],$ln,'Menyetujui,');
	$arrJabatan_3	 = $pdf->SplitToArray($w1[5],$ln,'Disusun oleh,');

	if ($max<count($arrJabatan_1)) $max=count($arrJabatan_1);
	if ($max<count($arrJabatan_2)) $max=count($arrJabatan_2);
	if ($max<count($arrJabatan_3)) $max=count($arrJabatan_3);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrJabatan_1[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrJabatan_2[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrJabatan_3[$i],'',1,'C');
	}
	
	$max = 0 ;
	$arrJabatan_1	 = $pdf->SplitToArray($w1[1],$ln,'.........................................');
	$arrJabatan_2	 = $pdf->SplitToArray($w1[3],$ln,'.........................................');
	$arrJabatan_3	 = $pdf->SplitToArray($w1[5],$ln,'.........................................');

	if ($max<count($arrJabatan_1)) $max=count($arrJabatan_1);
	if ($max<count($arrJabatan_2)) $max=count($arrJabatan_2);
	if ($max<count($arrJabatan_3)) $max=count($arrJabatan_3);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrJabatan_1[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrJabatan_2[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrJabatan_3[$i],'',1,'C');
	}
	
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*3,'','',1,'C');

	$max = 0 ;
	$arrNama_1	 = $pdf->SplitToArray($w1[1],$ln,'( ........................................ )');
	$arrNama_2	 = $pdf->SplitToArray($w1[3],$ln,'( ........................................ )');
	$arrNama_3	 = $pdf->SplitToArray($w1[5],$ln,'( ........................................ )');

	if ($max<count($arrNama_1)) $max=count($arrNama_1);
	if ($max<count($arrNama_2)) $max=count($arrNama_2);
	if ($max<count($arrNama_3)) $max=count($arrNama_3);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrNama_1[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNama_2[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrNama_3[$i],'',1,'C');
	}

	$max = 0 ;
	$arrNip_1	 = $pdf->SplitToArray($w1[1],$ln,'NIP. ...............................');
	$arrNip_2	 = $pdf->SplitToArray($w1[3],$ln,'NIP. ...............................');
	$arrNip_3	 = $pdf->SplitToArray($w1[5],$ln,'NIP. ...............................');

	if ($max<count($arrNip_1)) $max=count($arrNip_1);
	if ($max<count($arrNip_2)) $max=count($arrNip_2);
	if ($max<count($arrNip_3)) $max=count($arrNip_3);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrNip_1[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrNip_2[$i],'',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrNip_3[$i],'',1,'C');
	}
	
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');



?>