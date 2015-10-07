<?php
	include "../includes/includes.php";

	$kdkelkeg = $_GET['kdkelkeg'];
	// pilih data 
	$sql = "select * from tb_keg_bid
			where kdkelkeg = '$kdkelkeg' order by kdbidkeg";
	$obidang = mysql_query($sql);
	$nbidang = mysql_num_rows($obidang);
	
	if ($nbidang != 0)
	{ ?>
		<select name="kdbidkeg">
			<option value="">- Pilih Bidang Kegiatan -</option>
			<?php
			
			while($row = mysql_fetch_array($obidang)) 
			{ ?>
         	<option value="<?php echo $row['kdbidkeg']; ?>">
			<?php echo  $row['nmbidkeg'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


