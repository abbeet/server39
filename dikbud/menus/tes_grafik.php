<?
include ("../graph/src/jpgraph.php");
include ("../graph/src/jpgraph_line.php");

$sbx_grafik_1 = array(10,20,30,40);
$leg		= array("I","II","III","IV");

$graph = new Graph(1500,800,"auto");
$graph->SetScale('textint');
$graph->img->SetMargin(50,50,50,50);
$graph->SetShadow();
$graph->title->Set("Target Capaian Fisik Kegiatan Tahun ".$ta);
$graph->subtitle->Set("Kode Kegiatan : $kdskeg");

$graph->title->SetFont(FF_ARIAL,FS_BOLD,20);
$graph->subtitle->SetFont(FF_ARIAL,FS_BOLD,18);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,15);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,15);

$graph->xaxis->SetTickLabels($leg);
$graph->legend->Pos(0.1,0.09);
$graph->legend->SetFont(FF_ARIAL,FS_BOLD,15); 
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD,15); 
$graph->xaxis->title->Set("Triwulan");
$graph->yaxis->SetFont(FF_ARIAL,FS_BOLD,15); 
//$graph->yaxis->title->Set("Target (%)");

$graph->legend->Pos(0.8,0.13,"right","center");

//ajie : grafik 1, perencanaan

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
$bplot1->SetLegend("Target (%)");
$graph->Add($bplot1);

$graph->Stroke();

?>

