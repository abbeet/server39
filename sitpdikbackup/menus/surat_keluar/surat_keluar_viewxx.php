<?php
checkauthentication();

$q = ekstrak_get(@$get[1]);
$cari=$_GET['cari'];
$newpg=$_GET['pg'];
$bError		= false;
$sMessage	= "";

	$oEdit = mysql_query("SELECT * FROM suratkeluar WHERE IdSuratKeluar = '".$q."'") or die(mysql_error());

	if (mysql_num_rows($oEdit) == 0) {
		$bError		= true;
		$sMessage	= "Invalid Member ID Request...!!";
	} else {
		$Edit	= mysql_fetch_object($oEdit);
							$IdSifat 			= $Edit->IdSifat;
							$IdKategori			= $Edit->IdKategori;
							$IdKlasifikasi		= $Edit->IdKlasifikasi; 
							$TglTerima			= $Edit->TglTerima;
							$NoSurat			= $Edit->NoSurat; 
							$TglSurat			= $Edit->TglSurat; 
							$AsalSurat			= $Edit->AsalSurat; 
							$Perihal			= $Edit->Perihal; 
							$Lampiran			= $Edit->Lampiran; 
							$TujuanSurat		= $Edit->TujuanSurat;
							$Retensi			= $Edit->Retensi; 
							$LokasiFile			= $Edit->LokasiFile; 
							$TujuanSurat		= $Edit->TujuanSurat; 
							$Keterangan			= $Edit->Keterangan;
	}				

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>User Edit - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="calendar/skins/aqua/theme.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="js/global.js"></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<script language="javascript">
  function openTree(id){
  	// ambil semua tag <ul> yang mengandung attribut parent = id dari link yang dipilih
  	var elm = $('ul[@parent='+id+']'); 
  	if(elm != undefined){ // jika element ditemukan
  	  if(elm.css('display') == 'none'){ // jika element dalam keadaan tidak ditampilkan
  	    elm.show(); // tampilkan element 	  	
  	    $('#img'+id).attr('src','images/icons/folderopen.jpg'); // ubah gambar menjadi gambar folder sedang terbuka
  	  }else{
  	  	elm.hide(); // sembunyikan element
  	    $('#img'+id).attr('src','images/icons/folderclose2.jpg'); // ubah gambar menjadi gambar folder sedang tertutup
  	  }
	}
  }
  
  var halamanbaru;
function poptastic(url)
{
	halamanbaru=window.open(url,'Surat','height=600,width=800');
	if (window.focus) {halamanbaru.focus()}
}
 </script> 


</head>

<body>
<table width="100%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="left" valign="top"><br>
    
        <form name="frmAdministrator" method="post" action="surat_keluar_edit.php?id=<?=$_GET["id"]?>">
          <table width="65%" border="0" align="center" cellpadding="3" cellspacing="1" class="datatable">
            <?php
				  if ($bError) {
				?>
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td align="left" valign="top" class="errorstatus"><img src="images/icons/error.gif" alt="" width="16" height="16" border="0" align="absmiddle" hspace="3" vspace="3"><strong>Error Message(s) :</strong><br />
                  <br />
                  <?=$sMessage?>
              </td>
            </tr>
            
            <?php
				  }
				?>
            <tr>
        		<td background="images/glossyback2.gif" align="center" colspan="2"><p><span class="titlepage">:: 
                Lihat Surat Keluar ::</span> </p></td>
        	</tr>
            <tr>
            <td colspan="2">
             <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
               
<?php if ($NoSurat != "") {
?>
                
<tr> 
                  <td colspan="3" align="left" valign="top">
                    <div id="TabbedPanels1" class="TabbedPanels">
                      <ul class="TabbedPanelsTabGroup">
                        <li class="TabbedPanelsTab" tabindex="0">Info Surat</li>
						 <li class="TabbedPanelsTab" tabindex="0">Status Surat Keluar</li>
                      </ul>
                      <div class="TabbedPanelsContentGroup">
                        <div class="TabbedPanelsContent">
                        <?php
                        include("info_surat_keluar.php");
                        ?>
						</div>
						<div class="TabbedPanelsContent">
                        <?php
                        include("status_surat_keluar.php");
                        ?>
                        </div>
                      </div>
                  </div></td>
                </tr>

                
  <?php
}
?>              
				
                <tr> 
                  <td colspan="4" align="left" valign="top"><hr align="center" width="100%"></td>
                </tr>
                <tr> 
                 <td width="25%" align="center" valign="top">&nbsp;</td>
                  <td colspan="1">

<input name="Back" type="button" class="button" id="Back" value="Back" onClick="location.href='surat_keluar_cari_list.php?pg=<?=$newpg?>&cari=<?=$cari?>'">
<!--
<input name="Cetak" type="button" class="button" id="Cetak" value="Cetak" onClick="javascript:poptastic('lbrdisposisi.php?id=<?=$Edit->IdSuratKeluar?>');">
-->
                </td>
                </tr>
              </table>
            </td>
            </tr>
          </table>
                  
      	</form>
    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
