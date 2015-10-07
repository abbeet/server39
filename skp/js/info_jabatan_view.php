<?php
	include "../includes/includes.php";

	$kdunitkerja = $_GET['kdunitkerja'];
	//$kdjab = substr($kdunitkerja,2,5) ;
	//$kdunit = substr($kdunitkerja,0,5) ;
	// baca nama jabatan
	$sql = "SELECT * FROM mst_info_jabatan WHERE kdunitkerja = '$kdunitkerja' order by kdjabatan,grade desc";
	//echo 'kode unit '.$kdunitkerja ;
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
			<?php echo  $row['kdjabatan'].' - '.nm_jabatan_ij($row['kdjabatan'],$kdunitkerja).' [ Grade'.$row['grade'].' ] ';  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


