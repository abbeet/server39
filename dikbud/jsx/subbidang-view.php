<?php
	include "../includes/includes.php";

	$kdbidang = $_GET['kdbidang'];
	// pilih data 
	$sql = "select * from ref_subbidang
			where kdbidang = '$kdbidang' order by kdbidang,kdsubbidang";
	$oSubBidang = mysql_query($sql);
	$nSubBidang = mysql_num_rows($oSubBidang); ?>
	
<script language="javascript" src="js/phlin_combo.js"></script>
<?php	if ($nSubBidang != 0)
	{ ?>
		<select name="kdsubbidang" onchange="get_subbidang_phlin(this.value,<?php echo $kdbidang ?>)">
			<option value="">- Pilih Sub Bidang -</option>
			<?php
			
			while($row = mysql_fetch_array($oSubBidang)) 
			{ ?>
         	<option value="<?php echo $row['kdsubbidang']; ?>">
			<?php echo  $row['nmsubbidang'];  ?></option><?php
			} ?>
		</select>		
		<?php
	}
?>


