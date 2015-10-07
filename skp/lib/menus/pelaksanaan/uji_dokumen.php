<?php
	checkauthentication();
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$tabel_dok = "document";
	$xmenu_p = xmenu_id($p);
	$p_next = 43;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$id = $q;
			// bahasa
			$bahasa_query = $_POST['bahasa'];
			// upload file 
			$file_name=$_FILES['nama_file']['name'];
			$source=$_FILES['nama_file']['tmp_name'];
			$target = "dokumen/" . $file_name;
			if(trim($file_name)=="")
				die("File query belum dipilih!");

			move_uploaded_file($source,$target);
			$file_query = file_get_contents($target, true);
			echo "<font color=blue> Isi dokumen: </font><br>" . $file_query;
			if($bahasa_query=="id")
				echo " <font color=red>(Bahasa: Indonesia)</font>";
			else
				echo " <font color=red>(Bahasa: Inggris)</font>";
			echo "<hr>";

			// setting opsi uji kemiripan
			$hasil = mysql_query("select * from xuser where username = '$xusername_sess'");
			$baris = mysql_fetch_array($hasil);
			$opsi_tfidf = $baris['mode_tfidf'];
			$opsi_bm25 = $baris['mode_bm25'];
			$opsi_decision = $baris['mode_decision'];
			$opsi_persen = $baris['min_persen'];
			$opsi_language = $baris['cross_language'];
			if($opsi_tfidf==1 and $opsi_bm25!=1)
				$pilihan = 1;
			elseif ($opsi_tfidf!=1 and $opsi_bm25==1)
				$pilihan = 2;
			elseif ($opsi_tfidf==1 and $opsi_bm25==1)
				$pilihan = 3;
			else
				$pilihan = 4;
			// end of opsi uji

			$kata = tokenising($file_query);
			$hasil = filtering($kata, $bahasa);
			// calculate tf berdasarkan stemming masing2 bahasa
			if($bahasa=="id")
			{
				$doc_terms_id = calculate_tf($hasil);
				if($opsi_language==1)
				{
					foreach ($doc_terms_id as $k => $f)
					{
						$translate = mysql_query("select word from trans_id_en where kata = '$k'");
						$terjemahan  = mysql_fetch_array($translate);
						$word = $terjemahan[0];
						if($word!="")
							$doc_terms_en[$word] = $f;
						else
							$doc_terms_en[$k] = $f;;
					}
				}
			}
			else
			{
				$doc_terms_en = calculate_tf_en($hasil);
				if($opsi_language==1)
				{
					foreach ($doc_terms_en as $w => $f)
					{
						$translate = mysql_query("select kata from trans_id_en where word = '$w'");
						$terjemahan  = mysql_fetch_array($translate);
						$kata = $terjemahan[0];
						if($kata!="")
							$doc_terms_id[$kata] = $f;
						else
							$doc_terms_id[$w] = $f;;
					}
				}
			}
						
			if($opsi_language==1)
				echo "Opsi cross language (pencarian dwi bahasa) dipakai";
			else
				echo "Opsi cross language (pencarian dwi bahasa) tidak dipakai";

			// kerjakan 2 kali jika opsi cross language dipakai	
			// $i=0 -> proses sesuai dengan bahasa query
			// $i=1 -> proses dengan mentranslate query terlebih dahulu
			for($i=0;$i<=$opsi_language;$i++)
			{	
				if($bahasa=="id")
				{
					$doc_terms = $doc_terms_id;
					$vlist_doc = "vlist_doc_id";
					$vtotal_doc = "vtotal_doc_id";
					$vtotal_term = "vtotal_term_id";
					$tabel_tf = "vtf_document_id";
				}
				else
				{
					$doc_terms = $doc_terms_en;
					$vlist_doc = "vlist_doc_en";
					$vtotal_doc = "vtotal_doc_en";
					$vtotal_term = "vtotal_term_en";
					$tabel_tf = "vtf_document_en";
				}
						
				// read total dokumen
				$hasil = mysql_query("select total from $vtotal_doc");
				$baris = mysql_fetch_array($hasil);
				$total_dok = $baris['total'];
				if($bahasa=="id")
				{
					echo "<br>Total indeks dokumen Bahasa Indonesia di database = $total_dok";
					$bahasa="en";
				}
				else
				{
					echo "<br>Total indeks dokumen Bahasa Inggris di database = $total_dok";
					$bahasa="id";			
				}

				// algoritma TF/IDF dan BM25 didasarkan pada perhitungan frekuensi term dalam document
				// parameter k dan b yang digunakan dalam algoritma BM25
				if($opsi_bm25==1)
				{
					$k=2.0;
					$b=0.75;
					$qry1 = mysql_query("select * from $vtotal_term");
					$row1 = mysql_fetch_array($qry1);
					$total_term = $row1['total'];
					// rata-rata panjang dokumen
					$avgdl = $total_term / $total_dok;
					//echo "<br>total dokumen di database = $total_dok";
					//echo "<br>total term di database = $total_term";
					//echo "<br>rata-rata panjang dokumen di database = $avgdl";
			
					$qry2 = mysql_query("select * from $vlist_doc");
					while($row2 = mysql_fetch_array($qry2))
					{
						$kode = $row2['kd_doc'];
						$panjang = $row2['jumlah'];
						$length_doc[$kode]=$panjang;
					}
				}

				// perhitungan weight berdasarkan list term dalam dokumen 
				// reset semua nilai
				$wqq = 0;
				$wqd = array();
				$wdd = array();
				$bwqq = array();
				$bwqd = array();
				$bwdd = array();
			
				$hasil1 = mysql_query("select distinct kata from $tabel_tf");
				while($row=mysql_fetch_array($hasil1))
				{
					$term=$row['kata'];
					//echo "<br>" . ++$j . ". " . "$term >> nilai TF: ";
					$hasil2 = mysql_query("select kd_doc, frekuensi from $tabel_tf where kata='$term'");
					$datatfd = array();
					$n=0;
					while( $row = mysql_fetch_array($hasil2))
					{
						$kd_doc = $row['kd_doc'];
						// nilai sebelumnya harus direset
						$datatfd[$kd_doc] = $row['frekuensi'];
						$n++;
						//echo " (#$kd_doc," . $datatfd[$kd_doc] . ")";
					}
					// hitung idf dengan log atau dengan log10 hasilnya juga sama
					if($n==0)
					{
						$idf = 1;
					}
					else
					{
						$idf = log(($total_dok)/($n));
					}
				
					// weight query
					$tfq = $doc_terms[$term];
					$wqq=$wqq+pow($tfq*$idf,2);
								
					// weight dokumen
					foreach($datatfd as $n => $tfd)
					{
						// kalkulasi untuk tf/idf
						if($opsi_tfidf==1)
						{
							$wqd[$n] = $wqd[$n]+($tfd*$idf*$tfq*$idf);
							$wdd[$n] = $wdd[$n]+pow($tfd*$idf,2);
						}
						// kalkulasi untuk bm25
						if($opsi_bm25==1)
						{
							$lengthd = $length_doc[$n];
							$num1 = $tfq*($k+1);
							$denum1 = $tfq+$k*(1-$b+$b*$lengthd/$avgdl);
										
							$bwqq[$n]=$bwqq[$n]+pow($idf*$num1/$denum1,2);
							$num2 = $tfd*($k+1);
							$denum2 = $tfd+$k*(1-$b+$b*$lengthd/$avgdl);
					
							// jika ingin menampilkan bm25 tanpa normalisasi
							// jika qi ada di dokumen D
							if($tfq<>0)
							{
								$bm[$n] = $bm[$n] + $idf*$num2/$denum2;
							}

							$bwqd[$n] = $bwqd[$n]+($idf*($num1/$denum1)*$idf*($num2/$denum2));
							$bwdd[$n] = $bwdd[$n]+pow($idf*$num2/$denum2,2);
						}
					}
				}
			
				// hitung nilai cosine tfidf
				if($opsi_tfidf==1)
				{
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
				}
			
				// hitung nilai cosine bm25
				if($opsi_bm25==1)
				{
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
				}
			}

			echo "<hr>";
			// jika yang dipilih hanya mode tf-idf saja
			if($pilihan==1)
			{
				// sorting hasil
				if(count($sim)>1)
				{
					arsort($sim);
				}				
				echo "<font color=blue>Hasil Uji Kemiripan dengan TF/IDF dengan prosentase di atas $opsi_persen%: </font><br>";
				echo "<table border=1><tr bgcolor=green><td><strong>Kode Dokumen</strong></td><td><strong>Judul</strong></td><td><strong>Penulis</strong></td><td><strong>Nama File</strong></td>";
				echo "<td><strong>Prosentase Similaritas</strong></td></tr>";
				foreach($sim as $n => $v)
				{
					if((100*$v)>=$opsi_persen)
					{
						$hasil3 = mysql_query("select * from $tabel_dok where kd_doc='$n'");
						$row = mysql_fetch_array($hasil3);
						echo "<tr><td> $row[kd_doc]</td>";
						echo "<td> $row[judul_doc] </td>";
						echo "<td> $row[penulis] </td>";
						echo "<td><a href=files/$row[nama_file]>$row[nama_file]</a></td>";
						echo "<td align=center>" . 100*$v . "</td></tr>";
					}
				}
				echo "</table>";
			}
			
			// jika yang dipilih hanya mode bm25 saja
			if($pilihan==2)
			{
				// sorting hasil
				if(count($score)>1)
				{
					arsort($bm);
					arsort($score);
				}				

				// hasil tanpa normalisasi
				//echo "<font color=blue> <br>Hasil Uji Kemiripan dengan BM25 sebelum normalisasi: </font>";
				//foreach($bm as $n => $v)
				//	echo "<br>#" . $n . " = " . 100*number_format($v,3);
				
				echo "<font color=blue>Hasil Uji Kemiripan dengan BM25 dengan prosentase di atas $opsi_persen%: </font><br>";
				echo "<table border=1><tr bgcolor=green><td><strong>Kode Dokumen</strong></td><td><strong>Judul</strong></td><td><strong>Penulis</strong></td><td><strong>Nama File</strong></td>";
				echo "<td><strong>Prosentase Similaritas</strong></td></tr>";
				if(count($score)>0)
				{
					foreach($score as $n => $v)
					{
						if((100*$v)>=$opsi_persen)
						{
							$hasil3 = mysql_query("select * from $tabel_dok where kd_doc='$n'");
							$row = mysql_fetch_array($hasil3);
							echo "<tr><td> $row[kd_doc]</td>";
							echo "<td> $row[judul_doc] </td>";
							echo "<td> $row[penulis] </td>";
							echo "<td><a href=files/$row[nama_file]>$row[nama_file]</a></td>";
							echo "<td align=center>" . 100*$v . "</td></tr>";
						}
					}
				}
				echo "</table>";
			}
			if($pilihan==3)
			{
				// proses dari kedua method, ambil minimum, maksimum, atau nilai rata-rata dari kedua method
				foreach($sim as $n => $v)
				{
					switch($opsi_decision)
					{
						case 0:
							$endscore[$n] = min($sim[$n],$score[$n]);
							$textdecision = "Minimum";
							break;
						case 1:
							$endscore[$n] = ($sim[$n] + $score[$n])/2;
							$textdecision = "Rata-rata";
							break;
						case 2:
							$endscore[$n] = max($sim[$n],$score[$n]);
							$textdecision = "Maksimum";
							break;
					}
				}
				// sorting hasil
				if(count($endscore)>1)
				{
					arsort($endscore);
				}							
				echo "<font color=blue>Hasil Uji Kemiripan dengan Mengambil Nilai $textdecision antara TF/IDF dan BM25 dengan prosentase di atas $opsi_persen%:</font><br>";
				echo "<table border=1><tr bgcolor=green><td><strong>Kode Dokumen</strong></td><td><strong>Judul</strong></td><td><strong>Penulis</strong></td><td><strong>Nama File</strong></td>";
				echo "<td><strong>Prosentase Similaritas</strong></td></tr>";
				foreach($endscore as $n => $v)
				{
					if((100*$v)>=$opsi_persen)
					{
						$hasil3 = mysql_query("select * from $tabel_dok where kd_doc='$n'");
						$row = mysql_fetch_array($hasil3);
						echo "<tr><td> $row[kd_doc]</td>";
						echo "<td> $row[judul_doc] </td>";
						echo "<td> $row[penulis] </td>";
						echo "<td><a href=files/$row[nama_file]>$row[nama_file]</a></td>";
						echo "<td align=center>" . 100*$v . "</td></tr>";
					}
				}
				echo "</table>";
			}
			if($pilihan==4)
			{
				echo "<font color=blue> <br>Opsi Uji Kemiripan (TF-IDF dan BM25) tidak ada yang dipilih!!!</font><br>";
			}
		}
		?>
		<!--meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"--><?php
		exit();
	}
	?>

<form method="post" name="form" enctype="multipart/form-data">
	<table class="admintable" cellspacing="1">
		<tr>
		  <td><b>Masukkan file dokumen yang akan diuji </b></td>
		  <td><input type="file" name="nama_file" size="50" ></td>
		  <td><a href=index.php?p=45><font color=blue>Opsi Pengujian</font></a></td>
		</tr>
		 <tr>
				  <td><b>Bahasa Dokumen</b></td>
		  <td><select name="bahasa">
				<option value="id" selected>Indonesia</option>
				<option value="en" >Inggris</option>
			</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Uji Kemiripan</a>
					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
			</td>
		</tr>
	</table>
</form>