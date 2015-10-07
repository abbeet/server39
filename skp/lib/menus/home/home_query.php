<?php
	$kalimat = "pengetahuan logistik";
	
	if (@$_POST['submit'])
	{
			$file_query = $_REQUEST['kalimat'];
			echo "<font color=blue> Isi query: </font><br>" . $file_query ."<hr>";
			$document = array("manajemen transaksi! logistik",
			                  "pengetahuan tentang. individu",
							  "terdapat manajemen pengetahuan, dalam transfer pengetahuan logistik");
							  
			echo "<font color=blue> Isi dokumen: </font><br>";
			$data = array();
			foreach($document as $n => $v)
			{
				echo "Doc#" . ($n+1) . " " . $v . "<br>";
				$kata = tokenising($v);
				$hasil = filtering($kata, "id");
				$data[$n] = $hasil;
			}
			echo "<hr>";
			
			$kata = tokenising($file_query);
			$hasil = filtering($kata, "id");
			$doc_terms = calculate_tf($hasil);
			
			echo "<font color=blue>Isi document setelah filtering dan stemming</font>";
			$lkata = array();
			$total_term=0;
			foreach($data as $idx  => $val)
			{
				echo "<br>Doc#" . ($idx+1);
				foreach($val as $kata)
				{
					echo " " . $kata;
					$lkata[$kata]++;
					$total_term++;
				}
			}
			
			// algoritma TF/IDF ---- perhitungan based on term dalam document -----
			// read total dokumen
			echo "<hr><font color=blue>calculate IDF:</font><br>";
			$total_dok = count($document);
			echo "Total dokumen di database = $total_dok";
			
			foreach($lkata as $term => $jumlah)
			{
				echo "<br>" . ++$j . ". " . "$term >> nilai TF: ";
				$datatfd = array();
				$n=0;
				foreach($data as $idx  => $val)
				{
					$kd_doc = $idx;
					$flag=0;
					foreach($val as $kata)
					{
						// nilai sebelumnya harus direset
						if($kata==$term)
						{
							$datatfd[$kd_doc]++;
							if($flag==0)
							{
								$n++;
								$flag=1;
							}
						}
					}
					if($datatfd[$kd_doc]!="")
						echo " (#" . ($kd_doc+1) . "," . $datatfd[$kd_doc] . ")";
				}
				// hitung idf dengan log atau dengan log10 hasilnya juga sama
				if($n==0)
				{
					$idf = 0;
				}
				else
				{
					$idf = log($total_dok/$n);
				}
				echo " IDF = " . $idf;
				echo " <=> #doc berisi term = $n of $total_dok";

				// weight query
				$tfq = $doc_terms[$term];
				$wqq=$wqq+pow($tfq*$idf,2);

				// weight dokumen
				foreach($datatfd as $n => $tfd)
				{
					$wqd[$n] = $wqd[$n]+($tfd*$idf*$tfq*$idf);
					$wdd[$n] = $wdd[$n]+pow($tfd*$idf,2);
				}
			}
			
			// hitung nilai cosine
			foreach($wqd as $n => $v)
			{
				if((sqrt($wqq*$wdd[$n]))==0)
				{
					$sim[$n] = 0;
				}
				else
				{
					$sim[$n] = number_format($wqd[$n]/(sqrt($wqq*$wdd[$n])),3);
				}
			}

			// sorting hasil
			if(count($sim)>1)
			{
				arsort($sim);
			}
	
			echo "<font color=blue> <hr>Hasil Uji Kemiripan dengan TF/IDF: </font><br>";
			echo "<table border=1><tr bgcolor=cyan><td><strong>Kode Dokumen</strong></td>";
			echo "<td><strong>Prosentase Similaritas</strong></td></tr>";
	
			foreach($sim as $n => $v)
			{
				echo "<tr><td>Doc#" . ($n+1) ."</td>";
				echo "<td align=center>" . 100*$v . "</td></tr>";
			}
			echo "</table>";
			//---------------------------------------------------------------------
			
			// algoritma bm25 ---- perhitungan based on term dalam query -----
			echo "<font color=blue><br><hr>Analisis dengan BM25</font>";
			$k=2.0;
			$b=0.75;
			
			// rata-rata panjang dokumen
			$avgdl = $total_term / $total_dok;
			echo "<br>Total dokumen di database = $total_dok";
			echo "<br>Total term di database = $total_term";
			echo "<br>Rata-rata panjang dokumen di database = $avgdl";
			
			foreach($data as $idx => $val)
			{
				$length_doc[$idx]=count($val);
			}
			
			// inti perhitungan rumus bm25
			$j=0;

			foreach($lkata as $term => $tf)
			//foreach($doc_terms as $term => $tf)
			{
				echo "<br>" . ++$j . ". " . "$term >> nilai TF: ";
				$datatfd = array();
				$n=0;
				foreach($data as $idx  => $val)
				{
					$kd_doc = $idx;
					$flag=0;
					foreach($val as $kata)
					{
						// nilai sebelumnya harus direset
						if($kata==$term)
						{
							$datatfd[$kd_doc]++;
							if($flag==0)
							{
								$n++;
								$flag=1;
							}
						}
					}
					if($datatfd[$kd_doc]!="")
						echo " (#" . ($kd_doc+1) . "," . $datatfd[$kd_doc] . ")";
				}
				
				if($n==0)
				{
					$idf = 0;
				}
				else
				{
					$idf = log(($total_dok)/($n));
				}
				echo " IDF = " . $idf;
				echo " <=> #doc berisi term = $n of $total_dok";
				
				
				// weight query dan dokumen
				$tfq = $doc_terms[$term];
				foreach($datatfd as $n => $tfd)
				{
					$lengthd = $length_doc[$n];
					$num1 = $tfq*($k+1);
					$denum1 = $tfq+$k*(1-$b+$b*$lengthd/$avgdl);
										
					$bwqq[$n]=$bwqq[$n]+pow($idf*$num1/$denum1,2);
					$num2 = $tfd*($k+1);
					$denum2 = $tfd+$k*(1-$b+$b*$lengthd/$avgdl);
					
					// tanpa normalisasi
					// jika qi ada di dokumen D
					if($tfq<>0)
					{
						$bm[$n] = $bm[$n] + $idf*$num2/$denum2;
					}

					$bwqd[$n] = $bwqd[$n]+($idf*($num1/$denum1)*$idf*($num2/$denum2));
					$bwdd[$n] = $bwdd[$n]+pow($idf*$num2/$denum2,2);
				}			
			}	
					
			echo "<font color=green><br>Similaritas BM25 sebelum normalisasi:</font>";
			// hitung nilai cosine
			foreach($bwqd as $n => $v)
			{
				if((sqrt($bwqq[$n]*$bwdd[$n]))==0)
				{
					$score[$n] = 0;
				}
				else
				{
					$score[$n] = number_format($bwqd[$n]/(sqrt($bwqq[$n]*$bwdd[$n])),3);
				}
			}
			
			// sorting hasil
			if(count($score)>1)
			{
				arsort($bm);
				arsort($score);
			}
			
			// hasil tanpa normalisasi
			foreach($bm as $n => $v)
				echo "<br>#" . ($n+1) . " = " . 100*number_format($v,3);


			echo "<font color=blue> <br>Hasil Uji Kemiripan dengan BM25 setelah normalisasi: </font><br>";
			echo "<table border=1><tr bgcolor=cyan><td><strong>Kode Dokumen</strong></td></td>";
			echo "<td><strong>Prosentase Similaritas</strong></td></tr>";
			if(count($score)>0)
			{
				foreach($score as $n => $v)
				{
					echo "<tr><td>Doc#" . ($n+1) ."</td>";
					echo "<td align=center>" . 100*$v . "</td></tr>";
				}
			}
			echo "</table>";
			
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
		<p><strong>SIMULASI PROSES EVALUASI QUERY</strong></p>
		<p>Masukkan kata/kalimat:</p>
		<form method="post" action="index.php?p=62">
			<p>
			  <textarea name="kalimat" cols="75" rows="3"><?php echo $kalimat ?></textarea>
			  <br /><br />
			    <input name="submit" type="submit" value="Proses" />
          </p>
	</form>
		<p><?php echo @$output ?></p>
	</body>
</html>