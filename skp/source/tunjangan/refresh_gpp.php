<?php
	checkauthentication();
	$err = false;
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$ta = $_SESSION['xth'];
	$kdbulan = date('m');
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		    $kdbulan_input = $_REQUEST['kdbulan'];
			if ( $kdbulan_input <= 9 )    $kdbulan_input = '0'.$kdbulan_input ;
			$kdsatker_input = $_REQUEST['kdsatker'];
			if( $kdsatker_input <> '' ) {

odbc_close_all();
$dsn = "Driver={Microsoft Visual FoxPro Driver}; SourceType=DBF; SourceDB=c:\\xampp\\htdocs\\sikap\\file_gpp\\".$kdsatker_input."; Exclusive=No;";

$sambung_dipa = odbc_connect( $dsn,"","");
    if ( $sambung_dipa != 0 )   
    {
        echo "<strong> Tersambung GPP </strong></<br>";
				$oData="select BULAN,TAHUN,KDSATKER from T_GAJI.DBF";	
				$Data=odbc_exec($sambung_dipa,$oData);
				$row = odbc_fetch_row($Data);
				$tahun		=odbc_result($Data,TAHUN);
				$bulan		=odbc_result($Data,BULAN);
				$kdsatker_data	=odbc_result($Data,KDSATKER);
	}	# AND CEK KONEKSI

			if ($_REQUEST['gpp'] == "1")
			{
				
				mysql_query("DELETE FROM t_gaji WHERE TAHUN = '".$ta."' AND KDSATKER = '".$kdsatker_input."' AND BULAN = '".$kdbulan_input."'");
				$oGPP="select NOGAJI, TGLGAJI, BULAN,TAHUN,KDSATKER,NIP,KDPEG,KDDUDUK,KDKAWIN,KDGAPOK,KDJAB,JABLAIN,GAPOK, TISTRI, TANAK, TUMUM, TSTRUKTUR, TFUNGSI, TLAIN, TBERAS, BULAT, TPAJAK,IWP from T_GAJI.DBF where TAHUN = '$ta' and KDSATKER = '$kdsatker_input' and BULAN = '$kdbulan_input'";	
				$GPP=odbc_exec($sambung_dipa,$oGPP);
				while($row = odbc_fetch_row($GPP)){
					$NOGAJI		=odbc_result($GPP,NOGAJI);
					$TGLGAJI	=odbc_result($GPP,TGLGAJI);
					$TAHUN		=odbc_result($GPP,TAHUN);
					$BULAN		=odbc_result($GPP,BULAN);
					$KDSATKER	=odbc_result($GPP,KDSATKER);
					$NIP		=odbc_result($GPP,NIP);
					$KDPEG		=odbc_result($GPP,KDPEG);
					$KDDUDUK	=odbc_result($GPP,KDDUDUK);
					$KDKAWIN	=odbc_result($GPP,KDKAWIN);
					$KDGAPOK	=odbc_result($GPP,KDGAPOK);
					$KDJAB		=odbc_result($GPP,KDJAB);
					$JABLAIN	=odbc_result($GPP,JABLAIN);
					$GAPOK		=odbc_result($GPP,GAPOK);
					$TISTRI		=odbc_result($GPP,TISTRI);
					$TANAK		=odbc_result($GPP,TANAK);
					$TUMUM		=odbc_result($GPP,TUMUM);
					$TSTRUKTUR	=odbc_result($GPP,TSTRUKTUR);
					$TFUNGSI	=odbc_result($GPP,TFUNGSI);
					$TLAIN		=odbc_result($GPP,TLAIN);
					$TBERAS		=odbc_result($GPP,TBERAS);
					$BULAT		=odbc_result($GPP,BULAT);
					$TPAJAK		=odbc_result($GPP,TPAJAK);
					$IWP        =odbc_result($GPP,IWP);
					
					$sql = "INSERT INTO t_gaji(NoGaji,TglGaji, Bulan, Tahun, KdSatker, Nip, KdPeg, KdDuduk, KdKawin, KdGapok, KdJab, JabLain, Gapok, TIstri, TAnak, TUmum, TStruktur, TFungsi, TLain, TBeras, Bulat, TPajak,IWP) VALUES ('$NOGAJI','$TGLGAJI','$BULAN', '$TAHUN', '$KDSATKER', '$NIP', '$KDPEG', '$KDDUDUK', '$KDKAWIN', '$KDGAPOK', '$KDJAB', '$JABLAIN', '$GAPOK', '$TISTRI', '$TANAK', '$TUMUM', '$TSTRUKTUR', '$TFUNGSI', '$TLAIN', '$TBERAS', '$BULAT', '$TPAJAK', '$IWP')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE GAJI
				
			$_SESSION['errmsg'] = "Proses Refresh Data GAJI Satker ".$kdsatker_input." berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
			
			}		# AND CEK SATKER
			
			$_SESSION['errmsg'] = "Anda Belum memilih Satker"; ?>

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
      <td width="335"><?php echo $ta ?></td>
    </tr>
    <tr>
      <td class="key">Bulan</td>
      <td>		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 12; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
</td>
    </tr>
    <tr>
      <td class="key">Satker</td>
      <td><select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
	switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker group bu kdsatker order by kdsatker");
			break;
		case '7':
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker WHERE kdsatker = '$xusername' order by kdsatker");
			break;
		default:
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from t_satker order by kdsatker");
			break;
	}
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['kdsatker'].' '.$row['namasatker']; ?></option>
		    <?php
			} ?>
          </select></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">Data GPP </td>
      <td> &nbsp; <input type="checkbox" name="gpp" value="1" checked> <span class="style1">[ 
        File : T_GAJI]</span> </td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>&kdbulan=<?php echo $kdbulan_input ?>&kdsatker=<?php echo $kdsatker_input ?>')">Kembali</a></div>
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