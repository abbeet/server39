<?php
	include "../../includes/includes.php";

	$id = $_GET['id'];
	
	$s_subbidang = "SELECT * FROM kd_unitkerja WHERE kdunit LIKE '".$id."%' AND kdunit NOT LIKE '%0' ORDER BY kdunit";
	$q_subbidang = mysql_query($s_subbidang);
	$n_subbidang = mysql_num_rows($q_subbidang);
	
	if ($n_subbidang != 0 and $id != "") 
	{ ?>	
		
		<select name="s" id="subbidang">
			<option value="">Semua Sub Bidang / Sub Bagian</option><?php
			
			while ($subbidang = mysql_fetch_array($q_subbidang)) 
			{ ?>
				
                <option value="<?php echo $subbidang['kdunit']; ?>"><?php echo $subbidang['nmunit']; ?></option><?php
			
			} ?>
		
		</select><?php
	}
?>


