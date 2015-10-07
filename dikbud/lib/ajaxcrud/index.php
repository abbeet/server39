<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Aplikasi Insert, Edit dan Delete Dengan Ajax</title>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <style>
    body,td,th{   
	  font-family: Verdana;
	  font-size: 12px;
    }
  </style>
  <link href="css/thickbox.css" rel="stylesheet" type="text/css" />
  <!--link href="css/calendar.css" rel="stylesheet" type="text/css" /-->
  <script language="javascript" src="js/jquery.js"></script>
  <script language="javascript" src="js/thickbox.js"></script>
  <script language="javascript" src="js/jquery.form.js"></script>
  <!--script language="javascript" src="js/jsCalendar.js"></script-->
  <script language="javascript">
    /*  Fungsi addRow untuk menambahkan baris pada table pegawai setelah 
		Ajax berhasil melakukan proses tambah data pegawai	*/
    function addRow(ID,NIP,Name,DeptName){
	   var str = '<tr id="tr'+ID+'">';
	   /* cara mengetahui jumlah baris pada table pegawai saat ini
		  untuk membuat nomor urut data pada table */
	   var countLine = Object($('#tableBody tr')).length; 
	   str += '<td align="center">'+(countLine+1)+'</td>';
	   str += '<td align="center">'+NIP+'</td>';
	   str += '<td>'+Name+'</td>';
	   str += '<td>'+DeptName+'</td>';
	   str += '<td align=center><a href="form.php?width=370&height=230&id_pegawai='+ID+'" class="thickbox">Edit</a> ';
	   str += '| <a href="javascript:deleteRow(\''+ID+'\')">Delete</a></td>';
	   str += '</tr>';
	   
	   // kode html yang sudah disusun ditambahkan (append) ke dalam tag tbody
	   $('#tableBody').append(str);
	   
	   /* setiap link dengan class='thickbox pada baris yang baru dibuat akan 
		  mempunyai fungsi mengeluarkan dialog thickbox ketika melakukan edit data */
	   tb_init('#tr'+ID+' td a.thickbox');
	}
	
	// untuk mengedit data pada baris tertentu di table daftar pegawai
	function editRow(ID,NIP,Name,DeptName){
	   var element = '#tr'+ID; // ambil ID dari baris yang ingin diubah
	   $(element+' td:nth-child(2)').text(NIP); // kolom kedua (NIP) dari baris diubah datanya
	   $(element+' td:nth-child(3)').text(Name); // kolom ketiga (Nama) dari baris diubah datanya
	   $(element+' td:nth-child(4)').text(DeptName); // kolom keempat (Department) dari baris diubah datanya
	}
	
	// untuk menghapus baris atau data pada table pegawai
	function deleteRow(ID){ // ID dari record pegawai dikirimkan sebagai parameter
	   $.post(
	      'delete.php',
		  {id_pegawai: ID},
		  function(response){
			if(response == 'ok')  // jika respon dari delete.php adalah 'ok' 
			  $('#tr'+ID).remove();  // hapus 1 baris
			else 
			  alert('Delete gagal');
		  }
	   );
	}
	
	/*  fungsi submitForm akan dipanggil pada saat melakukan inputan pada 
		form tambah atau edit pegawai. Di dalam fungsi ini ada fungsi ajaxSubmit 
		yang merupakan plugin dari jquery yaitu jquery.form.js
	*/
	function submitForm(){
		// beri tanda bahwa data sedang di proses dengan efek loading fade in
		$('#divResult').text('loading...').fadeIn();		
		$('#formData').ajaxSubmit({
		  success: function(response){	
			// sembunyikan element tempat hasil respon sementara agar efek fade in lebih nyata
			$('#divResult').hide(); 
			/* respon yang diterima berupa json dengan struktur 
			{status:(nomor status), IDPegawai: (id dari pegawai)}*/
			if(response.status == 1){
			  /* jika nilai status adalah 1 berarti ada error dan
			     response.text yang merupakan pesan error akan ditampilkan di 
				 element dengan ID = divResult */
			  // pesan error diberi efek fade in dengan background warna merah
			  $('#divResult').text(response.text).css({'color':'#FFFFFF','background-color':'#FF0000'}).fadeIn();				
			}else if(response.status == 2){
			  /* jika nilai status adalah 2 maka tandanya sedang berlangsung
				proses penambahan data pegawai baru oleh karena itu fungsi yang 
				dipakai selanjutnya adalah addRow untuk menambah baris di table pegawai */
			  // pesan sukses diberi efek fade in dengan background warna kuning
			  $('#divResult').text('Data berhasil ditambah').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
			  addRow(
				response.IDPegawai,
				$('input[@name=NIP]').val(),
				$('input[@name=Name]').val(),
				$('select[@name=Department] option:selected').text()
			  );
			  tb_remove();  
			}else if(response.status == 3){
			  /* jika nilai status adalah 3 maka sedang berlangsung 
				proses edit data pegawai maka fungsi yang dipanggil selanjutnya
				adalah fungsi editRow untuk mengedit baris data pegawai yang 
				sudah diubah di form */			  
			  // pesan sukses diberi efek fade in dengan background warna kuning
			  $('#divResult').text('Data berhasil diedit').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
			  editRow(
				$('input[@name=ID]').val(),
				$('input[@name=NIP]').val(),
				$('input[@name=Name]').val(),
				$('select[@name=Department] option:selected').text()
			  );
			  tb_remove();
			}
		  }, 
		  dataType: 'json' // menandakan bahwa ajax menginginkan respon berupa json
		});
		return false;
	}
  </script>
</head>
<body>
 <div align="center">
 <h2>Ajax CRUD</h2>
 <small>By <a href="http://chandrajatnika.com" target="_blank">Chandra Jatnika</a></small><br /><br />
 <table cellspacing="0" cellpadding="4" border="1" width="500">
   <thead>
     <tr bgcolor="#CCCCCC">
	   <th>No</th>
	   <th>NIP</th>
	   <th>Nama</th>
	   <th>Department</th>
	   <th>Action</th>
     </tr>
   </thead>
   <tbody id="tableBody"><?
		include 'connect.inc.php';
		$query = mysql_query('SELECT p.*,d.DepartmentName FROM master_pegawai p JOIN master_department d ON p.Department = d.ID');
		if($query && mysql_num_rows($query) > 0){
		  $x = 1;
		  while($row = mysql_fetch_object($query)){
			echo "<tr id='tr{$row->ID}'>
					<td align='center'>$x</td>
					<td align='center'>{$row->NIP}</td>
					<td>{$row->Name}</td>
					<td>{$row->DepartmentName}</td>
					<td align='center'><a class='thickbox' href='form.php?id_pegawai={$row->ID}&width=370&height=230'>Edit</a> 
						| <a href='javascript:deleteRow(\"{$row->ID}\")'>Delete</a></td>
				  </tr>";
			$x++;
		  }
		}
   ?></tbody>
 </table>
 <br /><a href="form.php?width=370&height=230" class="thickbox" title="Tambah Data Pegawai">Tambah Data Pegawai</a>
 
 </div>	
</body>
</html>
