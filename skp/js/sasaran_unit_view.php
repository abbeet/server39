<?php
	include "../includes/includes.php";

	$kdunit = $_GET['kdunit'];
	// baca kode unit kerja
//	$sql = "SELECT KdUnitKerja FROM m_idpegawai WHERE Nib = '$nib'";
//	$hasil = mysql_query($sql);
//	$record = mysql_fetch_array($hasil);
//	$kdunitkerja = $record[0];
	// pilih data 
	$sql = "select NoUrut,left(Sasaran,60) as nama_sasaran from dtsasaran_renstra
			where KdUnitKerja = '$kdunit' order by KdUnitKerja,NoUrut";
	$oSasaran = mysql_query($sql);
	$nSasaran = mysql_num_rows($oSasaran);
	
	if ($nSasaran != 0)
	{ ?>
		<select name="kdsasaran">
			<option value="">- Pilih Sasaran -</option>
			<?php
			
			while($row = mysql_fetch_array($oSasaran)) 
			{ ?>
         	<option value="<?php echo $row['NoUrut']; ?>">
			<?php echo  '['.$row['NoUrut'].'] '.$row['nama_sasaran'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


