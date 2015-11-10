<?php
	checkauthentication();
	$err = false;

	extract($_POST);

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_FILES['output']['name'] != "")
			{
				mysql_query("DELETE FROM d_output WHERE THANG = '".$ta."'");
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
				$data = dbase_open($filedir, 0);
				
				if ($data)
				{
					$ndata = dbase_numrecords($data);
					
					$i = 0;
					
					while ($i <= $ndata)
					{
						$vdata = dbase_get_record_with_names($data, $i);
						$THANG = $vdata['THANG'];
						$KDJENDOK = $vdata['KDJENDOK'];
						$KDSATKER = $vdata['KDSATKER'];
						$KDDEPT = $vdata['KDDEPT'];
						$KDUNIT = $vdata['KDUNIT'];
						$KDPROGRAM = $vdata['KDPROGRAM'];
						$KDGIAT = $vdata['KDGIAT'];
						$KDOUTPUT = $vdata['KDOUTPUT'];
						$KDLOKASI = $vdata['KDLOKASI'];
						$KDKABKOTA = $vdata['KDKABKOTA'];
						$KDDEKON = $vdata['KDDEKON'];
						$VOLMIN1 = $vdata['VOLMIN1'];
						$VOL = $vdata['VOL'];
						$VOLPLS1 = $vdata['VOLPLS1'];
						$VOLPLS2 = $vdata['VOLPLS2'];
						$VOLPLS3 = $vdata['VOLPLS3'];
						$RPHMIN1 = $vdata['RPHMIN1'];
						$RPHPLS1 = $vdata['RPHPLS1'];
						$RPHPLS2 = $vdata['RPHPLS2'];
						$RPHPLS3 = $vdata['RPHPLS3'];
						$SBKKET = $vdata['SBKKET'];
						$SBKMIN1 = $vdata['SBKMIN1'];
						$KDSB = $vdata['KDSB'];
						$KDJOUTPUT = $vdata['KDJOUTPUT'];
						$THANGAWAL = $vdata['THANGAWAL'];
						$THANGAKHIR = $vdata['THANGAKHIR'];
						$KDTEMA = $vdata['KDTEMA'];
						$KDIB = $vdata['KDIB'];
						$KDAUTO = $vdata['KDAUTO'];
						
						if ($THANG == $ta)
						{
							$sql = "INSERT INTO d_output VALUES ('".$THANG."', '".$KDJENDOK."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDLOKASI."', '".$KDKABKOTA."', '".$KDDEKON."', '".$VOLMIN1."', '".$VOL."', '".$VOLPLS1."', '".$VOLPLS2."', '".$VOLPLS3."', '".$RPHMIN1."', '".$RPHPLS1."', '".$RPHPLS2."', '".$RPHPLS3."', '".$SBKKET."', '".$SBKMIN1."', '".$KDSB."', '".$KDJOUTPUT."', '".$THANGAWAL."', '".$THANGAKHIR."', '".$KDTEMA."', '".$KDIB."', '".$KDAUTO."')";
							
							#echo $sql."<br>";
							mysql_query($sql);
						}
						
						$i++;
					}
				}
			}
			
			if ($_FILES['suboutput']['name'] != "")
			{
				mysql_query("DELETE FROM d_soutput WHERE THANG = '".$ta."'");
				
				$filename = $_FILES['suboutput']['name'];
				$filedir = "dipa_files/".$filename;
				move_uploaded_file($_FILES["suboutput"]["tmp_name"], $filedir);
				
				$data = dbase_open($filedir, 0);
				
				if ($data)
				{
					$ndata = dbase_numrecords($data);
					
					$i = 0;
					
					while ($i <= $ndata)
					{
						$vdata = dbase_get_record_with_names($data, $i);
						$THANG = $vdata['THANG'];
						$KDJENDOK = $vdata['KDJENDOK'];
						$KDSATKER = $vdata['KDSATKER'];
						$KDDEPT = $vdata['KDDEPT'];
						$KDUNIT = $vdata['KDUNIT'];
						$KDPROGRAM = $vdata['KDPROGRAM'];
						$KDGIAT = $vdata['KDGIAT'];
						$KDOUTPUT = $vdata['KDOUTPUT'];
						$KDLOKASI = $vdata['KDLOKASI'];
						$KDKABKOTA = $vdata['KDKABKOTA'];
						$KDDEKON = $vdata['KDDEKON'];
						$KDSOUTPUT = $vdata['KDSOUTPUT'];
						$URSOUTPUT = $vdata['URSOUTPUT'];
						$SBMKVOL = $vdata['SBMKVOL'];
						$SBMKSAT = $vdata['SBMKSAT'];
						$SBMKMIN1 = $vdata['SBMKMIN1'];
						$SBMKKET = $vdata['SBMKKET'];
						$KDSB = $vdata['KDSB'];
						$VOLSOUT = $vdata['VOLSOUT'];
						$KDIB = $vdata['KDIB'];
						
						if ($THANG == $ta)
						{
							$sql = "INSERT INTO d_soutput VALUES ('".$THANG."', '".$KDJENDOK."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDLOKASI."', '".$KDKABKOTA."', '".$KDDEKON."', '".$KDSOUTPUT."', '".$URSOUTPUT."', '".$SBMKVOL."', '".$SBMKSAT."', '".$SBMKMIN1."', '".$SBMKKET."', '".$KDSB."', '".$VOLSOUT."', '".$KDIB."')";
							
							#echo $sql."<br>";
							mysql_query($sql);
						}
						
						$i++;
					}
				}
			}
			
			if ($_FILES['komponen']['name'] != "")
			{
				mysql_query("DELETE FROM d_kmpnen WHERE THANG = '".$ta."'");
				
				$filename = $_FILES['komponen']['name'];
				$filedir = "dipa_files/".$filename;
				move_uploaded_file($_FILES["komponen"]["tmp_name"], $filedir);
				
				$data = dbase_open($filedir, 0);
				
				if ($data)
				{
					$ndata = dbase_numrecords($data);
					
					$i = 0;
					
					while ($i <= $ndata)
					{
						$vdata = dbase_get_record_with_names($data, $i);
						$THANG = $vdata['THANG'];
						$KDJENDOK = $vdata['KDJENDOK'];
						$KDSATKER = $vdata['KDSATKER'];
						$KDDEPT = $vdata['KDDEPT'];
						$KDUNIT = $vdata['KDUNIT'];
						$KDPROGRAM = $vdata['KDPROGRAM'];
						$KDGIAT = $vdata['KDGIAT'];
						$KDOUTPUT = $vdata['KDOUTPUT'];
						$KDLOKASI = $vdata['KDLOKASI'];
						$KDKABKOTA = $vdata['KDKABKOTA'];
						$KDDEKON = $vdata['KDDEKON'];
						$KDSOUTPUT = $vdata['KDSOUTPUT'];
						$KDKMPNEN = $vdata['KDKMPNEN'];
						$KDBIAYA = $vdata['KDBIAYA'];
						$KDSBIAYA = $vdata['KDSBIAYA'];
						$URKMPNEN = $vdata['URKMPNEN'];
						$KDTEMA = $vdata['KDTEMA'];
						$RPHPLS1 = $vdata['RPHPLS1'];
						$RPHPLS2 = $vdata['RPHPLS2'];
						$RPHPLS3 = $vdata['RPHPLS3'];
						$RPHMIN1 = $vdata['RPHMIN1'];
						$THANGAWAL = $vdata['THANGAWAL'];
						$THANGAKHIR = $vdata['THANGAKHIR'];
						$INDEKSKALI = $vdata['INDEKSKALI'];
						$KDIB = $vdata['KDIB'];
						$INDEKSOUT = $vdata['INDEKSOUT'];
						
						if ($THANG == $ta)
						{
							$sql = "INSERT INTO d_kmpnen VALUES ('".$THANG."', '".$KDJENDOK."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDLOKASI."', '".$KDKABKOTA."', '".$KDDEKON."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDBIAYA."', '".$KDSBIAYA."', '".$URKMPNEN."', '".$KDTEMA."', '".$RPHPLS1."', '".$RPHPLS2."', '".$RPHPLS3."', '".$RPHMIN1."', '".$THANGAWAL."', '".$THANGAKHIR."', '".$INDEKSKALI."', '".$KDIB."', '".$INDEKSOUT."')";
							
							#echo $sql."<br>";
							mysql_query($sql);
						}
						
						$i++;
					}
				}
			}
			
			if ($_FILES['subkomponen']['name'] != "")
			{
				mysql_query("DELETE FROM d_skmpnen WHERE THANG = '".$ta."'");
				
				$filename = $_FILES['subkomponen']['name'];
				$filedir = "dipa_files/".$filename;
				move_uploaded_file($_FILES["subkomponen"]["tmp_name"], $filedir);
				
				$data = dbase_open($filedir, 0);
				
				if ($data)
				{
					$ndata = dbase_numrecords($data);
					
					$i = 0;
					
					while ($i <= $ndata)
					{
						$vdata = dbase_get_record_with_names($data, $i);
						$THANG = $vdata['THANG'];
						$KDJENDOK = $vdata['KDJENDOK'];
						$KDSATKER = $vdata['KDSATKER'];
						$KDDEPT = $vdata['KDDEPT'];
						$KDUNIT = $vdata['KDUNIT'];
						$KDPROGRAM = $vdata['KDPROGRAM'];
						$KDGIAT = $vdata['KDGIAT'];
						$KDOUTPUT = $vdata['KDOUTPUT'];
						$KDLOKASI = $vdata['KDLOKASI'];
						$KDKABKOTA = $vdata['KDKABKOTA'];
						$KDDEKON = $vdata['KDDEKON'];
						$KDSOUTPUT = $vdata['KDSOUTPUT'];
						$KDKMPNEN = $vdata['KDKMPNEN'];
						$KDSKMPNEN = $vdata['KDSKMPNEN'];
						$URSKMPNEN = $vdata['URSKMPNEN'];
						$KDIB = $vdata['KDIB'];
						
						if ($THANG == $ta)
						{
							$sql = "INSERT INTO d_skmpnen VALUES ('".$THANG."', '".$KDJENDOK."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDLOKASI."', '".$KDKABKOTA."', '".$KDDEKON."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$URSKMPNEN."', '".$KDIB."')";
							
							#echo $sql."<br>";
							mysql_query($sql);
						}
						
						$i++;
					}
				}
			}
			
			if ($_FILES['suboutput']['akun'] != "")
			{
				mysql_query("DELETE FROM d_akun WHERE THANG = '".$ta."'");
				
				$filename = $_FILES['akun']['name'];
				$filedir = "dipa_files/".$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
				$data = dbase_open($filedir, 0);
				
				if ($data)
				{
					$ndata = dbase_numrecords($data);
					
					$i = 0;
					
					while ($i <= $ndata)
					{
						$vdata = dbase_get_record_with_names($data, $i);
						$THANG = $vdata['THANG'];
						$KDJENDOK = $vdata['KDJENDOK'];
						$KDSATKER = $vdata['KDSATKER'];
						$KDDEPT = $vdata['KDDEPT'];
						$KDUNIT = $vdata['KDUNIT'];
						$KDPROGRAM = $vdata['KDPROGRAM'];
						$KDGIAT = $vdata['KDGIAT'];
						$KDOUTPUT = $vdata['KDOUTPUT'];
						$KDLOKASI = $vdata['KDLOKASI'];
						$KDKABKOTA = $vdata['KDKABKOTA'];
						$KDDEKON = $vdata['KDDEKON'];
						$KDSOUTPUT = $vdata['KDSOUTPUT'];
						$KDKMPNEN = $vdata['KDKMPNEN'];
						$KDSKMPNEN = $vdata['KDSKMPNEN'];
						$KDAKUN = $vdata['KDAKUN'];
						$KDKPPN = $vdata['KDKPPN'];
						$KDBEBAN = $vdata['KDBEBAN'];
						$KDJNSBAN = $vdata['KDJNSBAN'];
						$KDCTARIK = $vdata['KDCTARIK'];
						$REGISTER = $vdata['REGISTER'];
						$CARAHITUNG = $vdata['CARAHITUNG'];
						$PROSENPHLN = $vdata['PROSENPHLN'];
						$PROSENRKP = $vdata['PROSENRKP'];
						$PROSENRMP = $vdata['PROSENRMP'];
						$KPPNRKP = $vdata['KPPNRKP'];
						$KPPNRMP = $vdata['KPPNRMP'];
						$KPPNPHLN = $vdata['KPPNPHLN'];
						$REGDAM = $vdata['REGDAM'];
						$KDLUNCURAN = $vdata['KDLUNCURAN'];
						$KDIB = $vdata['KDIB'];
						
						if ($THANG == $ta)
						{
							$sql = "INSERT INTO d_akun VALUES ('".$THANG."', '".$KDJENDOK."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDLOKASI."', '".$KDKABKOTA."', '".$KDDEKON."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."', '".$KDKPPN."', '".$KDBEBAN."', '".$KDJNSBAN."', '".$KDCTARIK."', '".$REGISTER."', '".$CARAHITUNG."', '".$PROSENPHLN."', '".$PROSENRKP."', '".$PROSENRMP."', '".$KPPNRKP."', '".$KPPNRMP."', '".$KPPNPHLN."', '".$REGDAM."', '".$KDLUNCURAN."', '".$KDIB."')";
							
							#echo $sql."<br>";
							mysql_query($sql);
						}
						
						$i++;
					}
				}
			}
			
			if ($_FILES['pok']['name'] != "")
			{
				mysql_query("DELETE FROM d_item WHERE THANG = '".$ta."'");
				
				$filename = $_FILES['pok']['name'];
				$filedir = "dipa_files/".$filename;
				move_uploaded_file($_FILES["pok"]["tmp_name"], $filedir);
				
				$data = dbase_open($filedir, 0);
				
				if ($data)
				{
					$ndata = dbase_numrecords($data);
					
					$i = 0;
					
					#THANG 	KDJENDOK 	KDSATKER 	KDDEPT 	KDUNIT 	KDPROGRAM 	KDGIAT 	KDOUTPUT 	KDLOKASI 	KDKABKOTA 10 	KDDEKON 	KDSOUTPUT 	KDKMPNEN 	KDSKMPNEN 	KDAKUN 	KDKPPN 	KDBEBAN 	KDJNSBAN 	KDCTARIK 	REGISTER 20 	CARAHITUNG 	HEADER1 	HEADER2 	KDHEADER 	NOITEM 	NMITEM 	VOL1 	SAT1 	VOL2 	SAT2 30 	VOL3 	SAT3 	VOL4 	SAT4 	VOLKEG 	SATKEG 	HARGASAT 	JUMLAH 	PAGUPHLN 	PAGURMP 40 	PAGURKP 	KDBLOKIR 	BLOKIRPHLN 	BLOKIRRMP 	BLOKIRRKP 	RPHBLOKIR 	KDCOPY 	KDABT 	KDSBU 	VOLSBK 50 	VOLRKAKL 	BLNKONTRAK 	NOKONTRAK 	TGKONTRAK 	NILKONTRAK 	JANUARI 	PEBRUARI 	MARET 	APRIL 	MEI 60 	JUNI 	JULI 	AGUSTUS 	SEPTEMBER 	OKTOBER 	NOPEMBER 	DESEMBER 	JMLTUNDA 	KDLUNCURAN 	JMLABT 70 	NOREV 	KDUBAH 	KURS 	INDEXKPJM 	KDIB
					
					while ($i <= $ndata)
					{
						$vdata = dbase_get_record_with_names($data, $i);
						$THANG = $vdata['THANG'];
						$KDJENDOK = $vdata['KDJENDOK'];
						$KDSATKER = $vdata['KDSATKER'];
						$KDDEPT = $vdata['KDDEPT'];
						$KDUNIT = $vdata['KDUNIT'];
						$KDPROGRAM = $vdata['KDPROGRAM'];
						$KDGIAT = $vdata['KDGIAT'];
						$KDOUTPUT = $vdata['KDOUTPUT'];
						$KDLOKASI = $vdata['KDLOKASI'];
						$KDKABKOTA = $vdata['KDKABKOTA'];
						$KDDEKON = $vdata['KDDEKON'];
						$KDSOUTPUT = $vdata['KDSOUTPUT'];
						$KDKMPNEN = $vdata['KDKMPNEN'];
						$KDSKMPNEN = $vdata['KDSKMPNEN'];
						$KDAKUN = $vdata['KDAKUN'];
						$KDKPPN = $vdata['KDKPPN'];
						$KDBEBAN = $vdata['KDBEBAN'];
						$KDJNSBAN = $vdata['KDJNSBAN'];
						$KDCTARIK = $vdata['KDCTARIK'];
						$REGISTER = $vdata['REGISTER'];
						$CARAHITUNG = $vdata['CARAHITUNG'];
						$HEADER1 = $vdata['HEADER1'];
						$HEADER2 = $vdata['HEADER2'];
						$KDHEADER = $vdata['KDHEADER'];
						$NOITEM = $vdata['NOITEM'];
						$NMITEM = $vdata['NMITEM'];
						$VOL1 = $vdata['VOL1'];
						$SAT1 = $vdata['SAT1'];
						$VOL2 = $vdata['VOL2'];
						$SAT2 = $vdata['SAT2'];
						$VOL3 = $vdata['VOL3'];
						$SAT3 = $vdata['SAT3'];
						$VOL4 = $vdata['VOL4'];
						$SAT4 = $vdata['SAT4'];
						$VOLKEG = $vdata['VOLKEG'];
						$SATKEG = $vdata['SATKEG'];
						$HARGASAT = $vdata['HARGASAT'];
						$JUMLAH = $vdata['JUMLAH'];
						$PAGUPHLN = $vdata['PAGUPHLN'];
						$PAGURMP = $vdata['PAGURMP'];
						$PAGURKP = $vdata['PAGURKP'];
						$KDBLOKIR = $vdata['KDBLOKIR'];
						$BLOKIRPHLN = $vdata['BLOKIRPHLN'];
						$BLOKIRRMP = $vdata['BLOKIRRMP'];
						$BLOKIRRKP = $vdata['BLOKIRRKP'];
						$RPHBLOKIR = $vdata['RPHBLOKIR'];
						$KDCOPY = $vdata['KDCOPY'];
						$KDABT = $vdata['KDABT'];
						$KDSBU = $vdata['KDSBU'];
						$VOLSBK = $vdata['VOLSBK'];
						$VOLRKAKL = $vdata['VOLRKAKL'];
						$BLNKONTRAK = $vdata['BLNKONTRAK'];
						$NOKONTRAK = $vdata['NOKONTRAK'];
						$TGKONTRAK = $vdata['TGKONTRAK'];
						$NILKONTRAK = $vdata['NILKONTRAK'];
						$JANUARI = $vdata['JANUARI'];
						$PEBRUARI = $vdata['PEBRUARI'];
						$MARET = $vdata['MARET'];
						$APRIL = $vdata['APRIL'];
						$MEI = $vdata['MEI'];
						$JUNI = $vdata['JUNI'];
						$JULI = $vdata['JULI'];
						$AGUSTUS = $vdata['AGUSTUS'];
						$SEPTEMBER = $vdata['SEPTEMBER'];
						$OKTOBER = $vdata['OKTOBER'];
						$NOPEMBER = $vdata['NOPEMBER'];
						$DESEMBER = $vdata['DESEMBER'];
						$JMLTUNDA = $vdata['JMLTUNDA'];
						$KDLUNCURAN = $vdata['KDLUNCURAN'];
						$JMLABT = $vdata['JMLABT'];
						$NOREV = $vdata['NOREV'];
						$KDUBAH = $vdata['KDUBAH'];
						$KURS = $vdata['KURS'];
						$INDEXKPJM = $vdata['INDEXKPJM'];
						$KDIB = $vdata['KDIB']; #75
						
						if ($THANG == $ta)
						{
							$sql = "INSERT INTO d_item VALUES ('".$THANG."', '".$KDJENDOK."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDLOKASI."', '".$KDKABKOTA."', '".$KDDEKON."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."', '".$KDKPPN."', '".$KDBEBAN."', '".$KDJNSBAN."', '".$KDCTARIK."', '".$REGISTER."', '".$CARAHITUNG."', '".$HEADER1."', '".$HEADER2."', '".$KDHEADER."', '".$NOITEM."', '".$NMITEM."', '".$VOL1."', '".$SAT1."', '".$VOL2."', '".$SAT2."', '".$VOL3."', '".$SAT3."', '".$VOL4."', '".$SAT4."', '".$VOLKEG."', '".$SATKEG."', '".$HARGASAT."', '".$JUMLAH."', '".$PAGUPHLN."', '".$PAGURMP."', '".$PAGURKP."', '".$KDBLOKIR."', '".$BLOKIRPHLN."', '".$BLOKIRRMP."', '".$BLOKIRRKP."', '".$RPHBLOKIR."', '".$KDCOPY."', '".$KDABT."', '".$KDSBU."', '".$VOLSBK."', '".$VOLRKAKL."', '".$BLNKONTRAK."', '".$NOKONTRAK."', '".$TGKONTRAK."', '".$NILKONTRAK."', '".$JANUARI."', '".$PEBRUARI."', '".$MARET."', '".$APRIL."', '".$MEI."', '".$JUNI."', '".$JULI."', '".$AGUSTUS."', '".$SEPTEMBER."', '".$OKTOBER."', '".$NOPEMBER."', '".$DESEMBER."', '".$JMLTUNDA."', '".$KDLUNCURAN."', '".$JMLABT."', '".$NOREV."', '".$KDUBAH."', '".$KURS."', '".$INDEXKPJM."', '".$KDIB."')";
							
							#echo $sql."<br>";
							mysql_query($sql);
						}
						
						$i++;
					}
				}
			}
			
			$_SESSION['errmsg'] = "Proses Import data berhasil"; ?>
				
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		}
	} 
?>

<form action="" method="post" name="form" enctype="multipart/form-data">
	<table cellspacing="1" class="admintable">
		<tr> 
			<td class="key">Tahun Anggaran</td>
			<td>
				<select name="ta"><?php
					
					$t = date("Y-m-d");
					
					for ($i = $t-10; $i <= $t+10; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $t) echo "selected"; ?>><?php echo $i; ?></option><?php
					} ?>	
				</select>
			</td>
		</tr>
		<tr> 
			<td class="key">Data Output</td>
			<td>
				<input type="file" name="output" size="60" />
			</td>
		</tr>
		<tr> 
			<td class="key">Data Sub Output</td>
			<td>
				<input type="file" name="suboutput" size="60" />
			</td>
		</tr>
		<tr> 
			<td class="key">Data Komponen</td>
			<td>
				<input type="file" name="komponen" size="60" />
			</td>
		</tr>
		<tr> 
			<td class="key">Data Sub Komponen</td>
			<td>
				<input type="file" name="subkomponen" size="60" />
			</td>
		</tr>
		<tr> 
			<td class="key">Data Akun</td>
			<td>
				<input type="file" name="akun" size="60" />
			</td>
		</tr>
		<tr> 
			<td class="key">Data POK</td>
			<td>
				<input type="file" name="pok" size="60" />
			</td>
		</tr>
		<tr> 
			<td>&nbsp;</td>
			<td>
				<div class="button2-right"> 
					<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
				</div>
				<div class="button2-left"> 
					<div class="next"> <a onclick="form.submit();">Proses</a></div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
				<input name="form" type="hidden" value="1" />
			</td>
		</tr>
	</table>
</form>