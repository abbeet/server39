<?
$th = $_REQUEST['th'];
$bl = date("m");
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
					from d_trktrm WHERE THANG='$th' group by THANG";
$aGiat = mysql_query($sql);
$Giat = mysql_fetch_array($aGiat);
$pagu_1 = $Giat['JML01']/1000000000 ;
$pagu_2 = $Giat['JML02']/1000000000 ;
$pagu_3 = $Giat['JML03']/1000000000 ;
$pagu_4 = $Giat['JML04']/1000000000 ;
$pagu_5 = $Giat['JML05']/1000000000 ;
$pagu_6 = $Giat['JML06']/1000000000 ;
$pagu_7 = $Giat['JML07']/1000000000 ;
$pagu_8 = $Giat['JML08']/1000000000 ;
$pagu_9 = $Giat['JML09']/1000000000 ;
$pagu_10 = $Giat['JML10']/1000000000 ;
$pagu_11 = $Giat['JML11']/1000000000 ;
$pagu_12 = $Giat['JML12']/1000000000 ;

$real_1 = real_menteri_sdbulan($th,1)/1000000000 ;
$real_2 = real_menteri_sdbulan($th,2)/1000000000 ;
$real_3 = real_menteri_sdbulan($th,3)/1000000000 ;
$real_4 = real_menteri_sdbulan($th,4)/1000000000 ;
$real_5 = real_menteri_sdbulan($th,5)/1000000000 ;
$real_6 = real_menteri_sdbulan($th,6)/1000000000 ;
$real_7 = real_menteri_sdbulan($th,7)/1000000000 ;
$real_8 = real_menteri_sdbulan($th,8)/1000000000 ;
$real_9 = real_menteri_sdbulan($th,9)/1000000000 ;
$real_10 = real_menteri_sdbulan($th,10)/1000000000 ;
$real_11 = real_menteri_sdbulan($th,11)/1000000000 ;
$real_12 = real_menteri_sdbulan($th,12)/1000000000 ;
	
switch ($bl)
{
	case 1:
	$sbx_grafik_2 = array($real_1);
	break;
	
	case 2:
	$sbx_grafik_2 = array($real_1,$real_2);
	break;
	
	case 3:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3);
	break;
	
	case 4:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4);
	break;
	
	case 5:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5);
	break;
	
	case 6:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6);
	break;
	
	case 7:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6,$real_7);
	break;
	
	case 8:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6,$real_7,$real_8);
	break;
	
	case 9:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6,$real_7,$real_8,$real_9);
	break;
	
	case 10:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6,$real_7,$real_8,$real_9,$real_10);
	break;
	
	case 11:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6,$real_7,$real_8,$real_9,$real_10,$real_11);
	break;
	
	case 12:
	$sbx_grafik_2 = array($real_1,$real_2,$real_3,$real_4,$real_5,$real_6,$real_7,$real_8,$real_9,$real_10,$real_11,$real_12);
	break;
}	
$sbx_grafik_1 = array($pagu_1,$pagu_2,$pagu_3,$pagu_4,$pagu_5,$pagu_6,$pagu_7,$pagu_8,$pagu_9,$pagu_10,$pagu_11,$pagu_12);

$leg		= array("Jan","Peb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nop","Des");

$graph = new Graph(1500,800,"auto");
$graph->SetScale('textint');
$graph->img->SetMargin(50,50,50,50);
$graph->SetShadow();
$graph->title->Set("Realisasi Anggaran Tahun ".$th);
$graph->subtitle->Set(nm_unit('480000'));

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
$bplot1->value->SetFont(FF_ARIAL,FS_BOLD,10);
$bplot1->value->SetAngle(10);
//$bplot1->SetCenter(0.4,0.5); 
$bplot1->SetCenter(1,2); 
$bplot1->SetLegend("Rencana Penarikan (Miliyar Rupiah)");
$graph->Add($bplot1);

$bplot2 = new LinePlot($sbx_grafik_2);
$bplot2->mark->SetType(MARK_FILLEDCIRCLE);
$bplot2->mark->SetFillColor("yellow");
$bplot2->mark->SetWidth(8);
$bplot2->SetColor("red");
$bplot2->SetWeight(3);
$bplot2->value->Show();
$bplot2->value->SetFont(FF_ARIAL,FS_BOLD,10);
$bplot2->value->SetAngle(10);
//$bplot2->SetCenter(0.4,0.5);
$bplot1->SetCenter(1,2); 
$bplot2->SetLegend("Realisasi (Miliyar Rupiah)");
$graph->Add($bplot2);

$graph->Stroke();

?>

