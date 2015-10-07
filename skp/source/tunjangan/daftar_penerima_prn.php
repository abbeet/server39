<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
			$kdunit = $_REQUEST['kdunit'];
			$kdbulan = $_REQUEST['kdbulan'];
			//$kdsatker = $_REQUEST['kdsatker'];
			if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
			if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
			$th = $_REQUEST['th'];
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 9;
			$ln = 4;
			$margin = 5;
			$tinggi = 275 ;
			$w = array(0,330);
			$this->Ln();
			$this->SetFont($font,'B',$size+2);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'RINCIAN PEMBAYARAN TUNJANGAN KINERJA PEGAWAI','',1,'C');
			$this->SetX($margin+$w[0]);
			if ( $kdunit <> '' )  $this->Cell($w[1],$ln,trim(strtoupper(nm_unitkerja($kdunit))),'',1,'C');
			//if ( $kdsatker <> '' )  $this->Cell($w[1],$ln,'SATKER : '.trim(strtoupper(nm_satker($kdsatker))),'',1,'C');
			$this->SetX($margin+$w[0]);
			if ( $kdbl <> 13 )  $this->Cell($w[1],$ln,'Bulan : '.nama_bulan($kdbl).' '.$th,'',1,'C');
			else  $this->Cell($w[1],$ln,'Bulan : '.nama_bulan($kdbl).' Tahun '.$th,'',1,'C');
//			$this->Ln();
	
			$this->SetY(20);
			$this->SetFont($font,'',$size-3);
			$this->Cell(0, 10, 'Hal. ' . $this->PageNo(),0,1,'R');
//			if ($this->PageNo() != 1) $this->Line($margin, $this->GetY(), $margin+180,$this->GetY());
//			$this->Ln();

			$w1 = array(11,45,15,50,15,25,20,12,33);
			$this->SetFont($font,'B',$size);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*3,'NO.',$border,0,'C');
			$y = $this->GetY();
			$this->SetXY($margin+$w1[0],$y+2);
			$this->Cell($w1[1],$ln,'NAMA PEGAWAI',$noborder,0,'C');
			$this->SetXY($margin+$w1[0],$y+6);
			$this->Cell($w1[1],$ln,'NIP',$noborder,0,'C');
			$this->SetXY($margin+$w1[0],$y);
			$this->Cell($w1[1],$ln*3,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y+2);
			$this->Cell($w1[2],$ln,'GOL',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y+6);
			$this->Cell($w1[2],$ln,'STATUS',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1],$y);
			$this->Cell($w1[2],$ln*3,'',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
			$this->Cell($w1[3],$ln*3,'NAMA JABATAN / TMT',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
			$this->Cell($w1[4],$ln*3,'GRADE',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+2);
			$this->Cell($w1[5],$ln,'TUNJANGAN',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+6);
			$this->Cell($w1[5],$ln,'KINERJA',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+2);
			$this->Cell($w1[5],$ln,'TUNJANGAN',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+6);
			$this->Cell($w1[5],$ln,'PAJAK',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y+2);
			$this->Cell($w1[5],$ln,'JUMLAH',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y+6);
			$this->Cell($w1[5],$ln,'BRUTO',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2,$y);
			$this->Cell($w1[5],$ln*3,'',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
			$this->Cell($w1[6]*3+$w1[7],$ln,'POTONGAN',$border,1,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
			$this->Cell($w1[6],$ln*2,'PAJAK',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]);
			$y2 = $this->GetY();
			$this->Cell($w1[6]+$w1[7],$ln,'KEHADIRAN',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*2+$w1[7]);
			$this->Cell($w1[6],$ln,'JUMLAH',$noborder,1,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]);
			$this->Cell($w1[7],$ln,'(%)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]+$w1[7]);
			$this->Cell($w1[6],$ln,'(RP.)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*2+$w1[7]);
			$this->Cell($w1[6],$ln,'POTONGAN',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*2+$w1[7],$y2);
			$this->Cell($w1[6],$ln*2,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*3+$w1[7],$y+2);
			$this->Cell($w1[5],$ln,'JUMLAH',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*3+$w1[7],$y+6);
			$this->Cell($w1[5],$ln,'DIBAYARKAN',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*3+$w1[7],$y);
			$this->Cell($w1[5],$ln*3,'',$border,1,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7],$y+2);
			$this->Cell($w1[8],$ln,'NOMOR',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7],$y+6);
			$this->Cell($w1[8],$ln,'REKENING',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7],$y);
			$this->Cell($w1[8],$ln*3,'',$border,1,'C');
//			$this->Cell($w1[5],$ln*2,'Yang Diterima',$border,1,'C');
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
			$this->Cell($w1[5],$ln,'(8=6+7)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
			$this->Cell($w1[6],$ln,'(9)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]);
			$this->Cell($w1[7],$ln,'(10)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]+$w1[7]);
			$this->Cell($w1[6],$ln,'(11)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*2+$w1[7]);
			$this->Cell($w1[6],$ln,'(12=9+11)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*3+$w1[7]);
			$this->Cell($w1[5],$ln,'(13=8-12)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]);
			$this->Cell($w1[8],$ln,'(14)',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','Legal');
	$pdf->AddPage();
	$kdunit = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
	//$kdsatker = $_REQUEST['kdsatker'];
	if ( substr($kdbulan,0,1) == '0' ) $kdbl = substr($kdbulan,1,1) ;
	if ( substr($kdbulan,0,1) <> '0' ) $kdbl = $kdbulan ;
	$th = $_REQUEST['th'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 9;
	$ln = 4;
	$margin = 5;
	$tinggi = 275 ;
	$w1 = array(11,45,15,50,15,25,20,12,33);
	$pdf->SetFont($font,'',$size);
    
	//--------- status verifikasi
	$data_status = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
								AND bulan = '$kdbulan' AND tahun = '$th'");
	$rdata_status = mysql_fetch_array($data_status) ;
	
	$no = 0 ;
	$xkdunit = substr($kdunit,0,5) ;
	if ( $kdunit == '2320100' )
	{
	$sql = "SELECT * FROM mst_tk WHERE tahun = '$th' and bulan = '$kdbulan' and ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' ) ORDER BY grade desc,kdgol,kdjabatan";
	}else{
	$sql = "SELECT * FROM mst_tk WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%' ORDER BY grade desc,kdgol,kdjabatan";
	}
	
	$qu = mysql_query($sql);
	while($row = mysql_fetch_array($qu))
	{
	
	$nip = $row['nip'] ;
	$sql_bank = "SELECT no_rek FROM mst_rekening WHERE nip = '$nip'";
	$oList_bank = mysql_query($sql_bank) ;
	$List_bank  = mysql_fetch_array($oList_bank) ;
	
	$potongan_p = 0 ;
	$potongan_r = 0 ;
	if ( $rdata_status['status_verifikasi_potongan'] == '1' )
	{			
	$bulan = $th.'-'.$kdbulan ;
	$sql_pot = "SELECT TOT FROM potongan WHERE nip = '$nip' and bulan = '$bulan'";
	$oList_pot = mysql_query($sql_pot) ;
	$List_pot  = mysql_fetch_array($oList_pot) ;
	$potongan_p = $List_pot['TOT'] ;
	$potongan_r = ( $potongan_p / 100 ) * $row['tunker'] ;
	}
	
	$max = 0 ;
	$no += 1 ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrNama	  = $pdf->SplitToArray($w1[1],$ln,nama_peg($row['nip'])."\n".'NIP. '.reformat_nipbaru($row['nip']));
	$arrGol	      = $pdf->SplitToArray($w1[2],$ln,nm_gol($row['kdgol'])."\n".nm_status_peg($row['kdstatuspeg']));
	$arrJabatan  = $pdf->SplitToArray($w1[3],$ln,nm_jabatan_ij($row['kdjabatan'],$row['kdunitkerja'])."\n".reformat_tgl($row['tmtjabatan']));
	$arrGrade     = $pdf->SplitToArray($w1[4],$ln,$row['grade']);
	$arrTunker     = $pdf->SplitToArray($w1[5],$ln,number_format($row['tunker'],"0",",","."));
	$arrPajak     = $pdf->SplitToArray($w1[5],$ln,number_format($row['pajak_tunker'],"0",",","."));
	$arrBruto     = $pdf->SplitToArray($w1[5],$ln,number_format(($row['tunker'] + $row['pajak_tunker']),"0",",","."));
	$arrPPH      = $pdf->SplitToArray($w1[6],$ln,number_format($row['pajak_tunker'],"0",",","."));
	$arrKurang      = $pdf->SplitToArray($w1[7],$ln,number_format($potongan_p,"2",",",".").'%');
	$arrBayar       = $pdf->SplitToArray($w1[5],$ln,number_format( ( $row['tunker'] - $potongan_r ),"0",",","."));
	$arrPot         = $pdf->SplitToArray($w1[6],$ln,number_format($potongan_r ,"0",",","."));
	$arrJmlPot      = $pdf->SplitToArray($w1[6],$ln,number_format( ( $row['pajak_tunker'] + $potongan_r ),"0",",","."));

	$arrNorec     = $pdf->SplitToArray($w1[8],$ln,$List_bank['no_rek']);
    $total_tunker += $row['tunker'] ;
    $total_pajak  += $row['pajak_tunker'] ;
	$total_pot    += $potongan_r ;

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
		$pdf->Cell($w1[5],$ln,$arrTunker[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln,$arrPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln,$arrBruto[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[6],$ln,$arrPPH[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]);
		$pdf->Cell($w1[7],$ln,$arrKurang[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]+$w1[7]);
		$pdf->Cell($w1[6],$ln,$arrPot[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*2+$w1[7]);
		$pdf->Cell($w1[6],$ln,$arrJmlPot[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*3+$w1[7]);
		$pdf->Cell($w1[5],$ln,$arrBayar[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]);
		$pdf->Cell($w1[8],$ln,$arrNorec[$i],'LR',1,'C');
	}
	  if($pdf->GetY() >= 185 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]+$w1[8],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]+$w1[8],$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]+$w1[8],$pdf->GetY());
	 }
	}

	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]+$w1[8],$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$ln*2,'Jumlah Seluruhnya','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[5],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*2);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3);
		$pdf->Cell($w1[6],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]);
		$pdf->Cell($w1[7],$ln*2,'','LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]+$w1[7]);
		$pdf->Cell($w1[6],$ln*2,number_format($total_pot,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*2+$w1[7]);
		$pdf->Cell($w1[6],$ln*2,number_format(($total_pajak + $total_pot),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*3+$w1[6]*3+$w1[7]);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker - $total_pot),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]);
		$pdf->Cell($w1[8],$ln*2,'','LR',1,'R');
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]*4+$w1[6]*3+$w1[7]+$w1[8],$pdf->GetY());
/*	
//------------ Tanda Tangan ----
	  if($pdf->GetY() >= 150 )
	 {
	    	$pdf->AddPage();	
	 }
	$ln = 4 ;
	$pdf->Ln()+20;
	$w1 = array(30,60,30,60,30,60,10);
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
	*/
	$pdf->SetDisplayMode('real');
	$pdf->Output('daftar_pembayaran.pdf','I');

?>