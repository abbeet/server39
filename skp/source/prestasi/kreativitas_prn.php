<?php	
	include ("../../lib/fpdf/fpdf.php");
	include ("../../includes/dbh.php");
	include ("../../includes/query.php");
	include ("../../includes/functions.php");

	class PDF extends FPDF {
		function Header() {
		
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
		
//		}		
	}
	
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->AliasNbPages();

	$id_skp = $_REQUEST['id_skp'];
	$font = 'Arial';
	$noborder = 0;
	$border = 1;
	$size = 11;
	$ln = 6;
	$margin = 20;
	$tinggi = 275 ;
	
	$pdf->SetFont($font,'B',$size+1);
	$w = array(50,5,80);
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[2],$ln*10,'','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[2],$ln,'SURAT KETERANGAN','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[2],$ln,'MENEMUKAN SESUATU YANG BARU (KREATIVITAS)','',1,'C');
	$pdf->SetX($margin+$w[0]);
	$pdf->Cell($w[2],$ln*2,'','',1,'C');
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	$pdf->SetFont($font,'',$size);
	$w = array(7,100);
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[0],$ln,'1.');
	$arrUraian		= $pdf->SplitToArray($w[1],$ln,'Yang bertanda tangan di bawah ini :');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$w = array(7,5,45,5,100);
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'a.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Nama');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,trim(nama_peg($row['nib_atasan'])));

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'b.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'NIP');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,reformat_nipbaru(nip_peg($row['nib_atasan'])));

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'c.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Pangkat/Golongan');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,nm_pangkat($row['kdgol_atasan']).' ('.nm_gol($row['kdgol_atasan']).')');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'d.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Jabatan');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,$row['jabatan_atasan']);

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	if ( kdunitkerja_peg($row['nib_atasan']) == '0000' ) 
	{
		$unit =  'BATAN';
	}else{
		$unit = trim(skt_unitkerja(substr(kdunitkerja_peg($row['nib_atasan']),0,2))) ;
	} 
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'e.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Unit Kerja');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,$unit);

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'f.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Instansi');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,'BATAN');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$w = array(7,100);
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[0],$ln,'2.');
	$arrUraian		= $pdf->SplitToArray($w[1],$ln,'Dengan ini menyatarakan bahwa Saudara :');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$w = array(7,5,45,5,100);
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'a.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Nama');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,trim(nama_peg($row['nib'])));

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'b.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'NIP');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,reformat_nipbaru(nip_peg($row['nib'])));

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'c.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Pangkat/Golongan');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

if( substr($row['kdunitkerja'],1,3) == '000' and substr($row['kdjabatan'],0,4) == '0011' ) 
	{
		$jabatan = nm_jabatan_eselon1($row['kdunitkerja']);
	} 
	elseif ( substr($row['kdunitkerja'],1,3) <> '000' and substr($row['kdjabatan'],0,3) == '001' )
	{
		$jabatan = 'Kepala '.nm_unitkerja($row['kdunitkerja']);
	}else{
		$jabatan = nm_jabatan_ij($row['kdjabatan']);
	}
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'d.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Jabatan');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,$jabatan);

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'e.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Unit Kerja');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,skt_unitkerja(substr($row['kdunitkerja'],0,2)));

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'f.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Instansi');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,'BATAN');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'g.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Jangka waktu penilaian');
	$arrTitik		= $pdf->SplitToArray($w[3],$ln,':');
	$arrUraian		= $pdf->SplitToArray($w[4],$ln,reformat_tanggal($row['tgl_kemajuan_awal']).' s.d. '.reformat_tanggal($row['tgl_kemajuan_akhir']));

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]);
		$pdf->Cell($w[3],$ln,$arrTitik[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]+$w[2]+$w[3]);
		$pdf->Cell($w[4],$ln,$arrUraian[$i],'',1,'L');
	}

	$w = array(7,180);
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[0],$ln,'3.');
	$arrUraian		= $pdf->SplitToArray($w[1],$ln,'Telah menemukan sesuatu yang baru (kreativitas) yang bermanfaat bagi :');

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrUraian[$i],'',1,'L');
	}
	
	$w = array(7,5,80);
	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'a.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Unit Kerja, diberi nilai ');

	if ($max<count($arrLabel)) $max=count($arrLabel);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'b.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Organisasi, diberi nilai ');

	if ($max<count($arrLabel)) $max=count($arrLabel);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',1,'L');
	}

	$max = 0 ;
	$arrNomor		= $pdf->SplitToArray($w[1],$ln,'c.');
	$arrLabel		= $pdf->SplitToArray($w[2],$ln,'Negara, diberi nilai ');

	if ($max<count($arrLabel)) $max=count($arrLabel);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w[0]);
		$pdf->Cell($w[1],$ln,$arrNomor[$i],'',0,'L');
		$pdf->SetX($margin+$w[0]+$w[1]);
		$pdf->Cell($w[2],$ln,$arrLabel[$i],'',1,'L');
	}

	$w = array(190);
	$max = 0 ;
	$uraian = 'Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya';
	$arrUraian	= $pdf->SplitToArray($w[0],$ln,$uraian);

	if ($max<count($arrUraian)) $max=count($arrUraian);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin);
		$pdf->Cell($w[0],$ln,$arrUraian[$i],'',1,'L');
	}

# AKHIR WHILE
	if ( $pdf->GetY() >= 240 ) 	$pdf->AddPage();
//------------------ Tanda Tangan	
	$w3 = array(50,50,60);
	$pdf->Ln();
	

	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,'Pejabat yang membuat keterangan ,','',1,'C');
	$max = 0 ;
	$arrLabel		= $pdf->SplitToArray($w3[2],$ln,trim($row['jabatan_atasan']));

	if ($max<count($arrLabel)) $max=count($arrLabel);

	for($i=0;$i<$max;$i++)
	{
		$pdf->SetX($margin+$w3[0]+$w3[1]);
		$pdf->Cell($w3[2],$ln,$arrLabel[$i],'',1,'C');
	}
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$ln = 4 ;
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,trim(nama_peg($row['nib_atasan'])),'',1,'C');
	$pdf->SetX($margin+$w3[0]+$w3[1]);
	$pdf->Cell($w3[2],$ln,'NIP. '.reformat_nipbaru(nip_peg($row['nib_atasan'])),'',1,'C');

	$pdf->SetDisplayMode('real');
	$pdf->Output('doc.pdf','I');

?>