<?php 
	$th = $_SESSION['xth'];
	$kdsatker = $_REQUEST['kdsatker'];
?>
<html>
<head>
<title>Grafik Realisasi</title>
<link rel="stylesheet" href="style.css">
<script language="javascript" src="menus/monitoring/FusionCharts.js"></script>
</head>
<body>	
<h3><strong>Grafik Realisasi Anggaran Tahun <?php echo $th ?><br><?php echo 'Satker : '.$kdsatker ?></strong></h3>
<div id="grafik">
	bagian ini akan direplace dengan tampilan grafik.
</div>
<script type="text/javascript">
	var chart2 = new FusionCharts("menus/monitoring/FCF_StackedColumn2D.swf", "ChId1", "1000", "600");
	chart2.setDataURL("menus/monitoring/data_ang_satker.php?kdsatker=<?php echo $kdsatker ?>");
	chart2.render("grafik");
</script>
</body>
</html>