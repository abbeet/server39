<?
$th = $_REQUEST['th'];
$kdsatker = $_REQUEST['kdsatker'];
include ("../../includes/dbh.php");
include ("../../includes/query.php");
include ("../../includes/functions.php");
include ("../../graph/src/jpgraph.php");
include ("../../graph/src/jpgraph_line.php");

$sql = "select sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML01,
					sum(JML01+JML02) as JML02,
					sum(JML01+JML02+JML03) as JML03,
					sum(JML01+JML02+JML03+JML04) as JML04,
					sum(JML01+JML02+JML03+JML04+JML05) as JML05,
					sum(JML01+JML02+JML03+JML04+JML05+JML06) as JML06,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07) as JML07,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08) as JML08,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09) as JML09,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10) as JML10,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11) as JML11,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11+JML12) as JML12
					from d_trktrm WHERE THANG='2013' AND KDSATKER = '$kdsatker' group by THANG";
$aGiat = mysql_query($sql);
$Giat = mysql_fetch_array($aGiat);
$pagu_1 = $Giat['JML01']/$Giat['RPHPAGU']*100 ;
$pagu_2 = $Giat['JML02']/$Giat['RPHPAGU']*100 ;
$pagu_3 = $Giat['JML03']/$Giat['RPHPAGU']*100 ;
$pagu_4 = $Giat['JML04']/$Giat['RPHPAGU']*100 ;
$pagu_5 = $Giat['JML05']/$Giat['RPHPAGU']*100 ;
$pagu_6 = $Giat['JML06']/$Giat['RPHPAGU']*100 ;
$pagu_7 = $Giat['JML07']/$Giat['RPHPAGU']*100 ;
$pagu_8 = $Giat['JML08']/$Giat['RPHPAGU']*100 ;
$pagu_9 = $Giat['JML09']/$Giat['RPHPAGU']*100 ;
$pagu_10 = $Giat['JML10']/$Giat['RPHPAGU']*100 ;
$pagu_11 = $Giat['JML11']/$Giat['RPHPAGU']*100 ;
$pagu_12 = $Giat['JML12']/$Giat['RPHPAGU']*100 ;
$sbx_grafik_1 = array($pagu_1,$pagu_2,$pagu_3,$pagu_4,$pagu_5,$pagu_6,$pagu_7,$pagu_8,$pagu_9,$pagu_10,$pagu_11,$pagu_12);
$leg		= array("Jan","Peb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nop","Des");

$graph = new Graph(1500,800,"auto");
$graph->SetScale('textint');
$graph->img->SetMargin(50,50,50,50);
$graph->SetShadow();
$graph->title->Set("Rencana Penarikan Anggaran Tahun ".$th);
$graph->subtitle->Set('Satker : '.trim(nm_satker($kdsatker)));

$graph->title->SetFont(FF_ARIAL,FS_BOLD,20);
$graph->subtitle->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,15);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,15);

$graph->xaxis->SetTickLabels($leg);
$graph->legend->Pos(0.1,0.09);
$graph->legend->SetFont(FF_ARIAL,FS_BOLD,15); 
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD,15); 
$graph->xaxis->title->Set("Bulan");
$graph->yaxis->SetFont(FF_ARIAL,FS_BOLD,15); 

$graph->legend->Pos(0.8,0.13,"right","center");


$bplot1 = new LinePlot($sbx_grafik_1);
$bplot1->mark->SetType(MARK_FILLEDCIRCLE);
$bplot1->mark->SetFillColor("red");
$bplot1->mark->SetWidth(8);
$bplot1->SetColor("blue");
$bplot1->SetWeight(3);
$bplot1->value->Show();
$bplot1->value->SetFont(FF_ARIAL,FS_BOLD,15);
$bplot1->value->SetAngle(30);
$bplot1->SetCenter(0.4,0.5); 
$bplot1->SetLegend("Rencana Penarikan (%)");
$graph->Add($bplot1);

$graph->Stroke();

?>

