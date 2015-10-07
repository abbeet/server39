<?php
	checkauthentication();
	$err = false;

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];
	
odbc_close_all();
$dsn = "Driver={Microsoft Visual FoxPro Driver}; SourceType=DBF; SourceDB=c:\\xampp\\htdocs\\sipristek\\file_dipa; Exclusive=No;";

$sambung_dipa = odbc_connect( $dsn,"","");
    if ( $sambung_dipa != 0 )   
    {
        echo "<strong> Tersambung TABEL REFERENSI </strong></<br>";
	}

	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_REQUEST['dept'] == "1")
			{
				
				mysql_query("DELETE FROM t_dept ");
				$oDept="select KDDEPT,NMDEPT from T_DEPT.KEU where KDDEPT='$kddept' ";	
				$Dept=odbc_exec($sambung_dipa,$oDept);
				while($row = odbc_fetch_row($Dept)){
					$KDDEPT		=odbc_result($Dept,KDDEPT);
					$NMDEPT		=odbc_result($Dept,NMDEPT);
					
					$sql = "INSERT INTO t_dept(KDDEPT,NMDEPT) VALUES ('$KDDEPT', '$NMDEPT')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE DEPT
				
			if ($_REQUEST['satker'] == "1")
			{
								
				mysql_query("DELETE FROM t_satker");
				$oSatker="select KDDEPT,KDUNIT,KDSATKER,NMSATKER from T_SATKER.KEU WHERE KDDEPT='$kddept'";	
				$Satker	=odbc_exec($sambung_dipa,$oSatker);
				while($row = odbc_fetch_row($Satker)){
					$KDDEPT		=odbc_result($Satker,KDDEPT);
					$KDUNIT		=odbc_result($Satker,KDUNIT);
					$KDSATKER	=odbc_result($Satker,KDSATKER);
					$NMSATKER	=odbc_result($Satker,NMSATKER);
					
					$sql = "INSERT INTO t_satker(KDDEPT,KDSATKER,NMSATKER,KDUNIT) VALUES ('$KDDEPT', '$KDSATKER', '$NMSATKER', '$KDUNIT')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE SATKER
			
			if ($_REQUEST['giat'] == "1")
			{
								
				mysql_query("DELETE FROM t_giat");
				$oGiat="select KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,NMGIAT from T_GIAT.KEU WHERE KDDEPT='$kddept' ";	
				$Giat	=odbc_exec($sambung_dipa,$oGiat);
				while($row = odbc_fetch_row($Giat)){
					$KDDEPT		=odbc_result($Giat,KDDEPT);
					$KDUNIT		=odbc_result($Giat,KDUNIT);
					$KDPROGRAM	=odbc_result($Giat,KDPROGRAM);
					$KDGIAT		=odbc_result($Giat,KDGIAT);
					$NMGIAT		=odbc_result($Giat,NMGIAT);
					
					$sql = "INSERT INTO t_giat(KDDEPT,KDUNIT,KDPROGRAM,KdGiat,NmGiat) VALUES ('$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$NMGIAT')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE GIAT

			if ($_REQUEST['output'] == "1")
			{
								
				mysql_query("DELETE FROM t_output");
				$oOutput="select KDGIAT,KDOUTPUT,NMOUTPUT,SAT from T_OUTPUT.KEU where left(KDOUTPUT,1)='0' and right(KDOUTPUT,1)<>'' ";	
				$Output	=odbc_exec($sambung_dipa,$oOutput);
				while($row = odbc_fetch_row($Output)){
					$KDGIAT		=odbc_result($Output,KDGIAT);
					$KDOUTPUT	=odbc_result($Output,KDOUTPUT);
					$NMOUTPUT	=odbc_result($Output,NMOUTPUT);
					$SAT		=odbc_result($Output,SAT);
					
					$sql = "INSERT INTO t_output(KDGIAT,KDOUTPUT,NMOUTPUT,SAT) VALUES ('$KDGIAT', '$KDOUTPUT', '$NMOUTPUT', '$SAT')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE OUTPUT
			
			if ($_REQUEST['akun'] == "1")
			{
								
				mysql_query("DELETE FROM t_akun");
				$oAkun="select KDAKUN,NMAKUN from T_AKUN.KEU where left(KDAKUN,1)='5'";	
				$Akun	=odbc_exec($sambung_dipa,$oAkun);
				while($row = odbc_fetch_row($Akun)){
					$KDAKUN		=odbc_result($Akun,KDAKUN);
					$NMAKUN		=odbc_result($Akun,NMAKUN);
					
					$sql = "INSERT INTO t_akun(KDAKUN,NMAKUN) VALUES ('$KDAKUN', '$NMAKUN')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE AKUN

			$_SESSION['errmsg'] = "Proses Import data berhasil"; ?>

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
      <td width="120" class="key">Tabel Departemenl</td>
      <td width="335"> &nbsp; <input type="checkbox" name="dept" value="1" checked>
        <span class="style1">[ File : T_DEPT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Tabel Satker</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="satker" value="1" checked>
        [ File : T_SATKER.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Tabel Kegiatan</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="giat" value="1" checked>
        [ File : T_GIAT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Tabel Output</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="output" value="1" checked>
        [ File : T_OUTPUT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">Tabel Akun</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="akun" value="1" checked>
        [ File : T_AKUN.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
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