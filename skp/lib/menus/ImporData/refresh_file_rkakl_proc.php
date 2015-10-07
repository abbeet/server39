<?php
	if(isset($_POST['q']))
	{
		include ("../../includes/includes.php");
		$q = $_POST['q'];
		$tgl_refresh = $_POST['tgl_refresh'];
		$user_refresh = $_POST['user_refresh'];
		
		odbc_close_all();
		$dsn = "Driver={Microsoft Visual FoxPro Driver}; SourceType=DBF; SourceDB=c:\\xampp\\htdocs\\siplapan\\file_dipa; Exclusive=No;";

		$sambung_dipa = odbc_connect( $dsn,"","");
    	
		if ( $sambung_dipa != 0 )   
    	{
      	#echo "<strong> Tersambung RKAKL </strong></<br>";
			$oData = "SELECT THANG FROM D_ITEM.KEU";	
			$Data = odbc_exec($sambung_dipa,$oData);
			$row = odbc_fetch_row($Data);
			$ta = odbc_result($Data,THANG);
		}
		
		switch ($q)
		{
			case "D_OUTPUT":
				mysql_query("DELETE FROM d_output WHERE THANG = '".$ta."'");
				$oOutput = "SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, VOL FROM D_OUTPUT.KEU WHERE THANG = '$ta'";	
				$Output = odbc_exec($sambung_dipa,$oOutput);
				
				while ($row = odbc_fetch_row($Output))
				{
					$THANG = odbc_result($Output,THANG);
					$KDSATKER = odbc_result($Output,KDSATKER);
					$KDDEPT = odbc_result($Output,KDDEPT);
					$KDUNIT = odbc_result($Output,KDUNIT);
					$KDPROGRAM = odbc_result($Output,KDPROGRAM);
					$KDGIAT = odbc_result($Output,KDGIAT);
					$KDOUTPUT = odbc_result($Output,KDOUTPUT);
					$VOL = odbc_result($Output,VOL);

					$sql = "INSERT INTO d_output (THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, VOL) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$VOL')";
					mysql_query($sql);
						
				}
				
				break;
			
			case "D_SOUTPUT":
				mysql_query("DELETE FROM d_soutput WHERE THANG = '".$ta."'");
				$oSOutput = "SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, URSOUTPUT, VOLSOUT FROM D_SOUTPUT.KEU WHERE THANG = '$ta'";	
				$SOutput = odbc_exec($sambung_dipa,$oSOutput);
				
				while ($row = odbc_fetch_row($SOutput))
				{
					$THANG = odbc_result($SOutput,THANG);
					$KDSATKER = odbc_result($SOutput,KDSATKER);
					$KDDEPT = odbc_result($SOutput,KDDEPT);
					$KDUNIT = odbc_result($SOutput,KDUNIT);
					$KDPROGRAM = odbc_result($SOutput,KDPROGRAM);
					$KDGIAT = odbc_result($SOutput,KDGIAT);
					$KDOUTPUT = odbc_result($SOutput,KDOUTPUT);
					$KDSOUTPUT = odbc_result($SOutput,KDSOUTPUT);
					$URSOUTPUT = odbc_result($SOutput,URSOUTPUT);
					$VOLSOUT = odbc_result($SOutput,VOLSOUT);

					$sql = "INSERT INTO d_soutput (THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, URSOUTPUT, VOLSOUT) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$URSOUTPUT', '$VOLSOUT')";
					mysql_query($sql);
						
				}
				
				break;
				
			case "D_KMPNEN":
				mysql_query("DELETE FROM d_kmpnen WHERE THANG = '".$ta."'");
				$oKmpnen = "SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, URKMPNEN FROM D_KMPNEN.KEU WHERE THANG = '$ta'";	
				$Kmpnen = odbc_exec($sambung_dipa,$oKmpnen);
				
				while ($row = odbc_fetch_row($Kmpnen))
				{
					$THANG = odbc_result($Kmpnen,THANG);
					$KDSATKER = odbc_result($Kmpnen,KDSATKER);
					$KDDEPT = odbc_result($Kmpnen,KDDEPT);
					$KDUNIT = odbc_result($Kmpnen,KDUNIT);
					$KDPROGRAM = odbc_result($Kmpnen,KDPROGRAM);
					$KDGIAT = odbc_result($Kmpnen,KDGIAT);
					$KDOUTPUT = odbc_result($Kmpnen,KDOUTPUT);
					$KDSOUTPUT = odbc_result($Kmpnen,KDSOUTPUT);
					$KDKMPNEN = odbc_result($Kmpnen,KDKMPNEN);
					$URKMPNEN = odbc_result($Kmpnen,URKMPNEN);

					$sql = "INSERT INTO d_kmpnen (THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, URKMPNEN) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$URKMPNEN')";
					mysql_query($sql);
						
				}
				
				break;
				
			case "D_SKMPNEN":
				mysql_query("DELETE FROM d_skmpnen WHERE THANG = '".$ta."'");
				$oSKmpnen = "SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, URSKMPNEN FROM D_SKMPNEN.KEU WHERE THANG = '$ta'";	
				$SKmpnen = odbc_exec($sambung_dipa,$oSKmpnen);
				
				while ($row = odbc_fetch_row($SKmpnen))
				{
					$THANG = odbc_result($SKmpnen,THANG);
					$KDSATKER = odbc_result($SKmpnen,KDSATKER);
					$KDDEPT = odbc_result($SKmpnen,KDDEPT);
					$KDUNIT = odbc_result($SKmpnen,KDUNIT);
					$KDPROGRAM = odbc_result($SKmpnen,KDPROGRAM);
					$KDGIAT = odbc_result($SKmpnen,KDGIAT);
					$KDOUTPUT = odbc_result($SKmpnen,KDOUTPUT);
					$KDSOUTPUT = odbc_result($SKmpnen,KDSOUTPUT);
					$KDKMPNEN = odbc_result($SKmpnen,KDKMPNEN);
					$KDSKMPNEN = odbc_result($SKmpnen,KDSKMPNEN);
					$URSKMPNEN = odbc_result($SKmpnen,URSKMPNEN);

					$sql = "INSERT INTO d_skmpnen (THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, URSKMPNEN) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$KDSKMPNEN', '$URSKMPNEN')";
					mysql_query($sql);
						
				}
				
				break;
				
			case "D_AKUN":
				mysql_query("DELETE FROM d_akun WHERE THANG = '".$ta."'");
				$oAkun = "SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN FROM D_AKUN.KEU WHERE THANG = '$ta'";	
				$Akun = odbc_exec($sambung_dipa,$oAkun);
				
				while ($row = odbc_fetch_row($Akun))
				{
					$THANG = odbc_result($Akun,THANG);
					$KDSATKER = odbc_result($Akun,KDSATKER);
					$KDDEPT = odbc_result($Akun,KDDEPT);
					$KDUNIT = odbc_result($Akun,KDUNIT);
					$KDPROGRAM = odbc_result($Akun,KDPROGRAM);
					$KDGIAT = odbc_result($Akun,KDGIAT);
					$KDOUTPUT = odbc_result($Akun,KDOUTPUT);
					$KDSOUTPUT = odbc_result($Akun,KDSOUTPUT);
					$KDKMPNEN = odbc_result($Akun,KDKMPNEN);
					$KDSKMPNEN = odbc_result($Akun,KDSKMPNEN);
					$KDAKUN = odbc_result($Akun,KDAKUN);

					$sql = "INSERT INTO d_akun (THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$KDSKMPNEN', '$KDAKUN')";
					mysql_query($sql);
						
				}
				
				break;
				
			case "D_ITEM":
				mysql_query("DELETE FROM d_item WHERE THANG = '".$ta."'");
				$oItem = "SELECT THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN, JUMLAH, JANUARI, PEBRUARI, MARET, APRIL, MEI, JUNI, JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOPEMBER, DESEMBER, HEADER1, HEADER2, KDHEADER, NOITEM, NMITEM, VOLKEG, SATKEG, HARGASAT FROM D_ITEM.KEU WHERE THANG = '$ta'";	
				$Item = odbc_exec($sambung_dipa,$oItem);
				
				while ($row = odbc_fetch_row($Item))
				{
					$THANG = odbc_result($Item,THANG);
					$KDSATKER = odbc_result($Item,KDSATKER);
					$KDDEPT = odbc_result($Item,KDDEPT);
					$KDUNIT = odbc_result($Item,KDUNIT);
					$KDPROGRAM = odbc_result($Item,KDPROGRAM);
					$KDGIAT = odbc_result($Item,KDGIAT);
					$KDOUTPUT = odbc_result($Item,KDOUTPUT);
					$KDSOUTPUT = odbc_result($Item,KDSOUTPUT);
					$KDKMPNEN = odbc_result($Item,KDKMPNEN);
					$KDSKMPNEN = odbc_result($Item,KDSKMPNEN);
					$KDAKUN = odbc_result($Item,KDAKUN);
					$JUMLAH = odbc_result($Item,JUMLAH);
					$JANUARI = odbc_result($Item,JAN);
					$PEBRUARI = odbc_result($Item,PEB);
					$MARET = odbc_result($Item,MAR);
					$APRIL = odbc_result($Item,APR);
					$MEI = odbc_result($Item,MEI);
					$JUNI = odbc_result($Item,JUN);
					$JULI = odbc_result($Item,JUL);
					$AGUSTUS = odbc_result($Item,AGT);
					$SEPTEMBER = odbc_result($Item,SEP);
					$OKTOBER = odbc_result($Item,OKT);
					$NOPEMBER = odbc_result($Item,NOP);
					$DESEMBER = odbc_result($Item,DES);
					$HEADER1 = odbc_result($Item,HEADER1);
					$HEADER2 = odbc_result($Item,HEADER2);
					$KDHEADER = odbc_result($Item,KDHEADER);
					$NOITEM = odbc_result($Item,NOITEM);
					$NMITEM = odbc_result($Item,NMITEM);
					$VOLKEG = odbc_result($Item,VOLKEG);
					$SATKEG = odbc_result($Item,SATKEG);
					$HARGASAT = odbc_result($Item,HARGASAT);

					$sql = "INSERT INTO d_item (THANG, KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN, JUMLAH, JANUARI, PEBRUARI, MARET, APRIL, MEI, JUNI, JULI, AGUSTUS, SEPTEMBER, OKTOBER, NOPEMBER, DESEMBER, HEADER1, HEADER2, KDHEADER, NOITEM, NMITEM, VOLKEG, SATKEG, HARGASAT) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$KDSKMPNEN', '$KDAKUN', '$JUMLAH', '$JANUARI', '$PEBRUARI', '$MARET','$APRIL', '$MEI', '$JUNI', '$JULI', '$AGUSTUS', '$SEPTEMBER', '$OKTOBER', '$NOPEMBER', '$DESEMBER', '$HEADER1', '$HEADER2', '$KDHEADER', '$NOITEM', '$NMITEM', '$VOLKEG', '$SATKEG', '$HARGASAT' )";
					mysql_query($sql);
						
				}
				
				break;
		}
			
		$sql = "UPDATE dt_fileupload SET tgl_refresh = '$tgl_refresh', user_refresh = '$user_refresh' WHERE kdfile = '$q'";				
		$query = mysql_query($sql) or die(mysql_error());
		echo '{status:3}';
	}
?>
