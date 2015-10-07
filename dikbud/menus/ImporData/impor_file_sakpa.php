<?php
	checkauthentication();
	$err = false;
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
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
		
			if ($_FILES['spmind']['name'] != "")
			{
				
				$filename = $_FILES['spmind']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename.".dbf";
				move_uploaded_file($_FILES["spmind"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'sakpa' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (id,kdfile,nama_file,tgl_upload,user_upload,type,kdsatker,keterangan) values ('','M_SPMIND','$filename','$tgl_upload','$xusername','sakpa','$kdsatker','File Realisasi Total')";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'sakpa' and kdfile = 'M_SPMIND' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMIND
			
			if ($_FILES['spmmak']['name'] != "")
			{
				
				$filename = $_FILES['spmmak']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename.".dbf";
				move_uploaded_file($_FILES["spmmak"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (id,kdfile,nama_file,tgl_upload,user_upload,type,kdsatker,keterangan) values ('','M_SPMMAK','$filename','$tgl_upload','$xusername','sakpa','$kdsatker','File Realisasi Akun')";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE kdfile = 'M_SPMMAK' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------				
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
<?php
	switch ($xlevel)
	{
		case '1':
	$sql = "select * from dt_fileupload_keu WHERE type = 'sakpa' order by kdsatker";
			break;
		case '3':
	$sql = "select * from dt_fileupload_keu WHERE type = 'sakpa' and kdsatker = '$kdsatker' order by kdsatker";
			break;
		case '4':
	$sql = "select * from dt_fileupload_keu WHERE type = 'sakpa' and kdsatker = '$kdsatker' order by kdsatker";
			break;	
		case '6':
	$sql = "select * from dt_fileupload_keu WHERE type = 'sakpa' and kdsatker = '$kdsatker' order by kdsatker";
			break;
		case '7':
	$sql = "select * from dt_fileupload_keu WHERE type = 'sakpa' and kdsatker = '$kdsatker' order by kdsatker";
			break;
		default:
	$sql = "select * from dt_fileupload_keu WHERE type = 'sakpa' order by kdsatker";
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
            