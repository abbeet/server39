<?php
	checkauthentication();
	$err = false;

	extract($_POST);
 	$ta = date('Y');
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_FILES['output']['name'] != "")
			{
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE OUTPUT
			
			if ($_FILES['suboutput']['name'] != "")
			{
				
				$filename = $_FILES['suboutput']['name'];
				$filedir = "file_dipa/".$filename.".dbf";
				move_uploaded_file($_FILES["suboutput"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SUBOUTPUT
			
			if ($_FILES['komponen']['name'] != "")
			{
				$filename = $_FILES['komponen']['name'];
				$filedir = "file_dipa/".$filename.".dbf";
				move_uploaded_file($_FILES["komponen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE KOMPONEN
						
			if ($_FILES['subkomponen']['name'] != "")
			{
				$filename = $_FILES['subkomponen']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["subkomponen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SUBKOMPONEN
						
			if ($_FILES['akun']['name'] != "")
			{
				$filename = $_FILES['akun']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE AKUN
						
			if ($_FILES['pok']['name'] != "")
			{
				$filename = $_FILES['pok']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["pok"]["tmp_name"], $filedir);

			}		# AND CEK FILE POK
						
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