<?php
	checkauthentication();
	$err = false;
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	$xlevel = $_SESSION['xlevel'];
	$ta_input = $_SESSION['xth'];
	$file_1 = $ta_input.'_D_OUTPUT.KEU';
	$file_2 = $ta_input.'_D_SOUTPUT.KEU';
	$file_3 = $ta_input.'_D_KMPNEN.KEU';
	$file_4 = $ta_input.'_D_SKMPNEN.KEU';
	$file_5 = $ta_input.'_D_AKUN.KEU';
	$file_6 = $ta_input.'_D_ITEM.KEU';
	$file_7 = $ta_input.'_D_TRKTRM.KEU';
	extract($_POST);
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
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
    if ( $sambung_dipa != 0 )   
    {
        echo "<strong> Tersambung RKAKL </strong></<br>";
				$oData="select THANG,KDSATKER from $file_1 ";	
				$Data=odbc_exec($sambung_dipa,$oData);
				$row = odbc_fetch_row($Data);
				$ta		=odbc_result($Data,THANG);
				$kdsatker_data	=odbc_result($Data,KDSATKER);

	}	# AND CEK KONEKSI

			if ($_REQUEST['output'] == "1")
			{
				
				mysql_query("DELETE FROM d_output WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."' ");
				$oOutput="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,VOL from $file_1 where THANG='$ta_input' ";	
				$Output=odbc_exec($sambung_dipa,$oOutput);
				while($row = odbc_fetch_row($Output)){
					$THANG		=odbc_result($Output,THANG);
					$KDSATKER	=odbc_result($Output,KDSATKER);
					$KDDEPT		=odbc_result($Output,KDDEPT);
					$KDUNIT		=odbc_result($Output,KDUNIT);
					$KDPROGRAM	=odbc_result($Output,KDPROGRAM);
					$KDGIAT		=odbc_result($Output,KDGIAT);
					$KDOUTPUT	=odbc_result($Output,KDOUTPUT);
					$VOL		=odbc_result($Output,VOL);

					$sql = "INSERT INTO d_output(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,VOL) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$VOL')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE OUTPUT
				
			if ($_REQUEST['soutput'] == "1")
			{
								
				mysql_query("DELETE FROM d_soutput WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."' ");
				$oSOutput="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,URSOUTPUT,VOLSOUT from $file_2 where THANG='$ta_input' ";	
				$SOutput=odbc_exec($sambung_dipa,$oSOutput);
				while($row = odbc_fetch_row($SOutput)){
					$THANG		=odbc_result($SOutput,THANG);
					$KDSATKER	=odbc_result($SOutput,KDSATKER);
					$KDDEPT		=odbc_result($SOutput,KDDEPT);
					$KDUNIT		=odbc_result($SOutput,KDUNIT);
					$KDPROGRAM	=odbc_result($SOutput,KDPROGRAM);
					$KDGIAT		=odbc_result($SOutput,KDGIAT);
					$KDOUTPUT	=odbc_result($SOutput,KDOUTPUT);
					$KDSOUTPUT	=odbc_result($SOutput,KDSOUTPUT);
					$URSOUTPUT	=odbc_result($SOutput,URSOUTPUT);
					$VOLSOUT	=odbc_result($SOutput,VOLSOUT);

					$sql = "INSERT INTO d_soutput(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, URSOUTPUT, VOLSOUT) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$URSOUTPUT', '$VOLSOUT')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE SOUTPUT
			
			if ($_REQUEST['kmpnen'] == "1")
			{
				mysql_query("DELETE FROM d_kmpnen WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."'");
				$oKmpnen="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,URKMPNEN,KDSBIAYA from $file_3 where THANG='$ta_input' ";	
				$Kmpnen=odbc_exec($sambung_dipa,$oKmpnen);
				while($row = odbc_fetch_row($Kmpnen)){
					$THANG		=odbc_result($Kmpnen,THANG);
					$KDSATKER	=odbc_result($Kmpnen,KDSATKER);
					$KDDEPT		=odbc_result($Kmpnen,KDDEPT);
					$KDUNIT		=odbc_result($Kmpnen,KDUNIT);
					$KDPROGRAM	=odbc_result($Kmpnen,KDPROGRAM);
					$KDGIAT		=odbc_result($Kmpnen,KDGIAT);
					$KDOUTPUT	=odbc_result($Kmpnen,KDOUTPUT);
					$KDSOUTPUT	=odbc_result($Kmpnen,KDSOUTPUT);
					$KDKMPNEN	=odbc_result($Kmpnen,KDKMPNEN);
					$URKMPNEN	=odbc_result($Kmpnen,URKMPNEN);
					$KDSBIAYA	=odbc_result($Kmpnen,KDSBIAYA);
					
					$sql = "INSERT INTO d_kmpnen(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, URKMPNEN, KDSBIAYA) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$URKMPNEN', '$KDSBIAYA')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE KMPNEN
	
			if ($_REQUEST['skmpnen'] == "1")
			{
				mysql_query("DELETE FROM d_skmpnen WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."'");
				$oSKmpnen="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,URSKMPNEN from $file_4 where THANG='$ta_input' ";	
				$SKmpnen=odbc_exec($sambung_dipa,$oSKmpnen);
				while($row = odbc_fetch_row($SKmpnen)){
					$THANG		=odbc_result($SKmpnen,THANG);
					$KDSATKER	=odbc_result($SKmpnen,KDSATKER);
					$KDDEPT		=odbc_result($SKmpnen,KDDEPT);
					$KDUNIT		=odbc_result($SKmpnen,KDUNIT);
					$KDPROGRAM	=odbc_result($SKmpnen,KDPROGRAM);
					$KDGIAT		=odbc_result($SKmpnen,KDGIAT);
					$KDOUTPUT	=odbc_result($SKmpnen,KDOUTPUT);
					$KDSOUTPUT	=odbc_result($SKmpnen,KDSOUTPUT);
					$KDKMPNEN	=odbc_result($SKmpnen,KDKMPNEN);
					$KDSKMPNEN	=odbc_result($SKmpnen,KDSKMPNEN);
					$URSKMPNEN	=odbc_result($SKmpnen,URSKMPNEN);

					$sql = "INSERT INTO d_skmpnen(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, URSKMPNEN) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$KDSKMPNEN', '$URSKMPNEN')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE KMPNEN

			if ($_REQUEST['dipa'] == "1")
			{
				mysql_query("DELETE FROM d_akun WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."'");
				$oAkun="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN from $file_5 where THANG='$ta_input' ";	
				$Akun=odbc_exec($sambung_dipa,$oAkun);
				while($row = odbc_fetch_row($Akun)){
					$THANG		=odbc_result($Akun,THANG);
					$KDSATKER	=odbc_result($Akun,KDSATKER);
					$KDDEPT		=odbc_result($Akun,KDDEPT);
					$KDUNIT		=odbc_result($Akun,KDUNIT);
					$KDPROGRAM	=odbc_result($Akun,KDPROGRAM);
					$KDGIAT		=odbc_result($Akun,KDGIAT);
					$KDOUTPUT	=odbc_result($Akun,KDOUTPUT);
					$KDSOUTPUT	=odbc_result($Akun,KDSOUTPUT);
					$KDKMPNEN	=odbc_result($Akun,KDKMPNEN);
					$KDSKMPNEN	=odbc_result($Akun,KDSKMPNEN);
					$KDAKUN		=odbc_result($Akun,KDAKUN);

					$sql = "INSERT INTO d_akun(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN, KDAKUN) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$KDSKMPNEN', '$KDAKUN')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE SKMPNEN

			if ($_REQUEST['pok'] == "1")
			{
				mysql_query("DELETE FROM d_item WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."'");
				$oItem="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN,JUMLAH,JANUARI,PEBRUARI,MARET,
							APRIL,MEI,JUNI,JULI,AGUSTUS,SEPTEMBER,OKTOBER,NOPEMBER,DESEMBER,HEADER1,HEADER2,KDHEADER,NOITEM,NMITEM,VOLKEG,SATKEG,HARGASAT, KDBLOKIR, RPHBLOKIR
							 from $file_6 where THANG='$ta_input'";	
				$Item=odbc_exec($sambung_dipa,$oItem);
				while($row = odbc_fetch_row($Item)){
					$THANG		=odbc_result($Item,THANG);
					$KDSATKER	=odbc_result($Item,KDSATKER);
					$KDDEPT		=odbc_result($Item,KDDEPT);
					$KDUNIT		=odbc_result($Item,KDUNIT);
					$KDPROGRAM	=odbc_result($Item,KDPROGRAM);
					$KDGIAT		=odbc_result($Item,KDGIAT);
					$KDOUTPUT	=odbc_result($Item,KDOUTPUT);
					$KDSOUTPUT	=odbc_result($Item,KDSOUTPUT);
					$KDKMPNEN	=odbc_result($Item,KDKMPNEN);
					$KDSKMPNEN	=odbc_result($Item,KDSKMPNEN);
					$KDAKUN		=odbc_result($Item,KDAKUN);
					$JUMLAH		=odbc_result($Item,JUMLAH);
					$JANUARI	=odbc_result($Item,JANUARI);
					$PEBRUARI	=odbc_result($Item,PEBRUARI);
					$MARET		=odbc_result($Item,MARET);
					$APRIL		=odbc_result($Item,APRIL);
					$MEI		=odbc_result($Item,MEI);
					$JUNI		=odbc_result($Item,JUNI);
					$JULI		=odbc_result($Item,JULI);
					$AGUSTUS	=odbc_result($Item,AGUSTUS);
					$SEPTEMBER	=odbc_result($Item,SEPTEMBER);
					$OKTOBER	=odbc_result($Item,OKTOBER);
					$NOPEMBER	=odbc_result($Item,NOPEMBER);
					$DESEMBER	=odbc_result($Item,DESEMBER);
					$HEADER1	=odbc_result($Item,HEADER1);
					$HEADER2	=odbc_result($Item,HEADER2);
					$KDHEADER	=odbc_result($Item,KDHEADER);
					$NOITEM		=odbc_result($Item,NOITEM);
					$NMITEM		=addslashes(odbc_result($Item,NMITEM));
					$VOLKEG		=odbc_result($Item,VOLKEG);
					$SATKEG		=addslashes(odbc_result($Item,SATKEG));
					$HARGASAT	=odbc_result($Item,HARGASAT);
					$KDBLOKIR	=odbc_result($Item,KDBLOKIR);
					$RPHBLOKIR	=odbc_result($Item,RPHBLOKIR);
					$sql = "INSERT INTO d_item(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN,JUMLAH,JANUARI,PEBRUARI,MARET,
												APRIL,MEI,JUNI,JULI,AGUSTUS,SEPTEMBER,OKTOBER,NOPEMBER,DESEMBER,HEADER1,HEADER2,KDHEADER,NOITEM,NMITEM,VOLKEG,SATKEG,HARGASAT,
												KDBLOKIR, RPHBLOKIR) 
									 VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN',
									 '$KDSKMPNEN', '$KDAKUN', '$JUMLAH', '$JANUARI', '$PEBRUARI', '$MARET','$APRIL', '$MEI', '$JUNI', '$JULI', '$AGUSTUS' , '$SEPTEMBER' ,
									 '$OKTOBER' ,'$NOPEMBER', '$DESEMBER', '$HEADER1', '$HEADER2', '$KDHEADER', '$NOITEM', '$NMITEM', '$VOLKEG', '$SATKEG', '$HARGASAT' ,
									 '$KDBLOKIR' , '$RPHBLOKIR' )";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE D_ITEM

	if ($_REQUEST['trktrm'] == "1")
			{
				
				mysql_query("DELETE FROM d_trktrm WHERE THANG = '".$ta_input."' AND KDSATKER = '".$kdsatker_input."'");
				$oTrkTrn="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,RPHPAGU,KDTRKTRM,JNSBELANJA,JML01,JML02,JML03,JML04,JML05,JML06,JML07,JML08,JML09,JML10,JML11,JML12
							 from $file_7 where THANG='$ta_input'";	
				$TrkTrn=odbc_exec($sambung_dipa,$oTrkTrn);
				while($row = odbc_fetch_row($TrkTrn)){
					$THANG		= odbc_result($TrkTrn,THANG);
					$KDSATKER	= odbc_result($TrkTrn,KDSATKER);
					$KDDEPT		=odbc_result($TrkTrn,KDDEPT);
					$KDUNIT		=odbc_result($TrkTrn,KDUNIT);
					$KDPROGRAM	=odbc_result($TrkTrn,KDPROGRAM);
					$KDGIAT		=odbc_result($TrkTrn,KDGIAT);
					$RPHPAGU	=odbc_result($TrkTrn,RPHPAGU);
					$KDTRKTRM	=odbc_result($TrkTrn,KDTRKTRM);
					$JNSBELANJA	=odbc_result($TrkTrn,JNSBELANJA);
					$JML01		=odbc_result($TrkTrn,JML01);
					$JML02		=odbc_result($TrkTrn,JML02);
					$JML03		=odbc_result($TrkTrn,JML03);
					$JML04		=odbc_result($TrkTrn,JML04);
					$JML05		=odbc_result($TrkTrn,JML05);
					$JML06		=odbc_result($TrkTrn,JML06);
					$JML07		=odbc_result($TrkTrn,JML07);
					$JML08		=odbc_result($TrkTrn,JML08);
					$JML09		=odbc_result($TrkTrn,JML09);
					$JML10		=odbc_result($TrkTrn,JML10);
					$JML11		=odbc_result($TrkTrn,JML11);
					$JML12		=odbc_result($TrkTrn,JML12);
					
					$sql = "INSERT INTO d_trktrm(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,RPHPAGU,KDTRKTRM,JNSBELANJA,JML01,JML02,JML03,JML04,JML05,JML06,JML07,JML08,JML09,JML10,JML11,JML12) 
									 VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$RPHPAGU', '$KDTRKTRM', '$JNSBELANJA',
									 '$JML01', '$JML02', '$JML03', '$JML04', '$JML05', '$JML06', '$JML07', '$JML08', '$JML09', '$JML10', '$JML11', '$JML12' )";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE TRKTRM		

			$_SESSION['errmsg'] = "Proses Import data berhasil"; ?>
<?php		}else{		# else pilih satker
			
				$_SESSION['errmsg'] = "Anda Belum memilih Satker"; 
			}         # AND CEK pilih satker  ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
						
		}
	} 
?>

            <style type="text/css">
<!--
.style1 {color: #990000}
-->
            </style>
            <form action="" method="post" name="form" enctype="multipart/form-data">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td width="120" class="key">Tahun Anggaran</td>
      <td width="335"><strong><?php echo $ta_input ?></strong></td>
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
		case '3':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;
		case '4':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		case '6':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;
		case '7':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		default:
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
	}
			//$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
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
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">Data Output</td>
      <td> &nbsp; <input type="checkbox" name="output" value="1" checked> <span class="style1">[ 
        File : D_OUTPUT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data Sub Output</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="soutput" value="1" checked>
        [ File : D_SOUTPUT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data Komponen</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="kmpnen" value="1" checked>
        [ File : D_KMPNEN.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data Sub Komponen</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="skmpnen" value="1" checked>
        [ File : D_SKMPNEN.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data DIPA</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="dipa" value="1" checked>
        [ File : D_AKUN.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data POK</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="pok" value="1" checked>
        [ File : D_ITEM.KEU]</span> </td>
    </tr>
	<tr> 
      <td class="key">Data Rencana Penarikan</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="trktrm" value="1" checked>
        [ File : D_TRKTRM.KEU]</span> </td>
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