<?php
	include "includes.php";
	
	$fopen = fopen("2322810.csv", "r");
	
	if ($fopen)
	{
		$row1 = "";
		$row2 = "";
		$row3 = "";
		$row4 = "";
		$row5 = "";
		$row6 = "";
		$row7 = "";
		$row8 = "";
		$row9 = "";
		$row10 = "";
		$row11 = "";
		$row12 = "";
		$row13 = "";
		$row14 = "";
		$row15 = "";
		$row16 = "";
		$row17 = "";
		$row18 = "";
		$row19 = "";
		$row20 = ""; ?>
        
        <table border="1"><?php
		
			while (!feof($fopen))
			{
				fscanf($fopen, "%s %s %s %s %s %s %s %s %s %s %s %s %s %s %s %s %s %s %s %s", $row1, $row2, $row3, $row4, $row5, $row6, $row7, $row8, $row9, 
				$row10, $row11, $row12, $row13, $row14, $row15, $row16, $row17, $row18, $row19, $row20);
				
				$row = $row1." ".$row2." ".$row3." ".$row4." ".$row5." ".$row6." ".$row7." ".$row8." ".$row9." ".$row10." ".$row11." ".$row12." ".$row13." ".
				$row14." ".$row15." ".$row16." ".$row17." ".$row18." ".$row19." ".$row20;
				$xplode = explode(",", $row);
				
				$nama 		= trim(str_replace("#", ",", $xplode[0]));
				$nip 		= str_replace(" ", "", $xplode[1]);
				$unit 		= trim(str_replace("#", ",", $xplode[2]));
				$eselon 	= $xplode[3];
				$email 		= str_replace("#", ",", $xplode[4]);
				$alamat		= trim(str_replace("#", ",", $xplode[5]));
				$telepon	= str_replace("#", ",", $xplode[6]);
				
				if ($nip != "")
				{
					$sql 	= "SELECT kdunit FROM unit WHERE kdunit LIKE '232281%' AND nmunit LIKE '%".$unit."%'";
					$ounit 	= mysql_query($sql) or die(mysql_error());
					$unit 	= mysql_fetch_array($ounit);
					$kdunit	= $unit['kdunit'];
					
					switch ($eselon)
					{
						case "I"	: $es = "1"; $level = "DITJEN"; break;
						case "II"	: $es = "2"; $level = "DIT"; break;
						case "III"	: $es = "3"; $level = "SUBDIT"; break;
						case "IV"	: $es = "4"; $level = "SEKSI"; break;
						default		: $es = "";  $level = "STAF"; break;
					}
					
					$sql = "SELECT * FROM pegawai WHERE nip = '".$nip."'";
					$opegawai = mysql_query($sql) or die(mysql_error());
					$npegawai = mysql_num_rows($opegawai);
					
					if ($npegawai == 0)
					{
						$sql = "INSERT INTO pegawai (nip, nama, unit, eselon, alamat, telepon) VALUES ('".$nip."', '".$nama."', '".$kdunit."', '".$es.
						"', '".$alamat."', '".$telepon."')";
						
						#$query = mysql_query($sql) or die(mysql_error());
					}
					
					else
					{
						$sql = "UPDATE pegawai SET nama = '".$nama."', unit = '".$kdunit."', eselon = '".$es."', alamat = '".$alamat."', telepon = '".
						$telepon."' WHERE nip = '".$nip."'";
						
						#$query = mysql_query($sql) or die(mysql_error());
					}
					
						
					$sql = "SELECT * FROM xuser WHERE username = '".$nip."'";
					$ouser = mysql_query($sql) or die(mysql_error());
					$nuser = mysql_num_rows($ouser);
					
					if ($nuser == 0)
					{
						$sql = "INSERT INTO xuser (username, unit, password, email, aktif, reset) VALUES ('".$nip."', '".$kdunit."', 
						'5b4bec75d8b46e693da22199faafdd97', '".$email."', '1', '1')";
						
						#$query = mysql_query($sql) or die(mysql_error());
					}
					
					else
					{
						$sql = "UPDATE xuser SET unit = '".$kdunit."', email = '".$email."' WHERE username = '".$nip."'";
						#$query = mysql_query($sql) or die(mysql_error());
					}
					
					$sql = "DELETE FROM xuserlevel WHERE username = '".$nip."'";
					#$query = mysql_query($sql) or die(mysql_error());
					
					$sql = "INSERT INTO xuserlevel (username, level) VALUES ('".$nip."', '".$level."')";
					#$query = mysql_query($sql) or die(mysql_error()); ?>
					
					<tr>
						<td><?php echo $nip; ?></td>
						<td><?php echo $nama; ?></td>
						<td><?php echo $kdunit; ?></td>
						<td><?php echo $es; ?></td>
						<td><?php echo $alamat; ?></td>
						<td><?php echo $email; ?></td>
						<td><?php echo $telepon; ?></td>
					</tr><?php
					
					$row1 = "";
					$row2 = "";
					$row3 = "";
					$row4 = "";
					$row5 = "";
					$row6 = "";
					$row7 = "";
					$row8 = "";
					$row9 = "";
					$row10 = "";
					$row11 = "";
					$row12 = "";
					$row13 = "";
					$row14 = "";
					$row15 = "";
					$row16 = "";
					$row17 = "";
					$row18 = "";
					$row19 = "";
					$row20 = "";
				}
			} ?>
            
        </table><?php
	}
?>