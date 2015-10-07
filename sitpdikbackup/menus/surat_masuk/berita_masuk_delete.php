<?php
checkauthentication();
	$id = ekstrak_get(@$get[1]);
		
	$kotaksuratlist = 27;


	mysql_query("DELETE FROM berita WHERE IdBerita = '".$id."'") or die(mysql_error());
	//mysql_query("optimize table suratmasuk") or die(mysql_errno()." : ".mysql_error());
	
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($kotaksuratlist)."\">";
	exit();
?>