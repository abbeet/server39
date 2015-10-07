<?php
@session_start();
	//$omenu = xmenu("parent", "id = '".$p."'");
	//$xmenu = mysql_fetch_array($omenu);
	//$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	//$q = ekstrak_get(@$get[1]);
	
	
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 

	require_once("../../lib/codebase/config.php");
	$res=mysql_connect($mysql_server,$mysql_user,$mysql_pass);
	mysql_select_db($mysql_db);

	require("../../lib/codebase/grid_connector.php");
	require("../../includes/functions.php");
//	function color_rows($row){
//		if ($row->get_index()%2)
//				$row->set_row_color("pink"); 
//	}
		function formatting($row){
			$suratkeluarviewlink = 78;
                  //render field as details link
                  $data = $row->get_value("IdSuratKeluar");
                 // $row->set_value("TujuanSurat","<a href='details.php?id={$data}'><img src='image/ico_view.gif' alt='Lihat'> </a>");
				  
				//  $row->set_value("DicatatOleh","<a href='surat_masuk_cari_view.php?id={$data}'><img src='images/ico_view.gif' > </a>");
			 $alamat = "index.php?p=" . enkripsi($suratkeluarviewlink . "&q=".$data);
				  //$alamat = "<a href='index.php?p=".enkripsi($suratmasukviewlink ."&q=".$data)."><img src='images/ico_view.gif'></a>";
		  
				  
				 // $row->set_value("DicatatOleh","<a href='index.php?p=\".enkripsi($suratmasukviewlink &q=\{$data})\"><img src=\"images/ico_view.gif\" ></a>");
				   $row->set_value("DicatatOleh","<a href='$alamat'><img src='images/ico_view.gif'></a>");
				  				  
				 
				    $data = $row->get_value("WaktuBuat");
                  $row->set_value("WaktuBuat",date("d-m-Y",strtotime($data)));
 
		}
	$grid = new GridConnector($res);
	
//	$grid->event->attach("beforeRender","color_rows");
	$grid->event->attach("beforeRender","formatting");
	
	
	$grid->enable_log("temp.log",true);
	$grid->dynamic_loading(100);
	//$grid->render_table("country_data","country_id","name,full_name,type,capital");
	//$grid->render_sql("Select * from dtrealisasi_fisik,tbsatker where dtrealisasi_fisik.KdSatker=tbsatker.KdSatker","Id","KdSatker,NmSatker,KdProgram,KdGiat,KdSGiat");
//	$grid->render_table("suratmasuk","IdSuratMasuk","TujuanSurat,NoSurat,AsalSurat,Perihal,TglTerima");
	$grid->render_sql("SELECT * FROM suratkeluar WHERE DicatatOleh = '".$KdSatker."' order by WaktuBuat desc","IdSuratKeluar","DicatatOleh,NoSurat,TujuanSurat,Perihal,WaktuBuat");
	//$grid->render_sql("SELECT * FROM suratmasuk WHERE DicatatOleh = '". $KdSatker."'");
	
?>
