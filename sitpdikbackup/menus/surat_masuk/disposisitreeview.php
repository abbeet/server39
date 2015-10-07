<html>
<head>
 <title>Tree</title>
 <style>
  ul{
  	list-style-type:none; /* setiap list dihilangkan penanda setiap list-nya */
  	padding-left: 12px;
  	margin-left: 12px;
  }
  a:link, a:visited{
  	text-decoration: none;
  	font-size: 12px;
  	color: #006;
  }
  a:hover, a:active{
  	text-decoration: underline;
  }
 </style>
 
 <script language="javascript">
  function openTree(id){
  	// ambil semua tag <ul> yang mengandung attribut parent = id dari link yang dipilih
  	var elm = $('ul[@parent='+id+']'); 
  	if(elm != undefined){ // jika element ditemukan
  	  if(elm.css('display') == 'none'){ // jika element dalam keadaan tidak ditampilkan
  	    elm.show(); // tampilkan element 	  	
  	    $('#img'+id).attr('src','images/icons/folderopen.jpg'); // ubah gambar menjadi gambar folder sedang terbuka
  	  }else{
  	  	elm.hide(); // sembunyikan element
  	    $('#img'+id).attr('src','images/icons/folderclose2.jpg'); // ubah gambar menjadi gambar folder sedang tertutup
  	  }
	}
  }
 </script> 
</head>
<body>

 <?php
checkauthentication();
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$q = ekstrak_get(@$get[1]);
	
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 

//include("inc.php");

 
    /* fungsi ini akan terus di looping secara rekursif agar dapat menampilkan menu dengan format tree (pohon)
     * dengan kedalaman jenjang yang tidak terbatas */
 	function loop($data,$parent){
 	  if(isset($data[$parent])){ // jika ada anak dari menu maka tampilkan
 	    /* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element 
 	     * karena bukan merupakan menu utama melainkan sub menu */
 	  	$str = '<ul parent="'.$parent.'" style="display:'.($parent>0?'none':'').'">'; 
 	  	foreach($data[$parent] as $value){
 	  	  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
 	  	   * dan akan bernilai negatif apabila tidak ada sub menu */
		   
		   
				
 	  	  if ($value->TglBaca == "0000-00-00 00:00:00") { 
		  	$statusbaca = "<font color=\"#CC0000\"> Belum dibaca. </font>";
		  } else {
		  	$statusbaca = "Telah dibaca pada ". ViewDateTimeFormat($value->TglBaca) . ".";
		  }
		  
		  $child = loop($data,$value->IdDisposisi); 
		  
 	  	  $str .= '<table><tr><td><li>';
 	  	  /* beri tanda sebuah folder dengan warna yang mencolok apabila terdapat sub menu di bawah menu utama 	  	   
 	  	   * dan beri juga event javascript untuk membuka sub menu di dalamnya */
 	  	  $str .= ($child) ? '<a href="javascript:openTree('.$value->IdDisposisi.')"><img src="images/icons/folderclose2.jpg" id="img'.$value->IdDisposisi.'" border="0"></a>' : '<img src="images/icons/folderclose1.jpg">';
 	  	  $str .= '<a href="'.$value->url.'"></a> => '.GetNama($value->IdPenerima).' pada '.ViewDateTimeFormat($value->TglDisposisi) . ' </td></tr><tr><td><font color=#E238EC>Instruksi/Berita : '.$value->Instruksi.' </font></td></tr><tr><td><font color=#0000FF>Tanggapan : '.$value->Tanggapan.'</font></td></tr><tr><td> Status : ' . $statusbaca . ' </td></tr></table></li>';
 	  	  if($child) $str .= $child;
		}
		
		$str .= '</ul>';
		
		return $str;
		 
	  }else return false;
	   
	}
 	
 	// tampilkan menu di sortir berdasar id dan parent_id agar menu ditampilkan dengan rapih
 	
if (@$_SESSION['xlevel_'.$session_name]=="STAF") {
	
	
 	$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". substr($KdSatker,0,5) ."' ");
 	//$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' ORDER BY IdDisposisi,ParentId ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
	} 	
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". substr($KdSatker,0,5) ."'  ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	echo loop($data,0); // lakukan looping menu utama
}

else if (@$_SESSION['xlevel_'.$session_name]=="ADM") {  	
$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."'  and IdDeputi_Penerima = '" .substr($KdSatker,0,5). "' ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
	} 	
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". substr($KdSatker,0,5) ."'  AND ParentId = 0 ORDER BY IdDisposisi,ParentId  ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	echo loop($data,0); // lakukan looping menu utama
	}

else if (@$_SESSION['xlevel_'.$session_name]=="SUBDIT") {  	
$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."'  and IdDeputi_Penerima = '" .substr($KdSatker,0,5). "' ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
	}
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". substr($KdSatker,0,5) ."'  AND ParentId = 0 ORDER BY IdDisposisi,ParentId  ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	


	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);	
	
	
	echo loop($data,0); // lakukan looping menu utama
	}

else if (@$_SESSION['xlevel_'.$session_name]=="DIT") {  	
 	$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."'  and IdDeputi_Penerima = '" .substr($KdSatker,0,5). "'  ");
 	//$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' ORDER BY IdDisposisi,ParentId ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP


	
	} 	
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' AND ParentId = 0 ORDER BY IdDisposisi,ParentId ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	echo loop($data,0); // lakukan looping menu utama
}

else if (@$_SESSION['xlevel_'.$session_name]=="DITJEN") {  	
	
	
 	$query = mysql_query("SELECT * FROM disposisi LEFT JOIN v_xuser on disposisi.IdPenerima = v_xuser.username where  NoSurat = '".$NoSurat."' and (v_xuser.level = 'DITJEN' or v_xuser.level = 'DIT' or v_xuser.level = 'UPT') ");
 	//$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' ORDER BY IdDisposisi,ParentId ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP


	
	} 
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."'  ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	echo loop($data,0); // lakukan looping menu utama
}

else if (@$_SESSION['xlevel_'.$session_name]=="SEKSI") {  	
 	 	$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". substr($KdSatker,0,5) ."' ");
 	//$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' ORDER BY IdDisposisi,ParentId ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
		
		

	
	} 	
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". substr($KdSatker,0,5) ."' AND ParentId = 0 ORDER BY IdDisposisi,ParentId ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	echo loop($data,0); // lakukan looping menu utama
}

else {
		
	//$query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."' and IdDeputi_Penerima = '". $KdSatker ."' ORDER BY IdDisposisi,ParentId ");
 	// 24/04/2013 $query = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."'   ORDER BY IdDisposisi,ParentId ");
	
	$query = mysql_query("SELECT * FROM disposisi LEFT JOIN v_xuser on disposisi.IdPenerima = v_xuser.username where  NoSurat = '".$NoSurat."' and (v_xuser.level = 'DITJEN' or v_xuser.level = 'DIT' or v_xuser.level = 'UPT') ");
 	$data = array();
 	while($row = mysql_fetch_object($query)){
 	  $data[$row->ParentId][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
		
		

	
	} 	
	$query2 = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat."'  ");

	$parent		= mysql_fetch_object($query2);
		$ParentId	= GetNama($parent->IdPengirim);

	echo "Disposisi awal oleh : ". $ParentId;
	echo loop($data,0); // lakukan looping menu utama
	}
	$query3 = "SELECT COUNT(IdPengirim) AS JumlahDisposisi FROM disposisi WHERE NoSurat = '".$NoSurat."'";
				$result = mysql_query($query3);
				if($result === FALSE) {
					die(mysql_error()); // TODO: better error handling
				}
				while($data=mysql_fetch_array($result)){
				$count = $data['JumlahDisposisi'];
				}
	$query4 = "SELECT COUNT(IdPengirim) AS JumlahDisposisi4 FROM disposisi WHERE NoSurat = '".$NoSurat."' AND TglBaca = '0000-00-00 00:00:00'";
				$result4 = mysql_query($query4);
				if($result4 === FALSE) {
					die(mysql_error()); // TODO: better error handling
				}
				while($data=mysql_fetch_array($result4)){
				$count4 = $data['JumlahDisposisi4'];
				}
	echo "<br>";
	echo "Telah di disposisi sebanyak " . $count . " orang, yang belum membaca sebanyak " . $count4 ." orang.";	
 ?>
</body>
</html>
