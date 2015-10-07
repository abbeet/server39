<?php
	checkauthentication();
	$err = false;
	$field = array("id","id_skp","no_tugas","no_urut","ket_file","nama_file","waktu_upload");
	$idx = $_REQUEST['id'];
	$id_skp = $_REQUEST['id_skp'];
	$p = $_GET['p'];
	extract($_POST);
 	
	$data = mysql_query("select no_tugas,nama_tugas,jumlah_real,satuan_jumlah from  dtl_skp where id = '$idx'");
	$rdata = mysql_fetch_array($data);
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{

			if( $idx <> '' ) {
		
			if ($_FILES['nmfile']['name'] != "")
			{

				$data = mysql_query("select id_skp,no_tugas from  dtl_skp where id = '$idx'");
				$rdata = mysql_fetch_array($data);
				$id_skp = $rdata['id_skp'];
				$no_tugas = $rdata['no_tugas'];
				$nourut = $_REQUEST['nourut'];
				$dafisi = $_REQUEST['dafisi'];
				$filename = $_FILES['nmfile']['name'];
				
				$random_digit=rand(000,999); 
				$nama_baru=$random_digit."-".$fileName;
				$tmp_name= $_FILES["nmfile"]["tmp_name"];
				$nm_filename = $random_digit."_".$id_skp."_".$idx."-".$filename ;
				$filedir = "file_skp/".$nm_filename ;
				move_uploaded_file($tmp_name, $filedir);
				//-------- simpan data ------
				$tgl_upload = date ('Y-m-d H:i:s') ;
				$sql = mysql_query("select * from dtl_skp_file WHERE id_skp = '$id_skp' and no_urut = '$nourut' and no_tugas = '$no_tugas'");
				$row = mysql_fetch_array($sql);
				if(empty($row)){
					$sql = "INSERT INTO dtl_skp_file (id,id_skp,no_tugas,no_urut, ket_file,nama_file,waktu_upload) values ('','$id_skp','$no_tugas','$nourut','$dafisi','$nm_filename', '$tgl_upload')";				
					$query = mysql_query($sql) or die(mysql_error());
				}else{
					$sql = "UPDATE dtl_skp_file SET dafisi = '$dafisi', waktu_upload = '$tgl_upload' WHERE id_skp = '$id_skp' and no_urut = '$nourut' and no_tugas = '$no_tugas' ";				
					$query = mysql_query($sql) or die(mysql_error());
				}
				//--------------------
				
			}		# AND CEK FILE 
									
			$_SESSION['errmsg'] = "Proses berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=426&id=<?php echo $idx ?>&id_skp=<?php echo $id_skp ?>"><?php
			exit();
			
			}	 # AND CEK KDSATKER
			
			$_SESSION['errmsg'] = "Anda Belum memilih Unit Kerja"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=426&id=<?php echo $idx ?>&id_skp=<?php echo $id_skp ?>"><?php
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
            <form action="index.php?p=426&id=<?php echo $idx ?>&id_skp=<?php echo $id_skp ?>" method="post" name="xproses" enctype="multipart/form-data">
	
  <table cellspacing="1" class="admintable">
    
    
    <tr> 
      <td class="key">Kegiatan Tugas Jabatan  </td>
      <td><b><?php echo $rdata['nama_tugas'] ?></b></td>
    </tr>
    <tr>
      <td class="key">Jumlah Output</td>
      <td><b><?php echo $rdata['jumlah_real'].' '.$rdata['satuan_jumlah'] ?></b></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">No. Urut Dokumen</td>
      <td><input type="text" name="nourut" size="5" value="" />
      &nbsp;[1,2,3,...dst]</td>
    </tr>
    <tr> 
      <td class="key">Nama Dokumen</td>
      <td><input type="text" name="dafisi" size="50" value="" /></td>
    </tr>
    <tr> 
      <td class="key">File Dokumen</td>
      <td> <input type="file" name="nmfile" size="60" /></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form_proses();">Proses</a></div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> </td>
    </tr>
  </table>
</form>

<table width="58%" cellpadding="1" class="adminlist">
  <thead>
		
		<tr>
		  <th width="5%">No.</th>
		  <th width="20%">Keterangan File </th>
          <th width="20%">Waktu Upload </th>
          <th width="20%">Nama File </th>
		  <th width="20%">Aksi</th>
	  </tr>
		
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
          <th align="center">3</th>
          <th align="center">4</th>
		  <th align="center">5</th>
	  </tr>
  </thead>
	<?php 
	$oList = mysql_query("SELECT * FROM dtl_skp_file WHERE id_skp = '$id_skp' and no_tugas = '$rdata[no_tugas]' ORDER BY no_urut");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
	}
	?>
  <tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			$totalAK=0;
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $col[3][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
                    <td align="left" valign="top"><?php echo $col[6][$k] ?></td>
                    <td align="left" valign="top"><a href="file_skp/<?php echo $col[5][$k] ?>" target="_blank"><?php echo $col[5][$k] ?></a></td>
                    
					<?php $totalAK = $totalAK + $col[3][$k]; ?>
				  <td align="center" valign="top">
		  <a href="index.php?p=413&q=<?php echo $col[0][$k] ?>&id_skp=<?php echo $id_skp ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" title="Hapus">
			  <img src="css/images/stop_f2.png" border="0" width="16" height="16"></a>				  </td>
				</tr>
			<?php
			}
			} ?>
  </tbody>
	</table>
            