<?php
checkauthentication();

	$omenu = xmenu("parent", "id = '".$p."'");
	$xmenu = mysql_fetch_array($omenu);
	$p_next = $xmenu['parent'];
	$adddisposisi = 96;
	$tanyadisposisi = 97;
	$kotaksuratlist = 27;

	$q = ekstrak_get(@$get[1]);
	$id = ekstrak_get(@$get[2]);
	$NoSurat = ekstrak_get(@$get[3]);
	$Perihal = ekstrak_get(@$get[4]);
	$BeritaFlag = ekstrak_get(@$get[5]);
	$StatusDisposisi = ekstrak_get(@$get[6]);

$xlevel = @$_SESSION['xlevel_'.$session_name];
$IdUser = @$_SESSION['xusername_'.$session_name];
$KdSatker = @$_SESSION['xunit_'.$session_name]; 


date_default_timezone_set('Asia/Jakarta');
//$Perihal			=$_GET["Perihal"];
//$NoSurat			=$_GET["NoSurat"];
$id					=$q;
//$BeritaFlag			=$_GET["BeritaFlag"];
//$ParentId	=$_GET["StatusDisposisi"] + 1;
$bError		= false;
$sMessage	= "";
$CariParent = mysql_query("SELECT * FROM disposisi WHERE NoSurat = '$NoSurat' AND IdPenerima = '".$IdUser."'") or die(mysql_error());
	if (mysql_num_rows($CariParent) == 0) {
		$ParentId = 0;
	} else {
		$Edit		= mysql_fetch_object($CariParent);
		$ParentId	= $Edit->IdDisposisi;
	}
if ($_POST["Submit"]) {
	$NoSurat		=$_POST['NoSurat'];
	$ParentId		=$_POST['ParentId'];
	$IdPengirim		=@$_SESSION['xusername_'.$session_name];
	$Instruksi		=$_POST['Instruksi'];
	$Perihal		=$_POST["Perihal"];
	$Isi 			=$_POST['Isi'];
	$BeritaFlag	 	=$_POST['BeritaFlag'];
	
	$Instruksix =trim( preg_replace( '/\s+/', ' ', $Instruksi ) ); 
	$Instruksixx =  preg_replace("/[^a-zA-Z0-9\.|,|:|_|?|!|;|%]+/", " ", $Instruksix);
	
	
	
		//if ($_GET["id"] == "") {
			// ADD NEW
		//if (@$_POST['myselect'] != "") {
		foreach ($_POST[myselect] as $IdPenerima) {
			mysql_query("INSERT INTO disposisi ( `NoSurat` , `IdPenerima` , `IdPengirim` , `Instruksi` , `ParentId` , `TglBaca`, `TglDisposisi`,`IdDeputi_Penerima`,`KdUnit_Penerima`) 				   		VALUES ( '$NoSurat', '$IdPenerima', '$IdPengirim', '$Instruksixx', '$ParentId', '', now(), '$KdSatker','$KdSatker' )") or die(mysql_error());
			
			mysql_query("INSERT INTO berita ( 
			`Perihal` , `Isi` , `Pengirim` , `WaktuKirim` , `Penerima` ,`WaktuBaca` ,`NoSurat`,`StatusBerita` ) VALUES ( 
			'$Perihal', '$Instruksixx', '$IdPengirim', now(),  '$IdPenerima', '', '$NoSurat', '2' )") or die(mysql_error());
			
			$oEditpenerima = mysql_query("SELECT * FROM xuser_pegawai WHERE username = '".$IdPenerima."'") or die(mysql_error());
			if (mysql_num_rows($oEditpenerima) == 0) {
				$bError		= true;
				$sMessage	= "Invalid Member ID Request...!!";
			} else {
				$Editpenerima	= mysql_fetch_object($oEditpenerima);
				$penerimaIdDeputi  = $Editpenerima->IdDeputi;
				$penerimalevel		= $Editpenerima->level;
			}
			
			if (($penerimalevel == "DIT") OR ($penerimalevel == "DITJEN") OR ($penerimalevel == "WAMEN"))  {
			
			$oEditpenerimaadmintu = mysql_query("SELECT * FROM xuser_pegawai WHERE IdDeputi = '".$penerimaIdDeputi."' AND username like 'admin%'") or die(mysql_error());
			if (mysql_num_rows($oEditpenerimaadmintu) == 0) {
				$bError		= true;
				$sMessage	= "Invalid Member ID Request...!!";
			} else {
				$Editpenerimaadmintu	= mysql_fetch_object($oEditpenerimaadmintu);
				$admintuusername  = $Editpenerimaadmintu->username;
			}

			
			mysql_query("INSERT INTO berita ( `Perihal` , `Isi` , `Pengirim` , `WaktuKirim` , `Penerima` ,`WaktuBaca` ,`NoSurat` ,`StatusBerita` 			                                                   ) VALUES ( '$Perihal', '$Instruksixx', '$IdPengirim', now(),  '$admintuusername', '',                                                 '$NoSurat', '3' )") or die(mysql_error());
			}
			
		$Disposisi = "Disposisi terakhir oleh " . $IdPengirim . " ke " . $IdPenerima . " pada " . date( " d F Y  H:i:s");
			if (GetEmail($IdPenerima) != "") {
				$to      =	GetEmail($IdPenerima);
				$subject =	'Disposisi Surat baru ditambahkan pada SITP tentang ' . $Perihal;
				$message = 	'Disposisi Surat tentang '.$Perihal.' dengan No. Surat : ' . $NoSurat . ' baru ditambahkan di SITP silahkan cek di alamat http://118.98.234.39/sitpdik/';
				$headers = 	'From: admin_SITP@batan.go.id' . "\r\n" .
    						'Reply-To: layanan_si@batan.go.id' . "\r\n" .
    						'X-Mailer: PHP/' . phpversion();
				//mail($to, $subject, $message, $headers);
				//mysql_query("insert into kirim_email (`to`, `subject`, `message`, `headers`) values ($to, $subject, $message, $headers)");
				mysql_query("insert into kirim_email (`to`,`subject`,`message`,`headers`) values ('$to', '$subject', '$message', '$headers')")or die(mysql_error());;
			}
			}
		
			

			if ($BeritaFlag == "1") {
							mysql_query("UPDATE berita SET 
							StatusDisposisi 	= '1',
							StatusBerita 	= '1'
							WHERE NoSurat = '".$NoSurat."' and Penerima = '".$IdUser."'") or die(mysql_error());
							
			} else {
							mysql_query("UPDATE suratmasuk SET 
							StatusDisposisi 	= '1', 
							Disposisi 	= '".$Disposisi."'
							WHERE NoSurat = '".$NoSurat."' and DicatatOleh = '".$KdSatker."'") or die(mysql_error());
			}
          
		  
		  echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=". enkripsi($tanyadisposisi."&q=".$id[$i]."&Id=".$IdBerita."&NoSurat=".$NoSurat."&Perihal=".$Perihal."&BeritaFlag=".$BeritaFlag."&StatusDisposisi=".$StatusDisposisi)."\">";
			
			exit();
		//}
		} else {
			// UPDATE
			/*	mysql_query("UPDATE berita SET 
							title 	= '".$Title."',
							text 	= '".$Isi."',
							date    = '".$TglKirim."',
							image 	= '".$image."'
							WHERE id = '".$_GET["id"]."'") or die(mysql_error());
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=update_success.php?act=update_berita\">";
				exit();*/
			
		}
	
/*} else if ($_GET["id"] != "") {
	$oEdit = mysql_query("SELECT * FROM berita WHERE id = '".$_GET["id"]."'") or die(mysql_error());

	if (mysql_num_rows($oEdit) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$Edit	= mysql_fetch_object($oEdit);
		$Title		= $Edit->title;
		$Isi		= $Edit->text;
		$TglKirim	= $Edit->date ;
		$image		= $Edit->image;
		
	}
}*/
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tambah Berita - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/jquery.comboselect.css" />
		<!--[if IE]>
		<style type="text/css">
		select.csleft, select.csright {
			width: 150px;
		}
		</style>
		<![endif]-->

<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.selso.js"></script>	
<script type="text/javascript" src="js/jquery.comboselect.js"></script>
<script type="text/javascript">
$(document).ready( function() {
$("#hidden-div").hide();
    $("#toggle-hidden-div").click( function() {
		$("#hidden-div").slideToggle('slow');
	});
	$('#myselect').comboselect({ sort: 'right', addbtn: '>>',  rembtn: '<<' });	
});
</script>
</head>

<body>

        <form name="frmdisposisiadd" method="post" action="index.php?p=<?php echo enkripsi($adddisposisi."&q=".$id[$i]."&NoSurat".$NoSurat[$i]."&Perihal".$Perihal[$i]); ?>">

          <table class="admintable">
				
            <tr>
              
            <td class="key"><strong>Nomor Surat</strong></td>
              
            <td>
			<input   name="NoSurat"  type="text" class="formAll" id="NoSurat" size="100" readonly value="<?=$NoSurat?>"/>
            </td>
            </tr>
			<tr>
             
            <td class="key"><strong><a id="toggle-hidden-div" href="#toggle-hidden-div">Klik di sini untuk Disposisi</a></strong></td>
              
            <td align="left"  id='hidden-div'> 
              <?php 
										
					echo "<select  id='myselect'  size=\"6\" name=\"myselect[]\" multiple=\"multiple\" >\n";
					//Buka table 
			switch($xlevel) {
			case 'DEV':
					//$AdminlevelName = "Administrator";
					$perintah="SELECT * FROM xuser_pegawai ";
					break;
				
			}
			switch($xlevel) {
				case 'WAMEN':
					//$AdminlevelName = "KaBatan";
					$perintah="SELECT * FROM xuser_pegawai WHERE level = 'DITJEN' or level = 'DIT' or level = 'DITJEN' or level = 'SUBSEKSI' or level = 'UPT' ORDER BY level";
					break;
				
			}
			switch($xlevel) {
				case 'DITJEN':
				//deputi
						
					$perintah="SELECT * FROM xuser_pegawai WHERE level = 'DIT' or level = 'SUBDIT' or level = 'UPT' ORDER BY level";
					
				break;
				
			}
			switch($xlevel) {
				case 'UPT':
					//$perintah="SELECT * FROM xuser_pegawai WHERE level = 'DIT' or level = 'DITJEN' or level = 'UPT' or (level = 'SEKSI' AND unit like '". substr(@$_SESSION['xunit_'.$session_name],0,5) . "%' ORDER BY level";
					$perintah="SELECT * FROM xuser_pegawai WHERE level = 'SEKSI' AND unit like '". substr(@$_SESSION['xunit_'.$session_name],0,5) . "%' ORDER BY level";
						break;
			}
			switch($xlevel) {
				case 'DIT':
					$perintah="SELECT * FROM xuser_pegawai WHERE level = 'DIT' or level = 'UPT' or (level = 'SUBDIT' AND unit like '". substr(@$_SESSION['xunit_'.$session_name],0,5) . "%') ORDER BY level";
						break;
			}
			switch($xlevel) {
				case 'ADM':
					//$AdminlevelName = "Admin TU";
					$perintah="SELECT * FROM xuser_pegawai WHERE level = 'ADM' ";
					break;
				
			}
			switch($xlevel) {
				case 'SEKSI':
					$perintah="SELECT * FROM xuser_pegawai WHERE (level = 'STAF' AND unit like '". substr(@$_SESSION['xunit_' .$session_name],0,5) . "%') or (level = 'SEKSI' AND unit like '". substr(@$_SESSION['xunit_' .$session_name],0,5) . "%') ORDER BY level DESC";
					//$perintah="SELECT * FROM xuser_pegawai WHERE level = 'STAF' ORDER BY level DESC";
					break;
			}
			switch($xlevel) {
				case 'SUBDIT':
					$perintah="SELECT * FROM xuser_pegawai WHERE (level = 'SEKSI' AND unit like '". substr(@$_SESSION['xunit_' .$session_name],0,5) . "%') or  (level = 'SUBDIT' AND unit like '". substr(@$_SESSION['xunit_' .$session_name],0,5) . "%') ORDER BY level DESC";
					//$perintah="SELECT * FROM xuser_pegawai WHERE level = 'STAF' ORDER BY level DESC";
					break;
			}
			switch($xlevel) {
				case 7:
					//$AdminlevelName = "Staf";
					$perintah="SELECT * FROM xuser_pegawai WHERE  username != '" . $IdUser . "' AND KdUnit like '". substr($_SESSION['MM__AdminKdSatker'],0,4) . "%' ORDER BY level DESC";
					break;
				
			}
							
					     
       				//Eksekusi $perintah
        			$jalankan_perintah=mysql_query($perintah) or die(mysql_error());
				 	
					while ($rows=mysql_fetch_array($jalankan_perintah)) 
      				{	
					if ($rows[username]==$IdUser) {
				//	echo "<OPTION VALUE='".$rows[username]."'selected>".GetUserName($rows[username])."</OPTION>";
					} else {
					echo "\n<OPTION VALUE='".$rows[username]."'>".GetUserName($rows[username])."</OPTION>";
					}
					}
					echo "</select>";
					echo "<br clear=\"all\" >";
				?>
              &nbsp; </td>
            </tr>
			<tr>
              
            <td class="key"><strong>Perihal</strong></td>
              
            <td> 
              <input readonly name="Perihal" type="text" class="formAll" id="Perihal" size="100"  value="<?=$Perihal?>"/>
              <input readonly name="ParentId"  type="hidden" class="formAll" id="ParentId" size="100"  value="<?=$ParentId?>"/>
              <input readonly name="BeritaFlag"  type="hidden" class="formAll" id="BeritaFlag" size="100"  value="<?=$BeritaFlag?>"/>
            </td>
            </tr>
            <tr>
              <td class="key"><strong>Instruksi</strong></td>
              <td><textarea name="Instruksi" cols="80" rows="15" style="width: 100%" value="<?=$Instruksi?>"></textarea></td>
            </tr>
            <tr>
              <td class="key">&nbsp;</td>
              <td >
              
				<input type="Submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Submit" />
				<input type="hidden" name="suratmasuk" value="1" />
				<input type="hidden" name="id" value="<?php echo $q; ?>" />
              
              <input name="Submit" type="submit" class="button" value="Submit">
              <?php if ($BeritaFlag == "1") {
?>
<input name="BnCancel" type="button" class="button" id="BnCancel" value="Cancel" onClick="Cancel('index.php?p=<?php echo enkripsi($kotaksuratlist); ?>')">
<?php 
} else {
?>
<input name="BnCancel" type="button" class="button" id="BnCancel" value="Cancel" onClick="Cancel('index.php?p=<?php echo enkripsi($p_next); ?>?')">
<?php
}
?>                
                  </td>
            </tr>
          </table>
      </form>
</body>
</html>
