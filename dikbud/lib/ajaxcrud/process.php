<?
	/* proses.php akan menjadi file yang di request oleh Ajax 
	   dan akan mengembalikan nilai dengan struktur JSON */
	if(isset($_POST['ID'])){
	  include 'connect.inc.php';
      $ID = getPost('ID');
      $NIP = getPost('NIP');
      $Name = getPost('Name');
      $Address = getPost('Address');
      $Department = getPost('Department');
	  if($NIP && $Name){
	    if($ID){
		  $SQLUpdate = "UPDATE master_pegawai SET					
						 NIP = '$NIP',
						 Name = '$Name',
						 Address = '$Address',
						 Department = '$Department'
						WHERE ID = '$ID'";				
		  $query = mysql_query($SQLUpdate) or die(mysql_error());
		  echo '{status:3}'; // memberikan respon nilai status = 3 ketika berhasil mengedit
		}else{	  
		  $SQLInsert = "INSERT INTO master_pegawai
							(NIP,Name,Address,Department)
						  VALUES('$NIP','$Name','$Address','$Department')";				
		  $query = mysql_query($SQLInsert) or die(mysql_error());
		  $lastID = mysql_insert_id();
		  /* memberikan respon nilai status = 2 dan ID dari record pegawai 
			ketika berhasil menambah data pegawai baru */
		  echo '{status:2,IDPegawai:'.$lastID.'}';
		}
	  // mengembalikan respon nilai status = 1 dan text error message
	  }else echo '{status:1,text:"Lengkapi Isi Form. NIP dan Nama Harus Diinput"}';
	}
?>
