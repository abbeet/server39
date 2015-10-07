<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
			$kdunit = $_REQUEST['kdunit'];
			$kdbulan = $_REQUEST['kdbulan'];
			$kdsatker = $_REQUEST['kdsatker'];
			$th = $_REQUEST['th'];
			if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
			if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
			$th = $_REQUEST['th'];
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 5;
			$margin = 10;
			$tinggi = 275 ;
			$w = array(0,250);
			$this->SetFont($font,'B',$size+3);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'BADAN TENAGA NUKLIR NASIONAL','',1,'L');
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,strtoupper(trim(nm_satker($kdsatker))),'',1,'L');
			$this->Ln();
			$this->SetFont($font,'B',$size+2);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'REKAPITULASI DAFTAR PENERIMAAN TUNJANGAN KINERJA PEGAWAI','',1,'C');
			$this->SetX($margin+$w[0]);
			if ( $kdbl <> 13 )   $this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl)).' '.$th,'',1,'C');
			if ( $kdbl == 13 )   $this->Cell($w[1],$ln,'BULAN : '.nama_bulan($kdbl).' TAHUN '.$th,'',1,'C');
			$this->Ln()+5;
	
			$ln = 4 ;
			$w1 = array(10,30,20,32,22,32);
			$this->SetFont($font,'B',$size-1);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*3,'NO.',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$this->Cell($w1[1],$ln*3,'Kelas Jabatan',$border,0,'C');
			$y = $this->GetY();
			$this->SetXY($margin+$w1[0]+$w1[1],$y+2);
			$this->Cell($w1[2],$ln,'Jumlah',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y+6);
			$this->Cell($w1[2],$ln,'Penerima',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y);
			$this->Cell($w1[2],$ln*3,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+2);
			$this->Cell($w1[3],$ln,'Tunjangan Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+6);
			$this->Cell($w1[3],$ln,'Per Kelas Jabatan',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
			$this->Cell($w1[3],$ln*3,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+2);
			$this->Cell($w1[5],$ln,'Tunjangan Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+6);
			$this->Cell($w1[5],$ln,'Sebelum Pajak',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5],$y+2);
			$this->Cell($w1[4],$ln,'Tunjangan',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5],$y+6);
			$this->Cell($w1[4],$ln,'Pajak',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5],$y);
			$this->Cell($w1[4],$ln*3,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y);
			$this->Cell($w1[5],$ln,'Tunjangan Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+4);
			$this->Cell($w1[5],$ln,'Setelah Ditambah',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+8);
			$this->Cell($w1[5],$ln,'Tunjangan Pajak',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');
			
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
			$this->Cell($w1[4]*3,$ln,'POTONGAN',$border,1,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
			$this->Cell($w1[4],$ln*2,'Pajak',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2+$w1[5]*2);
			$this->Cell($w1[4],$ln*2,'Pengurang',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*3+$w1[5]*2,$y+4);
			$this->Cell($w1[4],$ln,'Jumlah',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*3+$w1[5]*2,$y+8);
			$this->Cell($w1[4],$ln,'Potongan',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*3+$w1[5]*2,$y+4);
			$this->Cell($w1[4],$ln*2,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*2,$y+2);
			$this->Cell($w1[5],$ln,'Tunjangan Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*2,$y+6);
			$this->Cell($w1[5],$ln,'Yang Diterima',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*2,$y);
			$this->Cell($w1[5],$ln*3,'',$border,1,'C');

			$this->SetFont($font,'B',$size-2);
			
			$this->SetX($margin);
			$this->Cell($w1[0],$ln,'(1)',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$this->Cell($w1[1],$ln,'(2)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]);
			$this->Cell($w1[2],$ln,'(3)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
			$this->Cell($w1[3],$ln,'(4)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
			$this->Cell($w1[5],$ln,'(5)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
			$this->Cell($w1[4],$ln,'(6)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[5],$ln,'(7=5+6)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
			$this->Cell($w1[4],$ln,'(8)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2+$w1[5]*2);
			$this->Cell($w1[4],$ln,'(9)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*3+$w1[5]*2);
			$this->Cell($w1[4],$ln,'(10=8+9)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*2);
			$this->Cell($w1[5],$ln,'(11=7-10)',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
	$kdsatker = $_REQUEST['kdsatker'];
	if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
	if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
	$th = $_REQUEST['th'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 6;
	$margin = 10;
	$tinggi = 275 ;
	$w1 = array(10,30,20,32,22,32);
	$pdf->SetFont($font,'',$size-1);
    
	$xx = 0 ;
	$no = 0 ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM mst_tk WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' GROUP BY grade ORDER BY grade desc");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	$nilGrade  	  = rp_grade($kdunit,$row['grade'],1) ;
	$total_tunker += $row['jml_tunker'] ;
	$total_pajak  += $row['jml_pajak'] ;
	$total_terima += $row['jml_terima'];
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrGrade	  = $pdf->SplitToArray($w1[1],$ln,'Kelas Jabatan '.$row['grade']);
	if ( $nilGrade * $row['jumlah'] <> $row['jml_tunker'] )
	{
		  $arrPenerima  = $pdf->SplitToArray($w1[2],$ln,number_format($row['jumlah'],"0",",",".").' (*)');
		  $xx = 1 ;
	}else{
	    $arrPenerima  = $pdf->SplitToArray($w1[2],$ln,number_format($row['jumlah'],"0",",","."));
	}
	$arrTunker    = $pdf->SplitToArray($w1[3],$ln,number_format($nilGrade,"0",",","."));
	$arrJmlTunker = $pdf->SplitToArray($w1[5],$ln,number_format($row['jml_tunker'],"0",",","."));
	$arrJmlPajak  = $pdf->SplitToArray($w1[4],$ln,number_format($row['jml_pajak'],"0",",","."));
	$arrJumlah    = $pdf->SplitToArray($w1[5],$ln,number_format(($row['jml_tunker']+$row['jml_pajak']),"0",",","."));
	$arrTerima    = $pdf->SplitToArray($w1[5],$ln,number_format($row['jml_terima'],"0",",","."));
	$arrPengurang    = $pdf->SplitToArray($w1[5],$ln,number_format(($row['jml_tunker'] - $row['jml_terima']),"0",",","."));
	$arrPotong    = $pdf->SplitToArray($w1[5],$ln,number_format(($row['jml_tunker'] - $row['jml_terima'] + $row['jml_pajak']),"0",",","."));

	if ($max<count($arrGrade)) $max=count($arrGrade);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrGrade[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrPenerima[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrTunker[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[5],$ln,$arrJmlTunker[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
		$pdf->Cell($w1[4],$ln,$arrJmlPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln,$arrJumlah[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[4],$ln,$arrJmlPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2+$w1[5]*2);
		$pdf->Cell($w1[4],$ln,$arrPengurang[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*3+$w1[5]*2);
		$pdf->Cell($w1[4],$ln,$arrPotong[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*2);
		$pdf->Cell($w1[5],$ln,$arrTerima[$i],'LR',1,'R');
	}
	  if($pdf->GetY() >= 180 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*3,$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*3,$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*3,$pdf->GetY());
	 }
	}

	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1],$ln*2,'Jumlah','LR',0,'C');
		$pdf->Cell($w1[2],$ln*2,jmlpeg_bulan($th,$kdbulan,$kdsatker),'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[5]);
		$pdf->Cell($w1[4],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[4],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*2+$w1[5]*2);
		$pdf->Cell($w1[4],$ln*2,number_format($total_tunker - $total_terima,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*3+$w1[5]*2);
		$pdf->Cell($w1[4],$ln*2,number_format($total_tunker - $total_terima + $total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format($total_terima,"0",",","."),'LR',1,'R');
	 $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]*4+$w1[5]*3,$pdf->GetY());
	
	if ( $xx == 1 ) {
//	$pdf->Ln() + 1 ;
	$pdf->SetFont($font,'',$size-2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln-2,'Catatan :','',1,'L');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln-2,'(*) Jumlah penerima yang tertera pada isian ini, beberapa pegawai tidak menerima Tunjangan Kinerja 1 bulan penuh','',1,'L');
	}
	
//------------ Tanda Tangan ----
	$ln = 4 ;
	$pdf->Ln()+20;
	$w1 = array(20,60,25,60,25,60,10);
	$pdf->SetFont($font,'',$size);
	
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,kota_satker($kdsatker).', '.reformat_tanggal(date('Y-m-d')),'',1,'C');

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
		$pdf->Cell($w1[5],$ln*4,'','',1,'C');

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