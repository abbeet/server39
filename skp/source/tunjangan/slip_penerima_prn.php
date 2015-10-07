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
			$th = $_REQUEST['th'];
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 4;
			$margin = 5;
			$tinggi = 275 ;
			$w = array(0,180);
			$this->SetFont($font,'B',$size+3);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln+1,'BADAN TENAGA NUKLIR NASIONAL','',1,'L');
			$this->SetFont($font,'B',$size+1);
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln+1,strtoupper(trim(nm_satker($kdsatker))),'',1,'L');
			$this->SetFont($font,'B',$size);
			$this->Ln()+5;
			$this->SetX($margin+$w[0]);
			$this->Cell($w[1],$ln+1,'SLIP PENERIMAAN TUNJANGAN KINERJA PEGAWAI','',1,'C');
			$this->SetX($margin+$w[0]);
			if ( $kdbl1 <> $kdbl2 ){
			    $this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl1)).' S/D '.strtoupper(nama_bulan($kdbl2)).' '.$th,'',1,'C');
			}elseif( $kdbl1 == 13 ) 
			{ 
				$this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl1)).' TAHUN '.$th,'',1,'C');
			}else{
				$this->Cell($w[1],$ln,'BULAN : '.strtoupper(nama_bulan($kdbl1)).' '.$th,'',1,'C');
			}
			$this->SetY(28);
			$this->SetFont($font,'',$size-3);
			$this->Cell(0, 8, 'Hal. ' . $this->PageNo(),0,1,'R');

	$w1 = array(10,27,50,15,18,18,18,18,28);
			$this->SetFont($font,'B',$size-1);
			$this->SetX($margin);
			$this->Cell($w1[0],$ln*2,'NO.',$border,0,'C');
			$this->SetX($margin+$w1[0]);
			$y = $this->GetY();
			$this->Cell($w1[1],$ln,'Nama Pegawai',$noborder,0,'C');
			$this->SetXY($margin+$w1[0],$y+4);
			$this->Cell($w1[1],$ln,'NIP',$noborder,0,'C');
			$this->SetXY($margin+$w1[0],$y);
			$this->Cell($w1[1],$ln*2,'',$border,0,'C');
			
			$this->SetX($margin+$w1[0]+$w1[1]);
			$this->Cell($w1[2],$ln*2,'Jabatan',$border,0,'C');
			
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
			$this->Cell($w1[3],$ln,'Kelas',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+4);
			$this->Cell($w1[3],$ln,'Jabatan',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
			$this->Cell($w1[3],$ln*2,'',$border,0,'C');

			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y);
			$this->Cell($w1[4],$ln,'Pajak',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+4);
			$this->Cell($w1[4],$ln,'Tunkin',$noborder,0,'C');
			$this->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y);
			$this->Cell($w1[4],$ln*2,'',$border,0,'C');

			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
			$this->Cell($w1[5],$ln*2,'Tunkin',$border,0,'C');

			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[6],$ln*2,'Potongan',$border,0,'C');
			
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
			$this->Cell($w1[7],$ln*2,'Diterima',$border,0,'C');

			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
			$this->Cell($w1[8],$ln*2,'Rekening',$border,1,'C');

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
			$this->Cell($w1[5],$ln,'(6)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
			$this->Cell($w1[6],$ln,'(7)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
			$this->Cell($w1[7],$ln,'(8=6-7)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
			$this->Cell($w1[8],$ln,'(9)',$border,1,'C');
		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();
	$th = $_REQUEST['th'];
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
	$kdsatker = $_REQUEST['kdsatker'];
	$tgl = $_POST['tgl'];
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 4;
	$margin = 5;
	$tinggi = 275 ;
	$w1 = array(10,27,50,15,18,18,18,18,28);
	$pdf->SetFont($font,'',$size-2);
    //----- while pegawai
	$no = 0 ;
	$oList = mysql_query("SELECT nib,nip,norec FROM mst_tk WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' GROUP BY nib");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	$nib = $row['nib'] ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no);
	$arrNama	  = $pdf->SplitToArray($w1[1],$ln,nama_peg($row['nib']));
	$arrNIP       = $pdf->SplitToArray($w1[2],$ln,'NIP. '.reformat_nipbaru($row['nip']));
	$arrNorek      = $pdf->SplitToArray($w1[7],$ln,$row['norec']);
	if ($max<count($arrNama)) $max=count($arrNama);
	if ($max<count($arrJabatan)) $max=count($arrJabatan);
	$pdf->SetFont($font,'B',$size-2);
	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrNo[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrNama[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrNIP[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,'','LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,'','LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,'','LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln,$arrNorek[$i],'LR',1,'C');
	}
	  if($pdf->GetY() >= 280 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	 }
	$pdf->SetFont($font,'',$size-2);
    //----- while bulan
	$JmlPajak 		= 0 ;
	$JmlTunker 		= 0 ;
	$JmlPotongan 	= 0 ;
	$JmlTerima 		= 0 ;

	$oList_bulan = mysql_query("SELECT bulan,kdunitkerja,kdjabatan, grade, jml_hari, tunker, pajak_tunker, nil_terima FROM mst_tk WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2' and nib = '$nib' order BY bulan, grade desc");
	while($row_bulan = mysql_fetch_array($oList_bulan))
	{
	$max = 0 ;
	if ( substr($row_bulan['bulan'],0,1) == '0' ) $kdbl = substr($row_bulan['bulan'],1,1) ;
	else $kdbl = $row_bulan['bulan'] ;
	$arrNo		  = $pdf->SplitToArray($w1[0],$ln,$no.'.');
	$arrBulan	  = $pdf->SplitToArray($w1[1],$ln,nama_bulan($kdbl));
	if ( $row_bulan['jml_hari'] == 0 ) $arrJabatan  = $pdf->SplitToArray($w1[2],$ln,nm_info_jabatan($row_bulan['kdunitkerja'],$row_bulan['kdjabatan']));
	if ( $row_bulan['jml_hari'] <> 0 ) $arrJabatan  = $pdf->SplitToArray($w1[2],$ln,nm_info_jabatan($row_bulan['kdunitkerja'],$row_bulan['kdjabatan'])."\n".' ('.$row_bulan['jml_hari'].' hari dari '.hari_bulan($th,$kdbl).' hari kerja)');
	$arrGrade     	  = $pdf->SplitToArray($w1[3],$ln,$row_bulan['grade']);
	$arrPajak      = $pdf->SplitToArray($w1[4],$ln,number_format($row_bulan['pajak_tunker'],"0",",","."));
	$arrTunker     = $pdf->SplitToArray($w1[5],$ln,number_format($row_bulan['tunker'],"0",",","."));
	$arrPotongan   = $pdf->SplitToArray($w1[6],$ln,number_format(($row_bulan['tunker'] - $row_bulan['nil_terima']),"0",",","."));
	$arrTerima     = $pdf->SplitToArray($w1[7],$ln,number_format($row_bulan['nil_terima'],"0",",","."));
	$JmlPajak 		+= $row_bulan['pajak_tunker'] ;
	$JmlTunker 		+= $row_bulan['tunker'] ;
	$JmlPotongan 	+= $row_bulan['tunker'] - $row_bulan['nil_terima'];
	$JmlTerima 		+= $row_bulan['nil_terima'] ;

	if ($max<count($arrJabatan)) $max=count($arrJabatan);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrBulan[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrJabatan[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrGrade[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrPajak[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrTunker[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrPotongan[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,$arrTerima[$i],'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln,'','LR',1,'R');
	}
	  if($pdf->GetY() >= 280 )
	 {
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	    	$pdf->AddPage();	
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	 }else{
	        $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	 }

	} # akhir while bulan	
	     $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
// ---- Jumlah Per Pegawai --------------
		$pdf->SetFont($font,'B',$size-2);
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,'','LR',0,'C');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,'','LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2]+$w1[3],$ln,'Jumlah','LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,number_format($JmlPajak,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,number_format($JmlTunker,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,number_format($JmlPotongan,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,number_format($JmlTerima,"0",",","."),'LR',0,'R');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln,'','LR',1,'C');
	    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	} # akhir while pegawai
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$pdf->GetY());
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>