<?
	// setting ftp address
	$ftp_server = "118.98.232.125";
	$ftp_port = 21;
	$ftp_user = "amerta";
	$ftp_passwd = "amerta";

	/* direct object methods */
	require_once "ftp.class.php";
	$ftp =& new FTP();
	if ($ftp->connect($ftp_server, $ftp_port)) {
		// mark start time
		$start_time = MICROTIME(TRUE);
		if ($ftp->login($ftp_user,$ftp_passwd)) {
			$ftp->get("sakpa.mdb","sakpa.mdb");
			$ftp->delete("sakpa.mdb");
		} else {
			echo "login failed: ";
		}
		$ftp->disconnect();
		// mark end time
		$stop_time = MICROTIME(TRUE);
		// get the difference in seconds
		$time = $stop_time - $start_time;
		echo "Elapsed time was $time seconds.";

	} 
	else {
		echo "connection failed: ";
	}
?>