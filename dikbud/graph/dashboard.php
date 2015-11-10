<html>
<head>
    <title>Contoh-Tampilan-Dashboard</title>

    <link class="include" rel="stylesheet" type="text/css" href="jquery.jqplot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="jquery.min.js"></script>
	<script class="include" type="text/javascript" src="jquery.jqplot.min.js"></script>
	<script class="include" type="text/javascript" src="plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="plugins/jqplot.highlighter.min.js"></script>

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
	$rec1 = mysql_query("select * from r_keuangan where tahun='2013' order by bulan", $id);
	echo "[";
	$first = true;
	while($row=mysql_fetch_array($rec1)) {
		if($first) {
			$first=false;
		}
		else {
			echo ",";
		}
		echo "[" . $row['bulan'] . "," . $row['rencana'] . "]";
	}
	echo "]";
?>
;
  var d2 = <?php
	$rec2 = mysql_query("select * from r_keuangan where tahun='2013' order by bulan", $id);
	echo "[";
	$first = true;
	while($row=mysql_fetch_array($rec2)) {
		if($first) {
			$first=false;
		}
		else {
			echo ",";
		}	
		echo "[" . $row['bulan'] . "," . $row['realisasi'] . "]";
	}
	echo "]";
?>
;
  var plot1 = $.jqplot('chart1', [d1, d2], 
    { 
		title:'Grafik Realisasi Keuangan', 
		// Set default options on all series, turn on smoothing.
		seriesDefaults: {
          rendererOptions: {
              smooth: true
          }
		},
		animate : true,
		highlighter: {
            show: true,
			fadeTooltip: true,
			tooltipFadeSpeed: "slow",
			tooltipAxes: 'y',
            sizeAdjust: 10,
            tooltipOffset: 5
        },
		legend: {
			show: true,
			placement: 'outside'
			//location: 'se',     // compass direction, nw, n, ne, e, se, s, sw, w.
			//xoffset: 12,        // pixel offset of the legend box from the x (or x2) axis.
			//yoffset: 12,        // pixel offset of the legend box from the y (or y2) axis.
		},
		axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Bulan",
		  tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		  min: 0,
		  max: 12,
		  tickInterval: 1,
          // Turn off "padding".  This will allow data point to lie on the
          // edges of the grid.  Default padding is 1.2 and will keep all
          // points inside the bounds of the grid.
          pad: 0
        },
        yaxis: {
          label: "Prosentase", 
		  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		  pad: 0
        }
      },
		
      // Series options are specified as an array of objects, one object
      // for each series.
      series:[ 
          {
            // Change our line width and use a diamond shaped marker.
            label: "Rencana",
			lineWidth:3, 
            markerOptions: { style:'diamond' }
          },  
          {
            // Use a thicker, 3 pixel line and 10 pixel
            // filled square markers.
			label: "Realisasi",
            lineWidth:3, 
            markerOptions: { style:"filledSquare", size:10 }
          }
      ]
    }
  );
   
});
</script>

<div id="chart1" style="height:400px; width:600px;"></div>
</body>
</html>
