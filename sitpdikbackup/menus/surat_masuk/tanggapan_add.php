<?php

checkauthentication();

	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$addtanggapan = 98;
	$tanyadisposisi = 97;
	$kotaksuratlist = 27;
	$addtanggapan = 98;

	$q = ekstrak_get(@$get[1]);
	$NoSurat = ekstrak_get(@$get[2]);
	$Perihal = ekstrak_get(@$get[3]);
	$BeritaFlag = ekstrak_get(@$get[4]);
	$StatusDisposisi = ekstrak_get(@$get[5]);
    $Instruksi = ekstrak_get(@$get[6]);
    $Pengirim = ekstrak_get(@$get[7]);

$xlevel = @$_SESSION['xlevel_'.$session_name];
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 


date_default_timezone_set('Asia/Jakarta');
//$Perihal			=$_GET["Perihal"];
//$Instruksi			=$_GET["Instruksi"];
//$NoSurat			=$_GET["NoSurat"];
//$id					=$_GET["Id"];
//$BeritaFlag			=$_GET["BeritaFlag"];
//$Pengirim   		=$_GET["Pengirim"];
//$ParentId   		=$_GET["StatusDisposisi"];

//$IdPengirim         =$_GET["IdPengirim"];
//$ParentId	=$_GET["StatusDisposisi"] + 1;
$bError		= false;
$sMessage	= "";
//$CariParent = mysql_query("SELECT * FROM $Tb_Diposisi WHERE NoSurat = '$NoSurat' AND IdPengirim = '".$_SESSION['MM__AdminID']."' and IdPenerima='$Pengirim' ") or die(mysql_error());
	$CariParent = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '".$NoSurat ."' AND IdPengirim='".$Pengirim."' and IdPenerima='".$IdUser."' ") or die(mysql_error());
	//if (mysql_num_rows($CariParent) == 0) {
	//	$ParentId = 0;
	//} else {
	$Edit		= mysql_fetch_object($CariParent);
		$ParentId	= $Edit->IdDisposisi;
		$StatusTgp = '1';
//	}
	
	
if ($_POST["Submit"]) {
	$NoSurat		=$_POST['NoSurat'];
	$ParentId		=$_POST['ParentId'];
	$IdPengirim		=$_SESSION['MM__AdminID'];
	$Tanggapan		=$_POST['Tanggapan'];
	$Perihal		=$_POST["Perihal"];
	$IdPenerima		=$_POST["Pengirim"];
	//$IdDisposisi    =$_POST["StatusDisposisi"];
	$Isi 			=$_POST['Isi'];
	$BeritaFlag	 	=$_POST['BeritaFlag'];
	
	$Tanggapany =trim( preg_replace( '/\s+/', ' ', $Tanggapan ) );
		$Tanggapanx =  preg_replace("/[^a-zA-Z0-9]+/", " ", $Tanggapany);
		
	mysql_query("update disposisi set Tanggapan='".$Tanggapanx."' where IdDisposisi='".$ParentId."'");
	
	$kata = "Tanggapan Tentang ";
	mysql_query("INSERT INTO berita ( `Perihal` , `Isi` , `Pengirim` , `WaktuKirim` , `Penerima` ,`WaktuBaca` ,`NoSurat` ,`StatusBerita` 			                                                   ,`StatusDisposisi` ) VALUES ( '$kata$Perihal', '$Tanggapanx', '$IdPengirim', now(),  '$IdPenerima', '',                                                 '$NoSurat', '2', '$ParentId' )") or die(mysql_error());
/*	
	if (GetEmail($IdPenerima) != "") {
				$to      =	GetEmail($IdPenerima);
				$subject =	'Tanggapan Surat baru ditambahkan pada SITP tentang ' . $Perihal;
				$message = 	'Tanggapan Surat tentang '.$Perihal.' dengan No. Surat : ' . $NoSurat . ' baru ditambahkan di SITP silahkan cek di alamat http://183.91.67.5/sitpbatan/';
				$headers = 	'From: admin_SITP@batan.go.id' . "\r\n" .
    						'Reply-To: sippin_group@batan.go.id' . "\r\n" .
    						'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $message, $headers);
			}
	*/		
			
			
	//	mysql_query("INSERT INTO $Tb_Diposisi ( `StatusTgp` , `Tanggapan`) 				   		VALUES ( '$StatusTgp', '$Tanggapan'")  or die(mysql_error());
			
			//mysql_query("INSERT INTO $Tb_Berita ( `Perihal` , `Isi` , `Pengirim` , `WaktuKirim` , `Penerima` ,`WaktuBaca` ,`NoSurat` ,`StatusBerita` 			                                                   ,`StatusDisposisi` ) VALUES ( '$Perihal', '$Instruksi', '$IdPengirim', now(),  '$IdPenerima', '',                                                 '$NoSurat', '2', '$ParentId' )") or die(mysql_error());
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($kotaksuratlist."&q=".$id[$i])."\">";
	 
	
	}
	

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tambah Tanggapan - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>
<table class="admintable" cellspacing="1">
  
        <form name="frmAdministrator" method="post" action="index.php?p=<?php echo enkripsi($addtanggapan."&q=".$_GET["id"])?>">

            <tr>
            <td class="key"><strong>Nomor Surat</strong></td>
              
            <td>
			<input   name="NoSurat"  type="text" class="formAll" id="NoSurat" size="100" readonly value="<?=$NoSurat?>"/>            </td>
            </tr>
			<tr>
              
            <td class="key"><strong>Perihal</strong></td>
              
            <td> 
              <input readonly name="Perihal" type="text" class="formAll" id="Perihal" size="100"  value="<?=$Perihal?>"/>
              <input readonly name="ParentId"  type="text" class="formAll" id="ParentId" size="100"  value="<?=$ParentId?>"/>
              <input readonly name="BeritaFlag"  type="text" class="formAll" id="BeritaFlag" size="100"  value="<?=$BeritaFlag?>"/>            </td>
            </tr>
			<tr>
              
            <td class="key"><strong>Tujuan</strong></td>
              
            <td>
			<input   name="Pengirim"  type="text" class="formAll" id="Pengirim" size="100" readonly value="<?=$Pengirim?>"/>           </td>
            </tr>
            <tr>
              <td class="key"><strong>Instruksi</strong></td>
              <td><textarea name="Instruksi" cols="80" rows="15" style="width: 100%"  disabled="disabled"><?php echo $Instruksi ?> </textarea></td>
            </tr>
			<tr>
              <td class="key"><strong>Tanggapan</strong></td>
              <td><textarea name="Tanggapan" cols="80" rows="15" style="width: 100%" value="<?=$Tanggapan?>"></textarea></td>
            </tr>
            <tr>
              <td width="30%" align="center" valign="top">&nbsp;</td>
              <td width="446">
              <input name="Submit" type="submit" class="button" value="Submit">
              <?php if ($BeritaFlag == "1") {
?>
<input name="BnCancel" type="button" class="button" id="BnCancel" value="Cancel" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<?php 
} else {
?>
<input name="BnCancel" type="button" class="button" id="BnCancel" value="Cancel" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<?php
}
?>                  </td>
            </tr>
      </form>
        
  
</table>
</body>
</html>
