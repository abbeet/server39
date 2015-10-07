<?php
	include "../includes/includes.php";

	$kdjabatan = $_GET['kdjabatan'];
	$kdunit = $_GET['kdunit'];
	// baca kode unit kerja
	if ( substr($kdjabatan,3,2) == '21' or substr($kdjabatan,3,2) == '12' or substr($kdjabatan,3,2) == '11' )
	{
			$sql = "SELECT Nib, NamaLengkap FROM m_idpegawai WHERE (KdEselon = '21' or KdEselon = '11' or KdEselon = '12' ) and KdStatusPeg = '2' order by KdEselon,KdUnitKerja";
	}else{
			$sql = "SELECT Nib, NamaLengkap FROM m_idpegawai WHERE left(KdUnitKerja,2) = '$kdunit' and KdEselon <> '' and KdStatusPeg = '2' order by NamaLengkap";
	}
	$hasil = mysql_query($sql);
	$njabatan = mysql_num_rows($hasil);
	
	if ($njabatan != 0)
	{ ?>
		<select name="nib_atasan">
			<option value="">- Pilih Jabatan -</option>
			<?php
			
			while($row = mysql_fetch_array($hasil)) 
			{ ?>
         	<option value="<?php echo $row['Nib']; ?>">
			<?php echo  '['.$row['Nib'].'] '.$row['NamaLengkap'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


