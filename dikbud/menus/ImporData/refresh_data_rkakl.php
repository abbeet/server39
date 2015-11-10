<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED) );

	require_once "lib/phpxbase/Column.class.php";
	require_once "lib/phpxbase/Record.class.php";
	require_once "lib/phpxbase/Table.class.php";
	
	checkauthentication();
	$err = false;
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'];
	
	if ( $_REQUEST['kdsatker'] == '' )   $kdsatker = '189643' ;
	else   $kdsatker = $_REQUEST['kdsatker'] ;

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	#$dirData = "c:\\xampp\\htdocs\\siren\\file_dipa\\";
	$dirData = "/var/www/html/dikbud/file_dipa/".$kdsatker."/";
	
	$tabel_1 = $dirData.$th."_d_output.keu" ;
	$tabel_2 = $dirData.$th."_d_soutput.keu" ;
	$tabel_3 = $dirData.$th."_d_kmpnen.keu" ;
	$tabel_4 = $dirData.$th."_d_skmpnen.keu" ;
	$tabel_5 = $dirData.$th."_d_akun.keu" ;
	$tabel_6 = $dirData.$th."_d_item.keu" ;
	$tabel_7 = $dirData.$th."_D_TRKTRM.KEU" ;

	#$conn = new COM("ADODB.Connection");
	#$dirData = "c:\\xampp\\htdocs\\siren\\file_dipa\\";
	#$conn->Open("Provider=vfpoledb.1;Data Source=$dirData;Collating Sequence=Machine");
	//$Data= $conn->Execute("select THANG,sum(JUMLAH) AS jml from $tabel_6 group by THANG");	
	//$th_file	= $Data->Fields(0);
	//$jumlah		= $Data->Fields(1);
	
	$th_file = $th ;
	#echo 'Tahun '.$th.'<br>';
	#echo 'tabel 1 '.$tabel_1.'<br>';
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_REQUEST['output'] == "1")
			{
				mysql_query("DELETE FROM d_output WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."' ");
				
				/*
				$Output = $conn->Execute("SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, VOL FROM ".$tabel_1." WHERE 
				THANG = '".$th."'");	
				
				while (!$Output->EOF) 
				{
					$THANG		= $Output->Fields(0);
					$KDSATKER	= $Output->Fields(1);
					$KDDEPT		= $Output->Fields(2);
					$KDUNIT		= $Output->Fields(3);
					$KDPROGRAM	= $Output->Fields(4);
					$KDGIAT		= $Output->Fields(5);
					$KDOUTPUT	= $Output->Fields(6);
					$VOL		= $Output->Fields(7);
					
					echo 'THANG '.$THANG.'<BR>';
					echo 'KDSATKER '.$KDSATKER.'<BR>';
					
					$sql = "INSERT INTO d_output(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, VOL) VALUES ('".$THANG."', '".$KDSATKER."', 
					'".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$VOL."')";
					
					mysql_query($sql);
    				$Output->MoveNext();
				}
				
				$Output->Close();
				*/
				
				$table_1 = new XBaseTable($tabel_1);
				$table_1->open();
				
				while ($record = $table_1->nextRecord())
				{
					foreach ($table_1->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "KDOUTPUT")	$KDOUTPUT	= $record->getString($c);
						else if ($c->getName() == "VOL")		$VOL		= $record->getString($c);
					}
					
					if ($THANG == $th)
					{
						echo 'THANG '.$THANG.'<BR>';
						echo 'KDSATKER '.$KDSATKER.'<BR>';
						
						$sql = "INSERT INTO d_output(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, VOL) VALUES ('".$THANG."', 
						'".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$VOL."')";
						
						mysql_query($sql);
					}
				}
				
				$table_1->close();
			}
				
			if ($_REQUEST['soutput'] == "1")
			{
								
				mysql_query("DELETE FROM d_soutput WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."' ");
				
				/*
				$SOutput = $conn->Execute("SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, URSOUTPUT, VOLSOUT 
				FROM ".$tabel_2." WHERE THANG = '".$th."'");	
				
				while (!$SOutput->EOF) 
				{
					$THANG		= $SOutput->Fields(0);
					$KDSATKER	= $SOutput->Fields(1);
					$KDDEPT		= $SOutput->Fields(2);
					$KDUNIT		= $SOutput->Fields(3);
					$KDPROGRAM	= $SOutput->Fields(4);
					$KDGIAT		= $SOutput->Fields(5);
					$KDOUTPUT	= $SOutput->Fields(6);
					$KDSOUTPUT	= $SOutput->Fields(7);
					$URSOUTPUT	= addslashes($SOutput->Fields(8));
					$VOLSOUT	= $SOutput->Fields(9);

					$sql = "INSERT INTO d_soutput(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, URSOUTPUT, VOLSOUT) VALUES 
					('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', 
					'".$URSOUTPUT."', '".$VOLSOUT."')";
					
					mysql_query($sql);
    				$SOutput->MoveNext();
						
				}
				
				$SOutput->Close();
				*/
				
				$table_2 = new XBaseTable($tabel_2);
				$table_2->open();
				
				while ($record = $table_2->nextRecord())
				{
					foreach ($table_2->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "KDOUTPUT")	$KDOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDSOUTPUT")	$KDSOUTPUT	= $record->getString($c);
						else if ($c->getName() == "URSOUTPUT")	$URSOUTPUT	= addslashes($record->getString($c));
						else if ($c->getName() == "VOLSOUT")	$VOLSOUT	= $record->getString($c);
					}
					
					if ($THANG == $th)
					{
						$sql = "INSERT INTO d_soutput(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, URSOUTPUT, VOLSOUT) VALUES 
						('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', 
						'".$URSOUTPUT."', '".$VOLSOUT."')";
					
						mysql_query($sql);
					}
				}
				
				$table_2->close();
			}
			
			if ($_REQUEST['kmpnen'] == "1")
			{
				mysql_query("DELETE FROM d_kmpnen WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."' ");
				
				/*
				$Kmpnen = $conn->Execute("SELECT THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,URKMPNEN FROM ".$tabel_3." WHERE 
				THANG = '".$th."'");	
				
				while (!$Kmpnen->EOF) 
				{
					$THANG		= $Kmpnen->Fields(0);
					$KDSATKER	= $Kmpnen->Fields(1);
					$KDDEPT		= $Kmpnen->Fields(2);
					$KDUNIT		= $Kmpnen->Fields(3);
					$KDPROGRAM	= $Kmpnen->Fields(4);
					$KDGIAT		= $Kmpnen->Fields(5);
					$KDOUTPUT	= $Kmpnen->Fields(6);
					$KDSOUTPUT	= $Kmpnen->Fields(7);
					$KDKMPNEN	= $Kmpnen->Fields(8);
					$URKMPNEN	= addslashes($Kmpnen->Fields(9));

					$sql = "INSERT INTO d_kmpnen(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, URKMPNEN) VALUES 
					('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', 
					'".$KDKMPNEN."', '".$URKMPNEN."')";
					
					mysql_query($sql);
    				$Kmpnen->MoveNext();

				}
				
				$Kmpnen->Close();
				*/
				
				$table_3 = new XBaseTable($tabel_3);
				$table_3->open();
				
				while ($record = $table_3->nextRecord())
				{
					foreach ($table_3->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "KDOUTPUT")	$KDOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDSOUTPUT")	$KDSOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDKMPNEN")	$KDKMPNEN	= $record->getString($c);
						else if ($c->getName() == "URKMPNEN")	$URKMPNEN	= addslashes($record->getString($c));
					}
					
					if ($THANG == $th)
					{
						$sql = "INSERT INTO d_kmpnen(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, URKMPNEN) VALUES 
						('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', 
						'".$KDKMPNEN."', '".$URKMPNEN."')";
					
						mysql_query($sql);
					}
				}
				
				$table_3->close();
			}
	
			if ($_REQUEST['skmpnen'] == "1")
			{
				mysql_query("DELETE FROM d_skmpnen WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."' ");
				
				/*
				$SKmpnen = $conn->Execute("SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN,URSKMPNEN 
				FROM ".$tabel_4." WHERE THANG = '".$th."'");	
				
				while (!$SKmpnen->EOF) 
				{
					$THANG		= $SKmpnen->Fields(0);
					$KDSATKER	= $SKmpnen->Fields(1);
					$KDDEPT		= $SKmpnen->Fields(2);
					$KDUNIT		= $SKmpnen->Fields(3);
					$KDPROGRAM	= $SKmpnen->Fields(4);
					$KDGIAT		= $SKmpnen->Fields(5);
					$KDOUTPUT	= $SKmpnen->Fields(6);
					$KDSOUTPUT	= $SKmpnen->Fields(7);
					$KDKMPNEN	= $SKmpnen->Fields(8);
					$KDSKMPNEN	= $SKmpnen->Fields(9);
					$URSKMPNEN	= addslashes($SKmpnen->Fields(10));

					$sql = "INSERT INTO d_skmpnen(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, URSKMPNEN) 
					VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', 
					'".$KDKMPNEN."', '".$KDSKMPNEN."', '".$URSKMPNEN."')";
					
					mysql_query($sql);
    				$SKmpnen->MoveNext();
				}
				
				$SKmpnen->Close();
				*/
				
				$table_4 = new XBaseTable($tabel_4);
				$table_4->open();
				
				while ($record = $table_4->nextRecord())
				{
					foreach ($table_4->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "KDOUTPUT")	$KDOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDSOUTPUT")	$KDSOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDKMPNEN")	$KDKMPNEN	= $record->getString($c);
						else if ($c->getName() == "KDSKMPNEN")	$KDSKMPNEN	= $record->getString($c);
						else if ($c->getName() == "URSKMPNEN")	$URSKMPNEN	= addslashes($record->getString($c));
					}
					
					if ($THANG == $th)
					{
						$sql = "INSERT INTO d_skmpnen(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, 
						URSKMPNEN) VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', 
						'".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$URSKMPNEN."')";
					
						mysql_query($sql);
					}
				}
				
				$table_4->close();
			}

			if ($_REQUEST['dipa'] == "1")
			{
				mysql_query("DELETE FROM d_akun WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."' ");
				
				/*
				$Akun = $conn->Execute("SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT,KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN 
				FROM ".$tabel_5." WHERE THANG = '".$th."'");	
				
				while (!$Akun->EOF) 
				{
					$THANG		= $Akun->Fields(0);
					$KDSATKER	= $Akun->Fields(1);
					$KDDEPT		= $Akun->Fields(2);
					$KDUNIT		= $Akun->Fields(3);
					$KDPROGRAM	= $Akun->Fields(4);
					$KDGIAT		= $Akun->Fields(5);
					$KDOUTPUT	= $Akun->Fields(6);
					$KDSOUTPUT	= $Akun->Fields(7);
					$KDKMPNEN	= $Akun->Fields(8);
					$KDSKMPNEN	= $Akun->Fields(9);
					$KDAKUN		= $Akun->Fields(10);

					$sql = "INSERT INTO d_akun(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN) VALUES 
					('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', 
					'".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."')";
					
					mysql_query($sql);
    				$Akun->MoveNext();
				}
				
				$Akun->Close();
				*/
				
				$table_5 = new XBaseTable($tabel_5);
				$table_5->open();
				
				while ($record = $table_5->nextRecord())
				{
					foreach ($table_5->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "KDOUTPUT")	$KDOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDSOUTPUT")	$KDSOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDKMPNEN")	$KDKMPNEN	= $record->getString($c);
						else if ($c->getName() == "KDSKMPNEN")	$KDSKMPNEN	= $record->getString($c);
						else if ($c->getName() == "KDAKUN")		$KDAKUN		= $record->getString($c);
					}
					
					if ($THANG == $th)
					{
						$sql = "INSERT INTO d_akun(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN) 
						VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', 
						'".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."')";
					
						mysql_query($sql);
					}
				}
				
				$table_5->close();
			}

			if ($_REQUEST['pok'] == "1")
			{
				mysql_query("DELETE FROM d_item WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."'");
				
				/*
				$Item = $conn->Execute("SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN,KDAKUN, JUMLAH, 
				JANUARI, PEBRUARI, MARET, APRIL, MEI,JUNI, JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOPEMBER, DESEMBER, HEADER1, HEADER2, KDHEADER, NOITEM, NMITEM,
				 VOLKEG, SATKEG, HARGASAT, KDBEBAN FROM ".$tabel_6." WHERE THANG = '".$th."'");	
				
				while (!$Item->EOF) 
				{
					$THANG		= $Item->Fields(0);
					$KDSATKER	= $Item->Fields(1);
					$KDDEPT		= $Item->Fields(2);
					$KDUNIT		= $Item->Fields(3);
					$KDPROGRAM	= $Item->Fields(4);
					$KDGIAT		= $Item->Fields(5);
					$KDOUTPUT	= $Item->Fields(6);
					$KDSOUTPUT	= $Item->Fields(7);
					$KDKMPNEN	= $Item->Fields(8);
					$KDSKMPNEN	= $Item->Fields(9);
					$KDAKUN		= $Item->Fields(10);
					$JUMLAH		= $Item->Fields(11);
					$JANUARI	= $Item->Fields(12);
					$PEBRUARI	= $Item->Fields(13);
					$MARET		= $Item->Fields(14);
					$APRIL		= $Item->Fields(15);
					$MEI		= $Item->Fields(16);
					$JUNI		= $Item->Fields(17);
					$JULI		= $Item->Fields(18);
					$AGUSTUS	= $Item->Fields(19);
					$SEPTEMBER	= $Item->Fields(20);
					$OKTOBER	= $Item->Fields(21);
					$NOPEMBER	= $Item->Fields(22);
					$DESEMBER	= $Item->Fields(23);
					$HEADER1	= $Item->Fields(24);
					$HEADER2	= $Item->Fields(25);
					$KDHEADER	= $Item->Fields(26);
					$NOITEM		= $Item->Fields(27);
					$NMITEM		= addslashes($Item->Fields(28));
					$VOLKEG		= $Item->Fields(29);
					$SATKEG		= addslashes($Item->Fields(30));
					$HARGASAT	= $Item->Fields(31);
					$KDBEBAN	= $Item->Fields(32);
					
					$sql = "INSERT INTO d_item(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN, JUMLAH, 
					JANUARI, PEBRUARI, MARET, APRIL, MEI, JUNI, JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOPEMBER, DESEMBER, HEADER1, HEADER2, KDHEADER, NOITEM, 
					NMITEM, VOLKEG, SATKEG, HARGASAT, KDBEBAN) VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', '".$KDPROGRAM."', 
					'".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."', '".$JUMLAH."', '".$JANUARI."', 
					'".$PEBRUARI."', '".$MARET."', '".$APRIL."', '".$MEI."', '".$JUNI."', '".$JULI."', '".$AGUSTUS."', '".$SEPTEMBER."', 
					'".$OKTOBER."', '".$NOPEMBER."', '".$DESEMBER."', '".$HEADER1."', '".$HEADER2."', '".$KDHEADER."', '".$NOITEM."', '".$NMITEM."', 
					'".$VOLKEG."', '".$SATKEG."', '".$HARGASAT."' , '".$KDBEBAN."')";
					
					mysql_query($sql);
    				$Item->MoveNext();
				}
				
				$Item->Close();
				*/
				
				$table_6 = new XBaseTable($tabel_6);
				$table_6->open();
				
				while ($record = $table_6->nextRecord())
				{
					foreach ($table_6->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "KDOUTPUT")	$KDOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDSOUTPUT")	$KDSOUTPUT	= $record->getString($c);
						else if ($c->getName() == "KDKMPNEN")	$KDKMPNEN	= $record->getString($c);
						else if ($c->getName() == "KDSKMPNEN")	$KDSKMPNEN	= $record->getString($c);
						else if ($c->getName() == "KDAKUN")		$KDAKUN		= $record->getString($c);
						else if ($c->getName() == "JUMLAH")		$JUMLAH		= $record->getString($c);
						//else if ($c->getName() == "JANUARI")	$JANUARI	= $record->getString($c);
						//else if ($c->getName() == "PEBRUARI")	$PEBRUARI	= $record->getString($c);
						//else if ($c->getName() == "MARET")		$MARET		= $record->getString($c);
						//else if ($c->getName() == "APRIL")		$APRIL		= $record->getString($c);
						//else if ($c->getName() == "MEI")		$MEI		= $record->getString($c);
						//else if ($c->getName() == "JUNI")		$JUNI		= $record->getString($c);
						//else if ($c->getName() == "JULI")		$JULI		= $record->getString($c);
						//else if ($c->getName() == "AGUSTUS")	$AGUSTUS	= $record->getString($c);
						//else if ($c->getName() == "SEPTEMBER")	$SEPTEMBER	= $record->getString($c);
						//else if ($c->getName() == "OKTOBER")	$OKTOBER	= $record->getString($c);
						//else if ($c->getName() == "NOPEMBER")	$NOPEMBER	= $record->getString($c);
						//else if ($c->getName() == "DESEMBER")	$DESEMBER	= $record->getString($c);
						else if ($c->getName() == "HEADER1")	$HEADER1	= $record->getString($c);
						else if ($c->getName() == "HEADER2")	$HEADER2	= $record->getString($c);
						else if ($c->getName() == "KDHEADER")	$KDHEADER	= $record->getString($c);
						else if ($c->getName() == "NOITEM")		$NOITEM		= $record->getString($c);
						else if ($c->getName() == "NMITEM")		$NMITEM		= addslashes($record->getString($c));
						else if ($c->getName() == "VOLKEG")		$VOLKEG		= $record->getString($c);
						else if ($c->getName() == "SATKEG")		$SATKEG		= addslashes($record->getString($c));
						else if ($c->getName() == "HARGASAT")	$HARGASAT	= $record->getString($c);
						else if ($c->getName() == "KDBEBAN")	$KDBEBAN	= $record->getString($c);
						else if ($c->getName() == "KDBLOKIR")	$KDBLOKIR	= $record->getString($c);
						else if ($c->getName() == "RPHBLOKIR")	$RPHBLOKIR	= $record->getString($c);
					}
					
					if ($THANG == $th)
					{
					//	$sql = "INSERT INTO d_item(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN, 
					//	JUMLAH, JANUARI, PEBRUARI, MARET, APRIL, MEI, JUNI, JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOPEMBER, DESEMBER, HEADER1, HEADER2, 
					//	KDHEADER, NOITEM, NMITEM, VOLKEG, SATKEG, HARGASAT, KDBEBAN) VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', 
					//	'".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."', '".$JUMLAH."', 
					//	'".$JANUARI."', '".$PEBRUARI."', '".$MARET."', '".$APRIL."', '".$MEI."', '".$JUNI."', '".$JULI."', '".$AGUSTUS."', '".$SEPTEMBER."', 
					//	'".$OKTOBER."', '".$NOPEMBER."', '".$DESEMBER."', '".$HEADER1."', '".$HEADER2."', '".$KDHEADER."', '".$NOITEM."', '".$NMITEM."', 
					//	'".$VOLKEG."', '".$SATKEG."', '".$HARGASAT."' , '".$KDBEBAN."')";
					$sql = "INSERT INTO d_item(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN, 
						JUMLAH, HEADER1, HEADER2, 
						KDHEADER, NOITEM, NMITEM, VOLKEG, SATKEG, HARGASAT, KDBEBAN,KDBLOKIR, RPHBLOKIR) VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', 
						'".$KDPROGRAM."', '".$KDGIAT."', '".$KDOUTPUT."', '".$KDSOUTPUT."', '".$KDKMPNEN."', '".$KDSKMPNEN."', '".$KDAKUN."', '".$JUMLAH."', 
						'".$HEADER1."', '".$HEADER2."', '".$KDHEADER."', '".$NOITEM."', '".$NMITEM."', 
						'".$VOLKEG."', '".$SATKEG."', '".$HARGASAT."' , '".$KDBEBAN."' , '".$KDBLOKIR."' , '".$RPHBLOKIR."' )";
						mysql_query($sql);
					}
				}
				
				$table_6->close();
			}

			if ($_REQUEST['trktrm'] == "1")
			{
				mysql_query("DELETE FROM d_trktrm WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker."'");
				
				/*
				$Item = $conn->Execute("SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, RPHPAGU, KDTRKTRM, JNSBELANJA, JML01, JML02, JML03, JML04,
				 JML05, JML06, JML07, JML08, JML09, JML10, JML11, JML12 FROM ".$tabel_7." WHERE THANG = '".$th."'");	
				
				while (!$Item->EOF) 
				{
					$THANG		= $Item->Fields(0);
					$KDSATKER	= $Item->Fields(1);
					$KDDEPT		= $Item->Fields(2);
					$KDUNIT		= $Item->Fields(3);
					$KDPROGRAM	= $Item->Fields(4);
					$KDGIAT		= $Item->Fields(5);
					$RPHPAGU	= $Item->Fields(6);
					$KDTRKTRM	= $Item->Fields(7);
					$JNSBELANJA	= $Item->Fields(8);
					$JML01		= $Item->Fields(9);
					$JML02		= $Item->Fields(10);
					$JML03		= $Item->Fields(11);
					$JML04		= $Item->Fields(12);
					$JML05		= $Item->Fields(13);
					$JML06		= $Item->Fields(14);
					$JML07		= $Item->Fields(15);
					$JML08		= $Item->Fields(16);
					$JML09		= $Item->Fields(17);
					$JML10		= $Item->Fields(18);
					$JML11		= $Item->Fields(19);
					$JML12		= $Item->Fields(20);
					
					$sql = "INSERT INTO d_trktrm(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, RPHPAGU, KDTRKTRM, JNSBELANJA, JML01, JML02, JML03, 
					JML04, JML05, JML06, JML07, JML08, JML09, JML10, JML11, JML12) VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', 
					'".$KDPROGRAM."', '".$KDGIAT."', '".$RPHPAGU."', '".$KDTRKTRM."', '".$JNSBELANJA."', '".$JML01."', '".$JML02."', '".$JML03."', 
					'".$JML04."', '".$JML05."', '".$JML06."', '".$JML07."', '".$JML08."', '".$JML09."', '".$JML10."', '".$JML11."', '".$JML12."')";
					
					mysql_query($sql);
    				$Item->MoveNext();
				}
				
				$Item->Close();
				*/
				
				$table_7 = new XBaseTable($tabel_7);
				$table_7->open();
				
				while ($record = $table_7->nextRecord())
				{
					foreach ($table_7->getColumns() as $i=>$c)
					{
						if ($c->getName() == "THANG") 			$THANG 		= $record->getString($c); 
						else if ($c->getName() == "KDSATKER") 	$KDSATKER	= $record->getString($c);
						else if ($c->getName() == "KDDEPT")		$KDDEPT		= $record->getString($c);
						else if ($c->getName() == "KDUNIT")		$KDUNIT		= $record->getString($c);
						else if ($c->getName() == "KDPROGRAM")	$KDPROGRAM	= $record->getString($c);
						else if ($c->getName() == "KDGIAT")		$KDGIAT		= $record->getString($c);
						else if ($c->getName() == "RPHPAGU")	$RPHPAGU	= $record->getString($c);
						else if ($c->getName() == "KDTRKTRM")	$KDTRKTRM	= $record->getString($c);
						else if ($c->getName() == "JNSBELANJA")	$JNSBELANJA	= $record->getString($c);
						else if ($c->getName() == "JML01")		$JML01		= $record->getString($c);
						else if ($c->getName() == "JML02")		$JML02		= $record->getString($c);
						else if ($c->getName() == "JML03")		$JML03		= $record->getString($c);
						else if ($c->getName() == "JML04")		$JML04		= $record->getString($c);
						else if ($c->getName() == "JML05")		$JML05		= $record->getString($c);
						else if ($c->getName() == "JML06")		$JML06		= $record->getString($c);
						else if ($c->getName() == "JML07")		$JML07		= $record->getString($c);
						else if ($c->getName() == "JML08")		$JML08		= $record->getString($c);
						else if ($c->getName() == "JML09")		$JML09		= $record->getString($c);
						else if ($c->getName() == "JML10")		$JML10		= $record->getString($c);
						else if ($c->getName() == "JML11")		$JML11		= $record->getString($c);
						else if ($c->getName() == "JML12")		$JML12		= $record->getString($c);
					}
					
					if ($THANG == $th)
					{
						$sql = "INSERT INTO d_trktrm(THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, RPHPAGU, KDTRKTRM, JNSBELANJA, JML01, JML02, JML03, 
						JML04, JML05, JML06, JML07, JML08, JML09, JML10, JML11, JML12) VALUES ('".$THANG."', '".$KDSATKER."', '".$KDDEPT."', '".$KDUNIT."', 
						'".$KDPROGRAM."', '".$KDGIAT."', '".$RPHPAGU."', '".$KDTRKTRM."', '".$JNSBELANJA."', '".$JML01."', '".$JML02."', '".$JML03."', 
						'".$JML04."', '".$JML05."', '".$JML06."', '".$JML07."', '".$JML08."', '".$JML09."', '".$JML10."', '".$JML11."', '".$JML12."')";
					
						mysql_query($sql);
					}
				}
				
				$table_7->close();
			}

			$_SESSION['errmsg'] = "Proses Refresh data berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		}
	} 
?>

<style type="text/css">
	<!--
	.style1 {color: #990000}
	-->
</style>

<form action="" method="post" name="form" enctype="multipart/form-data">
	<table cellspacing="1" class="admintable">
		<tr> 
			<td width="120" class="key">Seting Tahun</td>
			<td width="335"><?php echo $th ?></td>
		</tr>
		<tr>
			<td class="key">Data Tahun </td>
			<td><?php echo $th_file ?></td>
		</tr>
		<tr>
		  <td class="key">Satuan Kerja</td>
		  <td>
		  
		  <select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
			switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
		case '3':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;
		case '4':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		case '6':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;
		case '7':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		default:
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
	}
			//$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['KDSATKER'] ?>"><?php echo  $row['KDSATKER'].' '.$row['namasatker']; ?></option>
		    <?php
			} ?>
          </select>
	  
		  </td>
	  </tr>
		<tr>
		  <td class="key">&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td class="key">&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
			<td colspan="2" class="key">
            	<font color="#000066"><?php 

					if ( $th <> $th_file ) echo '<blink> Tahun tidak sesuai, Batalkan Proses dan Impor file data yang sesuai !';
					if ( $th == $th_file ) echo '<blink> Tahun sesuai, Proses dapat dilanjutkan !'; ?>
                </font>            </td>
		</tr>
		<tr>
			<td colspan="2" align="center">
            	<font color="#EC0000"><?php echo 'Jumlah Pagu Anggaran Tahun '.$th_file.' Rp. '.number_format($jumlah,"0",",",".") ?></font>            </td>
		</tr>
		<tr> 
			<td class="key">Data Output</td>
			<td> &nbsp; <input type="checkbox" name="output" value="1" checked> <span class="style1">[File : D_OUTPUT.KEU]</span></td>
		</tr>
		<tr> 
			<td class="key">Data Sub Output</td>
			<td> &nbsp;<span class="style1"><input type="checkbox" name="soutput" value="1" checked>[File : D_SOUTPUT.KEU]</span></td>
		</tr>
		<tr> 
			<td class="key">Data Komponen</td>
			<td> &nbsp;<span class="style1"><input type="checkbox" name="kmpnen" value="1" checked>[File : D_KMPNEN.KEU]</span></td>
		</tr>
		<tr> 
			<td class="key">Data Sub Komponen</td>
			<td> &nbsp;<span class="style1"><input type="checkbox" name="skmpnen" value="1" checked>[File : D_SKMPNEN.KEU]</span></td>
		</tr>
		<tr> 
			<td class="key">Data DIPA</td>
			<td> &nbsp;<span class="style1"><input type="checkbox" name="dipa" value="1" checked>[File : D_AKUN.KEU]</span></td>
		</tr>
		<tr> 
			<td class="key">Data POK</td>
			<td> &nbsp;<span class="style1"><input type="checkbox" name="pok" value="1" checked>[File : D_ITEM.KEU]</span></td>
		</tr>
		<tr> 
			<td class="key">Data Rencana Penarikan</td>
			<td> &nbsp;<span class="style1"><input type="checkbox" name="trktrm" value="1" checked>[File : D_TRKTRM.KEU]</span></td>
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
				<input name="form" type="hidden" value="1" />            </td>
		</tr>
	</table>
</form>