<html>
<head>
    <title>Contoh-Tampilan-Dashboard</title>

    <link class="include" rel="stylesheet" type="text/css" href="jquery.jqplot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="jquery.min.js"></script>
	<script class="include" type="text/javascript" src="jquery.jqplot.min.js"></script>
	
	<script class="include" type="text/javascript" src="plugins/jqplot.barRenderer.min.js"></script>
    <script class="include" type="text/javascript" src="plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script class="include" type="text/javascript" src="plugins/jqplot.pointLabels.min.js"></script>
	<script class="include" type="text/javascript" src="plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>

</head>
<body>
<p>Tampilan Dashboard</p>
<p>
<?php
	$id = mysql_connect("127.0.0.1","root","bidsi");
	mysql_select_db("dashboard");
?>
<script class="code" type="text/javascript">
$(document).ready(function(){
  var d1 = <?php
	$rec1 = mysql_query("select * from r_fisik where tahun='2013' order by triwulan", $id);
	echo "[";
	$first = true;
	while($row=mysql_fetch_array($rec1)) {
		if($first) {
			$first=false;
		}
		else {
			echo ",";
		}
		echo "[" . $row['triwulan'] . "," . $row['rencana'] . "]";
	}
	echo "]";
?>
;
  var d2 = <?php
	$rec2 = mysql_query("select * from r_fisik where tahun='2013' order by triwulan", $id);
	echo "[";
	$first = true;
	while($row=mysql_fetch_array($rec2)) {
		if($first) {
			$first=false;
		}
		else {
			echo ",";
		}	
		echo "[" . $row['triwulan'] . "," . $row['realisasi'] . "]";
	}
	echo "]";
?>
;
  var plot1 = $.jqplot('chart1', [d1,d2], 
    { 
		title:'Grafik Realisasi Fisik', 
		animate : true,
		// Set default options on all series, turn on smoothing.
		seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
			rendererOptions: {fillToZero: true},
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
            pointLabels: { show: true},
        },
		legend: {
            show: true,
            location: 'e',
            placement: 'outsideGrid'
        },
        axes: {
			xaxis: {
                label: "Triwulan",
				renderer: $.jqplot.CategoryAxisRenderer,
                //ticks: ticks
            },
			yaxis: {
                label: "Prosentase",
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
            }
			
        },
		series:[ 
          {
            // Change our line width and use a diamond shaped marker.
            label: "Rencana"
          },  
          {
            // Use a thicker, 3 pixel line and 10 pixel
            // filled square markers.
			label: "Realisasi"
          }
      ]
  });
   
});
</script>

<div id="chart1" style="height:400px; width:600px;"></div>
</body>
</html>
