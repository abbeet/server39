<html>
<head>

    <link class="include" rel="stylesheet" type="text/css" href="jquery.jqplot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="graph/jquery.min.js"></script>
	<script class="include" type="text/javascript" src="graph/jquery.jqplot.min.js"></script>
	<script class="include" type="text/javascript" src="graph/plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="graph/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="graph/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="graph/plugins/jqplot.pointLabels.min.js"></script>
	<!--script class="include" type="text/javascript" src="graph/plugins/jqplot.highlighter.min.js"></script-->

</head>
<body>

<?php
	$xusername = $_SESSION['xusername'] ;
	$xlevel = $_SESSION['xlevel'] ;
	$th = $_SESSION['xth'];
	$kdsatker = $_REQUEST['kdsatker'];
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
			$aDept = mysql_query($sql);
			$Dept = mysql_fetch_array($aDept);
			$kddept = $Dept['KDDEPT'];
			$kdunit = $Dept['KDUNIT'];
			
			if ( $kdsatker == '' )
			{
			$sql = "select sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML_1,
					sum(JML01+JML02) as JML_2,
					sum(JML01+JML02+JML03) as JML_3,
					sum(JML01+JML02+JML03+JML04) as JML_4,
					sum(JML01+JML02+JML03+JML04+JML05) as JML_5,
					sum(JML01+JML02+JML03+JML04+JML05+JML06) as JML_6,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07) as JML_7,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08) as JML_8,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09) as JML_9,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10) as JML_10,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11) as JML_11,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11+JML12) as JML_12
					from d_trktrm WHERE THANG = '$th' group by THANG";
			}else{
			$sql = "select sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML_1,
					sum(JML01+JML02) as JML_2,
					sum(JML01+JML02+JML03) as JML_3,
					sum(JML01+JML02+JML03+JML04) as JML_4,
					sum(JML01+JML02+JML03+JML04+JML05) as JML_5,
					sum(JML01+JML02+JML03+JML04+JML05+JML06) as JML_6,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07) as JML_7,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08) as JML_8,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09) as JML_9,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10) as JML_10,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11) as JML_11,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11+JML12) as JML_12
					from d_trktrm WHERE THANG = '$th' and KDSATKER = '$kdsatker' group by THANG";
			}
			$aGiat = mysql_query($sql);
			$Giat = mysql_fetch_array($aGiat);

			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_1 = $Giat['JML_1']/$Giat['RPHPAGU']*100 ;
			else $pagu_1 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_2 = $Giat['JML_2']/$Giat['RPHPAGU']*100 ;
			else $pagu_2 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_3 = $Giat['JML_3']/$Giat['RPHPAGU']*100 ;
			else $pagu_3 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_4 = $Giat['JML_4']/$Giat['RPHPAGU']*100 ;
			else $pagu_4 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_5 = $Giat['JML_5']/$Giat['RPHPAGU']*100 ;
			else $pagu_5 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_6 = $Giat['JML_6']/$Giat['RPHPAGU']*100 ;
			else $pagu_6 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_7 = $Giat['JML_7']/$Giat['RPHPAGU']*100 ;
			else $pagu_7 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_8 = $Giat['JML_8']/$Giat['RPHPAGU']*100 ;
			else $pagu_8 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_9 = $Giat['JML_9']/$Giat['RPHPAGU']*100 ;
			else $pagu_9 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_10 = $Giat['JML_10']/$Giat['RPHPAGU']*100 ;
			else $pagu_10 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_11 = $Giat['JML_11']/$Giat['RPHPAGU']*100 ;
			else $pagu_11 = 0 ;
			if ( $Giat['RPHPAGU'] <> 0 )   $pagu_12 = $Giat['JML_12']/$Giat['RPHPAGU']*100 ;
			else $pagu_12 = 0 ;
			
			if ( $kdsatker == '' )   $pagu = pagu_menteri($th);
			else  $pagu = pagu_satker($th,$kdsatker) ;
			
			for ( $i = 1 ; $i <= 12 ; $i++ ) 
			{
			if ( $kdsatker == '' )
			{
			$real_r[$i]  = real_menteri_spm_sdbulan($th,$kddept,$kdunit,$i);
			if ( $pagu <> 0 )  $real_p[$i]  = $real_r[$i]/$pagu*100;
			else  $real_p[$i]  = 0 ;
			}else{
			$real_r[$i]  = real_satker_spm_sdbulan($th,$kdsatker,$i);
			if ( $pagu <> 0 )  $real_p[$i]  = $real_r[$i]/$pagu*100;
			else $real_p[$i]  = 0 ;
			}
			
			if ( $th == Date("Y") ) {
			
			if ( Date("m") < $i ) $real_p[$i] = '';
			if ( Date("m") < $i ) $real_r[$i] = '';
			
			}
			
			}
		
			$leg	= array("","Jan","Peb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nop","Des");
			$pagu_p = array("",$pagu_1,$pagu_2,$pagu_3,$pagu_4,$pagu_5,$pagu_6,$pagu_7,$pagu_8,$pagu_9,$pagu_10,$pagu_11,$pagu_12);
			
			mysql_query("DELETE FROM das_real_ang_dept WHERE tahun = '$th' and kdsatker = '$kdsatker'");
			for ( $i = 1 ; $i <= 12 ; $i++ ) 
			{ 
				$pagu_r = 'JML_'.$i ;
				mysql_query("INSERT INTO das_real_ang_dept ( tahun , kdsatker , kdbulan , nmbulan , pagu_r , pagu_p , real_r , real_p)
							VALUES ( '$th' , '$kdsatker' , '$i' , '$leg[$i]' , '$Giat[$pagu_r]' , '$pagu_p[$i]' , '$real_r[$i]' , '$real_p[$i]' )");
			}
			
?>
<script class="code" type="text/javascript">
$(document).ready(function(){
  var d1 = <?php
	$sql = "select * from das_real_ang_dept WHERE tahun = '$th' and kdsatker = '$kdsatker' ORDER BY kdbulan";
	$rec1 = mysql_query($sql);
//	$rec1 = mysql_query("select * from r_keuangan where tahun='2013' order by bulan", $id);
	echo "[";
	$first = true;
	while($row=mysql_fetch_array($rec1)) {
		if($first) {
			$first=false;
		}
		else {
			echo ",";
		}
		echo "[" . $row['kdbulan'] . "," . $row['pagu_p'] . "]";
	}
	echo "]";
?>
;
  var d2 = <?php
	$sql = "select * from das_real_ang_dept WHERE tahun = '$th' and kdsatker = '$kdsatker' ORDER BY kdbulan";
	$rec2 = mysql_query($sql);
	echo "[";
	$first = true;
	while($row2=mysql_fetch_array($rec2)) {
	
	if ( $th == Date("Y") ) {
	
		if ( $row2['kdbulan'] <= date("m") )  $real_p = $row2['real_p'] ;
		else $real_p = '' ;
	
	}else{
	
		$real_p = $row2['real_p'] ;
		
	}
	
		if($first) {
			$first=false;
		}
		else {
			echo ",";
		}	
		echo "[" . $row2['kdbulan'] . "," . $real_p . "]";
	}
	echo "]";
?>
;
  var plot1 = $.jqplot('chart1', [d1, d2], 
    { 
		// title: 'Testing', 
		// Set default options on all series, turn on smoothing.
		seriesDefaults: {
          rendererOptions: {
              smooth: true
          },
		  pointLabels: { show: true},
		},
		animate : true,
		//highlighter: {
        //    show: true,
		//	fadeTooltip: true,
		//	tooltipFadeSpeed: "slow",
        //    sizeAdjust: 8,
        //    tooltipOffset: 4
        //},
		//legend: {
			//show: true,
            //placement: 'outside',
			//location: 'se',     // compass direction, nw, n, ne, e, se, s, sw, w.
			//xoffset: 100,        // pixel offset of the legend box from the x (or x2) axis.
			//yoffset: 100,        // pixel offset of the legend box from the y (or y2) axis.
		//},
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
		  tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		  min: 0,
		  max: 100,
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
            markerOptions: { style:"filledSquare", size:8 }
          }
      ]
    }
  );
   
});
</script>

<?php 
extract($_POST);
$xmenu_p = xmenu_id($p);
$p_next = $xmenu_p->parent;
?>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
</div><br><br>
<!-- div id="chart1" style="height:300px; width:500px;"></div --><br>
<table width="1000" border="0" bgcolor="">
  <tr>
    <td width="629" align="center"><div id="chart1" style="height:315px; width:600px;"></div></td>
    <td width="377">
	
	<table width="359" cellpadding="1" border="1" align="left">
  <thead>
    <tr bgcolor="#6666FF">
      <th width="43" rowspan="3" align="center"><font color="#FFFFFF">BLN</font></th>
      
      <th colspan="4" align="center"><font color="#FFFFFF">Anggaran</font></th>
      </tr>
    <tr bgcolor="#6666FF"> 
      <th colspan="2" align="center"><font color="#FFFFFF">Rencana</font></th>
      <th colspan="2" align="center"><font color="#FFFFFF">Realisasi</font></th>
    </tr>
    <tr bgcolor="#6666FF">
      <th width="79" align="center">Rp.</th>
      <th width="62" align="center">%</th>
      <th width="79" align="center">Rp.</th>
      <th width="62" align="center">%</th>
    </tr>
  </thead>
  <tbody>
	<?php 
	$sql = "select * from das_real_ang_dept WHERE tahun = '$th' and kdsatker = '$kdsatker' ORDER BY kdbulan";
	$aData = mysql_query($sql);
	while( $Data = mysql_fetch_array($aData)) { ?>
    <tr bordercolor="#66CCFF" bgcolor="#E2EAFE">
      <td align="center"><?php echo $Data['kdbulan'] ?></td> 
     
      <td align="right"><?php echo number_format($Data['pagu_r'],"0",",",".") ?></td>
      <td align="center"><?php echo number_format($Data['pagu_p'],"2",",",".").' %' ?></td>
      <td align="right"><?php echo number_format($Data['real_r'],"2",",",".") ?></td>
      <td align="center"><?php echo number_format($Data['real_p'],"2",",",".").' %' ?></td>
    </tr>
	<?php } ?>
  <tfoot>
  </tfoot>
</table>	</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
</body>
</html>
