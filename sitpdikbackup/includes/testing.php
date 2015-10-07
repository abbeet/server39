<?php
	include "includes.php";
	
	$text 	= "3"; 						echo $text."<BR>";
	$base64	= base64_encode($text); 	echo $base64."<BR>";
	$x 		= substr($base64, 0, 2); 	echo $x."<BR>";
	$y 		= substr($base64, 2); 		echo $y."<BR>";
	$z		= encode_password($x, 1);	echo $z."<BR>";
	$result	= $z.$y;					echo $result."<BR>";
	$base64	= base64_decode($result);	echo $base64."<BR>";
	
	$text	= $result;					echo $text."<BR>";
	$x		= substr($text, 0, 2);		echo $x."<BR>";
	$y		= substr($text, 2);			echo $y."<BR>";
	$z		= encode_password($x, 1);	echo $z."<BR>";
	$a		= $z.$y;					echo $a."<BR>";
	$base64 = base64_decode($a);		echo $base64."<BR>";
?>