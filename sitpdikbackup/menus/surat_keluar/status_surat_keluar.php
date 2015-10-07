<?php
checkauthentication();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Administrator List - <?=$Site_Name?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/global.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/jquery.timers.js"></script>
<script type="text/javascript" src="js/jquery.dropshadow.js"></script>
<script type="text/javascript" src="js/mbTooltip.js"></script>

<script>
  $(function(){
    $("[title]").mbTooltip({ // also $([domElement]).mbTooltip  >>  in this case only children element are involved
      opacity : .97,       //opacity
      wait:1,           //before show
      cssClass:"default",  // default = default
      timePerWord:70,      //time to show in milliseconds per word
      hasArrow:false,			// if you whant a little arrow on the corner
      hasShadow:true,
      imgPath:"images/",
      ancor:"mouse", //"parent"  you can ancor the tooltip to the mouse position or at the bottom of the element
      shadowColor:"black", //the color of the shadow
      mb_fade:300 //the time to fade-in
    });
  });
</script>
</head>

<body>
<table width="100%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="left" valign="top"><br>
      <table width="98%" align="center" cellpadding="3" cellspacing="5">
        <tr>
        	<td align="left"><p><span class="titlepage"><img src="images/messaging.png" align="middle" >STATUS SURAT KELUAR </span> </p></td>
        </tr>
        <tr>
            <td align="right" valign="top"><hr align="center" width="100%"></td>
        </tr>
        <tr>
        	<td>
				
            	<table width="100%">
                	<!--<td align="left"><a href="berita_add.php">
                    <img src="images/icons/ADD_24.GIF" style=" background:lightgray;padding:2px; -moz-border-radius:2px" title="Tambah Berita" width="24" height="24" border="0" align="middle">   Tambah Berita</a></td> -->
                    
                 </table>
      
      

        <?php
		$oList		 = "SELECT * FROM status_surat_keluar WHERE Pengirim = '".$_SESSION['MM__AdminID']."' and NoSurat = '".$NoSurat."' ";

		$SQLList	 = mysql_query($oList) or die(mysql_errno()." : ".mysql_error());
		?>      
             </td>
        </tr>
        
        <tr>
        <td>
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
              <tr align="center" valign="middle" bgcolor="#666666">
                <td rowspan="2" width="71" height="38" background="images/glossyback2.gif" class="tableheader"><strong>No.</strong></td>
           
                <td rowspan="2" width="694" background="images/glossyback2.gif" class="tableheader"><strong>Penerima</strong></td>
                <td rowspan="2" width="122" background="images/glossyback2.gif" class="tableheader"><strong>Tgl. Baca</strong></td>
                
                
                
              </tr>
              <tr align="center" valign="middle" bgcolor="#666666"> 
                  
              </tr>
              <?php
                    if (mysql_num_rows($SQLList) == 0) {
                  ?>
              <tr align="center" bgcolor="#FFFFFF">
                <td colspan="7" class="fontred"><strong>[No Data Found]</strong></td>
              </tr>
              <?php
                    } else {
                        $i	= 1+$Pg;
                        $bgcolor = "#efefef";
    
                        while($List = mysql_fetch_object($SQLList)) {
                    ?>
              <tr align="center" bgcolor="<?=$bgcolor?>">
                <td class="tablebody">
                  <?=$i?>
                .</td>
                
              
       
                <td class="tablebody">
                  <?=$List->Penerima ?>
                </td>
                <td class="tablebody">
                  <?=ViewDateTimeFormat($List->WaktuBaca , 2)?>
               </td>
               
               
                
            
                
              </tr>
              <?php
                            if ($bgcolor == "#efefef") { $bgcolor = "#dedede"; } else { $bgcolor = "#efefef"; }
                            $i++;
                        }
                    }
                    ?>
            </table>
           </td>
           </tr>
           
           </table>
        <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
