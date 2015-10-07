<?php
	include "dbh.php";
	$th = 2014 ;
	$defdir = str_replace("/", "\\", $_SERVER["DOCUMENT_ROOT"]);
    $dbq    = $defdir . "\\dikbud\\file_emsa\\sakpa.mdb";
	if (!file_exists($dbq)) { 
		die("Database file $dbq does not exist"); 
	}
	// DSN
    $dsn = "DRIVER=Microsoft Access Driver (*.mdb);UID=admin;UserCommitSync=Yes;Threads=3;
	SafeTransactions=0;PageTimeout=5;MaxScanRows=8;MaxBufferSize=2048;FIL=MS Access;
	DriverId=25;DefaultDir=$defdir;DBQ=$dbq";
    $conn = odbc_connect($dsn,"","")
        or die("Could not connect to Access database $dsn");
	// access to database
	if ($conn)   
    {
	
        echo "Proses 1 ... <br>";
		mysql_query("DELETE FROM m_spmind WHERE THANG = '$th' ");
				
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, totnilmak, totnilmap, nospm, tgspm, nosp2d, tgsp2d from d_spmind where thang = '$th'";	
		$Data=odbc_exec($conn,$oData);
		while(odbc_fetch_row($Data))
		{
			$thang    = odbc_result($Data, thang);
			$kdsatker = odbc_result($Data, kdsatker);
			$kddept   = odbc_result($Data, kddept);
			$kdunit   = odbc_result($Data, kdunit);  
			$kdprogram   = odbc_result($Data, kdprogram);
			$kdgiat   = odbc_result($Data, kdgiat);
			$kdoutput = odbc_result($Data, kdoutput);
			$totnilmak   = odbc_result($Data, totnilmak);
			$totnilmap = odbc_result($Data, totnilmap);
			$nospm   = odbc_result($Data, nospm);
			$tgspm   = odbc_result($Data, tgspm);
			$nosp2d  = odbc_result($Data, nosp2d);
			$tgsp2d   = odbc_result($Data, tgsp2d);
			
			//------ INSERT
				$sql_aksi = "INSERT INTO m_spmind(THANG, KDDEPT, KDUNIT, KDSATKER, KDPROGRAM, KDGIAT,
							 KDOUTPUT, TOTNILMAK, TOTNILMAP, NOSPM, TGSPM, NOSP2D, TGSP2D)
							 VALUES('$thang', '$kddept', '$kdunit', '$kdsatker',
							'$kdprogram', '$kdgiat', '$kdoutput', '$totnilmak', '$totnilmap',
							'$nospm', '$tgspm', '$nosp2d', '$tgsp2d')";
			//echo 'no sp2d '.$nosp2d.'<br>';
			mysql_query($sql_aksi) ;
		
		}
		
		$_SESSION['errmsg'] = "Proses Import data berhasil";
		odbc_close_all();
	}
?> 