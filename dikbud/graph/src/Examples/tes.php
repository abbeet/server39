<?
include ("../jpgraph.php");
include ("../jpgraph_bar.php");
//include ("../jpgraph_pie.php");
//include ("../jpgraph_pie3d.php");

$db = mysql_connect("localhost","root","bidsi") or die (mysql_error());
mysql_select_db("datainduksip",$db) or die (mysql_error());
$sql = mysql_query("select * from tbgrafik_tem") or die(mysql_error());

while ($row = mysql_fetch_array($sql))
{
$data[] = $row[1];
//$leg[] = $row[0];
}
$tes = mysql_query("select SbX from tbgrafik_tem where SbX='010109'") or die(mysql_error());

//$leg = $tes;



$graph = new Graph(1000,600,"center");
$graph->SetScale('textint');
$graph->img->SetMargin(50,30,50,50);
$graph->SetShadow();
$graph->title->Set("Grafik Batang");
$graph->xaxis->SetTickLabels($leg);
$graph->legend->Pos(0.1,0.09);

$bplot = new BarPlot($data);
$bplot->value->Show();
$bplot->value->SetFont(FF_ARIAL,FS_BOLD);
$bplot->value->SetAngle(45);
$bplot->SetLegend("Data");
//$bplot->SetLegend('Label 1');
//$bplot->SetLegend('Label 2');
//$bplot->SetLegend('Label 3');
$bplot->SetFillColor(array('red','blue','green','yellow','orange','black','gray','cyan','magenta','purple','pink')); 
$graph->Add($bplot);
$graph->Stroke();
?>