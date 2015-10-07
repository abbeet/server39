<?php
//	include("../../includes/dbh.php");
//	include("../../includes/functions.php");
//	include("../../includes/func_stemming.php");
	$kalimat = file_get_contents('home_text.txt', true);
	
	if (@$_POST['submit'])
	{
		$kalimat = $_REQUEST['kalimat'];
		$kata = tokenising($kalimat);
		$hasil = filtering($kata, "id");
		$doc_terms = calculate_tf($hasil);
		//--------- hasil TF --------------------
		$n = count($doc_terms);
		$i = 1;
		echo '<font color=blue> Hasil Indexing </font>'.'<br>';
		foreach($doc_terms as $kata => $tf)
		{
			echo 'kata ke '. $i++ . ' ==> ' . $kata . ' ' . $tf . '<br>';
		}
		echo '<strong>Jumlah kata ada : '. $n .'</strong><br>';
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Stemming</title>
	</head>
	
	<body>
		<p><strong>SIMULASI PROSES INDEXING </strong></p>
		<p>Masukkan kata/kalimat:</p>
		<form method="post">
			<p>
			  <textarea name="kalimat" cols="75" rows="15"><?php echo $kalimat ?></textarea>
			  <br /><br />
			    <input name="submit" type="submit" value="Proses" />
          </p>
	</form>
		<p><?php echo @$output ?></p>
	</body>
</html>
