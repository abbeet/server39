<?php
	checkauthentication();
	$err = false;

	extract($_POST);
 	$ta = date('Y');
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
odbc_close_all();
$dsn = "Driver={Microsoft Visual FoxPro Driver}; SourceType=DBF; SourceDB=c:\\xampp\\htdocs\\siban\\file_dipa; Exclusive=No;";

$sambung_dipa = odbc_connect( $dsn,"","");
    if ( $sambung_dipa != 0 )   
    {
        echo "<strong> Tersambung DIPA </strong></<br>";
	}

	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_FILES['output']['name'] != "")
			{
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
				mysql_query("DELETE FROM d_output WHERE THANG = '".$ta."'");
				$oOutput="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,VOL from D_OUTPUT.KEU where THANG='$ta'";	
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
			}		# AND CEK FILE DIPA
			
//--------------khir upload file OUTPUT
	
			if ($_FILES['suboutput']['name'] != "")
			{
				
				$filename = $_FILES['suboutput']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["suboutput"]["tmp_name"], $filedir);
				
				mysql_query("DELETE FROM d_soutput WHERE THANG = '".$ta."'");
				$oSOutput="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,URSOUTPUT,VOLSOUT from D_SOUTPUT.KEU where THANG='$ta'";	
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
			}		# AND CEK FILE DIPA
			
//--------------khir upload file SOUTPUT

			if ($_FILES['komponen']['name'] != "")
			{
				$filename = $_FILES['komponen']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["komponen"]["tmp_name"], $filedir);
				
				mysql_query("DELETE FROM d_kmpnen WHERE THANG = '".$ta."'");
				$oKmpnen="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,URKMPNEN from D_KMPNEN.KEU where THANG='$ta'";	
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

					$sql = "INSERT INTO d_kmpnen(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM, KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, URKMPNEN) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN', '$URKMPNEN')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE DIPA
			
//--------------khir upload file KMPNEN
			
			if ($_FILES['subkomponen']['name'] != "")
			{
				$filename = $_FILES['subkomponen']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["subkomponen"]["tmp_name"], $filedir);
				
				mysql_query("DELETE FROM d_skmpnen WHERE THANG = '".$ta."'");
				$oSKmpnen="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,URSKMPNEN from D_SKMPNEN.KEU where THANG='$ta'";	
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
			}		# AND CEK FILE DIPA
			
//--------------khir upload file SKMPNEN
			
			if ($_FILES['akun']['name'] != "")
			{
				$filename = $_FILES['akun']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
				mysql_query("DELETE FROM d_akun WHERE THANG = '".$ta."'");
				$oAkun="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN from D_AKUN.KEU where THANG='$ta'";	
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
			}		# AND CEK FILE DIPA
			
//--------------khir upload file AKUN
			
			if ($_FILES['pok']['name'] != "")
			{
//				$filename = $_FILES['pok']['name'];
//				$filedir = "file_dipa/".$filename;
//				move_uploaded_file($_FILES["pok"]["tmp_name"], $filedir);
				mysql_query("DELETE FROM d_item WHERE THANG = '".$ta."'");
				$oItem="select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN,JUMLAH from D_ITEM.KEU where THANG='$ta'";	
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

					$sql = "INSERT INTO d_item(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN,JUMLAH) 
									 VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$KDSOUTPUT', '$KDKMPNEN',
									 '$KDSKMPNEN', '$KDAKUN', '$JUMLAH')";
					mysql_query($sql);
						
				}	# AND WHILE
			}		# AND CEK FILE DIPA
			
//--------------khir upload file ITEM
			
			
			
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
			<td class="key">Tahun Anggaran</td>
			
      <td><?php echo date('Y') ?></td>
		</tr>
		<tr> 
			<td class="key">Data Output</td>
			<td>
				<input type="file" name="output" size="60" />&nbsp;<span class="style1">[ File : D_OUTPUT.KEU ]</span>
			</td>
		</tr>
		<tr> 
			<td class="key">Data Sub Output</td>
			<td>
				<input type="file" name="suboutput" size="60" />&nbsp;<span class="style1">[ File : D_SOUTPUT.KEU ]</span>
			</td>
		</tr>
		<tr> 
			<td class="key">Data Komponen</td>
		  <td>
			<input type="file" name="komponen" size="60" />&nbsp;<span class="style1">[ File : D_KMPNEN.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data Sub Komponen</td>
			<td>
				<input type="file" name="subkomponen" size="60" />&nbsp;<span class="style1">[ File : D_SKMPNEN.KEU ]</span>
			</td>
		</tr>
		<tr> 
			<td class="key">Data Akun</td>
			<td>
				<input type="file" name="akun" size="60" />&nbsp;<span class="style1">[ File : D_AKUN.KEU ]</span>
			</td>
		</tr>
		<tr> 
			<td class="key">Data POK</td>
			<td>
				<input type="file" name="pok" size="60" />&nbsp;<span class="style1">[ File : D_ITEM.KEU ]</span>
			</td>
		</tr>
		<tr> 
			<td>&nbsp;</td>
			<td>
				<div class="button2-right"> 
					<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
				</div>
				<div class="button2-left"> 
					<div class="next"> <a onclick="form.submit();">Proses</a></div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
				<input name="form" type="hidden" value="1" />
			</td>
		</tr>
	</table>
</form>