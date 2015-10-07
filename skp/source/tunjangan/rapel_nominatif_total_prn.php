<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
			$th = $_REQUEST['th'];
			$kdbulan1 = $_REQUEST['kdbulan1'];
			$kdbulan2 = $_REQUEST['kdbulan2'];
			$kdsatker = $_REQUEST['kdsatker'];
			if ( substr($kdbulan1,0,1) == '0' ) $kdbl1 = substr($kdbulan1,1,1) ;
			else $kdbl1 = $kdbulan1 ;
			if ( substr($kdbulan2,0,1) == '0' ) $kdbl2 = substr($kdbulan2,1,1) ;
			else $kdbl2 = $kdbulan2 ;
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 5;
			$margin = 30;
			$tinggi = 275 ;
			$w = array(0,220);
			$this->SetFont($font,'B',$size+2);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'BADAN TENAGA NUKLIR NASIONAL','',1,'L');
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,strtoupper(trim(nm_satker($kdsatker))),'',1,'L');
			$this->Ln();
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'REKAPITULASI DAFTAR PEMBAYARAN TUNJANGAN KINERJA PEGAWAI','',1,'C');
			// bagian lampiran
			$pos_x = $this->GetX();
			$pos_y = $this->GetY();
			$this->SetXY(245,4);
			$this->SetFont($font,'B',$size-2);
			$this->Cell(75,$ln-2,'LAMPIRAN III','',1,'L');
			$this->SetX(158);
			$this->Cell(150,$ln-2,'PERATURAN DIREKTUR JENDERAL PERBENDAHARAAN NO. PER.52/PB/2012','',1,'L');
			$this->SetX(158);
			$this->Cell(150,$ln-2,'TENTANG PETUNJUK PELAKSANAAN PEMBAYARAN TUNJANGAN KINERJA','',1,'L');
			$this->SetX(158);
			$this->Cell(150,$ln-2,'PADA 20 (DUA PULUH) KEMENTRIAN NEGARA/LEMBAGA','',1,'L');
			$this->SetXY($pos_x, $pos_y);
			//
			$this->SetX($margin+$w[0]);
			if ( $kdbulan2 <> 13 )  $this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl1)).' S/D '.strtoupper(nama_bulan($kdbl2)).' '.$th,'',1,'C');
			else $this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl1)).' DAN BULAN '.strtoupper(nama_bulan($kdbl2)).' TAHUN '.$th,'',1,'C');
			$ln = 4 ;
			$w1 = array(10,50,35,40,50,5);
			$this->SetFont($font,'B',$size);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*3,'NO.',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$this->Cell($w1[1],$ln*3,'Uraian Kelas Jabatan',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]);
			$this->Cell($w1[2],$ln*3,'Jumlah Penerima',$border,0,'C');
			$y = $this->GetY();
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+2);
			$this->Cell($w1[3],$ln,'Tunjangan Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+6);
			$this->Cell($w1[3],$ln,'Per Kelas Jabatan',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
			$this->Cell($w1[3],$ln*3,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5],$y);
			$this->Cell($w1[4],$ln,'1. Jumlah Tunjangan',$noborder,0,'L');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5],$y+4);
			$this->Cell($w1[4],$ln,'2. Pajak',$noborder,0,'L');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5],$y+8);
			$this->Cell($w1[4],$ln,'3. Jumlah',$noborder,0,'L');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y);
			$this->Cell($w1[4],$ln*3,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y);
			$this->Cell($w1[4],$ln,'1. Faktor Pengurang',$noborder,1,'L');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+4);
			$this->Cell($w1[4],$ln,'2. Potongan Pajak',$noborder,1,'L');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+8);
			$this->Cell($w1[4],$ln,'3. Jumlah Netto',$noborder,1,'L');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y);
			$this->Cell($w1[4],$ln*3,'',$border,1,'C');
			$this->SetFont($font,'B',$size-2);
			
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$th = $_REQUEST['th'];
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
	$kdsatker = $_REQUEST['kdsatker'];
	$tgl = $_POST['tgl'] ;
	$ket = $_POST['ket'] ;
	if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
	if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
	$th = $_REQUEST['th'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 6;
	$margin = 30;
	$tinggi = 275 ;
	$w1 = array(10,50,35,40,50,7);
//	$w1 = array(10,50,35,35,35);
	$pdf->SetFont($font,'',$size-1);
    
	$xx = 0 ;
	$no = 0 ;
	$ln = 3.5 ;
	if ( $kdbulan1 <= 9 )   $kdbulan1 = '0'.$kdbulan1 ;
	else  $kdbulan1 = $kdbulan1 ;
	if ( $kdbulan2 <= 9 )   $kdbulan2 = '0'.$kdbulan2 ;
	else  $kdbulan2 = $kdbulan2 ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM mst_tk WHERE tahun = '$th' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' and kdsatker = '$kdsatker' GROUP BY grade ORDER BY grade desc");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	$nilGrade  	  = rp_grade($kdunit,$row['grade'],1) ;
	$total_tunker += $row['jml_tunker'] ;
	$total_pajak  += $row['jml_pajak'] ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrGrade	  = $pdf->SplitToArray($w1[1],$ln,'Kelas Jabatan '.$row['grade']);
	if ( $nilGrade * $row['jumlah'] <> $row['jml_tunker'] and $ket=="Y")
	{
		  $arrPenerima  = $pdf->SplitToArray($w1[2],$ln,number_format($row['jumlah'],"0",",",".").' (*)');
		  $xx = 1 ;
	}else{
	    $arrPenerima  = $pdf->SplitToArray($w1[2],$ln,number_format($row['jumlah'],"0",",","."));
	}
	$arrUrut  	  = $pdf->SplitToArray($w1[5],$ln,'1.'."\n".'2.'."\n".'3.');
	$arrTunker    = $pdf->SplitToArray($w1[3],$ln,number_format($nilGrade,"0",",","."));
	$arrJmlTunker = $pdf->SplitToArray($w1[4]-$w1[5],$ln,number_format($row['jml_tunker'],"0",",",".")."\n".number_format($row['jml_pajak'],"0",",",".")."\n".number_format(($row['jml_tunker']+$row['jml_pajak']),"0",",","."));
//	$arrJmlPajak  = $pdf->SplitToArray($w1[4],$ln,number_format($row['jml_pajak'],"0",",","."));
	$arrJumlah    = $pdf->SplitToArray($w1[4],$ln,number_format(0,"0",",",".")."\n".number_format($row['jml_pajak'],"0",",",".")."\n".number_format($row['jml_tunker'],"0",",","."));
	
	
	
	if ($max<count($arrJmlTunker)) $max=count($arrJmlTunker);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		if ( $i == 1 )  $pdf->Cell($w1[0],$ln,$arrNo[$i-1],'LR',0,'C');
		else   $pdf->Cell($w1[0],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		if ( $i == 1 )  $pdf->Cell($w1[1],$ln,$arrGrade[$i-1],'LR',0,'L');
		else   $pdf->Cell($w1[1],$ln,'','LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		if ( $i == 1 )  $pdf->Cell($w1[2],$ln,$arrPenerima[$i-1],'LR',0,'C');
		else   $pdf->Cell($w1[2],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		if ( $i == 1 )  $pdf->Cell($w1[3],$ln,$arrTunker[$i-1],'LR',0,'R');
		else  $pdf->Cell($w1[3],$ln,'','LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[5],$ln,$arrUrut[$i],'L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,$arrJmlTunker[$i],'R',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrUrut[$i],'L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,$arrJumlah[$i],'R',1,'R');
	}
	  if($pdf->GetY() >= 150 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2,$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2,$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2,$pdf->GetY());
	 }
	}


	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2,$pdf->GetY());
	$pdf->SetFont($font,'B',$size-1);
	
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,'','LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[5],$ln,'1.','L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,number_format($total_tunker,"0",",","."),'R',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,'1.','L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,number_format('',"0",",","."),'R',1,'R');

		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,'Jumlah','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[5],$ln,'2.','L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,number_format($total_pajak,"0",",","."),'R',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,'2.','L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,number_format($total_pajak,"0",",","."),'R',1,'R');

		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,'','LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[5],$ln,'3.','L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,number_format($total_tunker + $total_pajak,"0",",","."),'R',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,'3.','L',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[4]-$w1[5],$ln,number_format($total_tunker,"0",",","."),'R',1,'R');
		$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2,$pdf->GetY());
//------------ Catatan
	if ( $xx == 1 and $ket=="Y") {
	$pdf->SetFont($font,'',$size-2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'Catatan :','',1,'L');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'(*) Jumlah penerima yang tertera pada isian ini, beberapa pegawai tidak menerima Tunjangan Kinerja 1 bulan penuh','',1,'L');
	}
	
//------------ Tanda Tangan ----
	$ln = 4 ;
	$w1 = array(5,60,25,60,25,60,10);
	$pdf->SetFont($font,'',$size);
	
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,kota_satker($kdsatker).', '.reformat_tanggal($tgl),'',1,'C');

	$max = 0 ;
	$arrJabatan_1	 = $pdf->SplitToArray($w1[1],$ln,'Kuasa Pengguna Anggaran');
	$arrJabatan_2	 = $pdf->SplitToArray($w1[3],$ln,'Pejabat Pembuat Komitmen');
	$arrJabatan_3	 = $pdf->SplitToArray($w1[5],$ln,'Bendahara Pengeluaran');

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
	$arrNama_1	 = $pdf->SplitToArray($w1[1],$ln,trim(nama_peg(nib_pejabat($th,$kdsatker,'1'))));
	$arrNama_2	 = $pdf->SplitToArray($w1[3],$ln,trim(nama_peg(nib_pejabat($th,$kdsatker,'2'))));
	$arrNama_3	 = $pdf->SplitToArray($w1[5],$ln,trim(nama_peg(nib_pejabat($th,$kdsatker,'3'))));

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
	$arrNip_1	 = $pdf->SplitToArray($w1[1],$ln,'NIP. '.reformat_nipbaru(nip_peg(nib_pejabat($th,$kdsatker,'1'))));
	$arrNip_2	 = $pdf->SplitToArray($w1[3],$ln,'NIP. '.reformat_nipbaru(nip_peg(nib_pejabat($th,$kdsatker,'2'))));
	$arrNip_3	 = $pdf->SplitToArray($w1[5],$ln,'NIP. '.reformat_nipbaru(nip_peg(nib_pejabat($th,$kdsatker,'3'))));

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