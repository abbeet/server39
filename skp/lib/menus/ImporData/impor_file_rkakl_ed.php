<?php
	include "../../includes/includes.php";
	
	$q = $_GET['q'];
	
	if ($q != "")
	{
		$sql = "SELECT kdfile, keterangan FROM dt_fileupload WHERE kdfile = '$q'";
		$query = mysql_query($sql);
		
		if ($query and mysql_num_rows($query) == 1)
		{
			$value = mysql_fetch_array($query);
		}
		else
		{
			echo "Data Tidak Ditemukan";
		}
	}
?>

<br />
<link href="../../css/general.css" rel="stylesheet" type="text/css" />
<div id="divResult" style="font-size:11px;text-align:center;display:none"></div>
<form method="post" action="menus/ImporData/impor_file_rkakl_proc.php" id="formData" onsubmit="return UploadFile();" enctype="multipart/form-data">
	<input name="tgl_upload" type="hidden" value="<?php echo date('Y-m-d H:i:s') ?>" />
	<input name="user_upload" type="hidden" value="<?php echo $_GET['u']; ?>" />
	<input name="q" type="hidden" value="<?php echo @$value['kdfile']; ?>" />
	
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key"><?php echo @$value['keterangan']; ?></td>
			<td>
				<input type="file" name="nama_file" size="40" />&nbsp;[File : <?php echo $value['kdfile']; ?>.KEU]
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="button" value="&nbsp; Batal &nbsp;" onClick="tb_remove()" />
				<input type="submit" name="upload" value="&nbsp; &nbsp; Upload &nbsp; &nbsp;" />
			</td>
		</tr>
	</table>
</form>