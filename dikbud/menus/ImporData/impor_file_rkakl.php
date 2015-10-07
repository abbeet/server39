<?php
	checkauthentication();
	$err = false;

	extract($_POST);
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		
			$kdsatker = $_REQUEST['kdsatker'];
			if( $kdsatker <> '' ) {

			if ($_FILES['output']['name'] != "")
			{
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE OUTPUT
			
			if ($_FILES['suboutput']['name'] != "")
			{
				
				$filename = $_FILES['suboutput']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["suboutput"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SUBOUTPUT
			
			if ($_FILES['komponen']['name'] != "")
			{
				$filename = $_FILES['komponen']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["komponen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE KOMPONEN
						
			if ($_FILES['subkomponen']['name'] != "")
			{
				$filename = $_FILES['subkomponen']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["subkomponen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SUBKOMPONEN
						
			if ($_FILES['akun']['name'] != "")
			{
				$filename = $_FILES['akun']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE AKUN
						
			if ($_FILES['pok']['name'] != "")
			{
				$filename = $_FILES['pok']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["pok"]["tmp_name"], $filedir);

			}		# AND CEK FILE POK
	
			if ($_FILES['tarik']['name'] != "")
			{
				$filename = $_FILES['tarik']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$th.'_'.$filename;
				move_uploaded_file($_FILES["tarik"]["tmp_name"], $filedir);

			}		# AND CEK FILE POK

			$_SESSION['errmsg'] = "Proses Import data berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
			
			}	 # AND CEK KDSATKER
			
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
			<td class="key">Tahun Anggaran</td>
			
      <td><?php echo $th ?></td>
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
		  <td><strong>Lokasi file pada folder //RKAKL/DB</strong></td>
	  </tr>
		<tr> 
			<td class="key">Data Output</td>
			<td>
				<input type="file" name="output" size="60" />&nbsp;<span class="style1">[ File : D_OUTPUT.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data Sub Output</td>
			<td>
				<input type="file" name="suboutput" size="60" />&nbsp;<span class="style1">[ File : D_SOUTPUT.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data Komponen</td>
		  <td>
			<input type="file" name="komponen" size="60" />&nbsp;<span class="style1">[ File : D_KMPNEN.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data Sub Komponen</td>
			<td>
				<input type="file" name="subkomponen" size="60" />&nbsp;<span class="style1">[ File : D_SKMPNEN.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data Akun</td>
			<td>
				<input type="file" name="akun" size="60" />&nbsp;<span class="style1">[ File : D_AKUN.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data POK</td>
			<td>
				<input type="file" name="pok" size="60" />&nbsp;<span class="style1">[ File : D_ITEM.KEU ]</span>			</td>
		</tr>
		<tr> 
			<td class="key">Data Rencana Penarikan</td>
			<td>
				<input type="file" name="tarik" size="60" />&nbsp;<span class="style1">[ File : D_TRKTRN.KEU ]</span>			</td>
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
				<input name="form" type="hidden" value="1" />			</td>
		</tr>
	</table>
</form>