<?php
	checkauthentication();
	$err = false;
	$xusername = $_SESSION['xusername'];
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
		
			if ($_FILES['gpp']['name'] != "")
			{
				
				$filename = $_FILES['gpp']['name'];
				$filedir = "file_gpp/".$kdsatker."/".$filename.".dbf";
				move_uploaded_file($_FILES["gpp"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_filegpp WHERE nama_file = '$filename' and kdsatker = '$kdsatker' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_filegpp (kdfile,nama_file,tgl_upload,user_upload,type,kdsatker,keterangan) values ('GAJI','$filename','$tgl_upload','$xusername','gpp','$kdsatker','File Gaji')";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_filegpp SET tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE kdsatker = '$kdsatker'";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE GPP
									
			$_SESSION['errmsg'] = "Proses Import data GPP Satker ".$kdsatker." berhasil"; ?>

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
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker group by kdsatker order by kdsatker");
			break;
		case '7':
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker WHERE kdsatker = '$xusername' order by KDSATKER");
			break;
		default:
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker group by kdsatker order by kdsatker");
			break;
	}

			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['kdsatker'].' '.$row['namasatker']; ?></option>
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
      <td><strong>Lokasi file pada folder //dbgaji8/DB</strong></td>
    </tr>
    <tr> 
      <td class="key">Data Gaji </td>
      <td> <input type="file" name="gpp" size="60" /> 
      &nbsp;<span class="style1">[ 
        File : T_GAJI]</span> </td>
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
	$sql = "select * from dt_filegpp WHERE order by kdsatker";
			break;
		case '7':
	$sql = "select * from dt_filegpp WHERE kdsatker = '$xusername' order by kdsatker";
			break;
		default:
	$sql = "select * from dt_filegpp WHERE order by kdsatker";
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
      <th rowspan="2">Nama<br />Satker</th>
      <th rowspan="2">Nama File </th>
      <th colspan="2">Upload Terakhir </th>
      <th width="18%" rowspan="2">Keterangan</th>
    </tr>
    <tr>
      <th height="21">User</th>
      <th width="13%">Waktu</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="11">Tidak ada data!</td>
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
      <td width="26%" align="left"><?php echo nm_satker($col[0][$k]) ?></td>
      <td width="17%" align="left"><?php echo $col[1][$k]?></td>
      <td width="14%" align="left"><?php echo $col[2][$k]?></td>
      <td align="center"><?php echo $col[3][$k]?></td>
      <td align="left"><?php echo $col[4][$k]?></td>
    </tr>
    <?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>
            