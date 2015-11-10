<?php
	checkauthentication();
	extract($_POST);
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$defdir = str_replace("/", "\\", $_SERVER["DOCUMENT_ROOT"]);
    $dbq    = $defdir . "\\dikbud\\file_emsa\\rkakl.mdb";
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
		$sql ="DELETE FROM d_akun WHERE THANG = '$th'" ; 
		mysql_query($sql) ;
			
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, Jumlah from d_akun";	
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
			$kdsoutput   = odbc_result($Data, kdsoutput);
			$kdkmpnen = odbc_result($Data, kdkmpnen);
			$kdskmpnen   = odbc_result($Data, kdskmpnen);
			$kdakun   = odbc_result($Data, kdakun);
			$jumlah   = odbc_result($Data, jumlah);
			
			if ( $thang <> $th )
			{
				$_SESSION['errmsg'] = "Seting Tahun tidak sesuai"; ?>

				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			
			}
			// cek data
			$sql ="INSERT INTO d_akun VALUES('$thang', '$kdsatker', '$kddept', '$kdunit',
					'$kdprogram', '$kdgiat', '$kdoutput', '$kdsoutput', '$kdkmpnen', '$kdskmpnen', 
					'$kdakun', '$jumlah')" ; 
			mysql_query($sql) ;
			
			//echo "$tahun $kdsatker $vol<br>";
		}
		
		echo "Proses 2 ... <br>";
		$sql ="DELETE FROM d_item WHERE THANG = '$th'" ; 
		mysql_query($sql) ;
			
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun,
				header1, header2, kdheader, noitem, nmitem, vol1, sat1, vol2, sat2,
				vol3, sat3, vol4, sat4, volkeg, satkeg, hargasat, jumlah,
				januari, pebruari, maret, april, mei, juni, juli, agustus,
				september, oktober, nopember, desember, kdblokir, rphblokir
				from d_item";	
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
			$kdsoutput   = odbc_result($Data, kdsoutput);
			$kdkmpnen = odbc_result($Data, kdkmpnen);
			$kdskmpnen   = odbc_result($Data, kdskmpnen);
			$kdakun   = odbc_result($Data, kdakun);
			$header1  = odbc_result($Data, header1);
			$header2  = odbc_result($Data, header2);
			$kdheader = odbc_result($Data, kdheader);
			$noitem   = odbc_result($Data, noitem);
			$nmitem   = odbc_result($Data, nmitem);
			$vol1     = odbc_result($Data, vol1);
			$sat1     = odbc_result($Data, sat1);
			$vol2     = odbc_result($Data, vol2);
			$sat2     = odbc_result($Data, sat2);
			$vol3     = odbc_result($Data, vol3);
			$sat3     = odbc_result($Data, sat3);
			$vol4     = odbc_result($Data, vol4);
			$sat4     = odbc_result($Data, sat4);
			$volkeg   = odbc_result($Data, volkeg);
			$satkeg   = odbc_result($Data, satkeg);
			$hargasat = odbc_result($Data, hargasat);
			$jumlah   = odbc_result($Data, jumlah);
			$januari  = odbc_result($Data, januari);
			$pebruari = odbc_result($Data, pebruari);
			$maret    = odbc_result($Data, maret);
			$april    = odbc_result($Data, april);
			$mei      = odbc_result($Data, mei);
			$juni     = odbc_result($Data, juni);
			$juli     = odbc_result($Data, juli);
			$agustus  = odbc_result($Data, agustus);
			$september     = odbc_result($Data, september);
			$oktober       = odbc_result($Data, oktober);
			$nopember      = odbc_result($Data, nopember);
			$desember      = odbc_result($Data, desember);
			$kdblokir      = odbc_result($Data, kdblokir);
			$rphblokir     = odbc_result($Data, rphblokir);
			
			if ( $thang <> $th )
			{
				$_SESSION['errmsg'] = "Seting Tahun tidak sesuai"; ?>

				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			
			}
			// cek data
			$sql ="INSERT INTO d_item VALUES('$thang', '$kdsatker', '$kddept', '$kdunit',
					'$kdprogram', '$kdgiat', '$kdoutput', '$kdsoutput', '$kdkmpnen', '$kdskmpnen', 
					'$kdakun', '$header1', '$header2', '$kdheader', '$noitem', '$nmitem', '$vol1',
					'$sat1', '$vol2', '$sat2', '$vol3', '$sat3', '$vol4', '$sat4', '$volkeg', '$satkeg',
					'$hargasat', '$jumlah', '$januari', '$pebruari', '$maret', '$april', '$mei',
					'$juni', '$juli', '$agustus', '$september', '$oktober', '$nopember', '$desember',
					'$kdblokir', '$rphblokir')" ; 
			mysql_query($sql) ;
			
			//echo "$tahun $kdsatker $vol<br>";
		}
		
		
        echo "Proses 3 ... <br>";
		$sql ="DELETE FROM d_skmpnen WHERE THANG = '$th'" ; 
		mysql_query($sql) ;
			
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, kdsoutput, kdkmpnen, kdskmpnen, urskmpnen from d_skomponen";	
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
			$kdsoutput   = odbc_result($Data, kdsoutput);
			$kdkmpnen = odbc_result($Data, kdkmpnen);
			$kdskmpnen   = odbc_result($Data, kdskmpnen);
			$urskmpnen   = odbc_result($Data, urskmpnen);
			
			if ( $thang <> $th )
			{
				$_SESSION['errmsg'] = "Seting Tahun tidak sesuai"; ?>

				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			
			}
			// cek data
			$sql ="INSERT INTO d_skmpnen VALUES('$thang', '$kdsatker', '$kddept', '$kdunit',
					'$kdprogram', '$kdgiat', '$kdoutput', '$kdsoutput', '$kdkmpnen', '$kdskmpnen', 
					'$urskmpnen')" ; 
			mysql_query($sql) ;
			
			//echo "$tahun $kdsatker $vol<br>";
		}
		
        echo "Proses 4 ... <br>";
		$sql ="DELETE FROM d_kmpnen WHERE THANG = '$th'" ; 
		mysql_query($sql) ;
			
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, kdsoutput, kdkmpnen, urkmpnen, kdsbiaya from d_komponen";	
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
			$kdsoutput   = odbc_result($Data, kdsoutput);
			$kdkmpnen = odbc_result($Data, kdkmpnen);
			$urkmpnen   = odbc_result($Data, urkmpnen);
			$kdsbiaya   = odbc_result($Data, kdsbiaya);
			
			if ( $thang <> $th )
			{
				$_SESSION['errmsg'] = "Seting Tahun tidak sesuai"; ?>

				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			
			}
			// cek data
			$sql ="INSERT INTO d_kmpnen VALUES('$thang', '$kdsatker', '$kddept', '$kdunit',
					'$kdprogram', '$kdgiat', '$kdoutput', '$kdsoutput', '$kdkmpnen', '$urkmpnen', 
					'$kdsbiaya')" ; 
			mysql_query($sql) ;
			
			//echo "$tahun $kdsatker $vol<br>";
		}
	
		echo "Proses 5 ... <br>";
		$sql ="DELETE FROM d_soutput WHERE THANG = '$th'" ; 
		mysql_query($sql) ;
			
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, kdsoutput, ursoutput, volsout from d_soutput";	
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
			$kdsoutput   = odbc_result($Data, kdsoutput);
			$ursoutput   = odbc_result($Data, ursoutput);
			$volsout   = odbc_result($Data, volsout);
			
			if ( $thang <> $th )
			{
				$_SESSION['errmsg'] = "Seting Tahun tidak sesuai"; ?>

				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			
			}
			// cek data
			$sql ="INSERT INTO d_soutput VALUES('$thang', '$kdsatker', '$kddept', '$kdunit',
					'$kdprogram', '$kdgiat', '$kdoutput', '$kdsoutput', '$ursoutput', 
					'$volsout')" ; 
			mysql_query($sql) ;
			
			//echo "$tahun $kdsatker $vol<br>";
		}
		
		echo "Proses 6 ... <br>";
		$sql ="DELETE FROM d_output WHERE THANG = '$th'" ; 
		mysql_query($sql) ;
			
		$oData="select thang, kdsatker, kddept, kdunit, kdprogram, kdgiat,
				kdoutput, vol from d_output";	
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
			$vol   = odbc_result($Data, vol);
			
			if ( $thang <> $th )
			{
				$_SESSION['errmsg'] = "Seting Tahun tidak sesuai"; ?>

				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			
			}
			// cek data
			$sql ="INSERT INTO d_output VALUES('$thang', '$kdsatker', '$kddept', '$kdunit',
					'$kdprogram', '$kdgiat', '$kdoutput', '$vol')" ; 
			mysql_query($sql) ;
			
			//echo "$tahun $kdsatker $vol<br>";
		}
		
		$_SESSION['errmsg'] = "Proses Import data berhasil";
		?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
		odbc_close_all();
	}
?> 