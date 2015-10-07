<?php
checkauthentication();
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$q = ekstrak_get(@$get[1]);
	
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 
?>

<html>
<head>
<title>Administrator List - <?=$Site_Name?></title>

<!--	<link rel='STYLESHEET' type='text/css' href='/lib/dhtmlxGrid/codebase/dhtmlxgrid.css'>    -->
		<link rel='stylesheet' type='text/css' href='lib/dhtmlxGrid/codebase/dhtmlxgrid.css'>
	<link rel="stylesheet" type="text/css" href="lib/dhtmlxGrid/codebase/skins/dhtmlxgrid_dhx_blue.css">  
	
	<script src='lib/dhtmlxGrid/codebase/dhtmlxcommon.js'></script>
	<script src='lib/dhtmlxGrid/codebase/dhtmlxgrid.js'></script>	
	<script src='lib/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js'></script>		
	<!--<script src='///lib/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor_debug.js'></script>-->
	<script src='lib/dhtmlxGrid/codebase/ext/dhtmlxgrid_filter.js'></script>		
	<script src='lib/dhtmlxGrid/codebase/ext/dhtmlxgrid_srnd.js'></script>		
	<script src='lib/dhtmlxGrid/codebase/dhtmlxgridcell.js'></script>	
	<script src='lib/codebase/connector.js'></script>	
	

</head>

<body>
	<div id="gridbox" width="1000px" height="450px" style="background-color:white;"></div>


 <script>
	mygrid = new dhtmlXGridObject('gridbox');
<!--	mygrid.setSkin('gridbox_light');            -->
	mygrid.setImagePath('lib/dhtmlxGrid/codebase/imgs/');
	mygrid.setHeader("Action, No Surat, Asal Surat, Perihal, Tanggal Terima [Tahun-Bulan-Tanggal] ");
	mygrid.attachHeader("#connector_text_filter,#connector_text_filter,#connector_text_filter,#connector_text_filter,#connector_text_filter");

	mygrid.setSkin("dhx_blue"); 


	mygrid.attachEvent("onRowSelect");
	mygrid.setInitWidths("50,190,100,500,150");
	mygrid.setColTypes("ro,ro,ro,ro,ro");
	mygrid.setColSorting("connector,connector,connector,connector,connector");
	mygrid.enableSmartRendering(true);
	mygrid.enableMultiselect(true)


	mygrid.init();
	mygrid.loadXML("menus/surat_masuk/01_basic_connector.php");

	var dp = new dataProcessor("menus/surat_masuk/01_basic_connector.php");
	dp.init(mygrid);
</script>
 </body>
