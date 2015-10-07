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
				$oData="select KDSATKER from T_PEGAWAI.DBF WHERE KDSATKER = '$kdsatker_input'";	
				$Data=odbc_exec($sambung_dipa,$oData);
				$row = odbc_fetch_row($Data);
				$kdsatker_data	=odbc_result($Data,KDSATKER);
	}	# AND CEK KONEKSI

			if ($_REQUEST['gpp'] == "1")
			{
				
				$oGPP="select KDSATKER,REKENING,NIP from T_PEGAWAI.DBF WHERE KDSATKER = '$kdsatker_data' ";	
				$GPP=odbc_exec($sambung_dipa,$oGPP);
				while($row = odbc_fetch_row($GPP)){
					$REKENING   =odbc_result($GPP,REKENING);
					$KDSATKER	=odbc_result($GPP,KDSATKER);
					$NIP		=odbc_result($GPP,NIP);
					
					$sql = "UPDATE mst_tk SET norec = '$REKENING' WHERE tahun = '$ta' AND bulan = '$kdbulan_input' AND kdsatker = '$KDSATKER' AND nip = '$NIP'";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE GAJI
				
//-------			
			}		# AND CEK SATKER
//----			

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
									
					for ($i = 1; $i <= 13; $i++)
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
      <td> &nbsp; <input type="checkbox" name="gpp" value="1" checked> 
      <span class="style1">[ 
        File : T_PEGAWAI]</span> </td>
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