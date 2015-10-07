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
	$size = 10;
	$ln = 5;
	$margin = 5;
	$tinggi = 275 ;
	$w = array(0,280);
	$this->Ln();
	$this->SetFont($font,'B',$size+2);
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,'PETA JABATAN','',1,'C');
	$this->SetX($margin+$w[0]);
	$this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit.'00'))),'',1,'C');
	$this->Ln()*2;
	
	$w1 = array(10,40,45,8,8,40,10,35,35,35,12);
	$this->SetFont($font,'B',$size);
	$this->SetX($margin);
	$this->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
	$this->SetX($margin+$w1[0]);
	$this->Cell($w1[1],$ln*2,'Unit Kerja',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]);
	$this->Cell($w1[2],$ln*2,'Nama Jabatan',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$y = $this->GetY();
	$this->Cell($w1[3]+$w1[4],$ln,'Jumlah',$border,1,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$this->Cell($w1[3],$ln,'(J1)',$border,0,'C');
	$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$this->Cell($w1[4],$ln,'(J2)',$border,0,'C');
	$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y);
	$this->Cell($w1[0],$ln*2,'SEL',$border,0,'C');
	$this->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
	$this->Cell($w1[5],$ln*2,'Nama Pegawai',$border,0,'C');
	$this->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
	$this->Cell($w1[6],$ln*2,'Gol.',$border,0,'C');
	$this->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
	$this->Cell($w1[7]+$w1[8]+$w1[9],$ln,'Jabatan Pegawai',$border,0,'C');
	$y = $this->GetY();
	$this->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+5);
	$this->Cell($w1[7],$ln,'Struktural',$border,0,'C');
	$this->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$y+5);
	$this->Cell($w1[8],$ln,'Fungsional',$border,0,'C');
	$this->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y+5);
	$this->Cell($w1[9],$ln,'Umum',$border,0,'C');
	$this->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9],$y);
	$this->Cell($w1[10],$ln*2,'Grade',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 5;
	$tinggi = 275 ;
	$w = array(0,280);
/*	$pdf->Ln();
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'PETA JABATAN','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit.'00'))),'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(10,40,45,8,8,40,10,35,35,35,12);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln*2,'Unit Kerja',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln*2,'Nama Jabatan',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$y = $pdf->GetY();
	$pdf->Cell($w1[3]+$w1[4],$ln,'Jumlah',$border,1,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$pdf->Cell($w1[3],$ln,'(J1)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$pdf->Cell($w1[4],$ln,'(J2)',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y);
	$pdf->Cell($w1[0],$ln*2,'SEL',$border,0,'C');
	$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
	$pdf->Cell($w1[5],$ln*2,'Nama Pegawai',$border,0,'C');
	$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
	$pdf->Cell($w1[6],$ln*2,'Gol.',$border,0,'C');
	$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
	$pdf->Cell($w1[7]+$w1[8]+$w1[9],$ln,'Jabatan Pegawai',$border,0,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+5);
	$pdf->Cell($w1[7],$ln,'Struktural',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$y+5);
	$pdf->Cell($w1[8],$ln,'Fungsional',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y+5);
	$pdf->Cell($w1[9],$ln,'Umum',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9],$y);
	$pdf->Cell($w1[10],$ln*2,'Grade',$border,1,'C');
*/	$pdf->SetFont($font,'',$size-2);
	$w1 = array(10,40,45,8,8,40,10,35,35,35,12);
	$no = 0 ;
	$sql = "SELECT * FROM mst_skp WHERE left(kdunitkerja,2) = '$kdunit' ORDER BY kdunitkerja,kdjabatan,kdgol";
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	if ( $row['kdunitkerja'] <> $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,trim(nm_unitkerja($row['kdunitkerja'])));
	if ( $row['kdunitkerja'] == $kdunitkerja )   $arrUnit = $pdf->SplitToArray($w1[1],$ln,'');
	if ( $row['kdunitkerja'] <> $kdunitkerja and $row['kdjabatan'] <> $kdjabatan )       $arrJabatan   = $pdf->SplitToArray($w1[2],$ln,nm_info_jabatan($row['kdunitkerja'],$row['kdjabatan']));
	if ( $row['kdunitkerja'] == $kdunitkerja and $row['kdjabatan'] <> $kdjabatan )       $arrJabatan   = $pdf->SplitToArray($w1[2],$ln,nm_info_jabatan($row['kdunitkerja'],$row['kdjabatan']));
	if ( $row['kdunitkerja'] == $kdunitkerja and $row['kdjabatan'] == $kdjabatan )       $arrJabatan   = $pdf->SplitToArray($w1[2],$ln,'');
	if ( $row['kdjabatan'] <> $kdjabatan )       $arrJumlah	  = $pdf->SplitToArray($w1[3],$ln,jml_info_jabatan($row['kdunitkerja'],$row['kdjabatan']));
	if ( $row['kdjabatan'] == $kdjabatan )       $arrJumlah   = $pdf->SplitToArray($w1[3],$ln,'');
	$arrNama	  = $pdf->SplitToArray($w1[5],$ln,nama_peg($row['nib'])."\n".'NIP. '.reformat_nipbaru(nip_peg($row['nib'])));
	$arrGol	      = $pdf->SplitToArray($w1[6],$ln,nm_gol($row['kdgol']));
	$arrGrade	  = $pdf->SplitToArray($w1[10],$ln,$row['grade']);
	if ( $row['kdjabatan'] <> $kdjabatan )		$arrJ2	  	  = $pdf->SplitToArray($w1[10],$ln,jml_j2($row['kdunitkerja'],$row['kdjabatan']));
	if ( $row['kdjabatan'] == $kdjabatan )		$arrJ2	  	  = $pdf->SplitToArray($w1[10],$ln,'');
	$tanda = jml_j2($row['kdunitkerja'],$row['kdjabatan']) - jml_info_jabatan($row['kdunitkerja'],$row['kdjabatan']) ;
	if ( $tanda >= 1 )  $xtanda = '+';
	if ( $tanda <= 0 )  $xtanda = '';
	if ( $row['kdjabatan'] <> $kdjabatan )		$arrSelisih	  = $pdf->SplitToArray($w1[10],$ln,$xtanda.$tanda);
	if ( $row['kdjabatan'] == $kdjabatan )		$arrSelisih	  = $pdf->SplitToArray($w1[10],$ln,'');

if ( kdeselon_peg($row['nib']) <> '' )
{
	$arrJabPeg_S	  = $pdf->SplitToArray($w1[7],$ln,jabstruk_peg($row['nib']));
	$arrJabPeg_F	  = $pdf->SplitToArray($w1[8],$ln,'');
	$arrJabPeg_U	  = $pdf->SplitToArray($w1[9],$ln,'');
}elseif( jabatan_peg($row['nib']) <> '' ){
	$arrJabPeg_S	  = $pdf->SplitToArray($w1[7],$ln,'');
	$arrJabPeg_F	  = $pdf->SplitToArray($w1[8],$ln,jabatan_peg($row['nib']));
	$arrJabPeg_U	  = $pdf->SplitToArray($w1[9],$ln,'');
}else{
	$arrJabPeg_S	  = $pdf->SplitToArray($w1[7],$ln,'');
	$arrJabPeg_F	  = $pdf->SplitToArray($w1[8],$ln,'');
	$arrJabPeg_U	  = $pdf->SplitToArray($w1[9],$ln,nm_info_jabatan($row['kdunitkerja'],$row['kdjabatan']));
}	


	$kdunitkerja = $row['kdunitkerja'];
	$kdjabatan   = $row['kdjabatan'];

	if ($max<count($arrUnit)) $max=count($arrUnit);
	if ($max<count($arrJabatan)) $max=count($arrJabatan);
	if ($max<count($arrNama)) $max=count($arrNama);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrUnit[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrJabatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrJumlah[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrJ2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[0],$ln,$arrSelisih[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrNama[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrGol[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,$arrJabPeg_S[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln,$arrJabPeg_F[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
		$pdf->Cell($w1[9],$ln,$arrJabPeg_U[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]);
		$pdf->Cell($w1[10],$ln,$arrGrade[$i],'LR',1,'C');
	}
		$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]+$w1[10],$pdf->GetY());
	    if($pdf->GetY() >= 180 )
		{
		$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]+$w1[10],$pdf->GetY());
		$pdf->AddPage();	
		$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]*2+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]+$w1[10],$pdf->GetY());
	    }
	}
	$pdf->SetFont($font,'',$size-3);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Dicetak tgl. '.date ('d-m-Y H:i:s'),'',1,'L');
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>