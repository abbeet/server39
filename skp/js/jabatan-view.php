<?php
	include "../includes/includes.php";

	$nip = $_GET['nip'];
	// baca kode unit kerja
	$sql = "SELECT kdunitkerja FROM m_idpegawai WHERE nip = '$nip'";
	$hasil = mysql_query($sql);
	$record = mysql_fetch_array($hasil);
	$kdunitkerja = $record[0];
	echo $nip.'---'.$kdunitkerja ;
	// pilih data 
	$sql = "select kode_jabatan, nama_jabatan from mst_info_jabatan
			where kdunitkerja = '$kdunitkerja' order by kode_jabatan";
	$ojabatan = mysql_query($sql);
	$njabatan = mysql_num_rows($ojabatan);
	
	if ($njabatan != 0)
	{ ?>
		<select name="kdjabatan">
			<option value="">- Pilih Jabatan -</option>
			<?php
			
			while($row = mysql_fetch_array($ojabatan)) 
			{ ?>
         	<option value="<?php echo $row['kode_jabatan']; ?>">
			<?php echo  '['.$row['kode_jabatan'].'] '.$row['nama_jabatan'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


