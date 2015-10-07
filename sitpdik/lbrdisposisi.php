<?php
@session_start();

$KdSatker = $_SESSION['MM__AdminIdDeputi'];
	include_once "includes/includes.php";
	checkauthentication();
	$session_name = "Kh41r4";

//include("inc.php");
//CheckAuthentication();


$oEdit = mysql_query("SELECT * FROM suratmasuk WHERE IdSuratMasuk = '".$_GET["id"]."'") or die(mysql_error());

	if (mysql_num_rows($oEdit) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$Edit	= mysql_fetch_object($oEdit);
							$IdSifat 			= $Edit->IdSifat;
							$IdKategori			= $Edit->IdKategori;
							$IdKlasifikasi		= $Edit->IdKlasifikasi;
							$TglTerima			= $Edit->TglTerima;
							$NoSurat			= $Edit->NoSurat;
							$TglSurat			= $Edit->TglSurat;
							$AsalSurat			= $Edit->AsalSurat;
							$Perihal			= $Edit->Perihal;
							$Lampiran			= $Edit->Lampiran;
							$TujuanSurat		= $Edit->TujuanSurat;
							$Retensi			= $Edit->Retensi;
							$LokasiFile			= $Edit->LokasiFile;
							$TujuanSurat		= $Edit->TujuanSurat;
							$Keterangan			= $Edit->Keterangan;
	}

define('FPDF_FONTPATH','lib/fpdf17/font/');
require('lib/fpdf17/fpdf.php');

class PDF extends FPDF {
/**
	function Header()
	 {
	 $this->Ln();
		$this->Cell(19,0,'',1,0);
	}
		function Footer() {
		$this->Cell(19,0,'',1,0);
		$this->SetY(-1.5);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,1,'Halaman '.$this->PageNo().'/{nb}',0,0,'L');
		$tanggal=date("d M Y",time());
		$this->SetFont('Arial','',10);
		$this->Cell(0,1,'Dicetak tanggal: '.$tanggal,0,0,'R');
	}
**/

/**
 * Draws text within a box defined by width = w, height = h, and aligns
 * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
 * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
 * drawTextBox uses drawRows
 *
 * This function is provided by TUFaT.com
 */
function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=true)
{
	$xi=$this->GetX();
	$yi=$this->GetY();
	
	$hrow=$this->FontSize;
	$textrows=$this->drawRows($w,$hrow,$strText,0,$align,0,0,0);
	$maxrows=floor($h/$this->FontSize);
	$rows=min($textrows,$maxrows);

	$dy=0;
	if (strtoupper($valign)=='M')
		$dy=($h-$rows*$this->FontSize)/2;
	if (strtoupper($valign)=='B')
		$dy=$h-$rows*$this->FontSize;

	$this->SetY($yi+$dy);
	$this->SetX($xi);

	$this->drawRows($w,$hrow,$strText,0,$align,false,$rows,1);

	if ($border)
		$this->Rect($xi,$yi,$w,$h);
}

function drawRows($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0, $prn=0)
{
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$b=0;
	if($border)
	{
		if($border==1)
		{
			$border='LTRB';
			$b='LRT';
			$b2='LR';
		}
		else
		{
			$b2='';
			if(is_int(strpos($border,'L')))
				$b2.='L';
			if(is_int(strpos($border,'R')))
				$b2.='R';
			$b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
		}
	}
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$ns=0;
	$nl=1;
	while($i<$nb)
	{
		//Get next character
		$c=$s[$i];
		if($c=="\n")
		{
			//Explicit line break
			if($this->ws>0)
			{
				$this->ws=0;
				if ($prn==1) $this->_out('0 Tw');
			}
			if ($prn==1) {
				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			}
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border && $nl==2)
				$b=$b2;
			if ( $maxline && $nl > $maxline )
				return substr($s,$i);
			continue;
		}
		if($c==' ')
		{
			$sep=$i;
			$ls=$l;
			$ns++;
		}
		$l+=$cw[$c];
		if($l>$wmax)
		{
			//Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws=0;
					if ($prn==1) $this->_out('0 Tw');
				}
				if ($prn==1) {
					$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
				}
			}
			else
			{
				if($align=='J')
				{
					$this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					if ($prn==1) $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				}
				if ($prn==1){
					$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
				}
				$i=$sep+1;
			}
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border && $nl==2)
				$b=$b2;
			if ( $maxline && $nl > $maxline )
				return substr($s,$i);
		}
		else
			$i++;
	}
	//Last chunk
	if($this->ws>0)
	{
		$this->ws=0;
		if ($prn==1) $this->_out('0 Tw');
	}
	if($border && is_int(strpos($border,'B')))
		$b.='B';
	if ($prn==1) {
		$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
	}
	$this->x=$this->lMargin;
	return $nl;
}

}
$pdf=new PDF('P','mm','A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln();
//images
//$img = "{$cell[0][0]}.jpg";
//$pdf->Image("images/logo_batan.gif",20,20,20);
//
		/*$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(0);
		$pdf->Ln(15);
		$pdf->Cell(140,10,'BADAN TENAGA NUKLIR NASIONAL',0,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->Ln();
		*/
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(190,8,'LEMBAR DISPOSISI',0,0,'C');
		$pdf->Ln();
		$pdf->Cell(190,8,'DIREKTUR JENDRAL KEBUDAYAAN',0,0,'C');
		$pdf->Ln();
		$pdf->Cell(190,8,'KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN',0,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Times','',11);
		$pdf->Cell(190,6,'PERHATIAN : Dilarang memisah sehelai suratpun yang tergabung dalam surat ini',0,0,'C');
		//$pdf->Ln();
		if ($IdSifat=='01') {
		$R = 'X';
		} else if ($IdSifat=='02') {
		$P = 'X';
		} else if ($IdSifat=='04') {
		$B = 'X';}
/*		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(150);
		$pdf->Cell(15,5,'Rahasia  :  '. $R ,0,0,'L');
		$pdf->Ln();
		$pdf->Cell(150);
		$pdf->Cell(15,5,'Penting  :  '. $P,0,0,'L');
		$pdf->Ln();
		$pdf->Cell(150);
		$pdf->Cell(15,5,'Biasa      :  '. $B,0,0,'L');
*/

$pdf->Ln(10);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,10,' ','LTB',0,'L');
$pdf->Cell(47,10,'RAHASIA','RTB',0,'L');
$pdf->Cell(15,10,' ','LTB',0,'L');
$pdf->Cell(46,10,'PENTING','TBR',0,'L');
$pdf->Cell(15,10,' ','LTB',0,'L');
$pdf->Cell(47,10,'SEGERA','TBR',0,'L');
$pdf->SetX(15);
$pdf->drawTextBox(  $R, 10, 8, 'C', 'M');
$pdf->SetY(44);
$pdf->SetX(77);
$pdf->drawTextBox(  $R, 10, 8, 'C', 'M');
$pdf->SetY(44);
$pdf->SetX(138);
$pdf->drawTextBox(  $R, 10, 8, 'C', 'M');

$pdf->SetY(54);
//$pdf->Ln();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(95,13,'NOMOR AGENDA :','LBR',0,'L');
$pdf->Cell(90,13,'TANGGAL  :  ','BR',0,'L');
$pdf->Ln(2);
$pdf->SetX(41);
$pdf->drawTextBox(  $NoSurat, 62, 6, 'L', 'M');
$pdf->SetY(56);
$pdf->SetX(127);
$pdf->drawTextBox(  substr($TglSurat,8,1), 10, 6, 'C', 'M');
$pdf->SetY(56);
$pdf->SetX(137);
$pdf->drawTextBox(  substr($TglSurat,9,1), 10, 6, 'C', 'M');
$pdf->SetY(56);
$pdf->SetX(150);
$pdf->drawTextBox(  substr($TglSurat,5,1), 10, 6, 'C', 'M');
$pdf->SetY(56);
$pdf->SetX(160);
$pdf->drawTextBox(  substr($TglSurat,6,1), 10, 6, 'C', 'M');
$pdf->SetY(56);
$pdf->SetX(173);
$pdf->drawTextBox(  substr($TglSurat,2,1) , 10, 6, 'C', 'M');
$pdf->SetY(56);
$pdf->SetX(183);
$pdf->drawTextBox(  substr($TglSurat,3,1), 10, 6, 'C', 'M');
/**/
$pdf->SetXY(127,63);
$pdf->Cell(20,3,'Tanggal',0,0,'C');
$pdf->SetXY(150,63);
$pdf->Cell(20,3,'Bulan',0,0,'C');
$pdf->SetXY(173,63);
$pdf->Cell(20,3,'Tahun',0,0,'C');
$pdf->Ln();
$pdf->Cell(40,10,'ASAL','LB',0,'L');
$pdf->Cell(145,10,': ' . $AsalSurat ,'RB',0,'L');
$pdf->Ln();
$pdf->Cell(40,10,'PERIHAL','LB',0,'L');
$b=$pdf->GetY();
$pdf->Cell(2,10,': ','B',0,'L');
$pdf->MultiCell(143,10,$Perihal,'RB','L');
$e=$pdf->GetY();
$c=$b + 10;
$p=$e - $c;
$pdf->SetXY(10,$c);
$pdf->Cell(40,$p,'','LB',0,'L');

$pdf->Ln();
$pdf->Cell(40,10,'Diterima Tanggal','LBT',0,'L');
$pdf->Cell(145,10,': '.ViewDateTimeFormat($TglTerima, 6)  ,'R,B',0,'L');
$pdf->Ln();
$pdf->Cell(40,10,'Tanggal Penyelesaian','L,B',0,'L');
$pdf->Cell(145,10,': ','RB',0,'L');
$pdf->Ln();
$pdf->Cell(100,10,'DITERUSKAN KEPADA','L',0,'L');
$pdf->Cell(85,10,'INSTRUKSI / INFORMASI',1,0,'L');
$pdf->Ln();

/**
$sql = mysql_query("SELECT * from disposisi where NoSurat = '".$NoSurat."'") or die(mysql_error());
	if (mysql_num_rows($sql) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$hdisposisi	= mysql_fetch_object($sql);
							$IdDisposisi		= $hdisposisi->IdDisposisi;
							$NoSurat			= $hdisposisi->NoSurat;
							$TglDisposisi		= $hdisposisi->TglDisposisi;
							$IdPenerima			= $hdisposisi->IdPenerima;
							$IdPengirim			= $hdisposisi->IdPengirim;
							$Instruksi			= $hdisposisi->Instruksi;
							$TglBaca			= $hdisposisi->TglBaca;
							$ParentId			= $hdisposisi->ParentId;
	}
$pdf->MultiCell(140,10,$Instruksi,'LR','L',0);
$pdf->MultiCell(45,10,$IdPenerima,'LR','L',0);
*/

// ini bagian isi
//$sql="SELECT * from disposisi where NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". $KdSatker ."' ";
$sql="SELECT * from disposisi where NoSurat = '".$NoSurat."'  ";
if (!$res=mysql_query($sql)) {
  echo mysql_error();
  return 0;
}
$i=0;
while ($row=mysql_fetch_row($res)) {
  $cell[$i][0]=$row[0];
  $cell[$i][1]=$row[1];
  $cell[$i][2]=$row[2];
  $cell[$i][3]=$row[3];
  $cell[$i][4]=$row[4];
  $cell[$i][5]=$row[5];
  $cell[$i][6]=$row[6];
  $cell[$i][7]=$row[7];
   $i++;
}

for ($j=0;$j<$i;$j++) {
	$m=$pdf->GetY();
//diganti, aslinya 260 ajie noorseto
	if($m>240)
	{
//diganti , aslinya 250	ajie noorseto
		$m = $m - 230;
		$pdf->AddPage();
		$m=$pdf->GetY();
	}
	$max=$m;
	$pdf->MultiCell(10,5,$j+1 .'.','L','L');

	$e=$pdf->GetY();
	$pdf->SetXY(15,$m);
	$pdf->MultiCell(95,5,'Oleh  '. GetNama($cell[$j][4]) .'  ke  ' . GetNama($cell[$j][3]) . '  pada  ' . ViewDateTimeFormat($cell[$j][2],2),'R','L',0);

	$f=$pdf->GetY();
	$pdf->SetXY(110,$m);
	$pdf->MultiCell(85,5,$cell[$j][5] ,'R','L',0);

	$g=$pdf->GetY();
	$max=(int) max($m,$e,$f,$g);

	$pdf->SetXY(10,$m);
	$pdf->Cell(100,$max-$m,'','LR',0,'L');
	$pdf->Cell(85,$max-$m,'','LR',0,'L');
	$pdf->Ln();
}

$pdf->Cell(100,10,'CATATAN','LRT',0);
$pdf->Cell(85,10,'PARAF DAN TANGGAL','LRT',0);
$pdf->Ln();
$pdf->Cell(100,20,'','LRB',0);
$pdf->Cell(85,20,'','LRB',0);
//$pdf->SetXY(10,$m);
//	$pdf->Cell(100,0,'x','LR',0,'L');
//	$pdf->Cell(85,0,'y','LR',0,'L');

$pdf->Output();
?>