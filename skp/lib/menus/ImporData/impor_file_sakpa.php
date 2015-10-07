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
		
			if ($_FILES['spmind']['name'] != "")
			{
				
				$filename = $_FILES['spmind']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename.".dbf";
				move_uploaded_file($_FILES["spmind"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SPMIND
			
			if ($_FILES['spmmak']['name'] != "")
			{
				
				$filename = $_FILES['spmmak']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename.".dbf";
				move_uploaded_file($_FILES["spmmak"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SPMIND
						
			$_SESSION['errmsg'] = "Proses Import data SAKPA Satker ".$kdsatker." berhasil"; ?>

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
      <td><?php echo date('Y') ?></td>
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
      <td><strong>Lokasi file pada folder //SAKPA/TRN</strong></td>
    </tr>
    <tr> 
      <td class="key">File Realisasi Total</td>
      <td> <input type="file" name="spmind" size="60" /> &nbsp;<span class="style1">[ 
        File : M_SPMIND]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Realisasi Akun</td>
      <td> <input type="file" name="spmmak" size="60" /> &nbsp;<span class="style1">[ 
        File : M_SPMMAK]</span> </td>
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