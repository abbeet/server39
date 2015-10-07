<?php
	checkauthentication();
	$err = false;
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	$xlevel = $_SESSION['xlevel'];
	extract($_POST);
 	$ta = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$kdsatker = $_REQUEST['kdsatker'];
			if( $kdsatker <> '' ) {
		
			if ($_FILES['spmind_1']['name'] != "")
			{
				
				$filename = $kdsatker.'_'.$_FILES['spmind_1']['name'];
				$filedir = "../../mysql/data/db_dikbud/".$filename;
				move_uploaded_file($_FILES["spmind_1"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'spm' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (kdfile , nama_file , tgl_upload , user_upload , type , kdsatker , keterangan) values
					       ('M_SPMIND_FRM' , '$filename' , '$tgl_upload' , '$xusername' , 'spm' , '$kdsatker' , 'File Realisasi SPM' )";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'spm' and kdfile = 'M_SPMIND_FRM' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMIND
			
			if ($_FILES['spmind_2']['name'] != "")
			{
				
				$filename = $kdsatker.'_'.$_FILES['spmind_2']['name'];
				$filedir = "../../mysql/data/db_dikbud/".$filename;
				move_uploaded_file($_FILES["spmind_2"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'spm' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (kdfile , nama_file , tgl_upload , user_upload , type , kdsatker , keterangan) values
					       ('M_SPMIND_MYD' , '$filename' , '$tgl_upload' , '$xusername' , 'spm' , '$kdsatker' , 'File Realisasi SPM' )";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'spm' and kdfile = 'M_SPMIND_MYD' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMIND
			
			if ($_FILES['spmind_3']['name'] != "")
			{
				
				$filename = $kdsatker.'_'.$_FILES['spmind_3']['name'];
				$filedir = "../../mysql/data/db_dikbud/".$filename;
				move_uploaded_file($_FILES["spmind_3"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'spm' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (kdfile , nama_file , tgl_upload , user_upload , type , kdsatker , keterangan) values
					       ('M_SPMIND_MYI' , '$filename' , '$tgl_upload' , '$xusername' , 'spm' , '$kdsatker' , 'File Realisasi SPM' )";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'spm' and kdfile = 'M_SPMIND_MYI' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMIND
			
			if ($_FILES['spmmak_1']['name'] != "")
			{
				
				$filename = $kdsatker.'_'.$_FILES['spmmak_1']['name'];
				$filedir = "../../mysql/data/db_dikbud/".$filename;
				move_uploaded_file($_FILES["spmmak_1"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'spm' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (kdfile , nama_file , tgl_upload , user_upload , type , kdsatker , keterangan) values
					       ('M_SPMMAK_FRM' , '$filename' , '$tgl_upload' , '$xusername' , 'spm' , '$kdsatker' , 'File Realisasi SPM' )";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'spm' and kdfile = 'M_SPMMAK_FRM' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMMAK
				
			if ($_FILES['spmmak_2']['name'] != "")
			{
				
				$filename = $kdsatker.'_'.$_FILES['spmmak_2']['name'];
				$filedir = "../../mysql/data/db_dikbud/".$filename;
				move_uploaded_file($_FILES["spmmak_2"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'spm' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (kdfile , nama_file , tgl_upload , user_upload , type , kdsatker , keterangan) values
					       ('M_SPMMAK_MYD' , '$filename' , '$tgl_upload' , '$xusername' , 'spm' , '$kdsatker' , 'File Realisasi SPM' )";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'spm' and kdfile = 'M_SPMMAK_MYD' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMMAK
			
			if ($_FILES['spmmak_3']['name'] != "")
			{
				
				$filename = $kdsatker.'_'.$_FILES['spmmak_3']['name'];
				$filedir = "../../mysql/data/db_dikbud/".$filename;
				move_uploaded_file($_FILES["spmmak_3"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'spm' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (kdfile , nama_file , tgl_upload , user_upload , type , kdsatker , keterangan) values
					       ('M_SPMMAK_MYI' , '$filename' , '$tgl_upload' , '$xusername' , 'spm' , '$kdsatker' , 'File Realisasi SPM' )";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'spm' and kdfile = 'M_SPMMAK_MYI' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMMAK
			$_SESSION['errmsg'] = "Proses Import data SPM Satker ".$kdsatker." berhasil"; ?>

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
      <td width="115" class="key">Tahun Anggaran</td>
      <td width="779"><?php echo date('Y') ?></td>
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
      <td><strong>Lokasi file pada folder //DBSATKER/DATA/DBSQL<?php echo substr($th,2,2) ?></strong></td>
    </tr>
    <tr> 
      <td class="key">File Realisasi Total</td>
      <td> <input type="file" name="spmind_1" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : M_SPMIND.FRM]</span> </td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td> <input type="file" name="spmind_2" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : M_SPMIND.MYD]</span> </td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td> <input type="file" name="spmind_3" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : M_SPMIND.MYI]</span> </td>
    </tr>
    <tr> 
      <td class="key">File Realisasi Akun</td>
      <td> <input type="file" name="spmmak_1" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : M_SPMMAK.FRM]</span> </td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td> <input type="file" name="spmmak_2" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : M_SPMMAK.MYD]</span> </td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td> <input type="file" name="spmmak_3" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : M_SPMMAK.MYI]</span> </td>
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
<?php
	switch ($xlevel)
	{
		case '1':
	$sql = "select * from dt_fileupload_keu WHERE type = 'spm' and left(kdfile,1) = 'M' order by kdsatker";
			break;
		case '3':
	$sql = "select * from dt_fileupload_keu WHERE type = 'spm' and kdsatker = '$kdsatker' and left(kdfile,1) = 'M' order by kdsatker";
			break;
		case '4':
	$sql = "select * from dt_fileupload_keu WHERE type = 'spm' and kdsatker = '$kdsatker' and left(kdfile,1) = 'M' order by kdsatker";
			break;
		case '6':
	$sql = "select * from dt_fileupload_keu WHERE type = 'spm' and kdsatker = '$kdsatker' and left(kdfile,1) = 'M' order by kdsatker";
			break;
		case '7':
	$sql = "select * from dt_fileupload_keu WHERE type = 'spm' and kdsatker = '$kdsatker' and left(kdfile,1) = 'M'norder by kdsatker";
			break;		
		default:
	$sql = "select * from dt_fileupload_keu WHERE type = 'spm' and left(kdfile,1) = 'M' border by kdsatker";
			break;
	}

	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['kdsatker'];
		$col[1][] 	= $Satker['kdfile'];
		$col[2][] 	= $Satker['user_upload'];
		$col[3][] 	= $Satker['tgl_upload'];
		$col[4][] 	= $Satker['keterangan'];
	}

?>
<table width="463" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode Satker </th>
      <th rowspan="2">Nama File </th>
      <th colspan="2">Upload Terakhir </th>
      <th width="51%" rowspan="2">Keterangan</th>
    </tr>
    <tr>
      <th height="21">User</th>
      <th width="11%">Waktu</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="10">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				?>
    <tr class="<?php echo $class ?>"> 
      <td width="12%" align="center"><?php echo $col[0][$k]?></td>
      <td width="10%" align="left"><?php echo $col[1][$k]?></td>
      <td width="16%" align="left"><?php echo $col[2][$k]?></td>
      <td align="center"><?php echo $col[3][$k]?></td>
      <td align="left"><?php echo $col[4][$k]?></td>
    </tr>
    <?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>
            