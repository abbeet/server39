<?php
	include "../includes/includes.php";

	$kdbidang = $_GET['kdbidang'];
	$kdsubbidang = $_GET['kdsubbidang'];
	
	$sql = "select * from ref_jenis
			where kdbidang = '$kdbidang' and kdsubbidang = '$kdsubbidang' order by kdbidang,kdsubbidang,kdjenis";
	$oJenis = mysql_query($sql);
	$nJenis = mysql_num_rows($oJenis);
	
	if ($nJenis != 0)
	{ ?>
		<select name="kdjenis">
			<option value="">- Pilih Jenis -</option>
			<?php
			
			while($row = mysql_fetch_array($oJenis)) 
			{ ?>
         	<option value="<?php echo $row['kdjenis']; ?>">
			<?php echo  $row['nmjenis'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


