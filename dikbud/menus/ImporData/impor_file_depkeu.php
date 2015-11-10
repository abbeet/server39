<?php
	checkauthentication();
	$err = false;

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_FILES['dept']['name'] != "")
			{
				
				$filename = $_FILES['dept']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["dept"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE DEPARTEMEN
			
			if ($_FILES['satker']['name'] != "")
			{
				
				$filename = $_FILES['satker']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["satker"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SATKER
						
			if ($_FILES['giat']['name'] != "")
			{
				
				$filename = $_FILES['giat']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["giat"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE GIAT
						
			if ($_FILES['output']['name'] != "")
			{
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE OUTPUT
						
			if ($_FILES['akun']['name'] != "")
			{
				
				$filename = $_FILES['akun']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
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
      <td width="202" class="key">&nbsp;</td>
      <td width="631"><strong>Lokasi file pada folder //SAKPA/TRN</strong></td>
    </tr>
    <tr> 
      <td class="key">File Tabel Departemen</td>
      <td> <input type="file" name="dept" size="60" /> &nbsp;<span class="style1">[ 
        File : T_DEPT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Tabel Satker</td>
      <td> <input type="file" name="satker" size="60" /> &nbsp;<span class="style1">[ 
        File : T_SATKER.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Tabel Kegiatan</td>
      <td> <input type="file" name="giat" size="60" />
        &nbsp;<span class="style1">[ File : T_GIAT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Tabel Output</td>
      <td> <input type="file" name="output" size="60" />
        &nbsp;<span class="style1">[ File : T_OUTPUT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Tabel Akun</td>
      <td> <input type="file" name="akun" size="60" />
        &nbsp;<span class="style1">[ File : T_AKUN.KEU]</span> </td>
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