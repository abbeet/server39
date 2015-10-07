<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
			$kdbulan1 = $_REQUEST['kdbulan1'];
			$kdbulan2 = $_REQUEST['kdbulan2'];
			$kdsatker = $_REQUEST['kdsatker'];
			if ( substr($kdbulan1,0,1) == '0' ) $kdbl1 = substr($kdbulan1,1,1) ;
			else $kdbl1 = $kdbulan1 ;
			if ( substr($kdbulan2,0,1) == '0' ) $kdbl2 = substr($kdbulan2,1,1) ;
			else $kdbl2 = $kdbulan2 ;
			$th = $_REQUEST['th'];
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 5;
			$margin = 10;
			$tinggi = 275 ;
			$w = array(0,280);
			$this->SetFont($font,'B',$size+3);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'BADAN TENAGA NUKLIR NASIONAL','',1,'L');
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,strtoupper(trim(nm_satker($kdsatker))),'',1,'L');
			$this->Ln();
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'REKAPITULASI PEMBAYARAN TUNJANGAN KINERJA PEGAWAI','',1,'C');
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl1)).' S/D '.strtoupper(nama_bulan($kdbl2)).' '.$th,'',1,'C');
			$this->SetX($margin);
			$this->Cell($w1[0],$ln,'',$noborder,1,'C');
			$ln = 4 ;
			$w1 = array(10,30,25,35,30,35,25,25,25,35);
			$this->SetFont($font,'B',$size);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*3,'No..',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$this->Cell($w1[1],$ln*3,'Bulan',$border,0,'C');
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
			$this->Cell($w1[3],$ln,'Sebelum Pajak',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
			$this->Cell($w1[3],$ln*3,'',$border,0,'C');

			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
			$this->Cell($w1[4],$ln*3,'Tunjangan Pajak',$border,0,'C');
			
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
			$this->Cell($w1[5],$ln*3,'Jumlah Bruto',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[6]+$w1[6]+$w1[6],$ln,'POTONGAN',$border,1,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[6],$ln*2,'Pajak',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+4);
			$this->Cell($w1[7],$ln,'Faktor',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+8);
			$this->Cell($w1[7],$ln,'Pengurang',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+4);
			$this->Cell($w1[7],$ln*2,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$y+4);
			$this->Cell($w1[8],$ln,'Jumlah',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$y+8);
			$this->Cell($w1[8],$ln,'Potongan',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$y+4);
			$this->Cell($w1[8],$ln*2,'',$border,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y+2);
			$this->Cell($w1[9],$ln,'Tunjangan Kinerja',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y+6);
			$this->Cell($w1[9],$ln,'Yang Diterima',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y);
			$this->Cell($w1[9],$ln*3,'',$border,1,'C');
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
			$this->Cell($w1[4],$ln,'(5)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
			$this->Cell($w1[5],$ln,'(6=4+5)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[6],$ln,'(7)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
			$this->Cell($w1[7],$ln,'(8)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
			$this->Cell($w1[8],$ln,'(9=7+8)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
			$this->Cell($w1[9],$ln,'(10=6-9)',$border,1,'C');
			
			
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*2,'',$noborder,0,'C');
		}		
	}
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
	$kdsatker = $_REQUEST['kdsatker'];
	$th = $_REQUEST['th'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 6;
	$margin = 10;
	$tinggi = 275 ;
	$w1 = array(10,30,25,35,30,35,25,25,25,35);
	$pdf->SetFont($font,'',$size-1);
    
	$jml_peg = 0 ;
	$no = 0 ;
	for ($j = $kdbulan1 ; $j <= $kdbulan2 ; $j++)
	{
	if ( $j <= 9 )    $kdbulan = '0'.$j ;
	else $kdbulan = $j ;
	$oList = mysql_query("SELECT sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM mst_tk WHERE tahun = '$th' and bulan = '$kdbulan' and kdsatker = '$kdsatker' GROUP BY bulan");
	$row = mysql_fetch_array($oList);

	$max = 0 ;
	$no += 1 ;
	$total_tunker += $row['jml_tunker'] ;
	$total_pajak  += $row['jml_pajak'] ;
	$total_terima  += $row['jml_terima'] ;
	if ( jmlpeg_bulan($th,$kdbulan,$kdsatker) > $jml_peg )   $jml_peg = jmlpeg_bulan($th,$kdbulan,$kdsatker) ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrBulan	  = $pdf->SplitToArray($w1[1],$ln,strtoupper(nama_bulan($j)));
	$arrPenerima  = $pdf->SplitToArray($w1[2],$ln,jmlpeg_bulan($th,$kdbulan,$kdsatker));
	$arrJmlTunker = $pdf->SplitToArray($w1[3],$ln,number_format($row['jml_tunker'],"0",",","."));
	$arrJmlPajak  = $pdf->SplitToArray($w1[4],$ln,number_format($row['jml_pajak'],"0",",","."));
	$arrJumlah    = $pdf->SplitToArray($w1[5],$ln,number_format(($row['jml_tunker']+$row['jml_pajak']),"0",",","."));
	$arrJmlPajak  = $pdf->SplitToArray($w1[6],$ln,number_format($row['jml_pajak'],"0",",","."));
	$arrJmlTerima  = $pdf->SplitToArray($w1[9],$ln,number_format($row['jml_terima'],"0",",","."));
	$arrJmlKurang  = $pdf->SplitToArray($w1[7],$ln,number_format($row['jml_tunker'] - $row['jml_terima'],"0",",","."));
	$arrJmlPotong  = $pdf->SplitToArray($w1[8],$ln,number_format($row['jml_tunker'] - $row['jml_terima'] + $row['jml_pajak'],"0",",","."));
	if ($max<count($arrBulan)) $max=count($arrBulan);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrBulan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrPenerima[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrJmlTunker[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrJmlPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrJumlah[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrJmlPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,$arrJmlKurang[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln,$arrJmlPotong[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
		$pdf->Cell($w1[9],$ln,$arrJmlTerima[$i],'LR',1,'R');
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9],$pdf->GetY());
	}

	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9],$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0]+$w1[1],$ln*2,'Jumlah','LR',0,'C');
		$pdf->Cell($w1[2],$ln*2,$jml_peg,'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln*2,number_format($total_tunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln*2,number_format(($total_tunker + $total_pajak),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln*2,number_format($total_pajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln*2,number_format(($total_tunker - $total_terima),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln*2,number_format(($total_tunker - $total_terima + $total_pajak),"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
		$pdf->Cell($w1[9],$ln*2,number_format($total_terima,"0",",","."),'LR',1,'R');
		
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9],$pdf->GetY());
//------------ Tanda Tangan ----
	$ln = 3.5 ;
	$pdf->Ln()+10;
	$w1 = array(20,60,25,60,25,60,10);
	$pdf->SetFont($font,'',$size);
	
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,kota_satker($xusername).', '.reformat_tanggal(date('Y-m-d')),'',1,'C');

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