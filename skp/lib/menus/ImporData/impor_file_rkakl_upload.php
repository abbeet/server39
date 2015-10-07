<?php
	checkauthentication();
	$err = false;
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];

	extract($_POST);
 	$ta = date('Y');
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$kdsatker = $_REQUEST['kdsatker'];
			if( $kdsatker <> '' ) {
		
			if ($_FILES['output']['name'] != "")
			{
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE OUTPUT
			
			if ($_FILES['soutput']['name'] != "")
			{
				
				$filename = $_FILES['soutput']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["soutput"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SOUTPUT
			
			if ($_FILES['kmpnen']['name'] != "")
			{
				
				$filename = $_FILES['kmpnen']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["kmpnen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE KMPNEN
			
			if ($_FILES['skmpnen']['name'] != "")
			{
				
				$filename = $_FILES['skmpnen']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["skmpnen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SKMPNEN
			
			if ($_FILES['akun']['name'] != "")
			{
				
				$filename = $_FILES['akun']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE AKUN
			
			if ($_FILES['item']['name'] != "")
			{
				
				$filename = $_FILES['item']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["item"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE ITEM

			$_SESSION['errmsg'] = "Proses Import data DIPA dan RKAKL Satker ".$kdsatker." berhasil"; ?>

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
      <td width="100" class="key">Tahun Anggaran</td>
      <td width="707"><?php echo date('Y') ?></td>
    </tr>
    <tr>
      <td class="key">Satker</td>
      <td><select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
			
	switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker order by KDSATKER");
			break;
		case '3':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$xusername' order by KDSATKER");
			break;
		default:
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker order by KDSATKER");
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
      <td class="key">File Output </td>
      <td> <input type="file" name="output" size="60" /> 
        &nbsp;<span class="style1">[ 
        File : D_OUTPUT.KEU]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Sub Output </td>
      <td><input type="file" name="soutput" size="60" />        &nbsp;<span class="style1">[ 
        File : D_SOUTPUT.KEU]</span> </td>
    </tr>
    <tr>
      <td class="key">File Komponen </td>
      <td><input type="file" name="kmpnen" size="60" />
        &nbsp;<span class="style1">[ 
          File : D_KMPNEN.KEU]</span> </td>
    </tr>
    <tr>
      <td class="key">File Sub Komponen </td>
      <td><input type="file" name="skmpnen" size="60" />        &nbsp;<span class="style1">[ 
          File : D_SKMNEN.KEU]</span> </td>
    </tr>
    <tr>
      <td class="key">File DIPA </td>
      <td><input type="file" name="akun" size="60" />
        &nbsp;<span class="style1">[ 
          File : D_AKUN.KEU]</span> </td>
    </tr>
    <tr>
      <td class="key">File POK </td>
      <td><input type="file" name="item" size="60" />
        &nbsp;<span class="style1">[ 
          File : D_ITEM.KEU]</span> </td>
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