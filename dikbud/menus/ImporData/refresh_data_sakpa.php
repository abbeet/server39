<?php
	checkauthentication();
	$err = false;

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		
			$kdsatker_input = $_REQUEST['kdsatker'];
						
			if( $kdsatker_input <> '' ) 
			{

odbc_close_all();
$dsn = "Driver={Microsoft Visual FoxPro Driver}; SourceType=DBF; SourceDB=C:\\xampp\\htdocs\\dikbud\\file_dipa\\".$kdsatker_input."\\; Exclusive=No;";

		$sambung_dipa = odbc_connect( $dsn,"","");
        echo "<strong> Tersambung SAKPA Tahun ".$th." Satker ".$kdsatker_input." </strong></<br>";

			if ($_REQUEST['spmind'] == "1")
			{
				mysql_query("DELETE FROM m_spmind WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker_input."'");
				$oSpmind="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,TGSPM,NOSP2D,TGSP2D from M_SPMIND.DBF where THANG = '$th' and KDSATKER = '$kdsatker_input'";	
				$Spmind=odbc_exec($sambung_dipa,$oSpmind);
				while($row = odbc_fetch_row($Spmind)){
					$THANG		= odbc_result($Spmind,THANG);
					$KDSATKER	= odbc_result($Spmind,KDSATKER);
					$KDDEPT		= odbc_result($Spmind,KDDEPT);
					$KDUNIT		= odbc_result($Spmind,KDUNIT);
					$KDPROGRAM	= odbc_result($Spmind,KDPROGRAM);
					$KDGIAT		= odbc_result($Spmind,KDGIAT);
					$KDOUTPUT	= odbc_result($Spmind,KDOUTPUT);
					$TOTNILMAK	= odbc_result($Spmind,TOTNILMAK);
					$TOTNILMAP	= odbc_result($Spmind,TOTNILMAP);
					$NOSPM		= odbc_result($Spmind,NOSPM);
					$TGSPM		= odbc_result($Spmind,TGSPM);
					$NOSP2D		= odbc_result($Spmind,NOSP2D);
					$TGSP2D		= odbc_result($Spmind,TGSP2D);
					
//					echo '<br>tahun :'.$THANG;
//					echo '<br>satker :'.$KDSATKER;
//					echo '<br>SP2D :'.$NOSP2D;
//					echo '<br>SP2D :'.$TGSP2D;
//					$tg_spm = substr($TGSPM,6,4).'-'.substr($TGSPM,3,2).'-'.substr($TGSPM,0,2);
//					$tg_sp2d = substr($TGSP2D,6,4).'-'.substr($TGSP2D,3,2).'-'.substr($TGSP2D,0,2);

					$sql = "INSERT INTO m_spmind(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,TGSPM,NOSP2D,TGSP2D) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$TOTNILMAK', '$TOTNILMAP', '$NOSPM', '$TGSPM', '$NOSP2D', '$TGSP2D')";
					mysql_query($sql);
				}	# AND WHILE
			}		# AND CEK FILE SPMMAK
				
			if ($_REQUEST['spmmak'] == "1")
			{
								
				mysql_query("DELETE FROM m_spmmak WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker_input."'");
				$oSpmmak="select THANG,KDSATKER,KDAKUN,NILMAK,NOSPM,TGSPM,NOSP2D,TGSP2D from M_SPMMAK.DBF where THANG = '$th' and KDSATKER = '$kdsatker_input'";	
				$Spmmak=odbc_exec($sambung_dipa,$oSpmmak);
				while($row = odbc_fetch_row($Spmmak)){
					$THANG		= odbc_result($Spmmak,THANG);
					$KDSATKER	= odbc_result($Spmmak,KDSATKER);
					$KDAKUN		= odbc_result($Spmmak,KDAKUN);
					$NILMAK		= odbc_result($Spmmak,NILMAK);
					$NOSPM		= odbc_result($Spmmak,NOSPM);
					$TGSPM		= odbc_result($Spmmak,TGSPM);
					$NOSP2D		= odbc_result($Spmmak,NOSP2D);
					$TGSP2D		= odbc_result($Spmmak,TGSP2D);
					
					$sql = "INSERT INTO m_spmmak(THANG,KDSATKER,KDAKUN,NILMAK,NOSPM,TGSPM,NOSP2D,TGSP2D) VALUES ('$THANG', '$KDSATKER', '$KDAKUN', '$NILMAK', '$NOSPM', '$TGSPM', '$NOSP2D', '$TGSP2D')";
					mysql_query($sql);
				}	# AND WHILE
			}		# AND CEK FILE SPMMAK
			
				$_SESSION['errmsg'] = "Proses Refresh Data SAKPA Satker ".$kdsatker_input." berhasil"; ?>
<?php		}else{		# else pilih satker
			
				$_SESSION['errmsg'] = "Anda Belum memilih Satker"; 
			}         # AND CEK pilih satker  ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		} # endif error
	} # endif form
?>

            <style type="text/css">
<!--
.style1 {color: #990000}
-->
            </style>
            <form action="" method="post" name="form" enctype="multipart/form-data">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td width="144" class="key">Seting Tahun</td>
      <td width="311"><?php echo $th ?></td>
    </tr>
    
    <tr>
      <td class="key">Satker</td>
      <td><select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
		switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
		case '4':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		case '7':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		default:
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
	}	
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['KDSATKER'] ?>"><?php echo  $row['KDSATKER'].' '.$row['namasatker']; ?></option>
		    <?php
			} ?>
          </select></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">Data Realisasi Total</td>
      <td> &nbsp; <input type="checkbox" name="spmind" value="1" checked> <span class="style1">[ 
        File : M_SPMIND]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data Realisasi Detil</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="spmmak" value="1" checked>
        [ File : M_SPMMAK]</span> </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Proses</a></div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> </td>
    </tr>
  </table>
</form>