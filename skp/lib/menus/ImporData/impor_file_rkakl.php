<?php
	checkauthentication();
	$err = false;

	extract($_POST);
 	$ta = date('Y');
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;

	if (isset($form)) 
	{		
		if ($err != true) 
		{
			if ($_FILES['output']['name'] != "")
			{
				
				$filename = $_FILES['output']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["output"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE OUTPUT
			
			if ($_FILES['suboutput']['name'] != "")
			{
				
				$filename = $_FILES['suboutput']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["suboutput"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SUBOUTPUT
			
			if ($_FILES['komponen']['name'] != "")
			{
				$filename = $_FILES['komponen']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["komponen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE KOMPONEN
						
			if ($_FILES['subkomponen']['name'] != "")
			{
				$filename = $_FILES['subkomponen']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["subkomponen"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE SUBKOMPONEN
						
			if ($_FILES['akun']['name'] != "")
			{
				$filename = $_FILES['akun']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["akun"]["tmp_name"], $filedir);
				
			}		# AND CEK FILE AKUN
						
			if ($_FILES['pok']['name'] != "")
			{
				$filename = $_FILES['pok']['name'];
				$filedir = "file_dipa/".$filename;
				move_uploaded_file($_FILES["pok"]["tmp_name"], $filedir);

			}		# AND CEK FILE POK
						
			$_SESSION['errmsg'] = "Proses Import data berhasil"; ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		}
	} 
?>

<link href="lib/ajaxcrud/css/thickbox.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="lib/ajaxcrud/js/jquery.js"></script>
<script language="javascript" src="lib/ajaxcrud/js/thickbox.js"></script>
<script language="javascript" src="lib/ajaxcrud/js/jquery.form.js"></script>
<script language="javascript">

	function EditRowUpload(q,tgl_upload,user_upload)
	{
		var element = '#tr'+q;
		
		$(element+' td:nth-child(4)').text(tgl_upload);
		$(element+' td:nth-child(5)').text(user_upload);
	}

	function UploadFile()
	{
		$('#divResult').text('loading...').fadeIn();		
		$('#formData').ajaxSubmit(
		{
			success: function(response)
			{
				$('#divResult').hide();
				if(response.status == 1)
				{
		  			$('#divResult').text(response.text).css({'color':'#FFFFFF','background-color':'#FF0000'}).fadeIn();				
				}
				else if(response.status == 3)
				{
		  			$('#divResult').text('Data berhasil dikirim').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
		  			EditRowUpload(
						$('input[@name=q]').val(),
						$('input[@name=tgl_upload]').val(),
						$('input[@name=user_upload]').val()
		  			);
		  			tb_remove();
				}
	  		}, 
	  		dataType: 'json'
		});
		return false;
	}
	
	function EditRowRefresh(q,tgl_refresh,user_refresh)
	{
		var element = '#tr'+q;
		
		$(element+' td:nth-child(6)').text(tgl_refresh);
		$(element+' td:nth-child(7)').text(user_refresh);
	}
	
	function RefreshFile()
	{
		$('#divResult').text('loading...').fadeIn();		
		$('#formData').ajaxSubmit(
		{
			success: function(response)
			{
				$('#divResult').hide();
				if(response.status == 1)
				{
		  			$('#divResult').text(response.text).css({'color':'#FFFFFF','background-color':'#FF0000'}).fadeIn();				
				}
				else if(response.status == 3)
				{
		  			$('#divResult').text('Proses berhasil').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
		  			EditRowRefresh(
						$('input[@name=q]').val(),
						$('input[@name=tgl_refresh]').val(),
						$('input[@name=user_refresh]').val()
		  			);
		  			tb_remove();
				}
	  		}, 
	  		dataType: 'json'
		});
		return false;
	}
</script>
<div class="button2-right"> 
<div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
</div><br><br>
<table cellpadding="1" class="adminlist">
	<thead>
		<tr> 
			<th>No.</th>
			<th>Keterangan</th>
			<th>Nama File</th>
			<th>Tanggal Upload Terakhir</th>
			<th>Diupload Oleh</th>
			<th>Tanggal Refresh Terakhir</th>
			<th>Direfresh Oleh</th>
			<th colspan="2">Aksi</th>
		</tr>
	</thead>
	<tbody><?php

		$sql = "SELECT * FROM dt_fileupload WHERE type = 'rkakl'";
		$qu = mysql_query($sql);
		$count = mysql_num_rows($qu);
		
		if ($count == 0) 
		{ ?>
	
			<tr> 
				<td align="center" colspan="9">Tidak ada data!</td>
			</tr><?php
	
		}
		else 
		{
			$k = 1;
			while ($rows = mysql_fetch_array($qu)) 
			{
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				
				<tr class="<?php echo $class ?>" id="tr<?php echo $rows['kdfile']; ?>"> 
					<td align="center"><?php echo $k++; ?></td>
					<td align="left"><?php echo $rows['keterangan']; ?></td>
					<td align="left"><?php echo $rows['nama_file']; ?></td>
					<td align="center"><?php echo $rows['tgl_upload']; ?></td>
					<td align="center"><?php echo $rows['user_upload']; ?></td>
					<td align="center"><?php echo $rows['tgl_refresh']; ?></td>
					<td align="center"><?php echo $rows['user_refresh']; ?></td>
					<td align="center">
						<a class='thickbox' href='menus/ImporData/impor_file_rkakl_ed.php?q=<?php echo $rows['kdfile']; ?>&u=<?php echo $_SESSION['xusername']; ?>&width=600&height=200' title="Upload File">Upload</a>
					</td>
					<td align="center">
						<a class='thickbox' href='menus/ImporData/refresh_file_rkakl_ed.php?q=<?php echo $rows['kdfile']; ?>&u=<?php echo $_SESSION['xusername']; ?>&width=600&height=200' title="Refresh File">Refresh</a>
					</td>
				</tr><?php 
				
			}
		} ?>
	</tbody>
	<tfoot>
		<tr> 
			<td colspan="9">&nbsp;</td>
		</tr>
	</tfoot>
</table>