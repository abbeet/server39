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
			if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
			if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
			$th = $_REQUEST['th'];
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 4;
			$margin = 15;
			$tinggi = 275 ;
			$w = array(0,280);
			$this->SetFont($font,'B',$size+3);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln+1,'BADAN TENAGA NUKLIR NASIONAL','',1,'L');
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln+1,strtoupper(trim(nm_satker($kdsatker))),'',1,'L');
			$this->SetFont($font,'B',$size+2);
			$this->Ln()+5;
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln+1,'DAFTAR NOMINATIF PEMBAYARAN TUNJANGAN KINERJA PEGAWAI','',1,'C');
			$this->SetX($margin+$w[0]);
			if ( $kdbl <> 13 ) $this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl)).' '.$th,'',1,'C');
			if ( $kdbl == 13 ) $this->Cell($w[1],$ln,'BULAN : '.nama_bulan($kdbl).' TAHUN '.$th,'',1,'C');
	
			$this->SetY(28);
			$this->SetFont($font,'',$size-3);
			$this->Cell(0, 8, 'Hal. ' . $this->PageNo(),0,1,'R');

			$w1 = array(10,50,12,40,10,30);
			$this->SetFont($font,'B',$size);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*3,'NO.',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$y = $this->GetY();
			$this->Cell($w1[1],$ln,'Nama Pegawai',$noborder,0,'C');
			$this->SetXY($margin+$w1[0],$y+4);
			$this->Cell($w1[1],$ln,'NIP',$noborder,0,'C');
			$this->SetXY($margin+$w1[0],$y);
			$this->Cell($w1[1],$ln*3,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y+2);
			$this->Cell($w1[2],$ln,'Gol /',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y+6);
			$this->Cell($w1[2],$ln,'Status',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y);
			$this->Cell($w1[2],$ln*3,'',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
			$this->Cell($w1[3],$ln*3,'Nama Jabatan / TMT',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+2);
			$this->Cell($w1[4],$ln,'Kls.',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+6);
			$this->Cell($w1[4],$ln,'Jab.',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y);
			$this->Cell($w1[4],$ln*3,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+4);
			$this->Cell($w1[5],$ln,'Tunj. Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+4);
			$this->Cell($w1[5],$ln,'Fakt. Pengurang',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y);
			$this->Cell($w1[5],$ln,'Tunj. Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y+4);
			$this->Cell($w1[5],$ln,'Dikurangi',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y+8);
			$this->Cell($w1[5],$ln,'Fakt.Pengurang',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');

			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
			$this->Cell($w1[5],$ln*3,'Tunj. Pajak',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4,$y);
			$this->Cell($w1[5],$ln,'Tunj. Kinerja',$noborder,1,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4,$y+4);
			$this->Cell($w1[5],$ln,'Ditambah',$noborder,1,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4,$y+8);
			$this->Cell($w1[5],$ln,'Tunjangan Pajak',$noborder,1,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4,$y);
			$this->Cell($w1[5],$ln*3,'',$border,1,'C');

			$this->SetFont($font,'B',$size-2);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln,'(1)',$border,0,'C');
			$this->Cell($w1[1],$ln,'(2)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]);
			$this->Cell($w1[2],$ln,'(3)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
			$this->Cell($w1[3],$ln,'(4)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
			$this->Cell($w1[4],$ln,'(5)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
			$this->Cell($w1[5],$ln,'(6)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[5],$ln,'(7)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
			$this->Cell($w1[5],$ln,'(8=6-7)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
			$this->Cell($w1[5],$ln,'(9)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4);
			$this->Cell($w1[5],$ln,'(10=8+9)',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
	$kdsatker = $_REQUEST['kdsatker'];
	$tgl = $_POST['tgl'];
	if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
	if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
	$th = $_REQUEST['th'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 4;
	$margin = 15;
	$tinggi = 275 ;
	$w1 = array(10,50,12,40,10,30);
	$pdf->SetFont($font,'',$size-1);
    
	$no = 0 ;
	$sql = "SELECT * FROM mst_tk WHERE kdsatker = '$kdsatker' and tahun = '$th' and bulan = '$kdbulan' ORDER BY grade desc, kdgol desc, kdjabatan";
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrNama	  = $pdf->SplitToArray($w1[1],$ln,nama_peg($row['nib'])."\n".'NIP. '.reformat_nipbaru(nip_peg($row['nib'])));
	$arrGol	      = $pdf->SplitToArray($w1[2],$ln,nm_gol(substr($row['kdgol'],0,1).hurufkeangka(substr($row['kdgol'],1,1)))."\n".status_peg($row['kdpeg']));
	if ( $row['jml_hari'] == 0 ) $arrJabatan  = $pdf->SplitToArray($w1[3],$ln,nm_info_jabatan($row['kdunitkerja'],$row['kdjabatan'])."\n".reformat_tgl($row['tmtjabatan']));
	if ( $row['jml_hari'] <> 0 ) $arrJabatan  = $pdf->SplitToArray($w1[3],$ln,nm_info_jabatan($row['kdunitkerja'],$row['kdjabatan'])."\n".reformat_tgl($row['tmtjabatan'])."\n".' ('.$row['jml_hari'].' hari dari '.hari_bulan($th,$kdbl).' hari kerja)');
	$arrGrade     = $pdf->SplitToArray($w1[4],$ln,$row['grade']);
	$arrTGrade     = $pdf->SplitToArray($w1[5],$ln,number_format(rp_grade($row['kdunitkerja'],$row['grade'],$row['kdpeg']),"0",",","."));
	$arrFPot     = $pdf->SplitToArray($w1[5],$ln,number_format(rp_grade($row['kdunitkerja'],$row['grade'],$row['kdpeg'])-$row['tunker'],"0",",","."));
	$arrTunker     = $pdf->SplitToArray($w1[5],$ln,number_format($row['tunker'],"0",",","."));
	$arrPajak     = $pdf->SplitToArray($w1[5],$ln,number_format($row['pajak_tunker'],"0",",","."));
	$arrMinta     = $pdf->SplitToArray($w1[5],$ln,number_format(($row['tunker']+$row['pajak_tunker']),"0",",","."));
    $total_tunker += $row['tunker'] ;
    $total_pajak += $row['pajak_tunker'] ;
	$total_tgrade += rp_grade($row['kdunitkerja'],$row['grade'],$row['kdpeg']);
	$total_fpot += rp_grade($row['kdunitkerja'],$row['grade'],$row['kdpeg'])-$row['tunker'];

	if ($max<count($arrNama)) $max=count($arrNama);
	if ($max<count($arrJabatan)) $max=count($arrJabatan);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrNama[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrGol[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrJabatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrGrade[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrTGrade[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln,$arrFPot[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln,$arrTunker[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[5],$ln,$arrPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4);
		$pdf->Cell($w1[5],$ln,$arrMinta[$i],'LR',1,'R');
	}
	  if($pdf->GetY() >= 170 )
	 {
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
		$pdf->Cell($w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$ln*2,'Jumlah Dipindahkan','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tgrade,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_fpot,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[5],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',1,'R');
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
	    $pdf->AddPage();
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$ln*2,'Jumlah Pindahan','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tgrade,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_fpot,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[5],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',1,'R');
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
	$pdf->SetFont($font,'',$size);
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
	 }
	}

	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$ln*2,'Jumlah Seluruhnya','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tgrade,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_fpot,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[5],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',1,'R');
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
//------------ Tanda Tangan ----
	if ( $pdf->GetY() >= 150 ){
	 	$pdf->AddPage();
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$ln*2,'Jumlah Seluruhnya','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tgrade,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_fpot,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[5],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',1,'R');
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*5,$pdf->GetY());
	}
	$pdf->Ln()+20;
	$w1 = array(15,60,30,60,30,60,10);
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