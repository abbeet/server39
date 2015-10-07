<?php
// ambil informasi tentang file yang akan diindeks
$q = $_GET['q'];
$nama_file = "files/" . $q;

$tipe_file = substr($nama_file,strpos($nama_file,'.')+1);

switch ($tipe_file) {
			case "txt": 
					echo "<strong>Nama Dokumen : ".$q. "</strong>";
					$kalimat = file_get_contents($nama_file, true);
					echo "<br><br><font color=blue> Isi dokumen: </font><br>" . $kalimat;
					echo  "<br><font color=red><br><blink><strong>Akhir Tampilan Dokumen</strong></blink></font>";
					exit();
					break;
			case "doc":					
					break;
			case "pdf": 
					$nama_file_swf = str_replace(".pdf",".swf",$nama_file);
					exec ("pdf2swf.exe $nama_file -o $nama_file_swf -f -T 9 -t -s storeallcharacters");
					exec ("swfcombine.exe -o $nama_file_swf rfxview.swf viewport=$nama_file_swf");		
					break;
			case "docx":
					break;
			case "odt": 
					break;
		}
		

		




?>
	
<BR>
<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\"WIDTH=\"760\" HEIGHT=\"612\" id=\"mysite\" ALIGN=\"\">
 <EMBED src="<?php echo $nama_file_swf	?>" quality=high bgcolor=#FFFFFF WIDTH=\"760\" HEIGHT=\"612\" NAME=\"mysite\" ALIGN=\"\"
TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\"></EMBED>
</OBJECT>	
