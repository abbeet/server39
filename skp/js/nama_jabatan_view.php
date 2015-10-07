<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	$kdjab = substr($kdunitkerja,2,5) ;
	$kdunit = substr($kdunitkerja,0,5) ;
	// baca nama jabatan
		$sql = "SELECT * FROM kd_jabatan WHERE kdunitkerja LIKE '$kdunit%' order by nmjabatan";
	
	$hasil = mysql_query($sql);
	$nrecord = mysql_num_rows($hasil);
	
	if ($nrecord != 0)
	{ ?>
		<select name="kdjabatan">
			<option value="">- Pilih Jabatan -</option>
			<?php
			
			while($row = mysql_fetch_array($hasil)) 
			{ ?>
         	<option value="<?php echo $row['kode']; ?>">
			<?php echo  $row['kode'].' - '.$row['nmjabatan'].' [ Grade'.$row['klsjabatan'].' ] ';  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


