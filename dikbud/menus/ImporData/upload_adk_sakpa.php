<?php
	checkauthentication();
	$err = false;
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	extract($_POST);
 	$th = $_REQUEST['th'];
	$kdsatker = $_REQUEST['kdsatker'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$kdsatker = $_REQUEST['kdsatker'];
			if( $kdsatker <> '' ) {
		
			if ($_FILES['adk']['name'] != "")
			{
				
				$filename = $_FILES['adk']['name'];
				$filedir = "file_dipa/".$kdsatker."/".$filename;
				move_uploaded_file($_FILES["adk"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload_keu WHERE type = 'adk' and nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload_keu (id,kdfile,nama_file,tgl_upload,user_upload,type,kdsatker,keterangan) values ('','ADK','$filename','$tgl_upload','$xusername','adk','$kdsatker','File ADK SAKPA')";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload_keu SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE type = 'adk' and kdfile = 'ADK' and kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE SPMIND
			
			
			$_SESSION['errmsg'] = "Proses Import data SAKPA Satker ".$kdsatker." berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=563&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>"><?php
			exit();
			
			}	 # AND CEK KDSATKER
			
			$_SESSION['errmsg'] = "Anda Belum memilih Satker"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=563&kdsatker=<?php echo $kdsatker ?>&th=<?php echo $th ?>"><?php
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
	
  <table width="656" cellspacing="1" class="admintable">
    <tr> 
      <td class="key">Tahun Anggaran</td>
      <td><?php echo $th ?></td>
    </tr>
    <tr>
      <td class="key">Satker</td>
      <td><?php echo '['.$kdsatker.'] '.nm_satker($kdsatker) ?></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td><strong>Lokasi file pada folder //SAKPA</strong></td>
    </tr>
    <tr> 
      <td class="key">File ADK SAKPA</td>
      <td> <input type="file" name="adk" size="60" /></td>
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
</form><br />
<?php
	$sql = "select * from dt_fileupload_keu WHERE type = 'adk' and kdsatker = '$kdsatker' order by kdsatker";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['kdsatker'];
		$col[1][] 	= $Satker['nama_file'];
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
            