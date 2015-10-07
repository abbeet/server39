<?php
checkauthentication();
	$table = "suratmasuk";
	$field = get_field($table);
	
	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$session_name = "Kh41r4";
	$usernamex = @$_SESSION['xusername_'.$session_name];
	$q = ekstrak_get(@$get[1]);
	$r = ekstrak_get(@$get[2]);
	$adddisposisi = 96;
	$kotaksuratlist = 27;
	$addtanggapan = 98;

@session_start();

$BeritaFlag = "1";	
date_default_timezone_set('Asia/Jakarta');	
$bError		= false;
$sMessage	= "";
	//$Pg	= $_GET["pg"];
	
	$olist = mysql_query("SELECT * FROM berita WHERE IdBerita = '".$r."'") or die(mysql_error());
	$nlist = mysql_num_rows($olist);

	while ($list = mysql_fetch_array($olist))
			{
		
							$IdBerita 			= $list['IdBerita'];
							$Perihal			= $list['Perihal'];
							$Isi				= $list['Isi']; 
							$Pengirim			= $list['Pengirim'];
							$WaktuKirim			= $list['WaktuKirim']; 
							$Penerima			= $list['Penerima']; 
							$WaktuBaca			= $list['WaktuBaca']; 
							$NoSurat			= $list['NoSurat']; 
							$StatusBerita		= $list['StatusBerita']; 
							$StatusDisposisi	= $list['StatusDisposisi']; 
							
							$Disposisi = "Terakhir dibaca oleh " . $susername . " pada " . date( " d F Y  H:i:s");
	if ($WaktuBaca == "0000-00-00 00:00:00") { 
		  	mysql_query("UPDATE berita SET 
							StatusBerita		= '5',
							WaktuBaca			= now()
							WHERE IdBerita = '".$r."'") or die(mysql_error());
	
			mysql_query("UPDATE disposisi SET 
							TglBaca			= now()
							WHERE IdPenerima = '".$susername."' AND NoSurat = '".$NoSurat."'") or die(mysql_error());
							
			mysql_query("UPDATE suratmasuk SET 
							Disposisi		= '".$Disposisi ."' 
							WHERE NoSurat = '".$NoSurat."'") or die(mysql_error());
		  } 					
	}				

?><html lang="en">
<head>
<title>Lihat Surat - <?=$Site_Name?></title>
<meta charset="utf-8" />
<script src="js/jquery-1.2.3.min.js"></script>
<script>

// When the document loads do everything inside here ...
$(document).ready(function(){

// When a link is clicked
$("a.tab").click(function () {

// switch all tabs off
$(".active").removeClass("active");

// switch this tab on
$(this).addClass("active");

// slide all content up
$(".content").slideUp();

// slide this content up
var content_show = $(this).attr("title");
$("#"+content_show).slideDown();

});

});
</script>
<style type="text/css" media="screen">
<!--

.tabbed_area {
border:1px solid #494e52;
padding:8px;
}

div.tabs {
margin-top:5px;
margin-bottom:6px;
}
div.tabs div {
display:inline;
}
div.tabs a {
background:#464c54;
color:#ffebb5;
padding:8px 14px 8px 14px;
text-decoration:none;
font-size:9px;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-weight:bold;
text-transform:uppercase;
background-repeat:repeat-x;
background-position:bottom;
}
div.tabs a:hover {
background-color:#2f343a;
border-color:#2f343a;
}
div.tabs a.active {
background-color:#ffffff;
color:#282e32;
border:1px solid #464c54;
border-bottom: 1px solid #ffffff;
background-repeat:repeat-x;
background-position:top;
}
.content {
background-color:#ffffff;
padding:10px;
border:1px solid #464c54;
font-family:Arial, Helvetica, sans-serif;
background-repeat:repeat-x;
background-position:bottom;
}
#content_2, #content_3 { display:none; }

.content ul {
margin:0px;
padding:0px 20px 0px 20px;
}
.content ul li {
list-style:none;
border-bottom:1px solid #d6dde0;
padding-top:15px;
padding-bottom:15px;
font-size:13px;
}
.content ul li:last-child {
border-bottom:none;
}
.content ul li a {
text-decoration:none;
color:#3e4346;
}
.content ul li a small {
color:#8b959c;
font-size:9px;
text-transform:uppercase;
font-family:Verdana, Arial, Helvetica, sans-serif;
position:relative;
left:4px;
top:0px;
}
.content ul li a:hover {
color:#a59c83;
}
.content ul li a:hover small {
color:#baae8e;
}
.content div {
margin:0px;
padding:0px;
}
-->
</style>

</head>

<body> 
<div class="tabbed_area">

<div class="tabs">
<div><a class="tab active" title="content_1" href="#Info Surat">Info Surat</a></div>
<div><a class="tab" title="content_2" href="#Detail Surat">Detail Surat</a></div>
<div><a class="tab" title="content_3" href="#History Disposisi">History Disposisi</a></div>
</div>


        <form name="frmAdministrator" method="post" action="disposisi_add.php?id=<?=$_GET["id"]?>">

                

                 <div class="content" id="content_1">
					<div>
                        <?php
                        include("info_surat_masuk.php");
                        ?>
                	</div>
                </div>
				<div class="content" id="content_2">
						
                        <?php
                        include("detil_surat_masuk.php");
                        ?>
					
				</div>
				<div class="content" id="content_3">
					                       
					<?php
                        include("disposisitreeview.php");
                        ?>
                 	
				</div>
  
                     

                
              
                
<?php 
	if ($StatusBerita == "0") {
?>
<input name="Tambah No. Surat" type="button" class="button" id="Tambah No. Surat" value="Tambah No. Surat" onClick="location.href='nosurat_add.php?Id=<?=$IdBerita?>&NoSurat=<?=$NoSurat?>&Perihal=<?=$Perihal?>'">
<?php 
}
 else if ($slevel=="STAF") {

?>

<!--<input type="button" name="Back" value="Back to Home" class="button" onClick="navRefresh();">-->
<input name="Back" type="button" class="button" id="Back" value="Kembali" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<input name="Tanggapan" type="button" class="button" id="Tanggapan" value="Tanggapan" onClick="location.href='index.php?p=<?php echo enkripsi($addtanggapan."&q=".$IdBerita."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi."&Instruksi=".$Isi."&Pengirim=".$Pengirim); ?>'">
<input name="Cetak" type="button" class="button" id="Cetak" value="Cetak Disposisi" onClick="javascript:poptastic('lbrdisposisi.php?id=<?=$Edit->IdSuratMasuk?>');">

<?php 
}
 else if ($slevel=="AUDITOR") {

?>

<!--<input type="button" name="Back" value="Back to Home" class="button" onClick="navRefresh();">-->
<input name="Back" type="button" class="button" id="Back" value="Kembali" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<input name="Tanggapan" type="button" class="button" id="Tanggapan" value="Tanggapan" onClick="location.href='index.php?p=<?php echo enkripsi($addtanggapan."&q=".$IdBerita."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi."&Instruksi=".$Isi."&Pengirim=".$Pengirim); ?>'">
<input name="Cetak" type="button" class="button" id="Cetak" value="Cetak Disposisi" onClick="javascript:poptastic('lbrdisposisi.php?id=<?=$Edit->IdSuratMasuk?>');">

<?php 
}
 else if ($slevel=="ADM") {

?>

<!--<input type="button" name="Back" value="Back to Home" class="button" onClick="navRefresh();">-->
<input name="Back" type="button" class="button" id="Back" value="Kembali" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<input name="Tanggapan" type="button" class="button" id="Tanggapan" value="Tanggapan" onClick="location.href='index.php?p=<?php echo enkripsi($addtanggapan."&q=".$IdBerita."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi."&Instruksi=".$Isi."&Pengirim=".$Pengirim); ?>'">
<input name="Cetak" type="button" class="button" id="Cetak" value="Cetak Disposisi" onClick="javascript:poptastic('lbrdisposisi.php?id=<?=$Edit->IdSuratMasuk?>');">
<?php 
}
 else if ($slevel<>"ADM") {

?>

<input name="Disposisi" type="button" class="button" id="Disposisi" value="Disposisi" onClick="location.href='index.php?p=<?php echo enkripsi($adddisposisi."&q=".$id[$i]."&id=".$q."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi); ?>'">
<!--<input type="button" name="Backe" id ="Backe" value="Back to Home" class="button" onClick="location.href='welcome.php'">-->
<input name="Back" type="button" class="button" id="Back" value="Kembali" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<!--<input name="Tanggapan" type="button" class="button" id="Tanggapan" value="Tanggapan" onClick="location.href='tanggapan_add.php'">-->
<input name="Tanggapan" type="button" class="button" id="Tanggapan" value="Tanggapan" onClick="location.href='index.php?p=<?php echo enkripsi($addtanggapan."&q=".$IdBerita."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi."&Instruksi=".$Isi."&Pengirim=".$Pengirim); ?>'">
<input name="Cetak" type="button" class="button" id="Cetak" value="Cetak Disposisi" onClick="javascript:poptastic('lbrdisposisi.php?id=<?=$Edit->IdSuratMasuk?>');">
<?php
}
?>				
      	</form>
   
</div>
</body>
</html>
