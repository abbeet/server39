<?php
	include "../includes/includes.php";

	$kdprov = $_GET['kdprov'];
	// pilih data 
	$sql = "select * from tb_kabupaten
			where kdprov = '$kdprov' order by nmkab";
	$okab = mysql_query($sql);
	$nkab = mysql_num_rows($okab);
	
	if ($nkab != 0)
	{ ?>
		<select name="kdkab">
			<option value="">- Pilih Kabupaten -</option>
			<?php
			
			while($row = mysql_fetch_array($okab)) 
			{ ?>
         	<option value="<?php echo $row['kdkab']; ?>">
			<?php echo  $row['nmkab'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


