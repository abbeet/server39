<?php
// ambil informasi tentang file yang akan diindeks
$kd_dok = $_GET['no'];
$nama_file = $_GET['nama_file'];
$bahasa = $_GET['bahasa'];
$tabel_tf  = "tf_document";
$nama_file = "files/" . $nama_file;

$tipe_file = substr($nama_file,strpos($nama_file,'.')+1);

echo 'Tipe File : '. $tipe_file . '<br>';
		switch ($tipe_file) {
			case "txt": $kalimat = file_get_contents($nama_file, true); break;
			case "doc": $kalimat = parseWord($nama_file); break;
			case "pdf": $kalimat = pdf2text($nama_file); break;
			case "docx": $kalimat = docx2text($nama_file); break;
			case "odt": $kalimat = odt2text($nama_file); break;
		}
echo 'Isi File Text ' . $kalimat ;

// -----proses tokenising-----
$kata = tokenising($kalimat);

//---proses filtering---
$hasil = filtering($kata, $bahasa);	

//--- proses Stemming and calculate tf ---
if($bahasa=="id")
	$doc_terms = calculate_tf($hasil);
else
	$doc_terms = calculate_tf_en($hasil);

// update nilai tf di database
// hapus term dokumen yg ada di database
mysql_query("delete from $tabel_tf where kd_doc = '$kd_dok'");
echo '<font color=blue> Proses Indexing </font>'.'<br>';
$i = 1;
foreach($doc_terms as $kata => $tf)
{
	// simpan nilai ini ke database
	mysql_query("insert into $tabel_tf values('$kd_dok','$kata',$tf)");
	echo "kata ke " . $i++ . " ==> " . $kata . " " . $tf . "<br>";
}
echo  "<font color=red><br><blink><strong>Proses indexing selesai</strong></blink></font>";
exit();
//---------------------------------------		
?>