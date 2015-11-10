

<?php
include ("../jpgraph.php");
include ("../jpgraph_line.php");
include ("../jpgraph_bar.php");

$dataJum = array();
$dataTh = array();

mysql_connect("localhost","root","bidsi");
mysql_select_db("test");

$query = "SELECT tahun, jmlpria + jmlwanita as jum FROM sensus WHERE negara = '$_GET[pil]'";
$hasil = mysql_query($query);
while ($data = mysql_fetch_array($hasil))
{
array_unshift($dataJum, $data['jum']);
array_unshift($dataTh, $data['tahun']);
}

$graph = new Graph(450,300,"auto");
$graph->SetScale("textlin");

// menampilkan plot batang dari data jumlah penduduk
$bplot = new BarPlot($dataJum);
$graph->Add($bplot);

// menampilkan plot garis dari data jumlah penduduk
$lineplot=new LinePlot($dataJum);
$graph->Add($lineplot);


$graph->img->SetMargin(40,20,20,40);
$graph->title->Set("Grafik Jumlah Penduduk Negara A");
$graph->xaxis->title->Set("Tahun");
$graph->yaxis->title->Set("Jumlah");
$graph->xaxis->SetTickLabels($dataTh);

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$lineplot->SetColor("blue");
$bplot->SetFillColor("red");
$blot->SetCenter(0.4,0.5); 

$graph->SetShadow();
$graph->Stroke();
?>