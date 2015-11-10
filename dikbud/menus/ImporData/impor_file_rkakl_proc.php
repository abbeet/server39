<?php
	if(isset($_POST['q']))
	{
		include ("../../includes/includes.php");
		$q = $_POST['q'];
		$tgl_upload = $_POST['tgl_upload'];
		$user_upload = $_POST['user_upload'];
		$nama_file = $_FILES['nama_file']['name'];
		
		if ($nama_file != "")
		{
			move_uploaded_file($_FILES["nama_file"]["tmp_name"], "../../file_dipa/".$nama_file);
				
			$sql = "UPDATE dt_fileupload SET nama_file = '$nama_file', tgl_upload = '$tgl_upload', user_upload = '$user_upload' WHERE kdfile = '$q'";				
			$query = mysql_query($sql) or die(mysql_error());
			echo '{status:3}';
		}
		else
		{
			echo '{status:1,text:"Tidak ada file!"}';
		}
	}
?>
