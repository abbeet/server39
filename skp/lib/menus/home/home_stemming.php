<?php
	$kalimat = file_get_contents('home_text.txt', true);
	
	if (@$_POST['submit'])
	{
		$kalimat = $_REQUEST['kalimat'];
		$kata = tokenising($kalimat);
		$hasil = filtering($kata, "id");
		
		echo '<strong>Kalimat :</strong>'.'<br>';
		echo $kalimat.'<br><br>';	
		//--------- hasil Stemming --------------------	
		echo '<font color=blue> Hasil Stemming </font>'.'<br>';
		
		$n=count($hasil);
		for ($i=0;$i<$n;$i++){
			$term = stemming($hasil[$i]);
			echo 'kata ke '. ($i+1) . ' '. $hasil[$i].' ==> hasil : <strong>'. stemming($hasil[$i]).'</strong><br>';
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
		<p><strong>SIMULASI PROSES STEMMING </strong></p>
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
