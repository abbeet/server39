<?php
	checkauthentication();
	$err = false;
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	extract($_POST);
 	$th = $_SESSION['xth'];
	$xkdunit = $_REQUEST['xkdunit'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		
			if ($_FILES['nmfile']['name'] != "")
			{
				$nourut = $_REQUEST['nourut'];
				$dafisi = $_REQUEST['dafisi'];
				$filename = $_FILES['nmfile']['name'];
				$nm_filename = $th.'_'.$filename ;
				$filedir = "file_semester1/".$xkdunit."/".$th.'_'.$filename ;
				move_uploaded_file($_FILES["nmfile"]["tmp_name"], $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dt_fileupload WHERE th = '$th' and kdunitkerja = '$xkdunit' and nourut = '$nourut' and keterangan = 'Semester1' ");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dt_fileupload (id,th,kdunitkerja,nourut,dafisi,nama_file,keterangan,tgl_upload,user_upload) values ('','$th','$xkdunit','$nourut','$dafisi','$nm_filename','Semester1', '$tgl_upload','$xusername')";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dt_fileupload SET dafisi = '$dafisi', nama_file = '$nm_filename', tgl_upload = '$tgl_upload', user_upload = '$xusername' WHERE th = '$th' and kdunitkerja = '$xkdunit' and nourut = '$nourut' and keterangan = 'Semester1' ";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE 
									
			$_SESSION['errmsg'] = "Proses berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=603&xkdunit=<?php echo $xkdunit ?>"><?php
			exit();
			
		}
	} 
?>

            <style type="text/css">
<!--
.style1 {color: #990000}
-->
            </style>
<script type="text/javascript">
	function form_proses()
		{
			document.forms['xproses'].submit();
		}
</script>
            <form action="index.php?p=603&xkdunit=<?php echo $xkdunit ?>" method="post" name="xproses" enctype="multipart/form-data">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td width="122" class="key">Tahun Anggaran</td>
      <td width="517"><strong><?php echo $th ?></strong></td>
    </tr>
    <tr>
      <td class="key">Satker Mandiri</td>
      <td><strong><?php echo nm_unit($xkdunit) ?></strong></td>
    </tr>
    
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">No. Urut </td>
      <td><input type="text" name="nourut" size="5" value="" />
        &nbsp;<font color="#FF33CC">[1,2,3,... dan 0 untuk file Cover]</font></td>
    </tr>
    <tr> 
      <td class="key">Teks yang tampil </td>
      <td><input type="text" name="dafisi" size="50" value="" /></td>
    </tr>
    <tr> 
      <td class="key">Nama File </td>
      <td> <input type="file" name="nmfile" size="60" /><br /><font color="#FF33CC">[cover : JPG dan dokumen : PDF]</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>&xkdunit=<?php echo $xkdunit ?>sw=1')">Kembali</a></div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form_proses();">Upload</a></div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> </td>
    </tr>
  </table>
</form>
<?php
	$sql = "select * from dt_fileupload WHERE th = '$th' and kdunitkerja = '$xkdunit' and keterangan = 'Semester1' order by nourut";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['id'];
		$col[1][] 	= $Satker['dafisi'];
		$col[2][] 	= $Satker['user_upload'];
		$col[3][] 	= $Satker['tgl_upload'];
		$col[4][] 	= $Satker['nama_file'];
		$col[5][] 	= $Satker['th'];
		$col[6][] 	= $Satker['nourut'];
		$col[7][] 	= $Satker['kdunitkerja'];
	}

?>
<table width="463" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th rowspan="2">Tahun</th> 
      <th rowspan="2">Unit Kerja </th>
      <th rowspan="2">Urutan</th>
      <th rowspan="2">Isi Teks </th>
      <th colspan="2">Upload Terakhir </th>
      <th width="18%" rowspan="2">Nama File </th>
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
      <td align="center" colspan="12">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				?>
    <tr class="<?php echo $class ?>">
      <td width="10%" align="center"><?php echo $col[5][$k]?></td> 
      <td width="19%" align="left"><?php echo nm_unit($col[7][$k]) ?></td>
      <td width="11%" align="center"><?php echo $col[6][$k]?></td>
      <td width="20%" align="left"><?php echo $col[1][$k]?></td>
      <td width="9%" align="left"><?php echo $col[2][$k]?></td>
      <td align="center"><?php echo $col[3][$k]?></td>
      <td align="left"><?php echo $col[4][$k]?></td>
    </tr>
    <?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="9">&nbsp;</td>
    </tr>
  </tfoot>
</table>
            