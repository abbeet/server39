<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");
	class PDF extends FPDF {
		function Header() {
			$font = 'Arial';
			$noborder = 0;
			$border = 1;
			$size = 10;
			$ln = 5;
			$margin = 5;
			$tinggi = 275 ;
			$this->SetFont($font,'B',$size);
			$w1 = array(35,40,18,9,40,9,40,9,40,9,40);
			if ($this->PageNo() != 1)
			{
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
			$this->Cell($w1[7],$ln,'(8)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
			$this->Cell($w1[8],$ln,'(9)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
			$this->Cell($w1[9],$ln,'(10)',$border,0,'C');
			$this->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]);
			$this->Cell($w1[10],$ln,'(11)',$border,1,'C');
		}

		}
			// function to force justified text
		function CellJ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
		{
			$k=$this->k;
			if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
			{
				$x=$this->x;
				$ws=$this->ws;
				if($ws>0)
				{
					$this->ws=0;
					$this->_out('0 Tw');
				}
				$this->AddPage($this->CurOrientation);
				$this->x=$x;
				if($ws>0)
				{
					$this->ws=$ws;
					$this->_out(sprintf('%.3F Tw',$ws*$k));
				}
			}
			if($w==0)
				$w=$this->w-$this->rMargin-$this->x;
			$s='';
			if($fill || $border==1)
			{
				if($fill)
					$op=($border==1) ? 'B' : 'f';
				else
					$op='S';
				$s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
			}
			if(is_string($border))
			{
				$x=$this->x;
				$y=$this->y;
				if(is_int(strpos($border,'L')))
					$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
				if(is_int(strpos($border,'T')))
					$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
				if(is_int(strpos($border,'R')))
					$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
				if(is_int(strpos($border,'B')))
					$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
			}
			if($txt!='')
			{
				if($align=='R')
					$dx=$w-$this->cMargin-$this->GetStringWidth($txt);
				elseif($align=='C')
					$dx=($w-$this->GetStringWidth($txt))/2;
				elseif($align=='J')
				{
					//Set word spacing
					$wmax=($w-2*$this->cMargin);
					if(substr_count($txt,' ')==0)
						$this->ws=($wmax-$this->GetStringWidth($txt));
					else
						$this->ws=($wmax-$this->GetStringWidth($txt))/substr_count($txt,' ');
					$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
					$dx=$this->cMargin;
				}
				else
					$dx=$this->cMargin;
				$txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
				if($this->ColorFlag)
					$s.='q '.$this->TextColor.' ';
				$s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt);
				if($this->underline)
					$s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
				if($this->ColorFlag)
					$s.=' Q';
				if($link)
				{
					if($align=='J')
						$wlink=$wmax;
					else
						$wlink=$this->GetStringWidth($txt);
					$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$wlink,$this->FontSize,$link);
				}
			}
			if($s)
				$this->_out($s);
			if($align=='J')
			{
				//Remove word spacing
				$this->_out('0 Tw');
				$this->ws=0;
			}
			$this->lasth=$h;
			if($ln>0)
			{
				$this->y+=$h;
				if($ln==1)
					$this->x=$this->lMargin;
			}
			else
				$this->x+=$w;
		}	

	}
	
	
	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$th = $_REQUEST['th'];
	$kdunit = $_REQUEST['kdunit'];
	$renstra = th_renstra($th);
	
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 10;
	$ln = 5;
	$margin = 5;
	$tinggi = 275 ;

	$y = $pdf->GetY();
	$pdf->SetY($y);
	$pdf->Image('../../css/images/logo_lapan.jpg',135,5,30,30,'jpg');
	$y = $pdf->GetY();
	$pdf->Cell(0,30,'','',1,'L');
	
	$oSatker = mysql_query("SELECT NAMA FROM t_satker WHERE KDUNITKERJA = '$kdunit' ");
	$Satker = mysql_fetch_array($oSatker);
	
	$kdeselon1 = substr($kdunit,0,3).'000';
	$oEselon = mysql_query("SELECT nama FROM tb_unitkerja WHERE kdunit = '$kdeselon1' ");
	$Eselon = mysql_fetch_array($oEselon);

	$w = array(0,290);
	$pdf->SetFont($font,'B',$size+2);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,'RENCANA AKSI DARI PENETAPAN KINERJA','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[1],$ln,trim(strtoupper(nm_unit($kdunit))),'',1,'C');
	$pdf->Ln()*2;
	
	$w1 = array(35,40,18,9,40,9,40,9,40,9,40);
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*3,'Sasaran Strategis',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln*3,'Indikator Kinerja',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln*3,'Target',$border,0,'C');
	$y = $pdf->GetY();
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
	$pdf->Cell(($w1[3]+$w1[4])*4,$ln,'Rencana Aksi',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+5);
	$pdf->Cell($w1[3]+$w1[4],$ln,'Triwulan I',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+5);
	$pdf->Cell($w1[5]+$w1[6],$ln,'Triwulan II',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+5);
	$pdf->Cell($w1[7]+$w1[8],$ln,'Triwulan III',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y+5);
	$pdf->Cell($w1[9]+$w1[10],$ln,'Triwulan IV',$border,0,'C');
	
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+10);
	$pdf->Cell($w1[3],$ln,'(%)',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+10);
	$pdf->Cell($w1[4],$ln,'Uraian',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4],$y+10);
	$pdf->Cell($w1[5],$ln,'(%)',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5],$y+10);
	$pdf->Cell($w1[6],$ln,'Uraian',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6],$y+10);
	$pdf->Cell($w1[7],$ln,'(%)',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7],$y+10);
	$pdf->Cell($w1[8],$ln,'Uraian',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8],$y+10);
	$pdf->Cell($w1[9],$ln,'(%)',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9],$y+10);
	$pdf->Cell($w1[10],$ln,'Uraian',$border,1,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y);
	$pdf->Cell(($w1[3]+$w1[4])*4,$ln,'Rencana Aksi',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+5);
	$pdf->Cell($w1[3]+$w1[4],$ln,'Triwulan I',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2],$y+10);
	$pdf->Cell($w1[3],$ln,'(%)',$border,0,'C');
	$pdf->SetXY($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3],$y+10);
	$pdf->Cell($w1[4],$ln,'Uraian',$border,1,'C');

	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln,'(1)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]);
	$pdf->Cell($w1[1],$ln,'(2)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]);
	$pdf->Cell($w1[2],$ln,'(3)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
	$pdf->Cell($w1[3],$ln,'(4)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
	$pdf->Cell($w1[4],$ln,'(5)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
	$pdf->Cell($w1[5],$ln,'(6)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
	$pdf->Cell($w1[6],$ln,'(7)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
	$pdf->Cell($w1[7],$ln,'(8)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
	$pdf->Cell($w1[8],$ln,'(9)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
	$pdf->Cell($w1[9],$ln,'(10)',$border,0,'C');
	$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]);
	$pdf->Cell($w1[10],$ln,'(11)',$border,1,'C');

	$pdf->SetFont($font,'',$size);
    $renstra = th_renstra($th);
	$no = 0 ;
	$oList = mysql_query("select * from th_pk WHERE th = '$th' and kdunitkerja = '$kdunit' order by no_pk");
	while($row = mysql_fetch_array($oList))
	{
	$max = 0 ;
	$no += 1 ;
	if ( $kdsasaran <> $row['no_sasaran'] )   $arrSasaran		= $pdf->SplitToArray($w1[0],$ln,nm_sasaran($renstra,$row['kdunitkerja'],$row['no_sasaran']));
	if ( $kdsasaran == $row['no_sasaran'] )   $arrSasaran		= $pdf->SplitToArray($w1[0],$ln,'');

	if ( $row['sub_pk'] == '1' )
	{
	        if ( $row['no_ikk'] <> 0 ) $iku_sub  = '[IKU '.$row['no_ikk'].'] '.trim($row['nm_pk'])."\n" ;
			else  $iku_sub  = trim($row['nm_pk'])."\n" ;
			$oList_sub = mysql_query("select * from th_pk_sub WHERE th = '$th' and kdunitkerja = '$kdunit' and no_pk = '$row[no_pk]' order by no_pk_sub");
			while($row_sub = mysql_fetch_array($oList_sub))
			{
			$iku_sub          = $iku_sub.nmalfa($row_sub['no_pk_sub']).'. '.$row_sub['nm_pk_sub']."\n" ;
			}
			$arrIndikator     = $pdf->SplitToArray($w1[1],$ln,trim($iku_sub));
	}else{		
			if ( $row['no_ikk'] <> 0 ) $arrIndikator    = $pdf->SplitToArray($w1[1],$ln,'[IKU '.$row['no_ikk'].'] '.trim($row['nm_pk']));
			else $arrIndikator    = $pdf->SplitToArray($w1[1],$ln,trim($row['nm_pk']));
	}
//	$arrIndikator   = $pdf->SplitToArray($w1[1],$ln,trim($row['nm_pk']));
	$arrTarget   	= $pdf->SplitToArray($w1[2],$ln,trim($row['target']));
	if ( $row['rencana_1'] <> 0 )   $arrCapaian_1 = $pdf->SplitToArray($w1[3],$ln,number_format($row['rencana_1'],"0",",","."));
	else  $arrCapaian_1 = $pdf->SplitToArray($w1[3],$ln,'');
	if ( $row['rencana_2'] <> 0 )   $arrCapaian_2 = $pdf->SplitToArray($w1[5],$ln,number_format($row['rencana_2'],"0",",","."));
	else  $arrCapaian_2 = $pdf->SplitToArray($w1[5],$ln,'');
	if ( $row['rencana_3'] <> 0 )   $arrCapaian_3 = $pdf->SplitToArray($w1[7],$ln,number_format($row['rencana_3'],"0",",","."));
	else  $arrCapaian_3 = $pdf->SplitToArray($w1[7],$ln,'');
	if ( $row['rencana_4'] <> 0 )   $arrCapaian_4 = $pdf->SplitToArray($w1[9],$ln,number_format($row['rencana_4'],"0",",","."));
	else  $arrCapaian_4 = $pdf->SplitToArray($w1[9],$ln,'');

	$arrAksi_1   	= $pdf->SplitToArray($w1[4],$ln,trim($row['aksi_1']));
	$arrAksi_2   	= $pdf->SplitToArray($w1[6],$ln,trim($row['aksi_2']));
	$arrAksi_3   	= $pdf->SplitToArray($w1[8],$ln,trim($row['aksi_3']));
	$arrAksi_4   	= $pdf->SplitToArray($w1[10],$ln,trim($row['aksi_4']));

	if ($max<count($arrSasaran)) $max=count($arrSasaran);
	if ($max<count($arrIndikator)) $max=count($arrIndikator);
	if ($max<count($arrAksi_1)) $max=count($arrAksi_1);
	if ($max<count($arrAksi_2)) $max=count($arrAksi_2);
	if ($max<count($arrAksi_3)) $max=count($arrAksi_3);
	if ($max<count($arrAksi_4)) $max=count($arrAksi_4);

	if ( $kdsasaran <> $row['no_sasaran'] )    $pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]+$w1[10],$pdf->GetY());
	if ( $kdsasaran == $row['no_sasaran'] )    $pdf->Line($margin+$w1[0], $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]+$w1[10],$pdf->GetY());
    $kdsasaran = $row['no_sasaran'] ;

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w1[0],$ln,$arrSasaran[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]);
		$pdf->Cell($w1[1],$ln,$arrIndikator[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]);
		$pdf->Cell($w1[2],$ln,$arrTarget[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]);
		$pdf->Cell($w1[3],$ln,$arrCapaian_1[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]);
		$pdf->Cell($w1[4],$ln,$arrAksi_1[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]);
		$pdf->Cell($w1[5],$ln,$arrCapaian_2[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]);
		$pdf->Cell($w1[6],$ln,$arrAksi_2[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]);
		$pdf->Cell($w1[7],$ln,$arrCapaian_3[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]);
		$pdf->Cell($w1[8],$ln,$arrAksi_3[$i],'LR',0,'L');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]);
		$pdf->Cell($w1[9],$ln,$arrCapaian_4[$i],'LR',0,'C');
		$pdf->SetX($margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]);
		$pdf->Cell($w1[10],$ln,$arrAksi_4[$i],'LR',1,'L');
	}
	}
	$pdf->Line($margin, $pdf->GetY(), $margin+$w1[0]+$w1[1]+$w1[2]+$w1[3]+$w1[4]+$w1[5]+$w1[6]+$w1[7]+$w1[8]+$w1[9]+$w1[10],$pdf->GetY());
	$pdf->SetFont($font,'B',$size);
	$pdf->SetX($margin);
	$pdf->Cell($w1[0],$ln*2,'','',1,'L');
	$pdf->SetX($margin);
	if ( $kdunit == '820000' ) {
	    $anggaran = pagudipa_lapan($th,'820000');
	}elseif( substr($kdunit,3,3) == '000' and $kdunit <> '820000' ) {
	  $anggaran = pagudipa_deputi($th,$kdunit);
	}else{
	    $anggaran = pagudipa_unit($th,$kdunit);
	}
	$pdf->Cell($w1[0],$ln,'Jumlah Pagu Anggaran '. $th .' : Rp. '.number_format($anggaran,"0",",",".").',-','',1,'L');
	
	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>